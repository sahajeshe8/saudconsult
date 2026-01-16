<?php
/**
 * Template Name: Careers
 *
 * The template for displaying the Careers page
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
	$image_text_data = array(
		'image' => get_template_directory_uri() . '/assets/images/careers-img-01.jpg',
		'image_alt' => 'Careers',
		'title' => 'Build What\'s Next<br>',
		'title_span' => 'With Us',
		'content' => '<p>We don\'t just fill positions—we cultivate talent. Explore opportunities where your skills lead to transformative impact across the region.</p>',
		'button_text' => 'Visit Careers',
		'button_link' => esc_url( home_url( '/careers-page' ) ),
		'section_class' => '',
		'image_container_class' => '',
		'text_container_class' => ''
	);

 

	get_template_part( 'template-parts/image-text-block', null, $image_text_data ); 
	?>







<?php 
	$image_text_data = array(
		'image' => get_template_directory_uri() . '/assets/images/careers-img-02.jpg',
		'image_alt' => 'Careers',
		'title' => 'Shape the Future of<br>',
		'title_span' => 'Engineering in Saudi Arabia',
		'content' => '<p>At Saud Consult, you don\'t just take a job; you join a 50-year legacy of engineering excellence. We recognize that our over 2,000 professionals are our greatest asset, and we offer dynamic opportunities to work on the Kingdom\'s most ambitious and defining projects. We are dedicated to the development of local talent, providing the foundation for a challenging, rewarding, and deeply impactful career where your technical skills will directly contribute to the nation\'s growth.</p>',
		'button_text' => 'Corporate Trainings',
		'button_link' => esc_url( home_url( '/' ) ),
	 
        'section_class' => 'row_reverse', // Multiple classes separated by space
		'bg_style' => 'bg-style', // Background style class
		'image_container_class' => '',
		'text_container_class' => ''
	);

 

	get_template_part( 'template-parts/image-text-block', null, $image_text_data ); 
	?>







<?php 
	$image_text_data = array(
		'image' => get_template_directory_uri() . '/assets/images/careers-img-03.jpg',
		'image_alt' => 'Careers',
		'title' => 'Launch Your Career with the<br>',
		'title_span' => 'Pioneers of Saudi Engineering.',
		'content' => '<p>The SAUDCONSULT Academic Internship Program offers highly motivated university students and new graduates a rigorous 6-month training experience at the forefront of the Kingdom\'s engineering sector. This is more than a placement; it\'s a direct immersion into real-world project delivery.</p><p>You will work side-by-side with our 2,000+ professionals, applying your academic knowledge to challenging projects in vital sectors like Infrastructure, Oil & Gas, and Transportation. We are committed to nurturing the next generation of Saudi talent, providing the hands-on skills and mentorship needed to succeed in a complex, high-stakes environment.</p>',
		'button_text' => 'Academic Programs',
		'button_link' => esc_url( home_url( '/' ) ),
		'section_class' => '',
		'image_container_class' => '',
		'text_container_class' => ''
	);

 

	get_template_part( 'template-parts/image-text-block', null, $image_text_data ); 
	?>



</main><!-- #main -->

<?php
get_footer();

