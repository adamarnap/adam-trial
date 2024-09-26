<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class user extends CI_Controller {


    private $sub_title;
    private $main_title;

    public function __construct()
    {
        parent::__construct();
        cek_akses_halaman();
        $this->load->library('form_validation');
        $this->load->model('M_user');
        $this->load->model('M_portal');
        $this->sub_title = 'Siswa';
        $this->main_title = 'Dashboard';
    }


    public function index(){
        // Mengambil data dari session
        $user_id = $this->session->userdata('user_id');
        $data['user'] = $this->M_user->get_data_user($user_id);
        // Data Portal
        $data['portal_data'] = $this->M_portal->get_data_portal();
        $data['portal'] = $data['portal_data'][0]['portal_nm'];
        // Data Judul
        $data['main_title'] = $this->main_title;
        $data['sub_title'] = $this->sub_title;
        // Display view
        $this->load->view('templates/header_backend', $data);
        $this->load->view('templates/sidebar_backend', $data);
        $this->load->view('templates/topbar_backend', $data);
        $this->load->view('welcome_user',$data);
        $this->load->view('templates/footer_backend', $data);
    }

}
?>