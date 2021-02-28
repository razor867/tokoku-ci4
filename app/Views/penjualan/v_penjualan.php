<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Penjualan</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary d-inline">Daftar Penjualan</h6>
            <a href="#" class="btn btn-primary btn-icon-split float-right add" data-toggle="modal" data-target="#penjualan_modal">
                <span class="icon text-white-50">
                    <i class="fas fa-flag"></i>
                </span>
                <span class="text">Add Penjualan</span>
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Satuan</th>
                            <th>Qty</th>
                            <th>Total Jual</th>
                            <th>Tanggal</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Produk</th>
                            <th>Satuan</th>
                            <th>Qty</th>
                            <th>Total Jual</th>
                            <th>Tanggal</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php
                        function rupiah($angka)
                        {
                            $hasil_rupiah = "Rp" . number_format($angka);
                            return $hasil_rupiah;
                        }
                        ?>
                        <?php foreach ($penjualan as $p) : ?>
                            <tr>
                                <td><?= $p->nama_produk ?></td>
                                <td><?= $p->nama_satuan ?></td>
                                <td><?= $p->qty ?></td>
                                <td><?= rupiah($p->total_jual) ?></td>
                                <td><?= $p->tanggal_jual ?></td>
                                <td>
                                    <a href="#" data="<?= $p->id ?>" class="btn btn-warning btn-circle edit" data-toggle="modal" data-target="#penjualan_modal" title="Edit">
                                        <i class="fas fa-exclamation-triangle"></i>
                                    </a>
                                    <a href="/penjualan/deletePenjualan/<?= $p->id ?>" class="btn btn-danger btn-circle delete" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<?= $this->endSection() ?>

<?= $this->section('modal_cutom') ?>
<div class="modal fade" id="penjualan_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="">
                    <?= csrf_field() ?>
                    <div class="form-row">
                        <input type="hidden" name="id" id="id">
                        <div class="col-md-6 mb-3">
                            <label for="produk">Nama Produk</label>
                            <select name="produk" id="produk" class="form-control sc_select <?= ($validation->hasError('produk') ? 'is-invalid' : '') ?>" required autofocus>
                                <option value=""></option>
                                <?php foreach ($produk as $s) : ?>
                                    <option value="<?= $s->id ?>" <?= (old('produk') == $s->id ? 'selected' : '') ?>><?= $s->nama_produk ?><small> (<?= $s->nama_category ?>)</small></option>
                                    <script>
                                        data_idProduk.push("<?= $s->id ?>");
                                        data_hargaProduk.push("<?= $s->harga ?>");
                                        data_stok.push("<?= $s->stok ?>");
                                    </script>
                                <?php endforeach ?>
                            </select>
                            <div class="invalid-feedback">
                                <?= $validation->getError('produk') ?>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="satuan">Satuan</label>
                            <select name="satuan" id="satuan" class="form-control sc_select <?= ($validation->hasError('satuan') ? 'is-invalid' : '') ?>" required autofocus>
                                <option value=""></option>
                                <?php foreach ($satuan as $s) : ?>
                                    <option value="<?= $s->id ?>" <?= (old('satuan') == $s->id ? 'selected' : '') ?>><?= $s->nama_satuan ?></option>
                                <?php endforeach ?>
                            </select>
                            <div class="invalid-feedback">
                                <?= $validation->getError('satuan') ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label for="qty">Qty</label>
                            <input type="number" class="form-control <?= ($validation->hasError('qty') ? 'is-invalid' : '') ?>" id="qty" name="qty" min="1" required autofocus value="<?= old('qty') ?>">
                            <div class="invalid-feedback">
                                <?= $validation->getError('qty') ?>
                            </div>
                            <small class="info_stok"></small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="total_jual">Total Jual</label>
                            <input type="number" class="form-control <?= ($validation->hasError('total_jual') ? 'is-invalid' : '') ?>" id="total_jual" name="total_jual" min="1" required autofocus value="<?= old('total_jual') ?>" data-a-sign="Rp. " data-a-dec="," data-a-sep="." readonly>
                            <div class="invalid-feedback">
                                <?= $validation->getError('total_jual') ?>
                            </div>
                            <i><small class="written_nominal"></small></i>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary submit_btn">Save changes</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('css_custom') ?>
<link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">
<script>
    var data_idProduk = [],
        data_stok = [],
        data_hargaProduk = [];
</script>
<?= $this->endSection() ?>

<?= $this->section('js_plugins') ?>
<script src="vendor/datatables/jquery.dataTables.min.js"></script>
<script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="/js/autoNumeric/autoNumeric.js"></script>
<script src="/js/numToWord/numToWord.js"></script>
<?= $this->endSection() ?>

<?= $this->section('js_custom') ?>
<script src="/js/demo/datatables-demo.js"></script>
<script>
    var tempQty = $('#qty').val();
    $('#total_jual').autoNumeric('init');

    function forQty(qty) {
        if (qty < 1) {
            $('#qty').val('1');
            $('#total_jual').val(original_price);
        } else {
            $('#total_jual').val('');
            tempQty = qty;
            total_price = original_price * qty;
        }
        $('#total_jual').val(total_price);
        $('.written_nominal').text('*' + convert($('#total_jual').val()) + ' rupiah*');
        $(".written_nominal:contains('satu ratus')").text($('.written_nominal').text().replace('satu ratus', 'seratus'));
        $(".written_nominal:contains('satu ribu')").text($('.written_nominal').text().replace('satu ribu', 'seribu'));
    }

    $(document).ready(function() {

        $('.add').click(function() {
            tempQty = 0;
            $('.written_nominal').empty();
            $('.modal-title').text('Tambah Penjualan');
            $('.submit_btn').text('Add');
            $('form').attr('action', '<?= base_url("penjualan/addPenjualan") ?>');
            if ('<?= session()->getFlashdata("info") ?>' != 'error') {
                $('#produk').val('').trigger('change');
                $('#satuan').val('').trigger('change');
                $('#qty').val('');
                $('#total_jual').val('');
                $('#id').val('');
            }
            $('.info_stok').empty();
        });

        $('.edit').click(function() {
            tempQty = 0;
            $('.modal-title').text('Edit Penjualan');
            $('.submit_btn').text('Edit');
            $('form').attr('action', '<?= base_url("penjualan/editPenjualan") ?>');
            $('#id').val($(this).attr('data'));
            $.ajax({
                url: '<?= base_url("penjualan/getRowPenjualan") ?>',
                data: {
                    id: $(this).attr('data'),
                },
                method: 'post',
                dataType: 'json',
                success: function(data) {
                    $('#produk').val(data.id_produk).trigger('change');
                    $('#satuan').val(data.id_satuan).trigger('change');
                    $('#qty').val(data.qty);
                    $('#total_jual').val(data.total_jual);
                    $('.written_nominal').text('*' + convert($('#total_jual').val()) + ' rupiah*');
                }
            })
        });

        $('.transaksi').click();
        $('.sc_select').select2({
            theme: 'bootstrap4',
            placeholder: "Pilih",
            allowClear: true
        });

        $('#qty').change(function() {
            forQty($(this).val());
        });

        $('#qty').keyup(function() {
            forQty($(this).val());
        });

        $('#produk').change(function() {
            var index = data_idProduk.indexOf($(this).val());
            $('#qty').val('1');
            tempQty = $('#qty').val();
            $('#total_jual').val(data_hargaProduk[index]);
            original_price = $('#total_jual').val();
            $('#id').val($(this).val());
            $('.info_stok').html('<i class="fas fa-info-circle"></i> Stok produk saat ini : ' + data_stok[index]);
            $('.written_nominal').text('*' + convert($('#total_jual').val()) + ' rupiah*');
        });

        $(".written_nominal:contains('satu ratus')").text($('.written_nominal').text().replace('satu ratus', 'seratus'));
        $(".written_nominal:contains('satu ribu')").text($('.written_nominal').text().replace('satu ribu', 'seribu'));
    })
</script>
<?= $this->endSection() ?>