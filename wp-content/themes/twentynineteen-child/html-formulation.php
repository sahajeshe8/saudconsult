<?php get_header('');
   /*Template Name: HTML Formulation*/
   wp_enqueue_script('script');
   add_action('wp_footer','page_script',21);
   function page_script(){
   ?>
<script>

jQuery(document).ready(function(){
//  
jQuery('.main-nav > ul > li').removeClass("active");
jQuery('.main-nav > ul :nth-child(4)').addClass("active");



});




   new Swiper('.reserch-slider', {
           loop: true,
           // nextButton: '.swiper-button-next',
           // prevButton: '.swiper-button-prev',
   		navigation: {
   		  	nextEl: ".pro-next",
   		  prevEl: ".pro-prev",
   		},
           slidesPerView: 2,
           paginationClickable: true,
    		speed:1500,
   		autoplay: false,
           breakpoints: {
               1920: {
                   slidesPerView: 3,
                   spaceBetween:  90
               },
               1028: {
                   slidesPerView: 3,
                   autoplay: {
   					delay: 3000,
   			 	  } ,
                   spaceBetween: 40
               },
               480: {
                   slidesPerView: 3,
                   spaceBetween: 20,
                   autoplay: {
   					delay: 3000,
   			 	  } 
               },
               0: {
                   slidesPerView: 2,
                   spaceBetween: 10,
                   speed:1500,
                     autoplay: {
   					delay: 3000,
   			 	  } 
               }
           }
       });



       jQuery('.counter').countUp();



</script>
<?php } ?>
<section class="inner-banner-02 pattern"style="background:url(<?php echo get_stylesheet_directory_uri(); ?>/images/formulation-banner.jpg) center bottom; background-size: cover;">
   <div class="banner-title-box">
      <h1 data-sr="wait 0.1s, enter right">Formulation Development</h1>
      <span class="title-line"></span>
   </div>
</section>
<section class="tab-row-02" data-sr="wait 0.1s, enter right">
   <ul>
      <li class="w-50 text-center align-center active-tab"><a href="<?php echo site_url('/formulation/');?>">Formulation Development</a></li>
      <li class="w-50 text-center align-center "><a href="<?php echo site_url('/analytical-development/');?>">Analytical Development</a></li>
   </ul>
</section>
<section class="pt-100 pb-30">
   <div class="wrap">
      <div class="flx-row center-align mob-top-align">
         <div class="w-50 analytical-img-block" data-sr="wait 0.1s, enter right">
            <img class="mx-100"  src="<?php  echo get_stylesheet_directory_uri(); ?>/images/formulation-img-01.jpg">
         </div>
         <div class="w-50 txt-block-01a b-r-line rel analytical-txt-block list-01a">
            <h2>
               Formulation R&D
            </h2>
            <p>Regent offers Formulation Development & Contract Manufacturing services. The state-of -the-art formulation development facility is certified by (Department of Science & Industrial Research) Government of India and is having research team compressing of over 40 senior scientists who have expertise across the therapeutic areas and geographies for generics and other differentiated products ranging from Nasal Sprays, Dry Powder Inhalers, Metered dose Inhalers and Tablets (Immediate / sustained/ extended / controlled/ delayed release and Bi -layered tablets), Capsules,
Ointments, Creams, Sterile ophthalmic ointments/gels and Sterile General Ointments/gels.</p>
<p>Experienced scientific man power and well established systems, able to support with documents for registrations in ROW/Regulated Markets</p>
         </div>
      </div>
   </div>
</section>
<section class="pt-30 pb-30">
   <div class="wrap">
      <h2 data-sr="wait 0.1s, enter right">Areas of Focus</h2>
      <ul class="areas-ul">
         <li data-sr="wait 0.1s, enter right">
            <span class="border-style-01">
               <h3>
                  <a href="#">Dry Powder Inhalers,Metered dose inhaler, Nasal Sprays </a>
               </h3>
            </span>
         </li>
        
         <li data-sr="wait 0.1s, enter right">
            <span class="border-style-01">
               <h3>
                  <a href="#">Sterile ophthalmic ointments/gels</a>
               </h3>
            </span>
         </li>
         <li data-sr="wait 0.1s, enter right">
            <span class="border-style-01">
               <h3>
                  <a href="#">Sterile General Ointments/gels</a>
               </h3>
            </span>
         </li>
         <li data-sr="wait 0.1s, enter right">
            <span class="border-style-01">
               <h3>
                  <a href="#">Capsules</a>
               </h3>
            </span>
         </li>
         
       
         <li data-sr="wait 0.1s, enter right" class="border-none">
            <span class="border-style-01">
               <h3>
                  <a href="#">Ointments and creams </a>
               </h3>
            </span>
         </li>
        
         <li data-sr="wait 0.1s, enter right" class="border-none">
            <span class="border-style-01">
               <h3>
                  <a href="#">Tablets <span>Immediate / sustained/ extended / controlled/ delayed release and Bi -layered tablets</span></a>
               </h3>
            </span>
         </li>
        
         
      </ul>
   </div>
</section>
<section class="pt-50 pb-50">
   <div class="flx-row">
      <div class="impact-txt padding-left pt-35 pb-35" data-sr="wait 0.1s, enter right">
         <h3>Our Impacts</h3>
      </div>
      <div class="count-box padding-right">
         <ul>
            <li data-sr="wait 0.1s, enter right">
               <div class="count-block">
                  <span class="count-numb counter count-01">300</span>
                  <span class="count-txt">
                     <span class="plus-icn">+</span>
                     <p>Formulation <br>Development</p>
                  </span>
                  <div class="mob-show-count"><p>Formulation <br>Development</p></div>
               </div>
            </li>
            <li data-sr="wait 0.1s, enter right">
               <div class="count-block">
                  <span class="count-numb counter count-02">20</span>
                  <span class="count-txt">
                  <span class="plus-icn">+</span>
                     <p>Formulation<br>
                        in pipeline
                     </p>
                  </span>
                  <div class="mob-show-count"><p>Formulation  in pipeline</p></div>
               </div>
            </li>
            <li data-sr="wait 0.1s, enter right">
               <div class="count-block">
                  <span class="count-numb counter count-03">20</span>
                  <span class="count-txt">
                     <span class="plus-icn">+</span>
                     <p>Contract <br>projects</p>
                  </span>
                  <div class="mob-show-count"><p>Contract projects</p></div>
               </div>
            </li>
         </ul>
      </div>
   </div>
</section>
<section class="pt-80 pb-100 service-padding-a1">
   <div class="wrap">
      <div class="b-l-line w-100 rel padding-style-01 ">
         <h2 data-sr="wait 0.1s, enter right">R&D Services</h2>
         <div data-sr="wait 0.1s, enter right">
            <p>The key R&D activities in support to the formulation development are as follows,</p>
         </div>
         <div class="list-position pl-0">
         <ul class="list-style-tick">
            <li data-sr="wait 0.1s, enter right">Pre formulation studies</li>
            <li data-sr="wait 0.1s, enter right">Prototype development and Stability Studies</li>
            <li data-sr="wait 0.1s, enter right">Process Optimization / Validation Studies</li>
            <li data-sr="wait 0.1s, enter right">Lab / Pilot Scale-up studies</li>
            <li data-sr="wait 0.1s, enter right">Stability studies as per ICH guidance</li>
             <li data-sr="wait 0.1s, enter right">Technical support to manufacturing / commercial locations</li>
             <li data-sr="wait 0.1s, enter right">Technology transfer of new products to manufacturing / commercial locations</li>
            <li data-sr="wait 0.1s, enter right">Preparation of product development reports(PDR), master formula records(MFR) etc. </li>
         </ul>
      </div>
      </div>
   </div>
</section>
<section class="pt-40 pb-100">
   <div class="wrap">
      <div class="flx-row">
         <div class="reserch-txt-block-01"  data-sr="wait 0.1s, enter right" >
            <h2>
               R&D
            </h2>
         </div>
         <div class="reserch-txt-block-02">
            <div class="swiper-container reserch-slider"  data-sr="wait 0.1s, enter right" >
               <!-- Additional required wrapper -->
               <div class="swiper-wrapper">
                  <div class="swiper-slide zoom-ef">
                     <a href="<?php echo site_url('/formulation/');?>" class="slider-link">
                        <!-- <div class="slider-txt-block">
                           <h4>scientific Discovery</h4>
                           </div> -->
                        <div class="pro-slide-img">
                           <img class="res-img"  src="<?php  echo get_stylesheet_directory_uri(); ?>/images/rd-img-01.jpg">
                        </div>
                     </a>
                  </div>
                  <div class="swiper-slide zoom-ef">
                     <a href="<?php echo site_url('/formulation/');?>" class="slider-link">
                        <!-- <div class="slider-txt-block">
                           <h4>scientific Discovery</h4>
                           </div> -->
                        <div class="pro-slide-img">
                           <img class="res-img"  src="<?php  echo get_stylesheet_directory_uri(); ?>/images/rd-img-02.jpg">
                        </div>
                     </a>
                  </div>
                  <div class="swiper-slide zoom-ef">
                     <a href="<?php echo site_url('/formulation/');?>" class="slider-link">
                        <!-- <div class="slider-txt-block">
                           <h4>scientific Discovery</h4>
                           </div> -->
                        <div class="pro-slide-img">
                           <img class="res-img"  src="<?php  echo get_stylesheet_directory_uri(); ?>/images/rd-img-03.jpg">
                        </div>
                     </a>
                  </div>
               </div>
               <!-- If we need navigation buttons -->
            </div>
         </div>
      </div>
   </div>
</section>
<?php get_footer('inner'); ?>