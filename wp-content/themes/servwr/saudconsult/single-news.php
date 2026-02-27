<?php
/**
 * Single News (News CPT)
 * WPML-ready strings.
 *
 * @package tasheel
 */
global $header_custom_class;
$header_custom_class = 'black-header';
get_header();

$news_list_url = '';
if ( function_exists( 'tasheel_get_news_listing_breadcrumb' ) ) {
	$news_list_breadcrumb = tasheel_get_news_listing_breadcrumb();
	$news_list_url = $news_list_breadcrumb['url'];
} else {
	$news_list_url = home_url( '/news' );
}
?>

<main id="primary" class="site-main no_banner_section news-detail-page">
	<?php
	while ( have_posts() ) :
		the_post();
		$post_id   = get_the_ID();
		$title    = get_the_title();
		$date     = get_the_date();
		$share_url = get_permalink( $post_id );
		$share_title = $title;
		$imgs = function_exists( 'tasheel_get_detail_images' ) ? tasheel_get_detail_images( $post_id, 'news' ) : array( 'desktop' => get_the_post_thumbnail_url( $post_id, 'full' ), 'mobile' => '' );
		if ( ! $imgs['desktop'] ) {
			$imgs['desktop'] = get_template_directory_uri() . '/assets/images/news-detail-image.jpg';
			$imgs['mobile']  = $imgs['desktop'];
		}
		if ( ! $imgs['mobile'] ) {
			$imgs['mobile'] = $imgs['desktop'];
		}
		$breadcrumb_data = array(
			'breadcrumb_items'       => function_exists( 'tasheel_get_listing_breadcrumb_items' ) ? tasheel_get_listing_breadcrumb_items( 'single_news', array( 'title' => $title ) ) : array(),
			'section_wrapper_class' => array(),
			'section_class'         => '',
		);
		get_template_part( 'template-parts/Breadcrumb', null, $breadcrumb_data );
		?>
		<section class="news_detail_section pt_40 pb_80">
			<div class="wrap">
				<div class="news_detail_container">
					<h1 class="h3_title_50 text-black"><?php echo esc_html( $title ); ?></h1>
					<div class="news_detail_header">
						<span class="news_detail_date"><?php echo esc_html( $date ); ?></span>
					</div>
					<div class="news_detail_image">
						<?php
						if ( function_exists( 'tasheel_listing_image_picture' ) ) {
							tasheel_listing_image_picture( $imgs['desktop'], $imgs['mobile'], $title );
						} else {
							echo '<img src="' . esc_url( $imgs['desktop'] ) . '" alt="' . esc_attr( $title ) . '">';
						}
						?>
					</div>
					<div class="news_detail_content">
						<div class="news_detail_left_block">
							<span class="update_lable"><?php echo esc_html__( 'Update', 'tasheel' ); ?></span>
							<h5><?php echo esc_html__( 'News', 'tasheel' ); ?> - <?php echo esc_html( $date ); ?></h5>
							<ul class="news_detail_share_list">
								<li><?php echo esc_html__( 'Share:', 'tasheel' ); ?></li>
								<?php
								$share_url_enc   = rawurlencode( $share_url );
								$share_title_enc = rawurlencode( $share_title );
								$fb_share   = 'https://www.facebook.com/sharer/sharer.php?u=' . $share_url_enc;
								$twitter_share = 'https://twitter.com/intent/tweet?url=' . $share_url_enc . '&text=' . $share_title_enc;
								$linkedin_share = 'https://www.linkedin.com/sharing/share-offsite/?url=' . $share_url_enc;
								?>
								<li><a href="<?php echo esc_url( $fb_share ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr__( 'Share on Facebook', 'tasheel' ); ?>"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/fb-n.svg' ); ?>" alt=""></a></li>
								<li><a href="#" data-share-url="<?php echo esc_attr( $share_url ); ?>" aria-label="<?php echo esc_attr__( 'Share on Instagram', 'tasheel' ); ?>"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/insta-n.svg' ); ?>" alt=""></a></li>
								<li><a href="<?php echo esc_url( $twitter_share ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr__( 'Share on X', 'tasheel' ); ?>"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/x-n.svg' ); ?>" alt=""></a></li>
								<li><a href="<?php echo esc_url( $linkedin_share ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr__( 'Share on LinkedIn', 'tasheel' ); ?>"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/in-n.svg' ); ?>" alt=""></a></li>
							</ul>
						</div>
						<div class="news_detail_right_block">
							<?php the_content(); ?>
						</div>
					</div>
				</div>
			</div>
		</section>
		<?php
		$related_news = function_exists( 'tasheel_get_related_news' ) ? tasheel_get_related_news( $post_id, 4 ) : array();
		$related_news_data = array(
			'title'                  => esc_html__( 'Related Posts', 'tasheel' ),
			'title_span'             => '',
			'news_items'             => $related_news,
			'section_class'          => 'bg_color_01 related-news pt_100 pb_100',
			'show_view_all_button'   => true,
			'view_all_url'           => $news_list_url,
		);
		get_template_part( 'template-parts/Related-News', null, $related_news_data );
	endwhile;
	?>
</main>

<?php
get_footer();
