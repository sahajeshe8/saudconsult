<?php get_header(''); 
   /*Template Name: HTML Respiratory Products Details*/
   wp_enqueue_script('script');
   add_action('wp_footer','page_script',21);
   function page_script(){
   ?>
<script></script>
<?php } ?>
<section class="pt-120 pb-120 border-top">
   <div class="wrap">
      <div class="single-details">
         <div class="left-side" data-sr="wait 0.1s, enter right">
            <img  class="object-contain" src="<?php echo get_stylesheet_directory_uri(); ?>/images/rgt-product-image2.png" alt="image">
         </div>
         <div class="right-side">
            <div class="inner pb-50">
               <span data-sr="wait 0.1s, enter right" class="brand">Dapoxetine and Tadalafil Tablets</span>
               <h2 data-sr="wait 0.1s, enter right">Exilar-Max</h2>
               <div data-sr="wait 0.1s, enter right">
                  <span class="gram">60mg + 20mg 4 Tab</span>
                  <p>Quisque pharetra tristique neque, non commodo elit. Integer blandit erat in vestibulum tempor. Vestibulum cursus lobortis augue nec tincidunt. Aliquam iaculis enim vitae ligula pellentesque.</p>
                  <p>Pellentesque dignissim ligula eleifend volutpat placerat. Vestibulum in sapien vitae orci finibus condimentum ac sed libero. Donec nisi augue, viverra commodo pulvinar at, maximus sit amet sapien. Pellentesque nec sodales mauris, nec consectetur nunc. Praesent id porttitor leo. </p>
               </div>
               <div data-sr="wait 0.1s, enter right"><a  href="#" class="blue-btn">Get in Touch</a></div>
            </div>
         </div>
      </div>
   </div>
</section>
<section>
   <div class="flx-row blue-text-border padding-right">
      <div class="impact-txt padding-left pt-25 pb-25" data-sr="wait 0.1s, enter right">
         <h3>Description</h3>
      </div>
      <div class="count-box  ">
         <div class="txt-block" data-sr="wait 0.1s, enter right">
            <p>Pharetra tristique neque, non commodo elit. Integer blandit erat in vestibulum tempor. Vestibulum cursus lobortis augue nec tincidunt. Aliquam iaculis enim vitae ligula pellentesque.  Pellentesque dignissim ligula eleifend volutpat placerat. Vestibulum in sapien vitae orci finibus condimentum ac sed libero.</p>
         </div>
      </div>
   </div>
</section>
<section class="pt-150 pb-100">
   <div class="wrap">
      <div class="related-product">
         <div class="title-row-02 mb-40">
            <h2 data-sr="wait 0.1s, enter right">Related Products</h2>
            <div class="slider-nav" data-sr="wait 0.1s, enter right">
               <div class="swipper-but rel-prev swipper-prev icon-arrow-1"></div>
               <div class="swipper-but rel-next swipper-next icon-arrow-1"></div>
            </div>
         </div>
         <div class="swiper-rel swiper-wrap over-flow-true">
            <ul class=" swiper-wrapper card-slider product-list-block style"  >
               <li class="swiper-slide">
                  <div class="product-item">
                     <div class="image">
                        <a href="<?php echo site_url('/respiratory-products-details');?>"><img class="res-img-contain" src="<?php echo get_stylesheet_directory_uri(); ?>/images/rgt-new-img1.jpg" alt="image"></a>
                     </div>
                     <div class="content">
                        <ul class="view-options">
                           <li><a href="#"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/search-icn.svg"
                              alt="image"></a></li>
                           <li><a href="#"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/heart-icn.svg" alt="image"></a>
                           </li>
                        </ul>
                        <h3><a href="<?php echo site_url('/respiratory-products-details');?>">Exilar 20mg 4 Tab</a></h3>
                        <p>Tadalafil, an oral treatment for erectile dysfunction, is a selective...</p>
                     </div>
                  </div>
               </li>
               <li class="swiper-slide">
                  <div class="product-item">
                     <div class="image">
                        <a href="<?php echo site_url('/respiratory-products-details');?>"><img class="res-img-contain" src="<?php echo get_stylesheet_directory_uri(); ?>/images/rgt-new-img2.jpg" alt="image"></a>
                     </div>
                     <div class="content">
                        <ul class="view-options">
                           <li><a href="<?php echo site_url('/respiratory-products-details');?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/search-icn.svg"
                              alt="image"></a></li>
                           <li><a href="#"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/heart-icn.svg" alt="image"></a>
                           </li>
                        </ul>
                        <h3><a href="<?php echo site_url('/respiratory-products-details');?>">Exilar-Max 60mg + 20mg 4 Tab</a></h3>
                        <p>Tadalafil, an oral treatment for erectile dysfunction, is a selective...</p>
                     </div>
                  </div>
               </li>
               <li class="swiper-slide">
                  <div class="product-item">
                     <div class="image">
                        <a href="<?php echo site_url('/respiratory-products-details');?>"><img class="res-img-contain" src="<?php echo get_stylesheet_directory_uri(); ?>/images/rgt-new-img3.jpg" alt="image"></a>
                     </div>
                     <div class="content">
                        <ul class="view-options">
                           <li><a href="#"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/search-icn.svg"
                              alt="image"></a></li>
                           <li><a href="#"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/heart-icn.svg" alt="image"></a>
                           </li>
                        </ul>
                        <h3><a href="<?php echo site_url('/respiratory-products-details');?>">Finsava 1 mg 30 Tab</a></h3>
                        <p>Tadalafil, an oral treatment for erectile dysfunction, is a selective...</p>
                     </div>
                  </div>
               </li>
            </ul>
         </div>
      </div>
   </div>
</section>
<?php get_footer('inner'); ?>