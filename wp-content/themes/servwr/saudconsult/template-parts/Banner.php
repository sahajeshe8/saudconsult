<?php
/**
 * Banner Component Template
 * Supports ACF slides via $args or theme mods.
 *
 * @package tasheel
 */

$args = isset( $args ) ? $args : array();
$banner_desktop_default = get_template_directory_uri() . '/assets/images/banner-img.jpg';
$banner_mobile_default  = get_template_directory_uri() . '/assets/images/banner-img-mobile.jpg';

$acf_slides = isset( $args['slides'] ) && is_array( $args['slides'] ) ? $args['slides'] : array();

if ( ! empty( $acf_slides ) ) {
	$use_acf_slides = true;
} else {
	$use_acf_slides = false;
	$banner_title       = get_theme_mod( 'banner_title', esc_html__( 'Engineering Excellence. Building', 'tasheel' ) );
	$banner_subtitle    = get_theme_mod( 'banner_description', esc_html__( 'the Future of Saudi Arabia.', 'tasheel' ) );
	$banner_description = get_theme_mod( 'banner_description', esc_html__( 'For over five decades, Saud Consult has stood as the Kingdom\'s foremost multidisciplinary engineering and architectural consultancy.', 'tasheel' ) );
	$banner_button_text = get_theme_mod( 'banner_button_text', esc_html__( 'Explore Our Expertise', 'tasheel' ) );
	$banner_button_link = get_theme_mod( 'banner_button_link', home_url( '/services/' ) );
}

?>
<div class="bannerContainer" id="bannerContainer">
   <div class="swiper mySwiper_banner">
      <div class="swiper-wrapper">
         <?php if ( $use_acf_slides ) : ?>
            <?php
            $delay = 0;
            foreach ( $acf_slides as $slide ) :
               $bg = isset( $slide['background_image'] ) ? $slide['background_image'] : '';
               $bg = is_array( $bg ) && isset( $bg['url'] ) ? $bg['url'] : ( is_string( $bg ) ? $bg : $banner_desktop_default );
               $bg_mobile = isset( $slide['background_image_mobile'] ) ? $slide['background_image_mobile'] : '';
               $bg_mobile = is_array( $bg_mobile ) && isset( $bg_mobile['url'] ) ? $bg_mobile['url'] : ( is_string( $bg_mobile ) ? $bg_mobile : $bg );
               $title       = isset( $slide['title'] ) ? $slide['title'] : '';
               $title_span  = isset( $slide['title_span'] ) ? $slide['title_span'] : '';
               $subtitle    = isset( $slide['subtitle'] ) ? $slide['subtitle'] : '';
               $btn_text    = isset( $slide['button_text'] ) ? $slide['button_text'] : esc_html__( 'Explore Our Expertise', 'tasheel' );
               $btn_link    = isset( $slide['button_link'] ) ? esc_url( $slide['button_link'] ) : esc_url( home_url( '/services/' ) );
            ?>
            <div class="swiper-slide banner_slide" data-desktop-bg="<?php echo esc_url( $bg ); ?>" data-mobile-bg="<?php echo esc_url( $bg_mobile ); ?>" style="background-image: url('<?php echo esc_url( $bg ); ?>');">
               <div class="wrap">
                  <div class="banner_slide_content">
                     <div class="banner_slide_content_02">
                        <div class="banner_slide_content_02_cl_01" data-aos="fade-up" data-aos-duration="800" data-aos-delay="<?php echo esc_attr( $delay ); ?>">
                           <h2><?php echo esc_html( $title ); ?> <?php if ( $title_span ) : ?><span><?php echo esc_html( $title_span ); ?></span><?php endif; ?></h2>
                           <?php if ( $subtitle ) : ?><h5><?php echo esc_html( $subtitle ); ?></h5><?php endif; ?>
                        </div>
                        <div class="banner_slide_content_02_cl_02" data-aos="fade-up" data-aos-duration="800" data-aos-delay="<?php echo esc_attr( $delay + 200 ); ?>">
                           <a class="btn_style btn_transparent" href="<?php echo $btn_link; ?>"><?php echo esc_html( $btn_text ); ?> <span><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/buttion-arrow.svg" alt="<?php echo esc_attr( $btn_text ); ?>"></span></a>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <?php $delay += 100; endforeach; ?>
         <?php else : ?>
         <div class="swiper-slide banner_slide" data-desktop-bg="<?php echo esc_url($banner_desktop_default); ?>"
            data-mobile-bg="<?php echo esc_url($banner_mobile_default); ?>"
            style="background-image: url('<?php echo esc_url($banner_desktop_default); ?>');">
            <div class="wrap">
               <div class="banner_slide_content">
                  <div class="banner_slide_content_02">
                     <div class="banner_slide_content_02_cl_01" data-aos="fade-up" data-aos-duration="800"
                        data-aos-delay="0">
                        <h2>
                           Engineering Excellence. Building <span>the Future of Saudi Arabia.</span>
                        </h2>
                        <h5> For over five decades, Saud Consult has stood as the Kingdom's foremost multidisciplinary
                           engineering and architectural consultancy.</h5>
                     </div>
                     <div class="banner_slide_content_02_cl_02" data-aos="fade-up" data-aos-duration="800"
                        data-aos-delay="200">
                        <a class="btn_style btn_transparent" href="<?php echo esc_url(home_url('/services/')); ?>">
                           Explore Our Expertise <span><img
                                 src="<?php echo get_template_directory_uri(); ?>/assets/images/buttion-arrow.svg"
                                 alt="Explore Our Expertise"></span>
                        </a>
                     </div>
                  </div>
               </div>
            </div>
         </div>

         <div class="swiper-slide banner_slide" data-desktop-bg="<?php echo esc_url($banner_desktop_default); ?>"
            data-mobile-bg="<?php echo esc_url($banner_mobile_default); ?>"
            style="background-image: url('<?php echo esc_url($banner_desktop_default); ?>');">
            <div class="wrap">
               <div class="banner_slide_content">
                  <div class="banner_slide_content_02">
                     <div class="banner_slide_content_02_cl_01" data-aos="fade-up" data-aos-duration="800"
                        data-aos-delay="0">
                        <h2>
                           Engineering Excellence. Building <span>the Future of Saudi Arabia.</span>
                        </h2>
                        <h5> For over five decades, Saud Consult has stood as the Kingdom's foremost multidisciplinary
                           engineering and architectural consultancy.</h5>
                     </div>
                     <div class="banner_slide_content_02_cl_02" data-aos="fade-up" data-aos-duration="800"
                        data-aos-delay="200">
                        <a class="btn_style btn_transparent" href="<?php echo esc_url(home_url('/services/')); ?>">
                           Explore Our Expertise <span><img
                                 src="<?php echo get_template_directory_uri(); ?>/assets/images/buttion-arrow.svg"
                                 alt="Explore Our Expertise"></span>
                        </a>
                     </div>
                  </div>
               </div>
            </div>
         </div>

         <div class="swiper-slide banner_slide" data-desktop-bg="<?php echo esc_url($banner_desktop_default); ?>"
            data-mobile-bg="<?php echo esc_url($banner_mobile_default); ?>"
            style="background-image: url('<?php echo esc_url($banner_desktop_default); ?>');">
            <div class="wrap">
               <div class="banner_slide_content">
                  <div class="banner_slide_content_02">
                     <div class="banner_slide_content_02_cl_01" data-aos="fade-up" data-aos-duration="800"
                        data-aos-delay="0">
                        <h2>
                           Engineering Excellence. Building <span>the Future of Saudi Arabia.</span>
                        </h2>
                        <h5> For over five decades, Saud Consult has stood as the Kingdom's foremost multidisciplinary
                           engineering and architectural consultancy.</h5>
                     </div>
                     <div class="banner_slide_content_02_cl_02" data-aos="fade-up" data-aos-duration="800"
                        data-aos-delay="200">
                        <a class="btn_style btn_transparent" href="<?php echo esc_url(home_url('/services/')); ?>">
                           Explore Our Expertise <span><img
                                 src="<?php echo get_template_directory_uri(); ?>/assets/images/buttion-arrow.svg"
                                 alt="Explore Our Expertise"></span>
                        </a>
                     </div>
                  </div>
               </div>
            </div>
         </div>

         <div class="swiper-slide banner_slide" data-desktop-bg="<?php echo esc_url($banner_desktop_default); ?>"
            data-mobile-bg="<?php echo esc_url($banner_mobile_default); ?>"
            style="background-image: url('<?php echo esc_url($banner_desktop_default); ?>');">
            <div class="wrap">
               <div class="banner_slide_content">
                  <div class="banner_slide_content_02">
                     <div class="banner_slide_content_02_cl_01" data-aos="fade-up" data-aos-duration="800"
                        data-aos-delay="0">
                        <h2>
                           Engineering Excellence. Building <span>the Future of Saudi Arabia.</span>
                        </h2>
                        <h5> For over five decades, Saud Consult has stood as the Kingdom's foremost multidisciplinary
                           engineering and architectural consultancy.</h5>
                     </div>
                     <div class="banner_slide_content_02_cl_02" data-aos="fade-up" data-aos-duration="800"
                        data-aos-delay="200">
                        <a class="btn_style btn_transparent" href="<?php echo esc_url(home_url('/services/')); ?>">
                           Explore Our Expertise <span><img
                                 src="<?php echo get_template_directory_uri(); ?>/assets/images/buttion-arrow.svg"
                                 alt="Explore Our Expertise"></span>
                        </a>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <?php endif; ?>
      </div>
      <div class="swiper-pagination banner-pagination"></div>
   </div>
</div>