<?php get_header('black'); 
   /*Template Name: HTML SEO*/
   wp_enqueue_script('script');
   add_action('wp_footer','page_script',21);
   function page_script(){
   ?>
<script></script>
<?php } ?>
<section class="inner-banner">
   <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/seo-banner.jpg" />
</section>
<section>
   <div class="container-02">
      <ul class="tab-menu-ul">
         <li  data-sr="wait 0.1s, enter right">
            <a href="<?php echo site_url('/graphic-design/');?>" style="background:url(<?php echo get_stylesheet_directory_uri(); ?>/images/graphic-design.jpg)">
            <span class="tab-txt">Graphic Design</span>
            </a>
         </li>
         <li  data-sr="wait 0.1s, enter right">
            <a href="<?php echo site_url('/online-advertising/');?>" style="background:url(<?php echo get_stylesheet_directory_uri(); ?>/images/online-advertising.jpg)">
            <span class="tab-txt">Online Advertising</span>
            </a>
         </li>
         <li  data-sr="wait 0.1s, enter right">
            <a href="<?php echo site_url('/advertising/');?>" style="background:url(<?php echo get_stylesheet_directory_uri(); ?>/images/advertising.jpg)">
            <span class="tab-txt">Advertising</span>
            </a>
         </li>
         <li class="active-tab" data-sr="wait 0.1s, enter right">
            <a href="<?php echo site_url('/seo/');?>" style="background:url(<?php echo get_stylesheet_directory_uri(); ?>/images/seo.jpg)">
            <span class="tab-txt">SEO</span>
            </a>
         </li>
         <li data-sr="wait 0.1s, enter right">
            <a href="<?php echo site_url('/social-media/');?>" style="background:url(<?php echo get_stylesheet_directory_uri(); ?>/images/social-media.jpg)">
            <span class="tab-txt">Social Media</span>
            </a>
         </li>
         <li data-sr="wait 0.1s, enter right">
            <a href="<?php echo site_url('/video-production/');?>" style="background:url(<?php echo get_stylesheet_directory_uri(); ?>/images/video-production.jpg)">
            <span class="tab-txt">Video Production</span>
            </a>
         </li>
      </ul>
   </div>
</section>
<section class="pt-100 ">
   <div class="max-750 align-center pb-60" data-sr="wait 0.1s, enter right">
      <p>
         Lorem Ipsum is simply dummy text of the printing and typesetting industry. 
         Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, 
         when an unknown printer tobut also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s.
      </p>
      <p>with the release of Letraset sheets containing Lorem Ipsum passages.</p>
   </div>
   <div class="container-02">
      <div class="align-center title-50" data-sr="wait 0.1s, enter right">
         <h2>SEO Services</h2>
      </div>
      <ul class="service-block-ul mt-35">
         <li class="mb-60">
            <div class="service-block-a">
               <div data-sr="wait 0.1s, enter right" class="service-img-block"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/seo-01.jpg" /></div>
               <div data-sr="wait 0.1s, enter right" style="border-top: solid 3px #fdb831;" class="service-txt-block">
                  <h3>
                     Local SEO
                  </h3>
                  <p>
                     Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam tristique augue eget nisi porttitor viverra. orci.
                  </p>
                  <!-- <a href="#" class="more-but"><span class="icon-arrow-1"></span>view details</a> -->
               </div>
            </div>
         </li>
         <li class="mb-60">
            <div class="service-block-a">
               <div data-sr="wait 0.1s, enter right" class="service-img-block"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/seo-02.jpg" /></div>
               <div data-sr="wait 0.1s, enter right" style="border-top: solid 3px #d7573a;" class="service-txt-block">
                  <h3>
                     SEO
                  </h3>
                  <p>
                     Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam tristique augue eget nisi porttitor viverra. orci.
                  </p>
                  <!-- <a href="#" class="more-but"><span class="icon-arrow-1"></span>view details</a> -->
               </div>
            </div>
         </li>
         <li class="mb-60">
            <div class="service-block-a">
               <div data-sr="wait 0.1s, enter right" class="service-img-block"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/seo-03.jpg" /></div>
               <div data-sr="wait 0.1s, enter right" style="border-top: solid 3px #ffffff;" class="service-txt-block">
                  <h3>
                     Technical SEO
                  </h3>
                  <p>
                     Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam tristique augue eget nisi porttitor viverra. orci.
                  </p>
                  <!-- <a href="#" class="more-but"><span class="icon-arrow-1"></span>view details</a> -->
               </div>
            </div>
         </li>
         <li class="mb-60">
            <div class="service-block-a">
               <div data-sr="wait 0.1s, enter right" class="service-img-block"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/seo-04.jpg" /></div>
               <div data-sr="wait 0.1s, enter right" style="border-top: solid 3px #fdb831;" class="service-txt-block">
                  <h3>
                     SEO Copyrighting
                  </h3>
                  <p>
                     Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam tristique augue eget nisi porttitor viverra. orci.
                  </p>
                  <!-- <a href="#" class="more-but"><span class="icon-arrow-1"></span>view details</a> -->
               </div>
            </div>
         </li>
         <li class="mb-60">
            <div class="service-block-a">
               <div data-sr="wait 0.1s, enter right" class="service-img-block"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/seo-05.jpg" /></div>
               <div data-sr="wait 0.1s, enter right" style="border-top: solid 3px #fdb831;" class="service-txt-block">
                  <h3>
                     Marketplace SEO
                  </h3>
                  <p>
                     Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam tristique augue eget nisi porttitor viverra. orci.
                  </p>
                  <!-- <a href="#" class="more-but"><span class="icon-arrow-1"></span>view details</a> -->
               </div>
            </div>
         </li>
      </ul>
   </div>
</section>
<section class="pt-50">
   <div class="container px-2">
   <div class=" align-center mb-100 title-03 title-50">
      <h2 data-sr="wait 0.1s, enter right">Related Works</h2>
   </div>
</section>
<section class="pb-100 inner-slide-recent">
   <div class="slider-row" data-sr="wait 0.1s, enter right">
      <!-- Slider main container -->
      <div class="home-slider swiper">
         <!-- Additional required wrapper -->
         <div class="swiper-wrapper ">
            <!-- Slides -->
            <div class="swiper-slide">
               <div class="swipper-img-box">
                  <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/slider-img-01.jpg">
               </div>
               <div class="swipper-txt-box">
                  <div class="swipper-txt-left">
                     <h3>Business Cards</h3>
                     <p>Basic information about a person</p>
                  </div>
                  <div class="swipper-txt-right">
                     <a href="#"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/arrow-more.png"></a>
                  </div>
               </div>
            </div>
            <div class="swiper-slide">
               <div class="swipper-img-box">
                  <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/slider-img-02.jpg">
               </div>
               <div class="swipper-txt-box">
                  <div class="swipper-txt-left">
                     <h3>Business Cards</h3>
                     <p>Basic information about a person</p>
                  </div>
                  <div class="swipper-txt-right">
                     <a href="#"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/arrow-more.png"></a>
                  </div>
               </div>
            </div>
            <div class="swiper-slide">
               <div class="swipper-img-box">
                  <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/slider-img-03.jpg">
               </div>
               <div class="swipper-txt-box">
                  <div class="swipper-txt-left">
                     <h3>Business Cards</h3>
                     <p>Basic information about a person</p>
                  </div>
                  <div class="swipper-txt-right">
                     <a href="#"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/arrow-more.png"></a>
                  </div>
               </div>
            </div>
            <div class="swiper-slide">
               <div class="swipper-img-box">
                  <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/slider-img-04.jpg">
               </div>
               <div class="swipper-txt-box">
                  <div class="swipper-txt-left">
                     <h3>Business Cards</h3>
                     <p>Basic information about a person</p>
                  </div>
                  <div class="swipper-txt-right">
                     <a href="#"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/arrow-more.png"></a>
                  </div>
               </div>
            </div>
            <div class="swiper-slide">
               <div class="swipper-img-box">
                  <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/slider-img-05.jpg">
               </div>
               <div class="swipper-txt-box">
                  <div class="swipper-txt-left">
                     <h3>Business Cards</h3>
                     <p>Basic information about a person</p>
                  </div>
                  <div class="swipper-txt-right">
                     <a href="#"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/arrow-more.png"></a>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<?php get_footer('inner'); ?>