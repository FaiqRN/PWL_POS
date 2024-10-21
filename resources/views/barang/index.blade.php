@extends('layouts.template')
@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $breadcrumb->title }}</h3>
        <div class="card-tools">
            <button onclick="createBarang()" class="btn btn-sm btn-success mt-1">Tambah Barang</button>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover table-sm" id="table_barang">
                <thead>
                    <tr>
                        <th>{{ __('No') }}</th>
                        <th>{{ __('Nama Barang') }}</th>
                        <th>{{ __('Kategori') }}</th>
                        <th>{{ __('Aksi') }}</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="barangModal" tabindex="-1" role="dialog" aria-labelledby="barangModalLabel" aria-hidden="true">
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
        dataTable = $('#table_barang').DataTable({
            serverSide: true,
            processing: true,
            ajax: "{{ route('barang.list') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: "barang_nama", name: "barang_nama"},
                {data: "kategori_nama", name: "kategori_nama"},
                {data: "aksi", name: "aksi", orderable: false, searchable: false}
            ],
            order: [[1, 'asc']],
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.25/i18n/Indonesian.json"
            }
        });
    });

    function createBarang() {
        $.get("{{ route('barang.create') }}", function(data) {
            $('#barangModal .modal-content').html(data);
            $('#barangModal').modal('show');
        });
    }

    function editBarang(id) {
        $.get("{{ url('barang') }}/" + id + "/edit", function(data) {
            $('#barangModal .modal-content').html(data);
            $('#barangModal').modal('show');
        });
    }

    function deleteBarang(id) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data barang akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ url('barang') }}/" + id,
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

    function showBarang(id) {
        $.get("{{ url('barang') }}/" + id, function(data) {
            $('#barangModal .modal-content').html(data);
            $('#barangModal').modal('show');
        });
    }

    $(document).on('submit', '#barangForm', function(e) {
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
                    $('#barangModal').modal('hide');
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