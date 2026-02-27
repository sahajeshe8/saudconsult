<?php
/**
 * Image Text Block Component Template
 *
 * @package tasheel
 */

// Extract data from args array passed from get_template_part()
$args = isset( $args ) ? $args : array();

// Set default values or use passed values
$image = isset( $args['image'] ) ? $args['image'] : get_template_directory_uri() . '/assets/images/about-img.jpg';
$image_alt = isset( $args['image_alt'] ) ? $args['image_alt'] : 'Image Text Block Image';
$title = isset( $args['title'] ) ? $args['title'] : 'Pioneering Engineering';
$title_span = isset( $args['title_span'] ) ? $args['title_span'] : 'Excellence Since 1965.';
$content = isset( $args['content'] ) ? $args['content'] : '';
$button_text = isset( $args['button_text'] ) ? $args['button_text'] : '';
$button_link = isset( $args['button_link'] ) ? $args['button_link'] : '';
$section_class      = isset( $args['section_class'] ) ? $args['section_class'] : '';
$bg_style           = isset( $args['bg_style'] ) ? $args['bg_style'] : '';
$show_image_overlay = isset( $args['show_image_overlay'] ) ? (bool) $args['show_image_overlay'] : true;
$image_container_class = isset( $args['image_container_class'] ) ? $args['image_container_class'] : '';
$text_container_class = isset( $args['text_container_class'] ) ? $args['text_container_class'] : '';
$enable_download = ! empty( $args['show_download_company_profile'] );

// Build section classes
$section_classes = 'image_text_block_section pt_80  pb_100';
if ( $section_class ) {
	$section_classes .= ' ' . esc_attr( $section_class );
}
if ( $bg_style ) {
	$section_classes .= ' ' . esc_attr( $bg_style );
}

// Build container classes (no-overlay / image_text_block_container_no_overlay hides the overlay on image)
$image_container_classes = 'image_text_block_container';
if ( ! $show_image_overlay ) {
	$image_container_classes .= ' no-overlay image_text_block_container_no_overlay';
}
if ( $image_container_class ) {
	$image_container_classes .= ' ' . esc_attr( $image_container_class );
}

$text_container_classes = 'image_image_block_container';
if ( $text_container_class ) {
	$text_container_classes .= ' ' . esc_attr( $text_container_class );
}

?>
<?php if ( ! $show_image_overlay ) : ?><style>.image_text_block_section .image_text_block_container.no-overlay::after,.image_text_block_section .image_text_block_container.image_text_block_container_no_overlay::after{display:none!important;visibility:hidden!important;opacity:0!important;pointer-events:none!important;content:none!important}</style><?php endif; ?>
<section class="<?php echo esc_attr( $section_classes ); ?>">
	<div class="wrap d_flex align_center justify_space_between align_top_tab">
		<div class="<?php echo esc_attr( $image_container_classes ); ?>" data-aos="fade-up" data-aos-duration="800" data-aos-delay="0">
			<img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $image_alt ); ?>">
		</div>
		<div class="<?php echo esc_attr( $text_container_classes ); ?>" data-aos="fade-up" data-aos-duration="800" data-aos-delay="150">
			<?php if ( $title || $title_span ) : ?>
				<h3 class="h3_title_50">
					<?php if ( $title ) : ?>
						<?php echo wp_kses_post( $title ); ?>
					<?php endif; ?>
					<?php if ( $title_span ) : ?>
						<span><?php echo wp_kses_post( $title_span ); ?></span>
					<?php endif; ?>
				</h3>
			<?php endif; ?>

			<?php if ( $content ) : ?>
				<?php echo wp_kses_post( $content ); ?>
			<?php endif; ?>

			<?php if ( $button_text && $button_link ) : ?>
				<div class="image_text_block_button">
					<a class="btn_style btn_transparent but_black" href="<?php echo esc_url( $button_link ); ?>"<?php echo $enable_download ? ' download' : ''; ?>>
						<?php echo esc_html( $button_text ); ?> <span><img src="<?php echo get_template_directory_uri(); ?>/assets/images/buttion-arrow.svg" alt="<?php echo esc_attr( $button_text ); ?>"></span>
					</a>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>

