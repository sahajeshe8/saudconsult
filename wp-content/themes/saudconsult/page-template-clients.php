<?php
/**
 * Template Name: Clients
 *
 * The template for displaying the Clients page
 *
 * @package tasheel
 */

get_header();
?>

<main id="primary" class="site-main">
	<?php 
	$inner_banner_data = array(
		'background_image' => get_template_directory_uri() . '/assets/images/careers-banner.jpg',
		'title' => 'Our Clients',
	);
	get_template_part( 'template-parts/inner-banner', null, $inner_banner_data ); 
	?>
 
</main><!-- #main -->

<?php
get_footer();

