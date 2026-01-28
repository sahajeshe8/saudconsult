<?php
/**
 * Template Name: Event Detail
 *
 * The template for displaying the Event Detail page
 *
 * @package tasheel
 */
global $header_custom_class;
$header_custom_class = 'black-header';

get_header();
?>

<main id="primary" class="site-main no_banner_section">
 
	<?php 
	$breadcrumb_data = array(
		'breadcrumb_items' => array(
			array(
				'url' => esc_url( home_url( '/' ) ),
				'icon' => true
			),
			array(
				'title' => 'Media Center',
				'url' => esc_url( home_url( '/media-center' ) )
			),
			array(
				'title' => 'Events',
				'url' => esc_url( home_url( '/events' ) )
			),
			array(
				'title' => 'SAUDCONSULT at the World Stadiums and Arenas Summit',
				'url' => '' // Empty URL makes it active
			)
		),
		'section_wrapper_class' => array(),
		'section_class' => ''
	);
	get_template_part( 'template-parts/Breadcrumb', null, $breadcrumb_data ); 
	?>

	<section class="news_detail_section pt_80 pb_80">
		<div class="wrap">
			<div class="news_detail_container">
				
				<h1 class="h3_title_50 text-black">SAUDCONSULT at the World Stadiums and Arenas Summit</h1>
				<div class="news_detail_header">
					<span class="news_detail_date">September 13, 2024</span>
					 
				</div>
				<div class="news_detail_image">
					<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/event-baner.jpg' ); ?>" alt="Event Detail">
				</div>

		  <div class="news_detail_content">
            <div class="news_detail_left_block">
                  <div class="date_time_block_event_detail">
                     <h5>Date and Time</h5>
                     <ul class="date_time_block_event_detail_list">
                        <li>
                            <span class="date_time_block_event_detail_list_item_span">
                                <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/date-icn-event.svg' ); ?>" alt="Date">
                            February  13th – 15th, 2025
                            </span>
                        </li>
                        <li>
                        <span class="date_time_block_event_detail_list_item_span">
                                <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/time-icn-event.svg' ); ?>" alt="Date">
                                09:30 AM -12:00 PM
                            </span>
                        </li>
                        <li>

                        <div class="event-map-block" id="event-map"></div>

                        <span class="date_time_block_event_detail_list_item_location">
                            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/icon-event-location.svg' ); ?>" alt="Location">
                        Riyadh -  Kingdom of Saudi Arabia
                        </span>
                        </li>
                     </ul>
                  </div>
            </div>
            <div class="news_detail_right_block">
                <h5>Riyadh, KSA, 13 September 2024</h5>


                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin elementum justo quis tempor elementum. Cras dapibus, ante non egestas viverra, mi ante venenatis est, non feugiat sem elit eu nisl. Vivamus efficitur luctus rutrum. Nulla nisi turpis, elementum in cursus venenatis, vehicula non ante. Maecenas fermentum odio ut nisi tempus interdum. Sed posuere, mi eu tempor accumsan, mi sem consectetur quam, vel ultrices sapien enim sit amet felis. Phasellus mattis nulla ac condimentum scelerisque. Etiam accumsan non neque eget mattis. Vestibulum luctus fermentum sodales. Vivamus finibus cursus mollis. Integer condimentum finibus nibh id egestas. Curabitur efficitur nibh eros, in interdum risus ultrices at. Mauris neque lorem, fringilla sit amet elementum vitae, posuere a velit. Proin ac neque non nisi bibendum tincidunt id et neque.</p>

<p>Donec pellentesque orci tincidunt, ultricies dui at, pharetra metus. In in dolor egestas, lacinia enim vel, congue turpis. Nam in ligula lobortis, ultrices purus ut, sodales orci. Donec nulla nibh, condimentum in mauris quis, molestie luctus diam. Sed eget enim quis sapien fermentum consequat. Morbi dictum molestie lorem, ut faucibus enim sodales quis. Quisque nec augue consectetur justo facilisis laoreet. Nunc vulputate interdum nunc, nec tincidunt felis pellentesque fringilla. Sed elementum sed sem tempus tempus. Cras dapibus efficitur diam vitae finibus. Sed nec metus dolor. Praesent consequat eget purus id laoreet. Sed luctus, nibh sit amet ultricies placerat, orci dui imperdiet nibh, a porta arcu nisi eget nisl. Pellentesque quis rhoncus velit. Mauris pellentesque dui sed orci efficitur lobortis. Proin aliquet fringilla accumsan.</p>

<p>Morbi a ex ac sem malesuada elementum. Aliquam posuere dui quis mattis tincidunt. Maecenas iaculis est vitae dui luctus porttitor. Aliquam tristique iaculis dolor porta euismod. Sed eu lacus maximus, cursus risus vitae, scelerisque nulla. Quisque porttitor velit velit, id sagittis sem imperdiet sed. Ut pulvinar vestibulum orci ut lobortis. Donec facilisis justo ac mauris mattis posuere vitae ac elit.</p>

<p>Phasellus quis maximus risus. Etiam dictum vel libero eu convallis. Etiam accumsan dolor vitae augue aliquet mattis placerat et nisi. Suspendisse sollicitudin imperdiet metus hendrerit lobortis. Integer vulputate sodales odio, id ullamcorper nibh faucibus ac. Morbi blandit tincidunt libero, et pulvinar sem. Pellentesque tristique magna sed nisl porttitor, in faucibus lorem vulputate. Nullam cursus turpis lacinia nibh rhoncus imperdiet. Nunc vel magna consequat, finibus quam id, posuere dui.</p>
            </div>
          </div>
				</div>
			</div>
		</div>
	</section>

    <?php 
	$project_gallery_data = array(
		'title' => 'Event Gallery',
		'section_wrapper_class' => array(),
		'section_class' => 'bg_color_01 pb_0',
		'gallery_items' => array(
			array(
				'image' => get_template_directory_uri() . '/assets/images/pro-01.jpg',
				'image_alt' => 'Highway at night with traffic lights',
				'is_video' => false,
				'video_url' => ''
			),
			array(
				'image' => get_template_directory_uri() . '/assets/images/pro-02.jpg',
				'image_alt' => 'Highway with landscaped median',
				'is_video' => false,
				'video_url' => ''
			),
			array(
				'image' => get_template_directory_uri() . '/assets/images/project-video.jpg',
				'image_alt' => 'Highway at night',
				'is_video' => true,
				'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ'
			),
			array(
				'image' => get_template_directory_uri() . '/assets/images/pro-04.jpg',
				'image_alt' => 'Tunnel interior',
				'is_video' => false,
				'video_url' => ''
			)
            ,
			array(
				'image' => get_template_directory_uri() . '/assets/images/pro-04.jpg',
				'image_alt' => 'Tunnel interior',
				'is_video' => false,
				'video_url' => ''
			)
            ,
			array(
				'image' => get_template_directory_uri() . '/assets/images/pro-04.jpg',
				'image_alt' => 'Tunnel interior',
				'is_video' => false,
				'video_url' => ''
			)
		)
	);
	get_template_part( 'template-parts/Project-Gallery', null, $project_gallery_data ); 
	?>

	<?php
	// Map Configuration
	$map_api_key = get_theme_mod( 'google_maps_api_key', 'AIzaSyAZY9WW5ucJZLvBYxY4cAeZYY8AvmjZygg' );
	$marker_icon = get_template_directory_uri() . '/assets/images/marker-map.png';
	
	// Default location: Riyadh, KSA
	$event_latitude = '24.7136';
	$event_longitude = '46.6753';
	$event_location = 'Riyadh, KSA';
	?>
	
	<script type="text/javascript">
		(function() {
			window.eventMapConfig = {
				latitude: '<?php echo esc_js( $event_latitude ); ?>',
				longitude: '<?php echo esc_js( $event_longitude ); ?>',
				zoom: 15,
				apiKey: '<?php echo esc_js( $map_api_key ); ?>',
				markerIcon: '<?php echo esc_url( $marker_icon ); ?>',
				title: '<?php echo esc_js( $event_location ); ?>'
			};
		})();
	</script>

	<?php 
	$same_month_events_data = array(
		'title' => "What's Happening on The Same Month",
		'events' => array(
			array(
				'image' => get_template_directory_uri() . '/assets/images/event-01.jpg',
				'location' => 'Riyadh, KSA',
				'title' => 'SAUDCONSULT at the World Stadiums and Arenas Summit',
				'date' => 'Fri 13 Sep',
				'time' => '3:00 PM – 4:00 PM',
				'link' => '#'
			),
			array(
				'image' => get_template_directory_uri() . '/assets/images/event-02.jpg',
				'location' => 'Riyadh, KSA',
				'title' => 'SCE board Awards Dr. Eng. Tariq AlShawaf',
				'date' => 'Fri 13 Sep',
				'time' => '3:00 PM – 4:00 PM',
				'link' => '#'
			),
			array(
				'image' => get_template_directory_uri() . '/assets/images/event-02.jpg',
				'location' => 'Riyadh, KSA',
				'title' => 'SCE board Awards Dr. Eng. Tariq AlShawaf',
				'date' => 'Fri 13 Sep',
				'time' => '3:00 PM – 4:00 PM',
				'link' => '#'
			)

		),
		'section_wrapper_class' => array(),
		'section_class' => 'pt_80 pb_80'
	);
	get_template_part( 'template-parts/Same-Month-Events', null, $same_month_events_data ); 
	?>

</main><!-- #main -->

<?php
get_footer();

