	<?php 
           // echo $h->num_rows();
           foreach($h->result() as $row){ 

       ?>
        <!-- Page Title -->
     


<main id="content">
   <div id="hero" class="section py-5 jarallax">
      <!-- background parallax -->
      <!-- background overlay -->
      <div class="overlay bg-primary opacity-90 z-index-n1"></div>
      <!-- rocket moving up animation -->
      <div class="container">
         <div class="row align-items-center justify-content-center">
            <!-- content -->
            <div class="col-lg-7">
               <br>
               <br>
               <div class="mt-0 pt-4 text-center">
                  <h1 class="text-white text-shadow"><?php
									          echo  $row->post_title;
									          ?></h1>
                  <hr class="divider mt-4 mx-auto bg-warning border-warning">
               </div>
            </div>
            <!-- end content -->
         </div>
      </div>
      <!-- End Page Title -->
      <!-- Section -->
      <div style="position: absolute; top: 0px; left: 0px; width: 100%; height: 100%; overflow: hidden; z-index: -100;" id="jarallax-container-0"><img class="jarallax-img" src="src/img-min/bg/bg-planet.jpg" alt="title" style="object-fit: cover; object-position: 50% 50%; max-width: none; position: absolute; top: 0px; left: 0px; width: 1525px; height: 351.727px; overflow: hidden; pointer-events: none; transform-style: preserve-3d; backface-visibility: hidden; will-change: transform, opacity; margin-top: 15.1367px; transform: translate3d(0px, -86.3367px, 0px);"></div>
   </div>
        <!-- End Page Title -->
        <!-- Section -->
        <section class="section">
	
           <p class="lead mb-3 text-center"> </p> 
           <br>
			
			<article class="post">
			
				<div class="container scrollimation fade-up in">
					
					<div class="row">
						
					
						<div class="col-sm-12 blog-box">
						   <div class="single-bolg hover01 brainer party">
                              <div class="blog-content">
						
							<header class="post-header">
								<h1 class="post-title">
									        
                                   </h1>
								<!-- <small class="post-meta">March 28 2014 , in <a href="blog-travel.html">Travelling</a></small> -->
							</header>
							
							
							
							<div class="post-content">
							
								<div class="post-excerpt">
									<p>
								
									 <?php
                                           echo $row->post_content;
                                      ?>
                                     </p>
							
								</div>
								
							</div>
							
							<footer>
								<p><a class="btn btn-primary" href="<?php echo base_url('order_now'); ?>">Order Now</a></p>
							</footer>
							</div>
						  </div>
						</div>
					<?php } ?>
						
					</div><!--End row -->
					
				</div><!--End container -->
			
			</article><!--End post -->

			
			
			
			
			
			
		
			
		</section>
