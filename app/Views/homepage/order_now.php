<main>
        <!-- Page Title -->
        <section class="page-heading parallax effect-section" style="background-image: url(static/img/bg-banner-1.jpg);">
            <div class="mask bg-dark-gradient opacity-8"></div>
            <div class="container position-relative">
                <h1 class="display-6 text-white mb-3">Order Now</h1>
                <ol class="breadcrumb light m-0">
                    <li class="breadcrumb-item"><a class="text-reset" href="<?php echo base_url(); ?>"><i class="bi bi-house-fill"></i> Home</a></li>
                    <li class="breadcrumb-item active text-white-50" aria-current="page">Order Now </li>
                </ol>
            </div>
        </section>
        <!-- End Page Title -->
<div id="pricing" class="section pt-6 pt-md-7 pb-4 pb-md-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                  <div class="eldoret">
                    <div class="card shadow-sm">
                      <div class="card-body">
                   

                       <?php
                                 if($this->session->flashdata('warning')){
                                  ?>
                                    <div class="alert alert-warning">

                                       <?php echo $this->session->flashdata('warning'); ?>
                                      
                                    </div>
                             <?php    }


                               ?>

                                 <?php
                                 if(isset($error)){
                                  ?>
                                    <div class="alert alert-warning">

                                       <?php echo $error; ?>
                                      
                                    </div>
                             <?php    }


                               ?>
                     
                           <form action="<?php echo base_url() ?>client/process_order_first" method="post" id="msform" enctype='multipart/form-data'>
                           
                            
                          

                               <div class="form-group">
                                    <?php   
                                       if($this->uri->segment(3)){

                                               $affiliate=$this->uri->segment(3);
                                               $aff_id=$affiliate;

                                       }
                                     ?>
                                   <input type="hidden" class="form-control mb-3" value="<?php if(isset($aff_id)){  echo $aff_id; } ?>" name="affiliate">
                                   <!-- <div class="btn-group" role="group" aria-label="...">
                                      <button type="button" class="btn btn-default">Writing</button>
                                      <button type="button" class="btn btn-default">Rewriting</button>
                                      <button type="button" class="btn btn-default">Proofreading</button>
                                    </div> -->
                                  <div style="text-align: center">
                                    <div class="stv-radio-buttons-wrapper">
                                          <input type="radio" onchange="get_tols()" onclick="get_tols()" class="stv-radio-button"  name="service" value="1" id="button1" checked />
                                          <label for="button1">Custom Writing</label> 
                                          <input type="radio" onchange="get_tols()" onclick="get_tols()" class="stv-radio-button"  name="service" value="2" id="button2" />
                                          <label for="button2">Editing</label>
                                          <input type="radio" onchange="get_tols()" onclick="get_tols()"  class="stv-radio-button"  name="service" value="3" id="button3" />
                                          <label for="button3">Proof Reading</label>
                                      </div>
                                    </div>
                                </div>
                               

                                <div class="form-group">
                                    <input type="text" class="form-control" id="order_title" name="order_title" placeholder="Title" required>
                                </div>
                                 <div class="form-group">
                                    <textarea class="form-control"  id="order_description" name="order_description" placeholder="Details" rows="5"></textarea>
                                </div>
                                

                                <div class="form-group row">
                                <div class="col-md-6">
                                    <select id="discipline" class="form-control" onchange="get_other()" name="order_discipline_id" required>
                                         <option value="" disabled selected hidden>Discipline</option>
                                       
                                         <?php

                                          foreach ($discipline->result_array() as $row)         

                                            { ?>

                                            <option  value="<?php echo $row['discipline_id']; ?>"><?php echo $row['discipline_name']; ?></option>

                                       <?php } ?>
                                    </select>
                                    
                                </div><!-- / sub-col -->
                                <div class="col-md-6">
                                      <select class="form-control" id="order_format_id" name="order_format_id" onchange="get_tols()" required>
                                         <option value="" disabled selected hidden>Paper Format</option>
                                       
                                        <?php

                                                          foreach ($format->result_array() as $row)

                         

                                                            { ?>

                                                            <option  value="<?php echo $row['format_id']; ?>" <?php if($disc==$row['format_id']){ echo "selected"; } ?>><?php echo $row['format_name']; ?></option>

                                                       <?php } ?>
                                    </select>
                                </div><!-- / sub-col -->
                               </div>

                                 <div class="form-group" id="other">
                                    <input id="thatinput" type="text" class="form-control mb-3" id="other"  name="other" placeholder="Enter Discipline">
                                </div>

                                <div class="form-group row">
                                <div class="col-md-6">
                                  <label class="small left">Pages</label>
                                  <div class="input-group">
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-warning btn-number"  disabled="disabled" data-type="minus" data-field="order_pages">
                                            <span class="fa fa-minus"></span>
                                        </button>
                                    </span>
                                    <input type="text" name="order_pages" onchange="get_words(),get_tols()" id="pages" class="form-control input-number" value="<?php if(!empty($page)){ echo $page; }else{ echo 1; } ?>" min="1"  max="100">
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-warning btn-number"  data-type="plus" data-field="order_pages">
                                            <span class="fa fa-plus"></span>
                                        </button>
                                    </span>
                                 </div>
                                </div><!-- / sub-col -->
                                <div class="col-md-6">
                                  <label class="small">Words</label>
                                  
                                    <input type="text" id="words" value="275 words" class="form-control mb-3" name="order_words" placeholder="Words" readonly>

                                  
                                </div>
                                </div>
                                <div class="form-group row">
                                <div class="col-md-6">
                                   <label class="small left">Sources</label>
                                  

                                     <div class="input-group">
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-warning btn-number" disabled="disabled" data-type="minus" data-field="order_sources">
                                            <span class="fa fa-minus"></span>
                                        </button>
                                    </span>
                                    <input type="text" id="order_sources" name="order_sources" class="form-control input-number" value="1" min="1"  max="100">
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-warning btn-number" data-type="plus" data-field="order_sources">
                                            <span class="fa fa-plus"></span>
                                        </button>
                                    </span>
                                 </div>

                                  
                                </div>

                                <div class="col-md-6">
                                  <label class="small left">Level</label>
                                    <select class="form-control" name="order_level_id" id="level" onchange="get_tols()" required>
                                         <option value="" disabled selected hidden>Academic Level</option>

                                      
                                      
                                         <?php

                                          foreach ($level->result_array() as $row)

         

                                            { ?>

                                            <option  value="<?php echo $row['level_id']; ?>" <?php if($row['level_id']==$leve){ echo 'selected'; }?>><?php echo $row['level_name']; ?></option>

                                       <?php } ?>
                                    </select>
                                    
                                </div><!-- / sub-col -->
                               </div>

                                  <div class="form-group">
                                   <label class="small left">Deadline</label>
                                    <div class="input-group mb-3">
                                   <div class="input-group-prepend">
                                      <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                    </div>
                                   <input class="form-control readonly" <?php if(!empty($dead)){ ?> value="<?php echo $dead; ?>" <?php }   ?> placeholder="Launch Calendar" onchange="get_tols()"  type="text" id="deadline" name="order_deadline_id" required />
                                  
                                  </div>

                                  <input type="hidden" name="order_tz" value=""  id="tz">

                                    
                                </div><!-- / sub-col -->
                                
                                <div class="form-group">
                                  <label class="small left">Upload Files</label>
                                    <div class="dropzone" id="myDropzone">
                                    </div>
                                 
                                 </div>

                                <div class="form-group">
                                  <label class="small left">Total (USD)</label>
                                    <input type="text" min="0" name="order_amount" class="form-control" id="total"  readonly>
                                </div>
                                 <div class="col-md-12 sub-col-right">
                                   
                                      <h5 class="text-default text-center mb-0"> - ACCOUNT INFORMATION - </h5> 
                                      <br>
                                </div>
                                  
                                    
                                    
                                   <div class="col-md-12 text-left">

                                    </div>
                                    <div class="row form-group">
                                    <div class="col-md-6">
                                       <input type="text" class="form-control  mb-3" id="user_fname"  name="user_fname" placeholder="First Name" required>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control  mb-3" id="user_lname"  name="user_lname" placeholder="Surname (optional)">
                                    </div>
                                    </div>
                                 
                                    <div class="form-group row">
                                       <div class="col-md-6">
                                        <input type="email" class="form-control mb-3" id="user_email" name="user_email" placeholder="Your email" required>
                                       </div>
                                       <div class="col-md-6">
                                        <input type="number" class="form-control mb-3" id="user_phone" name="user_phone" placeholder="Your Phone(Optional)">
                                       </div>
                                    </div>
                                    <div class="row form-group">
                                    <div class="col-md-6">
                                       <input type="password" class="form-control  mb-3" id="new_password"  name="password" placeholder="Password" required>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="password" class="form-control  mb-3" id="confirm_password" name="confirm_password" placeholder="Confirm Password" required>
                                    </div>
                                    </div>
                                  <!--   <div class="col-md-12 sub-col-right">
                                     <div class="g-recaptcha" data-sitekey="6LdKNwEVAAAAAJjsdTXqbJ-peDQOO57lXwhcXael"></div>
                                    </div> -->
                                     <div class="form-group">
                                     <div class="g-recaptcha" data-sitekey="6LdVpcgZAAAAAKXFlnZb259PNT4YoZpAHACYgRLu"></div>
                                    </div>
                                  <button  type="submit" id="submit-all" class="btn btn-lg btn-warning"><i class="fa fa-shopping-cart"></i> ORDER NOW</button>
                                   
                                

                                




                          

                                

                            <div class="spacer">&nbsp;</div>

                              <a href="<?= base_url() ?>home/technical_order">Make a technical order</a>

                            <div class="text-center">
                               
                            </div>
                           </form>               

                           </div>
                         </div>
                      </div>
                   </div>
                   <div class="col-lg-4">

                    <?php include 'sidebar_order.php'; ?>

                   </div>
                
               
            </div>
        </section>
              <?php include 'cta.php'; ?>

    </main>  
      
  

      
  