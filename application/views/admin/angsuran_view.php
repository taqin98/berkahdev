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
    <link rel="stylesheet" href="<?= base_url('/assets/css/dataTables.bootstrap4.min.css') ?>" async>
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/icons-style.css'); ?>">
    <!-- <script type="module" src="https://unpkg.com/ionicons@5.0.0/dist/ionicons/ionicons.esm.js" data-stencil-namespace="ionicons"></script>
    <script nomodule="" src="https://unpkg.com/ionicons@5.0.0/dist/ionicons/ionicons.js" data-stencil-namespace="ionicons"></script> -->
    <!-- <link rel="manifest" href="/__manifest.json"> -->
    <style type="text/css">
    	div.dataTables_wrapper div.dataTables_filter {
    		text-align: right;
    		float: right;
    	}
    	div.dataTables_wrapper div.dataTables_length {
    		text-align: left;
    		float: left;
    	}
        .bg-LULUS {
            background: #34C759 !important;
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
            <div class="section-title" style="display: inline-flex;">Data Angsuran
            </div>
            <div class="wide-block ml-2 mr-2 p-0">
            	<div class="modal fade dialogbox" id="DialogFormCetakAngsuran" data-bs-backdrop="static" tabindex="-1" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content" style="max-width: 500px;">
                            <div class="modal-header">
                                <h5 class="modal-title">Cetak Angsuran</h5>
                            </div>
                            <form method="POST"action="<?= base_url('angsuran/cetak_angsuran') ?>">
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
            	<div class="table-responsive">
                <form method="POST" action="<?= base_url('angsuran') ?>">
            		<table class="table" border="0" id="dataTables">
            			<thead>
            				<tr>
            					<?php
            					if ($isFilter) {
            						?>
            						<th rowspan="2">No</th>
            						<th rowspan="2">Tgl</th>
            						<th rowspan="2">Kode Angsuran</th>
            						<th rowspan="2">Kode Penjualan</th>
            						<th rowspan="2">Nama</th>
            						<th rowspan="2">Jenis Bayar</th>
            						<th rowspan="2">Jml</th>
            						<th rowspan="2">bonus</th>
            						<th rowspan="2">Total Harga Barang</th>
            						<th>A1</th>
            						<th>A2</th>
            						<th>A3</th>
            						<th>A4</th>
            						<th>A5</th>
            						<th>A6</th>
                                    <th>A7</th>
            						<th rowspan="2">Sisa Pembayaran</th>
            						<th rowspan="2">Collector</th>
            						<th rowspan="2">Status</th>
            						<?php
            					} else {
            						?>
            						<th>No</th>
            						<th>Tgl</th>
            						<th>Kode Angsuran</th>
            						<th>Kode Penjualan</th>
            						<th>Nama</th>
            						<th>Jenis Bayar</th>
            						<th>Jml</th>
            						<th>bonus</th>
            						<th>Total Harga Barang</th>                               
            						<th>Sisa Pembayaran</th>
            						<th>Collector</th>
            						<th>Status</th>
            						<?php
            					}
            					?>
            				</tr>
            				
            				<?php
            				if ($isFilter) {
            					$data_bulan = array();
            					if ($isData) {
            						echo "<tr>";
            						foreach ($month as $date) {
            							$month = (int) date("m",strtotime($date->format("Y-m-d")));
            							$year = (int) date("y",strtotime($date->format("Y-m-d")));
            							switch ($month) {
            								case 1:
            								echo "<th>JAN ".$year."</th>";
            								$data_bulan[1]=1;
            								break;
            								case 2:
            								echo "<th>FEB ".$year."</th>";
            								$data_bulan[2]=2;
            								break;
            								case 3:
            								echo "<th>MAR ".$year."</th>";
            								$data_bulan[3]=3;
            								break;
            								case 4:
            								echo "<th>APR ".$year."</th>";
            								$data_bulan[4]=4;
            								break;
            								case 5:
            								echo "<th>MEI ".$year."</th>";
            								$data_bulan[5]=5;
            								break;
            								case 6:
            								echo "<th>JUN ".$year."</th>";
            								$data_bulan[6]=6;
            								break;
            								case 7:
            								echo "<th>JUL ".$year."</th>";
            								$data_bulan[7]=7;
            								break;
            								case 8:
            								echo "<th>AGS ".$year."</th>";
            								$data_bulan[8]=8;
            								break;
            								case 9:
            								echo "<th>SEP ".$year."</th>";
            								$data_bulan[9]=9;
            								break;
            								case 10:
            								echo "<th>OKT ".$year."</th>";
            								$data_bulan[10]=10;
            								break;
            								case 11:
            								echo "<th>NOV ".$year."</th>";
            								$data_bulan[11]=11;
            								break;
            								case 12:
            								echo "<th>DES ".$year."</th>";
            								$data_bulan[12]=12;
            								break;
            							}
            						}
            						echo "</tr>";
            					} else {
                                		//echo "KOSONG";
            					}
            				}
            				?>
            			</thead>
            			<tbody>
            				<?php
            				$nomor = 0;
            				if ($isData) {
            					foreach ($data as $key): ?>
            						<tr style="background: <?php echo ($key->ket == 'LUNAS') ? "yellow" : "none"; ?>">
            							<td><?php $nomor++; echo $nomor; ?></td>
            							<td><?= $key->tanggal_transaksi; ?></td>
            							<td><?= $key->kode_angsuran; ?></td>
            							<td>
            								<a href="<?= base_url('angsuran/detail/') . $key->kode_penjualan ?>"><?= $key->kode_penjualan; ?></a>
            							</td>
            							<td><?= $key->nama; ?></td>
            							<td><?= $key->jenis_pembayaran; ?></td>
            							<td><?= $key->jumlah_produk; ?></td>
            							<td><?= $key->bonus; ?></td>
            							<td><?= number_format((float) $key->total_brg); ?></td>
            							<?php
            							if (isset($month)) {
            								foreach ($data_bulan as $bln) {
            									switch ($bln) {
            										case 1:
            										echo "<td>".$val = ($key->januari !== NULL) ? number_format((float) $key->januari) : $key->januari."</td>";
            										break;
            										case 2:
            										echo "<td>".$val = ($key->februari !== NULL) ? number_format((float) $key->februari) : $key->februari."</td>";
            										break;
            										case 3:
            										echo "<td>".$val = ($key->maret !== NULL) ? number_format((float) $key->maret) : $key->maret."</td>";
            										break;
            										case 4:
            										echo "<td>".$val = ($key->april !== NULL) ? number_format((float) $key->april) : $key->april."</td>";
            										break;
            										case 5:
            										echo "<td>".$val = ($key->mei !== NULL) ? number_format((float) $key->mei) : $key->mei."</td>";
            										break;
            										case 6:
            										echo "<td>".$val = ($key->juni !== NULL) ? number_format((float) $key->juni) : $key->juni."</td>";
            										break;
            										case 7:
            										echo "<td>".$val = ($key->juli !== NULL) ? number_format((float) $key->juli) : $key->juli."</td>";
            										break;
            										case 8:
            										echo "<td>".$val = ($key->agustus != NULL) ? number_format((float) $key->agustus) : $key->agustus."</td>";
            										break;
            										case 9:
            										echo "<td>".$val = ($key->september != NULL) ? number_format((float) $key->september) : $key->september."</td>";
            										break;
            										case 10:
            										echo "<td>".$val = ($key->oktober !== NULL) ? number_format((float) $key->oktober) : $key->oktober."</td>";
            										break;
            										case 11:
            										echo "<td>".$val = ($key->november !== NULL) ? number_format((float) $key->november) : $key->november."</td>";
            										break;
            										case 12:
            										echo "<td>".$val = ($key->desember !== NULL) ? number_format((float) $key->desember) : $key->desember."</td>";
            										break;
            									}
            								}
            							}
                            			if ($key->jenis_pembayaran == 'C') { // cash
                            				echo "<td>" . $key->sisa_pembayaran . "</td>";
                            			} else {
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
                            				echo "<td>" . number_format((float) $result) . "</td>";
                            			}
                            			?>
                            			<td><?= $key->collector ?></td>
                            			<td><?= $key->ket ?></td>
                            		</tr>
                            	<?php endforeach;
                            } else {
                            	?>
                            	<tr>
                            		<td colspan="9" align="center">DATA TIDAK DITEMUKAN. <a href="<?= base_url('angsuran')?>">KLIK RESET</a></td>
                            	</tr>
                            	<?php
                            }
                            ?>
                        </tbody>
                    </table>
                </form>
                </div>

            </div>
        </div>


        <!-- app footer -->

        <!-- * app footer -->
        <!-- <table id="example" class="display" style="width:100%">
        	<thead>
        		<tr>
        			<th rowspan="2">Name</th>
        			<th>A1</th>
        			<th>A2</th>
        			<th>A3</th>
        			<th>A4</th>
        			<th>A5</th>
        			<th>A6</th>
        			<th rowspan="2">Contact</th>
        		</tr>
        		<tr>
        			<th>Position</th>
        			<th>Salary</th>
        			<th>Office</th>
        			<th>Extn.</th>
        			<th>E-mail</th>
        			<th>E-mail</th>
        		</tr>
        	</thead>
        	<tbody>
        		<tr>
        			<td>Tiger Nixon</td>
        			<td>System Architect</td>
        			<td>$320,800</td>
        			<td>Edinburgh</td>
        			<td>5421</td>
        			<td>t.nixon@datatables.net</td>
        			<td>t.nixon@datatables.net</td>
        			<td>t.nixon@datatables.net</td>
        		</tr>
        		<tr>
        			<td>Garrett Winters</td>
        			<td>Accountant</td>
        			<td>$170,750</td>
        			<td>Tokyo</td>
        			<td>8422</td>
        			<td>g.winters@datatables.net</td>
        			<td>g.winters@datatables.net</td>
        			<td>g.winters@datatables.net</td>
        		</tr>
        	</tbody>
        </table> -->
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
    <script type="text/javascript" src="<?php echo base_url('assets/js/jquery-3.5.1.min.js'); ?>"></script>
    <!-- Bootstrap-->
    <script type="text/javascript" src="<?php echo base_url('assets/js/popper.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
    
    <!-- DataTables-->
    <script type="text/javascript" src="<?php echo base_url('assets/js/dataTables.bootstrap.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.dataTables.min.js'); ?>"></script>
    <script type="text/javascript">
    	$(document).ready(function() {
    		$('#dataTables').DataTable({
    			"info": false,
    			"lengthMenu": [10, 25, 50, 75, 100 ],
                "dom": '<"toolbar">frtip'
    		});

            $("div.toolbar").css('float','left');
            $("div.toolbar").css('display','flex');
            // $("div.toolbar").append('<span><input type="date" name="tgl" class="form-control"></span>');
            $("div.toolbar").append(
                                    '<span><select class="form-control m-1" name="bln">'+
                                        '<option value="">-- Pilih Bulan --</option>'+
                                        '<option value="01">Januari</option>'+
                                        '<option value="02">Februari</option>'+
                                        '<option value="03">Maret</option>'+
                                        '<option value="04">April</option>'+
                                        '<option value="05">Mei</option>'+
                                        '<option value="06">Juni</option>'+
                                        '<option value="07">Juli</option>'+
                                        '<option value="08">Agustus</option>'+
                                        '<option value="09">September</option>'+
                                        '<option value="10">Oktober</option>'+
                                        '<option value="11">November</option>'+
                                        '<option value="12">Desember</option>'+
                                    '</select></span>'+
                                    '<span><select class="form-control m-1" name="th">'+
                                        '<?php
                                        $mulai= date('Y') - 20;
                                        for($i = $mulai;$i<$mulai + 100;$i++){
                                            $sel = ($i == date('Y')) ? ' selected="selected"' : '';
                                            echo '<option value="'.$i.'"'.$sel.'>'.$i.'</option>';
                                        }
                                        ?>'+
                                    '</select></span>'+
                                    '<input type="submit" name="" class="btn btn-primary m-1" value="Filter">'+
                                    '<a href="<?= base_url('angsuran')?>" class="btn btn-danger ml-0 m-1">Reset</a>'+
                                '<div class="input-wrapper m-1">'+
                                    <?php
                                    if ($isFilter) {
                                        if (isset($periode)) {
                                            ?>
                                            '<h3>Periode</h3>'+
                                            '<div class="d-flex">'+
                                                '<span><?= $periode->bulan_mulai; ?></span>'+
                                                '<span> - </span>'+
                                                '<span><?= $periode->bulan_akhir; ?></span>'+
                                            '</div>'+
                                            <?php
                                        }
                                        
                                    }
                                    ?>
                                '</div>');
            $("div.toolbar").append('<span><button type="button" id="clickModalCetakAngsuran" class="btn shadowed ml-0 m-1" data-toggle="modal" data-target="#DialogFormCetakAngsuran">Cetak Angsuran</button></span>');

            $('.dataTables_wrapper>.dataTables_length').css('float','left');
            $('.dataTables_length>label>select').addClass('form-control');

            $('.dataTables_wrapper>.dataTables_filter').css('float','right');
            $('.dataTables_filter>label>input').addClass('form-control m-1');
    	});

        $("#clickModalCetakAngsuran").button("toggle");
    </script>
</body>
</html>