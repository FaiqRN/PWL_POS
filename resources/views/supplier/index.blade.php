@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $breadcrumb->title }}</h3>
        <div class="card-tools">
            <button onclick="createSupplier()" class="btn btn-sm btn-success mt-1">Tambah Supplier</button>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover table-sm" id="table_supplier">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Supplier</th>
                        <th>Nama Supplier</th>
                        <th>Alamat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="supplierModal" tabindex="-1" role="dialog" aria-labelledby="supplierModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <!-- Modal content will be loaded here -->
        </div>
    </div>
</div>
@endsection

@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
@endpush

@push('js')
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    let dataTable;

    $(document).ready(function() {
        dataTable = $('#table_supplier').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('supplier.list') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'supplier_kode', name: 'supplier_kode'},
                {data: 'supplier_nama', name: 'supplier_nama'},
                {data: 'supplier_alamat', name: 'supplier_alamat'},
                {data: 'aksi', name: 'aksi', orderable: false, searchable: false}
            ],
            order: [[1, 'asc']]
        });
    });

    function createSupplier() {
        $.get("{{ route('supplier.create') }}", function(data) {
            $('#supplierModal .modal-content').html(data);
            $('#supplierModal').modal('show');
        });
    }

    function editSupplier(id) {
        $.get("{{ url('supplier') }}/" + id + "/edit", function(data) {
            $('#supplierModal .modal-content').html(data);
            $('#supplierModal').modal('show');
        });
    }

    function deleteSupplier(id) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data supplier akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ url('supplier') }}/" + id,
                    type: 'DELETE',
                    data: {
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.status) {
                            Swal.fire('Terhapus!', response.message, 'success');
                            dataTable.ajax.reload();
                        } else {
                            Swal.fire('Gagal!', response.message, 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error!', 'Terjadi kesalahan saat menghapus data.', 'error');
                    }
                });
            }
        });
    }

    function showSupplier(id) {
        $.get("{{ url('supplier') }}/" + id, function(data) {
            $('#supplierModal .modal-content').html(data);
            $('#supplierModal').modal('show');
        });
    }

    $(document).on('submit', '#supplierForm', function(e) {
        e.preventDefault();
        let form = $(this);
        let url = form.attr('action');
        let method = form.attr('method');

        $.ajax({
            url: url,
            method: method,
            data: form.serialize(),
            success: function(response) {
                if (response.status) {
                    $('#supplierModal').modal('hide');
                    Swal.fire('Berhasil!', response.message, 'success');
                    dataTable.ajax.reload();
                } else {
                    Swal.fire('Gagal!', 'Terjadi kesalahan. Silakan coba lagi.', 'error');
                }
            },
            error: function(xhr) {
                let errors = xhr.responseJSON.errors;
                $.each(errors, function(key, value) {
                    $('#' + key).addClass('is-invalid');
                    $('#' + key + '_error').text(value[0]);
                });
            }
        });
    });
</script>
@endpush