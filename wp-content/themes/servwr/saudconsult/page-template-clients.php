<?php
/**
 * Template Name: Clients
 *
 * The template for displaying the Clients page. Uses ACF Flexible Content:
 * - Inner Banner
 * - Clients Section (heading + category filter + grid from Client CPT, AJAX filter & load more)
 * Sections with no content are hidden. All strings are WPML-ready.
 *
 * @package tasheel
 */

get_header();

$page_id = get_queried_object_id();
$sections = ( $page_id && function_exists( 'get_field' ) ) ? get_field( 'page_sections', $page_id ) : null;

if ( ! is_array( $sections ) || empty( $sections ) ) {
	// Fallback: show default banner + empty clients section structure so admin knows to add content
	$inner_banner_data = array(
		'background_image'      => get_template_directory_uri() . '/assets/images/client-img.jpg',
		'background_image_mobile' => '',
		'title'                 => __( 'Clients', 'tasheel' ),
	);
	get_template_part( 'template-parts/inner-banner', null, $inner_banner_data );
	?>
	<div class="pt_80">
		<div class="wrap">
			<p class="no-clients"><?php esc_html_e( 'Add page sections using the Clients Page flexible content in the editor.', 'tasheel' ); ?></p>
		</div>
	</div>
	<?php
	get_footer();
	return;
}
?>

<main id="primary" class="site-main">
	<?php
	foreach ( $sections as $section ) {
		$layout = isset( $section['acf_fc_layout'] ) ? $section['acf_fc_layout'] : '';

		if ( $layout === 'inner_banner' ) {
			$bg      = isset( $section['background_image'] ) ? $section['background_image'] : '';
			$bg_mobile = isset( $section['background_image_mobile'] ) ? $section['background_image_mobile'] : '';
			$title   = isset( $section['title'] ) ? $section['title'] : '';
			if ( ! is_string( $title ) ) {
				$title = __( 'Clients', 'tasheel' );
			}
			$banner_url = $bg ? ( is_array( $bg ) ? ( isset( $bg['url'] ) ? $bg['url'] : '' ) : $bg ) : get_template_directory_uri() . '/assets/images/client-img.jpg';
			$banner_mobile = '';
			if ( $bg_mobile ) {
				$banner_mobile = is_array( $bg_mobile ) ? ( isset( $bg_mobile['url'] ) ? $bg_mobile['url'] : '' ) : $bg_mobile;
			}
			$inner_banner_data = array(
				'background_image'       => $banner_url,
				'background_image_mobile' => $banner_mobile,
				'title'                  => $title,
			);
			get_template_part( 'template-parts/inner-banner', null, $inner_banner_data );
		}

		if ( $layout === 'clients_section' ) {
			$heading_title      = isset( $section['heading_title'] ) ? $section['heading_title'] : '';
			$heading_title_span = isset( $section['heading_title_span'] ) ? $section['heading_title_span'] : '';
			$load_more_label    = isset( $section['load_more_label'] ) ? $section['load_more_label'] : '';
			$per_page           = isset( $section['clients_per_page'] ) ? max( 1, min( 100, (int) $section['clients_per_page'] ) ) : 12;
			if ( ! is_string( $heading_title ) ) {
				$heading_title = __( 'Our', 'tasheel' );
			}
			if ( ! is_string( $heading_title_span ) ) {
				$heading_title_span = __( 'Clients', 'tasheel' );
			}
			if ( ! is_string( $load_more_label ) || $load_more_label === '' ) {
				$load_more_label = __( 'Load more', 'tasheel' );
			}

			$filter_category = isset( $_GET['category'] ) ? sanitize_text_field( wp_unslash( $_GET['category'] ) ) : '';

			// Categories for filter tabs (same order as "All" – used for category order on Clients page)
			$category_terms = get_terms( array(
				'taxonomy'   => 'client_category',
				'hide_empty' => true,
				'orderby'    => 'name',
				'order'      => 'ASC',
			) );
			$filter_categories = array();
			if ( ! is_wp_error( $category_terms ) && ! empty( $category_terms ) ) {
				foreach ( $category_terms as $term ) {
					$filter_categories[] = array( 'slug' => $term->slug, 'name' => $term->name );
				}
			}

			// "All" uses category order (same as home); single category uses normal query.
			if ( $filter_category === '' ) {
				$order_result = tasheel_get_client_ids_by_category_order( 0, $per_page );
				$client_ids   = $order_result['ids'];
				$total_found  = $order_result['total'];
				$clients      = array();
				foreach ( $client_ids as $pid ) {
					$clients[] = tasheel_build_client_item_data( $pid );
				}
			} else {
				$clients_args = array(
					'post_type'      => 'client',
					'posts_per_page' => $per_page,
					'post_status'    => 'publish',
					'orderby'        => 'menu_order title',
					'order'          => 'ASC',
					'tax_query'      => array(
						array(
							'taxonomy' => 'client_category',
							'field'    => 'slug',
							'terms'    => $filter_category,
						),
					),
				);
				$clients_query = new WP_Query( $clients_args );
				$clients       = array();
				if ( $clients_query->have_posts() ) {
					while ( $clients_query->have_posts() ) {
						$clients_query->the_post();
						$clients[] = tasheel_build_client_item_data( get_the_ID() );
					}
					wp_reset_postdata();
				}
				$total_found = (int) $clients_query->found_posts;
			}
			$show_load_more = $total_found > $per_page;
			?>
			<div class="pt_80">
				<div class="wrap">
					<?php
					get_template_part( 'template-parts/Clients-Filter', null, array(
						'title'       => $heading_title,
						'title_span'  => $heading_title_span,
						'categories'  => $filter_categories,
						'active_slug' => $filter_category,
						'filter_id'   => 'clients-section',
					) );
					?>
				</div>
			</div>

			<div class="wrap">
				<?php
				// Only output clients list section if we have clients or categories (filter has meaning)
				$has_any_clients = $total_found > 0;
				if ( $has_any_clients || ! empty( $filter_categories ) ) {
					?>
					<section class="clients_list_section pt_20 pb_80" aria-live="polite" style="position:relative;">
						<div class="project_filter_loader clients_filter_loader" style="display:none;position:absolute;inset:0;z-index:10;align-items:center;justify-content:center;background:rgba(255,255,255,0.85);"><?php esc_html_e( 'Loading…', 'tasheel' ); ?></div>
						<?php
						get_template_part( 'template-parts/Client-List', null, array(
							'title'            => '',
							'title_span'      => '',
							'clients'         => $clients,
							'display_type'    => 'grid',
							'section_class'   => 'clients_page_grid',
							'grid_id'         => 'clients-grid',
							'enable_load_more' => true,
							'load_more_btn_id' => 'load-more-clients-ajax',
							'load_more_label' => $load_more_label,
							'data_per_page'   => $per_page,
							'data_offset'     => count( $clients ),
							'data_total'     => $total_found,
							'show_load_more'  => $show_load_more,
						) );
						?>
					</section>
					<?php
				} else {
					?>
					<div class="client_list_section pt_40 pb_80 clients_page_grid">
						<p class="no-clients"><?php esc_html_e( 'No clients found.', 'tasheel' ); ?></p>
					</div>
					<?php
				}
				?>
			</div>
			<?php
		}
	}
	?>
</main><!-- #main -->

<?php
get_footer();
