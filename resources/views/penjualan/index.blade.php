@extends('layouts.template')
@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $breadcrumb->title }}</h3>
        <div class="card-tools">
            <button onclick="createPenjualan()" class="btn btn-sm btn-primary">Tambah Penjualan</button>
            <a href="{{ route('penjualan.export.excel') }}" class="btn btn-sm btn-success">
                <i class="fas fa-file-excel"></i> Export Excel
            </a>
            <a href="{{ route('penjualan.export.pdf') }}" class="btn btn-sm btn-danger">
                <i class="fas fa-file-pdf"></i> Export PDF
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover table-sm" id="table_penjualan">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Penjualan</th>
                        <th>Pembeli</th>
                        <th>Tanggal</th>
                        <th>Total Items</th>
                        <th>Total Harga</th>
                        <th>User</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="penjualanModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        </div>
    </div>
</div>
@endsection

@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
<style>
    .select2-container {
        width: 100% !important;
    }
    .barang-item {
        border-bottom: 1px solid #dee2e6;
        padding-bottom: 15px;
        margin-bottom: 15px;
    }
</style>
@endpush

@push('js')
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
let dataTable;

$(document).ready(function() {
    dataTable = $('#table_penjualan').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('penjualan.list') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'penjualan_kode', name: 'penjualan_kode'},
            {data: 'pembeli', name: 'pembeli'},
            {data: 'penjualan_tanggal', name: 'penjualan_tanggal'},
            {data: 'total_items', name: 'total_items'},
            {
                data: 'total_harga',
                name: 'total_harga',
                render: function(data) {
                    return 'Rp ' + new Intl.NumberFormat('id-ID').format(data);
                }
            },
            {data: 'user_nama', name: 'user_nama'},
            {data: 'aksi', name: 'aksi', orderable: false, searchable: false}
        ],
        order: [[1, 'desc']],
        language: {
            url: "//cdn.datatables.net/plug-ins/1.10.25/i18n/Indonesian.json"
        }
    });
});

function createPenjualan() {
    $.get("{{ route('penjualan.create') }}", function(data) {
        $('#penjualanModal .modal-content').html(data);
        $('#penjualanModal').modal('show');
        initializeComponents();
    });
}

function deletePenjualan(id) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Data penjualan akan dihapus permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "{{ url('penjualan') }}/" + id,
                type: 'DELETE',
                data: {
                    "_token": "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response.status) {
                        Swal.fire('Berhasil!', response.message, 'success');
                        dataTable.ajax.reload();
                    } else {
                        Swal.fire('Gagal!', response.message, 'error');
                    }
                }
            });
        }
    });
}
</script>
@endpush
