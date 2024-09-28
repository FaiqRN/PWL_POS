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
        <form action="{{ route('supplier.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="supplier_kode">{{ __('Kode Supplier') }}:</label>
                <input type="text" class="form-control @error('supplier_kode') is-invalid @enderror" id="supplier_kode" name="supplier_kode" value="{{ old('supplier_kode', $supplierCode) }}" required readonly>
                @error('supplier_kode')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="supplier_nama">{{ __('Nama Supplier') }}:</label>
                <input type="text" class="form-control @error('supplier_nama') is-invalid @enderror" id="supplier_nama" name="supplier_nama" value="{{ old('supplier_nama') }}" required>
                @error('supplier_nama')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="supplier_alamat">{{ __('Alamat') }}:</label>
                <textarea class="form-control @error('supplier_alamat') is-invalid @enderror" id="supplier_alamat" name="supplier_alamat" required>{{ old('supplier_alamat') }}</textarea>
                @error('supplier_alamat')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">{{ __('Simpan') }}</button>
            <a href="{{ route('supplier.index') }}" class="btn btn-secondary">{{ __('Kembali') }}</a>
        </form>
    </div>
</div>
@endsection