$(document).ready(function () {
  let filter = {};
  const configTable = {
    // fixedHeader: {
    //     header: true,
    //     headerOffset: $('.topbar').outerHeight()
    // },
    scrollX: true,
    stateSave: true,
    processing: true,
    serverSide: true,
    ajax: {
      url: $("#dataTable").attr("data-url"),
      type: "post",
      headers: { "X-Requested-With": "XMLHttpRequest" },
      data: function (d) {
        $(
          ".filter td"
        ).each(function () {
          filter[$(this).attr("name")] = $(this).val();
        });
        d.filter = filter;
        return d;
      },
    },
    autoWidth: false,
    columnDefs: [
      // {
      //   searchable: false,
      //   orderable: false,
      //   width: "7%",
      //   targets: 0,
      // },
      // // {
      // //   orderable: false,
      // //   targets: "no-sort",
      // // },
      // {
      //   orderable: false,
      //   targets: [3, 5],
      // },
      // {
      //   className: "text-center",
      //   targets: "text-center",
      // },
      // {
      //   className: "text-right",
      //   targets: "text-right",
      // },
      // {
      //   className: "no-padding",
      //   targets: "no-padding",
      // },
      // {
      //   className: "td-no-padding",
      //   targets: "td-no-padding",
      // },
      // {
      //   className: "th-no-padding",
      //   targets: "th-no-padding",
      // },
      {
        render: function (data, type, full, meta) {
          return (
            '<div class="text-wrap w-250">' + (data ? data : "") + "</div>"
          );
        },
        targets: "text-wrap",
      },
    ],
    // order: [[5, "desc"]],
    order: [
      [$("th.default-sort").index(), $("th.default-sort").attr("data-sort")],
    ],
    orderCellsTop: true,
    dom: '<"datatable-scroll-wrap"tr>B<"datatable-footer"ipl>',
    language: {
      processing: "Loading...",
      infoFiltered: "",
    },
    pagingType: "listbox",
  };
  ("use strict");

  const $tableDetail = $("#table-detail");
  let confTableDetail = configTable;
  let columns = [];
  $(".column th").each(function () {
    columns.push({
      data: $(this).attr("data-data"),
    });
  });
  confTableDetail.columns = columns;
  confTableDetail.ajax.url = $tableDetail.data("url");
  const tableDetail = $tableDetail.DataTable(confTableDetail);
  const $buttonColvis = $("#seats .buttons-colvis");
  $buttonColvis.removeClass("dropdown-toggle");
  $buttonColvis.detach().appendTo("#seats .btn-colvis");
  $("#seats .dt-buttons").addClass("d-none");
  $("#seats .dataTables_length")
    .find("select")
    .removeClass("custom-select custom-select-sm");

  const $body = $("body");
  $body.on("click", "#seats .filter button", function (e) {
    e.preventDefault;
    tableDetail.ajax.reload();
  });
  $body.on("keyup", "#seats .filter input", function (e) {
    if (e.keyCode === 13) {
      tableDetail.ajax.reload();
    }
  });
  tableDetail
    .on("order.dt search.dt", function () {
      tableDetail
        .column(0, { search: "applied", order: "applied" })
        .nodes()
        .each(function (cell, i) {
          cell.innerHTML = i + 1;
        });
    })
    .draw();
  $body.on("click", ".delete", function (e) {
    const url = $(this).attr("href");
    e.preventDefault();
    swal({
      title: "Are you sure want to delete?",
      type: "warning",
      showCancelButton: true,
      confirmButtonClass: "btn btn-success",
      cancelButtonClass: "btn btn-light mr-2",
      confirmButtonText: "Yes, delete it!",
      cancelButtonText: "No, cancel!",
    }).then(function (deleteIt) {
      if (deleteIt) {
        $.ajax({
          url: url,
          success: function (res) {
            res = JSON.parse(res);
            if (res.status === "success") {
              if (res.redirect) {
                window.location = res.redirect;
              } else {
                tableDetail.ajax.reload();
                successMessage(res.message);
              }
            } else {
              errorMessage(res.message);
            }
          },
        });
      }
    });
  });
});

// function openDetailForm(id = 0) {
//   startLoading();
//   const $modal = $("#modal");
//   $modal
//     .find(".modal-content")
//     .load(siteUrl + "accessories/detail-form/" + accessoryID + "/" + id);
//   $modal.modal("show");
//   stopLoading();
// }
// var idRowSeats = "";
// function checkin(id, sendGet) {
//   dataCheckin = id.split("|");
//   id = dataCheckin[0];
//   idRowSeats = dataCheckin[1];
//   const url = siteUrl + "checkin/" + id + "?" + sendGet;
//   actionLaunchModal(url);
// }

// function editseats(id) {
//   startLoading();
//   const $modal = $("#modal-sm");
//   $modal.find(".modal-content").load(siteUrl + "edit-seats/" + id);
//   $modal.modal("show");
//   stopLoading();
// }

// function checkout(id) {
//   startLoading();
//   const $modal = $("#modal");
//   $modal.find(".modal-content").load(siteUrl + "checkout/" + id);
//   $modal.modal("show");
//   stopLoading();
// }

// function checkin(id) {
//   startLoading();
//   const $modal = $("#modal");
//   $modal.find(".modal-content").load(siteUrl + "checkin/" + id);
//   $modal.modal("show");
//   stopLoading();
// }
