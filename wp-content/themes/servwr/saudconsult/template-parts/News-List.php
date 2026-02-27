<?php
/**
 * News List Component Template
 *
 * News list section for Media Center page
 *
 * @package tasheel
 */

// Extract data from args array passed from get_template_part() (WP 5.5+ or set_query_var).
$args = isset( $args ) && is_array( $args ) ? $args : (array) get_query_var( 'args', array() );

// Set default values or use passed values
$title = isset( $args['title'] ) ? $args['title'] : '';
$title_span = isset( $args['title_span'] ) ? $args['title_span'] : '';

// Handle section wrapper classes - can be array or string
$section_wrapper_class = isset( $args['section_wrapper_class'] ) ? $args['section_wrapper_class'] : array();
if ( is_array( $section_wrapper_class ) ) {
	$section_wrapper_class = ! empty( $section_wrapper_class ) ? implode( ' ', array_map( 'esc_attr', $section_wrapper_class ) ) : '';
} else {
	$section_wrapper_class = esc_attr( $section_wrapper_class );
}

$section_class = isset( $args['section_class'] ) ? $args['section_class'] : '';

// Dynamic news items from CPT (when passed from media center or listing).
$news_items = isset( $args['news_items'] ) && is_array( $args['news_items'] ) ? $args['news_items'] : array();
$show_empty_message = ! empty( $args['show_empty_message'] );

// Get news listing page URL (for "View all" link).
$news_page = get_page_by_path( 'news' );
$news_url = $news_page ? get_permalink( $news_page->ID ) : home_url( '/news' );
if ( post_type_exists( 'news' ) && get_option( 'permalink_structure' ) ) {
	$news_url = get_post_type_archive_link( 'news' );
	if ( ! $news_url ) {
		$news_url = $news_page ? get_permalink( $news_page->ID ) : home_url( '/news' );
	}
}
?>

<section class="news_list_section">
		<div class="news_list_wrapper">
            <div class="wrap">
			<?php if ( $title || $title_span ) : ?>
				<div class="title_block">
					<div class="title_block_left">
						<h3 class="h3_title_50"><?php echo esc_html( $title ? $title : __( 'News', 'tasheel' ) ); ?></h3>
					</div>
					<div class="title_block_right">
						<a class="btn_style btn_transparent but_black" href="<?php echo esc_url( $news_url ); ?>">
							<?php echo esc_html__( 'View all', 'tasheel' ); ?>
							<span><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/buttion-arrow.svg' ); ?>" alt="<?php echo esc_attr__( 'View All News', 'tasheel' ); ?>"></span>
						</a>
					</div>
				</div>
            </div>
			<?php endif; ?>

			<div class="news_list_content pt_30">
				<div class="swiper news_list_swiper">
					<div class="swiper-wrapper">
						<?php if ( ! empty( $news_items ) ) : ?>
							<?php foreach ( $news_items as $item ) :
								$item_title = isset( $item['title'] ) ? $item['title'] : '';
								$item_link   = isset( $item['link'] ) ? esc_url( $item['link'] ) : '#';
								$item_img_d  = isset( $item['image_desktop'] ) ? $item['image_desktop'] : ( isset( $item['image'] ) ? $item['image'] : get_template_directory_uri() . '/assets/images/news-img-01.jpg' );
								$item_img_m  = isset( $item['image_mobile'] ) ? $item['image_mobile'] : $item_img_d;
								$item_date   = isset( $item['date_label'] ) ? $item['date_label'] : '';
								$item_cat    = isset( $item['category_label'] ) ? $item['category_label'] : esc_html__( 'Latest News', 'tasheel' );
							?>
								<div class="swiper-slide">
									<div class="insights_item">
										<div class="insights_item_text">
											<span class="latest_news_text_lable_new"><?php echo esc_html( $item_cat ); ?></span>
											<a href="<?php echo $item_link; ?>">
												<h5><?php echo esc_html( $item_title ); ?></h5>
											</a>
											<span class="latest_news_text_date_new"><?php echo esc_html( $item_date ); ?></span>
										</div>
										<div class="insights_item_image">
											<a href="<?php echo $item_link; ?>">
												<?php
												if ( function_exists( 'tasheel_listing_image_picture' ) ) {
													tasheel_listing_image_picture( $item_img_d, $item_img_m, $item_title );
												} else {
													echo '<img src="' . esc_url( $item_img_d ) . '" alt="' . esc_attr( $item_title ) . '">';
												}
												?>
											</a>
										</div>
									</div>
								</div>
							<?php endforeach; ?>
						<?php elseif ( $show_empty_message ) : ?>
							<div class="swiper-slide">
								<div class="insights_item insights_item_empty">
									<p class="news_list_empty_message"><?php echo esc_html__( 'No news at the moment. Please check back later.', 'tasheel' ); ?></p>
								</div>
							</div>
						<?php else : ?>
							<!-- Fallback static slide when no news items (legacy) -->
							<div class="swiper-slide">
								<div class="insights_item">
									<div class="insights_item_text">
										<span class="latest_news_text_lable_new"><?php echo esc_html__( 'Latest News', 'tasheel' ); ?></span>
										<a href="<?php echo esc_url( $news_url ); ?>">
											<h5><?php echo esc_html__( 'Saud Consult Secures Design Contract for Jeddah\'s New Central Utility Plant.', 'tasheel' ); ?></h5>
										</a>
										<span class="latest_news_text_date_new">05 August 2025</span>
									</div>
									<div class="insights_item_image">
										<a href="<?php echo esc_url( $news_url ); ?>">
											<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/news-img-01.jpg' ); ?>" alt="<?php echo esc_attr__( 'News', 'tasheel' ); ?>">
										</a>
									</div>
								</div>
							</div>
						<?php endif; ?>
					</div>
				</div>
				<div class="slider_arrow_block pb_0 news-navigation-position position-unset">
					<span class="slider_buttion but_next news_list_but_next">
						<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/slider-arrow.svg' ); ?>" alt="<?php echo esc_attr__( 'Next News', 'tasheel' ); ?>">
					</span>
					<span class="slider_buttion but_prev news_list_but_prev">
						<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/slider-arrow.svg' ); ?>" alt="<?php echo esc_attr__( 'Previous News', 'tasheel' ); ?>">
					</span>
				</div>
			</div>
			<div class="news_list_pagination"></div>
		</div>
</section>
