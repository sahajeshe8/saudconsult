<?php
/**
 * Template Name: Leadership
 *
 * The template for displaying the Leadership page
 *
 * @package tasheel
 */

get_header();
?>

<main id="primary" class="site-main">
	<?php 
	$inner_banner_data = array(
		'background_image' => get_template_directory_uri() . '/assets/images/leadership-banner.jpg',
		'title' => 'Leadership',
	);
	get_template_part( 'template-parts/inner-banner', null, $inner_banner_data ); 
	?>



	<?php 
	$page_tabs_data = array(
		'tabs' => array(
			array( 'id' => 'overview', 'title' => 'Who We Are', 'link' => esc_url( home_url( '/about' ) ) ),
			array( 'id' => 'vision', 'title' => 'Vision, Mission & Values', 'link' => esc_url( home_url( '/vision-mission-values' ) ) ),
			array( 'id' => 'mission', 'title' => 'Leadership', 'link' => esc_url( home_url( '/leadership' ) ) ),
			array( 'id' => 'history', 'title' => 'Our Team', 'link' => esc_url( home_url( '/our-team' ) ) ),
			array( 'id' => 'journey', 'title' => 'Our Journey & Legacy', 'link' => esc_url( home_url( '/our-journey-legacy' ) ) ),
			array( 'id' => 'milestones', 'title' => 'Company Milestones', 'link' => esc_url( home_url( '/company-milestones' ) ) ),
			array( 'id' => 'Awards & Certifications', 'title' => 'Awards & Certifications', 'link' => esc_url( home_url( '/awards' ) ) )
		),
		'active_tab' => 'mission' // Set which tab should be active
	);
	get_template_part( 'template-parts/page-tabs', null, $page_tabs_data ); 
	?>



<section class="pt_100 pb_20">
		<div class="wrap">
			<h3 class="h3_title_50">
            Our Visionary <span>Leadership</span>
			</h3>
		</div>
	</section>





	<?php 
	$visionary_leadership_data = array(
		'label' => '',
		'title' => '', // Empty to hide title on this page
		'title_span' => '', // Empty to hide title on this page
		'list_class' => 'custom-leadership-list', // Custom class for leadership_section_inner_left_list
		'leadership_members' => array(
			array(
				'image' => get_template_directory_uri() . '/assets/images/l1.jpg',
				'name' => 'Daniel K. Hartman',
				'position' => 'Chief Operating Officer',
				'linkedin_url' => '#'
			),
			array(
				'image' => get_template_directory_uri() . '/assets/images/l2.jpg',
				'name' => 'Omar Reyes',
				'position' => 'Vice Chairman',
				'linkedin_url' => '#'
			),
			array(
				'image' => get_template_directory_uri() . '/assets/images/l2.jpg',
				'name' => 'Michael Trent',
				'position' => 'Chief Operating Officer',
				'linkedin_url' => '#'
			),
			array(
				'image' => get_template_directory_uri() . '/assets/images/l2.jpg',
				'name' => 'Adrian Cole',
				'position' => 'Chief Strategy Officer',
				'linkedin_url' => '#'
			) 
		)
	);
	get_template_part( 'template-parts/Visionary-Leadership', null, $visionary_leadership_data ); 
	?>



 
</main><!-- #main -->

<?php
get_footer();

