//config icon sidebar title
$(document).ready(function () {
  if ($("#accordionSidebar").width() > 223) {
    $(".sidebar-brand-icon").css("display", "none");
  }

  $("#sidebarToggle").click(function () {
    if ($("#accordionSidebar").width() == 104) {
      $(".sidebar-brand-icon").css("display", "block");
    } else {
      $(".sidebar-brand-icon").css("display", "none");
    }
  });
});

function deleteData(page, idDelete) {
  var link = "";
  if (page == "_product") {
    link = "/product/deleteProduct/" + idDelete;
  } else if (page == "_cat_product") {
    link = "/kategori_produk/deleteKategori/" + idDelete;
  } else if (page == "_satpro") {
    link = "/satuan/deleteSatuan/" + idDelete;
  } else if (page == "_datpen") {
    link = "/penjualan/deletePenjualan/" + idDelete;
  } else if (page == "_datpem") {
    link = "/pembelian/deletePembelian/" + idDelete;
  } else if (page == "_datusers") {
    link = "/home/deleteUserAccount/" + idDelete;
  }

  Swal.fire({
    title: "Yakin hapus data ini?",
    text: "Kamu tidak akan melihatnya lagi!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes",
  }).then((result) => {
    if (result.isConfirmed) {
      window.location = link;
    }
  });
}
