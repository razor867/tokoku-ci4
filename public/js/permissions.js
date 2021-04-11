$(document).ready(function () {
  $(".sc_select").select2({
    theme: "bootstrap4",
    placeholder: "Pilih",
    allowClear: true,
  });

  $(".add").click(function () {
    $(".modal-title").text("Add Permissions");
    $("form").attr("action", "/permissions/add");
    $("#name").val("");
    $("#description").val("");
    $("#permissionsid").val("");
    $(".modal-footer").find(".btn-primary").text("Add");
  });

  $(".edit").click(function () {
    $(".modal-title").text("Edit Permissions");
    $("form").attr("action", "/permissions/edit");
    var id_permissions = $(this).attr("data");
    $("#permissionsid").val(id_permissions);
    $(".modal-footer").find(".btn-primary").text("Edit");
    $.ajax({
      url: "/permissions/get_data_edit",
      method: "post",
      dataType: "json",
      data: { id: id_permissions },
      success: function (data) {
        // console.log(data);
        $("#name").val(data.name);
        $("#description").val(data.description);
      },
    });
  });
});
