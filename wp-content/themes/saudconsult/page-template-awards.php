<?php
/**
 * Template Name: Awards & Certifications
 *
 * The template for displaying the Awards & Certifications page
 *
 * @package tasheel
 */
global $header_custom_class;
$header_custom_class = ' ';
get_header();
?>

<main id="primary" class="site-main">

<?php 
	$inner_banner_data = array(
		'background_image' => get_template_directory_uri() . '/assets/images/awards-banner.jpg',
		'title' => 'Awards & Certifications',
	);
	get_template_part( 'template-parts/inner-banner', null, $inner_banner_data ); 
	?>




<?php 
	$page_tabs_data = array(
		'tabs' => array(
			array( 'id' => 'overview', 'title' => 'Who We Are', 'link' => esc_url( home_url( '/about' ) ) ),
			array( 'id' => 'vision', 'title' => 'Vision, Mission & Values', 'link' => esc_url( home_url( '/vision-mission-values' ) ) ),
			array( 'id' => 'mission', 'title' => 'Leadership', 'link' => esc_url( home_url( '/leadership' ) ) ),
			array( 'id' => 'Our Team', 'title' => 'Our Team', 'link' => esc_url( home_url( '/our-team' ) ) ),
			array( 'id' => 'journey', 'title' => 'Our Journey & Legacy', 'link' => esc_url( home_url( '/our-journey-legacy' ) ) ),
			array( 'id' => 'milestones', 'title' => 'Company Milestones', 'link' => esc_url( home_url( '/company-milestones' ) ) ),
			array( 'id' => 'Awards & Certifications', 'title' => 'Awards & Certifications', 'link' => esc_url( home_url( '/awards' ) ) )
		),
		'active_tab' => 'Awards & Certifications' // Set which tab should be active
	);
	get_template_part( 'template-parts/page-tabs', null, $page_tabs_data ); 
	?>




	<?php 
	$awards_slider_data = array(
		'title' => 'Certifications',
		'title_span' => '',
		'description' => 'Certified to international standards that ensure quality, compliance, and professional excellence.',
		'section_class' => '',
		'awards' => array(
                array(
                    'image' => get_template_directory_uri() . '/assets/images/awards.jpg',
                    'alt' => 'Awards & Certifications',
                    'title' => 'Awards & Certifications',
                    'year' => 'ISO 9001:2015',
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
				array(
                    'image' => get_template_directory_uri() . '/assets/images/awards.jpg',
                    'alt' => 'Awards & Certifications',
                    'title' => 'Awards & Certifications',
                    'year' => 'ISO 9001:2015',
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

<div class="w_100 d_flex_wrap mt_auto justify-content-between award-row-02">
	  <div class="slider-block-01">
	  <div class="swiper mySwiper-01">
    <div class="swiper-wrapper">
      <div class="swiper-slide"> <img src="<?php echo get_template_directory_uri(); ?>/assets/images/aw-01.jpg" alt="Awards & Certifications"></div>
      <div class="swiper-slide"> <img src="<?php echo get_template_directory_uri(); ?>/assets/images/aw-02.jpg" alt="Awards & Certifications"></div>
      <div class="swiper-slide"> <img src="<?php echo get_template_directory_uri(); ?>/assets/images/aw-02.jpg" alt="Awards & Certifications"></div>
      <div class="swiper-slide"> <img src="<?php echo get_template_directory_uri(); ?>/assets/images/aw-03.jpg" alt="Awards & Certifications"></div>
      
    </div>
  
  </div>
	  </div>
 
</div>
</div>










	  <div class="slider-block-03">





	  <div class="slider_arrow_block">
						<span class="slider_buttion but_prev-aw icon-rotate-01" tabindex="0" role="button" aria-label="Previous slide" aria-controls="swiper-wrapper-e3f72735436d4394">
						<img src="http://localhost/saudconsult/wp-content/themes/saudconsult/assets/images/slider-arrow.svg" alt="Previous Project">
						</span>
						<span class="slider_buttion but_next-aw icon-rotate-02" tabindex="0" role="button" aria-label="Next slide" aria-controls="swiper-wrapper-e3f72735436d4394">
						<img src="http://localhost/saudconsult/wp-content/themes/saudconsult/assets/images/slider-arrow.svg" alt="Next Project">
						
						</span>
						
					</div>




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

	// Awards Page Thumbnail Gallery Setup
	const thumbSwiperEl = document.querySelector('.mySwiper-01');
	const mainSwiperEl = document.querySelector('.mySwiper-03');

	if (thumbSwiperEl && mainSwiperEl) {
		// Check if already initialized
		if (thumbSwiperEl.swiper || mainSwiperEl.swiper) {
			console.warn('Awards Gallery: Swipers already initialized');
			return;
		}

		try {
			// Initialize thumbnail swiper first with auto slides per view
			const thumbSwiper = new Swiper('.mySwiper-01', {
				slidesPerView: 'auto',
				spaceBetween: 10,
				freeMode: false,
				watchSlidesProgress: true,
				slideToClickedSlide: true,
				centeredSlides: false,
			});

			// Wait a bit for thumbnail swiper to fully initialize
			setTimeout(function() {
				// Find custom navigation buttons
				const nextButton = document.querySelector('.but_next-aw');
				const prevButton = document.querySelector('.but_prev-aw');

				// Initialize main swiper with thumbnail control and custom navigation
				const mainSwiper = new Swiper('.mySwiper-03', {
					slidesPerView: 1,
					spaceBetween: 0,
					thumbs: {
						swiper: thumbSwiper,
					},
					loop: true, // Enable infinite loop
					loopAdditionalSlides: 2, // Add extra slides for smoother looping
					effect: 'slide',
					speed: 300,
					navigation: {
						nextEl: nextButton,
						prevEl: prevButton,
					},
				});

				// Wait for main swiper to initialize
				setTimeout(function() {
					// Add reliable click handlers to each thumbnail slide
					const thumbSlides = thumbSwiperEl.querySelectorAll('.swiper-slide');
					thumbSlides.forEach(function(slide, index) {
						slide.style.cursor = 'pointer';
						
						// Create a robust click handler
						const handleThumbClick = function(e) {
							e.preventDefault();
							e.stopPropagation();
							
							// Ensure main swiper exists and is ready
							if (mainSwiper && mainSwiper.initialized) {
								// Navigate to the clicked slide (use realIndex for loop compatibility)
								mainSwiper.slideToLoop(index, 300);
								
								// Also update thumbnail swiper to show active state
								if (thumbSwiper && thumbSwiper.initialized) {
									thumbSwiper.slideTo(index, 300);
								}
							}
						};
						
						// Remove any existing handler and add new one
						slide.removeEventListener('click', handleThumbClick);
						slide.addEventListener('click', handleThumbClick);
					});

					// Listen to main swiper slideChange to sync thumbnails
					mainSwiper.on('slideChange', function() {
						if (thumbSwiper && thumbSwiper.initialized) {
							// Use realIndex to get the actual slide index (accounts for loop)
							const realIndex = mainSwiper.realIndex;
							if (thumbSwiper.activeIndex !== realIndex) {
								thumbSwiper.slideTo(realIndex, 300);
							}
						}
					});

					// Backup: Listen to thumbnail swiper slideChange
					thumbSwiper.on('slideChange', function() {
						if (mainSwiper && mainSwiper.initialized) {
							const activeIndex = thumbSwiper.activeIndex;
							// Use slideToLoop for proper loop handling
							mainSwiper.slideToLoop(activeIndex, 300);
						}
					});

					console.log('Awards Gallery: Thumbnail gallery initialized successfully');
				}, 100);
			}, 50);
		} catch (error) {
			console.error('Awards Gallery: Error initializing thumbnail gallery', error);
		}
	} else {
		console.warn('Awards Gallery: Swiper elements not found');
	}
});
</script>

</main><!-- #main -->

<?php
get_footer();

