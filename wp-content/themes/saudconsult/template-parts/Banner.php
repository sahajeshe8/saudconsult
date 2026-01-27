<?php
/**
 * Banner Component Template
 *
 * @package tasheel
 */

// Get banner settings from theme mods or defaults
$banner_title = get_theme_mod( 'banner_title', 'Empowering Businesses, Enabling Growth' );
$banner_description = get_theme_mod( 'banner_description', 'Since 2005, TasHeel Holding Group (THG) has been driving innovation and transformation across travel, logistics, hospitality, and service sectors — shaping the future of Saudi enterprise.' );
$banner_button_text = get_theme_mod( 'banner_button_text', 'Discover Our Story' );
$banner_button_link = get_theme_mod( 'banner_button_link', '#' );

// Check if banner logo exists
$banner_logo_default = get_template_directory_uri() . '/assets/images/header-logo.svg';
$banner_logo_path = get_template_directory() . '/assets/images/header-logo.svg';
$banner_logo = get_theme_mod( 'banner_logo', $banner_logo_default );
if ( ! file_exists( $banner_logo_path ) ) {
	$banner_logo = '';
}

// Check if banner overlay exists
$banner_overlay_default = get_template_directory_uri() . '/assets/images/banner_overlay.svg';
$banner_overlay_path = get_template_directory() . '/assets/images/banner_overlay.svg';
$banner_overlay = get_theme_mod( 'banner_overlay', $banner_overlay_default );
if ( ! file_exists( $banner_overlay_path ) ) {
	$banner_overlay = '';
}

// Get banner slides (using repeater or multiple images)
$banner_slides = array();
for ( $i = 1; $i <= 3; $i++ ) {
	$slide_image = get_theme_mod( 'banner_slide_' . $i, '' );
	if ( $slide_image ) {
		$banner_slides[] = $slide_image;
	}
}

// If no slides from theme mods, use default banner image
if ( empty( $banner_slides ) ) {
	$banner_slides[] = get_template_directory_uri() . '/assets/images/banner-img.jpg';
}

?>

<div class="bannerContainer" id="bannerContainer">
	<div class="swiper mySwiper_banner">
		<div class="swiper-wrapper">
			<div class="swiper-slide banner_slide" style="background-image: url('<?php echo get_template_directory_uri(); ?>/assets/images/banner-img.jpg');">
                <div class="wrap">
                   <div class="banner_slide_content">
                    


                    <div class="banner_slide_content_02">
                        <div class="banner_slide_content_02_cl_01" data-aos="fade-up" data-aos-duration="800" data-aos-delay="0">
                         <h2>
                         Engineering Excellence. Building  <span>the Future of Saudi Arabia.</span>
                         </h2>
                         <h5> For over five decades, Saud Consult has stood as the Kingdom's foremost multidisciplinary engineering and architectural consultancy.</h5>
</div>

<div class="banner_slide_content_02_cl_02" data-aos="fade-up" data-aos-duration="800" data-aos-delay="200">
<a class="btn_style btn_transparent" href="http://localhost/saudconsult/contact">
Explore Our Expertise <span><img src="<?php echo get_template_directory_uri(); ?>/assets/images/buttion-arrow.svg" alt="Explore Our Expertise"></span>        
                    </a>
</div>
                    </div>
                   </div>  
                </div>
            </div>
		</div>
	</div>
</div>

