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

// Set default values or use passed values
$section_wrapper_class = isset( $args['section_wrapper_class'] ) ? $args['section_wrapper_class'] : array();
$section_class = isset( $args['section_class'] ) ? $args['section_class'] : '';

// Build section wrapper classes
$wrapper_classes = array( 'contact_map_section'  );
if ( $section_wrapper_class ) {
	if ( is_array( $section_wrapper_class ) ) {
		$wrapper_classes = array_merge( $wrapper_classes, $section_wrapper_class );
	} else {
		$wrapper_classes[] = $section_wrapper_class;
	}
}
$wrapper_class_string = implode( ' ', array_map( 'esc_attr', $wrapper_classes ) );

// Map Configuration
$map_api_key = get_theme_mod( 'google_maps_api_key', 'AIzaSyAZY9WW5ucJZLvBYxY4cAeZYY8AvmjZygg' );
$marker_icon = get_template_directory_uri() . '/assets/images/marker-map.png';

// Default marker: Riyadh, Saudi Arabia
$default_markers = array(
	array(
		'latitude' => '24.7136',
		'longitude' => '46.6753',
		'title' => 'Riyadh Office',
		'address' => 'P.O. Box 2341 RIYADH 11451, Kingdom of Saudi Arabia'
	),
);

// Get markers from theme mods or use defaults
$markers = get_theme_mod( 'contact_map_markers', $default_markers );
if ( ! is_array( $markers ) || empty( $markers ) ) {
	$markers = $default_markers;
}
?>

<section class="<?php echo $wrapper_class_string; ?> <?php echo esc_attr( $section_class ); ?>">
	<div class="contact_map_wrapper" data-aos="fade-up" data-aos-duration="800" data-aos-once="true">
		<div id="contactMap" class="contact_map_container"></div>
	</div>
	
	<script type="text/javascript">
		(function() {
			window.contactMapConfig = {
				markers: <?php echo json_encode( $markers ); ?>,
				zoom: <?php echo esc_js( get_theme_mod( 'contact_map_zoom', '12' ) ); ?>,
				apiKey: '<?php echo esc_js( $map_api_key ); ?>',
				markerIcon: '<?php echo esc_url( $marker_icon ); ?>'
			};
		})();
	</script>
</section>

