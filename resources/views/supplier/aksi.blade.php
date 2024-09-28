<div class="btn-group" role="group" aria-label="Basic example">
    <a href="{{ route('supplier.show', $supplier->supplier_id) }}" class="btn btn-sm btn-info me-2 mx-1">{{ __('Detail') }}</a>
    <a href="{{ route('supplier.edit', $supplier->supplier_id) }}" class="btn btn-sm btn-warning me-2 mx-1">{{ __('Edit') }}</a>
    <form action="{{ route('supplier.destroy', $supplier->supplier_id) }}" method="POST" onsubmit="return confirm('{{ __('Anda yakin ingin menghapus supplier ini?') }}');" style="display: inline-block;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-danger me-2 mx-1">{{ __('Hapus') }}</button>
    </form>
</div>