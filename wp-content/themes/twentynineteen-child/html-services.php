<?php get_header(''); 
    /*Template Name: HTML Services*/
    wp_enqueue_script('script');
    add_action('wp_footer','page_script',21);
    function page_script(){
?>
<script>



jQuery(document).ready(function(){
//  
jQuery('.main-nav > ul > li').removeClass("active");
jQuery('.main-nav > ul > :nth-child(3)').addClass("active");



});



 var markers = [];
   
   function initialize() {
   var locations = [
   
   	
   
   
   ['<div id="content-map" class="store-locator-info-window"><div id="siteNotice"></div><div id="bodyContent"> <p style="line-height:20pxfont-size:14px;text-align:center;color:#002543;text-transform:uppercase;font-weight:600;padding:0;margin-bottom:0;">1307-1308, JBC -2, Cluster- V, Jumeirah Lake Tower, Dubai, UAE</p></div></div>',25.0709248,55.1379023, '<?php echo get_stylesheet_directory_uri(); ?>/images/marker.png', 1],
     ['<div id="content-map" class="store-locator-info-window"><div id="siteNotice"></div><div id="bodyContent"> <p style="line-height:20pxfont-size:14px;text-align:center;color:#002543;text-transform:uppercase;font-weight:600;padding:0;margin-bottom:0;">60 Paya Lebar Road, #06-01, Paya Lebar Square, Singapore 409051</p></div></div>',1.3187506,103.8903877, '<?php echo get_stylesheet_directory_uri(); ?>/images/marker-2.png', 1],
     ['<div id="content-map" class="store-locator-info-window"><div id="siteNotice"></div><div id="bodyContent"> <p style="line-height:20pxfont-size:14px;text-align:center;color:#002543;text-transform:uppercase;font-weight:600;padding:0;margin-bottom:0;">BPML, Freeport Zone -9, Plaine Magnien -51505, Mauritius.</p></div></div>',20.4261963,57.6742072, '<?php echo get_stylesheet_directory_uri(); ?>/images/marker.png', 1],
     ['<div id="content-map" class="store-locator-info-window"><div id="siteNotice"></div><div id="bodyContent"> <p style="line-height:20pxfont-size:14px;text-align:center;color:#002543;text-transform:uppercase;font-weight:600;padding:0;margin-bottom:0;">Lalwani Plaza, Wing B, Off Airport Road, Sakore Nagar, Viman Nagar, Pune-411014, India.</p></div></div>',18.5623736,73.9071572, '<?php echo get_stylesheet_directory_uri(); ?>/images/marker-3.png', 1],
     ['<div id="content-map" class="store-locator-info-window"><div id="siteNotice"></div><div id="bodyContent"> <p style="line-height:20pxfont-size:14px;text-align:center;color:#002543;text-transform:uppercase;font-weight:600;padding:0;margin-bottom:0;">No. 22, Le Van Mien, Thao Dien Ward,District 2, Ho Chi Minh City, Vietnam</p></div></div>',10.8050601,106.7314802, '<?php echo get_stylesheet_directory_uri(); ?>/images/marker.png', 1],

   
   
    
   		
   ];
   
   if (jQuery(window).width() < 767) {
   var zoom =  5;
   }
   else {
   var zoom = 3 ;
   
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


<section class="inner-banner-02 pattern" style="background:url(<?php echo get_stylesheet_directory_uri(); ?>/images/rgt-services-banner.jpg) center;background-size: cover;">
  <div class="banner-title-box">    
    <h1 data-sr="wait 0.1s, enter right">Services</h1>
    <span data-sr="wait 0.1s, enter right" class="title-line"></span>
  </div>
</section>


<section >
  <ul class="service-list">
    <li id="contract-research-development" class="service-txt-block">
      <div class="service-left padding-left-ser"  >
      <span class="line-block"></span>
      <div data-sr="wait 0.1s, enter right">
        <h2>Contract Research & Development</h2>
    </div>
    <div data-sr="wait 0.1s, enter right">
        <p>Regent is providing formulation development & contract manufacturing services. The state-of -the-art formulation development facility is certified by (Department of Science & Industrial Research) Government of India and is having research team compressing of over 40 senior scientists. </p>
        <span class="moretext" style="display:none">
        <p >
        Who have expertise across the therapeutic areas and geographies for generics and other differentiated products ranging from Nasal Sprays, Dry Powder Inhalers, Metered dose Inhalers and Tablets (Immediate / sustained/ extended / controlled/ delayed release and Bi -layered tablets), Capsules, Ointments, Creams, Sterile ophthalmic ointments/gels and Sterile General Ointments/gels. Experienced scientific man power and well established systems, able to support with documents for registrations in ROW/Regulated Markets
    </p>
  </span>
    
      </div>
        <div   data-sr="wait 0.1s, enter right" class="expand-but swipper-but rel-next swipper-next icon-arrow-1 ml-auto" tabindex="0" role="button" aria-label="Next slide"></div>
        <!-- <div data-fancybox="" data-src="#contract" data-sr="wait 0.1s, enter right" class="swipper-but rel-next swipper-next icon-arrow-1 ml-auto" tabindex="0" role="button" aria-label="Next slide"></div> -->
      </div>
      <div class="service-right" data-sr="wait 0.1s, enter right">
        <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/rgt-services-img1.jpg" class="img-fit" alt="image">
      </div>
    </li>
    <li id="international-business-development-licensing" class="service-txt-block">
      <div class="service-left padding-right-ser  padding-right-ser-1" >
      <span class="line-block"></span>
      <div data-sr="wait 0.1s, enter right">
        <h2>International Business Development, Licensing</h2>
    </div>
    <div data-sr="wait 0.1s, enter right">
        <p>To fulfil our promise to provide more accessibility of healthcare products and innovative health care solutions. </p>
        <span class="moretext"> 
  </span>
    </div>
        <a data-sr="wait 0.1s, enter right" href="<?php echo site_url('/international-business-development-licensing');?>" class="link"><div class="swipper-but rel-next swipper-next icon-arrow-1 ml-auto" tabindex="0" role="button" aria-label="Next slide"></div></a>
      </div>
      <div class="service-right" data-sr="wait 0.1s, enter right">
        <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/rgt-services-img2.jpg" class="img-fit" alt="image">
      </div>
    </li>
    <li id="marketing-distribution" class="service-txt-block">
      <div class="service-left padding-left-ser">
        <span class="line-block"></span>
        <div data-sr="wait 0.1s, enter right">
        <h2>Marketing & Distribution</h2>
    </div>
    <div data-sr="wait 0.1s, enter right">
        <p>Our focus is to provide an optimum service and satisfaction to our customers. </p>
        <span class="moretext" style="display:none">
          <p>
           We ensure to provide marketing support through an expertised inhouse product management team
          </p>
          <p>
          We develop and run efficient distribution network in the countries we operate to improve the market access, drive trade growth and make products available and affordable. We work with different distribution models as per the market dynamics. Centralised procurement, sustainable supply demand planning across the regions: source, compliant ordering and payment, a single point of contact. 
          </p>
        </span>
    </div> 
        <a data-sr="wait 0.1s, enter right"  href="javascript:;" class="link expand-but"><div class="swipper-but rel-next swipper-next icon-arrow-1 ml-auto" tabindex="0" role="button" aria-label="Next slide"></div></a>
        <!-- <a data-sr="wait 0.1s, enter right" data-fancybox="" data-src="#marketing" href="javascript:;" class="link"><div class="swipper-but rel-next swipper-next icon-arrow-1 ml-auto" tabindex="0" role="button" aria-label="Next slide"></div></a> -->
      </div>
      <div class="service-right" data-sr="wait 0.1s, enter right">
        <img  src="<?php echo get_stylesheet_directory_uri(); ?>/images/rgt-services-img3.jpg" class="img-fit" alt="image">
      </div>
    </li>
  </ul>
</section>

<section id="contract-manufacturing" class="pt-135 pb-135 d-flx" style="background:url(<?php echo get_stylesheet_directory_uri(); ?>/images/rgt-service-sub-banner1.jpg) center;background-size: cover;">
  <div class="container">
    <div class="manufacturing-box">
      <div class="inner" data-sr="wait 0.1s, enter right">
        <h2>Manufacturing</h2>
        <a  href="<?php echo site_url('/manufacturing');?>"><div class="swipper-but rel-next swipper-next icon-arrow-1 ml-auto mr-auto" tabindex="0" role="button" aria-label="Next slide"></div></a>
      </div>
    </div>
  </div>
</section>



<section id="trading-of-pharma-products">
  <ul class="service-list">
    <li class="row-reverce section-bg-03 service-txt-block new-line-ser" >
      <div class="service-left padding-left-ser trading-left">
      <span class="line-block line-position-03"></span>
      <div data-sr="wait 0.1s, enter right">
        <h2>Trading of Pharma products</h2>
    </div>
    <div data-sr="wait 0.1s, enter right">
        <p>We reiterate our commitment to provide more accessibility of healthcare products through sourcing and supplying a comprehensive range of pharmaceutical and veterinary products from India, United Kingdom, Europe, New Zealand, Australia, Turkey, Singapore, and other countries worldwide.</p>
        <span class="moretext" style="display: none;">
        <p>
        We closely work with companies, medical fraternity, and other stake holders, offer them our expert services of sourcing and supply across the geographies. From Regulatory analysis to strategic plans, procurement, distribution and delivery, we provide tailored program and services. Our major objective is to help all the stake holder on global basis enabling access to healthcare products timely and efficient manner. Our motto is to empower the health care access to ALL!
        </p>
        </span>
    
      </div>

        <div  data-sr="wait 0.1s, enter right" class="swipper-but rel-next swipper-next icon-arrow-1 ml-auto expand-but" tabindex="0" role="button" aria-label="Next slide"></div>
      </div>
      <div class="service-right trading-right" data-sr="wait 0.1s, enter right">
        <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/service-bot-img.jpg" class="w-100 img-fit" alt="image">
      </div>
    </li></ul>
</section>


<!-- 
<section class="  mb-200 map-sec" >
  <div class="map-secton" id="map" ></div>
  <div class="location-detail-block">
     <div class="wrap" >
        <div class="map-title-box mb-20">
           <h2 data-sr="wait 0.1s, enter right">
              <img src="<?php // echo get_stylesheet_directory_uri(); ?>/images/map-icn-01.png"> Our Offices
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
              <p>1307-1308, JBC -2, 
Cluster- V, Jumeirah Lake 
Tower, Dubai, UAE
              </p>
              <a href="#" class="tell-a"> <img src="<?php // echo get_stylesheet_directory_uri(); ?>/images/call-icn.png"> +971 4 123456</a>
           </li>
           <li class="trans" data-sr="wait 0.1s, enter right">
              <h3>Singapore</h3>
              <p>60 Paya Lebar Road, 
#06-01, Paya Lebar Square, 
Singapore 409051
              </p>
              <a href="#" class="tell-a"> <img src="<?php // echo get_stylesheet_directory_uri(); ?>/images/call-icn.png"> +971 4 123456</a>
           </li>
           <li class="trans" data-sr="wait 0.1s, enter right">
              <h3>Mauritius</h3>
              <p>BPML, Freeport Zone -9, 
Plaine Magnien -51505, 
Mauritius.
              </p>
              <a href="#" class="tell-a"> <img src="<?php // echo get_stylesheet_directory_uri(); ?>/images/call-icn.png"> +971 4 123456</a>
           </li>
           <li class="trans" data-sr="wait 0.1s, enter right">
              <h3>India </h3>
              <p>Lalwani Plaza, Wing B, 
Off Airport Road, Sakore Nagar, 
Viman Nagar, Pune-411014, 
India.
              </p>
              <a href="#" class="tell-a"> <img src="<?php  //echo get_stylesheet_directory_uri(); ?>/images/call-icn.png"> +971 4 123456</a>
           </li>
           <li class="trans" data-sr="wait 0.1s, enter right">
              <h3>Vietnam</h3>
              <p>No. 22, Le Van Mien,
Thao Dien Ward,District 2, 
Ho Chi Minh City, 
Vietnam
              </p>
              <a href="#" class="tell-a"> <img src="<?php // echo get_stylesheet_directory_uri(); ?>/images/call-icn.png"> +971 4 123456</a>
           </li>
        </ul>
     </div>
  </div>
</section> -->


<section class="pt-80">
  <div class="wrap">
    <div class="career-title-row align-center">
      <h2 data-sr="wait 0.1s, enter right">Contact Us</h2>
      <h4 data-sr="wait 0.1s, enter right">
         Got a question or need some help? Get in touch. We’d<br>love to hear from you.
      </h4>
   </div>
   <div class="form-box mt-100">
    <ul class="contact-folrm-ul">
       <li>
          <ul class="form-ul contact-form">
             <li data-sr="wait 0.1s, enter right">
                <input class="fld-01" type="text" placeholder="Name*">
             </li>
             <li data-sr="wait 0.1s, enter right">
                <input class="fld-01" type="text" placeholder="Email*">
             </li>
             <li data-sr="wait 0.1s, enter right">
                <input class="fld-01" type="text" placeholder="Phone Number*">
             </li>
             <li data-sr="wait 0.1s, enter right">
                <input class="fld-01" type="text" placeholder="Type of Enquiry*">
             </li>
          </ul>
       </li>
       <li>
          <ul class="form-ul contact-form">
             <li data-sr="wait 0.1s, enter right">
                <input class="fld-01" type="text" placeholder="Company">
             </li>
             <li data-sr="wait 0.1s, enter right">
                <textarea  class="fld-01" rows="4" placeholder="Message" ></textarea>
             </li>
             <li data-sr="wait 0.1s, enter right" class="w-100">
                <div class="check-block">
                   <label class="container">I accept the processing of my <a href="#">personal data</a>
                   <input type="checkbox" checked="checked">
                   <span class="checkmark"></span>
                   </label>
                </div>
                <a href="#" class="but-01  blue-but">Submit</a>
             </li>
          </ul>
       </li>
    </ul>
 </div>
  </div>
</section>










<div style="display: none;" class="pop-content pop-content-2" id="trading">
  <h2>Trading of Pharma products</h2>
  <p>We reiterate our commitment to provide more accessibility of healthcare products through sourcing and supplying a comprehensive range of pharmaceutical and veterinary products from India, United Kingdom, Europe, New Zealand, Australia, Japan, Turkey, Singapore and other countries worldwide. We closely work with companies, medical fraternity, and other stake holders, offer them our expert services of sourcing and supply across the geographies. From Regulatory analysis to strategic plans, procurement, distribution and delivery, we provide tailored program and services. Our major objective is to help all the stake holder on global basis enabling access to healthcare products timely and efficient manner. 
    Our motto is to empower the health care access to ALL!</p>
</div>


<div style="display: none;" class="pop-content pop-content-2" id="marketing">
  <h2>Marketing & Distribution</h2>
  <p>Our focus is to provide an optimum service and satisfaction to our customers. We ensure to provide marketing support through an expertised inhouse product management team</p>
  <p>We develop and run efficient distribution network in the countries we operate to improve the market access, drive trade growth and make products avaiable and affordable. We work with different distribution models as per the market dynamics. Centralised procurement, sustaiable supply demand planning across the regions: source, compliant ordering and payment, a single point of contact. </p>
</div>

<div style="display: none;" class="pop-content pop-content-2" id="contract">
  <h2>Contract Research & Development</h2>
  <p>Regent offers Formulation Development & Contract Manufacturing services. The state-of -the-art formulation development facility is certified by (Department of Science & Industrial Research) Government of India and is having research team compressing of over 40 senior scientists who have expertise across the therapeutic areas and geographies for generics and other differentiated products ranging from Nasal Sprays, Dry Powder Inhalers, Metered dose Inhalers and Tablets (Immediate / sustained/ extended / controlled/ delayed release and Bi -layered tablets), Capsules, Ointments, Creams, Sterile ophthalmic ointments/gels and Sterile General Ointments/gels. Experienced scientific man power and well established systems, able to support with documents for registrations in ROW/advanced Markets</p>
</div>

<div style="display: none;" class="pop-content pop-content-2" id="international-business">
  <h2>Contract Research & Development</h2>
  <p>Regent offers Formulation Development & Contract Manufacturing services. The state-of -the-art formulation development facility is certified by (Department of Science & Industrial Research) Government of India and is having research team compressing of over 40 senior scientists who have expertise across the therapeutic areas and geographies for generics and other differentiated products ranging from Nasal Sprays, Dry Powder Inhalers, Metered dose Inhalers and Tablets (Immediate / sustained/ extended / controlled/ delayed release and Bi -layered tablets), Capsules, Ointments, Creams, Sterile ophthalmic ointments/gels and Sterile General Ointments/gels. Experienced scientific man power and well established systems, able to support with documents for registrations in ROW/advanced Markets</p>
</div>


<div style="display: none;" class="pop-content" id="manufacturing">
  <h2>
  UNIT 2: State -of-the-art Manufacturing 
facilities at Tarapur, Maharashtra 
(Near Mumbai)
  </h2>

 
               <p>State -of-the-art Manufacturing facilities at Tarapur, Maharashtra (Near Mumbai)<br>
               a.	Line 1-U1<br>
               A state-of-art formulation manufacturing facility complying with C-Gmp norms to manufacture pharmaceutical Products such as:</p>
           <div class="dot-list">
            <ul >
               <li>Liquid Orals</li>
               <li>Semisolid dosage Forms (Creams, Gel and Ointments)</li>
               <li>Sterile Ointment/Gel</li>
               <li>Liquid Externals</li>
           
            </ul>
           </div>
            <div class="slider-block-01 border-blue arrow-style mt-50">
         <div class="slider-sec logo-slider-4 swiper-container over-flow-true style ">
            <div class="swiper-wrapper" >
               <div class="swiper-slide">
                  <div class="logo-block-01">
                     <div class="icon">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/slide-logo1.png" alt="image">
                     </div>
                    
                  </div>
               </div>
               <div class="swiper-slide">
                  <div class="logo-block-01">
                     <div class="icon">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/gmp.jpg" alt="image">
                     </div>
                    
                  </div>
               </div>
               <div class="swiper-slide">
                  <div class="logo-block-01">
                     <div class="icon">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/slide-logo12.jpg" alt="image">
                     </div>
                     
                  </div>
               </div>
               <div class="swiper-slide">
                  <div class="logo-block-01">
                     <div class="icon">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/slide-logo4.png" alt="image">
                     </div>
                   
                  </div>
               </div>
                
            </div>
         </div>
         <div class="slider-nav">
            <div class="swipper-but rel-prev-a swipper-prev icon-arrow-1"></div>
            <div class="swipper-but rel-next-a swipper-next icon-arrow-1"></div>
         </div>
      </div>
   

    <div class="mt-40 mb-20">
      <p>
        b.	Line 2 -U2 <br>
        A state-of-art formulation manufacturing facility complying with C-Gmp norms to manufacture pharmaceutical exclusively for:
      </p>
      <div class="dot-list">
        <ul >
           <li>Sterile ophthalmic ointments/gels, </li>
           <li>Sterile General Ointments/gels, and </li>
           <li>Sterile prefilled syringes (For external Use)</li>
 
       
        </ul>
    </div>
    <div class="slider-block-01 border-blue arrow-style mt-60">
    <div class="slider-sec logo-slider-5 swiper-container over-flow-true style ">
       <div class="swiper-wrapper" >
          <div class="swiper-slide">
             <div class="logo-block-01">
                <div class="icon">
                   <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/slide-logo3.png" alt="image">
                </div>
               
             </div>
          </div>
          <div class="swiper-slide">
             <div class="logo-block-01">
                <div class="icon">
                   <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/slide-logo2.png" alt="image">
                </div>
               
             </div>
          </div>
          <div class="swiper-slide">
             <div class="logo-block-01">
                <div class="icon">
                   <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/slide-logo8.png" alt="image">
                </div>
                
             </div>
          </div>
          <div class="swiper-slide">
             <div class="logo-block-01">
                <div class="icon">
                   <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/slide-logo13.jpg" alt="image">
                </div>
              
             </div>
          </div>
           
       </div>
    </div>
    <div class="slider-nav">
       <div class="swipper-but rel-prev-c swipper-prev icon-arrow-1"></div>
       <div class="swipper-but rel-next-c swipper-next icon-arrow-1"></div>
    </div>
 </div>
  
 <div class="mt-40">
  <p>
    Among the few units designed to meet EU norms for the manufacturing of sterile semi-solid dosage forms in the whole of Asia. The utilities like Purified water system, Air Handling System, Oil fired Boiler, Compressed air are well designed and maintained to ensure proper supply of high-quality utility services.
  </p>
 </div>
  
  
  </div>




</div>



<?php get_footer('inner'); ?>