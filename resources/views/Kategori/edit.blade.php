<form id="kategoriForm" action="{{ route('kategori.update', $kategori->kategori_id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="modal-header">
        <h5 class="modal-title" id="kategoriModalLabel">Edit Kategori</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label for="kategori_kode">{{ __('Kode Kategori') }}:</label>
            <input type="text" class="form-control" id="kategori_kode" name="kategori_kode" value="{{ $kategori->kategori_kode }}" required>
            <span class="invalid-feedback" id="kategori_kode_error"></span>
        </div>
        <div class="form-group">
            <label for="kategori_nama">{{ __('Nama Kategori') }}:</label>
            <input type="text" class="form-control" id="kategori_nama" name="kategori_nama" value="{{ $kategori->kategori_nama }}" required>
            <span class="invalid-feedback" id="kategori_nama_error"></span>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary">Update</button>
    </div>
</form>