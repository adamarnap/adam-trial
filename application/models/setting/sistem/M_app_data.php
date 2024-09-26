<?php


class M_app_data extends CI_Model
{

    //put your code here
    public function __construct()
    {
        parent::__construct();
    }

    public function get_data_app_data($params)
    {
        $this->db->from('mst_app_data a');
        $this->db->join('mst_portal b', 'b.portal_id = a.portal_id');
        $this->db->select('a.app_data_id, a.logo_app, a.no_tlp_app, a.email_app, a.no_whatsapp_app, a.facebook_app, a.no_telegram_app, a.instagram_app, a.tiktok_app, a.twitter_app, a.github_app, a.linkedin_app, a.youtube_app, a.mdd, a.mdb, a.mdb_created');
        $this->db->select('a.portal_id, b.portal_nm, b.site_title');
        $this->db->where('a.portal_id', $params);
        $query = $this->db->get();
        return $query->row_array();
    }

    /* Get Data User By ID */
    public function get_data_user_by_id($params)
    {
        $this->db->select('*');
        $this->db->from('mst_user a');
        $this->db->join('mst_role_user b', 'b.user_id = a.user_id');
        $this->db->where('a.user_id', $params);
        $query = $this->db->get();
        return $query->row_array();
    }


    /* Get All Data User */
    public function get_all_data_user()
    {
        $this->db->from('mst_user a');
        $this->db->join('mst_role_user b', 'b.user_id = a.user_id', 'left');
        $this->db->join('mst_role c', 'c.role_id = b.role_id', 'left');
        $this->db->join('mst_group d', 'd.group_id = c.group_id', 'left');
        $this->db->select('a.user_id as user_id, a.mdd as tanggal_akun_dibuat, a.user_alias, a.user_nama, a.user_mail, a.user_img_name, a.user_st');
        $this->db->select('c.role_id, c.role_nama, c.role_deskripsi');
        $this->db->select('d.group_id, d.group_nama, d.group_deskripsi');
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
    function delete($table, $params)
    {
        return $this->db->delete($table, $params);
    }
}
