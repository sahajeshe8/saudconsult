<?php
/**
 * Template Name: Events
 *
 * Events listing page. Uses Event CPT; all strings WPML-ready.
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
	$banner_title = esc_html__( 'Events', 'tasheel' );
}
$banner_bg = $banner_image ? ( is_array( $banner_image ) && isset( $banner_image['url'] ) ? $banner_image['url'] : (string) $banner_image ) : ( get_template_directory_uri() . '/assets/images/news-banner-01.jpg' );
$banner_bg_mobile = '';
if ( $banner_image_mobile ) {
	$banner_bg_mobile = is_array( $banner_image_mobile ) && isset( $banner_image_mobile['url'] ) ? $banner_image_mobile['url'] : (string) $banner_image_mobile;
}

$per_page = 12;
if ( $page_id && function_exists( 'get_field' ) ) {
	$acf_per = (int) get_field( 'listing_items_per_page', $page_id );
	if ( $acf_per >= 1 && $acf_per <= 50 ) {
		$per_page = $acf_per;
	}
}
$events_result = array( 'items' => array(), 'found_posts' => 0 );
if ( function_exists( 'tasheel_get_media_center_events' ) ) {
	$events_result = tasheel_get_media_center_events( $per_page, 'listing', 0, true );
}
// Support both formats: array( 'items' => ..., 'found_posts' => ... ) or plain array of items (old API).
$events_has_found_posts = false;
if ( isset( $events_result['items'] ) && is_array( $events_result['items'] ) ) {
	$events_items   = $events_result['items'];
	$events_total   = isset( $events_result['found_posts'] ) ? (int) $events_result['found_posts'] : count( $events_items );
	$events_has_found_posts = isset( $events_result['found_posts'] );
} else {
	$events_items   = is_array( $events_result ) ? array_values( $events_result ) : array();
	$events_total   = count( $events_items );
}
// Show Load More if total > per_page, or if we got a full page and don't know total.
$events_has_more = $events_total > $per_page || ( count( $events_items ) >= $per_page && ! $events_has_found_posts );
?>

<main id="primary" class="site-main" style="background: #f5f9ee;">
	<?php
	$inner_banner_data = array(
		'background_image'        => $banner_bg,
		'background_image_mobile' => $banner_bg_mobile,
		'title'                    => $banner_title,
	);
	get_template_part( 'template-parts/inner-banner', null, $inner_banner_data );
	?>

	<?php
	$events_url = home_url( '/events' );
	if ( post_type_exists( 'event' ) && get_option( 'permalink_structure' ) ) {
		$events_archive = get_post_type_archive_link( 'event' );
		if ( $events_archive ) {
			$events_url = $events_archive;
		}
	}
	$breadcrumb_data = array(
		'breadcrumb_items'       => function_exists( 'tasheel_get_listing_breadcrumb_items' ) ? tasheel_get_listing_breadcrumb_items( 'events_listing', array( 'page_id' => $page_id ) ) : array(),
		'section_wrapper_class' => array(),
		'section_class'         => '',
	);
	get_template_part( 'template-parts/Breadcrumb', null, $breadcrumb_data );
	?>

	<section class="events_page_section pt_50 pb_80">
		<div class="wrap">
			<div class="title_block mb_30">
				<div class="title_block_left">
					<h3 class="h3_title_50"><?php echo esc_html__( 'Events', 'tasheel' ); ?></h3>
				</div>
			</div>
			<?php
			$events_list_data = array(
				'events_items'    => $events_items,
				'events_url'      => $events_url,
				'show_load_more_btn' => false,
			);
			get_template_part( 'template-parts/Events-Page-List', null, $events_list_data );
			?>
			<?php if ( $events_has_more ) : ?>
				<?php
				$current_lang = function_exists( 'apply_filters' ) ? apply_filters( 'wpml_current_language', get_locale() ) : get_locale();
				?>
				<div class="load_more_container events_load_more_container" style="text-align: center; margin-top: 30px;" data-per-page="<?php echo (int) $per_page; ?>" data-total="<?php echo (int) $events_total; ?>" data-current-page="1" data-listing-ajax="events" data-lang="<?php echo esc_attr( $current_lang ); ?>">
					<button type="button" class="btn_style btn_transparent btn_green load_more_btn tasheel-listing-load-more" id="tasheel-listing-load-more-events">
						<span><?php echo esc_html__( 'Load More', 'tasheel' ); ?></span>
					</button>
				</div>
			<?php endif; ?>
		</div>
	</section>
</main><!-- #main -->

<?php
get_footer();

