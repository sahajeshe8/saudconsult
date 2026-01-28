<?php
/**
 * Inner Banner Component Template
 *
 * @package tasheel
 */

// Extract data from args array passed from get_template_part()
$args = isset( $args ) ? $args : array();

// Set default values or use passed values
$background_image = isset( $args['background_image'] ) ? $args['background_image'] : ( has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_ID(), 'full' ) : get_template_directory_uri() . '/assets/images/banner-img.jpg' );
$label = isset( $args['label'] ) ? $args['label'] : '';
$title = isset( $args['title'] ) ? $args['title'] : 'Who We Are';
$title_span = isset( $args['title_span'] ) ? $args['title_span'] : '';
$section_class = isset( $args['section_class'] ) ? $args['section_class'] : '';

// Build section classes
$section_classes = array( 'inner_banner_section' );
if ( $section_class ) {
	if ( is_array( $section_class ) ) {
		$section_classes = array_merge( $section_classes, $section_class );
	} else {
		$section_classes[] = $section_class;
	}
}
$section_class_string = implode( ' ', array_map( 'esc_attr', $section_classes ) );

?>

<section class="<?php echo $section_class_string; ?>">
	<div class="inner_banner_image" style="background-image: url('<?php echo esc_url( $background_image ); ?>');">
		<div class="inner_banner_overlay"></div>
	</div>
	<div class="wrap">
		<div class="inner_banner_content" data-aos="fade-up" data-aos-duration="800" data-aos-delay="0">
			<?php if ( $title ) : ?>
				<h1 class="inner_banner_title">
					<?php echo esc_html( $title ); ?>
				</h1>
			<?php endif; ?>
		</div>
	</div>
</section>

