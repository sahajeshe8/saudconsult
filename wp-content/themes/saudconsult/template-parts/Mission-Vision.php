<?php
/**
 * Mission & Vision Section Component Template
 *
 * @package tasheel
 */

// Extract data from args array passed from get_template_part()
$args = isset( $args ) ? $args : array();

// Set default values or use passed values
$vision_title = isset( $args['vision_title'] ) ? $args['vision_title'] : 'Our Vision';
$vision_title_span = isset( $args['vision_title_span'] ) ? $args['vision_title_span'] : '';
$vision_content = isset( $args['vision_content'] ) ? $args['vision_content'] : 'To be the leading engineering consultancy firm in Saudi Arabia, recognized for excellence, innovation, and sustainable solutions that shape the future of the built environment.';
$vision_icon = isset( $args['vision_icon'] ) ? $args['vision_icon'] : '';

$mission_title = isset( $args['mission_title'] ) ? $args['mission_title'] : 'Our Mission';
$mission_title_span = isset( $args['mission_title_span'] ) ? $args['mission_title_span'] : '';
$mission_content = isset( $args['mission_content'] ) ? $args['mission_content'] : 'To deliver exceptional engineering solutions through integrated multidisciplinary expertise, ensuring quality, sustainability, and value for our clients while contributing to the Kingdom\'s development and growth.';
$mission_icon = isset( $args['mission_icon'] ) ? $args['mission_icon'] : '';

$section_class = isset( $args['section_class'] ) ? $args['section_class'] : '';

?>

<section class="mission_vision_section pt_80 pb_80 <?php echo esc_attr( $section_class ); ?>">
	<div class="wrap">
		<div class="mission_vision_container">
			<?php if ( $vision_title || $vision_content ) : ?>
				<div class="mission_vision_item mission_vision_vision" data-aos="fade-up" data-aos-duration="800" data-aos-delay="0">
					<?php if ( $vision_icon ) : ?>
						<div class="mission_vision_icon">
							<img src="<?php echo esc_url( $vision_icon ); ?>" alt="<?php echo esc_attr( $vision_title ); ?>">
						</div>
					<?php endif; ?>
					
					<?php if ( $vision_title || $vision_title_span ) : ?>
						<h3 class="h4_title_35 ">
							<?php if ( $vision_title ) : ?>
								<?php echo wp_kses_post( $vision_title ); ?>
							<?php endif; ?>
							<?php if ( $vision_title_span ) : ?>
								<span><?php echo wp_kses_post( $vision_title_span ); ?></span>
							<?php endif; ?>
						</h3>
					<?php endif; ?>
					
					<?php if ( $vision_content ) : ?>
						<div class="mission_vision_content">
							<?php echo wp_kses_post( $vision_content ); ?>
						</div>
					<?php endif; ?>
				</div>
			<?php endif; ?>

			<?php if ( $mission_title || $mission_content ) : ?>
				<div class="mission_vision_item mission_vision_mission" data-aos="fade-up" data-aos-duration="800" data-aos-delay="100">
					<?php if ( $mission_icon ) : ?>
						<div class="mission_vision_icon">
							<img src="<?php echo esc_url( $mission_icon ); ?>" alt="<?php echo esc_attr( $mission_title ); ?>">
						</div>
					<?php endif; ?>
					
					<?php if ( $mission_title || $mission_title_span ) : ?>
						<h3 class="h4_title_35">
							<?php if ( $mission_title ) : ?>
								<?php echo wp_kses_post( $mission_title ); ?>
							<?php endif; ?>
							<?php if ( $mission_title_span ) : ?>
								<span><?php echo wp_kses_post( $mission_title_span ); ?></span>
							<?php endif; ?>
						</h3>
					<?php endif; ?>
					
					<?php if ( $mission_content ) : ?>
						<div class="mission_vision_content">
							<?php echo wp_kses_post( $mission_content ); ?>
						</div>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>

