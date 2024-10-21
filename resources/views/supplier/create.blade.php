<form id="supplierForm" action="{{ route('supplier.store') }}" method="POST">
    @csrf
    <div class="modal-header">
        <h5 class="modal-title" id="supplierModalLabel">Tambah Supplier</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label for="supplier_kode">Kode Supplier</label>
            <input type="text" class="form-control" id="supplier_kode" name="supplier_kode" value="{{ $supplierCode }}" readonly>
            <span class="invalid-feedback" id="supplier_kode_error"></span>
        </div>
        <div class="form-group">
            <label for="supplier_nama">Nama Supplier</label>
            <input type="text" class="form-control" id="supplier_nama" name="supplier_nama" required>
            <span class="invalid-feedback" id="supplier_nama_error"></span>
        </div>
        <div class="form-group">
            <label for="supplier_alamat">Alamat Supplier</label>
            <textarea class="form-control" id="supplier_alamat" name="supplier_alamat" required></textarea>
            <span class="invalid-feedback" id="supplier_alamat_error"></span>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</form>