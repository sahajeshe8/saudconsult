<?php
/**
 * The front page template file
 *
 * This is the template for the home page.
 * Uses ACF flexible content (about_page_sections) when set. Shows nothing if no sections configured.
 *
 * Which file renders what (when using ACF):
 * - front-page.php loops sections and calls tasheel_render_contact_flexible_section() (inc/acf-contact-render.php).
 * - Contact renderer dispatches: home layouts → tasheel_render_home_flexible_section() (inc/acf-home-render.php).
 * - Home renderer loads: home_services → template-parts/Services.php; home_partners → template-parts/home-Partners.php;
 *   home_about → template-parts/About.php; home_banner → template-parts/Banner.php; etc.
 *
 * @package tasheel
 */

get_header();

$front_page_id = (int) get_option( 'page_on_front' );
$page_sections = array();
if ( function_exists( 'get_field' ) && $front_page_id ) {
	$page_sections = get_field( 'about_page_sections', $front_page_id );
	if ( ! is_array( $page_sections ) ) {
		$page_sections = array();
	}
}

if ( ! empty( $page_sections ) && is_array( $page_sections ) && function_exists( 'tasheel_render_contact_flexible_section' ) ) {
	// ACF flexible content from group_about_flexible_page (shared with About, Contact, Vendor, Home).
	foreach ( $page_sections as $section ) {
		tasheel_render_contact_flexible_section( $section );
	}
}

get_footer();
