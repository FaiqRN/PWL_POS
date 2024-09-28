@extends('layouts.template')
@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $breadcrumb->title }}</h3>
        <div class="card-tools">
            <a class="btn btn-sm btn-primary mt-1" href="{{ route('kategori.create') }}">{{ __('Tambah') }}</a>
        </div>
    </div>
    <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <table class="table table-bordered table-striped table-hover table-sm" id="table_kategori">
            <thead>
                <tr>
                    <th>{{ __('ID') }}</th>
                    <th>{{ __('Kode Kategori') }}</th>
                    <th>{{ __('Nama') }}</th>
                    <th>{{ __('Aksi') }}</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@endsection

@push('css')
@endpush

@push('js')

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function() {
        var dataKategori = $('#table_kategori').DataTable({
            serverSide: true,
            processing: true,
            ajax: "{{ route('kategori.index') }}",
            columns: [
                {data: "kategori_id", name: "kategori_id"},
                {data: "kategori_kode", name: "kategori_kode"},
                {data: "kategori_nama", name: "kategori_nama"},
                {data: "aksi", name: "aksi", orderable: false, searchable: false}
            ],
            order: [[0, 'asc']],
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.25/i18n/Indonesian.json"
            }
        });

        $('#table_kategori_filter input').unbind().bind('keyup', function() {
            dataKategori.search(this.value).draw();
        });
    });
</script>
@endpush
