<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Barang extends CI_Controller {

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
		$this->load->model('BarangModel');
		$this->load->library('form_validation');
	}

	public function index()
	{
		$data['data'] = $this->BarangModel->getAllData();
		$this->load->view('admin/barang_view', $data);
	}

	public function create()
	{
		$data['kode_auto'] = $this->BarangModel->getAutoKodeBarang();
		$this->form_validation->set_rules('kode_brg', 'Kode Barang', 'trim|required');
		$this->form_validation->set_rules('nm', 'Nama Barang', 'trim|required');
		$this->form_validation->set_rules('hrg', 'Harga Barang', 'trim|required|numeric');
		$this->form_validation->set_rules('stok', 'Stok Barang', 'trim|required|numeric');
		$this->form_validation->set_rules('kredit', 'Komisi (K)', 'trim|required|numeric');
		$this->form_validation->set_rules('cash', 'Komisi (C)', 'trim|required|numeric');
		
		if ($this->form_validation->run() == FALSE) {
			$this->load->view('admin/barang_input', $data);
		} else {
			$form = (object) array(
				'kode_brg' => $this->input->post('kode_brg', TRUE),
				'nama_brg' => $this->input->post('nm', TRUE),
				'harga_pcs' => $this->input->post('hrg', TRUE),
				'stok' => $this->input->post('stok', TRUE),
				'komisi_kredit' => $this->input->post('kredit', TRUE),
				'komisi_cash' => $this->input->post('cash', TRUE),
				'hrg_kredit' => $this->input->post('hrg_k', TRUE),
				'hrg_cash' => $this->input->post('hrg_c', TRUE)
			);

			$condition = $this->BarangModel->insert($form);
			if ($condition) {
				$this->session->set_flashdata('success','Data Berhasil Di Tambahkan');
				return redirect('barang');
			}
		}
	}

	public function edit($id)
	{
		$data['data'] = $this->BarangModel->getData($id);

		$this->form_validation->set_rules('kode_brg', 'Kode Barang', 'trim|required');
		$this->form_validation->set_rules('nm', 'Nama Barang', 'trim|required');
		$this->form_validation->set_rules('hrg', 'Harga Barang', 'trim|required|numeric');
		$this->form_validation->set_rules('stok', 'Stok Barang', 'trim|required|numeric');
		
		if ($this->form_validation->run() == FALSE) {
			$this->load->view('admin/barang_edit', $data);
		} else {
			$form = (object) array(
				'kode_brg' => $this->BarangModel->getData($id)->kode_brg,
				'nama_brg' => $this->input->post('nm', TRUE),
				'harga_pcs' => $this->input->post('hrg', TRUE),
				'stok' => $this->input->post('stok', TRUE),
				'komisi_kredit' => $this->input->post('kredit', TRUE),
				'komisi_cash' => $this->input->post('cash', TRUE),
				'hrg_kredit' => $this->input->post('hrg_k', TRUE),
				'hrg_cash' => $this->input->post('hrg_c', TRUE)
			);

			$condition = $this->BarangModel->updateData($form);
			if ($condition) {
				$this->session->set_flashdata('success','Data Berhasil Di Update');
				return redirect('barang');
			}
		}
	}

	public function delete($id)
	{
		$this->BarangModel->deleteData($id);
		$this->session->set_flashdata('success','Data Berhasil Di Hapus');
		redirect('barang','refresh');
	}

	public function countTotalKredit()
	{
		$jenis= $this->input->post('jenis');
		$kode= $this->input->post('kode');
		$qty= $this->input->post('quantity');

		if ($jenis == 'K') {
			$data['data'] = $this->db->query("SELECT kode_brg, '$qty' as qty, hrg_kredit, (hrg_kredit*'$qty') as sub_total_kredit FROM tb_barang WHERE kode_brg='$kode'")->row();
			echo json_encode($data);
		} else {
			$data['data'] = $this->db->query("SELECT kode_brg, '$qty' as qty, hrg_cash, (hrg_cash*'$qty') as sub_total_kredit FROM tb_barang WHERE kode_brg='$kode'")->row();
			echo json_encode($data);
		}
	}

	public function autofill_ajax()
	{
		$get= $this->input->post('id');
		$data['data'] = $this->BarangModel->getData($get);
		echo json_encode($data);
	}



}
