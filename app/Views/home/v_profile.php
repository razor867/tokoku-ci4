<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Profile</h1>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Content Column -->
        <div class="col-md-12 mb-4">

            <!-- Project Card Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3" style="background-color: #5a5c69;">
                    <h6 class="m-0 font-weight-bold text-white">Dashboard Profile</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <img src="/img/<?= user()->profile_picture ?>" class="w-100 mb-4">
                        </div>
                        <div class="col-md-9">
                            <?php
                            function user_role_name($id_user)
                            {
                                $model_users = new \App\Models\Users_model();
                                return $model_users->getRoleNameById($id_user);
                            }
                            ?>
                            <?php if (user()->firstname == null || user()->lastname == null) : ?>
                                <h4 class="h4 mb-2">Edit your profile</h4>
                                <small class="mb-4"><?= user_role_name(user_id()) ?></small><br />
                                <h5 class="h5 mb-2 mt-4">About me</h5>
                                <p>
                                    Edit your profile and tell about yourself.
                                </p>
                            <?php else : ?>
                                <h4 class="h4 mb-2"><?= user()->firstname . ' ' . user()->lastname ?></h4>
                                <small class="mb-4"><?= user_role_name(user_id()) ?></small><br />
                                <h5 class="h5 mb-2 mt-4">About me</h5>
                                <p>
                                    <?= user()->about_me ?>
                                </p>
                            <?php endif; ?>
                            <a href="#" class="btn btn-primary btn-icon-split float-right" data-toggle="modal" data-target="#exampleModal">
                                <span class="icon text-white-50">
                                    <i class="fas fa-pencil-alt"></i>
                                </span>
                                <span class="text">Edit Profile</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>
<?= $this->endSection() ?>

<?= $this->section('modal_cutom') ?>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #5a5c69;">
                <h5 class="modal-title text-white" id="exampleModalLabel">Edit Profile</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    <div class="form-group row">
                        <?= csrf_field() ?>
                        <label for="photo" class="col-sm-3 col-form-label">Photo</label>
                        <div class="col-sm-4">
                            <img src="/img/<?= user()->profile_picture ?>" id="output" class="img-thumbnail img-preview">
                        </div>
                        <div class="col-sm-5">
                            <div class="input-group mb-3">
                                <div class="custom-file">
                                    <input style="display: none;" type="file" name="photo" accept="image/gif, image/jpeg, image/png" class="custom-file-input" id="photo" onchange="loadFile(event)" aria-describedby="inputGroupFileAddon01">
                                    <label style="display: none;" class="custom-file-label" for="photo">Choose file</label>
                                    <a href="javascript:void(0)" id="upload_photo" class="btn btn-success">Upload picture</a>
                                </div>
                            </div>
                            <small><i>*Files must be .png or .jpg*</i></small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="firstname" class="col-sm-3 col-form-label">Your name</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="firstname" name="firstname" placeholder="firstname">
                        </div>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="lastname" name="lastname" placeholder="lastname">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="about" class="col-sm-3 col-form-label">About me</label>
                        <div class="col-sm-9">
                            <textarea id="about" class="form-control" name="about" rows="4" cols="50"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('css_custom') ?>
<?= $this->endSection() ?>

<?= $this->section('js_plugins') ?>

<?= $this->endSection() ?>

<?= $this->section('js_custom') ?>
<script>
    var loadFile = function(event) {
        var image = document.getElementById('output');
        image.src = URL.createObjectURL(event.target.files[0]);
    }
    $('#upload_photo').click(function() {
        $('#photo').click();
    })
</script>
<?= $this->endSection() ?>