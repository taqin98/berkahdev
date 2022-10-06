<?php
class AngsuranModel extends CI_Model
{
	private $_table = 'tb_angsuran';

	public function getAllData()
	{
		$data = $this->db->query("SELECT tb_penjualan.tanggal_transaksi, tb_angsuran.kode_angsuran, tb_angsuran.kode_penjualan, tb_pelanggan.nama,
tb_penjualan.jenis_pembayaran,
tb_penjualan.jumlah_produk,
tb_penjualan.bonus,
tb_penjualan.total_brg,
tb_penjualan.sisa_pembayaran,
januari,
februari,
maret,
april,
mei,
juni,
juli,
agustus,
september,
oktober,
november,
desember,
tb_angsuran.collector,
tb_penjualan.ket
FROM tb_angsuran, tb_penjualan, tb_pelanggan 
WHERE tb_angsuran.kode_penjualan=tb_penjualan.kode_penjualan AND tb_penjualan.kode_pelanggan=tb_pelanggan.kode_pelanggan ORDER BY tb_penjualan.tanggal_transaksi ASC");
		return $data->result();
	}
	public function getFilterData($bln, $thn)
	{
		$data = $this->db->query("SELECT tb_penjualan.tanggal_transaksi, tb_angsuran.kode_angsuran, tb_angsuran.kode_penjualan, tb_pelanggan.nama,
tb_penjualan.jenis_pembayaran,
tb_penjualan.jumlah_produk,
tb_penjualan.bonus,
tb_penjualan.total_brg,
tb_penjualan.sisa_pembayaran,
januari,
februari,
maret,
april,
mei,
juni,
juli,
agustus,
september,
oktober,
november,
desember,
tb_angsuran.collector,
tb_penjualan.ket
FROM tb_angsuran, tb_penjualan, tb_pelanggan 
WHERE tb_angsuran.kode_penjualan=tb_penjualan.kode_penjualan AND tb_penjualan.kode_pelanggan=tb_pelanggan.kode_pelanggan AND month(tb_penjualan.tanggal_transaksi)='$bln' AND year(tb_penjualan.tanggal_transaksi)='$thn' ORDER BY tb_angsuran.kode_angsuran ASC, tb_penjualan.tanggal_transaksi ASC");
		return $data->result();
	}
	public function insertAngsuran($arrData)
	{
		$data = $this->db->insert('tb_angsuran', $arrData);
		if($data)
			return true;
		else
			return false;
	}

	public function update($arrData)
	{
		$data = $this->db->replace('tb_angsuran', $arrData);
		if($data)
			return true;
		else
			return false;
	}

	public function getAngsuran($id)
	{
		$data = $this->db->query("select * from tb_angsuran join tb_penjualan using(kode_penjualan) join tb_pelanggan using(kode_pelanggan) where kode_penjualan='$id'");
		return $data->result();
	}

	public function editData($id)
	{
		return $data = $this->db->query("select * from tb_angsuran join tb_penjualan using(kode_penjualan) join tb_pelanggan using(kode_pelanggan) where kode_angsuran='$id'")->row();
	}

	public function deleteData($id)
	{
		return $this->db->delete('tb_angsuran', array('ktp_id' => $id));
	}
}
?>