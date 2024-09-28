@extends('layouts.template')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ $breadcrumb->title }}</h3>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th style="width: 200px;">{{ __('ID Barang') }}</th>
                <td>{{ $barang->barang_id }}</td>
            </tr>
            <tr>
                <th>{{ __('Kategori') }}</th>
                <td>{{ $barang->kategori->kategori_nama }}</td>
            </tr>
            <tr>
                <th>{{ __('Kode Barang') }}</th>
                <td>{{ $barang->barang_kode }}</td>
            </tr>
            <tr>
                <th>{{ __('Nama Barang') }}</th>
                <td>{{ $barang->barang_nama }}</td>
            </tr>
            <tr>
                <th>{{ __('Harga Beli') }}</th>
                <td>Rp {{ number_format($barang->harga_beli, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <th>{{ __('Harga Jual') }}</th>
                <td>Rp {{ number_format($barang->harga_jual, 0, ',', '.') }}</td>
            </tr>
        </table>
        <div class="mt-3">
            <a href="{{ route('barang.edit', $barang->barang_id) }}" class="btn btn-primary">{{ __('Edit') }}</a>
            <a href="{{ route('barang.index') }}" class="btn btn-secondary">{{ __('Kembali') }}</a>
        </div>
    </div>
</div>
@endsection