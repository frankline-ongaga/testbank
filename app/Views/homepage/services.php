<main>
        <!-- Page Title -->
        <section class="page-heading parallax effect-section" style="background-image: url(static/img/bg-banner-1.jpg);">
            <div class="mask bg-dark-gradient opacity-8"></div>
            <div class="container position-relative">
                <h1 class="display-6 text-white mb-3">Services</h1>
                <ol class="breadcrumb light m-0">
                    <li class="breadcrumb-item"><a class="text-reset" href="<?php echo base_url(); ?>"><i class="bi bi-house-fill"></i> Home</a></li>
                    <li class="breadcrumb-item active text-white-50" aria-current="page">Services </li>
                </ol>
            </div>
        </section>
        <!-- End Page Title -->     
       <div class="padding-top-large"></div>

    
    <div class="bussiness-about-company">
        <div class="container">
            <div class="row">
                 <?php 
           // echo $h->num_rows();
                      foreach($services->result() as $row){ ?>
                     <div class="col-md-12">  
                                        <a  style="color: blue;" href="<?php echo base_url() ?>home/service_details/<?php echo $row->post_name; ?>">
                                         <?=  $row->post_title ?> <i class="fa fa-arrow-right"></i></a>
                     </div>
                   <?php } ?>
                
                
            </div>
        </div>
    </div>  
      
  <div class="padding-top-large"></div>
      
    <div class="business-cta-2x">
    <div class="business-cta-2-content">
      <div class="container">
        <div class="row">
          <div class="col-md-8">
            <div class="business-cta-left-2">
              <h2>Get quality writing services </h2>
            </div>
          </div>  
          <div class="col-md-4">
            <div class="business-cta-right-2">
              <a href="<?php echo base_url('home/order_now') ?>" class=" btn bussiness-btn-larg">Place order <i class="fa fa-angle-right"></i> </a>
            </div>
          </div>  
        </div>  
      </div>  
    </div>  
  </div>

      
  