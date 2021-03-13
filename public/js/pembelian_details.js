$(document).ready(function () {
  $(".add").click(function () {
    if (editClick == true) {
      cleanForm();
    }
    $(".modal-title").text("Tambah Pembelian");
    $(".submit_btn").text("Add");
    $("#id").val("0");
    $("form").attr("action", "/pembelian/addPembelian");
    if (infoFlash != "error_add") {
      cleanForm();
    }
  });

  $(".transaksi").click();
  $(".sc_select").select2({
    theme: "bootstrap4",
    placeholder: "Pilih",
    allowClear: true,
  });

  $("#total_beli").keyup(function () {
    $(".written_nominal").text("*" + convert($(this).val()) + " rupiah*");
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
    dom: "Bfrtip",
    buttons: [
      {
        extend: "copy",
        className: "btn btn-secondary btn-sm",
      },
      {
        extend: "csv",
        className: "btn btn-secondary btn-sm",
      },
      {
        extend: "excel",
        className: "btn btn-secondary btn-sm",
      },
      {
        extend: "pdf",
        className: "btn btn-secondary btn-sm",
      },
      {
        extend: "print",
        className: "btn btn-secondary btn-sm",
      },
    ],
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
      url: "/pembelian/listdata",
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
  $("#total_beli").val("");
  $("#id").val("0");
  $(".written_nominal").empty();
}

function edit(idEdit) {
  editClick = true;
  $(".modal-title").text("Edit Pembelian");
  $(".submit_btn").text("Edit");
  $("form").attr("action", "/pembelian/editPembelian");
  $("#id").val(idEdit);
  $.ajax({
    url: "/pembelian/getRowPembelian",
    data: {
      id: idEdit,
    },
    method: "post",
    dataType: "json",
    success: function (data) {
      $("#produk").val(data.id_produk).trigger("change");
      $("#satuan").val(data.id_satuan).trigger("change");
      $("#qty").val(data.qty);
      $("#total_beli").val(data.total_beli);
      $(".written_nominal").text("*" + convert(data.total_beli) + " rupiah*");
    },
  });
}
