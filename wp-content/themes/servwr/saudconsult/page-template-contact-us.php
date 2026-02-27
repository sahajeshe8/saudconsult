<?php
/**
 * Template Name: Contact Us
 *
 * Content is driven by ACF flexible content (same field as About: about_page_sections).
 * Add Inner Banner, Contact Section, Contact Map, FAQ (or any About section). Empty sections are hidden.
 * All strings are translation-ready (WPML). Fallback content when no sections are set.
 *
 * @package tasheel
 */

get_header();
?>

<main id="primary" class="site-main">
	<?php
	if ( function_exists( 'get_field' ) && function_exists( 'tasheel_render_contact_flexible_section' ) ) {
		$sections = get_field( 'about_page_sections' );
		if ( ! empty( $sections ) && is_array( $sections ) ) {
			foreach ( $sections as $section ) {
				tasheel_render_contact_flexible_section( $section );
			}
		}
		// No sections selected: nothing is output (no default fallback).
	} else {
		// ACF or renderer missing: static fallback.
		$inner_banner_data = array(
			'background_image' => get_template_directory_uri() . '/assets/images/contact-banner.jpg',
			'title'            => esc_html__( 'Contact Us', 'tasheel' ),
		);
		get_template_part( 'template-parts/inner-banner', null, $inner_banner_data );
		get_template_part( 'template-parts/Contact-Section', null, array() );
		get_template_part( 'template-parts/Contact-Map', null, array( 'section_wrapper_class' => array(), 'section_class' => '' ) );
	}
	?>
</main><!-- #main -->

<?php
get_footer();
