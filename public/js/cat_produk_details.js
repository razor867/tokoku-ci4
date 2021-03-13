$(document).ready(function () {
  $(".add").click(function () {
    if (editClick == true) {
      cleanForm();
    }
    $(".modal-title").text("Tambah Kategori");
    $(".submit_btn").text("Add");
    $("#id").val("0");
    $("form").attr("action", "/kategori_produk/addKategori");
    if (infoFlash != "error_add") {
      cleanForm();
    }
  });

  $("#dataTable").DataTable({
    dom: "Bfrtip",
    buttons: ["copy", "csv", "excel", "pdf", "print"],
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
      url: "/kategori_produk/listdata",
      type: "post",
      error: function (e) {
        console.log("data tidak ditemukan di server");
      },
    },
  });
});

var editClick = false;

function cleanForm() {
  $("#kategori").val("");
  $("#id").val("0");
  $("#deskripsi").val("");
}

function edit(idEdit) {
  editClick = true;
  $(".modal-title").text("Edit Kategori");
  $(".submit_btn").text("Edit");
  $("form").attr("action", "/kategori_produk/editKategori");
  $("#id").val(idEdit);
  $.ajax({
    url: "/kategori_produk/getRowKategori",
    data: {
      id: idEdit,
    },
    method: "post",
    dataType: "json",
    success: function (data) {
      $("#kategori").val(data.nama_category);
      $("#deskripsi").val(data.deskripsi);
    },
  });
}
