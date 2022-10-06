<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Karyawan extends CI_Controller {

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
		$this->load->library('form_validation');
		$this->load->model('KaryawanModel');
	}

	public function index()
	{
		$data['data'] = $this->KaryawanModel->getAllData();
		$this->load->view('admin/karyawan_view', $data);
	}

	public function create()
	{
		$this->form_validation->set_rules('kode_kar', 'Kode Karyawan', 'trim|required');
		$this->form_validation->set_rules('nm', 'Nama Karyawan', 'trim|required');
		$this->form_validation->set_rules('hp', 'Nomor Hp', 'trim|required|numeric|max_length[16]');
		$this->form_validation->set_rules('alm', 'Alamat Karyawan', 'trim|required');
		$this->form_validation->set_rules('ket', 'Keterangan', 'trim|required');
		
		if ($this->form_validation->run() == FALSE) {
			$this->load->view('admin/karyawan_input');
		} else {
			$form = (object) array(
				'kode_karyawan' => $this->input->post('kode_kar', TRUE),
				'nama_karyawan' => $this->input->post('nm', TRUE),
				'hp' => $this->input->post('hp', TRUE),
				'alamat' => $this->input->post('alm', TRUE),
				'ket' => $this->input->post('ket', TRUE)
			);

			$condition = $this->KaryawanModel->insertKaryawan($form);
			if ($condition) {
				$this->session->set_flashdata('success','Data Berhasil Di Tambahkan');
				return redirect('karyawan');
			}
		}
	}

	public function edit($id)
	{
		$data['data'] = $this->KaryawanModel->getData($id);

		$this->form_validation->set_rules('nm', 'Nama Karyawan', 'trim|required');
		$this->form_validation->set_rules('hp', 'Nomor Hp', 'trim|required|numeric|max_length[16]');
		$this->form_validation->set_rules('alm', 'Alamat Karyawan', 'trim|required');
		$this->form_validation->set_rules('ket', 'Keterangan', 'trim|required');
		
		if ($this->form_validation->run() == FALSE) {
			$this->load->view('admin/karyawan_edit', $data);
		} else {
			$form = (object) array(
				'kode_karyawan' => $this->KaryawanModel->getData($id)->kode_karyawan,
				'nama_karyawan' => $this->input->post('nm', TRUE),
				'hp' => $this->input->post('hp', TRUE),
				'alamat' => $this->input->post('alm', TRUE),
				'ket' => $this->input->post('ket', TRUE)
			);

			$condition = $this->KaryawanModel->updateData($form);
			if ($condition) {
				$this->session->set_flashdata('success','Data Berhasil Di Update');
				return redirect('karyawan');
			}
		}
	}

	public function delete($id)
	{
		$this->KaryawanModel->deleteData($id);
		$this->session->set_flashdata('success','Data Berhasil Di Hapus');
		redirect('karyawan','refresh');
	}



}
