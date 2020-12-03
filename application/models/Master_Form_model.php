<?php
	class Master_Form_model extends CI_Model
	{
	

	  function add() {

	  	$error = false;
	  	$errmsg = "";

	  	//jangan di ubah ================================
	  	$tipe = $this->input->post('typeform');
	  	$createuser = $this->session->userdata('nik');
	  	//===============================================

	  	$this->load->helper('date');
	  	$this->form_validation->set_rules('formname', 'Nama Form', 'trim|required');
	  	$this->form_validation->set_rules('formtitle', 'Nama Title', 'trim|required');
	  	$this->form_validation->set_rules('formheader', 'Nama Header', 'trim|required');
	  	$this->form_validation->set_rules('status', 'Status', 'trim|required');
	  	$this->form_validation->set_error_delimiters('=> ', ' | ');

	  	if($tipe=="ADD") {
	  		$this->form_validation->set_rules('formname', 'Nama Form', 'trim|required|is_unique[secure_form_register.formname]',['is_unique' => 'Nama Form sudah pernah di input ']);
	  	}
	  	
	  	

	  	$formname = $this->input->post('formname');	
  		//$tglmasuk = date('Y-m-d',strtotime($tglmasuk));	  		
		$formtitle = $this->input->post('formtitle');
		$formheader = $this->input->post('formheader');
		$status = $this->input->post('status');
		$editkeyvalue = $this->input->post('editkeyvalue');
		


		if($this->form_validation->run() == FALSE) {
			$error = true;
			$errmsg .= validation_errors();	
		}		

	  	
	  	if($error) {
	  		echo "NO|".$errmsg;
	  	} else {

	  		if($tipe=="ADD"){
	  			$data = array(					
					'formname' => $formname, 
					'formtitle' => $formtitle, 
					'formheader' => $formheader, 
					'formstatus' => $status,					
				);
				//$this->db->set('createtime', 'NOW()', FALSE);
				$result = $this->db->insert('secure_form_register', $data);		
	  		} else {
	  			$data = array(					
					'formname' => $formname, 
					'formtitle' => $formtitle, 
					'formheader' => $formheader, 
					'formstatus' => $status,					
				);
				//$this->db->set('createtime', 'NOW()', FALSE);
				$result = $this->db->where('id_form', $editkeyvalue)
							   	   ->update('secure_form_register', $data);
	  		}
			if($result){ echo "OK|Data Berhasil Di Simpan"; } else { echo "NO|Data Gagal Di Simpan"; }					
	  	}
	}


	function hapus() {
	  	$error = false;
	  	$errmsg = "";
	  	$key_data = $this->input->post('key_data');	
		$result = $this->db->where('id_form',$key_data)
						   ->delete('secure_form_register');						 
		if($result){ echo "OK"; } else { echo "NO"; }						  	
	}




	function loadtable(){

	  $this->db->select('secure_form_register.id_form, formname, formtitle, headername, statusname');
      $this->db->from('secure_form_register');
      $this->db->join('master_formheader', 'secure_form_register.formheader = master_formheader.id_form');
      $this->db->join('list_status', 'secure_form_register.formstatus = list_status.id_status');

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
	      $this->db->from('secure_form_register');
	      $this->db->where('id_form',$key_data);
	      $key_data_val = $this->db->get()->result_array();
	      echo json_encode($key_data_val);
	  } 
	  // ===============================================


	
}


?>
