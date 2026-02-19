<?php get_header(''); 
   /*Template Name: HTML Careers list*/
   wp_enqueue_script('script');
   add_action('wp_footer','page_script',21);
   function page_script(){
   ?>
<script></script>
<?php } ?>
<section class="inner-banner-02 pattern"style="background:url(<?php echo get_stylesheet_directory_uri(); ?>/images/careers-list-banner.jpg) center bottom; background-size: cover;">
   <div class="banner-title-box">
      <h1>Careers</h1>
      <span class="title-line"></span>
   </div>
</section>
<section class="pt-100 pb-100"  >
   <div class="wrap">
      <ul class="career-search-form form-sumo mb-60">
         <li data-sr="wait 0.1s, enter right">
            <input class="fld-01" type="text" placeholder="Keywords">
         </li>
         <li data-sr="wait 0.1s, enter right">
            <select class="selectBox">
               <option>Category</option>
               <option>1</option>
               <option>1</option>
               <option>1</option>
               <option>1</option>
            </select>
         </li>
         <li data-sr="wait 0.1s, enter right" >
            <select class="selectBox">
               <option>Job Type</option>
               <option>1</option>
               <option>1</option>
               <option>1</option>
               <option>1</option>
            </select>
         </li>
         <li data-sr="wait 0.1s, enter right" >
            <select class="selectBox">
               <option>Location</option>
               <option>1</option>
               <option>1</option>
               <option>1</option>
               <option>1</option>
            </select>
         </li>
         <li data-sr="wait 0.1s, enter right" ><a href="<?php echo site_url('/careers-detail/');?>" class="but-01  blue-but">Search</a></li>
      </ul>
      <div data-sr="wait 0.1s, enter right">
         <p>
            We have entered an exciting era in health innovation. Powered by our incredible colleagues, new learnings, personal growth and career platform and a refreshed commitment to diversity, equity & inclusion, we are well-poised to help lead this transformative moment for our industry and for ourselves. Join Us!
         </p>
      </div>
      <div class="oppaning-block  pt-80 mt-80">

      <div class="title-row-02">
         <h2 data-sr="wait 0.1s, enter right">Latest Openings</h2> 
         
         <!-- <div class="slider-nav" style="visibility: visible; ">
               <div class="swipper-but rel-prev swipper-prev icon-arrow-1" tabindex="0" role="button" aria-label="Previous slide"></div>
               <div class="swipper-but rel-next swipper-next icon-arrow-1" tabindex="0" role="button" aria-label="Next slide"></div>
            </div> -->
   </div>
         <ul class="opening-ul">
            <li data-sr="wait 0.1s, enter right">
               <h3><a href="<?php echo site_url('/ra-manage/');?>">
                  <span>Master's degree in Pharmacy or equivalent</span>    
                  RA Manager
   </a>
               </h3>
               <p>United Arab Emirates</p>
            </li>
            <li data-sr="wait 0.1s, enter right">
               <h3><a href="<?php echo site_url('/finance-manager/');?>">
                  <span>CA is must</span>    
                  Finance Manager
   </a>
               </h3>
               <p>United Arab Emirates</p>
            </li>
            
         </ul>
      </div>
 
   </div>
   </div>
</section>
<?php get_footer('inner'); ?>