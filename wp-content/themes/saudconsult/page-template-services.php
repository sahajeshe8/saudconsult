<?php
/**
 * Template Name: Services
 *
 * The template for displaying the Services page
 *
 * @package tasheel
 */

get_header();
?>

<main id="primary" class="site-main">
	<?php 
	$inner_banner_data = array(
		'background_image' => get_template_directory_uri() . '/assets/images/service-banner.jpg',
		'title' => 'Services',
	);
	get_template_part( 'template-parts/inner-banner', null, $inner_banner_data ); 
	?>

	<?php 
	$content_block_service_data = array(
		'title' => 'Our Comprehensive<br> <span>Services</span>',
		'content' => 'Our multidisciplinary team is structured to deliver integrated solutions across the following critical sectors, ensuring innovation and efficiency in every design.',
		'section_wrapper_class' => array('bg_collor_green')
	);
	get_template_part( 'template-parts/Content-Block-Service', null, $content_block_service_data ); 
	?>

	<section class="services_items_section pb_100 bg_collor_green">
		<div class="wrap">
			<ul class="services_items_grid">
				<li>
					<?php 
					$service_item_data = array(
						'image' => get_template_directory_uri() . '/assets/images/service-img-01.jpg',
						'image_alt' => 'Engineering Design',
						'title' => 'Engineering Design',
						'subtitle' => 'Innovative Solutions',
						'description' => 'Translating vision into robust, buildable plans, including architectural, structural.',
						'button_text' => 'View more',
						'button_link' => esc_url( home_url( '/engineering-design' ) )
					);
					get_template_part( 'template-parts/Service-Item', null, $service_item_data ); 
					?>
				</li>

				<li>
					<?php 
					$service_item_data = array(
						'image' => get_template_directory_uri() . '/assets/images/service-img-02.jpg',
						'image_alt' => 'Construction Supervision',
						'title' => 'Construction Supervision',
						'subtitle' => 'Quality Assurance',
						'description' => 'Providing on-site assurance and quality management to ensure execution.',
						'button_text' => 'View more',
						'button_link' => esc_url( home_url( '/' ) )
					);
					get_template_part( 'template-parts/Service-Item', null, $service_item_data ); 
					?>
				</li>

				<li>
					<?php 
					$service_item_data = array(
						'image' => get_template_directory_uri() . '/assets/images/service-img-03.jpg',
						'image_alt' => 'Project Management',
						'title' => 'Project Management',
						'subtitle' => 'On-Time Delivery',
						'description' => 'Offering end-to-end management consultancy (PMC) to control scope.',
						'button_text' => 'View more',
						'button_link' => esc_url( home_url( '/' ) )
					);
					get_template_part( 'template-parts/Service-Item', null, $service_item_data ); 
					?>
				</li>

				<li>
					<?php 
					$service_item_data = array(
						'image' => get_template_directory_uri() . '/assets/images/service-img-04.jpg',
						'image_alt' => 'Specialized Studies',
						'title' => 'Specialized Studies',
						'subtitle' => 'Innovative Solutions',
						'description' => 'Conducting essential pre-design work, including feasibility studies.',
						'button_text' => 'View more',
						'button_link' => esc_url( home_url( '/' ) )
					);
					get_template_part( 'template-parts/Service-Item', null, $service_item_data ); 
					?>
				</li>
			</ul>
		</div>
	</section>
 

 

</main><!-- #main -->

<?php
get_footer();

