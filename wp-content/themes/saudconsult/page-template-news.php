<?php
/**
 * Template Name: News
 *
 * The template for displaying the News page
 *
 * @package tasheel
 */

get_header();
?>

<main id="primary" class="site-main">
	<?php 
	$inner_banner_data = array(
		'background_image' => get_template_directory_uri() . '/assets/images/news-banner-01.jpg',
		'title' => 'News',
	);
	get_template_part( 'template-parts/inner-banner', null, $inner_banner_data ); 
	?>

	<?php 
	$breadcrumb_data = array(
		'breadcrumb_items' => array(
			array(
				'url' => esc_url( home_url( '/' ) ),
				'icon' => true
			),
			array(
				'title' => 'Media Center',
				'url' => esc_url( home_url( '/media-center' ) )
			),
			array(
				'title' => 'News',
				'url' => '' // Empty URL makes it active
			)
		),
		'section_wrapper_class' => array(),
		'section_class' => ''
	);
	get_template_part( 'template-parts/Breadcrumb', null, $breadcrumb_data ); 
	?>

	<?php
	// Get news detail page URL
	$news_detail_page = get_page_by_path( 'news-detail' );
	$news_detail_url = $news_detail_page ? get_permalink( $news_detail_page->ID ) : home_url( '/news-detail' );
	?>

	<section class="news_page_section pt_80 pb_80">
		<div class="wrap">
			<div class="title_block mb_20">
				<div class="title_block_left">
					<h3 class="h3_title_50">News</h3>
				</div>
			</div>

			<ul class="news_list_ul" id="news-list">
				<li>
					<div class="insights_item">
						<a href="<?php echo esc_url( $news_detail_url ); ?>" class="insights_item_image_link">
							<div class="insights_item_image">
								<span class="latest_news_lable">05 August 2025</span>
								<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/news-01.jpg' ); ?>" alt="News">
							</div>
						</a>
						<div class="insights_item_content">
							<a href="<?php echo esc_url( $news_detail_url ); ?>"><h4>Saud Consult Secures Design Contract for Jeddah's New Central Utility Plant.</h4></a>
							<span class="latest_news_text_lable">Latest News</span>
						</div>
					</div>
				</li>
				<li>
					<div class="insights_item">
						<a href="<?php echo esc_url( $news_detail_url ); ?>" class="insights_item_image_link">
							<div class="insights_item_image">
								<span class="latest_news_lable">05 August 2025</span>
								<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/news-02.jpg' ); ?>" alt="News">
							</div>
						</a>
						<div class="insights_item_content">
							<a href="<?php echo esc_url( $news_detail_url ); ?>"><h4>Saud Consult Secures Design Contract for Jeddah's New Central Utility Plant.</h4></a>
							<span class="latest_news_text_lable">Latest News</span>
						</div>
					</div>
				</li>
				<li>
					<div class="insights_item">
						<a href="<?php echo esc_url( $news_detail_url ); ?>" class="insights_item_image_link">
							<div class="insights_item_image">
								<span class="latest_news_lable">05 August 2025</span>
								<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/news-03.jpg' ); ?>" alt="News">
							</div>
						</a>
						<div class="insights_item_content">
							<a href="<?php echo esc_url( $news_detail_url ); ?>"><h4>Saud Consult Secures Design Contract for Jeddah's New Central Utility Plant.</h4></a>
							<span class="latest_news_text_lable">Latest News</span>
						</div>
					</div>
				</li>
				<li>
					<div class="insights_item">
						<a href="<?php echo esc_url( $news_detail_url ); ?>" class="insights_item_image_link">
							<div class="insights_item_image">
								<span class="latest_news_lable">05 August 2025</span>
								<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/news-04.jpg' ); ?>" alt="News">
							</div>
						</a>
						<div class="insights_item_content">
							<a href="<?php echo esc_url( $news_detail_url ); ?>"><h4>Saud Consult Secures Design Contract for Jeddah's New Central Utility Plant.</h4></a>
							<span class="latest_news_text_lable">Latest News</span>
						</div>
					</div>
				</li>
				<li>
					<div class="insights_item">
						<a href="<?php echo esc_url( $news_detail_url ); ?>" class="insights_item_image_link">
							<div class="insights_item_image">
								<span class="latest_news_lable">04 August 2025</span>
								<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/news-01.jpg' ); ?>" alt="News">
							</div>
						</a>
						<div class="insights_item_content">
							<a href="<?php echo esc_url( $news_detail_url ); ?>"><h4>Saud Consult Secures Design Contract for Jeddah's New Central Utility Plant.</h4></a>
							<span class="latest_news_text_lable">Latest News</span>
						</div>
					</div>
				</li>
				<li>
					<div class="insights_item">
						<a href="<?php echo esc_url( $news_detail_url ); ?>" class="insights_item_image_link">
							<div class="insights_item_image">
								<span class="latest_news_lable">04 August 2025</span>
								<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/news-02.jpg' ); ?>" alt="News">
							</div>
						</a>
						<div class="insights_item_content">
							<a href="<?php echo esc_url( $news_detail_url ); ?>"><h4>Saud Consult Secures Design Contract for Jeddah's New Central Utility Plant.</h4></a>
							<span class="latest_news_text_lable">Latest News</span>
						</div>
					</div>
				</li>
				<li>
					<div class="insights_item">
						<a href="<?php echo esc_url( $news_detail_url ); ?>" class="insights_item_image_link">
							<div class="insights_item_image">
								<span class="latest_news_lable">04 August 2025</span>
								<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/news-03.jpg' ); ?>" alt="News">
							</div>
						</a>
						<div class="insights_item_content">
							<a href="<?php echo esc_url( $news_detail_url ); ?>"><h4>Saud Consult Secures Design Contract for Jeddah's New Central Utility Plant.</h4></a>
							<span class="latest_news_text_lable">Latest News</span>
						</div>
					</div>
				</li>
				<li>
					<div class="insights_item">
						<a href="<?php echo esc_url( $news_detail_url ); ?>" class="insights_item_image_link">
							<div class="insights_item_image">
								<span class="latest_news_lable">04 August 2025</span>
								<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/news-04.jpg' ); ?>" alt="News">
							</div>
						</a>
						<div class="insights_item_content">
							<a href="<?php echo esc_url( $news_detail_url ); ?>"><h4>Saud Consult Secures Design Contract for Jeddah's New Central Utility Plant.</h4></a>
							<span class="latest_news_text_lable">Latest News</span>
						</div>
					</div>
				</li>
				<li>
					<div class="insights_item">
						<a href="<?php echo esc_url( $news_detail_url ); ?>" class="insights_item_image_link">
							<div class="insights_item_image">
								<span class="latest_news_lable">03 August 2025</span>
								<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/news-01.jpg' ); ?>" alt="News">
							</div>
						</a>
						<div class="insights_item_content">
							<a href="<?php echo esc_url( $news_detail_url ); ?>"><h4>Saud Consult Secures Design Contract for Jeddah's New Central Utility Plant.</h4></a>
							<span class="latest_news_text_lable">Latest News</span>
						</div>
					</div>
				</li>
				<li>
					<div class="insights_item">
						<a href="<?php echo esc_url( $news_detail_url ); ?>" class="insights_item_image_link">
							<div class="insights_item_image">
								<span class="latest_news_lable">03 August 2025</span>
								<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/news-02.jpg' ); ?>" alt="News">
							</div>
						</a>
						<div class="insights_item_content">
							<a href="<?php echo esc_url( $news_detail_url ); ?>"><h4>Saud Consult Secures Design Contract for Jeddah's New Central Utility Plant.</h4></a>
							<span class="latest_news_text_lable">Latest News</span>
						</div>
					</div>
				</li>
				<li>
					<div class="insights_item">
						<a href="<?php echo esc_url( $news_detail_url ); ?>" class="insights_item_image_link">
							<div class="insights_item_image">
								<span class="latest_news_lable">03 August 2025</span>
								<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/news-03.jpg' ); ?>" alt="News">
							</div>
						</a>
						<div class="insights_item_content">
							<a href="<?php echo esc_url( $news_detail_url ); ?>"><h4>Saud Consult Secures Design Contract for Jeddah's New Central Utility Plant.</h4></a>
							<span class="latest_news_text_lable">Latest News</span>
						</div>
					</div>
				</li>
				<li>
					<div class="insights_item">
						<a href="<?php echo esc_url( $news_detail_url ); ?>" class="insights_item_image_link">
							<div class="insights_item_image">
								<span class="latest_news_lable">03 August 2025</span>
								<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/news-04.jpg' ); ?>" alt="News">
							</div>
						</a>
						<div class="insights_item_content">
							<a href="<?php echo esc_url( $news_detail_url ); ?>"><h4>Saud Consult Secures Design Contract for Jeddah's New Central Utility Plant.</h4></a>
							<span class="latest_news_text_lable">Latest News</span>
						</div>
					</div>
				</li>
				<li>
					<div class="insights_item">
						<a href="<?php echo esc_url( $news_detail_url ); ?>" class="insights_item_image_link">
							<div class="insights_item_image">
								<span class="latest_news_lable">02 August 2025</span>
								<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/news-01.jpg' ); ?>" alt="News">
							</div>
						</a>
						<div class="insights_item_content">
							<a href="<?php echo esc_url( $news_detail_url ); ?>"><h4>Saud Consult Secures Design Contract for Jeddah's New Central Utility Plant.</h4></a>
							<span class="latest_news_text_lable">Latest News</span>
						</div>
					</div>
				</li>
				<li>
					<div class="insights_item">
						<a href="<?php echo esc_url( $news_detail_url ); ?>" class="insights_item_image_link">
							<div class="insights_item_image">
								<span class="latest_news_lable">02 August 2025</span>
								<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/news-02.jpg' ); ?>" alt="News">
							</div>
						</a>
						<div class="insights_item_content">
							<a href="<?php echo esc_url( $news_detail_url ); ?>"><h4>Saud Consult Secures Design Contract for Jeddah's New Central Utility Plant.</h4></a>
							<span class="latest_news_text_lable">Latest News</span>
						</div>
					</div>
				</li>
				<li>
					<div class="insights_item">
						<a href="<?php echo esc_url( $news_detail_url ); ?>" class="insights_item_image_link">
							<div class="insights_item_image">
								<span class="latest_news_lable">02 August 2025</span>
								<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/news-03.jpg' ); ?>" alt="News">
							</div>
						</a>
						<div class="insights_item_content">
							<a href="<?php echo esc_url( $news_detail_url ); ?>"><h4>Saud Consult Secures Design Contract for Jeddah's New Central Utility Plant.</h4></a>
							<span class="latest_news_text_lable">Latest News</span>
						</div>
					</div>
				</li>
				<li>
					<div class="insights_item">
						<a href="<?php echo esc_url( $news_detail_url ); ?>" class="insights_item_image_link">
							<div class="insights_item_image">
								<span class="latest_news_lable">02 August 2025</span>
								<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/news-04.jpg' ); ?>" alt="News">
							</div>
						</a>
						<div class="insights_item_content">
							<a href="<?php echo esc_url( $news_detail_url ); ?>"><h4>Saud Consult Secures Design Contract for Jeddah's New Central Utility Plant.</h4></a>
							<span class="latest_news_text_lable">Latest News</span>
						</div>
					</div>
				</li>
				<li class="news_item_hidden">
					<div class="insights_item">
						<a href="<?php echo esc_url( $news_detail_url ); ?>" class="insights_item_image_link">
							<div class="insights_item_image">
								<span class="latest_news_lable">01 August 2025</span>
								<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/news-01.jpg' ); ?>" alt="News">
							</div>
						</a>
						<div class="insights_item_content">
							<a href="<?php echo esc_url( $news_detail_url ); ?>"><h4>Saud Consult Secures Design Contract for Jeddah's New Central Utility Plant.</h4></a>
							<span class="latest_news_text_lable">Latest News</span>
						</div>
					</div>
				</li>
				<li class="news_item_hidden">
					<div class="insights_item">
						<a href="<?php echo esc_url( $news_detail_url ); ?>" class="insights_item_image_link">
							<div class="insights_item_image">
								<span class="latest_news_lable">01 August 2025</span>
								<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/news-02.jpg' ); ?>" alt="News">
							</div>
						</a>
						<div class="insights_item_content">
							<a href="<?php echo esc_url( $news_detail_url ); ?>"><h4>Saud Consult Secures Design Contract for Jeddah's New Central Utility Plant.</h4></a>
							<span class="latest_news_text_lable">Latest News</span>
						</div>
					</div>
				</li>
				<li class="news_item_hidden">
					<div class="insights_item">
						<a href="<?php echo esc_url( $news_detail_url ); ?>" class="insights_item_image_link">
							<div class="insights_item_image">
								<span class="latest_news_lable">01 August 2025</span>
								<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/news-03.jpg' ); ?>" alt="News">
							</div>
						</a>
						<div class="insights_item_content">
							<a href="<?php echo esc_url( $news_detail_url ); ?>"><h4>Saud Consult Secures Design Contract for Jeddah's New Central Utility Plant.</h4></a>
							<span class="latest_news_text_lable">Latest News</span>
						</div>
					</div>
				</li>
				<li class="news_item_hidden">
					<div class="insights_item">
						<a href="<?php echo esc_url( $news_detail_url ); ?>" class="insights_item_image_link">
							<div class="insights_item_image">
								<span class="latest_news_lable">01 August 2025</span>
								<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/news-04.jpg' ); ?>" alt="News">
							</div>
						</a>
						<div class="insights_item_content">
							<a href="<?php echo esc_url( $news_detail_url ); ?>"><h4>Saud Consult Secures Design Contract for Jeddah's New Central Utility Plant.</h4></a>
							<span class="latest_news_text_lable">Latest News</span>
						</div>
					</div>
				</li>
				<li class="news_item_hidden">
					<div class="insights_item">
						<a href="<?php echo esc_url( $news_detail_url ); ?>" class="insights_item_image_link">
							<div class="insights_item_image">
								<span class="latest_news_lable">31 July 2025</span>
								<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/news-01.jpg' ); ?>" alt="News">
							</div>
						</a>
						<div class="insights_item_content">
							<a href="<?php echo esc_url( $news_detail_url ); ?>"><h4>Saud Consult Secures Design Contract for Jeddah's New Central Utility Plant.</h4></a>
							<span class="latest_news_text_lable">Latest News</span>
						</div>
					</div>
				</li>
				<li class="news_item_hidden">
					<div class="insights_item">
						<a href="<?php echo esc_url( $news_detail_url ); ?>" class="insights_item_image_link">
							<div class="insights_item_image">
								<span class="latest_news_lable">31 July 2025</span>
								<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/news-02.jpg' ); ?>" alt="News">
							</div>
						</a>
						<div class="insights_item_content">
							<a href="<?php echo esc_url( $news_detail_url ); ?>"><h4>Saud Consult Secures Design Contract for Jeddah's New Central Utility Plant.</h4></a>
							<span class="latest_news_text_lable">Latest News</span>
						</div>
					</div>
				</li>
				<li class="news_item_hidden">
					<div class="insights_item">
						<a href="<?php echo esc_url( $news_detail_url ); ?>" class="insights_item_image_link">
							<div class="insights_item_image">
								<span class="latest_news_lable">31 July 2025</span>
								<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/news-03.jpg' ); ?>" alt="News">
							</div>
						</a>
						<div class="insights_item_content">
							<a href="<?php echo esc_url( $news_detail_url ); ?>"><h4>Saud Consult Secures Design Contract for Jeddah's New Central Utility Plant.</h4></a>
							<span class="latest_news_text_lable">Latest News</span>
						</div>
					</div>
				</li>
				<li class="news_item_hidden">
					<div class="insights_item">
						<a href="<?php echo esc_url( $news_detail_url ); ?>" class="insights_item_image_link">
							<div class="insights_item_image">
								<span class="latest_news_lable">31 July 2025</span>
								<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/news-04.jpg' ); ?>" alt="News">
							</div>
						</a>
						<div class="insights_item_content">
							<a href="<?php echo esc_url( $news_detail_url ); ?>"><h4>Saud Consult Secures Design Contract for Jeddah's New Central Utility Plant.</h4></a>
							<span class="latest_news_text_lable">Latest News</span>
						</div>
					</div>
				</li>
			</ul>

			<div class="load_more_container" style="text-align: center; margin-top: 40px;">
				<button type="button" class="load_more_btn btn_style but_black" id="load-more-news">
					<span>Load More</span>
				</button>
			</div>


</div>


	</section>

</main><!-- #main -->

<?php
get_footer();

