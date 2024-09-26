<div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

        <div class="col-lg-7">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">

                        <div class="col-lg">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900"><?= $portal ?></h1>
                                    <h2 class="h4 text-gray-900 mb-1">Formulir Ubah Password Untuk Email</h2>
                                    <h5 class="h4 text-gray-900 mb-4"><?= $this->session->userdata('data_email_reset_password') ?></h5>
                                </div>
                                <!-- Alert -->
                                <?= $this->session->flashdata('message') ?>

                                <form class="user" action="<?= base_url('auth/ubahPassword') ?>" method="post">
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user" id="user_pass" name="user_pass" value="<?= set_value('user_pass') ?>" placeholder="Masukkan Password Baru">
                                        <?= form_error('user_pass', '<small class="text-danger pl-3">', '</small>') ?>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user" id="confirm_pass" name="confirm_pass" value="<?= set_value('confirm_pass') ?>" placeholder="Konfirmasi Password Baru">
                                        <?= form_error('confirm_pass', '<small class="text-danger pl-3">', '</small>') ?>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-user btn-block">
                                        Rubah Password Sekarang
                                    </button>

                                </form>
                                <hr>
                                <div class="text-center">
                                    <a href="<?= base_url('auth/register') ?>" class="small" href="register.html">Belum Memiliki Akun ? Buat Akun Sekarang.</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>