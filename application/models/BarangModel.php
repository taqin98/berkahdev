<?php
class BarangModel extends CI_Model
{
	private $_table = 'tb_barang';

	public function getAllData()
	{
		$data = $this->db->get('tb_barang');
		return $data->result();
	}

	public function insert($arrData)
	{
		$data = $this->db->insert('tb_barang', $arrData);
		if($data)
			return true;
		else
			return false;
	}

	public function getAutoKodeBarang()
	{
		$query = $this->db->query("SELECT MAX(kode_brg) as kd FROM tb_barang")->row();
		$kode = $query->kd;
		$sortir = substr($kode, 4,4);
		$sortir++;

		$huruf='BRG';
		$kode_brg = $huruf . sprintf("%04s", $sortir);

		return $kode_brg;
	}

	public function getData($id)
	{
		return $this->db->get_where('tb_barang', array('kode_brg' => $id))->row();
	}

	public function updateData($arrData)
	{
		$data = $this->db->replace('tb_barang', $arrData);
		if($data)
			return true;
		else
			return false;
	}

	public function updateDataStok($stok_brg, $kode_brg)
	{
		if ($stok_brg < 0){
			$data = $this->db->query("UPDATE tb_barang SET stok=(stok-('$stok_brg')) WHERE kode_brg='$kode_brg'");
		} else {
			$data = $this->db->query("UPDATE tb_barang SET stok=(stok-'$stok_brg') WHERE kode_brg='$kode_brg'");
		}
		
		if($data)
			return true;
		else
			return false;
	}

	public function restoreDataStok($stok_brg, $kode_brg)
	{
		if ($stok_brg < 0){
			$data = $this->db->query("UPDATE tb_barang SET stok=(stok+('$stok_brg')) WHERE kode_brg='$kode_brg'");
		} else {
			$data = $this->db->query("UPDATE tb_barang SET stok=(stok+'$stok_brg') WHERE kode_brg='$kode_brg'");
		}
		
		if($data)
			return true;
		else
			return false;
	}

	public function deleteData($id)
	{
		return $this->db->delete('tb_barang', array('kode_brg' => $id));
	}
	
}
?>