<?php
/**
 * Services Section Component Template
 * Supports ACF data via $args (label, title, description, services array).
 *
 * @package tasheel
 */

$args = isset( $args ) ? $args : array();
$label       = isset( $args['label'] ) ? $args['label'] : esc_html__( 'Our Comprehensive Services', 'tasheel' );
$title       = isset( $args['title'] ) ? $args['title'] : esc_html__( 'Explore Our Full Range', 'tasheel' );
$title_span  = isset( $args['title_span'] ) ? trim( (string) $args['title_span'] ) : '';
if ( $title_span === '' ) {
	$title_span = esc_html__( 'Professional Services', 'tasheel' );
}
$description = isset( $args['description'] ) ? $args['description'] : esc_html__( 'Our multidisciplinary team is structured to deliver integrated solutions across the following critical sectors,', 'tasheel' ) . ' <b>' . esc_html__( 'ensuring innovation and efficiency in every design.', 'tasheel' ) . '</b>';
$services    = isset( $args['services'] ) && is_array( $args['services'] ) ? $args['services'] : array();

$default_services = array(
	array( 'title' => 'Engineering<br>Design', 'subtitle' => 'Innovative Solutions', 'description' => 'Translating vision into robust, buildable plans, including architectural, structural.', 'button_link' => home_url( '/engineering-design' ) ),
	array( 'title' => 'Construction<br>Supervision', 'subtitle' => 'Quality Assurance', 'description' => 'Providing on-site assurance and quality management to ensure execution..', 'button_link' => home_url( '/engineering-design' ) ),
	array( 'title' => 'Project<br>Management', 'subtitle' => 'On-Time Delivery', 'description' => 'Offering end-to-end management consultancy (PMC) to control scope.', 'button_link' => home_url( '/engineering-design' ) ),
	array( 'title' => 'Specialized<br>Studies', 'subtitle' => 'Innovative Solutions', 'description' => 'Conducting essential pre-design work, including feasibility studies..', 'button_link' => home_url( '/engineering-design' ) ),
);
if ( empty( $services ) ) {
	$services = $default_services;
}

?>
<section class="services_section pt_80">
	<div class="wrap">
		<?php if ( $label ) : ?>
		<span class="lable_text green_text " data-aos="fade-up" data-aos-duration="800" data-aos-delay="0">
			<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/dot-02.svg" alt="<?php echo esc_attr( $label ); ?>">
			<?php echo esc_html( $label ); ?>
		</span>
		<?php endif; ?>

		<div class="services_section_01 pb_25">
			<div class="services_section_01_item_01 " data-aos="fade-up" data-aos-duration="800" data-aos-delay="100">
				<h3 class="h3_title_50">
					<?php echo wp_kses_post( $title ); ?><span> <?php echo wp_kses_post( $title_span ); ?></span>
				</h3>
			</div>
			<?php if ( $description ) : ?>
			<div class="services_section_01_item_02 pt_10" data-aos="fade-up" data-aos-duration="800" data-aos-delay="200">
				<p><?php echo wp_kses_post( $description ); ?></p>
			</div>
			<?php endif; ?>
		</div>
	</div>

	<div class="swiper mySwiper-services">
		<div class="swiper-wrapper">
			<?php
			$delay = 0;
			$service_images = array( 'service-01.jpg', 'service-02.jpg', 'service-03.jpg', 'service-04.jpg' );
			foreach ( $services as $i => $svc ) :
				$svc_title   = isset( $svc['title'] ) ? $svc['title'] : '';
				$svc_span    = isset( $svc['title_span'] ) ? $svc['title_span'] : ( isset( $svc['subtitle'] ) ? $svc['subtitle'] : '' );
				$svc_desc    = isset( $svc['description'] ) ? $svc['description'] : '';
				$svc_btn     = isset( $svc['button_text'] ) ? $svc['button_text'] : esc_html__( 'View more', 'tasheel' );
				$svc_link    = isset( $svc['button_link'] ) ? esc_url( $svc['button_link'] ) : '#';
				$svc_img     = isset( $svc['image'] ) ? $svc['image'] : get_template_directory_uri() . '/assets/images/' . ( $service_images[ $i % 4 ] ?? 'service-01.jpg' );
				$svc_img     = is_string( $svc_img ) ? $svc_img : ( is_array( $svc_img ) && isset( $svc_img['url'] ) ? $svc_img['url'] : '' );
			?>
			<div class="swiper-slide" data-aos="fade-up" data-aos-duration="800" data-aos-delay="<?php echo esc_attr( $delay ); ?>">
				<div class="services_section_item_01_content">
					<?php if ( $svc_title ) : ?><h3 class="h3_title_30"><?php echo wp_kses_post( $svc_title ); ?></h3><?php endif; ?>
					<?php if ( $svc_span ) : ?><h5><?php echo esc_html( $svc_span ); ?></h5><?php endif; ?>
					<?php if ( $svc_desc ) : ?><div class="service-card-desc"><?php echo wp_kses_post( $svc_desc ); ?></div><?php endif; ?>
					<?php if ( $svc_btn && $svc_link ) : ?>
					<a class="btn_style btn_transparent <?php echo strlen( $svc_btn ) < 12 ? 'short' : ''; ?>" href="<?php echo $svc_link; ?>">
						<?php echo esc_html( $svc_btn ); ?> <span><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/arrow-buttion.svg" alt="<?php echo esc_attr( $svc_btn ); ?>"></span>
					</a>
					<?php endif; ?>
				</div>
				<div class="services_section_item_01">
					<img src="<?php echo esc_url( $svc_img ); ?>" alt="<?php echo esc_attr( $svc_title ?: 'Services' ); ?>">
				</div>
			</div>
			<?php $delay += 100; endforeach; ?>
		</div>
		<div class="swiper-pagination"></div>
	</div>
</section>

