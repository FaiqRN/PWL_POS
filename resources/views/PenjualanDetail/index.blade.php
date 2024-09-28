@extends('layouts.template')
@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $breadcrumb->title }}</h3>
        <div class="card-tools">
            <a class="btn btn-sm btn-primary mt-1" href="{{ route('PenjualanDetail.create') }}">{{ __('Tambah Detail Penjualan') }}</a>
        </div>
    </div>
    <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <table class="table table-bordered table-striped table-hover table-sm" id="table_penjualan_detail">
            <thead>
                <tr>
                    <th>{{ __('ID') }}</th>
                    <th>{{ __('Kode Penjualan') }}</th>
                    <th>{{ __('Barang') }}</th>
                    <th>{{ __('Harga') }}</th>
                    <th>{{ __('Jumlah') }}</th>
                    <th>{{ __('Aksi') }}</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@endsection

@push('js')
<script>
    $(document).ready(function() {
        var dataPenjualanDetail = $('#table_penjualan_detail').DataTable({
            serverSide: true,
            processing: true,
            ajax: "{{ route('PenjualanDetail.index') }}",
            columns: [
                {data: "id", name: "id"},
                {data: "penjualan_kode", name: "penjualan_kode"},
                {data: "barang_nama", name: "barang_nama"},
                {data: "harga", name: "harga"},
                {data: "jumlah", name: "jumlah"},
                {data: "aksi", name: "aksi", orderable: false, searchable: false}
            ],
            order: [[0, 'asc']],
        });
    });
</script>
@endpush