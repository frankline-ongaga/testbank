<div class="business-banner">                 
        <div class="hvrbox">
            <img src="<?php echo base_url('loop/images/essayloopcollege.webp') ?>" alt="student essays" class="hvrbox-layer_bottom">
            <div class="hvrbox-layer_top">
                <div class="container">
                    <div class="overlay-text text-left">            
                        <h3>Writer Account</h3>
                        <nav aria-label="breadcrumb">
                          <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Writer Account</li>
                          </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>                       
    </div> 
<section id="features" class="water-bg padding-top-bottom">
<div class="container kevvy">
        
             <div class="spacer spacer-line border-primary">&nbsp;</div>
             <br>
             <div class="col-md-6 offset-md-3">
               <div class="card">
                

                          <nav>
                            <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">

                              <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">LOG IN</a>
                              <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">SIGN UP</a>
                             
                            </div>
                          </nav>


                            <div class="tab-content">
                              <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                 <?php 
                                        if(isset($error_message)){ ?>
                                        <div class="alert alert-warning">
                                          <?php 

                                            echo $error_message;
                                          ?>
                                         </div>
                                    <?php
                                        }


                                    ?>

                                     <?php 
                                        if(isset($success_message)){ ?>
                                        <div class="alert alert-success">
                                          <?php 

                                            echo $success_message;
                                          ?>
                                         </div>
                                    <?php
                                        }


                                    ?>

                                     <?php
                                           if($this->session->flashdata('warning')){
                                            ?>
                                            
                                              <div class="alert alert-warning">

                                                 <?php echo $this->session->flashdata('warning'); ?>
                                                
                                              </div>
                                       <?php    }


                                         ?>
                                   
                                      
                                        <form method="post" id="loginform"  action="<?php echo base_url() ?>homewriter/login_user">
                                            <br>
                                             <div class="form-group col-md-12">
                                            <input type="email" name="email" class="form-control mb-3" id="login-input" placeholder="Email" required>
                                          </div>
                                           <div class="form-group col-md-12">
                                            <input type="password" name="password" class="form-control mb-3" id="login-password-input" placeholder="Password" required>
                                           </div>
                                            <div class="form-group col-md-12">
                                                <div class="left-area">
                                                    <button type="submit" class="btn btn-primary btn-lg">LOG IN</button>
                                                </div><!-- / left-area -->
                                               <!--  <div class="right-area">
                                                    <a href="#x" class="btn btn-primary">LOG IN</a>
                                                </div> --><!-- / right-area -->
                                            </div><!-- / form-inline-extras -->
                                            </form>
                                            <div class="form-group col-md-12">
                                                <a href="#myModal"  data-target="#myModal" data-toggle="modal">Forgot your password?</a>
                                            </div><!-- / text-left -->
                                       
                                   
                              </div>
                              <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                      <form id="signupform" method="post" action="<?php echo base_url('writer/add_user') ?>">
                                         <br>
                                       
                                          <div class="form-group col-md-12">
                                            <input type="text" class="form-control mb-3" name="user_fname" placeholder="First Name" required>
                                          </div>
                                          <div class="form-group col-md-12">
                                            <input type="text" class="form-control mb-3" name="user_lname" placeholder="Surname">
                                          </div>
                                          <div class="form-group col-md-12">
                                            <input type="email" class="form-control mb-3" name="user_email" placeholder="Email Address" required>
                                          </div>
                                          <div class="form-group col-md-12">
                                            <input type="password" class="form-control mb-3" id="new_password"  name="password" placeholder="Password" required>
                                          </div>
                                          <div class="form-group col-md-12">
                                            <input type="password" class="form-control mb-3" id="confirm_password"  name="confirm_password" placeholder="Confirm Password" required>
                                          </div>
                                             
                                               <div class="col-md-12 form-group">
                                                 <div class="g-recaptcha" data-sitekey="6LdVpcgZAAAAAKXFlnZb259PNT4YoZpAHACYgRLu"></div>
                                                </div>
                                           
                                            <div class="form-group col-md-12">
                                                
                                                    
                                                    <small>By signing up you accept our <a href="<?php echo base_url('home/terms') ?>">terms and conditions</a></small>
                                                        
                                                    <!-- / checkbox -->
                                                </div><!-- / left-area -->
                                                
                                                <div class="form-group col-md-12">
                                                     <button type="submit" class="btn btn-primary btn-lg">SIGN UP</button>
                                                </div><!-- / right-area -->
                                            </div><!-- / form-inline-extras -->
                                      </form>
                                  
                              </div>
                            
                            </div>










                            <!-- pill tab in card -->
                         
                         
                            <!-- / pill tab in card -->
                        </div>
                     </div>
                
            </div>
</section>
<div class="modal fade" id="myModal" role="dialog" style="z-index: 100000">
                                              <div class="modal-dialog">
                                                <div class="modal-content">

                                                  <!-- Modal Header -->
                                                  <div class="modal-header">
                                                    <h4 class="modal-title">Recover your password</h4>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                  </div>

                                                  <!-- Modal body -->
                                                  <div class="modal-body">
                                                      <form class="contactform" id="signupform" method="post" action="<?php echo base_url('writer/recover_password')?>">
                                                                            <div class="row">
                                                                               
                                                                                 <div class="col-md-12">
                                                                                    <div class="form-group">
                                                                                        <input id="email" type="email" placeholder="Your email" name="email" class="form-control" required>
                                                                                    </div>
                                                                                </div>

                                                                                  <div class="col-md-12">
                                                                                    <div class="form-action">
                                                                                        <button class="btn btn-success" type="submit" name="send">Recover</button>
                                                                                    </div>
                                                                                </div>
                                                          </div>
                                                        </form>
                                                    </div>

                                                  <!-- Modal footer -->
                                                  <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                  </div>

                                                </div>
                                              </div>
</div>