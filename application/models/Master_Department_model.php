<?php
	class Master_Department_model extends CI_Model
	{
	

	  function add() {

	  	$error = false;
	  	$errmsg = "";

	  	//jangan di ubah ================================
	  	$tipe = $this->input->post('typeform');
	  	$createuser = $this->session->userdata('nik');
	  	//===============================================

	  	$this->load->helper('date');
	  	$this->form_validation->set_rules('department', 'Nama Department', 'trim|required');
	  	$this->form_validation->set_rules('status', 'Status', 'trim|required');
	  	$this->form_validation->set_error_delimiters('=> ', ' | ');


	  	
	  	

	  	$department = strtoupper($this->input->post('department'));	
  		//$tglmasuk = date('Y-m-d',strtotime($tglmasuk));	  		
		$status = $this->input->post('status');
		$editkeyvalue = $this->input->post('editkeyvalue');
		
		if($tipe=="ADD") {
	  		$this->form_validation->set_rules('department', 'Nama Department', 'trim|required|is_unique[master_department.dept_name]',['is_unique' => 'Department sudah pernah di input ']);
	  	}

		if($this->form_validation->run() == FALSE) {
			$error = true;
			$errmsg .= validation_errors();	
		}		

	  	
	  	if($error) {
	  		echo "NO|".$errmsg;
	  	} else {

	  		if($tipe=="ADD"){
	  			$data = array(					
					'dept_name' => $department, 
					'createuser' => $createuser, 
					'status' => $status,					
				);
				$this->db->set('createtime', 'NOW()', FALSE);
				$result = $this->db->insert('master_department', $data);		
	  		} else {
	  			$data = array(					
					'dept_name' => $department, 
					'createuser' => $createuser, 
					'status' => $status,					
				);
				$this->db->set('createtime', 'NOW()', FALSE);
				$result = $this->db->where('dept_id', $editkeyvalue)
							   	   ->update('master_department', $data);
	  		}
			if($result){ echo "OK|Data Berhasil Di Simpan"; } else { echo "NO|Data Gagal Di Simpan"; }					
	  	}
	}


	function hapus() {
	  	$error = false;
	  	$errmsg = "";
	  	$key_data = $this->input->post('key_data');	
		$result = $this->db->where('dept_id',$key_data)
						   ->delete('master_department');						 
		if($result){ echo "OK"; } else { echo "NO"; }						  	
	}




	function loadtable(){

	  $this->db->select('master_department.dept_id, dept_name, statusname');
      $this->db->from('master_department');
      $this->db->join('list_status', 'master_department.status = list_status.id_status');

      $datatable = $this->db->get()->result();
      $datatable = '{"data":'.json_encode($datatable) .'}';
      echo $datatable;

	}


	function GetFormHeader(){
	      $this->db->select('*');
	      $this->db->from('master_formheader');
	      $this->db->where('formstatus','1');
	      $arrvar = $this->db->get()->result_array();
	      return $arrvar;
	  }


	
	// JANGAN DI UBAH ==================================  
	function editloaddata(){

		  $key_data = $this->input->post('key_data');

	      $this->db->select('*');
	      $this->db->from('master_department');
	      $this->db->where('dept_id',$key_data);
	      $key_data_val = $this->db->get()->result_array();
	      echo json_encode($key_data_val);
	  } 
	  // ===============================================


	
}


?>
