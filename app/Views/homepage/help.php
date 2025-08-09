  <div class="business-banner">                 
        <div class="hvrbox">
            <img src="<?php echo base_url('loop/images/essayloopcollege.webp') ?>" alt="student essays" class="hvrbox-layer_bottom">
            <div class="hvrbox-layer_top">
                <div class="container">
                    <div class="overlay-text text-left">            
                        <h3>Help</h3>
                        <nav aria-label="breadcrumb">
                          <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Help</li>
                          </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>                       
    </div>      
    
    <div class="bussiness-about-company">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="padding-top-large"></div>  
                     <p>At EssayLoop, we have a variety of resources, guides and tips to help you : </p>   
                   </div>
                </div>
                 <div class="row">

                      <?php 
           // echo $h->num_rows();
                      foreach($help->result() as $row){ ?>
                     <div class="col-md-12">  
                                        <a  style="color: blue;" href="<?php echo base_url() ?>home/service_details/<?php echo $row->post_name; ?>">
                                         <?=  $row->post_title ?> <i class="fa fa-arrow-right"></i></a>
                     </div>
                   <?php } ?>
                      
                  </div>          


                       
 
                </div>
                
                
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

      
  