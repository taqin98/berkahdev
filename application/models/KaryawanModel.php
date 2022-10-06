<?php
class KaryawanModel extends CI_Model
{
	private $_table = 'tb_karyawan';

	public function getAllData()
	{
		$data = $this->db->get('tb_karyawan');
		return $data->result();
	}
	public function getCustomData()
	{
		$data = $this->db->query("SELECT DISTINCT tb_penjualan.kode_karyawan, tb_karyawan.nama_karyawan FROM tb_penjualan JOIN tb_karyawan USING (kode_karyawan)");
		return $data->result();
	}

	public function insertKaryawan($arrData)
	{
		$data = $this->db->insert('tb_karyawan', $arrData);
		if($data)
			return true;
		else
			return false;
	}

	public function getData($id)
	{
		return $this->db->get_where('tb_karyawan', array('kode_karyawan' => $id))->row();
	}

	public function updateData($arrData)
	{
		$data = $this->db->replace('tb_karyawan', $arrData);
		if($data)
			return true;
		else
			return false;
	}

	public function deleteData($id)
	{
		return $this->db->delete('tb_karyawan', array('kode_karyawan' => $id));
	}
	
}
?>