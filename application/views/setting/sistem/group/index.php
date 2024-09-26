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
                         <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#tambah_group">
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
                                     <th>Nama Grup</th>
                                     <th>Grup Deskripsi</th>
                                     <th>Aksi</th>
                                 </tr>
                             </thead>
                             <tfoot>
                                 <tr>
                                     <th>#</th>
                                     <th>Nama Grup</th>
                                     <th>Grup Deskripsi</th>
                                     <th>Aksi</th>
                                 </tr>
                             </tfoot>
                             <tbody>
                                 <?php $no = 1;
                                    foreach ($group_data as $gd) : ?>
                                     <tr>
                                         <td align="center"><?= $no++ ?></td>
                                         <td align="left"><?= $gd['group_nama'] ?></td>
                                         <td align="center"><?= $gd['group_deskripsi'] ?></td>

                                         <td align="center">
                                             <a href="" class="d-none d-sm-inline-block btn btn-sm btn-warning shadow-sm" data-toggle="modal" data-target="#edit_group_<?= $gd['group_id'] ?>">
                                                 <i class="fas fa-edit fa-sm text-white-50"></i>
                                             </a>
                                             <a href="<?= base_url('setting/sistem/group/hapus_group/') . $gd['group_id'] ?>" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm" onclick="konfirmasiHapus(event)">
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
     <div class="modal fade bd-example-modal-lg" id="tambah_group" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
         <div class="modal-dialog modal-lg">
             <div class="modal-content">
                 <!-- Modal Header -->
                 <div class="modal-header">
                     <h5 class="modal-title">Tambah Data Grup Baru</h5>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                     </button>
                 </div>
                 <!-- Modal Body -->
                 <div class="modal-body">
                     <!-- Form Tambah Data Grup -->
                     <form action="<?= base_url('setting/sistem/group/tambah_proses') ?>" method="post">
                         <div class="row">
                             <div class="col">
                                 <label class="col-form-label"><b>Nama Grup</b></label>
                                 <input type="text" class="form-control" name="group_nama" placeholder="Nama Grup" id="" required>
                                 <small class="text-danger pl-2">Wajib diisi</small>
                             </div>
                         </div>

                         <div class="row">
                             <div class="col">
                                 <label class="col-form-label"><b>Grup Deskripsi</b></label>
                                 <textarea class="form-control" id="exampleFormControlTextarea1" name="group_deskripsi" rows="3" required></textarea>
                                 <small class="text-danger pl-2">Wajib diisi</small>
                             </div>
                         </div>

                         <div class="modal-footer">
                             <button type="submit" class="btn btn-primary">Simpan Data Grup</button>
                             <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                         </div>
                     </form>
                 </div>
                 <!-- Modal Footer -->
             </div>
         </div>
     </div>

     <!-- Modals Edit Role-->
     <?php foreach ($group_data as $gd) : ?>
         <div class="modal fade bd-example-modal-lg" id="edit_group_<?= $gd['group_id'] ?>" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
             <div class="modal-dialog modal-lg">
                 <div class="modal-content">
                     <!-- Modal Header -->
                     <div class="modal-header">
                         <h5 class="modal-title">Edit Data Grup Baru</h5>
                         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                             <span aria-hidden="true">&times;</span>
                         </button>
                     </div>
                     <!-- Modal Body -->
                     <div class="modal-body">
                         <!-- Form Tambah Data Grup -->
                         <form action="<?= base_url('setting/sistem/group/edit_proses') ?>" method="post">
                             <input type="hidden" name="group_id" value="<?= $gd['group_id'] ?>">
                             <div class="row">
                                 <div class="col">
                                     <label class="col-form-label"><b>Nama Grup</b></label>
                                     <input type="text" class="form-control" name="group_nama" value="<?= $gd['group_nama'] ?>" placeholder="Nama Grup" id="" required>
                                     <small class="text-danger pl-2">Wajib diisi</small>
                                 </div>
                             </div>
                             <div class="row">
                                 <div class="col">
                                     <label class="col-form-label"><b>Grup Deskripsi</b></label>
                                     <textarea class="form-control" id="exampleFormControlTextarea1" name="group_deskripsi" rows="3" required><?= $gd['group_deskripsi'] ?></textarea>
                                     <small class="text-danger pl-2">Wajib diisi</small>
                                 </div>
                             </div>

                             <div class="modal-footer">
                                 <button type="submit" class="btn btn-primary">Simpan Data Grup</button>
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