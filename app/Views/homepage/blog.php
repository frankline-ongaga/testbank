<main>
        <!-- Page Title -->
        <section class="page-heading parallax effect-section" style="background-image: url(static/img/bg-banner-1.jpg);">
            <div class="mask bg-dark-gradient opacity-8"></div>
            <div class="container position-relative">
                <h1 class="display-6 text-white mb-3">Blog</h1>
                <ol class="breadcrumb light m-0">
                    <li class="breadcrumb-item"><a class="text-reset" href="<?php echo base_url(); ?>"><i class="bi bi-house-fill"></i> Home</a></li>
                    <li class="breadcrumb-item active text-white-50" aria-current="page">Blog </li>
                </ol>
            </div>
        </section>
        <!-- End Page Title -->
        <!-- End Page Title -->
        <!-- Section -->
        <section class="section">
            <div class="container">
                <div class="row">
                  <div class="col-md-9">
                    <div class="row">
                    <?php 
           // echo $h->num_rows();
                        foreach($h->result() as $row){ ?>

                    <div class="col-md-6 mb-5">
                        <div class="hover-top card shadow-only-hover">
                           
                            <div class="card-body">
                                <h5 class="mb-3"><a class="text-dark stretched-link" href="<?php echo base_url() ?>blog/<?php echo $row->post_name; ?>"> <?php
                                              echo  $row->post_title;
                                              ?></a></h5>
                                <p> 
                                      <?php
                                           echo $row->post_excerpt;
                                      ?>
                                          
                                      </p>
                                <div class="nav small border-top pt-3">
                                  
                                    <a class="text-body font-w-600 ms-auto" href="<?php echo base_url() ?>blog/<?php echo $row->post_name; ?>">Read More <i class="fas fa-chevron-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>

                   <?php } ?>

                    <?= $links; ?>

                    
                   </div>
                  </div>
                  <div class="col-md-3">

                      <?php include 'sidebar.php'; ?>


                  </div>



                </div>
            </div>
        </section>
              <?php include 'cta.php'; ?>

        <!-- End section -->
