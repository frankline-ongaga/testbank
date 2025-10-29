
    <!-- Footer Area Start -->
    <footer>
      <div class="footer_main py-60">
        <img src="assets/media/shapes/vector-7.png" alt="" class="vector_shape">
        <img src="assets/media/shapes/dots-1.png" alt="" class="dots">
        <div class="container">
          <div class="row">
            <div class="col-xl-5 ">
              <div class="footer_widget">
                <a href="index.html" class="mb-8"><img src="assets/media/logo.png" alt=""></a>
                <p class="description_text">Pass Your NCLEX on the First Try.</p>
                <p class="description_text">Whatsapp: +1 (209) 260-9257</p>
                <p class="description_text">Email: support@nclexprepcourse.org </p>

              </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-sm-6">
              <div class="footer_widget">
                <h5 class="medium-black mb-16">Quick Links</h5>
                <ul class="unstyled list">
                  <li><a href="<?= base_url('register'); ?>"><i class="fad fa-chevron-right"></i>Get Started</a></li>
                  <li><a href="<?= base_url('login/student'); ?>"><i class="fad fa-chevron-right"></i>Login</a></li>
                  <li><a href="<?= base_url('how_it_works'); ?>"><i class="fad fa-chevron-right"></i>How It Works</a></li>
                  <li><a href="<?= base_url('reviews'); ?>"><i class="fad fa-chevron-right"></i>Reviews</a></li>
                  <li><a href="<?= base_url(); ?>"><i class="fad fa-chevron-right"></i>Home</a></li>


                </ul>
              </div>
            </div>
            <div class="col-xl-4 col-lg-3 col-sm-6">
              <div class="footer_widget">
                <h5 class="medium-black mb-16">Payment</h5>
                <img src="<?= base_url('assets/media/securepaypal.webp'); ?>" alt="secure checkout by PayPal">
              </div>
            </div>
            
           
          </div>
          
        </div>
      </div>
      <div class="copyright_row">
        <p>©<?= Date('Y'); ?> NCLEX Prep Course. All Rights Reserved.</p>
      </div>
    </footer>
    <!-- Footer Area End -->

  </div>

  <!-- Mobile Menu Start -->
  <div class="mobile-nav__wrapper">
    <div class="mobile-nav__overlay mobile-nav__toggler"></div>
    <div class="mobile-nav__content">
      <span class="mobile-nav__close mobile-nav__toggler"><i class="fa fa-times"></i></span>
      <div class="logo-box">
        <a href="index.html" aria-label="logo image"><img src="assets/media/logo-light.png" alt="educate"></a>
      </div>
      <div class="mobile-nav__container"></div>
      <ul class="mobile-nav__contact list-unstyled">
        <li>
          <i class="fas fa-envelope"></i>
          <a href="mailto:example@company.com">example@company.com</a>
        </li>
        <li>
          <i class="fa fa-phone-alt"></i>
          <a href="tel:+12345678">+123 (4567) -890</a>
        </li>
      </ul>
      <div class="mobile-nav__social">
        <a href="https://twitter.com/"><i class="fab fa-twitter"></i></a>
        <a href="https://www.facebook.com/"><i class="fab fa-facebook"></i></a>
        <a href="https://www.pinterest.com/"><i class="fab fa-pinterest-p"></i></a>
        <a href="https://www.instagram.com/"><i class="fab fa-instagram"></i></a>
      </div>
    </div>
  </div>
  <!-- Mobile Menu End -->

  <div class="search-popup">
    <div class="search-popup__overlay search-toggler"></div>
    <div class="search-popup__content">
      <form role="search" method="get" class="search-popup__form" action="index.html">
        <input type="text" id="search" placeholder="Search Here...">
        <button type="submit"><i class="fal fa-search"></i></button>
      </form>
    </div>
  </div>
  <!-- search-popup -->

  <!-- back-to-top-start -->
  <a href="#" class="scroll-top">
    <svg class="scroll-top__circle" width="100%" height="100%" viewBox="-1 -1 102 102">
      <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
    </svg>
  </a>
  <!-- back-to-top-end -->

  <!-- Jquery Js -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>window.jQuery || document.write('<script src="<?php echo base_url('assets/js/jquery-3.6.0.min.js'); ?>"><\/script>')</script>
  <script src="<?php echo base_url('assets/js/bootstrap.bundle.min.js'); ?>"></script>
  <script src="<?php echo base_url('assets/vendor/jquery-appear/jquery-appear.js'); ?>"></script>
  <script src="<?php echo base_url('assets/vendor/jquery-validator/jquery-validator.js'); ?>"></script>
  <script src="<?php echo base_url('assets/vendor/countdown/jquery.countdown.min.js'); ?>"></script>
  <script src="<?php echo base_url('assets/vendor/jquery-magnific-popup/jquery.magnific-popup.min.js'); ?>"></script>
  <script src="<?php echo base_url('assets/vendor/slickslider/slick.min.js'); ?>"></script>
  <script src="<?php echo base_url('assets/vendor/tilt/tilt.jquery.js'); ?>"></script>
  <script src="<?php echo base_url('assets/vendor/wow/wow.js'); ?>"></script>

  <!-- Site Scripts -->
  <script src="<?php echo base_url('assets/js/app.js'); ?>"></script>

   <script type="text/javascript">
    (function () {
        var options = {
            whatsapp: "+1 (206) 350-4565", // WhatsApp number
            call: "+1 (206) 350-4565", // Call phone number
            call_to_action: "Message us", // Call to action
            button_color: "#FF318E", // Color of button
            position: "left", // Position may be 'right' or 'left'
            order: "whatsapp,call", // Order of buttons
        };
        var proto = document.location.protocol, host = "getbutton.io", url = proto + "//static." + host;
        var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = url + '/widget-send-button/js/init.js';
        s.onload = function () { WhWidgetSendButton.init(host, proto, options); };
        var x = document.getElementsByTagName('script')[0]; x.parentNode.insertBefore(s, x);
    })();
</script>
</body>

</html>