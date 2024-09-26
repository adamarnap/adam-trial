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
                         <h2 class="h3 mb-0 text-gray-800">Data <?= $sub_title ?></h2>
                         <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm" data-toggle="modal" data-target="#ubah_password">
                             <i class="fas fa-key fa-sm text-white-100"></i> Ubah Password Akun Saya
                         </a>
                     </div>
                     <!-- Notifikasi form validasi -->
                     <?= $this->session->flashdata('message') ?>
                     <!-- Notifikasi form validasi -->
                 </div>
                 <div class="card-body">
                     <form action="<?= base_url('profile/myprofile/profile/edit_proses') ?>" method="post" enctype="multipart/form-data">
                         <input type="hidden" name="user_id" value="<?= $user['user_id'] ?>">
                         <input type="hidden" name="old_image" value="<?= $user['user_img_name'] ?>">
                         <div class="row">
                             <div class="col-lg-4">
                                 <div class="card mb-4">
                                     <div class="card-body text-center">
                                         <img src="<?= base_url('assets/img/profile/' . $user['user_img_name']) ?>" alt="avatar" class="rounded-circle img-fluid" style="width: 150px;">
                                         <h5 class="my-3"><?= $user['user_alias'] ?></h5>
                                         <p class="text-muted mb-1">
                                             <?php if ($user['user_st'] == '1') : ?>
                                                 <span class="badge badge-success">Akun Aktif</span>
                                             <?php elseif ($user['user_st'] == '0') : ?>
                                                 <span class="badge badge-secondary">Akun Nonaktif</span>
                                             <?php else : ?>
                                                 <span class="badge badge-danger">Informasi Status Error</span>
                                             <?php endif; ?>
                                         </p>
                                         <p class="text-muted mb-1"><?= $user['user_nama'] ?></p>
                                         <p class="text-muted mb-4"><?= $user['user_mail'] ?></p>

                                     </div>
                                 </div>
                                 <div class="card mb-4 mb-lg-0">
                                     <div class="card-body p-0">
                                         <ul class="list-group list-group-flush rounded-3">
                                             <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                                 <i class="fas fa-phone fa-lg text-warning"></i>
                                                 <p class="mb-0"><?= $user['no_tlp'] ?></p>
                                             </li>
                                             <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                                 <i class="fab fa-whatsapp fa-lg" style="color: #39d073;"></i>
                                                 <p class="mb-0"><?= $user['no_whatsapp'] ?></p>
                                             </li>
                                             <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                                 <i class="fab fa-telegram fa-lg" style="color: #398fd0;"></i>
                                                 <p class="mb-0"><?= $user['no_telegram'] ?></p>
                                             </li>
                                             <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                                 <i class="fab fa-facebook-f fa-lg" style="color: #3b5998;"></i>
                                                 <p class="mb-0"><?= $user['facebook'] ?></p>
                                             </li>
                                             <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                                 <i class="fab fa-instagram fa-lg" style="color: #ac2bac;"></i>
                                                 <p class="mb-0"><?= $user['instagram'] ?></p>
                                             </li>
                                             <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                                 <i class="fab fa-twitter fa-lg" style="color: #55acee;"></i>
                                                 <p class="mb-0"><?= $user['twitter'] ?></p>
                                             </li>
                                         </ul>
                                     </div>
                                 </div>
                             </div>

                             <div class="col-lg-8">
                                 <div class="card mb-4">
                                     <div class="card-body">
                                         <div class="row">
                                             <div class="col-sm-3">
                                                 <p class="mb-0">Nama Pengguna</p>
                                             </div>
                                             <div class="col-sm-9">
                                                 <div class="col">
                                                     <input type="text" class="form-control" name="user_alias" value="<?= $user['user_alias'] ?>" id="" required>
                                                     <?= form_error('user_alias', '<small class="text-danger pl-3">', '</small>') ?>
                                                 </div>
                                             </div>
                                         </div>
                                         <hr>
                                         <div class="row">
                                             <div class="col-sm-3">
                                                 <p class="mb-0">Username</p>
                                             </div>
                                             <div class="col-sm-9">
                                                 <div class="col">
                                                     <input type="text" class="form-control" name="user_nama" disabled value="<?= $user['user_nama'] ?>" id="" required>
                                                     <?= form_error('user_nama', '<small class="text-danger pl-3">', '</small>') ?>
                                                 </div>
                                             </div>
                                         </div>
                                         <hr>
                                         <div class="row">
                                             <div class="col-sm-3">
                                                 <p class="mb-0">Email</p>
                                             </div>
                                             <div class="col-sm-9">
                                                 <div class="col">
                                                     <input type="email" class="form-control" name="user_mail" value="<?= $user['user_mail'] ?>" disabled id="" required>
                                                     <?= form_error('user_mail', '<small class="text-danger pl-3">', '</small>') ?>
                                                 </div>
                                             </div>
                                         </div>
                                         <hr>
                                         <div class="row">
                                             <div class="col-sm-3">
                                                 <p class="mb-0">Role</p>
                                             </div>
                                             <div class="col-sm-9">
                                                 <div class="col">
                                                     <input type="text" class="form-control" name="role_nama" disabled value="<?= $user['role_nama'] ?>" id="" required>
                                                     <?= form_error('role_nama', '<small class="text-danger pl-3">', '</small>') ?>
                                                 </div>
                                             </div>
                                         </div>
                                         <hr>
                                         <div class="row">
                                             <div class="col-sm-3">
                                                 <p class="mb-0">Grup</p>
                                             </div>
                                             <div class="col-sm-9">
                                                 <div class="col">
                                                     <input type="text" class="form-control" name="group_nama" disabled value="<?= $user['group_nama'] ?>" id="" required>
                                                     <?= form_error('group_nama', '<small class="text-danger pl-3">', '</small>') ?>
                                                 </div>
                                             </div>
                                         </div>
                                         <hr>
                                         <div class="row">
                                             <div class="col-sm-3">
                                                 <p class="mb-0">Tempat Lahir</p>
                                             </div>
                                             <div class="col-sm-9">
                                                 <div class="col">
                                                     <input type="text" class="form-control" name="tempat_lahir" value="<?= $user['tempat_lahir'] ?>" id="" required>
                                                     <?= form_error('tempat_lahir', '<small class="text-danger pl-3">', '</small>') ?>
                                                 </div>
                                             </div>
                                         </div>
                                         <hr>
                                         <div class="row">
                                             <div class="col-sm-3">
                                                 <p class="mb-0">Tanggal Lahir</p>
                                             </div>
                                             <div class="col-sm-9">
                                                 <div class="col">
                                                     <input type="date" class="form-control" name="tgl_lahir" value="<?= $user['tgl_lahir'] ?>" id="" required>
                                                     <?= form_error('tgl_lahir', '<small class="text-danger pl-3">', '</small>') ?>
                                                 </div>
                                             </div>
                                         </div>
                                         <hr>
                                         <div class="row">
                                             <div class="col-sm-3">
                                                 <p class="mb-0">Alamat Tempat Tinggal</p>
                                             </div>
                                             <div class="col-sm-9">
                                                 <div class="col">
                                                     <textarea class="form-control" name="alamat" id="exampleFormControlTextarea1" rows="3"><?= $user['alamat'] ?></textarea>
                                                     <?= form_error('alamat', '<small class="text-danger pl-3">', '</small>') ?>
                                                 </div>
                                             </div>
                                         </div>
                                         <hr>
                                         <div class="row">
                                             <div class="col-sm-3">
                                                 <p class="mb-0">Nomor Ponsel</p>
                                             </div>
                                             <div class="col-sm-9">
                                                 <div class="col">
                                                     <input type="number" class="form-control" name="no_tlp" value="<?= $user['no_tlp'] ?>" id="" required>
                                                     <?= form_error('no_tlp', '<small class="text-danger pl-3">', '</small>') ?>
                                                 </div>
                                             </div>
                                         </div>
                                         <hr>
                                         <div class="row">
                                             <div class="col-sm-3">
                                                 <p class="mb-0">Nomor Whats App</p>
                                             </div>
                                             <div class="col-sm-9">
                                                 <div class="col">
                                                     <input type="number" class="form-control" name="no_whatsapp" value="<?= $user['no_whatsapp'] ?>" id="" required>
                                                     <?= form_error('no_whatsapp', '<small class="text-danger pl-3">', '</small>') ?>
                                                 </div>
                                             </div>
                                         </div>
                                         <hr>
                                         <div class="row">
                                             <div class="col-sm-3">
                                                 <p class="mb-0">Nomor Telegram</p>
                                             </div>
                                             <div class="col-sm-9">
                                                 <div class="col">
                                                     <input type="number" class="form-control" name="no_telegram" value="<?= $user['no_telegram'] ?>" id="" required>
                                                     <?= form_error('no_telegram', '<small class="text-danger pl-3">', '</small>') ?>
                                                 </div>
                                             </div>
                                         </div>
                                         <hr>
                                         <div class="row">
                                             <div class="col-sm-3">
                                                 <p class="mb-0">Username Facebook</p>
                                             </div>
                                             <div class="col-sm-9">
                                                 <div class="col">
                                                     <input type="text" class="form-control" name="facebook" value="<?= $user['facebook'] ?>" id="" required>
                                                     <?= form_error('facebook', '<small class="text-danger pl-3">', '</small>') ?>
                                                 </div>
                                             </div>
                                         </div>
                                         <hr>
                                         <div class="row">
                                             <div class="col-sm-3">
                                                 <p class="mb-0">Username Instagram</p>
                                             </div>
                                             <div class="col-sm-9">
                                                 <div class="col">
                                                     <input type="text" class="form-control" name="instagram" value="<?= $user['instagram'] ?>" id="" required>
                                                     <?= form_error('instagram', '<small class="text-danger pl-3">', '</small>') ?>
                                                 </div>
                                             </div>
                                         </div>
                                         <hr>
                                         <div class="row">
                                             <div class="col-sm-3">
                                                 <p class="mb-0">Username Twitter</p>
                                             </div>
                                             <div class="col-sm-9">
                                                 <div class="col">
                                                     <input type="text" class="form-control" name="twitter" value="<?= $user['twitter'] ?>" id="" required>
                                                     <?= form_error('twitter', '<small class="text-danger pl-3">', '</small>') ?>
                                                 </div>
                                             </div>
                                         </div>
                                         <hr>
                                         <div class="row">
                                             <div class="col-sm-3">
                                                 <p class="mb-0">Foto Profil</p>
                                             </div>
                                             <div class="col-sm-9">
                                                 <div class="col">
                                                     <div class="custom-file">
                                                         <input type="file" name="user_img_name" class="custom-file-input" id="customFile" onchange="showEditFileName(event)">
                                                         <label class="custom-file-label" for="customFile">Pilih file</label>
                                                     </div>
                                                 </div>
                                             </div>
                                         </div>
                                         <hr>
                                         <div class="row">
                                             <div class="col-sm-9">
                                                 <div class="col">
                                                     <button type="submit" class="btn btn-primary">Simpan Data Akun</button>
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         </div>
                     </form>
                 </div>
             </div>
         </div>
     </div>
     <!-- /.container-fluid -->
 </div>
 </div>

 <!-- Modals Add Role-->
 <div class="modal fade bd-example-modal-lg" id="ubah_password" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
     <div class="modal-dialog">
         <div class="modal-content">
             <!-- Modal Header -->
             <div class="modal-header">
                 <h5 class="modal-title">Ubah Password</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <!-- Modal Body -->
             <div class="modal-body">
                 <!-- Form Ubah Password -->
                 <form action="<?= base_url('profile/myprofile/profile/ubah_password_proses') ?>" method="post" enctype="multipart/form-data">
                     <div class="row">
                         <div class="col">
                             <label class="col-form-label"><b>Password Lama</b></label>
                             <input type="password" class="form-control" name="old_user_pass" id="" required>
                             <?= form_error('old_user_pass', '<small class="text-danger pl-3">', '</small>') ?>
                             <small class="text-danger pl-2">Wajib diisi</small>
                         </div>
                     </div>
                     <div class="row">
                         <div class="col">
                             <label class="col-form-label"><b>Password Baru</b></label>
                             <input type="password" class="form-control" name="new_user_pass" id="" required>
                             <?= form_error('new_user_pass', '<small class="text-danger pl-3">', '</small>') ?>
                             <small class="text-danger pl-2">Wajib diisi</small>
                         </div>
                     </div>
                     <div class="row">
                         <div class="col">
                             <label class="col-form-label"><b>Konfirmasi Password</b></label>
                             <input type="password" class="form-control" name="confirm_pass" id="" required>
                             <?= form_error('confirm_pass', '<small class="text-danger pl-3">', '</small>') ?>
                             <small class="text-danger pl-2">Wajib diisi</small>
                         </div>
                     </div>
                     <div class="modal-footer">
                         <button type="submit" class="btn btn-danger">Ubah Password</button>
                         <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                     </div>
                 </form>
             </div>
             <!-- Modal Footer -->
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

     //  Menampilkan nama file setelah memilih file foto profile 

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