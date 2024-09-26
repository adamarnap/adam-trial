<?php
   

class M_admin extends CI_Model {

    //put your code here
    public function __construct() {
        parent::__construct();
    }

    public function get_data_user($params){
        $this->db->select('*');
        $this->db->from('mst_user a');
        $this->db->join('mst_role_user b', 'b.user_id = a.user_id');
        $this->db->where('a.user_id', $params);
        $query = $this->db->get();
        return $query->row_array();
    }

}
