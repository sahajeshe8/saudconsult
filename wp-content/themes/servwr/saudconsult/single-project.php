<?php
/**
 * The template for displaying single project posts
 *
 * @package tasheel
 */

get_header();

while (have_posts()) :
	the_post();
	$project_id = get_the_ID();
	
	// Breadcrumb data (output after first banner so order is: Banner → Breadcrumb → content)
	$projects_page_url = get_post_type_archive_link('project');
	if (!$projects_page_url) {
		$projects_page = get_posts(array('post_type' => 'page', 'meta_key' => '_wp_page_template', 'meta_value' => 'page-template-projects.php', 'numberposts' => 1));
		$projects_page_url = !empty($projects_page) ? get_permalink($projects_page[0]) : home_url('/');
	}
	$breadcrumb_data = array(
		'breadcrumb_items' => array(
			array('url' => esc_url(home_url('/')), 'icon' => true, 'title' => __('Home', 'tasheel')),
			array('title' => __('Projects', 'tasheel'), 'url' => esc_url($projects_page_url)),
			array('title' => get_the_title(), 'url' => '')
		),
		'section_wrapper_class' => array(),
		'section_class' => ''
	);
	
	// Get ACF Flexible Content
	$page_sections = get_field('page_sections');
	$breadcrumb_shown = false;
	$has_inner_banner = false;
	if (is_array($page_sections)) {
		foreach ($page_sections as $s) {
			if (isset($s['acf_fc_layout']) && $s['acf_fc_layout'] === 'inner_banner') {
				$has_inner_banner = true;
				break;
			}
		}
	}
	// If no Inner Banner block, show breadcrumb at top so it still appears
	if (!$has_inner_banner) {
		get_template_part('template-parts/Breadcrumb', null, $breadcrumb_data);
		$breadcrumb_shown = true;
	}
	
	if ($page_sections) :
		foreach ($page_sections as $section) :
			$layout = $section['acf_fc_layout'];
			
			// Inner Banner (desktop + mobile from flexible content block)
			if ($layout === 'inner_banner') :
				$banner_desktop = '';
				if (!empty($section['background_image'])) {
					$banner_desktop = is_array($section['background_image']) ? (isset($section['background_image']['url']) ? $section['background_image']['url'] : '') : $section['background_image'];
				}
				if (!$banner_desktop && has_post_thumbnail($project_id)) {
					$banner_desktop = get_the_post_thumbnail_url($project_id, 'full');
				}
				if (!$banner_desktop) {
					$banner_desktop = get_template_directory_uri() . '/assets/images/project-detail-banner.jpg';
				}
				$banner_mobile = '';
				if (!empty($section['background_image_mobile'])) {
					$banner_mobile = is_array($section['background_image_mobile']) ? (isset($section['background_image_mobile']['url']) ? $section['background_image_mobile']['url'] : '') : $section['background_image_mobile'];
				}
				$inner_banner_data = array(
					'background_image' => $banner_desktop,
					'background_image_mobile' => $banner_mobile,
					'title' => !empty($section['title']) ? apply_filters('wpml_translate_single_string', $section['title'], 'ACF', 'inner_banner_title_' . $project_id) : get_the_title(),
					'section_class' => 'banner-type-02'
				);
				get_template_part('template-parts/inner-banner', null, $inner_banner_data);
				// Breadcrumb right after banner (once)
				if (!$breadcrumb_shown) {
					get_template_part('template-parts/Breadcrumb', null, $breadcrumb_data);
					$breadcrumb_shown = true;
				}
			endif;
			
			// Project Info Block – from basic_info_items repeater
			if ($layout === 'project_info_block') :
				$info_items = function_exists('tasheel_get_project_info_items') ? tasheel_get_project_info_items($project_id) : array();
				
				$project_info_data = array(
					'description' => !empty($section['description']) ? apply_filters('wpml_translate_single_string', $section['description'], 'ACF', 'project_info_description_' . $project_id) : get_the_content(),
					'section_wrapper_class' => array(),
					'section_class' => '',
					'info_items' => $info_items
				);
				get_template_part('template-parts/Project-Info-Block', null, $project_info_data);
			endif;
			
			// Design Scope
			if ($layout === 'design_scope' && (!empty($section['title']) || !empty($section['scope_items']))) :
				$scope_image = '';
				if (!empty($section['image'])) {
					$scope_image = is_array($section['image']) ? $section['image']['url'] : $section['image'];
				}
				
				$scope_items = array();
				if (!empty($section['scope_items'])) {
					foreach ($section['scope_items'] as $item) {
						$scope_items[] = array(
							'icon' => !empty($item['icon']) ? $item['icon'] : '',
							'icon_alt' => !empty($item['title']) ? $item['title'] : '',
							'title' => !empty($item['title']) ? apply_filters('wpml_translate_single_string', $item['title'], 'ACF', 'scope_item_title_' . $project_id) : '',
							'title_span' => !empty($item['title_span']) ? apply_filters('wpml_translate_single_string', $item['title_span'], 'ACF', 'scope_item_title_span_' . $project_id) : '',
							'description' => !empty($item['description']) ? apply_filters('wpml_translate_single_string', $item['description'], 'ACF', 'scope_item_description_' . $project_id) : ''
						);
					}
				}
				
				$design_scope_data = array(
					'title' => !empty($section['title']) ? apply_filters('wpml_translate_single_string', $section['title'], 'ACF', 'design_scope_title_' . $project_id) : '',
					'title_span' => !empty($section['title_span']) ? apply_filters('wpml_translate_single_string', $section['title_span'], 'ACF', 'design_scope_title_span_' . $project_id) : '',
					'image' => $scope_image,
					'image_alt' => get_the_title(),
					'show_play_button' => !empty($section['show_play_button']) ? $section['show_play_button'] : false,
					'video_url' => !empty($section['video_url']) ? $section['video_url'] : '',
					'section_wrapper_class' => array(),
					'section_class' => '',
					'scope_items' => $scope_items
				);
				get_template_part('template-parts/Design-Scope', null, $design_scope_data);
			endif;
			
			// Project Gallery
			if ($layout === 'project_gallery' && !empty($section['gallery_items'])) :
				$gallery_items = array();
				foreach ($section['gallery_items'] as $item) {
					$gallery_image = '';
					if (!empty($item['image'])) {
						$gallery_image = is_array($item['image']) ? $item['image']['url'] : $item['image'];
					}
					
					$gallery_items[] = array(
						'image' => $gallery_image,
						'image_alt' => !empty($item['image']['alt']) ? $item['image']['alt'] : get_the_title(),
						'is_video' => !empty($item['is_video']) ? $item['is_video'] : false,
						'video_url' => !empty($item['video_url']) ? $item['video_url'] : ''
					);
				}
				
				$project_gallery_data = array(
					'title' => !empty($section['title']) ? apply_filters('wpml_translate_single_string', $section['title'], 'ACF', 'gallery_title_' . $project_id) : __('Gallery', 'tasheel'),
					'section_wrapper_class' => array(),
					'section_class' => '',
					'gallery_items' => $gallery_items
				);
				get_template_part('template-parts/Project-Gallery', null, $project_gallery_data);
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
					'title' => !empty($section['title']) ? apply_filters('wpml_translate_single_string', $section['title'], 'ACF', 'banner_add_title_' . $project_id) : '',
					'subtitle' => !empty($section['subtitle']) ? apply_filters('wpml_translate_single_string', $section['subtitle'], 'ACF', 'banner_add_subtitle_' . $project_id) : '',
					'description' => !empty($section['description']) ? apply_filters('wpml_translate_single_string', $section['description'], 'ACF', 'banner_add_description_' . $project_id) : '',
					'button_text' => !empty($section['button_text']) ? apply_filters('wpml_translate_single_string', $section['button_text'], 'ACF', 'banner_add_button_text_' . $project_id) : '',
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
