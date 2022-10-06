<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Angsuran extends CI_Controller {

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
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->model('PelangganModel');
		$this->load->model('PenjualanModel');
		$this->load->model('AngsuranModel');
	}

	public function index()
	{
		$bln = $this->input->post('bln', TRUE);
		$thn = $this->input->post('th', TRUE);
		$bFilter=null;

		if ($bln == '' || $thn == '') {
			$bFilter=false;
			$data['data'] = $this->AngsuranModel->getAllData();
			$data['isFilter'] = $bFilter;
			$data['isData'] = true;
		} else {
			$bFilter=true;
			$data['data'] = $this->AngsuranModel->getFilterData($bln, $thn);
			$data['isFilter'] = $bFilter;
			var_dump(count($data['data']));
			if (count($data['data']) == 0) {
				$data['isData'] = false;
			} else{
				$data['isData'] = true;
				$data['month'] = $this->range_month($data['data'][0]->tanggal_transaksi);
				$data['periode'] = $this->periode_month($data['data'][0]->tanggal_transaksi);
				$data['cetak_bulan'] = $this->bulan_indo($data['data'][0]->tanggal_transaksi, true);
			}
			
		}
		$this->load->view('admin/angsuran_view', $data);
	}

	public function detail($id)
	{
		$data['data'] = $this->AngsuranModel->getAngsuran($id);
		$data['month'] = $this->range_month($data['data'][0]->tanggal_transaksi);
		$data['periode'] = $this->periode_month($data['data'][0]->tanggal_transaksi);
		$data['cetak_bulan'] = $this->bulan_indo($data['data'][0]->tanggal_transaksi, true);
		
		$this->load->view('admin/angsuran_detail', $data);
	}

	public function input()
	{
		$data['data'] = $this->PelangganModel->getAllData();
		$this->load->view('admin/penjualan_input', $data);
	}

	public function edit($id)
	{
		$data['data'] = $this->AngsuranModel->editData($id);
		$data['month'] = $this->range_month($data['data']->tanggal_transaksi, true);
		$data['cetak_bulan'] = $this->bulan_indo($data['data']->tanggal_transaksi, true);

		// $this->form_validation->set_rules('ktpid', 'KTP', 'trim|required|numeric|max_length[50]');
		// $this->form_validation->set_rules('psiko', 'Psikotest', 'trim|required|numeric|max_length[2]');
		// $this->form_validation->set_rules('kes', 'Kesehatan', 'trim|required|numeric|max_length[2]');
		// $this->form_validation->set_rules('wawancara', 'Wawancara', 'trim|required|numeric|max_length[2]');

		// if ($this->form_validation->run() == FALSE) {
			$this->load->view('admin/angsuran_edit', $data);
		// } else {

		// }
	}

	public function update($id){
		$kode_pen 		= $this->input->post('kode_pen', TRUE);
		$kode_ang 		= $this->input->post('kode_ang', TRUE);
		$col 			= $this->input->post('col', TRUE);
		$sts 			= $this->input->post('sts', TRUE);

		$bln_jan 		= $this->input->post('jnr', TRUE);
		$bln_feb 		= $this->input->post('febr', TRUE);
		$bln_mar 		= $this->input->post('mar', TRUE);
		$bln_apr 		= $this->input->post('apr', TRUE);
		$bln_mei 		= $this->input->post('mei', TRUE);
		$bln_jun 		= $this->input->post('jun', TRUE);
		$bln_jul 		= $this->input->post('jul', TRUE);
		$bln_ags 		= $this->input->post('ags', TRUE);
		$bln_sep 		= $this->input->post('spt', TRUE);
		$bln_okt 		= $this->input->post('okt', TRUE);
		$bln_nov 		= $this->input->post('novb', TRUE);
		$bln_des 		= $this->input->post('desb', TRUE);

		$push_data = (object) array(
			'kode_angsuran' => $kode_ang,
			'kode_penjualan' => $kode_pen,
			'januari' => $bln_jan,
			'februari' => $bln_feb,
			'maret' => $bln_mar,
			'april' => $bln_apr,
			'mei' => $bln_mei,
			'juni' => $bln_jun,
			'juli' => $bln_jul,
			'agustus' => $bln_ags,
			'september' => $bln_sep,
			'oktober' => $bln_okt,
			'november' => $bln_nov,
			'desember' => $bln_des,
			'collector' => $col
		);
		$query = $this->AngsuranModel->update($push_data);
		$query = $this->PenjualanModel->updateStatus($kode_pen, $sts);
		if ($query)
			redirect('angsuran/detail/' . $kode_pen,'refresh');
		else 
			redirect('angsuran/detail/' . $kode_pen,'refresh');

		// var_dump($push_data);
	}

	public function cetak_angsuran()
	{
		$date = $this->input->post('tgl', TRUE) . '-01';

		$month = date("m",strtotime($date));
		$year = date("Y",strtotime($date));

		$data['data'] = $this->AngsuranModel->getFilterData($month, $year);

		// var_dump($data['periode']->bulan_mulai); exit();
		if (count($data['data']) > 0) {
			$data['month'] = $this->range_month($data['data'][0]->tanggal_transaksi);
			$data['periode'] = $this->periode_month($data['data'][0]->tanggal_transaksi);
			
			$Pdf = new FPDF('l','mm',array(210,330)); // F4
			$Pdf->AddPage();
			$Pdf->SetFont('Arial','',10);
			$Pdf->SetTextColor(0,0,0);
			$Pdf->SetY(5);
			$Pdf->SetX(5);
			$Pdf->Cell(321,7,'BERKAH ABADI',0,1,'C');

			// mencetak string
			$Pdf->SetX(5);
			$Pdf->SetTextColor(255,255,255);
			$Pdf->SetFont('Arial','',16);
			$Pdf->SetFillColor(0,0,0);
			$Pdf->Cell(321,15,'LAPORAN ANGSURAN ',1,1,'C',true);
        	//$Pdf->Image(base_url('assets/icons/logo_apple.jpg'),40,12,12,10, 'JPG');
			$Pdf->SetX(5);
			$Pdf->SetFont('Arial','',10);
			$Pdf->SetTextColor(0,0,0);
			$Pdf->Cell(30,10,'Laporan Penjualan : ' . $data['periode']->bulan_mulai .' - '. $data['periode']->bulan_akhir,0,1);

			$Pdf->Cell(10,10,'',0,1); 
			$Pdf->SetFont('Arial','B',9);
			$Pdf->SetFillColor(230,230,230);
			$Pdf->SetTextColor(0,0,0);
			$Pdf->SetY(40);
			$Pdf->SetX(5);
			$Pdf->Cell(5,12,'No',1,0,'C',true);
			$Pdf->Cell(20,12,'Tanggal',1,0,'C',true);
			$Pdf->Cell(30,12,'Kode Angsuran',1,0,'C',true);
			$Pdf->Cell(25,12,'Nama',1,0,'C',true);
			$Pdf->Cell(7,12,'Jns',1,0,'C',true);
			$Pdf->Cell(7,12,'Jml',1,0,'C',true);
			$Pdf->Cell(7,12,'BN',1,0,'C',true);
			$Pdf->Cell(25,12,'Total Brg',1,0,'C',true);
			$Pdf->Cell(20,6,'A1',1,0,'C',true);
			$Pdf->Cell(20,6,'A2',1,0,'C',true);
			$Pdf->Cell(20,6,'A3',1,0,'C',true);
			$Pdf->Cell(20,6,'A4',1,0,'C',true);
			$Pdf->Cell(20,6,'A5',1,0,'C',true);
			$Pdf->Cell(20,6,'A6',1,0,'C',true);
			$Pdf->Cell(20,6,'A7',1,0,'C',true);
			$Pdf->Cell(22,12,'Sisa',1,0,'C',true);
			$Pdf->Cell(18,12,'Col',1,0,'C',true);
			$Pdf->Cell(15,12,'Sts',1,1,'C',true);
			$Pdf->SetY(46);
			$Pdf->SetX(131);
			$data_bulan = array();
			foreach ($data['month'] as $bulan) {
				$_month = (int) date("m",strtotime($bulan->format("Y-m-d")));
				$_year = (int) date("y",strtotime($bulan->format("Y-m-d")));
				switch ($_month) {
					case 1:
					$Pdf->Cell(20,6,'JAN '. $_year,1,0,'C',true);
					$data_bulan[1]=1;
					break;
					case 2:
					$Pdf->Cell(20,6,'FEB '. $_year,1,0,'C',true);
					$data_bulan[2]=2;
					break;
					case 3:
					$Pdf->Cell(20,6,'MAR '. $_year,1,0,'C',true);
					$data_bulan[3]=3;
					break;
					case 4:
					$Pdf->Cell(20,6,'APR '. $_year,1,0,'C',true);
					$data_bulan[4]=4;
					break;
					case 5:
					$Pdf->Cell(20,6,'MEI '. $_year,1,0,'C',true);
					$data_bulan[5]=5;
					break;
					case 6:
					$Pdf->Cell(20,6,'JUN '. $_year,1,0,'C',true);
					$data_bulan[6]=6;
					break;
					case 7:
					$Pdf->Cell(20,6,'JUL '. $_year,1,0,'C',true);
					$data_bulan[7]=7;
					break;
					case 8:
					$Pdf->Cell(20,6,'AGS '. $_year,1,0,'C',true);
					$data_bulan[8]=8;
					break;
					case 9:
					$Pdf->Cell(20,6,'SEP '. $_year,1,0,'C',true);
					$data_bulan[9]=9;
					break;
					case 10:
					$Pdf->Cell(20,6,'OKT '. $_year,1,0,'C',true);
					$data_bulan[10]=10;
					break;
					case 11:
					$Pdf->Cell(20,6,'NOV '. $_year,1,0,'C',true);
					$data_bulan[11]=11;
					break;
					case 12:
					$Pdf->Cell(20,6,'DES '. $_year,1,0,'C',true);
					$data_bulan[12]=12;
					break;
				}
			}
			$setY=52;
			$nomor=1;
			$total_jumlah=0;
			$total_bonus=0;
			$total_kredit_brg=0;
			$total_sisa=0;

			$total_jan=0;
			$total_feb=0;
			$total_mar=0;
			$total_apr=0;
			$total_mei=0;
			$total_juni=0;
			$total_juli=0;
			$total_ags=0;
			$total_sep=0;
			$total_okt=0;
			$total_nov=0;
			$total_des=0;
			$Pdf->SetY($setY);
			foreach ($data['data'] as $key) {
				// var_dump($key); exit();
				// $Pdf->SetY($setY);
				
				$Pdf->SetX(5);
				
				$Pdf->SetTextColor(0,0,0);
				$Pdf->Cell(5,6,$nomor++,1,0,'C',false);
				$Pdf->Cell(20,6,$key->tanggal_transaksi,1,0,'C',false);
				$Pdf->Cell(30,6,$key->kode_angsuran,1,0,'L',false);
				$Pdf->Cell(25,6,substr($key->nama, 0,10) .'...',1,0,'L',false);
				$Pdf->Cell(7,6,$key->jenis_pembayaran,1,0,'C',false);
				$Pdf->Cell(7,6,$key->jumlah_produk,1,0,'C',false);
				$Pdf->Cell(7,6,$key->bonus,1,0,'C',false);
				$Pdf->Cell(25,6,'Rp. '.number_format((float) $key->total_brg),1,0,'L',false);
				foreach ($data_bulan as $bln) {
					switch ($bln) {
						case 1:
							$val = ($key->januari !== NULL) ? 'Rp. '.number_format((float) $key->januari) : $key->januari;
							$total_jan += $key->januari;
							$Pdf->Cell(20,6,$val,1,0,'L',false);
							break;
						case 2:
							$val = ($key->februari !== NULL) ? 'Rp. '.number_format((float) $key->februari) : $key->februari;
							$total_feb += $key->februari;
							$Pdf->Cell(20,6,$val,1,0,'L',false);
							break;
						case 3:
							$val = ($key->maret !== NULL) ? 'Rp. '.number_format((float) $key->maret) : $key->maret;
							$total_mar += $key->maret;
							$Pdf->Cell(20,6,$val,1,0,'L',false);
							break;
						case 4:
							$val = ($key->april !== NULL) ? 'Rp. '.number_format((float) $key->april) : $key->april;
							$total_apr += $key->april;
							$Pdf->Cell(20,6,$val,1,0,'L',false);
							break;
						case 5:
							$val = ($key->mei !== NULL) ? 'Rp. '.number_format((float) $key->mei) : $key->mei;
							$total_mei += $key->mei;
							$Pdf->Cell(20,6,$val,1,0,'L',false);
							break;
						case 6:
							$val = ($key->juni !== NULL) ? 'Rp. '.number_format((float) $key->juni) : $key->juni;
							$total_juni += $key->juni;
							$Pdf->Cell(20,6,$val,1,0,'L',false);
							break;
						case 7:
							$val = ($key->juli !== NULL) ? 'Rp. '.number_format((float) $key->juli) : $key->juli;
							$total_juli += $key->juli;
							$Pdf->Cell(20,6,$val,1,0,'L',false);
							break;
						case 8:
							$val = ($key->agustus !== NULL) ? 'Rp. '.number_format((float) $key->agustus) : $key->agustus;
							$total_ags += $key->agustus;
							$Pdf->Cell(20,6,$val,1,0,'L',false);
							break;
						case 9:
							$val = ($key->september !== NULL) ? 'Rp. '.number_format((float) $key->september) : $key->september;
							$total_sep += $key->september;
							$Pdf->Cell(20,6,$val,1,0,'L',false);
							break;
						case 10:
							$val = ($key->oktober !== NULL) ? 'Rp. '.number_format((float) $key->oktober) : $key->oktober;
							$total_okt += $key->oktober;
							$Pdf->Cell(20,6,$val,1,0,'L',false);
							break;
						case 11:
							$val = ($key->november !== NULL) ? 'Rp. '.number_format((float) $key->november) : $key->november;
							$total_nov += $key->november;
							$Pdf->Cell(20,6,$val,1,0,'L',false);
							break;
						case 12:
							$val = ($key->desember !== NULL) ? 'Rp. '.number_format((float) $key->desember) : $key->desember;
							$total_des += $key->desember;
							$Pdf->Cell(20,6,$val,1,0,'L',false);
							break;
					}
				}
				
				// $Pdf->Cell(20,6,'A2',1,0,'C',false);
				// $Pdf->Cell(20,6,'A2',1,0,'C',false);
				// $Pdf->Cell(20,6,'A2',1,0,'C',false);
				// $Pdf->Cell(20,6,'A2',1,0,'C',false);
				// $Pdf->Cell(20,6,'A2',1,0,'C',false);
				// $Pdf->Cell(20,6,'A2',1,0,'C',false);
				$total_jumlah += (int) $key->jumlah_produk;
				$total_bonus += (int) $key->bonus;
				$total_kredit_brg += (int) $key->total_brg;
				
				if ($key->jenis_pembayaran == 'C') {
					# code...
					$total_sisa += (int) $key->sisa_pembayaran;
					$Pdf->Cell(22,6,'Rp. '.number_format((float) $key->sisa_pembayaran),1,0,'L',false);
				} else {
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
					$Pdf->Cell(22,6,'Rp. '.number_format((float) $result),1,0,'L',false);
				}
				
				
				$Pdf->Cell(18,6,$key->collector,1,0,'C',false);
				$Pdf->Cell(15,6,$key->ket,1,1,'C');

				$setY += 6;
			}
			$Pdf->SetX(5);
			$Pdf->SetFillColor(230,230,230);
			$Pdf->SetTextColor(0,0,0);
			$Pdf->Cell(87,12,'Total',1,0,'C',true);
			$Pdf->Cell(7,12, $total_jumlah,1,0,'C',true);
			$Pdf->Cell(7,12,$total_bonus,1,0,'C',true);
			$Pdf->Cell(25,12,'Rp. '.number_format((float) $total_kredit_brg),1,0,'C',true);
			foreach ($data_bulan as $bln) {
				switch ($bln) {
					case 1:
						$Pdf->Cell(20,12,'Rp. '. number_format((float) $total_jan),1,0,'C',true);
						break;
					case 2:
						$Pdf->Cell(20,12,'Rp. '. number_format((float) $total_feb),1,0,'C',true);
						break;
					case 3:
						$Pdf->Cell(20,12,'Rp. '. number_format((float) $total_mar),1,0,'C',true);
						break;
					case 4:
						$Pdf->Cell(20,12,'Rp. '. number_format((float) $total_apr),1,0,'C',true);
						break;
					case 5:
						$Pdf->Cell(20,12,'Rp. '. number_format((float) $total_mei),1,0,'C',true);
						break;
					case 6:
						$Pdf->Cell(20,12,'Rp. '. number_format((float) $total_juni),1,0,'C',true);
						break;
					case 7:
						$Pdf->Cell(20,12,'Rp. '. number_format((float) $total_juli),1,0,'C',true);
						break;
					case 8:
						$Pdf->Cell(20,12,'Rp. '. number_format((float) $total_ags),1,0,'C',true);
						break;
					case 9:
						$Pdf->Cell(20,12,'Rp. '. number_format((float) $total_sep),1,0,'C',true);
						break;
					case 10:
						$Pdf->Cell(20,12,'Rp. '. number_format((float) $total_okt),1,0,'C',true);
						break;
					case 11:
						$Pdf->Cell(20,12,'Rp. '. number_format((float) $total_nov),1,0,'C',true);
						break;
					case 12:
						$Pdf->Cell(20,12,'Rp. '. number_format((float) $total_des),1,0,'C',true);
						break;
				}
			}
			$Pdf->Cell(22,12,'Rp. '.number_format((float) $total_sisa),1,0,'C',true);
			$Pdf->Cell(18+15,12,'',1,1,'C',true);

			$Pdf->Output('I');
		} else {
			echo "data Tidak ditemukan";
		}
		

		
	}

	public function range_month($data){
		$month = (int) date("m",strtotime($data));
	
		
		$mulai = new DateTime($data);
		$mulai->modify('+7 month'); // or you can use '-90 day' for deduct
		$akhir = $mulai->format('Y-m-d');
		// echo $akhir;

		// (A) START & END DATE
		$start = new DateTime($data);
		$end = new DateTime($akhir);

		// (D) MONTHLY INTERVAL
		$interval = new DateInterval("P1M");
		$range = new DatePeriod($start, $interval, $end);
		return $range;
		// foreach ($range as $date) {
		// 	$month = (int) date("m",strtotime($date->format("Y-m-d")));
		// 	echo $date->format("Y-m-d") . " => " . $month . " <br>";
		// }

	}

	public function periode_month($data){
		$mulai = new DateTime($data);
		$mulai->modify('+6 month'); // or you can use '-90 day' for deduct
		$akhir = $mulai->format('Y-m-d');
		// echo $akhir;

		$monthNumStart  = (int) date("m",strtotime($data));
		$dateObjStart   = DateTime::createFromFormat('!m', $monthNumStart);
		$monthNameStart = $dateObjStart->format('F'); // March

		$monthNumEnd  = (int) date("m",strtotime($akhir));
		$dateObjEnd   = DateTime::createFromFormat('!m', $monthNumEnd);
		$monthNameEnd = $dateObjEnd->format('F'); // March

		$arrayName = (object) array(
			'bulan_mulai' => $this->bulan_indo($data, true) . ' ' .date('y',strtotime($data)),
			'bulan_akhir' => $this->bulan_indo($akhir, true) . ' ' . date('y',strtotime($akhir))
		);

		return $arrayName;

		// echo "Periode : " . $monthNameStart . " " .date("y",strtotime($data)) . " - " .$monthNameEnd . " " . date("y",strtotime($akhir));
	}

	function tanggal_indo($tanggal, $cetak_hari = false)
	{
		$hari = array ( 1 =>    'Senin',
			2 => 'Selasa',
			3 => 'Rabu',
			4 => 'Kamis',
			5 => 'Jumat',
			6 => 'Sabtu',
			7 => 'Minggu'
		);

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
		$tgl_indo = $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];

		if ($cetak_hari) {
			$num = date('N', strtotime($tanggal));
			return $hari[$num] . ', ' . $tgl_indo;
		}
		return $tgl_indo;
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
