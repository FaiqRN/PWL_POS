<button onclick="editBarang({{ $barang->barang_id }})" class="btn btn-sm btn-warning">{{ __('Edit') }}</button>
<button onclick="showBarang({{ $barang->barang_id }})" class="btn btn-sm btn-info">{{ __('Detail') }}</button>
<button onclick="deleteBarang({{ $barang->barang_id }})" class="btn btn-sm btn-danger">{{ __('Hapus') }}</button>