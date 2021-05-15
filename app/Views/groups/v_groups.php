<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Groups</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3" style="background-color: #5a5c69;">
            <h6 class="m-0 font-weight-bold text-white d-inline">Daftar Groups</h6>
            <a href="#" class="btn btn-primary btn-icon-split float-right add" data-toggle="modal" data-target="#addGroups">
                <span class="icon text-white-50">
                    <i class="fas fa-flag"></i>
                </span>
                <span class="text">Add Groups</span>
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Groups</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Groups</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php foreach ($groups_data as $p) : ?>
                            <tr>
                                <td><?= $p->name ?></td>
                                <td><?= $p->description ?></td>
                                <td>
                                    <a href="javascript:void(0)" data="<?= $p->id ?>" class="btn btn-sm btn-warning btn-circle edit" data-toggle="modal" data-target="#addGroups" title="Edit">
                                        <i class="fas fa-exclamation-triangle"></i>
                                    </a>
                                    <a href="javascript:void(0)" class="btn btn-sm btn-danger btn-circle delete" onclick="deleteData('_groups','<?= $p->id ?>')" title="Delete">
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
<div class="modal fade" id="addGroups" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #5a5c69;">
                <h5 class="modal-title text-white" id="exampleModalLabel"><?= $modaltitle ?></h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/groups/add" method="post">
                    <?= csrf_field() ?>
                    <div class="form-group">
                        <label for="name">Groups Name</label>
                        <input type="text" id="name" class="form-control <?php if ($validation->hasError('name')) : ?>is-invalid<?php endif ?>" name="name" placeholder="Groups Name" value="<?= old('name') ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('name') ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <input type="text" id="description" class="form-control <?php if ($validation->hasError('description')) : ?>is-invalid<?php endif ?>" name="description" placeholder="Description" value="<?= old('description') ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('description') ?>
                        </div>
                    </div>
                    <input type="hidden" name="id_groups" id="groupsid">
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Add</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('css_custom') ?>
<link href="/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">
<?= $this->endSection() ?>

<?= $this->section('js_plugins') ?>
<script src="/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="/vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<?= $this->endSection() ?>

<?= $this->section('js_custom') ?>
<script src="/js/demo/datatables-demo.js"></script>
<script src="/js/groups.js"></script>
<?= $this->endSection() ?>