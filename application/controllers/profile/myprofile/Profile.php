<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends CI_Controller
{

    //Untuk mendefinisikan judul dalam sebuah halaman
    private $sub_title;
    private $main_title;

    public function __construct()
    {
        parent::__construct();
        cek_akses_halaman();
        $this->load->library('form_validation');
        $this->load->model('profile/myprofile/M_profile');
        $this->load->model('M_portal');
        $this->load->model('M_portal');
        $this->sub_title = 'Profil Saya';
        $this->main_title = 'Profil';
    }


    public function index()
    {
        // Mengambil data dari session
        $user_id = $this->session->userdata('user_id');
        $data['user'] = $this->M_profile->get_data_user_by_id($user_id);
        // dd($data);
        //Mengambil data portal untuk judul dari Model
        $data['portal_data'] = $this->M_portal->get_data_portal();
        $data['portal'] = $data['portal_data'][0]['portal_nm'];

        // Data Judul
        $data['main_title'] = $this->main_title;
        $data['sub_title'] = $this->sub_title;
        // Display
        $this->load->view('templates/header_backend', $data);
        $this->load->view('templates/sidebar_backend', $data);
        $this->load->view('templates/topbar_backend', $data);
        $this->load->view('profile/myprofile/index', $data);
        $this->load->view('templates/footer_backend', $data);
    }

    /* Edit Profile */
    public function edit_proses()
    {
        // Validasi
        $this->form_validation->set_rules('user_alias', 'Nama Pengguna', 'required|trim');
        $this->form_validation->set_rules('tempat_lahir', 'Tempat Lahir', 'required|trim');
        $this->form_validation->set_rules('tgl_lahir', 'Tanggal Lahir', 'required|trim');
        $this->form_validation->set_rules('alamat', 'Alamat Tempat Tinggal', 'required|trim|max_length[100]');
        $this->form_validation->set_rules('no_tlp', 'Nomor Ponsel', 'required|trim|numeric|max_length[13]');
        $this->form_validation->set_rules('no_whatsapp', 'Nomor Whatsapp', 'required|trim|numeric|max_length[13]');
        $this->form_validation->set_rules('no_telegram', 'Nomor Telegram', 'required|trim|numeric|max_length[13]');
        $this->form_validation->set_rules('instagram', 'Akun Instagram', 'required|trim');
        $this->form_validation->set_rules('facebook', 'Akun Facebook', 'required|trim');
        $this->form_validation->set_rules('twitter', 'Akun Twitter', 'required|trim');

        // Jika data validasi salah maka akan menembalikan halaman ke halaman user
        if ($this->form_validation->run() == false) {
            // Mengambil data dari session
            $user_id = $this->session->userdata('user_id');
            $data['user'] = $this->M_profile->get_data_user_by_id($user_id);

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
            $this->load->view('profile/myprofile/index');
            $this->load->view('templates/footer_backend', $data);
        } else {
            $file_input = $_FILES['user_img_name'];
            // dd($file_input);

            $user_id = $this->input->post('user_id');
            if (empty($file_input['name'])) {
                $params = [
                    'user_alias' => $this->input->post('user_alias', true),
                    'tempat_lahir' => $this->input->post('tempat_lahir', true),
                    'tgl_lahir' => $this->input->post('tgl_lahir', true),
                    'alamat' => $this->input->post('alamat', true),
                    'no_tlp' => $this->input->post('no_tlp', true),
                    'no_whatsapp' => $this->input->post('no_whatsapp', true),
                    'no_telegram' => $this->input->post('no_telegram', true),
                    'facebook' => $this->input->post('facebook', true),
                    'instagram' => $this->input->post('instagram', true),
                    'twitter' => $this->input->post('twitter', true),
                    'mdd' => date('Y-m-d H:i:s'),
                    'mdb' => $this->session->userdata('user_id'),
                    'mdb_name' => $this->session->userdata('user_nama')
                ];

                $where = [
                    'user_id' => $user_id
                ];


                if ($this->db->update('mst_user', $params, $where)) {
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Selamat data akun anda berhasil di ubah.</div>');
                    redirect(('profile/myprofile/profile'));
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Maaf akun gagal di ubah, silahkan coba lagi.</div>');
                    redirect(('profile/myprofile/profile'));
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
                        'user_img_name' => $file_name,
                        'tempat_lahir' => $this->input->post('tempat_lahir', true),
                        'tgl_lahir' => $this->input->post('tgl_lahir', true),
                        'alamat' => $this->input->post('alamat', true),
                        'no_tlp' => $this->input->post('no_tlp', true),
                        'no_whatsapp' => $this->input->post('no_whatsapp', true),
                        'no_telegram' => $this->input->post('no_telegram', true),
                        'facebook' => $this->input->post('facebook', true),
                        'instagram' => $this->input->post('instagram', true),
                        'twitter' => $this->input->post('twitter', true),
                        'mdd' => date('Y-m-d H:i:s'),
                        'mdb' => $this->session->userdata('user_id'),
                        'mdb_name' => $this->session->userdata('user_nama')
                    ];
                    $where = [
                        'user_id' => $user_id
                    ];

                    if ($this->db->update('mst_user', $params, $where)) {
                        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Selamat data akun anda berhasil di ubah.</div>');
                        redirect(('profile/myprofile/profile'));
                    } else {
                        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Maaf akun gagal di ubah, silahkan coba lagi.</div>');
                        redirect(('profile/myprofile/profile'));
                    }
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Maaf akun gagal di ubah, file foto profil salah dengan error' . $this->upload->display_errors() . 'silahkan coba lagi.</div>');
                    redirect(('profile/myprofile/profile'));
                }
            }
        }
    }

    /* Ubah Password */
    public function ubah_password_proses()
    {
        // validasi
        $this->form_validation->set_rules('old_user_pass', 'Password Lama', 'required|trim');
        $this->form_validation->set_rules('new_user_pass', 'Password Baru', 'required|trim|min_length[3]|matches[confirm_pass]');
        $this->form_validation->set_rules('confirm_pass', 'Konfirmasi Password', 'required|trim|matches[new_user_pass]');

        // Proses validasi
        if ($this->form_validation->run() == false) {
            // Mengambil data dari session
            $user_id = $this->session->userdata('user_id');
            $data['user'] = $this->M_profile->get_data_user_by_id($user_id);

            //Mengambil data portal untuk judul dari Model
            $data['portal_data'] = $this->M_portal->get_data_portal();
            $data['portal'] = $data['portal_data'][0]['portal_nm'];

            // Data Judul
            $data['main_title'] = $this->main_title;
            $data['sub_title'] = $this->sub_title;

            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data gagal ditambahkan, periksa kesempurnaan data yang diinputkan.</div>');
            // Display
            $this->load->view('templates/header_backend', $data);
            $this->load->view('templates/sidebar_backend', $data);
            $this->load->view('templates/topbar_backend', $data);
            $this->load->view('profile/myprofile/index');
            $this->load->view('templates/footer_backend', $data);
        } else {
            // Cek kesamaan password lama yang diinputkan dengan yang ada di database
            $password_lama = $this->input->post('old_user_pass');

            // Get data password saat ini
            $user_id = $this->session->userdata('user_id');
            $password_sekarang = $this->M_profile->get_password_now($user_id)['user_pass'];

            // proses cek password
            if (!password_verify($password_lama, $password_sekarang)) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Gagal, Password lama tidak ditemukan.</div>');
                redirect('profile/myprofile/profile');
            } else {
                // Cek kesamaan password lama dengan password baru
                $password_baru = $this->input->post('new_user_pass');

                // Proses cek kesamaan pasword lama dengan password baru
                if ($password_lama == $password_baru) {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Gagal, password lama dengan password baru tidak boleh sama.</div>');
                    redirect('profile/myprofile/profile');
                } else {
                    // Jika validasi password ok

                    // Encrypt password
                    $password_hash = password_hash($password_baru, PASSWORD_DEFAULT);
                    $params = [
                        'user_pass' => $password_hash
                    ];

                    $where = [
                        'user_id' => $user_id
                    ];

                    if ($this->db->update('mst_user', $params, $where)) {
                        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berhasil, Data password telah diubah.</div>');
                        redirect('profile/myprofile/profile');
                    }
                }
            }
        }
    }
}
