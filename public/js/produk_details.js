$(document).ready(function () {
  $(".add").click(function () {
    if (editClick == true) {
      cleanForm();
    }
    $(".modal-title").text("Tambah Produk");
    $(".submit_btn").text("Add");
    $("#id").val("0");
    $("form").attr("action", "/product/addProduct");
    if (infoFlash != "error_add") {
      cleanForm();
    }
  });

  $(".sc_select").select2({
    theme: "bootstrap4",
    placeholder: "Pilih",
    allowClear: true,
  });

  $("#harga").keyup(function () {
    $(".written_nominal").text("*" + convert($("#harga").val()) + " rupiah*");
    $(".written_nominal:contains('satu ratus')").text(
      $(".written_nominal").text().replace("satu ratus", "seratus")
    );
    $(".written_nominal:contains('satu ribu')").text(
      $(".written_nominal").text().replace("satu ribu", "seribu")
    );
  });

  $(".written_nominal:contains('satu ratus')").text(
    $(".written_nominal").text().replace("satu ratus", "seratus")
  );
  $(".written_nominal:contains('satu ribu')").text(
    $(".written_nominal").text().replace("satu ribu", "seribu")
  );

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
        targets: [5],
      },
      {
        className: "text-wrap w-25",
        targets: [0],
      },
    ],
    ordering: true,
    info: true,
    serverSide: true,
    stateSave: true,
    scrollX: true,
    ajax: {
      url: "/product/listdata",
      type: "post",
      error: function (e) {
        console.log("data tidak ditemukan di server");
      },
    },
  });
});

var editClick = false;

function cleanForm() {
  $("#id").val("0");
  $("#nama_produk").val("");
  $("#category").val("").trigger("change");
  $("#satuan").val("").trigger("change");
  $("#stok").val("");
  $("#harga").val("");
  $(".written_nominal").html("");
}

function edit(idEdit) {
  editClick = true;
  $(".modal-title").text("Edit Produk");
  $(".submit_btn").text("Edit");
  $("form").attr("action", "/product/editProduct");
  $("#id").val(idEdit);
  $.ajax({
    url: "/product/getRowProduct",
    data: {
      id: idEdit,
    },
    method: "post",
    dataType: "json",
    success: function (data) {
      $("#nama_produk").val(data.nama_produk);
      $("#category").val(data.id_cat_produk).trigger("change");
      $("#satuan").val(data.id_satuan).trigger("change");
      $("#stok").val(data.stok);
      $("#harga").val(data.harga);
      $(".written_nominal").text("*" + convert($("#harga").val()) + " rupiah*");
    },
  });
}
