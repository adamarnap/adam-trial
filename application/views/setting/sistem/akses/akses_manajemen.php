 <!-- Content Wrapper -->
 <div id="content-wrapper" class="d-flex flex-column">
     <!-- Main Content -->
     <div id="content">
         <!-- Begin Page Content -->
         <div class="container-fluid">

             <!-- Page Heading -->
             <h1 class="h3 mb-2 text-gray-800">Data <?= $sub_title ?></h1>

             <!-- DataTales Example -->
             <div class="card shadow mb-4">
                 <div class="card-header py-3">
                     <div class="d-sm-flex align-items-center justify-content-between mb-4">
                         <h3 class="h4 mb-0 text-gray-800">Daftar Data <?= $sub_title ?> | <?= $role_by_id['role_nama'] ?></h3>
                     </div>
                     <!-- Notifikasi form validasi -->
                     <?= $this->session->flashdata('message') ?>
                     <!-- Notifikasi form validasi -->
                 </div>
                 <div class="card-body">

                     <div class="table-responsive">
                         <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                             <thead>
                                 <tr>
                                     <th>#</th>
                                     <th>Level Menu</th>
                                     <th>ID Menu</th>
                                     <th>Nama Menu</th>
                                     <th>Menu Induk</th>
                                     <th>Menu Deskripsi</th>
                                     <th>Alamat Menu</th>
                                     <th>Akses</th>
                                 </tr>
                             </thead>
                             <tfoot>
                                 <tr>
                                     <th>#</th>
                                     <th>Level Menu</th>
                                     <th>ID Menu</th>
                                     <th>Nama Menu</th>
                                     <th>Menu Induk</th>
                                     <th>Menu Deskripsi</th>
                                     <th>Alamat Menu</th>
                                     <th>Akses</th>
                                 </tr>
                             </tfoot>
                             <tbody>
                                 <?php foreach ($menu_data as $sm) : ?>
                                     <tr>
                                         <td><?= $no++ ?></td>
                                         <td align="center">
                                             <?php if ($sm['menu_level'] == 'tunggal') : ?>
                                                 <span class="badge badge-pill badge-secondary">Menu Tunggal</span>
                                             <?php elseif ($sm['menu_level'] == 'induk') : ?>
                                                 <span class="badge badge-pill badge-primary">Induk Menu</span>
                                             <?php elseif ($sm['menu_level'] == 'submenu') : ?>
                                                 <span class="badge badge-pill badge-success">Sub Menu</span>
                                             <?php endif; ?>
                                         </td>
                                         <td align="center">
                                             <?= $sm['menu_id'] ?>
                                         </td>
                                         <td align="left">
                                             <?php if (($sm['menu_level'] == 'induk') || ($sm['menu_level'] == 'tunggal')) : ?>
                                                 <i class="<?= $sm['menu_icon'] ?>"></i> &nbsp;
                                             <?php else : ?>
                                                 --
                                             <?php endif; ?>
                                             <?= $sm['menu_judul'] ?>
                                         </td>

                                         <?php $menu_id = $menu_by_id->get_data_menu_by_id($sm['menu_induk']);  ?>
                                         <td align="center">
                                             <?php if (empty($menu_id['menu_judul'])) : ?>
                                                 -
                                             <?php else : ?>
                                                 <b style="color: crimson;"><?= $menu_id['menu_judul'] ?></b>
                                             <?php endif; ?>
                                         </td>

                                         <td align="left"><?= $sm['menu_deskripsi'] ?></td>
                                         <td align="center"><?= $sm['menu_url'] ?></td>

                                         <td align="center">
                                             <div class="custom-control custom-switch">
                                                 <input type="checkbox" <?= cek_akses($role_by_id['role_id'], $sm['menu_id']); ?> data-role="<?= $role_by_id['role_id']; ?>" data-menu="<?= $sm['menu_id']; ?>" class="custom-control-input checkbox-hak-akses" id="customSwitch_<?= $no - 1 ?>">
                                                 <label class="custom-control-label" for="customSwitch_<?= $no - 1 ?>"></label>
                                             </div>
                                         </td>
                                     </tr>
                                 <?php endforeach; ?>
                             </tbody>
                         </table>
                     </div>
                 </div>
             </div>
         </div>
         <!-- /.container-fluid -->
     </div>
 </div>

 <script src="<?= base_url('assets/'); ?>vendor/jquery/jquery.min.js"></script>
 <script>
     // Hak akses checkbox
     $('.checkbox-hak-akses').on('click', function() {
         // Mengambil data dari form input dengan atribut data-role dan data-menu
         const menuId = $(this).data('menu');
         const roleId = $(this).data('role');
         console.log(menuId, roleId)

         // Ajax untuk mengirim data guna untuk insert dan delete hak akses
         $.ajax({
             url: "<?= base_url('setting/sistem/akses/ajax_change_hak_akses'); ?>",
             type: 'post',
             data: {
                 menu_id: menuId,
                 role_id: roleId
             },
             success: function() {
                 document.location.href = "<?= base_url('setting/sistem/akses/akses_manajemen/') ?>" + roleId;
             }
         });

     });
 </script>