<?php
defined('BASEPATH') or exit('No direct script access allowed');

class user extends CI_Controller
{

    //Untuk mendefinisikan judul dalam sebuah halaman
    private $sub_title;
    private $main_title;

    public function __construct()
    {
        parent::__construct();
        cek_akses_halaman();
        $this->load->library('form_validation');
        $this->load->model('setting/user/M_user');
        $this->load->model('setting/sistem/M_role');
        $this->load->model('M_portal');
        $this->sub_title = 'User';
        $this->main_title = 'User Manajemen';
    }


    public function index()
    {
        // Mengambil data dari session
        $user_id = $this->session->userdata('user_id');
        $data['all_users'] = $this->M_user->get_all_data_user();
        $data['all_role'] = $this->M_role->get_all_role_data();
        $data['user'] = $this->M_user->get_data_user_by_id($user_id);

        //Mengambil data portal untuk judul dari Model
        $data['portal_data'] = $this->M_portal->get_data_portal();
        $data['portal'] = $data['portal_data'][0]['portal_nm'];

        // cek data
        // dd($data['all_users']);

        // Data Judul
        $data['main_title'] = $this->main_title;
        $data['sub_title'] = $this->sub_title;

        // Display
        $this->load->view('templates/header_backend', $data);
        $this->load->view('templates/sidebar_backend', $data);
        $this->load->view('templates/topbar_backend', $data);
        $this->load->view('setting/user/user/index');
        $this->load->view('templates/footer_backend', $data);
    }

    /* Tambah User */
    public function tambah_proses()
    {
        // Validasi
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

        // Jika data validasi salah maka akan menembalikan halaman ke halaman user
        if ($this->form_validation->run() == false) {
            // Mengambil data dari session
            $user_id = $this->session->userdata('user_id');
            $data['all_users'] = $this->M_user->get_all_data_user();
            $data['all_role'] = $this->M_role->get_all_role_data();
            $data['user'] = $this->M_user->get_data_user_by_id($user_id);

            //Mengambil data portal untuk judul dari Model
            $data['portal_data'] = $this->M_portal->get_data_portal();
            $data['portal'] = $data['portal_data'][0]['portal_nm'];

            // cek data
            // dd($data['user']);

            // Data Judul
            $data['main_title'] = $this->main_title;
            $data['sub_title'] = $this->sub_title;

            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data gagal ditambahkan, periksa kesempurnaan data yang diinputkan.</div>');
            // Display
            $this->load->view('templates/header_backend', $data);
            $this->load->view('templates/sidebar_backend', $data);
            $this->load->view('templates/topbar_backend', $data);
            $this->load->view('setting/user/user/index');
            $this->load->view('templates/footer_backend', $data);
        } else {
            // Generate USER_ID
            $prefix = date('ymd');
            $param_prefix = $prefix . '%';
            $user_id = $this->M_user->get_user_last_id($prefix, $param_prefix);
            $file_input = $_FILES['user_img_name'];
            // dd($file_input);

            if (empty($file_input['name'])) {
                $user_img_name = 'default.png';
                $params = [
                    'user_id' => $user_id,
                    'user_alias' => $this->input->post('user_alias', true),
                    'user_nama' =>  htmlspecialchars($this->input->post('user_nama', true)),
                    'user_mail' => htmlspecialchars($this->input->post('user_mail', true)),
                    'user_pass' => password_hash($this->input->post('user_pass'), PASSWORD_DEFAULT),
                    'user_img_name' => $user_img_name,
                    'user_st' => $this->input->post('user_st', true),
                    'mdd' => date('Y-m-d H:i:s'),
                    'mdb' => $this->session->userdata('user_id'),
                    'mdb_name' => $this->session->userdata('user_nama')
                ];

                $params_role_user_data = [
                    'user_id' => $user_id,
                    'role_id' => $this->input->post('role_id')
                ];

                if ($this->db->insert('mst_user', $params)) {
                    if ($this->db->insert('mst_role_user', $params_role_user_data)) {
                        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Selamat data akun berhasil terbuat.</div>');
                        redirect(('setting/user/user'));
                    } else {
                        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Maaf pengguna tidak dapat membuat akun, silahkan coba kembali.</div>');
                        redirect(('setting/user/user'));
                    }
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Maaf akun gagal terbuat, silahkan coba lagi.</div>');
                    redirect(('setting/user/user'));
                }
            } else {
                // upload file foto profil
                $config['upload_path'] = './assets/img/profile'; // Lokasi penyimpanan file
                $config['allowed_types'] = 'jpg|jpeg|png'; // Jenis file yang diizinkan
                $config['max_size'] = 2048; // Ukuran maksimum file (dalam kilobytes)
                $config['file_name'] = $user_id; // Nama file setelah diunggah (bisa disesuaikan)

                // Load library upload file
                $this->load->library('upload', $config);

                if ($this->upload->do_upload('user_img_name')) {
                    $data = $this->upload->data();
                    $file_name =  $data['file_name'];

                    // Data ke database
                    $params = [
                        'user_id' => $user_id,
                        'user_alias' => $this->input->post('user_alias', true),
                        'user_nama' =>  htmlspecialchars($this->input->post('user_nama', true)),
                        'user_mail' => htmlspecialchars($this->input->post('user_mail', true)),
                        'user_pass' => password_hash($this->input->post('user_pass'), PASSWORD_DEFAULT),
                        'user_img_name' => $file_name,
                        'user_st' => $this->input->post('user_st', true),
                        'mdd' => date('Y-m-d H:i:s'),
                        'mdb' => $this->session->userdata('user_id'),
                        'mdb_name' => $this->session->userdata('user_nama')
                    ];

                    $params_role_user_data = [
                        'user_id' => $user_id,
                        'role_id' => $this->input->post('role_id')
                    ];
                    if ($this->db->insert('mst_user', $params)) {
                        if ($this->db->insert('mst_role_user', $params_role_user_data)) {
                            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Selamat data akun berhasil terbuat</div>');
                            redirect(('setting/user/user'));
                        } else {
                            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Maaf pengguna tidak dapat membuat akun, silahkan coba kembali.</div>');
                            redirect(('setting/user/user'));
                        }
                    } else {
                        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Maaf akun gagal terbuat, silahkan coba lagi.</div>');
                        redirect(('setting/user/user'));
                    }
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Maaf akun gagal terbuat, file foto profil salah dengan error' . $this->upload->display_errors() . 'silahkan coba lagi.</div>');
                    redirect(('setting/user/user'));
                }
            }
        }
    }

    /* Edit User */
    public function edit_proses()
    {
        // Validasi
        $this->form_validation->set_rules('user_alias', 'Nama', 'required|trim');


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

        // Jika data validasi salah maka akan menembalikan halaman ke halaman user
        if ($this->form_validation->run() == false) {
            // Mengambil data dari session
            $user_id = $this->session->userdata('user_id');
            $data['all_users'] = $this->M_user->get_all_data_user();
            $data['all_role'] = $this->M_role->get_all_role_data();
            $data['user'] = $this->M_user->get_data_user_by_id($user_id);

            //Mengambil data portal untuk judul dari Model
            $data['portal_data'] = $this->M_portal->get_data_portal();
            $data['portal'] = $data['portal_data'][0]['portal_nm'];

            // cek data
            // dd($data['user']);

            // Data Judul
            $data['main_title'] = $this->main_title;
            $data['sub_title'] = $this->sub_title;

            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data gagal ditambahkan, periksa kesempurnaan data yang diinputkan.</div>');
            // Display
            $this->load->view('templates/header_backend', $data);
            $this->load->view('templates/sidebar_backend', $data);
            $this->load->view('templates/topbar_backend', $data);
            $this->load->view('setting/user/user/index');
            $this->load->view('templates/footer_backend', $data);
        } else {
            $file_input = $_FILES['user_img_name'];
            // dd($file_input);

            $user_id = $this->input->post('user_id');
            $role_id_key = $this->input->post('role_id_key');

            if (empty($file_input['name'])) {
                $params = [
                    'user_alias' => $this->input->post('user_alias', true),
                    'user_pass' => password_hash($this->input->post('user_pass'), PASSWORD_DEFAULT),
                    'user_st' => $this->input->post('user_st', true),
                    'mdd' => date('Y-m-d H:i:s'),
                    'mdb' => $this->session->userdata('user_id'),
                    'mdb_name' => $this->session->userdata('user_nama')
                ];

                $where = [
                    'user_id' => $user_id
                ];

                $params_role_user_data = [
                    'role_id' => $this->input->post('role_id')
                ];

                $where_role_user_data = [
                    'user_id' => $user_id,
                    'role_id' => $role_id_key
                ];

                if ($this->db->update('mst_user', $params, $where)) {
                    if ($this->db->update('mst_role_user', $params_role_user_data, $where_role_user_data)) {
                        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Selamat data akun berhasil di ubah.</div>');
                        redirect(('setting/user/user'));
                    } else {
                        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Maaf pengguna tidak dapat mengubah akun, silahkan coba kembali.</div>');
                        redirect(('setting/user/user'));
                    }
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Maaf akun gagal di ubah, silahkan coba lagi.</div>');
                    redirect(('setting/user/user'));
                }
            } else {
                // upload file foto profil
                $config['upload_path'] = './assets/img/profile'; // Lokasi penyimpanan file
                $config['allowed_types'] = 'jpg|jpeg|png'; // Jenis file yang diizinkan
                $config['max_size'] = 2048; // Ukuran maksimum file (dalam kilobytes)
                $config['file_name'] = $user_id; // Nama file setelah diunggah (bisa disesuaikan)

                // Load library upload file
                $this->load->library('upload', $config);

                if ($this->upload->do_upload('user_img_name')) {
                    $old_image = $this->input->post('old_image');
                    $data = $this->upload->data();
                    $file_name =  $data['file_name'];

                    /*  Cek jika gambar adalah default.png maka jangan hapus file gambar di folder aplikasi
                    Sebaliknya jika gambar bukan default.png maka hapus file tersebut dari dalam folder aplikasi */
                    if ($old_image != 'default.png') {
                        // Unlink untuk menghapus gambar
                        unlink(FCPATH . 'assets/img/profile/' . $old_image);
                    }

                    // Data ke database
                    $params = [
                        'user_alias' => $this->input->post('user_alias', true),
                        'user_pass' => password_hash($this->input->post('user_pass'), PASSWORD_DEFAULT),
                        'user_img_name' => $file_name,
                        'user_st' => $this->input->post('user_st', true),
                        'mdd' => date('Y-m-d H:i:s'),
                        'mdb' => $this->session->userdata('user_id'),
                        'mdb_name' => $this->session->userdata('user_nama')
                    ];
                    $where = [
                        'user_id' => $user_id
                    ];

                    $params_role_user_data = [
                        'user_id' => $user_id,
                        'role_id' => $this->input->post('role_id')
                    ];
                    // dd($params_role_user_data);

                    $where_role_user_data = [
                        'user_id' => $user_id,
                        'role_id' => $role_id_key
                    ];
                    if ($this->db->update('mst_user', $params, $where)) {
                        if ($this->db->update('mst_role_user', $params_role_user_data, $where_role_user_data)) {
                            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Selamat data akun berhasil di ubah.</div>');
                            redirect(('setting/user/user'));
                        } else {
                            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Maaf pengguna tidak dapat mengubah akun, silahkan coba kembali.</div>');
                            redirect(('setting/user/user'));
                        }
                    } else {
                        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Maaf akun gagal di ubah, silahkan coba lagi.</div>');
                        redirect(('setting/user/user'));
                    }
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Maaf akun gagal di ubah, file foto profil salah dengan error' . $this->upload->display_errors() . 'silahkan coba lagi.</div>');
                    redirect(('setting/user/user'));
                }
            }
        }
    }

    /* Hapuus Pengguna */
    public function hapus_user($user_id)
    {
        $where = ['user_id' => $user_id];

        if ($this->M_user->delete('mst_user', $where) && $this->M_user->delete('mst_role_user', $where)) {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data user berhasil dihapus.</div>');
            redirect(('setting/user/user'));
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data user gagal dihapus.</div>');
            redirect(('setting/user/user'));
        }
    }
}
