<?php
defined('BASEPATH') or exit('No direct script access allowed');

class App_data extends CI_Controller
{

    //Untuk mendefinisikan judul dalam sebuah halaman
    private $sub_title;
    private $main_title;

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('setting/sistem/M_app_data');
        $this->load->model('M_portal');
        $this->sub_title = 'Data Aplikasi';
        $this->main_title = 'Sistem';
        cek_akses_halaman();
    }


    public function index()
    {
        // Mengambil data dari session
        $user_id = $this->session->userdata('user_id');
        $data['user'] = $this->M_app_data->get_data_user_by_id($user_id);

        //Mengambil data portal untuk judul dari Model
        $data['portal_data'] = $this->M_portal->get_data_portal();
        $data['portal'] = $data['portal_data'][0]['portal_nm'];
        $data['app_data'] = $this->M_app_data->get_data_app_data($data['portal_data'][0]['portal_id']);
        // dd($data);
        // Data Judul
        $data['main_title'] = $this->main_title;
        $data['sub_title'] = $this->sub_title;

        // Display
        $this->load->view('templates/header_backend', $data);
        $this->load->view('templates/sidebar_backend', $data);
        $this->load->view('templates/topbar_backend', $data);
        $this->load->view('setting/sistem/app_data/index', $data);
        $this->load->view('templates/footer_backend', $data);
    }

    /* Edit logo */
    public function edit_proses()
    {
        // Validasi
        $this->form_validation->set_rules('no_tlp_app', 'Nomor Telephone Aplikasi', 'required|trim');
        $this->form_validation->set_rules('email_app', 'Email Aplikasi', 'required|trim');
        $this->form_validation->set_rules('no_whatsapp_app', 'Nomor Whatsapp Aplikasi', 'required|trim');
        $this->form_validation->set_rules('no_telegram_app', 'Nomor Telegram Aplikasi', 'required|trim');
        $this->form_validation->set_rules('instagram_app', 'Nomor Instagram Aplikasi', 'required|trim');
        $this->form_validation->set_rules('facebook_app', 'Facebook Aplikasi', 'required|trim');
        $this->form_validation->set_rules('tiktok_app', 'Tik Tok Aplikasi', 'required|trim');
        $this->form_validation->set_rules('twitter_app', 'Twitter Aplikasi', 'required|trim');
        $this->form_validation->set_rules('github_app', 'Github Aplikasi', 'required|trim');
        $this->form_validation->set_rules('linkedin_app', 'Linkedin Aplikasi', 'required|trim');
        $this->form_validation->set_rules('youtube_app', 'Youtube Aplikasi', 'required|trim');

        // Jika data validasi salah maka akan menembalikan halaman ke halaman user
        if ($this->form_validation->run() == false) {
            // Mengambil data dari session
            $user_id = $this->session->userdata('user_id');
            $data['user'] = $this->M_app_data->get_data_user_by_id($user_id);

            //Mengambil data portal untuk judul dari Model
            $data['portal_data'] = $this->M_portal->get_data_portal();
            $data['portal'] = $data['portal_data'][0]['portal_nm'];
            $data['app_data'] = $this->M_app_data->get_data_app_data($data['portal_data'][0]['portal_id']);
            // dd($data);
            // Data Judul
            $data['main_title'] = $this->main_title;
            $data['sub_title'] = $this->sub_title;

            // Display
            $this->load->view('templates/header_backend', $data);
            $this->load->view('templates/sidebar_backend', $data);
            $this->load->view('templates/topbar_backend', $data);
            $this->load->view('setting/sistem/app_data/index', $data);
            $this->load->view('templates/footer_backend', $data);
        } else {
            $file_input = $_FILES['logo_app'];
            // dd($file_input);

            $app_data_id = $this->input->post('app_data_id');
            if (empty($file_input['name'])) {
                $params = [
                    'no_tlp_app'=> $this->input->post('no_tlp_app'),
                    'email_app'=> $this->input->post('email_app'), 
                    'no_whatsapp_app'=> $this->input->post('no_whatsapp_app'), 
                    'no_telegram_app'=> $this->input->post('no_telegram_app'), 
                    'instagram_app'=> $this->input->post('instagram_app'),
                    'facebook_app'=> $this->input->post('facebook_app'), 
                    'tiktok_app'=> $this->input->post('tiktok_app'), 
                    'twitter_app'=> $this->input->post('twitter_app'), 
                    'github_app'=> $this->input->post('github_app'), 
                    'linkedin_app'=> $this->input->post('linkedin_app'), 
                    'youtube_app'=> $this->input->post('youtube_app'), 
                    'mdd' => date('Y-m-d H:i:s'),
                    'mdb' => $this->session->userdata('user_id'),
                    'mdb_created' => $this->session->userdata('user_nama')
                ];

                $where = [
                    'app_data_id' => $app_data_id
                ];


                if ($this->db->update('mst_app_data',$params,$where)) {
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Selamat data akun anda berhasil di ubah.</div>');
                    redirect(('setting/sistem/app_data'));
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Maaf akun gagal di ubah, silahkan coba lagi.</div>');
                    redirect(('setting/sistem/app_data'));
                }
            } else {
                // upload file foto profil
                $config['upload_path'] = './assets/img/logo'; // Lokasi penyimpanan file
                $config['allowed_types'] = 'jpg|jpeg|png'; // Jenis file yang diizinkan
                $config['max_size'] = 2048; // Ukuran maksimum file (dalam kilobytes)
                $config['file_name'] = $app_data_id; // Nama file setelah diunggah (bisa disesuaikan)

                // Load library upload file
                $this->load->library('upload', $config);

                if ($this->upload->do_upload('logo_app')) {
                    $old_image = $this->input->post('old_image');
                    $data = $this->upload->data();
                    $file_name =  $data['file_name'];

                    /*  Cek jika gambar adalah default.png maka jangan hapus file gambar di folder aplikasi
                    Sebaliknya jika gambar bukan default.png maka hapus file tersebut dari dalam folder aplikasi */
                    if ($old_image != 'default.png') {
                        // Unlink untuk menghapus gambar
                        unlink(FCPATH . 'assets/img/logo/' . $old_image);
                    }

                    // Data ke database
                    $params = [
                        'no_tlp_app' => $this->input->post('no_tlp_app'),
                        'logo_app' => $file_name,
                        'email_app' => $this->input->post('email_app'),
                        'no_whatsapp_app' => $this->input->post('no_whatsapp_app'),
                        'no_telegram_app' => $this->input->post('no_telegram_app'),
                        'instagram_app' => $this->input->post('instagram_app'),
                        'facebook_app' => $this->input->post('facebook_app'),
                        'tiktok_app' => $this->input->post('tiktok_app'),
                        'twitter_app' => $this->input->post('twitter_app'),
                        'github_app' => $this->input->post('github_app'),
                        'linkedin_app' => $this->input->post('linkedin_app'),
                        'youtube_app' => $this->input->post('youtube_app'), 
                        'mdd' => date('Y-m-d H:i:s'),
                        'mdb' => $this->session->userdata('user_id'),
                        'mdb_created' => $this->session->userdata('user_nama')
                    ];
                    $where = [
                        'app_data_id' => $app_data_id
                    ];

                    if ($this->db->update(
                        'mst_app_data', $params, $where)) {
                        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Selamat data aplikasi anda berhasil di ubah.</div>');
                        redirect(('setting/sistem/app_data'));
                    } else {
                        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Maaf aplikasi gagal di ubah, silahkan coba lagi.</div>');
                        redirect(('setting/sistem/app_data'));
                    }
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Maaf aplikasi gagal di ubah, file foto profil salah dengan error' . $this->upload->display_errors() . 'silahkan coba lagi.</div>');
                    redirect(('setting/sistem/app_data'));
                }
            }
        }
    }
}
