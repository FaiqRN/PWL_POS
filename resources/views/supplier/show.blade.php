@extends('layouts.template')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ __('Detail Supplier') }}</h3>
    </div>
    <div class="card-body">
        <div class="form-group">
            <label>{{ __('Kode Supplier') }}:</label>
            <p class="form-control-static">{{ $supplier->supplier_kode }}</p>
        </div>
        <div class="form-group">
            <label>{{ __('Nama Supplier') }}:</label>
            <p class="form-control-static">{{ $supplier->supplier_nama }}</p>
        </div>
        <div class="form-group">
            <label>{{ __('Alamat') }}:</label>
            <p class="form-control-static">{{ $supplier->supplier_alamat }}</p>
        </div>
        <a href="{{ route('supplier.edit', $supplier->supplier_id) }}" class="btn btn-primary">{{ __('Edit') }}</a>
        <a href="{{ route('supplier.index') }}" class="btn btn-secondary">{{ __('Kembali') }}</a>
    </div>
</div>
@endsection