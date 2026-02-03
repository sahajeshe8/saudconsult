<?php
/**
 * Why Partner Section Component Template
 *
 * @package tasheel
 */

// Extract data from args array passed from get_template_part()
$args = isset( $args ) ? $args : array();

// Set default values or use passed values
$title = isset( $args['title'] ) ? $args['title'] : 'Why Partner with';
$title_span = isset( $args['title_span'] ) ? $args['title_span'] : 'Saud Consult for Infrastructure?';

// Handle section wrapper classes - can be array or string
$section_wrapper_class = isset( $args['section_wrapper_class'] ) ? $args['section_wrapper_class'] : array();
if ( is_array( $section_wrapper_class ) ) {
	$section_wrapper_class = ! empty( $section_wrapper_class ) ? implode( ' ', array_map( 'esc_attr', $section_wrapper_class ) ) : '';
} else {
	$section_wrapper_class = esc_attr( $section_wrapper_class );
}

$section_class = isset( $args['section_class'] ) ? $args['section_class'] : '';

// Items array - each item should have: icon, title, text
$items = isset( $args['items'] ) ? $args['items'] : array(
	array(
		'icon' => get_template_directory_uri() . '/assets/images/why-ic-01.svg',
		'icon_alt' => 'Integrated Service',
		'title' => '',
		'text' => 'Our integrated service model (Design, Supervision, Management) eliminates coordination gaps and ensures superior quality.'
	),
	array(
		'icon' => get_template_directory_uri() . '/assets/images/why-ic-02.svg',
		'icon_alt' => 'Integrated Service',
		'title' => '',
		'text' => 'Our integrated service model (Design, Supervision, Management) eliminates coordination gaps and ensures superior quality.'
	),
	array(
		'icon' => get_template_directory_uri() . '/assets/images/why-ic-03.svg',
		'icon_alt' => 'Integrated Service',
		'title' => '',
		'text' => 'Our integrated service model (Design, Supervision, Management) eliminates coordination gaps and ensures superior quality.'
	),
	array(
		'icon' => get_template_directory_uri() . '/assets/images/why-ic-04.svg',
		'icon_alt' => 'Integrated Service',
		'title' => '',
		'text' => 'Our integrated service model (Design, Supervision, Management) eliminates coordination gaps and ensures superior quality.'
	)
);

?>

<section class="why_partner_section pb_80 <?php echo esc_attr( $section_class ); ?> <?php echo $section_wrapper_class; ?>">
	<div class="wrap d_flex align_center justify_space_between align_top_tab">
		<div class="w_50" data-aos="fade-up" data-aos-duration="800" data-aos-delay="0">
			<?php if ( $title || $title_span ) : ?>
				<h3 class="h3_title_50">
					<?php if ( $title ) : ?>
						<?php echo esc_html( $title ); ?>
					<?php endif; ?>
					<?php if ( $title_span ) : ?>
						<span class="font-light"><?php echo wp_kses_post( $title_span ); ?></span>
					<?php endif; ?>
				</h3>
			<?php endif; ?>
		</div>
		<div class="w_50" data-aos="fade-up" data-aos-duration="800" data-aos-delay="100">
			<?php if ( ! empty( $items ) ) : ?>
				<ul class="why_partner_list">
					<?php 
					$delay = 200;
					foreach ( $items as $item ) : 
						$item_icon = isset( $item['icon'] ) ? $item['icon'] : '';
						$item_icon_alt = isset( $item['icon_alt'] ) ? $item['icon_alt'] : '';
						$item_title = isset( $item['title'] ) ? $item['title'] : '';
						$item_text = isset( $item['text'] ) ? $item['text'] : '';
					?>
						<li class="why_partner_item" data-aos="fade-up" data-aos-duration="800" data-aos-delay="<?php echo esc_attr( $delay ); ?>">
							<?php if ( $item_icon ) : ?>
								<div class="why_partner_icon">
									<img src="<?php echo esc_url( $item_icon ); ?>" alt="<?php echo esc_attr( $item_icon_alt ); ?>">
								</div>
							<?php endif; ?>
							<div class="why_partner_content">
								<?php if ( $item_title ) : ?>
									<h4 class="why_partner_title"><?php echo esc_html( $item_title ); ?></h4>
								<?php endif; ?>
								<?php if ( $item_text ) : ?>
									<p class="why_partner_text"><?php echo wp_kses_post( $item_text ); ?></p>
								<?php endif; ?>
							</div>
						</li>
					<?php 
						$delay += 100;
					endforeach; ?>
				</ul>
			<?php endif; ?>
		</div>
	</div>
</section>

