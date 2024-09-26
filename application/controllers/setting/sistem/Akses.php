<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Akses extends CI_Controller
{
    private $sub_title;
    private $main_title;

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        cek_akses_halaman();
        // Modals Default
        $this->load->model('M_user');
        $this->load->model('M_portal');
        // Modals yang digunakan
        $this->load->model('setting/sistem/M_akses');
        $this->sub_title = 'Hak Akses';
        $this->main_title = 'Sistem';
    }



    public function index()
    {
        // Mengambil data
        $user_id = $this->session->userdata('user_id');
        $data['user'] = $this->M_user->get_data_user($user_id);
        $data['portal_data'] = $this->M_portal->get_data_portal();
        $data['portal'] = $data['portal_data'][0]['portal_nm'];
        $data['role_data'] = $this->M_akses->get_all_role_data();
        $data['no'] = 1;
        // Data Judul
        $data['main_title'] = $this->main_title;
        $data['sub_title'] = $this->sub_title;

        // Cek Data
        // dd($data);

        // Display
        $this->load->view('templates/header_backend', $data);
        $this->load->view('templates/sidebar_backend', $data);
        $this->load->view('templates/topbar_backend', $data);
        $this->load->view('setting/sistem/akses/index', $data);
        $this->load->view('templates/footer_backend', $data);
    }

    public function akses_manajemen($role_id)
    {
        // Mengambil data
        $user_id = $this->session->userdata('user_id');
        $data['user'] = $this->M_user->get_data_user($user_id);
        $data['portal_data'] = $this->M_portal->get_data_portal();
        $data['portal'] = $data['portal_data'][0]['portal_nm'];
        // Data Akses Manajemen
        $data['menu_data'] = $this->M_akses->get_data_all_menu();
        $data['role_data'] = $this->M_akses->get_all_role_data();
        $data['role_by_id'] = $this->M_akses->get_data_role_by_id($role_id);
        $data['menu_by_id']= $this->M_akses;
        $data['no'] = 1;
        // Data Judul web
        $data['main_title'] = $this->main_title;
        $data['sub_title'] = $this->sub_title;

        // Cek Data
        // dd($data);

        // Display
        $this->load->view('templates/header_backend', $data);
        $this->load->view('templates/sidebar_backend', $data);
        $this->load->view('templates/topbar_backend', $data);
        $this->load->view('setting/sistem/akses/akses_manajemen.php', $data);
        $this->load->view('templates/footer_backend', $data);
    }

    public function ajax_change_hak_akses()
    {
        $menu_id = $this->input->post('menu_id');
        $role_id = $this->input->post('role_id');

        $params = [
            'role_id' => $role_id,
            'menu_id' => $menu_id
        ];

        $params_insert = [
            'role_id' => $role_id,
            'menu_id' => $menu_id,
            'role_menu_akses' => '1'
        ];

        // pengecekan data di database mst_role_menu
        $cek_data_role_menu = $this->db->get_where('mst_role_menu', $params);

        /*  Jika data cek kosong maka akses menu dengan role yang ditentukan akan di insert
            Sebaliknya, jika data cek ada maka akses menu dengan role yang telah ditentukan akan di delete */
        if($cek_data_role_menu->num_rows() < 1){
            $this->M_akses->insert('mst_role_menu', $params_insert);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Akses berhasil diaktifkan.</div>');

        }else{
            $this->M_akses->delete('mst_role_menu', $params);
            $this->session->set_flashdata('message', '<div class="alert alert-warning" role="alert">Akses berhasil dinonaktifkan.</div>');
        }

    }

}
