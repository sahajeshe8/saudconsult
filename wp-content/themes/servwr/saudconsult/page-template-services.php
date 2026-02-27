<?php
/**
 * Template Name: Services
 *
 * The template for displaying the Services page
 *
 * @package tasheel
 */

get_header();

// Get ACF Flexible Content (order is automatically preserved from ACF admin)
$page_sections = get_field('page_sections');

if ($page_sections && is_array($page_sections)) :
	// Loop through sections in the exact order they appear in ACF admin
	foreach ($page_sections as $section) :
		if (empty($section['acf_fc_layout'])) {
			continue; // Skip invalid sections
		}
		$layout = $section['acf_fc_layout'];
		
		// Inner Banner
		if ($layout === 'inner_banner' && (!empty($section['background_image']) || !empty($section['title']))) :
			$banner_bg = !empty($section['background_image']) ? $section['background_image'] : get_template_directory_uri() . '/assets/images/service-banner.jpg';
			$banner_bg = is_array($banner_bg) ? (isset($banner_bg['url']) ? $banner_bg['url'] : '') : $banner_bg;
			$banner_bg_mobile = '';
			if (!empty($section['background_image_mobile'])) {
				$banner_bg_mobile = is_array($section['background_image_mobile']) ? (isset($section['background_image_mobile']['url']) ? $section['background_image_mobile']['url'] : '') : $section['background_image_mobile'];
			}
			$inner_banner_data = array(
				'background_image' => $banner_bg,
				'background_image_mobile' => $banner_bg_mobile,
				'title' => !empty($section['title']) ? apply_filters('wpml_translate_single_string', $section['title'], 'ACF', 'inner_banner_title') : __('Services', 'tasheel'),
			);
			get_template_part('template-parts/inner-banner', null, $inner_banner_data);
		endif;
		
		// Content Block
		if ($layout === 'content_block' && (!empty($section['title']) || !empty($section['content']))) :
			$content_block_service_data = array(
				'title' => !empty($section['title']) ? apply_filters('wpml_translate_single_string', $section['title'], 'ACF', 'content_block_title') : '',
				'content' => !empty($section['content']) ? apply_filters('wpml_translate_single_string', $section['content'], 'ACF', 'content_block_content') : '',
				'section_wrapper_class' => array('bg_collor_green')
			);
			get_template_part('template-parts/Content-Block-Service', null, $content_block_service_data);
		endif;
		
		// Services Grid: show categories (terms); click category → category page with details + matched services
		if ($layout === 'services_grid') :
			$services_source = !empty($section['services_source']) ? $section['services_source'] : 'all';
			$bg_class = 'bg_collor_green';

			// List categories (terms) on the listing page; optionally filter or manual selection
			$term_args = array(
				'taxonomy'   => 'service_category',
				'hide_empty' => false,
				'orderby'    => 'name',
				'order'      => 'ASC',
			);
			if ($services_source === 'category' && !empty($section['service_category'])) {
				$term_args['include'] = (array) $section['service_category'];
			} elseif ($services_source === 'manual' && !empty($section['services_manual'])) {
				// Manual: show selected service posts (not categories)
				$args = array(
					'post_type'      => 'service',
					'posts_per_page' => -1,
					'post_status'    => 'publish',
					'post__in'       => $section['services_manual'],
					'orderby'        => 'post__in',
				);
				$services_query = new WP_Query($args);
				if ($services_query->have_posts()) :
					?>
					<section class="services_items_section pb_80 <?php echo esc_attr($bg_class); ?>">
						<div class="wrap">
							<ul class="services_items_grid">
								<?php
								while ($services_query->have_posts()) : $services_query->the_post();
									$service_id = get_the_ID();
									$basic_info = get_field('basic_info', $service_id);
									$service_image = '';
									$service_alt = get_the_title();
									// Use featured_image
									$service_image = '';
									$service_alt = get_the_title();
									if (!empty($basic_info['featured_image'])) {
										$service_image = is_array($basic_info['featured_image']) 
											? $basic_info['featured_image']['url'] 
											: $basic_info['featured_image'];
										$service_alt = !empty($basic_info['featured_image']['alt']) 
											? $basic_info['featured_image']['alt'] 
											: get_the_title();
									} elseif (has_post_thumbnail($service_id)) {
										$service_image = get_the_post_thumbnail_url($service_id, 'full');
									}
									
									// Get listing description or fallback to excerpt
									$description_text = !empty($basic_info['listing_description']) 
										? wp_kses_post($basic_info['listing_description']) 
										: get_the_excerpt();
									
									$service_item_data = array(
										'image'        => $service_image,
										'image_alt'    => $service_alt,
										'title'        => get_the_title(),
										'subtitle'     => '',
										'description'  => $description_text,
										'button_text'  => __('View more', 'tasheel'),
										'button_link'  => get_permalink($service_id),
									);
									?>
									<li><?php get_template_part('template-parts/Service-Item', null, $service_item_data); ?></li>
									<?php
								endwhile;
								wp_reset_postdata();
								?>
							</ul>
						</div>
					</section>
					<?php
				endif;
				// Skip term grid below for manual
			} else {
				$categories = get_terms($term_args);
				if (!empty($categories) && !is_wp_error($categories)) :
					?>
					<section class="services_items_section pb_80 <?php echo esc_attr($bg_class); ?>">
						<div class="wrap">
							<ul class="services_items_grid">
								<?php
								foreach ($categories as $term) {
									$term_link = get_term_link($term);
									if (is_wp_error($term_link)) {
										continue;
									}
									// Get category thumbnail (from term ACF), then fallback to first service
									$cat_image = get_template_directory_uri() . '/assets/images/service-01.jpg';
									$cat_thumbnail = get_field('services_listing_thumbnail', 'service_category_' . $term->term_id);
									if (!empty($cat_thumbnail)) {
										$cat_image = is_array($cat_thumbnail) ? $cat_thumbnail['url'] : $cat_thumbnail;
									} else {
										// Fallback: use first service in category
										$first = get_posts(array(
											'post_type'   => 'service',
											'posts_per_page' => 1,
											'tax_query'   => array(array('taxonomy' => 'service_category', 'field' => 'term_id', 'terms' => $term->term_id)),
										));
										if (!empty($first)) {
											$first_service_id = $first[0]->ID;
											$first_basic_info = get_field('basic_info', $first_service_id);
											// Use featured_image, then post thumbnail
											if (!empty($first_basic_info['featured_image'])) {
												$cat_image = is_array($first_basic_info['featured_image']) 
													? $first_basic_info['featured_image']['url'] 
													: $first_basic_info['featured_image'];
											} elseif (has_post_thumbnail($first_service_id)) {
												$cat_image = get_the_post_thumbnail_url($first_service_id, 'full');
											}
										}
									}
									// Get listing content from ACF fields
									$listing_subtitle = get_field('listing_subtitle', 'service_category_' . $term->term_id);
									$listing_description = get_field('listing_description', 'service_category_' . $term->term_id);
									
									$cat_item_data = array(
										'image'        => $cat_image,
										'image_alt'    => $term->name,
										'title'        => $term->name,
										'subtitle'     => !empty($listing_subtitle) ? $listing_subtitle : '',
										'description'  => !empty($listing_description) 
											? wp_kses_post($listing_description) 
											: ($term->description ? wp_kses_post($term->description) : ''),
										'button_text'  => __('View more', 'tasheel'),
										'button_link'  => $term_link,
									);
									?>
									<li><?php get_template_part('template-parts/Service-Item', null, $cat_item_data); ?></li>
									<?php
								}
								?>
							</ul>
						</div>
					</section>
					<?php
				endif;
			}
		endif;
	endforeach;
else :
	// Fallback to default content if no ACF fields
	$inner_banner_data = array(
		'background_image' => get_template_directory_uri() . '/assets/images/service-banner.jpg',
		'title' => __('Services', 'tasheel'),
	);
	get_template_part('template-parts/inner-banner', null, $inner_banner_data);
	
	$content_block_service_data = array(
		'title' => __('Our Comprehensive<br> <span>Services</span>', 'tasheel'),
		'content' => __('Our multidisciplinary team is structured to deliver integrated solutions across the following critical sectors, ensuring innovation and efficiency in every design.', 'tasheel'),
		'section_wrapper_class' => array('bg_collor_green')
	);
	get_template_part('template-parts/Content-Block-Service', null, $content_block_service_data);
	
	// Default: show categories (terms); click → category page with matched services
	$categories = get_terms(array('taxonomy' => 'service_category', 'hide_empty' => false, 'orderby' => 'name', 'order' => 'ASC'));
	if (!empty($categories) && !is_wp_error($categories)) :
		?>
		<section class="services_items_section pb_80 bg_collor_green">
			<div class="wrap">
				<ul class="services_items_grid">
					<?php
					foreach ($categories as $term) {
						$term_link = get_term_link($term);
						if (is_wp_error($term_link)) {
							continue;
						}
						// Get category thumbnail (from term ACF), then fallback to first service
						$cat_image = get_template_directory_uri() . '/assets/images/service-01.jpg';
						$cat_thumbnail = get_field('services_listing_thumbnail', 'service_category_' . $term->term_id);
						if (!empty($cat_thumbnail)) {
							$cat_image = is_array($cat_thumbnail) ? $cat_thumbnail['url'] : $cat_thumbnail;
						} else {
							// Fallback: use first service in category
							$first = get_posts(array('post_type' => 'service', 'posts_per_page' => 1, 'tax_query' => array(array('taxonomy' => 'service_category', 'field' => 'term_id', 'terms' => $term->term_id))));
							if (!empty($first)) {
								$first_service_id = $first[0]->ID;
								$first_basic_info = get_field('basic_info', $first_service_id);
								// Use featured_image, then post thumbnail
								if (!empty($first_basic_info['featured_image'])) {
									$cat_image = is_array($first_basic_info['featured_image']) 
										? $first_basic_info['featured_image']['url'] 
										: $first_basic_info['featured_image'];
								} elseif (has_post_thumbnail($first_service_id)) {
									$cat_image = get_the_post_thumbnail_url($first_service_id, 'full');
								}
							}
						}
						// Get listing content from ACF fields
						$listing_subtitle = get_field('listing_subtitle', 'service_category_' . $term->term_id);
						$listing_description = get_field('listing_description', 'service_category_' . $term->term_id);
						
						$cat_item_data = array(
							'image' => $cat_image,
							'image_alt' => $term->name,
							'title' => $term->name,
							'subtitle' => !empty($listing_subtitle) ? $listing_subtitle : '',
							'description' => !empty($listing_description) 
								? wp_kses_post($listing_description) 
								: ($term->description ? wp_kses_post($term->description) : ''),
							'button_text' => __('View more', 'tasheel'),
							'button_link' => $term_link,
						);
						?>
						<li><?php get_template_part('template-parts/Service-Item', null, $cat_item_data); ?></li>
						<?php
					}
					?>
				</ul>
			</div>
		</section>
		<?php
	endif;
endif;
?>

</main><!-- #main -->

<?php
get_footer();
