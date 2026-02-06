<?php
/**
 * What to Expect Section Component Template
 *
 * @package tasheel
 */

// Extract data from args array passed from get_template_part()
$args = isset( $args ) ? $args : array();

// Set default values or use passed values
$title = isset( $args['title'] ) ? $args['title'] : 'What to';
$title_span = isset( $args['title_span'] ) ? $args['title_span'] : 'Expect';
$description = isset( $args['description'] ) ? $args['description'] : 'We seamlessly integrate our core service offerings to ensure holistic, end-to-end project success:';

// Handle section wrapper classes - can be array or string
$section_wrapper_class = isset( $args['section_wrapper_class'] ) ? $args['section_wrapper_class'] : array();
if ( is_array( $section_wrapper_class ) ) {
	$section_wrapper_class = ! empty( $section_wrapper_class ) ? implode( ' ', array_map( 'esc_attr', $section_wrapper_class ) ) : '';
} else {
	$section_wrapper_class = esc_attr( $section_wrapper_class );
}

$section_class = isset( $args['section_class'] ) ? $args['section_class'] : '';
$background_color = isset( $args['background_color'] ) ? $args['background_color'] : '#F5F9EE';

// Items array - each item should have: icon, title, title_span, content, bg_class, item_class
$items = isset( $args['items'] ) ? $args['items'] : array(
	array(
		'icon' => get_template_directory_uri() . '/assets/images/what-to-inc-01.svg',
		'icon_alt' => 'Objective',
		'title' => 'Objective',
		'title_span' => '',
		'content' => 'To bridge the gap between academic theory and professional practice by exposing interns to our 4 Core Services: Engineering Design, Construction Supervision, Specialized Studies, and Project Management',
		'bg_class' => '',
		'item_class' => ''
	),
	array(
		'icon' => get_template_directory_uri() . '/assets/images/what-to-inc-02.svg',
		'icon_alt' => 'Training Structure',
		'title' => 'Training Structure',
		'title_span' => '',
		'content' => 'A combination of on-the-job training, mentorship from senior engineers, and specialized internal workshops focused on industry standards (e.g., BIM, quality control).',
		'bg_class' => '',
		'item_class' => ''
	),
	array(
		'icon' => get_template_directory_uri() . '/assets/images/what-to-inc-03.svg',
		'icon_alt' => 'Career Pathway',
		'title' => 'Career Pathway',
		'title_span' => '',
		'content' => 'Successful completion of the program, demonstrated excellence, and alignment with company needs may lead to consideration for full-time employment upon graduation.',
		'bg_class' => '',
		'item_class' => ''
	)
);

?>

<section class="what_to_expect_section pt_100 pb_100 <?php echo esc_attr( $section_class ); ?> <?php echo $section_wrapper_class; ?>" style="background: <?php echo esc_attr( $background_color ); ?>;">
	<div class="wrap">
		<div class="what_to_expect_header">
			<?php if ( $title || $title_span ) : ?>
				<h3 class="h3_title_50">
					<?php if ( $title ) : ?>
						<?php echo esc_html( $title ); ?>
					<?php endif; ?>
					<?php if ( $title_span ) : ?>
						<span><?php echo esc_html( $title_span ); ?></span>
					<?php endif; ?>
				</h3>
			<?php endif; ?>
			
			<?php if ( $description ) : ?>
				<p class="what_to_expect_description"><?php echo wp_kses_post( $description ); ?></p>
			<?php endif; ?>
		</div>

		<?php if ( ! empty( $items ) ) : ?>
			<ul class="what_to_expect_content">
				<?php foreach ( $items as $item ) : 
					$item_icon = isset( $item['icon'] ) ? $item['icon'] : '';
					$item_icon_alt = isset( $item['icon_alt'] ) ? $item['icon_alt'] : '';
					$item_title = isset( $item['title'] ) ? $item['title'] : '';
					$item_title_span = isset( $item['title_span'] ) ? $item['title_span'] : '';
					$item_content = isset( $item['content'] ) ? $item['content'] : '';
					$item_class = isset( $item['item_class'] ) ? $item['item_class'] : '';
					$item_bg_class = isset( $item['bg_class'] ) ? $item['bg_class'] : '';
					
					// Combine item classes
					$li_classes = 'what_to_expect_item';
					if ( $item_class ) {
						$li_classes .= ' ' . esc_attr( $item_class );
					}
					if ( $item_bg_class ) {
						$li_classes .= ' ' . esc_attr( $item_bg_class );
					}
				?>
					<li class="<?php echo $li_classes; ?>">
						<?php if ( $item_icon ) : ?>
							<div class="what_to_expect_icon">
								<img src="<?php echo esc_url( $item_icon ); ?>" alt="<?php echo esc_attr( $item_icon_alt ); ?>">
							</div>
						<?php endif; ?>
						
						<?php if ( $item_title ) : ?>
							<h4 class="what_to_expect_item_title">
								<?php echo esc_html( $item_title ); ?>
								<?php if ( $item_title_span ) : ?>
									<span><?php echo esc_html( $item_title_span ); ?></span>
								<?php endif; ?>
							</h4>
						<?php endif; ?>
						
						<?php if ( $item_content ) : ?>
							<p class="what_to_expect_item_content"><?php echo wp_kses_post( $item_content ); ?></p>
						<?php endif; ?>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
	</div>
</section>
