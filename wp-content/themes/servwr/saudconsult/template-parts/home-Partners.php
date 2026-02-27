<?php
/**
 * Partners Section Component Template
 * Supports ACF data via $args (title, title_span, partners array with logo/name/link).
 *
 * @package tasheel
 */

$args = isset( $args ) ? $args : array();
$title      = isset( $args['title'] ) ? $args['title'] : esc_html__( 'Our Success', 'tasheel' );
$title_span = isset( $args['title_span'] ) ? $args['title_span'] : esc_html__( 'Partners', 'tasheel' );
$partners   = isset( $args['partners'] ) && is_array( $args['partners'] ) ? $args['partners'] : array();

$default_logos = array( 'partner-01.png', 'partner-02.png', 'partner-03.png', 'partner-04.png', 'partner-05.png', 'partner-02.png', 'partner-03.png' );
if ( empty( $partners ) ) {
	foreach ( $default_logos as $i => $img ) {
		$partners[] = array( 'logo' => get_template_directory_uri() . '/assets/images/' . $img, 'name' => 'Partner', 'link' => '#' );
	}
}

?>
<section class="partners_section pt_80 mt_80 pb_80">
	<div class="wrap">
		<?php if ( $title || $title_span ) : ?>
		<h4 class="h4_title_35 pb_30" data-aos="fade-up" data-aos-duration="800" data-aos-delay="0">
			<?php echo esc_html( $title ); ?><?php if ( $title_span ) : ?> <span><?php echo esc_html( $title_span ); ?></span><?php endif; ?>
		</h4>
		<?php endif; ?>
	</div>
	<div class="swiper mySwiper-partners">
		<div class="swiper-wrapper">
			<?php
			$delay = 100;
			foreach ( $partners as $p ) :
				$logo = isset( $p['logo'] ) ? $p['logo'] : get_template_directory_uri() . '/assets/images/partner-01.png';
				$name = isset( $p['name'] ) ? $p['name'] : 'Partner';
				$link = isset( $p['link'] ) ? $p['link'] : '';
			?>
			<div class="swiper-slide" data-aos="fade-up" data-aos-duration="800" data-aos-delay="<?php echo esc_attr( $delay ); ?>">
				<?php if ( $link && '#' !== $link ) : ?>
					<a href="<?php echo esc_url( $link ); ?>" target="_blank" rel="noopener noreferrer"><img src="<?php echo esc_url( $logo ); ?>" alt="<?php echo esc_attr( $name ); ?>"></a>
				<?php else : ?>
					<img src="<?php echo esc_url( $logo ); ?>" alt="<?php echo esc_attr( $name ); ?>">
				<?php endif; ?>
			</div>
			<?php $delay += 50; endforeach; ?>
		</div>
		<div class="swiper-pagination"></div>
	</div>
</section>

