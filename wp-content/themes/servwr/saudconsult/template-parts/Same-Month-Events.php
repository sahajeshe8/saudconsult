<?php
/**
 * Same Month Events Component Template
 *
 * Displays events happening in the same month
 *
 * @package tasheel
 */

// Extract data from args array passed from get_template_part()
$args = isset( $args ) ? $args : array();

// Set default values or use passed values
$title = isset( $args['title'] ) ? $args['title'] : "What's Happening on The Same Month";
$events = isset( $args['events'] ) ? $args['events'] : array();

// Handle section wrapper classes - can be array or string
$section_wrapper_class = isset( $args['section_wrapper_class'] ) ? $args['section_wrapper_class'] : array();
if ( is_array( $section_wrapper_class ) ) {
	$section_wrapper_class = ! empty( $section_wrapper_class ) ? implode( ' ', array_map( 'esc_attr', $section_wrapper_class ) ) : '';
} else {
	$section_wrapper_class = esc_attr( $section_wrapper_class );
}

$section_class = isset( $args['section_class'] ) ? $args['section_class'] : '';
?>

<section class="same_month_events_section <?php echo esc_attr( $section_class ); ?> <?php echo $section_wrapper_class; ?>">
	<div class="wrap">
		<?php if ( $title ) : ?>
			<div class="title_block">
				<div class="title_block_left">
					<h3 class="h3_title_50 green_txt">
						<?php echo esc_html( $title ); ?>
					</h3>
				</div>
			</div>
		<?php endif; ?>

		<div class="events_list_content">
			<div class="swiper same_month_events_swiper">
				<div class="swiper-wrapper">
					<?php if ( ! empty( $events ) ) : ?>
						<?php foreach ( $events as $event ) :
							$event_img_d    = isset( $event['image_desktop'] ) ? $event['image_desktop'] : ( isset( $event['image'] ) ? $event['image'] : '' );
							$event_img_m    = isset( $event['image_mobile'] ) ? $event['image_mobile'] : $event_img_d;
							$event_location = isset( $event['location'] ) ? $event['location'] : '';
							$event_title    = isset( $event['title'] ) ? $event['title'] : '';
							$event_date     = isset( $event['date'] ) ? $event['date'] : '';
							$event_time     = isset( $event['time'] ) ? $event['time'] : '';
							$event_link     = isset( $event['link'] ) ? $event['link'] : '#';
							if ( ! $event_img_d ) {
								$event_img_d = get_template_directory_uri() . '/assets/images/event-01.jpg';
								$event_img_m = $event_img_d;
							}
							// Fallbacks so layout matches design when ACF fields are empty
							if ( $event_location === '' ) {
								$event_location = '—';
							}
							if ( $event_time === '' ) {
								$event_time = '—';
							}
							if ( $event_date === '' ) {
								$event_date = '—';
							}
						?>
							<div class="swiper-slide">
								<a href="<?php echo esc_url( $event_link ); ?>">
									<div class="event_item_img">
										<?php
										if ( function_exists( 'tasheel_listing_image_picture' ) ) {
											tasheel_listing_image_picture( $event_img_d, $event_img_m, $event_title );
										} else {
											echo '<img src="' . esc_url( $event_img_d ) . '" alt="' . esc_attr( $event_title ) . '">';
										}
										?>
									</div>
									<div class="event_item_content">
										<span class="event_lable"><?php echo esc_html( $event_location ); ?></span>
										<h5><?php echo esc_html( $event_title ); ?></h5>
										<ul class="event_item_content_list_ul">
											<li><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/date-icn-event.svg' ); ?>" alt="<?php esc_attr_e( 'Date', 'tasheel' ); ?>"> <span><?php echo esc_html( $event_date ); ?></span></li>
											<li><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/time-icn-event.svg' ); ?>" alt="<?php esc_attr_e( 'Time', 'tasheel' ); ?>"> <span><?php echo esc_html( $event_time ); ?></span></li>
										</ul>
									</div>
								</a>
							</div>
						<?php endforeach; ?>
					<?php else : ?>
						<!-- Default events -->
						<div class="swiper-slide">
							<a href="#">
								<div class="event_item_img">
									<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/event-01.jpg' ); ?>" alt="SAUDCONSULT at the World Stadiums and Arenas Summit">
								</div>
								<div class="event_item_content">
									<span class="event_lable">Riyadh, KSA</span>
									<h5>SAUDCONSULT at the World Stadiums and Arenas Summit</h5>
									<ul class="event_item_content_list_ul">
										<li><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/date-icn-event.svg' ); ?>" alt="Date"> Fri 13 Sep</li>
										<li><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/time-icn-event.svg' ); ?>" alt="Time"> 3:00 PM – 4:00 PM</li>
									</ul>
								</div>
							</a>
						</div>
						<div class="swiper-slide">
							<a href="#">
								<div class="event_item_img">
									<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/event-02.jpg' ); ?>" alt="SCE board Awards Dr. Eng. Tariq AlShawaf">
								</div>
								<div class="event_item_content">
									<span class="event_lable">Riyadh, KSA</span>
									<h5>SCE board Awards Dr. Eng. Tariq AlShawaf</h5>
									<ul class="event_item_content_list_ul">
										<li><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/date-icn-event.svg' ); ?>" alt="Date"> <span>Fri 13 Sep</span></li>
										<li><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/time-icn-event.svg' ); ?>" alt="Time"> <span>3:00 PM – 4:00 PM</span></li>
									</ul>
								</div>
							</a>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</section>

