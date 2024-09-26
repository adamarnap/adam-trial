<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends CI_Controller
{
    private $sub_title;
    private $main_title;

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('setting/sistem/M_menu');
        $this->load->model('M_user');
        $this->load->model('M_portal');
        $this->sub_title = 'Menu';
        $this->main_title = 'Sistem';
        cek_akses_halaman();
    }



    public function index()
    {
        // Mengambil data
        $user_id = $this->session->userdata('user_id');
        $data['user'] = $this->M_user->get_data_user($user_id);
        $data['portal_data'] = $this->M_portal->get_data_portal();
        $data['menu_induk'] = $this->M_menu->get_data_menu_induk();
        $data['semua_menu'] = $this->M_menu->get_data_all_menu();
        $data['portal'] = $data['portal_data'][0]['portal_nm'];
        $data['menu_by_id'] = $this->M_menu;
        // Data Judul
        $data['main_title'] = $this->main_title;
        $data['sub_title'] = $this->sub_title;
        // Display
        $this->load->view('templates/header_backend', $data);
        $this->load->view('templates/sidebar_backend', $data);
        $this->load->view('templates/topbar_backend', $data);
        $this->load->view('setting/sistem/menu/index', $data);
        $this->load->view('templates/footer_backend', $data);
    }

    public function tambah_proses(){
        // validasi
        // dd($this->input->post('menu_level'));
        if($this->input->post('menu_level') == 'submenu'){
            $this->form_validation->set_rules('menu_induk', 'Menu Induk', 'required|trim');
            $menu_induk = $this->input->post('menu_induk');
        }else{
            $this->form_validation->set_rules('menu_induk', 'Menu Induk', 'trim');
            $menu_induk = 0;
        }
        // proses
        if ($this->form_validation->run() !== false){
            $menu_id = time();
            $params = [
                'menu_id' => $menu_id,
                'portal_id' => $this->input->post('portal_id'),
                'menu_level' => $this->input->post('menu_level'),
                'menu_induk' => $menu_induk,
                'menu_judul' => $this->input->post('menu_judul'),
                'menu_deskripsi' => $this->input->post('menu_deskripsi'),
                'menu_url' => $this->input->post('menu_url'),
                'menu_urut' => $this->input->post('menu_urut'),
                'status_aktif' => $this->input->post('status_aktif'),
                'status_tampil' => $this->input->post('status_tampil'),
                'menu_icon' => $this->input->post('menu_icon'),
                'mdb' => $this->session->userdata('user_id'),
                'mdb_name' => $this->session->userdata('user_nama'),
                'mdd' => date('Y-m-d H:i:s')
            ];
            // dd($params);

            if($this->M_menu->insert('mst_menu', $params)){
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data menu baru berhasil ditambahkan.</div>');
                redirect(('setting/sistem/menu'));
            }else{
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data menu baru gagal ditambahkan.</div>');
                redirect(('setting/sistem/menu'));
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data menu induk belum terisi.</div>');
            redirect(('setting/sistem/menu'));
        }
    }

    public function edit($menu_id){
        // Mengambil data dari session
        $user_id = $this->session->userdata('user_id');

        // Mengambil data dari modal
        $data['user'] = $this->M_user->get_data_user($user_id);
        $data['portal_data'] = $this->M_menu->get_data_portal();
        $data['menu_induk'] = $this->M_menu->get_data_menu_induk();
        $data['semua_menu'] = $this->M_menu->get_data_all_menu();
        $data['menu_by_id'] = $this->M_menu->get_data_menu_by_id($menu_id);
        $data['portal'] = $data['portal_data'][0]['portal_nm'];
        
        // Data Judul
        $data['main_title'] = $this->main_title;
        $data['sub_title'] = $this->sub_title;
        // Cek Data
        // dd($data);

        // Display
        $this->load->view('templates/header_backend', $data);
        $this->load->view('templates/sidebar_backend', $data);
        $this->load->view('templates/topbar_backend', $data);
        $this->load->view('setting/sistem/menu/edit', $data);
        $this->load->view('templates/footer_backend', $data);
    }

    public function edit_proses(){
        // validasi
        // dd($this->input->post('menu_level'));
        if($this->input->post('menu_level') == 'submenu'){
            $this->form_validation->set_rules('menu_induk', 'Menu Induk', 'required|trim');
            $menu_induk = $this->input->post('menu_induk');
        }else{
            $this->form_validation->set_rules('menu_induk', 'Menu Induk', 'trim');
            $menu_induk = 0;
        }
        // proses
        if ($this->form_validation->run() !== false){
            $params = [
                'portal_id' => $this->input->post('portal_id'),
                'menu_level' => $this->input->post('menu_level'),
                'menu_induk' => $menu_induk,
                'menu_judul' => $this->input->post('menu_judul'),
                'menu_deskripsi' => $this->input->post('menu_deskripsi'),
                'menu_url' => $this->input->post('menu_url'),
                'menu_urut' => $this->input->post('menu_urut'),
                'status_aktif' => $this->input->post('status_aktif'),
                'status_tampil' => $this->input->post('status_tampil'),
                'menu_icon' => $this->input->post('menu_icon'),
                'mdb' => $this->session->userdata('user_id'),
                'mdb_name' => $this->session->userdata('user_nama'),
                'mdd' => date('Y-m-d H:i:s')
            ];

            $where = [
                'menu_id' => $this->input->post('menu_id')
            ];

            // dd($params);

            if($this->M_menu->update('mst_menu', $params, $where)){
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data menu baru berhasil diubah.</div>');
                redirect(('setting/sistem/menu'));
            }else{
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data menu baru gagal diubah.</div>');
                redirect(('setting/sistem/menu'));
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data menu induk belum terisi.</div>');
            redirect(('setting/sistem/menu'));
        }
    }

    public function hapus_menu($menu_id){
        $where = ['menu_id' => $menu_id];

        if($this->M_menu->delete('mst_menu', $where)){
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data menu berhasil dihapus.</div>');
            redirect(('setting/sistem/menu'));
        }else{
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data menu gagal dihapus.</div>');
            redirect(('setting/sistem/menu'));
        }
    }


}
