<?php
/**
 * Template Name: Corporate Training
 *
 * The template for displaying the Corporate Training page
 *
 * @package tasheel
 */

get_header();
?>

<main id="primary" class="site-main">
	<?php 
	$inner_banner_data = array(
		'background_image' => get_template_directory_uri() . '/assets/images/corporate-banner.jpg',
		'title' => 'Corporate Training',
	);
	get_template_part( 'template-parts/inner-banner', null, $inner_banner_data ); 
	?>

	<?php 
	$page_tabs_data = array(
		'tabs' => array(
			array( 'id' => 'careers', 'title' => 'Careers', 'link' => esc_url( home_url( '/careers-page' ) ) ),
			array( 'id' => 'corporate-training', 'title' => 'Corporate Training', 'link' => esc_url( home_url( '/corporate-training' ) ) ),
			array( 'id' => 'academic-program', 'title' => 'Academic Program', 'link' => esc_url( home_url( '/academic-program' ) ) ),
		),
		'active_tab' => 'corporate-training' // Set which tab should be active
	);
	get_template_part( 'template-parts/page-tabs', null, $page_tabs_data ); 
	?>
	
	<?php 
	$image_text_data = array(
		'image' => get_template_directory_uri() . '/assets/images/corporate-img.jpg',
		'image_alt' => 'Corporate Training',
		'title' => 'Shape the Future of<br>',
		'title_span' => 'Engineering in Saudi Arabia',
		'content' => '<p>At Saud Consult, you don\'t just take a job; you join a 50-year legacy of engineering excellence. We recognize that our over 2,000 professionals are our greatest asset, and we offer dynamic opportunities to work on the Kingdom\'s most ambitious and defining projects. We are dedicated to the development of local talent, providing the foundation for a challenging, rewarding, and deeply impactful career where your technical skills will directly contribute to the nation\'s growth.</p>',
		// 'button_text' => 'Corporate Trainings',
		// 'button_link' => esc_url( home_url( '/' ) ),
		'section_class' => 'pb_0',
		// 'bg_style' => 'bg-style',
		'image_container_class' => '',
		'text_container_class' => ''
	);
	get_template_part( 'template-parts/image-text-block', null, $image_text_data ); 
	?>

	 
<?php 
	$latest_openings_data = array(
		'title' => 'Training ',
		'title_span' => 'opportunities',
		'openings' => array(
			array(
				'title' => 'Chief Financial Officer',
				'posted_date' => 'Posted 18 Hours Ago',
				'location' => 'Riyadh, Saudi Arabia',
				'job_id' => 'ID: 54294',
				'details_link' => esc_url( home_url( '/Job-details-training' ) )
			),
			array(
				'title' => 'Senior Civil Engineer',
				'posted_date' => 'Posted 1 Day Ago',
				'location' => 'Jeddah, Saudi Arabia',
				'job_id' => 'ID: 54295',
				'details_link' => esc_url( home_url( '/Job-details-training' ) )
			) 
		),
		'show_load_more' => true
	);
	get_template_part( 'template-parts/Latest-Openings', null, $latest_openings_data ); 
	?>
</main><!-- #main -->

<?php
get_footer();

