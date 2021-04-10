$(document).ready(function () {
  $(".sc_select").select2({
    theme: "bootstrap4",
    placeholder: "Pilih",
    allowClear: true,
  });

  $(".add").click(function () {
    $(".modal-title").text("Add User");
    $("form").attr("action", "/home/add_new_user");
    $("#userid").val("");
    $(".modal-footer").find(".btn-primary").text("Add");
  });

  $(".edit").click(function () {
    $(".modal-title").text("Edit User");
    $("form").attr("action", "/home/edit_user_account");
    var id_user = $(this).attr("data");
    $("#userid").val(id_user);
    $(".modal-footer").find(".btn-primary").text("Edit");
    $.ajax({
      url: "/home/get_user_account",
      method: "post",
      dataType: "json",
      data: { id_user: id_user },
      success: function (data) {
        // console.log(data);
        $("#email").val(data.email);
        $("#username").val(data.username);
        // $("#password").val(data.password_hash);
        $("#roles").val(data.roles_id).trigger("change");
      },
    });
  });
});
