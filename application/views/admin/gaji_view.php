<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=5, viewport-fit=cover" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="theme-color" content="#000000">
    <title>Mobilekit Mobile UI Kit</title>
    <meta name="description" content="Mobilekit HTML Mobile UI Kit">
    <meta name="keywords" content="bootstrap 4, mobile template, cordova, phonegap, mobile, html, responsive" />
    <link rel="icon" type="image/png" href="/assets/img/favicon.png" sizes="32x32">
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/img/icon/192x192.png">
    <link rel="preload" type="text/css" href="https://fonts.googleapis.com/css?family=Inter:400,500,700&amp;display=swap" async>
    <link rel="stylesheet" href="<?= base_url('/assets/css/style.css') ?>" async>
    <!-- <link rel="stylesheet" href="https://res.cloudinary.com/taqin/raw/upload/v1586263241/assets/css/style_i2j0lr.css"> -->
    <link rel="stylesheet" href="<?= base_url('/assets/css/helper.css') ?>" async>
    <link rel="stylesheet" href="<?= base_url('/assets/css/bootstrap-icons.css') ?>" async>
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/icons-style.css'); ?>">
    <!-- <script type="module" src="https://unpkg.com/ionicons@5.0.0/dist/ionicons/ionicons.esm.js" data-stencil-namespace="ionicons"></script>
    <script nomodule="" src="https://unpkg.com/ionicons@5.0.0/dist/ionicons/ionicons.js" data-stencil-namespace="ionicons"></script> -->
    <!-- <link rel="manifest" href="/__manifest.json"> -->
    <style type="text/css">
        .p-5px{padding:5px}.card .card-body{padding:5px;line-height:1.4em}.bg-white{background:#fff}
        body.dark-mode-active .appHeader.scrolled.bg-primary.is-active {
            background: #16417f !important;
        }
        body.dark-mode-active .bg-primary {
            background: #16417f !important;
            color: #FFF;
        }
        body.dark-mode-active .profileBox {
            background: #16417f !important;
        }
        body.dark-mode-active .dark-mode-image {
            filter:invert(1);mix-blend-mode:screen
        }
        .swiper-container {
            width: 100%;
            height: 100%;
        }
        .profile-head {
            display: flex;
            align-items: center;
        }
        .profile-head .avatar {
            margin-right: 16px;
        }
        .card.product-card .image {
            width: 100%;
            border-radius: 6px;
        }
        .card.product-card .card-body {
            padding: 8px;
        }
        .bg-LULUS {
            background: #34C759 !important;
        }

    </style>
</head>
<body>
    <div id="loader">
        <div class="spinner-border text-primary" role="status"></div>
    </div>
    <!-- App Header -->
    <div class="appHeader bg-primary scrolled is-active text-white">
        <div class="left">
            <a href="#" class="headerButton" hidden="" data-toggle="modal" data-target="#sidebarPanel">
                <ion-icon name="menu-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">
            <!-- Rotib Al Hadad -->
            BA
        </div>
        <div class="right">
            <a href="javascript:;" class="headerButton toggle-searchbox" hidden="">
                <ion-icon name="search-outline"></ion-icon>
            </a>
        </div>
    </div>
    <!-- * App Header -->

    <!-- Search Component -->
    <div id="search" class="appHeader">
        <form class="search-form" hidden="">
            <div class="form-group searchbox">
                <input type="text" class="form-control" placeholder="Search...">
                <i class="input-icon">
                    <ion-icon name="search-outline"></ion-icon>
                </i>
                <a href="javascript:;" class="ml-1 close toggle-searchbox">
                    <ion-icon name="close-circle"></ion-icon>
                </a>
            </div>
        </form>
    </div>
    <!-- * Search Component -->

    <!-- App Capsule --> <!-- Content -->
    <div id="appCapsule">
        <div class="section full m-2">
            <?php if ($this->session->flashdata('success') !== NULL) {
                    ?>
                    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                        <?php echo $this->session->flashdata('success'); ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <?php
                } else {
                    echo "";
                }
                ?>
        </div>
        <div class="section full mt-2">
            <div class="section-title" style="display: inline-flex;">Data Penggajian Karyawan
                <button type="button" id="clickModal" class="btn btn-success btn-sm ml-2" data-toggle="modal" data-target="#DialogForm">Tambah Data</button>
            </div>
            <div class="modal fade dialogbox" id="DialogForm" data-bs-backdrop="static" tabindex="-1" style="display: none;" aria-hidden="true">
            	<div class="modal-dialog" role="document">
            		<div class="modal-content" style="max-width: 500px;">
            			<div class="modal-header">
            				<h5 class="modal-title">Form Penggajian</h5>
            			</div>
            			<form method="POST"action="<?= base_url('gaji/create') ?>">
            				<div class="modal-body text-start mb-2">
            					<div class="form-group basic pt-0 pb-0">
            						<div class="input-wrapper">
            							<label class="form-label float-left mb-0" for="email1">Kode Karyawan</label>
            							<select name="kode_kar" class="form-control js-kar">
                							<option>-- Pilih Karyawan --</option>
                							<?php
                							foreach ($karyawan as $key): ?>
                								<option value="<?= $key->kode_karyawan; ?>"><?= $key->kode_karyawan; ?> - <?= $key->nama_karyawan; ?></option>
                							<?php endforeach; ?>
                						</select>
            						</div>
            					</div>

            					<div class="row">
            						<div class="form-group basic col pt-0 pb-0">
            							<div class="input-wrapper">
            								<label class="form-label float-left mb-0" for="tgl">Date Start</label>
            								<input type="date" name="tgl_awal" class="form-control">
            							</div>
            						</div>
            						<div class="form-group basic col pt-0 pb-0">
            							<div class="input-wrapper">
            								<label class="form-label float-left mb-0" for="tgl">Date End</label>
            								<input type="date" name="tgl_akhir" class="form-control">
            							</div>
            						</div>
            					</div>
            					<div class="row">
            						<div class="form-group basic col pt-0 pb-0">
            							<div class="input-wrapper">
            								<label class="form-label float-left mb-0" for="tgl">Pot. Bon</label>
            								<input type="number" name="pot_bon" class="form-control">
            							</div>
            						</div>
            						<div class="form-group basic col pt-0 pb-0">
            							<div class="input-wrapper">
            								<label class="form-label float-left mb-0" for="tgl">Keterangan</label>
            								<input type="text" name="ket_bon" class="form-control">
            							</div>
            						</div>
            					</div>
            					<div class="row">
            						<div class="form-group basic col pt-0 pb-0">
            							<div class="input-wrapper">
            								<label class="form-label float-left mb-0" for="tgl">Potongan 1</label>
            								<input type="number" name="pot_satu" class="form-control">
            							</div>
            						</div>
            						<div class="form-group basic col pt-0 pb-0">
            							<div class="input-wrapper">
            								<label class="form-label float-left mb-0" for="tgl">Keterangan</label>
            								<input type="text" name="ket_satu" class="form-control">
            							</div>
            						</div>
            					</div>
            					<div class="row">
            						<div class="form-group basic col pt-0 pb-0">
            							<div class="input-wrapper">
            								<label class="form-label float-left mb-0" for="tgl">Potongan 2</label>
            								<input type="number" name="pot_dua" class="form-control">
            							</div>
            						</div>
            						<div class="form-group basic col pt-0 pb-0">
            							<div class="input-wrapper">
            								<label class="form-label float-left mb-0" for="tgl">Keterangan</label>
            								<input type="text" name="ket_dua" class="form-control">
            							</div>
            						</div>
            					</div>
            				</div>
            				<div class="modal-footer">
            					<div class="btn-inline">
            						<button type="button" class="btn btn-text-secondary" data-dismiss="modal">CLOSE</button>
            						<input type="submit" class="btn btn-text-primary" value="Create">
            					</div>
            				</div>
            			</form>
            		</div>
            	</div>
            </div>
            <div class="wide-block ml-2 mr-2 p-0">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Kode Karyawan</th>
                                <th scope="col">Periode</th>
                                <th scope="col text-center">Jumlah Produk</th>
                                <th scope="col">Gaji</th>
                                <th scope="col text-center">KET1</th>
                                <th scope="col text-center">KET2</th>
                                <th scope="col text-center">KET3</th>
                                <th scope="col text-center">Gaji Terima</th>
                                <th scope="col text-center" colspan="2">AKsi</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            $nomor = 0;
                            foreach ($data as $key): ?>
                            <tr>
                                <td scope="row"><?php $nomor++; echo $nomor; ?></td>
                                <?php $gaji_bersih = $key->sub_total - ($key->pot_bon+$key->pot_satu+$key->pot_dua); ?>
                                <td scope="row"><?= $key->kd; ?></td>
                                <td scope="row"><?= $key->tgl_start .' - '. $key->tgl_end; ?></td>
                                <td scope="row"><?= $key->jml; ?></td>
                                <td scope="row">Rp. <?= number_format($key->sub_total); ?></td>
                                <td scope="row"><?= $key->pot_bon; ?></td>
                                <td scope="row"><?= $key->pot_satu; ?></td>
                                <td scope="row"><?= $key->pot_dua; ?></td>
                                <td scope="row">Rp <?= number_format($gaji_bersih); ?></td>
                                <td scope="row"><a href="<?= base_url('gaji/detail/') . $key->kd . '/' . $key->tgl_start ?>" class="btn btn-warning btn-sm">
                                Detail</a></td>
                                <td scope="row"><a href="<?= base_url('gaji/print/') . $key->kd . '/' . $key->tgl_start ?>" class="btn btn-success btn-sm">
                                Print</a></td>
                                <td scope="row"><a href="<?= base_url('gaji/delete/') . $key->kd . '/' . $key->tgl_start ?>" class="btn btn-danger btn-sm">
                                    <img src="<?= base_url('assets/icons/trash.svg') ?>" alt="Bootstrap" width="20" height="20" class="m-1">Delete</a></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>


        <!-- app footer -->

        <!-- * app footer -->

    </div>
    <!-- * App Capsule -->


    <!-- App Bottom Menu -->
    <?php include 'menu_view.php'; ?>
    <!-- * App Bottom Menu -->

    <!-- App Sidebar -->
    <!-- * App Sidebar -->

    <!-- welcome notification  -->
    <!-- * welcome notification -->
    <!-- ///////////// Js Files ////////////////////  -->
    <!-- Jquery -->
    <script type="text/javascript" src="<?php echo base_url('assets/js/main.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/jquery-3.5.1.min.js'); ?>"></script>
    <!-- Bootstrap-->
    <script type="text/javascript" src="<?php echo base_url('assets/js/popper.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
    <!-- Ionicons -->
    <script type="module" src="https://cdn.jsdelivr.net/npm/ionicons@5.0.0/dist/ionicons/ionicons.esm.js" async></script>
    <script nomodule src="https://cdn.jsdelivr.net/npm/ionicons@5.0.0/dist/ionicons/ionicons.js" async></script>
    <script type="text/javascript">
    	$("#clickModal").button("toggle");
    </script>
</body>
</html>