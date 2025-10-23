<section class="form_page" style="margin-top:96px;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-8">
                <div class="form_block">
                    <div class="text_block">
                        <a href="<?= base_url(); ?>" class="educate_link_btn color-primary h6 mb-48"><i class="far fa-chevron-left"></i> Back To Home</a>
                        <div class="title">
                            <img src="<?= base_url('assets/media/shapes/mic-speaker.png'); ?>" alt="" class="speaker_icon">
                            <h2 class="mb-48"><?= esc($title ?? 'Login') ?></h2>
                        </div>

                        <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
                        <?php endif; ?>
                        <?php if (session()->getFlashdata('message')): ?>
                        <div class="alert alert-success"><?= esc(session()->getFlashdata('message')) ?></div>
                        <?php endif; ?>

                        <div class="text-center">
                            <h6 class="mb-24">Login with your email address</h6>
                        </div>
                        <form method="post" action="<?= esc($loginAction ?? '/login/student') ?>" class="form-validator">
                            <?= csrf_field() ?>
                            <div class="mb-24">
                                <input type="email" class="form-control p_lg" id="login-email" name="email" required placeholder="Email">
                            </div>
                            <div class="mb-24">
                                <input type="password" class="form-control p_lg" id="login-password" name="password" required placeholder="Password">
                            </div>
                            <button type="submit" class="b-unstyle educate-btn w-100 mb-24"><span class="educate-btn__curve"></span>Login</button>
                        </form>
                        <div class="bottom-row d-flex justify-content-between">
                            <h6>Don’t have an account? <a href="<?= base_url('register') ?>" class="color-primary">Register</a></h6>
                            <h6><a href="<?= base_url('forgot') ?>" class="color-primary">Forgot Password?</a></h6>
                        </div>

                        <?php if (session()->getFlashdata('errors')): ?>
                            <ul class="text-danger mt-3">
                                <?php foreach (session()->getFlashdata('errors') as $e): ?>
                                    <li><?= esc($e) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </div>
                    <div class="shapes">
                        <img src="<?= base_url('assets/media/shapes/vector-9.png'); ?>" alt="">
                        <img src="<?= base_url('assets/media/shapes/vector-8.png'); ?>" alt="">
                        <img src="<?= base_url('assets/media/shapes/circle-lines-3.png'); ?>" alt="">
                        <img src="<?= base_url('assets/media/shapes/location.png'); ?>" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

