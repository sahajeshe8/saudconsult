<?php
/**
 * Timeline Component Template
 * Supports dynamic intro_text and timeline_items from ACF. WPML-ready.
 *
 * @package tasheel
 */

$args = isset( $args ) ? $args : array();

$section_class  = isset( $args['section_class'] ) ? $args['section_class'] : '';
$intro_text     = isset( $args['intro_text'] ) ? $args['intro_text'] : '';
$timeline_items = isset( $args['timeline_items'] ) && is_array( $args['timeline_items'] ) ? $args['timeline_items'] : array();

$default_intro = esc_html__( 'Discover the key milestones that shaped our legacy as Saudi Arabia\'s first engineering consulting firm.', 'tasheel' );
$intro_display = $intro_text ? $intro_text : $default_intro;

$default_images = array(
	get_template_directory_uri() . '/assets/images/timeline-img-01.jpg',
	get_template_directory_uri() . '/assets/images/timeline-img-02.jpg',
	get_template_directory_uri() . '/assets/images/timeline-img-03.jpg',
	get_template_directory_uri() . '/assets/images/timeline-img-04.jpg',
	get_template_directory_uri() . '/assets/images/timeline-img-05.jpg',
	get_template_directory_uri() . '/assets/images/timeline-img-06.jpg',
);

$items_per_page = 3;
$total_timeline_items = ! empty( $timeline_items ) ? count( $timeline_items ) : 7;
$show_load_more = $total_timeline_items > $items_per_page;
?>

<section class="timeline_section pt_80 pb_80 <?php echo esc_attr( $section_class ); ?>">
	<div class="wrap">
		<div class="timeline_row_01">
			<p><?php echo wp_kses_post( $intro_display ); ?></p>
		</div>

		<div class="timeline_row_02">
			<span class="timeline-line"></span>
			<ul class="tileline_ul">
				<?php
				if ( ! empty( $timeline_items ) ) :
					$delay = 0;
					foreach ( $timeline_items as $item ) :
						$img   = isset( $item['image'] ) ? $item['image'] : $default_images[ $delay % count( $default_images ) ];
						$year  = isset( $item['year'] ) ? $item['year'] : '';
						$title = isset( $item['title'] ) ? $item['title'] : '';
						$content = isset( $item['content'] ) ? $item['content'] : '';
						$alt   = $title ? $title : esc_attr__( 'Timeline Image', 'tasheel' );
				?>
				<li>
					<div class="timeline_item_img" data-aos="fade-up" data-aos-delay="<?php echo esc_attr( $delay ); ?>">
						<img src="<?php echo esc_url( $img ); ?>" alt="<?php echo esc_attr( $alt ); ?>">
					</div>
					<div class="timeline_item_content" data-aos="fade-up" data-aos-delay="<?php echo esc_attr( $delay + 100 ); ?>">
						<?php if ( $year ) : ?>
							<span class="timeline_item_content_year"><?php echo esc_html( $year ); ?><span class="timeline-dot"></span></span>
						<?php endif; ?>
						<?php if ( $title ) : ?>
							<h4><?php echo esc_html( $title ); ?></h4>
						<?php endif; ?>
						<?php if ( $content ) : ?>
							<p><?php echo wp_kses_post( $content ); ?></p>
						<?php endif; ?>
					</div>
				</li>
				<?php
						$delay += 100;
					endforeach;
				else :
					// Static fallback when no ACF items.
					foreach ( array( '1965', '1965', '1965', '1965', '1965', '1965', '1965' ) as $i => $y ) :
						$img = $default_images[ $i % count( $default_images ) ];
				?>
				<li>
					<div class="timeline_item_img" data-aos="fade-up" data-aos-delay="0">
						<img src="<?php echo esc_url( $img ); ?>" alt="<?php esc_attr_e( 'Timeline Image', 'tasheel' ); ?>">
					</div>
					<div class="timeline_item_content" data-aos="fade-up" data-aos-delay="100">
						<span class="timeline_item_content_year"><?php echo esc_html( $y ); ?><span class="timeline-dot"></span></span>
						<h4><?php esc_html_e( 'Founding of Saud Consult', 'tasheel' ); ?></h4>
						<p><?php esc_html_e( "Established as the first Saudi Engineering Consulting Firm to participate in the nation's massive countrywide infrastructure projects. This marks our commitment to national development.", 'tasheel' ); ?></p>
					</div>
				</li>
				<?php
					endforeach;
				endif;
				?>
			</ul>
		</div>

		<?php if ( $show_load_more ) : ?>
		<div class="w_100 text-center mt_100">
			<button type="button" class="btn_style btn_transparent btn_green timeline-load-more">
				<?php esc_html_e( 'Load more', 'tasheel' ); ?>
			</button>
		</div>
		<?php endif; ?>
	</div>
</section>
