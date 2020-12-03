<?php

class Laporan_pemasukan_bank extends CI_Controller
{

	public function index(){
		$nama = $this->router->fetch_class();
		$this->load->model('Transaksi_bank_model');
		$data['judul'] = $this->Transaksi_bank_model->GetJudul($nama);
		$this->load->model('Transaksi_bank_model');
		$data['rekening'] = $this->Transaksi_bank_model->GetRekening()->result();
		$this->load->model('Main_model');
    	$data['menu'] = $this->Main_model->GetMenu()->result();
    	$data['menulaporan'] = $this->Main_model->GetMenuLaporan()->result();
    	$data['saldobank'] = $this->Main_model->GetSaldoBank();
    	$data['saldoCOH'] = $this->Main_model->GetSaldoCOH();
		$this->load->view('laporan_pemasukan_bank',$data);
	}

	function loaddata(){
		$this->load->model('Laporan_pemasukan_bank_model');
		$this->Laporan_pemasukan_bank_model->loaddata();
	}



}