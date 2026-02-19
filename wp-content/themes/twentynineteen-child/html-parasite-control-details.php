<?php get_header(''); 
   /*Template Name: HTML Parasite control Details*/
   wp_enqueue_script('script');
   add_action('wp_footer','page_script',21);
   function page_script(){
   ?>
<script>
   jQuery(document).ready(function () {
   //   jQuery(".card-slider").owlCarousel({
   //     loop: true,
   //     margin: 35,
   //     dots: false,
   //     nav: true,
   //     navText: [
   //       '<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/owl-arw-prev.png" alt="image">',
   //       '<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/owl-arw-next.png" alt="image">',
   //     ],
   //     autoplay: false,
   //     smartSpeed: 1450,
   //     autoplaySpeed: 2500,
   //     center:true,
   //     items: 1,
   //     responsive: {
   //       0: {
   //         items: 2,
   //       },
   //       600: {
   //         items: 3,
   //         margin: 20,
   //       },
   //       1000: {
   //         items: 3,
   //         margin:20,
   //       },
   //     },
   //   });
   });
</script>
<?php } ?>
<section class="pt-120 pb-120 border-top">
   <div class="wrap">
      <div class="single-details">
         <div class="left-side" data-sr="wait 0.1s, enter right">
            <img class="object-contain" src="<?php echo get_stylesheet_directory_uri(); ?>/images/rgt-product-image.jpg" alt="image">
         </div>
         <div class="right-side">
            <div class="inner pb-50">
               <div data-sr="wait 0.1s, enter right">
                  <span class="brand">Farm Enrofloxacin Tablets</span>
                  <h2>Ataxin</h2>
                  <span class="gram">50mg</span>
                  <p>Quisque pharetra tristique neque, non commodo elit. Integer blandit erat in vestibulum tempor. Vestibulum cursus lobortis augue nec tincidunt. Aliquam iaculis enim vitae ligula pellentesque.</p>
                  <p>Pellentesque dignissim ligula eleifend volutpat placerat. Vestibulum in sapien vitae orci finibus condimentum ac sed libero. Donec nisi augue, viverra commodo pulvinar at, maximus sit amet sapien. Pellentesque nec sodales mauris, nec consectetur nunc. Praesent id porttitor leo. </p>
               </div>
               <div data-sr="wait 0.1s, enter right"><a class="but-01  blue-but but-style-02" href="#" style="visibility: visible; ">Get in Touch</a></div>
            </div>
         </div>
      </div>
   </div>
</section>
<section>
   <div class="flx-row blue-text-border">
      <div class="impact-txt padding-left pt-30 pb-30" data-sr="wait 0.1s, enter right">
         <h3>Description</h3>
      </div>
      <div class="count-box padding-right">
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
            <ul class=" swiper-wrapper card-slider product-list-block style" data-sr="wait 0.1s, enter right">
               <li class="swiper-slide">
                  <div class="product-item">
                     <div class="image">
                        <a href="<?php echo site_url('/parasite-control-details');?>"><img class="res-img-contain" src="<?php echo get_stylesheet_directory_uri(); ?>/images/rgt-new-img1.jpg" alt="image"></a>
                     </div>
                     <div class="content">
                        <ul class="view-options">
                           <li><a href="#"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/search-icn.svg"
                              alt="image"></a></li>
                           <li><a href="#"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/heart-icn.svg" alt="image"></a>
                           </li>
                        </ul>
                        <h3><a href="<?php echo site_url('/parasite-control-details');?>">Exilar 20mg 4 Tab</a></h3>
                        <p>Tadalafil, an oral treatment for erectile dysfunction, is a selective...</p>
                     </div>
                  </div>
               </li>
               <li class="swiper-slide">
                  <div class="product-item">
                     <div class="image">
                        <a href="<?php echo site_url('/parasite-control-details');?>"><img class="res-img-contain" src="<?php echo get_stylesheet_directory_uri(); ?>/images/rgt-new-img2.jpg" alt="image"></a>
                     </div>
                     <div class="content">
                        <ul class="view-options">
                           <li><a href="<?php echo site_url('/parasite-control-details');?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/search-icn.svg"
                              alt="image"></a></li>
                           <li><a href="#"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/heart-icn.svg" alt="image"></a>
                           </li>
                        </ul>
                        <h3><a href="<?php echo site_url('/parasite-control-details');?>">Exilar-Max 60mg + 20mg 4 Tab</a></h3>
                        <p>Tadalafil, an oral treatment for erectile dysfunction, is a selective...</p>
                     </div>
                  </div>
               </li>
               <li class="swiper-slide">
                  <div class="product-item">
                     <div class="image">
                        <a href="<?php echo site_url('/parasite-control-details');?>"><img class="res-img-contain" src="<?php echo get_stylesheet_directory_uri(); ?>/images/rgt-new-img3.jpg" alt="image"></a>
                     </div>
                     <div class="content">
                        <ul class="view-options">
                           <li><a href="#"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/search-icn.svg"
                              alt="image"></a></li>
                           <li><a href="#"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/heart-icn.svg" alt="image"></a>
                           </li>
                        </ul>
                        <h3><a href="<?php echo site_url('/parasite-control-details');?>">Finsava 1 mg 30 Tab</a></h3>
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