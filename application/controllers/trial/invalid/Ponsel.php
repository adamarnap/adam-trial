<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ponsel extends CI_Controller {

    //Untuk mendefinisikan judul dalam sebuah halaman
    private $sub_title;
    private $main_title;

    public function __construct()
    {
        parent::__construct();
        cek_akses_halaman();

        // Load library
        $this->load->library('form_validation');

        // Load model

        // Model untuk data judul dan portal
        $this->load->model('M_user');
        $this->load->model('M_portal');

        // Model untuk data yang diolah
        $this->load->model('invalid/M_ponsel');

        // Judul
        $this->sub_title = 'Ponsel';
        $this->main_title = 'Ponsel';
    }



    public function index(){
        // Mengambil data untuk judul
        $user_id = $this->session->userdata('user_id');
        $data['user'] = $this->M_user->get_data_user($user_id);
        $data['portal_data'] = $this->M_portal->get_data_portal();
        $data['portal'] = $data['portal_data'][0]['portal_nm'];
        // Data Judul
        $data['main_title'] = $this->main_title;
        $data['sub_title'] = $this->sub_title;

        // Data untuk di olah
        $data['ponsel'] = $this->M_ponsel->get_data_all_ponsel();

        // Cek Data
        // dd($data);

        // Display
        $this->load->view('templates/header_backend', $data);
        $this->load->view('templates/sidebar_backend', $data);
        $this->load->view('templates/topbar_backend', $data);
        $this->load->view('invalid/ponsel/index.html', $data);
        $this->load->view('templates/footer_backend', $data);
    }

    /* Tambah ponsel */
    public function tambah_proses(){
        // Validasi
        $this->form_validation->set_rules('nama_phone', 'Nama Ponsel', 'required|trim');
        $this->form_validation->set_rules('phone', 'Nomor Ponsel', 'required|trim');
        $this->form_validation->set_rules('status', 'Status', 'required|trim');

        // Cek Validasi
        if ($this->form_validation->run() == false) {
            // Mengatur pesan flashdata untuk ditampilkan di halaman tujuan
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'. validation_errors() .'</div>');
            
            // Redirect ke halaman tujuan
            redirect('trial/invalid/ponsel');
        } 

        // Input proses
        $params = [
            'nama_phone' => $this->input->post('nama_phone'),
            'phone' => $this->input->post('phone'),
            'st' => $this->input->post('status'),
            'mdb_name' => $this->session->userdata('user_nama'),
            'mdb' => $this->session->userdata('user_id'),
            'mdd' => date('Y-m-d H:i:s'),
        ];

        if ($this->db->insert('phone', $params)) {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data ponsel berhasil dibuat.</div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Maaf ponsel gagal terbuat, silahkan coba lagi.</div>');
        }

        // Redirect setelah input
        return redirect('trial/invalid/ponsel');
        
    }

    /* Hapuus Ponsel */
    public function hapus_ponsel($id_phone)
    {
        $where = ['id_phone' => $id_phone];

        if ($this->M_ponsel->delete('phone', $where)) {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data ponsel berhasil dihapus.</div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data ponsel gagal dihapus.</div>');
        }
        redirect(('trial/invalid/ponsel'));
    }



}
