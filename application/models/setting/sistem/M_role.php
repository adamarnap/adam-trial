<?php


class M_role extends CI_Model
{

    //put your code here
    public function __construct()
    {
        parent::__construct();
    }

    public function get_all_role_data()
    {
        $this->db->select('a.role_id, a.group_id as group_id_role, a.role_nama, a.role_deskripsi, a.default_halaman, b.group_id ,b.group_nama');
        $this->db->from('mst_role a');
        $this->db->join('mst_group b', 'b.group_id = a.group_id');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_all_group_data()
    {
        $this->db->select('*');
        $this->db->from('mst_group a');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_last_id_role()
    {
        $this->db->select_max('role_id','last_id_role');
        $this->db->from('mst_role a');
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
