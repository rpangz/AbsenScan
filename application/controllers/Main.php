<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Main extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('gedung')) header("location: " . base_url('login'));
	}

	function index()
	{

		$gedung = $this->session->userdata('gedung');
		$data['gedung'] = $this->cms_table_data($table_name = 'list_lokasi_header', $where_column = 'id_gedung', $result_column = 'nama_gedung', $gedung);
		$data['gedung_alamat'] = $this->cms_table_data($table_name = 'list_lokasi_header', $where_column = 'id_gedung', $result_column = 'alamat_gedung', $gedung);
		$data['judul'] = "Astel Group";
		$this->load->view('main', $data);
	}

	function cek_kapasitas_gedung()
	{

		$gedung = $this->session->userdata('gedung');
		$mysqlcomm = "SELECT * FROM tbl_eca_data WHERE status = 1 AND status_in = 'IN' AND lokasi_in = '" . $gedung . "' AND DATE(jam_in) = current_date()";
		$query = $this->db->query($mysqlcomm);
		$total_masuk = $query->num_rows();
		$total_kapasitas = $this->cms_table_data($table_name = 'list_lokasi_header', $where_column = 'id_gedung', $result_column = 'kapasitas', $gedung);
		$sisa_kapasitas = $total_kapasitas - $total_masuk;
		$persentase = round(($total_masuk / $total_kapasitas) * 100);

		$output = array(
			"total_kapasitas" => $total_kapasitas,
			"total_masuk" => $total_masuk,
			"sisa_kapasitas" => $sisa_kapasitas,
			"persentase" => $persentase,
		);

		echo json_encode($output);
	}

	function post_scan()
	{
		$dataqrcode = $this->input->post('data_id');
		// $dataqrcode = $this->input->get('data_id');
		$gedung = $this->session->userdata('gedung');


		//untuk cek data ada atau tidak
		$mysqlcomm = "SELECT * FROM tbl_eca_data WHERE dataqrcode = '" . $dataqrcode . "' AND DATE(createdtime)=current_date";



		$query = $this->db->query($mysqlcomm);
		$data = $query->row();
		$total = $query->num_rows();
		//======================================================================================

		$error = false;
		$errormsg = "";
		$nik = "";
		$Nama = "";
		$companyid = "";
		$divid = "";
		$deptid = "";
		$score = "";
		$risiko = "";
		$jam = "";
		$keterangan = "";
		$gedungname = "";
		$image_in = "";
		$tglskg = "";
		$latgeo = "";
		$longgeo = "";



		if ($total < 1 || strlen($gedung) < 1) {
			$error = true;
			$errormsg = "Data tidak ditemukan!!!";
		} else {

			$data_id = $data->data_id;
			$latgeo = $this->cms_table_data($table_name = 'list_lokasi_header', $where_column = 'id_gedung', $result_column = 'latgeo', $gedung);
			$longgeo = $this->cms_table_data($table_name = 'list_lokasi_header', $where_column = 'id_gedung', $result_column = 'longgeo', $gedung);

			$mysqlcomm = "SELECT status_in,lokasi_in,jam_in FROM tbl_eca_data WHERE data_id = '" . $data_id . "'";
			$query = $this->db->query($mysqlcomm);
			$dataold = $query->row();

			$status_in_old = $dataold->status_in;
			$jam_in_old = $dataold->jam_in;
			$lokasi_in_old = $dataold->lokasi_in;

			$this->db->trans_start();

			// $data = array(
			// 	'status_in' => $status_in_old,
			// 	'lokasin_in_old' => $lokasi_in_old,
			// 	'gedung' => $gedung
			// );

			// var_dump($data);
			// die();

			if ($status_in_old == "IN" && $lokasi_in_old <> $gedung) {
				$in_gedung_lain = true;
				$status_in = "IN";
			} else {
				$in_gedung_lain = false;
				if ($data->status_in == "IN") {
					$status_in = "OUT";
				} else {
					$status_in = "IN";
				}
			}

			$mysqlcommupdate = "UPDATE tbl_eca_data SET status_in='" . $status_in . "',jam_in=now(),lokasi_in='" . $gedung . "',scan_status='1'
			WHERE data_id = '" . $data_id . "'";
			$query = $this->db->query($mysqlcommupdate);

			//Insert jika karyawan keluar di gedung lain
			if ($in_gedung_lain) {
				$datainsert = array(
					'id_eca' => $data_id,
					'nik' => $data->NIK,
					'in_out' => 'OUT',
					'lokasi' => $lokasi_in_old,
					'createdtime' => $this->cms_table_data($table_name = 'tbl_eca_data', $where_column = 'data_id', $result_column = 'jam_in', $data_id),
					'jenis' => 'QRSCAN',
				);
				$result = $this->db->insert('tbl_eca_absen', $datainsert);
			}

			$data_update = array(
				'id_eca' => $data_id,
				'nik' => $data->NIK,
				'in_out' => $status_in,
				'lokasi' => $gedung,
				'createdtime' => $this->cms_table_data($table_name = 'tbl_eca_data', $where_column = 'data_id', $result_column = 'jam_in', $data_id),
				'jenis' => 'QRSCAN',
			);
			$result = $this->db->insert('tbl_eca_absen', $data_update);


			if ($status_in == "IN") {
				$check_in = $this->cms_table_data($table_name = 'tbl_eca_data', $where_column = 'data_id', $result_column = 'check_in', $data_id);
				if (strlen($check_in) < 1) {
					$mysqlcommupdate = "UPDATE tbl_eca_data 
										SET check_in=now(),latgeo='" . $latgeo . "',longgeo='" . $longgeo . "',errgeo='-'
										WHERE data_id = '" . $data_id . "'";
					$query = $this->db->query($mysqlcommupdate);
				}
			}

			if ($status_in == "OUT") {
				$mysqlcommupdate = "UPDATE tbl_eca_data 
									SET check_out=now(),latgeo_out='" . $latgeo . "',longgeo_out='" . $longgeo . "',errgeo_out='-'
									WHERE data_id = '" . $data_id . "'";
				$query = $this->db->query($mysqlcommupdate);
			}


			$this->db->trans_complete();

			if ($result) {
				$nik = $data->NIK;
				$Nama = $this->cms_table_data($table_name = 'tbl_profile', $where_column = 'NIK', $result_column = 'Nama', $nik);
				$companyid = $this->cms_table_data($table_name = 'federated_tbl_company', $where_column = 'iCompanyId', $result_column = 'cCompanyName', $data->CompanyId);
				$divid = $this->cms_table_data($table_name = 'federated_tbl_div', $where_column = 'iDivId', $result_column = 'cDivName', $data->DivisiId);
				$deptid = $this->cms_table_data($table_name = 'federated_tbl_dept', $where_column = 'iDeptID', $result_column = 'cDeptName', $data->DeptId);
				$score = $data->score;
				$risiko = $data->kesimpulan;
				$jam = $this->cms_table_data($table_name = 'tbl_eca_data', $where_column = 'data_id', $result_column = 'jam_in', $data_id);
				$jam = date('d-m-Y H:i', strtotime($jam));
				$keterangan = $status_in;
				$gedungname = $this->cms_table_data($table_name = 'list_lokasi_header', $where_column = 'id_gedung', $result_column = 'nama_gedung', $gedung);
				$image_in = $data->image_in;
				$tglskg = $this->cms_table_data($table_name = 'tbl_eca_data', $where_column = 'data_id', $result_column = 'createdtime', $data_id);
				$tglskg = date('Ymd', strtotime($tglskg));
			} else {
				$error = true;
				$errormsg = "Gagal update data";
			}
		}

		$output = array(
			"error" => $error,
			"errormsg" => $errormsg,
			"nik" => $nik,
			"nama" => $Nama,
			"companyid" => $companyid,
			"divid" => $divid,
			"deptid" => $deptid,
			"score" => $score,
			"risiko" => $risiko,
			"jam" => $jam,
			"keterangan" => $keterangan,
			"gedungname" => $gedungname,
			"image_in" => $image_in,
			"tglskg" => $tglskg,
		);

		echo json_encode($output);
	}




	private function cms_table_data($table_name, $where_column, $result_column, $value)
	{

		$this->db->select($result_column)->from($table_name)->where($where_column, $value);
		$db      = $this->db->get();
		$data    = $db->row(0);
		$num_row = $db->num_rows();

		if ($num_row > 0) {
			return $data->$result_column;
		} else {
			return '-';
		}
	}
}
