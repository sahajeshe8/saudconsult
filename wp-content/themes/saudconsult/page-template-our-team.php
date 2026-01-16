<?php
/**
 * Template Name: Our Team
 *
 * The template for displaying the Our Team page
 *
 * @package tasheel
 */

get_header();
?>

<main id="primary" class="site-main">









	<?php 
	$inner_banner_data = array(
		'background_image' => get_template_directory_uri() . '/assets/images/team-banner.jpg',
		'title' => 'Our Team',
	);
	get_template_part( 'template-parts/inner-banner', null, $inner_banner_data ); 
	?>



<?php 
	$page_tabs_data = array(
		'tabs' => array(
			array( 'id' => 'overview', 'title' => 'Who We Are' ),
			array( 'id' => 'Team', 'title' => 'Our Team' ),
			array( 'id' => 'mission', 'title' => 'Leadership' ),
			array( 'id' => 'journey', 'title' => 'Our Journey & Legacy' ),
			array( 'id' => 'vision', 'title' => 'Vision, Mission & Values' ),
			array( 'id' => 'milestones', 'title' => 'Company Milestones' ),
			array( 'id' => 'awards', 'title' => 'Awards' )
		),
		'active_tab' => 'Team' // Set which tab should be active
	);
	get_template_part( 'template-parts/page-tabs', null, $page_tabs_data ); 
	?>







	<?php 
	$executive_team_data = array(
		'title' => 'Our Executive',
		'title_span' => 'Team',
		'team_members' => array(
			array(
				'image' => get_template_directory_uri() . '/assets/images/l3.jpg',
				'name' => 'mma Caldwell',
				'position' => 'Chief Development Officer',
				'linkedin_url' => '#'
			),
			array(
				'image' => get_template_directory_uri() . '/assets/images/l4.jpg',
				'name' => 'David Ramires',
				'position' => 'Chief Operating Officer',
				'linkedin_url' => '#'
			),
			array(
				'image' => get_template_directory_uri() . '/assets/images/l5.jpg',
				'name' => 'Lucas Bennett',
				'position' => 'Chief Strategy Officer',
				'linkedin_url' => '#'
            ),
            array(
				'image' => get_template_directory_uri() . '/assets/images/l4.jpg',
				'name' => 'Maya Alston',
				'position' => 'Chief People Officer',
				'linkedin_url' => '#'
			),
			array(
				'image' => get_template_directory_uri() . '/assets/images/l1.jpg',
				'name' => 'Adrian Wells',
				'position' => 'Chief Financial Officer',
				'linkedin_url' => '#'
			),
			array(
				'image' => get_template_directory_uri() . '/assets/images/l3.jpg',
				'name' => 'Sophia Hart',
				'position' => 'Chief Innovation Officer',
				'linkedin_url' => '#'
            ),

            array(
				'image' => get_template_directory_uri() . '/assets/images/l5.jpg',
				'name' => 'Jihad Khoury',
				'position' => 'Chief Operating Officer',
				'linkedin_url' => '#'
			),
			array(
				'image' => get_template_directory_uri() . '/assets/images/l3.jpg',
				'name' => 'Hadi Sha',
				'position' => 'Chief Development Officer',
				'linkedin_url' => '#'
			),
			array(
				'image' => get_template_directory_uri() . '/assets/images/l5.jpg',
				'name' => 'Jihad Khoury',
				'position' => 'Chief Operating Officer',
				'linkedin_url' => '#'
            ),
             
		)
	);
	get_template_part( 'template-parts/Executive-Team', null, $executive_team_data ); 
	?>
	
  
</main><!-- #main -->

<?php
get_footer();

