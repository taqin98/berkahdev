<?php
class GajiModel extends CI_Model
{
	private $_table = 'tb_gaji';


	public function json_gaji($start=0, $length=0, $search='', $column='', $dir='') {
		// var_dump($start, $length, $search, $column, $dir); exit;
        $condition = '';
		if ($search != '') {
			$condition .= " WHERE (z.kd LIKE '%$search%'
                            OR z.jml LIKE '%$search%'
                            ";
		} else {
            // $condition .= " WHERE (c.delete_at IS NULL)";
            // $condition .= " ";
        }

		$order = '';
		if ($column != '' && $dir != '') {
			switch ($column) {
				case '0':
					$col = 'z.kd';
					break;
				case '1':
					$col = 'z.jml';
					break;
				default:
					$col = '';
					break;
			}

			if ($col != '') {
				$order .= " ORDER BY $col $dir ";
			}
		} 

		$limit = "LIMIT $start, $length";
		if($length == '-1'){
			$limit = "";
		}

		$filtered = $this->db->query("SELECT z.* FROM (SELECT tb_penjualan.kode_karyawan as kd, 

		(SELECT SUM(tb_penjualan.jumlah_produk) from tb_penjualan WHERE tb_penjualan.kode_karyawan=kd AND tb_penjualan.tanggal_transaksi BETWEEN tb_gaji.tgl_start AND tb_gaji.tgl_end) as jml, 
			tb_gaji.tgl_start, tb_gaji.tgl_end,

		(SELECT SUM(    
		CASE
			WHEN tb_penjualan.jenis_pembayaran = 'K' THEN tb_penjualan_detail.qty*tb_barang.komisi_kredit
			ELSE tb_penjualan_detail.qty*tb_barang.komisi_cash
		END) FROM tb_penjualan, tb_penjualan_detail, tb_barang WHERE tb_penjualan.kode_karyawan=kd AND tb_penjualan_detail.kode_brg=tb_barang.kode_brg AND tb_penjualan.kode_penjualan=tb_penjualan_detail.kode_penjualan AND tb_penjualan.tanggal_transaksi BETWEEN tb_gaji.tgl_start AND tb_gaji.tgl_end
		) as sub_total,

		tb_gaji.pot_bon, tb_gaji.ket_bon, tb_gaji.pot_satu, tb_gaji.ket_satu,

		tb_gaji.pot_dua, tb_gaji.ket_dua
		FROM tb_penjualan, tb_penjualan_detail, tb_barang, tb_gaji WHERE tb_penjualan.kode_karyawan=tb_gaji.kode_karyawan GROUP by sub_total) z
                $condition
                $order $limit
                ")->result();
		$total = $this->db->query("SELECT z.* FROM (SELECT tb_penjualan.kode_karyawan as kd, 

		(SELECT SUM(tb_penjualan.jumlah_produk) from tb_penjualan WHERE tb_penjualan.kode_karyawan=kd AND tb_penjualan.tanggal_transaksi BETWEEN tb_gaji.tgl_start AND tb_gaji.tgl_end) as jml, 
			tb_gaji.tgl_start, tb_gaji.tgl_end,

		(SELECT SUM(    
		CASE
			WHEN tb_penjualan.jenis_pembayaran = 'K' THEN tb_penjualan_detail.qty*tb_barang.komisi_kredit
			ELSE tb_penjualan_detail.qty*tb_barang.komisi_cash
		END) FROM tb_penjualan, tb_penjualan_detail, tb_barang WHERE tb_penjualan.kode_karyawan=kd AND tb_penjualan_detail.kode_brg=tb_barang.kode_brg AND tb_penjualan.kode_penjualan=tb_penjualan_detail.kode_penjualan AND tb_penjualan.tanggal_transaksi BETWEEN tb_gaji.tgl_start AND tb_gaji.tgl_end
		) as sub_total,

		tb_gaji.pot_bon, tb_gaji.ket_bon, tb_gaji.pot_satu, tb_gaji.ket_satu,

		tb_gaji.pot_dua, tb_gaji.ket_dua
		FROM tb_penjualan, tb_penjualan_detail, tb_barang, tb_gaji WHERE tb_penjualan.kode_karyawan=tb_gaji.kode_karyawan GROUP by sub_total) z
                $condition ")->num_rows();

        return [$filtered, $total];
    }

	public function getAllGaji()
	{
		//SKRIP LAMA
// 		$data = $this->db->query("SELECT DISTINCT tb_gaji.kode_karyawan as kd,
// (SELECT SUM(tb_penjualan.jumlah_produk) from tb_penjualan WHERE tb_penjualan.kode_karyawan=kd AND tb_penjualan.tanggal_transaksi BETWEEN tb_gaji.tgl_start AND tb_gaji.tgl_end) as jml,
// (SELECT SUM(tb_penjualan.jumlah_produk*12000) from tb_penjualan WHERE tb_penjualan.kode_karyawan=kd AND tb_penjualan.tanggal_transaksi BETWEEN tb_gaji.tgl_start AND tb_gaji.tgl_end) as sub_total,
// tb_gaji.pot_bon, tb_gaji.ket_bon, tb_gaji.pot_satu, tb_gaji.ket_satu,
// tb_gaji.pot_dua, tb_gaji.ket_dua
// from tb_gaji, tb_penjualan, tb_karyawan WHERE tb_gaji.kode_penjualan=tb_penjualan.kode_penjualan AND tb_gaji.kode_karyawan=tb_karyawan.kode_karyawan");
		$data = $this->db->query("SELECT tb_penjualan.kode_karyawan as kd, 

		(SELECT SUM(tb_penjualan.jumlah_produk) from tb_penjualan WHERE tb_penjualan.kode_karyawan=kd AND tb_penjualan.tanggal_transaksi BETWEEN tb_gaji.tgl_start AND tb_gaji.tgl_end) as jml, 
			tb_gaji.tgl_start, tb_gaji.tgl_end,

		(SELECT SUM(    
		CASE
			WHEN tb_penjualan.jenis_pembayaran = 'K' THEN tb_penjualan_detail.qty*tb_barang.komisi_kredit
			ELSE tb_penjualan_detail.qty*tb_barang.komisi_cash
		END) FROM tb_penjualan, tb_penjualan_detail, tb_barang WHERE tb_penjualan.kode_karyawan=kd AND tb_penjualan_detail.kode_brg=tb_barang.kode_brg AND tb_penjualan.kode_penjualan=tb_penjualan_detail.kode_penjualan AND tb_penjualan.tanggal_transaksi BETWEEN tb_gaji.tgl_start AND tb_gaji.tgl_end
		) as sub_total,

		tb_gaji.pot_bon, tb_gaji.ket_bon, tb_gaji.pot_satu, tb_gaji.ket_satu,

		tb_gaji.pot_dua, tb_gaji.ket_dua
		FROM tb_penjualan, tb_penjualan_detail, tb_barang, tb_gaji WHERE tb_penjualan.kode_karyawan=tb_gaji.kode_karyawan GROUP by sub_total");
		return $data->result();
	}

	public function getGaji($id)
	{
		$data = $this->db->query("SELECT tb_penjualan.kode_karyawan as kd, tb_penjualan.kode_penjualan, 

(SELECT SUM(tb_penjualan.jumlah_produk) from tb_penjualan WHERE tb_penjualan.kode_karyawan=kd AND tb_penjualan.tanggal_transaksi BETWEEN tb_gaji.tgl_start AND tb_gaji.tgl_end) as jml, 

(SELECT SUM(    
CASE
    WHEN tb_penjualan.jenis_pembayaran = 'K' THEN tb_penjualan_detail.qty*tb_barang.komisi_kredit
    ELSE tb_penjualan_detail.qty*tb_barang.komisi_cash
END) FROM tb_penjualan, tb_penjualan_detail, tb_barang WHERE tb_penjualan.kode_karyawan=kd AND tb_penjualan_detail.kode_brg=tb_barang.kode_brg AND tb_penjualan.kode_penjualan=tb_penjualan_detail.kode_penjualan AND tb_penjualan.tanggal_transaksi BETWEEN tb_gaji.tgl_start AND tb_gaji.tgl_end
) as sub_total,

tb_gaji.pot_bon, tb_gaji.ket_bon, tb_gaji.pot_satu, tb_gaji.ket_satu,

tb_gaji.pot_dua, tb_gaji.ket_dua
FROM tb_penjualan, tb_penjualan_detail, tb_barang, tb_gaji WHERE tb_penjualan.kode_karyawan='$id' GROUP BY tb_penjualan.kode_karyawan");
		return $data->result();
	}

	public function getGajiDetail($id, $start)
	{
		$data = $this->db->query("SELECT DISTINCT tb_gaji.*, tb_penjualan_detail.qty as jml, tb_pelanggan.nama, tb_gaji.kode_penjualan pj, tb_penjualan.jenis_pembayaran as jns, tb_penjualan.bonus as bn, tb_pelanggan.alamat,
			CASE
			WHEN tb_penjualan.jenis_pembayaran = 'K' THEN tb_barang.komisi_kredit
			ELSE tb_barang.komisi_cash
			END as komisi,
			CASE
			WHEN tb_penjualan.jenis_pembayaran = 'K' THEN tb_penjualan_detail.qty*tb_barang.komisi_kredit
			ELSE tb_penjualan_detail.qty*tb_barang.komisi_cash
			END as sub_total,

			tb_gaji.pot_bon, tb_gaji.ket_bon, tb_gaji.pot_satu, tb_gaji.ket_satu,
			tb_gaji.pot_dua, tb_gaji.ket_dua

			FROM tb_penjualan, tb_gaji, tb_penjualan_detail, tb_barang, tb_pelanggan 
			WHERE 
			tgl_start='$start' AND 
			tb_gaji.kode_karyawan='$id' AND 
			tb_gaji.kode_penjualan=tb_penjualan_detail.kode_penjualan AND 
			tb_penjualan_detail.kode_brg=tb_barang.kode_brg AND
			tb_penjualan.kode_penjualan=tb_penjualan_detail.kode_penjualan AND
			tb_penjualan.kode_pelanggan=tb_pelanggan.kode_pelanggan");
		return $data->result();
	}

	public function getDetailBrg($kode_pen)
	{
		$data = $this->db->query("SELECT tb_penjualan_detail.*,
			CASE
				WHEN tb_penjualan.jenis_pembayaran = 'K' THEN tb_barang.komisi_kredit
				ELSE tb_barang.komisi_cash
			END as komisi,
			CASE
				WHEN tb_penjualan.jenis_pembayaran = 'K' THEN tb_penjualan_detail.qty*tb_barang.komisi_kredit
				ELSE tb_penjualan_detail.qty*tb_barang.komisi_cash
			END as sub_total

			FROM tb_penjualan, tb_penjualan_detail, tb_barang WHERE tb_penjualan_detail.kode_penjualan='$kode_pen' GROUP by tb_barang.kode_brg")->result();	
	}

	public function getAllData()
	{
		$data = $this->db->get('tb_gaji');
		return $data->result();
	}

	public function insertData($arrData)
	{
		$data = $this->db->insert('tb_gaji', $arrData);
		if($data)
			return true;
		else
			return false;
	}

	public function getData($id)
	{
		return $this->db->get_where('tb_gaji', array('kode_karyawan' => $id))->row();
	}

	public function updateData($arrData)
	{
		$data = $this->db->replace('tb_gaji', $arrData);
		if($data)
			return true;
		else
			return false;
	}

	public function deleteData($id, $start)
	{
		return $this->db->delete('tb_gaji', array('kode_karyawan' => $id, 'tgl_start' => $start));
	}
	
}
?>