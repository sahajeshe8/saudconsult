<?php
/**
 * News List Component Template
 *
 * News list section for Media Center page
 *
 * @package tasheel
 */

// Extract data from args array passed from get_template_part()
$args = isset( $args ) ? $args : array();

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

// Get news detail page URL
$news_detail_page = get_page_by_path( 'news-detail' );
$news_detail_url = $news_detail_page ? get_permalink( $news_detail_page->ID ) : home_url( '/news-detail' );

// Get news listing page URL
$news_page = get_page_by_path( 'news' );
$news_url = $news_page ? get_permalink( $news_page->ID ) : home_url( '/news' );
?>

<section class="news_list_section <?php echo esc_attr( $section_class ); ?> <?php echo $section_wrapper_class; ?>">
	 
		<div class="news_list_wrapper">
            <div class="wrap">
			<?php if ( $title || $title_span ) : ?>
				<div class="title_block">
					<div class="title_block_left">
						<h3 class="h3_title_50">News</h3>
					</div>
					<div class="title_block_right">
						
						<a class="btn_style btn_transparent but_black" href="<?php echo esc_url( $news_url ); ?>">
							View all
							<span><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/buttion-arrow.svg' ); ?>" alt="View All News"></span>
						</a>
					</div>
				</div>
                </div>
			<?php endif; ?>

			<div class="news_list_content pt_30">
				<div class="swiper news_list_swiper">
					<div class="swiper-wrapper">
						<div class="swiper-slide">
							<div class="insights_item">
								<div class="insights_item_text">
									<span class="latest_news_text_lable_new">Latest News</span>
									<a href="<?php echo esc_url( $news_detail_url ); ?>">
										<h5>Saud Consult Secures Design Contract for Jeddah's New Central Utility Plant.</h5>
									</a>
									<span class="latest_news_text_date_new">05 August 2025</span>
								</div>
								<div class="insights_item_image">
									<a href="<?php echo esc_url( $news_detail_url ); ?>">
										<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/news-img-01.jpg' ); ?>" alt="News">
									</a>
								</div>
							</div>
						</div>

						<div class="swiper-slide">
							<div class="insights_item">
								<div class="insights_item_text">
									<span class="latest_news_text_lable_new">Latest News</span>
									<a href="<?php echo esc_url( $news_detail_url ); ?>">
										<h5>Saud Consult Secures Design Contract for Jeddah's New Central Utility Plant.</h5>
									</a>
									<span class="latest_news_text_date_new">05 August 2025</span>
								</div>
								<div class="insights_item_image">
									<a href="<?php echo esc_url( $news_detail_url ); ?>">
										<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/news-img-02.jpg' ); ?>" alt="News">
									</a>
								</div>
							</div>
						</div>

						<div class="swiper-slide">
							<div class="insights_item">
								<div class="insights_item_text">
									<span class="latest_news_text_lable_new">Latest News</span>
									<a href="<?php echo esc_url( $news_detail_url ); ?>">
										<h5>Saud Consult Secures Design Contract for Jeddah's New Central Utility Plant.</h5>
									</a>
									<span class="latest_news_text_date_new">05 August 2025</span>
								</div>
								<div class="insights_item_image">
									<a href="<?php echo esc_url( $news_detail_url ); ?>">
										<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/news-img-03.jpg' ); ?>" alt="News">
									</a>
								</div>
							</div>
						</div>

						<div class="swiper-slide">
							<div class="insights_item">
								<div class="insights_item_text">
									<span class="latest_news_text_lable_new">Latest News</span>
									<a href="<?php echo esc_url( $news_detail_url ); ?>">
										<h5>Saud Consult Secures Design Contract for Jeddah's New Central Utility Plant.</h5>
									</a>
									<span class="latest_news_text_date_new">05 August 2025</span>
								</div>
								<div class="insights_item_image">
									<a href="<?php echo esc_url( $news_detail_url ); ?>">
										<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/news-img-04.jpg' ); ?>" alt="News">
									</a>
								</div>
							</div>
						</div>



                        <div class="swiper-slide">
							<div class="insights_item">
								<div class="insights_item_text">
									<span class="latest_news_text_lable_new">Latest News</span>
									<a href="<?php echo esc_url( $news_detail_url ); ?>">
										<h5>Saud Consult Secures Design Contract for Jeddah's New Central Utility Plant.</h5>
									</a>
									<span class="latest_news_text_date_new">05 August 2025</span>
								</div>
								<div class="insights_item_image">
									<a href="<?php echo esc_url( $news_detail_url ); ?>">
										<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/news-img-05.jpg' ); ?>" alt="News">
									</a>
								</div>
							</div>
						</div>





                        <div class="swiper-slide">
							<div class="insights_item">
								<div class="insights_item_text">
									<span class="latest_news_text_lable_new">Latest News</span>
									<a href="<?php echo esc_url( $news_detail_url ); ?>">
										<h5>Saud Consult Secures Design Contract for Jeddah's New Central Utility Plant.</h5>
									</a>
									<span class="latest_news_text_date_new">05 August 2025</span>
								</div>
								<div class="insights_item_image">
									<a href="<?php echo esc_url( $news_detail_url ); ?>">
										<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/news-img-06.jpg' ); ?>" alt="News">
									</a>
								</div>
							</div>
						</div>











					</div>
				</div>


                <div class="slider_arrow_block pb_0 news-navigation-position">
							<span class="slider_buttion but_next news_list_but_next">
								<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/slider-arrow.svg' ); ?>" alt="Next News">
							</span>
							<span class="slider_buttion but_prev news_list_but_prev">
								<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/slider-arrow.svg' ); ?>" alt="Previous News">
							</span>
						</div>
			</div>

			<div class="news_list_pagination">
				<!-- Pagination will be added here -->
			</div>
		</div>
	 
</section>
