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
        <form action="{{ route('penjualan.update', $penjualan->penjualan_id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="user_id">{{ __('User') }}:</label>
                <select class="form-control" id="user_id" name="user_id" disabled>
                    @foreach($users as $user)
                        <option value="{{ $user->user_id }}" {{ $penjualan->user_id == $user->user_id ? 'selected' : '' }}>
                            {{ $user->nama }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="pembeli">{{ __('Pembeli') }}:</label>
                <input type="text" class="form-control @error('pembeli') is-invalid @enderror" id="pembeli" name="pembeli" value="{{ old('pembeli', $penjualan->pembeli) }}" required maxlength="50">
                @error('pembeli')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="penjualan_kode">{{ __('Kode Penjualan') }}:</label>
                <input type="text" class="form-control" id="penjualan_kode" value="{{ $penjualan->penjualan_kode }}" readonly>
                @error('penjualan_kode')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="penjualan_tanggal">{{ __('Tanggal Penjualan') }}:</label>
                <input type="datetime-local" class="form-control @error('penjualan_tanggal') is-invalid @enderror" id="penjualan_tanggal" name="penjualan_tanggal" value="{{ old('penjualan_tanggal', date('Y-m-d\TH:i', strtotime($penjualan->penjualan_tanggal))) }}" required>
                @error('penjualan_tanggal')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">{{ __('Simpan') }}</button>
            <a href="{{ route('penjualan.index') }}" class="btn btn-secondary">{{ __('Kembali') }}</a>
        </form>
    </div>
</div>
@endsection



