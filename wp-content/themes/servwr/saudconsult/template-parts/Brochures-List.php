<?php
/**
 * Brochures List Component Template
 *
 * Brochures list section for Media Center page
 *
 * @package tasheel
 */

// Extract data from args array passed from get_template_part() (WP 5.5+ or set_query_var).
$args = isset( $args ) && is_array( $args ) ? $args : (array) get_query_var( 'args', array() );

// Set default values or use passed values
$title = isset( $args['title'] ) ? $args['title'] : '';
$title_span = isset( $args['title_span'] ) ? $args['title_span'] : '';
$show_view_all = isset( $args['show_view_all'] ) ? $args['show_view_all'] : true;

// Handle section wrapper classes - can be array or string
$section_wrapper_class = isset( $args['section_wrapper_class'] ) ? $args['section_wrapper_class'] : array();
if ( is_array( $section_wrapper_class ) ) {
	$section_wrapper_class = ! empty( $section_wrapper_class ) ? implode( ' ', array_map( 'esc_attr', $section_wrapper_class ) ) : '';
} else {
	$section_wrapper_class = esc_attr( $section_wrapper_class );
}

$section_class = isset( $args['section_class'] ) ? $args['section_class'] : '';

// Dynamic brochures from CPT (when passed from media center).
$brochures_items = isset( $args['brochures_items'] ) && is_array( $args['brochures_items'] ) ? $args['brochures_items'] : array();
$show_empty_message = ! empty( $args['show_empty_message'] );
?>

<div class="brochures_list_section <?php echo esc_attr( $section_class ); ?> <?php echo $section_wrapper_class; ?>">
	<div class="brochures_list_wrapper">
		<div class="wrap">
			<?php if ( $title || $title_span ) : ?>
				<div class="title_block">
					<div class="title_block_left">
						<h3 class="h3_title_50">
							<?php if ( $title ) : ?><?php echo esc_html( $title ); ?><?php endif; ?>
							<?php if ( $title_span ) : ?><span><?php echo esc_html( $title_span ); ?></span><?php endif; ?>
						</h3>
					</div>
					<?php if ( $show_view_all ) : ?>
						<div class="title_block_right">
							<a class="btn_style btn_transparent but_black" href="#">
								<?php echo esc_html__( 'View all', 'tasheel' ); ?>
								<span><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/buttion-arrow.svg' ); ?>" alt="<?php echo esc_attr__( 'View All Brochures', 'tasheel' ); ?>"></span>
							</a>
						</div>
					<?php endif; ?>
				</div>
			<?php endif; ?>

			<div class="brochures_list_content">
				<div class="swiper brochures_list_swiper">
					<div class="swiper-wrapper">
						<?php if ( ! empty( $brochures_items ) ) : ?>
							<?php foreach ( $brochures_items as $item ) :
								$item_title   = isset( $item['title'] ) ? $item['title'] : '';
								$item_desc    = isset( $item['description'] ) ? $item['description'] : '';
								$item_image   = isset( $item['image'] ) ? esc_url( $item['image'] ) : get_template_directory_uri() . '/assets/images/brochure-01.jpg';
								$download_url = isset( $item['download_url'] ) ? esc_url( $item['download_url'] ) : '';
							?>
								<div class="swiper-slide">
									<div class="brochures_item">
										<div class="brochures_item_text">
											<h5><?php echo esc_html( $item_title ); ?></h5>
											<?php if ( $item_desc ) : ?><p><?php echo esc_html( $item_desc ); ?></p><?php endif; ?>
											<?php if ( $download_url ) : ?>
												<a href="<?php echo $download_url; ?>" class="brochures_download_link" download target="_blank" rel="noopener noreferrer">
													<span><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/download-icn.svg' ); ?>" alt="<?php echo esc_attr__( 'Download PDF', 'tasheel' ); ?>"></span>
												</a>
											<?php endif; ?>
										</div>
										<div class="brochures_item_image">
											<img src="<?php echo $item_image; ?>" alt="<?php echo esc_attr( $item_title ); ?>">
										</div>
									</div>
								</div>
							<?php endforeach; ?>
						<?php elseif ( $show_empty_message ) : ?>
							<div class="swiper-slide">
								<div class="brochures_item brochures_item_empty">
									<p class="brochures_list_empty_message"><?php echo esc_html__( 'No brochures at the moment. Please check back later.', 'tasheel' ); ?></p>
								</div>
							</div>
						<?php else : ?>
							<div class="swiper-slide">
								<div class="brochures_item">
									<div class="brochures_item_text">
										<h5><?php echo esc_html__( 'Annual Report 2024', 'tasheel' ); ?></h5>
										<p><?php echo esc_html__( 'Saud Consult mobilized a multidisciplinary team to deliver a comprehensive design', 'tasheel' ); ?></p>
										<a href="#" class="brochures_download_link">
											<span><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/download-icn.svg' ); ?>" alt="<?php echo esc_attr__( 'Download PDF', 'tasheel' ); ?>"></span>
										</a>
									</div>
									<div class="brochures_item_image">
										<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/brochure-01.jpg' ); ?>" alt="<?php echo esc_attr__( 'Brochure', 'tasheel' ); ?>">
									</div>
								</div>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
			<div class="brochures_list_pagination"></div>
		</div>
	</div>
</div>
