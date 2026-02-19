<?php get_header(''); 
   /*Template Name: HTML Manufacturing*/
   wp_enqueue_script('script');
   add_action('wp_footer','page_script',21);
   function page_script(){
   ?>
<script>
    jQuery(document).ready(function(){
//  
jQuery('.main-nav > ul > li').removeClass("active");
jQuery('.main-nav > ul :nth-child(5)').addClass("active");



});
</script>
<?php } ?>
<section class=" inner-banner-02 pattern" style="background:url(<?php echo get_stylesheet_directory_uri(); ?>/images/manufacturing-banner-img.jpg) center bottom; background-size: cover;">
   <div class="banner-title-box">
      <h1 data-sr="wait 0.1s, enter right">Facilities</h1>
      <span class="title-line"></span>
   </div>
</section>
<div class="rgt-first-block   pb-100 pt-115" style="background: #f8fcff;">
   <div class="wrap d-flx pb-20 pt-30">
      <div class="border-blue">
         <div class="content-block-02a flx-align-center">
            <div class="image">
               <ul class="img-block-02c">
                  <li>
                     <div data-sr="wait 0.1s, enter right" class="img-hlder"><img class="w-100" src="<?php echo get_stylesheet_directory_uri(); ?>/images/manufacturing-img-01.jpg" alt="image"></div>
                  </li>
                  <li>
                     <div data-sr="wait 0.1s, enter right" class="img-hlder"><img class="w-100" src="<?php echo get_stylesheet_directory_uri(); ?>/images/manufacturing-img-02.jpg" alt="image"></div>
                     <div data-sr="wait 0.1s, enter right" class="img-hlder"><img class="w-100" src="<?php echo get_stylesheet_directory_uri(); ?>/images/manufacturing-img-03.jpg" alt="image"></div>
                  </li>
               </ul>
            </div>
            <div class="content" data-sr="wait 0.1s, enter right">
               <p>At Regent, we strongly believe in offering quality medicines through innovation.
 In this mission, principally, we have inclined ourselves towards upkeeping both the 
qualitative and quantitative aspects with the help of robust formulations and 
manufacturing facilities.</p>
               <!-- <p>Research and Development a key growth driver for Regent. Our state-of-the-art R&D Facility located at Pune, certified by Department of Science & Industrial Research (DSIR), India. We run pioneering projects at the cutting edge of drug development across all technologies and dosage forms. </p>
               <p>Our team has expertise across the therapeutic areas and geographies for generics and other differentiated products ranging from Dry Powder Inhalers to Nasal Sprays and Bi -layered tablets to Ointments and creams. In short, our R&D competencies play a key role in fulfilling our commitment of delivering the affordable medicines and addressing unmet patients needs.</p> -->
            </div>
         </div>
         <div class="pos-img"  >
            <img class="mx-100" src="<?php echo get_stylesheet_directory_uri(); ?>/images/regent-img2.png" alt="image">
         </div>
      </div>
   </div>
</div>
<section class="rgt-second-block pb-150 pt-110">
   <div class="wrap">
      <div class="content-sec d-flx">
         <div class="content dot-list">
            <h2 data-sr="wait 0.1s, enter right">Manufacturing Unit at Surendra Nagar Ahmedabad</h2>
            <div data-sr="wait 0.1s, enter right">
               <p>A state-of-the- art formulation manufacturing facility complying with global regulatory norms to manufacture Pharmaceutical dosage form such as:</p>
            </div>
            <ul class="col-02">
               <li data-sr="wait 0.1s, enter right">Nasal Spray and Nasal Drops</li>
               <li data-sr="wait 0.1s, enter right">Puff Caps/Dry Powder Inhalation </li>
               <li data-sr="wait 0.1s, enter right">Tablets (Uncoated, Film-coated, Sustained & Controlled Release, Bilayer, Chewable Tablets)</li>
               <li data-sr="wait 0.1s, enter right">Capsules (General & Controlled Release)</li>
               <li data-sr="wait 0.1s, enter right">Dry Powder for Oral Suspension</li>
               <li data-sr="wait 0.1s, enter right">Semisolid dosage Forms (Creams, Gel and Ointments)</li>
            </ul>
         </div>
         <div class="image">
            <ul>
               <li data-sr="wait 0.1s, enter right"><img  class="mx-100" src="<?php echo get_stylesheet_directory_uri(); ?>/images/rgt-img1.jpg" alt="image"></li>
               <li class="d-flx">
                  <div data-sr="wait 0.1s, enter right" class="img-block-02a">
                     <img class="mx-100" src="<?php echo get_stylesheet_directory_uri(); ?>/images/rgt-img2.jpg" alt="image">
                  </div>
                  <div  data-sr="wait 0.1s, enter right" class="img-block-02b">
                     <img class="mx-100" src="<?php echo get_stylesheet_directory_uri(); ?>/images/rgt-img3.jpg" alt="image">
                  </div>
               </li>
            </ul>
            <div class="verticle-txt">
               <span class="ver-txt-block" data-sr="wait 0.1s, enter right">
               <img class="mx-100" src="<?php echo get_stylesheet_directory_uri(); ?>/images/ver-txt.jpg" alt="image">
               </span>
            </div>
         </div>
      </div>
      <div class="slider-block-01 border-blue arrow-style mt-100">
         <div class="slider-sec logo-slider swiper-container over-flow-true style ">
            <div class="swiper-wrapper"  >
               <div class="swiper-slide">
                  <div class="logo-block-01">
                     <div class="icon">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/pic.jpg" alt="image">
                     </div>
                     <p>PIC/s-UKRAlNE</p>
                  </div>
               </div>
               <div class="swiper-slide">
                  <div class="logo-block-01">
                     <div class="icon">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/gmp.jpg" alt="image">
                     </div>
                     <p>WHO-GMP (INDIA)</p>
                  </div>
               </div>
               <div class="swiper-slide">
                  <div class="logo-block-01">
                     <div class="icon">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/slide-logo12.jpg" alt="image">
                     </div>
                     <p>Russia GMP</p>
                  </div>
               </div>
               <div class="swiper-slide">
                  <div class="logo-block-01">
                     <div class="icon">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/slide-logo4.png" alt="image">
                     </div>
                     <p>NDA-UGANDA</p>
                  </div>
               </div>
               <div class="swiper-slide">
                  <div class="logo-block-01">
                     <div class="icon">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/moh.jpg" alt="image">
                     </div>
                     <p>MOH-NEPAL</p>
                  </div>
               </div>
               <div class="swiper-slide">
                  <div class="logo-block-01">
                     <div class="icon">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/slide-logo5.png" alt="image">
                     </div>
                     <p>IVORY .COAST </p>
                  </div>
               </div>
               <div class="swiper-slide">
                  <div class="logo-block-01">
                     <div class="icon">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/tanzania.jpg" alt="image">
                     </div>
                     <p>TANZANIA</p>
                  </div>
               </div>
               <div class="swiper-slide">
                  <div class="logo-block-01">
                     <div class="icon">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/slide-logo3.png" alt="image">
                     </div>
                     <p>PPB-KENYA</p>
                  </div>
               </div>
               <div class="swiper-slide">
                  <div class="logo-block-01">
                     <div class="icon">
                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/slide-logo2.png" alt="image">
                     </div>
                     <p>HEALTH CANADA</p>
                  </div>
               </div>
              
            </div>
         </div>
         <div class="slider-nav">
            <div class="swipper-but rel-prev-a swipper-prev icon-arrow-1"></div>
            <div class="swipper-but rel-next-a swipper-next icon-arrow-1"></div>
         </div>
      </div>
   </div>
</section>
<section style="background: #f8fcff;" class=" pt-130">
   <div class="wrap">
      <div class="state-block-1 dot-list  ">
         <h2 data-sr="wait 0.1s, enter right">State -of-the-art Manufacturing facilities at <br>Tarapur, Maharashtra (Near Mumbai)</h2>
         
         <div class="flx-row manufactur-block-main">
         <div class="manufactur-block-01">
         <div data-sr="wait 0.1s, enter right">

            <div class="title-03">
               <h3>A. Unit 1</h3>
            </div>
            <p> 
               A State-of-the-art formulation manufacturing facility complying with cGMP norms to manufacture Pharmaceutical dosage form such as:
            </p>
         </div>
         <ul>
            <li data-sr="wait 0.1s, enter right">Liquid Orals</li>
            <li data-sr="wait 0.1s, enter right">Semisolid dosage Forms (Creams, Gel and Ointments)</li>
            <li data-sr="wait 0.1s, enter right">Sterile Ointment/Gel</li>
            <li data-sr="wait 0.1s, enter right">Liquid Externals</li>
         </ul>
               </div>


               <div class="left-side padding-left-box" data-sr="wait 0.1s, enter right">
                  <img class="mx-100" src="<?php echo get_stylesheet_directory_uri(); ?>/images/rgt-hang-image.png" alt="image">
               </div>
               </div>



      </div>
      <div class="state-block-2 d-flx w-100">
        
         <div class="right-side w-100">
            <div class="slider-block-01 slider-block-02 border-blue arrow-style mt-50">
               <div class="slider-sec logo-slider-3 swiper-container over-flow-true style ">
                  <div class="swiper-wrapper"  >
                     <div class="swiper-slide">
                        <div class="logo-block-01">
                           <div class="icon">
                              <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/slide-logo6.png" alt="image">
                           </div>
                           <p>GHANA FDA</p>
                        </div>
                     </div>
                     <div class="swiper-slide">
                        <div class="logo-block-01">
                           <div class="icon">
                              <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/slide-logo8.png" alt="image">
                           </div>
                           <p>NAFDAC Nigeria</p>
                        </div>
                     </div>
                     <div class="swiper-slide">
                        <div class="logo-block-01">
                           <div class="icon">
                              <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/efda.jpg" alt="image">
                           </div>
                           <p>Ethiopia Ferderal democratic republic</p>
                        </div>
                     </div>

                     <div class="swiper-slide">
                        <div class="logo-block-01">
                           <div class="icon">
                              <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/slide-logo11.png" alt="image">
                           </div>
                           <p>Chile</p>
                        </div>
                     </div>

                     <div class="swiper-slide">
                        <div class="logo-block-01">
                           <div class="icon">
                              <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/slide-logo7.png" alt="image">
                           </div>
                           <p>Libiyan MOH</p>
                        </div>
                     </div>


                     <div class="swiper-slide">
                        <div class="logo-block-01">
                           <div class="icon">
                              <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/slide-logo10.png" alt="image">
                           </div>
                           <p>Myanmar MOH</p>
                        </div>
                     </div>

 




                     
                  </div>
               </div>
               <div class="slider-nav">
                  <div class="swipper-but rel-prev-b swipper-prev icon-arrow-1"></div>
                  <div class="swipper-but rel-next-b swipper-next icon-arrow-1"></div>
               </div>
            </div>
         </div>
        
      </div>
      <div class="state-block-3 d-flx flx-align-center pb-20">

      <div class="w-100 flx-row">
         <div class="left-side dot-list w-100">
            <div data-sr="wait 0.1s, enter right" class="w-100">
               <div class="title-03">
                  <h3>B. Unit 2</h3>
               </div>
               <p> A state-of-the-art formulation manufacturing facility complying with cGMP norms to manufacture Pharmaceutical dosage form such as:</p>
            </div>
            <ul>
               <li data-sr="wait 0.1s, enter right">Sterile ophthalmic ointments/gels</li>
               <li data-sr="wait 0.1s, enter right">Sterile General Ointments/gels</li>
               <li data-sr="wait 0.1s, enter right">Sterile prefilled syringes (For external Use)</li>
            </ul>
            <div class="mt-20 mb-20">
            <p>Among the few units designed to meet EU norms for the manufacturing of sterile semi-solid dosage forms in the whole of Asia. The utilities like Purified water system, Air Handling System, Oil fired Boiler, Compressed air are well designed and maintained to ensure proper supply of high-quality utility services.</p>
         </div>
         </div>

          
               </div>

         <div class="right-side mb-80 w-100">
            <div class="slider-block-01 slider-block-02 border-blue arrow-style ">
               <div class="slider-sec logo-slider-3 swiper-container over-flow-true style ">
                  <div class="swiper-wrapper"  >

                     <div class="swiper-slide">
                        <div class="logo-block-01">
                           <div class="icon">
                              <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/world-health-organisation.jpg" alt="image">
                           </div>
                           <p>World Health Organisation (GMP Certification)</p>
                        </div>
                     </div>
                     <div class="swiper-slide">
                        <div class="logo-block-01">
                           <div class="icon">
                              <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/slide-logo9.png" alt="image">
                           </div>
                           <p>SQA Service</p>
                        </div>
                     </div>
                     <div class="swiper-slide">
                        <div class="logo-block-01">
                           <div class="icon">
                              <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/ce.jpg" alt="image">
                           </div>
                           <p>Europe</p>
                        </div>
                     </div>
                    
                  </div>
               </div>
               <div class="slider-nav">
                  <div class="swipper-but rel-prev-a swipper-prev icon-arrow-1"></div>
                  <div class="swipper-but rel-next-a swipper-next icon-arrow-1"></div>
               </div>
            </div>
         </div>
      </div>
    
   </div>
</section>
<?php get_footer('inner'); ?>