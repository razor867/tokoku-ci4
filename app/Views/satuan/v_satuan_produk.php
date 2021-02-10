<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Satuan Produk</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary d-inline">Satuan untuk produk</h6>
            <a href="#" class="btn btn-primary btn-icon-split float-right add" data-toggle="modal" data-target="#satuan_modal">
                <span class="icon text-white-50">
                    <i class="fas fa-flag"></i>
                </span>
                <span class="text">Add Satuan</span>
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Satuan</th>
                            <th>Deskripsi</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Satuan</th>
                            <th>Deskripsi</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php foreach ($satuan as $s) : ?>
                            <tr>
                                <td><?= $s->nama_satuan ?></td>
                                <td><?= $s->deskripsi ?></td>
                                <td>
                                    <a href="#" data="<?= $s->id ?>" class="btn btn-warning btn-circle edit" data-toggle="modal" data-target="#satuan_modal" title="Edit">
                                        <i class="fas fa-exclamation-triangle"></i>
                                    </a>
                                    <a href="/satuan/deleteSatuan/<?= $s->id ?>" class="btn btn-danger btn-circle delete" title="Delete">
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
<div class="modal fade" id="satuan_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                    <div class="form-row">
                        <input type="hidden" name="id" id="id">
                        <div class="col-md-6 mb-3">
                            <label for="satuan">Nama Satuan</label>
                            <input type="text" class="form-control <?= ($validation->hasError('satuan')) ? 'is-invalid' : '' ?>" id="satuan" name="satuan" autofocus value="<?= old('satuan') ?>" required>
                            <div class="invalid-feedback">
                                <?= $validation->getError('satuan') ?>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="deskripsi">Deskripsi</label>
                            <input type="text" class="form-control <?= ($validation->hasError('deskripsi')) ? 'is-invalid' : '' ?>" id="deskripsi" name="deskripsi" autofocus value="<?= old('deskripsi') ?>" required>
                            <div class="invalid-feedback">
                                <?= $validation->getError('deskripsi') ?>
                            </div>
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
<?= $this->endSection() ?>

<?= $this->section('js_plugins') ?>
<script src="vendor/datatables/jquery.dataTables.min.js"></script>
<script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
<?= $this->endSection() ?>

<?= $this->section('js_custom') ?>
<script src="js/demo/datatables-demo.js"></script>
<script>
    $(document).ready(function() {
        $('.add').click(function() {
            $('.modal-title').text('Tambah Satuan');
            $('.submit_btn').text('Add');
            $('form').attr('action', '<?= base_url("satuan/addSatuan") ?>');
            if ('<?= session()->getFlashdata("info") ?>' != 'error') {
                $('#satuan').val('');
                $('#id').val('');
                $('#deskripsi').val('');
            }
        })

        $('.edit').click(function() {
            $('.modal-title').text('Edit Satuan');
            $('.submit_btn').text('Edit');
            $('form').attr('action', '<?= base_url("satuan/editSatuan") ?>');
            $('#id').val($(this).attr('data'));
            $.ajax({
                url: '<?= base_url("satuan/getRowSatuan") ?>',
                data: {
                    id: $(this).attr('data'),
                },
                method: 'post',
                dataType: 'json',
                success: function(data) {
                    $('#satuan').val(data.nama_satuan);
                    $('#deskripsi').val(data.deskripsi);
                }
            })

        })
    })
</script>
<?= $this->endSection() ?>