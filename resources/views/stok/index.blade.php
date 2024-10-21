@extends('layouts.template')
@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $breadcrumb->title }}</h3>
        <div class="card-tools">
            <button onclick="createStok()" class="btn btn-sm btn-success mt-1">Tambah Stok</button>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover table-sm" id="table_stok">
                <thead>
                    <tr>
                        <th>{{ __('No') }}</th>
                        <th>{{ __('Supplier') }}</th>
                        <th>{{ __('Barang') }}</th>
                        <th>{{ __('User') }}</th>
                        <th>{{ __('Tanggal') }}</th>
                        <th>{{ __('Jumlah') }}</th>
                        <th>{{ __('Aksi') }}</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="stokModal" tabindex="-1" role="dialog" aria-labelledby="stokModalLabel" aria-hidden="true">
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
        dataTable = $('#table_stok').DataTable({
            serverSide: true,
            processing: true,
            ajax: "{{ route('stok.list') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: "supplier_nama", name: "supplier_nama"},
                {data: "barang_nama", name: "barang_nama"},
                {data: "user_nama", name: "user_nama"},
                {data: "stok_tanggal", name: "stok_tanggal"},
                {data: "stok_jumlah", name: "stok_jumlah"},
                {data: "aksi", name: "aksi", orderable: false, searchable: false}
            ],
            order: [[4, 'desc']]
        });
    });

    function createStok() {
        $.get("{{ route('stok.create') }}", function(data) {
            $('#stokModal .modal-content').html(data);
            $('#stokModal').modal('show');
        });
    }

    function editStok(id) {
        $.get("{{ url('stok') }}/" + id + "/edit", function(data) {
            $('#stokModal .modal-content').html(data);
            $('#stokModal').modal('show');
        });
    }

    function deleteStok(id) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data stok akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ url('stok') }}/" + id,
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

    $(document).on('submit', '#stokForm', function(e) {
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
                    $('#stokModal').modal('hide');
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