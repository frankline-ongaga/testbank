<footer class="bussiness-footer-1x">    
    
      <div class="bussiness-footer-content ">
        <div class="container">
          <div class="row">
             <?php
                foreach($help->result() as $row){  ?>
         <div class="col-md-3">           
         
            
              <a  id="bamboo" href="<?php echo base_url() ?>home/service_details/<?php echo $row->post_name; ?>"><?php echo $row->post_title; ?></a>
                          
                                                
            
                       
         
        </div>

        <?php } ?>

          </div>
        </div>
        <br> <br>
                   <div class="container">
                    <p><i class="fa fa-paypal"></i> We accept Paypal</p>

                   </div>
                
 
                        <div class="container"> 
                            <div class="">
                                <div class="col-md-12 footer-info">
                                    <div class="row"> 
                                        <div class="col-md-9">  
                                            <div class="footer-info-left">  
                                                <p>All Rights Reserved. Copyright EssayLoop 2020.  <i class="fa fa-envelope"></i>  support@essayloop.com</p>
              
                                              
                                                 <a href="<?php echo base_url() ?>"> Home </a> |
                                                 <a href="<?php echo base_url('home/order_now') ?>"> Order Now </a> |     
                                                 <a href="<?php echo base_url('home/pricing') ?>"> Pricing </a> |      
                                                 <a href="<?php echo base_url('home/how_it_works') ?>"> How It Works </a> |   
                                                 <a href="<?php echo base_url('home/reviews') ?>"> Reviews </a> |     
                                                 <a href="https://blog.essayloop.com"> Blog </a> |  
                                                 <a href="<?php echo base_url('home/contactus') ?>"> Contact Us </a>
                                                
                                                
                                              </div>
                                        </div>      
                                        <div class="col-md-3">
                                            <div class="footer-info-right">
                                                <ul>
                                                    <li><a href="https://web.facebook.com/essayloopwriters"> <i class="fa fa-facebook fa-2x"></i> </a></li>                   
                                                    <li><a href="https://twitter.com/essayloop"> <i class="fa fa-twitter fa-2x"></i> </a></li>                      
                                                                         
                                                </ul>         
                                            </div>          
                                        </div>          
                                    </div>          
                                </div>          
                            </div>    
            </div>
        
          </div>          
        </div>      
      </div>      
  </footer> 
  <!-- End Footer --> 
      
    
  
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script  src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?php echo base_url('loop/js/bootstrap.min.js') ?>"></script>

  <!-- Wow Script -->
  <script src="<?php echo base_url('loop/js/wow.min.js') ?>"></script>
  <!-- Counter Script -->
  <script  src="<?php echo base_url('loop/js/waypoints.min.js') ?>"></script>
  <script  src="<?php echo base_url('loop/js/jquery.counterup.min.js') ?>"></script>
  <!-- Masonry Portfolio Script -->
  
    <!-- OWL Carousel js-->
  <script src="<?php echo base_url('loop/js/owl.carousel.min.js') ?>"></script>  
  <!-- Lightbox js -->
  <script src="<?php echo base_url('loop/inc/lightbox/js/jquery.fancybox.pack.js') ?>"></script>
  <script src="<?php echo base_url('loop/inc/lightbox/js/lightbox.js') ?>"></script>
  <!-- Google map js -->
  <!-- loader js-->
    <script src="<?php echo base_url('loop/js/fakeLoader.min.js') ?>"></script>
  <!-- Scroll bottom to top -->
  <script  src="<?php echo base_url('loop/js/scrolltopcontrol.js') ?>"></script>
  <!-- menu -->
  <script src="<?php echo base_url('loop/js/bootstrap-4-navbar.js') ?>"></script>    
    <!-- Stiky menu -->
  <script src="<?php echo base_url('loop/js/jquery.sticky.js') ?>"></script>  
    <!-- youtube popup video -->
  <script src="<?php echo base_url('loop/js/jquery.magnific-popup.min.js') ?>"></script>
    <!-- Color switcher js -->
    <!-- Color-switcher-active -->  
  <!-- Custom script -->
    <script src="<?php echo base_url('loop/js/custom.js') ?>"></script>

     <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js" integrity="sha512-AIOTidJAcHBH2G/oZv9viEGXRqDNmfdPVPYOYKGy3fti0xIplnlgMHUGfuNRzC6FkzIo0iIxgFnr9RikFxK+sw==" crossorigin="anonymous"></script>
  
  </body>


</html> 

    <script>
    $(".readonly").keydown(function(e){
        e.preventDefault();
    });
</script>

    <script type="text/javascript">
      //console.log(Intl.DateTimeFormat().resolvedOptions().timeZone)
        
          function get_words(){

            var pages=$("#pages").val();
            var words=pages*275;
            $("#words").val(words+" words");


          }


       function get_other() {
              
                
                    
                    // get the value of the select statement
                     var id =  $("#discipline").val();
                     console.log(id);
                    
                      if (id == 69) {
                          $('#other').show(500);
                          $("#thatinput").prop('required',true);
                      } else {    

                          $('#other').hide(500);
                      }


                 
             
           
          }

          function get_custom() {
              
                
                    
                    // get the value of the select statement
                     var id =  $(".chui").val();
                     //console.log(id);
                    
                      if (id == 8) {
                          $('#juice').show(500);
                          $('.chui').removeAttr("id"); 
                          $('.simba').attr('id', 'deadline');
                          $('.simba').attr('name', 'order_deadline_id');
                          $('.simba').val(5);

                         
                          get_tols();
                      } else {    

                          $('#juice').hide(500);
                          $('.simba').removeAttr("id"); 
                          $('.chui').attr('id', 'deadline');
                          $('.chui').attr('name', 'order_deadline_id');

                          
                           get_tols();
                      }


                 
             
           
          }
   
     
       


       
          
                             
          function get_tols(){


                      var timezone=Intl.DateTimeFormat().resolvedOptions().timeZone;
                      $("#tz").val(timezone);
                      var pages=$("#pages").val();
                      var level=$("#level").val();
                      var deadline=$("#deadline").val();
                      var coupon=$("#coupon").val();
                      var service=$('input[name=service]:checked').val();


                        if(deadline)
                        {
                          deadline=deadline;
                        }
                        else
                        {
                           deadline="2040/7/7 11:11"
                        }
                   
                     

                      
                      

                       var deady=$(".chui").val();

                       if(deady==8)
                       {

                        deadline=eval(deadline)+eval(3);
                        console.log("Simba:"+deadline);
                       // deadline=5;

                       }
                       else
                       {
                          deadline=deadline;
                          console.log("chui:"+deadline);

                       }

                      // if(deadline==8){
                      //   get_custom();
                      // }

                      
                  
                      $.ajax({
                              url:'<?php echo base_url() ?>home/get_price',
                              type:'POST',
                              data:{ deadline:deadline, level : level,coupon : coupon,pages:pages,service:service,timezone:timezone },
                              success:function(result){

                               // console.log('pages'+pages);
                                //console.log('result'+result);
                                  
                                var tot=parseFloat(result).toFixed(2);

                                // alert(result);

                                 if(tot>0){
                                    
                                 $("#total").val((tot));
                                 $("#total").css('border','2px solid #74a125');


                                 }
                                 else
                                 {
                                   $("#total").val(8.5);
                                   ("#total").css('border','2px solid #c8c9c9');
                                 }


                                    
                              }

                      });
                  // });
              }

      </script>
      <script type="text/javascript">
       
          //plugin bootstrap minus and plus
  //http://jsfiddle.net/laelitenetwork/puJ6G/
  $('.btn-number').click(function(e){
      e.preventDefault();
      
      fieldName = $(this).attr('data-field');
      type      = $(this).attr('data-type');
      var input = $("input[name='"+fieldName+"']");
      var currentVal = parseInt(input.val());
      if (!isNaN(currentVal)) {
          if(type == 'minus') {
              
              if(currentVal > input.attr('min')) {
                  input.val(currentVal - 1).change();
              } 
              if(parseInt(input.val()) == input.attr('min')) {
                  $(this).attr('disabled', true);
              }

          } else if(type == 'plus') {

              if(currentVal < input.attr('max')) {
                  input.val(currentVal + 1).change();
              }
              if(parseInt(input.val()) == input.attr('max')) {
                  $(this).attr('disabled', true);
              }

          }
      } else {
          input.val(0);
      }
  });
  $('.input-number').focusin(function(){
     $(this).data('oldValue', $(this).val());
  });
  $('.input-number').change(function() {
                                                                                                                                                                                                                            
      minValue =  parseInt($(this).attr('min'));
      maxValue =  parseInt($(this).attr('max'));
      valueCurrent = parseInt($(this).val());
      
      name = $(this).attr('name');
      if(valueCurrent >= minValue) {
          $(".btn-number[data-type='minus'][data-field='"+name+"']").removeAttr('disabled')
      } else {
          alert('Sorry, the minimum value was reached');
          $(this).val($(this).data('oldValue'));
      }
      if(valueCurrent <= maxValue) {
          $(".btn-number[data-type='plus'][data-field='"+name+"']").removeAttr('disabled')
      } else {
          alert('Sorry, the maximum value was reached');
          $(this).val($(this).data('oldValue'));
      }
      
      
  });
  $(".input-number").keydown(function (e) {
          // Allow: backspace, delete, tab, escape, enter and .
          if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
               // Allow: Ctrl+A
              (e.keyCode == 65 && e.ctrlKey === true) || 
               // Allow: home, end, left, right
              (e.keyCode >= 35 && e.keyCode <= 39)) {
                   // let it happen, don't do anything
                   return;
          }
          // Ensure that it is a number and stop the keypress
          if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
              e.preventDefault();
          }
      });
    </script>

    <script type="text/javascript">
      
         function removepaperwork(){
             
             $('.apps').hide();
             $('.psd').show();

         }

                               function removestuff(){
             
             $('.apps').show();
             $('.psd').hide();

         }

         function showall(){
             
             $('.apps').show();
             $('.psd').show();

         }
    </script>

    <script type="text/javascript">
    //change password script don't get it twisted
           jQuery().ready(function() {

            // validate form on keyup and submit
            
            var v = jQuery("#signupform").validate({
              rules: {
                 new_password: {
                    required: true,
                    
                },
                confirm_password: {
                    required: true,
                   
                    equalTo: "#new_password"
                }
              },
              
              messages: {
                    
                    confirm_password: {
                        equalTo: "Passwords must match",
                    }
                   
                },
              errorElement: "span",
              errorClass: "help-block",
            });

           

           

          });
</script> 

      <script>


                    $('#deadline').datetimepicker({
                    inline:false,
                   // minDate: -0,
                    validateOnBlur : true,
                   
                    minDateTime: true,
                    });

       </script>


