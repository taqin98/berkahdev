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
            <div class="section-title" style="display: inline-flex;">Detail Gaji Karyawan
                <a href="<?= base_url('gaji') ?>" class="btn btn-success btn-sm ml-3">
                    <img src="<?= base_url('assets/icons/arrow-left-circle-fill.svg') ?>" class="icons m-1">
                    Kembali
                </a>
            </div>
            <div class="wide-block ml-2 mr-2 p-0">
                <div class="table-responsive">
                	<table class="table mb-3" style="max-width: 500px;">
                		<tr>
                			<td align="left">Kode Karyawan</td>
                			<td align="left">:</td>
                			<td><?= $karyawan->kode_karyawan ?></td>

                            <td align="right">Periode</td>
                            <td align="left">:</td>
                            <td><?= $cetak_bulan ?></td>
                		</tr>
                		<tr>
                			<td align="left">Nama Karyawan</td>
                			<td align="left">:</td>
                			<td><?= $karyawan->nama_karyawan ?></td>
                            <td colspan="3"></td>
                		</tr>

                	</table>
                    <table class="table" border="0">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Nama Pelanggan</th>
                                <th scope="col">Kode Penjualan</th>
                                <th scope="col">Jenis</th>
                                <th scope="col text-center">Jml Produk</th>
                                <th scope="col text-center">Bonus</th>
                                <th scope="col" colspan="2">Sub Total</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            $nomor = 0;
                            $total=0;
                            $total_jml=0;
                            $total_bn=0;
                            $pot_1 = '';
                            $pot_2 = '';
                            $pot_3 = '';
                            foreach ($data as $key): $total += $key->sub_total; $total_jml += $key->jml; $total_bn += $key->bn; ?>
                            <tr>
                                <td scope="row"><?php $nomor++; echo $nomor; ?></td>
                                <td scope="row"><?= $key->nama; ?></td>
                                <td scope="row"><?= $key->pj; ?></td>
                                <td scope="row"><?= $key->jns; ?></td>
                                <td scope="row"><?= $key->jml; ?> x <small>Rp. <?= $key->komisi; ?></small></td>
                                <td width="100px"><?= $key->bn; ?></td>
                                <?php
                                $pot_1 = $key->ket_bon;
                                $pot_2 = $key->ket_satu;
                                $pot_3 = $key->ket_dua;
                                ?>
                                <td align="left">Rp. <?= number_format($key->sub_total); ?></td>
                            </tr>
                        <?php endforeach; ?>
	                        <tr>
	                			<td colspan="4">Total</td>
	                			<td align="left"><?= $total_jml ?></td>
                                <td align="left"><?= $total_bn ?></td>
	                			<td width="120px" align="left">Rp. <?= number_format($total); ?></td>
	                		</tr>
	                        <tr>
	                        	<td colspan="5"></td>
	                        	<td align="right"><?= $val = ($pot_1 == '') ? $val = 'Potongan 1' : $val = $pot_1; ?></td>
	                        	<td><?= number_format($data[0]->pot_bon); ?></td>
	                        </tr>
	                        <tr>
	                        	<td colspan="5"></td>
	                        	<td align="right"><?= ($pot_2 == '') ? $val = 'Potongan 2' : $val = $pot_2; ?></td>
	                        	<td><?= number_format($data[0]->pot_satu); ?></td>
	                        </tr>
	                        <tr>
	                        	<td colspan="5"></td>
	                        	<td align="right"><?= ($pot_3 == '') ? $val = 'Potongan 3' : $val = $pot_3; ?>
	                        	<td><?= number_format($data[0]->pot_dua); ?></td>
	                        </tr>
	                        <?php $gaji_bersih = $total - ($data[0]->pot_bon+$data[0]->pot_satu+$data[0]->pot_dua); ?>
	                        <tr>
	                        	<td colspan="5"></td>
	                        	<td align="right">Total Terima</td>
	                        	<td>Rp. <?= number_format($gaji_bersih); ?></td>
	                        </tr>
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
</body>
</html>