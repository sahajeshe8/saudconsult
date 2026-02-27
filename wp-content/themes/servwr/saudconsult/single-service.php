<?php
/**
 * The template for displaying single service posts
 *
 * @package tasheel
 */

get_header();

while (have_posts()) :
	the_post();
	$service_id = get_the_ID();
	
	// Get current service's category for breadcrumb
	$current_categories = wp_get_post_terms($service_id, 'service_category', array('fields' => 'all'));
	$category_name = !empty($current_categories) ? $current_categories[0]->name : '';
	$category_link = !empty($current_categories) ? get_term_link($current_categories[0]) : home_url('/services');
	
	// Services page URL for breadcrumb
	$services_page_url = home_url('/services/');
	$services_pages = get_posts(array('post_type' => 'page', 'meta_key' => '_wp_page_template', 'meta_value' => 'page-template-services.php', 'numberposts' => 1, 'post_status' => 'publish'));
	if (!empty($services_pages)) {
		$services_page_url = get_permalink($services_pages[0]->ID);
	}
	
	// Get ACF Flexible Content (order is automatically preserved from ACF admin)
	$page_sections = get_field('page_sections');
	
	if ($page_sections && is_array($page_sections)) :
		// First loop: render inner_banner if it exists
		foreach ($page_sections as $section) :
			if (empty($section['acf_fc_layout'])) {
				continue;
			}
			$layout = $section['acf_fc_layout'];
			
			// Inner Banner
			if ($layout === 'inner_banner' && (!empty($section['background_image']) || !empty($section['title']))) :
				$banner_bg = !empty($section['background_image']) ? $section['background_image'] : (has_post_thumbnail() ? get_the_post_thumbnail_url($service_id, 'full') : get_template_directory_uri() . '/assets/images/service-banner.jpg');
				$banner_bg = is_array($banner_bg) ? (isset($banner_bg['url']) ? $banner_bg['url'] : '') : $banner_bg;
				$banner_bg_mobile = '';
				if (!empty($section['background_image_mobile'])) {
					$banner_bg_mobile = is_array($section['background_image_mobile']) ? (isset($section['background_image_mobile']['url']) ? $section['background_image_mobile']['url'] : '') : $section['background_image_mobile'];
				}
				$inner_banner_data = array(
					'background_image' => $banner_bg,
					'background_image_mobile' => $banner_bg_mobile,
					'title' => !empty($section['title']) 
						? apply_filters('wpml_translate_single_string', $section['title'], 'ACF', 'inner_banner_title_' . $service_id) 
						: get_the_title(),
				);
				get_template_part('template-parts/inner-banner', null, $inner_banner_data);
			endif;
		endforeach;
	endif;

	// Auto-generate breadcrumb (always show after banner, not from ACF)
	$breadcrumb_data = array(
		'breadcrumb_items' => array(
			array(
				'title' => '',
				'url' => esc_url(home_url('/')),
				'icon' => true
			),
			array(
				'title' => __('Services', 'tasheel'),
				'url' => $services_page_url
			),
		),
		'section_wrapper_class' => array(),
		'section_class' => ''
	);
	
	// Add category if available
	if (!empty($category_name)) {
		$breadcrumb_data['breadcrumb_items'][] = array(
			'title' => $category_name,
			'url' => $category_link
		);
	}
	
	// Add current service (active)
	$breadcrumb_data['breadcrumb_items'][] = array(
		'title' => get_the_title(),
		'url' => '' // Empty URL makes it active
	);
	
	get_template_part('template-parts/Breadcrumb', null, $breadcrumb_data);

	// Continue with remaining ACF sections (skip inner_banner as it's already rendered)
	if ($page_sections && is_array($page_sections)) :
		foreach ($page_sections as $section) :
			if (empty($section['acf_fc_layout'])) {
				continue; // Skip invalid sections
			}
			$layout = $section['acf_fc_layout'];

			// Skip inner_banner (already rendered above)
			if ($layout === 'inner_banner') {
				continue;
			}
			
			// Image Text Block (first block only)
			if ($layout === 'image_text_block' && (!empty($section['title']) || !empty($section['content']))) :
				$image = '';
				if (!empty($section['image'])) {
					$image = is_array($section['image']) ? $section['image']['url'] : $section['image'];
				}
				$image_title = !empty($section['title']) ? apply_filters('wpml_translate_single_string', $section['title'], 'ACF', 'image_text_title_' . $service_id) : '';
				$image_title_span = !empty($section['title_span']) ? apply_filters('wpml_translate_single_string', $section['title_span'], 'ACF', 'image_text_title_span_' . $service_id) : '';
				$image_text_data = array(
					'image' => $image,
					'image_alt' => !empty($section['image']['alt']) ? $section['image']['alt'] : get_the_title(),
					'title' => $image_title,
					'title_span' => $image_title_span,
					'content' => !empty($section['content']) ? apply_filters('wpml_translate_single_string', $section['content'], 'ACF', 'image_text_content_' . $service_id) : '',
					'button_text' => '',
					'button_link' => '',
					'section_class' => 'pb_0',
					'bg_style' => '',
					'image_container_class' => '',
					'text_container_class' => ''
				);
				get_template_part('template-parts/image-text-block', null, $image_text_data);
			endif;

			// Image Text Block 2 (reversed - hardcoded classes)
			if ($layout === 'image_text_block_2' && (!empty($section['title']) || !empty($section['content']))) :
				$image = '';
				if (!empty($section['image'])) {
					$image = is_array($section['image']) ? $section['image']['url'] : $section['image'];
				}
				$image_title = !empty($section['title']) ? apply_filters('wpml_translate_single_string', $section['title'], 'ACF', 'image_text_2_title_' . $service_id) : '';
				$image_title_span = !empty($section['title_span']) ? apply_filters('wpml_translate_single_string', $section['title_span'], 'ACF', 'image_text_2_title_span_' . $service_id) : '';
				$image_text_data = array(
					'image' => $image,
					'image_alt' => !empty($section['image']['alt']) ? $section['image']['alt'] : get_the_title(),
					'title' => $image_title,
					'title_span' => $image_title_span,
					'content' => !empty($section['content']) ? apply_filters('wpml_translate_single_string', $section['content'], 'ACF', 'image_text_2_content_' . $service_id) : '',
					'button_text' => '',
					'button_link' => '',
					'section_class' => 'row_reverse',
					'bg_style' => 'bg_gradient',
					'image_container_class' => '',
					'text_container_class' => ''
				);
				get_template_part('template-parts/image-text-block', null, $image_text_data);
			endif;
			
			// Projects Home (service detail: only projects that have this service in their sector)
			if ($layout === 'projects_home') :
				$projects_source = !empty($section['projects_source']) ? $section['projects_source'] : 'manual';
				$projects_limit = !empty($section['projects_limit']) ? intval($section['projects_limit']) : 3;
				$projects_args = array(
					'post_type' => 'project',
					'posts_per_page' => $projects_limit > 0 ? $projects_limit : -1,
					'post_status' => 'publish',
				);
				if ($projects_source === 'manual' && !empty($section['projects_manual'])) {
					$projects_args['post__in'] = $section['projects_manual'];
					$projects_args['orderby'] = 'post__in';
				} else {
					$projects_args['orderby'] = 'date';
					$projects_args['order'] = 'DESC';
				}
				// On service detail page: only show projects whose sector includes this service (ACF relationship)
				$sid = (int) $service_id;
				if ($sid > 0) {
					$projects_args['meta_query'] = array(
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
				$projects_query = new WP_Query($projects_args);
				$projects = array();
				if ($projects_query->have_posts()) {
					while ($projects_query->have_posts()) {
						$projects_query->the_post();
						$project_id = get_the_ID();
						$project_stats = function_exists('tasheel_get_project_info_items') ? tasheel_get_project_info_items($project_id) : array();
						$project_bg = '';
						$project_bg_mobile = '';
						if (function_exists('get_field')) {
							$d = get_field('project_listing_services_image_desktop', $project_id);
							$m = get_field('project_listing_services_image_mobile', $project_id);
							if (!empty($d)) {
								$project_bg = is_array($d) ? (isset($d['url']) ? $d['url'] : '') : $d;
							}
							if (!empty($m)) {
								$project_bg_mobile = is_array($m) ? (isset($m['url']) ? $m['url'] : '') : $m;
							}
						}
						if (!$project_bg && has_post_thumbnail($project_id)) {
							$project_bg = get_the_post_thumbnail_url($project_id, 'full');
						}
						if (!$project_bg_mobile) {
							$project_bg_mobile = $project_bg;
						}
						
						$listing_desc = function_exists('get_field') ? get_field('project_listing_description', $project_id) : '';
						if (!is_string($listing_desc) || $listing_desc === '') {
							$listing_desc = get_the_excerpt();
						}
						$projects[] = array(
							'background_image' => $project_bg,
							'background_image_mobile' => $project_bg_mobile,
							'background_image_alt' => get_the_title(),
							'title' => get_the_title(),
							'description' => $listing_desc,
							'button_text' => __('Explore More', 'tasheel'),
							'button_link' => get_permalink($project_id),
							'stats' => $project_stats
						);
					}
					wp_reset_postdata();
				}
				
				$no_projects_behavior = isset($section['no_projects_behavior']) ? $section['no_projects_behavior'] : 'hide';
				if (empty($projects) && $no_projects_behavior === 'hide') {
					// Don't output the Projects section at all when no projects and "Hide section" is chosen
				} else {
					$empty_message = ( $no_projects_behavior === 'message' && !empty($section['empty_message']) ) ? $section['empty_message'] : ( $no_projects_behavior === 'message' ? __('No projects to display at this time.', 'tasheel') : '' );
					// Auto-build "View All ... Projects" URL: projects listing page + filter by service category + current service (sector)
					$projects_listing_url = get_post_type_archive_link('project');
					if (!$projects_listing_url) {
						$projects_page = get_posts(array('post_type' => 'page', 'meta_key' => '_wp_page_template', 'meta_value' => 'page-template-projects.php', 'numberposts' => 1, 'post_status' => 'publish'));
						$projects_listing_url = !empty($projects_page) ? get_permalink($projects_page[0]->ID) : home_url('/');
					}
					$filter_args = array();
					if (!empty($current_categories) && isset($current_categories[0]->slug)) {
						$filter_args['category'] = $current_categories[0]->slug;
					}
					$service_post = get_post($service_id);
					$filter_args['sector'] = ($service_post && $service_post->post_name) ? $service_post->post_name : $service_id;
					$projects_view_all_url = add_query_arg($filter_args, $projects_listing_url) . '#projects-section';
					$projects_home_data = array(
						'label_text' => '',
						'label_icon' => get_template_directory_uri() . '/assets/images/dot-02.svg',
						'title' => !empty($section['title']) ? $section['title'] : __('Projects', 'tasheel'),
						'title_span' => '',
						'description' => !empty($section['description']) ? $section['description'] : '',
						'button_text' => !empty($section['button_text']) ? $section['button_text'] : __('View All Projects', 'tasheel'),
						'button_link' => $projects_view_all_url,
						'section_wrapper_class' => array(),
						'section_class' => '',
						'projects' => $projects,
						'empty_message' => $empty_message
					);
					get_template_part('template-parts/Projects-home', null, $projects_home_data);
				}
			endif;

			// What to Expect / Capabilities
			if ($layout === 'what_to_expect' && (!empty($section['title']) || !empty($section['items']))) :
				$items = array();
				if (!empty($section['items'])) {
					$item_index = 0;
					foreach ($section['items'] as $item) {
						// Pattern: first 2 items have bg_class, last 4 items have item_class
						// Items 0,1: bg_class = 'bg_collor_green box-style-01'
						// Items 2,3,4,5: item_class = 'bg_collor_green box-style-01'
						$bg_class = '';
						$item_class = '';
						if ($item_index < 2) {
							$bg_class = 'bg_collor_green box-style-01';
						} else {
							$item_class = 'bg_collor_green box-style-01';
						}
						
						// Get icon alt from image array if available
						$icon_alt = '';
						if (!empty($item['icon']) && is_array($item['icon'])) {
							$icon_alt = !empty($item['icon']['alt']) ? $item['icon']['alt'] : '';
						}
						
						$items[] = array(
							'icon' => !empty($item['icon']) ? (is_array($item['icon']) ? $item['icon']['url'] : $item['icon']) : '',
							'icon_alt' => $icon_alt,
							'title' => isset($item['title']) ? $item['title'] : '',
							'title_span' => isset($item['title_span']) ? $item['title_span'] : '',
							'content' => isset($item['content']) ? $item['content'] : '',
							'bg_class' => $bg_class,
							'item_class' => $item_class,
						);
						$item_index++;
					}
				}
				$what_to_expect_data = array(
					'title' => isset($section['title']) ? $section['title'] : '',
					'title_span' => '',
					'description' => isset($section['description']) ? $section['description'] : '',
					'section_wrapper_class' => array(),
					'section_class' => '',
					'background_color' => '',
					'items' => $items
				);
				get_template_part('template-parts/What-to-Expect', null, $what_to_expect_data);
			endif;

			// Why Partner
			if ($layout === 'why_partner' && (!empty($section['title']) || !empty($section['items']))) :
				$wp_items = array();
				if (!empty($section['items'])) {
					foreach ($section['items'] as $item) {
						$icon_url = '';
						$icon_alt = '';
						if (!empty($item['icon'])) {
							if (is_array($item['icon'])) {
								$icon_url = !empty($item['icon']['url']) ? $item['icon']['url'] : '';
								$icon_alt = !empty($item['icon']['alt']) ? $item['icon']['alt'] : '';
							} else {
								$icon_url = $item['icon'];
							}
						}
						$wp_items[] = array(
							'icon' => $icon_url,
							'icon_alt' => $icon_alt,
							'title' => isset($item['title']) ? $item['title'] : '',
							'text' => isset($item['text']) ? $item['text'] : '',
						);
					}
				}
				// Handle title with <br> tag support
				$why_title = isset($section['title']) ? $section['title'] : '';
				$why_title_span = isset($section['title_span']) ? $section['title_span'] : '';
				// If title_span contains <br>, it should be part of the title_span
				$why_partner_data = array(
					'title' => $why_title,
					'title_span' => $why_title_span,
					'section_wrapper_class' => array(),
					'section_class' => 'bg_img_02 pt_80', // Hardcoded as per Infrastructure template
					'items' => $wp_items
				);
				get_template_part('template-parts/Why-Partner', null, $why_partner_data);
			endif;

			// Banner Add (CTA)
			if ($layout === 'banner_add' && (!empty($section['title']) || !empty($section['button_text']))) :
				$banner_bg = !empty($section['background_image']) ? $section['background_image'] : get_template_directory_uri() . '/assets/images/design-bg-img.jpg';
				$banner_bg = is_array($banner_bg) ? (isset($banner_bg['url']) ? $banner_bg['url'] : '') : $banner_bg;
				$banner_bg_mobile = '';
				if (!empty($section['background_image_mobile'])) {
					$banner_bg_mobile = is_array($section['background_image_mobile']) ? (isset($section['background_image_mobile']['url']) ? $section['background_image_mobile']['url'] : '') : $section['background_image_mobile'];
				}
				$banner_add_data = array(
					'background_image' => $banner_bg,
					'mobile_image' => $banner_bg_mobile,
					'title' => !empty($section['title']) ? apply_filters('wpml_translate_single_string', $section['title'], 'ACF', 'banner_add_title_' . $service_id) : '',
					'subtitle' => !empty($section['subtitle']) ? apply_filters('wpml_translate_single_string', $section['subtitle'], 'ACF', 'banner_add_subtitle_' . $service_id) : '',
					'description' => !empty($section['description']) ? apply_filters('wpml_translate_single_string', $section['description'], 'ACF', 'banner_add_description_' . $service_id) : '',
					'button_text' => !empty($section['button_text']) ? apply_filters('wpml_translate_single_string', $section['button_text'], 'ACF', 'banner_add_button_text_' . $service_id) : '',
					'button_link' => !empty($section['button_link']) ? $section['button_link'] : '#'
				);
				get_template_part('template-parts/banner-add', null, $banner_add_data);
			endif;
		endforeach;
	endif;

endwhile;
?>

</main><!-- #main -->

<?php
get_footer();
