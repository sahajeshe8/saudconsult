<?php
   /**
    * The header for our theme
    *
    * This is the template that displays all of the <head> section and everything up until <div id="content">
    *
    * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
    *
    * @package WordPress
    * @subpackage Twenty_Seventeen
    * @since 1.0
    * @version 1.0
    */
   
   ?>
<!DOCTYPE html>
<!-- theme-pink   <---  this class for color change  add to body-->
<html <?php language_attributes(); ?> class="no-js no-svg">
   <head>
      <meta charset="<?php bloginfo( 'charset' ); ?>">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800;900&family=Raleway:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;1,800&display=swap" rel="stylesheet">
      <?php wp_head(); ?>
   </head>
   <body <?php body_class('page'); ?>   >
      <header class="header-main">
         <div class="wrap flx-row">
            <div class="logo-box"  >
               <a href="<?php echo home_url(); ?>">
               <img class="white-logo" src="<?php echo get_stylesheet_directory_uri(); ?>/images/logo-main.png">
               </a>
            </div>
            <div class="nav-box" id="overlay"  >
               <!-- <ul>
                  <li><a href="<?php //echo site_url('');?>">Home</a></li>
                  <li><a href="<?php// echo site_url('/our-story-animal-wellfair/');?>">What We Do</a></li>
                  <li><a href="<?php //echo site_url('/category/');?>">About Us</a></li>
                  <li><a href="<?php //echo site_url('/news-events/');?>">Our Work</a></li>
                  <li><a href="<?php //echo site_url('/contact-us/');?>">Media Center</a></li>
                  <li><a href="<?php //echo site_url('/contact-us/');?>">Contact</a></li>
                  </ul> -->
               <nav class="main-nav">
                  <ul>
                     <li >
                        <a href="#">Home</a>
                     </li>
                     <li>
                        <a href="javascript:void(0)">About Us</a>
                        <i class="fl flaticon-plus">
                        <span class="icon-arrow-menu"></span>
                        </i>
                        <ul class="submenu">
                           <li><a href="#">Menu item 1</a></li>
                           <li><a href="#">Menu item 2</a></li>
                           <li><a href="#">Menu item 3</a></li>
                        </ul>
                     </li>
                     <li>
                        <a href="#">R & D</a>
                        
                        <ul class="submenu">
                           <li><a href="#">Menu item 1</a></li>
                           <li><a href="#">Menu item 2</a></li>
                           <li><a href="#">Menu item 3</a></li>
                        </ul>
                     </li>
                     <li class="mega-submenu">
                        <a href="#">Services & Products</a>
                        <i class="fl flaticon-plus">
                        <span class="icon-arrow-menu"></span>
                        </i>




<div class="menu-pannel">
    <div id="parentHorizontalTab">
            <ul class="resp-tabs-list horaa_1">
                <li>Services</li>
                <li>Products</li>
            </ul>
            <div class="resp-tabs-container horaa_1">
                <div>
                        <div id="ChildVerticalTab_1">
                            <ul class="resp-tabs-list ver_1">
                                <li>Human Products</li>
                                <li>Veterinary Products</li>
                            </ul>
                            <div class="resp-tabs-container   ver_1">
                                <div>
                                   <ul class="menu-tab-ul">
                                    <li><a href="#">Respiratory </a></li>
                                    <li><a href="#">Immunology / Hematology</a></li>
                                    <li><a href="#">Anti Infectives </a></li>
                                    <li><a href="#">Cardiovascular </a></li>
                                    <li><a href="#">Ophthalmology </a></li>
                                    <li><a href="#">Others</a></li>
                                   </ul>
                                </div>
                                <div>
                                    <p>Lorem ipsum dolor sit amet, lerisque commodo. Nam porta cursus lectusconsectetur adipiscing elit. Vestibulum nibh urna, euismod ut ornare non, volutpat vel tortor. Integer laoreet placerat suscipit. Sed sodales sce. Proin nunc erat, gravida a facilisis quis, ornare id lectus</p>
                                </div>
                            </div>
                        </div>
                </div>

                <div>
                  <div id="ChildVerticalTab_1">
                      <ul class="resp-tabs-list ver_1">
                          <li>Human Products</li>
                          <li>Veterinary Products</li>
                      </ul>
                      <div class="resp-tabs-container   ver_1">
                          <div>
                             <ul class="menu-tab-ul">
                              <li><a href="#">Respiratory </a></li>
                              <li><a href="#">Immunology / Hematology</a></li>
                              <li><a href="#">Anti Infectives </a></li>
                              <li><a href="#">Cardiovascular </a></li>
                              <li><a href="#">Ophthalmology </a></li>
                              <li><a href="#">Others</a></li>
                             </ul>
                          </div>
                          <div>
                              <p>Lorem ipsum dolor sit amet, lerisque commodo. Nam porta cursus lectusconsectetur adipiscing elit. Vestibulum nibh urna, euismod ut ornare non, volutpat vel tortor. Integer laoreet placerat suscipit. Sed sodales sce. Proin nunc erat, gravida a facilisis quis, ornare id lectus</p>
                          </div>
                      </div>
                  </div>
          </div>
            </div>
</div>
</div>







                        <!-- <div class="megamenu">
                           <ul>
                              <li class="parent">
                                 <a href="#" class="parent-item">Products</a>
                                 <div class="menu-tabs">
                                    <ul>
                                       <li class="children change">
                                          <a href="#">Human Products
                                             <i class="fl flaticon-plus">
                                                <span class="icon-arrow-menu"></span>
                                             </i>
                                          </a>
                                          <div class="menu-tab-right-outer">
                                             <ul class="menu-tab-right">
                                                <li><a href="#">Respiratory</a></li>
                                                <li><a href="#">Immunology / Hematology</a></li>
                                                <li><a href="#">Anti Infectives</a></li>
                                                <li><a href="#">Cardiovascular</a></li>
                                                <li><a href="#">Ophthalmology</a></li>
                                                <li><a href="#">Others</a></li>
                                             </ul>
                                          </div>
                                       </li>
                                       <li class="children">
                                          <a href="#">Veterinary Products</a>
                                          <div class="menu-tab-right-outer">
                                             <ul class="menu-tab-right">
                                                <li><a href="#">Parasite control</a></li>
                                                <li><a href="#">Pain management</a></li>
                                                <li><a href="#">Joint Health</a></li>
                                                <li><a href="#">Heart health</a></li>
                                                <li><a href="#">Liver Health</a></li>
                                                <li><a href="#">Eyes and Nose</a></li>
                                                <li><a href="#">Anti Infectives</a></li>
                                                <li><a href="#">Wellness range</a></li>
                                                <li><a href="#">Oral Care</a></li>
                                                <li><a href="#">Immunotherapy</a></li>
                                                <li><a href="#">Renal Health</a></li>
                                             </ul>
                                          </div>
                                       </li>
                                    </ul>
                                 </div>
                              </li>
                              <li class="parent active">
                                 <a href="#" class="parent-item">Services</a>
                                 <div class="menu-tabs">
                                    <ul>
                                       <li class="children change">
                                          <a href="#">Human Products
                                             <i class="fl flaticon-plus">
                                                <span class="icon-arrow-menu"></span>
                                             </i>
                                          </a>
                                          <div class="menu-tab-right-outer">
                                             <ul class="menu-tab-right">
                                                <li><a href="#">Respiratory</a></li>
                                                <li><a href="#">Immunology / Hematology</a></li>
                                                <li><a href="#">Anti Infectives</a></li>
                                                <li><a href="#">Cardiovascular</a></li>
                                                <li><a href="#">Ophthalmology</a></li>
                                                <li><a href="#">Others</a></li>
                                             </ul>
                                          </div>
                                       </li>
                                       <li class="children">
                                          <a href="#">Veterinary Products</a>
                                          <div class="menu-tab-right-outer">
                                             <ul class="menu-tab-right">
                                                <li><a href="#">Parasite control </a></li>
                                                <li><a href="#">Pain management</a></li>
                                                <li><a href="#">Joint Health</a></li>
                                                <li><a href="#">Heart health</a></li>
                                                <li><a href="#">Liver Health</a></li>
                                                <li><a href="#">Eyes and Nose</a></li>
                                                <li><a href="#">Anti Infectives</a></li>
                                                <li><a href="#">Wellness range</a></li>
                                                <li><a href="#">Oral Care</a></li>
                                                <li><a href="#">Immunotherapy</a></li>
                                                <li><a href="#">Renal Health</a></li>
                                             </ul>
                                          </div>
                                       </li>
                                    </ul>
                                 </div>
                              </li>
                           </ul>
                        </div> -->
                     </li>
                     <li>
                        <a href="#">Facilities</a>
                        <!-- <i class="fl flaticon-plus">
                        <span class="icon-arrow-menu"></span>
                        </i> -->
                        <ul class="submenu">
                           <li><a href="#">Menu item 1</a></li>
                           <li><a href="#">Menu item 2</a></li>
                           <li><a href="#">Menu item 3</a></li>
                        </ul>
                     </li>
                     <li><a href="#">CSR</a></li>
                     <li><a href="#">Media Center</a></li>
                     <li><a href="#">Contact Us</a></li>
                  </ul>
               </nav>
            </div>
            <div class="burger">
               <div class="burger__patty"></div>
               <div class="burger__patty"></div>
               <div class="burger__patty"></div>
            </div>
         </div>
      </header>
      <!-- <div id="fullpage"> -->
      <!-- <main > -->
      <script></script>