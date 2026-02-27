<?php
/**
 * Template Name: Projects
 *
 * The template for displaying the Projects page
 *
 * @package tasheel
 */

get_header();

$projects_page_id = is_page() ? get_queried_object_id() : 0;

// Banner: ACF-manageable (desktop + mobile background image, title)
$banner_image = ( $projects_page_id && function_exists( 'get_field' ) ) ? get_field( 'projects_banner_image', $projects_page_id ) : '';
$banner_image_mobile = ( $projects_page_id && function_exists( 'get_field' ) ) ? get_field( 'projects_banner_image_mobile', $projects_page_id ) : '';
$banner_title = ( $projects_page_id && function_exists( 'get_field' ) ) ? get_field( 'projects_banner_title', $projects_page_id ) : '';
if ( ! is_string( $banner_title ) || $banner_title === '' ) {
	$banner_title = __( 'Projects', 'tasheel' );
}
$banner_bg = $banner_image ? ( is_array( $banner_image ) ? ( isset( $banner_image['url'] ) ? $banner_image['url'] : '' ) : $banner_image ) : ( get_template_directory_uri() . '/assets/images/project-banner.jpg' );
$banner_bg_mobile = '';
if ( $banner_image_mobile ) {
	$banner_bg_mobile = is_array( $banner_image_mobile ) ? ( isset( $banner_image_mobile['url'] ) ? $banner_image_mobile['url'] : '' ) : $banner_image_mobile;
}

// Filter values from URL: category = service_category slug, sector = service post slug (or legacy ID), location = project_location slug (decoded/normalized)
$filter_category = isset($_GET['category']) ? sanitize_text_field( wp_unslash( $_GET['category'] ) ) : '';
$filter_sector   = isset($_GET['sector']) ? sanitize_text_field( wp_unslash( $_GET['sector'] ) ) : '';
$filter_location_raw = isset($_GET['location']) ? wp_unslash( $_GET['location'] ) : '';
$filter_location = is_string( $filter_location_raw ) ? trim( $filter_location_raw ) : '';
$filter_location_term_id = function_exists( 'tasheel_resolve_project_location_term_id' ) ? tasheel_resolve_project_location_term_id( $filter_location ) : 0;
// For dropdown selection, use normalized slug so it matches the option values we output (avoids encoding issues)
$filter_location_slug_for_select = $filter_location;
if ( $filter_location_term_id > 0 && function_exists( 'tasheel_normalize_location_slug' ) ) {
	$loc_term = get_term( $filter_location_term_id, 'project_location' );
	if ( $loc_term && ! is_wp_error( $loc_term ) ) {
		$filter_location_slug_for_select = tasheel_normalize_location_slug( $loc_term->slug ) ?: $loc_term->slug;
	}
}

// Resolve category/sector from URL (WPML-aware: English slugs in URL work on Arabic page)
$category_term_id_for_where = 0;
if ( $filter_category && function_exists( 'tasheel_resolve_category_slug_to_term_id' ) ) {
	$category_term_id_for_where = tasheel_resolve_category_slug_to_term_id( $filter_category );
}
$filter_category_slug_for_select = $filter_category;
if ( $category_term_id_for_where > 0 ) {
	$cat_term_for_select = get_term( $category_term_id_for_where, 'service_category' );
	if ( $cat_term_for_select && ! is_wp_error( $cat_term_for_select ) ) {
		$filter_category_slug_for_select = $cat_term_for_select->slug;
	}
}

// Resolve sector param (slug or numeric ID) to service post ID for meta_query (WPML-aware)
$filter_sector_id = 0;
if ( $filter_sector !== '' && function_exists( 'tasheel_resolve_sector_slug_to_post_id' ) ) {
	$filter_sector_id = tasheel_resolve_sector_slug_to_post_id( $filter_sector );
}
$filter_sector_slug_for_select = $filter_sector;
if ( $filter_sector_id > 0 ) {
	$sector_post_for_select = get_post( $filter_sector_id );
	if ( $sector_post_for_select && $sector_post_for_select->post_type === 'service' ) {
		$filter_sector_slug_for_select = $sector_post_for_select->post_name;
	}
}

// Per-page: from URL, then ACF on this page, then default 12. Allowed range: 1–100
$items_per_page = 12;
if ( isset( $_GET['per_page'] ) ) {
	$req_per = (int) $_GET['per_page'];
	if ( $req_per >= 1 && $req_per <= 100 ) {
		$items_per_page = $req_per;
	}
} elseif ( $projects_page_id && function_exists( 'get_field' ) ) {
	$acf_per = (int) get_field( 'projects_per_page', $projects_page_id );
	if ( $acf_per >= 1 && $acf_per <= 100 ) {
		$items_per_page = $acf_per;
	}
}
// Filter options: only show categories, sectors, and locations that are assigned to at least one project
$category_options = array(array('value' => '', 'text' => __('All Services', 'tasheel')));
$sector_options   = array(array('value' => '', 'text' => __('All Sectors', 'tasheel')));
$location_options = array(array('value' => '', 'text' => __('All Locations', 'tasheel')));

$projects_for_filters = get_posts(array(
	'post_type'      => 'project',
	'posts_per_page' => -1,
	'post_status'    => 'publish',
	'fields'         => 'ids',
));

$category_term_ids = array();
$sector_post_ids   = array();

foreach ($projects_for_filters as $pid) {
	$cat_val = get_post_meta($pid, 'project_category', true);
	if (is_array($cat_val)) {
		foreach ($cat_val as $cid) {
			if ($cid) {
				$category_term_ids[(int) $cid] = true;
			}
		}
	} elseif ($cat_val) {
		$category_term_ids[(int) $cat_val] = true;
	}
	$sector_val = get_post_meta($pid, 'sector', true);
	if (is_array($sector_val)) {
		foreach ($sector_val as $sid) {
			if ($sid) {
				$sector_post_ids[(int) $sid] = true;
			}
		}
	} elseif ($sector_val) {
		$sector_post_ids[(int) $sector_val] = true;
	}
}

// Category: only list categories that have at least one project assigned (project can have multiple categories)
if (!empty($category_term_ids)) {
	$category_terms = get_terms(array(
		'taxonomy' => 'service_category',
		'include'  => array_keys($category_term_ids),
		'orderby'  => 'name',
		'order'    => 'ASC',
	));
	if (!empty($category_terms) && !is_wp_error($category_terms)) {
		foreach ($category_terms as $term) {
			$category_options[] = array('value' => $term->slug, 'text' => $term->name);
		}
	}
}

// Sector options (services used as sector on at least one project) for "All Categories" and sector filter
if (!empty($sector_post_ids)) {
	$sector_posts = get_posts(array(
		'post_type'      => 'service',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'post__in'       => array_keys($sector_post_ids),
		'orderby'        => 'title',
		'order'          => 'ASC',
	));
	foreach ($sector_posts as $sp) {
		$sector_options[] = array('value' => $sp->post_name, 'text' => $sp->post_title);
	}
}

// Sectors by category: only services that belong to this category (Service Categories taxonomy), matching backend behaviour – no mixing from other categories, no duplicates
$sectors_by_category = array();
if (!empty($category_term_ids)) {
	$category_terms_for_sectors = get_terms(array(
		'taxonomy' => 'service_category',
		'include'  => array_keys($category_term_ids),
		'orderby'  => 'name',
		'order'    => 'ASC',
	));
	if (!empty($category_terms_for_sectors) && !is_wp_error($category_terms_for_sectors)) {
		foreach ($category_terms_for_sectors as $term) {
			$tid = (int) $term->term_id;
			$sectors_by_category[$term->slug] = array();
			$services_in_cat = get_posts(array(
				'post_type'      => 'service',
				'posts_per_page' => -1,
				'post_status'    => 'publish',
				'tax_query'      => array(array('taxonomy' => 'service_category', 'field' => 'term_id', 'terms' => $tid)),
				'orderby'        => 'title',
				'order'          => 'ASC',
			));
			foreach ($services_in_cat as $s) {
				$sectors_by_category[$term->slug][] = array('value' => $s->post_name, 'text' => $s->post_title);
			}
		}
	}
}

// When a category is selected, sector dropdown shows only sectors in that category; otherwise sector is disabled
$sector_disabled = ( $category_term_id_for_where <= 0 );
$sector_options_for_select = $sector_options;
$category_slug_for_sectors = $filter_category_slug_for_select ?: $filter_category;
if ( $category_slug_for_sectors && isset( $sectors_by_category[ $category_slug_for_sectors ] ) ) {
	$sector_options_for_select = array( array( 'value' => '', 'text' => __( 'All Sectors', 'tasheel' ) ) );
	$sector_options_for_select = array_merge( $sector_options_for_select, $sectors_by_category[ $category_slug_for_sectors ] );
} elseif ( $sector_disabled ) {
	$sector_options_for_select = array( array( 'value' => '', 'text' => __( 'All Sectors', 'tasheel' ) ) );
}

// Location: only terms that have at least one project; use normalized slug for option value (avoids URL encoding issues)
$locations = get_terms(array(
	'taxonomy'   => 'project_location',
	'hide_empty' => true,
	'orderby'    => 'name',
));
foreach ($locations as $loc) {
	$loc_slug = function_exists( 'tasheel_normalize_location_slug' ) ? tasheel_normalize_location_slug( $loc->slug ) : $loc->slug;
	$location_options[] = array( 'value' => $loc_slug ?: $loc->slug, 'text' => $loc->name );
}
?>

<main id="primary" class="site-main">
	<?php 
	$inner_banner_data = array(
		'background_image' => $banner_bg,
		'background_image_mobile' => $banner_bg_mobile,
		'title' => $banner_title,
	);
	get_template_part('template-parts/inner-banner', null, $inner_banner_data); 
	?>

	<?php 
	// Section heading: ACF-manageable
	$heading_title = ( $projects_page_id && function_exists( 'get_field' ) ) ? get_field( 'projects_heading_title', $projects_page_id ) : '';
	$heading_title_span = ( $projects_page_id && function_exists( 'get_field' ) ) ? get_field( 'projects_heading_title_span', $projects_page_id ) : '';
	if ( ! is_string( $heading_title ) || $heading_title === '' ) {
		$heading_title = __( 'Latest', 'tasheel' );
	}
	if ( ! is_string( $heading_title_span ) || $heading_title_span === '' ) {
		$heading_title_span = __( 'Projects', 'tasheel' );
	}
	$project_filter_data = array(
		'title' => $heading_title,
		'title_span' => $heading_title_span,
		'section_wrapper_class' => array(),
		'section_class' => '',
		'sectors_by_category' => $sectors_by_category,
		'filters' => array(
			array(
				'label' => __('Category', 'tasheel'),
				'filter_type' => 'category',
				'options' => $category_options,
				'default_value' => $filter_category_slug_for_select,
			),
			array(
				'label' => __('Sector', 'tasheel'),
				'filter_type' => 'sector',
				'options' => $sector_options_for_select,
				'default_value' => $filter_sector_slug_for_select,
			),
			array(
				'label' => __('Location', 'tasheel'),
				'filter_type' => 'location',
				'options' => $location_options,
				'default_value' => $filter_location_slug_for_select,
			),
		),
		'clear_filter_text' => __('Clear Filter', 'tasheel'),
		'clear_filter_link' => get_permalink(),
		'section_id' => 'projects-section',
	);
	get_template_part('template-parts/Project-Filter', null, $project_filter_data); 
	?>

	<?php
	$current_lang = function_exists( 'apply_filters' ) ? apply_filters( 'wpml_current_language', '' ) : '';
	?>
	<section class="projects_list_section pt_20 pb_80" style="position:relative;">
		<div class="project_filter_loader" aria-live="polite" style="display:none;position:absolute;inset:0;z-index:10;align-items:center;justify-content:center;background:rgba(255,255,255,0.85);"><?php esc_html_e( 'Loading…', 'tasheel' ); ?></div>
		<div class="wrap">
			<div class="project_cards_grid" id="projects-grid" data-per-page="<?php echo esc_attr( $items_per_page ); ?>" data-offset="<?php echo esc_attr( $items_per_page ); ?>" data-lang="<?php echo esc_attr( $current_lang ); ?>">
				<?php 
				// Query: Category & Sector = ACF fields (choose from service_category; stored as term ID in meta). Location = taxonomy only.
				$projects_args = array(
					'post_type'      => 'project',
					'posts_per_page' => $items_per_page,
					'post_status'    => 'publish',
					'orderby'        => 'date',
					'order'          => 'DESC',
					'paged'          => 1,
				);

				// Location = Project Location (term_id for reliable matching; handles encoded/Unicode slugs)
				if ( $filter_location_term_id > 0 ) {
					$projects_args['tax_query'] = array(
						array(
							'taxonomy' => 'project_location',
							'field'    => 'term_id',
							'terms'    => array( $filter_location_term_id ),
						),
					);
				}

				// Category = ACF project_category (filter applied via tasheel_project_category_posts_where; term_id already resolved WPML-aware above)
				$meta_queries = array();
				$projects_args['tasheel_category_term_id'] = $category_term_id_for_where;

				// Sector = service post ID (resolved from slug or ID in URL); ACF stores as serialized
				if ( $filter_sector_id > 0 ) {
					$sid = $filter_sector_id;
					$meta_queries[] = array(
						'relation' => 'OR',
						array(
							'key'     => 'sector',
							'value'   => '"' . $sid . '"',
							'compare' => 'LIKE',
						),
						array(
							'key'     => 'sector',
							'value'   => 'i:' . $sid . ';',
							'compare' => 'LIKE',
						),
					);
				}
				if ( ! empty( $meta_queries ) ) {
					$meta_queries['relation'] = 'AND';
					$projects_args['meta_query'] = $meta_queries;
				}

				if ( $category_term_id_for_where > 0 ) {
					add_filter( 'posts_where', 'tasheel_project_category_posts_where', 10, 2 );
				}
				$projects_query = new WP_Query( $projects_args );
				if ( $category_term_id_for_where > 0 ) {
					remove_filter( 'posts_where', 'tasheel_project_category_posts_where', 10 );
				}
				
				if ($projects_query->have_posts()) :
					while ($projects_query->have_posts()) : $projects_query->the_post();
						$project_id = get_the_ID();
						
						$project_image = '';
						$project_alt = get_the_title();
						if ( function_exists( 'get_field' ) ) {
							$listing_img = get_field( 'project_listing_image', $project_id );
							if ( ! empty( $listing_img ) ) {
								$project_image = is_array( $listing_img ) ? ( isset( $listing_img['url'] ) ? $listing_img['url'] : '' ) : $listing_img;
							}
						}
						if ( ! $project_image && has_post_thumbnail( $project_id ) ) {
							$project_image = get_the_post_thumbnail_url( $project_id, 'full' );
							$project_alt = get_the_post_thumbnail_caption( $project_id ) ?: get_the_title();
						}
						
						$title_first = '';
						$title_second = '';
						if ( function_exists( 'get_field' ) ) {
							$title_first = get_field( 'project_listing_title_first', $project_id );
							$title_second = get_field( 'project_listing_title_span', $project_id );
						}
						if ( ! is_string( $title_first ) ) {
							$title_first = '';
						}
						if ( ! is_string( $title_second ) ) {
							$title_second = '';
						}
						if ( $title_first === '' && $title_second === '' ) {
							$project_title = get_the_title();
							$title_parts = explode( ' ', $project_title );
							$title_mid = ceil( count( $title_parts ) / 2 );
							$title_first = implode( ' ', array_slice( $title_parts, 0, $title_mid ) );
							$title_second = implode( ' ', array_slice( $title_parts, $title_mid ) );
						}
						
						$project_description = '';
						if ( function_exists( 'get_field' ) ) {
							$project_description = get_field( 'project_listing_description', $project_id );
						}
						if ( ! is_string( $project_description ) || $project_description === '' ) {
							$project_description = get_the_excerpt();
						}
						$project_link = get_permalink($project_id);
						
						$project_card_data = array(
							'image' => $project_image,
							'image_alt' => $project_alt,
							'title' => $title_first,
							'title_span' => $title_second,
							'description' => $project_description,
							'link' => $project_link,
							'card_class' => '',
						);
						
						get_template_part('template-parts/Project-Card', null, $project_card_data);
					endwhile;
					wp_reset_postdata();
				else :
					?>
					<p class="no-projects"><?php _e('No projects found.', 'tasheel'); ?></p>
					<?php
				endif;
				?>

			</div>

			<?php
			// Always output Load More wrapper so JS can show/hide it after filtering (must exist in DOM)
			$total_found = $projects_query ? (int) $projects_query->found_posts : 0;
			$per_page = (int) $items_per_page;
			$show_load_more = $total_found > $per_page;
			?>
			<div class="load_more_wrapper" data-total="<?php echo (int) $total_found; ?>" style="display:<?php echo $show_load_more ? '' : 'none'; ?>">
				<button type="button" class="btn_style btn_green load_more_btn" id="load-more-projects">
					<span><?php _e('Load More', 'tasheel'); ?></span>
				</button>
			</div>
		</div>
	</section>

</main><!-- #main -->

<?php
get_footer();
