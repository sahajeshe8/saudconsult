<?php get_header(''); 
   /*Template Name: HTML Media Center*/
   wp_enqueue_script('script');
   add_action('wp_footer','page_script',21);
   function page_script(){
   ?>
<script>
    
   //  jQuery( document ).ready(function() {
      jQuery(window).load(function()
  { 
    console.log( "ready!" );
   jQuery('.grid').masonry({
	itemSelector: '.grid-item',
	// columnWidth: 400
  });
//   location.reload();
// location.reload(true);


 


});
</script>
<?php } ?>
<section class="inner-banner-02 pattern" style="background:url(<?php echo get_stylesheet_directory_uri(); ?>/images/media-center-banner.jpg) center bottom; background-size: cover;">
   <div class="banner-title-box">
      <h1>Media Center</h1>
      <span class="title-line"></span>
   </div>
</section>
<section class="tab-row-02">
   <ul>
      <li  class="w-50 text-center align-center active-tab"><a data-sr="wait 0.1s, enter right" href="<?php echo site_url('/media-center/');?>">News</a></li>
      <li  class="w-50 text-center align-center "><a data-sr="wait 0.1s, enter right" href="<?php echo site_url('/events/');?>">Events</a></li>
   </ul>
</section>
<section class="over-fls">
   <div class="wrap">
      <div class="form-sumo">
         <form action="" class="sorting-form mt-50 mb-40">
            <ul class="sort-ul">
               <li> <label for="">Sort by:</label></li>
               <li class="sort-li">
                  <select class="selectBox">
                     <option>Type</option>
                     <option>1</option>
                     <option>1</option>
                     <option>1</option>
                     <option>1</option>
                  </select>
               </li>
               <li class="sort-li">
                  <select class="selectBox">
                     <option>Latest</option>
                     <option>1</option>
                     <option>1</option>
                     <option>1</option>
                     <option>1</option>
                  </select>
               </li>
            </ul>
         </form>
      </div>
      <div class="grid  pb-20">
         <div class="grid-item "  >
            <div class="card-item"  >
               <div class="news-block-03 zoom-ef">
                  <a href="<?php echo site_url('/media-center-details');?>">
                     <div class="news-img-block">
                        <img class="res-img" src="<?php echo get_stylesheet_directory_uri(); ?>/images/rgt-media-img1.jpg" />
                     </div>
                     <div class="news-list-txt">
                        <p>11-02-22</p>
                        <h3>Regent Global DMCC, an establishlicensed pharmaceutical</h3>
                        <div class="news-discription">
                           <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pretium, pretium,</p>
                        </div>
                     </div>
                  </a>
               </div>
            </div>
         </div>
         <div class="grid-item " >
            <div class="card-item"  >
               <div class="news-block-03 zoom-ef">
                  <a href="<?php echo site_url('/media-center-details');?>">
                     <div class="news-img-block">
                        <img class="res-img" src="<?php echo get_stylesheet_directory_uri(); ?>/images/rgt-media-img2.jpg" />
                     </div>
                     <div class="news-list-txt">
                        <p>11-02-22</p>
                        <h3>Regent Global DMCC, an establishlicensed pharmaceutical</h3>
                        <div class="news-discription">
                           <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pretium, pretium,</p>
                        </div>
                     </div>
                  </a>
               </div>
            </div>
         </div>
         <div class="grid-item" >
            <div class="card-item"   >
               <div class="news-block-03 zoom-ef">
                  <a href="<?php echo site_url('/media-center-details');?>">
                     <div class="news-img-block">
                        <img class="res-img" src="<?php echo get_stylesheet_directory_uri(); ?>/images/rgt-media-img3.jpg" />
                     </div>
                     <div class="news-list-txt bg-03-event">
                        <p>11-02-22</p>
                        <h3>Regent Global DMCC, an establishlicensed pharmaceutical</h3>
                        <div class="news-discription">
                           <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pretium, pretium,</p>
                        </div>
                     </div>
                  </a>
               </div>
            </div>
         </div>
         <div class="grid-item" >
            <div class="card-item"  >
               <div class="news-block-03 zoom-ef">
                  <a href="<?php echo site_url('/media-center-details');?>">
                     <div class="news-img-block">
                        <img class="res-img" src="<?php echo get_stylesheet_directory_uri(); ?>/images/rgt-media-img5.jpg" />
                     </div>
                     <div class="news-list-txt bg-02-event">
                        <p>11-02-22</p>
                        <h3>Regent Global DMCC, an establishlicensed pharmaceutical</h3>
                        <div class="news-discription">
                           <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pretium, pretium,</p>
                        </div>
                     </div>
                  </a>
               </div>
            </div>
         </div>
         <div class="grid-item" >
            <div class="card-item" >
               <div class="news-block-03 zoom-ef">
                  <a href="<?php echo site_url('/media-center-details');?>">
                     <div class="news-img-block">
                        <img class="res-img" src="<?php echo get_stylesheet_directory_uri(); ?>/images/rgt-media-img6.jpg" />
                     </div>
                     <div class="news-list-txt">
                        <p>11-02-22</p>
                        <h3>Regent Global DMCC, an establishlicensed pharmaceutical</h3>
                        <div class="news-discription">
                           <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pretium, pretium,</p>
                        </div>
                     </div>
                  </a>
               </div>
            </div>
         </div>
         <div class="grid-item" >
            <div class="card-item" >
               <div class="news-block-03 zoom-ef">
                  <a href="<?php echo site_url('/media-center-details');?>">
                     <div class="news-img-block">
                        <img class="res-img" src="<?php echo get_stylesheet_directory_uri(); ?>/images/rgt-media-img4.jpg" />
                     </div>
                     <div class="news-list-txt">
                        <p>11-02-22</p>
                        <h3>Regent Global DMCC, an establishlicensed pharmaceutical</h3>
                        <div class="news-discription">
                           <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pretium, pretium,</p>
                        </div>
                     </div>
                  </a>
               </div>
            </div>
         </div>
         <div class="grid-item" >
            <div class="card-item"  >
               <div class="news-block-03 zoom-ef">
                  <a href="<?php echo site_url('/media-center-details');?>">
                     <div class="news-img-block">
                        <img class="res-img" src="<?php echo get_stylesheet_directory_uri(); ?>/images/rgt-card-img2.jpg" />
                     </div>
                     <div class="news-list-txt">
                        <p>11-02-22</p>
                        <h3>Regent Global DMCC, an establishlicensed pharmaceutical</h3>
                        <div class="news-discription">
                           <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pretium, pretium,</p>
                        </div>
                     </div>
                  </a>
               </div>
            </div>
         </div>
         <div class="grid-item" >
            <div class="card-item" >
               <div class="news-block-03 zoom-ef">
                  <a href="<?php echo site_url('/media-center-details');?>">
                     <div class="news-img-block">
                        <img class="res-img" src="<?php echo get_stylesheet_directory_uri(); ?>/images/rgt-card-img3.jpg" />
                     </div>
                     <div class="news-list-txt">
                        <p>11-02-22</p>
                        <h3>Regent Global DMCC, an establishlicensed pharmaceutical</h3>
                        <div class="news-discription">
                           <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pretium, pretium,</p>
                        </div>
                     </div>
                  </a>
               </div>
            </div>
         </div>
         <div class="grid-item" >
            <div class="card-item" >
               <div class="news-block-03 zoom-ef">
                  <a href="<?php echo site_url('/media-center-details');?>">
                     <div class="news-img-block">
                        <img class="res-img" src="<?php echo get_stylesheet_directory_uri(); ?>/images/rgt-card-img1.jpg" />
                     </div>
                     <div class="news-list-txt">
                        <p>11-02-22</p>
                        <h3>Regent Global DMCC, an establishlicensed pharmaceutical</h3>
                        <div class="news-discription">
                           <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pretium, pretium,</p>
                        </div>
                     </div>
                  </a>
               </div>
            </div>
         </div>
      </div>
      <div class="slider-nav mb-100 mb-100">
         <div class="swipper-but rel-prev swipper-prev icon-arrow-1"></div>
         <div class="swipper-but rel-next swipper-next icon-arrow-1"></div>
      </div>
   </div>
</section>
<?php get_footer('inner'); ?>