<?php
/**
 * About Section Component Template
 * Supports ACF data via $args (label, title, subtitle, description, button_text, button_link, stats).
 *
 * @package tasheel
 */

$args = isset( $args ) ? $args : array();
$label        = isset( $args['label'] ) ? $args['label'] : esc_html__( 'About Us', 'tasheel' );
$title        = isset( $args['title'] ) ? trim( (string) $args['title'] ) : '';
$title_span   = isset( $args['title_span'] ) ? trim( (string) $args['title_span'] ) : '';
$subtitle     = isset( $args['subtitle'] ) ? $args['subtitle'] : esc_html__( 'Established in 1965 as the first Saudi Engineering Consulting Firm,', 'tasheel' );
if ( $title === '' && $title_span === '' ) {
	$title      = esc_html__( "The Kingdom's Pioneer in Engineering.", 'tasheel' );
	$title_span = esc_html__( 'A Legacy of Trust Since 1965.', 'tasheel' );
}
$description  = isset( $args['description'] ) ? $args['description'] : esc_html__( "Saud Consult has been integral to shaping the nation's built environment. Our foundation is built on deep local understanding, navigating the complexities of the Saudi landscape, coupled with advanced international technical expertise.", 'tasheel' );
$button_text  = isset( $args['button_text'] ) ? $args['button_text'] : esc_html__( 'Learn more about us', 'tasheel' );
$button_link  = isset( $args['button_link'] ) ? esc_url( $args['button_link'] ) : esc_url( home_url( '/about' ) );
$stats        = isset( $args['stats'] ) && is_array( $args['stats'] ) ? $args['stats'] : array(
	array( 'value' => '50', 'suffix' => '+ Years', 'label' => esc_html__( 'Pioneering Excellence', 'tasheel' ), 'description' => esc_html__( 'Decades of navigating the market, establishing trust, and delivering landmark projects across the Kingdom.', 'tasheel' ) ),
	array( 'value' => '2000', 'suffix' => '+', 'label' => esc_html__( 'Professionals', 'tasheel' ), 'description' => esc_html__( 'Decades of navigating the market, establishing trust, and delivering landmark projects across the Kingdom.', 'tasheel' ) ),
	array( 'value' => '9', 'suffix' => ' Core', 'label' => esc_html__( 'Sectors', 'tasheel' ), 'description' => esc_html__( 'Decades of navigating the market, establishing trust, and delivering landmark projects across the Kingdom.', 'tasheel' ) ),
	array( 'value' => '2600', 'suffix' => '+', 'label' => esc_html__( 'Projects Completed', 'tasheel' ), 'description' => esc_html__( 'Decades of navigating the market, establishing trust, and delivering landmark projects across the Kingdom.', 'tasheel' ) ),
);

?>
<section class="about_section pt_80 pb_80  ">
	<div class="wrap">
	  <div class="about_section_01">
		 <div class="about_sectioncl_01" data-aos="fade-up" data-aos-duration="800" data-aos-delay="0">
			<span class="lable_text"> <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/banner-dot.svg" alt="<?php echo esc_attr( $label ); ?>"> <?php echo esc_html( $label ); ?></span>
			 <?php if ( $title || $title_span ) : ?><h1><?php echo esc_html( $title ); ?><?php if ( $title_span !== '' ) : ?> <span class="about_title_span"><?php echo esc_html( $title_span ); ?></span><?php endif; ?></h1><?php endif; ?>
		 </div>
		 <div class="about_sectioncl_02" data-aos="fade-up" data-aos-duration="800" data-aos-delay="100">
			 <?php if ( $subtitle ) : ?><h5><?php echo esc_html( $subtitle ); ?></h5><?php endif; ?>
			 <?php if ( $description ) : ?><p><?php echo wp_kses_post( $description ); ?></p><?php endif; ?>
			 <?php if ( $button_text && $button_link ) : ?>
			 <a class="btn_style btn_transparent" href="<?php echo $button_link; ?>">
				<?php echo esc_html( $button_text ); ?> <span><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/buttion-arrow.svg" alt="<?php echo esc_attr( $button_text ); ?>"></span>
			 </a>
			 <?php endif; ?>
		 </div>
	  </div>

	<?php if ( ! empty( $stats ) ) : ?>
	<div class="swiper about_4_cl_swiper">
		<ul class="about_4_cl_blocks home_4_cl_blocks about_4_cl_blocks_swipper swiper-wrapper">
			<?php
			$delay = 200;
			foreach ( $stats as $stat ) :
				$val  = isset( $stat['value'] ) ? $stat['value'] : '0';
				$suf  = isset( $stat['suffix'] ) ? $stat['suffix'] : '';
				$lbl  = isset( $stat['label'] ) ? $stat['label'] : '';
				$desc = isset( $stat['description'] ) ? $stat['description'] : '';
			?>
			<li class="swiper-slide" data-aos="fade-up" data-aos-duration="800" data-aos-delay="<?php echo esc_attr( $delay ); ?>">
				<div class="about_4_cl_blocks_item_01">
					<div class="w_100 text_cl_01">
						<h3 data-count-target="<?php echo esc_attr( $val ); ?>" data-count-suffix="<?php echo esc_attr( $suf ); ?>"><span class="count-number">0</span><span class="count-suffix"><?php echo esc_html( $suf ); ?></span></h3>
						<?php if ( $lbl ) : ?><p><?php echo esc_html( $lbl ); ?></p><?php endif; ?>
					</div>
					<?php if ( $desc ) : ?>
					<div class="about_4_cl_blocks_item_02">
						<p><?php echo esc_html( $desc ); ?></p>
					</div>
					<?php endif; ?>
				</div>
			</li>
			<?php $delay += 100; endforeach; ?>
		</ul>
	</div>
	<?php endif; ?>

	</div>
</section>

