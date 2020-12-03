<?php
	class Report_Assesment_model extends CI_Model
	{
	

	 

	function loadtable(){
/*
	  $this->db->select('master_jabatan.jabatan_id, jabatan_name, statusname');
      $this->db->from('tbl_eca_data');
      $this->db->where('NIK',$this->session->userdata('nik'));
      $datatable = $this->db->get()->result();
*/
      $mysqlcomm = "SELECT data_id,DATE_FORMAT(createdtime,'%d-%m-%Y %H:%i:%s') tanggal,keluarrumah,transportasi,keluarkota,kegiatan,kontak,kondisi,kesimpulan,CASE WHEN DATE(createdtime)=curdate() THEN 'now' ELSE 'pass' END checkdate FROM view_data_assesment WHERE NIK = '".$this->session->userdata('nik')."' AND status='1' ORDER BY DATE(createdtime) DESC";
      //$mysqlcomm = "SELECT DATE_FORMAT(createdtime,'%d-%m-%Y %H:%i:%s') tanggal,keluarrumah FROM tbl_eca_data WHERE NIK = '".$this->session->userdata('nik')."'";
      $query = $this->db->query($mysqlcomm);
	  $datatable = $query->result();	      
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
