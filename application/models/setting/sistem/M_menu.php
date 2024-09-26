<?php


class M_menu extends CI_Model
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

    // Get data menu induk
    public function get_data_menu_induk()
    {
        $this->db->select('*');
        $this->db->from('mst_menu a');
        $this->db->where('a.menu_level','induk');
        $query = $this->db->get();
        return $query->result_array();
    }

    // Get seluruh data menu
    public function get_data_all_menu()
    {
        $this->db->select('*');
        $this->db->from('mst_menu a');
        $query = $this->db->get();
        return $query->result_array();
    }

    // Get data menu by Id
    public function get_data_menu_by_id($params)
    {
        $this->db->select('*');
        $this->db->from('mst_menu a');
        $this->db->where('a.menu_id',$params);
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
    function delete($table, $params) {
    return $this->db->delete($table, $params);
    }
}
