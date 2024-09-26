<?php
   

class M_user extends CI_Model {

    //put your code here
    public function __construct() {
        parent::__construct();
    }

    /* Get All Data User */
    public function get_all_data_user(){
        $this->db->from('mst_user a');
        $this->db->join('mst_role_user b', 'b.user_id = a.user_id', 'left');
        $this->db->join('mst_role c','c.role_id = b.role_id', 'left');
        $this->db->join('mst_group d', 'd.group_id = c.group_id', 'left');
        $this->db->select('a.user_id as user_id, a.mdd as tanggal_akun_dibuat, a.user_alias, a.user_nama, a.user_mail, a.user_img_name, a.user_st');
        $this->db->select('c.role_id, c.role_nama, c.role_deskripsi');
        $this->db->select('d.group_id, d.group_nama, d.group_deskripsi');
        $query = $this->db->get();
        return $query->result_array();
    }

    /* Get Data User By ID */
    public function get_data_user_by_id($params){
        $this->db->select('*');
        $this->db->from('mst_user a');
        $this->db->join('mst_role_user b', 'b.user_id = a.user_id');
        $this->db->where('a.user_id', $params);
        $query = $this->db->get();
        return $query->row_array();
    }

    /* Get Last Id Data User */
    public function get_user_last_id($prefix, $params)
    {
        $sql = "SELECT RIGHT(user_id, 6) AS 'last_number'
                FROM mst_user
                WHERE user_id LIKE ?
                ORDER BY user_id DESC
                LIMIT 1";
        $query = $this->db->query($sql, $params);
        if ($query->num_rows() > 0
        ) {
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

    /* Delete Data User */
    
    function delete($table, $params)
    {
        return $this->db->delete($table, $params);
    }

}
