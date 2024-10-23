<div class="modal-header">
    <h5 class="modal-title" id="barangModalLabel">Edit Barang</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<form action="{{ route('barang.update', $barang->barang_id) }}" method="POST" id="barangForm">
    @csrf
    @method('PUT')
    <div class="modal-body">
        <div class="form-group">
            <label for="barang_kode">Kode Barang</label>
            <input type="text" class="form-control" id="barang_kode" name="barang_kode" value="{{ $barang->barang_kode }}" readonly>
            <small id="barang_kode_error" class="text-danger"></small>
        </div>
        <div class="form-group">
            <label for="kategori_id">Kategori</label>
            <select class="form-control" id="kategori_id" name="kategori_id">
                <option value="">Pilih Kategori</option>
                @foreach($kategoris as $kategori)
                    <option value="{{ $kategori->kategori_id }}" {{ $kategori->kategori_id == $barang->kategori_id ? 'selected' : '' }}>
                        {{ $kategori->kategori_nama }}
                    </option>
                @endforeach
            </select>
            <small id="kategori_id_error" class="text-danger"></small>
        </div>
        <div class="form-group">
            <label for="barang_nama">Nama Barang</label>
            <input type="text" class="form-control" id="barang_nama" name="barang_nama" value="{{ $barang->barang_nama }}">
            <small id="barang_nama_error" class="text-danger"></small>
        </div>
        <div class="form-group">
            <label for="harga_beli">Harga Beli</label>
            <input type="number" class="form-control" id="harga_beli" name="harga_beli" value="{{ $barang->harga_beli }}" min="0">
            <small id="harga_beli_error" class="text-danger"></small>
        </div>
        <div class="form-group">
            <label for="harga_jual">Harga Jual</label>
            <input type="number" class="form-control" id="harga_jual" name="harga_jual" value="{{ $barang->harga_jual }}" min="0">
            <small id="harga_jual_error" class="text-danger"></small>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</form>