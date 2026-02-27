<?php
/**
 * Single Event (Event CPT)
 * Dynamic event detail page – matches Event Detail HTML design.
 * Uses ACF: event_date, event_date_end, event_time, event_location, event_latitude, event_longitude, event_gallery_items.
 *
 * @package tasheel
 */
global $header_custom_class;
$header_custom_class = 'black-header';

get_header();

while ( have_posts() ) :
	the_post();
	$post_id    = get_the_ID();
	$title      = get_the_title();
	$event_date = function_exists( 'get_field' ) ? get_field( 'event_date', $post_id ) : '';
	$event_date_end = function_exists( 'get_field' ) ? get_field( 'event_date_end', $post_id ) : '';
	$event_time = function_exists( 'get_field' ) ? get_field( 'event_time', $post_id ) : '';
	$location   = function_exists( 'get_field' ) ? get_field( 'event_location', $post_id ) : '';
	$event_lat  = function_exists( 'get_field' ) ? get_field( 'event_latitude', $post_id ) : '';
	$event_lng  = function_exists( 'get_field' ) ? get_field( 'event_longitude', $post_id ) : '';
	$event_gallery_items = function_exists( 'get_field' ) ? get_field( 'event_gallery_items', $post_id ) : array();
	$detail_media_type    = function_exists( 'get_field' ) ? get_field( 'detail_media_type', $post_id ) : 'image';
	$detail_video         = function_exists( 'get_field' ) ? get_field( 'detail_video', $post_id ) : '';
	$detail_video_mobile  = function_exists( 'get_field' ) ? get_field( 'detail_video_mobile', $post_id ) : '';

	// Date display: show range at top for multi-day events; single date when start = end. Use date_i18n so month/numbers respect current language (WPML).
	if ( $event_date ) {
		$ts = strtotime( $event_date );
		$date_for_detail = date_i18n( 'F j, Y', $ts );
		$ts_end = $event_date_end ? strtotime( $event_date_end ) : null;
		$is_multi_day = $ts_end && date( 'Y-m-d', $ts ) !== date( 'Y-m-d', $ts_end );

		if ( $is_multi_day ) {
			// Top: show date range (e.g. "April 29 – 30, 2025")
			$date_display = date_i18n( 'F j', $ts );
			if ( date( 'Y-m', $ts ) === date( 'Y-m', $ts_end ) ) {
				$date_display .= ' – ' . date_i18n( 'j', $ts_end ) . ', ' . date_i18n( 'Y', $ts_end );
			} else {
				$date_display .= ' – ' . date_i18n( 'F j, Y', $ts_end );
			}
			$date_for_detail = date_i18n( 'F j', $ts ) . ' – ' . date_i18n( 'F j, Y', $ts_end );
		} else {
			// Single day: top and detail show one date only
			$date_display = date_i18n( get_option( 'date_format' ), $ts );
			// $date_for_detail already set above as single-day date
		}
	} else {
		$date_display = get_the_date();
		$date_for_detail = get_the_date( 'F j, Y' );
	}
	// Right block subtitle: range for multi-day, single date otherwise
	if ( $event_date && isset( $is_multi_day ) && $is_multi_day && isset( $ts_end ) ) {
		$date_right_line = date_i18n( 'j F', $ts ) . ' – ' . date_i18n( 'j F Y', $ts_end );
	} else {
		$date_right_line = $event_date ? date_i18n( 'j F Y', strtotime( $event_date ) ) : get_the_date( 'j F Y' );
	}
	// Eastern Arabic numerals when viewing in Arabic
	if ( function_exists( 'tasheel_arabic_numerals' ) ) {
		$date_display     = tasheel_arabic_numerals( $date_display );
		$date_for_detail  = tasheel_arabic_numerals( $date_for_detail );
		$date_right_line  = tasheel_arabic_numerals( $date_right_line );
	}

	$imgs = function_exists( 'tasheel_get_detail_images' ) ? tasheel_get_detail_images( $post_id, 'event' ) : array( 'desktop' => get_the_post_thumbnail_url( $post_id, 'full' ), 'mobile' => '' );
	if ( ! $imgs['desktop'] ) {
		$imgs['desktop'] = get_template_directory_uri() . '/assets/images/event-baner.jpg';
		$imgs['mobile']  = $imgs['desktop'];
	}
	if ( ! $imgs['mobile'] ) {
		$imgs['mobile'] = $imgs['desktop'];
	}

	// Map and location: only show when event has a location or custom coordinates (do not show default Riyadh when none set).
	$has_location = ( $location && trim( (string) $location ) !== '' ) || ( $event_lat !== '' && $event_lng !== '' && is_numeric( str_replace( ',', '.', $event_lat ) ) && is_numeric( str_replace( ',', '.', $event_lng ) ) );
	$has_date = ! empty( $event_date );
	$has_time = $event_time !== '' && trim( (string) $event_time ) !== '';
	$has_any_date_time_block = $has_date || $has_time || $has_location;
	$map_lat = is_numeric( str_replace( ',', '.', $event_lat ) ) ? str_replace( ',', '.', $event_lat ) : '24.7136';
	$map_lng = is_numeric( str_replace( ',', '.', $event_lng ) ) ? str_replace( ',', '.', $event_lng ) : '46.6753';
	$map_location_text = $location ? trim( (string) $location ) : esc_html__( 'Event location', 'tasheel' );
	?>

<main id="primary" class="site-main no_banner_section">

	<?php
	$breadcrumb_data = array(
		'breadcrumb_items'       => function_exists( 'tasheel_get_listing_breadcrumb_items' ) ? tasheel_get_listing_breadcrumb_items( 'single_event', array( 'title' => $title ) ) : array(),
		'section_wrapper_class'  => array(),
		'section_class'          => '',
	);
	get_template_part( 'template-parts/Breadcrumb', null, $breadcrumb_data );
	?>

	<section class="news_detail_section pt_40 pb_80">
		<div class="wrap">
			<div class="news_detail_container">

				<h1 class="h3_title_50 text-black"><?php echo esc_html( $title ); ?></h1>
				<?php if ( $has_date ) : ?>
				<div class="news_detail_header">
					<span class="news_detail_date"><?php echo esc_html( $date_display ); ?></span>
				</div>
				<?php endif; ?>
				<div class="news_detail_image">
					<?php
					if ( $detail_media_type === 'video' && ! empty( $detail_video ) ) {
						$video_desktop = is_array( $detail_video ) ? ( isset( $detail_video['url'] ) ? $detail_video['url'] : '' ) : $detail_video;
						if ( is_numeric( $detail_video ) ) {
							$video_desktop = wp_get_attachment_url( (int) $detail_video ) ?: $video_desktop;
						}
						$video_mobile = '';
						if ( ! empty( $detail_video_mobile ) ) {
							$video_mobile = is_array( $detail_video_mobile ) ? ( isset( $detail_video_mobile['url'] ) ? $detail_video_mobile['url'] : '' ) : $detail_video_mobile;
							if ( is_numeric( $detail_video_mobile ) ) {
								$video_mobile = wp_get_attachment_url( (int) $detail_video_mobile ) ?: $video_mobile;
							}
						}
						if ( empty( $video_mobile ) ) {
							$video_mobile = $video_desktop;
						}
						if ( $video_desktop ) {
							if ( $video_mobile === $video_desktop ) {
								// Same video: load only one
								echo '<video class="w_100" controls playsinline><source src="' . esc_url( $video_desktop ) . '" type="video/mp4"></video>';
							} else {
								// Different videos: mobile source first so browser picks correct one on initial load
								echo '<video class="w_100" controls playsinline>';
								echo '<source src="' . esc_url( $video_mobile ) . '" type="video/mp4" media="(max-width: 768px)">';
								echo '<source src="' . esc_url( $video_desktop ) . '" type="video/mp4" media="(min-width: 769px)">';
								echo '</video>';
							}
						} else {
							if ( function_exists( 'tasheel_listing_image_picture' ) ) {
								tasheel_listing_image_picture( $imgs['desktop'], $imgs['mobile'], $title );
							} else {
								echo '<img src="' . esc_url( $imgs['desktop'] ) . '" alt="' . esc_attr( $title ) . '">';
							}
						}
					} else {
						if ( function_exists( 'tasheel_listing_image_picture' ) ) {
							tasheel_listing_image_picture( $imgs['desktop'], $imgs['mobile'], $title );
						} else {
							echo '<img src="' . esc_url( $imgs['desktop'] ) . '" alt="' . esc_attr( $title ) . '">';
						}
					}
					?>
				</div>

				<div class="news_detail_content">
					<div class="news_detail_left_block">
						<?php if ( $has_any_date_time_block ) : ?>
						<div class="date_time_block_event_detail">
							<h5><?php esc_html_e( 'Date and Time', 'tasheel' ); ?></h5>
							<ul class="date_time_block_event_detail_list">
								<?php if ( $has_date ) : ?>
								<li>
									<span class="date_time_block_event_detail_list_item_span">
										<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/date-icn-event.svg' ); ?>" alt="<?php esc_attr_e( 'Date', 'tasheel' ); ?>">
										<?php echo esc_html( $date_for_detail ); ?>
									</span>
								</li>
								<?php endif; ?>
								<?php if ( $has_time ) : ?>
								<li>
									<span class="date_time_block_event_detail_list_item_span">
										<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/time-icn-event.svg' ); ?>" alt="<?php esc_attr_e( 'Time', 'tasheel' ); ?>">
										<?php echo esc_html( $event_time ); ?>
									</span>
								</li>
								<?php endif; ?>
								<?php if ( $has_location ) : ?>
								<li>
									<div class="event-map-block" id="event-map"></div>
									<span class="date_time_block_event_detail_list_item_location">
										<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/icon-event-location.svg' ); ?>" alt="<?php esc_attr_e( 'Location', 'tasheel' ); ?>">
										<?php echo esc_html( $map_location_text ); ?>
									</span>
								</li>
								<?php endif; ?>
							</ul>
						</div>
						<?php endif; ?>

						<ul class="news_detail_share_list">
							<li><?php esc_html_e( 'Share:', 'tasheel' ); ?></li>
							<li><a href="<?php echo esc_url( 'https://www.facebook.com/sharer/sharer.php?u=' . urlencode( get_permalink() ) ); ?>" target="_blank" rel="noopener noreferrer" aria-label="Facebook"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/fb-n.svg' ); ?>" alt="News"></a></li>
							<li></li>
							<li><a href="<?php echo esc_url( 'https://www.instagram.com/' ); ?>" target="_blank" rel="noopener noreferrer" aria-label="Instagram"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/insta-n.svg' ); ?>" alt="News"></a></li>
							<li></li>
							<li><a href="<?php echo esc_url( 'https://twitter.com/intent/tweet?url=' . urlencode( get_permalink() ) . '&text=' . urlencode( $title ) ); ?>" target="_blank" rel="noopener noreferrer" aria-label="Twitter"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/x-n.svg' ); ?>" alt="News"></a></li>
							<li></li>
							<li><a href="<?php echo esc_url( 'https://www.linkedin.com/shareArticle?mini=true&url=' . urlencode( get_permalink() ) . '&title=' . urlencode( $title ) ); ?>" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/in-n.svg' ); ?>" alt="News"></a></li>
							<li></li>
						</ul>
					</div>
					<div class="news_detail_right_block">
						<?php
						$right_subtitle = '';
						if ( $has_location && $location ) {
							$right_subtitle = $location;
							if ( $has_date ) {
								$right_subtitle .= ', ' . $date_right_line;
							}
						} elseif ( $has_date ) {
							$right_subtitle = $date_right_line;
						}
						if ( $right_subtitle !== '' ) :
							?>
						<h5><?php echo esc_html( $right_subtitle ); ?></h5>
						<?php endif; ?>

						<div class="event_detail_description">
							<?php the_content(); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<?php
	// Event Gallery: images, YouTube videos, or uploaded video files
	$gallery_items = array();
	if ( ! empty( $event_gallery_items ) && is_array( $event_gallery_items ) ) {
		foreach ( $event_gallery_items as $row ) {
			$item_type   = isset( $row['item_type'] ) ? $row['item_type'] : 'image';
			if ( $item_type === 'video' ) {
				$item_type = 'youtube';
			}
			$video_url   = isset( $row['video_url'] ) ? trim( (string) $row['video_url'] ) : '';
			$video_file  = isset( $row['video_file'] ) ? $row['video_file'] : '';
			$row_image   = isset( $row['image'] ) ? $row['image'] : null;
			$thumb_url   = '';
			$image_alt   = $title;
			$display_url = '';

			if ( $item_type === 'youtube' && $video_url !== '' ) {
				$vid_id = '';
				if ( preg_match( '#(?:youtube\.com/watch\?v=|youtu\.be/)([a-zA-Z0-9_-]+)#', $video_url, $m ) ) {
					$vid_id = $m[1];
				}
				if ( $vid_id ) {
					$youtube_thumb = 'https://img.youtube.com/vi/' . $vid_id . '/maxresdefault.jpg';
					$image_alt     = $title . ' - ' . __( 'Video', 'tasheel' );
					$display_url   = $video_url;
					// Prefer optional custom thumbnail when user adds one
					if ( is_array( $row_image ) && isset( $row_image['url'] ) && $row_image['url'] ) {
						$thumb_url = $row_image['url'];
					} elseif ( is_numeric( $row_image ) ) {
						$thumb_url = wp_get_attachment_image_url( (int) $row_image, 'full' );
					}
					if ( ! $thumb_url ) {
						$thumb_url = $youtube_thumb;
					}
				}
				if ( $display_url ) {
					$gallery_items[] = array(
						'image'     => $thumb_url ?: get_template_directory_uri() . '/assets/images/event-baner.jpg',
						'image_alt' => $image_alt,
						'is_video'  => true,
						'video_url' => $display_url,
					);
				}
			} elseif ( $item_type === 'video_file' && ! empty( $video_file ) ) {
				$file_url = is_array( $video_file ) && isset( $video_file['url'] ) ? $video_file['url'] : $video_file;
				if ( $file_url ) {
					$thumb_url = '';
					if ( is_array( $row_image ) && isset( $row_image['url'] ) ) {
						$thumb_url = $row_image['url'];
						$image_alt = isset( $row_image['alt'] ) ? $row_image['alt'] : ( isset( $row_image['title'] ) ? $row_image['title'] : $title );
					} elseif ( is_numeric( $row_image ) ) {
						$thumb_url = wp_get_attachment_image_url( (int) $row_image, 'full' );
						$image_alt = get_post_meta( (int) $row_image, '_wp_attachment_image_alt', true ) ?: $title;
					}
					$gallery_items[] = array(
						'image'     => $thumb_url ?: get_template_directory_uri() . '/assets/images/event-baner.jpg',
						'image_alt' => $title . ' - ' . __( 'Video', 'tasheel' ),
						'is_video'  => true,
						'video_url' => $file_url,
					);
				}
			} else {
				if ( is_array( $row_image ) && isset( $row_image['url'] ) ) {
					$thumb_url = $row_image['url'];
					$image_alt = isset( $row_image['alt'] ) ? $row_image['alt'] : ( isset( $row_image['title'] ) ? $row_image['title'] : $title );
				} elseif ( is_numeric( $row_image ) ) {
					$thumb_url = wp_get_attachment_image_url( (int) $row_image, 'full' );
					$image_alt = get_post_meta( (int) $row_image, '_wp_attachment_image_alt', true ) ?: $title;
				}
				if ( $thumb_url ) {
					$gallery_items[] = array( 'image' => $thumb_url, 'image_alt' => $image_alt, 'is_video' => false, 'video_url' => '' );
				}
			}
		}
	}
	if ( ! empty( $gallery_items ) ) {
		$project_gallery_data = array(
			'title'                 => esc_html__( 'Event Gallery', 'tasheel' ),
			'section_wrapper_class' => array(),
			'section_class'         => 'bg_color_01 pb_0',
			'gallery_items'         => $gallery_items,
		);
		get_template_part( 'template-parts/Project-Gallery', null, $project_gallery_data );
	}
	?>

	<?php
	if ( $has_location ) {
		$map_api_key = get_theme_mod( 'google_maps_api_key', 'AIzaSyAZY9WW5ucJZLvBYxY4cAeZYY8AvmjZygg' );
		?>
		<script type="text/javascript">
			(function() {
				window.eventMapConfig = {
					latitude: '<?php echo esc_js( $map_lat ); ?>',
					longitude: '<?php echo esc_js( $map_lng ); ?>',
					zoom: 15,
					apiKey: '<?php echo esc_js( $map_api_key ); ?>',
					title: '<?php echo esc_js( $map_location_text ); ?>'
				};
			})();
		</script>
		<?php
	}
	?>

	<?php
	$same_month_events = function_exists( 'tasheel_get_same_month_events' ) ? tasheel_get_same_month_events( $post_id, 6 ) : array();
	if ( ! empty( $same_month_events ) ) {
		$same_month_data = array(
			'title'                 => esc_html__( "What's Happening on The Same Month", 'tasheel' ),
			'events'                => $same_month_events,
			'section_wrapper_class' => array(),
			'section_class'         => 'pt_90 pb_80',
		);
		get_template_part( 'template-parts/Same-Month-Events', null, $same_month_data );
	}
	?>
</main>

<?php
endwhile;
get_footer();
