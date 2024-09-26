<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Not_found_page extends CI_Controller
{

    public function show_404()
    {
        $this->output->set_status_header('404');
        $this->load->view('404_page');
    }
}
