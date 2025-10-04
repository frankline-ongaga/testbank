
        <section id="features" class="section-yellow padding-top-bottom">
           <div class="container kevvy">
          <h2 class="section-title text-center god">Sample Papers</h2>
           <p class="lead mb-3">At EssaysCorp we strictly follow the instructions provided by the client. Find our sample papers below </p> 
           <br>

          <div class="col-sm-10 col-sm-offset-1">

             <?php
               foreach($samples->result() as $row) {  ?>

            <div class="blog-box">
            
              <header class="post-header">
                <h1 class="post-title"><?php echo $row->sample_title; ?></h1>
              </header>
              
              
              
              <div class="post-content" style="text-align: left;">
              
                <div class="post-excerpt">
                
                  <p style="font-weight: 400;"><?php echo $row->sample_paragraph; ?></p>
              
                </div>
                
              </div>
              
              <footer>
                <p><a class="read-more" href="<?php echo base_url() ?>home/paper_details_samples/<?php echo $row->sample_slug; ?>">Read More</a></p>
              </footer>
              
            </div>
          <?php } ?>

           

            

           
           </div>



              

          </div>
        </section>
          <section class="cta water-bg">
    
       <div class="container">
      
        <div class="row">
          <div class="col-md-8 cta-message">
            <p  style="color:black;"><strong>EssaysCorp writing services</strong> is the perfect solution for improving your grade, get 20% off when you make your first order</p>
          </div>
          <div class="col-md-4 cta-button">
            <p class="text-center"><a class="btn btn-qubico" href="<?php echo base_url('home/order_now') ?>"><i class="fa fa-shopping-cart"></i>ORDER NOW</a></p>
          </div>
        </div><!--End row-->
        
      </div><!--End container -->
      
    </section><!--End Call to Action -->
