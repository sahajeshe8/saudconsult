<?php
/**
 * Events List Component Template
 *
 * Events list section for Media Center page
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

// Dynamic events from CPT (when passed from media center).
$events_items = isset( $args['events_items'] ) && is_array( $args['events_items'] ) ? $args['events_items'] : array();
$show_empty_message = ! empty( $args['show_empty_message'] );

// Events listing URL (for "View all").
$events_page = get_page_by_path( 'events' );
$events_url = $events_page ? get_permalink( $events_page->ID ) : home_url( '/events' );
if ( post_type_exists( 'event' ) && get_option( 'permalink_structure' ) ) {
	$events_archive = get_post_type_archive_link( 'event' );
	if ( $events_archive ) {
		$events_url = $events_archive;
	}
}
?>

<div style="background: #272A2A url(<?php echo esc_url( get_template_directory_uri() . '/assets/images/event-bg.svg' ); ?>) no-repeat left top;" class="pt_100 events_list_section <?php echo esc_attr( $section_class ); ?> <?php echo $section_wrapper_class; ?>">
	<div class="events_list_wrapper">
		<div class="wrap">
			<?php if ( $title || $title_span ) : ?>
				<div class="title_block">
					<div class="title_block_left">
						<h3 class="h3_title_50 white_txt text-white">
							<?php if ( $title ) : ?><?php echo esc_html( $title ); ?><?php endif; ?>
							<?php if ( $title_span ) : ?> <?php echo esc_html( $title_span ); ?><?php endif; ?>
						</h3>
					</div>
					<div class="title_block_right">
						<a class="btn_style btn_transparent btn_green" href="<?php echo esc_url( $events_url ); ?>">
							<?php echo esc_html__( 'View all', 'tasheel' ); ?>
							<span><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/buttion-arrow.svg' ); ?>" alt="<?php echo esc_attr__( 'View All Events', 'tasheel' ); ?>"></span>
						</a>
					</div>
				</div>
			<?php endif; ?>
			<div class="events_list_pagination"></div>
		</div>
	</div>
	<div class="events_list_content pt_50">
		<div class="events_list_container">
			<ul class="events_list_ul">
				<?php if ( ! empty( $events_items ) ) : ?>
					<?php foreach ( $events_items as $item ) :
						$item_link    = isset( $item['link'] ) ? esc_url( $item['link'] ) : '#';
						$item_date    = isset( $item['date_display'] ) ? $item['date_display'] : '';
						$item_img_d   = isset( $item['image_desktop'] ) ? $item['image_desktop'] : ( isset( $item['image'] ) ? $item['image'] : get_template_directory_uri() . '/assets/images/event-img-01.jpg' );
						$item_img_m   = isset( $item['image_mobile'] ) ? $item['image_mobile'] : $item_img_d;
						$item_title   = isset( $item['title'] ) ? $item['title'] : '';
						$item_time    = isset( $item['time'] ) ? $item['time'] : '';
						$item_location = isset( $item['location'] ) ? $item['location'] : '';
					?>
						<li>
							<a href="<?php echo $item_link; ?>">
								<div class="events_list_item">
									<span class="events_list_item_date"><?php echo $item_date ? wp_kses_post( $item_date ) : ''; ?></span>
									<div class="events_list_item_image">
										<?php
										if ( function_exists( 'tasheel_listing_image_picture' ) ) {
											tasheel_listing_image_picture( $item_img_d, $item_img_m, $item_title );
										} else {
											echo '<img src="' . esc_url( $item_img_d ) . '" alt="' . esc_attr( $item_title ) . '">';
										}
										?>
									</div>
									<div class="events_list_item_content">
										<h4><?php echo esc_html( $item_title ); ?></h4>
										<ul class="events_detail_list">
											<?php if ( $item_time ) : ?>
												<li>
													<span class="events_detail_list_item_icon">
														<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/time-icn.svg' ); ?>" alt="<?php echo esc_attr__( 'Time', 'tasheel' ); ?>">
													</span>
													<span class="events_detail_list_item_text"><?php echo esc_html( $item_time ); ?></span>
												</li>
											<?php endif; ?>
											<?php if ( $item_location ) : ?>
												<li>
													<span class="events_detail_list_item_icon">
														<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/mark-icn.svg' ); ?>" alt="<?php echo esc_attr__( 'Location', 'tasheel' ); ?>">
													</span>
													<span class="events_detail_list_item_text"><?php echo esc_html( $item_location ); ?></span>
												</li>
											<?php endif; ?>
										</ul>
									</div>
								</div>
							</a>
						</li>
					<?php endforeach; ?>
				<?php elseif ( $show_empty_message ) : ?>
					<li>
						<div class="events_list_item events_list_item_empty">
							<p class="events_list_empty_message"><?php echo esc_html__( 'No events at the moment. Please check back later.', 'tasheel' ); ?></p>
						</div>
					</li>
				<?php else : ?>
					<li>
						<a href="<?php echo esc_url( $events_url ); ?>">
							<div class="events_list_item">
								<span class="events_list_item_date">30 <span>Jun</span></span>
								<div class="events_list_item_image">
									<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/event-img-01.jpg' ); ?>" alt="<?php echo esc_attr__( 'Events', 'tasheel' ); ?>">
								</div>
								<div class="events_list_item_content">
									<h4><?php echo esc_html__( 'Contracts awarded to Saudi consulting services company (Saudconsult)', 'tasheel' ); ?></h4>
									<ul class="events_detail_list">
										<li>
											<span class="events_detail_list_item_icon">
												<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/time-icn.svg' ); ?>" alt="<?php echo esc_attr__( 'Time', 'tasheel' ); ?>">
											</span>
											<span class="events_detail_list_item_text">3:00 PM – 4:00 PM</span>
										</li>
										<li>
											<span class="events_detail_list_item_icon">
												<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/mark-icn.svg' ); ?>" alt="<?php echo esc_attr__( 'Location', 'tasheel' ); ?>">
											</span>
											<span class="events_detail_list_item_text">Riyadh, KSA</span>
										</li>
									</ul>
								</div>
							</div>
						</a>
					</li>
				<?php endif; ?>
			</ul>
		</div>
	</div>
</div>

