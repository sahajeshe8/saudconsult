<?php
/**
 * ACF Media Center: render flexible content and helpers for News, Events, Brochures.
 * All output strings use esc_html__ / wp_kses_post with 'tasheel' text domain for WPML.
 *
 * @package tasheel
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Normalize ACF image field (array, ID, or URL) to URL.
 *
 * @param mixed $val ACF image value.
 * @return string URL or empty string.
 */
function tasheel_acf_image_to_url( $val ) {
	if ( is_array( $val ) && isset( $val['url'] ) ) {
		return $val['url'];
	}
	if ( is_numeric( $val ) ) {
		$url = wp_get_attachment_url( (int) $val );
		return $url ? $url : '';
	}
	return is_string( $val ) && $val !== '' ? $val : '';
}

/**
 * Get detail hero images (desktop + mobile) for single News/Event page.
 *
 * @param int    $post_id   Post ID.
 * @param string $post_type 'news' or 'event'.
 * @return array { 'desktop' => url, 'mobile' => url }
 */
function tasheel_get_detail_images( $post_id, $post_type = 'news' ) {
	$post_id  = (int) $post_id;
	$featured = get_the_post_thumbnail_url( $post_id, 'full' );
	$fallback = $post_type === 'event'
		? get_template_directory_uri() . '/assets/images/event-img-01.jpg'
		: get_template_directory_uri() . '/assets/images/news-detail-image.jpg';
	$desktop  = $featured ? $featured : $fallback;
	$mobile   = $desktop;

	if ( function_exists( 'get_field' ) ) {
		$d = tasheel_acf_image_to_url( get_field( 'image_detail_desktop', $post_id ) );
		$m = tasheel_acf_image_to_url( get_field( 'image_detail_mobile', $post_id ) );
		if ( $d !== '' ) {
			$desktop = $d;
		}
		$mobile = ( $m !== '' ) ? $m : $desktop;
	}

	return array( 'desktop' => $desktop, 'mobile' => $mobile );
}

/**
 * Get listing page image URL (News/Events listing pages, Related Posts, Same Month).
 *
 * @param int    $post_id   Post ID.
 * @param string $post_type 'news' or 'event'.
 * @return string URL.
 */
function tasheel_get_listing_page_image( $post_id, $post_type = 'news' ) {
	$post_id  = (int) $post_id;
	$detail   = tasheel_get_detail_images( $post_id, $post_type );
	$fallback = $post_type === 'event'
		? get_template_directory_uri() . '/assets/images/event-img-01.jpg'
		: get_template_directory_uri() . '/assets/images/news-img-01.jpg';
	$url      = $detail['desktop'];

	if ( function_exists( 'get_field' ) ) {
		$listing = tasheel_acf_image_to_url( get_field( 'image_listing', $post_id ) );
		if ( $listing !== '' ) {
			$url = $listing;
		}
	}

	return $url ? $url : $fallback;
}

/**
 * Get Media Center section image URL (News/Events sections on Media Center page only).
 *
 * @param int    $post_id   Post ID.
 * @param string $post_type 'news' or 'event'.
 * @return string URL.
 */
function tasheel_get_media_center_section_image( $post_id, $post_type = 'news' ) {
	$post_id  = (int) $post_id;
	$listing  = tasheel_get_listing_page_image( $post_id, $post_type );
	$fallback = $post_type === 'event'
		? get_template_directory_uri() . '/assets/images/event-img-01.jpg'
		: get_template_directory_uri() . '/assets/images/news-img-01.jpg';
	$url      = $listing;

	if ( function_exists( 'get_field' ) ) {
		$mc = tasheel_acf_image_to_url( get_field( 'image_media_center', $post_id ) );
		if ( $mc !== '' ) {
			$url = $mc;
		}
	}

	return $url ? $url : $fallback;
}

/**
 * Backward compatibility: return desktop + mobile for listing/related (same image for both when using listing field).
 *
 * @param int    $post_id   Post ID.
 * @param string $post_type 'news' or 'event'.
 * @return array { 'desktop' => url, 'mobile' => url }
 */
function tasheel_get_listing_images( $post_id, $post_type = 'news' ) {
	$url = tasheel_get_listing_page_image( $post_id, $post_type );
	return array( 'desktop' => $url, 'mobile' => $url );
}

/**
 * Output <picture> with desktop/mobile sources, or single <img> when both are the same.
 *
 * @param string $desktop_url Desktop image URL.
 * @param string $mobile_url  Mobile image URL (optional; defaults to desktop).
 * @param string $alt         Alt text.
 * @param string $class       Optional class for img.
 */
function tasheel_listing_image_picture( $desktop_url, $mobile_url, $alt = '', $class = '' ) {
	$desktop_url = esc_url( $desktop_url );
	$mobile_url  = $mobile_url && $mobile_url !== $desktop_url ? esc_url( $mobile_url ) : '';
	$alt         = esc_attr( $alt );
	$class       = esc_attr( $class );

	if ( $mobile_url ) {
		echo '<picture>';
		echo '<source media="(max-width: 767px)" srcset="' . $mobile_url . '">';
		echo '<source media="(min-width: 768px)" srcset="' . $desktop_url . '">';
		echo '<img src="' . $desktop_url . '" alt="' . $alt . '"' . ( $class ? ' class="' . $class . '"' : '' ) . '>';
		echo '</picture>';
	} else {
		echo '<img src="' . $desktop_url . '" alt="' . $alt . '"' . ( $class ? ' class="' . $class . '"' : '' ) . '>';
	}
}

/**
 * Normalize ACF relationship field value to array of post IDs.
 * Handles: array of IDs, array of WP_Post objects, single ID, null, false.
 *
 * @param mixed $value ACF relationship/post_object field value.
 * @return int[] Array of post IDs.
 */
function tasheel_normalize_post_ids_from_relationship( $value ) {
	if ( empty( $value ) ) {
		return array();
	}
	if ( ! is_array( $value ) ) {
		$value = array( $value );
	}
	$ids = array();
	foreach ( $value as $item ) {
		if ( is_object( $item ) && isset( $item->ID ) ) {
			$ids[] = (int) $item->ID;
		} elseif ( is_numeric( $item ) && (int) $item > 0 ) {
			$ids[] = (int) $item;
		}
	}
	return array_filter( array_unique( $ids ) );
}

/**
 * Build news item array from a single post ID (for manual selection).
 *
 * @param int    $post_id       Post ID.
 * @param string $image_context 'media_center' or 'listing'.
 * @param int    $index         Index (0 = first, for "Latest News" label).
 * @return array|null Item array or null if invalid.
 */
function tasheel_news_item_from_post_id( $post_id, $image_context = 'media_center', $index = 0 ) {
	$post_id = (int) $post_id;
	$post = get_post( $post_id );
	if ( ! $post || $post->post_type !== 'news' || $post->post_status !== 'publish' ) {
		return null;
	}
	$img = ( $image_context === 'listing' ) ? tasheel_get_listing_page_image( $post_id, 'news' ) : tasheel_get_media_center_section_image( $post_id, 'news' );
	$category_label = ( $index === 0 )
		? esc_html__( 'Latest News', 'tasheel' )
		: sprintf( esc_html__( '%s ago', 'tasheel' ), human_time_diff( get_the_date( 'U', $post_id ), current_time( 'timestamp' ) ) );
	return array(
		'image'          => $img,
		'image_desktop'  => $img,
		'image_mobile'   => $img,
		'date_label'     => get_the_date( '', $post_id ),
		'title'          => get_the_title( $post_id ),
		'category_label' => $category_label,
		'link'           => get_permalink( $post_id ),
	);
}

/**
 * Get news items from an array of post IDs (manual selection).
 *
 * @param array  $post_ids      Array of post IDs.
 * @param string $image_context 'media_center' or 'listing'.
 * @return array Items in same format as tasheel_get_media_center_news.
 */
function tasheel_news_items_from_post_ids( $post_ids, $image_context = 'media_center' ) {
	$items  = array();
	$ids    = tasheel_normalize_post_ids_from_relationship( $post_ids );
	$index  = 0;
	foreach ( $ids as $pid ) {
		$item = tasheel_news_item_from_post_id( (int) $pid, $image_context, $index );
		if ( $item ) {
			$items[] = $item;
			$index++;
		}
	}
	return $items;
}

/**
 * Build event item array from a single post ID (for manual selection).
 *
 * @param int    $post_id       Post ID.
 * @param string $image_context 'media_center' or 'listing'.
 * @return array|null Item array or null if invalid.
 */
function tasheel_event_item_from_post_id( $post_id, $image_context = 'media_center' ) {
	$post_id = (int) $post_id;
	$post = get_post( $post_id );
	if ( ! $post || $post->post_type !== 'event' || $post->post_status !== 'publish' ) {
		return null;
	}
	$img = ( $image_context === 'listing' ) ? tasheel_get_listing_page_image( $post_id, 'event' ) : tasheel_get_media_center_section_image( $post_id, 'event' );
	$event_date = function_exists( 'get_field' ) ? get_field( 'event_date', $post_id ) : '';
	$event_time = function_exists( 'get_field' ) ? get_field( 'event_time', $post_id ) : '';
	$location   = function_exists( 'get_field' ) ? get_field( 'event_location', $post_id ) : '';
	if ( $event_date ) {
		$ts = strtotime( $event_date );
		$date_day    = date_i18n( 'd', $ts );
		$date_month  = date_i18n( 'M', $ts );
		$date_display = $date_day . ' <span>' . $date_month . '</span>';
		$date_short   = date_i18n( 'D j M', $ts );
	} else {
		$date_display = get_the_date( 'd <span>M</span>', $post_id );
		$date_day     = get_the_date( 'd', $post_id );
		$date_month   = get_the_date( 'M', $post_id );
		$date_short   = get_the_date( 'D j M', $post_id );
	}
	if ( function_exists( 'tasheel_arabic_numerals' ) ) {
		$date_display = tasheel_arabic_numerals( $date_display );
		$date_day     = tasheel_arabic_numerals( $date_day );
		$date_short   = tasheel_arabic_numerals( $date_short );
	}
	return array(
		'image'         => $img,
		'image_desktop' => $img,
		'image_mobile'  => $img,
		'date_display'  => $date_display,
		'date_day'      => isset( $date_day ) ? $date_day : '',
		'date_month'    => isset( $date_month ) ? $date_month : '',
		'date_short'    => isset( $date_short ) ? $date_short : '',
		'title'         => get_the_title( $post_id ),
		'time'          => $event_time ? $event_time : '',
		'location'      => $location ? $location : '',
		'link'          => get_permalink( $post_id ),
	);
}

/**
 * Get event items from an array of post IDs (manual selection).
 *
 * @param array  $post_ids      Array of post IDs.
 * @param string $image_context 'media_center' or 'listing'.
 * @return array Items in same format as tasheel_get_media_center_events.
 */
function tasheel_events_items_from_post_ids( $post_ids, $image_context = 'media_center' ) {
	$items = array();
	$ids   = tasheel_normalize_post_ids_from_relationship( $post_ids );
	foreach ( $ids as $pid ) {
		$item = tasheel_event_item_from_post_id( (int) $pid, $image_context );
		if ( $item ) {
			$items[] = $item;
		}
	}
	return $items;
}

/**
 * Build brochure item array from a single post ID (for manual selection).
 *
 * @param int $post_id Post ID.
 * @return array|null Item array or null if invalid.
 */
function tasheel_brochure_item_from_post_id( $post_id ) {
	$post_id = (int) $post_id;
	$post = get_post( $post_id );
	if ( ! $post || $post->post_type !== 'brochure' || $post->post_status !== 'publish' ) {
		return null;
	}
	// Prefer ACF Listing image over Featured Image for brochure.
	$img = '';
	if ( function_exists( 'get_field' ) ) {
		$listing_img = tasheel_acf_image_to_url( get_field( 'image_listing', $post_id ) );
		if ( $listing_img !== '' ) {
			$img = $listing_img;
		}
	}
	if ( ! $img ) {
		$img = get_the_post_thumbnail_url( $post_id, 'full' );
	}
	if ( ! $img ) {
		$img = get_template_directory_uri() . '/assets/images/brochure-01.jpg';
	}
	$desc = function_exists( 'get_field' ) ? get_field( 'description', $post_id ) : '';
	$pdf  = function_exists( 'get_field' ) ? get_field( 'pdf_file', $post_id ) : '';
	return array(
		'title'        => get_the_title( $post_id ),
		'description'  => is_string( $desc ) ? $desc : '',
		'image'        => $img,
		'download_url' => is_string( $pdf ) && $pdf ? $pdf : '',
		'link'         => get_permalink( $post_id ),
	);
}

/**
 * Get brochure items from an array of post IDs (manual selection).
 *
 * @param array $post_ids Array of post IDs.
 * @return array Items in same format as tasheel_get_media_center_brochures.
 */
function tasheel_brochures_items_from_post_ids( $post_ids ) {
	$items = array();
	$ids   = tasheel_normalize_post_ids_from_relationship( $post_ids );
	foreach ( $ids as $pid ) {
		$item = tasheel_brochure_item_from_post_id( (int) $pid );
		if ( $item ) {
			$items[] = $item;
		}
	}
	return $items;
}

/**
 * Get latest news posts. Used for Media Center section and for News listing page.
 *
 * @param int    $limit         Posts per page.
 * @param string $image_context 'media_center' = image in Media Center page section; 'listing' = image on News listing page and Related Posts.
 * @param int    $offset        Offset for pagination (default 0).
 * @param bool   $return_found  If true, return array( 'items' => ..., 'found_posts' => int ).
 * @return array Array of items, or array with 'items' and 'found_posts' when $return_found.
 */
function tasheel_get_media_center_news( $limit = 6, $image_context = 'media_center', $offset = 0, $return_found = false ) {
	$limit  = max( 1, min( 50, (int) $limit ) );
	$offset = max( 0, (int) $offset );
	$q = new WP_Query( array(
		'post_type'      => 'news',
		'posts_per_page' => $limit,
		'offset'         => $offset,
		'post_status'    => 'publish',
		'orderby'        => array( 'menu_order' => 'ASC', 'date' => 'DESC' ),
		'order'          => 'DESC',
		'no_found_rows'  => ! $return_found,
	) );
	$items = array();
	$index = 0;
	if ( $q->have_posts() ) {
		while ( $q->have_posts() ) {
			$q->the_post();
			$pid  = get_the_ID();
			$img  = ( $image_context === 'listing' ) ? tasheel_get_listing_page_image( $pid, 'news' ) : tasheel_get_media_center_section_image( $pid, 'news' );
			// "Latest News" only for the very first post overall (offset 0, first item); load-more items use relative time
			$category_label = ( $offset === 0 && $index === 0 )
				? esc_html__( 'Latest News', 'tasheel' )
				: sprintf( esc_html__( '%s ago', 'tasheel' ), human_time_diff( get_the_date( 'U' ), current_time( 'timestamp' ) ) );
			$items[] = array(
				'image'          => $img,
				'image_desktop'  => $img,
				'image_mobile'   => $img,
				'date_label'     => get_the_date(),
				'title'          => get_the_title(),
				'category_label' => $category_label,
				'link'           => get_permalink(),
			);
			$index++;
		}
		wp_reset_postdata();
	}
	if ( $return_found ) {
		return array( 'items' => $items, 'found_posts' => (int) $q->found_posts );
	}
	return $items;
}

/**
 * Get latest events (Event CPT). Used for Media Center section and for Events listing page.
 *
 * @param int    $limit         Posts per page.
 * @param string $image_context 'media_center' = image in Media Center page section; 'listing' = image on Events listing page.
 * @param int    $offset        Offset for pagination (default 0).
 * @param bool   $return_found  If true, return array( 'items' => ..., 'found_posts' => int ).
 * @return array Array of items, or array with 'items' and 'found_posts' when $return_found.
 */
function tasheel_get_media_center_events( $limit = 8, $image_context = 'media_center', $offset = 0, $return_found = false ) {
	$limit  = max( 1, min( 50, (int) $limit ) );
	$offset = max( 0, (int) $offset );
	$args = array(
		'post_type'      => 'event',
		'posts_per_page' => $limit,
		'offset'         => $offset,
		'post_status'    => 'publish',
		'orderby'        => array( 'menu_order' => 'ASC', 'meta_value' => 'ASC' ),
		'meta_key'       => 'event_date',
		'meta_type'      => 'DATE',
		'order'          => 'ASC',
		'no_found_rows'  => ! $return_found,
	);
	// Fetch ALL events (upcoming and past), ordered by event_date ASC (soonest first = past then future).
	// Same behavior as Events listing page.
	$q = new WP_Query( $args );
	$items = array();
	if ( $q->have_posts() ) {
		while ( $q->have_posts() ) {
			$q->the_post();
			$pid    = get_the_ID();
			$img    = ( $image_context === 'listing' ) ? tasheel_get_listing_page_image( $pid, 'event' ) : tasheel_get_media_center_section_image( $pid, 'event' );
			$event_date = function_exists( 'get_field' ) ? get_field( 'event_date', $pid ) : '';
			$event_time = function_exists( 'get_field' ) ? get_field( 'event_time', $pid ) : '';
			$location   = function_exists( 'get_field' ) ? get_field( 'event_location', $pid ) : '';
			if ( $event_date ) {
				$ts = strtotime( $event_date );
				$date_day    = date_i18n( 'd', $ts );
				$date_month  = date_i18n( 'M', $ts );
				$date_display = $date_day . ' <span>' . $date_month . '</span>';
				$date_short   = date_i18n( 'D j M', $ts );
			} else {
				$date_display = get_the_date( 'd <span>M</span>' );
				$date_day     = get_the_date( 'd' );
				$date_month   = get_the_date( 'M' );
				$date_short   = get_the_date( 'D j M' );
			}
			if ( function_exists( 'tasheel_arabic_numerals' ) ) {
				$date_display = tasheel_arabic_numerals( $date_display );
				$date_day     = tasheel_arabic_numerals( $date_day );
				$date_short   = tasheel_arabic_numerals( $date_short );
			}
			$items[] = array(
				'image'         => $img,
				'image_desktop' => $img,
				'image_mobile'  => $img,
				'date_display'  => $date_display,
				'date_day'      => isset( $date_day ) ? $date_day : '',
				'date_month'    => isset( $date_month ) ? $date_month : '',
				'date_short'    => isset( $date_short ) ? $date_short : '',
				'title'         => get_the_title(),
				'time'          => $event_time ? $event_time : '',
				'location'      => $location ? $location : '',
				'link'          => get_permalink(),
			);
		}
		wp_reset_postdata();
	}
	if ( $return_found ) {
		return array( 'items' => $items, 'found_posts' => (int) $q->found_posts );
	}
	return $items;
}

/**
 * Get brochures for media center (Brochure CPT). Listing only; each has download link.
 *
 * @param int $limit Max items.
 * @return array Array of items: title, description, image, download_url, link (permalink optional).
 */
function tasheel_get_media_center_brochures( $limit = 12 ) {
	$limit = max( 1, min( 24, (int) $limit ) );
	$q = new WP_Query( array(
		'post_type'      => 'brochure',
		'posts_per_page' => $limit,
		'post_status'    => 'publish',
		'orderby'        => array( 'menu_order' => 'ASC', 'date' => 'DESC' ),
		'order'          => 'DESC',
		'no_found_rows'  => true,
	) );
	$items = array();
	if ( $q->have_posts() ) {
		while ( $q->have_posts() ) {
			$q->the_post();
			$pid = get_the_ID();
			// Prefer ACF Listing image over Featured Image for brochure.
			$img = '';
			if ( function_exists( 'get_field' ) ) {
				$listing_img = tasheel_acf_image_to_url( get_field( 'image_listing', $pid ) );
				if ( $listing_img !== '' ) {
					$img = $listing_img;
				}
			}
			if ( ! $img ) {
				$img = get_the_post_thumbnail_url( $pid, 'full' );
			}
			if ( ! $img ) {
				$img = get_template_directory_uri() . '/assets/images/brochure-01.jpg';
			}
			$desc = function_exists( 'get_field' ) ? get_field( 'description', $pid ) : '';
			$pdf  = function_exists( 'get_field' ) ? get_field( 'pdf_file', $pid ) : '';
			$items[] = array(
				'title'        => get_the_title(),
				'description'  => is_string( $desc ) ? $desc : '',
				'image'        => $img,
				'download_url' => is_string( $pdf ) && $pdf ? $pdf : '',
				'link'         => get_permalink(),
			);
		}
		wp_reset_postdata();
	}
	return $items;
}

/**
 * Get events in the same month as the given event (for "What's Happening on The Same Month").
 *
 * @param int $exclude_id Event post ID to exclude.
 * @param int $limit      Max events to return.
 * @return array Items with image, image_desktop, image_mobile, location, title, date, time, link.
 */
function tasheel_get_same_month_events( $exclude_id = 0, $limit = 6 ) {
	$exclude_id = (int) $exclude_id;
	$event_date = $exclude_id && function_exists( 'get_field' ) ? get_field( 'event_date', $exclude_id ) : '';
	if ( ! $event_date ) {
		return tasheel_get_media_center_events( $limit );
	}
	$ts    = strtotime( $event_date );
	$month = date( 'm', $ts );
	$year  = date( 'Y', $ts );
	$q = new WP_Query( array(
		'post_type'      => 'event',
		'posts_per_page' => max( 1, min( 12, (int) $limit ) ),
		'post_status'    => 'publish',
		'post__not_in'   => $exclude_id ? array( $exclude_id ) : array(),
		'orderby'        => array( 'menu_order' => 'ASC', 'meta_value' => 'ASC' ),
		'meta_key'       => 'event_date',
		'meta_type'      => 'DATE',
		'order'          => 'ASC',
		'no_found_rows'  => true,
		'meta_query'     => array(
			array(
				'key'     => 'event_date',
				'value'   => array( $year . '-' . $month . '-01', $year . '-' . $month . '-31' ),
				'compare' => 'BETWEEN',
				'type'    => 'DATE',
			),
		),
	) );
	$items = array();
	if ( $q->have_posts() ) {
		while ( $q->have_posts() ) {
			$q->the_post();
			$pid     = get_the_ID();
			$imgs    = tasheel_get_listing_images( $pid, 'event' );
			$ed      = function_exists( 'get_field' ) ? get_field( 'event_date', $pid ) : '';
			$et      = function_exists( 'get_field' ) ? get_field( 'event_time', $pid ) : '';
			$loc     = function_exists( 'get_field' ) ? get_field( 'event_location', $pid ) : '';
			$d_short = $ed ? date( 'D j M', strtotime( $ed ) ) : get_the_date( 'D j M' );
			$img     = tasheel_get_listing_page_image( $pid, 'event' );
			$items[] = array(
				'image'         => $img,
				'image_desktop' => $img,
				'image_mobile'  => $img,
				'location'      => $loc ? $loc : '',
				'title'         => get_the_title(),
				'date'          => $d_short,
				'time'          => ( $et !== null && $et !== '' ) ? (string) $et : '',
				'link'          => get_permalink(),
			);
		}
		wp_reset_postdata();
	}
	return $items;
}

/**
 * Get related news (for Related Posts / Insights). Uses listing image.
 *
 * @param int $exclude_id News post ID to exclude.
 * @param int $limit      Max posts.
 * @return array Items with image, image_desktop, image_mobile, date_label, title, category_label, link.
 */
function tasheel_get_related_news( $exclude_id = 0, $limit = 4 ) {
	$exclude_id = (int) $exclude_id;
	$q = new WP_Query( array(
		'post_type'      => 'news',
		'posts_per_page' => max( 1, min( 12, (int) $limit ) ),
		'post_status'    => 'publish',
		'post__not_in'   => $exclude_id ? array( $exclude_id ) : array(),
		'orderby'        => array( 'menu_order' => 'ASC', 'date' => 'DESC' ),
		'order'          => 'DESC',
		'no_found_rows'  => true,
	) );
	$items = array();
	$index = 0;
	if ( $q->have_posts() ) {
		while ( $q->have_posts() ) {
			$q->the_post();
			$pid   = get_the_ID();
			$img   = tasheel_get_listing_page_image( $pid, 'news' );
			$category_label = ( $index === 0 )
				? esc_html__( 'Latest News', 'tasheel' )
				: sprintf( esc_html__( '%s ago', 'tasheel' ), human_time_diff( get_the_date( 'U' ), current_time( 'timestamp' ) ) );
			$items[] = array(
				'image'          => $img,
				'image_desktop'  => $img,
				'image_mobile'   => $img,
				'date_label'     => get_the_date(),
				'title'          => get_the_title(),
				'category_label' => $category_label,
				'link'           => get_permalink(),
			);
			$index++;
		}
		wp_reset_postdata();
	}
	return $items;
}

/**
 * Check if a media center section has content (to hide empty sections).
 *
 * @param string $layout_name Layout key (e.g. news_section, events_section).
 * @param array  $section     ACF section data.
 * @return bool
 */
function tasheel_media_center_section_has_content( $layout_name, $section ) {
	switch ( $layout_name ) {
		case 'news_section':
			if ( isset( $section['selection_mode'] ) && $section['selection_mode'] === 'manual' ) {
				$ids = isset( $section['posts_manual'] ) ? $section['posts_manual'] : array();
				$items = tasheel_news_items_from_post_ids( $ids );
			} else {
				$limit = isset( $section['posts_limit'] ) ? (int) $section['posts_limit'] : 6;
				$items = tasheel_get_media_center_news( $limit );
			}
			return ! empty( $items );
		case 'events_section':
			if ( isset( $section['selection_mode'] ) && $section['selection_mode'] === 'manual' ) {
				$ids = isset( $section['posts_manual'] ) ? $section['posts_manual'] : array();
				$items = tasheel_events_items_from_post_ids( $ids );
			} else {
				$limit = isset( $section['posts_limit'] ) ? (int) $section['posts_limit'] : 8;
				$items = tasheel_get_media_center_events( $limit );
			}
			return ! empty( $items );
		case 'brochures_section':
			if ( isset( $section['selection_mode'] ) && $section['selection_mode'] === 'manual' ) {
				$ids = isset( $section['posts_manual'] ) ? $section['posts_manual'] : array();
				$items = tasheel_brochures_items_from_post_ids( $ids );
			} else {
				$limit = isset( $section['posts_limit'] ) ? (int) $section['posts_limit'] : 12;
				$items = tasheel_get_media_center_brochures( $limit );
			}
			return ! empty( $items );
		case 'gallery_section':
			$images = isset( $section['gallery_images'] ) && is_array( $section['gallery_images'] ) ? $section['gallery_images'] : array();
			return ! empty( $images );
		case 'faq_section':
			$items = isset( $section['faq_items'] ) && is_array( $section['faq_items'] ) ? $section['faq_items'] : array();
			return ! empty( $items );
		case 'inner_banner':
			return true;
		default:
			return true;
	}
}

/**
 * Render one Media Center flexible section.
 * News, Events, Brochures, Gallery are always shown when added in the backend (empty state if no items).
 * FAQ and inner_banner are only shown when they have content.
 *
 * @param array $section ACF flexible content row (acf_fc_layout + sub_fields).
 */
function tasheel_render_media_center_section( $section ) {
	if ( empty( $section ) || empty( $section['acf_fc_layout'] ) ) {
		return;
	}
	$layout_name = $section['acf_fc_layout'];

	// Normalize layout key (ACF may return layout_about_news_section or layout_mc_news etc.).
	if ( strpos( $layout_name, 'layout_about_' ) === 0 ) {
		$layout_name = str_replace( 'layout_about_', '', $layout_name );
	}
	if ( strpos( $layout_name, 'layout_mc_' ) === 0 ) {
		$layout_name = str_replace( 'layout_mc_', '', $layout_name );
	}

	// Only hide section when it has no content for layouts that should be hidden when empty (e.g. FAQ).
	// News, Events, Brochures, Gallery always show when the block is added (template can show empty state).
	$hide_when_empty = array( 'faq_section' );
	if ( in_array( $layout_name, $hide_when_empty, true ) && ! tasheel_media_center_section_has_content( $layout_name, $section ) ) {
		return;
	}

	switch ( $layout_name ) {
		case 'inner_banner':
			$bg = isset( $section['background_image'] ) ? $section['background_image'] : '';
			if ( is_array( $bg ) && isset( $bg['url'] ) ) {
				$bg = $bg['url'];
			} elseif ( is_numeric( $bg ) ) {
				$bg = wp_get_attachment_url( (int) $bg );
			}
			if ( ! $bg ) {
				$bg = get_template_directory_uri() . '/assets/images/media-center-banner.jpg';
			}
			$bg_mobile = isset( $section['background_image_mobile'] ) ? $section['background_image_mobile'] : '';
			if ( is_array( $bg_mobile ) && isset( $bg_mobile['url'] ) ) {
				$bg_mobile = $bg_mobile['url'];
			} elseif ( is_numeric( $bg_mobile ) ) {
				$bg_mobile = wp_get_attachment_url( (int) $bg_mobile );
			}
			$title = isset( $section['title'] ) ? $section['title'] : esc_html__( 'Media Center', 'tasheel' );
			$inner_banner_data = array(
				'background_image'       => $bg,
				'background_image_mobile' => $bg_mobile,
				'title'                  => $title,
			);
			get_template_part( 'template-parts/inner-banner', null, $inner_banner_data );
			break;

		case 'news_section':
			$title = isset( $section['section_title'] ) ? $section['section_title'] : esc_html__( 'News', 'tasheel' );
			if ( isset( $section['selection_mode'] ) && $section['selection_mode'] === 'manual' ) {
				$ids = isset( $section['posts_manual'] ) ? $section['posts_manual'] : array();
				$news_items = tasheel_news_items_from_post_ids( $ids );
			} else {
				$limit = isset( $section['posts_limit'] ) ? (int) $section['posts_limit'] : 6;
				$news_items = tasheel_get_media_center_news( $limit );
			}
			$news_list_data = array(
				'title'                 => $title,
				'title_span'            => '',
				'section_wrapper_class' => array( 'pt_100', 'pb_50' ),
				'section_class'         => '',
				'news_items'            => $news_items,
				'show_empty_message'    => true,
			);
			echo '<section class="media_center_section pt_100 pb_50">';
			get_template_part( 'template-parts/News-List', null, $news_list_data );
			echo '</section>';
			break;

		case 'events_section':
			$title = isset( $section['section_title'] ) ? $section['section_title'] : esc_html__( 'Events', 'tasheel' );
			if ( isset( $section['selection_mode'] ) && $section['selection_mode'] === 'manual' ) {
				$ids = isset( $section['posts_manual'] ) ? $section['posts_manual'] : array();
				$events_items = tasheel_events_items_from_post_ids( $ids );
			} else {
				$limit = isset( $section['posts_limit'] ) ? (int) $section['posts_limit'] : 8;
				$events_items = tasheel_get_media_center_events( $limit );
			}
			$events_list_data = array(
				'title'                 => '',
				'title_span'            => $title,
				'section_wrapper_class' => array(),
				'section_class'         => '',
				'events_items'          => $events_items,
				'show_empty_message'    => true,
			);
			echo '<section class="media_center_events_section pt_50 pb_100">';
			get_template_part( 'template-parts/Events-List', null, $events_list_data );
			echo '</section>';
			break;

		case 'brochures_section':
			$title = isset( $section['section_title'] ) ? $section['section_title'] : esc_html__( 'Brochures', 'tasheel' );
			if ( isset( $section['selection_mode'] ) && $section['selection_mode'] === 'manual' ) {
				$ids = isset( $section['posts_manual'] ) ? $section['posts_manual'] : array();
				$brochures_items = tasheel_brochures_items_from_post_ids( $ids );
			} else {
				$limit = isset( $section['posts_limit'] ) ? (int) $section['posts_limit'] : 12;
				$brochures_items = tasheel_get_media_center_brochures( $limit );
			}
			$brochures_list_data = array(
				'title'                 => $title,
				'title_span'            => '',
				'show_view_all'         => false,
				'section_wrapper_class' => array(),
				'section_class'         => '',
				'brochures_items'       => $brochures_items,
				'show_empty_message'    => true,
			);
			echo '<section class="media_center_brochures_section">';
			get_template_part( 'template-parts/Brochures-List', null, $brochures_list_data );
			echo '</section>';
			break;

		case 'gallery_section':
			$title = isset( $section['section_title'] ) ? $section['section_title'] : esc_html__( 'Gallery', 'tasheel' );
			$raw_images = isset( $section['gallery_images'] ) && is_array( $section['gallery_images'] ) ? $section['gallery_images'] : array();
			$gallery_items = array();
			foreach ( $raw_images as $img ) {
				$url = '';
				if ( is_array( $img ) && isset( $img['url'] ) ) {
					$url = $img['url'];
					$alt = isset( $img['alt'] ) ? $img['alt'] : ( isset( $img['title'] ) ? $img['title'] : esc_attr__( 'Gallery Image', 'tasheel' ) );
				} elseif ( is_numeric( $img ) ) {
					$url = wp_get_attachment_url( (int) $img );
					$alt = get_post_meta( (int) $img, '_wp_attachment_image_alt', true );
					if ( ! $alt ) {
						$alt = esc_attr__( 'Gallery Image', 'tasheel' );
					}
				}
				if ( $url ) {
					$gallery_items[] = array( 'image' => $url, 'alt' => $alt, 'size' => 'normal' );
				}
			}
			$gallery_data = array(
				'title'                 => $title,
				'title_span'            => '',
				'show_view_all'         => true,
				'section_wrapper_class' => array(),
				'section_class'         => '',
				'gallery_items'         => $gallery_items,
				'show_empty_message'    => true,
			);
			echo '<section class="media_center_gallery_section">';
			get_template_part( 'template-parts/Gallery', null, $gallery_data );
			echo '</section>';
			break;

		case 'faq_section':
			$heading_first = isset( $section['faq_heading_first'] ) ? $section['faq_heading_first'] : esc_html__( 'Frequently', 'tasheel' );
			$heading_span  = isset( $section['faq_heading_span'] ) ? $section['faq_heading_span'] : esc_html__( 'Asked Questions', 'tasheel' );
			$raw_items = isset( $section['faq_items'] ) && is_array( $section['faq_items'] ) ? $section['faq_items'] : array();
			$faq_items = array();
			foreach ( $raw_items as $index => $item ) {
				$q = isset( $item['question'] ) ? $item['question'] : '';
				$a = isset( $item['answer'] ) ? $item['answer'] : '';
				if ( $q || $a ) {
					$faq_items[] = array(
						'question' => $q,
						'answer'   => $a,
						'is_open'  => $index === 0,
					);
				}
			}
			$faq_data = array(
				'section_wrapper_class' => array( 'pt_80', 'pb_80' ),
				'section_class'          => '',
				'faq_heading_first'     => $heading_first,
				'faq_heading_span'      => $heading_span,
				'faq_items'             => $faq_items,
			);
			get_template_part( 'template-parts/FAQ', null, $faq_data );
			break;

		default:
			// Unknown layout – do nothing.
			break;
	}
}

/**
 * Render news list items to HTML (for AJAX load more). Same structure as page-template-news.php.
 *
 * @param array $items Array of items from tasheel_get_media_center_news.
 * @return string HTML of <li> elements.
 */
function tasheel_render_news_list_items_html( $items ) {
	if ( empty( $items ) || ! is_array( $items ) ) {
		return '';
	}
	ob_start();
	foreach ( $items as $item ) {
		$item_link  = isset( $item['link'] ) ? esc_url( $item['link'] ) : '#';
		$item_img_d = isset( $item['image_desktop'] ) ? $item['image_desktop'] : ( isset( $item['image'] ) ? $item['image'] : get_template_directory_uri() . '/assets/images/news-01.jpg' );
		$item_img_m = isset( $item['image_mobile'] ) ? $item['image_mobile'] : $item_img_d;
		$item_date  = isset( $item['date_label'] ) ? $item['date_label'] : '';
		$item_title = isset( $item['title'] ) ? $item['title'] : '';
		$item_cat   = isset( $item['category_label'] ) ? $item['category_label'] : esc_html__( 'Latest News', 'tasheel' );
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
		<?php
	}
	return ob_get_clean();
}

/**
 * Render events list items to HTML (for AJAX load more). Same structure as Events-Page-List.
 *
 * @param array $items Array of items from tasheel_get_media_center_events.
 * @return string HTML of <li> elements.
 */
function tasheel_render_events_list_items_html( $items ) {
	if ( empty( $items ) || ! is_array( $items ) ) {
		return '';
	}
	ob_start();
	foreach ( $items as $item ) {
		$item_link       = isset( $item['link'] ) ? esc_url( $item['link'] ) : '#';
		$item_img_d      = isset( $item['image_desktop'] ) ? $item['image_desktop'] : ( isset( $item['image'] ) ? $item['image'] : get_template_directory_uri() . '/assets/images/event-01.jpg' );
		$item_img_m      = isset( $item['image_mobile'] ) ? $item['image_mobile'] : $item_img_d;
		$item_title      = isset( $item['title'] ) ? $item['title'] : '';
		$item_location   = isset( $item['location'] ) ? $item['location'] : '';
		$item_date_short = isset( $item['date_short'] ) ? $item['date_short'] : '';
		$item_time       = isset( $item['time'] ) ? $item['time'] : '';
		?>
		<li>
			<div class="event_item_img">
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
			<div class="event_item_content">
				<?php if ( $item_location ) : ?><span class="event_lable"><?php echo esc_html( $item_location ); ?></span><?php endif; ?>
				<h5><a href="<?php echo $item_link; ?>"><?php echo esc_html( $item_title ); ?></a></h5>
				<ul class="event_item_content_list_ul">
					<?php if ( $item_date_short ) : ?>
						<li><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/date-icn-event.svg' ); ?>" alt="<?php echo esc_attr__( 'Date', 'tasheel' ); ?>"> <?php echo esc_html( $item_date_short ); ?></li>
					<?php endif; ?>
					<?php if ( $item_time ) : ?>
						<li><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/time-icn-event.svg' ); ?>" alt="<?php echo esc_attr__( 'Time', 'tasheel' ); ?>"> <?php echo esc_html( $item_time ); ?></li>
					<?php endif; ?>
				</ul>
			</div>
		</li>
		<?php
	}
	return ob_get_clean();
}
