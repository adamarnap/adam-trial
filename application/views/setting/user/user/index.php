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
                         <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#tambah_user">
                             <i class="fas fa-plus fa-sm text-white-50"></i> Tambah <?= $sub_title ?> Baru
                         </a>
                     </div>
                     <!-- Notifikasi form validasi -->
                     <?= $this->session->flashdata('message') ?>
                     <!-- Notifikasi form validasi -->
                 </div>
                 <div class="card-body">

                     <div class="table-responsive">
                         <table class="table table-bouered" id="dataTable" width="100%" cellspacing="0">
                             <thead>
                                 <tr>
                                     <th>#</th>
                                     <th>Nama Alias</th>
                                     <th>Username</th>
                                     <th>User mail</th>
                                     <th>User Group</th>
                                     <th>User Role</th>
                                     <th>Status User</th>
                                     <th>Aksi</th>
                                 </tr>
                             </thead>
                             <tfoot>
                                 <tr>
                                     <th>#</th>
                                     <th>Nama Alias</th>
                                     <th>Username</th>
                                     <th>User mail</th>
                                     <th>User Group</th>
                                     <th>User Role</th>
                                     <th>Status User</th>
                                     <th>Aksi</th>
                                 </tr>
                             </tfoot>
                             <tbody>
                                 <?php $no = 1;
                                    foreach ($all_users as $u) : ?>
                                     <tr>
                                         <td class="text-center"><?= $no++ ?></td>
                                         <td class="text-left"><?= $u['user_alias'] ? $u['user_alias'] : '-' ?></td>
                                         <td class="text-left"><?= $u['user_nama'] ? $u['user_nama'] : '-' ?></td>
                                         <td class="text-left"><?= $u['user_mail'] ? $u['user_mail'] : '-' ?></td>
                                         <td class="text-left"><?= $u['group_nama'] ? $u['group_nama'] : '-' ?></td>
                                         <td class="text-left"><?= $u['role_nama'] ? $u['role_nama'] : '-' ?></td>
                                         <td class="text-center">
                                             <?php if ($u['user_st'] == 1) : ?>
                                                 <span class="badge badge-pill badge-success">Aktif</span>
                                             <?php elseif ($u['user_st'] == 0) : ?>
                                                 <span class="badge badge-pill badge-secondary">Nonaktif</span>
                                             <?php else : ?>
                                                 <span class="badge badge-pill badge-danger">Data Error</span>
                                             <?php endif; ?>
                                         </td>

                                         <td class="text-center d-flex align-items-center">
                                             <a href="" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm mr-1" data-toggle="modal" data-target="#view_user_<?= $u['user_id'] ?>">
                                                 <i class="fas fa-eye fa-xs text-white-50"></i>
                                             </a>
                                             <a href="" class="d-none d-sm-inline-block btn btn-sm btn-warning shadow-sm mr-1" data-toggle="modal" data-target="#edit_user_<?= $u['user_id'] ?>">
                                                 <i class="fas fa-edit fa-xs text-white-50"></i>
                                             </a>
                                             <a href="<?= base_url('setting/user/user/hapus_user/') . $u['user_id'] ?>" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm" onclick="konfirmasiHapus(event)">
                                                 <i class="fas fa-trash fa-xs text-white-50"></i>
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
     <div class="modal fade bd-example-modal-lg" id="tambah_user" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
         <div class="modal-dialog modal-lg">
             <div class="modal-content">
                 <!-- Modal Header -->
                 <div class="modal-header">
                     <h5 class="modal-title">Tambah Data User Baru</h5>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                     </button>
                 </div>
                 <!-- Modal Body -->
                 <div class="modal-body">
                     <!-- Form Tambah Data Role -->
                     <form action="<?= base_url('setting/user/user/tambah_proses') ?>" method="post" enctype="multipart/form-data">
                         <div class="row">
                             <div class="col">
                                 <label class="col-form-label"><b>Nama Pengguna</b></label>
                                 <input type="text" class="form-control" name="user_alias" value="<?= set_value('user_alias') ?>" placeholder="Nama Penguna" id="" required>
                                 <?= form_error('user_alias', '<small class="text-danger pl-3">', '</small>') ?>
                                 <small class="text-danger pl-2">Wajib diisi</small>
                             </div>
                         </div>
                         <div class="row">
                             <div class="col">
                                 <label class="col-form-label"><b>Username</b></label>
                                 <input type="text" class="form-control" name="user_nama" value="<?= set_value('user_nama') ?>" placeholder="Username" id="" required>
                                 <?= form_error('user_nama', '<small class="text-danger pl-3">', '</small>') ?>
                                 <small class="text-danger pl-2">Wajib diisi</small>
                             </div>
                             <div class="col">
                                 <label class="col-form-label"><b>User Mail</b></label>
                                 <input type="email" class="form-control" name="user_mail" value="<?= set_value('user_mail') ?>" placeholder="Email Pengguna" id="" required>
                                 <?= form_error('user_mail', '<small class="text-danger pl-3">', '</small>') ?>
                                 <small class="text-danger pl-2">Wajib diisi</small>
                             </div>
                         </div>
                         <div class="row">
                             <div class="col">
                                 <label class="col-form-label"><b>Password</b></label>
                                 <input type="password" class="form-control" name="user_pass" placeholder="Password Akun" id="" required>
                                 <?= form_error('user_pass', '<small class="text-danger pl-3">', '</small>') ?>
                                 <small class="text-danger pl-2">Wajib diisi</small>
                             </div>
                             <div class="col">
                                 <label class="col-form-label"><b>Konfirmasi Password</b></label>
                                 <input type="password" class="form-control" name="confirm_pass" placeholder="Konfirmasi Password Akun" id="" required>
                                 <?= form_error('confirm_pass', '<small class="text-danger pl-3">', '</small>') ?>
                                 <small class="text-danger pl-2">Wajib diisi</small>
                             </div>
                         </div>
                         <div class="row">
                             <div class="col">
                                 <label class="col-form-label"><b>User Role</b></label>
                                 <select name="role_id" id="" class="form-control select2" required>
                                     <option value="">- Pilih Role -</option>
                                     <?php foreach ($all_role as $ar) : ?>
                                         <option value="<?= $ar['role_id'] ?>"><?= $ar['role_nama'] ?></option>
                                     <?php endforeach; ?>
                                 </select>
                                 <small class="text-danger pl-2">Wajib diisi</small>
                             </div>
                             <div class="col">
                                 <label class="col-form-label"><b>Status User</b></label>
                                 <select name="user_st" id="" class="form-control select2" required>
                                     <option value="">- Pilih Status -</option>
                                     <option value="1">Aktif</option>
                                     <option value="0">Nonaktif</option>
                                 </select>
                                 <small class="text-danger pl-2">Wajib diisi</small>
                             </div>
                         </div>
                         <div class="row">
                             <div class="col">
                                 <label class="col-form-label"><b>Foto Profil User</b></label>
                                 <div class="custom-file">
                                     <input type="file" class="custom-file-input" name="user_img_name" id="customFile" onchange="showAddFileName(event)">
                                     <label class="custom-file-label" for="customFile">Pilih file</label>
                                 </div>
                             </div>
                         </div>
                         <div class="modal-footer">
                             <button type="submit" class="btn btn-primary">Simpan Data User</button>
                             <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                         </div>
                     </form>
                 </div>
                 <!-- Modal Footer -->
             </div>
         </div>
     </div>

     <!-- Modals Edit Pengguna-->
     <?php foreach ($all_users as $u) : ?>
         <div class="modal fade bd-example-modal-lg" id="edit_user_<?= $u['user_id'] ?>" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
             <div class="modal-dialog modal-lg">
                 <div class="modal-content">
                     <!-- Modal Header -->
                     <div class="modal-header">
                         <h5 class="modal-title">Edit Data User</h5>
                         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                             <span aria-hidden="true">&times;</span>
                         </button>
                     </div>
                     <!-- Modal Body -->
                     <div class="modal-body">
                         <!-- Form Edit Data Pengguna -->
                         <form action="<?= base_url('setting/user/user/edit_proses') ?>" method="post" enctype="multipart/form-data">
                             <input type="hidden" name="user_id" value="<?= $u['user_id'] ?>">
                             <input type="hidden" name="role_id_key" value="<?= $u['role_id'] ?>">
                             <input type="hidden" name="old_image" value="<?= $u['user_img_name'] ?>">
                             <div class="row">
                                 <div class="col">
                                     <label class="col-form-label"><b>Nama Alias</b></label>
                                     <input type="text" class="form-control" name="user_alias" value="<?= $u['user_alias'] ?>" placeholder="Nama Pengguna" id="" required>
                                     <?= form_error('user_alias', '<small class="text-danger pl-3">', '</small>') ?>
                                     <small class="text-danger pl-2">Wajib diisi</small>
                                 </div>
                             </div>
                             <div class="row">
                                 <div class="col">
                                     <label class="col-form-label"><b>Username</b></label>
                                     <input type="text" class="form-control" name="user_nama" value="<?= $u['user_nama'] ?>" placeholder="Username" id="" disabled required>
                                     <small class="text-danger pl-2">Wajib diisi</small>
                                 </div>
                                 <div class="col">
                                     <label class="col-form-label"><b>User Mail</b></label>
                                     <input type="email" class="form-control" name="user_mail" value="<?= $u['user_mail'] ?>" placeholder="Email Pengguna" disabled id="" required>
                                     <small class="text-danger pl-2">Wajib diisi</small>
                                 </div>
                             </div>
                             <div class="row">
                                 <div class="col">
                                     <label class="col-form-label"><b>Password</b></label>
                                     <input type="password" class="form-control" name="user_pass" placeholder="Password Akun" id="" required>
                                     <small class="text-danger pl-2">Wajib diisi</small>
                                 </div>
                                 <div class="col">
                                     <label class="col-form-label"><b>Konfirmasi Password</b></label>
                                     <input type="password" class="form-control" name="confirm_pass" placeholder="Konfirmasi Password Akun" id="" required>
                                     <?= form_error('confirm_pass', '<small class="text-danger pl-3">', '</small>') ?>
                                     <small class="text-danger pl-2">Wajib diisi</small>
                                 </div>
                             </div>
                             <div class="row">
                                 <div class="col">
                                     <label class="col-form-label"><b>User Role</b></label>
                                     <select name="role_id" id="" class="form-control select2" required>
                                         <option value="">- Pilih Role -</option>
                                         <?php foreach ($all_role as $ar) : ?>
                                             <option value="<?= $ar['role_id'] ?>" <?php if ($u['role_id'] == $ar['role_id']) : ?>selected<?php endif; ?>><?= $ar['role_nama'] ?></option>
                                         <?php endforeach; ?>
                                     </select>
                                     <small class="text-danger pl-2">Wajib diisi</small>
                                 </div>
                                 <div class="col">
                                     <label class="col-form-label"><b>Status User</b></label>
                                     <select name="user_st" id="" class="form-control select2" required>
                                         <option value="">- Pilih Status -</option>
                                         <option value="1" <?php if ($u['user_st'] == 1) : ?>selected<?php endif; ?>>Aktif</option>
                                         <option value="0" <?php if ($u['user_st'] == 0) : ?>selected<?php endif; ?>>Nonaktif</option>
                                     </select>
                                     <small class="text-danger pl-2">Wajib diisi</small>
                                 </div>
                             </div>

                             <div class="row">
                                 <div class="col-3">
                                     <div class="mb-3">
                                         <img id="preview" src="<?= base_url('assets/img/profile/' . $u['user_img_name']) ?>" alt="Preview Foto Profil" style="max-width: 100px; max-height: 100px;">
                                     </div>
                                 </div>
                                 <div class="col-9">
                                     <div class="mb-3">
                                         <label class="form-label"><b>Foto Profil User</b></label>
                                         <div class="custom-file">
                                             <input type="file" name="user_img_name" class="custom-file-input" id="customFile" onchange="showEditFileName(event)">
                                             <label class="custom-file-label" for="customFile">Pilih file</label>
                                         </div>
                                     </div>
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

     <!-- Modals View Pengguna-->
     <?php foreach ($all_users as $u) : ?>
         <div class="modal fade bd-example-modal-lg" id="view_user_<?= $u['user_id'] ?>" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
             <div class="modal-dialog modal-lg">
                 <div class="modal-content">
                     <!-- Modal Header -->
                     <div class="modal-header">
                         <h5 class="modal-title">Detail Data Pengguna</h5>
                         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                             <span aria-hidden="true">&times;</span>
                         </button>
                     </div>
                     <!-- Modal Body -->
                     <div class="modal-body">
                         <div class="row">
                             <div class="col-2">
                                 <div class="mb-3">
                                     <img id="preview" src="<?= base_url('assets/img/profile/' . $u['user_img_name']) ?>" alt="Preview Foto Profil" style="max-width: 100px; max-height: 100px;">
                                 </div>
                             </div>
                             <div class="col">
                                 <label class="col-form-label"><b>Nama Alias</b></label>
                                 <input type="text" class="form-control" value="<?= $u['user_alias'] ?>" id="" disabled>
                             </div>
                             <div class="col">
                                 <label class="col-form-label"><b>ID User</b></label>
                                 <input type="text" class="form-control" value="<?= $u['user_id'] ?>" id="" disabled>
                             </div>
                         </div>
                         <div class="row">
                             <div class="col">
                                 <label class="col-form-label"><b>Username</b></label>
                                 <input type="text" class="form-control" value="<?= $u['user_nama'] ?>" id="" disabled>
                             </div>
                             <div class="col">
                                 <label class="col-form-label"><b>User Mail</b></label>
                                 <input type="email" class="form-control" value="<?= $u['user_mail'] ?>" id="" disabled>
                             </div>
                         </div>
                         <div class="row">
                             <div class="col">
                                 <label class="col-form-label"><b>User Group</b></label>
                                 <input type="text" class="form-control" value="<?= $u['group_nama'] ?>" id="" disabled>
                             </div>
                             <div class="col">
                                 <label class="col-form-label"><b>Deskripsi Group</b></label>
                                 <input type="text" class="form-control" value="<?= $u['group_deskripsi'] ?>" id="" disabled>
                             </div>
                         </div>
                         <div class="row">
                             <div class="col">
                                 <label class="col-form-label"><b>User Role</b></label>
                                 <select id="" class="form-control select2" disabled>
                                     <option value="">- Pilih Role -</option>
                                     <?php foreach ($all_role as $ar) : ?>
                                         <option value="<?= $ar['role_id'] ?>" <?php if ($u['role_id'] == $ar['role_id']) : ?>selected<?php endif; ?>><?= $ar['role_nama'] ?></option>
                                     <?php endforeach; ?>
                                 </select>
                             </div>
                             <div class="col">
                                 <label class="col-form-label"><b>Deskripsi Role</b></label>
                                 <input type="text" class="form-control" value="<?= $u['role_deskripsi'] ?>" id="" disabled>
                             </div>
                         </div>

                         <div class="row">
                             <div class="col">
                                 <label class="col-form-label"><b>Tanggal Akun Dibuat / Diubah</b></label>
                                 <?php
                                    $tanggal_akun_dibuat = date('d M Y H:i:s', strtotime($u['tanggal_akun_dibuat']));
                                    ?>
                                 <input type="text" class="form-control" value="<?= $tanggal_akun_dibuat ?>" id="" disabled>
                             </div>
                             <div class="col">
                                 <label class="col-form-label"><b>Status User</b></label>
                                 <select id="" class="form-control select2" disabled>
                                     <option value="">- Pilih Status -</option>
                                     <option value="1" <?php if ($u['user_st'] == 1) : ?>selected<?php endif; ?>>Aktif</option>
                                     <option value="0" <?php if ($u['user_st'] == 0) : ?>selected<?php endif; ?>>Nonaktif</option>
                                 </select>
                             </div>
                         </div>

                         <div class="modal-footer mt-3">
                             <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                         </div>
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

     //  Menampilkan nama file setelah memilih file foto profile 
     function showAddFileName(event) {
         var input = event.target;
         var fileName = input.files[0].name;
         var label = input.nextElementSibling;
         label.innerText = fileName;
     }

     function showEditFileName(event) {
         var input = event.target;
         var fileName = input.files[0].name;
         var label = input.nextElementSibling;
         label.innerText = fileName;
     }

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