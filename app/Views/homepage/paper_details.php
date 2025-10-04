 <?php  
               
               foreach ($h as $row) {  ?>
    <main>
        <!-- Page Title -->
        <section class="page-heading parallax effect-section" style="background-image: url(static/img/bg-banner-1.jpg);">
            <div class="mask bg-dark-gradient opacity-8"></div>
            <div class="container position-relative">
                <h1 class="display-6 text-white mb-3"><?= $row->sample_title ?></h1>
                <ol class="breadcrumb light m-0">
                    <li class="breadcrumb-item"><a class="text-reset" href="<?php echo base_url(); ?>"><i class="bi bi-house-fill"></i> Home</a></li>
                    <li class="breadcrumb-item active text-white-50" aria-current="page"><?= $row->sample_title ?> </li>
                </ol>
            </div>
        </section>
        
     
<section>
 
        <div class="container">
            <div class="row">

       

       <div class="col-md-6 mb-5">

                    
          <div class="card card-style10">
            <div class="card-body">
              <h2><?php echo $row->sample_paper; ?></h2>
                          
                           
                            <br>

                 <a href="<?php echo base_url('order_now'); ?>" class="btn btn-warning">Order Now</a>                   
            </div>
                       
          </div>

           </div>

       
        
         

                  
                    
                   

 
               
                
                
            </div>
        </div>
    </section>

    <?php include 'cta.php'; ?>

     <?php } ?>

      
  

           
            
            
            
            
            
                         
           