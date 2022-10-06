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
    <link rel="stylesheet" href="<?= base_url('/assets/css/select2.min.css') ?>" async>
    <link rel="stylesheet" href="<?= base_url('/assets/css/dataTables.bootstrap4.min.css') ?>" async>
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
        .abu-abu {
            background: #ced4da61;
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
            <div class="section-title" style="display: inline-flex;">Rekap Penjualan
                <form method="POST" action="" class="m-0 d-flex">
                	<select name="bln" class="form-control form-control-sm ml-2">
                		<option>-- Filter Bulan --</option>
                		<option value="">Januari - Juni</option>
                	</select>
                	<select name="bln" class="form-control form-control-sm ml-1">
                		<option>-- Filter Tahun --</option>
                		<?php
                		$mulai= date('Y') - 20;
                		for($i = $mulai;$i<$mulai + 100;$i++){
                			$sel = $i == date('Y') ? ' selected="selected"' : '';
                			echo '<option value="'.$i.'"'.$sel.'>'.$i.'</option>';
                		}
                		?>
                	</select>
                	<input type="submit" value="submit" class="btn-success btn btn-sm ml-1" name="">
                </form>
            </div>
            <div class="wide-block ml-2 mr-2 p-0">
                <h3 class="m-2">KETERANGAN</h3>
                <table class="m-2">
                    <tr>
                        <td>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="red" width="16" height="16" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                                <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                            </svg>
                        </td>
                        <td>:</td>
                        <td>
                            <small>- Terdapat data baru didalam jangka waktu 7 Bulan</small>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td><small>&nbsp; walaupun terdapat selisih tanggal</small></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td><small>- Data lebih dari 1</small></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td><small>- Data belum lunas</small></td>
                    </tr>
                </table>
                <div class="table-responsive">
                    <table class="table table-hover" border="0" id="dataTables">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Pelanggan</th>
                                <th>Nama Pelanggan</th>
                                <th>Thn</th>
                                <th>Jan</th>
                                <th class="abu-abu">BN</th>

                                <th>Feb</th>
                                <th class="abu-abu">BN</th>
                                
                                <th>Mar</th>
                                <th class="abu-abu">BN</th>

                                <th>Apr</th>
                                <th class="abu-abu">BN</th>

                                <th>Mei</th>
                                <th class="abu-abu">BN</th>

                                <th>Jun</th>
                                <th class="abu-abu">BN</th>

                                <th>Jul</th>
                                <th class="abu-abu">BN</th>

                                <th>Ags</th>
                                <th class="abu-abu">BN</th>

                                <th>Sep</th>
                                <th class="abu-abu">BN</th>

                                <th>Okt</th>
                                <th class="abu-abu">BN</th>

                                <th>Nov</th>
                                <th class="abu-abu">BN</th>

                                <th>Des</th>
                                <th class="abu-abu">BN</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no=1;
                            $data = $this->db->query("SELECT tb_pelanggan.kode_pelanggan as kode_pel, tb_pelanggan.nama, tb_penjualan.tanggal_transaksi as tgl, tb_penjualan.ket as sts,
SUM( IF(MONTH(tanggal_transaksi) = 1, jumlah_produk, NULL) ) as januari,
SUM( IF(MONTH(tanggal_transaksi) = 1, bonus, NULL) ) as bn_jan,
(SELECT tanggal_transaksi FROM tb_penjualan WHERE MONTH(tanggal_transaksi) = 1 AND kode_pelanggan=kode_pel LIMIT 1) as tgl_jan,

SUM( IF(MONTH(tanggal_transaksi) = 2, jumlah_produk, NULL) ) as februari,
SUM( IF(MONTH(tanggal_transaksi) = 2, bonus, NULL) ) as bn_feb,
(SELECT tanggal_transaksi FROM tb_penjualan WHERE MONTH(tanggal_transaksi) = 2 AND kode_pelanggan=kode_pel LIMIT 1) as tgl_feb,

SUM( IF(MONTH(tanggal_transaksi) = 3, jumlah_produk, NULL) ) as maret,
SUM( IF(MONTH(tanggal_transaksi) = 3, bonus, NULL) ) as bn_mar,
(SELECT tanggal_transaksi FROM tb_penjualan WHERE MONTH(tanggal_transaksi) = 3 AND kode_pelanggan=kode_pel LIMIT 1) as tgl_mar,

SUM( IF(MONTH(tanggal_transaksi) = 4, jumlah_produk, NULL) ) as april,
SUM( IF(MONTH(tanggal_transaksi) = 4, bonus, NULL) ) as bn_apr,
(SELECT tanggal_transaksi FROM tb_penjualan WHERE MONTH(tanggal_transaksi) = 4 AND kode_pelanggan=kode_pel LIMIT 1) as tgl_apr,

SUM( IF(MONTH(tanggal_transaksi) = 5, jumlah_produk, NULL) ) as mei,
SUM( IF(MONTH(tanggal_transaksi) = 5, bonus, NULL) ) as bn_mei,
(SELECT tanggal_transaksi FROM tb_penjualan WHERE MONTH(tanggal_transaksi) = 5 AND kode_pelanggan=kode_pel LIMIT 1) as tgl_mei,

SUM( IF(MONTH(tanggal_transaksi) = 6, jumlah_produk, NULL) ) as juni,
SUM( IF(MONTH(tanggal_transaksi) = 6, bonus, NULL) ) as bn_jun,
(SELECT tanggal_transaksi FROM tb_penjualan WHERE MONTH(tanggal_transaksi) = 6 AND kode_pelanggan=kode_pel LIMIT 1) as tgl_jun,

SUM( IF(MONTH(tanggal_transaksi) = 7, jumlah_produk, NULL) ) as juli,
SUM( IF(MONTH(tanggal_transaksi) = 7, bonus, NULL) ) as bn_jul,
(SELECT tanggal_transaksi FROM tb_penjualan WHERE MONTH(tanggal_transaksi) = 7 AND kode_pelanggan=kode_pel LIMIT 1) as tgl_jul,

SUM( IF(MONTH(tanggal_transaksi) = 8, jumlah_produk, NULL) ) as agustus,
SUM( IF(MONTH(tanggal_transaksi) = 8, bonus, NULL) ) as bn_ags,
(SELECT tanggal_transaksi FROM tb_penjualan WHERE MONTH(tanggal_transaksi) = 8 AND kode_pelanggan=kode_pel LIMIT 1) as tgl_ags,

SUM( IF(MONTH(tanggal_transaksi) = 9, jumlah_produk, NULL) ) as september,
SUM( IF(MONTH(tanggal_transaksi) = 9, bonus, NULL) ) as bn_sep,
(SELECT tanggal_transaksi FROM tb_penjualan WHERE MONTH(tanggal_transaksi) = 9 AND kode_pelanggan=kode_pel LIMIT 1) as tgl_sep,

SUM( IF(MONTH(tanggal_transaksi) = 10, jumlah_produk, NULL) ) as oktober,
SUM( IF(MONTH(tanggal_transaksi) = 10, bonus, NULL) ) as bn_okt,
(SELECT tanggal_transaksi FROM tb_penjualan WHERE MONTH(tanggal_transaksi) = 10 AND kode_pelanggan=kode_pel LIMIT 1) as tgl_okt,

SUM( IF(MONTH(tanggal_transaksi) = 11, jumlah_produk, NULL) ) as november,
SUM( IF(MONTH(tanggal_transaksi) = 11, bonus, NULL) ) as bn_nov,
(SELECT tanggal_transaksi FROM tb_penjualan WHERE MONTH(tanggal_transaksi) = 11 AND kode_pelanggan=kode_pel LIMIT 1) as tgl_nov,

SUM( IF(MONTH(tanggal_transaksi) = 12, jumlah_produk, NULL) ) as desember,
SUM( IF(MONTH(tanggal_transaksi) = 12, bonus, NULL) ) as bn_des,
(SELECT tanggal_transaksi FROM tb_penjualan WHERE MONTH(tanggal_transaksi) = 12 AND kode_pelanggan=kode_pel LIMIT 1) as tgl_des,
SUM(jumlah_produk) as jml
FROM tb_penjualan JOIN tb_pelanggan USING(kode_pelanggan) GROUP BY kode_pelanggan")->result();
                            foreach ($data as $key) {
                            	?>
                            	<tr>
                            		<td><?= $no++; ?></td>
                            		<td><?= $key->kode_pel ?></td>
                            		<td><?= $key->nama ?></td>
                                    <td><?= date('Y', strtotime($key->tgl)) ?></td>
                            		<td><?= $key->januari ?>
                                    <?php
                                    if ($key->januari == ''){
                                        echo " ";
                                    } else{
                                        $controller->checkDataSevenMonth($key->tgl_jan, $key->kode_pel);
                                    }
                                    ?>      
                                    </td>
                            		<td class="abu-abu"><?= $key->bn_jan ?></td>

                            		<td><?= $key->februari ?>
                                    <?php
                                    if ($key->februari == ''){
                                        echo " ";
                                    } else{
                                        $controller->checkDataSevenMonth($key->tgl_feb, $key->kode_pel);
                                    }
                                    ?>       
                                    </td>
                            		<td class="abu-abu"><?= $key->bn_feb ?></td>

                            		<td><?= $key->maret ?>
                                    <?php
                                    if ($key->maret == ''){
                                        echo " ";
                                    } else{
                                        $controller->checkDataSevenMonth($key->tgl_mar, $key->kode_pel);
                                    }
                                    ?>      
                                    </td>
                            		<td class="abu-abu"><?= $key->bn_mar ?></td>

                            		<td><?= $key->april ?>
                                    <?php
                                    if ($key->april == ''){
                                        echo " ";
                                    } else{
                                        $controller->checkDataSevenMonth($key->tgl_apr, $key->kode_pel);
                                    }
                                    ?>      
                                    </td>
                            		<td class="abu-abu"><?= $key->bn_apr ?></td>

                            		<td><?= $key->mei ?>
                                    <?php
                                    if ($key->mei == ''){
                                        echo " ";
                                    } else{
                                        $controller->checkDataSevenMonth($key->tgl_mei, $key->kode_pel);
                                    }
                                    ?>      
                                    </td>
                            		<td class="abu-abu"><?= $key->bn_mei ?></td>

                            		<td><?= $key->juni ?>
                                    <?php
                                    if ($key->juni == ''){
                                        echo " ";
                                    } else{
                                        $controller->checkDataSevenMonth($key->tgl_jun, $key->kode_pel);
                                    }
                                    ?>      
                                    </td>
                            		<td class="abu-abu"><?= $key->bn_jun ?></td>

                            		<td><?= $key->juli ?>
                                    <?php
                                    if ($key->juli == ''){
                                        echo " ";
                                    } else{
                                        $controller->checkDataSevenMonth($key->tgl_jul, $key->kode_pel);
                                    }
                                    ?>      
                                    </td>
                            		<td class="abu-abu"><?= $key->bn_jul ?></td>

                            		<td><?= $key->agustus ?>
                                    <?php
                                    if ($key->agustus == ''){
                                        echo " ";
                                    } else{
                                        $controller->checkDataSevenMonth($key->tgl_ags, $key->kode_pel);
                                    }
                                    ?>      
                                    </td>
                            		<td class="abu-abu"><?= $key->bn_ags ?></td>

                                    <?php //($key->sts == 'LUNAS') ? 'bg-success' : 'bg-white' ?>
                            		<td class=""><?= $key->september ?>
                                    <?php
                                    if ($key->september == ''){
                                        echo " ";
                                    } else{
                                        $controller->checkDataSevenMonth($key->tgl_sep, $key->kode_pel);
                                    }
                                    ?>      
                                    </td>
                            		<td class="abu-abu"><?= $key->bn_sep ?></td>

                            		<td><?= $key->oktober ?>
                                    <?php
                                    if ($key->oktober == ''){
                                        echo " ";
                                    } else{
                                        $controller->checkDataSevenMonth($key->tgl_okt, $key->kode_pel);
                                    }
                                    ?>      
                                    </td>
                            		<td class="abu-abu"><?= $key->bn_okt ?></td>

                            		<td><?= $key->november ?>
                                    <?php
                                    if ($key->november == ''){
                                        echo " ";
                                    } else{
                                        $controller->checkDataSevenMonth($key->tgl_nov, $key->kode_pel);
                                    }
                                    ?>      
                                    </td>
                            		<td class="abu-abu"><?= $key->bn_nov ?></td>

                            		<td><?= $key->desember ?>
                                    <?php
                                    if ($key->desember == ''){
                                        echo " ";
                                    } else{
                                        $controller->checkDataSevenMonth($key->tgl_des, $key->kode_pel);
                                    }
                                    ?>      
                                    </td>
                            		<td class="abu-abu"><?= $key->bn_des ?></td>
                            	</tr>
                            	<?php
                            }
                            ?>
                            
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


	<script type="text/javascript" src="<?php echo base_url('assets/js/jquery-3.5.1.min.js'); ?>"></script>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <!-- Bootstrap-->
    <script type="text/javascript" src="<?php echo base_url('assets/js/popper.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/select2.min.js'); ?>"></script>
    <!-- DataTables-->
    <script type="text/javascript" src="<?php echo base_url('assets/css/dataTables.bootstrap.min.css'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.dataTables.min.js'); ?>"></script>
    <script type="text/javascript">
    	$(document).ready(function() {
    		$('#dataTables').DataTable({
    			"info": true,
    			"lengthMenu": [100 ],
                "fixedHeader": true,
                // "lengthMenu": [10, 25, 50, 75, 100 ],
    			// "dom": '<"toolbar">frtip',
    		});

    		// $("div.toolbar").html('<input type="submit" class="btn btn-success" value="print">');
    		// $("div.toolbar").css('float','left');
    		// $("div.toolbar").append('<span><?php echo "fff" ?></span>');

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

        $(function () {
            $('.example-popover').popover({
                container: 'body'
            })
        })

        $('.example-popover').popover({
            trigger: 'focus'
        })

    </script>
    <script type="text/javascript">
     //    var position = $(window).scrollTop(); 


     //    $(window).scroll(function() {
     //        var scroll = $(window).scrollTop();
     //        if(scroll > position) {
     //            console.log('scrollDown');
     //            $('.appHeader').css('visibility', 'hidden');
     //        } else {
     //         console.log('scrollUp');
     //         if (scroll == 0) {
     //            $('.appHeader').css('visibility', 'visible');
     //        }
     //     }
     //     position = scroll;
     // });
    </script>
</body>
</html>