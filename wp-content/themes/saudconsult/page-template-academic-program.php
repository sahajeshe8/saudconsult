<?php
/**
 * Template Name: Academic Program
 *
 * The template for displaying the Academic Program page
 *
 * @package tasheel
 */

get_header();
?>

<main id="primary" class="site-main">
	<?php 
	$inner_banner_data = array(
		'background_image' => get_template_directory_uri() . '/assets/images/careers-banner.jpg',
		'title' => 'Academic Program',
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
		'active_tab' => 'academic-program' // Set which tab should be active
	);
	get_template_part( 'template-parts/page-tabs', null, $page_tabs_data ); 
	?>
	
	<?php 
	$image_text_data = array(
		'image' => get_template_directory_uri() . '/assets/images/launch-img.jpg',
		'image_alt' => 'Academic Program',
		'title' => 'Launch Your Career with the<br>',
		'title_span' => 'Pioneers of Saudi Engineering.',
		'content' => '<p>The SAUDCONSULT Academic Internship Program offers highly motivated university students and new graduates a rigorous 6-month training experience at the forefront of the Kingdom\'s engineering sector. This is more than a placement; it\'s a direct immersion into real-world project delivery.</p><p>You will work side-by-side with our 2,000+ professionals, applying your academic knowledge to challenging projects in vital sectors like Infrastructure, Oil & Gas, and Transportation. We are committed to nurturing the next generation of Saudi talent, providing the hands-on skills and mentorship needed to succeed in a complex, high-stakes environment.</p>',
		// 'button_text' => 'Academic Programs',
		// 'button_link' => esc_url( home_url( '/' ) ),
		'section_class' => 'pb_0',
		'image_container_class' => '',
		'text_container_class' => ''
	);
	get_template_part( 'template-parts/image-text-block', null, $image_text_data ); 
	?>

<?php 
	$image_text_data = array(
		'image' => get_template_directory_uri() . '/assets/images/who-should-img.jpg',
		'image_alt' => 'Academic Program',
		'title' => 'Who Should',
		'title_span' => 'Apply?',
		'content' => '
        <h5>Ideal Candidate Profile</h5>
        <ul>
            <li>Currently enrolled in the final year of study, or a recent graduate (within 12 months) from a recognized university.</li>
            <li>Majors in Civil Engineering, Structural Engineering, Mechanical Engineering, Electrical Engineering, Architecture, or related fields.</li>
            <li>Strong academic record and demonstrable passion for solving complex, large-scale engineering problems.</li>
            <li>Excellent communication skills and proficiency in technical software relevant to your specialization.</li>
        </ul>',
		// 'button_text' => 'Academic Programs',
		// 'button_link' => esc_url( home_url( '/' ) ),
		'section_class' => 'row_reverse',
		'image_container_class' => '',
		'text_container_class' => ''
	);
	get_template_part( 'template-parts/image-text-block', null, $image_text_data ); 
	?>

	<?php get_template_part( 'template-parts/What-to-Expect' ); ?>




    <?php 
	$latest_openings_data = array(
		'title' => 'Academic',
		'title_span' => 'opportunities',
		'openings' => array(
			array(
				'icon' => get_template_directory_uri() . '/assets/images/academic-icn.svg',
				'title' => 'Chief Financial Officer',
				'posted_date' => 'Posted 18 Hours Ago',
				'location' => 'Riyadh, Saudi Arabia',
				'job_id' => 'ID: 54294',
				'details_link' => esc_url( home_url( '/job-details' ) )
			),
			array(
				'icon' => get_template_directory_uri() . '/assets/images/academic-icn.svg',
				'title' => 'Senior Civil Engineer',
				'posted_date' => 'Posted 1 Day Ago',
				'location' => 'Jeddah, Saudi Arabia',
				'job_id' => 'ID: 54295',
				'details_link' => esc_url( home_url( '/job-details' ) )
			),
		),
		'show_load_more' => true
	);
	get_template_part( 'template-parts/Latest-Openings', null, $latest_openings_data ); 
	?>









</main><!-- #main -->

<?php
get_footer();

