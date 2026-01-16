<?php
/**
 * Template Name: About Us
 *
 * The template for displaying the About Us page
 *
 * @package tasheel
 */

get_header();
?>

<main id="primary" class="site-main">
	<?php 
	$inner_banner_data = array(
		'background_image' => get_template_directory_uri() . '/assets/images/about-banner.jpg',
		'title' => 'Who We Are',
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
		'active_tab' => 'overview' // Set which tab should be active
	);
	get_template_part( 'template-parts/page-tabs', null, $page_tabs_data ); 
	?>
	
	<?php 
	$image_text_data = array(
		'image' => get_template_directory_uri() . '/assets/images/about-img.jpg',
		'image_alt' => 'About Us',
		'title' => 'Pioneering Engineering',
		'title_span' => 'Excellence Since 1965.',
		'section_class' => 'about-page-section custom-class another-class third-class', // Multiple classes separated by space
		 
		'image_container_class' => 'about-image-container',
		'text_container_class' => 'about-text-container'
	);
	get_template_part( 'template-parts/image-text-block', null, $image_text_data ); 
	?>





<?php 
	$image_text_data = array(
		'image' => get_template_directory_uri() . '/assets/images/about-img-02.jpg',
		'image_alt' => 'About Us',
		'title' => 'A foundational pillar of modern',
		'title_span' => 'Saudi development',
		'content' => '<p>Saud Consult is not merely an engineering firm; we are a foundational pillar of modern Saudi development. As one of the Kingdom\'s oldest and largest privately owned multidisciplinary consultancies, we offer comprehensive services from feasibility studies and design to construction supervision and project management.</p>',
		'button_text' => 'Download Company Profile',
		'button_link' => esc_url( home_url( '/' ) ),
		'section_class' => 'row_reverse', // Multiple classes separated by space
		'bg_style' => 'bg-style', // Background style class
		'image_container_class' => 'about-image-container',
		'text_container_class' => 'about-text-container'
	);
	get_template_part( 'template-parts/image-text-block', null, $image_text_data ); 
	?>

 





	 

</main><!-- #main -->

<?php
get_footer();

