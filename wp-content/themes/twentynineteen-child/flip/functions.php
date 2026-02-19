<?php

function theme_project_scripts() {
  $ver = date('dmyhis');
    wp_enqueue_style( 'theme-style', get_stylesheet_uri() ); 
    wp_enqueue_style( 'responsive-css', get_template_directory_uri() . '/assets/css/responsive.css');
    wp_enqueue_style( 'fontawesome-all', get_template_directory_uri() . '/assets/css/all.min.css');
    wp_enqueue_style( 'niceselect', get_template_directory_uri() . '/assets/css/nice-select.css');
    wp_enqueue_style( 'wow-animation-style', get_template_directory_uri() . '/assets/css/wow-animate.css');
    wp_enqueue_style( 'glide-core-style', get_template_directory_uri() . '/assets/css/glide.core.css');
    wp_enqueue_style( 'magnific-popup-style', get_template_directory_uri() . '/assets/css/magnific-popup.css');
    wp_enqueue_style( 'jquery.fancybox.min', get_template_directory_uri() . '/assets/css/jquery.fancybox.min.css');
 

    //jquery
    wp_enqueue_script( 'theme-script', get_template_directory_uri() . '/assets/js/jquery-3.6.0.min.js', array(), $ver, true );
    wp_enqueue_script( 'project-script', get_template_directory_uri() . '/assets/js/common-script.js', array(), $ver, true );
    wp_enqueue_script( 'niceselect-script', get_template_directory_uri() . '/assets/js/nice-select.js', array(), $ver, true );
    wp_enqueue_script( 'wow-script', get_template_directory_uri() . '/assets/js/wow.min.js', array(), $ver, true );
    wp_enqueue_script( 'glide-script', get_template_directory_uri() . '/assets/js/glide.js', array(), $ver, true );
    wp_enqueue_script( 'magnific-popup-js', get_template_directory_uri() . '/assets/js/jquery.magnific-popup.js', array(), $ver, true );
    wp_enqueue_script( 'jquery.fancybox.min', get_template_directory_uri() . '/assets/js/jquery.fancybox.min.js', array(), $ver, true );
    wp_enqueue_script( 'my_loadmore', get_template_directory_uri() . '/assets/js/load-more.js', array(), $ver, true );

    

}
add_action( 'wp_enqueue_scripts', 'theme_project_scripts',10);

	add_theme_support('post-thumbnails');
  add_theme_support( 'title-tag' );

/* Register Menu */
function register_my_menus() {
  register_nav_menus(
    array(
      'header-menu' => __( 'Header Menu' ),
      'footer-menu' => __( 'Footer Menu' ),
      'footer-menu2' => __( 'Footer Menu 2' ),
      'privacy-policy' => __( 'Privacy Policy' )
    )
  );
}
add_action( 'init', 'register_my_menus' );


function add_slug_body_class( $classes ) {
global $post;
if ( isset( $post ) ) {
  $classes[] = $post->post_name;
}
  return $classes;
}
add_filter( 'body_class', 'add_slug_body_class' );




// Disable Gutenberg on the back end.
add_filter( 'use_block_editor_for_post', '__return_false' );

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

  acf_add_options_sub_page(array(
    'page_title'  => 'Guides Pop up Media',
    'menu_title'  => 'Guides Popup',
    'parent_slug' => 'theme-general-settings',
  ));
  



  
  
  
}


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



function my_login_logo() { ?>
  <style type="text/css">
    #login h1 a, .login h1 a {
      background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/assets/images/logo.png);    
      width:187px; 
      height:70px;
      background-size:contain;
      background-repeat: no-repeat;
    }
    #loginform{ border-radius: 2%; border: 2px solid #000; }
    body.login { 
      background: #000000;
      width: 100%;
      background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/assets/images/charter_bg-image.jpg);
      background-repeat: no-repeat;
      background-size: 100%;

    }
    .login #backtoblog a, .login #nav a, .privacy-policy-page-link a{color:#000 !important}
    .wp-core-ui .button-primary{background:#000 !important; border-color:#000 !important;}
    .wp-core-ui .button-secondary{ color:#000 !important;}
    .wp-core-ui .button-primary:hover{
      background:#5B3427 !important;
      border-color:#5B3427 !important;
    }
    div.nsl-container.nsl-container-block .nsl-container-buttons{
      width:100%;
    }
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

add_action( 'template_redirect', 'prefix_remove_template_redirect', 10, 2);

function prefix_remove_template_redirect(){
ob_start( function( $buffer ){
$buffer = str_replace( array( 
    '<script type="text/javascript">',
    "<script type='text/javascript'>", 
    "<script type='text/javascript' src=",
    '<script type="text/javascript" src=',
    '<style type="text/css">', 
    "' type='text/css' media=", 
    '<style type="text/css" media',
    "' type='text/css'>"
), 
array(
    '<script>', 
    "<script>", 
    "<script src=",
    '<script src=',
    '<style>', 
    "' media=", 
    '<style media',
    "' >"
), $buffer );

return $buffer;
});
};


//enable upload for webp image files.
function webp_upload_mimes($existing_mimes) {
    $existing_mimes['webp'] = 'image/webp';
    return $existing_mimes;
}
add_filter('mime_types', 'webp_upload_mimes');

//enable preview / thumbnail for webp image files.
function webp_is_displayable($result, $path) {
    if ($result === false) {
        $displayable_image_types = array( IMAGETYPE_WEBP );
        $info = @getimagesize( $path );

        if (empty($info)) {
            $result = false;
        } elseif (!in_array($info[2], $displayable_image_types)) {
            $result = false;
        } else {
            $result = true;
        }
    }

    return $result;
}
add_filter('file_is_displayable_image', 'webp_is_displayable', 10, 2);













function formatSizeUnits($bytes)
{
  if ($bytes >= 1073741824) {
    $bytes = number_format($bytes / 1073741824, 2) . ' GB';
  } elseif ($bytes >= 1048576) {
    $bytes = number_format($bytes / 1048576, 2) . ' MB';
  } elseif ($bytes >= 1024) {
    $bytes = number_format($bytes / 1024, 2) . ' KB';
  } elseif ($bytes > 1) {
    $bytes = $bytes . ' bytes';
  } elseif ($bytes == 1) {
    $bytes = $bytes . ' byte';
  } else {
    $bytes = '0 bytes';
  }

  return $bytes;
}



function getYouTubeDetails($youtubeId)
{
  //Its different for all users
  $myApiKey = 'AIzaSyBI46ESod0yYiHR8NHCdN9XE8o0RzFmOuo';
  $googleApi =
    'https://www.googleapis.com/youtube/v3/videos?id='
    . $youtubeId . '&key=' . $myApiKey . '&part=snippet,statistics,contentDetails';

  /* Create new resource */
  $ch = curl_init();

  curl_setopt($ch, CURLOPT_HEADER, 0);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  /* Set the URL and options  */
  curl_setopt($ch, CURLOPT_URL, $googleApi);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
  curl_setopt($ch, CURLOPT_VERBOSE, 0);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  /* Grab the URL */
  $curlResource = curl_exec($ch);

  /* Close the resource */
  curl_close($ch);

  $youtubeData = json_decode($curlResource);

  $youtubeVals = json_decode(
    json_encode($youtubeData),
    true
  );

  return $youtubeVals;
}

function time_elapsed_string($datetime, $full = false)
{

  /*echo time_elapsed_string('2013-05-01 00:22:35');
    echo time_elapsed_string('@1367367755'); # timestamp input
    echo time_elapsed_string('2013-05-01 00:22:35', true);*/

  $now = new DateTime;
  $ago = new DateTime($datetime);
  $diff = $now->diff($ago);

  $diff->w = floor($diff->d / 7);
  $diff->d -= $diff->w * 7;

  $string = array(
    'y' => 'year',
    'm' => 'month',
    'w' => 'week',
    'd' => 'day',
    'h' => 'hour',
    'i' => 'minute',
    's' => 'second',
  );
  foreach ($string as $k => &$v) {
    if ($diff->$k) {
      $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
    } else {
      unset($string[$k]);
    }
  }

  if (!$full) $string = array_slice($string, 0, 1);
  return $string ? implode(', ', $string) . ' ago' : 'just now';
}


function thousandsCurrencyFormat($num)
{

  /*thousandsCurrencyFormat(3000) - 3k
  thousandsCurrencyFormat(35500) - 35.5k
  thousandsCurrencyFormat(905000) - 905k
  thousandsCurrencyFormat(5500000) - 5.5m
  thousandsCurrencyFormat(88800000) - 88.8m
  thousandsCurrencyFormat(745000000) - 745m
  thousandsCurrencyFormat(2000000000) - 2b
  thousandsCurrencyFormat(22200000000) - 22.2b
  thousandsCurrencyFormat(1000000000000) - 1t (1 trillion)*/

  if ($num > 1000) {

    $x = round($num);
    $x_number_format = number_format($x);
    $x_array = explode(',', $x_number_format);
    $x_parts = array('k', 'm', 'b', 't');
    $x_count_parts = count($x_array) - 1;
    $x_display = $x;
    $x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
    $x_display .= $x_parts[$x_count_parts - 1];

    return $x_display;
  }

  return $num;
}

function duration($ytDuration)
{
  $di = new DateInterval($ytDuration);
  //print_r($di);
  $totalSec = 0;
  if ($di->h > 0) {
    $totalSec += $di->h * 3600;
  }
  if ($di->i > 0) {
    $totalSec += $di->i * 60;
  }
  $totalSec += $di->s;

  $duration = brsfl_secondsToTime($totalSec);

  return $duration;
}

function brsfl_secondsToTime($inputSeconds)
{

  $secondsInAMinute = 60;
  $secondsInAnHour  = 60 * $secondsInAMinute;
  $secondsInADay    = 24 * $secondsInAnHour;

  // extract days
  $days = floor($inputSeconds / $secondsInADay);

  // extract hours
  $hourSeconds = $inputSeconds % $secondsInADay;
  $hours = floor($hourSeconds / $secondsInAnHour);

  // extract minutes
  $minuteSeconds = $hourSeconds % $secondsInAnHour;
  $minutes = floor($minuteSeconds / $secondsInAMinute);

  // extract the remaining seconds
  $remainingSeconds = $minuteSeconds % $secondsInAMinute;
  $seconds = ceil($remainingSeconds);

  // DAYS
  if ((int)$days == 0)
    $days = '';
  elseif ((int)$days < 10)
    $days = '0' . (int)$days . ':';
  else
    $days = (int)$days . ':';

  // HOURS
  if ((int)$hours == 0)
    $hours = '';
  elseif ((int)$hours < 10)
    $hours = '0' . (int)$hours . ':';
  else
    $hours = (int)$hours . ':';

  // MINUTES
  if ((int)$minutes == 0)
    $minutes = '00:';
  elseif ((int)$minutes < 10)
    $minutes = '0' . (int)$minutes . ':';
  else
    $minutes = (int)$minutes . ':';

  // SECONDS
  if ((int)$seconds == 0)
    $seconds = '00';
  elseif ((int)$seconds < 10)
    $seconds = '0' . (int)$seconds;

  return $days . $hours . $minutes . $seconds;
}


add_filter('pre_get_posts', 'filter_search_cpt_threads');
/** filter search for threads CPT */

function filter_search_cpt_threads($query)
{
  if ( !is_admin() && $query->is_main_query() && $query->is_search ) {
     $query->set('post_type', array('post','guide','deep_dive', 'video'));
     $query->set('exact', false);
     $query->set('sentence', false);
     $query->set( 'suppress_filters', false );
      $query->set( 'orderby', array( 'relevance' => 'desc' ) );
   }


    return $query;

}



  /* Awards Load more */
  function awards_load_more_scripts() {

   $args=array('post_type' => 'testimonials',
     'post_status' => 'publish',
     'posts_per_page' => 4,                   
     'paged' => get_query_var('paged') ? get_query_var('paged') : 1,
			//'meta_key' => 'add_date',
     'orderby' => 'date',
     'order' => 'DESC',
   );
		    // The Query
   $the_query = new WP_Query( $args );
			// In most cases it is already included on the page and this line can be removed
   wp_enqueue_script('jquery');
   
	// register our main script but do not enqueue it yet
   wp_register_script( 'my_loadmore', get_stylesheet_directory_uri() . '/assets/js/load-more.js', array('jquery') );
   
	// now the most interesting part
	// we have to pass parameters to myloadmore.js script but we can get the parameters values only in PHP
	// you can define variables directly in your HTML but I decided that the most proper way is wp_localize_script()
   wp_localize_script( 'my_loadmore', 'awards_loadmore_params', array(
		'ajaxurl' => admin_url('admin-ajax.php'), // WordPress AJAX
		'posts' => json_encode( $the_query->query_vars ), // everything about your loop is here
		'current_page' => get_query_var( 'paged' ) ? get_query_var('paged') : 1,
		'max_page' => $the_query->max_num_pages
	) );
   
   wp_enqueue_script( 'my_loadmore' );
 }
 
 add_action( 'wp_enqueue_scripts', 'awards_load_more_scripts' );

 function awards_loadmore_ajax_handler(){

	// prepare our arguments for the query
   $args = json_decode( stripslashes( $_POST['query'] ), true );
	$args['paged'] = $_POST['page'] + 1; // we need next page to be loaded
   // $args['post_type'] = $_POST['post_type'];
	$args['post_status'] = 'publish';

	// it is always better to use WP_Query but not here
	query_posts( $args );

	if( have_posts()):

		// run the loop
		while( have_posts() ): the_post();?>
    <li>
					<div class="testimonial-image-box">
						<figure>
							<picture>
						<?php if( get_field('testimonials_image_webp') ){ ?><source srcset="<?php echo get_field('testimonials_image_webp')['url']; ?>" type="image/webp"><?php } ?>
						<?php if( get_field('testimonials_image') ){ ?><source srcset="<?php echo get_field('testimonials_image')['url']; ?>" type="image/png"><?php } ?>
						<?php if( get_field('testimonials_image') ){ ?><img src="<?php echo get_field('testimonials_image')['url']; ?>" alt=image><?php } ?>
								
							</picture>
						</figure>
						<?php if( get_field('video_url') ){ ?>
						<a href="#video" class="openVideo"><i class="fa-sharp fa-solid fa-play"></i></a>
						<div id="video" class="video-popup mfp-hide">
						<video preload="false" controls>
							<source src="<?php echo get_field('video_url'); ?>" type="video/mp4">
						</video>
					</div>
					<?php } ?>
					</div>
					<div class="testimonial-content-box">
						<h5><?php the_title(); ?></h5>
						<p><?php echo get_field('company_name'); ?></p>
						<p><?php echo get_field('department'); ?></p>
					</div>
				</li>
     
      <?php
      
    endwhile;
    
  endif;
	die; // here we exit the script and even no wp_reset_query() required!
}


add_action('wp_ajax_loadmore', 'awards_loadmore_ajax_handler'); // wp_ajax_{action}
add_action('wp_ajax_nopriv_loadmore', 'awards_loadmore_ajax_handler'); // wp_ajax_nopriv_{action}


// Custom Thumbnail size
add_action( 'after_setup_theme', 'my_child_theme_image_size', 11 );
function my_child_theme_image_size() {
  add_image_size( 'webp_image', 585, 585, true );  
  add_image_size( 'webp_list', 240, 240, true );  
}



