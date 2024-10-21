<form id="stokForm" action="{{ route('stok.update', $stok->stok_id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="modal-header">
        <h5 class="modal-title" id="stokModalLabel">Edit Stok</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
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
            <input type="date" class="form-control" id="stok_tanggal" name="stok_tanggal" value="{{ $stok->stok_tanggal }}" required>
            <span class="invalid-feedback" id="stok_tanggal_error"></span>
        </div>
        <div class="form-group">
            <label for="stok_jumlah">{{ __('Jumlah') }}:</label>
            <input type="number" class="form-control" id="stok_jumlah" name="stok_jumlah" value="{{ $stok->stok_jumlah }}" required min="0">
            <span class="invalid-feedback" id="stok_jumlah_error"></span>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </div>
</form>