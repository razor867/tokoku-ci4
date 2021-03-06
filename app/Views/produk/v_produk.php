<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Produk</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary d-inline">Daftar Produk</h6>
            <a href="#" class="btn btn-primary btn-icon-split float-right add" data-toggle="modal" data-target="#product_modal">
                <span class="icon text-white-50">
                    <i class="fas fa-flag"></i>
                </span>
                <span class="text">Add Produk</span>
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Kategori</th>
                            <th>Satuan</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Produk</th>
                            <th>Kategori</th>
                            <th>Satuan</th>
                            <th>Harga</th>
                            <th>Stok</th>
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
                        <?php foreach ($produk as $p) : ?>
                            <tr>
                                <td><?= $p->nama_produk ?><br><?= ($p->stok > 0) ? '<span class="badge badge-success">Tersedia</span>' : '<span class="badge badge-secondary">Kosong</span>' ?></td>
                                <td><?= $p->nama_category ?></td>
                                <td><?= $p->nama_satuan ?></td>
                                <td><?= rupiah($p->harga) ?></td>
                                <td><?= $p->stok ?></td>
                                <td>
                                    <a href="#" data="<?= $p->id ?>" class="btn btn-warning btn-circle edit" data-toggle="modal" data-target="#product_modal" title="Edit">
                                        <i class="fas fa-exclamation-triangle"></i>
                                    </a>
                                    <a href="/product/deleteProduct/<?= $p->id ?>" class="btn btn-danger btn-circle delete" title="Delete">
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
<div class="modal fade" id="product_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                            <label for="nama_produk">Nama Produk</label>
                            <input type="text" class="form-control <?= ($validation->hasError('nama_produk') ? 'is-invalid' : '') ?>" id="nama_produk" name="nama_produk" required autofocus value="<?= old('nama_produk') ?>">
                            <div class="invalid-feedback">
                                <?= $validation->getError('nama_produk') ?>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="category">Category</label>
                            <select name="category" id="category" class="form-control sc_select <?= ($validation->hasError('category') ? 'is-invalid' : '') ?>" required autofocus>
                                <option value=""></option>
                                <?php foreach ($cat_produk as $cp) : ?>
                                    <option value="<?= $cp->id ?>" <?= (old('category') == $cp->id ? 'selected' : '') ?>><?= $cp->nama_category ?></option>
                                <?php endforeach ?>
                            </select>
                            <div class="invalid-feedback">
                                <?= $validation->getError('category') ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
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
                        <div class="col-md-6 mb-3">
                            <label for="stok">Stok</label>
                            <input type="number" class="form-control <?= ($validation->hasError('stok') ? 'is-invalid' : '') ?>" id="stok" name="stok" min="0" required autofocus value="<?= old('stok') ?>">
                            <div class="invalid-feedback">
                                <?= $validation->getError('stok') ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="harga">Harga</label>
                        <input type="number" class="form-control <?= ($validation->hasError('harga') ? 'is-invalid' : '') ?>" id="harga" name="harga" min="0" required autofocus value="<?= old('harga') ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('harga') ?>
                        </div>
                        <i><small class="written_nominal"></small></i>
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
<?= $this->endSection() ?>

<?= $this->section('js_plugins') ?>
<script src="vendor/datatables/jquery.dataTables.min.js"></script>
<script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="/js/numToWord/numToWord.js"></script>
<?= $this->endSection() ?>

<?= $this->section('js_custom') ?>
<script src="js/demo/datatables-demo.js"></script>
<script>
    $(document).ready(function() {
        $('.add').click(function() {
            $('.modal-title').text('Tambah Produk');
            $('.submit_btn').text('Add');
            $('form').attr('action', '<?= base_url("product/addProduct") ?>');
            if ('<?= session()->getFlashdata("info") ?>' != 'error') {
                $('#nama_produk').val('');
                $('#category').val('').trigger('change');
                $('#satuan').val('').trigger('change');
                $('#stok').val('');
                $('#harga').val('');
                $('.written_nominal').html('');
            }
        })

        $('.edit').click(function() {
            $('.modal-title').text('Edit Produk');
            $('.submit_btn').text('Edit');
            $('form').attr('action', '<?= base_url("product/editProduct") ?>');
            $('#id').val($(this).attr('data'));
            $.ajax({
                url: '<?= base_url("product/getRowProduct") ?>',
                data: {
                    id: $(this).attr('data'),
                },
                method: 'post',
                dataType: 'json',
                success: function(data) {
                    $('#nama_produk').val(data.nama_produk);
                    $('#category').val(data.id_cat_produk).trigger('change');
                    $('#satuan').val(data.id_satuan).trigger('change');
                    $('#stok').val(data.stok);
                    $('#harga').val(data.harga);
                    $('.written_nominal').text('*' + convert($('#harga').val()) + ' rupiah*');
                }
            })
        })

        $('.sc_select').select2({
            theme: 'bootstrap4',
            placeholder: "Pilih",
            allowClear: true
        });

        $('#harga').keyup(function() {
            $('.written_nominal').text('*' + convert($('#harga').val()) + ' rupiah*');
            $(".written_nominal:contains('satu ratus')").text($('.written_nominal').text().replace('satu ratus', 'seratus'));
            $(".written_nominal:contains('satu ribu')").text($('.written_nominal').text().replace('satu ribu', 'seribu'));
        });

        $(".written_nominal:contains('satu ratus')").text($('.written_nominal').text().replace('satu ratus', 'seratus'));
        $(".written_nominal:contains('satu ribu')").text($('.written_nominal').text().replace('satu ribu', 'seribu'));
    })
</script>
<?= $this->endSection() ?>