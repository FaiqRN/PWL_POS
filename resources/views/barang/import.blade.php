<form action="{{ route('barang.import_ajax') }}" method="POST" id="form-import" enctype="multipart/form-data">
    @csrf
    <div class="modal-header">
        <h5 class="modal-title">Import Data Barang</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label>Download Template</label>
            <a href="{{ asset('template_barang.xlsx') }}" class="btn btn-info btn-sm">
                <i class="fa fa-file-excel"></i> Download
            </a>
        </div>
        <div class="form-group">
            <label>Pilih File</label>
            <input type="file" name="file_barang" id="file_barang" class="form-control" accept=".xlsx">
            <div id="error-file_barang" class="invalid-feedback"></div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Upload</button>
    </div>
</form>

<script>
    $(document).ready(function() {
        $("#form-import").validate({
            rules: {
                file_barang: {required: true, extension: "xlsx"},
            },
            submitHandler: function(form) {
                var formData = new FormData(form);  
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: formData,     
                    processData: false, 
                    contentType: false,
                    success: function(response) {
                        if(response.status){ 
                            $('#myModal').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message
                            });
                            tableBarang.ajax.reload(); 
                        }else{ 
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
                    }
                });
                return false;
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
    });
</script>