<?php
/**
 * Template Name: Careers Page
 *
 * The template for displaying the Careers Page
 *
 * @package tasheel
 */

get_header();
?>

<main id="primary" class="site-main">
	<?php 
	$inner_banner_data = array(
		'background_image' => get_template_directory_uri() . '/assets/images/careers-banner.jpg',
		'title' => 'Careers',
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
		'active_tab' => 'careers' // Set which tab should be active
	);
	get_template_part( 'template-parts/page-tabs', null, $page_tabs_data ); 
	?>
	
	<?php 
	$image_text_data = array(
		'image' => get_template_directory_uri() . '/assets/images/careers-img-04.jpg',
		'image_alt' => 'Careers',
		'title' => 'Build What\'s Next<br>',
		'title_span' => 'With Us',
		'content' => '<p>At Saud Consult, you don\'t just take a job; you join a 50-year legacy of engineering excellence. We recognize that our over 2,000 professionals are our greatest asset, and we offer dynamic opportunities to work on the Kingdom\'s most ambitious and defining projects.</p><p>We are dedicated to the development of local talent, providing the foundation for a challenging, rewarding, and deeply impactful career where your technical skills will directly contribute to the nation\'s growth.</p>',
		// 'button_text' => 'Visit Careers',
		// 'button_link' => esc_url( home_url( '/' ) ),
		'section_class' => '',
		'image_container_class' => '',
		'text_container_class' => ''
	);
	get_template_part( 'template-parts/image-text-block', null, $image_text_data ); 
	?>

	<?php get_template_part( 'template-parts/Why-Build-Career' ); ?>

	<?php 
	$latest_openings_data = array(
		'title' => 'Latest',
		'title_span' => 'Openings',
		'openings' => array(
			array(
				'title' => 'Chief Financial Officer',
				'posted_date' => 'Posted 18 Hours Ago',
				'location' => 'Riyadh, Saudi Arabia',
				'job_id' => 'ID: 54294',
				'details_link' => esc_url( home_url( '/job-details' ) )
			),
			array(
				'title' => 'Senior Civil Engineer',
				'posted_date' => 'Posted 1 Day Ago',
				'location' => 'Jeddah, Saudi Arabia',
				'job_id' => 'ID: 54295',
				'details_link' => esc_url( home_url( '/job-details' ) )
			),
			array(
				'title' => 'Project Manager',
				'posted_date' => 'Posted 2 Days Ago',
				'location' => 'Riyadh, Saudi Arabia',
				'job_id' => 'ID: 54296',
				'details_link' => esc_url( home_url( '/job-details' ) )
			),
			array(
				'title' => 'Structural Engineer',
				'posted_date' => 'Posted 3 Days Ago',
				'location' => 'Dammam, Saudi Arabia',
				'job_id' => 'ID: 54297',
				'details_link' => esc_url( home_url( '/job-details' ) )
			),
			array(
				'title' => 'Electrical Engineer',
				'posted_date' => 'Posted 4 Days Ago',
				'location' => 'Riyadh, Saudi Arabia',
				'job_id' => 'ID: 54298',
				'details_link' => esc_url( home_url( '/job-details' ) )
			),
			array(
				'title' => 'Mechanical Engineer',
				'posted_date' => 'Posted 5 Days Ago',
				'location' => 'Jeddah, Saudi Arabia',
				'job_id' => 'ID: 54299',
				'details_link' => esc_url( home_url( '/job-details' ) )
			),
			array(
				'title' => 'Architect',
				'posted_date' => 'Posted 6 Days Ago',
				'location' => 'Riyadh, Saudi Arabia',
				'job_id' => 'ID: 54300',
				'details_link' => esc_url( home_url( '/job-details' ) )
			),
			array(
				'title' => 'Quality Assurance Manager',
				'posted_date' => 'Posted 1 Week Ago',
				'location' => 'Dammam, Saudi Arabia',
				'job_id' => 'ID: 54301',
				'details_link' => esc_url( home_url( '/job-details' ) )
            ),
            array(
				'title' => 'Quality Assurance Manager',
				'posted_date' => 'Posted 1 Week Ago',
				'location' => 'Dammam, Saudi Arabia',
				'job_id' => 'ID: 54301',
				'details_link' => esc_url( home_url( '/job-details' ) )
			)
		),
		'show_load_more' => true
	);
	get_template_part( 'template-parts/Latest-Openings', null, $latest_openings_data ); 
	?>

</main><!-- #main -->

<?php
get_footer();

