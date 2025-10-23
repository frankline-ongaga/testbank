<!DOCTYPE html>
<html lang="zxx">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="<?php if(isset($description)){ echo $description; } ?>">

  <title><?php if(isset($title)){ echo $title; } ?></title>

  <!-- Favicon -->
  <link rel="shortcut icon" type="image/x-icon" href="assets/media/favicon.png">

  <!-- All CSS files -->
  <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="<?php echo base_url('assets/vendor/slickslider/slick.css'); ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/vendor/jquery-magnific-popup/jquery.magnific-popup.css'); ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/vendor/animate/animate.min.css'); ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/css/app.css'); ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/css/course.css'); ?>">
  <link rel="stylesheet" href="<?php echo base_url('static/css/mystyle.css'); ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/css/mystyle.css'); ?>">


  <style>
    /* Hide sticky header placeholder to remove gap above hero */
    .stricky-header { display: none !important; }

    /* Make header overlay the hero (transparent over top) */
    header { position: absolute; top: 0; left: 0; right: 0; z-index: 1000; background: transparent !important; }
    /* Sticky on scroll */
    header.fixed-header { position: fixed; top: 0; left: 0; right: 0; background: #ffffff !important; box-shadow: 0 2px 12px rgba(0,0,0,0.06); }
    .main-wrapper.has-header-offset { padding-top: 84px !important; }
    .main-menu, .main-menu__block { background: transparent !important; }
    .main-menu__block { padding-top: 8px; padding-bottom: 8px; }
    /* Ensure hero sits at the very top */
    .hero-banner-1 { margin-top: 0 !important; padding-top: 0 !important; }
    .hero-banner-1 .container { padding-top: 0 !important; margin-top: 0 !important; }
    .hero-banner-1 .content, .hero-banner-1 .text_block { margin-top: 0 !important; }
    /* Add breathing room under the transparent header */
    .hero-banner-1 .content .text_block { padding-top: 96px !important; }
    #main-wrapper { margin-top: 0 !important; }
    /* Force-remove any top padding set via CSS vars */
    .main-wrapper { padding-top: 0 !important; }
    .main-menu { box-shadow: none !important; margin: 0 !important; }
  </style>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      var headerEl = document.querySelector('header');
      var wrapperEl = document.getElementById('main-wrapper');
      if (!headerEl || !wrapperEl) return;
      function syncSticky() {
        if (window.scrollY > 10) {
          headerEl.classList.add('fixed-header');
          wrapperEl.classList.add('has-header-offset');
        } else {
          headerEl.classList.remove('fixed-header');
          wrapperEl.classList.remove('has-header-offset');
        }
      }
      syncSticky();
      window.addEventListener('scroll', syncSticky, { passive: true });
    });
  </script>
  </style>

   
        <script type="text/javascript">
          var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
          (function(){
          var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
          s1.async=true;
          s1.src='https://embed.tawk.to/5c95e820101df77a8be41012/default';
          s1.charset='UTF-8';
          s1.setAttribute('crossorigin','*');
          s0.parentNode.insertBefore(s1,s0);
          })();
          </script>

</head>

<body class="custom-cursor locked">

  <!-- cursor style  -->
  <div class="custom-cursor__cursor"></div>
  <div class="custom-cursor__cursor-two"></div>

  <!-- Preloader-->
  <!-- <div id="preloader">
    <div class="book">
      <div class="inner">
        <div class="left"></div>
        <div class="middle"></div>
        <div class="right"></div>
      </div>
      <ul>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
      </ul>
    </div>
  </div> -->

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
                  <img src="<?= base_url('assets/media/logo.png'); ?>" alt="Educate">
                </a>
              </div>

              <div class="main-menu__nav">
                <ul class="main-menu__list">
                    <li><a href="<?php echo base_url(); ?>" class="active">Home</a></li>

                     <li><a href="<?php echo base_url('how_it_works'); ?>">How It Works</a></li>

                     <li> <a href="<?php echo base_url('pricing'); ?>">Pricing</a> </li>

                     <li> <a href="<?php echo base_url('reviews'); ?>">Reviews</a> </li>



             
                </ul>
              </div>
            </div>
            <div class="main-menu__right">
              
              <a href="<?php echo base_url('login/student'); ?>" class="educate-btn sec"><span class="educate-btn__curve"></span>Account </a>
              <a href="<?php echo base_url('register'); ?>" class="educate-btn d-xl-flex d-none"><span
                  class="educate-btn__curve"></span>Get Started</a>
              <a href="#" class="main-menu__toggler mobile-nav__toggler">
                <i class="fa fa-bars"></i>
              </a>
            </div>
          </div>
        </div>
      </nav>
    </header>
    <!-- Sticky Header -->
    <div class="stricky-header stricked-menu main-menu">
      <div class="sticky-header__content"></div>
    </div>
    <!-- Header Area End  -->