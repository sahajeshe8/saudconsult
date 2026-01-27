<?php
/**
 * Template Name: Clients
 *
 * The template for displaying the Clients page
 *
 * @package tasheel
 */

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


<section>
  <div class="wrap d_flex_wrap">
	  <div class="slider-block-01">
		
	  <div class="swiper mySwiper-01">
    <div class="swiper-wrapper">
      <div class="swiper-slide">Slide 1</div>
      <div class="swiper-slide">Slide 2</div>
      <div class="swiper-slide">Slide 3</div>
      <div class="swiper-slide">Slide 4</div>
      <div class="swiper-slide">Slide 5</div>
      <div class="swiper-slide">Slide 6</div>
      <div class="swiper-slide">Slide 7</div>
      <div class="swiper-slide">Slide 8</div>
      <div class="swiper-slide">Slide 9</div>
    </div>
  </div>
	  </div>
	  <div  class="slider-block-02">
	  <div class="swiper mySwiper-02">
    <div class="swiper-wrapper">
      <div class="swiper-slide">Slide 1</div>
      <div class="swiper-slide">Slide 2</div>
      <div class="swiper-slide">Slide 3</div>
      <div class="swiper-slide">Slide 4</div>
      <div class="swiper-slide">Slide 5</div>
      <div class="swiper-slide">Slide 6</div>
      <div class="swiper-slide">Slide 7</div>
      <div class="swiper-slide">Slide 8</div>
      <div class="swiper-slide">Slide 9</div>
    </div>
  </div>

	  </div>
	  <div class="slider-block-03">
		
	  <div class="swiper mySwiper-03">
    <div class="swiper-wrapper">
      <div class="swiper-slide">Slide 1</div>
      <div class="swiper-slide">Slide 2</div>
      <div class="swiper-slide">Slide 3</div>
      <div class="swiper-slide">Slide 4</div>
      <div class="swiper-slide">Slide 5</div>
      <div class="swiper-slide">Slide 6</div>
      <div class="swiper-slide">Slide 7</div>
      <div class="swiper-slide">Slide 8</div>
      <div class="swiper-slide">Slide 9</div>
    </div>
  </div>
	  </div>
  </div>
  </section>





</main><!-- #main -->

<?php
get_footer();

