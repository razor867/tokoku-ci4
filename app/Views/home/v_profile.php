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
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Dashboard Profile</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                        <img src="/img/ganteng.jpg" class="w-100 mb-4">
                    </div>
                    <div class="col-md-9">
                        <h4 class="h4 mb-2">Wahyu Arya Pambudi</h4>
                        <small class="mb-4">Operator Admin</small><br />
                        <h5 class="h5 mb-2 mt-4">About me</h5>
                        <p>
                            Edit your profile and tell about yourself.
                        </p>
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
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Profile</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
            <div class="form-group row">
                <?= csrf_field() ?>
                <label for="photo" class="col-sm-3 col-form-label">Photo</label>
                 <div class="col-sm-4">
                    <img src="/img/ganteng.jpg" class="img-thumbnail img-preview">
                </div>
                <div class="col-sm-5">
                    <div class="input-group mb-3">
                        <div class="custom-file">
                            <input type="file" name="photo" class="custom-file-input" id="photo" aria-describedby="inputGroupFileAddon01">
                            <label class="custom-file-label" for="photo">Choose file</label>
                        </div>
                    </div>
                    <small><i>*Files must be .png or .jpg*</i></small>
                </div>
            </div>
            <div class="form-group row">
                <label for="name" class="col-sm-3 col-form-label">Name</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="name">
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

<?= $this->endSection() ?>