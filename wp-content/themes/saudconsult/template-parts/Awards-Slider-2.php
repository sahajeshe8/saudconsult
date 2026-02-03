<?php
/**
 * Awards Slider 2 Component Template
 *
 * Swiper slider for displaying awards and certifications (1 slide per view)
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

<section class="awards_slider_2_section pt_80 pb_80 <?php echo esc_attr( $section_class ); ?>">
	<div class="wrap">
		<?php if ( $title || $title_span ) : ?>
			<div class="awards_slider_2_title_block">
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
			<div class="swiper mySwiper-awards-2">
				<div class="swiper-wrapper">
					<?php foreach ( $awards as $index => $award ) : 
						$image = isset( $award['image'] ) ? $award['image'] : '';
						$alt = isset( $award['alt'] ) ? $award['alt'] : 'Award';
						$title_text = isset( $award['title'] ) ? $award['title'] : '';
						$year = isset( $award['year'] ) ? $award['year'] : '';
						$link = isset( $award['link'] ) ? $award['link'] : '';
					?>
						<div class="swiper-slide">
							<div class="award_item_2">
								<?php if ( $link ) : ?>
									 
										<div class="award_item_2_image">
											<img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $alt ); ?>">
											<a href="<?php echo esc_url( $image ); ?>" class="award_popup_trigger" data-fancybox="award-gallery" data-caption="<?php echo esc_attr( $title_text . ( $year ? ' - ' . $year : '' ) ); ?>" style="display: none;"></a>
											<div class="award_click_overlay" data-award-index="<?php echo esc_attr( $index ); ?>"></div>
										</div>
										<?php if ( $title_text || $year ) : ?>
											<div class="award_item_2_info">
												<?php if ( $title_text ) : ?>
													<h4 class="award_2_title"><?php echo esc_html( $title_text ); ?></h4>
												<?php endif; ?>
												<?php if ( $year ) : ?>
													<span class="award_2_year"><?php echo esc_html( $year ); ?></span>
												<?php endif; ?>
											</div>
										<?php endif; ?>
									 
								<?php else : ?>
									<div class="award_item_2_wrapper">
										<div class="award_item_2_image">
											<img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $alt ); ?>">
											<a href="<?php echo esc_url( $image ); ?>" class="award_popup_trigger" data-fancybox="award-gallery" data-caption="<?php echo esc_attr( $title_text . ( $year ? ' - ' . $year : '' ) ); ?>" style="display: none;"></a>
											<div class="award_click_overlay" data-award-index="<?php echo esc_attr( $index ); ?>"></div>
										</div>
										<?php if ( $title_text || $year ) : ?>
											<div class="award_item_2_info">
												<?php if ( $title_text ) : ?>
													<h4 class="award_2_title"><?php echo esc_html( $title_text ); ?></h4>
												<?php endif; ?>
												<?php if ( $year ) : ?>
													<span class="award_2_year"><?php echo esc_html( $year ); ?></span>
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





