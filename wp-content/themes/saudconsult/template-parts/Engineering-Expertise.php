<?php
/**
 * Engineering Expertise Section Component Template
 *
 * @package tasheel
 */

// Extract data from args array passed from get_template_part()
$args = isset( $args ) ? $args : array();

// Set default values or use passed values
$title = isset( $args['title'] ) ? $args['title'] : 'Engineering';
$title_span = isset( $args['title_span'] ) ? $args['title_span'] : 'Expertise';
$description = isset( $args['description'] ) ? $args['description'] : '';
$expertise_items = isset( $args['expertise_items'] ) ? $args['expertise_items'] : array(
	array(
		'icon' => get_template_directory_uri() . '/assets/images/expertise-icon-01.svg',
		'title' => 'Architectural Design',
		'description' => 'Creating innovative and functional architectural solutions that balance aesthetics with practicality.'
	),
	array(
		'icon' => get_template_directory_uri() . '/assets/images/expertise-icon-02.svg',
		'title' => 'Structural Engineering',
		'description' => 'Designing robust structural systems that ensure safety, durability, and compliance with international standards.'
	),
	array(
		'icon' => get_template_directory_uri() . '/assets/images/expertise-icon-03.svg',
		'title' => 'MEP Design',
		'description' => 'Integrating mechanical, electrical, and plumbing systems seamlessly into building designs for optimal performance.'
	),
	array(
		'icon' => get_template_directory_uri() . '/assets/images/expertise-icon-04.svg',
		'title' => 'Civil Engineering',
		'description' => 'Planning and designing infrastructure projects including roads, bridges, utilities, and site development.'
	),
	array(
		'icon' => get_template_directory_uri() . '/assets/images/expertise-icon-05.svg',
		'title' => '3D Modeling & BIM',
		'description' => 'Utilizing advanced Building Information Modeling (BIM) technology to create detailed 3D models.'
	),
	array(
		'icon' => get_template_directory_uri() . '/assets/images/expertise-icon-06.svg',
		'title' => 'Sustainability & Green Design',
		'description' => 'Incorporating sustainable design principles and green building practices to minimize environmental impact.'
	)
);

// Handle section wrapper classes - can be array or string
$section_wrapper_class = isset( $args['section_wrapper_class'] ) ? $args['section_wrapper_class'] : array();
if ( is_array( $section_wrapper_class ) ) {
	$section_wrapper_class = ! empty( $section_wrapper_class ) ? implode( ' ', array_map( 'esc_attr', $section_wrapper_class ) ) : '';
} else {
	$section_wrapper_class = esc_attr( $section_wrapper_class );
}

$section_class = isset( $args['section_class'] ) ? $args['section_class'] : '';

// Content section data - array of items with image, title, description, button for each
$content_items = isset( $args['content_items'] ) ? $args['content_items'] : array(
	array(
		'label' => 'Infrastructure',
		'image' => get_template_directory_uri() . '/assets/images/infrastructure.jpg',
		'title' => 'Infrastructure',
		'description' => 'Infrastructure is the lifeblood of national development. We deliver comprehensive infrastructure solutions including roads, bridges, utilities, and public facilities that form the foundation of modern society.',
		'button_text' => 'View more',
		'button_link' => esc_url( home_url( '/infrastructure' ) )
	),
	array(
		'label' => 'Planning and Site Development',
		'image' => get_template_directory_uri() . '/assets/images/planning-and-site-development.jpg',
		'title' => 'Planning and Site Development',
		'description' => 'Comprehensive planning and site development services that optimize land use, ensure environmental compliance, and create sustainable communities. Our expertise covers master planning, feasibility studies, and site optimization.',
		'button_text' => 'View more',
		'button_link' => esc_url( home_url( '/infrastructure' ) )
	),
	array(
		'label' => 'Building Engineering',
		'image' => get_template_directory_uri() . '/assets/images/building-engineering.jpg',
		'title' => 'Building Engineering',
		'description' => 'Expert building engineering solutions that ensure structural integrity, energy efficiency, and code compliance. We design commercial, residential, and institutional buildings that stand the test of time.',
		'button_text' => 'View more',
		'button_link' => esc_url( home_url( '/infrastructure' ) )
	),
	array(
		'label' => 'Electric Power Projects',
		'image' => get_template_directory_uri() . '/assets/images/electric-power-projects.jpg',
		'title' => 'Electric Power Projects',
		'description' => 'Advanced electric power project design and implementation services including transmission lines, substations, and renewable energy systems. We power the future with reliable and sustainable energy solutions.',
		'button_text' => 'View more',
		'button_link' => esc_url( home_url( '/infrastructure' ) )
	),
	array(
		'label' => 'Transportation',
		'image' => get_template_directory_uri() . '/assets/images/building-engineering.jpg',
		'title' => 'Transportation',
		'description' => 'Innovative transportation infrastructure solutions for modern mobility needs. From highways and railways to airports and ports, we design transportation systems that connect communities and drive economic growth.',
		'button_text' => 'View more',
		'button_link' => esc_url( home_url( '/infrastructure' ) )
	),
	array(
		'label' => 'Defense and Aviation',
		'image' => get_template_directory_uri() . '/assets/images/building-engineering.jpg',
		'title' => 'Defense and Aviation',
		'description' => 'Specialized engineering services for defense and aviation infrastructure projects. We deliver secure, efficient facilities that meet the highest standards of safety and operational excellence for military and aviation sectors.',
		'button_text' => 'View more',
		'button_link' => esc_url( home_url( '/infrastructure' ) )
	),
	array(
		'label' => 'Oil & Gas / Industrial',
		'image' => get_template_directory_uri() . '/assets/images/building-engineering.jpg',
		'title' => 'Oil & Gas / Industrial',
		'description' => 'Comprehensive engineering solutions for oil, gas, and industrial facilities. Our expertise includes refineries, petrochemical plants, pipelines, and industrial complexes designed for safety, efficiency, and environmental compliance.',
		'button_text' => 'View more',
		'button_link' => esc_url( home_url( '/infrastructure' ) )
	),
	array(
		'label' => 'Environmental and Sustainability',
		'image' => get_template_directory_uri() . '/assets/images/building-engineering.jpg',
		'title' => 'Environmental and Sustainability',
		'description' => 'Sustainable engineering practices for environmental protection and conservation. We integrate green building principles, renewable energy, and environmental management systems to minimize impact and maximize sustainability.',
		'button_text' => 'View more',
		'button_link' => esc_url( home_url( '/infrastructure' ) )
	),
	array(
		'label' => 'BIM / GIS',
		'image' => get_template_directory_uri() . '/assets/images/careers-banner.jpg',
		'title' => 'BIM / GIS',
		'description' => 'Advanced Building Information Modeling and Geographic Information Systems services. We leverage cutting-edge technology to create detailed 3D models, spatial analysis, and digital twins that enhance project visualization and collaboration.',
		'button_text' => 'View more',
		'button_link' => esc_url( home_url( '/infrastructure' ) )
	)
);

// Set default/active item (first one)
$active_item = ! empty( $content_items ) ? $content_items[0] : array();

?>

<section style="background:url(<?php echo get_template_directory_uri(); ?>/assets/images/design-section-bg.png) #F5F9EE no-repeat  85% center; background-size: contain;" class="engineering_expertise_section  pt_80 pb_80 <?php echo esc_attr( $section_class ); ?> <?php echo $section_wrapper_class; ?>">
	<div class="wrap">
		<?php if ( $title || $title_span ) : ?>
			<div class="engineering_expertise_header pb_50">
				<h3 class="h3_title_50">
					<?php if ( $title ) : ?>
						<?php echo esc_html( $title ); ?>
					<?php endif; ?>
					<?php if ( $title_span ) : ?>
						<span><?php echo esc_html( $title_span ); ?></span>
					<?php endif; ?>
				</h3>
			</div>
		<?php endif; ?>

	 

	 
	</div>


	<div class="engineering_expertise_content_01" data-expertise-container>
		<div class="expertise_image_wrapper">
			<?php if ( ! empty( $active_item ) && isset( $active_item['image'] ) ) : ?>
				<img src="<?php echo esc_url( $active_item['image'] ); ?>" alt="<?php echo esc_attr( isset( $active_item['title'] ) ? $active_item['title'] : '' ); ?>" class="expertise_active_image expertise_image_1">
				<img src="<?php echo esc_url( $active_item['image'] ); ?>" alt="<?php echo esc_attr( isset( $active_item['title'] ) ? $active_item['title'] : '' ); ?>" class="expertise_active_image expertise_image_2" style="opacity: 0;">
			<?php endif; ?>
		</div>
		
		<div class="expertise_thumb_row_content">
			<div class="wrap">
				<div class="expertise_content_wrapper">
					<?php if ( ! empty( $active_item ) && isset( $active_item['title'] ) ) : ?>
						<h3 class="expertise_active_title"><?php echo esc_html( $active_item['title'] ); ?></h3>
					<?php endif; ?>
					
					<?php if ( ! empty( $active_item ) && isset( $active_item['description'] ) ) : ?>
						<div class="expertise_active_description">
							<p ><?php echo wp_kses_post( $active_item['description'] ); ?></p>
						</div>
					<?php endif; ?>
					
					<?php if ( ! empty( $active_item ) && isset( $active_item['button_text'] ) && isset( $active_item['button_link'] ) ) : ?>
						<a class="btn_style btn_transparent expertise_active_button" href="<?php echo esc_url( $active_item['button_link'] ); ?>">
							<?php echo esc_html( $active_item['button_text'] ); ?> 
							<span>
								<img src="<?php echo get_template_directory_uri(); ?>/assets/images/arrow-buttion.svg" alt="<?php echo esc_attr( $active_item['button_text'] ); ?>">
							</span>
						</a>
					<?php endif; ?>
				</div>
			</div>

			<?php if ( ! empty( $content_items ) ) : ?>
				<div class="expertise_thumb_row">
					<ul class="expertise_list_ul">
						<?php foreach ( $content_items as $index => $item ) : 
							$item_label = isset( $item['label'] ) ? $item['label'] : '';
							$item_image = isset( $item['image'] ) ? $item['image'] : '';
							$item_title = isset( $item['title'] ) ? $item['title'] : '';
							$item_description = isset( $item['description'] ) ? $item['description'] : '';
							$item_button_text = isset( $item['button_text'] ) ? $item['button_text'] : '';
							$item_button_link = isset( $item['button_link'] ) ? $item['button_link'] : '';
							$is_active = ( $index === 0 ) ? 'active' : '';
						?>
							<li class="expertise_list_item <?php echo esc_attr( $is_active ); ?>" 
								data-index="<?php echo esc_attr( $index ); ?>"
								data-image="<?php echo esc_url( $item_image ); ?>"
								data-title="<?php echo esc_attr( $item_title ); ?>"
								data-description="<?php echo esc_attr( $item_description ); ?>"
								data-button-text="<?php echo esc_attr( $item_button_text ); ?>"
								data-button-link="<?php echo esc_url( $item_button_link ); ?>">
							<span> <?php echo esc_html( $item_label ); ?></span>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>

