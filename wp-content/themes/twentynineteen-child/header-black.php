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

 

   <header class="header-main black-head">
         <div class="container">
            <div class="logo-box"  >
            <a href="<?php echo home_url(); ?>">
               <img class="white-logo" src="<?php echo get_stylesheet_directory_uri(); ?>/images/logo-main-black.png">
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
        <li>
            <a href="#">Home</a>
         </li>
        <li>
            <a href="#">What We Do</a>
            
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
        <li><a href="#">Our Work</a></li>
        <li><a href="#">Media Center</a></li>
        <li><a href="#">Contact</a></li>
       
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
      