<?php
	class Laporan_pemasukan_bank_model extends CI_Model
	{
		public function GetJudul($nama) {
		  $this->db->select('*');
	      $this->db->from('secure_form_akses');
	      $this->db->where('formname', $nama);
	      $judul = $this->db->get()->result();	
	     foreach ($judul as $variant){
            $namajudul = $variant->nama;                
          } 
          return $namajudul;
		}	

	  function GetRekening(){
	      $this->db->select('*');
	      $this->db->from('list_rekening');
	      $this->db->where('status', '+');
	      $rekening = $this->db->get();
	      return $rekening;
	  }

	  function add() {
	  	$this->load->helper('date');
	  	$this->form_validation->set_rules('rekening', 'Rekening', 'trim|required');
	  	$this->form_validation->set_rules('jenistransaksi', 'Jenis Transaksi', 'trim|required');
	  	$this->form_validation->set_rules('nominal', 'Nominal', 'trim|required');
	  	$this->form_validation->set_rules('noref', 'Noref', 'trim|required');
	  	$this->form_validation->set_rules('tglmasuk', 'Tgl Masuk', 'trim|required');

	  	$tglmasuk = $this->input->post('tglmasuk');	
  		$tglmasuk = date('Y-m-d',strtotime($tglmasuk));	  		
		$rekening = $this->input->post('rekening');
		$jenistransaksi = $this->input->post('jenistransaksi');
		$nominal = $this->input->post('nominal');
		$keterangan = $this->input->post('keterangan');
		$noref = $this->input->post('noref');

	  	$scr = "SELECT SUM(debet)-SUM(credit) saldo FROM (
				SELECT CASE WHEN jenistrx = 'DEBET' THEN nominal ELSE 0 END debet,
				CASE WHEN jenistrx = 'CREDIT' THEN nominal ELSE 0 END credit 
				FROM tr_pemasukan_bank WHERE rekening = '".$rekening."' AND tglmasuk<='".$tglmasuk."') a";		
				$query = $this->db->query($scr);
				foreach ($query->result() as $row)
				{
				        $saldobank = $row->saldo;
				}

		if($saldobank<$nominal && $jenistransaksi=="CREDIT") {
			$errmsg = "NO|NOMINAL ADJUSTMEN KURANG DARI SALDO";
	  		echo $errmsg;
	  		exit;	
		}


	  	if ($this->form_validation->run() == FALSE) {
	  			$errmsg = validation_errors();
	  			echo $errmsg;
	  	} else {
	  		
			if($noref=="-") {
				$scr = "SELECT CASE WHEN ref IS NULL THEN 
		  			CONCAT('BK/',year(now()),'/00000000') 
		  		ELSE 
		  			CONCAT('BK/',year(now()),'/',ref) END ref FROM (
				SELECT LPAD(MAX(REPLACE(REPLACE(noref,'BK/',''),CONCAT(year(now()),'/'),''))+1,8,0) ref FROM tr_pemasukan_bank) a";		
				$query = $this->db->query($scr);
				foreach ($query->result() as $row)
				{
				        $noref = $row->ref;
				}	
			}

			$data = array(
				'noref' => $noref,
				'tglmasuk' => $tglmasuk, 
				'rekening' => $rekening, 
				'jenistrx' => $jenistransaksi, 
				'nominal' => $nominal,
				'keterangan' => $keterangan,
				'createtime' => '2018-01-01',
				'createuser' => 'testuser',
				'status' => '+'
			);
				$this->db->insert('tr_pemasukan_bank', $data);	
				echo "Berhasil";
	  	}
	  	
		
			//$this->db->where('kodecbg', $kodecbg);
			//$this->db->update('cabang', $data);
			//echo "UPDATE";
		
	}



	function addx() {

	  		$tglmasuk = '2018-01-01';
			$rekening = $this->input->post('rekening');
			$jenistransaksi = $this->input->post('jenistransaksi');
			$nominal = $this->input->post('nominal');
			$keterangan = $this->input->post('keterangan');
			$noref = $this->input->post('noref');

			if($noref=="-") {
				$scr = "SELECT CASE WHEN ref IS NULL THEN 
		  			CONCAT('BK/',year(now()),'/00000000') 
		  		ELSE 
		  			CONCAT('BK/',year(now()),'/',ref) END ref FROM (
				SELECT LPAD(MAX(REPLACE(REPLACE(noref,'BK/',''),CONCAT(year(now()),'/'),''))+1,8,0) ref FROM tr_pemasukan_bank) a";		
				$query = $this->db->query($scr);
				foreach ($query->result() as $row)
				{
				        $noref = $row->ref;
				}	
			}

			$data = array(
				'noref' => $noref,
				'tglmasuk' => date('Y-m-d',$tglmasuk), 
				'rekening' => $rekening, 
				'jenistrx' => $jenistransaksi, 
				'nominal' => $nominal,
				'keterangan' => $keterangan,
				'createtime' => '2018-01-01',
				'createuser' => 'testuser',
				'status' => '+'
			);
				$this->db->insert('tr_pemasukan_bank', $data);	
				echo "Berhasil";
	  
	  	
		
			//$this->db->where('kodecbg', $kodecbg);
			//$this->db->update('cabang', $data);
			//echo "UPDATE";
		
	}


	function loadtable(){
	  $this->db->select('noref, DATE_FORMAT(tglmasuk,"%d/%m/%Y") as tglmasuk, CONCAT(norek," (",bank,")") rekening, jenistrx, FORMAT(nominal,0) as nominal, keterangan, createtime, createuser, tr_pemasukan_bank.status');
      $this->db->from('tr_pemasukan_bank');
      $this->db->join('list_rekening', 'tr_pemasukan_bank.rekening = list_rekening.kode');
      $datatable = $this->db->get()->result();
      $datatable = '{"data":'.json_encode($datatable) .'}';
      echo $datatable;
	}
	
}


?>
