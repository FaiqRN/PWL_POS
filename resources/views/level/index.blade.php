@extends('layouts.template')
@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $breadcrumb->title }}</h3>
        <div class="card-tools">
            <a class="btn btn-sm btn-primary mt-1" href="{{ route('level.create') }}">{{ __('Tambah') }}</a>
        </div>
    </div>
    <div class="card-body">
        @if (session('success'))
        <div class="alert alert-success">{{session('success')}}</div>
        @endif
        @if (session('error'))
        <div class="alert alert-danger">{{session('error')}}</div>
        @endif
        <table class="table table-bordered table-striped table-hover table-sm" id="table_level">
            <thead>
                <tr>
                    <th>{{ __('ID') }}</th>
                    <th>{{ __('Kode') }}</th>
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
        var dataLevel = $('#table_level').DataTable({
            serverSide: true,
            processing: true,
            ajax: "{{ route('level.index') }}",
            columns: [
                {data: "level_id", name: "level_id"},
                {data: "level_kode", name: "level_kode"},
                {data: "level_nama", name: "level_nama"},
                {data: "aksi", name: "aksi", orderable: false, searchable: false}
            ],
            order: [[0, 'asc']],
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.25/i18n/Indonesian.json"
            }
        });


        $('#table_level_filter input').unbind().bind('keyup', function() {
            dataLevel.search(this.value).draw();
        });
    });
</script>
@endpush



