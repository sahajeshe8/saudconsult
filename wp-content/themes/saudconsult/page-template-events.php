<?php
/**
 * Template Name: Events
 *
 * The template for displaying the Events page
 *
 * @package tasheel
 */

get_header();
?>

<main id="primary" class="site-main" style="background: #f5f9ee ;">
	<?php 
	$inner_banner_data = array(
		'background_image' => get_template_directory_uri() . '/assets/images/news-banner-01.jpg',
		'title' => 'Events',
	);
	get_template_part( 'template-parts/inner-banner', null, $inner_banner_data ); 
	?>

	<?php 
	$breadcrumb_data = array(
		'breadcrumb_items' => array(
			array(
				'url' => esc_url( home_url( '/' ) ),
				'icon' => true
			),
			array(
				'title' => 'Media Center',
				'url' => esc_url( home_url( '/media-center' ) )
			),
			array(
				'title' => 'Events',
				'url' => '' // Empty URL makes it active
			)
		),
		'section_wrapper_class' => array(),
		'section_class' => ''
	);
	get_template_part( 'template-parts/Breadcrumb', null, $breadcrumb_data ); 
	?>
<section class="events_page_section pt_80 pb_80"    >
	<div class="wrap">
		<div class="title_block mb_40">
			<div class="title_block_left">
				<h3 class="h3_title_50 ">Events</h3>
			</div>
		</div>

		<?php 
		$events_list_data = array(
			'events' => array() // Pass empty array to use defaults, or provide custom events array
		);
		get_template_part( 'template-parts/Events-Page-List', null, $events_list_data ); 
		?>
	</div>
</section>
	 
</main><!-- #main -->

<?php
get_footer();

