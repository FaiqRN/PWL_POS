@extends('layouts.template')
@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $breadcrumb->title }}</h3>
    </div>
    <div class="card-header">
        <h3 class="card-title">{{ $breadcrumb->title }}</h3>
        <div class="card-tools">
            <a class="btn btn-sm btn-primary mt-1" href="{{ route('stok.create') }}">{{ __('Tambah Stok') }}</a>
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
        <table class="table table-bordered table-striped table-hover table-sm" id="table_stok">
            <thead>
                <tr>
                    <th>{{ __('ID') }}</th>
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
@endsection

@push('css')
@endpush

@push('js')

<script>
    $(document).ready(function() {
        var dataStok = $('#table_stok').DataTable({
            serverSide: true,
            processing: true,
            ajax: "{{ route('stok.index') }}",
            columns: [
                {data: "stok_id", name: "stok_id"},
                {data: "supplier_nama", name: "supplier_nama"},
                {data: "barang_nama", name: "barang_nama"},
                {data: "user_nama", name: "user_nama"},
                {data: "stok_tanggal", name: "stok_tanggal"},
                {data: "stok_jumlah", name: "stok_jumlah"},
                {data: "aksi", name: "aksi", orderable: false, searchable: false}
            ],
            order: [[0, 'asc']],
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.25/i18n/Indonesian.json"
            }
        });
    });
</script>
@endpush