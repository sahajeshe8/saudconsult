<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 *
 * @package Gulberg
 * @subpackage Gulberg_theme
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="icon" href="">
<link rel="profile" href="https://gmpg.org/xfn/11" />

<?php
if ( ! function_exists( '_wp_render_title_tag' ) ) {
    function theme_slug_render_title() {
?>
<title><?php wp_title( '|', true, 'right' ); ?></title>
<?php
    }
    add_action( 'wp_head', 'theme_slug_render_title' );
}
?>




<?php wp_head(); ?>
</head>
<body <?php body_class();?>>
 <?php 
 $class = '';
 if ( is_singular(array('video','guide','deep_dive','post'))|| is_page_template(array('business-insights.php','blogs-news.php','guides.php','deep-dives.php','videos.php','thank-you.php','thankyou-career.php'))||is_search()) { 
    $class.="blog-header";
 } 

 ?> 
 <?php if(!is_page_template('contact-us.php')){ ?>
<header class="header <?php echo $class;?>">
    <div class="header_inner">
        <div class="header-logo-area">
            <a href="<?php echo home_url(); ?>">
                <img src="<?php echo get_field('site_logo_hover', 'options')['url']; ?>" alt="<?php echo get_field('site_logo_hover', 'options')['alt']; ?>" class="logo-white">
                <img src="<?php echo get_field('site_logo', 'options')['url']; ?>" alt="<?php echo get_field('site_logo', 'options')['alt']; ?>" class="logo-clr"></a>
        </div>
        <div class="header-left-section">
              <!-- <?php if(wp_is_mobile()){ ?>
        <div class="lang-area-select 11">
                <select>
                    <option>EN</option>
                    <option>AR</option>
                </select>
            </div>
             <?php }?> -->

            <div class="menu-bars-place menu-button">
                <div class="animated-icon1"><span></span><span></span><span></span></div>
            </div>
            
            <?php if(!wp_is_mobile()){ ?>
            <nav>
                 <?php
                    wp_nav_menu( array(
                        'menu'   => 'Main Menu',
                        'container' => 'ul',
                        'menu_class' => 'header-main-menu'
                    ) );
                    ?>
            </nav>
           
            <!-- <div class="lang-area-select">
                <select>
                    <option>English</option>
                    <option>Arabic</option>
                </select>
            </div> -->
             <?php }?>
        
        </div>
    </div> 
</header>
<?php if (wp_is_mobile() ){ ?>

<div class="mob-menu">
    <div class="header-close-btn">
        <!-- <div class="lang-area-select">
            <select>
                <option>English</option>
                <option>Arabic</option>
            </select>
        </div> -->
        <div class="bars-wrap menu-button">
            <div class="animated-icon1"><span></span><span></span><span></span></div>  
        </div>
    </div>
    <div class="mob-menu-wrap">
         <nav>
             <?php
                wp_nav_menu( array(
                    'menu'   => 'Main Menu',
                    'container' => 'ul',
                    'menu_class' => 'header-main-menu'
                ) );
                ?>
        </nav>
    </div>
    <ul class="social-media-mob">
        <li><a href="#"><i class="fa-solid fa-phone"></i></a></li>
        <li><a href="#"><i class="fa-brands fa-instagram"></i></a></li>
        <li><a href="#"><i class="fa-brands fa-linkedin-in"></i></a></li>
        <li><a href="#"><i class="fa-brands fa-facebook-f"></i></a></li>
    </ul>
</div>
<?php } ?>

<?php } else{ ?>
    <?php if (wp_is_mobile() ){ ?>
        <header class="header">
    <div class="header_inner">
        <div class="header-logo-area">
            <a href="<?php echo home_url(); ?>">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.png" alt="logo" class="logo-white">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo-clr.png" alt="logo" class="logo-clr"></a>
        </div>
        <div class="header-left-section">  
        <div class="menu-bars-place menu-button">
                <div class="animated-icon1"><span></span><span></span><span></span></div>
            </div>         
            <!-- <div class="lang-area-select 123">
                <select>
                    <option>EN</option>
                    <option>AR</option>
                </select>
            </div> -->
        </div>
    </div> 
</header>

<div class="mob-menu">
    <div class="header-close-btn">
        <!-- <div class="lang-area-select">
            <select>
                <option>English</option>
                <option>Arabic</option>
            </select>
        </div> -->
        <div class="bars-wrap menu-button">
            <div class="animated-icon1"><span></span><span></span><span></span></div>  
        </div>
    </div>
    <div class="mob-menu-wrap">
         <nav>
             <?php
                wp_nav_menu( array(
                    'menu'   => 'Main Menu',
                    'container' => 'ul',
                    'menu_class' => 'header-main-menu'
                ) );
                ?>
        </nav>
    </div>
     <?php
// Check rows exists.
					if (have_rows('social_media', 'options')) :?>
                       			<ul class="social-media-mob">
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
					endif; ?>
   
</div>

<?php } else { ?>
<header class="header">
    <div class="header_inner">
        <div class="header-logo-area">
            <a href="<?php echo home_url(); ?>">
               <img src="<?php echo get_field('site_logo_hover', 'options')['url']; ?>" alt="<?php echo get_field('site_logo_hover', 'options')['alt']; ?>" class="logo-white">
                <img src="<?php echo get_field('site_logo', 'options')['url']; ?>" alt="<?php echo get_field('site_logo', 'options')['alt']; ?>" class="logo-clr"></a>
        </div>
        <div class="header-left-section">
            <a href="<?php echo home_url(); ?>" class="back-home"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/back-home.png" alt="icon">Back to homepage</a>
            <!-- <div class="lang-area-select">
                <select>
                    <option>English</option>
                    <option>Arabic</option>
                </select>
            </div> -->
        </div>
    </div> 
</header>
<?php } ?>
<?php } ?>    

  