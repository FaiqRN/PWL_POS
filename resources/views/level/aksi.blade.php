<form action="{{ route('level.destroy', $level) }}" method="POST" style="display:inline;">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-sm btn-danger" 
    onclick="return confirm('{{ __('level.confirm_delete') }}')">{{ __('Hapus') }}</button>
</form>



