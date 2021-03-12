$(document).ready(function () {
  $(".add").click(function () {
    if (editClick == true) {
      cleanForm();
    }
    $(".modal-title").text("Tambah Satuan");
    $(".submit_btn").text("Add");
    $("#id").val("0");
    $("form").attr("action", "/satuan/addSatuan");
    if (infoFlash != "error_add") {
      cleanForm();
    }
  });

  $("#dataTable").DataTable({
    processing: true,
    oLanguage: {
      sLengthMenu: "Tampilkan _MENU_ data per halaman",
      sSearch: "Pencarian: ",
      sZeroRecords: "Maaf, tidak ada data yang ditemukan",
      sInfo: "Menampilkan _START_ s/d _END_ dari _TOTAL_ data",
      sInfoEmpty: "Menampilkan 0 s/d 0 dari 0 data",
      sInfoFiltered: "(di filter dari _MAX_ total data)",
      // 'oPaginate': {
      //     'sFirst': '<<',
      //     'slast': '>>',
      //     'sPrevious': '<',
      //     'sNext': '>'
      // }
    },
    columnDefs: [
      {
        orderable: false,
        targets: [2],
      },
      {
        className: "text-wrap w-25",
        targets: [0],
      },
      {
        className: "text-wrap w-50",
        targets: [1],
      },
    ],
    ordering: true,
    info: true,
    serverSide: true,
    stateSave: true,
    scrollX: true,
    ajax: {
      url: "/satuan/listdata",
      type: "post",
      error: function (e) {
        console.log("data tidak ditemukan di server");
      },
    },
  });
});

var editClick = false;

function cleanForm() {
  $("#satuan").val("");
  $("#id").val("0");
  $("#deskripsi").val("");
}

function edit(idEdit) {
  editClick = true;
  $(".modal-title").text("Edit Satuan");
  $(".submit_btn").text("Edit");
  $("form").attr("action", "/satuan/editSatuan");
  $("#id").val(idEdit);
  $.ajax({
    url: "/satuan/getRowSatuan",
    data: {
      id: idEdit,
    },
    method: "post",
    dataType: "json",
    success: function (data) {
      $("#satuan").val(data.nama_satuan);
      $("#deskripsi").val(data.deskripsi);
    },
  });
}
