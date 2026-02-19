<?php get_header(''); 
   /*Template Name: HTML Veterinary Products*/
   wp_enqueue_script('script');
   add_action('wp_footer','page_script',21);
   function page_script(){
   ?> <script>


jQuery(document).ready(function(){
//  
jQuery('.main-nav > ul > li').removeClass("active");
jQuery('.main-nav > ul > :nth-child(3)').addClass("active");



});
   jQuery( document ).ready(function() {
     var swiper = new Swiper(".pro-list-slider", {
       pagination: {
         el: ".swiper-pagination",
         type: "fraction",
       },
       loop: false,
       navigation: {
         nextEl: ".swiper-button-next",
         prevEl: ".swiper-button-prev",
       },
       speed: 2000,
       autoplay: {
   		delay: 2500,
   		speed:2000,
   		disableOnInteraction: false,
   	  },
 
     });




     if (swiper.activeIndex == swiper.slides.length-1) {
         jQuery('.left-arrow').hide()
         jQuery('.right-arrow').hide()
    }




     });
</script> <?php } ?> 
<section class="inner-banner-02 pattern" style="background:url(
   <?php echo get_stylesheet_directory_uri(); ?>/images/veterinary-products-banner.jpg);background-size: cover;">
   <div class="banner-title-box">
      <h1 data-sr="wait 0.1s, enter right">Veterinary Products</h1>
      <span class="title-line"></span>
   </div>
</section>
<ul class="tabs">
 

   <li ><a href="<?php echo site_url('/product/');?>">Human Products</a></li>
   <li class="active"><a href="<?php echo site_url('/veterinary-products/');?>">Veterinary Products</a></li>




</ul>
<section class="pt-100 pb-100">
   <div class="wrap">
      <div class="title-block-vet-main">
         <h2 data-sr="wait 0.1s, enter right">By Therapies <span>Presentation</span>
         </h2>
         <ul class="veterinary-block">
            <li class="vet-temp-1">
               <div data-sr="wait 0.1s, enter right" class="vent-img-main img-w-1 rel title-position-01 flx-align-right">
                  <h2 > parasites <br> away </h2>
                  <img    class="mx-100" src="<?php echo get_stylesheet_directory_uri(); ?>/images/rgt-veterinary-img1.png" alt="image">
               </div>
               <div class="vent-txt-main txt-w-1">
                  <div class="vent-title-block" data-sr="wait 0.1s, enter right">
                     <span class="title-line-vet" style="background: #ffbac4;"></span>
                     <h2>Parasite Control <span>FIPROFORT PLUS</span>
                     </h2>
                  </div>
                  <div class="slide-block-01" data-sr="wait 0.1s, enter right">
                     <div class="swiper pro-list-slider">
                        <div class="swiper-wrapper">
                           <div class="swiper-slide">
                              <img class="mx-100" src="
                                 <?php echo get_stylesheet_directory_uri(); ?>/images/rgt-slide-img1.png" alt="image">
                           </div>
                           <div class="swiper-slide">
                              <img class="mx-100" src="
                                 <?php echo get_stylesheet_directory_uri(); ?>/images/rgt-slide-img1.png" alt="image">
                           </div>
                        </div>
                     </div>
                     <div class="swiper-button-next"><span class="slib-but">></span></div>
                     <div class="swiper-button-prev"><span class="slib-but"><</span></div>
                  </div>
               </div>
            </li>
            <li class="row-reverce vet-temp-2">
               <div class="vent-img-main img-w-2 rel title-position-02 flx-align-left flx-align-center txt-style-02" data-sr="wait 0.1s, enter right">
                  <h2>Safe<br>
                     Heart
                  </h2>
                  <img class="mx-100" src="
                     <?php echo get_stylesheet_directory_uri(); ?>/images/rgt-veterinary-img2.png" alt="image">
               </div>
               <div class="vent-txt-main txt-w-2">
                  <div class="vent-title-block" data-sr="wait 0.1s, enter right">
                     <span class="title-line-vet" style="background: #cd2f26;"></span>
                     <h2>Heart Health <span>FIPROFORT PLUS</span>
                     </h2>
                  </div>
                  <div class="slide-block-01" data-sr="wait 0.1s, enter right">
                     <div class="swiper pro-list-slider">
                        <div class="swiper-wrapper">
                           <div class="swiper-slide">
                              <img class="mx-100" src="
                                 <?php echo get_stylesheet_directory_uri(); ?>/images/rgt-slide-img2.png" alt="image">
                           </div>
                           <div class="swiper-slide">
                              <img class="mx-100" src="
                                 <?php echo get_stylesheet_directory_uri(); ?>/images/rgt-slide-img2.png" alt="image">
                           </div>
                        </div>
                     </div>
                     <div class="swiper-button-next"><span class="slib-but">></span></div>
                     <div class="swiper-button-prev"><span class="slib-but"><</span></div>
                  </div>
               </div>
            </li>
            <li class="vet-temp-3">
               <div data-sr="wait 0.1s, enter right" class="vent-img-main img-w-1 rel title-position-01 flx-align-right txt-style-02 font-size-02">
                  <h2> GUT <br>
                     Health
                  </h2>
                  <img class="mx-100" src="
                     <?php echo get_stylesheet_directory_uri(); ?>/images/rgt-veterinary-img3.png" alt="image">
               </div>
               <div class="vent-txt-main txt-w-1">
                  <div data-sr="wait 0.1s, enter right" class="vent-title-block">
                     <span class="title-line-vet" style="background: #313957;"></span>
                     <h2>Renal Health<span>RENODIS</span>
                     </h2>
                  </div>
                  <div data-sr="wait 0.1s, enter right" class="slide-block-01">
                     <div class="swiper pro-list-slider">
                        <div class="swiper-wrapper">
                           <div class="swiper-slide">
                              <img class="mx-100" src="
                                 <?php echo get_stylesheet_directory_uri(); ?>/images/rgt-slide-img3.png" alt="image">
                           </div>
                        </div>
                     </div>
                     <div class="swiper-button-next"><span class="slib-but">></span></div>
                     <div class="swiper-button-prev"><span class="slib-but"><</span></div>
                  </div>
               </div>
            </li>
            <li class="row-reverce vet-temp-4">
               <div data-sr="wait 0.1s, enter right" class="vent-img-main img-w-1 rel title-position-01 flx-align-right  ">
                  <h2> Live <br>
                     Healthy 
                  </h2>
                  <img class="mx-100" src="
                     <?php echo get_stylesheet_directory_uri(); ?>/images/rgt-veterinary-img4.png" alt="image">
               </div>
               <div class="vent-txt-main txt-w-1">
                  <div data-sr="wait 0.1s, enter right" class="vent-title-block">
                     <span class="title-line-vet" style="background: #8d3830;"></span>
                     <h2>Liver
                        Healthy<span>REVELL</span>
                     </h2>
                  </div>
                  <div data-sr="wait 0.1s, enter right" class="slide-block-01">
                     <div class="swiper pro-list-slider">
                        <div class="swiper-wrapper">
                           <div class="swiper-slide">
                              <img class="mx-100" src="
                                 <?php echo get_stylesheet_directory_uri(); ?>/images/rgt-slide-img4.png" alt="image">
                           </div>
                        </div>
                     </div>
                     <div class="swiper-button-next"><span class="slib-but">></span></div>
                     <div class="swiper-button-prev"><span class="slib-but"><</span></div>
                  </div>
               </div>
            </li>
            <li class="vet-temp-5">
               <div data-sr="wait 0.1s, enter right" class="vent-img-main img-w-1 rel title-position-01 flx-align-right  txt-style-02 font-size-02">
                  <h2>Visioncare</h2>
                  <img class="mx-100" src="
                     <?php echo get_stylesheet_directory_uri(); ?>/images/rgt-veterinary-img5.png" alt="image">
               </div>
               <div class="vent-txt-main txt-w-1">
                  <div data-sr="wait 0.1s, enter right" class="vent-title-block">
                     <span class="title-line-vet" style="background: #b8b88d;"></span>
                     <h2>Eyes and Ear<span>Earworks 100ml</span>
                     </h2>
                  </div>
                  <div data-sr="wait 0.1s, enter right" class="slide-block-01">
                     <div class="swiper pro-list-slider">
                        <div class="swiper-wrapper">
                           <div class="swiper-slide">
                              <img class="mx-100" src="
                                 <?php echo get_stylesheet_directory_uri(); ?>/images/rgt-slide-img5.png" alt="image">
                           </div>
                        </div>
                     </div>
                     <div class="swiper-button-next"><span class="slib-but">></span></div>
                     <div class="swiper-button-prev"><span class="slib-but"><</span></div>
                  </div>
               </div>
            </li>
            <li class="row-reverce vet-temp-6">
               <div data-sr="wait 0.1s, enter right" class="vent-img-main img-w-1 rel title-position-03 flx-align-right  txt-style-02 font-size-02">
                  <h2>Reflection</h2>
                  <img class="mx-100" src="
                     <?php echo get_stylesheet_directory_uri(); ?>/images/rgt-veterinary-img6.png" alt="image">
               </div>
               <div class="vent-txt-main txt-w-5">
                  <div data-sr="wait 0.1s, enter right" class="vent-title-block">
                     <span class="title-line-vet" style="background: #38405f;"></span>
                     <h2>Skin Range<span>Vetachlor-M</span>
                     </h2>
                  </div>
                  <div data-sr="wait 0.1s, enter right" class="slide-block-01">
                     <div class="swiper pro-list-slider">
                        <div class="swiper-wrapper">
                           <div class="swiper-slide">
                              <img class="mx-100" src="
                                 <?php echo get_stylesheet_directory_uri(); ?>/images/rgt-slide-img6.png" alt="image">
                           </div>
                        </div>
                     </div>
                     <div class="swiper-button-next"><span class="slib-but">></span></div>
                     <div class="swiper-button-prev"><span class="slib-but"><</span></div>
                  </div>
               </div>
            </li>
            <li class="vet-temp-7">
               <div data-sr="wait 0.1s, enter right" class="vent-img-main img-w-1 rel title-position-04 flx-align-right  ">
                  <h2>life<br>
                     cured
                  </h2>
                  <img class="mx-100" src="
                     <?php echo get_stylesheet_directory_uri(); ?>/images/rgt-veterinary-img7.png" alt="image">
               </div>
               <div class="vent-txt-main txt-w-1">
                  <div data-sr="wait 0.1s, enter right" class="vent-title-block">
                     <span class="title-line-vet" style="background: #105985;"></span>
                     <h2>Immunotherapy<span>Ataxin 50</span>
                     </h2>
                  </div>
                  <div data-sr="wait 0.1s, enter right" class="slide-block-01">
                     <div class="swiper pro-list-slider">
                        <div class="swiper-wrapper">
                           <div class="swiper-slide">
                              <img class="mx-100" src="
                                 <?php echo get_stylesheet_directory_uri(); ?>/images/rgt-slide-img7.png" alt="image">
                           </div>
                        </div>
                     </div>
                     <!-- <div class="swiper-button-next"><span class="slib-but">></span></div>
                     <div class="swiper-button-prev"><span class="slib-but"><</span></div> -->
                  </div>
               </div>
            </li>
            <li class="row-reverce vet-temp-8" >
               <div data-sr="wait 0.1s, enter right" class="vent-img-main img-w-1 rel title-position-05 flx-align-right font-size-02 txt-style-02  ">
                  <h2>Prevention</h2>
                  <img class="mx-100" src="
                     <?php echo get_stylesheet_directory_uri(); ?>/images/rgt-veterinary-img8.png" alt="image">
               </div>
               <div class="vent-txt-main txt-w-1">
                  <div data-sr="wait 0.1s, enter right" class="vent-title-block">
                     <span class="title-line-vet" style="background: #c2b492;"></span>
                     <h2>Anti Infective<span>Bonhans</span>
                     </h2>
                  </div>
                  <div data-sr="wait 0.1s, enter right" class="slide-block-01">
                     <div class="swiper pro-list-slider">
                        <div class="swiper-wrapper">
                           <div class="swiper-slide">
                              <img class="mx-100" src="<?php echo get_stylesheet_directory_uri(); ?>/images/rgt-slide-img8.png" alt="image">
                           </div>
                           <div class="swiper-slide">
                              <img class="mx-100" src="<?php echo get_stylesheet_directory_uri(); ?>/images/rgt-slide-img8.png" alt="image">
                           </div>
                        </div>
                     </div>
                     <div class="swiper-button-next"><span class="slib-but">></span></div>
                     <div class="swiper-button-prev"><span class="slib-but"><</span></div>
                  </div>
               </div>
            </li>
            <li class="vet-temp-9">
               <div data-sr="wait 0.1s, enter right" class="vent-img-main img-w-1 rel title-position-06 flx-align-right  ">
                  <h2>SMART<br>
                     IRON
                  </h2>
                  <img class="mx-100" src="
                     <?php echo get_stylesheet_directory_uri(); ?>/images/rgt-veterinary-img9.png" alt="image">
               </div>
               <div class="vent-txt-main txt-w-1">
                  <div  data-sr="wait 0.1s, enter right" class="vent-title-block">
                     <span class="title-line-vet" style="background: #c9a668;"></span>
                     <h2>Recovery<span>Electrolyte Supplement </span>
                     </h2>
                  </div>
                  <div data-sr="wait 0.1s, enter right" class="slide-block-01">
                     <div class="swiper pro-list-slider">
                        <div class="swiper-wrapper">
                           <div class="swiper-slide">
                              <img class="mx-100" src="
                                 <?php echo get_stylesheet_directory_uri(); ?>/images/rgt-slide-img9.png" alt="image">
                           </div>
                        </div>
                     </div>
                     <!-- <div class="swiper-button-next"><span class="slib-but">></span></div>
                     <div class="swiper-button-prev"><span class="slib-but"><</span></div> -->
                  </div>
               </div>
            </li>
            <li class="row-reverce  vet-temp-10">
               <div data-sr="wait 0.1s, enter right" class="vent-img-main img-w-3 rel title-position-07 font-size-02 txt-style-02 flx-align-right  ">
                  <h2>Oral<br>
                     Hygiene
                  </h2>
                  <img class="mx-100" src="
                     <?php echo get_stylesheet_directory_uri(); ?>/images/rgt-veterinary-img10.png" alt="image">
               </div>
               <div class="vent-txt-main txt-w-3">
                  <div data-sr="wait 0.1s, enter right" class="vent-title-block">
                     <span class="title-line-vet" style="background: #2c8485;"></span>
                     <h2>Oral<span>Probiotic Dental Drops</span>
                     </h2>
                  </div>
                  <div data-sr="wait 0.1s, enter right" class="slide-block-01 slider-itm-align-right">
                     <div class="swiper pro-list-slider">
                        <div class="swiper-wrapper">
                           <div class="swiper-slide">
                              <img class="mx-100" src="
                                 <?php echo get_stylesheet_directory_uri(); ?>/images/rgt-slide-img10.png" alt="image">
                           </div>
                        </div>
                     </div>
                     <!-- <div class="swiper-button-next"><span class="slib-but">></span></div>
                     <div class="swiper-button-prev"><span class="slib-but"><</span></div> -->
                  </div>
               </div>
            </li>
            <li class="vet-temp-11">
               <div data-sr="wait 0.1s, enter right" class="vent-img-main img-w-4 rel title-position-08 flx-align-right  ">
                  <h2>Improved<br>
                     care
                  </h2>
                  <img class="mx-100" src="
                     <?php echo get_stylesheet_directory_uri(); ?>/images/rgt-veterinary-img11.png" alt="image">
               </div>
               <div class="vent-txt-main txt-w-4">
                  <div data-sr="wait 0.1s, enter right" class="vent-title-block">
                     <span class="title-line-vet" style="background: #8d3830;"></span>
                     <h2>Wellness<span>VAAV</span>
                     </h2>
                  </div>
                  <div data-sr="wait 0.1s, enter right" class="slide-block-01">
                     <div class="swiper pro-list-slider">
                        <div class="swiper-wrapper">
                           <div class="swiper-slide">
                              <img class="mx-100" src="
                                 <?php echo get_stylesheet_directory_uri(); ?>/images/rgt-slide-img11.png" alt="image">
                           </div>
                        </div>
                     </div>
                     <!-- <div class="swiper-button-next"><span class="slib-but">></span></div>
                     <div class="swiper-button-prev"><span class="slib-but"><</span></div> -->
                  </div>
               </div>
            </li>
         </ul>
      </div>
   </div>
</section>
<?php get_footer('inner'); ?>