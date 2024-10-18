<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori extends CI_Controller {

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
        $this->load->model('invalid/M_kategori');

        // Judul
        $this->sub_title = 'Kategori';
        $this->main_title = 'Kategori';
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
        $data['kategori'] = $this->M_kategori->get_data_all_kategori();

        // Cek Data
        // dd($data);

        // Display
        $this->load->view('templates/header_backend', $data);
        $this->load->view('templates/sidebar_backend', $data);
        $this->load->view('templates/topbar_backend', $data);
        $this->load->view('invalid/kategori/index.html', $data);
        $this->load->view('templates/footer_backend', $data);
    }

    /* Tambah Kategori */
    public function tambah_proses(){
        // Validasi
        $this->form_validation->set_rules('nama_kategori', 'Nama Kategori', 'required|trim');
        $this->form_validation->set_rules('deskripsi_kategori', 'Deskripsi Kategori', 'required|trim');

        // Cek Validasi
        if ($this->form_validation->run() == false) {
            // Mengatur pesan flashdata untuk ditampilkan di halaman tujuan
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data gagal ditambahkan, periksa kesempurnaan data yang diinputkan.</div>');
            
            // Redirect ke halaman tujuan
            redirect('trial/invalid/kategori');
        }

        // Input proses
        $params = [
            'nama_kategori' => $this->input->post('nama_kategori'),
            'deskripsi_kategori' => $this->input->post('deskripsi_kategori'),
            'mdb_name' => $this->session->userdata('user_nama'),
            'mdb' => $this->session->userdata('user_id'),
            'mdd' => date('Y-m-d H:i:s'),
        ];

        if ($this->db->insert('kategori', $params)) {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data kategori berhasil dibuat.</div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Maaf kategori gagal terbuat, silahkan coba lagi.</div>');
        }

        // Redirect setelah input
        return redirect('trial/invalid/kategori');
        
    }

    /* Edit Kategori */
    public function edit_proses(){
        // Validasi
        $this->form_validation->set_rules('nama_kategori', 'Nama Kategori', 'required|trim');
        $this->form_validation->set_rules('deskripsi_kategori', 'Deskripsi Kategori', 'required|trim');

        // Cek Validasi
        if ($this->form_validation->run() == false) {
            // Mengatur pesan flashdata untuk ditampilkan di halaman tujuan
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data gagal ditambahkan, periksa kesempurnaan data yang diinputkan.</div>');
            
            // Redirect ke halaman tujuan
            redirect('trial/invalid/kategori');
        }

        // Input proses
        $params = [
            'nama_kategori' => $this->input->post('nama_kategori'),
            'deskripsi_kategori' => $this->input->post('deskripsi_kategori'),
            'mdb_name' => $this->session->userdata('user_nama'),
            'mdb' => $this->session->userdata('user_id'),
            'mdd' => date('Y-m-d H:i:s'),
        ];

        $where = ['id_kategori' => $this->input->post('id_kategori')];

        if ($this->db->update('kategori', $params, $where)) {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data kategori berhasil dibuat.</div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Maaf kategori gagal terbuat, silahkan coba lagi.</div>');
        }

        // Redirect setelah input
        return redirect('trial/invalid/kategori');
        
    }

    /* Hapuus Kategori */
    public function hapus_kategori($id_kategori)
    {
        $where = ['id_kategori' => $id_kategori];

        if ($this->M_kategori->delete('kategori', $where)) {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data kategori berhasil dihapus.</div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data kategori gagal dihapus.</div>');
        }
        redirect(('trial/invalid/kategori'));
    }



}
