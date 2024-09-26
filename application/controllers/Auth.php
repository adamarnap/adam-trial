<?php
defined('BASEPATH') or exit('No direct script access allowed');

class auth extends CI_Controller
{

    private $portal;

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('auth/M_auth');
        $this->load->model('M_portal');
        $portal_data = $this->M_portal->get_data_portal();
        $portal_nama = $portal_data[0]['portal_nm'];
        $this->portal = $portal_nama;
    }

    public function index()
    {
        // Cek Status Login
        if ($this->session->userdata('user_nama')) {
            redirect('dashboard');
        }
        // validasi
        $this->form_validation->set_rules('user_nama', 'Username', 'required|trim');
        $this->form_validation->set_rules('user_pass', 'user_pass', 'required|trim');
        // proses
        if ($this->form_validation->run() == false) {
            // ketika validasi gagal
            $data['title'] =  $this->portal . ' | Login';
            $data['portal'] =  $this->portal;
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/login');
            $this->load->view('templates/auth_footer');
        } else {
            // ketika valdasi berhasil
            // memanggil method login
            $this->_login();
        }
    }

    /* Method Login */
    private function _login()
    {
        // Get data dari form input
        $user_nama  = $this->input->post('user_nama');
        $user_pass  = $this->input->post('user_pass');

        // cek username
        // Get data dari database sesuai data yang diinputkan
        $user = $this->M_auth->get_user_nama_by_input($user_nama);
        // Proses
        if ($user) {
            // Jika username terdaftar
            if ($user['user_st']) {
                // Jika username aktif
                // Cek password
                if (password_verify($user_pass, $user['user_pass'])) {
                    // Jika password benar

                    // Simpan data di session 
                    $data = [
                        'user_id' => $user['user_id'],
                        'user_nama' => $user['user_nama'],
                        'user_st' => $user['user_st'],
                        'user_mail' => $user['user_mail'],
                        'user_img_name' => $user['user_img_name'],
                        'role_id' => $user['role_id'],
                        'role_default' => $user['role_default'],
                        'role_tampil' => $user['role_tampil']
                    ];

                    // Simpan $data ke session
                    $this->session->set_userdata($data);

                    // Redirect berdasarkan role user
                    if ($user['role_id'] == 01) {
                        redirect(('admin'));
                    } elseif ($user['role_id'] == 02) {
                        redirect(('mentor'));
                    } elseif ($user['role_id'] == 03) {
                        redirect(('siswa'));
                    }
                } else {
                    // Jika password salah
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Maaf password yang diinputkan salah.</div>');
                    redirect(('auth'));
                }
            } else {
                // Jika username tidak aktif
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Maaf aktivasi akun belum dilakukan.</div>');
                redirect(('auth'));
            }
        } else {
            // Jika username tidak terdaftar
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Maaf username tidak terdaftar.</div>');
            redirect(('auth'));
        }
    }

    /* Register */
    public function register()
    {
        // Cek Status Login
        if ($this->session->userdata('user_nama')) {
            redirect('dashboard');
        }

        // validasi
        $this->form_validation->set_rules('user_alias', 'Nama', 'required|trim');
        $this->form_validation->set_rules(
            'user_nama',
            'Username',
            'required|trim|is_unique[mst_user.user_nama]',
            array(
                'is_unique' => 'Username yang diinputkan sudah digunakan user lain !'
            )
        );
        $this->form_validation->set_rules(
            'user_mail',
            'Email',
            'required|trim|valid_email|is_unique[mst_user.user_mail]',
            array(
                'is_unique' => 'Email yang diinputkan sudah digunakan user lain !'
            )
        );
        $this->form_validation->set_rules(
            'user_pass',
            'Password',
            'required|trim|min_length[3]|matches[confirm_pass]',
            array(
                'matches' => 'Konfirmasi pasword tidak sama !',
                'min_length' => 'Password harus terdiri dari minimal 6 karakter !'
            )
        );
        $this->form_validation->set_rules('confirm_pass', 'Konfirmasi Password', 'required|trim|matches[user_pass]');

        // proses
        if ($this->form_validation->run() == false) {
            $data['title'] = $this->portal . ' | Registrasi';
            $data['portal'] =  $this->portal;
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/register');
            $this->load->view('templates/auth_footer');
        } else {
            // Generate USER_ID
            $prefix = date('ymd');
            $param_prefix = $prefix . '%';
            $user_id = $this->M_auth->get_user_last_id($prefix, $param_prefix);
            // dd($user_id);
            $params = [
                'user_id' => $user_id,
                'user_alias' => $this->input->post('user_alias', true),
                'user_nama' =>  htmlspecialchars($this->input->post('user_nama', true)),
                'user_mail' => htmlspecialchars($this->input->post('user_mail', true)),
                'user_pass' => password_hash($this->input->post('user_pass'), PASSWORD_DEFAULT),
                'user_img_name' => 'default.png',
                'user_st' => '0',
                'mdd' => date('Y-m-d H:i:s')
            ];
            $params_role = [
                'user_id' => $user_id,
                'role_id' => '02'
            ];

            // Data Token
            $token = base64_encode(random_bytes(32));

            // Data untuk menyimpan data token user sementara
            $params_token = [
                'user_mail' => htmlspecialchars($this->input->post('user_mail', true)),
                'jenis_verifikasi' => 'aktifasi_akun',
                'token' => $token,
                'date_created' => time()
            ];

            // Selamat data akun anda berhasil terbuat, silahkan login.
            if ($this->db->insert('mst_user', $params)) {
                if ($this->db->insert('mst_role_user', $params_role) && $this->db->insert('mst_token_verification', $params_token)) {
                    // memanggil method _sendEmail
                    $this->_sendEmail($token, 'aktifasi_akun');
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Email aktifasi akun telah dikirimkan ke <u><b>' .  htmlspecialchars($this->input->post('user_mail', true)) . '</b></u> Silahkan aktifasi akun anda sebelum kadaluarsa dalam 1 Jam dari sekarang. </div>');
                    redirect(('auth'));
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Maaf pengguna tidak dapat membuat akun, silahkan coba kembali.</div>');
                    redirect(('auth'));
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Maaf akun gagal terbuat, silahkan coba lagi.</div>');
                redirect(('auth'));
            }
        }
    }

    /* Proses Kirim Email */
    private function _sendEmail($token, $jenis_verifikasi)
    {
        // Get data portal dari mst_portal
        $portal = $this->M_auth->get_data_portal();
        // Get data email dari mst_email
        $email = $this->M_auth->get_data_email();
        // dd($email);

        $config = [
            'protocol' => 'smtp',
            'smtp_host' => $email['smtp_host'],
            'smtp_user' => $email['smtp_username'],
            'smtp_pass' => $email['smtp_password'],
            'smtp_port' => $email['smtp_port'],
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'newline' => "\r\n"
        ];

        // load library
        $this->load->library('email', $config);

        $this->email->initialize($config);

        
        // Penentuan jenis verifikasi

        // Jika jenis verifikasi untuk aktifasi akun
        if ($jenis_verifikasi == 'aktifasi_akun') {

            $this->email->from($email['email_address'], $email['email_name'].' | Aktifasi Akun');
            $this->email->to($this->input->post('user_mail'));

            $this->email->subject('Aktifasi Akun Pengguna | ' . $portal['site_title']);
            // Data isi Pesan
            $data_isi_pesan['nama_lengkap'] = $this->input->post('user_alias');
            $data_isi_pesan['user_nama'] = htmlspecialchars($this->input->post('user_nama', true));
            $data_isi_pesan['user_mail'] = htmlspecialchars($this->input->post('user_mail', true));
            $data_isi_pesan['data_website'] = $portal['site_title'];
            $data_isi_pesan['token'] = $token;
            $data_isi_pesan['url_aktifasi'] = 'auth/verify?user_mail=' . $data_isi_pesan['user_mail'] . '&token=' . urlencode($token);

            // Memanggil isi pesan yang disimpan dalam file html
            $message = $this->load->view('auth/email_activation', $data_isi_pesan, TRUE);

            $this->email->message($message);
        }
        // Jika aktifasi untuk pemulihan password
        elseif ($jenis_verifikasi == 'lupa_password') {

            $this->email->from($email['email_address'], $email['email_name'] . ' | Pemulihan Password');
            $this->email->to($this->input->post('user_mail'));

            $this->email->subject('Pemulihan Password Pengguna | ' . $portal['site_title']);
            // Data isi Pesan
            $data_isi_pesan['nama_lengkap'] = $this->input->post('user_alias');
            $data_isi_pesan['user_nama'] = htmlspecialchars($this->input->post('user_nama', true));
            $data_isi_pesan['user_mail'] = htmlspecialchars($this->input->post('user_mail', true));
            $data_isi_pesan['data_website'] = $portal['site_title'];
            $data_isi_pesan['token'] = $token;
            $data_isi_pesan['url_aktifasi'] = 'auth/reset_password?user_mail=' . $data_isi_pesan['user_mail'] . '&token=' . urlencode($token);

            // Memanggil isi pesan yang disimpan dalam file html
            $message = $this->load->view('auth/email_reset_password', $data_isi_pesan, TRUE);

            $this->email->message($message);
        }

        if ($this->email->send()) {
            // print_r('send');die;
            return true;
        } else {
            echo $this->email->print_debugger();
            die;
        }
    }


    /* Proses Verifikasi Aktifasi Akun */
    public function verify()
    {
        // Get data dari url
        $user_mail = $this->input->get('user_mail');
        $token = $this->input->get('token');

        // Get data dari database mst_user by email yang berasal dari url
        $user = $this->M_auth->get_user_by_user_mail($user_mail);

        // Proses cek email yang berasal dari url dengan email yang ada di database
        if ($user) {

            // Get data dari database mst_token_verification by token yang berasal dari url
            $user_token = $this->M_auth->get_user_token_by_token($token);

            // Proses cek email yang berasal dari url dengan email yang ada di database
            if ($user_token) {

                // Proses cek kadaluarsa token dalam satu jam / 3600 detik
                if ((time() - $user_token['date_created']) < (3600)) {
                    // Jika akun sudah diaktifasi maka data mst_user akan di update user_st menjadi aktif , dan data token dan user akan dihapus
                    $params_data_user = ['user_st' => '1'];

                    $this->M_auth->update('mst_user', $params_data_user, ['user_mail' => $user_mail]);
                    $this->M_auth->delete('mst_token_verification', ['user_mail' => $user_mail]);

                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert"><b><u>' . $user_mail . '</u></b> Berhasil teraktifasi, Silahkan Login</div>');
                    redirect(('auth'));
                } else {

                    // Jika token telah kadaluarsa maka data user akan dihapus
                    $this->M_auth->delete('mst_user', ['user_mail' => $user_mail]);
                    $this->M_auth->delete('mst_token_verification', ['user_mail' => $user_mail]);

                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Aktifasi akun gagal, Token telah kadaluarsa !</div>');
                    redirect(('auth'));
                }
            } else {

                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Aktifasi akun gagal, Token tidak ditemukan !</div>');
                redirect(('auth'));
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Aktifasi akun gagal, email tidak ditemukan !</div>');
            redirect(('auth'));
        }
    }

    /* Proses Verifikasi Reset Password Akun */
    public function reset_password()
    {
        // Get data dari url
        $user_mail = $this->input->get('user_mail');
        $token = $this->input->get('token');

        // Get data dari database mst_user by email yang berasal dari url
        $user = $this->M_auth->get_user_by_user_mail($user_mail);

        // Proses cek email yang berasal dari url dengan email yang ada di database
        if ($user) {

            // Get data dari database mst_token_verification by token yang berasal dari url
            $user_token = $this->M_auth->get_user_token_by_token($token);

            // Proses cek email yang berasal dari url dengan email yang ada di database
            if ($user_token) {

                // Proses cek kadaluarsa token dalam satu jam / 3600 detik
                if ((time() - $user_token['date_created']) < (3600)) {

                    // Beri session jika data token dan email cocok
                    $this->session->set_userdata('data_email_reset_password', $user_mail);
                    // Panggil method ubah password untuk merubah password > menampilkan tampilan form ubah password
                    $this->ubahPassword();
                } else {

                    // Jika token telah kadaluarsa maka data user akan dihapus
                    $this->M_auth->delete('mst_user', ['user_mail' => $user_mail]);
                    $this->M_auth->delete('mst_token_verification', ['user_mail' => $user_mail]);

                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Aktifasi akun gagal, Token telah kadaluarsa !</div>');
                    redirect(('auth'));
                }
            } else {

                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Aktifasi akun gagal, Token tidak ditemukan !</div>');
                redirect(('auth'));
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Aktifasi akun gagal, email tidak ditemukan !</div>');
            redirect(('auth'));
        }
    }



    /* Lupa password */
    public function lupa_password()
    {
        // validasi
        $this->form_validation->set_rules('user_mail', 'Email', 'required|trim|valid_email');

        // proses generate token untuk dikirim email sebagai email verifikasi pemulihan password
        if ($this->form_validation->run() == false) {
            $data['title'] = $this->portal . ' | Lupa Password';
            $data['portal'] =  $this->portal;
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/lupa_password');
            $this->load->view('templates/auth_footer');
        } else {
            // Get data email dari form
            $user_mail = $this->input->post('user_mail');
            // Get data user dari email yang diinputkan oleh pengguna untuk pemulihan password
            $user = $this->M_auth->get_user_is_activated_by_user_mail($user_mail);

            // jika terdapat user maka akan generate token dan simpan ke database
            if ($user) {
                // Data Token
                $token = base64_encode(random_bytes(32));

                // Data untuk menyimpan data token user sementara
                $params_token = [
                    'user_mail' => $this->input->post('user_mail', true),
                    'jenis_verifikasi' => 'lupa_password',
                    'token' => $token,
                    'date_created' => time()
                ];

                // Proses insert data token
                $this->M_auth->insert('mst_token_verification', $params_token);

                // Proses kirim email verifikasi pemulihan password
                $this->_sendEmail($token, 'lupa_password');

                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Verifikasi reset password telah dikrimkan ke <b><u>' . $user_mail . '</u></b></div>');
                redirect(('auth/lupa_password'));
            } else {
                $this->session->set_flashdata('message', '<div class="alert al bert-danger" role="alert">Gagal, data email tidak terdaftar atau belum aktifasi.</div>');
                redirect(('auth/lupa_password'));
            }
        }
    }

    /* ubahPassword */
    public function ubahPassword()
    {
        // Validasi
        $this->form_validation->set_rules(
            'user_pass',
            'Password',
            'required|trim|min_length[3]|matches[confirm_pass]',
            array(
                'matches' => 'Konfirmasi pasword tidak sama !',
                'min_length' => 'Password harus terdiri dari minimal 6 karakter !'
            )
        );
        $this->form_validation->set_rules('confirm_pass', 'Konfirmasi Password', 'required|trim|matches[user_pass]');

        // Proses pemulihan password
        if ($this->form_validation->run() == false) {
            $data['title'] = $this->portal . ' | Rubah Password';
            $data['portal'] =  $this->portal;
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/ubah_password');
            $this->load->view('templates/auth_footer');
        } else {
            $user_pass = password_hash($this->input->post('user_pass'), PASSWORD_DEFAULT);
            $user_mail = $this->session->userdata('data_email_reset_password');

            // Data password baru
            $params_ubah_password = [
                'user_pass' => $user_pass
            ];

            // Data kondisi where by email
            $where_ubah_password = [
                'user_mail' => $user_mail
            ];

            // Proses ubah password di database
            if ($this->M_auth->update('mst_user', $params_ubah_password, $where_ubah_password)) {
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Password anda berhasil dipulihkan, silahkan melakukan login.</div>');
                redirect(('auth'));
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Password anda gagal dipulihkan, silahkan coba pemulihan password kembali.</div>');
                redirect(('auth'));
            }
        }
    }

    /* Logout */
    public function logout()
    {
        $data = ['user_id', 'user_nama', 'user_st', 'user_mail', 'user_img_name', 'role_id', 'role_default', 'role_tampil'];
        $this->session->unset_userdata($data);
        // dd($this->session->userdata);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Anda berhasil logout.</div>');
        redirect(('auth'));
    }

    /* Halaman Blocked 403 Forbidden */
    public function blocked_page()
    {
        $this->load->view('blocked_page');
    }
}
