<?php


class M_akses extends CI_Model
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
        $this->db->where('a.menu_id', $params);
        $query = $this->db->get();
        return $query->row_array();
    }

    // Get all data role
    public function get_all_role_data()
    {
        $this->db->select('a.role_id, a.group_id as group_id_role, a.role_nama, a.role_deskripsi, a.default_halaman, b.group_id ,b.group_nama');
        $this->db->from('mst_role a');
        $this->db->join('mst_group b', 'b.group_id = a.group_id');
        $query = $this->db->get();
        return $query->result_array();
    }

    // Get data role by role id
    public function get_data_role_by_id($params)
    {
        $this->db->select('*');
        $this->db->from('mst_role a');
        $this->db->where('a.role_id',$params);
        $query = $this->db->get();
        return $query->row_array();
    }


    // Get data role by role id
    public function cek_data_role_menu($params)
    {
        $query =  $this->db->get_where('mst_role_menu', $params);
        return $query->row_array();
    }


    // Insert data
    public function insert($table, $params)
    {
        return $this->db->insert($table, $params);
    }

    // update data
    function update($table, $params, $where)
    {
        return $this->db->update($table, $params, $where);
    }

    // delete data
    function delete($table, $params)
    {
        return $this->db->delete($table, $params);
    }
}
