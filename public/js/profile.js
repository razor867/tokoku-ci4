var loadFile = function (event) {
  var image = document.getElementById("output");
  image.src = URL.createObjectURL(event.target.files[0]);
};

$(document).ready(function () {
  $("#upload_photo").click(function () {
    $("#photo").click();
  });

  $(".edit_profile").click(function () {
    $.ajax({
      url: "/home/edit_user_page",
      method: "post",
      dataType: "json",
      data: {
        id_user: userlogid,
      },
      success: function (data) {
        // console.log(data);
        $("#photo").attr(
          "value",
          data.profile_picture != null ? data.profile_picture : ""
        );
        $("#firstname").attr(
          "value",
          data.firstname != null ? data.firstname : ""
        );
        $("#lastname").attr(
          "value",
          data.lastname != null ? data.lastname : ""
        );
        $("#about").html(data.about_me != null ? data.about_me : "");
        $("#old_sampul").attr(
          "value",
          data.profile_picture != null ? data.profile_picture : ""
        );
      },
    });
  });
});
