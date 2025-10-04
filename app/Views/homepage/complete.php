<section id="features" class="water-bg padding-top-bottom">
<div class="container kevvy" style="min-height: 450px;">
       
          <h3 class="section-title text-center" style="text-transform: none;">Securely check out with Paypal</h3>
           <div class="spacer spacer-line border-primary">&nbsp;</div>
           <br>
          <!--  <p class="lead mb-3">Duis ac nibh a nunc tincidunt vulputate in nec augue. In quis ornare arcu. Mauris viverra viverra arcu in dignissim. Praesent volutpat mauris vel neque facilisis, in ultricies neque convallis.</p> -->
           <br>
            <div class="col-md-6 col-md-offset-3 mt-3 mb-3 right-area animated fadeInRight second text-center">

                                

                                 <div  id="paypal-button-container"></div>
                                <?php  
                                    if(!empty($amount)){
                                       $amount = $amount; 
                                    }
                                    $return_url = base_url().'paypal/callback';
                                    $order_id = $order_id;
                                ?>
                              
                           
                            <script src="https://www.paypal.com/sdk/js?client-id=<?php echo PAYPAL_CLIENTID; ?>"> </script>
                      <script>
                        paypal.Buttons({
                          createOrder: function(data, actions) {
                            return actions.order.create({
                              purchase_units: [{
                                amount: {
                                  value: '<?php echo $amount; ?>'
                                }
                              }]
                            });
                          },
                          onApprove: function(data, actions) {
                            return actions.order.capture().then(function(details) {
                              window.location = "<?php echo $return_url;?>?txn_id="+details.id+"&invoice_id="+details.invoice_id+"&status="+details.status+"&amount=<?php echo $amount; ?>&order_id=<?php echo $order_id; ?>"
                              // alert('Transaction completed by ' + details.payer.name.given_name);

                              // Call your server to save the transaction
                              return fetch('/paypal-transaction-complete', {
                                method: 'post',
                                headers: {
                                  'content-type': 'application/json'
                                },
                                body: JSON.stringify({
                                  orderID: data.orderID
                                })
                              });
                            });
                          }
                        }).render('#paypal-button-container');
                      </script>
                </div>
              <br>
            <br>

    
</div>
</section>
      
    
    