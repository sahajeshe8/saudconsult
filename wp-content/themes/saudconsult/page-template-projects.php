<?php
/**
 * Template Name: Projects
 *
 * The template for displaying the Projects page
 *
 * @package tasheel
 */

get_header();
?>

<main id="primary" class="site-main">
	<?php 
	$inner_banner_data = array(
		'background_image' => get_template_directory_uri() . '/assets/images/project-banner.jpg',
		'title' => 'Projects',
	);
	get_template_part( 'template-parts/inner-banner', null, $inner_banner_data ); 
	?>

	<?php 
	$project_filter_data = array(
		'title' => 'Latest',
		'title_span' => 'Projects',
		'section_wrapper_class' => array(),
		'section_class' => '',
		'filters' => array(
			array(
				'label' => 'Services',
				'options' => array(
					array( 'value' => '', 'text' => 'All Services' ),
					array( 'value' => 'engineering-design', 'text' => 'Engineering Design' ),
					array( 'value' => 'construction-supervision', 'text' => 'Construction Supervision' ),
					array( 'value' => 'project-management', 'text' => 'Project Management' ),
					array( 'value' => 'specialized-studies', 'text' => 'Specialized Studies' )
				),
				'default_value' => ''
			),
			array(
				'label' => 'Sectors',
				'options' => array(
					array( 'value' => '', 'text' => 'All Sectors' ),
					array( 'value' => 'infrastructure', 'text' => 'Infrastructure' ),
					array( 'value' => 'building', 'text' => 'Building' ),
					array( 'value' => 'transportation', 'text' => 'Transportation' ),
					array( 'value' => 'oil-gas', 'text' => 'Oil & Gas' ),
					array( 'value' => 'power', 'text' => 'Power' )
				),
				'default_value' => ''
			),
			array(
				'label' => 'Location',
				'options' => array(
					array( 'value' => '', 'text' => 'All Locations' ),
					array( 'value' => 'riyadh', 'text' => 'Riyadh' ),
					array( 'value' => 'jeddah', 'text' => 'Jeddah' ),
					array( 'value' => 'dammam', 'text' => 'Dammam' ),
					array( 'value' => 'makkah', 'text' => 'Makkah' )
				),
				'default_value' => ''
			)
		),
		'clear_filter_text' => 'Clear Filter',
		'clear_filter_link' => '#'
	);
	get_template_part( 'template-parts/Project-Filter', null, $project_filter_data ); 
	?>

	<section class="projects_list_section pt_20 pb_80">
		<div class="wrap">
			<div class="project_cards_grid" id="projects-grid">
				<?php 
				// Define all projects in an array
				$all_projects = array(
					array(
						'image' => get_template_directory_uri() . '/assets/images/pro-01.jpg',
						'image_alt' => 'King Abdullah Road - Phase 2',
						'title' => 'King Abdullah ',
						'title_span' => 'Road - Phase 2',
						'description' => 'Road expansion and infrastructure upgrades to improve traffic flow, safety, and connectivity.',
						'link' => esc_url( home_url( '/project-details' ) )
					),
					array(
						'image' => get_template_directory_uri() . '/assets/images/pro-02.jpg',
						'image_alt' => 'Al Riyadh Transit Hub',
						'title' => 'Al Riyadh ',
						'title_span' => 'Transit Hub',
						'description' => 'Water treatment and reuse plant supporting urban and industrial growth.',
						'link' => esc_url( home_url( '/project-details' ) )
					),
					array(
						'image' => get_template_directory_uri() . '/assets/images/pro-03.jpg',
						'image_alt' => 'Eastern Coastal Water Facility',
						'title' => 'Eastern Coastal ',
						'title_span' => 'Water Facility',
						'description' => 'Water treatment and reuse plant supporting urban and industrial growth.',
						'link' => esc_url( home_url( '/project-details' ) )
					),
					array(
						'image' => get_template_directory_uri() . '/assets/images/pro-04.jpg',
						'image_alt' => 'Jubail Logistics Park',
						'title' => 'Jubail ',
						'title_span' => 'Logistics Park',
						'description' => 'Planned industrial logistics park with roads, utilities, and support facilities.',
						'link' => esc_url( home_url( '/project-details' ) )
					),
					array(
						'image' => get_template_directory_uri() . '/assets/images/pro-05.jpg',
						'image_alt' => 'Al Riyadh Transit Hub',
						'title' => 'Al Riyadh ',
						'title_span' => 'Transit Hub',
						'description' => 'Water treatment and reuse plant supporting urban and industrial growth.',
						'link' => esc_url( home_url( '/project-details' ) )
					),
					array(
						'image' => get_template_directory_uri() . '/assets/images/pro-06.jpg',
						'image_alt' => 'Eastern Coastal Water Facility',
						'title' => 'Eastern Coastal ',
						'title_span' => 'Water Facility',
						'description' => 'Water treatment and reuse plant supporting urban and industrial growth.',
						'link' => esc_url( home_url( '/project-details' ) )
					),
					array(
						'image' => get_template_directory_uri() . '/assets/images/pro-07.jpg',
						'image_alt' => 'Jubail Logistics Park',
						'title' => 'Jubail ',
						'title_span' => 'Logistics Park',
						'description' => 'Planned industrial logistics park with roads, utilities, and support facilities.',
						'link' => esc_url( home_url( '/project-details' ) )
					),
					array(
						'image' => get_template_directory_uri() . '/assets/images/pro-08.jpg',
						'image_alt' => 'King Abdullah Road - Phase 2',
						'title' => 'King Abdullah ',
						'title_span' => 'Road - Phase 2',
						'description' => 'Road expansion and infrastructure upgrades to improve traffic flow, safety, and connectivity.',
						'link' => esc_url( home_url( '/project-details' ) )
					),
					array(
						'image' => get_template_directory_uri() . '/assets/images/pro-09.jpg',
						'image_alt' => 'Al Riyadh Transit Hub',
						'title' => 'Al Riyadh ',
						'title_span' => 'Transit Hub',
						'description' => 'Water treatment and reuse plant supporting urban and industrial growth.',
						'link' => esc_url( home_url( '/project-details' ) )
					),
					array(
						'image' => get_template_directory_uri() . '/assets/images/pro-10.jpg',
						'image_alt' => 'King Abdullah Road - Phase 2',
						'title' => 'King Abdullah ',
						'title_span' => 'Road - Phase 2',
						'description' => 'Road expansion and infrastructure upgrades to improve traffic flow, safety, and connectivity.',
						'link' => esc_url( home_url( '/project-details' ) )
					),
					array(
						'image' => get_template_directory_uri() . '/assets/images/pro-11.jpg',
						'image_alt' => 'Al Riyadh Transit Hub',
						'title' => 'Al Riyadh ',
						'title_span' => 'Transit Hub',
						'description' => 'Water treatment and reuse plant supporting urban and industrial growth.',
						'link' => esc_url( home_url( '/project-details' ) )
					),
					array(
						'image' => get_template_directory_uri() . '/assets/images/pro-12.jpg',
						'image_alt' => 'Eastern Coastal Water Facility',
						'title' => 'Eastern Coastal ',
						'title_span' => 'Water Facility',
						'description' => 'Water treatment and reuse plant supporting urban and industrial growth.',
						'link' => esc_url( home_url( '/project-details' ) )
					)
				);

				// Duplicate projects array to have more items for Load More
				$duplicated_projects = array_merge( $all_projects, $all_projects );
				
				// Display projects with initial visibility
				$items_per_load = 12;
				foreach ( $duplicated_projects as $index => $project_card_data ) {
					// Add class to hide items after the first 12
					if ( $index >= $items_per_load ) {
						$project_card_data['card_class'] = 'project_card_hidden';
					}
					get_template_part( 'template-parts/Project-Card', null, $project_card_data ); 
				}
				?>

			</div>
			
			<?php 
			// Show Load More button only if there are more than 12 projects
			if ( count( $duplicated_projects ) > $items_per_load ) : ?>
				<div class="load_more_wrapper">
					<button type="button" class="btn_style btn_green load_more_btn" id="load-more-projects">
						<span>Load More</span>
					</button>
				</div>
			<?php endif; ?>
		</div>
	</section>

 

</main><!-- #main -->

<?php
get_footer();

