@extends('layouts.template')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ $breadcrumb->title }}</h3>
    </div>
    <div class="card-body">
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <form action="{{ route('stok.update', $stok->stok_id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="supplier_id">{{ __('Supplier') }}:</label>
                <select class="form-control" id="supplier_id" name="supplier_id" disabled>
                    @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->supplier_id }}" {{ $stok->supplier_id == $supplier->supplier_id ? 'selected' : '' }}>
                            {{ $supplier->supplier_nama }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="barang_id">{{ __('Barang') }}:</label>
                <select class="form-control" id="barang_id" name="barang_id" disabled>
                    @foreach($barangs as $barang)
                        <option value="{{ $barang->barang_id }}" {{ $stok->barang_id == $barang->barang_id ? 'selected' : '' }}>
                            {{ $barang->barang_nama }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="user_id">{{ __('User') }}:</label>
                <select class="form-control" id="user_id" name="user_id" disabled>
                    @foreach($users as $user)
                        <option value="{{ $user->user_id }}" {{ $stok->user_id == $user->user_id ? 'selected' : '' }}>
                            {{ $user->nama }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="stok_tanggal">{{ __('Tanggal') }}:</label>
                <input type="date" class="form-control @error('stok_tanggal') is-invalid @enderror" id="stok_tanggal" name="stok_tanggal" value="{{ old('stok_tanggal', $stok->stok_tanggal) }}" required>
                @error('stok_tanggal')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="stok_jumlah">{{ __('Jumlah') }}:</label>
                <input type="number" class="form-control @error('stok_jumlah') is-invalid @enderror" id="stok_jumlah" name="stok_jumlah" value="{{ old('stok_jumlah', $stok->stok_jumlah) }}" required min="0">
                @error('stok_jumlah')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">{{ __('Simpan') }}</button>
            <a href="{{ route('stok.index') }}" class="btn btn-secondary">{{ __('Kembali') }}</a>
        </form>
    </div>
</div>
@endsection