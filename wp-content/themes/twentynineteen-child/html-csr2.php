<?php get_header('');
   /*Template Name: HTML csr2*/
   wp_enqueue_script('script');
   add_action('wp_footer', 'page_script', 21);
   function page_script() {
   ?>
<script>

jQuery(document).ready(function(){
//  
jQuery('.main-nav > ul > li').removeClass("active");
jQuery('.main-nav > ul :nth-child(6)').addClass("active");



});
</script>
<?php
   } ?>
<section class="inner-banner-02 pattern title-left" style="background:url(<?php echo get_stylesheet_directory_uri(); ?>/images/csr-banner.jpg) center bottom; background-size: cover;">
   <div class="wrap">
      <div class="banner-title-box " data-sr="wait 0.1s, enter right">
         <h1>Corporate<br>
            Social<br>
            Responsibility
         </h1>
         <span class="title-line white-line"></span>
      </div>
   </div>
</section>
<section class="pt-120 pb-120">
   <div class="wrap">
      <div class="content-block-02 no-image-block">
         <div class="txt-block-left" data-sr="wait 0.1s, enter right">
            <div class="txt-block-01b">
               <p>Since the inception, we have endeavoured to grow responsibly. We believe that along with sustained economic, environmental and social stewardship also being a key factor for holistic growth. Giving back to the society is a tenet of our chairman Mr Vinod Jadhav, who is the ethos of our company.</p><p>This reflects on in our community development programmes focusing on Education, livelihood, Health, and Environmental Sustainability</p>
            </div>
         </div>
         <!-- <div class="img-block-right" data-sr="wait 0.1s, enter right">
            <img class="res-img" src="<?php // echo get_stylesheet_directory_uri(); ?>/images/csr-img.jpg">
         </div> -->
      </div>
   </div>
</section>
<section class="pt-80 pb-80 flx-row flx-align-center" style="background:#38405f">
   <div class="video-block-left rel">
      <a data-fancybox="video-gallery" id="play-video" class="video-play-button" href="<?php echo get_stylesheet_directory_uri(); ?>/images/video.mp4" >
      <span></span>
      </a>
      <img class="res-img" src="<?php  echo get_stylesheet_directory_uri(); ?>/images/csr2-img-02.png" data-sr="wait 0.1s, enter right">
   </div>
   <div class="csr-right-block" data-sr="wait 0.1s, enter right">
      <h2>Mission helping 100 people…</h2>
      <p>Our Managing Director, Vinod Ramchandra Jadhav generously helped 131 prisoners to go their hometown after the completion of their jail terms in UAE based through a appeal #help100 from BAPS Hindu Mandir, Abu Dhabi on the occasion of Pramukh Swami Maharaj Shatabdi Mahotsav #psm100</p>
      <p>A great example on Selflessness, Kindness and Humanity… </p>
      <p>We at Regent are inspired on this act of our Managing Director and believe that we all can make a difference; we simply have to get started.</p>
      <p>Let’s listen in his own voice on how he did it…</p>
   </div>
</section>
<section class="pt-100 pb-100" style="background:url(<?php echo get_stylesheet_directory_uri(); ?>/images/csr-bg.jpg) center top; background-size: cover;">
   <div class="wrap flx-row csr-padding">
      <div class="title-row" data-sr="wait 0.1s, enter right">
         <h2>Education</h2>
      </div>
      <div class="w-100 b-l-line rel left-line-position-2">
   <ul class="csr-content-ul">
      <li class="pt-30 pb-30">
      <div data-sr="wait 0.1s, enter right" class="csr-img-block"><img class="res-img" src="<?php  echo get_stylesheet_directory_uri(); ?>/images/csr-img-01a.jpg"></div>
         <div data-sr="wait 0.1s, enter right" class="csr-txt-block-2">
            <p>
            Regent believes that education plays a significant role in shaping the future of a nation. As a part of our CSR activity, We have contributed few classroom projectors to develop the technology infrastructure of the Sahyadri English Medium School, Pune. We believe this will help the school in delivering high quality education to students with ease. We are elated to announce that one of our CSR Project “Late Shrimati Shanta Jadhav Study Centre” has been inaugurated on 21st January 2023 by Shri Shrinivas Patil, Ex-Governor of Sikkim & Member of Parliament of India. 
            </p>
         </div>
         
      </li>
      <li class="pt-30 pb-30">
      <div data-sr="wait 0.1s, enter right" class="csr-img-block"><img class="res-img" src="<?php  echo get_stylesheet_directory_uri(); ?>/images/csr-img-02a.jpg"></div>
         <div data-sr="wait 0.1s, enter right" class="csr-txt-block-2">
            <p>
            We believe that it will make a significant impact by improving the educational outcome of children in the rural area of india. Regent Global will continue making such efforts in enhancing its social responsibility in creating a holistic impact. Six schools of St. George’s, Grenada receive computers from Mr. Vinod Ramchandra Jadhav, Managing Director of Regent Global. As part of the international project titled ‘Giving back to society” included computerising of all 75 primary schools of Grenada. 
            </p>
         </div>
         
      </li>

      <li class="pt-30 pb-30">
      <div data-sr="wait 0.1s, enter right" class="csr-img-block"><img class="res-img" src="<?php  echo get_stylesheet_directory_uri(); ?>/images/csr-img-03a.jpg"></div>
         <div data-sr="wait 0.1s, enter right" class="csr-txt-block-2">
            <p>
            Grenada is a small island in Eastern Caribbean which is popularly known in cricket as the West Indies. On 8th Dec 2020 computers were donated to the Ministry of Education by Mr. Jadhav.</p>
            <p>Mr Jadhav recently sponsored its Happy Schools Project, which adopts and repairs the infrastructure of rural schools, and has pledged funds for setting up a 120-bed hostel for girls and boys in Ahmednagar, India.</p>
         </div>
         
      </li>
   </ul>



          
       </div>
      <!-- <div class="w-50 csr-img-block-a01">
         <ul class="img-ul align-right">
            <li data-sr="wait 0.1s, enter right"><img class="res-img" src="<?php // echo get_stylesheet_directory_uri(); ?>/images/img-csr-img-01.jpg"></li>
            <li data-sr="wait 0.1s, enter right"><img class="res-img" src="<?php  //echo get_stylesheet_directory_uri(); ?>/images/img-csr-img-02.jpg"></li>
         </ul>
      </div> -->
   </div>
</section>
<section class="pt-100 pb-100 health-bot-sec " style="background:#f8fcff">
   <div class="wrap flx-row flx-align-center ">
      <div class="img-block-csr-a" data-sr="wait 0.1s, enter right">
         <img class="res-img" src="<?php  echo get_stylesheet_directory_uri(); ?>/images/csr-img-02.jpg">
      </div>
      <div class="txt-block-csr-a">
         <div class="csr-txt-block rel" data-sr="wait 0.1s, enter right">
            <span style="background:#f8fcff" class="title-style-02">
               <h2>Healthcare</h2>
            </span>
            <p>Mr. Jadhav is committed to developing the dialysis unit and pediatric ward at Sassoon Hospital in Pune, India, alongside Rotary International. He also received a Major Donor Crystal from Rotary International and is a member of the "Paul Harris Society."</p>
         </div>
      </div>
   </div>
</section>
<?php get_footer('inner'); ?>