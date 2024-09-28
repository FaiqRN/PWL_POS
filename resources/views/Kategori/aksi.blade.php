<a href="{{ route('kategori.edit', $kategori->kategori_id) }}" class="btn btn-sm btn-warning">{{ __('Edit') }}</a>
<form action="{{ route('kategori.destroy', $kategori->kategori_id) }}" method="POST" style="display:inline;">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Anda yakin ingin menghapus kategori ini?')">{{ __('Hapus') }}</button>
</form>
