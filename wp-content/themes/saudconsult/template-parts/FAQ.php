<?php
/**
 * FAQ Component Template
 *
 * FAQ section template part
 *
 * @package tasheel
 */

// Extract data from args array passed from get_template_part()
$args = isset( $args ) ? $args : array();

// Set default values or use passed values
$section_wrapper_class = isset( $args['section_wrapper_class'] ) ? $args['section_wrapper_class'] : array();
$section_class = isset( $args['section_class'] ) ? $args['section_class'] : '';

// Build section wrapper classes
$wrapper_classes = array( 'faq_section' );
if ( $section_wrapper_class ) {
	if ( is_array( $section_wrapper_class ) ) {
		$wrapper_classes = array_merge( $wrapper_classes, $section_wrapper_class );
	} else {
		$wrapper_classes[] = $section_wrapper_class;
	}
}
$wrapper_class_string = implode( ' ', array_map( 'esc_attr', $wrapper_classes ) );
?>

<section class="<?php echo $wrapper_class_string; ?> <?php echo esc_attr( $section_class ); ?>">
	<div class="wrap">
		<div class="faq_wrapper">
			<!-- FAQ content will be added here -->
		</div>
	</div>
</section>

