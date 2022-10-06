<?php
class PelangganModel extends CI_Model
{
	private $_table = 'tb_pelanggan';

	public function getAllData()
	{
		$data = $this->db->get('tb_pelanggan');
		return $data->result();
	}

	public function getAutoKodePelanggan()
	{
		$query = $this->db->query("SELECT MAX(kode_pelanggan) as kd FROM tb_pelanggan")->row();
		$kode = $query->kd;
		$sortir = substr($kode, 4,4);
		$sortir++;

		$huruf='PEL';
		$kode_pelanggan = $huruf . sprintf("%05s", $sortir);

		return $kode_pelanggan;
	}
	public function insertData($arrData)
	{
		$data = $this->db->insert('tb_pelanggan', $arrData);
		if($data)
			return true;
		else
			return false;
	}

	public function updateData($arrData)
	{
		$data = $this->db->replace('tb_pelanggan', $arrData);
		if($data)
			return true;
		else
			return false;
	}

	public function getPelanggan($id)
	{
		$data = $this->db->get_where('tb_pelanggan', array('kode_pelanggan' => $id));
		return $data->row();
	}

	public function deleteData($id)
	{
		return $this->db->delete('tb_pelanggan', array('kode_pelanggan' => $id));
	}
}
?>