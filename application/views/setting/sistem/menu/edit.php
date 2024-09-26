 <!-- Content Wrapper -->
 <div id="content-wrapper" class="d-flex flex-column">
     <!-- Main Content -->
     <div id="content">
         <!-- Begin Page Content -->
         <div class="container-fluid">

             <!-- Page Heading -->
             <h1 class="h3 mb-2 text-gray-800">Data Menu</h1>

             <!-- DataTales Example -->
             <div class="card shadow mb-4">
                 <div class="card-header py-3">
                     <div class="d-sm-flex align-items-center justify-content-between mb-4">
                         <h2 class="h3 mb-0 text-gray-800">Edit Data Menu</h2>
                         <a href="<?= base_url('setting/sistem/menu/') ?>" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
                             <i class="fas fa-arrow-left fa-sm text-white-50"> </i> Kembali
                         </a>
                     </div>
                     <!-- Notifikasi form validasi -->
                     <?= $this->session->flashdata('message') ?>
                     <!-- Notifikasi form validasi -->
                 </div>
                 <div class="card-body">
                     <form action="<?= base_url('setting/sistem/menu/edit_proses') ?>" method="post">
                         <input type="hidden" name="menu_id" id="menu_id" value="<?= $menu_by_id['menu_id'] ?>" />
                         <input type="hidden" name="kode_menu_level" id="kode_menu_level" value="<?= $menu_by_id['menu_level'] ?>" />
                         <div class="row">
                             <div class="col">
                                 <label class="col-form-label"><b>Nama Menu</b></label>
                                 <input type="text" class="form-control" name="menu_judul" value="<?= $menu_by_id['menu_judul'] ?>" placeholder="Nama Menu" id="" required>
                                 <small class="text-danger pl-2">Wajib diisi</small>
                             </div>
                             <div class="col">
                                 <label class="col-form-label"><b>Alamat URL Menu</b></label>
                                 <input type="text" class="form-control" name="menu_url" value="<?= $menu_by_id['menu_url'] ?>" placeholder="Alamat URL Menu" id="" required>
                                 <small class="text-danger pl-2">Wajib diisi</small>
                             </div>
                         </div>
                         <div class="row">
                             <div class="col">
                                 <label class="col-form-label"><b>Menu Urut</b></label>
                                 <input type="number" id="" name="menu_urut" value="<?= $menu_by_id['menu_urut'] ?>" class="form-control" placeholder="Nomor Urut Menu" required>
                                 <small class="text-danger pl-2">Wajib diisi</small>
                             </div>
                             <div class="col">
                                 <label class="col-form-label"><b>Portal Website</b></label>
                                 <select name="portal_id" id="" class="form-control select2" required>
                                     <option value="">Pilih Portal Website</option>
                                     <?php foreach ($portal_data as $p) : ?>
                                         <option value="<?= $p['portal_id'] ?>" <?php if ($menu_by_id['portal_id'] == $p['portal_id']) : ?>selected<?php endif; ?>>
                                             <?= $p['portal_nm'] ?>
                                         </option>
                                     <?php endforeach; ?>
                                 </select>
                                 <small class="text-danger pl-2">Wajib diisi</small>
                             </div>
                         </div>
                         <div class="row">
                             <div class="col">
                                 <label class="col-form-label"><b>Level Menu</b></label>
                                 <select name="menu_level" id="" class="form-control select2" onchange="set_menu_level_edit(this);" required>
                                     <option value="">Pilih Level Menu</option>
                                     <option value="tunggal" <?php if ($menu_by_id['menu_level'] == 'tunggal') : ?>selected<?php endif; ?>>Menu Tunggal</option>
                                     <option value="induk" <?php if ($menu_by_id['menu_level'] == 'induk') : ?>selected<?php endif; ?>>Menu Induk</option>
                                     <option value="submenu" <?php if ($menu_by_id['menu_level'] == 'submenu') : ?>selected<?php endif; ?>>Sub Menu</option>
                                 </select>
                                 <small class="text-danger pl-2">Wajib diisi</small>
                             </div>
                             <div class="col">
                                 <label class="col-form-label"><b>Status Menu</b></label>
                                 <select name="status_aktif" id="" class="form-control select2" required>
                                     <option value="">Pilih Status Menu</option>
                                     <option value="1" <?php if ($menu_by_id['status_aktif'] == '1') : ?>selected<?php endif; ?>>Aktif</option>
                                     <option value="0" <?php if ($menu_by_id['status_aktif'] == '0') : ?>selected<?php endif; ?>>Nonaktif</option>
                                 </select>
                                 <small class="text-danger pl-2">Wajib diisi</small>
                             </div>
                         </div>
                         <div class="row">
                             <div class="col" id="menu_induk_edit">
                                 <label class="col-form-label"><b>Menu Induk</b></label>
                                 <select name="menu_induk" id="" class="form-control select2">
                                     <option value="">Pilih Menu Induk</option>
                                     <?php foreach ($menu_induk as $mi) : ?>
                                         <option value="<?= $mi['menu_id'] ?>" <?php if ($menu_by_id['menu_induk'] == $mi['menu_id']) : ?>selected<?php endif; ?>><?= $mi['menu_judul'] ?></option>
                                     <?php endforeach; ?>
                                 </select>
                                 <small class="text-danger pl-2">Wajib diisi</small>
                             </div>
                             <div class="col">
                                 <label class="col-form-label"><b>Icon Menu</b></label>
                                 <input type="text" id="" value="<?= $menu_by_id['menu_icon']?>" name="menu_icon" class="form-control" placeholder="Icon Menu" required>
                                 <small class="text-danger pl-2">Wajib diisi</small>
                             </div>
                             <div class="col">
                                 <label class="col-form-label"><b>Status Tampil</b></label>
                                 <select name="status_tampil" id="" class="form-control select2" required>
                                     <option value="">Pilih Status Tampil</option>
                                     <option value="1" <?php if ($menu_by_id['status_tampil'] == '1') : ?>selected<?php endif; ?>>Tampil</option>
                                     <option value="0" <?php if ($menu_by_id['status_tampil'] == '0') : ?>selected<?php endif; ?>>Sembunyikan</option>
                                 </select>
                                 <small class="text-danger pl-2">Wajib diisi</small>
                             </div>
                         </div>
                         <div class="row">
                             <div class="col">
                                 <label class="col-form-label"><b>Deskripsi Menu</b></label>
                                 <textarea class="form-control" id="exampleFormControlTextarea1" name="menu_deskripsi" rows="3" required><?= $menu_by_id['menu_deskripsi'] ?></textarea>
                                 <small class="text-danger pl-2">Wajib diisi</small>
                             </div>
                         </div>

                         <div class="modal-footer">
                             <button type="submit" class="btn btn-primary">Simpan Data Menu</button>
                             <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                         </div>
                     </form>
                 </div>
             </div>
         </div>
         <!-- /.container-fluid -->
     </div>


 </div>

 <script src="<?= base_url('assets/'); ?>vendor/jquery/jquery.min.js"></script>
 <script type="text/javascript">
     //  Kondisi Menu Level
     console.log($("#kode_menu_level").val())
     if ($("#kode_menu_level").val() == 'submenu') {
         $('#menu_induk_edit').show();
     } else if ($("#kode_menu_level").val() == 'induk') {
         $('#menu_induk_edit').hide();
     } else if ($("#kode_menu_level").val() == 'tunggal') {
         $('#menu_induk_edit').hide();
     }

     function set_menu_level_edit(e) {
         switch (e.value) {
             case "":
                 $('#menu_induk_edit').hide();
                 break;
             case "tunggal":
                 $('#menu_induk_edit').hide();
                 break;
             case "submenu":
                 $('#menu_induk_edit').show();
                 break;
             case "induk":
                 $('#menu_induk_edit').hide();
                 break;

         }
     }

     // Select 2
     $(document).ready(function() {
         $(".select2").select2({
             theme: 'bootstrap4',
         });
     });
 </script>