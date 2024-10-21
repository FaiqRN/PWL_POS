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
        <form action="{{ route('penjualan.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="user_id">{{ __('User') }}:</label>
                <select class="form-control @error('user_id') is-invalid @enderror" id="user_id" name="user_id" required>
                    <option value="">Pilih User</option>
                    @foreach($users as $user)
                        <option value="{{ $user->user_id }}" {{ old('user_id') == $user->user_id ? 'selected' : '' }}>
                            {{ $user->nama }}
                        </option>
                    @endforeach
                </select>
                @error('user_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="pembeli">{{ __('Pembeli') }}:</label>
                <input type="text" class="form-control @error('pembeli') is-invalid @enderror" id="pembeli" name="pembeli" value="{{ old('pembeli') }}" required maxlength="50">
                @error('pembeli')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="penjualan_kode">{{ __('Kode Penjualan') }}:</label>
                <input type="text" class="form-control" id="penjualan_kode" value="{{ $penjualanKode }}" readonly>
            </div>
            <div class="form-group">
                <label for="penjualan_tanggal">{{ __('Tanggal Penjualan') }}:</label>
                <input type="datetime-local" class="form-control @error('penjualan_tanggal') is-invalid @enderror" id="penjualan_tanggal" name="penjualan_tanggal" value="{{ old('penjualan_tanggal', date('Y-m-d\TH:i')) }}" required>
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



