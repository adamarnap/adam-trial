<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Group extends CI_Controller
{
    private $sub_title;
    private $main_title;

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('M_user');
        $this->load->model('M_portal');
        $this->load->model('setting/sistem/M_group');
        $this->sub_title = 'Grup';
        $this->main_title = 'Sistem';
        cek_akses_halaman();
    }



    public function index()
    {
        // Mengambil data
        $user_id = $this->session->userdata('user_id');
        $data['user'] = $this->M_user->get_data_user($user_id);
        $data['portal_data'] = $this->M_portal->get_data_portal();
        $data['group_data'] = $this->M_group->get_data_group();
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
        $this->load->view('setting/sistem/group/index', $data);
        $this->load->view('templates/footer_backend', $data);
    }

    public function tambah_proses()
    {
        // validasi
        $this->form_validation->set_rules('group_nama', 'Nama Grup', 'trim');
        $this->form_validation->set_rules('group_deskripsi', 'Grup Deskripsi', 'trim');
       
        // proses
        if ($this->form_validation->run() !== false) {
            $last_id_group = $this->M_group->get_last_id_group();
            $group_id = '0' . strval(intval($last_id_group['last_id_group']) + 1);
            $params = [
                'group_id' => $group_id,
                'group_nama' => $this->input->post('group_nama'),
                'group_deskripsi' => $this->input->post('group_deskripsi'),
                'mdb' => $this->session->userdata('user_id'),
                'mdb_name' => $this->session->userdata('user_nama'),
                'mdd' => date('Y-m-d H:i:s')
            ];
            // dd($params);
            if ($this->M_group->insert('mst_group', $params)) {
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data group baru berhasil ditambahkan.</div>');
                redirect(('setting/sistem/group'));
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data group baru gagal ditambahkan.</div>');
                redirect(('setting/sistem/group'));
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Pastikan data group terisi dengan sempurna.</div>');
            redirect(('setting/sistem/group'));
        }
    }


    public function edit_proses()
    {
        // validasi
        $this->form_validation->set_rules('group_nama', 'Nama Grup', 'trim');
        $this->form_validation->set_rules('group_deskripsi', 'Grup Deskripsi', 'trim');

        // proses
        if ($this->form_validation->run() !== false) {
            $params = [
                'group_nama' => $this->input->post('group_nama'),
                'group_deskripsi' => $this->input->post('group_deskripsi'),
                'mdb' => $this->session->userdata('user_id'),
                'mdb_name' => $this->session->userdata('user_nama'),
                'mdd' => date('Y-m-d H:i:s')
            ];
            $where = [
                'group_id' => $this->input->post('group_id')
            ];

            // dd($where);

            if ($this->M_group->update('mst_group', $params, $where)) {
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data group baru berhasil diubah.</div>');
                redirect(('setting/sistem/group'));
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data group baru gagal diubah.</div>');
                redirect(('setting/sistem/group'));
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data group induk belum terisi.</div>');
            redirect(('setting/sistem/group'));
        }
    }

    public function hapus_group($group_id)
    {
        $where = ['group_id' => $group_id];

        if ($this->M_group->delete('mst_group', $where)) {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data group berhasil dihapus.</div>');
            redirect(('setting/sistem/group'));
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data group gagal dihapus.</div>');
            redirect(('setting/sistem/group'));
        }
    }
}
