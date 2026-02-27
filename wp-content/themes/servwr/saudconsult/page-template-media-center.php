<?php
/**
 * Template Name: Media Center
 *
 * Renders all Page Sections (ACF flexible content) in the same order as in the backend.
 * Inner banner, News, Events, Brochures, Gallery, FAQ, etc. are rendered via the contact
 * renderer (which delegates News/Events/Brochures/Gallery to inc/acf-media-center-render.php).
 * If no sections are set, a default banner is shown.
 *
 * @package tasheel
 */

get_header();

$page_id  = get_queried_object_id();
$sections = array();
if ( function_exists( 'get_field' ) ) {
	$sections = get_field( 'about_page_sections', $page_id );
}
$sections = is_array( $sections ) ? $sections : array();
?>

<main id="primary" class="site-main">
	<?php
	if ( ! empty( $sections ) && function_exists( 'tasheel_render_contact_flexible_section' ) ) {
		foreach ( $sections as $section ) {
			tasheel_render_contact_flexible_section( $section );
		}
	} else {
		$banner_url = get_template_directory_uri() . '/assets/images/media-center-banner.jpg';
		get_template_part( 'template-parts/inner-banner', null, array(
			'background_image'        => $banner_url,
			'background_image_mobile' => '',
			'title'                    => esc_html__( 'Media Center', 'tasheel' ),
		) );
	}
	?>
</main><!-- #main -->

<?php
get_footer();
