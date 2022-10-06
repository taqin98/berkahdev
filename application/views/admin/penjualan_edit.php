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
        <div class="section full mt-2">
            <div class="section-title">Edit Data Penjualan</div>
             
            <div class="wide-block pb-1 pt-1">
                
                <form method="POST" action="<?= base_url('penjualan/update/') . $data->kode_penjualan ?>">
                	<div class="row p-1" id="1" >
                		<div class="form-group boxed col pr-1">
                			<div class="input-wrapper">
                				<label class="label" for="name5">Nama Barang</label>
                				<select name="kode_brg[]" class="form-control js-select-brg kode_brg_0" required="">
                					<?php
                					foreach ($barang as $key){
                						if ($key->kode_brg == $penjualan_detail[0]->kode_brg) {
                							?>
                							<option value="<?= $key->kode_brg; ?>"><?= $key->kode_brg; ?> - <?= $key->nama_brg; ?></option>
                							<?php
                						} else {
                							?>
                							<option value="<?= $key->kode_brg; ?>"><?= $key->kode_brg; ?> - <?= $key->nama_brg; ?></option>
                							<?php
                						}
                					}
                					?>
                				</select>
                			</div>
                		</div>
                		<div class="form-group boxed col pr-1">
                			<div class="input-wrapper">
                				<label class="label" for="name5">Qty</label>
                				<input type="text" name="qty[]" class="form-control qty_0" onkeyup="hitungSub(0)" required="" value="<?= $penjualan_detail[0]->qty ?>">
                			</div>
                		</div>
                		<div class="form-group boxed col pr-1">
                			<div class="input-wrapper">
                				<label class="label" for="name5">Harga</label>
                				<?php
                				$brg = $this->db->get_where('tb_barang', array('kode_brg' => $penjualan_detail[0]->kode_brg))->row();
                				?>
                				<input type="text" name="harga_pcs[]" class="form-control harga_pcs_0 disabled" readonly="" value="<?= $brg->harga_pcs ?>">
                			</div>
                		</div>
                		<div class="form-group boxed col pr-1">
                			<div class="input-wrapper">
                				<label class="label" for="name5">Su btotal</label>
                				<div class="input-group">
                					<input type="text" name="subtotal[]" class="form-control subtotal_0 disabled" readonly="">
                					<span class="btn btn-outline-secondary" onclick="updateSub(0)">
                						<img src="<?= base_url('assets/icons/arrow-repeat.svg') ?>" class="icons">
                					</span>
                				</div>
                			</div>
                		</div>
                		<div class="form-group boxed col-1">
                			<div class="input-wrapper">
                				<label class="label" for="name5">&nbsp;</label>
                				<a class="btn btn-success form-control" id="addInput">Add</a>
                			</div>
                		</div>
                	</div>
                	<div id="dynamicForm"></div>
                	<div class="row p-1">
                		<div class="form-group boxed col mr-1">
                			<div class="form-group boxed">
                				<div class="input-wrapper">
                					<label class="label" for="name5">Pilih Pelanggan</label>
                					<select name="kode_pel" class="form-control js-select" required="" style="background: grey">
                							<option value="<?= $data->kode_pelanggan; ?>"><?= $pelanggan->kode_pelanggan; ?> - <?= $pelanggan->nama ?></option>
                					</select>
                				</div>
                				
                			</div>
                			<div class="form-group boxed">
                				<div class="input-wrapper">
                					<label class="label" for="name5">Nama Pemesan</label>
                					<input type="text" name="nm" class="form-control disabled" readonly="" placeholder="Nomor Hp">
                				</div>
                			</div>
                			<div class="form-group boxed">
                				<div class="input-wrapper">
                					<label class="label" for="name5">Alamat</label>
                					<input type="text" name="alm" class="form-control disabled" readonly="" placeholder="Alamat">
                				</div>
                			</div>
                			<div class="form-group boxed">
                				<div class="input-wrapper">
                					<label class="label" for="name5">Hp</label>
                					<input type="text" name="hp" class="form-control disabled" readonly="" placeholder="Keterangan">
                				</div>
                			</div>
                		</div>

                		<div class="form-group boxed col pt-0">
                			<div class="form-group boxed ml-1 pt-2">
                				<div class="input-wrapper">
                					<label class="label" for="name">Kode Penjualan</label>
                					<input type="text" readonly="" class="form-control disabled" placeholder="Kode Penjualan" name="kode_pen" required="" value="<?= $data->kode_penjualan ?>">
                				</div>
                			</div>

                			<div class="row">
                				<div class="col">
                					<div class="form-group boxed">
                						<div class="input-wrapper">
                							<label class="label" for="name5">Jenis Pembayaran</label>
                							<select name="jenis_pem" class="form-control" required="" id="jenis_pem">
                								<option value="">-- Pilih Jenis Pembayaran --</option>
                								<?= ($data->jenis_pembayaran == 'K') ? '<option value="K" selected>Kredit</option><option value="C">Cash</option>' : '<option value="C" selected>Cash</option><option value="K">Kredit</option>' ?>
                								
                								
                							</select>
                						</div>
                					</div>
                				</div>
                				<div class="row col">
                					<div class="col p-0">
                						<div class="form-group boxed">
                							<div class="input-wrapper">
                								<label class="label" for="name5">Jumlah Pcs</label>
                								<input type="text" name="jml" id="eJmlPcs" class="form-control disabled" readonly="" placeholder="Jml">
                							</div>
                						</div>
                					</div>
                					<div class="col p-0">
                						<div class="form-group boxed">
                							<div class="input-wrapper">
                								<label class="label" for="name5">BN</label>
                								<input type="text" name="bn" id="eBn" class="form-control" value="<?= $data->bonus ?>">
                							</div>
                						</div>
                					</div>
                				</div>
                				<div class="col">
                					<div class="form-group boxed">
                						<!-- <div class="input-wrapper">
                							<label class="label" for="name5">Harga</label>
                							<input type="text" name="hrg" id="eHrg" oninput="calculate()" class="form-control disabled" readonly="" placeholder="Harga">
                						</div> -->
                						<div class="input-wrapper">
                							<label class="label" for="name5">Harga Kredit</label>
                							<input type="text" name="hrg" id="eHrg" class="form-control" placeholder="Harga">
                						</div>
                					</div>
                				</div>
                			</div>
                			<div class="row">
                				<div class="col pt-1">
                					<div class="form-group boxed pt-0">
                						<div class="input-wrapper">
                							<label class="label" for="name5">Total Kredit Brg</label>
                							<input type="text" name="total_brg" id="eTotalBrg" class="form-control disabled" readonly="" placeholder="Total Harga Brg">
                						</div>
                					</div>
                				</div>
                				<div class="col pt-1">
                					<div class="form-group boxed pt-0">
                						<div class="input-wrapper">
                							<label class="label" for="name5">Pembayaran A1</label>
                							<input type="text" name="byr" id="eByr" oninput="countSisa()" class="form-control" placeholder="Pembayaran Pertama" required="" value="<?= $data->dp_pembayaran ?>">
                						</div>
                					</div>
                				</div>
                				<div class="col pt-1">
                					<div class="form-group boxed pt-0">
                						<div class="input-wrapper">
                							<label class="label" for="name5">Sisa Pembayaran</label>
                							<input type="text" name="sisa_byr"  id="eSisaByr" class="form-control disabled" readonly="" placeholder="Sisa Pembayaran" value="<?= $data->sisa_pembayaran ?>">
                						</div>
                					</div>
                				</div>
                			</div>
                			<div class="row">
                				<div class="col pt-1">
                					<div class="input-wrapper">
                						<label class="label" for="name5">Pilih Karyawan</label>
                						<select name="kode_kar" class="form-control js-kar" required="">
                							<option value="">-- Pilih Karyawan --</option>
                							<?php
                							foreach ($karyawan as $key): ?>
                								<?php
                								if ($data->kode_karyawan == $key->kode_karyawan) {
                									?>
                									<option selected="" value="<?= $key->kode_karyawan; ?>"><?= $key->kode_karyawan; ?> - <?= $key->nama_karyawan; ?></option>
                									<?php
                								} else {
                									?>
                									<option value="<?= $key->kode_karyawan; ?>"><?= $key->kode_karyawan; ?> - <?= $key->nama_karyawan; ?></option>
                									<?php
                								}
                								?>
                								
                							<?php endforeach; ?>
                						</select>
                					</div>
                				</div>
                				<div class="col pt-1">
                					<div class="form-group boxed pt-0">
                						<div class="input-wrapper">
                							<label class="label" for="name5">Tanggal</label>
                							<input type="date" name="tgl" id="eTgl" class="form-control" required="" value="<?= $data->tanggal_transaksi ?>">
                						</div>
                					</div>
                				</div>
                			</div>
                			

                		</div>
                	</div>
                    
                    
                    
                    
                    
                    
                    
                    
                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <input type="submit" class="btn btn-primary btn-block btn-lg" value="Update Data">
                        </div>
                    </div>
                </form>
            </div>
        </div>


        <!-- app footer -->

        <!-- * app footer -->
<?php var_dump(count($penjualan_detail)) ?>
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
    <script type="text/javascript">
    	var x=0;

    </script>
    <script type="text/javascript">
    	
    	console.log('BERITA', <?= count($penjualan_detail) ?>);
    	$(document).ready(function() {
    		//var body = 
    		if (<?= count($penjualan_detail) ?> == 1) {
    			console.log('HIDEN');
    			$('#dynamicForm').append('');
    		} else {
    			console.log('SHOW');

    		for (var i = 1; i < <?= count($penjualan_detail) ?>; i++) {
    			$('#dynamicForm').append('<div class="row row_'+i+' p-1"><div class="form-group boxed col pr-1 pt-0">'+
                			'<div class="input-wrapper">'+
                				'<label class="label" for="name5">Nama Barang</label>'+
                				'<select name="kode_brg[]" readonly="" class="form-control kode_brg_'+i+' js-select-brg_'+i+'" onchange="getHarga('+i+')">'+
                							'<option value="">-- Pilih Barang --</option>'+
                							<?php
                							$index = 0;
                							foreach ($barang as $key): ?>
                								<?php
                								if (count($penjualan_detail) > 1) {
                									if ($key->kode_brg == $penjualan_detail[$index]->kode_brg) {
                										?>
                										'<option selected value="<?= $key->kode_brg; ?>"><?= $key->kode_brg; ?> - <?= $key->nama_brg; ?></option>'+
                										<?php
                									} 
                								}
                								

                								?>
                								
                							<?php $index++; endforeach; ?>
                						'</select>'+
                			'</div>'+
                		'</div>'+
                		'<div class="form-group boxed col pr-1 pt-0">'+
                			'<div class="input-wrapper">'+
                				'<label class="label" for="name5">Qty</label>'+
                				<?php if (count($penjualan_detail) > 1) {
                					?>
                					'<input type="text" name="qty[]" class="form-control qty_'+i+'" onkeyup="hitungSubTot('+i+')" value="<?= $penjualan_detail[$index-1]->qty ?>">'+
                					<?php
                				}
                				?>
                				
                			'</div>'+
                		'</div>'+
                		'<div class="form-group boxed col pr-1 pt-0">'+
                			'<div class="input-wrapper">'+
                				'<label class="label" for="name5">Harga</label>'+
                				<?php
                				if (count($penjualan_detail) > 1) {
                					$brg = $this->db->get_where('tb_barang', array('kode_brg' => $penjualan_detail[$index-1]->kode_brg))->row();
                				}
                				?>
                				'<input type="text" name="harga_pcs[]" class="form-control disabled harga_pcs_'+i+'" readonly="" value="<?= $brg->harga_pcs  ?>">'+
                			'</div>'+
                		'</div>'+
                		'<div class="form-group boxed col pr-1 pt-0">'+
                			'<label class="label" for="name5">Su btotal</label>'+
                			'<div class="input-wrapper">'+
                				'<div class="input-group">'+
                				'<input type="text" name="subtotal[]" class="form-control disabled subtotal_'+i+'" readonly="">'+
                				'<span class="btn btn-outline-secondary" onclick="updateSub('+i+')">'+
                						'<img src="<?= base_url('assets/icons/arrow-repeat.svg') ?>" class="icons">'+
                					'</span>'+
                				'</div>'+
                			'</div>'+
                		'</div>'+
                		'<div class="form-group boxed col-1 pt-0">'+
                			'<div class="input-wrapper">'+
                				'<label class="label" for="name5">&nbsp;</label>'+
                				'<a class="btn btn-danger btn-remove form-control" id="'+i+'" onclick="hitungSubTot('+i+')">Delete</a>'+
                			'</div>'+
                		'</div>'+
                		'</div>');

    		
    		x=i;
    	}
    	
    	}
				
				
				
				
				
				//AUTO LOAD DATA
				var loadTotal=0;
				var loadTotalQty=0;
				if (x == 0) console.log('X KOSONG');
				for (var i = 0; i <= x; i++) {

					var subPertama = $('.qty_'+i).val() * $('.harga_pcs_'+i).val();
					loadTotalQty += parseInt($('.qty_'+i).val());

					loadTotal += subPertama;
					$('.subtotal_'+i).val(subPertama);

					console.log('AUTO COUNT ==>>', );
  				}
  				// $('#eHrg').val(loadTotal);
  				$('#eJmlPcs').val(loadTotalQty);
  				// $('#eTotalBrg').val(loadTotalQty*loadTotal);

  				//CEK BONUS
			// $('#eJmlPcs').on('change', function(){
				// cek_bonus($('#eJmlPcs').val());
			// })

			// init
			// $('#eJmlPcs').change();
		});

    </script>
    <script type="text/javascript">
    	$('#addInput').click(() => {
    		var i =x;
    		i++;
    		x= i;
					//x += 1;
					$('#dynamicForm').append('<div class="row row_'+i+' p-1"><div class="form-group boxed col pr-1 pt-0">'+
						'<div class="input-wrapper">'+
						'<label class="label" for="name5">Nama Barang</label>'+
						'<select name="kode_brg[]" class="form-control kode_brg_'+i+' js-select-brg_'+i+'" onchange="getHarga('+i+')">'+
						'<option value="">-- Pilih Barang --</option>'+
						<?php
						foreach ($barang as $key): ?>
							'<option value="<?= $key->kode_brg; ?>"><?= $key->kode_brg; ?> - <?= $key->nama_brg; ?></option>'+
						<?php endforeach; ?>
						'</select>'+
						'</div>'+
						'</div>'+
						'<div class="form-group boxed col pr-1 pt-0">'+
						'<div class="input-wrapper">'+
						'<label class="label" for="name5">Qty</label>'+
						'<input type="text" name="qty[]" class="form-control qty_'+i+'" onkeyup="hitungSubTot('+i+')">'+
						'</div>'+
						'</div>'+
						'<div class="form-group boxed col pr-1 pt-0">'+
						'<div class="input-wrapper">'+
						'<label class="label" for="name5">Harga</label>'+
						'<input type="text" name="harga_pcs[]" class="form-control disabled harga_pcs_'+i+'" readonly="">'+
						'</div>'+
						'</div>'+
						'<div class="form-group boxed col pr-1 pt-0">'+
						'<label class="label" for="name5">Su btotal</label>'+
						'<div class="input-wrapper">'+
						'<div class="input-group">'+
						'<input type="text" name="subtotal[]" class="form-control disabled subtotal_'+i+'" readonly="">'+
						'<span class="btn btn-outline-secondary" onclick="updateSub('+i+')">'+
						'<img src="<?= base_url('assets/icons/arrow-repeat.svg') ?>" class="icons">'+
						'</span>'+
						'</div>'+
						'</div>'+
						'</div>'+
						'<div class="form-group boxed col-1 pt-0">'+
						'<div class="input-wrapper">'+
						'<label class="label" for="name5">&nbsp;</label>'+
						'<a class="btn btn-danger btn-remove form-control" id="'+i+'" onclick="hitungSubTot('+i+')">Delete</a>'+
						'</div>'+
						'</div>'+
						'</div>');
		});
    	$(document).on('click', '.btn-remove', () => {

    		var btn_remove = $('.btn-remove').attr("id");
    		console.log('dsfdsf',btn_remove);
    		$('.row_'+btn_remove).remove();
    		x--;
    	});
    	function getHarga(iNumber){
    		console.log('xx', $('.js-select-brg_'+iNumber).val());
    		show_brg($('.js-select-brg_'+iNumber).val(), iNumber);
    	}
    	var timerClear=0;
    	function hitungSub(iNumber){
    		clearTimeout(timerClear); 
    		timerClear = setTimeout(countPcsAndHrg, 1000);

    		function countPcsAndHrg() {
    			if (x > 0) {
    				var subPertama = $('.qty_0').val() * $('.harga_pcs_0').val();
    				$('.subtotal_0').val(subPertama);
    				

    				var totalQty=0;
    				var total=0;
    				for(var j=0; j <= x; j++){
    					totalQty += parseInt($('.qty_'+j).val());
    					total += parseInt($('.qty_'+j).val() * $('.harga_pcs_'+j).val());

    					console.log('FOR TOTAL QTY', totalQty);
    					console.log('FOR TOTAL', total);
    				}
    				$('#eJmlPcs').val(totalQty);
    				// $('#eHrg').val(total);
    			} else {
    				var subPertama = $('.qty_0').val() * $('.harga_pcs_0').val();
    				$('.subtotal_0').val(subPertama);

    				$('#eJmlPcs').val(parseInt($('.qty_0').val()) );
    				// $('#eHrg').val(parseInt($('.subtotal_0').val()) );

    				console.log('sub', subPertama);
    				var hargaTotalBrg=0;
    				// hargaTotalBrg = parseInt($('#eJmlPcs').val()) * parseInt($('#eHrg').val());
    				// $('#eTotalBrg').val(hargaTotalBrg);
    			}
    			
    		}
    	}

    	var timerSub=0;
    	function hitungSubTot(iNumber){
    		clearTimeout(timerSub); 
    		timerSub = setTimeout(countPcsAndHrg, 1000);

    		function countPcsAndHrg() {
    			var subPertama = $('.qty_'+iNumber).val() * $('.harga_pcs_'+iNumber).val();
    			$('.subtotal_'+iNumber).val(subPertama);
    			var total=0;
    			var totalQty=0;
    			for(var j=0; j <= x; j++){
    				total += parseInt($('.subtotal_'+j).val());

    				totalQty += parseInt($('.qty_'+j).val());
    				console.log('FOR TOTAL QTY', totalQty);
    			}
    			$('#eJmlPcs').val(totalQty);
    			// $('#eHrg').val(total);

    			var hargaTotalBrg=0;
    			total=0; totalQty=0;
    			// hargaTotalBrg = parseInt($('#eJmlPcs').val()) * parseInt($('#eHrg').val());
    			// $('#eTotalBrg').val(hargaTotalBrg);

    			// console.log('TOTAL QTY', totalQty + parseInt($('.qty_0').val()), i);
    			// console.log('TOTAL GEDE', total + parseInt($('.subtotal_0').val()), i);
    		}
    	}

    	function updateSub(iNumber) {
    		hitungTotalKredit();
    		var subPertama = $('.qty_'+iNumber).val() * $('.harga_pcs_'+iNumber).val();
    		$('.subtotal_'+iNumber).val(subPertama);
    		var total=0;
    		for(var j=0; j <= x; j++){
    			total += parseInt($('.subtotal_'+j).val());
    		}
    		// $('#eHrg').val(total);

    		var hargaTotalBrg = 0;
    		// hargaTotalBrg = parseInt($('#eJmlPcs').val()) * parseInt($('#eHrg').val());
    			// $('#eTotalBrg').val(hargaTotalBrg);
    	}

		$(document).ready(function() {
			//PELANGGAN
			$('.js-select').on('change', function(){
				cek_db($('.js-select').val());
			})

			// init
			$('.js-select').change();

			//BARANG
			$('.js-select-brg').on('change', function(){
				cek_brg($('.js-select-brg').val());
			})

			// init
			$('.js-select-brg').change();
			for (var i = 1; i <= x; i++) {
				$('.js-select-brg_'+i).change();
			}

			//CEK BONUS
			// $('#eTgl').on('change', function(){
			// 	cek_bonus($('#eJmlPcs').val());
			// })

			// // init
			// $('#eTgl').change();

			$('#jenis_pem').on('change', function(){
				hitungTotalKredit($('#jenis_pem').val());
			})
			$('#jenis_pem').change();
		});

		//SELECT2 JS PLUGIN
		$(document).ready(function() {
			$('.js-select').select2();
		});

		$(document).ready(function() {
			$('.js-kar').select2();
		});
		
	</script>
	<script type="text/javascript">
		function cek_db(sKode){
			var id = sKode; 

			$.ajax({
          		url : '<?= base_url('pelanggan/autofill_ajax') ?>', // file proses penginputan
         		method: 'POST',
          		data : {"id": id}

	      	}).success(function (data){
	      		obj = JSON.parse(data);
	      		$('input[name=nm]').val(obj.data.nama); 
	      		$('input[name=alm]').val(obj.data.alamat);
	      		$('input[name=hp]').val(obj.data.hp);
	      })
	      	
  		}
  		function cek_brg(sKode){
			var id = sKode; 
			console.log('id brg', sKode);

			$.ajax({
          		url : '<?= base_url('barang/autofill_ajax') ?>', // file proses penginputan
         		method: 'POST',
          		data : {"id": id}

	      	}).success(function (data){
	      		obj = JSON.parse(data);
	      		console.log('obj', obj);
	      		// var subPertama=0;
	      		// if (obj.data.harga_pcs) {
	      		// 	subPertama = $('.qty_0').val() * $('.harga_pcs_0').val();
	      			
	      		// }
	      		// $('.subtotal_0').val(subPertama);
	      			$('.harga_pcs_0').val(obj.data.harga_pcs); 
	      		
	      })
	      	
  		}

  		function show_brg(sKode, iNumber){
			var id = sKode; 
			console.log('id brg', sKode);

			$.ajax({
          		url : '<?= base_url('barang/autofill_ajax') ?>', // file proses penginputan
         		method: 'POST',
          		data : {"id": id}

	      	}).success(function (data){
	      		obj = JSON.parse(data);
	      		console.log('obj', obj);
	      		$('.harga_pcs_'+iNumber).val(obj.data.harga_pcs); 
	      })
	      	
  		}

  		function cek_bonus(eJml) {
  			var sId = $('select[name=kode_pel]').val();
  			var sTgl = $('input[name=tgl]').val();
  			console.log('cek_bonus =>> ', sId, eJml, sTgl);
  			$.ajax({
          		url : '<?= base_url('penjualan/count') ?>', // file proses penginputan
         		method: 'POST',
          		data : {"id": sId,"jml": eJml, "tgl": sTgl}

	      	}).success(function (data){
	      		obj = JSON.parse(data);
	      		console.log('RETURN DATA BONUS Line 544', obj.bonus);
	      		$('input[name=bn]').val(obj.bonus); 
	      })
  			
  		}

  		var timer = null;

  		function calculate(){
  			$('#eHrg').keyup(function(){
  				clearTimeout(timer); 
  				timer = setTimeout(countPcsAndHrg, 1000)
  			});

  			function countPcsAndHrg() {
  				var total_brg = $('#eJmlPcs').val() * $('#eHrg').val(); $('#eTotalBrg').val(total_brg);
  			}
  		}

  		function countSisa(){
  			$('#eByr').keyup(function(){
  				clearTimeout(timer); 
  				timer = setTimeout(resultSisa, 1000)
  			});

  			function resultSisa() {
  				var sisa_byr = $('#eTotalBrg').val() - $('#eByr').val(); $('#eSisaByr').val(sisa_byr);
  			}
  		}
  		$(document).ready(function(){
  			hitungTotalKredit();
  		});

  		function hitungTotalKredit(){
  			console.log('hitungTotalKredit',$('#jenis_pem').val());
  			var kode, quantity, sub_total_kredit=0;
  			var jns = $('#jenis_pem').val();
  			const arr_sub_total_kredit=[];
  			for (var j = 0; j <= x; j++) {
  				kode = $('.kode_brg_'+j).val();
  				quantity = $('.qty_'+j).val();
                // console.log('AMBIL KODE ', $('.kode_brg_'+j).val(), $('.qty_'+j).val());
                $.ajax({
                    url : '<?= base_url('barang/countTotalKredit') ?>', // file proses penginputan
                    method: 'POST',
                    data : {"kode": kode,"quantity": quantity, "jenis": jns}

                }).success(function (data){
                	obj = JSON.parse(data);
                	arr_sub_total_kredit.push(obj.data.sub_total_kredit);
                	sub_total_kredit += parseInt(obj.data.sub_total_kredit);
                	console.log('hitungTotalKredit 617', obj);
                	$('#eTotalBrg').val(sub_total_kredit); 
                	$('#eHrg').val(arr_sub_total_kredit); 
                })
            }
  		}

	</script>
</body>
</html>