<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=5, viewport-fit=cover" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="theme-color" content="#000000">
    <title><?= (ENVIRONMENT !== 'production' || ENVIRONMENT !== 'staging') ? 'development' : ENVIRONMENT ?></title>
    <meta name="description" content="Mobilekit HTML Mobile UI Kit">
    <meta name="keywords" content="bootstrap 4, mobile template, cordova, phonegap, mobile, html, responsive" />
    <link rel="icon" type="image/png" href="/assets/img/favicon.png" sizes="32x32">
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/img/icon/192x192.png">
    <link rel="preload" type="text/css" href="https://fonts.googleapis.com/css?family=Inter:400,500,700&amp;display=swap" async>
    <link rel="stylesheet" href="<?= base_url('/assets/css/style.css') ?>">
    <!-- <link rel="stylesheet" href="https://res.cloudinary.com/taqin/raw/upload/v1586263241/assets/css/style_i2j0lr.css"> -->
    <link rel="stylesheet" href="<?= base_url('/assets/css/helper.css') ?>" async>
    <link rel="stylesheet" href="<?= base_url('/assets/css/select2.min.css') ?>" async>
    <link rel="stylesheet" href="<?= base_url('/assets/css/dataTables.bootstrap4.min.css') ?>" async>
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/icons-style.css'); ?>">
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
        .select2-container--default .select2-selection--single {
        	height: 42px;
        	padding: 5px 40px 0 16px;
        }
        .form-group.boxed .form-control.disabled {
        	background: #f6f7f7;
        }
        .dataTables_paginate {
        	padding: 0px;
        	text-align: center;
        	margin: auto;
        	display: flex;
        	align-items: baseline;
        	justify-content: flex-end;
        }
        .paginate_button {
        	padding: .5rem!important;
        	background: rgb(30, 116, 253);
        	border: 0px;
        	color: rgb(255, 255, 255);
        	margin: 0px 4px;
        	font-size: 13px;
        	outline: 0px !important;
        	border-radius: 6px !important;
        }
        span > .paginate_button {
        	/*font-size: 18px;*/
        }
        .user {
            background-size: 50px 50px;
            background: url(<?= base_url('assets/icons/wallet.svg') ?>) no-repeat right;
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

    <div id="appCapsule">
    	<div class="section full mt-2">
    		<div class="section-title user">Data Penjualan</div>
            <div class="modal fade dialogbox" id="DialogForm" data-bs-backdrop="static" tabindex="-1" style="display: none;" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content" style="max-width: 500px;">
                        <div class="modal-header">
                            <h5 class="modal-title">Cetak Pengiriman Barang</h5>
                        </div>
                        <form method="POST" action="<?= base_url('penjualan/pengiriman') ?>">
                            <div class="modal-body text-start mb-2">
                                <div class="form-group pt-0 pb-0">
                                    <div class="input-wrapper">
                                        <label class="form-label float-left mb-0" for="email1">Bulan Tahun</label>
                                        <input type="month" name="tgl" class="form-control">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col pt-0 pb-0 pl-1">
                                        <div class="input-wrapper">
                                            <label class="form-label float-left mb-0" for="tgl">Nomor Awal</label>
                                            <input type="number" name="no_awal" class="form-control" placeholder="example: 1">
                                        </div>
                                    </div>
                                    <div class="form-group col pt-0 pb-0 pr-1">
                                        <div class="input-wrapper">
                                            <label class="form-label float-left mb-0" for="tgl">Nomor Akhir</label>
                                            <input type="number" name="no_akhir" class="form-control" placeholder="example: 500">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <div class="btn-inline">
                                    <button type="button" class="btn btn-text-secondary" data-dismiss="modal">CLOSE</button>
                                    <input type="submit" class="btn btn-text-primary" value="CREATE">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Modal cetak Penjualan Per Bulan -->
            <div class="modal fade dialogbox" id="DialogFormBulan" data-bs-backdrop="static" tabindex="-1" style="display: none;" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content" style="max-width: 500px;">
                        <div class="modal-header">
                            <h5 class="modal-title">Cetak Per-Bulan Penjualan</h5>
                        </div>
                        <form method="POST"action="<?= base_url('penjualan/cetak_penjualan') ?>">
                            <div class="modal-body text-start mb-2">
                                <div class="form-group pt-0 pb-0">
                                    <div class="input-wrapper">
                                        <label class="form-label float-left mb-0" for="email1">Bulan Tahun</label>
                                        <input type="month" name="tgl" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <div class="btn-inline">
                                    <button type="button" class="btn btn-text-secondary" data-dismiss="modal">CLOSE</button>
                                    <input type="submit" class="btn btn-text-primary" value="CREATE">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Modal cetak Penjualan Per 6 Bulan -->
            <div class="modal fade dialogbox" id="DialogFormNamBulan" data-bs-backdrop="static" tabindex="-1" style="display: none;" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content" style="max-width: 500px;">
                        <div class="modal-header">
                            <h5 class="modal-title">Cetak Per-6 Penjualan</h5>
                        </div>
                        <form method="POST"action="<?= base_url('penjualan/cetak_penjualan/') . 'true'; ?>">
                            <div class="modal-body text-start mb-2">
                                <div class="form-group pt-0 pb-0">
                                    <div class="input-wrapper">
                                        <label class="form-label float-left mb-0" for="email1">Tgl Awal</label>
                                        <input type="date" name="tgl_awal" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group pt-0 pb-0">
                                    <div class="input-wrapper">
                                        <label class="form-label float-left mb-0" for="email1">Tgl Akhir</label>
                                        <input type="date" name="tgl_akhir" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <div class="btn-inline">
                                    <button type="button" class="btn btn-text-secondary" data-dismiss="modal">CLOSE</button>
                                    <input type="submit" class="btn btn-text-primary" value="CREATE">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    		<div class="wide-block pb-1 pt-1">
    			<?php if ($this->session->flashdata('danger') !== NULL && $this->session->flashdata('danger') !== '') {
    				?>
    				<div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
    					<?php echo $this->session->flashdata('danger'); ?>
    					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    						<span aria-hidden="true">&times;</span>
    					</button>
    				</div>
    				<?php
    			} else {
    				echo "";
    			}
    			?>
                <?php if ($this->session->flashdata('success') !== NULL && $this->session->flashdata('success') !== '') {
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
    			<hr>
    			<!-- <div class="table-responsive"> -->
    				<form method="POST" id="form1">
    					<!-- <div class="form-group">
    						<div class="row">
    							<div class="col-md-12 p-0">
    								<input type="submit" value="print" class="form-control form-control-sm">
    							</div>
    						</div>
    					</div> -->
    				<table class="table table-responsive" id="dataTables">
    					<thead>
    						<tr>
    							<th><input type="reset" value="x"></th>
    							<th>No</th>
    							<th>Kode Penjualan</th>
    							<th>Nama Pemesan</th>
    							<th>Alamat</th>
    							<th>Hp</th>
    							<th>Jenis Pembayaran</th>
    							<th>Jumlah Pcs</th>
    							<th>BN</th>
    							<th>Harga kredit</th>
    							<th>Total Kredit Brg</th>
    							<th>DP Pembayaran</th>
    							<th>Sisa Pembayaran</th>
    							<th style="min-width: 100px;">Tanggal</th>
    							<th>Status</th>
    							<th>Kode Karyawan</th>
    							<th>Aksi</th>
    						</tr>
    					</thead>
    					<tbody>
    						<?php
    						$nomor=1;
    						foreach ($data as $key): ?>
    							<tr style="background: <?php echo ($key->ket == 'LUNAS') ? "yellow" : "none"; ?>">
    								<?php if ($key->ket == 'BELUM'): ?>
    									<td>
    										<input type="checkbox" name="kode_pen[]" value="<?= $key->kode_penjualan ?>" class="ml-1" style="transform: scale(1.5);">
    									</td>
    								<?php else: ?>
    									<td></td>
    								<?php endif;?>
    								<td><?= $nomor++; ?></td>
    								<td>
    									<a href="<?= base_url('angsuran/detail/') . $key->kode_penjualan ?>">
    										<?= $key->kode_penjualan; ?>
    									</a>
    								</td>
    								<td><?= $key->nama; ?></td>
    								<td><?= $key->alamat; ?></td>
    								<td><?= $key->hp; ?></td>
    								<td><?= $key->jenis_pembayaran; ?></td>
    								<td><?= $key->jumlah_produk; ?></td>
    								<td><?= $key->bonus; ?></td>
    								<td>
                                        <?php $ex= explode(",", $key->harga);
                                        foreach ($ex as $hrg) {
                                            echo '<small>['.number_format((float) $hrg).']</small>';
                                        }
                                        ?> 
                                        </td>
    								<td><?= 'Rp.'. number_format((float) $key->total_brg); ?></td>
    								<td><?= 'Rp.'. number_format((float) $key->dp_pembayaran) ?></td>
    								<?php
    								$result = (int) $key->total_brg;
                                    $result -= ((int) $key->januari < 0) ? 0 : (int) $key->januari;
                                    $result -= ((int) $key->februari < 0) ? 0 : (int) $key->februari;
                                    $result -= ((int) $key->maret < 0) ? 0 : (int) $key->maret;
                                    $result -= ((int) $key->april < 0) ? 0 : (int) $key->april;
                                    $result -= ((int) $key->mei < 0) ? 0 : (int) $key->mei;
                                    $result -= ((int) $key->juni < 0) ? 0 : (int) $key->juni;
                                    $result -= ((int) $key->juli < 0) ? 0 : (int) $key->juli;
                                    $result -= ((int) $key->agustus < 0) ? 0 : (int) $key->agustus;
                                    $result -= ((int) $key->september < 0) ? 0 : (int) $key->september;
                                    $result -= ((int) $key->oktober < 0) ? 0 : (int) $key->oktober;
                                    $result -= ((int) $key->november < 0) ? 0 : (int) $key->november;
                                    $result -= ((int) $key->desember < 0) ? 0 : (int) $key->desember;
    								?>
    								<td><?= 'Rp.'. number_format((float) $result) ?></td>
    								<td width="500px"><?= $key->tanggal_transaksi; ?></td>
    								<td><?= $key->ket; ?></td>
    								<td><?= $key->kode_karyawan; ?></td>
    								<td colspan="2">
                                        <div class="d-flex">
                                            <a class="btn btn-sm btn-warning m-1" href="<?= base_url('penjualan/edit/') . $key->kode_penjualan ?>">EDIT</a>
                                            <a class="btn btn-sm btn-success m-1" href="<?= base_url('penjualan/detail/') . $key->kode_penjualan ?>">DETAIL</a>
                                            <a class="btn btn-sm btn-danger m-1" href="<?= base_url('penjualan/delete/') . $key->kode_penjualan ?>">DELETE</a>
                                        </div>
    								</td>
    							</tr>
    						<?php endforeach; ?>
    					</tbody>
    				</table>
    				</form>
    			<!-- </div> -->
    			
    		</div>
    	</div>
    </div>

	
	<!-- App Bottom Menu -->
    <?php include 'menu_view.php'; ?>


	<script type="text/javascript" src="<?php echo base_url('assets/js/jquery-3.5.1.min.js'); ?>"></script>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <!-- Bootstrap-->
    <script type="text/javascript" src="<?php echo base_url('assets/js/popper.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/select2.min.js'); ?>"></script>
    <!-- DataTables-->
    <script type="text/javascript" src="<?php echo base_url('assets/js/dataTables.bootstrap.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.dataTables.min.js'); ?>"></script>
    <script type="text/javascript">
    	$(document).ready(function() {
    		$('#dataTables').DataTable({
    			"info": true,
                "lengthChange": true,
                "order": [[0, "asc"], [1, "asc"]],
                "pagingType": "full_numbers",
    			"lengthMenu": [1000, 25, 50, 75, 100 ],
    			"dom": '<"toolbar">fltip'
    		});

    		$("div.toolbar").css('float','left');
            $("div.toolbar").css('display','flex');
    		$("div.toolbar").append('<span><input type="date" name="tgl" class="form-control"></span>');
            $("div.toolbar").append('<button class="btn btn-success" type="submit" id="one" data-toggle="tooltip" data-placement="top" title="cetak banyak data SATU pelanggan"><img src="<?= base_url('assets/icons/person.svg') ?>" class="icons m-1">Tagihan</button>');

            $("div.toolbar").append('<button class="btn btn-success" type="submit" id="more" data-toggle="tooltip" data-placement="top" title="cetak banyak data BEDA pelanggan"><img src="<?= base_url('assets/icons/people.svg') ?>" class="icons m-1">Tagihan</button>');
            $("div.toolbar").append('<a class="btn ml-1 btn-success" href="<?= base_url('penjualan/input') ?>">Tambah Penjualan</a>');
            $("div.toolbar").append('<button type="button" id="clickModal" class="btn shadowed ml-1" data-toggle="modal" data-target="#DialogForm"><img src="<?= base_url('assets/icons/printer.svg') ?>" class="icons mr-1">Cetak Pengiriman Brg</button>');
            $("div.toolbar").append('<div class="dropdown">'+
                '<button class="btn shadowed dropdown-toggle" id="menu1" type="button" data-toggle="dropdown"><img src="<?= base_url('assets/icons/printer.svg') ?>" class="icons mr-1">Cetak Penjualan'+
                    '<span class="caret"></span></button>'+
                    '<ul class="dropdown-menu" role="menu" aria-labelledby="menu1">'+
                        '<li role="presentation">'+
                            '<a role="menuitem" class="dropdown-item" tabindex="-1" href="#" id="clickModalBulan" data-toggle="modal" data-target="#DialogFormBulan">Cetak Per Bulan</a>'+
                        '</li>'+
                        '<li role="presentation"><a role="menuitem" class="dropdown-item" tabindex="-1" href="#" id="clickModalNamBulan" data-toggle="modal" data-target="#DialogFormNamBulan">Cetak Per 6 Bulan</a></li>'+  
                    '</ul>'+
            '</div>');


    		$('.dataTables_length').css('float','left');
    		$('.dataTables_length>label>select').addClass('form-control');

    		$('.dataTables_filter').css('float','right');
    		$('.dataTables_filter>label>input').addClass('form-control');


    	});
    	function hideNotification(){
    		$('#notification-8').hide();
    	}

    	function callNotification(){
    		$('#notification-8').show();
    	};

        $("#clickModal").button("toggle");
        $("#clickModalBulan").button("toggle");
        $("#clickModalNamBulan").button("toggle");
        $(document).ready(function() {
            $('#one').click(function(){
                $('#form1').attr("action", "<?= base_url('penjualan/tagihan') ?>");
            });
            $('#more').click(function(){
                $('#form1').attr("action", "<?= base_url('penjualan/tagihanmore') ?>");
            });

            $(function () {
                $('[data-toggle="tooltip"]').tooltip()
            })
        });

        
    </script>
</body>
</html>