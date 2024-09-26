<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Portal extends CI_Controller
{
    private $sub_title;
    private $main_title;

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('M_user');
        $this->load->model('M_portal');
        $this->sub_title = 'Portal';
        $this->main_title = 'Sistem';
        cek_akses_halaman();
    }



    public function index()
    {
        // Mengambil data
        $user_id = $this->session->userdata('user_id');
        $data['user'] = $this->M_user->get_data_user($user_id);
        $data['portal_data'] = $this->M_portal->get_data_portal();  
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
        $this->load->view('setting/sistem/portal/index', $data);
        $this->load->view('templates/footer_backend', $data);
    }

    public function tambah_proses()
    {
        // validasi
        $this->form_validation->set_rules('portal_nm', 'Nama Portal', 'trim');
        $this->form_validation->set_rules('site_title', 'Judul Website', 'trim');
        $this->form_validation->set_rules('site_desc', 'Deskripsi Website', 'trim');
        $this->form_validation->set_rules('meta_desc', 'Meta Website', 'trim');
        $this->form_validation->set_rules('meta_keyword', 'Keyword Pencarian Website', 'trim');


        // proses
        if ($this->form_validation->run() !== false) {
            $last_id_portal = $this->M_portal->get_last_id_portal();
            $portal_id = '0' . strval(intval($last_id_portal['last_id_portal']) + 1);
            $params = [
                'portal_id' => $portal_id,
                'portal_nm' => $this->input->post('portal_nm'),
                'site_title' => $this->input->post('site_title'),
                'site_desc' => $this->input->post('site_desc'),
                'meta_desc' => $this->input->post('meta_desc'),
                'meta_keyword' => $this->input->post('meta_keyword'),
                'mdb' => $this->session->userdata('user_id'),
                'mdb_name' => $this->session->userdata('user_nama'),
                'mdd' => date('Y-m-d H:i:s')
            ];
            // dd($params);
            if ($this->M_portal->insert('mst_portal', $params)) {
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data portal baru berhasil ditambahkan.</div>');
                redirect(('setting/sistem/portal'));
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data portal baru gagal ditambahkan.</div>');
                redirect(('setting/sistem/portal'));
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Pastikan data portal terisi dengan sempurna.</div>');
            redirect(('setting/sistem/portal'));
        }
    }


    public function edit_proses()
    {
        // validasi
        $this->form_validation->set_rules('portal_nm', 'Nama Portal', 'trim');
        $this->form_validation->set_rules('site_title', 'Judul Website', 'trim');
        $this->form_validation->set_rules('site_desc', 'Deskripsi Website', 'trim');
        $this->form_validation->set_rules('meta_desc', 'Meta Website', 'trim');
        $this->form_validation->set_rules('meta_keyword', 'Keyword Pencarian Website', 'trim');

        // proses
        if ($this->form_validation->run() !== false) {
            $params = [
                'portal_nm' => $this->input->post('portal_nm'),
                'site_title' => $this->input->post('site_title'),
                'site_desc' => $this->input->post('site_desc'),
                'meta_desc' => $this->input->post('meta_desc'),
                'meta_keyword' => $this->input->post('meta_keyword'),
                'mdb' => $this->session->userdata('user_id'),
                'mdb_name' => $this->session->userdata('user_nama'),
                'mdd' => date('Y-m-d H:i:s')
            ];
            $where = [
                'portal_id' => $this->input->post('portal_id')
            ];

            // dd($where);

            if ($this->M_portal->update('mst_portal', $params, $where)) {
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data portal baru berhasil diubah.</div>');
                redirect(('setting/sistem/portal'));
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data portal baru gagal diubah.</div>');
                redirect(('setting/sistem/portal'));
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data portal induk belum terisi.</div>');
            redirect(('setting/sistem/portal'));
        }
    }

    public function hapus_portal($portal_id)
    {
        $where = ['portal_id' => $portal_id];

        if ($this->M_portal->delete('mst_portal', $where)) {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data portal berhasil dihapus.</div>');
            redirect(('setting/sistem/portal'));
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data portal gagal dihapus.</div>');
            redirect(('setting/sistem/portal'));
        }
    }
}
