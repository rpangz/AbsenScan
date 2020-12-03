<?php
	class Support_Form_Akses_model extends CI_Model
	{
	

	  function add() {

	  	$error = false;
	  	$errmsg = "";

	  	//jangan di ubah ================================
	  	$tipe = $this->input->post('typeform');
	  	$createuser = $this->session->userdata('nik');
	  	$editkeyvalue = $this->input->post('editkeyvalue');
	  	//===============================================

	  	$this->load->helper('date');
	  	$this->form_validation->set_rules('namamenu', 'Nama Menu', 'trim|required');
	  	$this->form_validation->set_rules('department', 'Nama Department', 'trim|required');
	  	$this->form_validation->set_rules('jabatan', 'Nama Jabatan', 'trim|required');
	  	$this->form_validation->set_rules('status', 'Status', 'trim|required');
	  	$this->form_validation->set_error_delimiters('=> ', ' | ');

/*
	  	if($tipe=="ADD") {
	  		$this->form_validation->set_rules('formname', 'Nama Form', 'trim|required|is_unique[secure_form_register.formname]',['is_unique' => 'Nama Form sudah pernah di input ']);
	  	}
	  	
*/	  	

	  	$menu = $this->input->post('namamenu');	  		
		$department = $this->input->post('department');
		$jabatan = $this->input->post('jabatan');
		$status = $this->input->post('status');
		
		/*cek data yang sudah ada */
		$this->db->select('*');
        $this->db->from('secure_form_akses');
        $this->db->where('id_form', $menu);
		$this->db->where('formdepartment', $department);
		$this->db->where('formjabatan', $jabatan);
        $arrvar = $this->db->get()->num_rows();
        /*===========================================*/

		if($this->form_validation->run() == FALSE) {
			$error = true;
			$errmsg .= validation_errors();	
		}

		if($arrvar>0) {
			$error = true;
			$errmsg .= 'Data sudah pernah di input!';		
		}		

	  	
	  	if($error) {
	  		echo "NO|".$errmsg;
	  	} else {

	  		if($tipe=="ADD"){
	  			$data = array(					
					'id_form' => $menu, 
					'formdepartment' => $department, 
					'formjabatan' => $jabatan, 
					'formstatus' => $status,					
				);
				//$this->db->set('createtime', 'NOW()', FALSE);
				$result = $this->db->insert('secure_form_akses', $data);		
	  		} else {
	  			$data = array(										
					'formstatus' => $status,					
				);
				//$this->db->set('createtime', 'NOW()', FALSE);
				$result = $this->db->where('id_form', $menu)
								   ->where('formdepartment', $department)
								   ->where('formjabatan', $jabatan)	
							   	   ->update('secure_form_akses', $data);
	  		}
			if($result){ echo "OK|Data Berhasil Di Simpan"; } else { echo "NO|Data Gagal Di Simpan"; }					
	  	}
	}


	function hapus() {
	  	$error = false;
	  	$errmsg = "";
	  	$key_data = $this->input->post('key_data');	
	  	$key_data2 = $this->input->post('key_data2');
	  	$key_data3 = $this->input->post('key_data3');

		$result =  $this->db->where('id_form',$key_data)
							->where('formdepartment',$key_data2)
							->where('formjabatan',$key_data3)	
						    ->delete('secure_form_akses');						 
		if($result){ echo "OK"; } else { echo "NO"; }						  	
	}




	function loadtable(){

	  $this->db->select('secure_form_akses.id_form AS id_form_akses,formname, dept_id, dept_name,jabatan_id, jabatan_name, statusname');
      $this->db->from('secure_form_akses');
      $this->db->join('secure_form_register', 'secure_form_akses.id_form = secure_form_register.id_form');
      $this->db->join('master_department', 'secure_form_akses.formdepartment = master_department.dept_id');
      $this->db->join('master_jabatan', 'secure_form_akses.formjabatan = master_jabatan.jabatan_id');
      $this->db->join('list_status', 'secure_form_akses.formstatus = list_status.id_status');

      $datatable = $this->db->get()->result();
      $datatable = '{"data":'.json_encode($datatable) .'}';
      echo $datatable;

	}

	
	// JANGAN DI UBAH ==================================  
	function editloaddata(){

		  $key_data = $this->input->post('key_data');
		  $key_data2 = $this->input->post('key_data2');
		  $key_data3 = $this->input->post('key_data3');

	      $this->db->select('*');
	      $this->db->from('secure_form_akses');
	      $this->db->where('id_form',$key_data);
	      $this->db->where('formdepartment',$key_data2);
	      $this->db->where('formjabatan',$key_data3);

	      $key_data_val = $this->db->get()->result_array();
	      echo json_encode($key_data_val);
	  } 
	  // ===============================================

	  function GetMenu(){
	      $this->db->select('*');
	      $this->db->from('secure_form_register');
	      $this->db->join('master_formheader','secure_form_register.formheader=master_formheader.id_form');
	      $this->db->where('secure_form_register.formstatus','1');
	      $this->db->where('master_formheader.formstatus','1');
	      $this->db->order_by('ordinal', 'ASC');
	      $this->db->order_by('formname', 'ASC');
	      $arrvar = $this->db->get()->result_array();
	      return $arrvar;
	  }

	  function GetDepartment(){
	      $this->db->select('*');
	      $this->db->from('master_department');
	      $this->db->where('status','1');
	      $arrvar = $this->db->get()->result_array();
	      return $arrvar;
	  }

	  function GetJabatan(){
	      $this->db->select('*');
	      $this->db->from('master_jabatan');
	      $this->db->where('status','1');
	      $arrvar = $this->db->get()->result_array();
	      return $arrvar;
	  }
	
}


?>
