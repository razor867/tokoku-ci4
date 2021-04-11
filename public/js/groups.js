$(document).ready(function () {
  $(".sc_select").select2({
    theme: "bootstrap4",
    placeholder: "Pilih",
    allowClear: true,
  });

  $(".groups").click();

  $(".add").click(function () {
    $(".modal-title").text("Add Groups");
    $("form").attr("action", "/groups/add");
    $("#name").val("");
    $("#description").val("");
    $("#groupsid").val("");
    $(".modal-footer").find(".btn-primary").text("Add");
  });

  $(".edit").click(function () {
    $(".modal-title").text("Edit Groups");
    $("form").attr("action", "/groups/edit");
    var id_groups = $(this).attr("data");
    $("#groupsid").val(id_groups);
    $(".modal-footer").find(".btn-primary").text("Edit");
    $.ajax({
      url: "/groups/get_data_edit",
      method: "post",
      dataType: "json",
      data: { id: id_groups },
      success: function (data) {
        // console.log(data);
        $("#name").val(data.name);
        $("#description").val(data.description);
      },
    });
  });
});
