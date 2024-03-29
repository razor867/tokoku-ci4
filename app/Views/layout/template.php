<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Tokoku - <?= $title ?></title>

    <!-- Custom fonts for this template-->
    <link href="/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="/css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom css -->
    <?= $this->renderSection('css_custom') ?>
    <style>
        .bg-gradient-primary {
            background-color: #5a5c69;
            background-image: linear-gradient(180deg, #5a5c69 10%, #5a5c69 100%);
            background-size: cover;
        }

        .close {
            color: #fff;
            opacity: 1;
        }

        th,td {
            font-size: 14px;
        }

        .dt-buttons {
            margin-bottom: 1rem!important;
        }

        .dataTables_length {
            margin-right: 20px;
            display: inline;
        }
        
        .dataTables_info {
            display: inline;
        }
    </style>

    <link rel="icon" type="image/png" href="/img/tokoku.png" />

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-store"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Tokoku - Admin</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <?php if (in_groups('Super Admin') || in_groups('Admin')) : ?>
                <li class="nav-item <?= (current_url() == 'http://localhost:8080/' || current_url() == base_url('home') ? 'active' : '') ?>">
                    <a class="nav-link" href="/">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
            <?php endif ?>

            <!-- Divider -->
            <!-- <hr class="sidebar-divider"> -->

            <!-- Heading -->
            <!-- <div class="sidebar-heading">
                Interface
            </div> -->

            <!-- Nav Item - Pages Collapse Menu -->
            <?php if (in_groups('Super Admin') || in_groups('Admin') || in_groups('Admin Produk') || in_groups('Admin Kasir') || in_groups('Admin Gudang')) : ?>
                <li class="nav-item <?= (current_url() == base_url('product') ? 'active' : '') ?>">
                    <a class="nav-link collapsed" href="/product">
                        <i class="fas fa-box"></i>
                        <span>Data Produk</span>
                    </a>
                </li>
            <?php endif ?>

            <?php if (in_groups('Super Admin') || in_groups('Admin') || in_groups('Admin Produk') || in_groups('Admin Kasir') || in_groups('Admin Gudang')) : ?>
                <li class="nav-item <?= (current_url() == base_url('kategori_produk') ? 'active' : '') ?>">
                    <a class="nav-link collapsed" href="/kategori_produk">
                        <i class="fas fa-tag"></i>
                        <span>Kategori Produk</span>
                    </a>
                </li>
            <?php endif ?>

            <?php if (in_groups('Super Admin') || in_groups('Admin') || in_groups('Admin Produk') || in_groups('Admin Kasir') || in_groups('Admin Gudang')) : ?>
                <li class="nav-item <?= (current_url() == base_url('satuan') ? 'active' : '') ?>">
                    <a class="nav-link collapsed" href="/satuan">
                        <i class="fas fa-balance-scale"></i>
                        <span>Satuan</span>
                    </a>
                </li>
            <?php endif ?>

            <!-- Nav Item - Utilities Collapse Menu -->
            <?php if (in_groups('Super Admin') || in_groups('Admin') || in_groups('Admin Gudang') || in_groups('Admin Kasir')) : ?>
                <li class="nav-item <?= (current_url() == base_url('penjualan') || current_url() == base_url('pembelian') ? 'active' : '') ?>">
                    <a class="nav-link collapsed transaksi" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
                        <i class="fas fa-shopping-cart"></i>
                        <span>Transaksi</span>
                    </a>
                    <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">List data:</h6>
                            <?php if (in_groups('Super Admin') || in_groups('Admin') || in_groups('Admin Kasir')) : ?>
                                <a class="collapse-item <?= (current_url() == base_url('penjualan') ? 'active' : '') ?>" href="/penjualan">Penjualan</a>
                            <?php endif ?>
                            <?php if (in_groups('Super Admin') || in_groups('Admin') || in_groups('Admin Gudang')) : ?>
                                <a class="collapse-item <?= (current_url() == base_url('pembelian') ? 'active' : '') ?>" href="/pembelian">Pembelian</a>
                            <?php endif ?>
                        </div>
                    </div>
                </li>
            <?php endif ?>

            <!-- Divider -->
            <!-- <hr class="sidebar-divider"> -->

            <!-- Heading -->
            <!-- <div class="sidebar-heading">
                Action
            </div> -->

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item <?= (current_url() == base_url('home/profile')) ? 'active' : '' ?>">
                <a class="nav-link collapsed" href="/home/profile">
                    <i class="fas fa-id-badge"></i>
                    <span>Profile</span>
                </a>
            </li>

            <?php if (in_groups('Super Admin') || in_groups('Admin')) : ?>
                <li class="nav-item <?= (current_url() ==  base_url('home/users')) ? 'active' : '' ?>">
                    <a class="nav-link collapsed" href="/home/users">
                        <i class="fas fa-user"></i>
                        <span>Users</span>
                    </a>
                </li>
            <?php endif ?>

            <?php if (in_groups('Super Admin')) : ?>
                <li class="nav-item <?= (current_url() ==  base_url('permissions')) ? 'active' : '' ?>">
                    <a class="nav-link collapsed" href="/permissions">
                        <i class="fas fa-user-slash"></i>
                        <span>Permissions</span>
                    </a>
                </li>
            <?php endif ?>

            <?php if (in_groups('Super Admin')) : ?>
                <li class="nav-item <?= (current_url() == base_url('groups') || current_url() == base_url('groups_permissions') ? 'active' : '') ?>">
                    <a class="nav-link collapsed groups" href="#" data-toggle="collapse" data-target="#groups_dropdown" aria-expanded="true" aria-controls="collapseUtilities">
                        <i class="fas fa-users"></i>
                        <span>Groups</span>
                    </a>
                    <div id="groups_dropdown" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <h6 class="collapse-header">List data:</h6>
                            <a class="collapse-item <?= (current_url() == base_url('groups') ? 'active' : '') ?>" href="/groups">Groups</a>
                            <a class="collapse-item <?= (current_url() == base_url('groups_perm') ? 'active' : '') ?>" href="/groups_perm">Groups Permissions</a>
                        </div>
                    </div>
                </li>
            <?php endif ?>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <!-- <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div> -->

            <!-- Sidebar Message -->
            <!-- <div class="sidebar-card">
                <img class="sidebar-card-illustration mb-2" src="img/undraw_rocket.svg" alt="">
                <p class="text-center mb-2"><strong>SB Admin Pro</strong> is packed with premium features, components, and more!</p>
                <a class="btn btn-success btn-sm" href="https://startbootstrap.com/theme/sb-admin-pro">Upgrade to Pro!</a>
            </div> -->

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->
                    <!-- <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form> -->


                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <!-- <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a> -->
                            <!-- Dropdown - Messages -->
                            <!-- <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div> -->
                        </li>

                        <!-- Nav Item - Alerts
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                Counter - Alerts
                                <span class="badge badge-danger badge-counter">3+</span>
                            </a>
                            Dropdown - Alerts
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                    Alerts Center
                                </h6>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-primary">
                                            <i class="fas fa-file-alt text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 12, 2019</div>
                                        <span class="font-weight-bold">A new monthly report is ready to download!</span>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-success">
                                            <i class="fas fa-donate text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 7, 2019</div>
                                        $290.29 has been deposited into your account!
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-warning">
                                            <i class="fas fa-exclamation-triangle text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 2, 2019</div>
                                        Spending Alert: We've noticed unusually high spending for your account.
                                    </div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
                            </div>
                        </li> -->

                        <!-- Nav Item - Messages
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-envelope fa-fw"></i>
                                Counter - Messages
                                <span class="badge badge-danger badge-counter">7</span>
                            </a>
                            Dropdown - Messages
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="messagesDropdown">
                                <h6 class="dropdown-header">
                                    Message Center
                                </h6>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="/img/undraw_profile_1.svg" alt="">
                                        <div class="status-indicator bg-success"></div>
                                    </div>
                                    <div class="font-weight-bold">
                                        <div class="text-truncate">Hi there! I am wondering if you can help me with a
                                            problem I've been having.</div>
                                        <div class="small text-gray-500">Emily Fowler · 58m</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="/img/undraw_profile_2.svg" alt="">
                                        <div class="status-indicator"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">I have the photos that you ordered last month, how
                                            would you like them sent to you?</div>
                                        <div class="small text-gray-500">Jae Chun · 1d</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="/img/undraw_profile_3.svg" alt="">
                                        <div class="status-indicator bg-warning"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">Last month's report looks great, I am very happy with
                                            the progress so far, keep up the good work!</div>
                                        <div class="small text-gray-500">Morgan Alvarez · 2d</div>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="dropdown-list-image mr-3">
                                        <img class="rounded-circle" src="https://source.unsplash.com/Mv9hjnEUHR4/60x60" alt="">
                                        <div class="status-indicator bg-success"></div>
                                    </div>
                                    <div>
                                        <div class="text-truncate">Am I a good boy? The reason I ask is because someone
                                            told me that people say this to all dogs, even if they aren't good...</div>
                                        <div class="small text-gray-500">Chicken the Dog · 2w</div>
                                    </div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
                            </div>
                        </li> -->

                        <!-- <div class="topbar-divider d-none d-sm-block"></div> -->

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-3 d-none d-lg-inline text-gray-600 small">
                                    <?= (logged_in()) ? user()->username : '' ?>
                                </span>
                                <img class="img-profile rounded-circle" src="/img/<?= (logged_in()) ? user()->profile_picture : '' ?>">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="/home/profile">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <!-- <a class="dropdown-item" href="#">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Settings
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Activity Log
                                </a> -->
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <?= $this->renderSection('content') ?>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Tokoku 2020</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #5a5c69;">
                    <h5 class="modal-title text-white" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="<?= base_url('logout') ?>">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal custom-->
    <?= $this->renderSection('modal_cutom') ?>

    <!-- Bootstrap core JavaScript-->
    <script src="/vendor/jquery/jquery.min.js"></script>
    <script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <?= $this->renderSection('js_plugins') ?>

    <!-- Page level custom scripts -->
    <?= $this->renderSection('js_custom') ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="/js/app.js"></script>
    <?php if (session()->getFlashdata('info') != '') : ?>
        <script>
            const infoFlash = '<?= session()->getFlashdata('info') ?>';
            if (infoFlash == 'error' || infoFlash == 'error_add' || infoFlash == 'error_edit' || infoFlash == 'error_delete') {
                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi kesalahan...',
                    text: 'Aksi tidak dapat dilakukan',
                    showConfirmButton: false,
                    timer: 2500
                })
            } else if (infoFlash == 'error_stok') {
                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi kesalahan...',
                    text: 'Stok produk tidak mencukupi',
                    showConfirmButton: false,
                    timer: 2500
                })
            } else {
                Swal.fire({
                    icon: 'success',
                    title: infoFlash,
                    showConfirmButton: false,
                    timer: 1500
                })
            }
        </script>
    <?php endif ?>


</body>

</html>