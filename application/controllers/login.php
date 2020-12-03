<?php
defined('BASEPATH') or exit('No direct script access allowed');

class login extends MY_Controller
{

	function index()
	{
		$this->form_validation->set_rules('username', 'USERNAME', 'trim|required');
		$this->form_validation->set_rules('password', 'USERNAME', 'trim|required');

		if ($this->form_validation->run() == FALSE) {
			$data['list_lokasi_header'] =  $this->GetLokasiHeader();
			$this->load->view('login.php', $data);
		} else {
			$this->_ceklogin();
		}
	}

	function GetLokasiHeader()
	{

		$this->db->select('*')
			->from('list_lokasi_header')
			->where('status', "1");
		$list_lokasi_header = $this->db->get()->result();

		return $list_lokasi_header;
	}

	private function _ceklogin()
	{
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$gedung = $this->input->post('gedung');
		$error = false;

		$this->db->select('*')
			->from('tbl_main_user_scan')
			->where('user_name', $username);
		$user = $this->db->get()->row_array();
		$databasepass = $user['password'];
		$nikid = $user['user_id'];

		if ($gedung == "0") {
			$error = true;
			$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Lokasi Belum Di Pilih</div> ');
			redirect('login');
		}

		if ($user && !$error) {
			$password = md5($password);
			if ($password == $databasepass) {
				$data = array(
					'username' => $username,
					'gedung' => $gedung,
				);

				$this->session->set_userdata($data);
				redirect('main');
			} else {
				$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Password Salah!</div> ');
				redirect('login');
			}
		} else {
			$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Username tidak terdaftar!</div> ');
			redirect('login');
		}
	}

	public function logout()
	{
		$this->session->unset_userdata('username');
		$this->session->unset_userdata('gedung');
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="success">Anda Telah Log Out !</div> ');
		redirect('login');
	}
}
