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
                         <h2 class="h3 mb-0 text-gray-800">Daftar Data Role</h2>
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
                                     <th>Nama Role</th>
                                     <th>Role ID</th>
                                     <th>Nama Group</th>
                                     <th>Deskripsi Role</th>
                                     <th>Halaman Default</th>
                                     <th>Akses</th>
                                 </tr>
                             </thead>
                             <tfoot>
                                 <tr>
                                     <th>#</th>
                                     <th>Nama Role</th>
                                     <th>Role ID</th>
                                     <th>Nama Group</th>
                                     <th>Deskripsi Role</th>
                                     <th>Halaman Default</th>
                                     <th>Akses</th>
                                 </tr>
                             </tfoot>
                             <tbody>
                                 <?php foreach ($role_data as $rd) : ?>
                                     <tr>
                                        <td><?= $no++ ?></td>
                                         <td align="left"><?= $rd['role_nama'] ?></td>
                                         <td align="center"><?= $rd['role_id'] ?></td>
                                         <td align="center"><?= $rd['group_nama'] ?></td>
                                         <td align="left"><?= $rd['role_deskripsi'] ?></td>
                                         <td align="center"><?= $rd['default_halaman'] ?></td>

                                         <td align="center">
                                             <a href="<?= base_url('setting/sistem/akses/akses_manajemen/') . $rd['role_id'] ?>" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm">
                                                 <i class="fas fa-user-shield fa-sm text-white-100" style="color: #ebebeb;">&nbsp; Akses Manajemen</i>
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

 </div>


 <script src="<?= base_url('assets/'); ?>vendor/jquery/jquery.min.js"></script>
 <script type="text/javascript">
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