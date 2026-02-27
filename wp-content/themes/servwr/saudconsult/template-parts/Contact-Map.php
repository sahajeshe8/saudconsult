<?php
/**
 * Contact Map Component Template
 *
 * Google Map section for the Contact Us page with dark Snazzy Maps style
 *
 * @package tasheel
 */

// Extract data from args array passed from get_template_part()
$args = isset( $args ) ? $args : array();

// Map section uses only this class (no pt_80/pb_80 or other classes from callers)
$wrapper_class_string = 'contact_map_section';

// Map Configuration
$map_api_key = get_theme_mod( 'google_maps_api_key', 'AIzaSyAZY9WW5ucJZLvBYxY4cAeZYY8AvmjZygg' );
$marker_icon = get_template_directory_uri() . '/assets/images/marker-map.png';

// Default marker: Riyadh, Saudi Arabia
$default_markers = array(
	array(
		'latitude'  => '24.7136',
		'longitude' => '46.6753',
		'title'     => 'Riyadh Office',
		'address'   => 'P.O. Box 2341 RIYADH 11451, Kingdom of Saudi Arabia',
	),
);

// Use ACF markers/zoom when passed from renderer, else theme mod, else defaults
$markers = isset( $args['markers'] ) && is_array( $args['markers'] ) && ! empty( $args['markers'] )
	? $args['markers']
	: get_theme_mod( 'contact_map_markers', $default_markers );
if ( ! is_array( $markers ) || empty( $markers ) ) {
	$markers = $default_markers;
}

$zoom = 0;
if ( isset( $args['zoom'] ) && (int) $args['zoom'] >= 1 && (int) $args['zoom'] <= 20 ) {
	$zoom = (int) $args['zoom'];
}
if ( $zoom === 0 ) {
	$zoom = (int) get_theme_mod( 'contact_map_zoom', 12 );
}
if ( $zoom < 1 || $zoom > 20 ) {
	$zoom = 12;
}
?>

<section class="<?php echo esc_attr( $wrapper_class_string ); ?>">
	<div class="contact_map_wrapper" data-aos="fade-up" data-aos-duration="800" data-aos-once="true">
		<div id="contactMap" class="contact_map_container"></div>
	</div>

	<script type="text/javascript">
		(function() {
			window.contactMapConfig = {
				markers: <?php echo wp_json_encode( $markers ); ?>,
				zoom: <?php echo (int) $zoom; ?>,
				apiKey: '<?php echo esc_js( $map_api_key ); ?>',
				markerIcon: '<?php echo esc_url( $marker_icon ); ?>'
			};
		})();
	</script>
</section>
