$(document).ready(function () {
  $(".add").click(function () {
    if (editClick == true) {
      cleanForm();
    }
    tempQty = 0;
    $(".written_nominal").empty();
    $(".modal-title").text("Tambah Penjualan");
    $(".submit_btn").text("Add");
    $("#id").val("0");
    $("form").attr("action", "/penjualan/addPenjualan");
    if (infoFlash != "error_add") {
      cleanForm();
    }
    $(".info_stok").empty();
  });

  $(".transaksi").click();
  $(".sc_select").select2({
    theme: "bootstrap4",
    placeholder: "Pilih",
    allowClear: true,
  });

  $("#qty").change(function () {
    forQty($(this).val());
  });

  $("#qty").keyup(function () {
    forQty($(this).val());
  });

  $("#produk").change(function () {
    var index = data_idProduk.indexOf($(this).val());
    $("#qty").val("1");
    tempQty = $("#qty").val();
    $("#total_jual").val(data_hargaProduk[index]);
    original_price = $("#total_jual").val();
    // $("#id").val($(this).val());
    $(".info_stok").html(
      '<i class="fas fa-info-circle"></i> Stok produk saat ini : ' +
        data_stok[index]
    );
    $(".written_nominal").text(
      "*" + convert($("#total_jual").val()) + " rupiah*"
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
      url: "/penjualan/listdata",
      type: "post",
      error: function (e) {
        console.log("data tidak ditemukan di server");
      },
    },
  });
});

var editClick = false;

function cleanForm() {
  $("#produk").val("").trigger("change");
  $("#satuan").val("").trigger("change");
  $("#qty").val("");
  $("#total_jual").val("");
  $("#id").val("0");
}

function edit(idEdit) {
  editClick = true;
  tempQty = 0;
  $(".modal-title").text("Edit Penjualan");
  $(".submit_btn").text("Edit");
  $("form").attr("action", "/penjualan/editPenjualan");
  $("#id").val(idEdit);
  $.ajax({
    url: "/penjualan/getRowPenjualan",
    data: {
      id: idEdit,
    },
    method: "post",
    dataType: "json",
    success: function (data) {
      $("#produk").val(data.id_produk).trigger("change");
      $("#satuan").val(data.id_satuan).trigger("change");
      $("#qty").val(data.qty);
      $("#total_jual").val(data.total_jual);
      $(".written_nominal").text(
        "*" + convert($("#total_jual").val()) + " rupiah*"
      );
    },
  });
}

var tempQty = $("#qty").val();
$("#total_jual").autoNumeric("init");

function forQty(qty) {
  if (qty < 1) {
    $("#qty").val("1");
    $("#total_jual").val(original_price);
  } else {
    $("#total_jual").val("");
    tempQty = qty;
    total_price = original_price * qty;
  }
  $("#total_jual").val(total_price);
  $(".written_nominal").text(
    "*" + convert($("#total_jual").val()) + " rupiah*"
  );
  $(".written_nominal:contains('satu ratus')").text(
    $(".written_nominal").text().replace("satu ratus", "seratus")
  );
  $(".written_nominal:contains('satu ribu')").text(
    $(".written_nominal").text().replace("satu ribu", "seribu")
  );
}
