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
                <h1 class="post-title"><?php echo $row->sample_title; ?></h1>
              </header>
              
              
              
              <div class="post-content">
              
                <div class="post-excerpt" style="text-align: left;">
                
                  <p style="font-weight: 400;"><?php echo $row->sample_paper; ?></p>
              
                </div>
                
              </div>
              
              <footer>
                <p><a class="btn btn-qubico" href="<?php echo base_url() ?>home/order_now">Order a similar paper</a></p>
              </footer>
              
            </div>

            <?php } ?>

              
            </div>


       
</div>
 </section>
  <section class="water-bg cta">
    
      <div class="container">
      
        <div class="row">
          <div class="col-md-8 cta-message">
            <p  style="color:black;">Get prompt quotations for your technical orders, we have a dedicated team that handles technical orders professionally</p>
          </div>
          <div class="col-md-4 cta-button">
            <p class="text-center"><a class="btn btn-qubico" href="<?php echo base_url('home/technical_order') ?>"><i class="fa fa-shopping-cart"></i>ORDER NOW</a></p>
          </div>
        </div><!--End row-->
        
      </div><!--End container -->
      
    </section><!--End Call to Action -->