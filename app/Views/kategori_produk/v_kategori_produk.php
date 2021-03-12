<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Kategori Produk</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary d-inline">Kategori untuk produk</h6>
            <a href="#" class="btn btn-primary btn-icon-split float-right add" data-toggle="modal" data-target="#kategori_produk_modal">
                <span class="icon text-white-50">
                    <i class="fas fa-flag"></i>
                </span>
                <span class="text">Add kategori</span>
            </a>
        </div>
        <div class="card-body" style="overflow-y: scroll; height:400px;">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="text-wrap w-25">Kategori</th>
                            <th class="text-wrap w-50">Deskripsi</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th class="text-wrap w-25">Kategori</th>
                            <th class="text-wrap w-50">Deskripsi</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

</div>
<?= $this->endSection() ?>

<?= $this->section('modal_cutom') ?>
<div class="modal fade" id="kategori_produk_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                            <label for="kategori">Nama Kategori</label>
                            <input type="text" class="form-control <?= ($validation->hasError('kategori')) ? 'is-invalid' : '' ?>" id="kategori" name="kategori" autofocus value="<?= old('kategori') ?>" required>
                            <div class="invalid-feedback">
                                <?= $validation->getError('kategori') ?>
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
<script src="js/cat_produk_details.js"></script>
<?= $this->endSection() ?>