<?php
/**
 * Our Journey Section Component Template
 *
 * @package tasheel
 */

// Extract data from args array passed from get_template_part()
$args = isset( $args ) ? $args : array();

// Set default values or use passed values
$title       = isset( $args['title'] ) ? $args['title'] : 'Our Journey &';
$title_span  = isset( $args['title_span'] ) ? $args['title_span'] : 'Legacy';
$description = isset( $args['description'] ) ? $args['description'] : 'Since our founding, we have been committed to excellence and innovation in engineering consultancy. Our journey spans decades of growth, achievement, and contribution to the development of Saudi Arabia.';
$milestones  = isset( $args['milestones'] ) ? $args['milestones'] : array(
	array(
		'year'   => '1965',
		'title'  => 'Founded',
		'text'   => 'Established as one of the first Saudi engineering consulting firms.',
	),
	array(
		'year'   => '1995',
		'title'  => 'Regional Growth',
		'text'   => 'Expanded multidisciplinary services across major sectors and regions.',
	),
	array(
		'year'   => '2024',
		'title'  => 'Shaping the Future',
		'text'   => 'Delivering sustainable, innovative solutions for the next generation.',
	),
);

?>

<section class="our_journey_section pt_120 pb_120 bg-style">
	<div class="wrap">


   <div class="p-relative d_flex_wrap  align-items-center justify-content-between align_end" data-aos="fade-up" data-aos-duration="800" data-aos-delay="0">
   <h3 class="h3_title_50">Our Journey & <br><span>Legacy</span></h3>
   <div class="slider_arrow_block pb_0" data-aos="fade-up" data-aos-duration="800" data-aos-delay="100">
					<span class="slider_buttion but_next news_but_next but_black">
						<img src="<?php echo get_template_directory_uri(); ?>/assets/images/slider-arrow.svg" alt="Next Project">
					</span>
					<span class="slider_buttion but_prev news_but_prev but_black">
						<img src="<?php echo get_template_directory_uri(); ?>/assets/images/slider-arrow.svg" alt="Previous Project">
					</span>
				</div>
</div>

   <div class="our_journey_gallery_wrapper" data-aos="fade-up" data-aos-duration="800" data-aos-delay="200">




   <div class="swiper our_journey_thumb_swiper">
         <div class="swiper-wrapper">
            <div class="swiper-slide">
               <span class="dot-icn"></span>
            1965
            </div>
            <div class="swiper-slide">
            <span class="dot-icn"></span>
            1980
            </div>
            <div class="swiper-slide">
            <span class="dot-icn"></span>
            2000
            </div>
            <div class="swiper-slide">
            <span class="dot-icn"></span>
            2010
            </div>
            <div class="swiper-slide">
            <span class="dot-icn"></span>
            2000
            </div>
            <div class="swiper-slide">
            <span class="dot-icn"></span>
            1980
            </div>
            
         </div>
      </div>





      <!-- Main Swiper Slider -->
      <div class="swiper our_journey_main_swiper">
         <div class="swiper-wrapper">
            <div class="swiper-slide">
<div class="d_flex_wrap align-items-center justify-content-between">

            <div class="our_journey_item_image">
               <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/jurny-01.jpg' ); ?>" alt="Gallery Image 1">
              </div>

             
<div class="our_journey_content_block">

            <div class="our_journey_main_swiper_item_content_year"> 
              <p >1965 – 1980s</p>
</div> 

   <div class="our_journey_main_swiper_item_content">
    <h4>Founding and National Infrastructure Focus.</h4>
    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,Lorem Ipsum is simply dummy...Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,Lorem Ipsum is simply dummy...</p>

<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,Lorem Ipsum is simply dummy...</p>
   </div>


</div>


</div>
 
            </div>
          
            <div class="swiper-slide">
<div class="d_flex_wrap align-items-center justify-content-between">

            <div class="our_journey_item_image">
               <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/jurny-01.jpg' ); ?>" alt="Gallery Image 1">
              </div>

             
<div class="our_journey_content_block">

            <div class="our_journey_main_swiper_item_content_year"> 
              <p >1965 – 1980s</p>
</div> 

   <div class="our_journey_main_swiper_item_content">
    <h4>Founding and National Infrastructure Focus.</h4>
    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,Lorem Ipsum is simply dummy...Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,Lorem Ipsum is simply dummy...</p>

<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,Lorem Ipsum is simply dummy...</p>
   </div>


</div>


</div>
 
            </div>
            <div class="swiper-slide">
<div class="d_flex_wrap align-items-center justify-content-between">

            <div class="our_journey_item_image">
               <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/jurny-01.jpg' ); ?>" alt="Gallery Image 1">
              </div>

             
<div class="our_journey_content_block">

            <div class="our_journey_main_swiper_item_content_year"> 
              <p >1965 – 1980s</p>
</div> 

   <div class="our_journey_main_swiper_item_content">
    <h4>Founding and National Infrastructure Focus.</h4>
    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,Lorem Ipsum is simply dummy...Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,Lorem Ipsum is simply dummy...</p>

<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,Lorem Ipsum is simply dummy...</p>
   </div>


</div>


</div>
 
            </div>
            <div class="swiper-slide">
<div class="d_flex_wrap align-items-center justify-content-between">

            <div class="our_journey_item_image">
               <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/jurny-01.jpg' ); ?>" alt="Gallery Image 1">
              </div>

             
<div class="our_journey_content_block">

            <div class="our_journey_main_swiper_item_content_year"> 
              <p >1965 – 1980s</p>
</div> 

   <div class="our_journey_main_swiper_item_content">
    <h4>Founding and National Infrastructure Focus.</h4>
    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,Lorem Ipsum is simply dummy...Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,Lorem Ipsum is simply dummy...</p>

<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,Lorem Ipsum is simply dummy...</p>
   </div>


</div>


</div>
 
            </div>
            <div class="swiper-slide">
<div class="d_flex_wrap align-items-center justify-content-between">

            <div class="our_journey_item_image">
               <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/jurny-01.jpg' ); ?>" alt="Gallery Image 1">
              </div>

             
<div class="our_journey_content_block">

            <div class="our_journey_main_swiper_item_content_year"> 
              <p >1965 – 1980s</p>
</div> 

   <div class="our_journey_main_swiper_item_content">
    <h4>Founding and National Infrastructure Focus.</h4>
    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,Lorem Ipsum is simply dummy...Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,Lorem Ipsum is simply dummy...</p>

<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,Lorem Ipsum is simply dummy...</p>
   </div>


</div>


</div>
 
            </div>
            <div class="swiper-slide">
<div class="d_flex_wrap align-items-center justify-content-between">

            <div class="our_journey_item_image">
               <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/jurny-01.jpg' ); ?>" alt="Gallery Image 1">
              </div>

             
<div class="our_journey_content_block">

            <div class="our_journey_main_swiper_item_content_year"> 
              <p >1965 – 1980s</p>
</div> 

   <div class="our_journey_main_swiper_item_content">
    <h4>Founding and National Infrastructure Focus.</h4>
    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,Lorem Ipsum is simply dummy...Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,Lorem Ipsum is simply dummy...</p>

<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,Lorem Ipsum is simply dummy...</p>
   </div>


</div>


</div>
 
            </div>
         </div>
      </div>

      <!-- Thumbnail Swiper Slider -->
     
   </div>
	</div>
</section>

