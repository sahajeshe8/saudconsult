<?php
/**
 * Project Info Block Component Template
 *
 * @package tasheel
 */

// Extract data from args array passed from get_template_part()
$args = isset( $args ) ? $args : array();

// Set default values or use passed values
$description = isset( $args['description'] ) ? $args['description'] : '';
$section_wrapper_class = isset( $args['section_wrapper_class'] ) ? $args['section_wrapper_class'] : array();
$section_class = isset( $args['section_class'] ) ? $args['section_class'] : '';
$info_items = isset( $args['info_items'] ) ? $args['info_items'] : array();

// Build section wrapper classes
$wrapper_classes = array( 'project_info_block_section' );
if ( $section_wrapper_class ) {
	if ( is_array( $section_wrapper_class ) ) {
		$wrapper_classes = array_merge( $wrapper_classes, $section_wrapper_class );
	} else {
		$wrapper_classes[] = $section_wrapper_class;
	}
}
$wrapper_class_string = implode( ' ', array_map( 'esc_attr', $wrapper_classes ) );

?>

<section class="<?php echo $wrapper_class_string; ?>">
	<div class="wrap">
		<div class="project_info_block_container">
			<?php if ( $description ) : ?>
				<div class="project_info_description">
					<p><?php echo wp_kses_post( $description ); ?></p>
				</div>
			<?php endif; ?>

			<?php if ( ! empty( $info_items ) ) : ?>
				<ul class="project_info_grid">
					<?php foreach ( $info_items as $item ) : 
						$label = isset( $item['label'] ) ? $item['label'] : '';
						$value = isset( $item['value'] ) ? $item['value'] : '';
					?>
						<?php if ( $label && $value ) : ?>
							<li class="project_info_item">
								<h5 class="project_info_label"><?php echo esc_html( $label ); ?></h5>
								<div class="project_info_value"><?php echo wp_kses_post( $value ); ?></div>
							</li>
						<?php endif; ?>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</div>
	</div>
</section>

