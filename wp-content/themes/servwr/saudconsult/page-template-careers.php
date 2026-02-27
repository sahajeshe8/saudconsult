<?php
/**
 * Template Name: Careers
 *
 * The template for the Careers hub page (three sections: Visit Career, Corporate Trainings, Academic Programs).
 * Content is driven by ACF Flexible Content (careers_page_sections). Empty sections are hidden. WPML-ready.
 *
 * @package tasheel
 */

get_header();
?>

<main id="primary" class="site-main">
	<?php
	if ( function_exists( 'get_field' ) && function_exists( 'tasheel_render_careers_flexible_section' ) ) {
		$sections = get_field( 'careers_page_sections', get_queried_object_id() );
		if ( ! empty( $sections ) && is_array( $sections ) ) {
			foreach ( array_keys( $sections ) as $i ) {
				$next = isset( $sections[ $i + 1 ] ) ? $sections[ $i + 1 ] : null;
				tasheel_render_careers_flexible_section( $sections[ $i ], $next );
			}
		} else {
			// Fallback when no ACF content: show default inner banner only.
			$inner_banner_data = array(
				'background_image' => get_template_directory_uri() . '/assets/images/careers-banner.jpg',
				'title'            => esc_html__( 'Careers', 'tasheel' ),
			);
			get_template_part( 'template-parts/inner-banner', null, $inner_banner_data );
		}
	} else {
		$inner_banner_data = array(
			'background_image' => get_template_directory_uri() . '/assets/images/careers-banner.jpg',
			'title'            => esc_html__( 'Careers', 'tasheel' ),
		);
		get_template_part( 'template-parts/inner-banner', null, $inner_banner_data );
	}
	?>
</main><!-- #main -->

<?php
get_footer();
