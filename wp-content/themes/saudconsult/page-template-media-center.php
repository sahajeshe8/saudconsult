<?php
/**
 * Template Name: Media Center
 *
 * The template for displaying the Media Center page
 *
 * @package tasheel
 */

get_header();
?>

<main id="primary" class="site-main">
	<?php 
	$inner_banner_data = array(
		'background_image' => get_template_directory_uri() . '/assets/images/media-center-banner.jpg',
		'title' => 'Media Center',
	);
	get_template_part( 'template-parts/inner-banner', null, $inner_banner_data ); 
	?>

	<section class="media_center_section pt_80 pb_80">
		<?php 
		$news_list_data = array(
			'title' => 'News',
			'title_span' => '',
			'section_wrapper_class' => array(),
			'section_class' => ''
		);
		get_template_part( 'template-parts/News-List', null, $news_list_data ); 
		?>
	</section>

	<section class="media_center_events_section pt_80 pb_80">
		<?php 
		$events_list_data = array(
			'title' => '',
			'title_span' => 'Events',
			'section_wrapper_class' => array(),
			'section_class' => ''
		);
		get_template_part( 'template-parts/Events-List', null, $events_list_data ); 
		?>
	</section>

	<section class="media_center_brochures_section  ">
		<?php 
		$brochures_list_data = array(
			'title' => 'Brochures',
			'title_span' => '',
			'show_view_all' => false,
			'section_wrapper_class' => array(),
			'section_class' => ''
		);
		get_template_part( 'template-parts/Brochures-List', null, $brochures_list_data ); 
		?>
	</section>

	<section class="media_center_gallery_section pt_80 ">
		<?php 
		$gallery_data = array(
			'title' => 'Gallery',
			'title_span' => '',
			'show_view_all' => true,
			'section_wrapper_class' => array(),
			'section_class' => ''
		);
		get_template_part( 'template-parts/Gallery', null, $gallery_data ); 
		?>
	</section>

	<?php 
	$faq_data = array(
		'section_wrapper_class' => array( 'pt_80', 'pb_80' ),
		'section_class' => '',
		'faq_items' => array(
			array(
				'question' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit,',
				'answer' => 'Engineering Design is the cornerstone of project success. We transform ambitious visions into detailed, optimized, and buildable plans. Our multidisciplinary team ensures every element—architectural, structural, mechanical, electrical, and utility—is integrated flawlessly, adhering to local regulations and international standards.',
				'is_open' => true
			),
			array(
				'question' => 'Lorem ipsum dolor sit amet,',
				'answer' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.',
				'is_open' => false
			),
			array(
				'question' => 'Lorem ipsum dolor sit amet, consectetur adipiscing',
				'answer' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.',
				'is_open' => false
			),
			array(
				'question' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit,',
				'answer' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.',
				'is_open' => false
			),
		)
	);
	get_template_part( 'template-parts/FAQ', null, $faq_data ); 
	?>

</main><!-- #main -->

<?php
get_footer();

