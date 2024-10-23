@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $breadcrumb->title }}</h3>
        <div class="card-tools">
            <a href="{{ route('stok.create') }}" class="btn btn-sm btn-success">
                <i class="fas fa-plus"></i> Tambah Stok
            </a>
            <a href="{{ route('stok.export.excel') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-file-excel"></i> Export Excel
            </a>
            <a href="{{ route('stok.export.pdf') }}" class="btn btn-sm btn-danger">
                <i class="fas fa-file-pdf"></i> Export PDF
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover" id="table_stok">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="15%">Tanggal</th>
                        <th width="20%">Supplier</th>
                        <th width="20%">Barang</th>
                        <th width="15%">User</th>
                        <th width="10%">Jumlah</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@endsection

@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
<style>
    .table th { 
        text-align: center;
        vertical-align: middle !important;
    }
    .table td {
        vertical-align: middle !important;
    }
</style>
@endpush

@push('js')
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    let table;
    $(document).ready(function() {
    table = $('#table_stok').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('stok.list') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false},
            {data: 'stok_tanggal', name: 'stok_tanggal'},
            {data: 'supplier_nama', name: 'supplier.supplier_nama'},
            {data: 'barang_nama', name: 'barang.barang_nama'},
            {data: 'user_nama', name: 'user.nama'},
            {data: 'stok_jumlah', name: 'stok_jumlah'},
            {data: 'aksi', name: 'aksi', orderable: false, searchable: false}
        ],
        order: [[1, 'desc']],
        language: {
            url: "//cdn.datatables.net/plug-ins/1.10.25/i18n/Indonesian.json"
        },
        responsive: true
    });
});
function editStok(id) {
    $.ajax({
        url: `{{ url('stok') }}/${id}/edit`,
        type: 'GET',
        success: function(response) {
            $('#modal-content').html(response);
            $('#modal').modal('show');
        },
        error: function(xhr) {
            Swal.fire('Error!', 'Terjadi kesalahan saat mengambil data.', 'error');
        }
    });
}
function deleteStok(id) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Data yang dihapus tidak dapat dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `{{ url('stok') }}/${id}`,
                type: 'DELETE',
                data: {
                    "_token": "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response.status) {
                        Swal.fire('Berhasil!', response.message, 'success');
                        table.ajax.reload();
                    } else {
                        Swal.fire('Gagal!', response.message, 'error');
                    }
                },
                error: function(xhr) {
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

    $.ajax({
        url: url,
        type: 'POST',
        data: form.serialize(),
        success: function(response) {
            if (response.status) {
                $('#modal').modal('hide');
                Swal.fire('Berhasil!', response.message, 'success');
                table.ajax.reload();
            } else {
                Swal.fire('Gagal!', response.message, 'error');
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
