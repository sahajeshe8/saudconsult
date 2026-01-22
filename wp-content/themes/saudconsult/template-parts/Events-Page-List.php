<?php
/**
 * Events Page List Component Template
 *
 * Events list section for Events page
 *
 * @package tasheel
 */

// Extract data from args array passed from get_template_part()
$args = isset( $args ) ? $args : array();

// Set default values or use passed values
$events = isset( $args['events'] ) ? $args['events'] : array();
?>

<div class="events_list_content">
	<div class="events_list_container">
		<ul class="events_list_ul_new_style_01" id="events-list">
			<li>
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
			</li>
			<li>
				<div class="event_item_img">
					<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/event-02.jpg' ); ?>" alt="Ministry of Transport Annual Confernce">
				</div>
				<div class="event_item_content">
					<span class="event_lable">Riyadh, KSA</span>
					<h5>Ministry of Transport Annual Confernce</h5>
					<ul class="event_item_content_list_ul">
						<li><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/date-icn-event.svg' ); ?>" alt="Date"> Fri 13 Sep</li>
						<li><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/time-icn-event.svg' ); ?>" alt="Time"> 3:00 PM – 4:00 PM</li>
					</ul>
				</div>
			</li>
			<li>
				<div class="event_item_img">
					<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/event-03.jpg' ); ?>" alt="SAUDCONSULT at the World Stadiums and Arenas Summit">
				</div>
				<div class="event_item_content">
					<span class="event_lable">Riyadh, KSA</span>
					<h5>SAUDCONSULT at the World Stadiums and Arenas Summit</h5>
					<ul class="event_item_content_list_ul">
						<li><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/date-icn-event.svg' ); ?>" alt="Date"> Fri 13 Sep</li>
						<li><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/time-icn-event.svg' ); ?>" alt="Time"> 3:00 PM – 4:00 PM</li>
					</ul>
				</div>
			</li>
			<li>
				<div class="event_item_img">
					<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/event-04.jpg' ); ?>" alt="SC being awarded a contract to begin groundwork for Coastal Village">
				</div>
				<div class="event_item_content">
					<span class="event_lable">Riyadh, KSA</span>
					<h5>SC being awarded a contract to begin groundwork for Coastal Village</h5>
					<ul class="event_item_content_list_ul">
						<li><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/date-icn-event.svg' ); ?>" alt="Date"> Fri 13 Sep</li>
						<li><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/time-icn-event.svg' ); ?>" alt="Time"> 3:00 PM – 4:00 PM</li>
					</ul>
				</div>
			</li>
			<li>
				<div class="event_item_img">
					<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/event-05.jpg' ); ?>" alt="The 2nd International Engineering Conference and Exhibition">
				</div>
				<div class="event_item_content">
					<span class="event_lable">Riyadh, KSA</span>
					<h5>The 2nd International Engineering Conference and Exhibition</h5>
					<ul class="event_item_content_list_ul">
						<li><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/date-icn-event.svg' ); ?>" alt="Date"> Fri 13 Sep</li>
						<li><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/time-icn-event.svg' ); ?>" alt="Time"> 3:00 PM – 4:00 PM</li>
					</ul>
				</div>
			</li>
			<li>
				<div class="event_item_img">
					<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/event-06.jpg' ); ?>" alt="The 2nd International Engineering Conference and Exhibition">
				</div>
				<div class="event_item_content">
					<span class="event_lable">Riyadh, KSA</span>
					<h5>The 2nd International Engineering Conference and Exhibition</h5>
					<ul class="event_item_content_list_ul">
						<li><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/date-icn-event.svg' ); ?>" alt="Date"> Fri 13 Sep</li>
						<li><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/time-icn-event.svg' ); ?>" alt="Time"> 3:00 PM – 4:00 PM</li>
					</ul>
				</div>
			</li>
			 
			 
		</ul>
	</div>
</div>

<div class="load_more_container">
	<button class="btn_style btn_transparent btn_green load_more_btn" id="events-load-more">
		Load More
	</button>
</div>

