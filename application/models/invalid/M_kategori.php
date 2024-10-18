<?php

class M_kategori extends CI_Model {

    //put your code here
    public function __construct() {
        parent::__construct();
    }

    public function get_data_all_kategori(){
        $this->db->select('*');
        $this->db->from('kategori a');
        $query = $this->db->get();
        return $query->result_array();
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
