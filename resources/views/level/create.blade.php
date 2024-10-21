@extends('layouts.template')


@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ __('Tambah Level Baru') }}</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('level.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="level_kode">{{ __('kode') }}:</label>
                <input type="text" class="form-control @error('level_kode') is-invalid @enderror" id="level_kode" name="level_kode" value="{{ old('level_kode') }}" required>
                @error('level_kode')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="level_nama">{{ __('Nama') }}:</label>
                <input type="text" class="form-control @error('level_nama') is-invalid @enderror" id="level_nama" name="level_nama" value="{{ old('level_nama') }}" required>
                @error('level_nama')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">{{ __('Simpan') }}</button>
            <a href="{{ route('level.index') }}" class="btn btn-secondary">{{ __('Kembali') }}</a>
        </form>
    </div>
</div>
@endsection



