<?php
/**
 * Awards Slider 3 Component Template
 *
 * Swiper slider for displaying awards and certifications (1 slide per view - variant 2)
 *
 * @package tasheel
 */

// Extract data from args array passed from get_template_part()
$args = isset( $args ) ? $args : array();

// Set default values or use passed values
$title = isset( $args['title'] ) ? $args['title'] : 'Our';
$title_span = isset( $args['title_span'] ) ? $args['title_span'] : 'Awards & Certifications';
$awards = isset( $args['awards'] ) ? $args['awards'] : array();
$section_class = isset( $args['section_class'] ) ? $args['section_class'] : '';

?>

<section class="awards_slider_3_section pt_80 pb_80 <?php echo esc_attr( $section_class ); ?>">
	<div class="wrap">
		<?php if ( $title || $title_span ) : ?>
			<div class="awards_slider_3_title_block">
				<h3 class="h3_title_50">
					<?php if ( $title ) : ?>
						<?php echo esc_html( $title ); ?>
					<?php endif; ?>
					<?php if ( $title_span ) : ?>
						<span><?php echo esc_html( $title_span ); ?></span>
					<?php endif; ?>
				</h3>
			</div>
		<?php endif; ?>

		<?php if ( ! empty( $awards ) ) : ?>
			<div class="swiper mySwiper-awards-3">
				<div class="swiper-wrapper">
					<?php foreach ( $awards as $award ) : 
						$image = isset( $award['image'] ) ? $award['image'] : '';
						$alt = isset( $award['alt'] ) ? $award['alt'] : 'Award';
						$title_text = isset( $award['title'] ) ? $award['title'] : '';
						$year = isset( $award['year'] ) ? $award['year'] : '';
						$link = isset( $award['link'] ) ? $award['link'] : '';
					?>
						<div class="swiper-slide">
							<div class="award_item_3">
								<?php if ( $link ) : ?>
									<a href="<?php echo esc_url( $link ); ?>" class="award_item_3_link" data-lightbox="awards-3">
										<div class="award_item_3_image">
											<img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $alt ); ?>">
										</div>
										<?php if ( $title_text || $year ) : ?>
											<div class="award_item_3_info">
												<?php if ( $title_text ) : ?>
													<h4 class="award_3_title"><?php echo esc_html( $title_text ); ?></h4>
												<?php endif; ?>
												<?php if ( $year ) : ?>
													<span class="award_3_year"><?php echo esc_html( $year ); ?></span>
												<?php endif; ?>
											</div>
										<?php endif; ?>
									</a>
								<?php else : ?>
									<div class="award_item_3_wrapper">
										<div class="award_item_3_image">
											<img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $alt ); ?>">
										</div>
										<?php if ( $title_text || $year ) : ?>
											<div class="award_item_3_info">
												<?php if ( $title_text ) : ?>
													<h4 class="award_3_title"><?php echo esc_html( $title_text ); ?></h4>
												<?php endif; ?>
												<?php if ( $year ) : ?>
													<span class="award_3_year"><?php echo esc_html( $year ); ?></span>
												<?php endif; ?>
											</div>
										<?php endif; ?>
									</div>
								<?php endif; ?>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
				<div class="swiper-pagination"></div>
				<div class="swiper-button-next"></div>
				<div class="swiper-button-prev"></div>
			</div>
		<?php endif; ?>
	</div>
</section>




