<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Forgot Password">

    <title><?= esc($title ?? 'Forgot Password') ?></title>

    <link rel="shortcut icon" type="image/x-icon" href="<?= base_url('assets/media/favicon.png') ?>">

    <link rel="stylesheet" href="<?= base_url('assets/vendor/bootstrap/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/vendor/fontawesome/font-awesome.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/vendor/slickslider/slick.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/vendor/jquery-magnific-popup/jquery.magnific-popup.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/vendor/animate/animate.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/vendor/odometer/odometer.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/vendor/nice-select/nice-select.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/app.css') ?>">
    <style>
        h1, .h1 { font-size: 61px; }
        h2, .h2 { font-size: 47px; }
        h3, .h3 { font-size: 36px; }
        h4, .h4 { font-size: 27px; }
        h5, .h5 { font-size: 21px; }
        h6, .h6 { font-size: 16px; }

        html, body { height: 100%; overflow: hidden; }
        #main-wrapper { min-height: 100vh; }
        .form_page { padding-top: 60px; padding-bottom: 60px; min-height: 100vh; overflow: hidden; }
    </style>
</head>

<body>
    <div id="main-wrapper" class="main-wrapper">
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

        <section class="form_page">
            <div class="container">
                <div class="row">
                    <div class="col-xl-6">
                        <div class="form_block">
                            <div class="text_block">
                                <br><br><br><br>
                                <a href="<?= base_url(); ?>" class="educate_link_btn color-primary h6 mb-48"><i class="far fa-chevron-left"></i> Back To Home</a>
                                <div class="title">
                                    <img src="<?= base_url('assets/media/shapes/mic-speaker.png') ?>" alt="" class="speaker_icon">
                                    <h2 class="mb-48">Forgot Password</h2>
                                </div>

                                <?php if (session()->getFlashdata('message')): ?>
                                    <div class="alert alert-info mb-24"><?= esc(session()->getFlashdata('message')) ?></div>
                                <?php endif; ?>
                                <?php if (session()->getFlashdata('errors')): ?>
                                    <div class="alert alert-danger mb-24">
                                        <ul class="mb-0">
                                            <?php foreach (session()->getFlashdata('errors') as $e): ?>
                                                <li><?= esc($e) ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                <?php endif; ?>

                                <form method="post" action="<?= base_url('forgot') ?>" class="form-validator">
                                    <?= csrf_field() ?>
                                    <div class="mb-24">
                                        <input type="email" class="form-control p_lg" name="email" required placeholder="Email">
                                    </div>
                                    <button type="submit" class="b-unstyle educate-btn w-100 mb-24"><span class="educate-btn__curve"></span>Send Reset Link</button>
                                </form>
                                <div class="bottom-row mt-3">
                                    <h6>Remembered your password? <a href="<?= base_url('login/student') ?>" class="color-primary">Login</a></h6>
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
    </div>

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
    <script src="<?= base_url('assets/js/app.js') ?>"></script>
</body>

</html>





