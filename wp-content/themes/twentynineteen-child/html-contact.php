<?php get_header(''); 
   /*Template Name: HTML Contact*/
   wp_enqueue_script('script');
   add_action('wp_footer','page_script',21);
   function page_script(){
   ?>
<script>

jQuery(document).ready(function(){
//  
jQuery('.main-nav > ul > li').removeClass("active");
jQuery('.main-nav > ul :nth-child(7)').addClass("active");



});

</script>
<?php } ?>
<section class="inner-banner-02 banner-3 pattern" style="background:url(<?php echo get_stylesheet_directory_uri(); ?>/images/contact-banner.jpg) center bottom; background-size: cover;">
   <div class="wrap">
      <div class="banner-title-box ">
         <h1 data-sr="wait 0.1s, enter right">The best way to 
            Predict the future 
            is to create it
            <span>Abraham Lincoln</span>
            <span class="title-line"></span>
         </h1>
      </div>
   </div>
</section>
<section class="pt-100 pb-100"  >
   <div class="wrap">
      <div class="career-title-row align-center">
         <h2 data-sr="wait 0.1s, enter right">Contact Us</h2>
         <h4 data-sr="wait 0.1s, enter right">
            Got a question or need some help? Get in touch. We’d love to hear from you.
         </h4>
      </div>
      <div class="form-box mt-100">
         <ul class="contact-folrm-ul">
            <li>
               <ul class="form-ul contact-form">
                  <li data-sr="wait 0.1s, enter right">
                     <input class="fld-01" type="text" placeholder="Name*">
                  </li>
                  <li data-sr="wait 0.1s, enter right">
                     <input class="fld-01" type="text" placeholder="Email*">
                  </li>
                  <li data-sr="wait 0.1s, enter right">
                     <input class="fld-01" type="text" placeholder="Phone Number*">
                  </li>
                  <li data-sr="wait 0.1s, enter right">
                     <input class="fld-01" type="text" placeholder="Type of Enquiry*">
                  </li>
               </ul>
            </li>
            <li>
               <ul class="form-ul contact-form">
                  <li data-sr="wait 0.1s, enter right">
                     <input class="fld-01" type="text" placeholder="Company">
                  </li>
                  <li data-sr="wait 0.1s, enter right">
                     <textarea  class="fld-01" rows="4" placeholder="Message" ></textarea>
                  </li>
                  <li data-sr="wait 0.1s, enter right" class="w-100">
                     <div class="check-block">
                        <label class="container">I accept the processing of my <a href="#">personal data</a>
                        <input type="checkbox" checked="checked">
                        <span class="checkmark"></span>
                        </label>
                     </div>
                     <a href="#" class="but-01  blue-but">Submit</a>
                  </li>
               </ul>
            </li>
         </ul>
      </div>
      <!-- <div class="oppaning-block  pt-80 mt-80">
         <div class="align-center">
            <h2 data-sr="wait 0.1s, enter right">Reach Us</h2>
         </div>
         <div class="reach-us-block">
            <ul class="career-block-ul">
               <li class="trans" data-sr="wait 0.1s, enter right">
                  <h3>Address</h3>
                  <ul class="address-block">
                     <li>
                        <span class="contact-icn" ><img src="<?php  echo get_stylesheet_directory_uri(); ?>/images/contact-icn-01.png"></span>   
                        <p>
                           Regent Global DMCC
                           1307-1308, JBC-2
                           Cluster-V, Jumeirah Lake Towers PO Box 943292 Dubai, UAE
                        </p>
                     </li>
                  </ul>
               </li>
               <li class="trans" data-sr="wait 0.1s, enter right">
                  <h3>Contact</h3>
                  <ul class="address-block">
                     <li>
                        <span class="contact-icn" ><img src="<?php  echo get_stylesheet_directory_uri(); ?>/images/contact-icn-02.png"></span>   
                        <p><a href="tel:+971 1 123 1234">+971 1 123 1234</a></p>
                     </li>
                     <li>
                        <span class="contact-icn" ><img src="<?php  echo get_stylesheet_directory_uri(); ?>/images/contact-icn-03.png"></span>   
                        <p><a href="mailto:info@regent.com">info@regent.com</a></p>
                     </li>
                  </ul>
               </li>
               <li class="trans" data-sr="wait 0.1s, enter right">
                  <h3>Office Hours</h3>
                  <ul class="address-block">
                     <li>
                        <span class="contact-icn" ><img src="<?php  echo get_stylesheet_directory_uri(); ?>/images/contact-icn-04.png"></span>   
                        <p>9:00am to 6:00pm
                           <span><i>(Monday to Friday)</i></span>
                        </p>
                     </li>
                  </ul>
               </li>
            </ul>
         </div> -->
         <div class="contact-bot-block align-center">
            <h5>Connect with us</h5>
            <ul class="contact-social">
               <li><a style="background:url(<?php echo get_stylesheet_directory_uri(); ?>/images/social-01.png) center top;" target="_blank"  href="https://www.facebook.com/regent200723"></a></li>
               <li><a style="background:url(<?php echo get_stylesheet_directory_uri(); ?>/images/social-02.png) center top;"  href="#"></a></li>
               <li><a style="background:url(<?php echo get_stylesheet_directory_uri(); ?>/images/social-03.png) center top;"  href="#"></a></li>
               <li><a style="background:url(<?php echo get_stylesheet_directory_uri(); ?>/images/social-04.png) center top;"  href="#"></a></li>
            </ul>
         </div>
      </div>
   </div>
   </div>
</section>
<?php get_footer('inner'); ?>