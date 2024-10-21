<div class="btn-group" role="group" aria-label="Basic example">
    <button onclick="editStok({{ $stok->stok_id }})" class="btn btn-sm btn-warning me-2 mx-1">{{ __('Edit') }}</button>
    <button onclick="deleteStok({{ $stok->stok_id }})" class="btn btn-sm btn-danger me-2 mx-1">{{ __('Hapus') }}</button>
</div>