<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manajemen extends CI_Controller {

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
        $this->load->model('invalid/M_manajemen');
        $this->load->model('invalid/M_mail');
        $this->load->model('invalid/M_ponsel');
        $this->load->model('invalid/M_kategori');

        // Judul
        $this->sub_title = 'Manajemen';
        $this->main_title = 'Manajemen';
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
        $data['akun'] = $this->M_manajemen->get_data_all_akun();
        $data['mail'] = $this->M_mail->get_list_mail();
        $data['ponsel'] = $this->M_ponsel->get_data_all_ponsel();
        $data['kategori'] = $this->M_kategori->get_data_all_kategori();

        // Cek Data
        // dd($data);

        // Display
        $this->load->view('templates/header_backend', $data);
        $this->load->view('templates/sidebar_backend', $data);
        $this->load->view('templates/topbar_backend', $data);
        $this->load->view('invalid/manajemen/index.html', $data);
        $this->load->view('templates/footer_backend', $data);
    }

    public function tambah_proses() {
        // Validasi input
        $this->form_validation->set_rules('id_kategori', 'Kategori', 'required|trim');
        $this->form_validation->set_rules('nama_akun', 'Nama mail', 'required|trim');
        $this->form_validation->set_rules('deskripsi_akun', 'Deskripsi mail', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'trim');
        $this->form_validation->set_rules('status', 'Status Akun', 'required|trim');
    
        // Jika validasi gagal
        if ($this->form_validation->run() === false) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'. validation_errors() .'</div>');
            return redirect('trial/invalid/manajemen');
        }
    
        // ID dan waktu sekarang
        $id = date('ymdHis');  
        $current_time = date('Y-m-d H:i:s');
    
        // Dapatkan token dan enkripsi password
        $token = $this->M_mail->get_token('10002');
        $password = $this->encrypt_password_multiple_layers($this->input->post('password'), $token);
    
        // Persiapan data untuk tabel token
        $params_token = [
            'id_token' => $id,
            'token' => $password,
            'mdb_name' => $this->session->userdata('user_nama'),
            'mdb' => $this->session->userdata('user_id'),
            'mdd' => $current_time,
        ];
    
        // Persiapan data akun
        $icon_akun = 'default.png'; // Default icon
        $file_input = $_FILES['icon_akun'];
    
        if (!empty($file_input['name'])) {
            // Konfigurasi upload file
            $config['upload_path'] = './assets/img/manajemen';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size'] = 2048; // 2MB
            $config['file_name'] = $id; // Gunakan ID sebagai nama file
    
            // Load dan proses upload file
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('icon_akun')) {
                $data = $this->upload->data();
                $icon_akun = $data['file_name']; // Set nama file setelah upload
            }
        }
    
        // Data akun yang akan dimasukkan
        $params_akun = [
            'id_akun' => $id,
            'id_kategori' => $this->input->post('id_kategori'),
            'id_mail' => $this->input->post('id_mail'),
            'id_phone' => $this->input->post('id_phone'),
            'nama_akun' => $this->input->post('nama_akun'),
            'password' => uniqid(), // Set password unik
            'deskripsi_akun' => $this->input->post('deskripsi_akun'),
            'status' => $this->input->post('status'),
            'icon_akun' => $icon_akun,
            'mdb_name' => $this->session->userdata('user_nama'),
            'mdb' => $this->session->userdata('user_id'),
            'mdd' => $current_time,
        ];
    
        // Simpan data akun dan token ke database
        if ($this->db->insert('akun', $params_akun) && $this->db->insert('token', $params_token)) {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data akun berhasil dibuat.</div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Maaf akun gagal terbuat, silahkan coba lagi.</div>');
        }
    
        // Redirect setelah proses
        return redirect('trial/invalid/manajemen');
    }

    /* Enkripsi password */
    function encrypt_password_multiple_layers($password, $token) {
        ini_set('memory_limit', '256M'); // Set ke limit yang lebih besar sesuai kebutuhan
        $token_decode = base64_decode($token);
        $layers = explode('-', $token_decode)[2];
        $encryption_key = base64_decode($token); // Gunakan kunci enkripsi yang aman
        $encrypted_password = $password;
        for ($i = 0; $i < $layers; $i++) {
            $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
            $encrypted_password = openssl_encrypt($encrypted_password, 'aes-256-cbc', $encryption_key, 0, $iv);
            // Gabungkan hasil enkripsi dan IV setiap kali untuk memastikan dekripsi bisa dilakukan
            $encrypted_password = base64_encode($encrypted_password . '::' . $iv);
        }
        return $encrypted_password;
    }

    /* Edit Akun */
    public function edit_proses(){
        // Validasi input
        $this->form_validation->set_rules('id_akun', 'ID Akun', 'required|trim');
        $this->form_validation->set_rules('id_kategori', 'Kategori', 'required|trim');
        $this->form_validation->set_rules('nama_akun', 'Nama mail', 'required|trim');
        $this->form_validation->set_rules('deskripsi_akun', 'Deskripsi mail', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'trim');
        $this->form_validation->set_rules('status', 'Status Akun', 'required|trim');

        // Cek Validasi
        if ($this->form_validation->run() == false) {
            // Mengatur pesan flashdata untuk ditampilkan di halaman tujuan
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'. validation_errors() .'</div>');
            
            // Redirect ke halaman tujuan
            redirect('trial/invalid/manajemen');
        }
        
        // Get ID
        $id = $this->input->post('id_akun');  
        $current_time = date('Y-m-d H:i:s');

        // Get Token
        $token = $this->M_manajemen->get_token('10002');
        $password = $this->input->post('password');        


        // Check password is same or not
        if($this->input->post('old_password') == $password){
            $update_password = false;
        }else{
            $update_password = true;
            // Generate Password
            $password = $this->encrypt_password_multiple_layers($password, $token);

            // Params Update Password
            $params_token = [
                'id_token' => date('ymdHis'),
                'id_old_token' => $id,
                'token' => $password,
                'mdb_name' => $this->session->userdata('user_nama'),
                'mdb' => $this->session->userdata('user_id'),
                'mdd' => date('Y-m-d H:i:s'),
            ];
        }

        // Get data akun
        $akun = $this->M_manajemen->get_data_akun_by_id($id);
        

        // Persiapan data akun
        $icon_akun = $akun['icon_akun']; // Default icon
        $file_input = $_FILES['icon_akun'];
        if (!empty($file_input['name'])) {
            // Konfigurasi upload file
            $config['upload_path'] = './assets/img/manajemen';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size'] = 2048; // 2MB
            $config['file_name'] = $id; // Gunakan ID sebagai nama file
    
            // Load dan proses upload file
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('icon_akun')) {
                $data = $this->upload->data();
                $icon_akun = $data['file_name']; // Set nama file setelah upload
            }

            // Unlink file lama
            if($akun['icon_akun'] != 'default.png'){
                unlink(FCPATH . 'assets/img/manajemen/' . $akun['icon_akun']);
            }
        }

        // Input proses
        $params = [
            'id_akun' => $id,
            'id_kategori' => $this->input->post('id_kategori'),
            'id_mail' => $this->input->post('id_mail'),
            'id_phone' => $this->input->post('id_phone'),
            'nama_akun' => $this->input->post('nama_akun'),
            'password' => uniqid(), // Set password unik
            'deskripsi_akun' => $this->input->post('deskripsi_akun'),
            'status' => $this->input->post('status'),
            'icon_akun' => $icon_akun,
            'mdb_name' => $this->session->userdata('user_nama'),
            'mdb' => $this->session->userdata('user_id'),
            'mdd' => $current_time,
        ];
        
        $where = ['id_akun' => $id];

        if ($this->db->update('akun', $params, $where)) {
            if($update_password){
                $this->db->insert('token', $params_token);
            }
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data akun berhasil diubah.</div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Maaf akun gagal terbuat, silahkan coba lagi.</div>');
        }

        // Redirect setelah input
        return redirect('trial/invalid/manajemen');
        
    }

    /* Hapuus akun */
public function hapus_akun($id_akun)
    {
        $where = ['id_akun' => $id_akun];
        $where2 = ['id_token' => $id_akun];
        $where3 = ['id_old_token' => $id_akun];

        if ($this->M_manajemen->delete('akun', $where) && $this->M_manajemen->delete('token', $where2) && $this->M_manajemen->delete('token', $where3)) {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data akun berhasil dihapus.</div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data akun gagal dihapus.</div>');
        }
        redirect(('trial/invalid/manajemen'));
    }



}
