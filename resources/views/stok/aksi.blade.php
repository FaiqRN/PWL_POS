<div class="btn-group" role="group" aria-label="Basic example">
    <a href="{{ route('stok.edit', $stok->stok_id) }}" class="btn btn-sm btn-warning me-2 mx-1">{{ __('Edit') }}</a>
    <form action="{{ route('stok.destroy', $stok->stok_id) }}" method="POST" onsubmit="return confirm('{{ __('Anda yakin ingin menghapus stok ini?') }}');" style="display: inline-block;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-danger me-2 mx-1">{{ __('Hapus') }}</button>
    </form>
</div>