<?php
/**
 * Template Name: Awards & Certifications
 *
 * The template for displaying the Awards & Certifications page
 *
 * @package tasheel
 */

get_header();
?>

<main id="primary" class="site-main">
	<?php 
	$awards_slider_data = array(
		'title' => 'Our',
		'title_span' => 'Awards & Certifications',
		'section_class' => '',
		'awards' => array(
                array(
                    'image' => get_template_directory_uri() . '/assets/images/awards.jpg',
                    'alt' => 'Awards & Certifications',
                    'title' => 'Awards & Certifications',
                    'year' => '',
                    'link' => ''
                ),
                array(
                    'image' => get_template_directory_uri() . '/assets/images/awards.jpg',
                    'alt' => 'Awards & Certifications',
                    'title' => 'Awards & Certifications',
                    'year' => 'ISO 9001:2015 ',
                    'link' => 'Ensures consistent quality management and service excellence.'
                ),
                array(
                    'image' => get_template_directory_uri() . '/assets/images/awards.jpg',
                    'alt' => 'Awards & Certifications',
                    'title' => 'Awards & Certifications',
                    'year' => 'ISO 9001:2015 ',
                    'link' => 'Ensures consistent quality management and service excellence.'
                ),
                array(
                    'image' => get_template_directory_uri() . '/assets/images/awards.jpg',
                    'alt' => 'Awards & Certifications',
                    'year' => 'ISO 9001:2015 ',
                    'link' => 'Ensures consistent quality management and service excellence.'
                ),
                array(
                    'image' => get_template_directory_uri() . '/assets/images/awards.jpg',
                    'alt' => 'Awards & Certifications',
                    'title' => 'Awards & Certifications',
                    'year' => 'ISO 9001:2015 ',
                    'link' => 'Ensures consistent quality management and service excellence.'
                ),
                array(
                    'image' => get_template_directory_uri() . '/assets/images/awards.jpg',
                    'alt' => 'Awards & Certifications',
                    'title' => 'Awards & Certifications',
                    'year' => 'ISO 9001:2015 ',
                    'link' => 'Ensures consistent quality management and service excellence.'
                ),
		)
	);
	// Slider 1: 3 slides per view
	get_template_part( 'template-parts/Awards-Slider', null, $awards_slider_data );
	
	// Slider 2: 1 slide per view - Awards Bot Slider Data
	$awards_bot_slider_data = array(
		'title' => 'Our',
		'title_span' => 'Awards & Certifications',
		'section_class' => '',
		'awards' => array(
			array(
				'image' => get_template_directory_uri() . '/assets/images/awards.jpg',
				'alt' => 'Awards & Certifications',
				'title' => 'Awards & Certifications',
				'year' => '',
				'link' => ''
			),
			array(
				'image' => get_template_directory_uri() . '/assets/images/awards.jpg',
				'alt' => 'Awards & Certifications',
				'title' => 'Awards & Certifications',
				'year' => 'ISO 9001:2015 ',
				'link' => 'Ensures consistent quality management and service excellence.'
			),
			array(
				'image' => get_template_directory_uri() . '/assets/images/awards.jpg',
				'alt' => 'Awards & Certifications',
				'title' => 'Awards & Certifications',
				'year' => 'ISO 9001:2015 ',
				'link' => 'Ensures consistent quality management and service excellence.'
			),
			array(
				'image' => get_template_directory_uri() . '/assets/images/awards.jpg',
				'alt' => 'Awards & Certifications',
				'year' => 'ISO 9001:2015 ',
				'link' => 'Ensures consistent quality management and service excellence.'
			),
			array(
				'image' => get_template_directory_uri() . '/assets/images/awards.jpg',
				'alt' => 'Awards & Certifications',
				'title' => 'Awards & Certifications',
				'year' => 'ISO 9001:2015 ',
				'link' => 'Ensures consistent quality management and service excellence.'
			),
			array(
				'image' => get_template_directory_uri() . '/assets/images/awards.jpg',
				'alt' => 'Awards & Certifications',
				'title' => 'Awards & Certifications',
				'year' => 'ISO 9001:2015 ',
				'link' => 'Ensures consistent quality management and service excellence.'
			),
		)
	);
	get_template_part( 'template-parts/Awards-Slider-Bot', null, $awards_bot_slider_data );
	
	// Slider 3: 1 slide per view - Awards Slider 2 Data
	$awards_slider_2_data = array(
		'title' => 'Our',
		'title_span' => 'Awards & Certifications',
		'section_class' => '',
		'awards' => array(
			array(
				'image' => get_template_directory_uri() . '/assets/images/awards.jpg',
				'alt' => 'Awards & Certifications',
				'title' => 'Awards & Certifications',
				'year' => '',
				'link' => ''
			),
			array(
				'image' => get_template_directory_uri() . '/assets/images/awards.jpg',
				'alt' => 'Awards & Certifications',
				'title' => 'Awards & Certifications',
				'year' => 'ISO 9001:2015 ',
				'link' => 'Ensures consistent quality management and service excellence.'
			),
			array(
				'image' => get_template_directory_uri() . '/assets/images/awards.jpg',
				'alt' => 'Awards & Certifications',
				'title' => 'Awards & Certifications',
				'year' => 'ISO 9001:2015 ',
				'link' => 'Ensures consistent quality management and service excellence.'
			),
			array(
				'image' => get_template_directory_uri() . '/assets/images/awards.jpg',
				'alt' => 'Awards & Certifications',
				'year' => 'ISO 9001:2015 ',
				'link' => 'Ensures consistent quality management and service excellence.'
			),
			array(
				'image' => get_template_directory_uri() . '/assets/images/awards.jpg',
				'alt' => 'Awards & Certifications',
				'title' => 'Awards & Certifications',
				'year' => 'ISO 9001:2015 ',
				'link' => 'Ensures consistent quality management and service excellence.'
			),
			array(
				'image' => get_template_directory_uri() . '/assets/images/awards.jpg',
				'alt' => 'Awards & Certifications',
				'title' => 'Awards & Certifications',
				'year' => 'ISO 9001:2015 ',
				'link' => 'Ensures consistent quality management and service excellence.'
			),
		)
	);
	get_template_part( 'template-parts/Awards-Slider-2', null, $awards_slider_2_data );
	?>
</main><!-- #main -->

<?php
get_footer();

