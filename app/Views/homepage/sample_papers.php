<main>
        <!-- Page Title -->
        <section class="page-heading parallax effect-section" style="background-image: url(static/img/bg-banner-1.jpg);">
            <div class="mask bg-dark-gradient opacity-8"></div>
            <div class="container position-relative">
                <h1 class="display-6 text-white mb-3">Samples</h1>
                <ol class="breadcrumb light m-0">
                    <li class="breadcrumb-item"><a class="text-reset" href="<?php echo base_url(); ?>"><i class="bi bi-house-fill"></i> Home</a></li>
                    <li class="breadcrumb-item active text-white-50" aria-current="page">Samples </li>
                </ol>
            </div>
        </section>
        
     
<section>
 
        <div class="container">
            <div class="row">

         <?php
               foreach($samples->result() as $row) {  ?>

       <div class="col-md-6 mb-5">

                    
          <div class="card card-style10">
            <div class="card-body">
              <h2><?php echo $row->sample_title; ?></h2>
                          
                           
                            <br>

                 <a href="<?php echo base_url() ?>sample_details/<?php echo $row->sample_slug; ?>" class="btn btn-warning">Read More</a>                   
            </div>
                       
          </div>

           </div>

        <?php } ?>
        
         

                  
                    
                   

 
               
                
                
            </div>
        </div>
    </section>

    <?php include 'cta.php'; ?>

      
  
