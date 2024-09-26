<?php
defined('BASEPATH') or exit('No direct script access allowed');

class dashboard extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        cek_akses_halaman();
    }


    public function index()
    {
        // Mengambil data role_id dari session lalu role_id di cek dan akan dibawakan ke controller sesuai role_id yang ada di session
        $role_id = $this->session->userdata('role_id');
        // dd($role_id);

        // Proses pengecekan role id
        if ($role_id == 01) {
            redirect(('admin'));
        } elseif ($role_id == 02) {
            redirect(('user'));
        } elseif ($role_id == 03) {
            redirect(('siswa'));
        }

        
    }
}
