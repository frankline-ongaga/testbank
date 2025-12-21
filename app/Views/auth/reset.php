<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Reset Password">

    <title>Reset Password</title>

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url('assets/images/fav/apple-touch-icon.png'); ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url('assets/images/fav/favicon-32x32.png'); ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('assets/images/fav/favicon-16x16.png'); ?>">
    <link rel="manifest" href="/site.webmanifest">
    <!-- All CSS files -->
    <link rel="stylesheet" href="<?= base_url('assets/vendor/bootstrap/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/vendor/fontawesome/font-awesome.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/vendor/slickslider/slick.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/vendor/jquery-magnific-popup/jquery.magnific-popup.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/vendor/animate/animate.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/vendor/odometer/odometer.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/vendor/nice-select/nice-select.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/app.css') ?>">

    <style>
        /* Restore original heading sizes for auth pages */
        h1, .h1 { font-size: 61px; }
        h2, .h2 { font-size: 47px; }
        h3, .h3 { font-size: 36px; }
        h4, .h4 { font-size: 27px; }
        h5, .h5 { font-size: 21px; }
        h6, .h6 { font-size: 16px; }

        html, body { min-height: 100%; }
        #main-wrapper { min-height: 100vh; }
        .form_page { padding-top: 60px; padding-bottom: 60px; min-height: 100vh; }
    </style>

</head>

<body>
    <!-- Main Wrapper Start -->
    <div id="main-wrapper" class="main-wrapper">
        <!-- Header Area start -->
        <header>
            <nav class="main-menu">
                <div class="container">
                    <div class="main-menu__block">
                        <div class="main-menu__left">
                            <div class="main-menu__logo">
                                <a href="<?= base_url(); ?>">
                                    <img src="<?= base_url('assets/media/logo.png'); ?>" alt="NCLEX Prep Course">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </header>
        
        <!-- Header Area End  -->
        <!-- Reset Password Area Start -->
        <section class="form_page">
            <div class="container">
                <div class="row">
                    <div class="col-xl-6">
                        <div class="form_block">
                            <div class="text_block">
                                <br> <br> <br> <br>
                                <a href="<?= base_url(); ?>" class="educate_link_btn color-primary h6 mb-48"><i
                                        class="far fa-chevron-left"></i> Back To Home</a>
                                <div class="title">
                                    <img src="<?= base_url('assets/media/shapes/mic-speaker.png') ?>" alt="" class="speaker_icon">
                                <h2 class="mb-48">Reset Password</h2>
                                </div>
                                <?php if (session()->getFlashdata('error')): ?>
                                <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
                                <?php endif; ?>
                                <?php if (session()->getFlashdata('message')): ?>
                                <div class="alert alert-success"><?= esc(session()->getFlashdata('message')) ?></div>
                                <?php endif; ?>
                                <?php if (session()->getFlashdata('errors')): ?>
                                    <div class="alert alert-danger">
                                        <ul class="mb-0">
                                            <?php foreach (session()->getFlashdata('errors') as $e): ?>
                                                <li><?= esc($e) ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                <?php endif; ?>
                                <div class="text-center">
                                    <h6 class="mb-24">Enter your new password</h6>
                                </div>
                                <form method="post" action="<?= base_url('reset/' . esc($token)) ?>" class="form-validator">
                                    <?= csrf_field() ?>
                                    <div class="mb-24">
                                        <input type="password" class="form-control p_lg" id="reset-password"
                                            name="password" required placeholder="New Password">
                                    </div>
                                    <button type="submit" class="b-unstyle educate-btn w-100 mb-24"><span
                                            class="educate-btn__curve"></span>Reset Password</button>
                                </form>
                                <div class="bottom-row">
                                    <h6><a href="<?= base_url('login/student') ?>" class="color-primary">Back to Login</a></h6>
                                </div>
                            </div>
                            <div class="shapes">
                                <img src="<?= base_url('assets/media/shapes/vector-9.png') ?>" alt="">
                                <img src="<?= base_url('assets/media/shapes/vector-8.png') ?>" alt="">
                                <img src="<?= base_url('assets/media/shapes/circle-lines-3.png') ?>" alt="">
                                <img src="<?= base_url('assets/media/shapes/location.png') ?>" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>
        <!-- Reset Password Area End -->
    </div>

    <!-- Jquery Js -->
    <script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= base_url('assets/vendor/jquery/jquery-3.6.3.min.js') ?>"></script>
    <script src="<?= base_url('assets/vendor/jquery-appear/jquery-appear.js') ?>"></script>
    <script src="<?= base_url('assets/vendor/jquery-validator/jquery-validator.js') ?>"></script>
    <script src="<?= base_url('assets/vendor/odometer/odometer.min.js') ?>"></script>
    <script src="<?= base_url('assets/vendor/countdown/jquery.countdown.min.js') ?>"></script>
    <script src="<?= base_url('assets/vendor/jquery-magnific-popup/jquery.magnific-popup.min.js') ?>"></script>
    <script src="<?= base_url('assets/vendor/slickslider/slick.min.js') ?>"></script>
    <script src="<?= base_url('assets/vendor/tilt/tilt.jquery.js') ?>"></script>
    <script src="<?= base_url('assets/vendor/nice-select/jquery.nice-select.min.js') ?>"></script>
    <script src="<?= base_url('assets/vendor/wow/wow.js') ?>"></script>

    <!-- Site Scripts -->
    <script src="<?= base_url('assets/js/app.js') ?>"></script>
</body>

</html>
