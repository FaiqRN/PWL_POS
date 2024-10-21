@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools">
            <a class="btn btn-sm btn-primary mt-1" href="{{ url('user/create') }}">Tambah</a>
            <button onclick="modalAction('{{ url('/user/create_ajax') }}')" class="btn btn-sm btn-success mt-1">Tambah Ajax</button>
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
        
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Filter:</label>
                        <div class="col-3">
                            <select class="form-control" id="level_id" name="level_id">
                                <option value="">- Semua -</option>
                                @foreach($level as $item)
                                    <option value="{{ $item->level_id }}">{{ $item->level_nama }}</option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Level Pengguna</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover table-sm" id="table_user">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Username</th>
                            <th>Nama</th>
                            <th>Level Pengguna</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            </div>
        </div>
    </div>
    @endsection

    @push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
    <style>
        .highlight {
            background-color: #FFFF99 !important;
            transition: background-color 1.5s ease-out;
        }
        #myModal .modal-dialog {
        max-width: 400px;
        }
        #myModal .modal-body {
            padding: 20px;
        }
        #myModal .form-group {
            margin-bottom: 15px;
        }
        #myModal .form-control:disabled {
            background-color: #f8f9fa;
            opacity: 1;
        }
        #myModal .modal-footer {
            justify-content: flex-end;
            border-top: none;
            padding-top: 0;
        }
        #myModal .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
        }
    </style>
    @endpush

    @push('js')
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
    <script>
    function modalAction(url = '') {
        $('#myModal').load(url, function() {
            $('#myModal').modal('show');
        });
    }

    var dataUser;
    $(document).ready(function() {
        dataUser = $('#table_user').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ url('user/list') }}",
                type: "POST",
                data: function (d) {
                    d.level_id = $('#level_id').val();
                    d._token = "{{ csrf_token() }}";
                }
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'username', name: 'username'},
                {data: 'nama', name: 'nama'},
                {data: 'level.level_nama', name: 'level_id'},
                {data: 'aksi', name: 'aksi', orderable: false, searchable: false}
            ],
            order: [[0, 'desc']]
        });

        $('#level_id').on('change', function() {
            dataUser.ajax.reload();
        });

        $(document).on('submit', '#form-tambah', function(e) {
        e.preventDefault();
        const form = $(this);
        $.ajax({
            url: form.attr('action'),
            method: form.attr('method'),
            data: form.serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.status) {
                    $('#myModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: response.message
                    });
                    
                    var newRowNode = dataUser.row.add([
                        response.data.DT_RowIndex,
                        response.data.username,
                        response.data.nama,
                        response.data.level.level_nama,
                        `<button onclick="showDetail('${response.data.detail_url}')" class="btn btn-info btn-sm">Detail</button>
                        <button onclick="editUser('${response.data.edit_url}')" class="btn btn-warning btn-sm">Edit</button>
                        <button onclick="deleteUser('${response.data.delete_url}')" class="btn btn-danger btn-sm">Hapus</button>`
                    ]).draw().node();

                    // Highlight baris baru
                    $(newRowNode).addClass('highlight');
                    setTimeout(function() {
                        $(newRowNode).removeClass('highlight');
                    }, 3000);

                    form[0].reset();
                } else {
                    $('.error-text').text('');
                    $.each(response.msgField, function(prefix, val) {
                        $('#error-'+prefix).text(val[0]);
                    });
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan',
                        text: response.message
                    });
                }
            },
            error: function(xhr) {
                console.error(xhr.responseText);
                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi Kesalahan',
                    text: 'Gagal menyimpan data. Silakan coba lagi.'
                });
            }
        });
    });
    });

    function showDetail(url) {
        $.ajax({
            url: url,
            type: 'GET',
            success: function(response) {
                if (response.status) {
                    var user = response.data;
                    var modalContent = `
                        <div class="modal-header">
                            <h5 class="modal-title">Detail User</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="user-id">ID</label>
                                <input type="text" class="form-control" id="user-id" value="${user.id}" disabled>
                            </div>
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" id="username" value="${user.username}" disabled>
                            </div>
                            <div class="form-group">
                                <label for="nama">Nama</label>
                                <input type="text" class="form-control" id="nama" value="${user.nama}" disabled>
                            </div>
                            <div class="form-group">
                                <label for="level">Level</label>
                                <input type="text" class="form-control" id="level" value="${user.level}" disabled>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        </div>
                    `;
                    $('#myModal .modal-content').html(modalContent);
                    $('#myModal').modal('show');
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Gagal memuat detail user'
                    });
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Terjadi kesalahan saat memuat detail user'
                });
            }
        });
    }

    function editUser(url) {
        $.ajax({
            url: url,
            type: 'GET',
            success: function(response) {
                if (response.status) {
                    var user = response.data;
                    var modalContent = `
                        <div class="modal-header">
                            <h5 class="modal-title">Edit User</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="editUserForm">
                                <input type="hidden" name="user_id" value="${user.user_id}">
                                <div class="form-group">
                                    <label>Username</label>
                                    <input type="text" class="form-control" name="username" value="${user.username}" required>
                                </div>
                                <div class="form-group">
                                    <label>Nama</label>
                                    <input type="text" class="form-control" name="nama" value="${user.nama}" required>
                                </div>
                                <div class="form-group">
                                    <label>Level</label>
                                    <select class="form-control" name="level_id" required>
                                        ${response.level.map(l => `<option value="${l.level_id}" ${l.level_id == user.level_id ? 'selected' : ''}>${l.level_nama}</option>`).join('')}
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Password (Kosongkan jika tidak ingin mengubah)</label>
                                    <input type="password" class="form-control" name="password">
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="button" class="btn btn-primary" onclick="updateUser()">Simpan Perubahan</button>
                        </div>
                    `;
                    $('#myModal .modal-content').html(modalContent);
                    $('#myModal').modal('show');
                } else {
                    alert('Gagal memuat data user');
                }
            },
            error: function() {
                alert('Terjadi kesalahan saat memuat data user');
            }
        });
    }

    function updateUser() {
        var formData = $('#editUserForm').serialize();
        $.ajax({
            url: "{{ url('user') }}/" + $('input[name="user_id"]').val() + "/update_ajax",
            type: 'PUT',
            data: formData,
            success: function(response) {
                if (response.status) {
                    $('#myModal').modal('hide');
                    dataUser.ajax.reload();
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Data user berhasil diupdate'
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Gagal mengupdate data user'
                    });
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Terjadi kesalahan saat mengupdate data'
                });
            }
        });
    }

    function deleteUser(url) {
        if (confirm('Apakah Anda yakin ingin menghapus user ini?')) {
            $.ajax({
                url: url,
                type: 'DELETE',
                data: {
                    "_token": "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response.status) {
                        $('#table_user').DataTable().ajax.reload();
                        alert('User berhasil dihapus');
                    } else {
                        alert('Gagal menghapus user');
                    }
                },
                error: function() {
                    alert('Terjadi kesalahan saat menghapus data');
                }
            });
        }
    }
    </script>
    @endpush