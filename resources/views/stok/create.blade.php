<form id="stokForm" action="{{ route('stok.store') }}" method="POST">
    @csrf
    <div class="modal-header">
        <h5 class="modal-title" id="stokModalLabel">Tambah Stok</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label for="supplier_id">{{ __('Supplier') }}:</label>
            <select class="form-control" id="supplier_id" name="supplier_id" required>
                <option value="">Pilih Supplier</option>
                @foreach($suppliers as $supplier)
                    <option value="{{ $supplier->supplier_id }}">{{ $supplier->supplier_nama }}</option>
                @endforeach
            </select>
            <span class="invalid-feedback" id="supplier_id_error"></span>
        </div>
        <div class="form-group">
            <label for="barang_id">{{ __('Barang') }}:</label>
            <select class="form-control" id="barang_id" name="barang_id" required>
                <option value="">Pilih Barang</option>
                @foreach($barangs as $barang)
                    <option value="{{ $barang->barang_id }}">{{ $barang->barang_nama }}</option>
                @endforeach
            </select>
            <span class="invalid-feedback" id="barang_id_error"></span>
        </div>
        <div class="form-group">
            <label for="user_id">{{ __('User') }}:</label>
            <select class="form-control" id="user_id" name="user_id" required>
                <option value="">Pilih User</option>
                @foreach($users as $user)
                    <option value="{{ $user->user_id }}">{{ $user->nama }}</option>
                @endforeach
            </select>
            <span class="invalid-feedback" id="user_id_error"></span>
        </div>
        <div class="form-group">
            <label for="stok_tanggal">{{ __('Tanggal') }}:</label>
            <input type="date" class="form-control" id="stok_tanggal" name="stok_tanggal" value="{{ date('Y-m-d') }}" required>
            <span class="invalid-feedback" id="stok_tanggal_error"></span>
        </div>
        <div class="form-group">
            <label for="stok_jumlah">{{ __('Jumlah') }}:</label>
            <input type="number" class="form-control" id="stok_jumlah" name="stok_jumlah" required min="1">
            <span class="invalid-feedback" id="stok_jumlah_error"></span>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</form>