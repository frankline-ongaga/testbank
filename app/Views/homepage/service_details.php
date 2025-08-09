<main>
        <!-- Page Title -->
        <section class="page-heading parallax effect-section" style="background-image: url(static/img/bg-banner-1.jpg);">
            <div class="mask bg-dark-gradient opacity-8"></div>
            <div class="container position-relative">
                <h1 class="display-6 text-white mb-3">Details</h1>
                <ol class="breadcrumb light m-0">
                    <li class="breadcrumb-item"><a class="text-reset" href="<?php echo base_url(); ?>"><i class="bi bi-house-fill"></i> Home</a></li>
                    <li class="breadcrumb-item active text-white-50" aria-current="page">Details </li>
                </ol>
            </div>
        </section>
        <!-- End Page Title -->
<section id="features" class="section-yellow padding-top-bottom god">
           <div class="container kevvy">
          
           <br>
<div class="container kevvy">
        
        	
        	
        	 <br>
        	

             <div class="row">


              <?php
               foreach($h->result() as $row) {  ?>
                <div class="blog-box">
            
              <header class="post-header">
                <h1 class="post-title"><?php  echo $row->post_title ?></h1>
              </header>
              
              
              
              <div class="post-content">
              
                <div class="post-excerpt" style="text-align: left;">
                
                  <p style="font-weight: 400;"><?php  echo $row->post_content ?></p>
              
                </div>
                
              </div>
              
              
              
            </div>

            <?php } ?>

              
            </div>


       
</div>
 </section>
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