<?php
/**
 * Main category details (like Engineering Design): ACF flexible + matched services
 *
 * @package tasheel
 */

get_header();

$term = get_queried_object();
if (!$term || !isset($term->term_id)) {
	return;
}

$term_id = $term->term_id;
$term_name = $term->name;

// Services page URL for breadcrumb
$services_page_url = home_url('/services/');
$services_pages = get_posts(array('post_type' => 'page', 'meta_key' => '_wp_page_template', 'meta_value' => 'page-template-services.php', 'numberposts' => 1, 'post_status' => 'publish'));
if (!empty($services_pages)) {
	$services_page_url = get_permalink($services_pages[0]->ID);
}

// ACF flexible content for this category term (order is automatically preserved from ACF admin)
$page_sections = get_field('page_sections', 'service_category_' . $term_id);
?>

<main id="primary" class="site-main">
	<?php
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
					'title' => !empty($section['title']) ? $section['title'] : $term_name,
				);
				get_template_part('template-parts/inner-banner', null, $inner_banner_data);
			endif;
		endforeach;
	endif;

	// Auto-generate breadcrumb (always show after banner, not from ACF)
	$breadcrumb_data = array(
		'breadcrumb_items' => array(
			array(
				'url' => esc_url(home_url('/')),
				'icon' => true
			),
			array(
				'title' => __('Services', 'tasheel'),
				'url' => $services_page_url
			),
			array(
				'title' => $term_name,
				'url' => '' // Empty URL makes it active
			)
		),
		'section_wrapper_class' => array(),
		'section_class' => ''
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

			// Image Text Block
			if ($layout === 'image_text_block' && (!empty($section['title']) || !empty($section['content']))) :
				$image = '';
				if (!empty($section['image'])) {
					$image = is_array($section['image']) 
						? $section['image']['url'] 
						: $section['image'];
				}
				$image_text_data = array(
					'image' => $image,
					'image_alt' => $term_name,
					'title' => isset($section['title']) ? $section['title'] : '',
					'title_span' => isset($section['title_span']) ? $section['title_span'] : '',
					'content' => isset($section['content']) ? $section['content'] : '',
					'button_text' => '',
					'button_link' => esc_url(home_url('')),
					'section_class' => 'pt_40IM', // Hardcoded as per Engineering Design template
					'bg_style' => '',
					'image_container_class' => '',
					'text_container_class' => ''
				);
				get_template_part('template-parts/image-text-block', null, $image_text_data);
			endif;

			// Engineering Expertise (with ACF options for service selection and empty state)
			if ($layout === 'engineering_expertise') :
				$services_source = !empty($section['services_source']) 
					? $section['services_source'] 
					: 'all';
				$empty_behavior = !empty($section['empty_behavior']) 
					? $section['empty_behavior'] 
					: 'hide';
				$empty_message = !empty($section['empty_message']) 
					? $section['empty_message'] 
					: __('No services available in this category yet.', 'tasheel');

				// Build query based on source selection
				$services_args = array(
					'post_type'      => 'service',
					'posts_per_page' => -1,
					'post_status'    => 'publish',
					'orderby'        => 'menu_order title',
					'order'          => 'ASC',
				);

				if ($services_source === 'custom' && !empty($section['services_custom'])) {
					// Custom selection - use specific service IDs
					$services_args['post__in'] = is_array($section['services_custom']) 
						? $section['services_custom'] 
						: array($section['services_custom']);
					$services_args['orderby'] = 'post__in';
				} else {
					// Show all - get services from this category
					$services_args['tax_query'] = array(array(
						'taxonomy' => 'service_category',
						'field'    => 'term_id',
						'terms'    => $term_id,
					));
				}

				$services_query = new WP_Query($services_args);

				$content_items = array();
				if ($services_query->have_posts()) {
					while ($services_query->have_posts()) {
						$services_query->the_post();
						$service_id = get_the_ID();
						$basic_info = get_field('basic_info', $service_id);
						if (!is_array($basic_info)) {
							$basic_info = array();
						}
						// Desktop: Featured Image (main) – key from group_main_service_details.json "name": "featured_image"
						$desktop_image_url = '';
						$fi = isset($basic_info['featured_image']) ? $basic_info['featured_image'] : null;
						if (!empty($fi)) {
							$desktop_image_url = is_array($fi) && !empty($fi['url']) ? $fi['url'] : (is_string($fi) ? $fi : '');
							if (!$desktop_image_url && is_numeric($fi)) {
								$desktop_image_url = wp_get_attachment_image_url($fi, 'full');
							}
						}
						if (!$desktop_image_url && has_post_thumbnail($service_id)) {
							$desktop_image_url = get_the_post_thumbnail_url($service_id, 'full');
						}
						// Mobile: Featured Image (mobile) – key "name": "featured_image_mobile" in same group
						$mobile_image_url = '';
						$fm = isset($basic_info['featured_image_mobile']) ? $basic_info['featured_image_mobile'] : null;
						if (!empty($fm)) {
							$mobile_image_url = is_array($fm) && !empty($fm['url']) ? $fm['url'] : (is_string($fm) ? $fm : '');
							if (!$mobile_image_url && is_numeric($fm)) {
								$mobile_image_url = wp_get_attachment_image_url($fm, 'full');
							}
						}
						// Fallback: some ACF/contexts store group subfield under different meta
						if (!$mobile_image_url && function_exists('get_field')) {
							$fm_alt = get_field('featured_image_mobile', $service_id);
							if (!empty($fm_alt)) {
								$mobile_image_url = is_array($fm_alt) && !empty($fm_alt['url']) ? $fm_alt['url'] : (is_numeric($fm_alt) ? wp_get_attachment_image_url($fm_alt, 'full') : (is_string($fm_alt) ? $fm_alt : ''));
							}
						}

						// Get listing description - check both basic_info group and direct field
						$description_text = '';
						if (!empty($basic_info['listing_description'])) {
							$description_text = wp_kses_post($basic_info['listing_description']);
						} else {
							// Fallback: try direct field access
							$direct_description = get_field('listing_description', $service_id);
							if (!empty($direct_description)) {
								$description_text = wp_kses_post($direct_description);
							} else {
								// Final fallback to excerpt
								$description_text = get_the_excerpt();
							}
						}

						$content_items[] = array(
							'label'        => get_the_title(),
							'image'        => $desktop_image_url,
							'image_mobile' => $mobile_image_url,
							'title'        => get_the_title(),
							'description'  => $description_text,
							'button_text'  => __('View more', 'tasheel'),
							'button_link'  => get_permalink($service_id),
						);
					}
					wp_reset_postdata();
				}

				// Handle empty state
				if (empty($content_items)) {
					if ($empty_behavior === 'hide') {
						// Don't render the section at all - skip it
					} else {
						// Show message - display a simple message section
						?>
						<section class="engineering_expertise_section pt_80 pb_80" style="background:url(<?php echo get_template_directory_uri(); ?>/assets/images/design-section-bg.png) #F5F9EE no-repeat 85% center; background-size: contain;">
							<div class="wrap">
								<?php if (!empty($section['title']) || !empty($section['title_span'])) : ?>
									<div class="engineering_expertise_header pb_40">
										<h3 class="h3_title_50">
											<?php if (!empty($section['title'])) : ?>
												<?php echo esc_html($section['title']); ?>
											<?php else : ?>
												Engineering
											<?php endif; ?>
											<?php if (!empty($section['title_span'])) : ?>
												<span><?php echo esc_html($section['title_span']); ?></span>
											<?php else : ?>
												<span>Expertise</span>
											<?php endif; ?>
										</h3>
									</div>
								<?php endif; ?>
								<div class="engineering_expertise_empty_message">
									<p><?php echo wp_kses_post($empty_message); ?></p>
								</div>
							</div>
						</section>
						<?php
					}
				} else {
					// Show services normally
					$engineering_expertise_data = array(
						'title'         => !empty($section['title']) 
							? $section['title'] 
							: 'Engineering',
						'title_span'    => !empty($section['title_span']) 
							? $section['title_span'] 
							: 'Expertise',
						'content_items' => $content_items,
					);
					get_template_part('template-parts/Engineering-Expertise', null, $engineering_expertise_data);
				}
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
					'title' => !empty($section['title']) ? $section['title'] : 'Need help choosing the',
					'subtitle' => !empty($section['subtitle']) ? $section['subtitle'] : 'right service?',
					'description' => !empty($section['description']) ? $section['description'] : 'Let\'s discuss how we can align our technology with your goals.',
					'button_text' => !empty($section['button_text']) ? $section['button_text'] : 'Get in Touch',
					'button_link' => !empty($section['button_link']) ? $section['button_link'] : '#',
				);
				get_template_part('template-parts/banner-add', null, $banner_add_data);
			endif;
		endforeach;
	else :
		// Fallback: banner + breadcrumb + term description
		$inner_banner_data = array(
			'background_image' => get_template_directory_uri() . '/assets/images/service-banner.jpg',
			'title'            => $term_name,
		);
		get_template_part('template-parts/inner-banner', null, $inner_banner_data);

		// Auto-generated breadcrumb
		$breadcrumb_data = array(
			'breadcrumb_items'       => array(
				array('url' => home_url('/'), 'icon' => true),
				array('title' => __('Services', 'tasheel'), 'url' => $services_page_url),
				array('title' => $term_name, 'url' => ''),
			),
			'section_wrapper_class' => array(),
			'section_class'        => '',
		);
		get_template_part('template-parts/Breadcrumb', null, $breadcrumb_data);

		if ($term->description) : ?>
			<section class="category_intro_section pt_40 pb_40">
				<div class="wrap">
					<div class="category_description"><?php echo wp_kses_post($term->description); ?></div>
				</div>
			</section>
		<?php endif;
	endif;
	?>
</main><!-- #main -->

<?php
get_footer();
