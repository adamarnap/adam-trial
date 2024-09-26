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
                         <h2 class="h3 mb-0 text-gray-800">Daftar Data <?= $sub_title ?></h2>
                         <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#tambah_menu">
                             <i class="fas fa-plus fa-sm text-white-50"></i> Tambah <?= $sub_title ?> Baru
                         </a>
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
                                     <th>Nama Menu</th>
                                     <th>Menu Induk</th>
                                     <th>Deskripsi</th>
                                     <th>Urut</th>
                                     <th>Alamat Menu</th>
                                     <th>Aktif</th>
                                     <th>Tampil</th>
                                     <th>Aksi</th>
                                 </tr>
                             </thead>
                             <tfoot>
                                 <tr>
                                     <th>#</th>
                                     <th>Level Menu</th>
                                     <th>Nama Menu</th>
                                     <th>Menu Induk</th>
                                     <th>Deskripsi</th>
                                     <th>Urut</th>
                                     <th>Alamat Menu</th>
                                     <th>Aktif</th>
                                     <th>Tampil</th>
                                     <th>Aksi</th>
                                 </tr>
                             </tfoot>
                             <tbody>
                                 <?php $no =  1; ?>
                                 <?php foreach ($semua_menu as $sm) : ?>
                                     <tr>
                                         <td align="center"><?= $no++ ?></td>
                                         <td align="center">
                                             <?php if ($sm['menu_level'] == 'tunggal') : ?>
                                                 <span class="badge badge-pill badge-secondary">Menu Tunggal</span>
                                             <?php elseif ($sm['menu_level'] == 'induk') : ?>
                                                 <span class="badge badge-pill badge-primary">Induk Menu</span>
                                             <?php elseif ($sm['menu_level'] == 'submenu') : ?>
                                                 <span class="badge badge-pill badge-success">Sub Menu</span>
                                             <?php endif; ?>
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
                                         <td><?= $sm['menu_deskripsi'] ?></td>
                                         <td align="center"><?= $sm['menu_urut'] ?></td>
                                         <td><?= $sm['menu_url'] ?></td>
                                         <td align="center">
                                             <?php if ($sm['status_aktif'] == '1') : ?>
                                                 <span class="badge badge-pill badge-primary">Aktif</span>
                                             <?php elseif ($sm['status_aktif'] == '0') : ?>
                                                 <span class="badge badge-pill badge-danger">Nonaktif</span>
                                             <?php endif; ?>
                                         </td>
                                         <td align="center">
                                             <?php if ($sm['status_tampil'] == '1') : ?>
                                                 <span class="badge badge-pill badge-primary">Tampil</span>
                                             <?php elseif ($sm['status_tampil'] == '0') : ?>
                                                 <span class="badge badge-pill badge-danger">Disembunyikan</span>
                                             <?php endif; ?>
                                         </td>
                                         <td align="center">
                                             <a href="<?= base_url('setting/sistem/menu/edit/') . $sm['menu_id'] ?>" class="d-none d-sm-inline-block btn btn-sm btn-warning shadow-sm">
                                                 <i class="fas fa-edit fa-sm text-white-50"></i>
                                             </a>
                                             <a href="<?= base_url('setting/sistem/menu/hapus_menu/') . $sm['menu_id'] ?>" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm" onclick="konfirmasiHapus(event)">
                                                 <i class="fas fa-trash fa-sm text-white-50"></i>
                                             </a>
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

     <!-- Modals Add Menu-->
     <div class="modal fade bd-example-modal-lg" id="tambah_menu" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
         <div class="modal-dialog modal-lg">
             <div class="modal-content">
                 <!-- Modal Header -->
                 <div class="modal-header">
                     <h5 class="modal-title">Tambah Data Menu Baru</h5>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                     </button>
                 </div>
                 <!-- Modal Body -->
                 <div class="modal-body">
                     <!-- Form Tambah Data Menu -->
                     <form action="<?= base_url('setting/sistem/menu/tambah_proses') ?>" method="post">
                         <div class="row">
                             <div class="col">
                                 <label class="col-form-label"><b>Nama Menu</b></label>
                                 <input type="text" class="form-control" name="menu_judul" placeholder="Nama Menu" id="" required>
                                 <small class="text-danger pl-2">Wajib diisi</small>
                             </div>
                             <div class="col">
                                 <label class="col-form-label"><b>Alamat URL Menu</b></label>
                                 <input type="text" class="form-control" name="menu_url" placeholder="Alamat URL Menu" id="" required>
                                 <small class="text-danger pl-2">Wajib diisi</small>
                             </div>
                         </div>
                         <div class="row">
                             <div class="col">
                                 <label class="col-form-label"><b>Menu Urut</b></label>
                                 <input type="number" id="" name="menu_urut" class="form-control" placeholder="Nomor Urut Menu" required>
                                 <small class="text-danger pl-2">Wajib diisi</small>
                             </div>
                             <div class="col">
                                 <label class="col-form-label"><b>Portal Website</b></label>
                                 <select name="portal_id" id="" class="form-control select2" required>
                                     <option value="">Pilih Portal Website</option>
                                     <?php foreach ($portal_data as $p) : ?>
                                         <option value="<?= $p['portal_id'] ?>"><?= $p['portal_nm'] ?></option>
                                     <?php endforeach; ?>
                                 </select>
                                 <small class="text-danger pl-2">Wajib diisi</small>
                             </div>
                         </div>
                         <div class="row">
                             <div class="col">
                                 <label class="col-form-label"><b>Level Menu</b></label>
                                 <select name="menu_level" id="" class="form-control select2" onchange="set_menu_level(this);" required>
                                     <option value="">Pilih Level Menu</option>
                                     <option value="tunggal">Menu Tunggal</option>
                                     <option value="induk">Menu Induk</option>
                                     <option value="submenu">Sub Menu</option>
                                 </select>
                                 <small class="text-danger pl-2">Wajib diisi</small>
                             </div>
                             <div class="col">
                                 <label class="col-form-label"><b>Status Menu</b></label>
                                 <select name="status_aktif" id="" class="form-control select2" required>
                                     <option value="">Pilih Status Menu</option>
                                     <option value="1">Aktif</option>
                                     <option value="2">Nonaktif</option>
                                 </select>
                                 <small class="text-danger pl-2">Wajib diisi</small>
                             </div>
                         </div>
                         <div class="row">
                             <div class="col" id="menu_induk">
                                 <label class="col-form-label"><b>Menu Induk</b></label>
                                 <select name="menu_induk" id="" class="form-control select2">
                                     <option value="">Pilih Menu Induk</option>
                                     <?php foreach ($menu_induk as $mi) : ?>
                                         <option value="<?= $mi['menu_id'] ?>"><?= $mi['menu_judul'] ?></option>
                                     <?php endforeach; ?>
                                 </select>
                                 <small class="text-danger pl-2">Wajib diisi</small>
                             </div>
                             <div class="col">
                                 <label class="col-form-label"><b>Icon Menu</b></label>
                                 <input type="text" id="" name="menu_icon" class="form-control" placeholder="Icon Menu" required>
                                 <small class="text-danger pl-2">Wajib diisi</small>
                             </div>
                             <div class="col">
                                 <label class="col-form-label"><b>Status Tampil</b></label>
                                 <select name="status_tampil" id="" class="form-control select2" required>
                                     <option value="">Pilih Status Tampil</option>
                                     <option value="1">Tampil</option>
                                     <option value="2">Sembunyikan</option>
                                 </select>
                                 <small class="text-danger pl-2">Wajib diisi</small>
                             </div>
                         </div>
                         <div class="row">
                             <div class="col">
                                 <label class="col-form-label"><b>Deskripsi Menu</b></label>
                                 <textarea class="form-control" id="exampleFormControlTextarea1" name="menu_deskripsi" rows="3" required></textarea>
                                 <small class="text-danger pl-2">Wajib diisi</small>
                             </div>
                         </div>

                         <div class="modal-footer">
                             <button type="submit" class="btn btn-primary">Simpan Data Menu</button>
                             <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                         </div>
                     </form>
                 </div>
                 <!-- Modal Footer -->
             </div>
         </div>
     </div>
 </div>


 <script src="<?= base_url('assets/'); ?>vendor/jquery/jquery.min.js"></script>
 <script type="text/javascript">
     // Selector kondisi menu level
     function set_menu_level(e) {
         switch (e.value) {
             case "tunggal":
                 $('#menu_induk').hide();
                 break;
             case "submenu":
                 $('#menu_induk').show();
                 break;
             case "induk":
                 $('#menu_induk').hide();
                 break;

         }
     }

     // Select 2
     $(document).ready(function() {
         $(".select2").select2({
             theme: 'bootstrap4',
         });
     });

     //  Konfirmasi Hapus
     function konfirmasiHapus(e) {
         e.preventDefault();
         var urlToRedirect = e.currentTarget.getAttribute('href');
         Swal.fire({
             icon: 'question',
             text: 'Apakah data ini ingin dihapus secara permanen ?',
             title: 'Konfirmasi Hapus',
             showDenyButton: false,
             showCancelButton: true,
             confirmButtonColor: '#ef4523',
             confirmButtonText: 'Hapus',
             cancelButtonText: 'Batal',
             denyButtonText: `Don't save`,
         }).then((result) => {
             /* Read more about isConfirmed, isDenied below */
             if (result.isConfirmed) {
                 window.location.href = urlToRedirect;
             }
         })
     }
 </script>