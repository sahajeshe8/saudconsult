<?php
/**
 * Content Block Service Section Component Template
 *
 * @package tasheel
 */

// Extract data from args array passed from get_template_part()
$args = isset( $args ) ? $args : array();

// Set default values or use passed values
$title = isset( $args['title'] ) ? $args['title'] : 'Explore Our Full Range <br>of <span>Professional Services</span>';
$content = isset( $args['content'] ) ? $args['content'] : 'Our multidisciplinary team is structured to deliver integrated solutions across the following critical sectors, <b>ensuring innovation and efficiency in every design.</b>';
$section_class = isset( $args['section_class'] ) ? $args['section_class'] : '';
$wrap_class = isset( $args['wrap_class'] ) ? $args['wrap_class'] : '';

// Handle section wrapper classes - can be array or string
$section_wrapper_class = isset( $args['section_wrapper_class'] ) ? $args['section_wrapper_class'] : array();
if ( is_array( $section_wrapper_class ) ) {
	$section_wrapper_class = ! empty( $section_wrapper_class ) ? implode( ' ', array_map( 'esc_attr', $section_wrapper_class ) ) : '';
} else {
	$section_wrapper_class = esc_attr( $section_wrapper_class );
}

?>
<section class="<?php echo $section_wrapper_class; ?>">
<div class="wrap <?php echo esc_attr( $wrap_class ); ?>">
	<div class="services_section_01 pt_100 pb_60 <?php echo esc_attr( $section_class ); ?>">
		<div class="services_section_01_item_01 ">
			<?php if ( $title ) : ?>
				<h3 class="h3_title_50">
					<?php echo wp_kses_post( $title ); ?>
				</h3>
			<?php endif; ?>
		</div>
		<div class="services_section_01_item_02">
			<?php if ( $content ) : ?>
				<p>
					<?php echo wp_kses_post( $content ); ?>
				</p>
			<?php endif; ?>
		</div>
	</div>
</div>

</section>