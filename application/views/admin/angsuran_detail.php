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
        .icons-white {
            filter: invert(1) hue-rotate(189deg);
        }

    </style>
</head>
<body>
    <!-- App Header -->
    <div class="appHeader bg-primary scrolled is-active text-white">
        <div class="left">
            <a href="#" class="headerButton" hidden="" data-toggle="modal" data-target="#sidebarPanel">
                <ion-icon name="menu-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">
            <?php include 'title_view.php'; ?>
        </div>
        <div class="right">
            <a href="javascript:;" class="headerButton toggle-searchbox" hidden="">
                <ion-icon name="search-outline"></ion-icon>
            </a>
        </div>
    </div>
    <!-- * App Header -->

	<div id="appCapsule">
		<div class="section full mt-2">
			<div class="section-title" style="display: inline-flex;">
				<a class="btn btn-success btn-sm" href="<?= base_url('penjualan') ?>">
					<img src="<?= base_url('assets/icons/arrow-left.svg') ?>" class="icons icons-white">
					&nbsp; &nbsp;Kembali
				</a>
				&nbsp;
				Data Angsuran: <?= $data[0]->nama ?> (<?= $data[0]->kode_penjualan ?>)
			</div>
			<div class="wide-block ml-2 mr-2 p-0">
				<div class="table-responsive">
					<table border="0" class="table">
						<thead>
							<tr>
								<th rowspan="2">Kode<br>Angsuran</th>
								<th rowspan="2">Kode<br>Penjualan</th>
								<th rowspan="2">Nama<br>Pemesan</th>
								<th rowspan="2">Alamat</th>
								<th rowspan="2">Hp</th>
								<th rowspan="2">Jenis Bayar</th>
								<th rowspan="2">Jml Pcs</th>
								<th rowspan="2">BN</th>
								<th rowspan="2" style='min-width:150px;'>Total Bayar</th>
								<th>A1</th>
								<th>A2</th>
								<th>A3</th>
								<th>A4</th>
								<th>A5</th>
								<th>A6</th>
								<th>A7</th>
								<th rowspan="2">Sisa Pembayaran</th>
								<th rowspan="2">COLLECTOR</th>
								<th rowspan="2">Aksi</th>
							</tr>
							<tr>
								<?php
								$data_bulan = array();
								foreach ($month as $date) {
									$month = (int) date("m",strtotime($date->format("Y-m-d")));
									$year = (int) date("y",strtotime($date->format("Y-m-d")));
									switch ($month) {
										case 1:
										echo "<th style='min-width: 80px;'>JAN ".$year."</th>";
										$data_bulan[1]=1;
										break;
										case 2:
										echo "<th style='min-width: 80px;'>FEB ".$year."</th>";
										$data_bulan[2]=2;
										break;
										case 3:
										echo "<th style='min-width: 80px;'>MAR ".$year."</th>";
										$data_bulan[3]=3;
										break;
										case 4:
										echo "<th style='min-width: 80px;'>APR ".$year."</th>";
										$data_bulan[4]=4;
										break;
										case 5:
										echo "<th style='min-width: 80px;'>MEI ".$year."</th>";
										$data_bulan[5]=5;
										break;
										case 6:
										echo "<th style='min-width: 80px;'>JUN ".$year."</th>";
										$data_bulan[6]=6;
										break;
										case 7:
										echo "<th style='min-width: 80px;'>JUL ".$year."</th>";
										$data_bulan[7]=7;
										break;
										case 8:
										echo "<th style='min-width: 80px;'>AGS ".$year."</th>";
										$data_bulan[8]=8;
										break;
										case 9:
										echo "<th style='min-width: 80px;'>SEP ".$year."</th>";
										$data_bulan[9]=9;
										break;
										case 10:
										echo "<th style='min-width: 80px;'>OKT ".$year."</th>";
										$data_bulan[10]=10;
										break;
										case 11:
										echo "<th style='min-width: 80px;'>NOV ".$year."</th>";
										$data_bulan[11]=11;
										break;
										case 12:
										echo "<th style='min-width: 80px;'>DES ".$year."</th>";
										$data_bulan[12]=12;
										break;
									}
								}
								?>
							</tr>
						</thead>
						<tbody>
							<tr style="font-size: 15px;">
								<td><?= $data[0]->kode_angsuran ?></td>
								<td><?= $data[0]->kode_penjualan ?></td>
								<td><?= $data[0]->nama ?></td>
								<td><?= $data[0]->alamat ?></td>
								<td><?= $data[0]->hp ?></td>
								<?php
									if ($data[0]->jenis_pembayaran == 'K') { // kredit
										echo "<td>Kredit</td>";
										echo "<td>" . $data[0]->jumlah_produk . "</td>";
									} else {
										echo "<td>Cash</td>";
										echo "<td>" . $data[0]->jumlah_produk . "</td>";
									}
									?>
								<td><?= $data[0]->bonus ?></td>
								<?php
								if ($data[0]->jenis_pembayaran == 'C') { // cash
									echo "<td>Rp. " . number_format((float)$data[0]->total_brg) . "</td>";
								} else {
									echo "<td>Rp. " . number_format((float)$data[0]->total_brg) . "</td>";
								}
								foreach ($data_bulan as $bln) {
									switch ($bln) {
										case 1:
										echo "<td>".$val = ($data[0]->januari !== NULL) ? number_format((float)$data[0]->januari) : $data[0]->januari."</td>";
										break;
										case 2:
										echo "<td>".$val = ($data[0]->februari !== NULL) ? number_format((float)$data[0]->februari) : $data[0]->februari."</td>";
										break;
										case 3:
										echo "<td>".$val = ($data[0]->maret !== NULL) ? number_format((float)$data[0]->maret) : $data[0]->maret."</td>";
										break;
										case 4:
										echo "<td>".$val = ($data[0]->april !== NULL) ? number_format((float)$data[0]->april) : $data[0]->april."</td>";
										break;
										case 5:
										echo "<td>".$val = ($data[0]->mei !== NULL) ? number_format((float)$data[0]->mei) : $data[0]->mei."</td>";
										break;
										case 6:
										echo "<td>".$val = ($data[0]->juni !== NULL) ? number_format((float)$data[0]->juni) : $data[0]->juni."</td>";
										break;
										case 7:
										echo "<td>".$val = ($data[0]->juli !== NULL) ? number_format((float)$data[0]->juli) : $data[0]->juli."</td>";
										break;
										case 8:
										echo "<td>".$val = ($data[0]->agustus != NULL) ? number_format((float)$data[0]->agustus) : $data[0]->agustus."</td>";
										break;
										case 9:
										echo "<td>".$val = ($data[0]->september != NULL) ? number_format((float)$data[0]->september) : $data[0]->september."</td>";
										break;
										case 10:
										echo "<td>".$val = ($data[0]->oktober !== NULL) ? number_format((float) $data[0]->oktober) : $data[0]->oktober."</td>";
										break;
										case 11:
										echo "<td>".$val = ($data[0]->november !== NULL) ? number_format((float)$data[0]->november) : $data[0]->november."</td>";
										break;
										case 12:
										echo "<td>".$val = ($data[0]->desember !== NULL) ? number_format((float)$data[0]->desember) : $data[0]->desember."</td>";
										break;
									}
								}

								if ($data[0]->jenis_pembayaran == 'C') { // cash
									echo "<td>" . $data[0]->sisa_pembayaran . "</td>";
								} else {
									$result = $data[0]->total_brg;
									$result -= ((int) $data[0]->januari < 0) ? 0 : (int) $data[0]->januari;
									$result -= ((int) $data[0]->februari < 0) ? 0 : (int) $data[0]->februari;
									$result -= ((int) $data[0]->maret < 0) ? 0 : (int) $data[0]->maret;
									$result -= ((int) $data[0]->april < 0) ? 0 : (int) $data[0]->april;
									$result -= ((int) $data[0]->mei < 0) ? 0 : (int) $data[0]->mei;
									$result -= ((int) $data[0]->juni < 0) ? 0 : (int) $data[0]->juni;
									$result -= ((int) $data[0]->juli < 0) ? 0 : (int) $data[0]->juli;
									$result -= ((int) $data[0]->agustus < 0) ? 0 : (int) $data[0]->agustus;
									$result -= ((int) $data[0]->september < 0) ? 0 : (int) $data[0]->september;
									$result -= ((int) $data[0]->oktober < 0) ? 0 : (int) $data[0]->oktober;
									$result -= ((int) $data[0]->november < 0) ? 0 : (int) $data[0]->november;
									$result -= ((int) $data[0]->desember < 0) ? 0 : (int) $data[0]->desember;
									echo "<td>Rp. " . number_format((float)$result) . "</td>";
								}
								?>
								<td><?= $data[0]->collector ?></td>
								<td>
									<a class="btn btn-sm btn-warning" href="<?= base_url('angsuran/edit/') . $data[0]->kode_angsuran ?>">
										<img src="<?= base_url('assets/icons/pencil-square.svg') ?>" alt="Bootstrap" width="20" height="20" class="m-1">
										Edit
									</a>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
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
</body>
</html>