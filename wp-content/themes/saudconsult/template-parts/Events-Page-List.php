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
		<ul class="events_list_ul" id="events-list">
			<li>fgf</li>
			<li>fgf</li>
			<li>fgfg</li>
		</ul>
	</div>
</div>

<div class="load_more_container">
	<button class="btn_style btn_transparent btn_green load_more_btn" id="events-load-more">
		Load More
	</button>
</div>

