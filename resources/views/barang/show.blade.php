<div class="modal-header">
    <h5 class="modal-title" id="barangModalLabel">Detail Barang</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <table class="table table-bordered">
        <tr>
            <th style="width: 200px;">{{ __('ID Barang') }}</th>
            <td>{{ $barang->barang_id }}</td>
        </tr>
        <tr>
            <th>{{ __('Kategori') }}</th>
            <td>{{ $barang->kategori->kategori_nama }}</td>
        </tr>
        <tr>
            <th>{{ __('Kode Barang') }}</th>
            <td>{{ $barang->barang_kode }}</td>
        </tr>
        <tr>
            <th>{{ __('Nama Barang') }}</th>
            <td>{{ $barang->barang_nama }}</td>
        </tr>
        <tr>
            <th>{{ __('Harga Beli') }}</th>
            <td>Rp {{ number_format($barang->harga_beli, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <th>{{ __('Harga Jual') }}</th>
            <td>Rp {{ number_format($barang->harga_jual, 0, ',', '.') }}</td>
        </tr>
    </table>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
</div>