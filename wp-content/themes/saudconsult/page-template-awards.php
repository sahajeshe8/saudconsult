<?php
/**
 * Template Name: Awards & Certifications
 *
 * The template for displaying the Awards & Certifications page
 *
 * @package tasheel
 */
global $header_custom_class;
$header_custom_class = 'black-header';
get_header();
?>

<main id="primary" class="site-main">
	<?php 
	$awards_slider_data = array(
		'title' => 'Our',
		'title_span' => 'Awards & Certifications',
		'section_class' => '',
		'awards' => array(
                array(
                    'image' => get_template_directory_uri() . '/assets/images/awards.jpg',
                    'alt' => 'Awards & Certifications',
                    'title' => 'Awards & Certifications',
                    'year' => '',
                    'link' => ''
                ),
                array(
                    'image' => get_template_directory_uri() . '/assets/images/awards.jpg',
                    'alt' => 'Awards & Certifications',
                    'title' => 'Awards & Certifications',
                    'year' => 'ISO 9001:2015 ',
                    'link' => 'Ensures consistent quality management and service excellence.'
                ),
                array(
                    'image' => get_template_directory_uri() . '/assets/images/awards.jpg',
                    'alt' => 'Awards & Certifications',
                    'title' => 'Awards & Certifications',
                    'year' => 'ISO 9001:2015 ',
                    'link' => 'Ensures consistent quality management and service excellence.'
                ),
                array(
                    'image' => get_template_directory_uri() . '/assets/images/awards.jpg',
                    'alt' => 'Awards & Certifications',
                    'year' => 'ISO 9001:2015 ',
                    'link' => 'Ensures consistent quality management and service excellence.'
                ),
                array(
                    'image' => get_template_directory_uri() . '/assets/images/awards.jpg',
                    'alt' => 'Awards & Certifications',
                    'title' => 'Awards & Certifications',
                    'year' => 'ISO 9001:2015 ',
                    'link' => 'Ensures consistent quality management and service excellence.'
                ),
                array(
                    'image' => get_template_directory_uri() . '/assets/images/awards.jpg',
                    'alt' => 'Awards & Certifications',
                    'title' => 'Awards & Certifications',
                    'year' => 'ISO 9001:2015 ',
                    'link' => 'Ensures consistent quality management and service excellence.'
                ),
		)
	);
	// Slider 1: 3 slides per view
	get_template_part( 'template-parts/Awards-Slider', null, $awards_slider_data );
 
	?>


<section style="background: #f5f9ee;" class="pt_80 pb_80">
  <div class="wrap d_flex_wrap justify-content-between">


<div class="award_slider_block_01">


<div class="w_100 d_flex_wrap mb_auto">
	 <h3 class="h3_title_50">Awards</h3>
	 <p>Our state-of-the-art facility is ISO-certified, ensuring every product meets rigorous international standards for quality and food safety.</p>
</div>

<div class="w_100 d_flex_wrap mt_auto justify-content-between">
	  <div class="slider-block-01">
	  <div class="swiper mySwiper-01">
    <div class="swiper-wrapper">
      <div class="swiper-slide"> <img src="<?php echo get_template_directory_uri(); ?>/assets/images/aw-01.jpg" alt="Awards & Certifications"></div>
      <div class="swiper-slide"> <img src="<?php echo get_template_directory_uri(); ?>/assets/images/aw-02.jpg" alt="Awards & Certifications"></div>
      <div class="swiper-slide"> <img src="<?php echo get_template_directory_uri(); ?>/assets/images/aw-03.jpg" alt="Awards & Certifications"></div>
      
    </div>
  
  </div>
	  </div>
	  <div  class="slider-block-02">
	  <div class="swiper mySwiper-02">
    <div class="swiper-wrapper">
      <div class="swiper-slide">
		<img src="<?php echo get_template_directory_uri(); ?>/assets/images/aw-04.jpg" alt="Awards & Certifications">
	  </div>
      
    </div>
   
  </div>
	  </div>
</div>
</div>










	  <div class="slider-block-03">
	  <div class="swiper mySwiper-03">
    <div class="swiper-wrapper">
      <div class="swiper-slide d_flex_wrap  justify-content-between">
		<div class="swiper-slide-inner-img">
			<img src="<?php echo get_template_directory_uri(); ?>/assets/images/award-slider-img.jpg" alt="Awards & Certifications">
		</div>
		<div class="swiper-slide-inner-txt">
			<div class="swiper-slide-inner-txt-content">
			 <h6>Saud Consult Honored by the Saudi Boccia Federation</h6>
			 <p>Recognized for our role as the Platinum Sponsor of the <b>Al-Ojami Boccia Championship – Elite 2025,</b> reflecting our commitment to social responsibility and inclusive sports.</p>
		</div>
		</div>


	  </div>
      <div class="swiper-slide d_flex_wrap  justify-content-between">
		<div class="swiper-slide-inner-img">
			<img src="<?php echo get_template_directory_uri(); ?>/assets/images/award-slider-img.jpg" alt="Awards & Certifications">
		</div>
		<div class="swiper-slide-inner-txt">
			<div class="swiper-slide-inner-txt-content">
			 <h6>Saud Consult Honored by the Saudi Boccia Federation</h6>
			 <p>Recognized for our role as the Platinum Sponsor of the <b>Al-Ojami Boccia Championship – Elite 2025,</b> reflecting our commitment to social responsibility and inclusive sports.</p>
		</div>
		</div>


	  </div>

	  <div class="swiper-slide d_flex_wrap  justify-content-between">
		<div class="swiper-slide-inner-img">
			<img src="<?php echo get_template_directory_uri(); ?>/assets/images/award-slider-img.jpg" alt="Awards & Certifications">
		</div>
		<div class="swiper-slide-inner-txt">
			<div class="swiper-slide-inner-txt-content">
			 <h6>Saud Consult Honored by the Saudi Boccia Federation</h6>
			 <p>Recognized for our role as the Platinum Sponsor of the <b>Al-Ojami Boccia Championship – Elite 2025,</b> reflecting our commitment to social responsibility and inclusive sports.</p>
		</div>
		</div>


	  </div>
    </div>
    
  </div>
	  </div>
  </div>
  </section>

<script>
document.addEventListener('DOMContentLoaded', function() {
	// Check if Swiper is loaded
	if (typeof Swiper === 'undefined') {
		console.warn('Swiper library is not loaded');
		return;
	}
 

	 
 
});
</script>

</main><!-- #main -->

<?php
get_footer();

