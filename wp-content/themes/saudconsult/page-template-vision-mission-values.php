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
			array( 'id' => 'overview', 'title' => 'Who We Are' ),
			array( 'id' => 'history', 'title' => 'Our Team' ),
			array( 'id' => 'mission', 'title' => 'Leadership' ),
			array( 'id' => 'journey', 'title' => 'Our Journey & Legacy' ),
			array( 'id' => 'vision', 'title' => 'Vision, Mission & Values' ),
			array( 'id' => 'milestones', 'title' => 'Company Milestones' ),
			array( 'id' => 'awards', 'title' => 'Awards' )
		),
		'active_tab' => 'vision' // Set which tab should be active
	);
	get_template_part( 'template-parts/page-tabs', null, $page_tabs_data ); 
	?>

	<?php 
	$mission_vision_data = array(
		'vision_title' => 'Our Vision',
		'vision_title_span' => 'To Pioneer the Future.',
		'vision_content' => '<p> To be the leading engineering consultancy firm that enables the realization of Saudi Arabia’s national development vision through enduring, innovative, and sustainable solutions that set global benchmarks for quality and resilience.</p>',
		'vision_icon' => get_template_directory_uri() . '/assets/images/vision-icn.svg',
		'mission_title' => 'Our Mission',
		'mission_title_span' => 'Delivering Comprehensive Success.',
		'mission_content' => '<p>To deliver comprehensive, high-quality engineering and architectural services that seamlessly integrate modern technical know-how with deep local sensitivity, ensuring client success across the full project lifecycle and maximizing positive national impact.</p>',
		'mission_icon' => get_template_directory_uri() . '/assets/images/mission-icn.svg',
		'section_class' => 'bg_02'
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
				'icon' => get_template_directory_uri() . '/assets/images/values-icn-01.svg',
				'title' => 'Integrity and Professionalism.',
				'title_span' => 'Pioneering Excellence',
				'text' => 'Upholding the highest ethical standards, transparency, and fiduciary responsibility in every engagement. Trust is the foundation of our five-decade legacy.',
			),
			array(
				'icon' => get_template_directory_uri() . '/assets/images/values-icn-02.svg',
				'title' => 'Technical',
				'title_span' => 'Excellence.',
				'text' => 'Driving continuous innovation and leveraging vast experience to solve the most complex technical challenges. We are committed to optimal, cost-effective, and technologically advanced design solutions.',
			),
			array(
				'icon' => get_template_directory_uri() . '/assets/images/values-icn-03.svg',
				'title' => 'Partnership and',
				'title_span' => 'Collaboration.',
				'text' => 'Working as a genuine partner to our clients, stakeholders, and international affiliates, ensuring clear communication and a unified vision from project inception to final handover.',
			),
			array(
				'icon' => get_template_directory_uri() . '/assets/images/values-icn-04.svg',
				'title' => 'Quality &',
				'title_span' => 'Sustainability.',
				'text' => 'An uncompromising commitment to quality, safety, and sustainable practices, ensuring that all our designs are resilient, environmentally responsible, and contribute positively to future generations.',
			),
		),
	);
	get_template_part( 'template-parts/Core-Values', null, $core_values_data ); 
	?>


</main><!-- #main -->

<?php
get_footer();

