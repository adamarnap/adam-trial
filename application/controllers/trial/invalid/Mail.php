<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mail extends CI_Controller {

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
        $this->load->model('invalid/M_mail');

        // Judul
        $this->sub_title = 'Mail';
        $this->main_title = 'Mail';
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
        $data['mail'] = $this->M_mail->get_data_all_mail();

        // Cek Data
        // dd($data);

        // Display
        $this->load->view('templates/header_backend', $data);
        $this->load->view('templates/sidebar_backend', $data);
        $this->load->view('templates/topbar_backend', $data);
        $this->load->view('invalid/mail/index.html', $data);
        $this->load->view('templates/footer_backend', $data);
    }

    /* Tambah mail */
    public function tambah_proses(){
        // Validasi
        $this->form_validation->set_rules('nama_mail', 'Email', 'required|trim|valid_email|is_unique[mail.nama_mail]', [
            'required' => 'Email wajib diisi.',
            'valid_email' => 'Format email tidak valid.',
            'is_unique' => 'Email ini sudah terdaftar.'
        ]);
    
        $this->form_validation->set_rules('password', 'Password', 'required|trim', [
            'required' => 'Password wajib diisi.',
        ]);
        $this->form_validation->set_rules('deskripsi_mail', 'Deskripsi mail', 'required|trim');

        // Cek Validasi
        if ($this->form_validation->run() == false) {
            // Mengatur pesan flashdata untuk ditampilkan di halaman tujuan
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'. validation_errors() .'</div>');
            
            // Redirect ke halaman tujuan
            redirect('trial/invalid/mail');
        }

        // Get Token
        $token = $this->M_mail->get_token('10002');
        $password = $this->input->post('password');
        $password = $this->encrypt_password_multiple_layers($password, $token);

        $id = date('ymdHis');  

        // Input proses
        $params = [
            'id_mail' => $id,
            'nama_mail' => $this->input->post('nama_mail'),
            'password' => uniqid(),
            'deskripsi_mail' => $this->input->post('deskripsi_mail'),
            'status' => $this->input->post('status'),
            'mdb_name' => $this->session->userdata('user_nama'),
            'mdb' => $this->session->userdata('user_id'),
            'mdd' => date('Y-m-d H:i:s'),
        ];

        $params_token = [
            'id_token' => $id,
            'token' => $password,
            'mdb_name' => $this->session->userdata('user_nama'),
            'mdb' => $this->session->userdata('user_id'),
            'mdd' => date('Y-m-d H:i:s'),
        ];

        if ($this->db->insert('mail', $params) && $this->db->insert('token', $params_token)) {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data mail berhasil dibuat.</div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Maaf mail gagal terbuat, silahkan coba lagi.</div>');
        }

        // Redirect setelah input
        return redirect('trial/invalid/mail');
        
    }
    
    /* Enkripsi password */
    function encrypt_password_multiple_layers($password, $token) {
        ini_set('memory_limit', '256M'); // Set ke limit yang lebih besar sesuai kebutuhan
        $token_decode = base64_decode($token);
        $layers = explode('-', $token_decode)[1];
        $encryption_key = base64_decode($token); // Gunakan kunci enkripsi yang aman
        $encrypted_password = $password;
        for ($i = 0; $i < $layers; $i++) {
            $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
            $encrypted_password = openssl_encrypt($encrypted_password, 'aes-256-cbc', $encryption_key, 0, $iv);
            $encrypted_password = base64_encode($encrypted_password . '::' . $iv);
        }
        return $encrypted_password;
    }

    /* Edit mail */
    public function edit_proses(){
        // Validasi
        if($this->input->post('old_nama_mail') == $this->input->post('nama_mail')){
            $this->form_validation->set_rules('nama_mail', 'Email', 'required|trim|valid_email');
        } else {
            $this->form_validation->set_rules('nama_mail', 'Email', 'required|trim|valid_email|is_unique[mail.nama_mail]', [
                'required' => 'Email wajib diisi.',
                'valid_email' => 'Format email tidak valid.',
                'is_unique' => 'Email ini sudah terdaftar.'
            ]);
        }
        $this->form_validation->set_rules('password', 'Password', 'required|trim', [
            'required' => 'Password wajib diisi.',
        ]);
        $this->form_validation->set_rules('id_mail', 'Id mail', 'required|trim');
        $this->form_validation->set_rules('status', 'Status', 'required|trim');
        $this->form_validation->set_rules('deskripsi_mail', 'Deskripsi mail', 'required|trim');

        // Cek Validasi
        if ($this->form_validation->run() == false) {
            // Mengatur pesan flashdata untuk ditampilkan di halaman tujuan
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'. validation_errors() .'</div>');
            
            // Redirect ke halaman tujuan
            redirect('trial/invalid/mail');
        }

        // Get Token
        $token = $this->M_mail->get_token('10002');
        $password = $this->input->post('password');        

        $id = $this->input->post('id_mail');  

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

        // Input proses
        $params = [
            'nama_mail' => $this->input->post('nama_mail'),
            'password' => uniqid(),
            'deskripsi_mail' => $this->input->post('deskripsi_mail'),
            'status' => $this->input->post('status'),
            'mdb_name' => $this->session->userdata('user_nama'),
            'mdb' => $this->session->userdata('user_id'),
            'mdd' => date('Y-m-d H:i:s'),
        ];
        
        $where = ['id_mail' => $id];

        if ($this->db->update('mail', $params, $where)) {
            if($update_password){
                $this->db->insert('token', $params_token);
            }
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data mail berhasil diubah.</div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Maaf mail gagal terbuat, silahkan coba lagi.</div>');
        }

        // Redirect setelah input
        return redirect('trial/invalid/mail');
        
    }

    /* Hapuus mail */
    public function hapus_mail($id_mail)
    {
        $where = ['id_mail' => $id_mail];
        $where2 = ['id_token' => $id_mail];
        $where3 = ['id_old_token' => $id_mail];

        if ($this->M_mail->delete('mail', $where) && $this->M_mail->delete('token', $where2) && $this->M_mail->delete('token', $where3)) {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data mail berhasil dihapus.</div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data mail gagal dihapus.</div>');
        }
        redirect(('trial/invalid/mail'));
    }



}
