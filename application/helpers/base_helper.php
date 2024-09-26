<?php
date_default_timezone_set('Asia/Jakarta');
// Untuk mengecek akses user ke setiap controller
function cek_akses_halaman()
{
  // Menggantikan fungsi $this karena di helper tidak dapat menggunakan fungsi $htis
  $ci = get_instance();

  // Jika data session kosong maka akan kembali ke menu login  
  if (!$ci->session->userdata('user_nama')) 
  {
    redirect('auth');
  }
  // Jika data session tersedia maka akan mengecek role
  else 
  {
    $role_id = $ci->session->userdata('role_id');

    $segments = $ci->uri->segment_array();
    $uri = implode('/', array_slice($segments, 0, 3));

    /* Karena controller dashboard akan meredirect ke admin atau user dan di database,
    tidak ada data admin atau user maka dibuat kondisi seperti dibawah ini */
    if ($uri == 'admin' || $uri == 'user') {
      $uri = 'dashboard';
    }
    /* 
    query --> SELECT *, SUBSTRING_INDEX(menu_url, '/', 1) AS menu_url_segment
              FROM mst_menu
              HAVING menu_url_segment = 'setting';
 */

    // $ci->db->select('*');
    // $ci->db->select("SUBSTRING_INDEX(menu_url, '/', 1) AS menu_url_segment");
    // $ci->db->from('mst_menu');
    // $ci->db->having('menu_url_segment', 'setting');
    // $query_menu = $ci->db->get()->result_array();
    // dd($query_menu);
    $queryMenu = $ci->db->get_where('mst_menu', ['menu_url' => $uri])->row_array();
    $queryMenu = $ci->db->get_where('mst_menu', ['menu_url' => $uri])->row_array();
    $menu_id = $queryMenu['menu_id'];
    $user_access = $ci->db->get_where('mst_role_menu', ['role_id' => $role_id, 'menu_id' => $menu_id]);

    if ($user_access->num_rows() < 1 ) {
      redirect("auth/blocked_page");
    }
  }
}

// Untuk mengecek menu yang sudah memiliki akses pada setiap role di menu hak akses > manajemen akses
function cek_akses($role_id, $menu_id)
{
  // Menggantikan fungsi $this karena di helper tidak dapat menggunakan fungsi $htis
  $ci = get_instance();

  $ci->db->where('role_id', $role_id);
  $ci->db->where('menu_id', $menu_id);
  $result = $ci->db->get('mst_role_menu');

  if ($result->num_rows() > 0) {
    return "checked='checked'";
  }
}
