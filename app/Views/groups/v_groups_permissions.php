<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Groups Permissions</h1>

    <!-- DataTales Example -->
    <ul class="list-group list-group-flush w-50">
        <?php foreach ($groups_data as $p) : ?>
            <li class="list-group-item">
                <?= $p->name ?>
                <a href="javascript:void(0)" data="<?= $p->id ?>" class="btn btn-primary btn-circle edit float-right" data-toggle="modal" data-target="#addGroups" title="Edit">
                    <i class="fas fa-tools"></i>
                </a>
            </li>
        <?php endforeach ?>
    </ul>

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
                <form action="/groups_perm/edit" method="post">
                    <?= csrf_field() ?>
                    <div class="form-group">
                        <label for="name">Groups Name</label>
                        <input type="text" disabled id="name" class="form-control <?php if ($validation->hasError('name')) : ?>is-invalid<?php endif ?>" name="name" placeholder="Groups Name" value="<?= old('name') ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('name') ?>
                        </div>
                    </div>
                    <p>Permissions</p>
                    <div class="list_permissions">
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
<style>
    .list_permissions {
        width: 100%;
        max-height: 300px;
        background-color: #e4e4e4;
        border-radius: 5px;
        padding: 13px;
        overflow-y: auto;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('js_plugins') ?>
<script src="/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="/vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<?= $this->endSection() ?>

<?= $this->section('js_custom') ?>
<script src="/js/demo/datatables-demo.js"></script>
<script src="/js/groups_perm.js"></script>
<script>
    $(document).ready(function() {
        $(".edit").click(function() {
            $('.list_permissions').empty();
            $("form").attr("action", "/groups_perm/edit");
            var id_groups = $(this).attr("data");
            $("#groupsid").val(id_groups);
            $(".modal-footer").find(".btn-primary").text("Save Settings");
            $.ajax({
                url: "/groups/get_data_edit",
                method: "post",
                dataType: "json",
                data: {
                    id: id_groups
                },
                success: function(data) {
                    $("#name").val(data.name);
                },
            });
            $.ajax({
                url: "<?= base_url('groups_perm/get_listperm') ?>",
                method: "post",
                dataType: "json",
                data: {
                    id: id_groups
                },
                success: function(data) {
                    $(".list_permissions").append(data);
                },
            })
        });
    })
</script>
<?= $this->endSection() ?>