<div class="business-banner">                 
        <div class="hvrbox">
            <img src="<?php echo base_url('loop/images/essayloopcollege.webp') ?>" alt="student essays" class="hvrbox-layer_bottom">
            <div class="hvrbox-layer_top">
                <div class="container">
                    <div class="overlay-text text-left">            
                        <h3>Contact Us</h3>
                        <nav aria-label="breadcrumb">
                          <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Contact Us</li>
                          </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>                       
    </div>      
        <section id="features" class="water-bg padding-top-bottom">
           <div class="container kevvy">
         

          
        <div class="row">
          <div class="col-md-6 offset-md-3">
             <div class="padding-top-large"></div>

           
           <p class="subsection-description">Drop us a line and we will contact you as soon as possible.</p>

                           <?php
                                 if(isset($message)){
                                  ?>
                                    <div class="alert alert-success">

                                       <?php echo $message; ?>
                                      
                                    </div>
                             <?php    } ?>


                              <?php
                                 if(isset($fail)){
                                  ?>
                                    <div class="alert alert-warning">

                                       <?php echo $fail; ?>
                                      
                                    </div>
                             <?php    } ?>
        
        <!--=== Contact Form ===-->

          <form id="loginform" class="" action="<?php echo base_url() ?>home/contactus_process" method="post">
            
            <div class="form-group">
              <label class="control-label" for="contact-name">Name</label>
              <div class="controls">
              <input id="contact-name" name="fname" placeholder="Your name" class="form-control requiredField label_better" data-new-placeholder="Your name" type="text" data-error-empty="Please enter your name">
             
              </div>
            </div><!-- End name input -->
            
            <div class="form-group">
              <label class="control-label" for="contact-mail">Email</label>
              <div class=" controls">
              <input id="contact-mail" name="email" placeholder="Your email" class="form-control requiredField label_better" data-new-placeholder="Your email" type="email" data-error-empty="Please enter your email" data-error-invalid="Invalid email address">
             
              </div>
            </div><!-- End email input -->

            <div class="form-group">
              <label class="control-label" for="contact-mail">Subect</label>
              <div class=" controls">
              <input id="contact-mail" name="subject" placeholder="subject" class="form-control requiredField label_better" data-new-placeholder="Your email" type="text">
             
              </div>
            </div><!-- End email input -->
            
            <div class="form-group">
              <label class="control-label" for="contact-message">Message</label>
              <div class="controls">
                <textarea id="contact-message" name="message"  placeholder="Your message" class="form-control requiredField label_better" data-new-placeholder="Your message" rows="6" data-error-empty="Please enter your message"></textarea>
                
              </div>
            </div><!-- End textarea -->
            <div class="form-group">
                                                         <div class="g-recaptcha" data-sitekey="6LdVpcgZAAAAAKXFlnZb259PNT4YoZpAHACYgRLu"></div>
            </div>
            
            <p><button  type="submit" class="btn bussiness-btn-larg"><i class="fa fa-location-arrow"></i>Send Message</button></p>
           
            
          </form><!-- End contact-form -->



              
             </div>
          </div>
        </section>
