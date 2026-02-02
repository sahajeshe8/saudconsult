<?php
/**
 * Template Name: Project Details
 *
 * The template for displaying the Project Details page
 *
 * @package tasheel
 */

get_header();
?>

<main id="primary" class="site-main">
	<?php 
	// Project title - can be extracted from post/page title or set here
	$project_title = 'King Abdullah Road – Phase 2';
	
	$inner_banner_data = array(
		'background_image' => get_template_directory_uri() . '/assets/images/project-detail-banner.jpg',
		'title' => $project_title,
		'section_class' => 'banner-type-02'
	);
	get_template_part( 'template-parts/inner-banner', null, $inner_banner_data ); 
	?>

	<?php 
	$breadcrumb_data = array(
		'breadcrumb_items' => array(
			array(
				'url' => esc_url( home_url( '/' ) ),
				'icon' => true
			),
			array(
				'title' => 'Projects',
				'url' => esc_url( home_url( '/projects' ) )
			),
			array(
				'title' => $project_title,
				'url' => '' // Empty URL makes it active
			)
		),
		'section_wrapper_class' => array(),
		'section_class' => ''
	);
	get_template_part( 'template-parts/Breadcrumb', null, $breadcrumb_data ); 
	?>

	<?php 
	$project_info_data = array(
		'description' => 'Detailed design of King Abdullah Road as <strong>Freeway including Underpasses and Bridges</strong>, Infrastructure of whole <strong>King Abdullah corridor consists of Roads, Underpasses, Water, Wastewater, Storm Drainage, Power, Telecom, Irrigation, Comprehensive soft and hard-scaping.</strong> This project is the land mark in the urban context of Riyadh city as it carries the Light Rail also in the median.',
		'section_wrapper_class' => array(),
		'section_class' => '',
		'info_items' => array(
			array(
				'label' => 'Client',
				'value' => 'Riyadh Development<br>Authority'
			),
			array(
				'label' => 'Sectors',
				'value' => 'Infrastructure'
			),
			array(
				'label' => 'Locations',
				'value' => 'Riyadh, Saudia<br>Arabia'
			),
			array(
				'label' => 'Cost',
				'value' => '(SAR) 1,000,000,000'
			),
			array(
				'label' => 'Length of Road',
				'value' => '20KM'
			)
		)
	);
	get_template_part( 'template-parts/Project-Info-Block', null, $project_info_data ); 
	?>

	<?php 
	$design_scope_data = array(
		'title' => 'Comprehensive, <br>Multi-Disciplinary',
		'title_span' => 'Design Scope.',
		'image' => get_template_directory_uri() . '/assets/images/project-video.jpg',
		'image_alt' => 'Design Scope',
		'show_play_button' => true,
		'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ', // Add your video URL here
		'section_wrapper_class' => array(),
		'section_class' => '',
		'scope_items' => array(
			array(
				'icon' => get_template_directory_uri() . '/assets/images/scop-ic-01.svg',
				'icon_alt' => 'Transportation Engineering',
				'title' => 'Transportation',
				'title_span' => 'Engineering',
				'description' => 'Ut sit integer fringilla amet quam odio turpis interdum nisi massa est facilisi ultrices mauris eget mi.'
			),
			array(
				'icon' => get_template_directory_uri() . '/assets/images/scop-ic-02.svg',
				'icon_alt' => 'Infrastructure Design',
				'title' => 'Infrastructure',
				'title_span' => 'Design',
				'description' => 'Et imperdiet vitae diam ac eget non velit turpis viverra justo dol integer feugiat viverra tellus.'
			),
			array(
				'icon' => get_template_directory_uri() . '/assets/images/scop-ic-03.svg',
				'icon_alt' => 'Structural Engineering',
				'title' => 'Structural',
				'title_span' => 'Engineering',
				'description' => 'Design of all underpasses and bridges to ensure structural integrity and seismic resilience.'
			),
			array(
				'icon' => get_template_directory_uri() . '/assets/images/scop-ic-04.svg',
				'icon_alt' => 'Deliverable',
				'title' => 'Deliverable',
				'title_span' => '',
				'description' => 'Preparation of all detailed engineering drawings and tender specifications.'
			)
		)
	);
	get_template_part( 'template-parts/Design-Scope', null, $design_scope_data ); 
	?>

	<?php 
	$project_gallery_data = array(
		'title' => 'Gallery',
		'section_wrapper_class' => array(),
		'section_class' => '',
		'gallery_items' => array(
			array(
				'image' => get_template_directory_uri() . '/assets/images/pro-01.jpg',
				'image_alt' => 'Highway at night with traffic lights',
				'is_video' => false,
				'video_url' => ''
			),
			array(
				'image' => get_template_directory_uri() . '/assets/images/pro-02.jpg',
				'image_alt' => 'Highway with landscaped median',
				'is_video' => false,
				'video_url' => ''
			),
			array(
				'image' => get_template_directory_uri() . '/assets/images/project-video.jpg',
				'image_alt' => 'Highway at night',
				'is_video' => true,
				'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ'
			),
			array(
				'image' => get_template_directory_uri() . '/assets/images/pro-04.jpg',
				'image_alt' => 'Tunnel interior',
				'is_video' => false,
				'video_url' => ''
			)
            ,
			array(
				'image' => get_template_directory_uri() . '/assets/images/pro-04.jpg',
				'image_alt' => 'Tunnel interior',
				'is_video' => false,
				'video_url' => ''
			)
            ,
			array(
				'image' => get_template_directory_uri() . '/assets/images/pro-04.jpg',
				'image_alt' => 'Tunnel interior',
				'is_video' => false,
				'video_url' => ''
			)
		)
	);
	get_template_part( 'template-parts/Project-Gallery', null, $project_gallery_data ); 
	?>

<?php 
		$banner_add_data = array(
			'background_image' => get_template_directory_uri() . '/assets/images/design-bg-img.jpg',
			'title' => 'Need help choosing the',
			'subtitle' => 'right service?',
			'description' => 'Let’s discuss how we can align our technology with your goals.',
			'button_text' => 'Get in Touch',
			'button_link' => '/contact-us'
		);
		get_template_part( 'template-parts/banner-add', null, $banner_add_data ); 
		?>

</main><!-- #main -->

<?php
get_footer();

