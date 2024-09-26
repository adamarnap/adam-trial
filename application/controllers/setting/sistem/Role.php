<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Role extends CI_Controller
{
    private $sub_title;
    private $main_title;

    public function __construct()
    {
        parent::__construct();
        cek_akses_halaman();
        $this->load->library('form_validation');
        $this->load->model('setting/sistem/M_role');
        $this->load->model('M_user');
        $this->load->model('M_portal');
        $this->sub_title = 'Role';
        $this->main_title = 'Sistem';
    }



    public function index()
    {
        // Mengambil data
        $user_id = $this->session->userdata('user_id');
        $data['user'] = $this->M_user->get_data_user($user_id);
        $data['portal_data'] = $this->M_portal->get_data_portal();
        $data['role_data'] = $this->M_role->get_all_role_data();
        $data['group_data'] = $this->M_role->get_all_group_data();
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
        $this->load->view('setting/sistem/role/index', $data);
        $this->load->view('templates/footer_backend', $data);
    }

    public function tambah_proses()
    {
        // validasi
        $this->form_validation->set_rules('role_nama', 'Nama Role', 'trim');
        $this->form_validation->set_rules('group_id', 'Group', 'trim');
        $this->form_validation->set_rules('default_halaman', 'Halaman Default', 'trim');
        $this->form_validation->set_rules('role_deskripsi', 'Deskripsi Role', 'trim');


        // proses
        if ($this->form_validation->run() !== false) {
            $last_id_role = $this->M_role->get_last_id_role();
            $role_id = '0'.strval(intval($last_id_role['last_id_role']) + 1); 
            $params = [
                'role_id' => $role_id,
                'group_id' => $this->input->post('group_id'),
                'role_nama' => $this->input->post('role_nama'),
                'role_deskripsi' => $this->input->post('role_deskripsi'),
                'default_halaman' => $this->input->post('default_halaman'),
                'mdb' => $this->session->userdata('user_id'),
                'mdb_name' => $this->session->userdata('user_nama'),
                'mdd' => date('Y-m-d H:i:s')
            ];

            if ($this->M_role->insert('mst_role', $params)) {
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data role baru berhasil ditambahkan.</div>');
                redirect(('setting/sistem/role'));
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data role baru gagal ditambahkan.</div>');
                redirect(('setting/sistem/role'));
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Pastikan data role terisi dengan sempurna.</div>');
            redirect(('setting/sistem/role'));
        }
    }


    public function edit_proses()
    {
        // validasi
        $this->form_validation->set_rules('role_nama', 'Nama Role', 'trim');
        $this->form_validation->set_rules('group_id', 'Group', 'trim');
        $this->form_validation->set_rules('default_halaman', 'Halaman Default', 'trim');
        $this->form_validation->set_rules('role_deskripsi', 'Deskripsi Role', 'trim');


        // proses
        if ($this->form_validation->run() !== false) {
            $params = [
                'group_id' => $this->input->post('group_id'),
                'role_nama' => $this->input->post('role_nama'),
                'role_deskripsi' => $this->input->post('role_deskripsi'),
                'default_halaman' => $this->input->post('default_halaman'),
                'mdb' => $this->session->userdata('user_id'),
                'mdb_name' => $this->session->userdata('user_nama'),
                'mdd' => date('Y-m-d H:i:s')
            ];
            $where = [
                'role_id' => $this->input->post('role_id')
            ];

            // dd($where);

            if ($this->M_role->update('mst_role', $params, $where)) {
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data role baru berhasil diubah.</div>');
                redirect(('setting/sistem/role'));
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data role baru gagal diubah.</div>');
                redirect(('setting/sistem/role'));
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data role induk belum terisi.</div>');
            redirect(('setting/sistem/role'));
        }
    }

    public function hapus_role($role_id)
    {
        $where = ['role_id' => $role_id];

        if ($this->M_role->delete('mst_role', $where)) {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data role berhasil dihapus.</div>');
            redirect(('setting/sistem/role'));
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data role gagal dihapus.</div>');
            redirect(('setting/sistem/role'));
        }
    }
}
