<?php
	class Petty_Cash_model extends CI_Model
	{
		public function GetJudul($nama) {
		  $this->db->select('*');
	      $this->db->from('secure_form_akses');
	      $this->db->where('formname', $nama);
	      $judul = $this->db->get()->result();	
	     foreach ($judul as $variant){
            $namajudul = $variant->nama;
            $formname =  $variant->formname;               
          } 
          return $namajudul."|".$formname;
		}	

	  function GetRekening(){
	      $this->db->select('*');
	      $this->db->from('list_rekening');
	      $this->db->where('status', '+');
	      $rekening = $this->db->get()->result();
	      return $rekening;
	  }

	  function GetJenisMakanan(){
	      $this->db->select('*');
	      $this->db->from('spek_jenis_makanan');
	      $jenismakanan = $this->db->get()->result();
	      return $jenismakanan;
	  }

	  function GetSupplier(){
	      $this->db->select('*');
	      $this->db->from('spek_supplier');
	      $supplier = $this->db->get()->result();
	      return $supplier;
	  }

	  function add() {
	  	$errstatus = "OK";
	  	$this->load->helper('date');
	  	$this->form_validation->set_rules('rekening', 'Rekening', 'trim|required');
	  	$this->form_validation->set_rules('jenistransaksi', 'Jenis Transaksi', 'trim|required');
	  	$this->form_validation->set_rules('nominal', 'Nominal', 'trim|required');
	  	$this->form_validation->set_rules('noref', 'Noref', 'trim|required');
	  	$this->form_validation->set_rules('tglmasuk', 'Tgl Masuk', 'trim|required');
	  	//$this->form_validation->set_rules('jenismakanan', 'Jenis Makanan', 'trim|required');
	  	//$this->form_validation->set_rules('supplier', 'Supplier', 'trim|required');
	  	$this->form_validation->set_rules('keterangan', 'keterangan', 'trim|required');

	  	$tglmasuk = $this->input->post('tglmasuk');	
  		$tglmasuk = date('Y-m-d',strtotime($tglmasuk));	  		
		$rekening = $this->input->post('rekening');
		$jenistransaksi = $this->input->post('jenistransaksi');
		$nominal = $this->input->post('nominal');
		$keterangan = $this->input->post('keterangan');
		$noref = $this->input->post('noref');
		$jenismakanan = $this->input->post('jenismakanan');
		$supplier = $this->input->post('supplier');

	  	if ($this->form_validation->run() == FALSE) {
	  			$errmsg = "NO|".validation_errors();
	  			$errstatus = "NO";
	  	}


	  	$scr = "SELECT SUM(debet)-SUM(credit) saldo FROM (
				SELECT CASE WHEN jenistrx = 'DEBET' THEN nominal ELSE 0 END debet,
				CASE WHEN jenistrx = 'CREDIT' THEN nominal ELSE 0 END credit 
				FROM tr_pemasukan_bank WHERE rekening = '".$rekening."' AND tglmasuk<='".$tglmasuk."') a";		
				$query = $this->db->query($scr);
				foreach ($query->result() as $row)
				{
				        $saldobank = $row->saldo;
				}

		$scr = "SELECT SUM(debet)-SUM(credit) saldo FROM (
				SELECT CASE WHEN jenistrx = 'DEBET' THEN nominal ELSE 0 END debet,
				CASE WHEN jenistrx = 'CREDIT' THEN nominal ELSE 0 END credit 
				FROM tr_petty_cash WHERE rekening = '".$rekening."'  AND tgltrx<='".$tglmasuk."') a";		
				$query = $this->db->query($scr);
				foreach ($query->result() as $row)
				{
				        $saldokaskecil = $row->saldo;
				}		

		if($saldobank<$nominal && $jenistransaksi=="DEBET") {
			$errmsg = "NO|NOMINAL PENARIKAN KURANG DARI SALDO BANK";
	  		$errstatus = "NO";	
		}

		if($saldokaskecil<$nominal && $jenistransaksi=="CREDIT") {
			$errmsg = "NO|NOMINAL PEMBELIAN KURANG DARI SALDO KAS KECIL";
	  		$errstatus = "NO";	
		}		

	  	if($errstatus=="OK") {	  				  	
				if($noref=="-") {
					$scr = "SELECT CASE WHEN ref IS NULL THEN 
			  			CONCAT('BK/',year(now()),'/00000000') 
			  		ELSE 
			  			CONCAT('BK/',year(now()),'/',ref) END ref FROM (
					SELECT LPAD(MAX(REPLACE(REPLACE(noref,'BK/',''),CONCAT(year(now()),'/'),''))+1,8,0) ref FROM tr_petty_cash) a";		
					$query = $this->db->query($scr);
					foreach ($query->result() as $row)
					{
					        $noref = $row->ref;
					}

					$scr = "SELECT CASE WHEN ref IS NULL THEN 
			  			CONCAT('BK/',year(now()),'/00000000') 
			  		ELSE 
			  			CONCAT('BK/',year(now()),'/',ref) END ref FROM (
					SELECT LPAD(MAX(REPLACE(REPLACE(noref,'BK/',''),CONCAT(year(now()),'/'),''))+1,8,0) ref FROM tr_pemasukan_bank) a";		
					$query = $this->db->query($scr);
					foreach ($query->result() as $row)
					{
					        $noref_bank = $row->ref;
					}	
				}

				$data = array(
					'noref' => $noref,
					'tgltrx' => $tglmasuk, 
					'rekening' => $rekening, 
					'jenistrx' => $jenistransaksi, 
					'jenismakanan' => $jenismakanan,
					'supplier' => $supplier,
					'nominal' => $nominal,
					'keterangan' => $keterangan,
					'createtime' => '2018-01-01',
					'createuser' => 'testuser',
					'status' => '+'
				);
				$this->db->insert('tr_petty_cash', $data);
				
				if($jenistransaksi=="DEBET") {
					$data2 = array(
						'noref' => $noref_bank,
						'tglmasuk' => $tglmasuk, 
						'rekening' => $rekening, 
						'jenistrx' => 'CREDIT', 
						'nominal' => $nominal,
						'keterangan' => 'PENARIKAN UANG',
						'createtime' => '2018-01-01',
						'createuser' => 'testuser',
						'status' => '+'
					);
					$this->db->insert('tr_pemasukan_bank', $data2);	
				}	
				
					$errmsg = "OK|DATA BERHASIL DI INPUT";
		  	}

			echo $errmsg;
	}

	function loadtable(){
	  $this->db->select('noref, DATE_FORMAT(tgltrx,"%d/%m/%Y") as tgltrx, CONCAT(norek," (",bank,")") rekening, jenistrx, FORMAT(nominal,0) as nominal, keterangan, createtime, createuser, tr_petty_cash.status');
      $this->db->from('tr_petty_cash');
      $this->db->join('list_rekening', 'tr_petty_cash.rekening = list_rekening.kode');
      $datatable = $this->db->get()->result();
      $datatable = '{"data":'.json_encode($datatable) .'}';
      echo $datatable;
	}
}


?>
