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
                         <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#tambah_role">
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
                                     <th>Nama Role</th>
                                     <th>Role ID</th>
                                     <th>Nama Group</th>
                                     <th>Deskripsi Role</th>
                                     <th>Halaman Default</th>
                                     <th>Aksi</th>
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
                                     <th>Aksi</th>
                                 </tr>
                             </tfoot>
                             <tbody>
                                 <?php $no = 1;
                                    foreach ($role_data as $rd) : ?>
                                     <tr>
                                         <td align="center"><?= $no++ ?></td>
                                         <td align="left"><?= $rd['role_nama'] ?></td>
                                         <td align="center"><?= $rd['role_id'] ?></td>
                                         <td align="center"><?= $rd['group_nama'] ?></td>
                                         <td align="left"><?= $rd['role_deskripsi'] ?></td>
                                         <td align="center"><?= $rd['default_halaman'] ?></td>

                                         <td align="center">
                                             <a href="" class="d-none d-sm-inline-block btn btn-sm btn-warning shadow-sm" data-toggle="modal" data-target="#edit_role_<?= $rd['role_id'] ?>">
                                                 <i class="fas fa-edit fa-sm text-white-50"></i>
                                             </a>
                                             <a href="<?= base_url('setting/sistem/role/hapus_role/') . $rd['role_id'] ?>" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm" onclick="konfirmasiHapus(event)">
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

     <!-- Modals Add Role-->
     <div class="modal fade bd-example-modal-lg" id="tambah_role" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
         <div class="modal-dialog modal-lg">
             <div class="modal-content">
                 <!-- Modal Header -->
                 <div class="modal-header">
                     <h5 class="modal-title">Tambah Data Role Baru</h5>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                     </button>
                 </div>
                 <!-- Modal Body -->
                 <div class="modal-body">
                     <!-- Form Tambah Data Role -->
                     <form action="<?= base_url('setting/sistem/role/tambah_proses') ?>" method="post">
                         <div class="row">
                             <div class="col">
                                 <label class="col-form-label"><b>Nama Role</b></label>
                                 <input type="text" class="form-control" name="role_nama" placeholder="Nama Role" id="" required>
                                 <small class="text-danger pl-2">Wajib diisi</small>
                             </div>
                         </div>
                         <div class="row">
                             <div class="col">
                                 <label class="col-form-label"><b>Group</b></label>
                                 <select name="group_id" id="" class="form-control select2" required>
                                     <option value="">Pilih Group</option>
                                     <?php foreach ($group_data as $gd) : ?>
                                         <option value="<?= $gd['group_id'] ?>"><?= $gd['group_nama'] ?></option>
                                     <?php endforeach; ?>
                                 </select>
                                 <small class="text-danger pl-2">Wajib diisi</small>
                             </div>
                         </div>
                         <div class="row">
                             <div class="col">
                                 <label class="col-form-label"><b>Halaman Default</b></label>
                                 <input type="text" id="" name="default_halaman" class="form-control" placeholder="Halaman Default Role" required>
                                 <small class="text-danger pl-2">Wajib diisi</small>
                             </div>
                         </div>
                         <div class="row">
                             <div class="col">
                                 <label class="col-form-label"><b>Deskripsi Role</b></label>
                                 <textarea class="form-control" id="exampleFormControlTextarea1" name="role_deskripsi" rows="3" required></textarea>
                                 <small class="text-danger pl-2">Wajib diisi</small>
                             </div>
                         </div>

                         <div class="modal-footer">
                             <button type="submit" class="btn btn-primary">Simpan Data Role</button>
                             <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                         </div>
                     </form>
                 </div>
                 <!-- Modal Footer -->
             </div>
         </div>
     </div>

     <!-- Modals Edit Role-->
     <?php foreach ($role_data as $rd) : ?>
         <div class="modal fade bd-example-modal-lg" id="edit_role_<?= $rd['role_id'] ?>" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
             <div class="modal-dialog modal-lg">
                 <div class="modal-content">
                     <!-- Modal Header -->
                     <div class="modal-header">
                         <h5 class="modal-title">Edit Data Role Baru</h5>
                         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                             <span aria-hidden="true">&times;</span>
                         </button>
                     </div>
                     <!-- Modal Body -->
                     <div class="modal-body">
                         <!-- Form Tambah Data Role -->
                         <form action="<?= base_url('setting/sistem/role/edit_proses') ?>" method="post">
                             <input type="hidden" name="role_id" value="<?= $rd['role_id'] ?>">
                             <div class="row">
                                 <div class="col">
                                     <label class="col-form-label"><b>Nama Role</b></label>
                                     <input type="text" class="form-control" name="role_nama" value="<?= $rd['role_nama'] ?>" placeholder="Nama Role" id="" required>
                                     <small class="text-danger pl-2">Wajib diisi</small>
                                 </div>
                             </div>
                             <div class="row">
                                 <div class="col">
                                     <label class="col-form-label"><b>Group</b></label>
                                     <select name="group_id" id="" class="form-control select2" required>
                                         <option value="">Pilih Group</option>
                                         <?php foreach ($group_data as $gd) : ?>
                                             <option value="<?= $gd['group_id'] ?>" <?php if ($rd['group_id_role'] == $gd['group_id']) : ?>selected<?php endif; ?>><?= $gd['group_nama'] ?></option>
                                         <?php endforeach; ?>
                                     </select>
                                     <small class="text-danger pl-2">Wajib diisi</small>
                                 </div>
                             </div>
                             <div class="row">
                                 <div class="col">
                                     <label class="col-form-label"><b>Halaman Default</b></label>
                                     <input type="text" id="" name="default_halaman" value="<?= $rd['default_halaman'] ?>" class="form-control" placeholder="Halaman Default Role" required>
                                     <small class="text-danger pl-2">Wajib diisi</small>
                                 </div>
                             </div>
                             <div class="row">
                                 <div class="col">
                                     <label class="col-form-label"><b>Deskripsi Role</b></label>
                                     <textarea class="form-control" id="exampleFormControlTextarea1" name="role_deskripsi" rows="3" required><?= $rd['role_deskripsi'] ?></textarea>
                                     <small class="text-danger pl-2">Wajib diisi</small>
                                 </div>
                             </div>

                             <div class="modal-footer">
                                 <button type="submit" class="btn btn-primary">Simpan Data Role</button>
                                 <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                             </div>
                         </form>
                     </div>
                     <!-- Modal Footer -->
                 </div>
             </div>
         </div>
     <?php endforeach; ?>
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