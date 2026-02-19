<?php get_header(''); 
   /*Template Name: HTML International Business  Development, Licensing*/
   wp_enqueue_script('script');
   add_action('wp_footer','page_script',21);
   function page_script(){
   ?>
<script>

jQuery(document).ready(function(){
//  
jQuery('.main-nav > ul > li').removeClass("active");
jQuery('.main-nav > ul :nth-child(3)').addClass("active");



});


   var markers = [];
   
   function initialize() {
   var locations = [
   
   	

    // -----------------main-----------start
    ['<div id="content-map" class="store-locator-info-window"><div id="siteNotice"></div><div id="bodyContent"> <p style="line-height:20pxfont-size:14px;text-align:center;color:#002543;text-transform:uppercase;font-weight:600;padding:0;margin-bottom:0;">UAE</p></div></div>',23.3999639,53.8500201, '<?php echo get_stylesheet_directory_uri(); ?>/images/main-pin.png', 1],
    ['<div id="content-map" class="store-locator-info-window"><div id="siteNotice"></div><div id="bodyContent"> <p style="line-height:20pxfont-size:14px;text-align:center;color:#002543;text-transform:uppercase;font-weight:600;padding:0;margin-bottom:0;">Singapore</p></div></div>',1.3452859,103.811959, '<?php echo get_stylesheet_directory_uri(); ?>/images/main-pin.png', 1],
    ['<div id="content-map" class="store-locator-info-window"><div id="siteNotice"></div><div id="bodyContent"> <p style="line-height:20pxfont-size:14px;text-align:center;color:#002543;text-transform:uppercase;font-weight:600;padding:0;margin-bottom:0;">Mauritius</p></div></div>',-20.3420551,57.4781237, '<?php echo get_stylesheet_directory_uri(); ?>/images/main-pin.png', 1],
    ['<div id="content-map" class="store-locator-info-window"><div id="siteNotice"></div><div id="bodyContent"> <p style="line-height:20pxfont-size:14px;text-align:center;color:#002543;text-transform:uppercase;font-weight:600;padding:0;margin-bottom:0;">India</p></div></div>',18.5622874,73.8821979, '<?php echo get_stylesheet_directory_uri(); ?>/images/main-pin.png', 1],
    ['<div id="content-map" class="store-locator-info-window"><div id="siteNotice"></div><div id="bodyContent"> <p style="line-height:20pxfont-size:14px;text-align:center;color:#002543;text-transform:uppercase;font-weight:600;padding:0;margin-bottom:0;">Vietnam</p></div></div>',13.7156467,108.4660325, '<?php echo get_stylesheet_directory_uri(); ?>/images/main-pin.png', 1],
    // -----------------main-----------end






   
    ['<div id="content-map" class="store-locator-info-window"><div id="siteNotice"></div><div id="bodyContent"> <p style="line-height:20pxfont-size:14px;text-align:center;color:#002543;text-transform:uppercase;font-weight:600;padding:0;margin-bottom:0;">Canada</p></div></div>',56.1505892,-106.3631975, '<?php echo get_stylesheet_directory_uri(); ?>/images/sub-pin.png', 1],
    ['<div id="content-map" class="store-locator-info-window"><div id="siteNotice"></div><div id="bodyContent"> <p style="line-height:20pxfont-size:14px;text-align:center;color:#002543;text-transform:uppercase;font-weight:600;padding:0;margin-bottom:0;">Ukraine</p></div></div>',48.4600656,30.9168816, '<?php echo get_stylesheet_directory_uri(); ?>/images/sub-pin.png', 1],
    ['<div id="content-map" class="store-locator-info-window"><div id="siteNotice"></div><div id="bodyContent"> <p style="line-height:20pxfont-size:14px;text-align:center;color:#002543;text-transform:uppercase;font-weight:600;padding:0;margin-bottom:0;">Thailand </p></div></div>',15.8699885,100.9924416, '<?php echo get_stylesheet_directory_uri(); ?>/images/sub-pin.png', 1],



     ['<div id="content-map" class="store-locator-info-window"><div id="siteNotice"></div><div id="bodyContent"> <p style="line-height:20pxfont-size:14px;text-align:center;color:#002543;text-transform:uppercase;font-weight:600;padding:0;margin-bottom:0;">Hongkong</p></div></div>',22.3385476,114.1365498, '<?php echo get_stylesheet_directory_uri(); ?>/images/sub-pin.png', 1],
     ['<div id="content-map" class="store-locator-info-window"><div id="siteNotice"></div><div id="bodyContent"> <p style="line-height:20pxfont-size:14px;text-align:center;color:#002543;text-transform:uppercase;font-weight:600;padding:0;margin-bottom:0;">Philippines</p></div></div>',22.2146729,114.1659844, '<?php echo get_stylesheet_directory_uri(); ?>/images/sub-pin.png', 1],
     ['<div id="content-map" class="store-locator-info-window"><div id="siteNotice"></div><div id="bodyContent"> <p style="line-height:20pxfont-size:14px;text-align:center;color:#002543;text-transform:uppercase;font-weight:600;padding:0;margin-bottom:0;">Uzbekistan</p></div></div>',41.3844388,64.5748158, '<?php echo get_stylesheet_directory_uri(); ?>/images/sub-pin.png', 1],
     ['<div id="content-map" class="store-locator-info-window"><div id="siteNotice"></div><div id="bodyContent"> <p style="line-height:20pxfont-size:14px;text-align:center;color:#002543;text-transform:uppercase;font-weight:600;padding:0;margin-bottom:0;">Cambodia </p></div></div>',12.5512144,104.9717244, '<?php echo get_stylesheet_directory_uri(); ?>/images/sub-pin.png', 1],
     ['<div id="content-map" class="store-locator-info-window"><div id="siteNotice"></div><div id="bodyContent"> <p style="line-height:20pxfont-size:14px;text-align:center;color:#002543;text-transform:uppercase;font-weight:600;padding:0;margin-bottom:0;">Myanmar </p></div></div>',21.9141902,95.9486041, '<?php echo get_stylesheet_directory_uri(); ?>/images/sub-pin.png', 1],





     ['<div id="content-map" class="store-locator-info-window"><div id="siteNotice"></div><div id="bodyContent"> <p style="line-height:20pxfont-size:14px;text-align:center;color:#002543;text-transform:uppercase;font-weight:600;padding:0;margin-bottom:0;">Nepal</p></div></div>',28.3965843,84.1130631, '<?php echo get_stylesheet_directory_uri(); ?>/images/sub-pin.png', 1],
     ['<div id="content-map" class="store-locator-info-window"><div id="siteNotice"></div><div id="bodyContent"> <p style="line-height:20pxfont-size:14px;text-align:center;color:#002543;text-transform:uppercase;font-weight:600;padding:0;margin-bottom:0;">Kenya </p></div></div>',-0.0722746,37.8883125, '<?php echo get_stylesheet_directory_uri(); ?>/images/sub-pin.png', 1],
     ['<div id="content-map" class="store-locator-info-window"><div id="siteNotice"></div><div id="bodyContent"> <p style="line-height:20pxfont-size:14px;text-align:center;color:#002543;text-transform:uppercase;font-weight:600;padding:0;margin-bottom:0;">Tanzania</p></div></div>',-6.4034768,34.8357098, '<?php echo get_stylesheet_directory_uri(); ?>/images/sub-pin.png', 1],
     ['<div id="content-map" class="store-locator-info-window"><div id="siteNotice"></div><div id="bodyContent"> <p style="line-height:20pxfont-size:14px;text-align:center;color:#002543;text-transform:uppercase;font-weight:600;padding:0;margin-bottom:0;">Sri Lanka </p></div></div>',7.8640899,80.7603968, '<?php echo get_stylesheet_directory_uri(); ?>/images/sub-pin.png', 1],
     ['<div id="content-map" class="store-locator-info-window"><div id="siteNotice"></div><div id="bodyContent"> <p style="line-height:20pxfont-size:14px;text-align:center;color:#002543;text-transform:uppercase;font-weight:600;padding:0;margin-bottom:0;">Burkina Faso </p></div></div>',12.1925512,-1.5779182, '<?php echo get_stylesheet_directory_uri(); ?>/images/sub-pin.png', 1],





     ['<div id="content-map" class="store-locator-info-window"><div id="siteNotice"></div><div id="bodyContent"> <p style="line-height:20pxfont-size:14px;text-align:center;color:#002543;text-transform:uppercase;font-weight:600;padding:0;margin-bottom:0;">Ivory Coast</p></div></div>',7.0620634,-5.5064627, '<?php echo get_stylesheet_directory_uri(); ?>/images/sub-pin.png', 1],
     ['<div id="content-map" class="store-locator-info-window"><div id="siteNotice"></div><div id="bodyContent"> <p style="line-height:20pxfont-size:14px;text-align:center;color:#002543;text-transform:uppercase;font-weight:600;padding:0;margin-bottom:0;">Gabon </p></div></div>',-0.832583,11.5951018, '<?php echo get_stylesheet_directory_uri(); ?>/images/sub-pin.png', 1],
     ['<div id="content-map" class="store-locator-info-window"><div id="siteNotice"></div><div id="bodyContent"> <p style="line-height:20pxfont-size:14px;text-align:center;color:#002543;text-transform:uppercase;font-weight:600;padding:0;margin-bottom:0;">Guinea</p></div></div>',10.4158483,-10.9955847, '<?php echo get_stylesheet_directory_uri(); ?>/images/sub-pin.png', 1],
     ['<div id="content-map" class="store-locator-info-window"><div id="siteNotice"></div><div id="bodyContent"> <p style="line-height:20pxfont-size:14px;text-align:center;color:#002543;text-transform:uppercase;font-weight:600;padding:0;margin-bottom:0;">Mali</p></div></div>',17.5560561,-4.0078052, '<?php echo get_stylesheet_directory_uri(); ?>/images/sub-pin.png', 1],
     ['<div id="content-map" class="store-locator-info-window"><div id="siteNotice"></div><div id="bodyContent"> <p style="line-height:20pxfont-size:14px;text-align:center;color:#002543;text-transform:uppercase;font-weight:600;padding:0;margin-bottom:0;">Niger</p></div></div>',17.3453326,9.1664732, '<?php echo get_stylesheet_directory_uri(); ?>/images/sub-pin.png', 1],




     ['<div id="content-map" class="store-locator-info-window"><div id="siteNotice"></div><div id="bodyContent"> <p style="line-height:20pxfont-size:14px;text-align:center;color:#002543;text-transform:uppercase;font-weight:600;padding:0;margin-bottom:0;">Senegal</p></div></div>',14.3567743,-14.4792546, '<?php echo get_stylesheet_directory_uri(); ?>/images/sub-pin.png', 1],
     ['<div id="content-map" class="store-locator-info-window"><div id="siteNotice"></div><div id="bodyContent"> <p style="line-height:20pxfont-size:14px;text-align:center;color:#002543;text-transform:uppercase;font-weight:600;padding:0;margin-bottom:0;">Togo </p></div></div>',8.6184462,0.8241126, '<?php echo get_stylesheet_directory_uri(); ?>/images/sub-pin.png', 1],
    //  ['<div id="content-map" class="store-locator-info-window"><div id="siteNotice"></div><div id="bodyContent"> <p style="line-height:20pxfont-size:14px;text-align:center;color:#002543;text-transform:uppercase;font-weight:600;padding:0;margin-bottom:0;">Tchand</p></div></div>',11.2073885,75.8216568, '<?php echo get_stylesheet_directory_uri(); ?>/images/sub-pin.png', 1],
     ['<div id="content-map" class="store-locator-info-window"><div id="siteNotice"></div><div id="bodyContent"> <p style="line-height:20pxfont-size:14px;text-align:center;color:#002543;text-transform:uppercase;font-weight:600;padding:0;margin-bottom:0;">Japan</p></div></div>',36.2017599,138.2367979, '<?php echo get_stylesheet_directory_uri(); ?>/images/sub-pin.png', 1],
     ['<div id="content-map" class="store-locator-info-window"><div id="siteNotice"></div><div id="bodyContent"> <p style="line-height:20pxfont-size:14px;text-align:center;color:#002543;text-transform:uppercase;font-weight:600;padding:0;margin-bottom:0;">Georgia </p></div></div>',42.2755534,43.3329135, '<?php echo get_stylesheet_directory_uri(); ?>/images/sub-pin.png', 1],






     ['<div id="content-map" class="store-locator-info-window"><div id="siteNotice"></div><div id="bodyContent"> <p style="line-height:20pxfont-size:14px;text-align:center;color:#002543;text-transform:uppercase;font-weight:600;padding:0;margin-bottom:0;">US</p></div></div>',36.9407758,-95.7334831, '<?php echo get_stylesheet_directory_uri(); ?>/images/sub-pin.png', 1],
     ['<div id="content-map" class="store-locator-info-window"><div id="siteNotice"></div><div id="bodyContent"> <p style="line-height:20pxfont-size:14px;text-align:center;color:#002543;text-transform:uppercase;font-weight:600;padding:0;margin-bottom:0;">Chile </p></div></div>',-26.8071184,-69.7658659, '<?php echo get_stylesheet_directory_uri(); ?>/images/sub-pin.png', 1],
     ['<div id="content-map" class="store-locator-info-window"><div id="siteNotice"></div><div id="bodyContent"> <p style="line-height:20pxfont-size:14px;text-align:center;color:#002543;text-transform:uppercase;font-weight:600;padding:0;margin-bottom:0;">Zambia</p></div></div>',-13.5119698,27.6848325, '<?php echo get_stylesheet_directory_uri(); ?>/images/sub-pin.png', 1],
     ['<div id="content-map" class="store-locator-info-window"><div id="siteNotice"></div><div id="bodyContent"> <p style="line-height:20pxfont-size:14px;text-align:center;color:#002543;text-transform:uppercase;font-weight:600;padding:0;margin-bottom:0;">Ethiopia </p></div></div>',8.5710847,39.6108808, '<?php echo get_stylesheet_directory_uri(); ?>/images/sub-pin.png', 1],

     ['<div id="content-map" class="store-locator-info-window"><div id="siteNotice"></div><div id="bodyContent"> <p style="line-height:20pxfont-size:14px;text-align:center;color:#002543;text-transform:uppercase;font-weight:600;padding:0;margin-bottom:0;">UK</p></div></div>',54.9665693,-2.713166, '<?php echo get_stylesheet_directory_uri(); ?>/images/sub-pin.png', 1],






    
   		
   ];
   
   if (jQuery(window).width() < 767) {
   var zoom =  2;
   }
   else {
   var zoom = 2 ;
   
   }
   
   var myLatlng = new google.maps.LatLng(15.3973117,53.9142207); 
   
   var mapOptions = {     
   
    zoom:5,
   
    zoomControl: true,
   
    scrollwheel: false,
   
    disableDefaultUI: true,
    
    center: myLatlng,  
    
    mapTypeId: google.maps.MapTypeId.ROADMAP,
    
   styles :[
     {
          "featureType": "water",
          "elementType": "geometry",
          "stylers": [
              {
                  "color": "#e9e9e9"
              },
              {
                  "lightness": 17
              }
          ]
      },
      {
          "featureType": "landscape",
          "elementType": "geometry",
          "stylers": [
              {
                  "color": "#f5f5f5"
              },
              {
                  "lightness": 20
              }
          ]
      },
      {
          "featureType": "road.highway",
          "elementType": "geometry.fill",
          "stylers": [
              {
                  "color": "#ffffff"
              },
              {
                  "lightness": 17
              }
          ]
      },
      {
          "featureType": "road.highway",
          "elementType": "geometry.stroke",
          "stylers": [
              {
                  "color": "#ffffff"
              },
              {
                  "lightness": 29
              },
              {
                  "weight": 0.2
              }
          ]
      },
      {
          "featureType": "road.arterial",
          "elementType": "geometry",
          "stylers": [
              {
                  "color": "#ffffff"
              },
              {
                  "lightness": 18
              }
          ]
      },
      {
          "featureType": "road.local",
          "elementType": "geometry",
          "stylers": [
              {
                  "color": "#ffffff"
              },
              {
                  "lightness": 16
              }
          ]
      },
      {
          "featureType": "poi",
          "elementType": "geometry",
          "stylers": [
              {
                  "color": "#f5f5f5"
              },
              {
                  "lightness": 21
              }
          ]
      },
      {
          "featureType": "poi.park",
          "elementType": "geometry",
          "stylers": [
              {
                  "color": "#dedede"
              },
              {
                  "lightness": 21
              }
          ]
      },
      {
          "elementType": "labels.text.stroke",
          "stylers": [
              {
                  "visibility": "on"
              },
              {
                  "color": "#ffffff"
              },
              {
                  "lightness": 16
              }
          ]
      },
      {
          "elementType": "labels.text.fill",
          "stylers": [
              {
                  "saturation": 36
              },
              {
                  "color": "#333333"
              },
              {
                  "lightness": 40
              }
          ]
      },
      {
          "elementType": "labels.icon",
          "stylers": [
              {
                  "visibility": "off"
              }
          ]
      },
      {
          "featureType": "transit",
          "elementType": "geometry",
          "stylers": [
              {
                  "color": "#f2f2f2"
              },
              {
                  "lightness": 19
              }
          ]
      },
      {
          "featureType": "administrative",
          "elementType": "geometry.fill",
          "stylers": [
              {
                  "color": "#fefefe"
              },
              {
                  "lightness": 20
              }
          ]
      },
      {
          "featureType": "administrative",
          "elementType": "geometry.stroke",
          "stylers": [
              {
                  "color": "#fefefe"
              },
              {
                  "lightness": 17
              },
              {
                  "weight": 1.2
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
   // script.src = 'https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyAckDfo-t9err2vrWBpmXVc9oVhemW3UTQ' + '&callback=initialize';
   script.src = 'https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyD1SPvz7vs1KPYNtGs4T4fa3a7nqzUzLqk' + '&callback=initialize';
   document.body.appendChild(script);
   }
   
   
   window.onload = loadScript;
   
   filterInfobox = function (id) {
   
   jQuery('.store-locator-address').removeClass('active');
   jQuery('#address_'+id).addClass('active');
   
   google.maps.event.trigger(markers[id], 'click');
   
   }
</script>
<?php } ?>
<section class="inner-banner-02 pattern" style="background:url(<?php echo get_stylesheet_directory_uri(); ?>/images/banner-new.png);background-size: cover;">
   <div class="banner-title-box">
      <h1 data-sr="wait 0.1s, enter right">International Business<br>Development, Licensing</h1>
      <span class="title-line"></span>
   </div>
</section>
<section class="pt-100 pb-30">
   <div class="wrap">
      <div class="flx-row top-align row-reverce">
         <div class="w-50 analytical-img-block align-right"  data-sr="wait 0.1s, enter right" >
            <img class="mx-100"  src="<?php  echo get_stylesheet_directory_uri(); ?>/images/health-care-img.jpg">
         </div>
         <div class="w-50 txt-block-01a t-l-line rel analytical-txt-block list-01a padding-l-t title-bold" data-sr="wait 0.1s, enter right" >
            <h2>
            We help you navigate the Global marketplace, together
            </h2>
            <p>To fulfil our promise to provide more accessibility of healthcare products  through innovative health care solutions. We are looking for reliable partners around the world and want to be a preferred partner that continuously provides a meaningful difference in the life of the people we serve.  We have an experienced team of in-house experts in commercial strategy, regulatory and scientific affairs, and our team offers project management support and valuable market knowledge. </p>
         </div>
      </div>
   </div>
</section>
<section class="pb-90 pt-70 provide-section">
   <div class="wrap">
      <div class="title-02a title-padding-b10" data-sr="wait 0.1s, enter right">
         <h2>We provide complete solutions for all your needs:</h2>
         <p >We are firm to become the preferred partner in all our markets and have a clear vision on how we want our company to nurture and progress, which is outlined in our strategic roadmap that shapes our customer commitments. </p>
      </div>
      <ul class="provide-list">
         <li data-sr="wait 0.1s, enter right">
            <div class="solution-block">
               <div class="icon">
               <a across class="m-0" href="#" ><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/rgt-ny-icn1.png" alt="icon"></a>
               </div>
               <div class="content">
                  <h4><a across class="m-0" href="#" >Branded Generic</a> <!-- <a across class="plus-icn" href="#">+</a>--></h4> 
                </div>
            </div>
         </li>
         <li data-sr="wait 0.1s, enter right">
            <div class="solution-block">
               <div class="icon">
               <a across class="m-0" href="#" ><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/rgt-ny-icn2.png" alt="icon"></a>
               </div>
               <div class="content">
                  <h4><a across class="m-0" href="#" >Generic</a> <!-- <a across class="plus-icn" href="#">+</a>--></h4>
                </div>
            </div>
         </li>
         <li data-sr="wait 0.1s, enter right">
            <div class="solution-block">
               <div class="icon">
               <a across class="m-0" href="#" ><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/rgt-ny-icn3.png" alt="icon"></a>
               </div>
               <div class="content">
                  <h4><a across class="m-0" href="#" >Nutraceuticals</a> <!-- <a across class="plus-icn" href="#">+</a>--></h4>
                </div>
            </div>
         </li>
         <li data-sr="wait 0.1s, enter right">
            <div class="solution-block">
               <div class="icon">
               <a across class="m-0" href="#" ><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/rgt-ny-icn4.png" alt="icon"></a>
               </div>
               <div class="content">
                  <h4><a across class="m-0" href="#" >Regulatory Services</a> <!-- <a across class="plus-icn" href="#">+</a>--></h4>
                </div>
            </div>
         </li>
         <li data-sr="wait 0.1s, enter right">
            <div class="solution-block">
               <div class="icon">
               <a across class="m-0" href="#" ><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/rgt-ny-icn5.png" alt="icon"></a>
               </div>
               <div class="content">
                  <h4><a across class="m-0" href="#" >Distribution</a> <!-- <a across class="plus-icn" href="#">+</a>--></h4>
                </div>
            </div>
         </li>
         <li data-sr="wait 0.1s, enter right">
            <div class="solution-block">
               <div class="icon">
               <a across class="m-0" href="#" ><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/rgt-ny-icn6.png" alt="icon"></a>
               </div>
               <div class="content">
                  <h4><a across class="m-0" href="#" >Special Import</a> <!-- <a across class="plus-icn" href="#">+</a>--></h4>
                </div>
            </div>
         </li>
         <li data-sr="wait 0.1s, enter right">
            <div class="solution-block">
               <div class="icon">
               <a across class="m-0" href="#" ><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/rgt-ny-icn7.png" alt="icon"></a>
               </div>
               <div class="content">
                  <h4><a across class="m-0" href="#" >Out -Licensing</a> <!-- <a across class="plus-icn" href="#">+</a>--></h4>
                </div>
            </div>
         </li>
         <li data-sr="wait 0.1s, enter right">
            <div class="solution-block">
               <div class="icon">
               <a across class="m-0" href="#" ><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/rgt-ny-icn8.png" alt="icon"></a>
               </div>
               <div class="content">
                  <h4><a across class="m-0" href="#" >In-Licensing</a> <!-- <a across class="plus-icn" href="#">+</a>--></h4>
                </div>
            </div>
         </li>
      </ul>

      <!-- data-fancybox="" data-src="#more-content" -->

      <!-- across -->
   </div>
</section>
 
<!-- <section class="map-sec-new pt-150 pb-80">
   <div class="wrap">
      <div class="maptitle-block">
     
         <h2>Global Presence</h2>
      </div>
      <div class="map-sec-block">
         <div class="map-ic-01 map-icn-block"><img src="<?php  echo get_stylesheet_directory_uri(); ?>/images/map-icn-01a.png"></div>
         <div class="map-ic-02 map-icn-block"><img src="<?php  echo get_stylesheet_directory_uri(); ?>/images/map-icn-01a.png"></div>
         <div class="map-ic-03 map-icn-block"><img src="<?php  echo get_stylesheet_directory_uri(); ?>/images/map-icn-01a.png"></div>
         <div class="map-ic-04 map-icn-block"><img src="<?php  echo get_stylesheet_directory_uri(); ?>/images/map-icn-01a.png"></div>
         <div class="map-ic-05 map-icn-block"><img src="<?php  echo get_stylesheet_directory_uri(); ?>/images/map-icn-01b.png"></div>
         <div class="map-ic-06 map-icn-block"><img src="<?php  echo get_stylesheet_directory_uri(); ?>/images/map-icn-01b.png"></div>
         <div class="map-ic-07 map-icn-block"><img src="<?php  echo get_stylesheet_directory_uri(); ?>/images/map-icn-01b.png"></div>
         <div class="map-ic-08 map-icn-block"><img src="<?php  echo get_stylesheet_directory_uri(); ?>/images/map-icn-01c.png"></div>
         <div class="map-ic-09 map-icn-block"><img src="<?php  echo get_stylesheet_directory_uri(); ?>/images/map-icn-01c.png"></div>
         <div class="map-ic-10 map-icn-block"><img src="<?php  echo get_stylesheet_directory_uri(); ?>/images/map-icn-01c.png"></div>
         <div class="map-ic-11 map-icn-block"><img src="<?php  echo get_stylesheet_directory_uri(); ?>/images/map-icn-01c.png"></div>
         <div class="map-ic-12 map-icn-block"><img src="<?php  echo get_stylesheet_directory_uri(); ?>/images/map-icn-01c.png"></div>
         <div class="map-ic-13 map-icn-block"><img src="<?php  echo get_stylesheet_directory_uri(); ?>/images/map-icn-01b.png"></div>
         <div class="map-ic-14 map-icn-block"><img src="<?php  echo get_stylesheet_directory_uri(); ?>/images/map-icn-01b.png"></div>
         <div class="map-ic-15 map-icn-block"><img src="<?php  echo get_stylesheet_directory_uri(); ?>/images/map-icn-01b.png"></div>
         <div class="map-ic-16 map-icn-block"><img src="<?php  echo get_stylesheet_directory_uri(); ?>/images/map-icn-01b.png"></div>
         <div class="map-ic-17 map-icn-block"><img src="<?php  echo get_stylesheet_directory_uri(); ?>/images/map-icn-01b.png"></div>
         <div class="map-ic-18 map-icn-block"><img src="<?php  echo get_stylesheet_directory_uri(); ?>/images/map-icn-01b.png"></div>
         <div class="map-ic-19 map-icn-block"><img src="<?php  echo get_stylesheet_directory_uri(); ?>/images/map-icn-01c.png"></div>
         <div class="map-ic-20 map-icn-block"><img src="<?php  echo get_stylesheet_directory_uri(); ?>/images/map-icn-01c.png"></div>
         <img class="glob-img" src="<?php  echo get_stylesheet_directory_uri(); ?>/images/map.svg">
      </div>


 
   </div>
</section> -->



<section  class="map-sec-new pt-150  ">

<div class="maptitle-block pb-30">
     
     <h2>Global Presence</h2>
  </div>

  

<div id="map" class="map-block"></div>

 


</section>






<div id="more-content"  class="max-width-pop" style="display: none;" class="list-popup">
 <div class="pop-txt-block">
   <div class="icn-block-pop">
      <img src="<?php  echo get_stylesheet_directory_uri(); ?>/images/rgt-ny-icn2-w.png">
   
 </div>

 <h3>Generic</h3>
 <p>Pellentesque nisl elit, varius eu sodales at, gravida non lectus. Etiam condimentum diam non varius lacinia. Nunc iaculis metus ligula, eget pulvinar neque ultricies eu. Pellentesque pellentesque mi non hendrerit tincidunt. Maecenas suscipit rhoncus nulla, aliquam laoreet nulla aliquet ac. Etiam pharetra vulputate volutpat. Donec rutrum bibendum erat a posuere.</p>
</div>
</div>

<?php get_footer('inner'); ?>