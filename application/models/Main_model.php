<?php
class Main_model extends CI_Model
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
    foreach ($query->result() as $row) {
      $menu[] =  array(
        'formheader' => $row->headername,
        'formname' => $row->formname,
        'formtitle' => $row->formtitle,
        'glyph' => $row->glyph
      );
    }

    return $menu;
  }
  //=============================================================================


  function GetStatus()
  {
    $this->db->select('*');
    $this->db->from('list_status');
    $status = $this->db->get()->result_array();
    return $status;
  }


  function GetListTempatBekerja()
  {
    $this->db->select('*')
      ->from('list_tempat_bekerja')
      ->where('status', "1")
      ->order_by("ordinal");
    $list_tempat_bekerja = $this->db->get()->result();

    return $list_tempat_bekerja;
  }

  function GetCheckIp($ipaddr)
  {
    $this->db->select('*')
      ->from('absenscan_allowed_ip')
      ->where('ipaddr', $ipaddr)
      ->where('status', "1");
    $total = $this->db->get()->num_rows();
    if ($total > 0) {
      return true;
    } else {
      return false;
    }
    // return $list_tempat_bekerja;
  }

  function GetListLokasi()
  {
    $this->db->select('*')
      ->from('list_lokasi')
      ->where('status', "1")
      ->order_by("ordinal");
    $list_lokasi = $this->db->get()->result();

    return $list_lokasi;
  }
}
