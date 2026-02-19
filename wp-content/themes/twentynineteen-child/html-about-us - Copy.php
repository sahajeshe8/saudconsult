<?php get_header('');
   /*Template Name: HTML About*/
   wp_enqueue_script('script');
   add_action('wp_footer', 'page_script', 21);
   function page_script() {
   ?>
<script>
   var galleryThumbs = new Swiper(".gallery-thumbs", {
    centeredSlides: true,
    centeredSlidesBounds: true,
    slidesPerView: 5,
    watchOverflow: true,
    watchSlidesVisibility: true,
    watchSlidesProgress: true,
    direction: 'vertical',
    pagination: {
          el: ".swiper-pagination",
          clickable: true,
        },
    
   });
   
   var galleryMain = new Swiper(".gallery-main", {
    watchOverflow: true,
    watchSlidesVisibility: true,
    watchSlidesProgress: true,
    preventInteractionOnTransition: true,
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
   
    effect: 'fade',
      fadeEffect: {
      crossFade: true
    },
    thumbs: {
      swiper: galleryThumbs
    }
   });
   
   galleryMain.on('slideChangeTransitionStart', function() {
    galleryThumbs.slideTo(galleryMain.activeIndex);
   });
   
   galleryThumbs.on('transitionStart', function(){
    galleryMain.slideTo(galleryThumbs.activeIndex);
   });
</script>
<?php
   } ?>
<section class="inner-banner pattern"style="background:url(<?php echo get_stylesheet_directory_uri(); ?>/images/about-banner.jpg) center bottom">
   <div class="banner-title-box">
      <h1>About</h1>
      <span class="title-line"></span>
   </div>
</section>
<section class="pt-100 pb-100" style="background:url(<?php echo get_stylesheet_directory_uri(); ?>/images/about-bg.jpg) center top; background-size: cover;">
   <div class="wrap">
      <div class="flx-row">
         <div class=" about-left-box">
            <div class="title-main">
               <h2>Regent<br>
                  An Integrated Pharma Company
               </h2>
            </div>
            <p>Established in 2007, Regent Global group is a prominent name among the healthcare service providers in the business of formulation development, manufacturing, marketing, and distribution and trading of pharmaceutical products for Human and Veterinary use. Our state-of -the- art manufacturing plants located at Surendra Nagar near Ahmedabad and Tarapur near Mumbai in India, which holds various accreditations and produces wide variety of dosage forms across the therapeutic categories. We reiterate our commitment to provide more accessibility of healthcare products through sourcing and supplying a comprehensive range of pharmaceutical and veterinary products from India, United Kingdom, Europe, New Zealand, Australia, Turkey, Singapore, and other countries worldwide. </p>
            <p>Regent Global is known for its quality products and has a presence of over 30 countries worldwide by virtue of our trading business with efficient distribution infrastructure in the market such as United states of America,  Europe, Canada, Asia, Africa, Latin America, Middle East, and CIS besides significant presence in Indian Market. We have built our corporate brand and its reputation as a reliable and result-oriented organization. Our expertise lies in Regulatory affairs, Importation, Marketing, Sales, Distribution, Government Supplies, Tender participation, Institution business, clinics, and retail pharmacies, both in human and veterinary.</p>
            <p>Regent is actively expanding, its horizons by partnering with leading global pharmaceutical companies by meeting R&D needs for finished formulation development.
               Regent Global is dedicated to the scope and diversity of its product portfolio, encompassing generic, branded, and over-the- counter drugs as well as medical devices meeting the highest regulatory standards in the world. In addition, we offer a board range of services such as contract R&D, CDMO, CMO, manufacturing and distribution of products.
               We have now embarked on a new journey in the developed nations, taking nascent steps such as in-licensing/ acquiring of products and front-end marketing capabilities.
               We intend to become the preferred and long-term partner of local and foreign pharmaceutical manufacturers in creating, building, and sustaining proprietary pharmaceutical brands. Regent Global, headquartered in Dubai, is a privately held & diversified organization.​
            </p>
         </div>
      </div>
   </div>
</section>
<section class="pt-90 pb-90">
   <div class="wrap">
      <ul class="mission-vission-ul">
         <li class="mission-block">
            <div class="icn-box-main"  data-sr="wait 0.1s, enter right" >
               <img  src="<?php echo get_stylesheet_directory_uri(); ?>/images/mission-icn.png">
            </div>
            <div class="txt-block-01a"  data-sr="wait 0.1s, enter right" >
               <h2>
                  Our Mission
               </h2>
               <p>
                  To bring out the best in Pharma and Healthcare Industry, which will benefit all its stake holders.
               </p>
            </div>
         </li>
         <li class="vission-block">
            <div class="icn-box-main"  data-sr="wait 0.1s, enter right" >
               <img  src="<?php echo get_stylesheet_directory_uri(); ?>/images/vission-icn.png">
            </div>
            <div class="txt-block-01a"  data-sr="wait 0.1s, enter right" >
               <h2>
                  Vision
               </h2>
               <p>
                  To become the preferred partner by setting a new standard for the access to healthcare.
               </p>
            </div>
         </li>
      </ul>
   </div>
</section>
<section>
   <div class="wrap">
      <div class="title-main align-center"  data-sr="wait 0.1s, enter right" >
         <h2>Our Values</h2>
      </div>
      <div class="value-box mb-80">
         <ul>
            <li>
               <ul>
                  <li  data-sr="wait 0.1s, enter right" >
                     <span class="value-icn-01"><img  src="<?php echo get_stylesheet_directory_uri(); ?>/images/value-icn-01.png"></span>
                     <span class="value-txt-01">
                        <h3>R-Royalty</h3>
                     </span>
                  </li>
                  <li  data-sr="wait 0.1s, enter right" >
                     <span class="value-icn-01"><img  src="<?php echo get_stylesheet_directory_uri(); ?>/images/value-icn-06.png"></span>
                     <span class="value-txt-01">
                        <h3>E- Ethical</h3>
                     </span>
                  </li>
                  <li  data-sr="wait 0.1s, enter right" >
                     <span class="value-icn-01"><img  src="<?php echo get_stylesheet_directory_uri(); ?>/images/value-icn-03.png"></span>
                     <span class="value-txt-01">
                        <h3>G- Genuine</h3>
                     </span>
                  </li>
               </ul>
            </li>
            <li>
               <ul>
                  <li  data-sr="wait 0.1s, enter right" >
                     <span class="value-icn-01"><img  src="<?php echo get_stylesheet_directory_uri(); ?>/images/value-icn-02.png"></span>
                     <span class="value-txt-01">
                        <h3>E- Elevate</h3>
                     </span>
                  </li>
                  <li  data-sr="wait 0.1s, enter right" >
                     <span class="value-icn-01"><img  src="<?php echo get_stylesheet_directory_uri(); ?>/images/value-icn-04.png"></span>
                     <span class="value-txt-01">
                        <h3>N- Novel</h3>
                     </span>
                  </li>
                  <li  data-sr="wait 0.1s, enter right" >
                     <span class="value-icn-01"><img  src="<?php echo get_stylesheet_directory_uri(); ?>/images/value-icn-05.png"></span>
                     <span class="value-txt-01">
                        <h3>T- Triumph</h3>
                     </span>
                  </li>
               </ul>
            </li>
         </ul>
      </div>
      <div class="video-block mb-100"  data-sr="wait 0.1s, enter right" >
         <img class="res-img" src="<?php echo get_stylesheet_directory_uri(); ?>/images/video-player.jpg">
      </div>
   </div>
</section>
<section class="mb-100">
   <div class="wrap">
      <div class="career-title-row align-center"  data-sr="wait 0.1s, enter right" >
         <h2>Major Accomplishments and Milestones</h2>
         <p>
            Regent Group has a widespread supply chain across 30+ countries with a key fucus on USA, Europe, <br>and Emerging markets by virtue of its trading business.
         </p>
      </div>
      <div class="milestone-block mt-50">
         <ul class="milestone-ul">
            <li>
               <div class="milstone-block-01"  data-sr="wait 0.1s, enter right" >
                  <div class="minls-icn"><img   src="<?php echo get_stylesheet_directory_uri(); ?>/images/mile-icn-01.png"></div>
                  <h3>2023</h3>
               </div>
               <div class="milstone-txt-01"  data-sr="wait 0.1s, enter right" >
                  <p>Emerging as a fully integrated Pharmaceutical global player</p>
               </div>
            </li>
            <li>
               <div class="milstone-block-01"  data-sr="wait 0.1s, enter right" >
                  <div class="minls-icn"><img   src="<?php echo get_stylesheet_directory_uri(); ?>/images/mile-icn-02.png"></div>
                  <h3>2019</h3>
               </div>
               <div class="milstone-txt-01"  data-sr="wait 0.1s, enter right" >
                  <p>Established 4th overseas office in Mauritius</p>
               </div>
            </li>
            <li>
               <div class="milstone-block-01"  data-sr="wait 0.1s, enter right" >
                  <div class="minls-icn"><img   src="<?php echo get_stylesheet_directory_uri(); ?>/images/mile-icn-03.png"></div>
                  <h3>2015</h3>
               </div>
               <div class="milstone-txt-01"  data-sr="wait 0.1s, enter right" >
                  <p>Established 3rd overseas(scientific) office in Vietnam, to strengthen Asia-pacific operations</p>
               </div>
            </li>
            <li>
               <div class="milstone-block-01"  data-sr="wait 0.1s, enter right" >
                  <div class="minls-icn"><img   src="<?php echo get_stylesheet_directory_uri(); ?>/images/mile-icn-04.png"></div>
                  <h3>2014</h3>
               </div>
               <div class="milstone-txt-01"  data-sr="wait 0.1s, enter right" >
                  <p>Established 2nd overseas office in Singapore</p>
               </div>
            </li>
            <li>
               <div class="milstone-block-01"  data-sr="wait 0.1s, enter right" >
                  <div class="minls-icn"><img   src="<?php echo get_stylesheet_directory_uri(); ?>/images/mile-icn-05.png"></div>
                  <h3>2013</h3>
               </div>
               <div class="milstone-txt-01"  data-sr="wait 0.1s, enter right" >
                  <p>Started Manufacturing, packaging and distribution of Veterinary products in India</p>
               </div>
            </li>
            <li>
               <div class="milstone-block-01"  data-sr="wait 0.1s, enter right" >
                  <div class="minls-icn"><img   src="<?php echo get_stylesheet_directory_uri(); ?>/images/mile-icn-06.png"></div>
                  <h3>2012</h3>
               </div>
               <div class="milstone-txt-01"  data-sr="wait 0.1s, enter right" >
                  <p>R&D establishment</p>
               </div>
            </li>
            <li>
               <div class="milstone-block-01"  data-sr="wait 0.1s, enter right" >
                  <div class="minls-icn"><img   src="<?php echo get_stylesheet_directory_uri(); ?>/images/mile-icn-07.png"></div>
                  <h3>2010</h3>
               </div>
               <div class="milstone-txt-01"  data-sr="wait 0.1s, enter right" >
                  <p>Complete acquisition of Bio-deal and integration of this business 
                     along with international operations Started exporting pharmaceutical products over 30 countries
                  </p>
               </div>
            </li>
            <li>
               <div class="milstone-block-01"  data-sr="wait 0.1s, enter right" >
                  <div class="minls-icn"><img   src="<?php echo get_stylesheet_directory_uri(); ?>/images/mile-icn-08.png"></div>
                  <h3>2007</h3>
               </div>
               <div class="milstone-txt-01"  data-sr="wait 0.1s, enter right" >
                  <p>Established 1st overseas office (UAE)</p>
               </div>
            </li>
            <li>
               <div class="milstone-block-01"  data-sr="wait 0.1s, enter right" >
                  <div class="minls-icn"><img   src="<?php echo get_stylesheet_directory_uri(); ?>/images/mile-icn-09.png"></div>
                  <h3>2003</h3>
               </div>
               <div class="milstone-txt-01"  data-sr="wait 0.1s, enter right" >
                  <p>Stepped into International Pharmaceutical trading</p>
               </div>
            </li>
            <li>
               <div class="milstone-block-01"  data-sr="wait 0.1s, enter right" >
                  <div class="minls-icn"><img   src="<?php echo get_stylesheet_directory_uri(); ?>/images/mile-icn-10.png"></div>
                  <h3>2023</h3>
               </div>
               <div class="milstone-txt-01"  data-sr="wait 0.1s, enter right" >
                  <p>Initiated with a Franchise shop named<br>Medicine shoppe international</p>
               </div>
            </li>
         </ul>
      </div>
   </div>
</section>
<?php get_footer('inner'); ?>