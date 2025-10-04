  <div class="business-banner">                 
        <div class="hvrbox">
            <img src="<?php echo base_url('loop/images/essayloopcollege.webp') ?>" alt="student essays" class="hvrbox-layer_bottom">
            <div class="hvrbox-layer_top">
                <div class="container">
                    <div class="overlay-text text-left">            
                        <h3>Disciplines</h3>
                        <nav aria-label="breadcrumb">
                          <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Disciplines</li>
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
                     <p>At EssayLoop, we acknowledge that our clients specialize in different majors and as such, we strive to ensure that we have writers from all subjects. In order to achieve this, our recruiting department carries out an intensive recruitment process so as to ensure that we only have competent writers on board. As a matter of fact, our experts are PhD and masters holders. Others posses important certifications such as ACCA, CPA, and Oracle Certifications. The following subjects, among others, are handled by our team of experts: </p>   
                   </div>
                </div>
                 <div class="row">
                     <?php 
           // echo $h->num_rows();
                      foreach($discipline->result() as $row){ ?>
                     <div class="col-md-6">  
                                        <a href="<?php echo base_url() ?>home/service_details/<?php echo $row->post_name; ?>"><span class="badge badge-primary">
                                         <?=  $row->post_title ?></span></a>
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

      
  