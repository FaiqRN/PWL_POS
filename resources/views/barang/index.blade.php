@extends('layouts.template')
@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $breadcrumb->title }}</h3>
        <div class="card-tools">
            <button onclick="createBarang()" class="btn btn-sm btn-success mt-1">Tambah Barang</button>
            <button onclick="modalImport()" class="btn btn-warning">Upload Data Barang</button>
            <a href="{{ route('barang.export') }}" class="btn btn-primary">
                <i class="fas fa-file-excel"></i> Export Excel
            </a>
            <a href="{{ route('barang.export.pdf') }}" class="btn btn-danger">
                <i class="fas fa-file-pdf"></i> Export PDF
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover table-sm" id="table_barang">
                <thead>
                    <tr>
                        <th>{{ __('No') }}</th>
                        <th>{{ __('Kode Barang') }}</th>
                        <th>{{ __('Nama Barang') }}</th>
                        <th>{{ __('Kategori') }}</th>
                        <th>{{ __('Harga Beli') }}</th>
                        <th>{{ __('Harga Jual') }}</th>
                        <th>{{ __('Aksi') }}</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<!-- Modal Barang -->
<div class="modal fade" id="barangModal" tabindex="-1" role="dialog" aria-labelledby="barangModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <!-- Modal content will be loaded here -->
        </div>
    </div>
</div>

<!-- Modal Import -->
<div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="{{ route('barang.import_ajax') }}" method="POST" id="form-import" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="importModalLabel">Import Data Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Download Template</label>
                        <a href="{{ asset('template_barang.xlsx') }}" class="btn btn-info btn-sm">
                            <i class="fa fa-file-excel"></i> Download
                        </a>
                    </div>
                    <div class="form-group">
                        <label>Pilih File</label>
                        <input type="file" name="file_barang" id="file_barang" class="form-control" accept=".xlsx">
                        <small id="error-file_barang" class="error-text text-danger"></small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </div>
            </form>
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
                {data: 'barang_kode', name: 'barang_kode'},
                {data: 'barang_nama', name: 'barang_nama'},
                {data: 'kategori_nama', name: 'kategori_nama'},
                {
                    data: 'harga_beli',
                    name: 'harga_beli',
                    render: function(data) {
                        return 'Rp ' + parseFloat(data).toLocaleString('id-ID');
                    }
                },
                {
                    data: 'harga_jual',
                    name: 'harga_jual',
                    render: function(data) {
                        return 'Rp ' + parseFloat(data).toLocaleString('id-ID');
                    }
                },
                {data: 'aksi', name: 'aksi', orderable: false, searchable: false}
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

    function showBarang(id) {
        $.get("{{ url('barang') }}/" + id, function(data) {
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

    function modalImport() {
        $('#importModal').modal('show');
    }

    // Handler untuk form import
    $('#form-import').on('submit', function(e) {
        e.preventDefault();
        
        let formData = new FormData(this);
        
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function() {
                $('.error-text').text('');
                $('.is-invalid').removeClass('is-invalid');
            },
            success: function(response) {
                if(response.status) {
                    $('#importModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: response.message
                    });
                    dataTable.ajax.reload();
                    $('#form-import')[0].reset();
                } else {
                    if(response.msgField) {
                        $.each(response.msgField, function(field, message) {
                            $('#' + field).addClass('is-invalid');
                            $('#error-' + field).text(message[0]);
                        });
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: response.message
                    });
                }
            },
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Terjadi kesalahan saat mengupload file.'
                });
            }
        });
    });

    // Handler untuk form barang (create/edit)
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
                    if(response.errors) {
                        $.each(response.errors, function(key, value) {
                            $('#' + key).addClass('is-invalid');
                            $('#' + key + '_error').text(value[0]);
                        });
                    } else {
                        Swal.fire('Gagal!', 'Terjadi kesalahan. Silakan coba lagi.', 'error');
                    }
                }
            },
            error: function(xhr) {
                Swal.fire('Error!', 'Terjadi kesalahan saat menyimpan data.', 'error');
            }
        });
    });
</script>
@endpush