<div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5 col-lg-7 mx-auto">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-1"><?= $portal ?></h1>
                            <h2 class="h4 text-gray-900 mb-4">Buat Akun Baru !</h2>
                        </div>
                        <form class="user" method="post" action="<?= base_url('auth/register') ?>">
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" id="user_alias" name="user_alias" value="<?= set_value('user_alias') ?>" placeholder="Nama Lengkap">
                                <?= form_error('user_alias', '<small class="text-danger pl-3">', '</small>') ?>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" id="user_nama" name="user_nama" value="<?= set_value('user_nama') ?>" placeholder="Username">
                                <?= form_error('user_nama', '<small class="text-danger pl-3">', '</small>') ?>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" id="user_mail" name="user_mail" value="<?= set_value('user_mail') ?>" placeholder="Email">
                                <?= form_error('user_mail', '<small class="text-danger pl-3">', '</small>') ?>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="password" class="form-control form-control-user" id="user_pass" name="user_pass" placeholder="Password">
                                    <?= form_error('user_pass', '<small class="text-danger pl-3">', '</small>') ?>
                                </div>
                                <div class="col-sm-6">
                                    <input type="password" class="form-control form-control-user" id="confirm_pass" name="confirm_pass" placeholder="Konfirmasi Password">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-user btn-block">
                                Daftar Akun Sekarang
                            </button>
                        </form>
                        <hr>
                        <div class="text-center">
                            <a class="small" href="<?= base_url('auth/lupa_password') ?>">Lupa Password?</a>
                        </div>
                        <div class="text-center">
                            <a class="small" href="<?= base_url('auth'); ?>">Sudah Memiliki Akun ? Login Sekarang !</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>