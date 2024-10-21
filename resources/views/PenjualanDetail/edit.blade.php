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
        <form action="{{ route('PenjualanDetail.update', $penjualanDetail->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="penjualan_id">{{ __('Penjualan') }}:</label>
                <select class="form-control @error('penjualan_id') is-invalid @enderror" id="penjualan_id" name="penjualan_id" required>
                    @foreach($penjualans as $penjualan)
                        <option value="{{ $penjualan->penjualan_id }}" {{ $penjualanDetail->penjualan_id == $penjualan->penjualan_id ? 'selected' : '' }}>
                            {{ $penjualan->penjualan_kode }}
                        </option>
                    @endforeach
                </select>
                @error('penjualan_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="barang_id">{{ __('Barang') }}:</label>
                <select class="form-control @error('barang_id') is-invalid @enderror" id="barang_id" name="barang_id" required>
                    @foreach($barangs as $barang)
                        <option value="{{ $barang->barang_id }}" {{ $penjualanDetail->barang_id == $barang->barang_id ? 'selected' : '' }}>
                            {{ $barang->barang_nama }}
                        </option>
                    @endforeach
                </select>
                @error('barang_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="harga">{{ __('Harga') }}:</label>
                <input type="number" class="form-control @error('harga') is-invalid @enderror" id="harga" name="harga" value="{{ old('harga', $penjualanDetail->harga) }}" required min="0" step="0.01">
                @error('harga')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="jumlah">{{ __('Jumlah') }}:</label>
                <input type="number" class="form-control @error('jumlah') is-invalid @enderror" id="jumlah" name="jumlah" value="{{ old('jumlah', $penjualanDetail->jumlah) }}" required min="1">
                @error('jumlah')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">{{ __('Simpan') }}</button>
            <a href="{{ route('PenjualanDetail.index') }}" class="btn btn-secondary">{{ __('Kembali') }}</a>
        </form>
    </div>
</div>
@endsection


@push('js')
<script>
    $(document).ready(function() {
        $('#barang_id').change(function() {
            var barangId = $(this).val();
            if(barangId) {
                $.ajax({
                    url: '{{ url("/get-harga-barang") }}/' + barangId,
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        if(data.harga !== undefined) {
                            $('#harga').val(data.harga);
                        } else {
                            $('#harga').val('');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', status, error);
                        $('#harga').val('');
                    }
                });
            } else {
                $('#harga').val('');
            }
        });
    });
</script>
@endpush



