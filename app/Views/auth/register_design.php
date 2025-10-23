<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Create Account">

    <title><?= esc($title ?? 'Create Account') ?></title>

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
                                <br>
                                <a href="<?= base_url(); ?>" class="educate_link_btn color-primary h6 mb-48"><i class="far fa-chevron-left"></i> Back To Home</a>
                                <div class="title">
                                    <img src="<?= base_url('assets/media/shapes/mic-speaker.png') ?>" alt="" class="speaker_icon">
                                    <h2 class="mb-48">Create Account</h2>
                                </div>

                                <?php if (session()->getFlashdata('errors')): ?>
                                    <div class="alert alert-danger">
                                        <ul class="mb-0">
                                            <?php foreach (session()->getFlashdata('errors') as $e): ?>
                                                <li><?= esc($e) ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                <?php endif; ?>

                                <div id="g_id_onload"
                                     data-client_id="<?= esc(getenv('GOOGLE_CLIENT_ID')) ?>"
                                     data-context="signup"
                                     data-ux_mode="popup"
                                     data-callback="onGoogleCredential"
                                     data-auto_prompt="false">
                                </div>
                                <div class="g_id_signin mb-3" data-type="standard" data-shape="pill" data-theme="outline" data-text="signup_with" data-size="large" data-logo_alignment="left"></div>
                                <div class="text-center my-3 text-muted">or</div>

                                <form method="post" action="<?= base_url('register') ?>" class="form-validator">
                                    <?= csrf_field() ?>
                                    <div class="mb-24">
                                        <input type="text" class="form-control p_lg" name="first_name" value="<?= esc(old('first_name')) ?>" required placeholder="First name">
                                    </div>
                                    <div class="mb-24">
                                        <input type="email" class="form-control p_lg" name="email" value="<?= esc(old('email')) ?>" required placeholder="Email">
                                    </div>
                                    <div class="mb-24">
                                        <input type="password" class="form-control p_lg" name="password" required placeholder="Password">
                                    </div>
                                    <button type="submit" class="b-unstyle educate-btn w-100 mb-24"><span class="educate-btn__curve"></span>Create Account</button>
                                </form>
                                <div class="bottom-row mt-3">
                                    <h6>Already have an account? <a href="<?= base_url('login/student') ?>" class="color-primary">Login</a></h6>
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
    <script src="https://accounts.google.com/gsi/client" async defer></script>
    <script>
        function onGoogleCredential(response) {
            $.post('<?= base_url('oauth/google') ?>', { credential: response.credential })
                .done(function(res) {
                    if (res && res.redirect) {
                        window.location = res.redirect;
                    } else {
                        window.location = '<?= base_url('client/subscription') ?>';
                    }
                })
                .fail(function() {
                    alert('Google sign-in failed. Please try again.');
                });
        }
    </script>
</body>

</html>


