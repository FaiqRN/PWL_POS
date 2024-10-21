<div class="modal-header">
    <h5 class="modal-title" id="supplierModalLabel">Detail Supplier</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <table class="table table-bordered">
        <tr>
            <th>Kode Supplier</th>
            <td>{{ $supplier->supplier_kode }}</td>
        </tr>
        <tr>
            <th>Nama Supplier</th>
            <td>{{ $supplier->supplier_nama }}</td>
        </tr>
        <tr>
            <th>Alamat Supplier</th>
            <td>{{ $supplier->supplier_alamat }}</td>
        </tr>
    </table>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
</div>