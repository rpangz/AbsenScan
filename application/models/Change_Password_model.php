<?php
class Change_Password_model extends CI_Model
{

  //TIDAK DI GUNAKAN KARENA PENGECEKAN LANGSUNG DI VIEW/PARTIAL/MENU.PHP
  function GetMenu()
  {
      $menu = array();
      $scr = "SELECT headername,formname,formtitle,glyph FROM secure_form_register a
              INNER JOIN secure_form_akses b ON a.id_form=b.id_form
              INNER JOIN master_formheader c ON a.formheader=c.id_form
              WHERE b.formdepartment=1 AND b.formjabatan=1
              AND b.formjabatan=1 AND a.formstatus = 1 AND b.formstatus = 1 AND c.formstatus = 1
              ORDER BY c.ordinal";    
      $query = $this->db->query($scr);
      foreach ($query->result() as $row)
      {
              $menu[] =  array('formheader' => $row->headername, 
                               'formname' => $row->formname, 
                               'formtitle' => $row->formtitle, 
                               'glyph' => $row->glyph
                              );
      }

      return $menu;
  }
  //=============================================================================

  
  function GetStatus(){
        $this->db->select('*');
        $this->db->from('list_status');
        $status = $this->db->get()->result_array();
        return $status;
  }


  function GetMenuLaporan()
  {
      $this->db->select('*');
      $this->db->from('secure_form_akses');
      $this->db->where('department', 'ADMIN');
      $this->db->where('jabatan', 'ADMIN');
      $this->db->where('nama_header', 'LAPORAN');
      $menu = $this->db->get();
      return $menu;
  }

  function GetSaldoBank(){
      $scr = "SELECT CASE WHEN SUM(debet)-SUM(credit) IS NULL THEN 0 ELSE FORMAT(SUM(debet)-SUM(credit),0) END saldo FROM (
      SELECT CASE WHEN jenistrx = 'DEBET' THEN nominal ELSE 0 END debet,
      CASE WHEN jenistrx = 'CREDIT' THEN nominal ELSE 0 END credit 
      FROM tr_pemasukan_bank) a";    
      $query = $this->db->query($scr);
      foreach ($query->result() as $row)
      {
              $saldobank = $row->saldo;
      }

      return $saldobank;
  }

  function GetSaldoCOH(){
      $scr = "SELECT CASE WHEN SUM(debet)-SUM(credit) IS NULL THEN 0 ELSE FORMAT(SUM(debet)-SUM(credit),0) END saldo FROM (
      SELECT CASE WHEN jenistrx = 'DEBET' THEN nominal ELSE 0 END debet,
      CASE WHEN jenistrx = 'CREDIT' THEN nominal ELSE 0 END credit 
      FROM tr_petty_cash) a";    
      $query = $this->db->query($scr);
      foreach ($query->result() as $row)
      {
              $saldocoh = $row->saldo;
      }

      return $saldocoh;
  }


  function GetJudul($nama) {
      $this->db->select('*');
        $this->db->from('secure_form_register');
        $this->db->where('formname', $nama);
        $judul = $this->db->get()->result();  
       foreach ($judul as $variant){
            $namajudul = $variant->formtitle;                
          } 
          return $namajudul;
    }
  
}


?>
