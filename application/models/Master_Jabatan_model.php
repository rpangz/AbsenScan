<?php
	class Master_Jabatan_model extends CI_Model
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
	  	$this->form_validation->set_rules('jabatan', 'Nama Jabatan', 'trim|required');
	  	$this->form_validation->set_rules('status', 'Status', 'trim|required');
	  	$this->form_validation->set_error_delimiters('=> ', ' | ');


	  	$jabatan = strtoupper($this->input->post('jabatan'));	
  		//$tglmasuk = date('Y-m-d',strtotime($tglmasuk));	  		
		$status = $this->input->post('status');
		
		
		if($tipe=="ADD") {
	  		$this->form_validation->set_rules('jabatan', 'Nama Jabatan', 'trim|required|is_unique[master_jabatan.jabatan_name]',['is_unique' => 'Jabatan sudah pernah di input ']);
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
					'jabatan_name' => $jabatan, 
					'createuser' => $createuser, 
					'status' => $status,					
				);
				$this->db->set('createtime', 'NOW()', FALSE);
				$result = $this->db->insert('master_jabatan', $data);		
	  		} else {
	  			$data = array(					
					'jabatan_name' => $jabatan, 
					'createuser' => $createuser, 
					'status' => $status,					
				);
				$this->db->set('createtime', 'NOW()', FALSE);
				$result = $this->db->where('jabatan_id', $editkeyvalue)
							   	   ->update('master_jabatan', $data);
	  		}
			if($result){ echo "OK|Data Berhasil Di Simpan"; } else { echo "NO|Data Gagal Di Simpan"; }					
	  	}
	}


	function hapus() {
	  	$error = false;
	  	$errmsg = "";
	  	$key_data = $this->input->post('key_data');	
		$result = $this->db->where('jabatan_id',$key_data)
						   ->delete('master_jabatan');						 
		if($result){ echo "OK"; } else { echo "NO"; }						  	
	}




	function loadtable(){

	  $this->db->select('master_jabatan.jabatan_id, jabatan_name, statusname');
      $this->db->from('master_jabatan');
      $this->db->join('list_status', 'master_jabatan.status = list_status.id_status');

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
	      $this->db->from('master_jabatan');
	      $this->db->where('jabatan_id',$key_data);
	      $key_data_val = $this->db->get()->result_array();
	      echo json_encode($key_data_val);
	  } 
	  // ===============================================


	
}


?>
