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
        <form action="{{ route('barang.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="kategori_id">{{ __('Kategori') }}:</label>
                <select class="form-control @error('kategori_id') is-invalid @enderror" id="kategori_id" name="kategori_id" required>
                    <option value="">Pilih Kategori</option>
                    @foreach($kategoris as $kategori)
                        <option value="{{ $kategori->kategori_id }}" {{ old('kategori_id') == $kategori->kategori_id ? 'selected' : '' }}>
                            {{ $kategori->kategori_nama }}
                        </option>
                    @endforeach
                </select>
                @error('kategori_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="barang_kode">{{ __('Kode Barang') }}:</label>
                <input type="text" class="form-control @error('barang_kode') is-invalid @enderror" 
                       id="barang_kode" name="barang_kode" 
                       value="{{ old('barang_kode', $barangCode) }}" required maxlength="10" readonly>
                @error('barang_kode')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="barang_nama">{{ __('Nama Barang') }}:</label>
                <input type="text" class="form-control @error('barang_nama') is-invalid @enderror" id="barang_nama" name="barang_nama" value="{{ old('barang_nama') }}" required maxlength="100">
                @error('barang_nama')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="harga_beli">{{ __('Harga Beli') }}:</label>
                <input type="number" class="form-control @error('harga_beli') is-invalid @enderror" id="harga_beli" name="harga_beli" value="{{ old('harga_beli') }}" required min="0">
                @error('harga_beli')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="harga_jual">{{ __('Harga Jual') }}:</label>
                <input type="number" class="form-control @error('harga_jual') is-invalid @enderror" id="harga_jual" name="harga_jual" value="{{ old('harga_jual') }}" required min="0">
                @error('harga_jual')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">{{ __('Simpan') }}</button>
            <a href="{{ route('barang.index') }}" class="btn btn-secondary">{{ __('Kembali') }}</a>
        </form>
    </div>
</div>
@endsection