<?php
/* start of php file */
class MY_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        //$this->load->model('Main_model');
        //$data['menu'] = $this->Main_model->GetMenu();
        //$this->load->vars($data);
        $ipaddr = $this->input->ip_address();

        $this->load->model('Main_model');
        $list_status = $this->Main_model->GetStatus();

        $allowedipstatus = $this->Main_model->GetCheckIp($ipaddr);

        // if (!$allowedipstatus) {
        //     echo '<div class="alert alert-danger" role="alert">YOUR COMPUTER IS NOT ALLOW !!</div> ';
        //     die();
        // }
    }
}
