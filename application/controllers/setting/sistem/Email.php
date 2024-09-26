<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Email extends CI_Controller
{

    //Untuk mendefinisikan judul dalam sebuah halaman
    private $sub_title;
    private $main_title;

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('setting/sistem/M_email');
        $this->load->model('M_portal');
        $this->sub_title = 'Email Verifikasi';
        $this->main_title = 'Sistem';
        cek_akses_halaman();
    }


    public function index()
    {
        // Mengambil data dari session
        $user_id = $this->session->userdata('user_id');
        $data['user'] = $this->M_email->get_data_user_by_id($user_id);

        //Mengambil data portal untuk judul dari Model
        $data['portal_data'] = $this->M_portal->get_data_portal();
        $data['portal'] = $data['portal_data'][0]['portal_nm'];

        // Mengambil data dari model
        $data['email'] = $this->M_email->get_data_email();

        // Data Judul
        $data['main_title'] = $this->main_title;
        $data['sub_title'] = $this->sub_title;

        // Display
        $this->load->view('templates/header_backend', $data);
        $this->load->view('templates/sidebar_backend', $data);
        $this->load->view('templates/topbar_backend', $data);
        $this->load->view('setting/sistem/email/index', $data);
        $this->load->view('templates/footer_backend', $data);
    }

    public function edit_proses()
    {
        // validasi
        $this->form_validation->set_rules('email_name', 'Nama Email', 'trim');
        $this->form_validation->set_rules('email_address', 'Alamat Email', 'trim');
        $this->form_validation->set_rules('smtp_host', 'SMTP Host', 'trim');
        $this->form_validation->set_rules('smtp_port', 'SMTP Port', 'trim');
        $this->form_validation->set_rules('smtp_username', 'SMTP Username', 'trim');
        $this->form_validation->set_rules('smtp_password', 'SMTP Password', 'trim');
        $this->form_validation->set_rules('use_smtp', 'Status Penggunaan SMTP', 'trim');
        $this->form_validation->set_rules('use_authorization', 'Status Fitur Verifikasi', 'trim');

        // proses
        if ($this->form_validation->run() !== false) {
            $params = [
                'email_name' => $this->input->post('email_name'),
                'email_address' => $this->input->post('email_address'),
                'smtp_host' => $this->input->post('smtp_host'),
                'smtp_port' => $this->input->post('smtp_port'),
                'smtp_username' => $this->input->post('smtp_username'),
                'smtp_password' => $this->input->post('smtp_password'),
                'use_smtp' => $this->input->post('use_smtp'),
                'use_authorization' => $this->input->post('use_authorization'),
                'mdb' => $this->session->userdata('user_id'),
                'mdb_name' => $this->session->userdata('user_nama'),
                'mdd' => date('Y-m-d H:i:s')
            ];
            $where = [
                'email_id' => $this->input->post('email_id')
            ];

            // dd($params);

            if ($this->M_email->update('mst_email', $params, $where)) {
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data email berhasil diubah.</div>');
                redirect(('setting/sistem/email'));
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data email gagal diubah.</div>');
                redirect(('setting/sistem/email'));
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data email induk belum terisi.</div>');
            redirect(('setting/sistem/email'));
        }
    }

}
