<?php get_header(''); 
   /*Template Name: HTML Analytical Development*/
   wp_enqueue_script('script');
   add_action('wp_footer','page_script',21);
   function page_script(){
   ?>
<script>



jQuery(document).ready(function(){
//  
jQuery('.main-nav > ul > li').removeClass("active");
jQuery('.main-nav > ul > :nth-child(4)').addClass("active");



});

   new Swiper('.reserch-slider', {
         loop: false,
         // nextButton: '.swiper-button-next',
         // prevButton: '.swiper-button-prev',
   navigation: {
     	nextEl: ".pro-next",
     prevEl: ".pro-prev",
   },
         slidesPerView: 2,
         paginationClickable: true,
         spaceBetween: 0,
         speed:1500,
         autoplay: {
   			     delay: 3000,
   	 	  },
         breakpoints: {
             1920: {
                 slidesPerView: 3,
                 spaceBetween:  90,
                 
             },
             1028: {
                 slidesPerView: 3,
                 spaceBetween:  80
             },
             480: {
                 slidesPerView: 3,
                 spaceBetween: 20,
                 loop: true,
                 speed:1000,
                 
             },
             0: {
                 slidesPerView: 2,
                 spaceBetween: 10,
                 speed:1000,
                 loop: true,
                 
             }
         }
     });
</script>
<?php } ?>
<section class="inner-banner-02 pattern"style="background:url(<?php echo get_stylesheet_directory_uri(); ?>/images/analytical-banner.jpg) center bottom; background-size: cover;">
   <div class="banner-title-box"  data-sr="wait 0.1s, enter right" >
      <h1>Analytical Development</h1>
      <span class="title-line"></span>
   </div>
</section>
<section class="tab-row-02">
   <ul>
 
      <li class="w-50 text-center align-center "><a href="<?php echo site_url('/formulation/');?>">Formulation Development</a></li>
      <li class="w-50 text-center align-center active-tab"><a href="<?php echo site_url('/analytical-development/');?>">Analytical Development</a></li>
   </ul>
</section>
<section class="pt-100 pb-30">
   <div class="wrap">
      <div class="flx-row top-align">
         <div class=" analytical-img-block  analytical-img-block-w"  data-sr="wait 0.1s, enter right" >
            <img class="mx-100"  src="<?php  echo get_stylesheet_directory_uri(); ?>/images/analytical-img-01.jpg">
         </div>
         <div class=" analytical-txt-block-w txt-block-01a rel analytical-txt-block list-01a pb-0 title-bold" >
            <h2>
               Analytical Development Laboratory
            </h2>
            <p>Brief Description of activities in Analytical development (ADL) department is as below:
R&D activities in support to the analytical development are as follows,
            </p>
            <ul >
               <li>Literature search for analytical method development</li>
               <li>Analytical support for Evaluation of Innovator/competitor’s product.</li>
               <li>Analytical method development & validation for API</li>
               <li>Analytical support to study the physicochemical properties of API: This study involves determining the solubility, particle size, polymorphs etc.</li>
               <li>Analytical method development and validation for finished dosage forms including Dry Powder Inhalers and Nasal Spray Products</li>
               <li>
                  Stability Studies:<br>
                  <ul>
                     <li><span class="list-num">(a)</span>	Incubation and withdrawal of samples as per approved stability protocol.</li>
                     <li><span class="list-num">(b)</span>	Analysis of sample by developed stability indicating analytical methods (Assay, Related Substances, Dissolution and Residual Solvents)</li>
                  </ul>
               </li>
               <li>Technology Transfer of the analytical methods to manufacturing/commercial locations.</li>
            </ul>
            
         </div>
      </div>
      <div class="flx-row b-r-line rel analytical-bot-txt">
      <p>The developed generic and new product dossiers are submitted for review to various regulatory agencies and after receiving approval & registration, are marketed in India/ US/ UK/ EU/ South Africa and other countries of the world. R&D center adopts any new technology that will help to serve the healthcare sector, human & animal being better.</p>
            <p>All kind of Analytical instruments are available at the R&D namely HPLC, GC, weighing Balances, Dissolution Apparatus,  Microscope, Osmometer, pH meter, Viscometer etc.</p>
            <p>Advance Inhalation product testing and characterization instruments are available in R&D namely SprayTec, SprayView, DUSA, NGI, ACI, TPK flow controller etc.</p>
      </div>
   </div>
</section>
<section class="pt-50 pb-100">
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
                           <img class="res-img"  src="<?php  echo get_stylesheet_directory_uri(); ?>/images/analytical-01.jpg">
                        </div>
                     </a>
                  </div>
                  <div class="swiper-slide zoom-ef">
                     <a href="<?php echo site_url('/formulation/');?>" class="slider-link">
                        <!-- <div class="slider-txt-block">
                           <h4>scientific Discovery</h4>
                           </div> -->
                        <div class="pro-slide-img">
                           <img class="res-img"  src="<?php  echo get_stylesheet_directory_uri(); ?>/images/analytical-02.jpg">
                        </div>
                     </a>
                  </div>
                  <div class="swiper-slide zoom-ef">
                     <a href="<?php echo site_url('/formulation/');?>" class="slider-link">
                        <!-- <div class="slider-txt-block">
                           <h4>scientific Discovery</h4>
                           </div> -->
                        <div class="pro-slide-img">
                           <img class="res-img"  src="<?php  echo get_stylesheet_directory_uri(); ?>/images/analytical-03.jpg">
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