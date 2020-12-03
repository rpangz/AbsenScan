<?php
	class Master_User_model extends CI_Model
	{
	

	  function add() {

	  	$error = false;
	  	$errmsg = "";

	  	$this->load->helper('date');
	  	$this->form_validation->set_rules('NIK', 'NIK', 'trim|required|numeric');
	  	$this->form_validation->set_rules('nama', 'Nama', 'trim|required');
	  	$this->form_validation->set_rules('department', 'Department', 'trim|required');
	  	$this->form_validation->set_rules('jabatan', 'Jabatan', 'trim|required');
	  	$this->form_validation->set_rules('status', 'Status', 'trim|required');
	  	$this->form_validation->set_error_delimiters('=> ', ' | ');

	  	
	  	$createuser = $this->session->userdata('nik');

	  	$NIK = $this->input->post('NIK');	
  		//$tglmasuk = date('Y-m-d',strtotime($tglmasuk));	  		
		$nama = $this->input->post('nama');
		$department = $this->input->post('department');
		$jabatan = $this->input->post('jabatan');
		$status = $this->input->post('status');
		$tipe = $this->input->post('typeform');
		$password =  password_hash('password.123', PASSWORD_DEFAULT);

		if($tipe=="ADD") {
	  		$this->form_validation->set_rules('NIK', 'NIK', 'trim|required|numeric|is_unique[secure_user_register.nik]',['is_unique' => 'NIK sudah pernah di input ']);
	  	}

/*
		$query = $this->db->query("SELECT * FROM secure_user_register WHERE nik = '".$NIK."'");
		$jumlahdata = $query->num_rows();
	  
		if($jumlahdata>0 && $tipe=="ADD"){
			$error = true;
			$errmsg .= "- NIK Sudah Pernah Di Input";
		}
*/
		if($this->form_validation->run() == FALSE) {
			$error = true;
			$errmsg .= validation_errors();	
		}		

	  	
	  	if($error) {
	  		echo "NO|".$errmsg;
	  	} else {

	  		if($tipe=="ADD"){
	  			$data = array(
					'nik' => $NIK,
					'nama' => strtoupper($nama), 
					'password' => $password, 
					'department' => $department, 
					'jabatan' => $jabatan,
					'createuser' => $createuser,
					'status' => $status
				);
				$this->db->set('createtime', 'NOW()', FALSE);
				$result = $this->db->insert('secure_user_register', $data);		
	  		} else {
	  			$data = array(					
					'nama' => strtoupper($nama), 
					'department' => $department, 
					'jabatan' => $jabatan,
					'createuser' => $createuser,
					'status' => $status
				);
				$this->db->set('createtime', 'NOW()', FALSE);
				$result = $this->db->where('nik', $NIK)
							   	   ->update('secure_user_register', $data);
	  		}
			if($result){ echo "OK|Data Berhasil Di Simpan"; } else { echo "NO|Data Gagal Di Simpan"; }					
	  	}
	}


	function hapus() {
	  	$error = false;
	  	$errmsg = "";
	  	$key_data = $this->input->post('key_data');	
		$result = $this->db->where('nik',$key_data)
						   ->delete('secure_user_register');						 
		if($result){ echo "OK"; } else { echo "NO"; }						  	
	}

	function resetpassword() {

		$key_data = $this->input->post('key_data');	
		$password =  password_hash('password.123', PASSWORD_DEFAULT);
		$data = array(					
					'password' => $password 					
				);	  	
		$this->db->set('createtime', 'NOW()', FALSE);
				$result = $this->db->where('nik', $key_data)
							   	   ->update('secure_user_register', $data);					 
		if($result){ echo "OK"; } else { echo "NO"; }						  	
	}

	function loadtable(){

	  $this->db->select('CAST(nik AS CHAR) nik,nama,dept_name,jabatan_name,statusname');
      $this->db->from('secure_user_register');
      $this->db->join('master_department', 'secure_user_register.department = master_department.dept_id');
      $this->db->join('master_jabatan', 'secure_user_register.jabatan = master_jabatan.jabatan_id');
      $this->db->join('list_status', 'secure_user_register.status = list_status.id_status');
      $datatable = $this->db->get()->result();
      $datatable = '{"data":'.json_encode($datatable) .'}';
      echo $datatable;

	}


	function GetDepartment(){
	      $this->db->select('*');
	      $this->db->from('master_department');
	      $this->db->where('status','1');
	      $department = $this->db->get()->result_array();
	      return $department;
	  }


	function GetJabatan(){
	      $this->db->select('*');
	      $this->db->from('master_jabatan');
	      $this->db->where('status','1');
	      $jabatan = $this->db->get()->result_array();
	      return $jabatan;
	  }

	function editloaddata(){

		  $NIK = $this->input->post('key_data');
	      $this->db->select('*');
	      $this->db->from('secure_user_register');
	      $this->db->where('nik',$NIK);
	      $userdata = $this->db->get()->result_array();
	      echo json_encode($userdata);
	  } 



	
}


?>
