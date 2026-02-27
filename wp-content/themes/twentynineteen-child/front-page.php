<?php
   /**
    * The front page template file
    *
    * If the user has selected a static page for their homepage, this is what will
    * appear.
    * Learn more: https://codex.wordpress.org/Template_Hierarchy
    *
    * @package WordPress
    * @subpackage Twenty_Seventeen
    * @since 1.0
    * @version 1.0
    */
   
   get_header(); 
   function wpdocs_dequeue_script() {
      wp_dequeue_style( 'fancybox', get_stylesheet_uri() );

   }
   

   add_action('wp_footer','page_script',21);
   function page_script(){
   ?>
<script>
   var markers = [];
   
   function initialize() {
   var locations = [
   
   	
   
   
     ['<div id="content-map" class="store-locator-info-window"><div id="siteNotice"></div><div id="bodyContent"> <p style="line-height:20pxfont-size:14px;text-align:center;color:#002543;text-transform:uppercase;font-weight:600;padding:0;margin-bottom:0;">1307, JBC-2,Cluster-V, Jumeirah Lake Tower, Dubai</p></div></div>',25.0777982,55.1508309, '<?php echo get_stylesheet_directory_uri(); ?>/images/marker.png', 1],
     ['<div id="content-map" class="store-locator-info-window"><div id="siteNotice"></div><div id="bodyContent"> <p style="line-height:20pxfont-size:14px;text-align:center;color:#002543;text-transform:uppercase;font-weight:600;padding:0;margin-bottom:0;">60 Paya Lebar Road, #06-01, Paya Lebar Square, Singapore 409051</p></div></div>',1.3190251,103.8924167, '<?php echo get_stylesheet_directory_uri(); ?>/images/marker-2.png', 1],
     ['<div id="content-map" class="store-locator-info-window"><div id="siteNotice"></div><div id="bodyContent"> <p style="line-height:20pxfont-size:14px;text-align:center;color:#002543;text-transform:uppercase;font-weight:600;padding:0;margin-bottom:0;">BPML, Freeport Zone -9, Plaine Magnien -51505, Mauritius.</p></div></div>',-20.4284922,57.6715361, '<?php echo get_stylesheet_directory_uri(); ?>/images/marker.png', 1],
     ['<div id="content-map" class="store-locator-info-window"><div id="siteNotice"></div><div id="bodyContent"> <p style="line-height:20pxfont-size:14px;text-align:center;color:#002543;text-transform:uppercase;font-weight:600;padding:0;margin-bottom:0;">Sava house, Viman Nagar, Pune</p></div></div>',18.5628323,73.9077251, '<?php echo get_stylesheet_directory_uri(); ?>/images/marker-3.png', 1],
     ['<div id="content-map" class="store-locator-info-window"><div id="siteNotice"></div><div id="bodyContent"> <p style="line-height:20pxfont-size:14px;text-align:center;color:#002543;text-transform:uppercase;font-weight:600;padding:0;margin-bottom:0;">No. 22, Le Van Mien,Thao Dien Ward,District 2, Ho Chi Minh City, Vietnam</p></div></div>',10.8050601,106.7314802, '<?php echo get_stylesheet_directory_uri(); ?>/images/marker.png', 1],

   
   	  
   
   
   
    
   		
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
<section class="main-banner over-flow-fls rel" >
   <!-- style="background:url(<?php// echo get_stylesheet_directory_uri(); ?>/images/banner.jpg) center top" -->
   <!-- <img src="<?php  echo get_stylesheet_directory_uri(); ?>/images/banner.jpg"> -->
   <?php  echo do_shortcode("[rev_slider alias='banner'][/rev_slider]"); ?>

   <ul class="banner-chat-ul">
      <li><a href="#"><img  src="<?php  echo get_stylesheet_directory_uri(); ?>/images/wtsap-icn.png"></a></li>
      <li><a href="#"><img  src="<?php  echo get_stylesheet_directory_uri(); ?>/images/chat-icn.png"></a></li>
   </ul>
 </section>
<section class="pt-110 pb-100" style="background:url(<?php echo get_stylesheet_directory_uri(); ?>/images/bg-01.jpg) center center; background-size: cover;" >
   <div class="wrap">
      <div class="w-68">
         <div class="title-main" data-sr="wait 0.1s, enter right">
            <h2>
            <span class="main-title-01b"><span style="color:#78397f">R</span><span style="color:#0099da">e</span><span style="color:#ed3136">g</span><span style="color:#78397f">e</span><span style="color:#0096d9">n</span><span style="color:#ed3035">t</span></span>
            <br>Accelerating accessibility to strengthen Healthcare
            </h2>
         </div>
         <div data-sr="wait 0.1s, enter right">
            <p>Regent Global is a privately owned Dubai based company focused on developing, In-licensing, out-licensing, manufacturing, marketing, distributing and trading of pharmaceutical products for Human and Veterinary use. Our commitment is to provide access to medicines on global level using our know-how, regulatory expertise and network of supplies from over 30+ countries, we deliver access to the global health system through our distribution hubs in the Dubai, India, Singapore, and more. We focus each day on our mission to improve lives, through the quality, accessibility and affordability of our products. </p>
            <a href="<?php echo site_url('/about-us');?>" class="but-01">More about us</a>
         </div>
      </div>
   </div>
</section>
<section class="pt-110 pb-110 service-sec">
   <div class="wrap">
      <div class="title-row align-center">
         <div class="pb-10">
            <img  src="<?php  echo get_stylesheet_directory_uri(); ?>/images/about-icn.png">
         </div>
         <h2>Our Services</h2>
         <p> For nearly 15 years, we have been committed to supporting healthcare professionals by making products more accessible and affordable. As we look to future, we are committed to our diversified services while guaranteeing as the most reliable partner.</p>
      </div>
      <ul class="home-service-block">
         <li data-sr="wait 0.1s, enter right">
            <div class="service-block-01 zoom-ef ">
               <a href="<?php echo site_url('/services#contract-research-development');?>">
                  <div class="service-txt-block">
                     <h3>
                        Contract Research &
                        Development
                     </h3>
                  </div>
                  <img class="res-img"  src="<?php  echo get_stylesheet_directory_uri(); ?>/images/service-01.jpg">
               </a>
            </div>
         </li>
         <li data-sr="wait 0.1s, enter right">
            <div class="service-block-01 zoom-ef ">
               <a href="<?php echo site_url('/services#international-business-development-licensing');?>">
                  <div class="service-txt-block">
                     <h3>
                        Licensing and Regulatory Services
                     </h3>
                  </div>
                  <img class="res-img"  src="<?php  echo get_stylesheet_directory_uri(); ?>/images/service-02.jpg">
               </a>
            </div>
         </li>
         <li data-sr="wait 0.1s, enter right">
            <div class="service-block-01 zoom-ef ">
               <a href="<?php echo site_url('/services#marketing-distribution');?>">
                  <div class="service-txt-block">
                     <h3>
                        Marketing & Distribution
                     </h3>
                  </div>
                  <img class="res-img"  src="<?php  echo get_stylesheet_directory_uri(); ?>/images/service-03.jpg">
               </a>
            </div>
         </li>
         <li  data-sr="wait 0.1s, enter right">
            <div class="service-block-01 zoom-ef ">
               <a href="<?php echo site_url('/services#contract-manufacturing');?>">
                  <div class="service-txt-block">
                     <h3>
                        Contract Manufacturing
                     </h3>
                  </div>
                  <img class="res-img"  src="<?php  echo get_stylesheet_directory_uri(); ?>/images/service-04.jpg">
               </a>
            </div>
         </li>
         <li  data-sr="wait 0.1s, enter right">
            <div class="service-block-01 zoom-ef ">
               <a href="<?php echo site_url('/services#trading-of-pharma-products');?>">
                  <div class="service-txt-block">
                     <h3>
                        Trading of Pharma products
                     </h3>
                  </div>
                  <img class="res-img"  src="<?php  echo get_stylesheet_directory_uri(); ?>/images/service-05.jpg">
               </a>
            </div>
         </li>
      </ul>
   </div>
</section>
<section class="pt-65 pb-65 bg-half">
   <div class="product-slider-block padding-left">
      <div class="title-box white-txt mb-50 padding-right">
         <h2 data-sr="wait 0.1s, enter right">Our Products</h2>
         <!-- <div class="slid-nav-box" data-sr="wait 0.1s, enter right">
            <div class="pro-prev trans slide-nav icon-arrow-1"></div>
            <div class="pro-next trans slide-nav icon-arrow-1"></div>
         </div> -->
      </div>
      <div class="slider-block-main" data-sr="wait 0.1s, enter right">
         <div class="swiper-container product-slider">
            <!-- Additional required wrapper -->
            <div class="swiper-wrapper">
               <div class="swiper-slide zoom-ef">
                  <a href="<?php echo site_url('/product');?>">
                     <div class="pro-slide-img">
                        <img class="res-img"  src="<?php  echo get_stylesheet_directory_uri(); ?>/images/pro-01.jpg">
                     </div>
                     <h3>Respiratory</h3>
                  </a>
               </div>
               <div class="swiper-slide zoom-ef">
                  <a href="<?php echo site_url('/product');?>">
                     <div class="pro-slide-img">
                        <img class="res-img"  src="<?php  echo get_stylesheet_directory_uri(); ?>/images/pro-02.jpg">
                     </div>
                     <h3>Immunology / Hematology</h3>
                  </a>
               </div>
               <div class="swiper-slide zoom-ef">
                  <a href="<?php echo site_url('/product');?>">
                     <div class="pro-slide-img">
                        <img class="res-img"  src="<?php  echo get_stylesheet_directory_uri(); ?>/images/pro-03.jpg">
                     </div>
                     <h3>Anti Infectives </h3>
                  </a>
               </div>
               <div class="swiper-slide zoom-ef">
                  <a href="<?php echo site_url('/product');?>">
                     <div class="pro-slide-img">
                        <img class="res-img"  src="<?php  echo get_stylesheet_directory_uri(); ?>/images/pro-04.jpg">
                     </div>
                     <h3>Cardiovascular</h3>
                  </a>
               </div>
            </div>
            <!-- If we need navigation buttons -->
         </div>
      </div>
   </div>
</section>
<section class="pt-100 pb-80 facility-sec">
   <div class="wrap">
      <div class="facility-block">
         <div class="facility-title" data-sr="wait 0.1s, enter right">
            <h2>Our Facilities</h2>
         </div>
         <div data-sr="wait 0.1s, enter right">
            <p>
               At Regent, we strongly believe in offering quality medicines through innovation. In this mission, principally, we have inclined ourselves towards upkeeping both the qualitative and quantitative aspects with the help of robust formulations and manufacturing facilities. The company has two state-of-the-art formulation manufacturing facilities, one located near Ahmedabad and second one near Mumbai, India. 
            </p>
         </div>
         <ul class="facility-ul">
            <li data-sr="wait 0.1s, enter right">
               <img   src="<?php  echo get_stylesheet_directory_uri(); ?>/images/facility-img-01.png">
            </li>
            <li data-sr="wait 0.1s, enter right">
               <img src="<?php  echo get_stylesheet_directory_uri(); ?>/images/facility-img-02.png">
            </li>
         </ul>
         <div class="facility-bot-but-block">
            <div class="facility-bot-but">
               <a data-sr="wait 0.1s, enter right " class="but-01  blue-but" href="<?php echo site_url('/manufacturing');?>">Surendra Nagar Ahmedabad</a>
               <a data-sr="wait 0.1s, enter right " class="but-01 dark-blue-but" href="<?php echo site_url('/manufacturing');?>">Tarapur, Maharashtra</a>
            </div>
         </div>
      </div>
   </div>
</section>
<section class="pb-50 rel padding-right enrich-live-sec pt-100">
   <div class="flx-row center-align">
      <div class="bot-block-left" data-sr="wait 0.1s, enter right">
         <img class="res-img" src="<?php  echo get_stylesheet_directory_uri(); ?>/images/bot-img-01.jpg">
      </div>
      <div class="bot-block-right">
         <img data-sr="wait 0.1s, enter right"  src="<?php  echo get_stylesheet_directory_uri(); ?>/images/inc-02.png">
         <div data-sr="wait 0.1s, enter right">
            <h2 >Veterinary Products</h2>
            <p>At Regent, we aspire to fulfill the dynamic and daunting needs of pet parents with our varied veterinary products that ptrotect and groom your extended family member...your pets!</p>
         </div>
         <div class="bution-block-01">
            <a data-sr="wait 0.1s, enter right " class="but-01  blue-but" href="<?php echo site_url('/veterinary-products');?>">View More</a>
            <a data-sr="wait 0.1s, enter right " class="but-01 dark-blue-but"  href="<?php echo site_url('/products-presentation');?>" >View Presentation</a>
         </div>
      </div>
   </div>
</section>
<section class="rel ">
   <div class="p-absolute t-0 w-100">
      <div class="wrap-02">
         <div class="title-02 w-80 mb-20 pt-100 take-look-sec" data-sr="wait 0.1s, enter right">
            <h3>Take a look at how we are enriching lives with our countable efforts. </h3>
         </div>
         <a class="but-01  blue-but" href="<?php echo site_url('/csr2/');?>" data-sr="wait 0.1s, enter right">View Details</a>
      </div>
   </div>
   <img class="res-img w-100" src="<?php  echo get_stylesheet_directory_uri(); ?>/images/home-img-02.jpg">
</section>
<section class="  mb-150 map-sec" >
   <div class="map-secton" id="map" ></div>
    <div class="location-detail-block">
      <div class="wrap" >
         <div class="map-title-box mb-20">
            <h2 data-sr="wait 0.1s, enter right">
               <img src="<?php  echo get_stylesheet_directory_uri(); ?>/images/map-icn-01.png"> Our Offices
            </h2>
            <h4 data-sr="wait 0.1s, enter right">
               Widespread supply chain across 30+ 
            </h4>
         </div>
         <ul class="location-box">
            <li class="trans" data-sr="wait 0.1s, enter right">
               <h3>UAE
                  <span>Head Office</span>
               </h3>
               <p>1307, JBC-2,Cluster-V, Jumeirah Lake Tower, Dubai </p>
               <!-- <a href="#" class="tell-a"> <img src="<?php // echo get_stylesheet_directory_uri(); ?>/images/call-icn.png">04 222 3922</a> -->
            </li>
            <li class="trans" data-sr="wait 0.1s, enter right">
               <h3>Singapore</h3>
               <p>60 Paya Lebar Road, #06-01, Paya Lebar Square, Singapore 409051
               </p>
               <!-- <a href="#" class="tell-a"> <img src="<?php // echo get_stylesheet_directory_uri(); ?>/images/call-icn.png"> +971 4 123456</a> -->
            </li>
            <li class="trans" data-sr="wait 0.1s, enter right">
               <h3>Mauritius</h3>
               <p>BPML, Freeport Zone -9, Plaine Magnien -51505, Mauritius.

               </p>
               <!-- <a href="#" class="tell-a"> <img src="<?php//  echo get_stylesheet_directory_uri(); ?>/images/call-icn.png"> +971 4 123456</a> -->
            </li>
            <li class="trans" data-sr="wait 0.1s, enter right">
               <h3>India </h3>
               <p>Sava house, Viman Nagar, Pune</p>
               <!-- <a href="#" class="tell-a"> <img src="<?php // echo get_stylesheet_directory_uri(); ?>/images/call-icn.png"> +971 4 123456</a> -->
            </li>
            <li class="trans" data-sr="wait 0.1s, enter right">
               <h3>Vietnam</h3>
               <p>No. 22, Le Van Mien, Thao Dien Ward, District 2, Ho Chi Minh City, Vietnam
               </p>
               <!-- <a href="#" class="tell-a"> <img src="<?php // echo get_stylesheet_directory_uri(); ?>/images/call-icn.png"> +971 4 123456</a> -->
            </li>
         </ul>
      </div>
   </div>
</section>
<!-- <section class="pt-50 pb-100">
   <div class="wrap">
      <div class="home-news-row flx-row w-100 center-align">
         <div class="news-block-01">
            <img data-sr="wait 0.1s, enter right"  src="<?php//  echo get_stylesheet_directory_uri(); ?>/images/inc-03.png">
            <div data-sr="wait 0.1s, enter right" class="mt-10">
               <h2 >
                  Latest News 
                  and Insights
               </h2>
               <p>Keep up with our latest insights and events so that you never miss out on our health revolution.  </p>
            </div>
         </div>
         <div class="news-block-02">
            <div class="news-block-03 zoom-ef" data-sr="wait 0.1s, enter right">
               <a href="#">
                  <span class="lable-block">News</span>
                  <div class="news-img-block"><img class="res-img" src="<?php // echo get_stylesheet_directory_uri(); ?>/images/news-fea-img.jpg"></div>
                  <div class="news-list-txt">
                     <p>07 April 2023</p>
                     <h3>The Future of Smart Medical Education with Virtual Cadaver Dissection</h3>
                  </div>
               </a>
            </div>
         </div>
      </div>
      <div class="home-news-row w-100 ">
         <ul class="news-ul flx-row">
            <li data-sr="wait 0.1s, enter right">
               <div class="news-block-03 zoom-ef">
                  <a href="<?php// echo site_url('/events-details');?>">
                     <span class="lable-block">News</span>
                     <div class="news-img-block"><img class="res-img" src="<?php // echo get_stylesheet_directory_uri(); ?>/images/news-01.jpg"></div>
                     <div class="news-list-txt">
                        <p>07 April 2023</p>
                        <h3>Pharmaceutical Contract Manufacturing with state-of-art production</h3>
                     </div>
                  </a>
               </div>
            </li>
            <li data-sr="wait 0.1s, enter right">
               <div class="news-block-03 zoom-ef">
                  <a href="<?php //echo site_url('/events-details');?>">
                     <span class="lable-block">News</span>
                     <div class="news-img-block"><img class="res-img" src="<?php // echo get_stylesheet_directory_uri(); ?>/images/news-02.jpg"></div>
                     <div class="news-list-txt">
                        <p>07 April 2023dd</p>
                        <h3>Catering to the needs of customers across the world</h3>
                     </div>
                  </a>
               </div>
            </li>
            <li data-sr="wait 0.1s, enter right">
               <div class="news-block-03 zoom-ef">
                  <a href="<?php// echo site_url('/events-details');?>">
                     <span class="lable-block">News</span>
                     <div class="news-img-block"><img class="res-img" src="<?php // echo get_stylesheet_directory_uri(); ?>/images/news-03.jpg"></div>
                     <div class="news-list-txt">
                        <p>07 April 2023</p>
                        <h3>Portfolio of human pharmaceutical and herbal formulations</h3>
                     </div>
                  </a>
               </div>
            </li>
         </ul>
      </div>
   </div>
</section> -->
<?php get_footer(); ?>