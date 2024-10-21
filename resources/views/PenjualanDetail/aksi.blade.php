<div class="btn-group" role="group" aria-label="Basic example">
    <a href="{{ route('PenjualanDetail.edit', $penjualanDetail->detail_id) }}" class="btn btn-sm btn-warning me-2 mx-1">{{ __('Edit') }}</a>
    <form action="{{ route('PenjualanDetail.destroy', $penjualanDetail->detail_id) }}" method="POST" onsubmit="return confirm('{{ __('Anda yakin ingin menghapus detail penjualan ini?') }}');" style="display: inline-block;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-danger me-2 mx-1">{{ __('Hapus') }}</button>
    </form>
</div>



