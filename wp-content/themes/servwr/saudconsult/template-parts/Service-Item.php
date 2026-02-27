<?php
/**
 * Service Item Component Template
 *
 * @package tasheel
 */

// Extract data from args array passed from get_template_part()
$args = isset( $args ) ? $args : array();

// Set default values or use passed values
$image = isset( $args['image'] ) ? $args['image'] : get_template_directory_uri() . '/assets/images/service-01.jpg';
$image_alt = isset( $args['image_alt'] ) ? $args['image_alt'] : 'Service';
$title = isset( $args['title'] ) ? $args['title'] : 'Engineering Design';
$subtitle = isset( $args['subtitle'] ) ? $args['subtitle'] : 'Innovative Solutions';
$description = isset( $args['description'] ) ? $args['description'] : 'Translating vision into robust, buildable plans, including architectural, structural.';
$button_text = isset( $args['button_text'] ) ? $args['button_text'] : 'View more';
$button_link = isset( $args['button_link'] ) ? $args['button_link'] : esc_url( home_url( '/contact' ) );
$item_class = isset( $args['item_class'] ) ? $args['item_class'] : '';

?>

<div class="service_item_block <?php echo esc_attr( $item_class ); ?>">
	<div class="service_item_image">
		<img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $image_alt ); ?>">
	</div>
	<div class="service_item_content">

    <div class="service_item_content_01">
		<?php if ( $title ) : ?>
			<h3 class="h3_title_30">
				<?php echo wp_kses_post( $title ); ?>
			</h3>
		<?php endif; ?>
		
		<?php if ( $subtitle ) : ?>
			<h5>
				<?php echo esc_html( $subtitle ); ?>
			</h5>
		<?php endif; ?>
		
		<?php if ( $description ) : ?>
			<p>
				<?php echo wp_kses_post( $description ); ?>
			</p>
		<?php endif; ?>

        </div>
		
		<?php if ( $button_text && $button_link ) : ?>
			<a class="btn_style btn_transparent" href="<?php echo esc_url( $button_link ); ?>">
				<?php echo esc_html( $button_text ); ?> 
				<span>
					<img src="<?php echo get_template_directory_uri(); ?>/assets/images/arrow-buttion.svg" alt="<?php echo esc_attr( $button_text ); ?>">
				</span>
			</a>
		<?php endif; ?>
	</div>
</div>

