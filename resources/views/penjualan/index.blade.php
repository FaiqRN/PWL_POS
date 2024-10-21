@extends('layouts.template')
@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $breadcrumb->title }}</h3>
        <div class="card-tools">
            <a class="btn btn-sm btn-primary mt-1" href="{{ route('penjualan.create') }}">{{ __('Tambah Penjualan') }}</a>
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
        <table class="table table-bordered table-striped table-hover table-sm" id="table_penjualan">
            <thead>
                <tr>
                    <th>{{ __('ID') }}</th>
                    <th>{{ __('User') }}</th>
                    <th>{{ __('Pembeli') }}</th>
                    <th>{{ __('Kode Penjualan') }}</th>
                    <th>{{ __('Tanggal Penjualan') }}</th>
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
        var dataPenjualan = $('#table_penjualan').DataTable({
            serverSide: true,
            processing: true,
            ajax: "{{ route('penjualan.index') }}",
            columns: [
                {data: "penjualan_id", name: "penjualan_id"},
                {data: "user_nama", name: "user_nama"},
                {data: "pembeli", name: "pembeli"},
                {data: "penjualan_kode", name: "penjualan_kode"},
                {data: "penjualan_tanggal", name: "penjualan_tanggal"},
                {data: "aksi", name: "aksi", orderable: false, searchable: false}
            ],
            order: [[0, 'asc']],


        });
    });
</script>
@endpush



