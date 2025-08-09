<!doctype html>
<html lang="en">
  
<!-- Mirrored from onekit.madethemes.com/index-course.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 28 Feb 2022 11:13:04 GMT -->
<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Title  -->
    <title><?php if (isset($title)) {echo $title;  } ?>
    </title>
    <meta name="description" content="Bootstrap 5 landing page template with flat design and fast loading. Create great website with Onekit landing page template.">

    <!--Plugins Styles-->
    <link rel="stylesheet" href="<?php echo base_url('src/plugins/aos/dist/aos.css') ?>">
    <link rel="stylesheet" href="<?php echo base_url('src/plugins/lightgallery.js/dist/css/lightgallery.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('src/plugins/flickity/dist/flickity.min.css'); ?>"> 

    <!--Styles-->
    <link rel="stylesheet" href="<?php echo base_url('src/css/theme.css'); ?>">

    <!-- Css Optimize -->
    <!-- <link rel="stylesheet" href="dist/css/bundle.min.css"> -->

    <!-- PWA Optimize -->
    <link rel="manifest" href="src/js/pwa/manifest.json">
    <!-- <link rel="canonical" href="https://onekit.madethemes.com"> -->
    <meta name="theme-color" content="#5b2be0">
    <link rel="apple-touch-icon" href="<?php echo base_url('src/img-min/logo/apple-icon.png'); ?>">

    <!-- google font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&amp;display=swap" rel="stylesheet">

    <!-- Favicon  -->
    <link rel="icon" href="<?php echo base_url('src/img-min/logo/favicon.png'); ?>">
  </head>

  <body id="top">
    <!--Skippy-->
   
  
    <!-- progress scroll -->
    <progress id="progress-bar" class="progress-one" max="100">
      <span class="progress-container">
        <span class="progress-bar"></span>
      </span>
    </progress>
    
    <!-- ========== { HEADER }==========  -->
    <header>
      <!-- Navbar -->
      <nav class="main-nav navbar navbar-expand-lg hover-navbar dark-to-light fixed-top navbar-dark">
        <div class="container">
          <a class="navbar-brand main-logo" href="<?php echo base_url(); ?>">
            <!-- <span class="h2 text-white fw-bold mt-2">Onekit</span> -->
            <img class="logo-light" src="<?= base_url('src/img-min/logo/logo-light.png'); ?>" alt="LOGO">
            <img class="logo-dark" src="<?php echo base_url('src/img-min/logo/logo.png'); ?>" alt="LOGO">
          </a>

          <!-- navbar toggler -->
          <button class="navbar-toggler" type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarTogglerDemo"
            aria-controls="navbarTogglerDemo"
            aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

          <!-- collapse menu -->
          <div class="collapse navbar-collapse" id="navbarTogglerDemo">
            <ul class="navbar-nav ms-auto mt-2 mt-lg-0">
              <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url(); ?>" aria-expanded="false" >
                  Home
                </a>
                
              </li>

              <!--dropdown submenu-->
              <li class="nav-item">
                <a class="nav-link"  href="<?php echo base_url('home/about_us'); ?>"  aria-expanded="false">About Us</a>
                
              </li>

              <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url('home/how_it_works'); ?>">How It Works</a>
              </li>


              <li class="nav-item">
                <a class="nav-link" href="<?php echo base_url('home/pricing'); ?>">Pricing</a>
              </li>b
            </ul>
            <div class="d-grid d-lg-block my-3 my-lg-0 ms-0 ms-lg-4">
              <a class="btn btn-warning btn-sm" target="_blank" rel="noopener" href="<?php echo base_url('home/order_now'); ?>">
                
                Order Now
              </a>
            </div>
          </div><!-- end collapse menu -->
        </div>
      </nav><!-- End Navbar -->
    </header><!-- end header -->