<?php
/**
 * Core Values Section Component Template
 *
 * @package tasheel
 */

// Extract data from args array passed from get_template_part()
$args = isset( $args ) ? $args : array();

// Defaults
$title       = isset( $args['title'] ) ? $args['title'] : 'Our Core';
$title_span  = isset( $args['title_span'] ) ? $args['title_span'] : 'Values';
$description = isset( $args['description'] ) ? $args['description'] : 'We are guided by principles that ensure integrity, excellence, innovation, and sustainability in every project we deliver.';
$values      = isset( $args['values'] ) ? $args['values'] : array(
	array(
		'icon'  => '',
		'title' => 'Integrity',
		'text'  => 'We act with honesty and transparency, earning trust through responsibility.',
	),
	array(
		'icon'  => '',
		'title' => 'Excellence',
		'text'  => 'We pursue the highest quality in our solutions and client partnerships.',
	),
	array(
		'icon'  => '',
		'title' => 'Innovation',
		'text'  => 'We embrace new ideas and technologies to drive better outcomes.',
	),
	array(
		'icon'  => '',
		'title' => 'Sustainability',
		'text'  => 'We design with long-term resilience and environmental stewardship in mind.',
	),
);

?>

<section class="core_values_section pt_80 pb_80 " style="background:url(<?php echo get_template_directory_uri(); ?>/assets/images/vision-miossion-bg.svg) no-repeat left top;  ">
	<div class="wrap d_flex_wrap">
		<div class="core_values_header pb_40">
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

			<?php if ( $description ) : ?>
				<h5 class="core_values_desc"><?php echo wp_kses_post( $description ); ?></h5>
			<?php endif; ?>
		</div>

		<?php if ( ! empty( $values ) ) : ?>
			<ul class="core_values_list">
				<?php foreach ( $values as $value ) :
					$val_icon       = isset( $value['icon'] ) ? $value['icon'] : '';
					$val_icon_hover = isset( $value['icon_hover'] ) ? $value['icon_hover'] : '';
					$val_title      = isset( $value['title'] ) ? $value['title'] : '';
					$val_title_span = isset( $value['title_span'] ) ? $value['title_span'] : '';
					$val_text       = isset( $value['text'] ) ? $value['text'] : '';
					if ( ! $val_title && ! $val_title_span && ! $val_text && ! $val_icon ) {
						continue;
					}
					?>
					<li class="core_values_card">
						<?php if ( $val_icon ) : ?>
							<div class="core_values_icon">
								<img src="<?php echo esc_url( $val_icon ); ?>" alt="<?php echo esc_attr( $val_title ); ?>" class="core_values_icon_default">
								<?php if ( $val_icon_hover ) : ?>
									<img src="<?php echo esc_url( $val_icon_hover ); ?>" alt="<?php echo esc_attr( $val_title ); ?>" class="core_values_icon_hover">
								<?php endif; ?>
							</div>
						<?php endif; ?>

						<?php if ( $val_title || $val_title_span ) : ?>
							<h4 class="h4_title_30">
								<?php if ( $val_title ) : ?>
									<?php echo esc_html( $val_title ); ?>
								<?php endif; ?>
								<?php if ( $val_title_span ) : ?>
									<span><?php echo esc_html( $val_title_span ); ?></span>
								<?php endif; ?>
							</h4>
						<?php endif; ?>

						<?php if ( $val_text ) : ?>
							<p class="core_values_text"><?php echo wp_kses_post( $val_text ); ?></p>
						<?php endif; ?>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
	</div>
</section>

