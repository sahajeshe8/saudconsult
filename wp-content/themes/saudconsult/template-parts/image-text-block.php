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
$section_class = isset( $args['section_class'] ) ? $args['section_class'] : '';
$bg_style = isset( $args['bg_style'] ) ? $args['bg_style'] : '';
$image_container_class = isset( $args['image_container_class'] ) ? $args['image_container_class'] : '';
$text_container_class = isset( $args['text_container_class'] ) ? $args['text_container_class'] : '';

// Build section classes
$section_classes = 'image_text_block_section pt_120 pb_120';
if ( $section_class ) {
	$section_classes .= ' ' . esc_attr( $section_class );
}
if ( $bg_style ) {
	$section_classes .= ' ' . esc_attr( $bg_style );
}

// Build container classes
$image_container_classes = 'image_text_block_container';
if ( $image_container_class ) {
	$image_container_classes .= ' ' . esc_attr( $image_container_class );
}

$text_container_classes = 'image_image_block_container';
if ( $text_container_class ) {
	$text_container_classes .= ' ' . esc_attr( $text_container_class );
}

?>

<section class="<?php echo esc_attr( $section_classes ); ?>">
	<div class="wrap d_flex align_center justify_space_between">
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
			<?php else : ?>
				<p>Established in 1965 as the first Saudi Engineering Consulting Firm, Saud Consult has been integral to shaping the nation's built environment. Our foundation is built on deep local understanding, navigating the complexities of the Saudi landscape, coupled with advanced international technical expertise.</p>
				<p>We have grown into a multidisciplinary firm with over 2,000 professionals of various disciplines, securing all project requirements single-handedly—a comprehensive approach that ensures seamless delivery and unwavering quality from concept to commissioning. We don't just design structures; we engineer the future of vital sectors like transportation, energy, and urban planning, ensuring sustainability and longevity for the next generation.</p>
			<?php endif; ?>

			<?php if ( $button_text && $button_link ) : ?>
				<div class="image_text_block_button">
					<a class="btn_style btn_transparent but_black" href="<?php echo esc_url( $button_link ); ?>">
						<?php echo esc_html( $button_text ); ?> <span><img src="<?php echo get_template_directory_uri(); ?>/assets/images/buttion-arrow.svg" alt="<?php echo esc_attr( $button_text ); ?>"></span>
					</a>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>

