<?php
/**
 * Template Name: Corporate Training
 *
 * The template for the Corporate Training page. Content is driven by ACF Flexible Content.
 * Page tabs shown after first section. Empty sections hidden. WPML-ready.
 *
 * @package tasheel
 */

get_header();
?>

<main id="primary" class="site-main">
	<?php
	$page_id = get_queried_object_id();
	$page_tabs_data = array(
		'tabs'            => function_exists( 'tasheel_careers_subpage_tabs' ) ? tasheel_careers_subpage_tabs() : array(
			array( 'id' => 'careers', 'title' => esc_html__( 'Careers', 'tasheel' ), 'link' => esc_url( home_url( '/careers-page' ) ) ),
			array( 'id' => 'corporate-training', 'title' => esc_html__( 'Corporate Training', 'tasheel' ), 'link' => esc_url( home_url( '/corporate-training' ) ) ),
			array( 'id' => 'academic-program', 'title' => esc_html__( 'Academic Program', 'tasheel' ), 'link' => esc_url( home_url( '/academic-program' ) ) ),
		),
		'active_tab'      => 'corporate-training',
		'active_page_id'  => $page_id,
	);

	if ( function_exists( 'get_field' ) && function_exists( 'tasheel_render_careers_flexible_section' ) ) {
		$sections = get_field( 'careers_page_sections', $page_id );
		$tabs_rendered = false;
		if ( ! empty( $sections ) && is_array( $sections ) ) {
			$has_banner = false;
			foreach ( $sections as $s ) {
				if ( ! empty( $s['acf_fc_layout'] ) && $s['acf_fc_layout'] === 'inner_banner' ) {
					$has_banner = true;
					break;
				}
			}
			if ( ! $has_banner ) {
				get_template_part( 'template-parts/page-tabs', null, $page_tabs_data );
				$tabs_rendered = true;
			}
			foreach ( array_keys( $sections ) as $i ) {
				$section = $sections[ $i ];
				$next    = isset( $sections[ $i + 1 ] ) ? $sections[ $i + 1 ] : null;
				tasheel_render_careers_flexible_section( $section, $next );
				if ( ! $tabs_rendered && ! empty( $section['acf_fc_layout'] ) && $section['acf_fc_layout'] === 'inner_banner' ) {
					get_template_part( 'template-parts/page-tabs', null, $page_tabs_data );
					$tabs_rendered = true;
				}
			}
			if ( ! $tabs_rendered ) {
				get_template_part( 'template-parts/page-tabs', null, $page_tabs_data );
			}
		} else {
			get_template_part( 'template-parts/page-tabs', null, $page_tabs_data );
			$inner_banner_data = array(
				'background_image' => get_template_directory_uri() . '/assets/images/corporate-banner.jpg',
				'title'            => esc_html__( 'Corporate Training', 'tasheel' ),
			);
			get_template_part( 'template-parts/inner-banner', null, $inner_banner_data );
		}
	} else {
		get_template_part( 'template-parts/page-tabs', null, $page_tabs_data );
		$inner_banner_data = array(
			'background_image' => get_template_directory_uri() . '/assets/images/corporate-banner.jpg',
			'title'            => esc_html__( 'Corporate Training', 'tasheel' ),
		);
		get_template_part( 'template-parts/inner-banner', null, $inner_banner_data );
	}
	?>
</main><!-- #main -->

<?php
get_footer();
