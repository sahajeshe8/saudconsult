<?php
/**
 * Template Name: Engineering Design
 *
 * The template for displaying the Engineering Design service page
 *
 * @package tasheel
 */

get_header();
?>

<main id="primary" class="site-main">
	<?php 
	$inner_banner_data = array(
		'background_image' => get_template_directory_uri() . '/assets/images/engineering-design-banner.jpg',
		'title' => 'Engineering Design',
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
				'title' => 'Services',
				'url' => esc_url( home_url( '/services' ) )
			),
			array(
				'title' => 'Engineering Design',
				'url' => '' // Empty URL makes it active
			)
		),
		'section_wrapper_class' => array(),
		'section_class' => ''
	);
	get_template_part( 'template-parts/Breadcrumb', null, $breadcrumb_data ); 
	?>

	<?php 
	$image_text_data = array(
		'image' => get_template_directory_uri() . '/assets/images/design-precision-img.jpg',
		'image_alt' => 'Careers',
		'title' => 'Design Precision. <br>',
		'title_span' => 'The Blueprint for National Development',
		'content' => '<p>Engineering Design is the cornerstone of project success. We transform ambitious visions into detailed, optimized, and buildable plans. Our multidisciplinary team ensures every element—architectural, structural, mechanical, electrical, and utility—is integrated flawlessly, adhering to local regulations and international standards.</p> <p>Master Planning & Conceptual Design, Detailed Technical Drawings (2D/3D/BIM), Structural Analysis & Calculations, Specifications & Material Schedules, Value Engineering Reports, Tender Documentation Packages.</p>',
		'button_text' => '',
		'button_link' => esc_url( home_url( '' ) ),
	 
        'section_class' => 'pt_40IM', //row_reverse  Multiple classes separated by space
		'bg_style' => '', // Background style class
		'image_container_class' => '',
		'text_container_class' => ''
	);

 

	get_template_part( 'template-parts/image-text-block', null, $image_text_data ); 
	?>

	<?php 
	$engineering_expertise_data = array(
		'title' => 'Our Engineering',
		'title_span' => 'Expertise',
 		 
	);
	get_template_part( 'template-parts/Engineering-Expertise', null, $engineering_expertise_data ); 
	?>







<?php 
		$banner_add_data = array(
			'background_image' => get_template_directory_uri() . '/assets/images/design-bg-img.jpg',
			'title' => 'Need help choosing the',
			'subtitle' => 'right service?',
			'description' => 'Let’s discuss how we can align our technology with your goals.',
			'button_text' => 'Get in Touch',
			'button_link' => '#'
		);
		get_template_part( 'template-parts/banner-add', null, $banner_add_data ); 
		?>

</main><!-- #main -->

<?php
get_footer();

