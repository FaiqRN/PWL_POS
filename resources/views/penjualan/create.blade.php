<div class="modal-header">
    <h5 class="modal-title">Tambah Penjualan</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
    <form id="penjualanForm">
        @csrf
    
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="form-group">
                    <label>User</label>
                    <select class="form-control" name="user_id" required>
                        <option value="">Pilih User</option>
                        @foreach($users as $user)
                            <option value="{{ $user->user_id }}">{{ $user->nama }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Pembeli</label>
                    <input type="text" class="form-control" name="pembeli" required>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Kode Penjualan</label>
                    <input type="text" class="form-control" value="{{ $penjualanKode }}" readonly>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Tanggal Penjualan</label>
                    <input type="datetime-local" class="form-control" name="tanggal" value="{{ date('Y-m-d\TH:i') }}" required>
                </div>
            </div>
        </div>

        <div id="barang-container">
        </div>

        <template id="barang-template">
            <div class="barang-item mb-3">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Barang</label>
                            <select class="form-control barang-select" name="barang_id[]" required>
                                <option value="">Pilih Barang</option>
                                @foreach($barangs as $barang)
                                    <option value="{{ $barang->barang_id }}" 
                                            data-stok="{{ $barang->stok_total }}"
                                            data-harga="{{ $barang->harga_jual }}">
                                        {{ $barang->barang_nama }} (Stok: {{ $barang->stok_total }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Jumlah</label>
                            <input type="number" class="form-control jumlah" name="jumlah[]" min="1" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Harga</label>
                            <input type="number" class="form-control harga" name="harga[]" readonly>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Total</label>
                            <input type="text" class="form-control total" readonly>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Stok</label>
                            <input type="text" class="form-control stok" readonly>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <button type="button" class="btn btn-danger btn-sm btn-block hapus-barang">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </template>

        <button type="button" class="btn btn-success btn-sm" id="tambah-barang">+ Tambah Barang</button>

        <div class="form-group mt-3">
            <label>Total Keseluruhan</label>
            <input type="text" class="form-control" id="total-keseluruhan" readonly>
        </div>
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
    <button type="button" class="btn btn-primary" onclick="simpanPenjualan()">Simpan</button>
</div>

<script>
$(document).ready(function() {
    
    tambahBarang();

    $('#tambah-barang').click(function() {
        tambahBarang();
    });

    $(document).on('click', '.hapus-barang', function() {
        if ($('.barang-item').length > 1) {
            $(this).closest('.barang-item').remove();
            hitungTotalKeseluruhan();
        }
    });

    $(document).on('change', '.barang-select', function() {
        let row = $(this).closest('.barang-item');
        let selected = $(this).find(':selected');
        
        if (selected.val()) {
            row.find('.harga').val(selected.data('harga'));
            row.find('.stok').val(selected.data('stok'));
            row.find('.jumlah')
                .attr('max', selected.data('stok'))
                .trigger('input');
        } else {
            row.find('.harga, .stok, .jumlah, .total').val('');
        }
    });

    $(document).on('input', '.jumlah', function() {
        let row = $(this).closest('.barang-item');
        let jumlah = parseInt($(this).val()) || 0;
        let stok = parseInt(row.find('.stok').val()) || 0;
        let harga = parseFloat(row.find('.harga').val()) || 0;

        if (jumlah > stok) {
            alert('Jumlah melebihi stok tersedia!');
            $(this).val(stok);
            jumlah = stok;
        }

        row.find('.total').val(formatRupiah(jumlah * harga));
        hitungTotalKeseluruhan();
    });
});

function tambahBarang() {
    let template = document.querySelector('#barang-template');
    let clone = document.importNode(template.content, true);
    document.querySelector('#barang-container').appendChild(clone);
}

function formatRupiah(angka) {
    return 'Rp ' + new Intl.NumberFormat('id-ID').format(angka);
}

function hitungTotalKeseluruhan() {
    let total = 0;
    $('.barang-item').each(function() {
        let jumlah = parseInt($(this).find('.jumlah').val()) || 0;
        let harga = parseFloat($(this).find('.harga').val()) || 0;
        total += jumlah * harga;
    });
    $('#total-keseluruhan').val(formatRupiah(total));
}

function simpanPenjualan() {
    $.ajax({
        url: "{{ route('penjualan.store') }}",
        method: 'POST',
        data: $('#penjualanForm').serialize(),
        success: function(response) {
            if (response.status) {
                $('#penjualanModal').modal('hide');
                dataTable.ajax.reload();
                Swal.fire('Berhasil!', response.message, 'success');
            } else {
                Swal.fire('Gagal!', response.message, 'error');
            }
        },
        error: function(xhr) {
            Swal.fire('Error!', xhr.responseJSON.message || 'Terjadi kesalahan', 'error');
        }
    });
}
</script>