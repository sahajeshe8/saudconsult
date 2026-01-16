<?php
/**
 * Template Name: Our Journey & Legacy
 *
 * The template for displaying the Our Journey & Legacy page
 *
 * @package tasheel
 */

get_header();
?>

<main id="primary" class="site-main">
	<?php 
	$inner_banner_data = array(
		'background_image' => get_template_directory_uri() . '/assets/images/journy-banner.jpg',
		'title' => 'Our Journey & Legacy',
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
		'active_tab' => 'journey' // Set which tab should be active
	);
	get_template_part( 'template-parts/page-tabs', null, $page_tabs_data ); 
	?>

	<?php 
	$image_text_data = array(
		'image' => get_template_directory_uri() . '/assets/images/journy-img.jpg',
		'image_alt' => 'Our Journey & Legacy',
		'title' => 'Our Journey & <br>',
		'title_span' => 'Legacy',
		'content' => '<p>Our legacy of excellence is built on a foundation of trust, innovation, and technical precision. Our integrated structure ensures we secure all project requirements single-handedly, minimizing risk and maximizing efficiency across the entire project lifecycle. We manage complexity, deliver quality, and build for the long term.</p>',
		'section_class' => '',
		// 'bg_style' => 'bg-style',
		'image_container_class' => '',
		'text_container_class' => ''
	);
	get_template_part( 'template-parts/image-text-block', null, $image_text_data ); 
	?>

<?php get_template_part( 'template-parts/Our-Journey', null, $image_text_data ); ?>


 
</main><!-- #main -->

<?php
get_footer();

