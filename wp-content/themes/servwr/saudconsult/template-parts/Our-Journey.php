<?php
/**
 * Our Journey Section Component Template
 *
 * @package tasheel
 */

$args       = isset( $args ) ? $args : array();
$title      = isset( $args['title'] ) ? $args['title'] : 'Our Journey &';
$title_span = isset( $args['title_span'] ) ? $args['title_span'] : 'Legacy';
$description = isset( $args['description'] ) ? $args['description'] : '';
$journey_items = isset( $args['journey_items'] ) && is_array( $args['journey_items'] ) ? $args['journey_items'] : array();

if ( empty( $journey_items ) ) {
	return;
}
?>

<section class="our_journey_section pt_120 pb_120 bg-style-2">
	<div class="wrap">

		<div class="p-relative d_flex_wrap align-items-center justify-content-between align_end" data-aos="fade-up" data-aos-duration="800" data-aos-delay="0">
			<h3 class="h3_title_50"><?php echo esc_html( $title ); ?> <br><span><?php echo esc_html( $title_span ); ?></span></h3>
			<div class="slider_arrow_block pb_0" data-aos="fade-up" data-aos-duration="800" data-aos-delay="100">
				<span class="slider_buttion but_next news_but_next but_black">
					<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/slider-arrow.svg' ); ?>" alt="<?php esc_attr_e( 'Next', 'tasheel' ); ?>">
				</span>
				<span class="slider_buttion but_prev news_but_prev but_black">
					<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/slider-arrow.svg' ); ?>" alt="<?php esc_attr_e( 'Previous', 'tasheel' ); ?>">
				</span>
			</div>
		</div>

		<div class="our_journey_gallery_wrapper" data-aos="fade-up" data-aos-duration="800" data-aos-delay="200">

			<div class="swiper our_journey_thumb_swiper">
				<div class="swiper-wrapper">
					<?php foreach ( $journey_items as $item ) : ?>
						<div class="swiper-slide">
							<span class="dot-icn"></span>
							<?php echo esc_html( isset( $item['year'] ) ? $item['year'] : '' ); ?>
						</div>
					<?php endforeach; ?>
				</div>
			</div>

			<div class="swiper our_journey_main_swiper">
				<div class="swiper-wrapper">
					<?php foreach ( $journey_items as $item ) :
						$img = isset( $item['image'] ) ? $item['image'] : '';
						$img_url = $img ? esc_url( $img ) : get_template_directory_uri() . '/assets/images/jurny-01.jpg';
						$year_label = isset( $item['year_range_label'] ) ? $item['year_range_label'] : '';
						$item_title = isset( $item['title'] ) ? $item['title'] : '';
						$item_content = isset( $item['content'] ) ? $item['content'] : '';
					?>
						<div class="swiper-slide">
							<div class="d_flex_wrap align-items-center justify-content-between">
								<div class="our_journey_item_image">
									<img src="<?php echo $img_url; ?>" alt="<?php echo esc_attr( $item_title ?: __( 'Gallery Image', 'tasheel' ) ); ?>">
								</div>
								<div class="our_journey_content_block">
									<?php if ( $year_label ) : ?>
										<div class="our_journey_main_swiper_item_content_year">
											<p><?php echo esc_html( $year_label ); ?></p>
										</div>
									<?php endif; ?>
									<div class="our_journey_main_swiper_item_content">
										<?php if ( $item_title ) : ?>
											<h4><?php echo esc_html( $item_title ); ?></h4>
										<?php endif; ?>
										<?php if ( $item_content ) : ?>
											<?php echo wp_kses_post( $item_content ); ?>
										<?php endif; ?>
									</div>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>

		</div>
	</div>
</section>
