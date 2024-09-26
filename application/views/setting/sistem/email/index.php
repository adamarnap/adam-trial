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
                                     <th>Email Nama</th>
                                     <th>SMTP Username</th>
                                     <th>Alamat Email</th>
                                     <th>SMTP Host</th>
                                     <th>SMTP Port</th>
                                     <th>Status SMTP</th>
                                     <th>Status Verifikasi</th>
                                     <th>Aksi</th>
                                 </tr>
                             </thead>
                             <tfoot>
                                 <th>#</th>
                                 <th>Email Nama</th>
                                 <th>SMTP Username</th>
                                 <th>Alamat Email</th>
                                 <th>SMTP Host</th>
                                 <th>SMTP Port</th>
                                 <th>Status SMTP</th>
                                 <th>Status Verifikasi</th>
                                 <th>Aksi</th>
                             </tfoot>
                             <tbody>
                                 <tr>
                                     <td align="center"><?= 1 ?></td>
                                     <td align="left"><?= $email['email_name'] ?></td>
                                     <td align="left"><?= $email['smtp_username'] ?></td>
                                     <td align="left"><?= $email['email_address'] ?></td>
                                     <td align="left"><?= $email['smtp_host'] ?></td>
                                     <td align="left"><?= $email['smtp_port'] ?></td>
                                     <td align="left">
                                         <?php if ($email['use_smtp'] == 1) : ?>
                                             <span class="badge badge-pill badge-success">Aktif</span>
                                         <?php elseif ($email['use_smtp'] == 0) : ?>
                                             <span class="badge badge-pill badge-secondary">Nonaktif</span>
                                         <?php else : ?>
                                             <span class="badge badge-pill badge-danger">Data Error</span>
                                         <?php endif; ?>
                                     </td>
                                     <td align="left">
                                         <?php if ($email['use_authorization'] == 1) : ?>
                                             <span class="badge badge-pill badge-success">Aktif</span>
                                         <?php elseif ($email['use_authorization'] == 0) : ?>
                                             <span class="badge badge-pill badge-secondary">Nonaktif</span>
                                         <?php else : ?>
                                             <span class="badge badge-pill badge-danger">Data Error</span>
                                         <?php endif; ?>
                                     </td>

                                     <td align="center">
                                         <a href="" class="d-none d-sm-inline-block btn btn-sm btn-warning shadow-sm" data-toggle="modal" data-target="#edit_email_<?= $email['email_id'] ?>">
                                             <i class="fas fa-edit fa-sm text-white-50"></i>
                                         </a>
                                         <!-- <a href="<?= base_url('setting/sistem/group/hapus_group/') . $email['email_id'] ?>" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm" onclick="konfirmasiHapus(event)">
                                             <i class="fas fa-trash fa-sm text-white-50"></i>
                                         </a> -->
                                     </td>
                                 </tr>
                             </tbody>
                         </table>
                     </div>
                 </div>
             </div>
         </div>
         <!-- /.container-fluid -->
     </div>

     <!-- Modals Edit Email-->

     <div class="modal fade bd-example-modal-lg" id="edit_email_<?= $email['email_id'] ?>" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
         <div class="modal-dialog modal-lg">
             <div class="modal-content">
                 <!-- Modal Header -->
                 <div class="modal-header">
                     <h5 class="modal-title">Edit Data Email Verifikasi</h5>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                     </button>
                 </div>
                 <!-- Modal Body -->
                 <div class="modal-body">
                     <!-- Form Tambah Data Portal -->
                     <form action="<?= base_url('setting/sistem/email/edit_proses') ?>" method="post">
                         <input type="hidden" name="email_id" value="<?= $email['email_id'] ?>">
                         <div class="row">
                             <div class="col">
                                 <label class="col-form-label"><b>Nama Email</b></label>
                                 <input type="text" class="form-control" name="email_name" value="<?= $email['email_name'] ?>" id="" required>
                                 <small class="text-danger pl-2">Wajib diisi</small>
                             </div>
                         </div>
                         <div class="row">
                             <div class="col">
                                 <label class="col-form-label"><b>SMTP Username</b></label>
                                 <input type="text" class="form-control" name="smtp_username" value="<?= $email['smtp_username'] ?>" id="" required>
                                 <small class="text-danger pl-2">Wajib diisi</small>
                             </div>
                             <div class="col">
                                 <label class="col-form-label"><b>Alamat Email</b></label>
                                 <input type="text" class="form-control" name="email_address" value="<?= $email['email_address'] ?>" id="" required>
                                 <small class="text-danger pl-2">Wajib diisi</small>
                             </div>
                         </div>
                         <div class="row">
                             <div class="col">
                                 <label class="col-form-label"><b>SMTP Host</b></label>
                                 <input type="text" class="form-control" name="smtp_host" value="<?= $email['smtp_host'] ?>" id="" required>
                                 <small class="text-danger pl-2">Wajib diisi</small>
                             </div>
                             <div class="col">
                                 <label class="col-form-label"><b>SMTP Port</b></label>
                                 <input type="text" class="form-control" name="smtp_port" value="<?= $email['smtp_port'] ?>" id="" required>
                                 <small class="text-danger pl-2">Wajib diisi</small>
                             </div>
                         </div>
                         <div class="row">
                             <div class="col">
                                 <label class="col-form-label"><b>SMTP Password</b></label>
                                 <input type="text" class="form-control" name="smtp_password" value="<?= $email['smtp_password'] ?>" id="" required>
                                 <small class="text-danger pl-2">Wajib diisi</small>
                             </div>
                         </div>
                         <div class="row">
                             <div class="col">
                                 <label class="col-form-label"><b>Status Digunakan SMTP</b></label>
                                 <select name="use_smtp" class="form-control select2" id="" required>
                                     <option value="">-Pilih Status-</option>
                                     <option value="1" <?php if ($email['use_smtp'] == 1) : ?>selected<?php endif; ?>>Aktif</option>
                                     <option value="2" <?php if ($email['use_smtp'] == 2) : ?>selected<?php endif; ?>>Nonaktif</option>
                                 </select>
                                 <small class="text-danger pl-2">Wajib diisi</small>
                             </div>
                             <div class="col">
                                 <label class="col-form-label"><b>Status Fitur Verifikasi</b></label>
                                 <select name="use_authorization" class="form-control select2" id="" required>
                                     <option value="">-Pilih Status-</option>
                                     <option value="1" <?php if ($email['use_authorization'] == 1) : ?>selected<?php endif; ?>>Aktif</option>
                                     <option value="2" <?php if ($email['use_authorization'] == 2) : ?>selected<?php endif; ?>>Nonaktif</option>
                                 </select>
                                 <small class="text-danger pl-2">Wajib diisi</small>
                             </div>
                         </div>

                         <div class="modal-footer">
                             <button type="submit" class="btn btn-primary">Simpan Data Email</button>
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