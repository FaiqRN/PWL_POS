<form id="barangForm" action="{{ route('barang.store') }}" method="POST">
    @csrf
    <div class="modal-header">
        <h5 class="modal-title" id="barangModalLabel">Tambah Barang</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label for="kategori_id">{{ __('Kategori') }}:</label>
            <select class="form-control" id="kategori_id" name="kategori_id" required>
                <option value="">Pilih Kategori</option>
                @foreach($kategoris as $kategori)
                    <option value="{{ $kategori->kategori_id }}">{{ $kategori->kategori_nama }}</option>
                @endforeach
            </select>
            <span class="invalid-feedback" id="kategori_id_error"></span>
        </div>
        <div class="form-group">
            <label for="barang_kode">{{ __('Kode Barang') }}:</label>
            <input type="text" class="form-control" id="barang_kode" name="barang_kode" value="{{ $barangCode }}" required maxlength="10" readonly>
            <span class="invalid-feedback" id="barang_kode_error"></span>
        </div>
        <div class="form-group">
            <label for="barang_nama">{{ __('Nama Barang') }}:</label>
            <input type="text" class="form-control" id="barang_nama" name="barang_nama" required maxlength="100">
            <span class="invalid-feedback" id="barang_nama_error"></span>
        </div>
        <div class="form-group">
            <label for="harga_beli">{{ __('Harga Beli') }}:</label>
            <input type="number" class="form-control" id="harga_beli" name="harga_beli" required min="0">
            <span class="invalid-feedback" id="harga_beli_error"></span>
        </div>
        <div class="form-group">
            <label for="harga_jual">{{ __('Harga Jual') }}:</label>
            <input type="number" class="form-control" id="harga_jual" name="harga_jual" required min="0">
            <span class="invalid-feedback" id="harga_jual_error"></span>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</form>