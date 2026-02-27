<?php
/**
 * Template Name: News
 *
 * News listing page. Uses News CPT when available; all strings WPML-ready.
 *
 * @package tasheel
 */

get_header();

$page_id = is_page() ? get_queried_object_id() : 0;

// Banner: ACF options (desktop + mobile image, title); fallback to default.
$banner_image        = ( $page_id && function_exists( 'get_field' ) ) ? get_field( 'listing_banner_image', $page_id ) : '';
$banner_image_mobile = ( $page_id && function_exists( 'get_field' ) ) ? get_field( 'listing_banner_image_mobile', $page_id ) : '';
$banner_title        = ( $page_id && function_exists( 'get_field' ) ) ? get_field( 'listing_banner_title', $page_id ) : '';
if ( ! is_string( $banner_title ) || $banner_title === '' ) {
	$banner_title = esc_html__( 'News', 'tasheel' );
}
$banner_bg = $banner_image ? ( is_array( $banner_image ) && isset( $banner_image['url'] ) ? $banner_image['url'] : (string) $banner_image ) : ( get_template_directory_uri() . '/assets/images/news-banner-01.jpg' );
$banner_bg_mobile = '';
if ( $banner_image_mobile ) {
	$banner_bg_mobile = is_array( $banner_image_mobile ) && isset( $banner_image_mobile['url'] ) ? $banner_image_mobile['url'] : (string) $banner_image_mobile;
}

$news_list_url = home_url( '/news' );
if ( post_type_exists( 'news' ) && get_option( 'permalink_structure' ) ) {
	$archive = get_post_type_archive_link( 'news' );
	if ( $archive ) {
		$news_list_url = $archive;
	}
}

?>

<main id="primary" class="site-main">
	<?php
	$inner_banner_data = array(
		'background_image'        => $banner_bg,
		'background_image_mobile'  => $banner_bg_mobile,
		'title'                    => $banner_title,
	);
	get_template_part( 'template-parts/inner-banner', null, $inner_banner_data );
	?>

	<?php
	$breadcrumb_data = array(
		'breadcrumb_items'       => function_exists( 'tasheel_get_listing_breadcrumb_items' ) ? tasheel_get_listing_breadcrumb_items( 'news_listing', array( 'page_id' => $page_id ) ) : array(),
		'section_wrapper_class' => array(),
		'section_class'         => '',
	);
	get_template_part( 'template-parts/Breadcrumb', null, $breadcrumb_data );
	?>

	<section class="news_page_section pt_60 pb_80">
		<div class="wrap">
			<div class="title_block mb_20">
				<div class="title_block_left">
					<h3 class="h3_title_50"><?php echo esc_html__( 'News', 'tasheel' ); ?></h3>
				</div>
			</div>

			<?php
			$per_page = 12;
			if ( $page_id && function_exists( 'get_field' ) ) {
				$acf_per = (int) get_field( 'listing_items_per_page', $page_id );
				if ( $acf_per >= 1 && $acf_per <= 50 ) {
					$per_page = $acf_per;
				}
			}
			$news_result = array( 'items' => array(), 'found_posts' => 0 );
			if ( function_exists( 'tasheel_get_media_center_news' ) ) {
				$news_result = tasheel_get_media_center_news( $per_page, 'listing', 0, true );
			}
			if ( empty( $news_result['items'] ) && post_type_exists( 'news' ) ) {
				$q = new WP_Query( array(
					'post_type'      => 'news',
					'posts_per_page' => $per_page,
					'post_status'    => 'publish',
					'orderby'        => array( 'menu_order' => 'ASC', 'date' => 'DESC' ),
					'order'          => 'DESC',
					'no_found_rows'  => false,
				) );
				$news_index = 0;
				if ( $q->have_posts() ) {
					while ( $q->have_posts() ) {
						$q->the_post();
						$pid  = get_the_ID();
						$listing_img = function_exists( 'tasheel_get_listing_page_image' ) ? tasheel_get_listing_page_image( $pid, 'news' ) : get_the_post_thumbnail_url( $pid, 'full' );
						if ( ! $listing_img ) {
							$listing_img = get_template_directory_uri() . '/assets/images/news-01.jpg';
						}
						$cat_label = ( $news_index === 0 )
							? esc_html__( 'Latest News', 'tasheel' )
							: sprintf( esc_html__( '%s ago', 'tasheel' ), human_time_diff( get_the_date( 'U' ), current_time( 'timestamp' ) ) );
						$news_result['items'][] = array(
							'image'          => $listing_img,
							'image_desktop'  => $listing_img,
							'image_mobile'   => $listing_img,
							'date_label'     => get_the_date(),
							'title'          => get_the_title(),
							'category_label' => $cat_label,
							'link'           => get_permalink(),
						);
						$news_index++;
					}
					$news_result['found_posts'] = (int) $q->found_posts;
					wp_reset_postdata();
				}
			}
			// Support both formats: array( 'items' => ..., 'found_posts' => ... ) or plain array of items (old API).
			$has_found_posts = false;
			if ( isset( $news_result['items'] ) && is_array( $news_result['items'] ) ) {
				$news_items   = $news_result['items'];
				$news_total   = isset( $news_result['found_posts'] ) ? (int) $news_result['found_posts'] : count( $news_items );
				$has_found_posts = isset( $news_result['found_posts'] );
			} else {
				$news_items   = is_array( $news_result ) ? array_values( $news_result ) : array();
				$news_total   = count( $news_items );
			}
			// Show Load More if total > per_page, or if we got a full page and don't know total (so user can try loading more).
			$news_has_more = $news_total > $per_page || ( count( $news_items ) >= $per_page && ! $has_found_posts );
			?>

			<ul class="news_list_ul" id="news-list">
				<?php if ( ! empty( $news_items ) ) : ?>
					<?php foreach ( $news_items as $item ) :
						$item_link   = isset( $item['link'] ) ? esc_url( $item['link'] ) : '#';
						$item_img_d  = isset( $item['image_desktop'] ) ? $item['image_desktop'] : ( isset( $item['image'] ) ? $item['image'] : get_template_directory_uri() . '/assets/images/news-01.jpg' );
						$item_img_m  = isset( $item['image_mobile'] ) ? $item['image_mobile'] : $item_img_d;
						$item_date   = isset( $item['date_label'] ) ? $item['date_label'] : '';
						$item_title  = isset( $item['title'] ) ? $item['title'] : '';
						$item_cat    = isset( $item['category_label'] ) ? $item['category_label'] : esc_html__( 'Latest News', 'tasheel' );
					?>
						<li>
							<div class="insights_item">
								<a href="<?php echo $item_link; ?>" class="insights_item_image_link">
									<div class="insights_item_image">
										<span class="latest_news_lable"><?php echo esc_html( $item_date ); ?></span>
										<?php
										if ( function_exists( 'tasheel_listing_image_picture' ) ) {
											tasheel_listing_image_picture( $item_img_d, $item_img_m, $item_title );
										} else {
											echo '<img src="' . esc_url( $item_img_d ) . '" alt="' . esc_attr( $item_title ) . '">';
										}
										?>
									</div>
								</a>
								<div class="insights_item_content">
									<a href="<?php echo $item_link; ?>"><h4><?php echo esc_html( $item_title ); ?></h4></a>
									<span class="latest_news_text_lable"><?php echo esc_html( $item_cat ); ?></span>
								</div>
							</div>
						</li>
					<?php endforeach; ?>
				<?php else : ?>
					<li class="news_list_empty">
						<p class="news_no_items"><?php echo esc_html__( 'No news found.', 'tasheel' ); ?></p>
					</li>
				<?php endif; ?>
			</ul>

			<?php if ( $news_has_more ) : ?>
				<?php
				$current_lang = function_exists( 'apply_filters' ) ? apply_filters( 'wpml_current_language', get_locale() ) : get_locale();
				?>
				<div class="load_more_container news_load_more_container" style="text-align: center; margin-top: 40px;" data-per-page="<?php echo (int) $per_page; ?>" data-total="<?php echo (int) $news_total; ?>" data-current-page="1" data-listing-ajax="news" data-lang="<?php echo esc_attr( $current_lang ); ?>">
					<button type="button" class="load_more_btn btn_style btn_green tasheel-listing-load-more" id="tasheel-listing-load-more-news">
						<span><?php echo esc_html__( 'Load More', 'tasheel' ); ?></span>
					</button>
				</div>
			<?php endif; ?>
		</div>
	</section>

</main><!-- #main -->

<?php
get_footer();

