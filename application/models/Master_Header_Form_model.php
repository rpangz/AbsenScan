<?php
	class Master_Header_Form_model extends CI_Model
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

	  	$this->form_validation->set_rules('headername', 'Form Header', 'trim|required');
	  	$this->form_validation->set_rules('glyphicon', 'Icon', 'trim|required');
	  	$this->form_validation->set_rules('ordinal', 'Posisi', 'trim|required|numeric');
	  	$this->form_validation->set_rules('status', 'Status', 'trim|required');
	  	$this->form_validation->set_error_delimiters('=> ', ' | ');


	  	$headername = $this->input->post('headername');	
	  	$glyphicon = $this->input->post('glyphicon');	
	  	$ordinal = $this->input->post('ordinal');		  		
		$status = $this->input->post('status');
		
		
		if($tipe=="ADD") {
	  		$this->form_validation->set_rules('headername', 'Form Header', 'trim|required|is_unique[master_formheader.headername]',['is_unique' => 'Form Header sudah pernah di input ']);
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
					'headername' => $headername, 
					'glyph' => $glyphicon,
					'ordinal' => $ordinal,
					'createuser' => $createuser, 
					'formstatus' => $status,					
				);
				$this->db->set('createtime', 'NOW()', FALSE);
				$result = $this->db->insert('master_formheader', $data);		
	  		} else {
	  			$data = array(					
					'headername' => $headername, 
					'glyph' => $glyphicon,
					'ordinal' => $ordinal,
					'createuser' => $createuser, 
					'formstatus' => $status,					
				);
				$this->db->set('createtime', 'NOW()', FALSE);
				$result = $this->db->where('id_form', $editkeyvalue)
							   	   ->update('master_formheader', $data);
	  		}
			if($result){ echo "OK|Data Berhasil Di Simpan"; } else { echo "NO|Data Gagal Di Simpan"; }					
	  	}
	}


	function hapus() {
	  	$error = false;
	  	$errmsg = "";
	  	$key_data = $this->input->post('key_data');	
		$result = $this->db->where('id_form',$key_data)
						   ->delete('master_formheader');						 
		if($result){ echo "OK"; } else { echo "NO"; }						  	
	}




	function loadtable(){

	  $this->db->select('master_formheader.id_form, headername, glyph, ordinal, statusname');
      $this->db->from('master_formheader');
      $this->db->join('list_status', 'master_formheader.formstatus = list_status.id_status');
      $datatable = $this->db->get()->result();
      $datatable = '{"data":'.json_encode($datatable) .'}';
      echo $datatable;

	}



	function editloaddata(){

		  $NIK = $this->input->post('key_data');
	      $this->db->select('*');
	      $this->db->from('master_formheader');
	      $this->db->where('id_form',$NIK);
	      $userdata = $this->db->get()->result_array();
	      echo json_encode($userdata);
	  } 



	
}


?>
