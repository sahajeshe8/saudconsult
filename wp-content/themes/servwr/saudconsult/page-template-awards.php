<?php
/**
 * Template Name: Awards & Certifications
 *
 * Content is managed via ACF Flexible Content. Empty sections are hidden. WPML-ready.
 *
 * @package tasheel
 */
global $header_custom_class;
$header_custom_class = ' ';
get_header();
?>
<main id="primary" class="site-main">
	<?php
	$current_page = is_singular( 'page' ) ? get_queried_object() : null;
	$current_slug = $current_page ? $current_page->post_name : '';
	$current_id   = $current_page ? (int) $current_page->ID : 0;
	$page_tabs_data = array( 'tabs' => tasheel_about_subpage_tabs(), 'active_tab' => $current_slug, 'active_page_id' => $current_id );
	if ( function_exists( 'get_field' ) && function_exists( 'tasheel_render_contact_flexible_section' ) ) {
		$sections = get_field( 'about_page_sections', get_queried_object_id() );
		$tabs_rendered = false;
		if ( ! empty( $sections ) && is_array( $sections ) ) {
			$has_banner = false;
			foreach ( $sections as $s ) {
				if ( ! empty( $s['acf_fc_layout'] ) && $s['acf_fc_layout'] === 'inner_banner' ) { $has_banner = true; break; }
			}
			if ( ! $has_banner ) { get_template_part( 'template-parts/page-tabs', null, $page_tabs_data ); $tabs_rendered = true; }
			foreach ( $sections as $section ) {
				tasheel_render_contact_flexible_section( $section );
				if ( ! $tabs_rendered && ! empty( $section['acf_fc_layout'] ) && $section['acf_fc_layout'] === 'inner_banner' ) {
					get_template_part( 'template-parts/page-tabs', null, $page_tabs_data );
					$tabs_rendered = true;
				}
			}
			if ( ! $tabs_rendered ) { get_template_part( 'template-parts/page-tabs', null, $page_tabs_data ); }
		} else {
			get_template_part( 'template-parts/page-tabs', null, $page_tabs_data );
		}
	} else {
		get_template_part( 'template-parts/page-tabs', null, $page_tabs_data );
	}
	?>

	<?php
	// Awards page thumbnail + main slider JS (runs when .mySwiper-01 / .mySwiper-03 exist)
	?>
	<script>
		document.addEventListener('DOMContentLoaded', function() {
			if (typeof Swiper === 'undefined') return;
			var thumbSwiperEl = document.querySelector('.mySwiper-01');
			var mainSwiperEl = document.querySelector('.mySwiper-03');
			if (!thumbSwiperEl || !mainSwiperEl || thumbSwiperEl.swiper || mainSwiperEl.swiper) return;
			try {
				var thumbSwiper = new Swiper('.mySwiper-01', {
					slidesPerView: 'auto',
					 
					freeMode: false,
					watchSlidesProgress: true,
					slideToClickedSlide: true,
					centeredSlides: false,
				});
				setTimeout(function() {
					var nextButton = document.querySelector('.but_next-aw');
					var prevButton = document.querySelector('.but_prev-aw');
					var mainSwiper = new Swiper('.mySwiper-03', {
    slidesPerView: 1,
    spaceBetween: 0,
    thumbs: { swiper: thumbSwiper },
    loop: true,
    loopAdditionalSlides: 2,
    loopedSlides: 2,
    effect: 'slide',
    speed: 300,
    navigation: { 
        nextEl: nextButton, 
        prevEl: prevButton 
    },

    // Default (Desktop) - No autoplay
    autoplay: false,

    breakpoints: {
        0: { // Mobile
            autoplay: {
                delay: 2500,
                disableOnInteraction: false,
            }
        },
        768: { // Tablet & Desktop
            autoplay: false
        }
    }
});
					setTimeout(function() {
						if (nextButton) nextButton.addEventListener('click', function() { if (mainSwiper && mainSwiper.initialized) mainSwiper.slideNext(); });
						if (prevButton) prevButton.addEventListener('click', function() { if (mainSwiper && mainSwiper.initialized) mainSwiper.slidePrev(); });
						var thumbSlides = thumbSwiperEl.querySelectorAll('.swiper-slide');
						thumbSlides.forEach(function(slide, index) {
							slide.style.cursor = 'pointer';
							slide.addEventListener('click', function(e) {
								e.preventDefault();
								e.stopPropagation();
								if (mainSwiper && mainSwiper.initialized) mainSwiper.slideToLoop(index, 300);
								if (thumbSwiper && thumbSwiper.initialized) thumbSwiper.slideTo(index, 300);
							});
						});
						mainSwiper.on('slideChange', function() {
							if (thumbSwiper && thumbSwiper.initialized && thumbSwiper.activeIndex !== mainSwiper.realIndex) {
								thumbSwiper.slideTo(mainSwiper.realIndex, 300);
							}
						});
					}, 100);
				}, 50);
			} catch (err) { console.warn('Awards Gallery init:', err); }
		});
	</script>
</main><!-- #main -->
<?php
get_footer();
