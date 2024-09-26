<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class siswa extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('user/M_user');
    }


    public function index(){
        // Mengambil data dari session
        $user_id = $this->session->userdata('user_id');
        $data['user'] = $this->M_user->get_data_user($user_id);

        // Display view
        $data['title'] = ': Dashboard';
        $data['portal'] = ': Portal Website';
        $this->load->view('templates/header_backend', $data);
        $this->load->view('templates/sidebar_backend', $data);
        $this->load->view('templates/topbar_backend', $data);
        $this->load->view('user/index',$data);
        $this->load->view('templates/footer_backend', $data);
    }

}
