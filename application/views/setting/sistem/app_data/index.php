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

                     </div>
                     <!-- Notifikasi form validasi -->
                     <?= $this->session->flashdata('message') ?>
                     <!-- Notifikasi form validasi -->
                 </div>
                 <div class="card-body">
                     <form action="<?= base_url('setting/sistem/app_data/edit_proses') ?>" method="post" enctype="multipart/form-data">
                         <input type="hidden" name="app_data_id" value="<?= $app_data['app_data_id'] ?>">
                         <input type="hidden" name="old_image" value="<?= $app_data['logo_app'] ?>">
                         <div class="row">
                             <div class="col-lg-4">
                                 <div class="card mb-4">
                                     <div class="card-body text-center">
                                         <img src="<?= base_url('assets/img/logo/' . $app_data['logo_app']) ?>" alt="Website Logo" class="rounded-circle img-fluid" style="width: 150px;">
                                         <h5 class="my-3"><?= $app_data['portal_nm'] ?></h5>
                                         <p class="text-muted mb-1"><?= $app_data['email_app'] ?></p>
                                         <p class="text-muted mb-4"><?= $app_data['site_title'] ?></p>

                                     </div>
                                 </div>
                                 <div class="card mb-4 mb-lg-0">
                                     <div class="card-body p-0">
                                         <ul class="list-group list-group-flush rounded-3">
                                             <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                                 <i class="fas fa-phone fa-lg text-warning"></i>
                                                 <p class="mb-0"><?= $app_data['no_tlp_app'] ?></p>
                                             </li>
                                             <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                                 <i class="fab fa-whatsapp fa-lg" style="color: #39d073;"></i>
                                                 <p class="mb-0"><?= $app_data['no_whatsapp_app'] ?></p>
                                             </li>
                                             <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                                 <i class="fab fa-telegram fa-lg" style="color: #398fd0;"></i>
                                                 <p class="mb-0"><?= $app_data['no_telegram_app'] ?></p>
                                             </li>
                                             <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                                 <i class="fab fa-facebook-f fa-lg" style="color: #3b5998;"></i>
                                                 <p class="mb-0"><?= $app_data['facebook_app'] ?></p>
                                             </li>
                                             <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                                 <i class="fab fa-instagram fa-lg" style="color: #ac2bac;"></i>
                                                 <p class="mb-0"><?= $app_data['instagram_app'] ?></p>
                                             </li>
                                             <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                                 <i class="fab fa-twitter fa-lg" style="color: #55acee;"></i>
                                                 <p class="mb-0"><?= $app_data['twitter_app'] ?></p>
                                             </li>
                                             <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                                 <i class="fab fa-tiktok fa-lg" style="color: black;"></i>
                                                 <p class="mb-0"><?= $app_data['tiktok_app'] ?></p>
                                             </li>
                                             <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                                 <i class="fab fa-youtube fa-lg" style="color: red;"></i>
                                                 <p class="mb-0"><?= $app_data['youtube_app'] ?></p>
                                             </li>
                                             <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                                 <i class="fab fa-github fa-lg" style="color: black;"></i>
                                                 <p class="mb-0"><?= $app_data['github_app'] ?></p>
                                             </li>
                                             <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                                 <i class="fab fa-linkedin fa-lg" style="color: #55acee;"></i>
                                                 <p class="mb-0"><?= $app_data['linkedin_app'] ?></p>
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
                                                 <p class="mb-0">Nama Aplikasi</p>
                                             </div>
                                             <div class="col-sm-9">
                                                 <div class="col">
                                                     <input type="text" class="form-control" name="site_title" value="<?= $app_data['site_title'] ?>" id="" disabled>
                                                     <?= form_error('site_title', '<small class="text-danger pl-3">', '</small>') ?>
                                                 </div>
                                             </div>
                                         </div>
                                         <hr>
                                         <div class="row">
                                             <div class="col-sm-3">
                                                 <p class="mb-0">Nama Portal</p>
                                             </div>
                                             <div class="col-sm-9">
                                                 <div class="col">
                                                     <input type="text" class="form-control" name="portal_nm" disabled value="<?= $app_data['portal_nm'] ?>" id="" required>
                                                     <?= form_error('portal_nm', '<small class="text-danger pl-3">', '</small>') ?>
                                                 </div>
                                             </div>
                                         </div>
                                         <hr>
                                         <div class="row">
                                             <div class="col-sm-3">
                                                 <p class="mb-0">Email Aplikasi</p>
                                             </div>
                                             <div class="col-sm-9">
                                                 <div class="col">
                                                     <input type="email" class="form-control" name="email_app" value="<?= $app_data['email_app'] ?>" id="" required>
                                                     <?= form_error('email_app', '<small class="text-danger pl-3">', '</small>') ?>
                                                 </div>
                                             </div>
                                         </div>
                                         <hr>
                                         <div class="row">
                                             <div class="col-sm-3">
                                                 <p class="mb-0">Nomor Telephone Aplikasi</p>
                                             </div>
                                             <div class="col-sm-9">
                                                 <div class="col">
                                                     <input type="number" class="form-control" name="no_tlp_app" value="<?= $app_data['no_tlp_app'] ?>" id="" required>
                                                     <?= form_error('no_tlp_app', '<small class="text-danger pl-3">', '</small>') ?>
                                                 </div>
                                             </div>
                                         </div>
                                         <hr>
                                         <div class="row">
                                             <div class="col-sm-3">
                                                 <p class="mb-0">Nomor Whats App Aplikasi</p>
                                             </div>
                                             <div class="col-sm-9">
                                                 <div class="col">
                                                     <input type="number" class="form-control" name="no_whatsapp_app" value="<?= $app_data['no_whatsapp_app'] ?>" id="" required>
                                                     <?= form_error('no_whatsapp_app', '<small class="text-danger pl-3">', '</small>') ?>
                                                 </div>
                                             </div>
                                         </div>
                                         <hr>
                                         <div class="row">
                                             <div class="col-sm-3">
                                                 <p class="mb-0">Nomor Telegram Aplikasi</p>
                                             </div>
                                             <div class="col-sm-9">
                                                 <div class="col">
                                                     <input type="number" class="form-control" name="no_telegram_app" value="<?= $app_data['no_telegram_app'] ?>" id="" required>
                                                     <?= form_error('no_telegram_app', '<small class="text-danger pl-3">', '</small>') ?>
                                                 </div>
                                             </div>
                                         </div>
                                         <hr>
                                         <div class="row">
                                             <div class="col-sm-3">
                                                 <p class="mb-0">Username Facebook Aplikasi</p>
                                             </div>
                                             <div class="col-sm-9">
                                                 <div class="col">
                                                     <input type="text" class="form-control" name="facebook_app" value="<?= $app_data['facebook_app'] ?>" id="" required>
                                                     <?= form_error('facebook_app', '<small class="text-danger pl-3">', '</small>') ?>
                                                 </div>
                                             </div>
                                         </div>
                                         <hr>
                                         <div class="row">
                                             <div class="col-sm-3">
                                                 <p class="mb-0">Username Instagram Aplikasi</p>
                                             </div>
                                             <div class="col-sm-9">
                                                 <div class="col">
                                                     <input type="text" class="form-control" name="instagram_app" value="<?= $app_data['instagram_app'] ?>" id="" required>
                                                     <?= form_error('instagram_app', '<small class="text-danger pl-3">', '</small>') ?>
                                                 </div>
                                             </div>
                                         </div>
                                         <hr>
                                         <div class="row">
                                             <div class="col-sm-3">
                                                 <p class="mb-0">Username Twitter Aplikasi</p>
                                             </div>
                                             <div class="col-sm-9">
                                                 <div class="col">
                                                     <input type="text" class="form-control" name="twitter_app" value="<?= $app_data['twitter_app'] ?>" id="" required>
                                                     <?= form_error('twitter_app', '<small class="text-danger pl-3">', '</small>') ?>
                                                 </div>
                                             </div>
                                         </div>
                                         <hr>
                                         <div class="row">
                                             <div class="col-sm-3">
                                                 <p class="mb-0">Username Tik Tok Aplikasi</p>
                                             </div>
                                             <div class="col-sm-9">
                                                 <div class="col">
                                                     <input type="text" class="form-control" name="tiktok_app" value="<?= $app_data['tiktok_app'] ?>" id="" required>
                                                     <?= form_error('tiktok_app', '<small class="text-danger pl-3">', '</small>') ?>
                                                 </div>
                                             </div>
                                         </div>
                                         <hr>
                                         <div class="row">
                                             <div class="col-sm-3">
                                                 <p class="mb-0">Github Aplikasi</p>
                                             </div>
                                             <div class="col-sm-9">
                                                 <div class="col">
                                                     <input type="text" class="form-control" name="github_app" value="<?= $app_data['github_app'] ?>" id="" required>
                                                     <?= form_error('github_app', '<small class="text-danger pl-3">', '</small>') ?>
                                                 </div>
                                             </div>
                                         </div>
                                         <hr>
                                         <div class="row">
                                             <div class="col-sm-3">
                                                 <p class="mb-0">Username Linkedin Aplikasi</p>
                                             </div>
                                             <div class="col-sm-9">
                                                 <div class="col">
                                                     <input type="text" class="form-control" name="linkedin_app" value="<?= $app_data['linkedin_app'] ?>" id="" required>
                                                     <?= form_error('linkedin_app', '<small class="text-danger pl-3">', '</small>') ?>
                                                 </div>
                                             </div>
                                         </div>
                                         <hr>
                                         <div class="row">
                                             <div class="col-sm-3">
                                                 <p class="mb-0">Youtube Aplikasi</p>
                                             </div>
                                             <div class="col-sm-9">
                                                 <div class="col">
                                                     <input type="text" class="form-control" name="youtube_app" value="<?= $app_data['youtube_app'] ?>" id="" required>
                                                     <?= form_error('youtube_app', '<small class="text-danger pl-3">', '</small>') ?>
                                                 </div>
                                             </div>
                                         </div>
                                         <hr>
                                         <div class="row">
                                             <div class="col-sm-3">
                                                 <p class="mb-0">Logo Aplikasi</p>
                                             </div>
                                             <div class="col-sm-9">
                                                 <div class="col">
                                                     <div class="custom-file">
                                                         <input type="file" name="logo_app" class="custom-file-input" id="customFile" onchange="showEditFileName(event)">
                                                         <label class="custom-file-label" for="customFile">Pilih file</label>
                                                     </div>
                                                 </div>
                                             </div>
                                         </div>
                                         <hr>
                                         <div class="row">
                                             <div class="col-sm-9">
                                                 <div class="col">
                                                     <button type="submit" class="btn btn-primary">Simpan Data Aplikasi</button>
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