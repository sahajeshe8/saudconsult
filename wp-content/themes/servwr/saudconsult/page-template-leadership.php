<?php
/**
 * Template Name: Leadership
 *
 * Content is managed via ACF Flexible Content. Visionary Leadership can use global data from Company Options. WPML-ready.
 *
 * @package tasheel
 */

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
</main><!-- #main -->

<?php
get_footer();
