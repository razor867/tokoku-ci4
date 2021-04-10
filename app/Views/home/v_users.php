<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Users</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3" style="background-color: #5a5c69;">
            <h6 class="m-0 font-weight-bold text-white d-inline">Daftar User</h6>
            <a href="#" class="btn btn-primary btn-icon-split float-right add" data-toggle="modal" data-target="#addUserModal">
                <span class="icon text-white-50">
                    <i class="fas fa-flag"></i>
                </span>
                <span class="text">Add User</span>
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Image</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php
                        $class_badge = '';
                        function user_role_name($id_user)
                        {
                            $model_users = new \App\Models\Users_model();
                            return $model_users->getRoleNameById($id_user);
                        }
                        ?>
                        <?php foreach ($user_data as $u) : ?>
                            <?php
                            $user_role = user_role_name($u->id);
                            if ($user_role == 'Super Admin') {
                                $class_badge = 'badge-success';
                            } else if ($user_role == 'Admin') {
                                $class_badge = 'badge-info';
                            } else if ($user_role == 'Admin Kasir') {
                                $class_badge = 'badge-warning';
                            } else {
                                $class_badge = 'badge-primary';
                            }
                            ?>
                            <tr>
                                <td><img src="<?= '/img/' . $u->profile_picture ?>" width="75px" class="img-thumbnail img-preview"></td>
                                <td><?= $u->username ?></td>
                                <td><?= $u->email ?></td>
                                <td><span class="badge <?= $class_badge ?>"><?= $user_role ?></span></td>
                                <td>
                                    <a href="javascript:void(0)" data="<?= $u->id ?>" class="btn btn-warning btn-circle edit" data-toggle="modal" data-target="#addUserModal" title="Edit">
                                        <i class="fas fa-exclamation-triangle"></i>
                                    </a>
                                    <a href="javascript:void(0)" class="btn btn-danger btn-circle delete" onclick="deleteData('_datusers','<?= $u->id ?>')" title="Delete">
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
<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #5a5c69;">
                <h5 class="modal-title text-white" id="exampleModalLabel"><?= $modaltitle ?></h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/home/add_new_user" method="post">
                    <?= csrf_field() ?>
                    <div class="form-group">
                        <label for="email"><?= lang('Auth.email') ?></label>
                        <input type="email" id="email" class="form-control <?php if (session('errors.email')) : ?>is-invalid<?php endif ?>" name="email" aria-describedby="emailHelp" placeholder="<?= lang('Auth.email') ?>" value="<?= old('email') ?>">
                        <small id="emailHelp" class="form-text text-muted"><?= lang('Auth.weNeverShare') ?></small>
                        <div class="invalid-feedback">
                            <?= $validation->getError('email') ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="username"><?= lang('Auth.username') ?></label>
                        <input type="text" id="username" class="form-control <?php if ($validation->hasError('username')) : ?>is-invalid<?php endif ?>" name="username" placeholder="<?= lang('Auth.username') ?>" value="<?= old('username') ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('username') ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password"><?= lang('Auth.password') ?></label>
                        <input type="password" id="password" name="password" class="form-control <?php if ($validation->hasError('password')) : ?>is-invalid<?php endif ?>" placeholder="<?= lang('Auth.password') ?>" autocomplete="off">
                        <div class="invalid-feedback">
                            <?= $validation->getError('password') ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="pass_confirm"><?= lang('Auth.repeatPassword') ?></label>
                        <input type="password" id="pass_confirm" name="pass_confirm" class="form-control <?php if ($validation->hasError('pass_confirm')) : ?>is-invalid<?php endif ?>" placeholder="<?= lang('Auth.repeatPassword') ?>" autocomplete="off">
                        <div class="invalid-feedback">
                            <?= $validation->getError('pass_confirm') ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="roles">Role</label>
                        <select name="roles" id="roles" class="form-control sc_select <?= ($validation->hasError('roles') ? 'is-invalid' : '') ?>" required autofocus>
                            <option value=""></option>
                            <?php foreach ($roles as $s) : ?>
                                <option value="<?= $s->id ?>" <?= (old('roles') == $s->id ? 'selected' : '') ?>><?= $s->name ?></option>
                            <?php endforeach ?>
                        </select>
                        <div class="invalid-feedback">
                            <?= $validation->getError('roles') ?>
                        </div>
                    </div>
                    <input type="hidden" name="id_user" id="userid">
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
<script src="/js/users.js"></script>
<?= $this->endSection() ?>