<?php
/**
 * The front page template file
 *
 * This is the template for the home page
 *
 * @package tasheel
 */

get_header();
?>

  
		<?php get_template_part( 'template-parts/Banner' ); ?>
 		<?php get_template_part( 'template-parts/About' ); ?>
 		<?php get_template_part( 'template-parts/Innovation' ); ?>
 		<?php get_template_part( 'template-parts/Services' ); ?>
 		<?php 
		$projects_home_data = array(
			'label_text' => 'Our Projects',
			'label_icon' => get_template_directory_uri() . '/assets/images/dot-02.svg',
			'title' => 'Our Work,',
			'title_span' => 'Across Industries',
			'description' => 'Where Our Expertise Makes an Impact.',
			'button_text' => 'Explore More',
			'button_link' => esc_url( home_url( '/contact' ) ),
			'section_wrapper_class' => array(),
			'section_class' => '',
			'projects' => array(
				array(
					'background_image' => get_template_directory_uri() . '/assets/images/pro-img.jpg',
					'background_image_alt' => 'Project Background',
					'title' => 'Rayadah Housing Project',
					'description' => 'Detailed Infrastructure Design, Construction Supervision, Environmental Impact Study, and Value Engineering for the complete mixed-use development.',
					'button_text' => 'Explore More',
					'button_link' => '#',
					'stats' => array(
						array(
							'value' => '2011',
							'label' => 'Completion'
						),
						array(
							'value' => '22,000 M2',
							'label' => 'Area'
						),
						array(
							'value' => '20KM',
							'label' => 'Length of Road'
						),
						array(
							'value' => '(SAR) 1M',
							'label' => 'Cost'
						)
					)
				),
				array(
					'background_image' => get_template_directory_uri() . '/assets/images/pro-img.jpg',
					'background_image_alt' => 'Project Background',
					'title' => 'Rayadah Housing Project',
					'description' => 'Detailed Infrastructure Design, Construction Supervision, Environmental Impact Study, and Value Engineering for the complete mixed-use development.',
					'button_text' => 'Explore More',
					'button_link' => '#',
					'stats' => array(
						array(
							'value' => '2011',
							'label' => 'Completion'
						),
						array(
							'value' => '22,000 M2',
							'label' => 'Area'
						),
						array(
							'value' => '20KM',
							'label' => 'Length of Road'
						),
						array(
							'value' => '(SAR) 1M',
							'label' => 'Cost'
						)
					)
				)
			)
		);
		get_template_part( 'template-parts/Projects-home', null, $projects_home_data ); 
		?>
 		<?php get_template_part( 'template-parts/Leadership' ); ?>
 		<?php get_template_part( 'template-parts/home-Partners' ); ?>
		<?php 
		$banner_add_data = array(
			'background_image' => get_template_directory_uri() . '/assets/images/ready-to-partner-one.jpg',
			'mobile_image' => get_template_directory_uri() . '/assets/images/ready-to-partner-one-mobile.jpg',
			'title' => 'Ready to Partner',
			'subtitle' => 'on Your Vision?',
			'description' => 'Leverage our five decades of pioneering excellence to ensure the success of your next ambitious venture.',
			'button_text' => 'Explore More',
			'button_link' => '#'
		);
		get_template_part( 'template-parts/banner-add', null, $banner_add_data ); 
		?>



<?php get_template_part( 'template-parts/Insights-Resources' ); ?>

<?php 
		$banner_add_data = array(
			'background_image' => get_template_directory_uri() . '/assets/images/build-your-future.jpg',
			'mobile_image' => get_template_directory_uri() . '/assets/images/build-your-future-mobile.jpg',
			'title' => 'Build Your Future',
			'subtitle' => 'With Us',
			'description' => 'We don\'t just fill positions—we cultivate talent. Explore opportunities where your skills lead to transformative impact across the region.',
			'button_text' => 'Join our Team',
			'button_link' => '#'
		);
		get_template_part( 'template-parts/banner-add', null, $banner_add_data ); 
		?>
 		 

<?php
get_footer();

