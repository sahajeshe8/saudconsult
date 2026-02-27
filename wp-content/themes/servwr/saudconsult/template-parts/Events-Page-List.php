<?php
/**
 * Events Page List Component Template
 *
 * Events list for Events listing page. Uses events_items when provided (from Event CPT).
 *
 * @package tasheel
 */

$args = isset( $args ) ? $args : array();
$events_items = isset( $args['events_items'] ) && is_array( $args['events_items'] ) ? $args['events_items'] : array();
$events_url   = isset( $args['events_url'] ) ? $args['events_url'] : home_url( '/events' );
$show_load_more_btn = isset( $args['show_load_more_btn'] ) ? (bool) $args['show_load_more_btn'] : true;
?>

<div class="events_list_content">
	<div class="events_list_container">
		<ul class="events_list_ul_new_style_01" id="events-list">
			<?php if ( ! empty( $events_items ) ) : ?>
				<?php foreach ( $events_items as $item ) :
					$item_link      = isset( $item['link'] ) ? esc_url( $item['link'] ) : '#';
					$item_img_d     = isset( $item['image_desktop'] ) ? $item['image_desktop'] : ( isset( $item['image'] ) ? $item['image'] : get_template_directory_uri() . '/assets/images/event-01.jpg' );
					$item_img_m     = isset( $item['image_mobile'] ) ? $item['image_mobile'] : $item_img_d;
					$item_title     = isset( $item['title'] ) ? $item['title'] : '';
					$item_location  = isset( $item['location'] ) ? $item['location'] : '';
					$item_date_short = isset( $item['date_short'] ) ? $item['date_short'] : '';
					$item_time      = isset( $item['time'] ) ? $item['time'] : '';
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
									<li><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/date-icn-event.svg' ); ?>" alt="<?php echo esc_attr__( 'Date', 'tasheel' ); ?>"><span> <?php echo esc_html( $item_date_short ); ?></span></li>
								<?php endif; ?>
								<?php if ( $item_time ) : ?>
									<li><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/time-icn-event.svg' ); ?>" alt="<?php echo esc_attr__( 'Time', 'tasheel' ); ?>"><span> <?php echo esc_html( $item_time ); ?></span></li>
								<?php endif; ?>
							</ul>
						</div>
					</li>
				<?php endforeach; ?>
			<?php else : ?>
				<li class="events_list_empty">
					<p class="events_no_items"><?php echo esc_html__( 'No events found.', 'tasheel' ); ?></p>
				</li>
			<?php endif; ?>
		</ul>
	</div>
</div>

<?php if ( $show_load_more_btn && count( $events_items ) > 12 ) : ?>
	<div class="load_more_container">
		<button class="btn_style btn_transparent btn_green load_more_btn" id="events-load-more">
			<?php echo esc_html__( 'Load More', 'tasheel' ); ?>
		</button>
	</div>
<?php endif; ?>

