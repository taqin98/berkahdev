<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pelanggan extends CI_Controller {

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
	}

	public function index()
	{
		$data['data'] = $this->PelangganModel->getAllData();
		$data['kode_auto'] = $this->PelangganModel->getAutoKodePelanggan();
		$this->load->view('admin/pelanggan_view', $data);
	}

	public function create()
	{
		$form = (object) array(
			'kode_pelanggan' => $this->input->post('kd', TRUE),
			'nama' => $this->input->post('nm', TRUE),
			'alamat' => $this->input->post('alm', TRUE),
			'hp' => $this->input->post('hp', TRUE)
		);

		$condition = $this->PelangganModel->insertData($form);
			if ($condition) {
				$this->session->set_flashdata('success','Data Berhasil Di Tambahkan');
				return redirect('pelanggan');
			}
	}

	public function edit()
	{
		$get= $this->input->post('id');
		$data = $this->PelangganModel->getPelanggan($get);
		echo json_encode($data);
	}

	public function update()
	{
		$form = (object) array(
			'kode_pelanggan' => $this->input->post('kd', TRUE),
			'nama' => $this->input->post('nm', TRUE),
			'alamat' => $this->input->post('alm', TRUE),
			'hp' => $this->input->post('hp', TRUE)
		);
		$condition = $this->PelangganModel->updateData($form);
		if ($condition) {
			$this->session->set_flashdata('success','Data Berhasil Di Update');
			return redirect('pelanggan');
		}
	}

	public function delete($id)
	{
		$this->PelangganModel->deleteData($id);
		$this->session->set_flashdata('success','Data Berhasil Di Hapus');
		redirect('pelanggan','refresh');
	}

	public function autofill_ajax()
	{
		$get= $this->input->post('id');
		$data['data'] = $this->PelangganModel->getPelanggan($get);
		echo json_encode($data);
	}



}
