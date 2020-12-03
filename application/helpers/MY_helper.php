<?php

function cek_login(){
	$that = get_instance();
	if(!$that->session->userdata('nik')) {
		//header("location: ".base_url('login'));	
		redirect('login');
	} else {
		$department = $that->session->userdata('department');
		$jabatan = $that->session->userdata('jabatan');
		$controller = $that->uri->segment(1);
		 $that->db->select('*')
	 	 ->from('secure_form_register')
	 	 ->join('secure_form_akses','secure_form_register.id_form=secure_form_akses.id_form')
	 	 ->where('formdepartment',$department)
	 	 ->where('formjabatan',$jabatan)
	 	 ->where('secure_form_register.formname',$controller);
	     $arrvar = $that->db->get()->num_rows();
	     if($arrvar<1) {
	     	redirect('Main');
	     } 
	}
}


function GetStatusList(){
	$that = get_instance();
	$that->db->select('*');
    $that->db->from('list_status');
    $status = $that->db->get()->result_array();
    return $status;
}

function GetJudul($nama) {
		 $that = get_instance();
         $that->db->select('*');
         $that->db->from('secure_form_register');
         $that->db->where('formname', $nama);
         $judul = $that->db->get()->result();  
	     foreach ($judul as $variant){
	        $namajudul = $variant->formtitle;                
	      } 
	      return $namajudul;
    }