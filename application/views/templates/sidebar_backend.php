<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion " id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            <!-- logo website -->
            <!-- <i class="fas fa-laugh-wink"></i> -->
        </div>
        <div class="sidebar-brand-text mx-3"><?= $portal; ?></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Menu Tunggal -->
    <?php
    $role_id = $this->session->userdata('role_id');
    $queryMenuTunggal = "SELECT a.menu_id, a.menu_induk , a.menu_icon,
                    a.menu_judul, a.menu_deskripsi, 
                    a.menu_url, a.menu_urut, b.role_id, b.role_menu_akses 
                    FROM mst_menu a
                JOIN mst_role_menu b ON a.menu_id = b.menu_id 
                WHERE b.role_id = $role_id AND a.menu_level = 'tunggal' AND b.role_menu_akses = '1'
                ORDER BY a.menu_urut asc
        ";
    $menuTunggal = $this->db->query($queryMenuTunggal)->result_array();
    ?>

    <?php foreach ($menuTunggal as $mt) : ?>
        <li class="nav-item <?php if ($main_title == $mt['menu_judul']) : ?>active<?php endif; ?>">
            <a class="nav-link" href="<?= base_url($mt['menu_url']) ?>">
                <i class="<?= $mt['menu_icon'] ?>"></i>
                <span><?= $mt['menu_judul'] ?></span></a>
        </li>
    <?php endforeach; ?>


    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading
    <div class="sidebar-heading">
        Interface
    </div> -->

    <!-- Menu Induk -->
    <?php
    $role_id = $this->session->userdata('role_id');
    $queryMenu = "SELECT a.menu_id, a.menu_induk , a.menu_icon,
                    a.menu_judul, a.menu_deskripsi, 
                    a.menu_url, a.menu_urut, b.role_id, b.role_menu_akses 
                    FROM mst_menu a
                JOIN mst_role_menu b ON a.menu_id = b.menu_id 
                WHERE b.role_id = $role_id AND a.menu_level = 'induk' AND b.role_menu_akses = '1'
                ORDER BY a.menu_urut asc
        ";
    $menu = $this->db->query($queryMenu)->result_array();
    ?>

    <!-- Menu -->
    <?php foreach ($menu as $m) : ?>
        <!-- Nav Item - Pages Collapse Menu [DROPDOWN MENU]-->
        <li class="nav-item <?php if ($main_title == $m['menu_judul']) : ?>active<?php endif; ?>">
            <a class="nav-link <?php if ($main_title !== $m['menu_judul']) : ?>collapsed<?php endif; ?>" href="<?= base_url($m['menu_url']) ?>" data-toggle="collapse" data-target="#collapse_<?= $m['menu_id'] ?>" aria-expanded="true" aria-controls="collapseTwo">
                <i class="<?= $m['menu_icon'] ?>"></i>
                <span><?= $m['menu_judul'] ?></span>
            </a>
            <!-- Sub menu -->
            <?php
            $menu_id = $m['menu_id'];
            $querySubMenu = "SELECT a.menu_id, a.menu_induk , 
                                        a.menu_judul, a.menu_deskripsi,
                                        a.menu_url, a.menu_urut, b.role_id, b.role_menu_akses
                                        FROM mst_menu a
                                    JOIN mst_role_menu b ON a.menu_id = b.menu_id 
                                    WHERE b.role_id = $role_id AND a.menu_induk = $menu_id  AND b.role_menu_akses = '1'
                                    ORDER BY a.menu_urut asc
                                    ";
            $sub_menu = $this->db->query($querySubMenu)->result_array();
            ?>

            <!-- Data Sub Menu -->
            <div id="collapse_<?= $m['menu_id'] ?>" class="collapse <?php if($main_title == $m['menu_judul']) : ?>show<?php endif; ?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <?php foreach ($sub_menu as $sm) : ?>
                        <!-- <h6 class="collapse-header"></h6> -->
                        <a class="collapse-item <?php if($sub_title == $sm['menu_judul']): ?>active<?php endif; ?>" href="<?= base_url($sm['menu_url']) ?>"><?= $sm['menu_judul'] ?></a>
                    <?php endforeach; ?>
                </div>
            </div>
        </li>
    <?php endforeach; ?>
    <!-- Divider -->
    <hr class="sidebar-divider">




    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->