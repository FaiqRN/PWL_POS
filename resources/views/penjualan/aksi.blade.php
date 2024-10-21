<div class="btn-group" role="group" aria-label="Basic example">
    <a href="{{ route('penjualan.edit', $penjualan->penjualan_id) }}" class="btn btn-sm btn-warning me-2 mx-1">{{ __('Edit') }}</a>
    <form action="{{ route('penjualan.destroy', $penjualan->penjualan_id) }}" method="POST" onsubmit="return confirm('{{ __('Anda yakin ingin menghapus penjualan ini?') }}');" style="display: inline-block;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-danger me-2 mx-1">{{ __('Hapus') }}</button>
    </form>
</div>



