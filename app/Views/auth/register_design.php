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
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <style>
        /* Restore original heading sizes for auth pages */
        h1, .h1 { font-size: 61px; }
        h2, .h2 { font-size: 47px; }
        h3, .h3 { font-size: 36px; }
        h4, .h4 { font-size: 27px; }
        h5, .h5 { font-size: 21px; }
        h6, .h6 { font-size: 16px; }

        html, body { min-height: 100%; }
        body.register-auth { background: #f5f8fb; }
        body.register-auth header { display: none; }
        #main-wrapper { min-height: 100vh; }
        .register-page.form_page {
            min-height: 100vh;
            padding: 34px 0;
            background: linear-gradient(180deg, #f7fbfd 0%, #eef6fa 100%);
        }
        .register-shell {
            min-height: calc(100vh - 68px);
            align-items: stretch;
        }
        .register-card {
            width: 100%;
            max-width: 520px;
            height: auto !important;
            display: block !important;
            align-content: unset !important;
            margin: 0 auto;
            padding: 32px;
            border: 1px solid #dbe7ee;
            border-radius: 10px;
            background: #fff;
            box-shadow: 0 18px 45px rgba(15, 23, 42, .08);
        }
        .auth-brand {
            display: inline-flex;
            align-items: center;
            margin-bottom: 22px;
        }
        .auth-brand img {
            width: 154px;
            height: auto;
        }
        .register-card .title {
            width: auto !important;
            margin-bottom: 24px;
        }
        .register-card .title h2 {
            margin: 0 0 8px !important;
            color: #071327;
            font-size: 36px;
            line-height: 1.12;
            font-weight: 800;
        }
        .register-card .title p {
            margin: 0;
            color: #64748b;
            font-size: 15px;
            line-height: 1.55;
        }
        .register-card .speaker_icon,
        .register-card .shapes {
            display: none !important;
        }
        .register-card .text-muted.my-3 {
            position: relative;
            margin: 18px 0 !important;
            color: #64748b !important;
            font-size: 14px;
        }
        .register-card .text-muted.my-3::before,
        .register-card .text-muted.my-3::after {
            content: "";
            position: absolute;
            top: 50%;
            width: 42%;
            height: 1px;
            background: #e2e8f0;
        }
        .register-card .text-muted.my-3::before { left: 0; }
        .register-card .text-muted.my-3::after { right: 0; }
        .register-card .form-control.p_lg {
            height: 56px;
            padding: 0 18px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            color: #0f172a;
            font-size: 15px;
            box-shadow: none;
        }
        .register-card .form-control.p_lg:focus {
            border-color: #1680a6;
            box-shadow: 0 0 0 4px rgba(22, 128, 166, .12);
        }
        .policy-consent {
            display: flex;
            gap: 12px;
            align-items: flex-start;
            padding: 13px 14px;
            border: 1px solid #dbe7ee;
            border-radius: 8px;
            background: #f8fafc;
            color: #475569;
            font-size: 14px;
            line-height: 1.5;
        }
        .policy-consent input {
            width: 18px;
            height: 18px;
            margin-top: 2px;
            flex: 0 0 auto;
        }
        .policy-consent a {
            color: #1680a6;
            font-weight: 700;
            text-decoration: underline;
            text-underline-offset: 2px;
        }
        .register-card .educate-btn {
            min-height: 54px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 800;
        }
        .register-card .bottom-row {
            justify-content: center !important;
            text-align: center;
        }
        .register-card .bottom-row h6 {
            margin: 0;
            color: #475569;
            font-size: 15px;
            font-weight: 500;
        }
        .register-card .bottom-row a {
            color: #1680a6;
            font-weight: 800;
        }
        .register-side {
            display: flex;
            align-items: flex-start;
            justify-content: flex-start;
            min-height: 100%;
            padding: 42px;
            border-radius: 10px;
            background:
                linear-gradient(135deg, rgba(8, 71, 101, .92), rgba(25, 151, 185, .88)),
                url("<?= base_url('assets/images/nclexnursingtutoring.webp') ?>");
            background-size: cover;
            background-position: center;
            color: #fff;
            overflow: hidden;
        }
        .register-side__inner {
            align-self: flex-start;
            max-width: 470px;
            padding-top: 4px;
        }
        .register-side__eyebrow {
            margin: 0 0 12px;
            color: #f8c33b;
            font-size: 13px;
            font-weight: 900;
            text-transform: uppercase;
        }
        .register-side h1 {
            margin: 0 0 16px;
            color: #fff;
            font-size: clamp(34px, 4vw, 54px);
            line-height: 1.05;
            font-weight: 800;
        }
        .register-side p {
            margin: 0 0 24px;
            color: rgba(255,255,255,.86);
            font-size: 17px;
            line-height: 1.65;
        }
        .register-benefits {
            display: grid;
            gap: 12px;
            margin: 0;
            padding: 0;
            list-style: none;
        }
        .register-benefits li {
            display: flex;
            gap: 10px;
            align-items: center;
            color: rgba(255,255,255,.94);
            font-weight: 700;
        }
        .register-benefits i {
            color: #f8c33b;
        }
        @media (max-width: 1199px) {
            .register-side { display: none; }
            .register-shell { justify-content: center; }
        }
        @media (max-width: 575px) {
            .register-page.form_page { padding: 18px 0 30px; }
            .register-card { padding: 24px 18px; }
            .auth-brand img { width: 140px; }
            .register-card .title h2 { font-size: 31px; }
            .register-card .text-muted.my-3::before,
            .register-card .text-muted.my-3::after { width: 38%; }
        }
    </style>
</head>

<body class="register-auth">
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
      
        <section class="form_page register-page">
            <div class="container">
                <div class="row register-shell g-4">
                    <div class="col-xl-5 col-lg-8 col-md-10">
                        <div class="form_block register-card">
                            <div class="text_block">
                                <a href="<?= base_url(); ?>" class="auth-brand">
                                    <img src="<?= base_url('assets/media/logo.png'); ?>" alt="NCLEX Prep Course">
                                </a>
                                <div class="title">
                                    <img src="<?= base_url('assets/media/shapes/mic-speaker.png') ?>" alt="" class="speaker_icon">
                                    <h2>Create Account</h2>
                                    <p>Start your NCLEX prep with practice tests, study notes, and guided review tools.</p>
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

                                <?php
                                    $productIntent = (string) ($productIntent ?? old('product') ?? '');
                                    $googleSignupUrl = base_url('oauth/google') . '?context=register';
                                    if ($productIntent !== '') {
                                        $googleSignupUrl .= '&product=' . rawurlencode($productIntent);
                                    }
                                ?>
                                <a href="<?= esc($googleSignupUrl) ?>" class="link-btn h6 mb-24">
                                    <img src="<?= base_url('assets/media/icons/brands/google.png') ?>" alt="">
                                    Sign up with Google
                                </a>
                                <div class="text-center my-3 text-muted">or</div>

                                <form method="post" action="<?= base_url('register') ?>" class="form-validator">
                                    <?= csrf_field() ?>
                                    <?php if ($productIntent !== ''): ?>
                                        <input type="hidden" name="product" value="<?= esc($productIntent) ?>">
                                    <?php endif; ?>
                                    <div class="mb-24">
                                        <input type="text" class="form-control p_lg" name="first_name" value="<?= esc(old('first_name')) ?>" required placeholder="First name">
                                    </div>
                                    <div class="mb-24">
                                        <input type="email" class="form-control p_lg" name="email" value="<?= esc(old('email')) ?>" required placeholder="Email">
                                    </div>
                                    <div class="mb-24">
                                        <input type="password" class="form-control p_lg" name="password" required placeholder="Password">
                                    </div>
                                    <div class="mb-24">
                                        <label class="policy-consent">
                                            <input
                                                type="checkbox"
                                                name="terms_agreement"
                                                value="1"
                                                <?= old('terms_agreement') ? 'checked' : '' ?>
                                                required
                                            >
                                            <span>
                                                I agree to the
                                                <a href="<?= base_url('terms') ?>" target="_blank" rel="noopener">Terms and Conditions</a>
                                                and
                                                <a href="<?= base_url('refund_policy') ?>" target="_blank" rel="noopener">Refund Policy</a>.
                                            </span>
                                        </label>
                                    </div>
                                    <div class="mb-24">
                                        <?php $siteKey = env('RECAPTCHA_SITE_KEY'); ?>
                                        <?php if (!empty($siteKey)): ?>
                                        <div class="g-recaptcha" data-sitekey="<?= esc($siteKey) ?>"></div>
                                        <?php else: ?>
                                        <div class="text-muted small">reCAPTCHA not configured. Set RECAPTCHA_SITE_KEY in .env</div>
                                        <?php endif; ?>
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
                    <div class="col-xl-7 d-none d-xl-block">
                        <aside class="register-side">
                            <div class="register-side__inner">
                                <p class="register-side__eyebrow">NCLEX Prep Course</p>
                                <h1>Practice smarter before exam day.</h1>
                                <p>Build confidence with question banks, mock exams, rationales, notes, and progress tracking in one student dashboard.</p>
                                <ul class="register-benefits">
                                    <li><i class="fas fa-check-circle"></i><span>NCLEX-style practice questions</span></li>
                                    <li><i class="fas fa-check-circle"></i><span>Study notes and downloadable resources</span></li>
                                    <li><i class="fas fa-check-circle"></i><span>Performance insights after every test</span></li>
                                </ul>
                            </div>
                        </aside>
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
