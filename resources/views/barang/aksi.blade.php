<a href="{{ route('barang.edit', $barang->barang_id) }}" class="btn btn-sm btn-warning">{{ __('Edit') }}</a>
<a href="{{ route('barang.show', $barang->barang_id) }}" class="btn btn-sm btn-info">{{ __('Detail') }}</a>
<form action="{{ route('barang.destroy', $barang->barang_id) }}" method="POST" style="display:inline;">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Anda yakin ingin menghapus barang ini?')">{{ __('Hapus') }}</button>
</form>