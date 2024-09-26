<?php


class M_portal extends CI_Model
{

    //put your code here
    public function __construct()
    {
        parent::__construct();
    }


    // row_array = menampilkan dalam bentuk satu array
    // row  = menampilkan dalam bentuk std_class
    // result = menampilkan dalam bentuk array dan std_class
    // result_array = menampilkan dalam bentuk aray multidimensi

    // Get data portal
    public function get_data_portal()
    {
        $this->db->select('*');
        $this->db->from('mst_portal a');
        $query = $this->db->get();
        return $query->result_array();
    }

    // Get Last Id Portal
    public function get_last_id_portal()
    {
        $this->db->select_max('portal_id', 'last_id_portal');
        $this->db->from('mst_portal a');
        $query = $this->db->get();
        return $query->row_array();
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
    function delete($table, $params)
    {
        return $this->db->delete($table, $params);
    }
    
}
