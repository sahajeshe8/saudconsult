<?php
/**
 * Ready to Partner Section Component Template
 *
 * @package tasheel
 */

// Extract data from args array passed from get_template_part()
$args = isset( $args ) ? $args : array();

// Set default values or use passed values
$background_image = isset( $args['background_image'] ) ? $args['background_image'] : get_template_directory_uri() . '/assets/images/ready-to-partner-one.jpg';
$title = isset( $args['title'] ) ? $args['title'] : 'Ready to Partner';
$subtitle = isset( $args['subtitle'] ) ? $args['subtitle'] : 'on Your Vision?';
$description = isset( $args['description'] ) ? $args['description'] : 'Leverage our five decades of pioneering excellence to ensure the success of your next ambitious venture.';
$button_text = isset( $args['button_text'] ) ? $args['button_text'] : 'Explore More';
$button_link = isset( $args['button_link'] ) ? $args['button_link'] : '#';

?>

<section class="ready_to_partner_section pt_80 pb_80" style="background: url('<?php echo esc_url( $background_image ); ?>') no-repeat center center; background-size: cover;">
	<div class="wrap">
		<?php if ( $title || $subtitle ) : ?>
			<h3 class="h3_title_50 white_txt">
				<?php if ( $title ) : ?>
					<?php echo esc_html( $title ); ?>
				<?php endif; ?>
				<?php if ( $subtitle ) : ?>
					<br><span><?php echo esc_html( $subtitle ); ?></span>
				<?php endif; ?>
			</h3>
		<?php endif; ?>
		
		<?php if ( $description ) : ?>
			<p><?php echo esc_html( $description ); ?></p>
		<?php endif; ?>
		
		<?php if ( $button_text && $button_link ) : ?>
			<a class="btn_style btn_transparent" href="<?php echo esc_url( $button_link ); ?>">
				<?php echo esc_html( $button_text ); ?> <span><img src="<?php echo get_template_directory_uri(); ?>/assets/images/buttion-arrow.svg" alt="<?php echo esc_attr( $button_text ); ?>"></span>
			</a>
		<?php endif; ?>
	</div>
</section>

