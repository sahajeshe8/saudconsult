<?php
/**
 * About Section Component Template
 *
 * @package tasheel
 */

// Get about section settings from theme mods or defaults
$about_title = get_theme_mod( 'about_title', 'About Saud Consult' );
$about_subtitle = get_theme_mod( 'about_subtitle', 'Engineering Excellence Since 1975' );
$about_description = get_theme_mod( 'about_description', 'For over five decades, Saud Consult has stood as the Kingdom\'s foremost multidisciplinary engineering and architectural consultancy, delivering innovative solutions that shape the future of Saudi Arabia.' );
$about_image = get_theme_mod( 'about_image', get_template_directory_uri() . '/assets/images/about-img.jpg' );
$about_button_text = get_theme_mod( 'about_button_text', 'Learn More' );
$about_button_link = get_theme_mod( 'about_button_link', '#' );

?>

<section class="about_section pt_80 pb_80 height_100vh">
	<div class="wrap">
	  <div class="about_section_01">
		 <div class="about_sectioncl_01" data-aos="fade-up" data-aos-duration="800" data-aos-delay="0">

		 <span class="lable_text"> <img src="<?php echo get_template_directory_uri(); ?>/assets/images/banner-dot.svg" alt="About Us"> About Us</span>
			 <h1>
			 The Kingdom's Pioneer in Engineering. <span>A Legacy of Trust Since 1965.</span>
</h1>
		 </div>
		 <div class="about_sectioncl_02" data-aos="fade-up" data-aos-duration="800" data-aos-delay="100">
			 <h5>Established in 1965 as the first Saudi Engineering Consulting Firm, </h5>
			 <p>Saud Consult has been integral to shaping the nation's built environment. Our foundation is built on deep local understanding, navigating the complexities of the Saudi landscape, coupled with advanced international technical expertise.</p>
		 
			 <a class="btn_style btn_transparent" href="<?php echo esc_url( home_url( '/about' ) ); ?>">
			 Learn more about us <span><img src="<?php echo get_template_directory_uri(); ?>/assets/images/buttion-arrow.svg" alt="Explore Our Expertise"></span>        
                    </a>
			
			</div>
	  </div>


<div class="swiper about_4_cl_swiper">
	<ul class="about_4_cl_blocks home_4_cl_blocks about_4_cl_blocks_swipper swiper-wrapper"> 
		<li class="swiper-slide" data-aos="fade-up" data-aos-duration="800" data-aos-delay="200">
			<div class="about_4_cl_blocks_item_01">
				<div class="w_100 text_cl_01">
					<h3 data-count-target="50" data-count-suffix="+ Years"><span class="count-number">0</span><span class="count-suffix">+ Years</span></h3>
					<p>Pioneering Excellence</p>
				</div>
				<div class="about_4_cl_blocks_item_02">
					<p>Decades of navigating the market, establishing trust, and delivering landmark projects across the Kingdom.</p>
				</div>
			</div>
		</li>
		<li class="swiper-slide" data-aos="fade-up" data-aos-duration="800" data-aos-delay="300">
			<div class="about_4_cl_blocks_item_01">
				<div class="w_100 text_cl_01">
					<h3 data-count-target="2000" data-count-suffix="+"><span class="count-number">0</span><span class="count-suffix">+</span></h3>
					<p>Professionals</p>
				</div>
				<div class="about_4_cl_blocks_item_02">
					<p>Decades of navigating the market, establishing trust, and delivering landmark projects across the Kingdom.</p>
				</div>
			</div>
		</li>
		<li class="swiper-slide" data-aos="fade-up" data-aos-duration="800" data-aos-delay="400">
			<div class="about_4_cl_blocks_item_01">
				<div class="w_100 text_cl_01">
					<h3 data-count-target="9" data-count-suffix=" Core"><span class="count-number">0</span><span class="count-suffix"> Core</span></h3>
					<p>Sectors</p>
				</div>
				<div class="about_4_cl_blocks_item_02">
					<p>Decades of navigating the market, establishing trust, and delivering landmark projects across the Kingdom.</p>
				</div>
			</div>
		</li>
		<li class="swiper-slide" data-aos="fade-up" data-aos-duration="800" data-aos-delay="500">
			<div class="about_4_cl_blocks_item_01">
				<div class="w_100 text_cl_01">
					<h3 data-count-target="2600" data-count-suffix="+"><span class="count-number">0</span><span class="count-suffix">+</span></h3>
					<p>Projects Completed</p>
				</div>
				<div class="about_4_cl_blocks_item_02">
					<p>Decades of navigating the market, establishing trust, and delivering landmark projects across the Kingdom.</p>
				</div>
			</div>
		</li>
	</ul>
</div>

	</div>
</section>

