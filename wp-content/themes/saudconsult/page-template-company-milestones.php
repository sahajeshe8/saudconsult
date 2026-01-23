<?php
/**
 * Template Name: Company Milestones
 *
 * The template for displaying the Company Milestones page
 *
 * @package tasheel
 */

get_header();
?>

<main id="primary" class="site-main">
	<?php 
	$inner_banner_data = array(
		'background_image' => get_template_directory_uri() . '/assets/images/company-milestones-banner.jpg',
		'title' => 'Company Milestones',
	);
	get_template_part( 'template-parts/inner-banner', null, $inner_banner_data ); 
	?>

	<?php 
	$page_tabs_data = array(
		'tabs' => array(
			array( 'id' => 'overview', 'title' => 'Who We Are', 'link' => esc_url( home_url( '/about' ) ) ),
			array( 'id' => 'vision', 'title' => 'Vision, Mission & Values', 'link' => esc_url( home_url( '/vision-mission-values' ) ) ),
			array( 'id' => 'mission', 'title' => 'Leadership', 'link' => esc_url( home_url( '/leadership' ) ) ),
			array( 'id' => 'Our Team', 'title' => 'Our Team', 'link' => esc_url( home_url( '/our-team' ) ) ),
			array( 'id' => 'journey', 'title' => 'Our Journey & Legacy', 'link' => esc_url( home_url( '/our-journey-legacy' ) ) ),
			array( 'id' => 'milestones', 'title' => 'Company Milestones', 'link' => esc_url( home_url( '/company-milestones' ) ) ),
			array( 'id' => 'Awards & Certifications', 'title' => 'Awards & Certifications', 'link' => esc_url( home_url( '/awards' ) ) )
		),
		'active_tab' => 'milestones' // Set which tab should be active
	);
	get_template_part( 'template-parts/page-tabs', null, $page_tabs_data ); 
	?>

 




<?php 
	$image_text_data = array(
		'image' => get_template_directory_uri() . '/assets/images/journey-img.jpg',
		'image_alt' => 'Our Journey & Legacy',
		'title' => 'Five Decades of Defining <br>',
		'title_span' => 'the Kingdom\'s Landscape.',
		'content' => '<p>A timeline of the pivotal moments, major achievements, and strategic expansions that mark our journey as the first Saudi Engineering Consulting Firm.</p>',
		'button_text' => 'Download Company Profile',
		'button_link' => esc_url( home_url( '/' ) ),
		'section_class' => '',
		// 'bg_style' => 'bg-style',
		'image_container_class' => '',
		'text_container_class' => ''
	);
	get_template_part( 'template-parts/image-text-block', null, $image_text_data ); 
	?>

<?php 
get_template_part( 'template-parts/Timeline', null, $image_text_data );
	?>
</main><!-- #main -->

<?php
get_footer();

