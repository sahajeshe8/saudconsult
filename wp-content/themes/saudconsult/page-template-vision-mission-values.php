<?php
/**
 * Template Name: Vision, Mission & Values
 *
 * The template for displaying the Vision, Mission & Values page
 *
 * @package tasheel
 */

get_header();
?>

<main id="primary" class="site-main">
	<?php 
	$inner_banner_data = array(
		'background_image' => get_template_directory_uri() . '/assets/images/vision-banner.jpg',
		'title' => 'Vision, Mission & Values',
	);
	get_template_part( 'template-parts/inner-banner', null, $inner_banner_data ); 
	?>

	<?php 
	$page_tabs_data = array(
		'tabs' => array(
			array( 'id' => 'overview', 'title' => 'Who We Are', 'link' => esc_url( home_url( '/about' ) ) ),
			array( 'id' => 'vision', 'title' => 'Vision, Mission & Values', 'link' => esc_url( home_url( '/vision-mission-values' ) ) ),
			array( 'id' => 'mission', 'title' => 'Leadership', 'link' => esc_url( home_url( '/leadership' ) ) ),
			array( 'id' => 'history', 'title' => 'Our Team', 'link' => esc_url( home_url( '/our-team' ) ) ),
			array( 'id' => 'journey', 'title' => 'Our Journey & Legacy', 'link' => esc_url( home_url( '/our-journey-legacy' ) ) ),
			array( 'id' => 'milestones', 'title' => 'Company Milestones', 'link' => esc_url( home_url( '/company-milestones' ) ) ),
			array( 'id' => 'Awards & Certifications', 'title' => 'Awards & Certifications', 'link' => esc_url( home_url( '/awards' ) ) )
		),
		'active_tab' => 'vision' // Set which tab should be active
	);
	get_template_part( 'template-parts/page-tabs', null, $page_tabs_data ); 
	?>

	<?php 
	$mission_vision_data = array(
		'vision_title' => 'Our Vision:',
		'vision_title_span' => 'To Pioneer the Future.',
		'vision_content' => '<p> To be the leading engineering consultancy firm that enables the realization of Saudi Arabia\'s national development vision through enduring, innovative, and sustainable solutions that set global benchmarks for quality and resilience.</p>',
		'vision_icon' => get_template_directory_uri() . '/assets/images/vision-icn.svg',
		'vision_icon_hover' => get_template_directory_uri() . '/assets/images/vision-icn-h.svg',
		'mission_title' => 'Our Mission:',
		'mission_title_span' => 'Delivering Comprehensive Success.',
		'mission_content' => '<p>To deliver comprehensive, high-quality engineering and architectural services that seamlessly integrate modern technical know-how with deep local sensitivity, ensuring client success across the full project lifecycle and maximizing positive national impact.</p>',
		'mission_icon' => get_template_directory_uri() . '/assets/images/mission-icn.svg',
		'mission_icon_hover' => get_template_directory_uri() . '/assets/images/mission-icn-h.svg',
		'section_class' => 'bg_color_01'
	);
	get_template_part( 'template-parts/Mission-Vision', null, $mission_vision_data ); 
	?>



	<?php 
	$core_values_data = array(
		'title' => 'Core ',
		'title_span' => 'Values',
		'description' => 'Our history is inextricably linked to the national development story of Saudi Arabia. We have consistently met the moment, adapting our expertise to the growing scale and complexity of the Kingdom\'s infrastructure needs.',
		'values' => array(
			array(
				'icon' => get_template_directory_uri() . '/assets/images/cor-icn-1.svg',
				'icon_hover' => get_template_directory_uri() . '/assets/images/cor-icn-1-h.svg',
				'title' => 'Integrity and Professionalism. Pioneering Excellence',
				'title_span' => '',
				'text' => 'Upholding the highest ethical standards, transparency, and fiduciary responsibility in every engagement. Trust is the foundation of our five-decade legacy.',
			),
			array(
				'icon' => get_template_directory_uri() . '/assets/images/cor-icn-2.svg',
				'icon_hover' => get_template_directory_uri() . '/assets/images/cor-icn-2-h.svg',
				'title' => 'Technical Excellence.',
				'title_span' => '',
				'text' => 'Driving continuous innovation and leveraging vast experience to solve the most complex technical challenges. We are committed to optimal, cost-effective, and technologically advanced design solutions.',
			),
			array(
				'icon' => get_template_directory_uri() . '/assets/images/cor-icn-3.svg',
				'icon_hover' => get_template_directory_uri() . '/assets/images/cor-icn-3-h.svg',
				'title' => 'Partnership and Collaboration.',
				'title_span' => '',
				'text' => 'Working as a genuine partner to our clients, stakeholders, and international affiliates, ensuring clear communication and a unified vision from project inception to final handover.',
			),
			array(
				'icon' => get_template_directory_uri() . '/assets/images/cor-icn-4.svg',
				'icon_hover' => get_template_directory_uri() . '/assets/images/cor-icn-4-h.svg',
				'title' => 'Quality & Sustainability.',
				'title_span' => '',
				'text' => 'An uncompromising commitment to quality, safety, and sustainable practices, ensuring that all our designs are resilient, environmentally responsible, and contribute positively to future generations.',
			),
		),
	);
	get_template_part( 'template-parts/Core-Values', null, $core_values_data ); 
	?>


</main><!-- #main -->

<?php
get_footer();

