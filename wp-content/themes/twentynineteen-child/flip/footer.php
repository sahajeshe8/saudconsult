<?php wp_footer(); ?>
<?php if(!is_page_template('promo-page.php')){ ?>
<section class="map-widget">
    <div class="map-area" id="view-map">
        <figure>
            <picture>
                <source srcset="<?php echo get_field('map_cover_image_webp', 'options')['url']; ?>" type="image/webp">
                <source srcset="<?php echo get_field('map_cover_image', 'options')['url']; ?>" type="image/png">
                <img src="<?php echo get_field('map_cover_image', 'options')['url']; ?>" alt=image>
            </picture>
        </figure>
    </div>
    <?php if(get_field('is_hide_title', 'options')!=1){ ?> <div class="map-box-heading-wrap">
        <div class="container">
            <?php if(get_field('come_visit_us_today', 'options')){ ?><span id="view-map-txt"><?php the_field('come_visit_us_today', 'options'); ?> <!-- <img src="<?php echo get_template_directory_uri(); ?>/assets/images/arrow-forward.png" alt="image" class="normal-view"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/arrow-forward-blk.png" alt="image" class="on-hover"> --> </span>  <?php } ?>
        </div>
    </div>  <?php } ?>
    <div class="location-map-wrap">
             <?php if(get_field('is_iframe', 'options')){ ?>
        <div class="map-view">
             <span class="map-close"><i class="fa-solid fa-xmark"></i></span>
           <?php the_field('iframe_checkbox', 'options'); ?>
        </div>
        <?php } else {  ?>
             <div class="map-view" id="map"></div>
            <?php } ?>
    </div>
</section>
<footer class="footer">
	<div class="container">
		<div class="footer-inner">
			<div class="footer-left-wrap">
				<div class="footer-left-info">
                    <?php           
           $right_side_address = get_field('right_side_address', 'options'); 
            if( $right_side_address ) :
                $address_more = $right_side_address['address_more'];          
                if( $address_more ) {   
                    foreach( $address_more as $address ) { ?>   
					<div class="footer-address-area">
						<?php echo $address['address_detail']; ?>
					</div>
					<div class="footer-contact-info">
						<p><?php echo $address['toll_free']; ?> <a href="tel:<?php echo $address['toll_free_phone_number']; ?>"><?php echo $address['toll_free_phone_number']; ?></a></p>
						<p><?php echo $address['phone']; ?> <a href="tel:<?php echo $address['phone_number']; ?>"><?php echo $address['phone_number']; ?></a></p>
						<p><?php echo $address['email']; ?> <a href="mailto:<?php echo $address['email_address']; ?>"><?php echo $address['email_address']; ?></a></p>
					</div>
                   <?php } ?>
                   <?php } ?>
                <?php endif; ?>

                    <?php
// Check rows exists.
					if (have_rows('social_media', 'options')) :?>
                       			<ul class="footer-social-media">
                            <?php
						// Loop through rows.
						while (have_rows('social_media', 'options')) : the_row(); ?>

							<li><a href="<?php the_sub_field('sm_link', 'options'); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php the_sub_field('sm_name', 'options'); ?> icon"><i class="fa-brands <?php the_sub_field('sm_icon', 'options'); ?>"></i></a>
                            </li>

					<?php
						// End loop.
						endwhile;?>
                            
                        </ul>
                        <?php
					// No value.
					else :
					// Do something...
					endif; ?>
					
				</div>
               <?php  if (have_rows('reception_hours', 'options')) :?>
				<div class="footer-left-time-hour-wrap">
					<?php
						// Loop through rows.
						while (have_rows('reception_hours', 'options')) : the_row(); ?>

                <div class="footer-left-time-hour">
						<span><?php the_sub_field('block_title', 'options'); ?></span>
                        <?php  if (have_rows('timings')) :
                            while (have_rows('timings')) : the_row(); ?>
						<p><strong><?php the_sub_field('t_date', 'options'); ?> </strong><?php the_sub_field('t_time', 'options'); ?></p>
                        <?php endwhile; 
                        endif; ?>
						
					</div>
                    <?php
						// End loop.
						endwhile;?>
					
                    <!-- <div class="footer-left-time-hour">
						<span>Call Centre Hours</span>
						<p><strong>Monday - Friday: </strong>8.30Am to 8.00Pm</p>
						<p><strong>Sunday: </strong>10.00Am to 4.00Pm</p>
					</div> -->

				</div>
                <?php
					// No value.
					else :
					// Do something...
					endif; ?>
			</div>
			<div class="footer-right-menu-wrap">
                <?php
                  wp_nav_menu(
                     array(
                        'theme_location' => 'footer-menu',
                        'menu_class' => 'footer-menu',
                        'container' => 'ul'
                     )
                  );
               ?>
              <?php
                  wp_nav_menu(
                     array(
                        'theme_location' => 'footer-menu2',
                        'menu_class' => 'footer-menu',
                        'container' => 'ul'
                     )
                  );
               ?>
               <?php
                  wp_nav_menu(
                     array(
                        'theme_location' => 'privacy-policy',
                        'menu_class' => 'footer-menu',
                        'container' => 'ul'
                     )
                  );
               ?>
				
				
			</div>
		</div>
		<div class="footer-copy-right">
			<p><?php the_field('copy_right', 'options'); ?></p>
		</div>
	</div>
    <?php /* if(get_field('whatsapp_number', 'options')){?>
	<div class="whats-app-icon">
		<a href="https://wa.me/send?phone=<?php the_field('whatsapp_number', 'options'); ?>" target="_blank"><i class="fa-brands fa-whatsapp"></i></a>
	</div>
    <?php } */ ?>
    <!-- Back to top button -->
    <a id="back-to-top"></a>
</footer>
<?php } ?>
<?php if( have_rows('map_pins','options') ): ?>

<script>
    // ----------tab------
    var markers = [];
    function initialize() {

    var locations = [
        <?php $m=1; while( have_rows('map_pins','options') ): the_row();  ?>
      ['<div id="content-map" class="store-locator-info-window"><p><?php the_sub_field('map_address'); ?></p><a href="mailto:<?php the_sub_field('map_email'); ?>"><?php the_sub_field('map_email'); ?></a><a href="tel:<?php the_sub_field('map_phone'); ?>"><?php the_sub_field('map_phone'); ?></a></div>', <?php the_sub_field('map_latitude'); ?>,<?php the_sub_field('map_longitude'); ?>, '<?php echo get_template_directory_uri(); ?>/assets/images/map-marker.png', <?php echo $m; ?>],       
  <?php $m++; endwhile; ?>
    ];

    var zoom = 17;

    var myLatlng = new google.maps.LatLng(25.1186154,55.3755325);

    var mapOptions = {     

    zoom: zoom,

    zoomControl: true,

    scrollwheel: false,

    disableDefaultUI: true,

    center: myLatlng,  

    mapTypeId: google.maps.MapTypeId.ROADMAP,

    styles :[
    {
        "featureType": "administrative.country",
        "elementType": "geometry",
        "stylers": [
            {
                "visibility": "on"
            }
        ]
    },
    {
        "featureType": "administrative.country",
        "elementType": "geometry.stroke",
        "stylers": [
            {
                "visibility": "on"
            }
        ]
    },
    {
        "featureType": "administrative.country",
        "elementType": "labels.text",
        "stylers": [
            {
                "visibility": "on"
            }
        ]
    },
    {
        "featureType": "administrative.country",
        "elementType": "labels.text.fill",
        "stylers": [
            {
                "visibility": "on"
            }
        ]
    },
    {
        "featureType": "administrative.country",
        "elementType": "labels.text.stroke",
        "stylers": [
            {
                "visibility": "on"
            }
        ]
    },
    {
        "featureType": "administrative.country",
        "elementType": "labels.icon",
        "stylers": [
            {
                "visibility": "on"
            }
        ]
    },
    {
        "featureType": "administrative.province",
        "elementType": "geometry",
        "stylers": [
            {
                "visibility": "on"
            }
        ]
    },
    {
        "featureType": "administrative.province",
        "elementType": "geometry.fill",
        "stylers": [
            {
                "visibility": "on"
            }
        ]
    },
    {
        "featureType": "administrative.province",
        "elementType": "geometry.stroke",
        "stylers": [
            {
                "visibility": "on"
            }
        ]
    },
    {
        "featureType": "administrative.province",
        "elementType": "labels.text",
        "stylers": [
            {
                "visibility": "on"
            }
        ]
    },
    {
        "featureType": "administrative.province",
        "elementType": "labels.text.fill",
        "stylers": [
            {
                "visibility": "on"
            }
        ]
    },
    {
        "featureType": "administrative.province",
        "elementType": "labels.text.stroke",
        "stylers": [
            {
                "visibility": "on"
            }
        ]
    },
    {
        "featureType": "administrative.province",
        "elementType": "labels.icon",
        "stylers": [
            {
                "visibility": "on"
            }
        ]
    }
]          
                    
    };    

    window.map = new google.maps.Map(document.getElementById('map'), mapOptions);
    var infowindow = new google.maps.InfoWindow();
    var bounds = new google.maps.LatLngBounds();
    for (i = 0; i < locations.length; i++) {
    marker = new google.maps.Marker({
    position: new google.maps.LatLng(locations[i][1], locations[i][2]),
    map: map,
    icon: locations[i][3],
    animation: google.maps.Animation.DROP
    });


    bounds.extend(marker.position);
    markers.push(marker);
    google.maps.event.addListener(marker, 'click', (function (marker, i) {
    return function () {
    infowindow.setContent(locations[i][0]);
    infowindow.open(map, marker);
    jQuery('.store-locator-address').removeClass('active');
    jQuery('#address_'+i).addClass('active');
    }
    })(marker, i));
    }

    map.fitBounds(bounds);

    var listener = google.maps.event.addListener(map, "idle", function () {
    map.setZoom(zoom);
    google.maps.event.removeListener(listener);
    });

    google.maps.event.addListener(infowindow,'closeclick',function(){
    jQuery('.store-locator-address').removeClass('active');
    });
    }
    function loadScript() {
    var script = document.createElement('script');
    script.type = 'text/javascript';
    script.src = 'https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyAckDfo-t9err2vrWBpmXVc9oVhemW3UTQ&' + 'callback=initialize';
    document.body.appendChild(script);
    }

    window.onload = loadScript;

    filterInfobox = function (id) {

    jQuery('.store-locator-address').removeClass('active');
    jQuery('#address_'+id).addClass('active');
    google.maps.event.trigger(markers[id], 'click');

    }
</script>
 <?php endif; ?>