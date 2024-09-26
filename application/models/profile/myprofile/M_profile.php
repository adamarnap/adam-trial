<?php


class M_profile extends CI_Model
{

    //put your code here
    public function __construct()
    {
        parent::__construct();
    }

    /* Get Data User By Id */
    public function get_data_user_by_id($params)
    {
        $this->db->from('mst_user a');
        $this->db->join('mst_role_user b', 'b.user_id = a.user_id', 'left');
        $this->db->join('mst_role c', 'c.role_id = b.role_id', 'left');
        $this->db->join('mst_group d', 'd.group_id = c.group_id', 'left');
        $this->db->select('a.user_id as user_id, a.mdd as tanggal_akun_dibuat, a.user_alias, a.user_nama, a.user_mail, a.user_img_name, a.user_st, a.tgl_lahir, a.tempat_lahir, a.alamat, a.no_tlp, a.no_whatsapp, a.no_telegram, a.instagram, a.facebook, a.twitter');
        $this->db->select('c.role_id, c.role_nama, c.role_deskripsi');
        $this->db->select('d.group_id, d.group_nama, d.group_deskripsi');
        $this->db->where('a.user_id', $params);
        $query = $this->db->get();
        return $query->row_array();
    }

    /* Get data password user saat ini */
    public function get_password_now($params){
        $this->db->from('mst_user a');
        $this->db->select('a.user_pass');
        $this->db->where('a.user_id', $params);
        $query = $this->db->get();
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
