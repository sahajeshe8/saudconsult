<?php

function twentysixteen_scripts() {
  // wp_enqueue_style('style-font', 'https://fonts.googleapis.com/css2family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,500&display=swap', true, '1.4', 'all' );

    // enqueue style
    // wp_enqueue_style('PageScrolling', get_stylesheet_directory_uri().'/assets/css/UIPageScrolling.css', true, '1.0', 'all' );

    // wp_enqueue_style('timeline', get_stylesheet_directory_uri().'/assets/css/timeline.min.css', true, '1.4', 'all' );
    wp_enqueue_style('easy-responsive-tabs', get_stylesheet_directory_uri().'/css/easy-responsive-tabs.css', true, '1.4', 'all' );
    // wp_enqueue_style('fullpage', get_stylesheet_directory_uri().'/assets/css/fullpage.css', true, '1.4', 'all' );
 
    wp_enqueue_style('swiper-bundle', get_stylesheet_directory_uri().'/assets/css/swiper-bundle.min.css', true, '1.4', 'all' );
    // wp_enqueue_style('style-bundle', get_stylesheet_directory_uri().'/css/style.css', true, '1.4', 'all' );
    wp_enqueue_style('style-sumoselect', get_stylesheet_directory_uri().'/css/sumoselect.min.css', true, '1.4', 'all' );
    wp_enqueue_style('style-main', get_stylesheet_directory_uri().'/scss/regent.css', true, '1.4', 'all' );
    wp_enqueue_style('style-global', get_stylesheet_directory_uri().'/css/global.css', true, '1.4', 'all' );
    wp_enqueue_style('style-accordion', get_stylesheet_directory_uri().'/css/accordion.css', true, '1.4', 'all' );
    wp_enqueue_style('fancybox', get_stylesheet_directory_uri().'/css/jquery.fancybox.min.css', true, '1.4', 'all' );
    wp_enqueue_style('dflip-css', get_stylesheet_directory_uri().'/css/dflip.min.css', true, '1.4', 'all' );
    // wp_enqueue_style('style-animate', get_stylesheet_directory_uri().'/css/animate.min.css', true, '1.4', 'all' );
     
    
    
    // enqueue script
 
    // wp_enqueue_script('fullpage', get_stylesheet_directory_uri() .'/js/jquery.fullPage.min.js', array('jquery'), '20150825', true);
    // wp_enqueue_script('PageScrolling', get_stylesheet_directory_uri() .'/assets/js/PageScrolling.js', array('jquery'), '20150825', true);
    // wp_enqueue_script('scrolloverflow', get_stylesheet_directory_uri() .'/assets/js/scrolloverflow.js', array('jquery'), '20150825', true);
    // wp_enqueue_script('owl', get_stylesheet_directory_uri() .'/assets/js/owl.carousel.min.js', array('jquery'), '20150825', true);
    // wp_enqueue_script('Scrollbar', get_stylesheet_directory_uri() .'/assets/js/Scrollbar.js', array('jquery'), '20150825', true);
    // wp_enqueue_script('smoothscroll', get_stylesheet_directory_uri() .'/assets/js/smoothscroll.js', array('jquery'), '20150825', true);
    // wp_enqueue_script('hoverplay', get_stylesheet_directory_uri() .'/assets/js/jquery.hoverplay.js', array('jquery'), '20150825', true);
    // wp_enqueue_script('aos', get_stylesheet_directory_uri() .'/assets/js/aos.js', array('jquery'), '20150825', true);
    // wp_enqueue_script('waypoints', get_stylesheet_directory_uri() .'/assets/js/waypoints.min.js', array('jquery'), '20150825', true);
    // wp_enqueue_script('jquery.countup', get_stylesheet_directory_uri() .'/assets/js/jquery.countup.js', array('jquery'), '20150825', true);
    wp_enqueue_script('masonry', get_stylesheet_directory_uri() .'/js/masonry.pkgd.js', array('jquery'), '20150825', true);

    wp_enqueue_script('swiper-bundle', get_stylesheet_directory_uri() .'/js/swiper-bundle.min.js', array('jquery'), '20150825', true);
    wp_enqueue_script('appear', get_stylesheet_directory_uri() .'/js/jquery.appear.js', array('jquery'), '20150825', true);
    wp_enqueue_script('scrollReveal', get_stylesheet_directory_uri() .'/js/scrollReveal.min.js', array('jquery'), '20150825', true);
    wp_enqueue_script('sumoselect', get_stylesheet_directory_uri() .'/js/jquery.sumoselect.min.js', array('jquery'), '20150825', true);
    wp_enqueue_script('marquee', get_stylesheet_directory_uri() .'/js/jquery.marquee.min.js', array('jquery'), '20150825', true);
    wp_enqueue_script('isotope', get_stylesheet_directory_uri() .'/js/isotope.pkgd.min.js', array('jquery'), '20150825', true);
    wp_enqueue_script('easyResponsiveTabs', get_stylesheet_directory_uri() .'/js/easyResponsiveTabs.js', array('jquery'), '20150825', true);
    wp_enqueue_script('fancybox', get_stylesheet_directory_uri() .'/js/jquery.fancybox.min.js', array('jquery'), '20150825', true);
    wp_enqueue_script('waypoints', get_stylesheet_directory_uri() .'/js/jquery.waypoints.min.js', array('jquery'), '20150825', true);
    wp_enqueue_script('countup', get_stylesheet_directory_uri() .'/js/jquery.countup.js', array('jquery'), '20150825', true);
    wp_enqueue_script('dflip', get_stylesheet_directory_uri() .'/js/dflip.js', array('jquery'), '20150825', true);
    // wp_enqueue_script('fancybox', get_stylesheet_directory_uri() .'/js/fancybox.js', array('jquery'), '20150825', true);
    
    wp_enqueue_script('accordion-js', get_stylesheet_directory_uri() .'/js/accordion.js', array('jquery'), '20150825', true);
    // wp_enqueue_script('smoothscrolling', get_stylesheet_directory_uri() .'/js/smoothscrolling.js', array('jquery'), '20150825', true);
    // wp_enqueue_script('timeline', get_stylesheet_directory_uri() .'/assets/js/timeline.js', array('jquery'), '20150825', true);
    // wp_enqueue_script('appear', get_stylesheet_directory_uri() .'/js/jquery.appear.js', array('jquery'), '20150825', true);
wp_enqueue_script('main', get_stylesheet_directory_uri() .'/js/main.js', array('jquery'), '20150825', true);
		
}

register_nav_menus(
    array(
        'header1'  => __( 'Header Menu', 'twentynineteen' ),
        'sub-menus'  => __( 'Sub Menus', 'twentynineteen' ),
    )
);
register_nav_menus(
  array(
      'fixedmenus'  => __( 'Fixed Menu', 'twentynineteen' ),
  )
);
register_nav_menus(
  array(
      'footermenu'  => __( 'Footer Menu', 'twentynineteen' ),
  )
);

function add_menu_link_class( $atts, $item, $args ) {
    if (property_exists($args, 'link_class')) {
      $atts['class'] = $args->link_class;
    }
    return $atts;
  }
add_filter( 'nav_menu_link_attributes', 'add_menu_link_class', 1, 3 );

add_action('wp_enqueue_scripts', 'twentysixteen_scripts');

function df_disable_comments_post_types_support() {
 $post_types = get_post_types();
 foreach ($post_types as $post_type) {
  if(post_type_supports($post_type, 'comments')) {
   remove_post_type_support($post_type, 'comments');
   remove_post_type_support($post_type, 'trackbacks');
  }
 }
}
add_action('admin_init', 'df_disable_comments_post_types_support');
// Close comments on the front-end
function df_disable_comments_status() {
 return false;
}
add_filter('comments_open', 'df_disable_comments_status', 20, 2);
add_filter('pings_open', 'df_disable_comments_status', 20, 2);
// Hide existing comments
function df_disable_comments_hide_existing_comments($comments) {
 $comments = array();
 return $comments;
}
add_filter('comments_array', 'df_disable_comments_hide_existing_comments', 10, 2);
// Remove comments page in menu
function df_disable_comments_admin_menu() {
 remove_menu_page('edit-comments.php');
}
add_action('admin_menu', 'df_disable_comments_admin_menu');
// Redirect any user trying to access comments page
function df_disable_comments_admin_menu_redirect() {
 global $pagenow;
 if ($pagenow === 'edit-comments.php') {
  wp_redirect(admin_url()); exit;
 }
}
add_action('admin_init', 'df_disable_comments_admin_menu_redirect');
// Remove comments metabox from dashboard
function df_disable_comments_dashboard() {
 remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
}
add_action('admin_init', 'df_disable_comments_dashboard');
// Remove comments links from admin bar
function df_disable_comments_admin_bar() {
 if (is_admin_bar_showing()) {
  remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
 }
}
add_action('init', 'df_disable_comments_admin_bar');


// our Code 



remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'wp_shortlink_wp_head');
remove_action('wp_head', 'wp_oembed_add_discovery_links', 10 );
remove_action('wp_head', 'wp_oembed_add_host_js' );
remove_action('wp_head', 'feed_links', 2 );
remove_action('wp_head', 'wp_resource_hints', 2 );
remove_action('wp_head', 'index_rel_link' );
remove_action('wp_head', 'feed_links_extra', 3 );
remove_action('wp_head', 'start_post_rel_link', 10, 0 );
remove_action('wp_head', 'parent_post_rel_link', 10, 0 );
remove_action('rest_api_init', 'wp_oembed_register_route');
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0 );
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);

function pagely_security_headers( $headers ) {
    $headers['X-Frame-Options'] = 'deny';
    $headers['X-XSS-Protection'] = '1; mode=block';
    $headers['X-Content-Type-Options'] = 'nosniff';
    //$headers['Content-Security-Policy'] = 'default-src \'self\' \'unsafe-inline\' fonts.googleapis.com www.googletagmanager.com;';
	  $headers['Content-Security-Policy'] = 'none';
    $headers['Referrer-Policy'] = 'no-referrer-when-downgrade';
    $headers['Expect-CT'] = 'max-age=7776000, enforce';
    $headers['Permissions-Policy'] = null;
    $headers['Cross-Origin-Embedder-Policy'] = 'unsafe-none';
    $headers['Cross-Origin-Resource-Policy'] = 'same-site';
    $headers['Cross-Origin-Opener-Policy'] = 'same-origin';
	  $headers['Strict-Transport-Security'] = 'max-age=31536000;'; 
  	$headers['Developed-By'] = 'Element8'; 
    return $headers;
}

add_filter( 'wp_headers', 'pagely_security_headers' );


/**
 * Prevent update notification for plugin
 * Place in theme functions.php or at bottom of wp-config.php
 */
function disable_plugin_updates( $value ) {
  if ( isset($value) && is_object($value) ) {

    if ( isset( $value->response['advanced-custom-fields-pro/acf.php'] ) ) {
      unset( $value->response['advanced-custom-fields-pro/acf.php'] );
    }

     if ( isset( $value->response['revslider/revslider.php'] ) ) {
      unset( $value->response['revslider/revslider.php'] );
    }

    
  }
  return $value;
}
add_filter( 'site_transient_update_plugins', 'disable_plugin_updates' );


// Admin login section

function my_login_logo() { ?>
  <style type="text/css">
    #login h1 a, .login h1 a {
      background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/assets/images/logo.png); 
      width: 250px !important;
      height:80px;
      background-size:contain;
      background-repeat: no-repeat;
    }
   
    #loginform{ border-radius: 2%; border: 2px solid #593D3D; }
    body.login { 
		background: #E1E1E1;
		width: 100%;
		background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/assets/images/about-pattern-bg.png);
		background-repeat: no-repeat;
		background-size: 100%;
		background-position: bottom;

	}
    .login #backtoblog a, .login #nav a, .privacy-policy-page-link a{color:#FFF !important}
    .wp-core-ui .button-primary{background: #593D3D !important;    border-color:#593D3D !important;}
    .wp-core-ui .button-secondary{ color: #593D3D !important;  }
  </style>
<?php }
add_action( 'login_enqueue_scripts', 'my_login_logo' );

function my_login_logo_url() {
  return 'https://www.element8.ae';
}
add_filter( 'login_headerurl', 'my_login_logo_url' );

function my_login_logo_url_title() {
  return 'Powered by Element8';
}
add_filter( 'login_headertitle', 'my_login_logo_url_title' );

function login_error_override()
{
  return 'Incorrect login details.';
}
add_filter('login_errors', 'login_error_override');

add_action( 'admin_bar_menu', 'remove_wp_logo', 999 );

function remove_wp_logo( $wp_admin_bar ) {
  $wp_admin_bar->remove_node( 'wp-logo' );
}
 

// Option settings
if( function_exists('acf_add_options_page') ) {
  
  acf_add_options_page(array(
    'page_title'  => 'Theme General Settings',
    'menu_title'  => 'Theme Settings',
    'menu_slug'   => 'theme-general-settings',
    'capability'  => 'edit_posts',
    'redirect'    => false
  ));
  
  acf_add_options_sub_page(array(
    'page_title'  => 'Theme Header',
    'menu_title'  => 'Header',
    'parent_slug' => 'theme-general-settings',
  ));

   acf_add_options_sub_page(array(
    'page_title'  => 'Theme Footer',
    'menu_title'  => 'Footer',
    'parent_slug' => 'theme-general-settings',
  ));

    acf_add_options_sub_page(array(
    'page_title'  => 'Theme Social Media',
    'menu_title'  => 'Social Media',
    'parent_slug' => 'theme-general-settings',
  ));
 
  
  
}


add_action( 'wp_footer', 'mycustom_wp_footer' );
 
function mycustom_wp_footer() {
?>
<script>
    document.addEventListener( 'wpcf7submit', function( event ) { 
	  jQuery(".wpcf7-response-output").fadeIn('fast');
      setTimeout(function() {
        jQuery(".wpcf7-response-output").fadeOut('slow');
      }, 5000);
    }, false );
  </script>
<?php
}

