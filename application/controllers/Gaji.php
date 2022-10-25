<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gaji extends CI_Controller {

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
		$this->load->model('KaryawanModel');
		$this->load->model('PenjualanModel');
		$this->load->model('GajiModel');
	}

	public function index()
	{
		// $data['data'] = $this->GajiModel->getAllGaji();
		$data['karyawan'] = $this->KaryawanModel->getCustomData();
		// var_dump($data['data'][0]);
		// echo "<br><br>";
		// var_dump($data['data'][1]);
		// echo "<br><br>";
		// var_dump($data['data'][2]);
		$this->load->view('admin/gaji_view', $data);
	}

	public function ajax_get_gaji(){
		// if ($this->input->is_ajax_request()) {
			// $draw   = 1;
			// $start  = 0;
			// $length = 10;
			// $search = [];
			// $order  = [];

			$draw   = $this->input->post('draw');
			$start  = $this->input->post('start');
			$length = $this->input->post('length');
			$search = $this->input->post('search');
			$order  = $this->input->post('order');

			$json = $this->GajiModel->json_gaji($start, $length, $search['value'], $order[0]['column'], $order[0]['dir']);
			// $json = $this->GajiModel->json_gaji($start, $length, '', '', '');

			// var_dump($json); exit;

            $filtered   = $json[1];
            $total      = $json[1];
            $json_data  = $json[0];
            $data       = [];

            if (!empty($json_data)) {
                $no = $start + 1;
                foreach ($json_data as $row => $val) {
                	$gaji_bersih = $val->sub_total - ($val->pot_bon+$val->pot_satu+$val->pot_dua);

                    $edit = '<a href="'. base_url('gaji/detail/') . $val->kd . '/' . $val->tgl_start .'" class="btn btn-warning btn-sm">Detail</a>';
                    $print = '<a href="'. base_url('gaji/print/') . $val->kd . '/' . $val->tgl_start .'" class="btn btn-success btn-sm">Print</a>';
                    $delete = '<a href="'. base_url('gaji/delete/') . $val->kd . '/' . $val->tgl_start .'" class="btn btn-danger btn-sm">
                                    <img src="'. base_url('assets/icons/trash.svg') .'" alt="Bootstrap" width="20" height="20" class="m-1">Delete</a>';
                    
                    $button = $edit.$print.$delete;

                    $data[$row] = array(
                        $no++,
                        $val->kd,
                        $val->tgl_start.' - '. $val->tgl_end,
                        $val->jml,
                        'Rp. '. number_format($val->sub_total),
                        'Rp. '. number_format($val->pot_bon) . '<br>'.$val->ket_bon,
                        'Rp. '. number_format($val->pot_satu) . '<br>'.$val->ket_satu,
                        'Rp. '. number_format($val->pot_dua) . '<br>'.$val->ket_dua,
                        'Rp. '. number_format($gaji_bersih),
                        $button
                    );
                }
            }

            $result = array(
                'draw' => $draw,
                'recordsFiltered' => $filtered,
                'recordsTotal' => $total,
                'data' => $data,
            );

			echo json_encode($result);
		// }
	}

	public function detail($id, $start)
	{
		$data['data'] = $this->GajiModel->getGajiDetail($id, $start);
		$data['cetak_bulan'] = $this->bulan_indo($start, true, true);
		$data['karyawan'] = $this->KaryawanModel->getData($id);
		// var_dump($data['data']);
		// echo "<br><br>";
		// var_dump($data['info']);
		$this->load->view('admin/gaji_detail', $data);
	}

	public function create()
	{
		$kode_kar = $this->input->post('kode_kar', TRUE);
		$tgl_awal = $this->input->post('tgl_awal', TRUE);
		$tgl_akhir = $this->input->post('tgl_akhir', TRUE);

		$pot_bon = $this->input->post('pot_bon', TRUE);
		$ket_bon = $this->input->post('ket_bon', TRUE);
		$pot_satu = $this->input->post('pot_satu', TRUE);
		$ket_satu = $this->input->post('ket_satu', TRUE);
		$pot_dua = $this->input->post('pot_dua', TRUE);
		$ket_dua = $this->input->post('pot_dua', TRUE);
		// var_dump($kode_kar, $tgl_awal, $tgl_akhir);

		$data = $this->db->query("SELECT kode_karyawan,kode_penjualan FROM tb_penjualan WHERE tb_penjualan.tanggal_transaksi BETWEEN '$tgl_awal' AND '$tgl_akhir' AND tb_penjualan.kode_karyawan='$kode_kar'");
		$gaji['data'] = $data->result();

		$index=0;
		$data_gaji = [];

		for ($i=0; $i < count($gaji['data']); $i++) { 

			array_push($data_gaji, array(
					'kode_karyawan' => $gaji['data'][$i]->kode_karyawan,
					'kode_penjualan' => $gaji['data'][$i]->kode_penjualan,
					'tgl_start' => $tgl_awal,
					'tgl_end' => $tgl_akhir,
					'pot_bon' => $pot_bon,
					'ket_bon' => $ket_bon,
					'pot_satu' => $pot_satu,
					'ket_satu' => $ket_satu,
					'pot_dua' => $pot_dua,
					'ket_dua' => $ket_dua
				));
		}
		// var_dump($gaji);
		// var_dump($data_gaji);
		$sql = $this->db->insert_batch('tb_gaji', $data_gaji);
		if ($sql) {
			redirect('gaji','refresh');
		}
		else {
			echo "gagal";
		}

		// $data['data'] = $this->GajiModel->($id);
		// $this->load->view('admin/gaji_view', $data);
	}

	public function delete($id, $start)
	{
		$this->GajiModel->deleteData($id, $start);
		$this->session->set_flashdata('success','Data Berhasil Di Hapus');
		redirect('gaji','refresh');
	}

	public function print($id, $start)
	{

		$Pdf = new FPDF('l','mm','A4');
		$Pdf->AddPage();
		$data['data'] = $this->GajiModel->getGajiDetail($id, $start);
		$data['cetak_bulan'] = $this->bulan_indo($start, true, true);
		$data['info'] = $this->GajiModel->getGaji($id);
		$data['karyawan'] = $this->KaryawanModel->getData($id);
		$Pdf->SetFont('Arial','',10);
        $Pdf->SetTextColor(0,0,0);
        $Pdf->SetY(5);
        $Pdf->SetX(10);
        $Pdf->Cell(278,7,'Slip Gaji Karyawan',0,1,'C');

        $Pdf->SetTextColor(0,0,0);
        $Pdf->SetFont('Arial','',16);
        // mencetak string
        $Pdf->Cell(278,15,'Berkah Abadi',1,1,'C');
        //$Pdf->Image(base_url('assets/icons/logo_apple.jpg'),40,12,12,10, 'JPG');
        $Pdf->SetFont('Arial','',10);
        $Pdf->SetTextColor(0,0,0);
        $Pdf->Cell(278,7,'Alamat Lengkap dengan nama jalan berserta kode pos wilayah - nomor hp/wa',0,1,'C');

        $Pdf->Cell(10,5,'',0,1);
        $Pdf->SetFont('Arial','',10);
        $Pdf->Cell(30,10,'Nama Karyawan',0,0);
        $Pdf->Cell(40,10,': (' . $data['karyawan']->kode_karyawan . ') - ' . $data['karyawan']->nama_karyawan,0,0);
        $Pdf->Cell(170,10,'Periode ',0,0,'R');
        $Pdf->Cell(35,10,': ' . $data['cetak_bulan'],0,1,'R');

        $Pdf->Cell(30,0,'Alamat',0,0);
        $Pdf->Cell(40,0,': ' . $data['karyawan']->alamat,0,0);
        $Pdf->Cell(90,0,' ',0,0,'R');
        $Pdf->Cell(28,0,' ',0,1,'R');
        $Pdf->Cell(30,10,'Nomor Hp/WA',0,0);
        $Pdf->Cell(40,10,': ' .  $data['karyawan']->hp,0,0);
        $Pdf->Cell(90,10,' ',0,0,'R');
        $Pdf->Cell(28,10,' ',0,0,'R');
        // Memberikan space kebawah agar tidak terlalu rapat
        $Pdf->Cell(10,10,'',0,1); 
        $Pdf->SetFont('Arial','B',10);
        $Pdf->SetFillColor(230,230,230);
        $Pdf->Cell(10,6,'No',1,0,'C',true);
        $Pdf->Cell(44,6,'Nama Pelanggan',1,0,'C',true);
        $Pdf->Cell(130,6,'Alamat',1,0,'C',true);
        $Pdf->Cell(30,6,'Kode Penjualan',1,0,'C',true);

        $Pdf->Cell(10,6,'Jns',1,0,'C',true);
        $Pdf->Cell(10,6,'Jml',1,0,'C',true);
        $Pdf->Cell(10,6,'BN',1,0,'C',true);
        // $Pdf->SetY(63);
        // $Pdf->SetX(75);
        // $Pdf->Cell(15,6,'P',1,0,'C',true);
        // $Pdf->Cell(15,6,'L',1,0,'C',true);
        // $Pdf->Cell(15,6,'T',1,0,'C',true);

        // $Pdf->SetY(-240);
        // $Pdf->SetX(120);
        $Pdf->Cell(33,6,'Komisi',1,1,'C',true);
        // $Pdf->Cell(32,6,'Harga',1,0,'C',true);
        // $Pdf->Cell(32,6,'Sub total',1,1,'C',true);
        $nomor=1;
        $sub_total=0;
        $total_jml=0;
        $total_bn=0;
        foreach ($data['data'] as $row){
        	$total_jml += $row->jml;
        	$total_bn += $row->bn;

            $Pdf->Cell(10,6,$nomor++,1,0);
            $Pdf->Cell(44,6,$row->nama,1,0,'L');
            // $Pdf->SetFont('Arial','B',5);
            $Pdf->Cell(130,6,$row->alamat,1,0,'L');
            $Pdf->SetFont('Arial','B',10);
            $Pdf->Cell(30,6,$row->pj,1,0,'L');
            $Pdf->Cell(10,6,$row->jns,1,0,'L');
            $Pdf->Cell(10,6,$row->jml,1,0,'C');
            $Pdf->Cell(10,6,$row->bn,1,0,'C');
            $Pdf->Cell(33,6,'Rp. ' . number_format($row->sub_total),1,1,'L');
            $sub_total += $row->sub_total;
            // $Pdf->Cell(32,40,$this->rupiah($row->harga),1,0,'C');
            // $Pdf->Cell(32,40,$this->rupiah($row->qty*$row->harga),1,1,'C');
            // $Pdf->Cell(15,6,$row->tinggi,1);
            // $Pdf->Cell(25,6,$row->tanggal_lahir,1,1); 
        }
        $Pdf->Cell(224,6,'Total',1,0,'R',true);
        $Pdf->Cell(10,6,$total_jml,1,0,'C',true);
        $Pdf->Cell(10,6,$total_bn,1,0,'C',true);
        $Pdf->Cell(33,6,'Rp. ' . number_format($sub_total),1,1,'L',true);

        $Pdf->Cell(244,6, $val = ($data['data'][0]->ket_bon == '') ? $val='Potongan 1' : $val=$data['data'][0]->ket_bon,1,0,'R',true);
        $Pdf->Cell(33,6,$val = ($data['data'][0]->pot_bon == '' || $data['data'][0]->pot_bon == 0) ? $val='' : 'Rp. ' . number_format($data['data'][0]->pot_bon),1,1,'L',true);

        $Pdf->Cell(244,6,$val = ($data['data'][0]->ket_satu == '') ? $val='Potongan 2' : $val=$data['data'][0]->ket_satu,1,0,'R',true);
        $Pdf->Cell(33,6,$val = ($data['data'][0]->pot_satu == '' || $data['data'][0]->pot_satu == 0) ? $val='' : 'Rp. ' . number_format($data['data'][0]->pot_satu),1,1,'L',true);

        $Pdf->Cell(244,6,$val = ($data['data'][0]->ket_dua == '') ? $val='Potongan 3' : $val=$data['data'][0]->ket_dua,1,0,'R',true);
        $Pdf->Cell(33,6,$val = ($data['data'][0]->pot_dua == '' || $data['data'][0]->pot_dua == 0) ? $val='' : 'Rp. ' . number_format($data['data'][0]->pot_dua),1,1,'L',true);

        $gaji_bersih = $sub_total-($data['data'][0]->pot_bon+$data['data'][0]->pot_satu+$data['data'][0]->pot_dua);

        $Pdf->Cell(244,6,'Total terima',1,0,'R');
        $Pdf->Cell(33,6,'Rp. ' . number_format($gaji_bersih),1,1,'L',true);
        $Pdf->SetFont('Arial','',10);
		$Pdf->Output('');
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
