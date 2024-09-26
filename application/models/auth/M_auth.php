<?php
   

class M_auth extends CI_Model {

    //put your code here
    public function __construct() {
        parent::__construct();
    }

    /* Get data id terakhir untuk ditambahkan nilai 1 sebagai id baru dari tabel mst_user */
   public function get_user_last_id($prefix, $params) {
        $sql = "SELECT RIGHT(user_id, 6) AS 'last_number'
                FROM mst_user
                WHERE user_id LIKE ?
                ORDER BY user_id DESC
                LIMIT 1";
        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0) {
            $result = $query->row_array();
            $query->free_result();
            // create next number
            $number = intval($result['last_number']) + 1;
            if ($number > 999999) {
                return false;
            }
            $zero = '';
            for ($i = strlen($number); $i < 6; $i++) {
                $zero .= '0';
            }
            return $prefix . $zero . $number;
        } else {
            // create new number
            return $prefix . '000001';
        }
    }

    /* Get data user by user_nama dari proses auth */
    public function get_user_nama_by_input($params) {
        $this->db->select('*');
        $this->db->from('mst_user a');
        $this->db->join('mst_role_user b', 'b.user_id = a.user_id');
        $this->db->where('a.user_nama', $params);
        $query = $this->db->get();
        return $query->row_array();
    }   

    /* Get data user by user_mail */
    public function get_user_by_user_mail($params) {
        $this->db->select('*');
        $this->db->from('mst_user a');
        $this->db->where('a.user_mail', $params);
        $query = $this->db->get();
        return $query->row_array();
    }   

    /* Get data yang sudah melakukan aktifasi akun user by user_mail */
    public function get_user_is_activated_by_user_mail($params) {
        $this->db->select('*');
        $this->db->from('mst_user a');
        $this->db->where('a.user_mail', $params);
        $this->db->where('a.user_st', '1');
        $query = $this->db->get();
        return $query->row_array();
    }   

    /* Get data verifikasi by token */
    public function get_user_token_by_token($params) {
        $this->db->select('*');
        $this->db->from('mst_token_verification a');
        $this->db->where('a.token', $params);
        $query = $this->db->get();
        return $query->row_array();
    }   

    /* Get data email pribadi website yang digunakan sebagai pengirim SMTP EMAIL CODE IGNITER */
    public function get_data_email() {
        $this->db->select('*');
        $this->db->from('mst_email a');
        $this->db->where('a.use_smtp', '1');
        $this->db->where('a.use_authorization', '1');
        $query = $this->db->get();
        return $query->row_array();
    }   
    
    /* Get data portal */
    public function get_data_portal() {
        $this->db->select('*');
        $this->db->from('mst_portal a');
        $query = $this->db->get();
        return $query->row_array();
    }

    /* Insert data */
    public function insert($table, $params)
    {
        return $this->db->insert($table, $params);
    }

    /* update data */
    function update($table, $params, $where)
    {
        return $this->db->update($table, $params, $where);
    }

    /* delete data */
    function delete($table, $params)
    {
        return $this->db->delete($table, $params);
    }
    

}

?>