<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penjualan extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	// use PhpOffice\PhpSpreadsheet\Spreadsheet;
	// use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
		$this->load->model('UserModel');
		$this->load->library('session');
		$this->load->model('PelangganModel');
		$this->load->model('PenjualanModel');
		$this->load->model('AngsuranModel');
		$this->load->model('KaryawanModel');
		$this->load->model('BarangModel');
	}

	public function index()
	{
		$data['data'] = $this->PenjualanModel->getCustomData();
		// var_dump($data);
		$this->load->view('admin/dashboard_admin', $data);
	}

	public function input()
	{
		$data['data'] = $this->PelangganModel->getAllData();
		$data['karyawan'] = $this->KaryawanModel->getAllData();
		$data['barang'] = $this->BarangModel->getAllData();
		$this->load->view('admin/penjualan_input', $data);
	}

	public function create()
	{
		$tgl = $this->input->post('tgl', TRUE);
		$byr = $this->input->post('byr', TRUE);

		$bulan = array (1 =>   'januari',
			2 => 'februari',
			3 => 'maret',
			4 => 'april',
			5 => 'mei',
			6 => 'juni',
			7 => 'juli',
			8 => 'agustus',
			9 => 'september',
			10 => 'oktober',
			11 => 'november',
			12 => 'desember'
		);
		$split 	  = explode('-', $tgl);
		$bulan_indo = $bulan[ (int)$split[1] ];
		$intBonus = (int) $this->input->post('bn', TRUE);
		if ($this->input->post('jenis_pem', TRUE) == 'K') {
			# jenis pembayaran kredit
			$data_pen = (object) array(
				'kode_penjualan' => 'PJL'. $this->input->post('kode_pen', TRUE),
				'kode_pelanggan' => $this->input->post('kode_pel', TRUE),
				'jenis_pembayaran' => $this->input->post('jenis_pem', TRUE),
				'bonus' => $this->input->post('bn', TRUE),
				'jumlah_produk' => $this->input->post('jml', TRUE),
				'harga' => $this->input->post('hrg', TRUE),
				'total_brg' => $this->input->post('total_brg', TRUE),
				'dp_pembayaran' => $this->input->post('byr', TRUE),
				'sisa_pembayaran' => $this->input->post('sisa_byr', TRUE),
				'tanggal_transaksi' => $this->input->post('tgl', TRUE),
				'kode_karyawan' => $this->input->post('kode_kar', TRUE),
				'ket' => 'BELUM'
			);
			$data_angsuran = (object) array(
				'kode_angsuran' => 'ANG'. $this->input->post('kode_pen', TRUE),
				'kode_penjualan' => 'PJL'. $this->input->post('kode_pen', TRUE),
				'januari' => $val = ($bulan_indo == 'januari') ? $byr : NULL,
				'februari' => $val = ($bulan_indo == 'februari') ? $byr : NULL,
				'maret' => $val = ($bulan_indo == 'maret') ? $byr : NULL,
				'april' => $val = ($bulan_indo == 'april') ? $byr : NULL,
				'mei' => $val = ($bulan_indo == 'mei') ? $byr : NULL,
				'juni' => $val = ($bulan_indo == 'juni') ? $byr : NULL,
				'juli' => $val = ($bulan_indo == 'juli') ? $byr : NULL,
				'agustus' => $val = ($bulan_indo == 'agustus') ? $byr : NULL,
				'september' => $val = ($bulan_indo == 'september') ? $byr : NULL,
				'oktober' => $val = ($bulan_indo == 'oktober') ? $byr : NULL,
				'november' => $val = ($bulan_indo == 'november') ? $byr : NULL,
				'desember' => $val = ($bulan_indo == 'desember') ? $byr : NULL
			);
			$data_brg = [];
			$this->PenjualanModel->insertPenjualan($data_pen);
			$this->AngsuranModel->insertAngsuran($data_angsuran);
			$kode_pen 	= 'PJL'. $this->input->post('kode_pen', TRUE);
			$kodebrg 	= $_POST['kode_brg'];
			$qty 		= $_POST['qty'];
			$harga_pcs 	= $_POST['harga_pcs'];

			$index=0;
			foreach ($kodebrg as $key) {
				//var_dump($key);
				array_push($data_brg, array(
					'kode_penjualan' => $kode_pen,
					'kode_brg' => $key,
					'qty' => $qty[$index],
				));

				$this->BarangModel->updateDataStok($qty[$index] + $intBonus, $key);
				$index++;
			}
			// $data_brg[] = $data_brg;
			// var_dump($data_pen);
			$this->db->insert_batch('tb_penjualan_detail', $data_brg);
			redirect('penjualan','refresh');
		} else {
			# jenis pembayaran cash
			$data_pen = (object) array(
				'kode_penjualan' => 'PJL'. $this->input->post('kode_pen', TRUE),
				'kode_pelanggan' => $this->input->post('kode_pel', TRUE),
				'jenis_pembayaran' => $this->input->post('jenis_pem', TRUE),
				'bonus' => $this->input->post('bn', TRUE),
				'jumlah_produk' => $this->input->post('jml', TRUE),
				'harga' => $this->input->post('hrg', TRUE),
				'total_brg' => $this->input->post('total_brg', TRUE),
				'dp_pembayaran' => $this->input->post('byr', TRUE),
				'sisa_pembayaran' => $this->input->post('sisa_byr', TRUE),
				'tanggal_transaksi' => $this->input->post('tgl', TRUE),
				'kode_karyawan' => $this->input->post('kode_kar', TRUE),
				'ket' => 'LUNAS'
			);
			$data_angsuran = (object) array(
				'kode_angsuran' => 'ANG'. $this->input->post('kode_pen', TRUE),
				'kode_penjualan' => 'PJL'. $this->input->post('kode_pen', TRUE),
				'januari' => $val = ($bulan_indo == 'januari') ? $byr : NULL,
				'februari' => $val = ($bulan_indo == 'februari') ? $byr : NULL,
				'maret' => $val = ($bulan_indo == 'maret') ? $byr : NULL,
				'april' => $val = ($bulan_indo == 'april') ? $byr : NULL,
				'mei' => $val = ($bulan_indo == 'mei') ? $byr : NULL,
				'juni' => $val = ($bulan_indo == 'juni') ? $byr : NULL,
				'juli' => $val = ($bulan_indo == 'juli') ? $byr : NULL,
				'agustus' => $val = ($bulan_indo == 'agustus') ? $byr : NULL,
				'september' => $val = ($bulan_indo == 'september') ? $byr : NULL,
				'oktober' => $val = ($bulan_indo == 'oktober') ? $byr : NULL,
				'november' => $val = ($bulan_indo == 'november') ? $byr : NULL,
				'desember' => $val = ($bulan_indo == 'desember') ? $byr : NULL
			);
			$data_brg = [];
			$this->PenjualanModel->insertPenjualan($data_pen);
			$this->AngsuranModel->insertAngsuran($data_angsuran);
			$kode_pen 	= 'PJL'. $this->input->post('kode_pen', TRUE);
			$kodebrg 	= $_POST['kode_brg'];
			$qty 		= $_POST['qty'];
			$harga_pcs 	= $_POST['harga_pcs'];

			$index=0;
			foreach ($kodebrg as $key) {
				//var_dump($key);
				array_push($data_brg, array(
					'kode_penjualan' => $kode_pen,
					'kode_brg' => $key,
					'qty' => $qty[$index],
				));

				$this->BarangModel->updateDataStok($qty[$index] + $intBonus, $key);
				$index++;
			}
			// $data_brg[] = $data_brg;
			// var_dump($data_pen);
			$this->db->insert_batch('tb_penjualan_detail', $data_brg);
			redirect('penjualan','refresh');
		}
	}

	public function update($id)
	{
		// $this->db->query("DELETE FROM tb_penjualan_detail WHERE kode_penjualan='$id'");
		// var_dump($id); exit();
		$tgl = $this->input->post('tgl', TRUE);
		$byr = $this->input->post('byr', TRUE);

		$bulan = array (1 =>   'januari',
			2 => 'februari',
			3 => 'maret',
			4 => 'april',
			5 => 'mei',
			6 => 'juni',
			7 => 'juli',
			8 => 'agustus',
			9 => 'september',
			10 => 'oktober',
			11 => 'november',
			12 => 'desember'
		);
		$split 	  = explode('-', $tgl);
		$bulan_indo = $bulan[ (int)$split[1] ];
		// var_dump($this->PenjualanModel->getDataEdit($id)->kode_penjualan); exit();
		
		if ($this->input->post('jenis_pem', TRUE) == 'K') {
			# jenis pembayaran kredit
			$data_pen = (object) array(
				'kode_penjualan' => $id,
				'kode_pelanggan' => $this->input->post('kode_pel', TRUE),
				'jenis_pembayaran' => $this->input->post('jenis_pem', TRUE),
				'bonus' => $this->input->post('bn', TRUE),
				'jumlah_produk' => $this->input->post('jml', TRUE),
				'harga' => $this->input->post('hrg', TRUE),
				'total_brg' => $this->input->post('total_brg', TRUE),
				'dp_pembayaran' => $this->input->post('byr', TRUE),
				'sisa_pembayaran' => $this->input->post('sisa_byr', TRUE),
				'tanggal_transaksi' => $this->input->post('tgl', TRUE),
				'kode_karyawan' => $this->input->post('kode_kar', TRUE),
				'ket' => 'BELUM'
			);
			$data_angsuran = (object) array(
				'kode_angsuran' => $this->AngsuranModel->getAngsuran($id)[0]->kode_angsuran,
				'kode_penjualan' => $this->PenjualanModel->getDataEdit($id)->kode_penjualan,
				'januari' => $val = ($bulan_indo == 'januari') ? $byr : NULL,
				'februari' => $val = ($bulan_indo == 'februari') ? $byr : NULL,
				'maret' => $val = ($bulan_indo == 'maret') ? $byr : NULL,
				'april' => $val = ($bulan_indo == 'april') ? $byr : NULL,
				'mei' => $val = ($bulan_indo == 'mei') ? $byr : NULL,
				'juni' => $val = ($bulan_indo == 'juni') ? $byr : NULL,
				'juli' => $val = ($bulan_indo == 'juli') ? $byr : NULL,
				'agustus' => $val = ($bulan_indo == 'agustus') ? $byr : NULL,
				'september' => $val = ($bulan_indo == 'september') ? $byr : NULL,
				'oktober' => $val = ($bulan_indo == 'oktober') ? $byr : NULL,
				'november' => $val = ($bulan_indo == 'november') ? $byr : NULL,
				'desember' => $val = ($bulan_indo == 'desember') ? $byr : NULL
			);
			$data_brg = [];
			


			$kode_pen 	= $this->PenjualanModel->getDataEdit($id)->kode_penjualan;
			$kode_brg_qr 	= $this->db->query("SELECT * FROM tb_penjualan_detail WHERE kode_penjualan='$id'")->result();
			$kodebrg 	= $_POST['kode_brg'];
			$qty 		= $_POST['qty'];
			$harga_pcs 	= $_POST['harga_pcs'];
			$new_bn 	= (int) $_POST['bn'];
			$old_bn		= (int) $this->PenjualanModel->getDataEdit($id)->bonus;
			

			$index=0;
			
			foreach ($kodebrg as $key) {
				//var_dump($key);
				array_push($data_brg, array(
					'kode_penjualan' => $kode_pen,
					'kode_brg' => $key,
					'qty' => $qty[$index],
				));
				$val = null;

				if ($new_bn > $old_bn){
					$val = $new_bn - $old_bn;
					$this->BarangModel->updateDataStok($val, $key);
				} else {
					$val = $old_bn - $new_bn;
					$val = -$val;
					$this->BarangModel->updateDataStok($val, $key);
				}
				// var_dump($val); exit();

				foreach ($kode_brg_qr as $value) {
					if ($key !== $value->kode_brg) {
						
						// break;
						$checkData = $this->db->query("SELECT EXISTS(SELECT * FROM tb_penjualan_detail WHERE kode_penjualan='$id' AND kode_brg='$key') as data")->row();
						var_dump($key .' !== '.$value->kode_brg, $checkData->data.'<br>');
						if ($checkData->data > 0) {
							echo "Data Sudah Ada, Maka ".$value->kode_brg . ' Dihapus dengan id '.$id.'<br>';
							$this->db->query("DELETE FROM tb_penjualan_detail WHERE kode_penjualan='$id' AND kode_brg='$value->kode_brg'");
						} else {
							$this->db->query("INSERT INTO tb_penjualan_detail (kode_penjualan, kode_brg, qty) VALUES ('$id', '$key', '$qty[$index]')");
							echo "Data Tidak Ada $key<br>";
						}
					}
				}
				

				// $this->BarangModel->updateDataStok($qty[$index], $key);
				// if ()
				$index++;
			}
			// exit();
			// $data_brg[] = $data_brg;
			// var_dump($data_pen);
			//$this->db->update_batch('tb_penjualan_detail', $data_brg, 'kode_brg');

			$this->PenjualanModel->update($data_pen);
			$this->AngsuranModel->update($data_angsuran);
			redirect('penjualan','refresh');
		} else {
			# jenis pembayaran cash
			$data_pen = (object) array(
				'kode_penjualan' => $this->PenjualanModel->getDataEdit($id)->kode_penjualan,
				'kode_pelanggan' => $this->input->post('kode_pel', TRUE),
				'jenis_pembayaran' => $this->input->post('jenis_pem', TRUE),
				'bonus' => $this->input->post('bn', TRUE),
				'jumlah_produk' => $this->input->post('jml', TRUE),
				'harga' => $this->input->post('hrg', TRUE),
				'total_brg' => $this->input->post('total_brg', TRUE),
				'dp_pembayaran' => $this->input->post('byr', TRUE),
				'sisa_pembayaran' => $this->input->post('sisa_byr', TRUE),
				'tanggal_transaksi' => $this->input->post('tgl', TRUE),
				'kode_karyawan' => $this->input->post('kode_kar', TRUE),
				'ket' => 'LUNAS'
			);
			$data_angsuran = (object) array(
				'kode_angsuran' => $this->AngsuranModel->getAngsuran($id)[0]->kode_angsuran,
				'kode_penjualan' => $this->PenjualanModel->getDataEdit($id)->kode_penjualan,
				'januari' => $val = ($bulan_indo == 'januari') ? $byr : NULL,
				'februari' => $val = ($bulan_indo == 'februari') ? $byr : NULL,
				'maret' => $val = ($bulan_indo == 'maret') ? $byr : NULL,
				'april' => $val = ($bulan_indo == 'april') ? $byr : NULL,
				'mei' => $val = ($bulan_indo == 'mei') ? $byr : NULL,
				'juni' => $val = ($bulan_indo == 'juni') ? $byr : NULL,
				'juli' => $val = ($bulan_indo == 'juli') ? $byr : NULL,
				'agustus' => $val = ($bulan_indo == 'agustus') ? $byr : NULL,
				'september' => $val = ($bulan_indo == 'september') ? $byr : NULL,
				'oktober' => $val = ($bulan_indo == 'oktober') ? $byr : NULL,
				'november' => $val = ($bulan_indo == 'november') ? $byr : NULL,
				'desember' => $val = ($bulan_indo == 'desember') ? $byr : NULL
			);
			$data_brg = [];
			
			$kode_pen 	= $this->PenjualanModel->getDataEdit($id)->kode_penjualan;
			$kode_brg_qr 	= $this->db->query("SELECT * FROM tb_penjualan_detail WHERE kode_penjualan='$id'")->result();
			$kodebrg 	= $_POST['kode_brg'];
			$qty 		= $_POST['qty'];
			$harga_pcs 	= $_POST['harga_pcs'];
			$new_bn 	= (int) $_POST['bn'];
			$old_bn		= (int) $this->PenjualanModel->getDataEdit($id)->bonus;

			$index=0;
			foreach ($kodebrg as $key) {
				//var_dump($key);
				array_push($data_brg, array(
					'kode_penjualan' => $kode_pen,
					'kode_brg' => $key,
					'qty' => $qty[$index],
				));

				$val = null;

				if ($new_bn > $old_bn){
					$val = $new_bn - $old_bn;
					$this->BarangModel->updateDataStok($val, $key);
				} else {
					$val = $old_bn - $new_bn;
					$val = -$val;
					$this->BarangModel->updateDataStok($val, $key);
				}

				
				foreach ($kode_brg_qr as $value) {
					if ($key !== $value->kode_brg) {
						
						// break;
						$checkData = $this->db->query("SELECT EXISTS(SELECT * FROM tb_penjualan_detail WHERE kode_penjualan='$id' AND kode_brg='$key') as data")->row();
						var_dump($key .' !== '.$value->kode_brg, $checkData->data);
						if ($checkData->data > 0) {
							echo "Data Sudah Ada, Maka ".$value->kode_brg . ' Dihapus';
							$this->db->query("DELETE FROM tb_penjualan_detail WHERE kode_penjualan='$id' AND kode_brg='$value->kode_brg'");
						} else {
							$this->db->query("INSERT INTO tb_penjualan_detail (kode_penjualan, kode_brg, qty) VALUES ('$id', '$key', '$qty[$index]')");
							echo "Data Tidak Ada";
						}
					}
					break;
				}
				// $this->BarangModel->updateDataStok($qty[$index], $key);
				$index++;
			}
			// $data_brg[] = $data_brg;
			// var_dump($data_pen);
			//$this->db->update_batch('tb_penjualan_detail', $data_brg, 'kode_brg');
			$this->PenjualanModel->update($data_pen);
			$this->AngsuranModel->update($data_angsuran);
			redirect('penjualan','refresh');
		}
	}

	public function edit($id)
	{
		$data['data'] = $this->PenjualanModel->getDataEdit($id);
		$data['pelanggan'] = $this->PelangganModel->getPelanggan($data['data']->kode_pelanggan);
		$data['penjualan_detail'] = $this->db->get_where('tb_penjualan_detail', array('kode_penjualan' => $id))->result();
		$data['karyawan'] = $this->KaryawanModel->getAllData();
		$data['barang'] = $this->BarangModel->getAllData();
		// $data['barang'] = $this->BarangModel->getData($id);
		// var_dump($data['penjualan_detail'][0]);
		$this->load->view('admin/penjualan_edit', $data);

	}

	public function rekap()
	{
		
		$data['data'] = $this->PenjualanModel->getAllData();
		$data['controller'] = $this;
		$this->load->view('admin/rekap_view', $data);
	}

	public function checkDataSevenMonth($tgl, $kode_pel){
		//CEK DATA 6 BULAN KE DEPAN
		$sql = $this->db->query("SELECT SUM(jumlah_produk) as jml,
			tanggal_transaksi,
			DATE_SUB('$tgl', INTERVAL -6 MONTH) 
			FROM tb_penjualan WHERE kode_pelanggan='$kode_pel'
			AND tb_penjualan.tanggal_transaksi BETWEEN  '$tgl'
			AND DATE_SUB('$tgl', INTERVAL -6 MONTH)
			GROUP BY tb_penjualan.tanggal_transaksi
			ORDER BY `tb_penjualan`.`tanggal_transaksi` ASC");

        if ($sql->num_rows() > 1) { // JIKA ADA TRANSAKSI BARU DI 6 BULAN KEDAPAN
        	//ABAIKAN
        	echo '<svg xmlns="http://www.w3.org/2000/svg" fill="red" width="16" height="16" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
        	<path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
        	</svg>';
        } else { // JIKA TIDAK ADA TRANSAKSI DALAM JANGKA 6 BULAN KEDAPAN
        	//HITUNG & CEK LUNAS/BELUM
        	// echo '#eksekusi' . $sql->row()->jml;
        	// echo '#param' . $kode_pel . $tgl;
        	$qry = $this->db->query("SELECT ket,
        		tanggal_transaksi as start_date,
        		DATE_SUB(tanggal_transaksi, INTERVAL -6 MONTH) as due_date
        		FROM tb_penjualan WHERE kode_pelanggan='$kode_pel' AND MONTH(tanggal_transaksi)=MONTH('$tgl') AND ket='BELUM'");
        	// echo 'STATUS' . $qry->num_rows();
        	if ($qry->num_rows() < 1) {
        		//HITUNG JUMLAH PRODUK 6 BULAN SEBELUNYA
        		$qry_count = $this->db->query("SELECT SUM(jumlah_produk) as jml, SUM(bonus) as bn,
        			tanggal_transaksi, ket,
        			DATE_SUB('$tgl', INTERVAL 6 MONTH) 
        			FROM tb_penjualan WHERE kode_pelanggan='$kode_pel'
        			AND tb_penjualan.tanggal_transaksi BETWEEN
        			DATE_SUB('$tgl', INTERVAL 6 MONTH) AND '$tgl' 
        			GROUP BY tb_penjualan.tanggal_transaksi
        			ORDER BY `tb_penjualan`.`tanggal_transaksi` ASC")->result();
        		// echo "string". $qry_count->row()->jml;
        		$count_jml=0;
        		$count_bn=0;
        		foreach ($qry_count as $key) {
        			$count_jml += $key->jml;
        			$count_bn += $key->bn;
        		}
        		
        		
        		if (date('Y-m') >= date('Y-m', strtotime('+6 months', strtotime($tgl)))){
        			//HITUNG JUMLAH PRODUK x BONUS PELANGGAN
        			//echo "SAMA ".date('Y-m', strtotime('+6 months', strtotime($tgl))) .'-'. date('2022-03'); 
        			
        			$hasil=0;
        			for ($i=1; $i <= $count_jml ; $i++) { 
        				if ($i %10==0) {
        					$bilangan=$count_jml;
        					$pembagi=10;
        					$sisaBagi=$bilangan%$pembagi;
        					$hasilBagi=($bilangan-$sisaBagi)/$pembagi;
        					$hasil += $sisaBagi;
        					// echo $bilangan." dibagi dengan ".$pembagi." adalah ".$hasilBagi." sisa ".$sisaBagi;
							// echo "Kelipatan 10 - " . $i . '<br>';

        				} else {
        					// $hasil += 1;
						// echo "bukan kelipatan 10 - "  . $i.'<br>';
        				}
        			}

        			if ($hasil !== 0) {
        				$hasil=$hasil;
        				echo '<button type="button" class="btn btn-sm p-1 bg-secondary text-white example-popover" data-container="body" data-toggle="popover" data-placement="right" data-content="'.$hasil .'x 12000 = '.($hasil*12000).'">
        			total: '.$count_jml.'
        			</button>';
        			} else { 
        				$hasil=$count_jml;
        				echo '<button type="button" class="btn btn-sm p-1 bg-secondary text-white example-popover" data-container="body" data-toggle="popover" data-placement="right" data-content="'.$hasil .'x 12000 = '.($hasil*12000).'">
        			total: '.$count_jml.'
        			</button>';
        			}
        			
        			
        		}
        		else{
        			// echo '<br>'.date('Y-m') .'<br>';
        			// echo "BEDA ".date('Y-m', strtotime('+6 months', strtotime($tgl) ) );
        		}

        	} else {
        		//BELUM LUNAS
        		echo 'sts: '.$qry->row()->ket;
        	}

        }
	}

	public function tagihan()
	{
		$kode_pen = $this->input->post('kode_pen', TRUE);
		$tgl_inv = $this->input->post('tgl', TRUE);
		$getMonth = date('m', strtotime($tgl_inv));

		if (!isset($kode_pen)) {
			$this->session->set_flashdata('danger','Anda Belum memilih data');
			return redirect('penjualan');
		}
		// var_dump($this->input->post('kode_pen', TRUE));
		$data = array();
		$index=0;
		foreach ($kode_pen as $key) {
			// echo $key . '<br>';
			$data[$index] = $this->PenjualanModel->getTagihan($key);

			$index++;
		}
		// var_dump($data[0][0]);	
		// echo "<br><br>";
		// var_dump($data[1][0]);	
		// echo "<br><br>";
		// var_dump($data[2][0]);
		// foreach ($data as $key) {
		// 	var_dump($key[0]->total_byr);
		// 	echo "<br><br>";
		// }

		$Pdf = new FPDF('l','mm','A5');
		$Pdf->AddPage();
		$Pdf->SetFont('Arial','',10);
        $Pdf->SetTextColor(0,0,0);
        $Pdf->SetY(5);
        $Pdf->SetX(10);
        $Pdf->Cell(190,7,'Tagihan Angsuran',0,1,'C');

        $Pdf->SetTextColor(0,0,0);
        $Pdf->SetFont('Arial','',16);
        // mencetak string
        $Pdf->Cell(190,15,'Berkah Abadi',1,1,'C');
        //$Pdf->Image(base_url('assets/icons/logo_apple.jpg'),40,12,12,10, 'JPG');
        $Pdf->SetFont('Arial','',10);
        $Pdf->SetTextColor(0,0,0);
        $Pdf->Cell(190,7,'Alamat Lengkap dengan nama jalan berserta kode pos wilayah - nomor hp/wa',0,1,'C');

        $Pdf->Cell(10,5,'',0,1);
        $Pdf->SetFont('Arial','',10);
        $Pdf->Cell(30,10,'Nama',0,0);
        $Pdf->Cell(40,10,': Bpk/Ibu ' . $data[0][0]->nama . ' (' . $data[0][0]->kode_pelanggan . ')' ,0,0);
        $Pdf->Cell(90,10,' Tgl Penagihan',0,0,'R');
        $Pdf->Cell(28,10,': '. $this->input->post('tgl', TRUE),0,1,'R');

        $Pdf->Cell(30,0,'Alamat',0,0);
        $Pdf->Cell(40,0,': ' . $data[0][0]->alamat,0,0);
        $Pdf->Cell(90,0,' Collector',0,0,'R');
        $Pdf->Cell(10,0,': ',0,1,'R');
        $Pdf->Cell(30,10,'Nomor Hp/WA',0,0);
        $Pdf->Cell(40,10,': ' .  $data[0][0]->hp,0,0);
        $Pdf->Cell(90,10,' ',0,0,'R');
        $Pdf->Cell(28,10,' ',0,0,'R');
        // Memberikan space kebawah agar tidak terlalu rapat
        $Pdf->Cell(10,10,'',0,1); 
        $Pdf->SetFont('Arial','B',10);
        $Pdf->SetFillColor(230,230,230);
        $Pdf->Cell(10,6,'No',1,0,'C',true);
        $Pdf->Cell(30,6,'Kode Penjualan',1,0,'C',true);
        $Pdf->Cell(15,6,'Sales',1,0,'C',true);
        // $Pdf->Cell(30,6,'Kode Brg',1,0,'C',true);
        $Pdf->Cell(30,6,'Nama Brg',1,0,'C',true);

        $Pdf->Cell(10,6,'Jml',1,0,'C',true);
        $Pdf->Cell(25,6,'Harga',1,0,'C',true);
        $Pdf->Cell(20,6,'Angsrn Ke',1,0,'C',true);
        $Pdf->Cell(25,6,'Sisa Angsrn',1,0,'C',true);
        $Pdf->SetX(175);
        $Pdf->Cell(25,6,'Sub Total',1,1,'C',true);
        $nomor=1;
        $angsuranke=0;
        $total_sisa=0;
        $total=0;
        $setPY=65;
        foreach ($data as $row){
        	$brg = $this->db->get_where('tb_penjualan_detail', array('kode_penjualan' => $row[0]->kode_penjualan))->result();

        	// $Pdf->SetY($setPY);
            $Pdf->Cell(10,6 *count($brg),$nomor++,1,0);
            $Pdf->Cell(30,6 *count($brg),$row[0]->kode_penjualan,1,0,'C');
            $Pdf->Cell(15,6 *count($brg),$row[0]->karyawan,1,0,'C');
            // $Pdf->SetX(120);
            // $Pdf->Cell(10,6,$row[0]->jml_produk,1,0,'C');
            if ($row[0]->A1 == NULL || $row[0]->A1 == 0) {
            	$angsuranke=1;
            	$Pdf->SetY($setPY);
            	$Pdf->SetX(120+10);

            	// $val = ($row[0]->A1_number <= $getMonth) ? (int) $getMonth-$row[0]->A1_number : (int) ($row[0]->A1_number+$getMonth)-$row[0]->A1_number;

				// $angsuranke += $val;
            	$Pdf->Cell(20,6 *count($brg),$angsuranke,1,0,'C');
            } elseif ($row[0]->A2 == NULL || $row[0]->A2 == 0) {
            	$angsuranke=2;
            	$Pdf->SetY($setPY);
            	$Pdf->SetX(120+10);

            	// $val = ($row[0]->A2_number <= $getMonth) ? (int) $getMonth-$row[0]->A2_number : (int) ($row[0]->A2_number+$getMonth)-$row[0]->A2_number;

				// $angsuranke += $val;
            	$Pdf->Cell(20,6*count($brg),$angsuranke,1,0,'C');
            } elseif ($row[0]->A3 == NULL || $row[0]->A3 == 0) {
            	$angsuranke=3;
            	$Pdf->SetY($setPY);
            	$Pdf->SetX(120+10);

            	// $val = ($row[0]->A3_number <= $getMonth) ? (int) $getMonth-$row[0]->A3_number : (int) ($row[0]->A3_number+$getMonth)-$row[0]->A3_number;

				// $angsuranke += $val;
            	$Pdf->Cell(20,6 *count($brg),$angsuranke,1,0,'C');
            } elseif ($row[0]->A4 == NULL || $row[0]->A4 == 0) {
            	$angsuranke=4;
            	$Pdf->SetY($setPY);
            	$Pdf->SetX(120+10);

            	// $val = ($row[0]->A4_number <= $getMonth) ? (int) $getMonth-$row[0]->A4_number : (int) ($row[0]->A4_number+$getMonth)-$row[0]->A4_number;

				// $angsuranke += $val;
            	$Pdf->Cell(20,6 *count($brg),$angsuranke,1,0,'C');
            } elseif ($row[0]->A5 == NULL || $row[0]->A5 == 0) {
            	$angsuranke=5;
            	$Pdf->SetY($setPY);
            	$Pdf->SetX(120+10);

            	// $val = ($row[0]->A5_number <= $getMonth) ? (int) $getMonth-$row[0]->A5_number : (int) ($row[0]->A5_number+$getMonth)-$row[0]->A5_number;

				// $angsuranke += $val;
            	$Pdf->Cell(20,6 *count($brg),$angsuranke,1,0,'C');
            } elseif ($row[0]->A6 == NULL || $row[0]->A6 == 0) {
            	$angsuranke=6;
            	$Pdf->SetY($setPY);
            	$Pdf->SetX(120+10);

            	// $val = ($row[0]->A6_number <= $getMonth) ? (int) $getMonth-$row[0]->A6_number : (int) ($row[0]->A6_number+$getMonth)-$row[0]->A6_number;

				// $angsuranke += $val;
            	$Pdf->Cell(20,6 *count($brg),$angsuranke,1,0,'C');
            } elseif ($row[0]->A7 == NULL || $row[0]->A7 == 0) {
            	$angsuranke=7;
            	$Pdf->SetY($setPY);
            	$Pdf->SetX(120+10);

            	// $val = ($row[0]->A7_number <= $getMonth) ? (int) $getMonth-$row[0]->A7_number : (int) ($row[0]->A7_number+$getMonth)-$row[0]->A7_number;

				// $angsuranke += $val;
            	$Pdf->Cell(20,6 *count($brg),$angsuranke,1,0,'C');
            } else {
            	$Pdf->SetY($setPY);
            	$Pdf->SetX(120);
            	$Pdf->Cell(20,6 *count($brg),' LUNAS ',1,0,'C');
            }

            if ($row[0]->A1 == NULL || $row[0]->A1 == 0) {
            	$Pdf->SetY($setPY);
            	$Pdf->SetX(150);
            	$Pdf->Cell(25,6 *count($brg), 7-$angsuranke .'x',1,0,'C');
            } elseif ($row[0]->A2 == NULL || $row[0]->A2 == 0) {
            	$Pdf->SetY($setPY);
            	$Pdf->SetX(150);
            	$Pdf->Cell(25,6 *count($brg), 7-$angsuranke .'x',1,1,'C');
            } elseif ($row[0]->A3 == NULL || $row[0]->A3 == 0) {
            	$Pdf->SetY($setPY);
            	$Pdf->SetX(150);
            	$Pdf->Cell(25,6 *count($brg), 7-$angsuranke .'x',1,0,'C');
            } elseif ($row[0]->A4 == NULL || $row[0]->A4 == 0) {
            	$Pdf->SetY($setPY);
            	$Pdf->SetX(150);
            	$Pdf->Cell(25,6 *count($brg), 7-$angsuranke .'x',1,0,'C');
            } elseif ($row[0]->A5 == NULL || $row[0]->A5 == 0) {
            	$Pdf->SetY($setPY);
            	$Pdf->SetX(150);
            	$Pdf->Cell(25,6 *count($brg), 7-$angsuranke .'x',1,0,'C');
            } elseif ($row[0]->A6 == NULL || $row[0]->A6 == 0) {
            	$Pdf->SetY($setPY);
            	$Pdf->SetX(150);
            	$Pdf->Cell(25,6 *count($brg), 7-$angsuranke .'x',1,0,'C');
            } elseif ($row[0]->A7 == NULL || $row[0]->A7 == 0) {
            	$Pdf->SetY($setPY);
            	$Pdf->SetX(150);
            	$Pdf->Cell(25,6 *count($brg), 7-$angsuranke .'x',1,0,'C');
            } else {
            	$Pdf->SetY($setPY);
            	$Pdf->SetX(150);
            	$Pdf->Cell(25,6 *count($brg),' LUNAS ',1,0,'C');
            }
            
            // $kode_pjl = $row[0]->kode_penjualan;
            // $brg = $this->db->query("SELECT tb_penjualan_detail.kode_brg, tb_penjualan_detail.qty, tb_barang.harga_pcs, tb_barang.nama_brg,
            // 	tb_penjualan_detail.qty*tb_barang.harga_pcs as sub_total
            // 	FROM tb_penjualan_detail, tb_barang WHERE 
            // 	tb_penjualan_detail.kode_penjualan='$kode_pjl' AND 
            // 	tb_penjualan_detail.kode_brg=tb_barang.kode_brg")->result();
            // $Pdf->SetY($setPY);
            foreach ($brg as $key) {
            	// $Pdf->Cell(10,6, '',1,0,'C');
            	// $Pdf->Cell(35,6,' ',1,0,'C');
            	// $Pdf->SetY($setBrgY);
            	$Pdf->SetY($setPY);
            	$Pdf->SetX(55+10);
            	// $Pdf->Cell(30,6,$key->kode_brg,1,0,'C');
            	$Pdf->Cell(30,6,$this->BarangModel->getData($key->kode_brg)->nama_brg,1,0,'C');
            	$Pdf->Cell(10,6,$key->qty,1,0,'C');
            	$Pdf->Cell(25,6,'Rp. '.number_format($this->BarangModel->getData($key->kode_brg)->harga_pcs),1,0,'L');

            	$Pdf->SetX(175);
            	$harga_per_angsuran=$key->qty*$this->BarangModel->getData($key->kode_brg)->harga_pcs;
				$total_angsuran=$angsuranke*$harga_per_angsuran-$row[0]->total_angsuran;

            	// $Pdf->Cell(25,6,'Rp. '.number_format((float) $total_angsuran),1,1,'L');
            	$Pdf->Cell(25,6,'Rp. '.number_format((float) $key->qty*$this->BarangModel->getData($key->kode_brg)->harga_pcs),1,1,'L');
            	$total += $key->qty*$this->BarangModel->getData($key->kode_brg)->harga_pcs;
            	// $total += $total_angsuran;
            	// $total += $total;
            	$setPY += 6;
            	// $Pdf->Cell(30,10,$this->BarangModel->getData($key->kode_brg)->harga_pcs,0,1,'C');
            }
            
            // $Pdf->Cell(32,40,$this->rupiah($row->qty*$row->harga),1,1,'C');
            // $Pdf->Cell(15,6,$row->tinggi,1);
            // $Pdf->Cell(25,6,$row->tanggal_lahir,1,1); 
            
        }
        $Pdf->Cell(140,6,' ',1,0,'C',true);
        $Pdf->Cell(25,6,'Total',1,0,'C',true);
        $Pdf->Cell(25,6,'Rp. '. number_format($total),1,1,'L',true);

        //Tanda Terima
        $setKetY=0;
        $Pdf->SetY($setPY+(3*3));
        $Pdf->Cell(10,6,' ',0,0,'C',False);
        $Pdf->Cell(35,6,'Collector',0,0,'C',False);
        $Pdf->Cell(30,6,'',0,0,'L',False);
        $Pdf->Cell(35,6,'Pelanggan',0,1,'C',False);

        $Pdf->SetY($setPY+(5*5));
        $Pdf->Cell(10,6,' ',0,0,'C',False);
        $Pdf->Cell(35,6,'(....................)',0,0,'C',False);
        $Pdf->Cell(30,6,'',0,0,'L',False);
        $Pdf->Cell(35,6,'(....................)',0,1,'C',False);

        //KETERANGAN
        $Pdf->SetY($setPY+(3*3));
        $Pdf->SetX(122);
        $Pdf->Cell(35,6,'KETERANGAN:','L,T',0,'C',False);
        $Pdf->Cell(42,6,'','T,R',1,'L',False);

        $Pdf->SetX(122);
        $Pdf->Cell(77,15,'','B,L,R',0,'L',False);


		$Pdf->Output('');

		// $brg = $this->db->get_where('tb_penjualan_detail', array('kode_penjualan' => 'PJL20082021-001'))->result();
		// foreach ($brg as $key) {
		// 	var_dump($key->kode_brg);
		// }
	}

	public function tagihanmore(){
		$kode_pen = $this->input->post('kode_pen', TRUE);
		$tgl_inv = $this->input->post('tgl', TRUE);

		if (!isset($kode_pen)) {
			$this->session->set_flashdata('danger','Anda Belum memilih data');
			return redirect('penjualan');
		}
		// var_dump($this->input->post('kode_pen', TRUE));
		$Pdf = new FPDF('l','mm','A5');
		$data = array();
		$index=0;
		foreach ($kode_pen as $key) {
			// echo $key . '<br>';
			$data[$index] = $this->PenjualanModel->getTagihan($key);
			// var_dump($data[$index][0]->kode_penjualan); 

			$Pdf->AddPage();
			$Pdf->SetFont('Arial','',10);
			$Pdf->SetTextColor(0,0,0);
			$Pdf->SetY(5);
			$Pdf->SetX(10);
			$Pdf->Cell(190,7,'Tagihan Angsuran',0,1,'C');

			$Pdf->SetTextColor(0,0,0);
			$Pdf->SetFont('Arial','',16);
        // mencetak string
			$Pdf->SetFillColor(0,0,0);
			$Pdf->Cell(190,15,'Berkah Abadi',1,1,'C');
        //$Pdf->Image(base_url('assets/icons/logo_apple.jpg'),40,12,12,10, 'JPG');
			$Pdf->SetFont('Arial','',10);
			$Pdf->SetTextColor(0,0,0);
			$Pdf->Cell(190,7,'Alamat Lengkap dengan nama jalan berserta kode pos wilayah - nomor hp/wa',0,1,'C');

			$Pdf->Cell(10,5,'',0,1);
			$Pdf->SetFont('Arial','',10);
			$Pdf->Cell(30,10,'Nama',0,0);
			$Pdf->Cell(40,10,': Bpk/Ibu ' . $data[$index][0]->nama . ' (' . $data[$index][0]->kode_pelanggan . ')' ,0,0);
			$Pdf->Cell(90,10,' Tgl Penagihan',0,0,'R');
			$Pdf->Cell(28,10,': '. $tgl_inv,0,1,'R');

			$Pdf->Cell(30,0,'Alamat',0,0);
			$Pdf->Cell(40,0,': ' . $data[$index][0]->alamat,0,0);
			$Pdf->Cell(90,0,' Collector',0,0,'R');
			$Pdf->Cell(10,0,': ',0,1,'R');
			$Pdf->Cell(30,10,'Nomor Hp/WA',0,0);
			$Pdf->Cell(40,10,': ' .  $data[$index][0]->hp,0,0);
			$Pdf->Cell(90,10,' ',0,0,'R');
			$Pdf->Cell(28,10,' ',0,0,'R');
        // Memberikan space kebawah agar tidak terlalu rapat
			$Pdf->Cell(10,10,'',0,1); 
			$Pdf->SetFont('Arial','B',10);
			$Pdf->SetFillColor(230,230,230);
			$Pdf->Cell(10,6,'No',1,0,'C',true);
			$Pdf->Cell(30,6,'Kode Penjualan',1,0,'C',true);
			$Pdf->Cell(15,6,'Sales',1,0,'C',true);
        // $Pdf->Cell(30,6,'Kode Brg',1,0,'C',true);
			$Pdf->Cell(30,6,'Nama Brg',1,0,'C',true);

			$Pdf->Cell(10,6,'Jml',1,0,'C',true);
			$Pdf->Cell(25,6,'Harga',1,0,'C',true);
			$Pdf->Cell(20,6,'Angsrn Ke',1,0,'C',true);
			$Pdf->Cell(25,6,'Sisa Angsrn',1,0,'C',true);
			$Pdf->SetX(175);
			$Pdf->Cell(25,6,'Sub Total',1,1,'C',true);
			$nomor=1;
			$angsuranke=0;
			$total_sisa=0;
			$total=0;
			$setPY=65;
			$getMonth = date('m', strtotime($tgl_inv));
			
			$brg = $this->db->get_where('tb_penjualan_detail', array('kode_penjualan' => $data[$index][0]->kode_penjualan))->result();

        	// $Pdf->SetY($setPY);
			$Pdf->Cell(10,6 *count($brg),$nomor++,1,0);
			$Pdf->Cell(30,6 *count($brg),$data[$index][0]->kode_penjualan,1,0,'C');
			$Pdf->Cell(15,6 *count($brg),$data[$index][0]->karyawan,1,0,'C');
            // $Pdf->SetX(120);
            // $Pdf->Cell(10,6,$row[0]->jml_produk,1,0,'C');
			if ($data[$index][0]->A1 == NULL || $data[$index][0]->A1 == 0) {
				$angsuranke=1;
				$Pdf->SetY($setPY);
				$Pdf->SetX(120+10);

				// $val = ($data[$index][0]->A1_number <= $getMonth) ? (int) $getMonth-$data[$index][0]->A1_number : (int) ($data[$index][0]->A1_number+$getMonth)-$data[$index][0]->A1_number;

				// $angsuranke += $val;
				$Pdf->Cell(20,6 *count($brg),$angsuranke,1,0,'C');
			} elseif ($data[$index][0]->A2 == NULL || $data[$index][0]->A2 == 0) {
				$angsuranke=2;
				$Pdf->SetY($setPY);
				$Pdf->SetX(120+10);

				// $val = ($data[$index][0]->A2_number <= $getMonth) ? (int) $getMonth-$data[$index][0]->A2_number : (int) ($data[$index][0]->A2_number+$getMonth)-$data[$index][0]->A2_number;

				// $angsuranke += $val;
				$Pdf->Cell(20,6*count($brg),$angsuranke ,1,0,'C');
			} elseif ($data[$index][0]->A3 == NULL || $data[$index][0]->A3 == 0) {
				$angsuranke=3;
				$Pdf->SetY($setPY);
				$Pdf->SetX(120+10);

				// $val = ($data[$index][0]->A3_number <= $getMonth) ? (int) $getMonth-$data[$index][0]->A3_number : (int) ($data[$index][0]->A3_number+$getMonth)-$data[$index][0]->A3_number;

				// $angsuranke += $val;
				$Pdf->Cell(20,6 *count($brg),$angsuranke,1,0,'C');
			} elseif ($data[$index][0]->A4 == NULL || $data[$index][0]->A4 == 0) {
				$angsuranke=4;
				$Pdf->SetY($setPY);
				$Pdf->SetX(120+10);
				// if (8 < 10) ? 18-8=2
				// if (12 > 2) ? (12+2)-12=2
				// $val = ($data[$index][0]->A4_number <= $getMonth) ? (int) $getMonth-$data[$index][0]->A4_number : (int) ($data[$index][0]->A4_number+$getMonth)-$data[$index][0]->A4_number;

				// $angsuranke += $val;
				$Pdf->Cell(20,6 *count($brg),$angsuranke,1,0,'C');
			} elseif ($data[$index][0]->A5 == NULL || $data[$index][0]->A5 == 0) {
				$angsuranke=5;
				$Pdf->SetY($setPY);
				$Pdf->SetX(120+10);

				// $val = ($data[$index][0]->A5_number <= $getMonth) ? (int) $getMonth-$data[$index][0]->A5_number : (int) ($data[$index][0]->A5_number+$getMonth)-$data[$index][0]->A5_number;

				// $angsuranke += $val;
				$Pdf->Cell(20,6 *count($brg),$angsuranke,1,0,'C');
			} elseif ($data[$index][0]->A6 == NULL || $data[$index][0]->A6 == 0) {
				$angsuranke=6;
				$Pdf->SetY($setPY);
				$Pdf->SetX(120+10);

				// $val = ($data[$index][0]->A6_number <= $getMonth) ? (int) $getMonth-$data[$index][0]->A6_number : (int) ($data[$index][0]->A6_number+$getMonth)-$data[$index][0]->A6_number;

				// $angsuranke += $val;
				$Pdf->Cell(20,6 *count($brg),$angsuranke,1,0,'C');
			} elseif ($data[$index][0]->A7 == NULL || $data[$index][0]->A7 == 0) {
				$angsuranke=7;
				$Pdf->SetY($setPY);
				$Pdf->SetX(120+10);

				// $val = ($data[$index][0]->A7_number <= $getMonth) ? (int) $getMonth-$data[$index][0]->A7_number : (int) ($data[$index][0]->A7_number+$getMonth)-$data[$index][0]->A7_number;

				// $angsuranke += $val;
				$Pdf->Cell(25,6 *count($brg),$angsuranke,1,0,'C');
			} else {
				$Pdf->SetY($setPY);
				$Pdf->SetX(120+10);
				$Pdf->Cell(25,6 *count($brg),' LUNAS ',1,0,'C');
			}

			if ($data[$index][0]->A1 == NULL || $data[$index][0]->A1 == 0) {
				$Pdf->SetY($setPY);
				$Pdf->SetX(150);
				$Pdf->Cell(25,6 *count($brg), 7-$angsuranke .'x',1,0,'C');
			} elseif ($data[$index][0]->A2 == NULL || $data[$index][0]->A2 == 0) {
				$Pdf->SetY($setPY);
				$Pdf->SetX(150);
				$Pdf->Cell(25,6 *count($brg), 7-$angsuranke .'x',1,0,'C');
			} elseif ($data[$index][0]->A3 == NULL || $data[$index][0]->A3 == 0) {
				$Pdf->SetY($setPY);
				$Pdf->SetX(150);
				$Pdf->Cell(25,6 *count($brg), 7-$angsuranke .'x',1,0,'C');
			} elseif ($data[$index][0]->A4 == NULL || $data[$index][0]->A4 == 0) {
				$Pdf->SetY($setPY);
				$Pdf->SetX(150);
				$Pdf->Cell(25,6 *count($brg), 7-$angsuranke .'x',1,0,'C');
			} elseif ($data[$index][0]->A5 == NULL || $data[$index][0]->A5 == 0) {
				$Pdf->SetY($setPY);
				$Pdf->SetX(150);
				$Pdf->Cell(25,6 *count($brg), 7-$angsuranke .'x',1,0,'C');
			} elseif ($data[$index][0]->A6 == NULL || $data[$index][0]->A6 == 0) {
				$Pdf->SetY($setPY);
				$Pdf->SetX(150);
				$Pdf->Cell(25,6 *count($brg), 7-$angsuranke .'x',1,0,'C');
			} elseif ($data[$index][0]->A7 == NULL || $data[$index][0]->A7 == 0) {
				$Pdf->SetY($setPY);
				$Pdf->SetX(150);
				$Pdf->Cell(25,6 *count($brg), 7-$angsuranke .'x',1,0,'C');
			} else {
				$Pdf->SetY($setPY);
				$Pdf->SetX(150);
				$Pdf->Cell(25,6 *count($brg),'LUNAS ',1,0,'C');
			}

            // $kode_pjl = $row[0]->kode_penjualan;
            // $brg = $this->db->query("SELECT tb_penjualan_detail.kode_brg, tb_penjualan_detail.qty, tb_barang.harga_pcs, tb_barang.nama_brg,
            // 	tb_penjualan_detail.qty*tb_barang.harga_pcs as sub_total
            // 	FROM tb_penjualan_detail, tb_barang WHERE 
            // 	tb_penjualan_detail.kode_penjualan='$kode_pjl' AND 
            // 	tb_penjualan_detail.kode_brg=tb_barang.kode_brg")->result();
            // $Pdf->SetY($setPY);
			foreach ($brg as $key) {
            	// $Pdf->Cell(10,6, '',1,0,'C');
            	// $Pdf->Cell(35,6,' ',1,0,'C');
            	// $Pdf->SetY($setBrgY);
				$Pdf->SetY($setPY);
				$Pdf->SetX(55+10);
            	// $Pdf->Cell(30,6,$key->kode_brg,1,0,'C');
				$Pdf->Cell(30,6,$this->BarangModel->getData($key->kode_brg)->nama_brg,1,0,'C');
				$Pdf->Cell(10,6,$key->qty,1,0,'C');
				$Pdf->Cell(25,6,'Rp. '.number_format($this->BarangModel->getData($key->kode_brg)->harga_pcs),1,0,'L');

				$Pdf->SetX(175);
				$harga_per_angsuran=$key->qty*$this->BarangModel->getData($key->kode_brg)->harga_pcs;
				$total_angsuran=$angsuranke*$harga_per_angsuran-$data[$index][0]->total_angsuran;

				// $Pdf->Cell(25,6,'Rp. '.number_format((float) $total_angsuran),1,1,'L');
				$Pdf->Cell(25,6,'Rp. '.number_format((float) $key->qty*$this->BarangModel->getData($key->kode_brg)->harga_pcs),1,1,'L');
				$total += $key->qty*$this->BarangModel->getData($key->kode_brg)->harga_pcs;
				// $total += $total_angsuran;
            	// $total += $total;
				$setPY += 6;
            	// $Pdf->Cell(30,10,$this->BarangModel->getData($key->kode_brg)->harga_pcs,0,1,'C');
			}

            // $Pdf->Cell(32,40,$this->rupiah($row->qty*$row->harga),1,1,'C');
            // $Pdf->Cell(15,6,$row->tinggi,1);
            // $Pdf->Cell(25,6,$row->tanggal_lahir,1,1); 


			$Pdf->Cell(140,6,' ',1,0,'C',true);
			$Pdf->Cell(25,6,'Total',1,0,'C',true);
			$Pdf->Cell(25,6,'Rp. '. number_format($total),1,1,'L',true);

        //Tanda Terima
			$setKetY=0;
			$Pdf->SetY($setPY+(3*3));
			$Pdf->Cell(10,6,' ',0,0,'C',False);
			$Pdf->Cell(35,6,'Collector',0,0,'C',False);
			$Pdf->Cell(30,6,'',0,0,'L',False);
			$Pdf->Cell(35,6,'Pelanggan',0,1,'C',False);

			$Pdf->SetY($setPY+(5*5));
			$Pdf->Cell(10,6,' ',0,0,'C',False);
			$Pdf->Cell(35,6,'(....................)',0,0,'C',False);
			$Pdf->Cell(30,6,'',0,0,'L',False);
			$Pdf->Cell(35,6,'(....................)',0,1,'C',False);

        //KETERANGAN
			$Pdf->SetY($setPY+(3*3));
			$Pdf->SetX(122);
			$Pdf->Cell(35,6,'KETERANGAN:','L,T',0,'C',False);
			$Pdf->Cell(42,6,'','T,R',1,'L',False);

			$Pdf->SetX(122);
			$Pdf->Cell(77,15,'','B,L,R',0,'L',False);
			$index++;
		}

		
		

        $Pdf->Output('');
	}

	public function pengiriman()
	{
		$tgl 		= $this->input->post('tgl', TRUE);
		$no_awal 	= (int) $this->input->post('no_awal', TRUE);
		$no_akhir	= (int) $this->input->post('no_akhir', TRUE);

		$month = (int) date("m",strtotime($tgl));
		$year = (int) date("Y",strtotime($tgl));

		// var_dump($month, $year);
		$Pdf = new FPDF('p','mm','A5');
		for ($i=$no_awal; $i <= $no_akhir; $i++) { 
			$kwitansi = $month . $year . '-' . $i;

			$Pdf->AddPage();
			$Pdf->SetFont('Arial','',10);
			$Pdf->SetTextColor(0,0,0);
			$Pdf->SetY(5);
			$Pdf->SetX(5);
			$Pdf->Cell(138,7,'BERKAH ABADI',0,1,'C');

       		// mencetak string
			$Pdf->SetX(5);
			$Pdf->SetTextColor(0,0,0);
			$Pdf->SetFont('Arial','',16);
			$Pdf->SetFillColor(0,0,0);
			$Pdf->Cell(138,15,'SURAT PENGIRIMAN BARANG ',1,1,'C');
        	//$Pdf->Image(base_url('assets/icons/logo_apple.jpg'),40,12,12,10, 'JPG');

			$Pdf->SetX(5);
			$Pdf->SetFont('Arial','',10);
			$Pdf->SetTextColor(0,0,0);
			$Pdf->Cell(30,10,'Nama',0,0);
			$Pdf->Cell(40,10,': ............................................................' ,0,0);
			$Pdf->Cell(35,10,'RT/RW',0,0,'R');
			$Pdf->Cell(40,10,': .............................',0,1,'L');

			$Pdf->SetX(5);
			$Pdf->Cell(30,0,'Alamat',0,0);
			$Pdf->Cell(40,0,': .............................................................',0,0);
			$Pdf->Cell(35,0,'Kel',0,0,'R');
			$Pdf->Cell(40,0,': .............................',0,1,'L');

			$Pdf->SetX(5);
			$Pdf->Cell(30,10,'Nomor Hp/WA',0,0);
			$Pdf->Cell(40,10,': ............................................................',0,0);
			$Pdf->Cell(35,10,'Kec',0,0,'R');
			$Pdf->Cell(40,10,': .............................',0,1,'L');

			$Pdf->SetX(5);
			$Pdf->Cell(30,5,'Nomor Kwitansi',0,0);
			$Pdf->Cell(40,5,': ' . $kwitansi,0,0);
			$Pdf->Cell(35,5,'Tgl',0,0,'R');
			$Pdf->Cell(40,5,': ........./......./...........',0,0,'L');
        	// Memberikan space kebawah agar tidak terlalu rapat
			$Pdf->Cell(10,10,'',0,1); 
			$Pdf->SetFont('Arial','B',10);
			$Pdf->SetFillColor(230,230,230);
			$Pdf->SetX(5);
			$Pdf->Cell(10,6,'No',1,0,'C',true);
			$Pdf->Cell(50,6,'NAMA BARANG',1,0,'C',true);
			$Pdf->Cell(10,6,'QTY',1,0,'C',true);
			$Pdf->Cell(30,6,'HARGA',1,0,'C',true);
			$Pdf->Cell(37,6,'SUB TOTAL',1,1,'C',true);

			for ($j=1; $j <= 5; $j++) { 
				$Pdf->SetX(5);
				$Pdf->Cell(10,6,$j,1,0,'C',false);
				$Pdf->Cell(50,6,'',1,0,'C',false);
				$Pdf->Cell(10,6,'',1,0,'C',false);
				$Pdf->Cell(30,6,'',1,0,'C',false);
				$Pdf->Cell(37,6,'',1,1,'C',false);
			}
			$Pdf->SetX(5);
			$Pdf->Cell(70,6,' ',0,0,'C',false);
			$Pdf->Cell(30,6,'Total',1,0,'C',false);
			$Pdf->Cell(37,6,'',1,1,'C',false);

        	//Tanda Terima
        	$Pdf->SetX(5);
        	$Pdf->SetFont('Arial','',10);
			$Pdf->Cell(35,6,'_____________________________________________________________________	',0,1,'L',False);
			
			$Pdf->SetX(5);
			$Pdf->Cell(35,6,'Pembayaran Diterima',0,1,'C',False);
			$Pdf->SetX(5);
			$Pdf->Cell(35,6,'Jumlah Setor Tunai',0,0,'L',False);
			$Pdf->Cell(5,6,':',0,0,'L',False);
			$Pdf->Cell(10,6,'.................................................................................................',0,1,'L',False);

			$Pdf->SetX(5);
			$Pdf->Cell(35,6,'Terbilang',0,0,'L',False);
			$Pdf->Cell(5,6,':',0,0,'L',False);
			$Pdf->Cell(10,6,'.................................................................................................',0,1,'L',False);

			$Pdf->SetX(5);
			$Pdf->Cell(35,6,'Angsuran Ke',0,0,'L',False);
			$Pdf->Cell(5,6,':',0,0,'L',False);
			$Pdf->Cell(15,6,'............',0,0,'L',False);
			$Pdf->Cell(25,6,'Sisa Angsuran',0,0,'L',False);
			$Pdf->Cell(5,6,':',0,0,'L',False);
			$Pdf->Cell(10,6,'............',0,1,'L',False);

			$Pdf->SetX(5);
			$Pdf->Cell(60,6,'Besar Nominal Angsuran per Bulan',0,0,'L',False);
			$Pdf->Cell(5,6,':',0,0);
			$Pdf->Cell(30,6,'.................................',0,0);
			$Pdf->Cell(22,6,'Setiap Tgl',0,0,'R',False);
			$Pdf->Cell(5,6,':',0,0);
			$Pdf->Cell(10,6,'.............',0,1,'L',False);
			$Pdf->SetX(104);
			$Pdf->Cell(10,5,'Untuk Bulan Berikutnya',0,1,'L',False);
			$Pdf->Cell(10,25,'',0,1,'L',False);

			$Pdf->SetX(5);
			$Pdf->Cell(35,6,'Sales',0,0,'C',False);
			$Pdf->Cell(30,6,'',0,0,'L',False);
			$Pdf->Cell(35,6,'Pelanggan',0,1,'C',False);
			$Pdf->Cell(35,6,'',0,1,'C',False);

			$Pdf->SetX(5);
			$Pdf->Cell(35,6,'(....................)',0,0,'C',False);
			$Pdf->Cell(30,6,'',0,0,'L',False);
			$Pdf->Cell(35,6,'(....................)',0,1,'C',False);
		}

        $Pdf->Output('I', 'cetak_pengiriman_'.$month . $year . '-' .$no_awal . '-' . $no_akhir);

	}

	public function cetak_penjualan($bSix=null)
	{
		if ($bSix == 'true') { // Cetak Penjualan Per 6 Bulan
			$tgl_awal 		= $this->input->post('tgl_awal', TRUE);
			$tgl_akhir 		= $this->input->post('tgl_akhir', TRUE);


			$data = $this->PenjualanModel->getDataBySixMonth($tgl_awal, $tgl_akhir);
			// var_dump($data[0]);
			$Pdf = new FPDF('l','mm','A4');
			$Pdf->AddPage();
			$Pdf->SetFont('Arial','',10);
			$Pdf->SetTextColor(0,0,0);
			$Pdf->SetY(5);
			$Pdf->SetX(5);
			$Pdf->Cell(288,7,'BERKAH ABADI',0,1,'C');

			// mencetak string
			$Pdf->SetX(5);
			$Pdf->SetTextColor(0,0,0);
			$Pdf->SetFont('Arial','',16);
			$Pdf->SetFillColor(0,0,0);
			$Pdf->Cell(288,15,'LAPORAN PENJUALAN ',1,1,'C');
        	//$Pdf->Image(base_url('assets/icons/logo_apple.jpg'),40,12,12,10, 'JPG');
			$Pdf->SetX(5);
			$Pdf->SetFont('Arial','',10);
			$Pdf->SetTextColor(0,0,0);
			$Pdf->Cell(30,10,'Laporan Penjualan : ' . $tgl_awal . '-' . $tgl_akhir,0,1);

			$Pdf->Cell(10,10,'',0,1); 
			$Pdf->SetFont('Arial','B',9);
			$Pdf->SetFillColor(230,230,230);
			$Pdf->SetTextColor(0,0,0);
			$Pdf->SetXY(5,40);
			$Pdf->Cell(10,6,'No',1,0,'C',true);
			$Pdf->Cell(30,6,'Nama',1,0,'C',true);
			$Pdf->Cell(40,6,'Alamat',1,0,'C',true);
			$Pdf->Cell(10,6,'Jns',1,0,'C',true);
			$Pdf->Cell(10,6,'Jml',1,0,'C',true);
			$Pdf->Cell(10,6,'BN',1,0,'C',true);
			$Pdf->Cell(30,6,'Harga',1,0,'C',true);
			$Pdf->Cell(30,6,'Total Brg',1,0,'C',true);
			$Pdf->Cell(30,6,'DP Pembayaran',1,0,'C',true);
			$Pdf->Cell(30,6,'Sisa Pembayaran',1,0,'C',true);
			$Pdf->Cell(25,6,'Tanggal',1,0,'C',true);
			$Pdf->Cell(30,6,'Status',1,1,'C',true);

			$nomor=1;
			$SetY=46;
			$SetLongColum=6;
			$total_jumlah=0;
			$total_bonus=0;
			$total_kredit_brg=0;
			$total_dp=0;
			$total_sisa=0;
			foreach ($data as $key) {
				$Pdf->SetX(5);
				$Pdf->Cell(10,$SetLongColum,$nomor++,1,0,'L',false);
				// $Pdf->SetXY(15,$SetY);
				$Pdf->Cell(30,$SetLongColum,$key->nama,1,0,'L',false);
				// $Pdf->SetXY(45,$SetY);
				$Pdf->Cell(40,$SetLongColum,substr($key->alamat, 0,20) . '...',1,0,'L',false);
				// $Pdf->SetXY(85,$SetY);
				$Pdf->Cell(10,$SetLongColum,$key->jenis_pembayaran,1,0,'C',false);
				// $Pdf->SetXY(95,$SetY);
				$Pdf->Cell(10,$SetLongColum,$key->jumlah_produk,1,0,'C',false);
				// $Pdf->SetXY(105,$SetY);
				$Pdf->Cell(10,$SetLongColum,$key->bonus,1,0,'C',false);
				
				$Pdf->SetFont('Arial','',8);
				$Pdf->Cell(30,$SetLongColum,'['.$key->harga.']',1,0,'L',false);
				// $Pdf->SetXY(145,$SetY);
				$Pdf->Cell(30,$SetLongColum,'Rp. ' .number_format((float) $key->total_brg),1,0,'L',false);
				// $Pdf->SetXY(175,$SetY);
				$Pdf->Cell(30,$SetLongColum,'Rp. ' .number_format((float) $key->dp_pembayaran),1,0,'C',false);

				$result = (int) $key->total_brg-(
					$key->januari+
					$key->februari+
					$key->maret+
					$key->april+
					$key->mei+
					$key->juni+
					$key->juli+
					$key->agustus+
					$key->september+
					$key->oktober+
					$key->november+
					$key->desember);

				$total_jumlah += (int) $key->jumlah_produk;
				$total_bonus += (int) $key->bonus;
				$total_kredit_brg += (int) $key->total_brg;
				$total_dp += (int) $key->dp_pembayaran;
				$total_sisa += (int) $result;

				$Pdf->Cell(30,$SetLongColum,'Rp. ' .number_format((float) $result),1,0,'L',false);
				// $Pdf->SetXY(235,$SetY);
				$Pdf->Cell(25,$SetLongColum,$key->tanggal_transaksi,1,0,'C',false);
				// $Pdf->SetXY(260,$SetY);
				$Pdf->Cell(30,$SetLongColum,$key->ket,1,1,'C',false);
				// $Pdf->Ln();
				// $SetY += 6;
			}

			$Pdf->SetX(5);
			$Pdf->Cell(90,$SetLongColum,'Total',1,0,'C',false);
			$Pdf->Cell(10,$SetLongColum,$total_jumlah,1,0,'C',false);
			$Pdf->Cell(10,$SetLongColum,$total_bonus,1,0,'C',false);
			$Pdf->Cell(30,$SetLongColum,'',1,0,'L',false);
			$Pdf->Cell(30,$SetLongColum,'Rp. ' .number_format((float) $total_kredit_brg),1,0,'L',false);
			$Pdf->Cell(30,$SetLongColum,'Rp. ' .number_format((float) $total_dp),1,0,'C',false);
			$Pdf->Cell(30,$SetLongColum,'Rp. ' .number_format((float) $total_sisa),1,0,'L',false);
			$Pdf->Cell(55,$SetLongColum,'',1,1,'C',false);


			$Pdf->Output('I', 'centak_penjualan_'. $tgl_awal .'-'.$tgl_akhir);
		} else {
			$tgl 		= $this->input->post('tgl', TRUE);

			$month = date("m",strtotime($tgl));
			$year = date("Y",strtotime($tgl));

			$data = $this->PenjualanModel->getDataByMonthYear($month, $year);
			// echo '<pre>';
			// var_dump(print_r($data));
			// echo '<pre>'; exit;
			$Pdf = new FPDF('l','mm','A4');
			$Pdf->AddPage();
			$Pdf->SetFont('Arial','',10);
			$Pdf->SetTextColor(0,0,0);
			$Pdf->SetY(5);
			$Pdf->SetX(5);
			$Pdf->Cell(288,7,'BERKAH ABADI',0,1,'C');

			// mencetak string
			$Pdf->SetX(5);
			$Pdf->SetTextColor(0,0,0);
			$Pdf->SetFont('Arial','',16);
			$Pdf->SetFillColor(0,0,0);
			$Pdf->Cell(288,15,'LAPORAN PENJUALAN ',1,1,'C');
        	//$Pdf->Image(base_url('assets/icons/logo_apple.jpg'),40,12,12,10, 'JPG');
			$Pdf->SetX(5);
			$Pdf->SetFont('Arial','',10);
			$Pdf->SetTextColor(0,0,0);
			$Pdf->Cell(30,10,'Laporan Penjualan Bulan ' . $this->bulan_indo($tgl . '-01', true, true),0,1);

			$Pdf->Cell(10,10,'',0,1); 
			$Pdf->SetFont('Arial','B',9);
			$Pdf->SetFillColor(230,230,230);
			$Pdf->SetTextColor(0,0,0);
			$Pdf->SetXY(5,40);
			$Pdf->Cell(10,6,'No',1,0,'C',true);
			$Pdf->Cell(30,6,'Nama',1,0,'C',true);
			$Pdf->Cell(40,6,'Alamat',1,0,'C',true);
			$Pdf->Cell(10,6,'Jns',1,0,'C',true);
			$Pdf->Cell(10,6,'Jml',1,0,'C',true);
			$Pdf->Cell(10,6,'BN',1,0,'C',true);
			$Pdf->Cell(30,6,'Harga',1,0,'C',true);
			$Pdf->Cell(30,6,'Total Brg',1,0,'C',true);
			$Pdf->Cell(30,6,'DP Pembayaran',1,0,'C',true);
			$Pdf->Cell(30,6,'Sisa Pembayaran',1,0,'C',true);
			$Pdf->Cell(25,6,'Tanggal',1,0,'C',true);
			$Pdf->Cell(30,6,'Status',1,1,'C',true);

			$nomor=1;
			$SetY=46;
			$SetLongColum=6;
			$total_jumlah=0;
			$total_bonus=0;
			$total_kredit_brg=0;
			$total_dp=0;
			$total_sisa=0;
			foreach ($data as $key) {
				$Pdf->SetX(5);
				$Pdf->Cell(10,$SetLongColum,$nomor++,1,0,'L',false);
				// $Pdf->SetXY(15,$SetY);
				$Pdf->Cell(30,$SetLongColum,$key->nama,1,0,'L',false);
				// $Pdf->SetXY(45,$SetY);
				$Pdf->Cell(40,$SetLongColum,substr($key->alamat, 0,20) . '...',1,0,'L',false);
				// $Pdf->SetXY(85,$SetY);
				$Pdf->Cell(10,$SetLongColum,$key->jenis_pembayaran,1,0,'C',false);
				// $Pdf->SetXY(95,$SetY);
				$total_jumlah += (int) $key->jumlah_produk;
				$Pdf->Cell(10,$SetLongColum,$key->jumlah_produk,1,0,'C',false);
				$total_bonus += (int) $key->bonus;
				$Pdf->Cell(10,$SetLongColum,$key->bonus,1,0,'C',false);
				// $Pdf->SetXY(115,$SetY);
				$Pdf->SetFont('Arial','',8);
				$Pdf->Cell(30,$SetLongColum,'['.$key->harga.']',1,0,'L',false);
				// $Pdf->SetXY(145,$SetY);
				$Pdf->SetFont('Arial','B',9);
				$total_kredit_brg += (int) $key->total_brg;
				$Pdf->Cell(30,$SetLongColum,'Rp. ' .number_format((float) $key->total_brg),1,0,'L',false);
				$total_dp += (int) $key->dp_pembayaran;
				$Pdf->Cell(30,$SetLongColum,'Rp. ' .number_format((float) $key->dp_pembayaran),1,0,'C',false);

				$result = (int) $key->total_brg-(
					$key->januari+
					$key->februari+
					$key->maret+
					$key->april+
					$key->mei+
					$key->juni+
					$key->juli+
					$key->agustus+
					$key->september+
					$key->oktober+
					$key->november+
					$key->desember);
				$total_sisa += (int) $result;
				$Pdf->Cell(30,$SetLongColum,'Rp. ' .number_format((float) $result),1,0,'L',false);
				// $Pdf->SetXY(235,$SetY);
				$Pdf->Cell(25,$SetLongColum,$key->tanggal_transaksi,1,0,'C',false);
				// $Pdf->SetXY(260,$SetY);
				$Pdf->Cell(30,$SetLongColum,$key->ket,1,1,'C',false);
				// $Pdf->Ln();
				$SetY += 6;
			}

			$Pdf->SetX(5);
			$Pdf->Cell(90,$SetLongColum,'Total',1,0,'C',false);
			$Pdf->Cell(10,$SetLongColum,$total_jumlah,1,0,'C',false);
			$Pdf->Cell(10,$SetLongColum,$total_bonus,1,0,'C',false);
			$Pdf->Cell(30,$SetLongColum,'',1,0,'L',false);
			$Pdf->Cell(30,$SetLongColum,'Rp. ' .number_format((float) $total_kredit_brg),1,0,'L',false);
			$Pdf->Cell(30,$SetLongColum,'Rp. ' .number_format((float) $total_dp),1,0,'C',false);
			$Pdf->Cell(30,$SetLongColum,'Rp. ' .number_format((float) $total_sisa),1,0,'L',false);
			$Pdf->Cell(55,$SetLongColum,'',1,1,'C',false);


			$Pdf->Output('I', 'centak_penjualan_'. $tgl);
		}
		
	}

	public function detail($id)
	{
		$data['data'] = $this->db->get_where('tb_penjualan_detail', array('kode_penjualan' => $id))->result();
		$this->load->view('admin/penjualan_detail', $data);

	}

	public function delete($id)
	{
		$url = base_url('penjualan');
		$data = $this->PenjualanModel->deleteData($id);
		if ($data[0]) {
			$this->session->set_flashdata('success','Data <span class="text-dark">[ '.$data[1].' - '.$data[2].' ]</span> Berhasil dihapus');
			redirect('penjualan','refresh');
		}
	}

	public function input_pembayaran($input_tgl, $input_pem)
	{
		$tgl = $input_tgl;
		$bulan = array (1 =>   'januari',
			2 => 'februari',
			3 => 'maret',
			4 => 'april',
			5 => 'mei',
			6 => 'juni',
			7 => 'juli',
			8 => 'agustus',
			9 => 'september',
			10 => 'oktober',
			11 => 'november',
			12 => 'desember'
		);
		$split 	  = explode('-', $tgl);
		$bulan_indo = $bulan[ (int)$split[1] ];
		
		// echo $bulan_indo;
		for ($i=1; $i <= count($bulan) ; $i++) { 
			# code...
			// echo $bulan[$i];
			// echo $bulan_indo;
			
			break;
		}
		// echo $bulan[8];
		// if ('januari' == 'januari')
		// 	echo "sama";
		// else
		// 	echo "tidak sama";
	}

	public function bonus()
	{
		date_default_timezone_set('Asia/Jakarta');
		$data['data'] = $this->PenjualanModel->getBonus('PEL00001','BELUM', '2021-08-30');
		// var_dump($data);
		$intMonth = (int) date("m",strtotime('2022-11-12'));
		$intDay = (int) date("d",strtotime('2022-11-12'));
		//echo "string " . $intMonth;
		// echo "string " . count($data['data']);

		$i=0;
		foreach ($data['data'] as $key) { 
			// echo $key->tgl_awal . '<br>';

			$start = new DateTime($key->tgl_awal);
			$end = new DateTime($key->tgl_akhir);

		// (D) MONTHLY INTERVAL
			$interval = new DateInterval("P1M");
			$range = new DatePeriod($start, $interval, $end);
			// var_dump($range);

			for($i = $start; $i <= $end; $i->modify('+1 month')){
				// echo $i->format("Y-m-d") . '<br>';
				$getMonth = (int) date("m",strtotime($i->format("Y-m-d")));

				if ($getMonth == $intMonth) {
					echo "tgl/bln " . $i->format("Y-m-d") . ' == ' . '2022-11-12 ';
					echo "True <br>"; 
				}else {
					echo "tgl/bln " . $i->format("Y-m-d") . ' !== ' . '2022-11-12 ';
					echo "False <br>";
				}

			}
			foreach ($range as $datemonth) {
				$getMonth = (int) date("m",strtotime($datemonth->format("Y-m-d")));
				$getDay = (int) date("d",strtotime($datemonth->format("Y-m-d")));
				// echo "bln " . $datemonth->format("Y-m-d") . '<br>	';
				// echo "post bln " . $intMonth . '<br>	';
				// if ($getMonth == $intMonth) {
				// 	echo "tgl/bln " . $datemonth->format("Y-m-d") . ' == ' . '2022-05-12 ';
				// 	echo "True <br>"; 
				// }else {
				// 	echo "tgl/bln " . $datemonth->format("Y-m-d") . ' !== ' . '2022-05-12 ';
				// 	echo "False <br>";
				// }
			}
			// break;
		}
	}

	public function count()
	{
		$kode_pel = $this->input->post('id');
		$tgl_pen  = $this->input->post('tgl');
		$jml_pcs  = (int) $this->input->post('jml');

		// var_dump($kode_pel);
		// exit();

		// $data['data'] = $this->PenjualanModel->getBonus($kode_pel,'BELUM', $tgl_pen);
		$data['data'] = $this->PenjualanModel->getBonus($kode_pel, $tgl_pen);
		$sum=0;
		$bonus_sebelumnya=0;
		foreach ($data['data'] as $key) {
			$sum += $key->jumlah_produk;
			$bonus_sebelumnya += $key->bonus;
			// echo $sum. ' <br>';
		}
		// echo 'sum ' .$sum;
		$sum += $jml_pcs;
		$bonus= (int) 0;
		for ($i=1; $i <= $sum ; $i++) { 
			if ($i %10==0) {
				$bonus += 1;
				// echo "Kelipatan 10 - " . $i . '<br>';

			} else {
			//echo "bukan kelipatan 10 - "  . $i.'<br>';
			}
		}
		// if ($bonus <= 0){
		// 	$bonus=$bonus;
		// } else {
		// 	for ($i=1; $i <= $sum ; $i++) { 
		// 		if ($i % 10 == 0){
		// 			$bonus += $bonus_sebelumnya;
		// 			$bonus = $bonus-$bonus_sebelumnya;
		// 		}
		// 	}
			
		// }
		
		
		$bonus = $bonus-$bonus_sebelumnya; // CODE SEBELUMNYA
		// echo "Bonus Produk " . $bonus . '<br>';
		$array = (object) array('bonus' => $bonus,
			'bonus_sebelumnya' => $bonus_sebelumnya,
			'sum' => $sum,
			'post' => (object) array('bonus' => $bonus,
				'kode_pel' => $kode_pel,
				'tgl_pen' => $tgl_pen,
				'jml_pcs' => $jml_pcs,
			),
		);

		// echo json_encode($data['data']);
		echo json_encode($array);
		
	}

	function bulan_indo($tanggal, $cetak_bulan = false, $cetak_tahun = false)
	{

		$bulan = array (1 =>   'Januari',
			2 => 'Februari',
			3 => 'Maret',
			4 => 'April',
			5 => 'Mei',
			6 => 'Juni',
			7 => 'Juli',
			8 => 'Agustus',
			9 => 'September',
			10 => 'Oktober',
			11 => 'November',
			12 => 'Desember'
		);
		$split 	  = explode('-', $tanggal);
		$bulan_indo = $bulan[ (int)$split[1] ];
		// return $bulan_indo;

		$format = ($cetak_tahun) ? $bulan_indo . ' - ' . date("Y",strtotime($tanggal)) : $bulan_indo;
		if ($cetak_bulan){
			if ($cetak_tahun) {
				return $format;
			}
			return $format;
		}
	}



}
