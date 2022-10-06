<?php
class PenjualanModel extends CI_Model
{
	private $_table = 'tb_penjualan';

	public function getAllData()
	{
		$data = $this->db->get('tb_penjualan');
		return $data->result();
	}
	public function getCustomData()
	{
		$data = $this->db->query('SELECT * FROM tb_penjualan, tb_pelanggan, tb_angsuran WHERE tb_penjualan.kode_pelanggan=tb_pelanggan.kode_pelanggan AND tb_penjualan.kode_penjualan=tb_angsuran.kode_penjualan ORDER BY tb_penjualan.tanggal_transaksi ASC');
		return $data->result();
	}

	public function getDataByMonthYear($month, $year)
	{
		$data = $this->db->query("SELECT * FROM tb_penjualan, tb_pelanggan, tb_angsuran WHERE tb_penjualan.kode_pelanggan=tb_pelanggan.kode_pelanggan AND tb_penjualan.kode_penjualan=tb_angsuran.kode_penjualan AND YEAR(tb_penjualan.tanggal_transaksi)='$year' AND MONTH(tb_penjualan.tanggal_transaksi)='$month' ORDER BY tb_penjualan.tanggal_transaksi ASC");
		return $data->result();
	}

	public function getDataBySixMonth($tgl_awal, $tgl_akhir)
	{
		$data = $this->db->query("SELECT * FROM tb_penjualan, tb_pelanggan, tb_angsuran WHERE tb_penjualan.kode_pelanggan=tb_pelanggan.kode_pelanggan AND tb_penjualan.kode_penjualan=tb_angsuran.kode_penjualan AND tb_penjualan.tanggal_transaksi BETWEEN '$tgl_awal' AND '$tgl_akhir' ORDER BY tb_penjualan.tanggal_transaksi ASC");
		return $data->result();
	}

	public function getDataEdit($id)
	{
		$data = $this->db->get_where('tb_penjualan', array('kode_penjualan' => $id));
		return $data->row();
	}

	public function insertPenjualan($arrData)
	{
		$data = $this->db->insert('tb_penjualan', $arrData);
		if($data)
			return true;
		else
			return false;
	}

	public function update($arrData)
	{
		$data = $this->db->replace('tb_penjualan', $arrData);
		if($data)
			return true;
		else
			return false;
	}

	public function updateStatus($kodeParam, $statusParam)
	{
		$data = $this->db->query("UPDATE tb_penjualan SET tb_penjualan.ket='$statusParam' WHERE tb_penjualan.kode_penjualan='$kodeParam'");
		if($data)
			return true;
		else
			return false;
	}

	public function getPelanggan($id)
	{
		$data = $this->db->get_where('tb_penjualan', array('kode_pelanggan' => $id));
		return $data->row();
	}

	public function deleteData($id)
	{
		$gt_data = $this->db->query("SELECT a.kode_penjualan, a.kode_pelanggan, a.bonus,
			a.jumlah_produk as qty,b.kode_brg, d.nama FROM
			tb_penjualan a
			INNER JOIN tb_penjualan_detail b ON a.kode_penjualan=b.kode_penjualan
			INNER JOIN tb_angsuran c ON b.kode_penjualan=c.kode_penjualan
			INNER JOIN tb_pelanggan d ON a.kode_pelanggan=d.kode_pelanggan
			WHERE a.kode_penjualan='$id' ");
		
		if ($gt_data->num_rows() > 0) {
			$gt_bonus = ($gt_data->row()->bonus !== '' || $gt_data->row()->bonus !== 0) ? (int) $gt_data->row()->bonus : 0;
			$gt_qty = (int) $gt_data->row()->qty;
			$gt_brg = $gt_data->row()->kode_brg;
			$gt_kd = $gt_data->row()->kode_penjualan;
			$gt_nm = $gt_data->row()->nama;

			$data = $this->BarangModel->restoreDataStok(($gt_qty+$gt_bonus), $gt_brg);
			$this->db->query("DELETE tb_penjualan, tb_penjualan_detail, tb_angsuran FROM
				tb_penjualan INNER JOIN tb_penjualan_detail ON tb_penjualan.kode_penjualan=tb_penjualan_detail.kode_penjualan
				INNER JOIN tb_angsuran ON tb_penjualan_detail.kode_penjualan=tb_angsuran.kode_penjualan
				WHERE tb_penjualan.kode_penjualan='$id'");
		}
		if($data)
			return [true, $gt_kd, $gt_nm];
		else
			return false;
	}
// Nambah Bulan
// DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -5 MONTH)

// Mengurangi Bulan
// DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL 5 MONTH)

	// public function getBonus($pel, $ket, $dateParam)
	// {
	// 	return $this->db->query("SELECT
	// 		tb_penjualan.kode_pelanggan,
	// 		tb_penjualan.jumlah_produk,
	// 		tb_penjualan.bonus,
	// 		tb_penjualan.tanggal_transaksi as tgl_awal,
	// 		DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -5 MONTH) as tgl_akhir
	// 		FROM tb_penjualan
	// 		WHERE tb_penjualan.kode_pelanggan='$pel' AND tb_penjualan.ket='$ket' AND
	// 		tb_penjualan.tanggal_transaksi BETWEEN DATE_SUB('$dateParam', INTERVAL 5 MONTH) AND '$dateParam' ")->result();
	// }
	public function getBonus($pel, $dateParam)
	{
		return $this->db->query("SELECT
			tb_penjualan.kode_pelanggan,
			tb_penjualan.jumlah_produk,
			tb_penjualan.bonus,
			tb_penjualan.tanggal_transaksi as tgl_awal,
			DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -5 MONTH) as tgl_akhir
			FROM tb_penjualan
			WHERE tb_penjualan.kode_pelanggan='$pel' AND
			tb_penjualan.tanggal_transaksi BETWEEN DATE_SUB('$dateParam', INTERVAL 5 MONTH) AND '$dateParam' ")->result();
	}

	public function getTagihan($kode_pel)
	{
		return $this->db->query("SELECT tb_pelanggan.kode_pelanggan, tb_pelanggan.nama,
			tb_pelanggan.alamat,
			tb_pelanggan.hp, tb_angsuran.kode_penjualan,
			tb_penjualan.kode_karyawan as karyawan,
			tb_penjualan.total_brg as total_byr,
			tb_penjualan.jumlah_produk as jml_produk,
			tb_penjualan.tanggal_transaksi as tgl_awal,
			DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -5 MONTH) as tgl_akhir,
			CASE
			WHEN MONTH(tb_penjualan.tanggal_transaksi) = 1 THEN tb_angsuran.januari
			WHEN MONTH(tb_penjualan.tanggal_transaksi) = 2 THEN tb_angsuran.februari
			WHEN MONTH(tb_penjualan.tanggal_transaksi) = 3 THEN tb_angsuran.maret
			WHEN MONTH(tb_penjualan.tanggal_transaksi) = 4 THEN tb_angsuran.april
			WHEN MONTH(tb_penjualan.tanggal_transaksi) = 5 THEN tb_angsuran.mei
			WHEN MONTH(tb_penjualan.tanggal_transaksi) = 6 THEN tb_angsuran.juni
			WHEN MONTH(tb_penjualan.tanggal_transaksi) = 7 THEN tb_angsuran.juli
			WHEN MONTH(tb_penjualan.tanggal_transaksi) = 8 THEN tb_angsuran.agustus
			WHEN MONTH(tb_penjualan.tanggal_transaksi) = 9 THEN tb_angsuran.september
			WHEN MONTH(tb_penjualan.tanggal_transaksi) = 10 THEN tb_angsuran.oktober
			WHEN MONTH(tb_penjualan.tanggal_transaksi) = 11 THEN tb_angsuran.november
			WHEN MONTH(tb_penjualan.tanggal_transaksi) = 12 THEN tb_angsuran.desember
			ELSE NULL
			END as A1,
			
			CASE
			WHEN MONTH(tb_penjualan.tanggal_transaksi) = 1 THEN 1
			WHEN MONTH(tb_penjualan.tanggal_transaksi) = 2 THEN 2
			WHEN MONTH(tb_penjualan.tanggal_transaksi) = 3 THEN 3
			WHEN MONTH(tb_penjualan.tanggal_transaksi) = 4 THEN 4
			WHEN MONTH(tb_penjualan.tanggal_transaksi) = 5 THEN 5
			WHEN MONTH(tb_penjualan.tanggal_transaksi) = 6 THEN 6
			WHEN MONTH(tb_penjualan.tanggal_transaksi) = 7 THEN 7
			WHEN MONTH(tb_penjualan.tanggal_transaksi) = 8 THEN 8
			WHEN MONTH(tb_penjualan.tanggal_transaksi) = 9 THEN 9
			WHEN MONTH(tb_penjualan.tanggal_transaksi) = 10 THEN 10
			WHEN MONTH(tb_penjualan.tanggal_transaksi) = 11 THEN 11
			WHEN MONTH(tb_penjualan.tanggal_transaksi) = 12 THEN 12
			ELSE NULL
			END as A1_number,

			CASE
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -1 MONTH)) = 1 THEN tb_angsuran.januari
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -1 MONTH)) = 2 THEN tb_angsuran.februari
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -1 MONTH)) = 3 THEN tb_angsuran.maret
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -1 MONTH)) = 4 THEN tb_angsuran.april
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -1 MONTH)) = 5 THEN tb_angsuran.mei
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -1 MONTH)) = 6 THEN tb_angsuran.juni
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -1 MONTH)) = 7 THEN tb_angsuran.juli
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -1 MONTH)) = 8 THEN tb_angsuran.agustus
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -1 MONTH)) = 9 THEN tb_angsuran.september
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -1 MONTH)) = 10 THEN tb_angsuran.oktober
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -1 MONTH)) = 11 THEN tb_angsuran.november
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -1 MONTH)) = 12 THEN tb_angsuran.desember
			ELSE NULL
			END as A2,
			
			CASE
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -1 MONTH)) = 1 THEN 1
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -1 MONTH)) = 2 THEN 2
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -1 MONTH)) = 3 THEN 3
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -1 MONTH)) = 4 THEN 4
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -1 MONTH)) = 5 THEN 5
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -1 MONTH)) = 6 THEN 6
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -1 MONTH)) = 7 THEN 7
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -1 MONTH)) = 8 THEN 8
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -1 MONTH)) = 9 THEN 9
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -1 MONTH)) = 10 THEN 10
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -1 MONTH)) = 11 THEN 11
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -1 MONTH)) = 12 THEN 12
			ELSE NULL
			END as A2_number,

			CASE
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -2 MONTH)) = 1 THEN tb_angsuran.januari
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -2 MONTH)) = 2 THEN tb_angsuran.februari
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -2 MONTH)) = 3 THEN tb_angsuran.maret
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -2 MONTH)) = 4 THEN tb_angsuran.april
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -2 MONTH)) = 5 THEN tb_angsuran.mei
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -2 MONTH)) = 6 THEN tb_angsuran.juni
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -2 MONTH)) = 7 THEN tb_angsuran.juli
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -2 MONTH)) = 8 THEN tb_angsuran.agustus
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -2 MONTH)) = 9 THEN tb_angsuran.september
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -2 MONTH)) = 10 THEN tb_angsuran.oktober
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -2 MONTH)) = 11 THEN tb_angsuran.november
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -2 MONTH)) = 12 THEN tb_angsuran.desember
			ELSE NULL
			END as A3,
			
			CASE
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -2 MONTH)) = 1 THEN 1
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -2 MONTH)) = 2 THEN 2
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -2 MONTH)) = 3 THEN 3
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -2 MONTH)) = 4 THEN 4
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -2 MONTH)) = 5 THEN 5
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -2 MONTH)) = 6 THEN 6
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -2 MONTH)) = 7 THEN 7
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -2 MONTH)) = 8 THEN 8
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -2 MONTH)) = 9 THEN 9
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -2 MONTH)) = 10 THEN 10
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -2 MONTH)) = 11 THEN 11
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -2 MONTH)) = 12 THEN 12
			ELSE NULL
			END as A3_number,

			CASE
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -3 MONTH)) = 1 THEN tb_angsuran.januari
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -3 MONTH)) = 2 THEN tb_angsuran.februari
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -3 MONTH)) = 3 THEN tb_angsuran.maret
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -3 MONTH)) = 4 THEN tb_angsuran.april
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -3 MONTH)) = 5 THEN tb_angsuran.mei
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -3 MONTH)) = 6 THEN tb_angsuran.juni
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -3 MONTH)) = 7 THEN tb_angsuran.juli
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -3 MONTH)) = 8 THEN tb_angsuran.agustus
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -3 MONTH)) = 9 THEN tb_angsuran.september
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -3 MONTH)) = 10 THEN tb_angsuran.oktober
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -3 MONTH)) = 11 THEN tb_angsuran.november
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -3 MONTH)) = 12 THEN tb_angsuran.desember
			ELSE NULL
			END as A4,
			
			CASE
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -3 MONTH)) = 1 THEN 1
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -3 MONTH)) = 2 THEN 2
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -3 MONTH)) = 3 THEN 3
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -3 MONTH)) = 4 THEN 4
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -3 MONTH)) = 5 THEN 5
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -3 MONTH)) = 6 THEN 6
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -3 MONTH)) = 7 THEN 7
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -3 MONTH)) = 8 THEN 8
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -3 MONTH)) = 9 THEN 9
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -3 MONTH)) = 10 THEN 10
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -3 MONTH)) = 11 THEN 11
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -3 MONTH)) = 12 THEN 12
			ELSE NULL
			END as A4_number,

			CASE
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -4 MONTH)) = 1 THEN tb_angsuran.januari
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -4 MONTH)) = 2 THEN tb_angsuran.februari
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -4 MONTH)) = 3 THEN tb_angsuran.maret
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -4 MONTH)) = 4 THEN tb_angsuran.april
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -4 MONTH)) = 5 THEN tb_angsuran.mei
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -4 MONTH)) = 6 THEN tb_angsuran.juni
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -4 MONTH)) = 7 THEN tb_angsuran.juli
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -4 MONTH)) = 8 THEN tb_angsuran.agustus
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -4 MONTH)) = 9 THEN tb_angsuran.september
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -4 MONTH)) = 10 THEN tb_angsuran.oktober
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -4 MONTH)) = 11 THEN tb_angsuran.november
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -4 MONTH)) = 12 THEN tb_angsuran.desember
			ELSE NULL
			END as A5,
			
			CASE
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -4 MONTH)) = 1 THEN 1
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -4 MONTH)) = 2 THEN 2
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -4 MONTH)) = 3 THEN 3
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -4 MONTH)) = 4 THEN 4
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -4 MONTH)) = 5 THEN 5
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -4 MONTH)) = 6 THEN 6
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -4 MONTH)) = 7 THEN 7
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -4 MONTH)) = 8 THEN 8
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -4 MONTH)) = 9 THEN 9
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -4 MONTH)) = 10 THEN 10
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -4 MONTH)) = 11 THEN 11
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -4 MONTH)) = 12 THEN 12
			ELSE NULL
			END as A5_number,

			CASE
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -5 MONTH)) = 1 THEN tb_angsuran.januari
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -5 MONTH)) = 2 THEN tb_angsuran.februari
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -5 MONTH)) = 3 THEN tb_angsuran.maret
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -5 MONTH)) = 4 THEN tb_angsuran.april
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -5 MONTH)) = 5 THEN tb_angsuran.mei
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -5 MONTH)) = 6 THEN tb_angsuran.juni
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -5 MONTH)) = 7 THEN tb_angsuran.juli
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -5 MONTH)) = 8 THEN tb_angsuran.agustus
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -5 MONTH)) = 9 THEN tb_angsuran.september
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -5 MONTH)) = 10 THEN tb_angsuran.oktober
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -5 MONTH)) = 11 THEN tb_angsuran.november
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -5 MONTH)) = 12 THEN tb_angsuran.desember
			ELSE NULL
			END as A6,
			
			CASE
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -5 MONTH)) = 1 THEN 1
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -5 MONTH)) = 2 THEN 2
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -5 MONTH)) = 3 THEN 3
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -5 MONTH)) = 4 THEN 4
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -5 MONTH)) = 5 THEN 5
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -5 MONTH)) = 6 THEN 6
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -5 MONTH)) = 7 THEN 7
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -5 MONTH)) = 8 THEN 8
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -5 MONTH)) = 9 THEN 9
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -5 MONTH)) = 10 THEN 10
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -5 MONTH)) = 11 THEN 11
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -5 MONTH)) = 12 THEN 12
			ELSE NULL
			END as A6_number,

			CASE
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -6 MONTH)) = 1 THEN tb_angsuran.januari
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -6 MONTH)) = 2 THEN tb_angsuran.februari
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -6 MONTH)) = 3 THEN tb_angsuran.maret
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -6 MONTH)) = 4 THEN tb_angsuran.april
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -6 MONTH)) = 5 THEN tb_angsuran.mei
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -6 MONTH)) = 6 THEN tb_angsuran.juni
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -6 MONTH)) = 7 THEN tb_angsuran.juli
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -6 MONTH)) = 8 THEN tb_angsuran.agustus
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -6 MONTH)) = 9 THEN tb_angsuran.september
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -6 MONTH)) = 10 THEN tb_angsuran.oktober
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -6 MONTH)) = 11 THEN tb_angsuran.november
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -6 MONTH)) = 12 THEN tb_angsuran.desember
			ELSE NULL
			END as A7,
			
			CASE
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -6 MONTH)) = 1 THEN 1
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -6 MONTH)) = 2 THEN 2
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -6 MONTH)) = 3 THEN 3
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -6 MONTH)) = 4 THEN 4
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -6 MONTH)) = 5 THEN 5
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -6 MONTH)) = 6 THEN 6
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -6 MONTH)) = 7 THEN 7
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -6 MONTH)) = 8 THEN 8
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -6 MONTH)) = 9 THEN 9
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -6 MONTH)) = 10 THEN 10
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -6 MONTH)) = 11 THEN 11
			WHEN MONTH(DATE_SUB(tb_penjualan.tanggal_transaksi, INTERVAL -6 MONTH)) = 12 THEN 12
			ELSE NULL
			END as A7_number,

			SUM(
			COALESCE(januari,0) + 
			COALESCE(februari,0) +
			COALESCE(maret,0) +
			COALESCE(april,0) +
			COALESCE(mei,0) +
			COALESCE(juni,0) +
			COALESCE(juli,0) +
			COALESCE(agustus,0) +
			COALESCE(september,0) +
			COALESCE(oktober,0) +
			COALESCE(november,0) +
			COALESCE(desember,0)
			) as total_angsuran,
			SUM(
			tb_penjualan.total_brg-
			COALESCE(januari,0) - 
			COALESCE(februari,0) -
			COALESCE(maret,0) -
			COALESCE(april,0) -
			COALESCE(mei,0) -
			COALESCE(juni,0) -
			COALESCE(juli,0) -
			COALESCE(agustus,0) -
			COALESCE(september,0) -
			COALESCE(oktober,0) -
			COALESCE(november,0) -
			COALESCE(desember,0)

			) as sisa

			FROM tb_angsuran, tb_penjualan, tb_pelanggan WHERE tb_angsuran.kode_penjualan=tb_penjualan.kode_penjualan AND tb_angsuran.kode_penjualan='$kode_pel' AND tb_penjualan.kode_pelanggan=tb_pelanggan.kode_pelanggan")->result();
	}
}
?>