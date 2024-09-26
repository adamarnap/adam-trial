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
                                    <h1 class="h4 text-gray-900 mb-1"><?= $portal ?></h1>
                                    <h2 class="h4 text-gray-900 mb-4">Pemulihan Password</h2>
                                </div>
                                <!-- Alert -->
                                <?= $this->session->flashdata('message') ?>

                                <form class="user" action="<?= base_url('auth/lupa_password') ?>" method="post">
                                    <div class="form-group">
                                        <input type="email" class="form-control form-control-user" id="user_mail" name="user_mail" value="<?= set_value('user_mail') ?>" placeholder="Masukkan email terdaftar">
                                        <?= form_error('user_mail', '<small class="text-danger pl-3">', '</small>') ?>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-user btn-block">
                                        Pulihkan Password
                                    </button>

                                </form>
                                <hr>
                                <div class="text-center">
                                    <a class="small" href="<?= base_url('auth'); ?>">Sudah Memiliki Akun ? Login Sekarang !</a>
                                </div>
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