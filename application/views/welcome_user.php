       <!-- Begin Page Content -->
       <div class="container-fluid">

           <!-- Page Heading -->
           <h1 class="h3 mb-4 text-gray-800"><?= $sub_title . ' | ' . $main_title ?></h1>

           <!-- Card -->
           <div class="card mb-3" style="max-width: 540px;">
               <div class="row g-0">
                   <div class="col-md-4 p-3">
                       <img src="<?= base_url('assets/img/profile/') . $user['user_img_name'] ?>" class="img-fluid rounded-start" alt="Foto Profil">
                   </div>
                   <div class="col-md-8">
                       <div class="card-body">
                           <h5 class="card-title"><?= $user['user_nama'] ?></h5>
                           <p class="card-text"><?= $user['user_mail'] ?></p>
                           <p class="card-text"><small class="text-body-secondary">Melakukan pendaftaran akun sejak, <?= date('d F Y', strtotime($user['mdd'])) ?></small></p>
                       </div>
                   </div>
               </div>
           </div>

       </div>
       <!-- /.container-fluid -->

       </div>
       <!-- End of Main Content -->