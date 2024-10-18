<?php

class M_manajemen extends CI_Model {

    //put your code here
    public function __construct() {
        parent::__construct();
    }

    /* Get all data akun */
    public function get_data_all_akun(){
        $sql = "
            SELECT a.*, c.nama_kategori, d.nama_mail, e.nama_phone, e.phone, b.id_token, b.token, b.mdd as mdd_token
            FROM akun a
            LEFT JOIN (
                SELECT id_token, token, mdd
                FROM token t1
                WHERE mdd = (
                    SELECT MAX(t2.mdd) 
                    FROM token t2 
                    WHERE t2.id_token = t1.id_token
                )
            ) b ON a.id_akun = b.id_token
            LEFT JOIN kategori c ON a.id_kategori = c.id_kategori
            LEFT JOIN mail d ON a.id_mail = d.id_mail
            LEFT JOIN phone e ON a.id_phone = e.id_phone
            WHERE d.id_mail <> 10002
            ORDER BY a.id_akun DESC
        ";

        $result = $this->db->query($sql)->result_array();
        $result = $this->decrypt_password($result);
        return $result;
    }

    /* Get data akun by id */
    public function get_data_akun_by_id($id){
        $this->db->select('*');
        $this->db->from('akun a');
        $this->db->where('a.id_akun', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    /* Get Token */
    public function get_token($token){
        $this->db->select('password');
        $this->db->from('mail a');
        $this->db->where('a.id_mail', $token);
        $query = $this->db->get();
        return $query->row_array()['password'];
    }

    /* Get password log update */
    public function get_password_log($id_token){
        $this->db->select('id_old_token, token, mdd as mdd_token');
        $this->db->from('token a');
        $this->db->where('a.id_token', $id_token);
        $this->db->or_where('a.id_old_token', $id_token);
        $this->db->order_by('a.mdd', 'asc');
        $query = $this->db->get();
        return $query->result_array();
    }

    /* Dekripsi password */
    function decrypt_password($result) {
        // Set Limit
        ini_set('memory_limit', '256M');
        // Get Token
        $captcha = $this->session->userdata('captcha');
        if (strpos($captcha, '-') !== false) {
            $captcha = explode('-', $captcha)[1];
        } else {
            $captcha = $captcha;
        }
        $token = $this->get_token('10002');
        $token_decode = base64_decode($token);
        $layers = explode('-', $token_decode)[2];
        if($captcha != $layers){
            $captcha = 1;
        }
        $token = $this->get_token('10002');
        $encryption_key = base64_decode($token);
        // Dekripsi password
        foreach($result as $key => $row){
            $log_password = $this->get_password_log($row['id_token']);
            foreach($log_password as $index => $log){
                $encrypted_password = $log['token'];
                for ($i = 0; $i < $captcha; $i++) {
                    // Pisahkan encrypted data dan IV
                    list($encrypted_data, $iv) = explode('::', base64_decode($encrypted_password), 2);
                    // Dekripsi menggunakan IV yang sesuai
                    $encrypted_password = openssl_decrypt($encrypted_data, 'aes-256-cbc', $encryption_key, 0, $iv);
                }
                $result[$key]['psw'][$index] = [
                    'password' => $encrypted_password,
                    'old' => $log['id_old_token'] ? 'T' : 'F',
                    'mdd_token' => $log['mdd_token']
                ];
            }
        }
        return $result;
    }

    // Insert data menu
    public function insert($table, $params)
    {
        return $this->db->insert($table, $params);
    }

    // update data menu
    function update($table, $params, $where)
    {
        return $this->db->update($table, $params, $where);
    }

    // delete data menu
    function delete($table, $params) {
    return $this->db->delete($table, $params);
    }

}
