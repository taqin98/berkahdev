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
				<a class="btn btn-success btn-sm" href="<?= base_url('angsuran/index/') . $data->kode_penjualan ?>">
					<img src="<?= base_url('assets/icons/arrow-left.svg') ?>" class="icons icons-white">
					&nbsp; &nbsp;Kembali
				</a>
			</div>
			<div class="wide-block ml-2 mr-2 p-0">
				<div class="row m-1 mb-0" style="font-size: 12px;">
					<div class="col">
						Kode Angsuran
					</div>
					<div class="col-3">
						: <?= $data->kode_angsuran ?>
					</div>
					<div class="col-1">
						Periode
					</div>
					<div class="col-2">
						: <?= $cetak_bulan ?>
					</div>
					<div class="col-2">
						Nama Pelanggan
					</div>
					<div class="col-2">
						: <?= $data->nama ?>
					</div>
				</div>
				<div class="row m-1 mb-0" style="font-size: 12px">
					<div class="col">
						Tgl Transaksi
					</div>
					<div class="col-3">
						: <?= $data->tanggal_transaksi ?>
					</div>
					<div class="col-1">
						Tagihan
					</div>
					<div class="col-2">
						<?php
							if ($data->jenis_pembayaran == 'K') { // Kredit
								echo ": Rp. " . number_format($data->total_brg);
							} else {
								echo ": Rp. " . number_format($data->total_brg);
							}
						?>
					</div>
					<div class="col-2">
						Alamat
					</div>
					<div class="col-2">
						: <?= $data->tanggal_transaksi ?>
					</div>
				</div>
				<div class="table-responsive">

					<form method="POST" action="<?php echo base_url('angsuran/update/') . $data->kode_angsuran; ?>">
						<input type="hidden" name="kode_ang" value="<?= $data->kode_angsuran ?>">
						<input type="hidden" name="kode_pen" value="<?= $data->kode_penjualan ?>">
						<table width="100%" class="table">
							<tr>
								<td colspan="2" align="center">A1</td>
								<td colspan="2" align="center">A2</td>
								<td colspan="2" align="center">A3</td>
								<td colspan="2" align="center">A4</td>
								<td colspan="2" align="center">A5</td>
								<td colspan="2" align="center">A6</td>
								<td colspan="2" align="center">A7</td>
								<td align="center">COLLECTOR</td>
								<td colspan="2" align="center">KET</td>
							</tr>
							<tr>
								<?php
								foreach ($month as $date) {
									$month_number = (int) date("m",strtotime($date->format("Y-m-d")));
									switch ($month_number) {
										case 1:
										echo "<td width='50px'>JAN</td>";
										if ($data->januari !== NULL){
											$val=$data->januari;
											echo "<td> <input class='form-control' style='width:100px;' type='text' name='jnr'value='". $val ."'></td>";
										}
										else{
											$val=NULL;
											echo "<td> <input class='form-control' style='width:100px;' type='text' name='jnr' value='". $val ."' oninput='calculate()'></td>";
										}
										break;
										case 2:
										echo "<td width='50px'>FEB</td>";
										if ($data->februari !== NULL){
											$val=$data->februari;
											echo "<td> <input class='form-control' style='width:100px;' type='text' name='febr' value='". $val ."'></td>";
										}
										else{
											$val=NULL;
											echo "<td> <input class='form-control' style='width:100px;' type='text' name='febr' value='". $val ."' oninput='calculate()'></td>";
										}
										break;
										case 3:
										echo "<td width='50px'>MAR</td>";
										if ($data->maret !== NULL){
											$val=$data->maret;
											echo "<td> <input class='form-control' style='width:100px;' type='text' name='mar' value='". $val ."'></td>";
										}
										else{
											$val=NULL;
											echo "<td> <input class='form-control' style='width:100px;' type='text' name='mar' value='". $val ."' oninput='calculate()'></td>";
										}
										break;
										case 4:
										echo "<td width='50px'>APR</td>";
										if ($data->april !== NULL) {
											$val=$data->april;
											echo "<td> <input class='form-control' style='width:100px;' type='text' name='apr' value='". $val ."'></td>";
										}
										else{
											$val=NULL;
											echo "<td> <input class='form-control' style='width:100px;' type='text' name='apr' value='". $val ."' oninput='calculate()'></td>";
										}
										break;
										case 5:
										echo "<td width='50px'>MEI</td>";
										if ($data->mei !== NULL){
											$val=$data->mei;
											echo "<td> <input class='form-control' style='width:100px;' type='text' name='mei' value='". $val ."'></td>";
										} else {
											$val=NULL;
											echo "<td> <input class='form-control' style='width:100px;' type='text' name='mei' value='". $val ."' ></td>";
										}
										break;
										case 6:
										echo "<td width='50px'>JUN</td>";
										if ($data->juni !== NULL){
											$val=$data->juni;
											echo "<td> <input class='form-control' style='width:100px;' type='text' name='jun' value='". $val ."'></td>";
										}
										else{
											$val=NULL;
											echo "<td> <input class='form-control' style='width:100px;' type='text' name='jun' value='". $val ."'></td>";
										}
										break;
										case 7:
										echo "<td width='50px'>JUL</td>";
										if ($data->juli !== NULL){
											$val=$data->juli;
											echo "<td> <input class='form-control' style='width:100px;' type='text' name='jul' value='". $val ."'></td>";
										}
										else{
											$val=NULL;
											echo "<td> <input class='form-control' style='width:100px;' type='text' name='jul' value='". $val ."'></td>";
										}
										break;
										case 8:
										echo "<td width='50px'>AGS</td>";
										if (!empty($data->agustus)){
											$val=$data->agustus;
											echo "<td> <input class='form-control' style='width:100px;' type='text' name='ags' value='". $val ."'></td>";

										}
										else{
											$val=NULL;
											echo "<td> <input class='form-control' style='width:100px;' type='text' name='ags' value='". $val ."'></td>";
										}

										break;
										case 9:
										echo "<td width='50px'>SEP</td>";
										if (!empty($data->september)){
											$val=$data->september;
											echo "<td> <input class='form-control' style='width:100px;' type='text' name='spt' value='". $val ."'></td>";
										}
										else{
											$val=NULL;
											echo "<td> <input class='form-control' style='width:100px;' type='text' name='spt'></td>";
										}

										break;
										case 10:
										echo "<td width='50px'>OKT</td>";
										if ($data->oktober !== NULL){
											$val=$data->oktober;
											echo "<td> <input class='form-control' style='width:100px;' type='text' name='okt' value='". $val ."'></td>";
										}
										else{
											$val=NULL;
											echo "<td> <input class='form-control' style='width:100px;' type='text' name='okt' value='". $val ."'></td>";
										}

										break;
										case 11:
										echo "<td width='50px'>NOV</td>";
										if ($data->november !== NULL){
											$val=$data->november;
											echo "<td> <input class='form-control' style='width:100px;' type='text' name='novb' value='". $val ."'></td>";
										}
										else{
											$val=NULL;
											echo "<td> <input class='form-control' style='width:100px;' type='text' name='novb' value='". $val ."'></td>";
										}

										break;
										case 12:
										echo "<td width='50px'>DES</td>";
										if ($data->desember !== NULL){
											$val=$data->desember;
											echo "<td> <input class='form-control' style='width:100px;' type='text' name='desb' value='". $val ."'></td>";
										}
										else{
											$val=NULL;
											echo "<td> <input class='form-control' style='width:100px;' type='text' name='desb' value='". $val ."'></td>";
										}

										break;
									}
								}
								?>
								<td style="min-width: 150px">
									<input class="form-control" type="text" name="col" width="200px" value="<?= $data->collector ?>">
								</td>
								<td>
									<select name="sts" class="form-control" style="min-width: 150px">
										<?php
										if ($data->ket == 'BELUM') {
											echo "<option value='BELUM'>BELUM</option>";
											echo "<option value='LUNAS'>LUNAS</option>";
										} else {
											echo "<option value='LUNAS'>LUNAS</option>";
											echo "<option value='BELUM'>BELUM</option>";
										}
										?>
									</select>
								</td>
							</tr>
							<tr>
								<td colspan="13"></td>
								<td colspan="2" align="center">
									<input class="form-control btn btn-primary" type="submit" name="submit" value="Update Data" >
								</td>
							</tr>
						</table>
					</form>

				</div>
			</div>
		</div>
	</div>
	<!-- App Bottom Menu -->
    <?php include 'menu_view.php'; ?>
    <!-- * App Bottom Menu -->
</body>
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery-3.5.1.min.js'); ?>"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<!-- Bootstrap-->
<script type="text/javascript" src="<?php echo base_url('assets/js/popper.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
<script type="text/javascript">
	var iTagihan=parseInt($("table #eValSisaTagihan").text());
		var sisa=0;
	function calculate(){
		$('input[name=jan]').keyup(function(){
			// countPcsAndHrg(1)
			var timer=0;
			clearTimeout(timer); 
			timer = setTimeout(countPcsAndHrg(1, $('input[name=sisa_pem]').val(), $('input[name=jan]').val()), 1000)
		});

		$('input[name=feb]').keyup(function(){
			// countPcsAndHrg(2)
			var timer=0;
			clearTimeout(timer); 
			timer = setTimeout(countPcsAndHrg(2, $('input[name=sisa_pem]').val(), $('input[name=feb]').val()), 1000);
			iTagihan = $('input[name=sisa_pem]').val();
		});

		$('input[name=mar]').keyup(function(){
			// countPcsAndHrg(3);
			var timer=0;
			clearTimeout(timer); 
			timer = setTimeout(countPcsAndHrg(3, $('input[name=sisa_pem]').val(), $('input[name=mar]').val()), 1000);
			// iTagihan= $('input[name=sisa_pem]').val();
		});


		
		function countPcsAndHrg($bln, pem, value) {
			console.log('184', pem, value);
			switch($bln){
				case 1:
				sisa = iTagihan - value;
				$('input[name=sisa_pem]').val(sisa);
				break;

				case 2:
				sisa = iTagihan - value;
				$('input[name=sisa_pem]').val(sisa);
				break;

				case 3:
				sisa = iTagihan - value;
				$('input[name=sisa_pem]').val(sisa);
				break;

				case 4:
				sisa = iTagihan - $('input[name=apr]').val();
				$('input[name=sisa_pem]').val(iTagihan);
				break;

				case 5:
				sisa = iTagihan - $('input[name=mei]').val();
				$('input[name=sisa_pem]').val(iTagihan);
				break;

				case 6:
				sisa = iTagihan - $('input[name=jun]').val();
				$('input[name=sisa_pem]').val(iTagihan);
				break;

				case 7:
				sisa = iTagihan - $('input[name=jul]').val();
				$('input[name=sisa_pem]').val(iTagihan);
				break;

				case 8:
				sisa = iTagihan - $('input[name=ags]').val();
				$('input[name=sisa_pem]').val(iTagihan);
				break;

				case 9:
				sisa = iTagihan - $('input[name=sep]').val();
				$('input[name=sisa_pem]').val(iTagihan);
				break;

				case 10:
				sisa = iTagihan - $('input[name=okt]').val();
				$('input[name=sisa_pem]').val(iTagihan);
				break;

				case 11:
				sisa = iTagihan - $('input[name=nov]').val();
				$('input[name=sisa_pem]').val(iTagihan);
				break;

				case 12:
				sisa = iTagihan - $('input[name=des]').val();
				$('input[name=sisa_pem]').val(iTagihan);
				break;
			}
		}
	}
</script>
</html>