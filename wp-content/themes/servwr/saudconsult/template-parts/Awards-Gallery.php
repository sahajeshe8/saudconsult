<?php
/**
 * Awards Gallery: thumb + main slider. Used by ACF flexible layout awards_gallery.
 * WPML: translate title, description, heading and content per language.
 *
 * @package tasheel
 */

$args = isset( $args ) ? $args : array();

$title         = isset( $args['title'] ) ? $args['title'] : esc_html__( 'Awards', 'tasheel' );
$description   = isset( $args['description'] ) ? $args['description'] : '';
$slides        = isset( $args['slides'] ) && is_array( $args['slides'] ) ? $args['slides'] : array();

$placeholder_img = get_template_directory_uri() . '/assets/images/award-slider-img.jpg';
$arrow_img       = get_template_directory_uri() . '/assets/images/slider-arrow.svg';
$fallback_thumbs = array(
	get_template_directory_uri() . '/assets/images/aw-01.jpg',
	get_template_directory_uri() . '/assets/images/aw-02.jpg',
	get_template_directory_uri() . '/assets/images/aw-03.jpg',
	get_template_directory_uri() . '/assets/images/aw-01.jpg',
);

if ( empty( $slides ) ) {
	$slides = array();
	foreach ( $fallback_thumbs as $fallback_thumb ) {
		$slides[] = array(
			'thumbnail_image' => $fallback_thumb,
			'image'           => $placeholder_img,
			'heading'         => $title,
			'content'         => $description,
		);
	}
}
?>

<section style="background: #f5f9ee;" class="pt_80 pb_80 awards-gallery-section">
	<div class="wrap d_flex_wrap justify-content-between-02">
		<div class="award_slider_block_01">
			<div class="w_100 d_flex_wrap mb_auto">
				<?php if ( $title ) : ?>
					<h3 class="h3_title_50"><?php echo esc_html( $title ); ?></h3>
				<?php endif; ?>
				<?php if ( $description ) : ?>
					<p><?php echo wp_kses_post( $description ); ?></p>
				<?php endif; ?>
			</div>
			<div class="w_100 d_flex_wrap mt_auto justify-content-between award-row-02">
				<div class="slider-block-01">
					<div class="swiper mySwiper-01">
						<div class="swiper-wrapper">
							<?php
							foreach ( $slides as $slide ) :
								$thumb = isset( $slide['thumbnail_image'] ) ? $slide['thumbnail_image'] : '';
								if ( ! $thumb ) {
									$thumb = isset( $slide['image'] ) ? $slide['image'] : '';
								}
								if ( is_array( $thumb ) && isset( $thumb['url'] ) ) {
									$thumb = $thumb['url'];
								}
								$thumb = $thumb ? $thumb : $placeholder_img;
							?>
								<div class="swiper-slide"><img src="<?php echo esc_url( $thumb ); ?>" alt="<?php echo esc_attr( $title ); ?>"></div>
							<?php endforeach; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="slider-block-03">
			<div class="slider_arrow_block">
				<span class="slider_buttion but_prev-aw icon-rotate-01" tabindex="0" role="button" aria-label="<?php esc_attr_e( 'Previous slide', 'tasheel' ); ?>">
					<img src="<?php echo esc_url( $arrow_img ); ?>" alt="<?php esc_attr_e( 'Previous Project', 'tasheel' ); ?>">
				</span>
				<span class="slider_buttion but_next-aw icon-rotate-02" tabindex="0" role="button" aria-label="<?php esc_attr_e( 'Next slide', 'tasheel' ); ?>">
					<img src="<?php echo esc_url( $arrow_img ); ?>" alt="<?php esc_attr_e( 'Next Project', 'tasheel' ); ?>">
				</span>
			</div>
			<div class="swiper mySwiper-03">
				<div class="swiper-wrapper">
					<?php foreach ( $slides as $slide ) :
						$img = isset( $slide['image'] ) ? $slide['image'] : '';
						if ( ! $img && isset( $slide['thumbnail_image'] ) ) {
							$img = $slide['thumbnail_image'];
						}
						if ( is_array( $img ) && isset( $img['url'] ) ) {
							$img = $img['url'];
						}
						$img      = $img ? $img : $placeholder_img;
						$heading  = isset( $slide['heading'] ) ? $slide['heading'] : '';
						$content  = isset( $slide['content'] ) ? $slide['content'] : '';
					?>
						<div class="swiper-slide d_flex_wrap justify-content-between-02">
							<div class="swiper-slide-inner-img">
								<img src="<?php echo esc_url( $img ); ?>" alt="<?php echo esc_attr( $heading ? $heading : $title ); ?>">
							</div>
							<div class="swiper-slide-inner-txt">
								<div class="swiper-slide-inner-txt-content">
									<?php if ( $heading ) : ?>
										<h6><?php echo esc_html( $heading ); ?></h6>
									<?php endif; ?>
									<?php if ( $content ) : ?>
										<?php echo wp_kses_post( $content ); ?>
									<?php endif; ?>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
</section>
