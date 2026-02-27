<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package tasheel
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php
	?>
	<script>
(function(){
	function hasLoginPopupHash(){var h=window.location.hash||'';return h.indexOf('login-popup')!==-1&&h.indexOf('login-popup-training-submit')===-1;}
	function goToCleanUrl(){
		var u=window.location.pathname,q=window.location.search||'';
		window.location.replace(u+q);
	}
	if(hasLoginPopupHash()){goToCleanUrl();return;}
	if(<?php echo is_user_logged_in() ? 'true' : 'false'; ?>&&window.location.search.indexOf('open_login=1')!==-1){
		var p=new URLSearchParams(window.location.search);p.delete('open_login');p.delete('redirect_to');
		window.location.replace(window.location.pathname+(p.toString()?'?'+p.toString():''));
		return;
	}
	function onBackOrRestore(){if(hasLoginPopupHash())goToCleanUrl();}
	window.addEventListener('popstate',onBackOrRestore);
	window.addEventListener('pageshow',function(e){if(e.persisted)onBackOrRestore();});
})();
</script>
	<?php
	// Determine header classes based on page type
	$header_classes = array( 'header-main', 'header_b' );
	
	// Front page
	if ( is_front_page() ) {
		$header_classes[] = 'header-front-page';
	}
	
	// Inner pages with banner
	if ( is_page() && ! is_front_page() ) {
		$header_classes[] = 'header-inner-page';
		
		// Check if page has banner (inner-banner template part)
		$has_banner = true; // Default to true for inner pages
		if ( ! $has_banner ) {
			$header_classes[] = 'header-no-banner';
		}
	}
	
	// Media Center Detail page
	if ( is_page_template( 'page-media-center-detail.php' ) ) {
		$header_classes[] = 'header-media-center-detail';
		$header_classes[] = 'media-center-detail-page';
		$header_classes[] = 'header-no-banner';
	}
	
	// Contact Us page
	if ( is_page_template( 'page-contact-us.php' ) ) {
		$header_classes[] = 'header-contact-page';
	}
	
	// Careers page
	if ( is_page_template( 'page-careers.php' ) ) {
		$header_classes[] = 'header-careers-page';
	}
	
	// Career Detail page
	if ( is_page_template( 'page-career-detail.php' ) ) {
		$header_classes[] = 'header-career-detail';
		$header_classes[] = 'career-detail-page';
		$header_classes[] = 'header-no-banner';
	}
	
	// About Us page
	if ( is_page_template( 'page-about-us.php' ) ) {
		$header_classes[] = 'header-about-page';
	}
	
	// Awards page
	if ( is_page_template( 'page-template-awards.php' ) ) {
		$header_classes[] = 'header-awards-page';
	}
	
	// Products pages
	if ( is_page_template( 'page-products.php' ) || is_page_template( 'page-product-detail.php' ) ) {
		$header_classes[] = 'header-products-page';
	}
	
	// Projects pages
	if ( is_page_template( 'page-projects.php' ) || is_page_template( 'page-project-detail.php' ) ) {
		$header_classes[] = 'header-projects-page';
	}
	
	// Brands pages
	if ( is_page_template( 'page-brands.php' ) || is_page_template( 'page-brand-detail.php' ) ) {
		$header_classes[] = 'header-brands-page';
	}
	
	// Blog/Archive pages
	if ( is_home() || is_archive() || is_single() ) {
		$header_classes[] = 'header-blog-page';
	}
	
	// 404 page
	if ( is_404() ) {
		$header_classes[] = 'header-404-page';
	}
	
	// Sitemap page
	if ( is_page_template( 'page-sitemap.php' ) ) {
		$header_classes[] = 'header-sitemap-page';
	}
	
	// Check for custom header class from page template
	global $header_custom_class;
	if ( ! empty( $header_custom_class ) ) {
		$header_classes[] = $header_custom_class;
	}
	
	$header_class_string = implode( ' ', array_unique( $header_classes ) );
	
	// Determine which logo to use based on header class (dynamic from ACF)
	$is_black_header = in_array( 'black-header', $header_classes );
	$logo_default_url = function_exists( 'tasheel_get_header_logo_url' ) ? tasheel_get_header_logo_url( 'default' ) : null;
	$logo_dark_url   = function_exists( 'tasheel_get_header_logo_url' ) ? tasheel_get_header_logo_url( 'dark' ) : null;
	$logo_url        = $is_black_header ? ( $logo_dark_url ?: get_template_directory_uri() . '/assets/images/saudconsult-logo-black.svg' ) : ( $logo_default_url ?: get_template_directory_uri() . '/assets/images/saudconsult-logo.svg' );
	$logo_white_url  = $logo_default_url ?: get_template_directory_uri() . '/assets/images/saudconsult-logo.svg';
	$logo_black_url  = $logo_dark_url ?: get_template_directory_uri() . '/assets/images/saudconsult-logo-black.svg';
	
	// Helper function to check if a URL matches the current page
	if ( ! function_exists( 'is_current_menu_item' ) ) {
		function is_current_menu_item( $url ) {
			// Get menu URL path
			$menu_url = esc_url( $url );
			$menu_path = parse_url( $menu_url, PHP_URL_PATH );
			$menu_path = untrailingslashit( $menu_path );
			$menu_slug = basename( $menu_path );
			
			// Get current request URI
			$request_uri = isset( $_SERVER['REQUEST_URI'] ) ? $_SERVER['REQUEST_URI'] : '';
			$request_path = untrailingslashit( parse_url( $request_uri, PHP_URL_PATH ) );
			
			// Check if request path matches menu path
			if ( $request_path === $menu_path || $request_path === $menu_path . '/' ) {
				return true;
			}
			
			// Check using WordPress functions
			if ( is_page() ) {
				global $post;
				if ( $post ) {
					$page_slug = $post->post_name;
					$page_uri = get_page_uri( $post->ID );
					
					// Check by slug
					if ( $menu_slug === $page_slug ) {
						return true;
					}
					
					// Check by URI
					if ( $page_uri && ( $menu_path === '/' . $page_uri || $menu_path === '/' . basename( $page_uri ) ) ) {
						return true;
					}
					
					// Check by permalink
					$page_permalink = get_permalink( $post->ID );
					$page_permalink_path = untrailingslashit( parse_url( $page_permalink, PHP_URL_PATH ) );
					if ( $page_permalink_path === $menu_path ) {
						return true;
					}
				}
			}
			
			// Check if current page is a child of the menu URL
			if ( $menu_path && $request_path && strpos( $request_path, $menu_path ) === 0 ) {
				return true;
			}
			
			// Final check: compare current URL with menu URL
			$current_url = home_url( $request_uri );
			$current_path = untrailingslashit( parse_url( $current_url, PHP_URL_PATH ) );
			if ( $current_path === $menu_path ) {
				return true;
			}
			
			return false;
		}
	}
	
	// Get current page URL for comparison
	$current_page_url = home_url( $_SERVER['REQUEST_URI'] );
	?>
	<header class="<?php echo esc_attr( $header_class_string ); ?>" id="headerMainSection">
   <div class="wrap">

     <div class="header_main_wrapper">
        <div class="logo_desktop text-center d-flex">
            <?php if ( ! empty( $logo_url ) ) : ?>
                <a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">
                    <img src="<?php echo esc_url( $logo_url ); ?>" 
                         alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"
                         id="header-logo"
                         data-logo-white="<?php echo esc_url( $logo_white_url ); ?>"
                         data-logo-black="<?php echo esc_url( $logo_black_url ); ?>"
                         data-is-black-header="<?php echo $is_black_header ? 'true' : 'false'; ?>">
                </a>
            <?php endif; ?>
        </div>
 <div class="desk_nav_right">
                <div class="navbar nav_desk">
                    <?php
                    $header_menu_id = function_exists( 'tasheel_get_header_menu_id' ) ? tasheel_get_header_menu_id() : null;
                    $menu_args = array(
                        'container'      => false,
                        'items_wrap'     => '<ul class="list-unstyled">%3$s</ul>',
                        'fallback_cb'    => false,
                        'walker'         => new Tasheel_Header_Mega_Menu_Walker(),
                        'depth'          => 2,
                        'menu_class'     => '',
                    );
                    if ( $header_menu_id ) {
                        $menu_args['menu'] = $header_menu_id;
                    } else {
                        $menu_args['theme_location'] = has_nav_menu( 'header-menu' ) ? 'header-menu' : 'menu-1';
                    }
                    $has_menu = false;
                    if ( $header_menu_id || has_nav_menu( 'menu-1' ) || has_nav_menu( 'header-menu' ) ) {
                        ob_start();
                        wp_nav_menu( $menu_args );
                        $menu_output = ob_get_clean();
                        $has_menu = ! empty( trim( $menu_output ) );
                        if ( $has_menu ) {
                            echo $menu_output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                        }
                    }
                    if ( ! $has_menu ) {
                        get_template_part( 'template-parts/header', 'fallback-menu' );
                    }
                    ?>
                    <div class="menu_right_block">
                    <?php if ( function_exists( 'tasheel_header_show_login' ) && tasheel_header_show_login() ) : ?>
                    <?php
                    $my_profile_url = function_exists( 'tasheel_hr_my_profile_url' ) ? tasheel_hr_my_profile_url() : home_url( '/my-profile/' );
                    if ( is_user_logged_in() ) : ?>
                    <a href="<?php echo esc_url( $my_profile_url ); ?>" class="user-profile-link" title="<?php esc_attr_e( 'My Profile', 'tasheel' ); ?>">
					<svg xmlns="http://www.w3.org/2000/svg" width="16" height="20" viewBox="0 0 16 20" fill="#a8d05a">
<path d="M7.95 7.95C9.93822 7.95 11.55 6.33822 11.55 4.35C11.55 2.36177 9.93822 0.75 7.95 0.75C5.96177 0.75 4.35 2.36177 4.35 4.35C4.35 6.33822 5.96177 7.95 7.95 7.95Z" stroke="white" stroke-width="1.5"/>
<path d="M15.15 14.7C15.15 16.9365 15.15 18.75 7.95 18.75C0.75 18.75 0.75 16.9365 0.75 14.7C0.75 12.4635 3.9738 10.65 7.95 10.65C11.9262 10.65 15.15 12.4635 15.15 14.7Z" stroke="white" stroke-width="1.5"/>
</svg>
                    </a>
                    <?php else : ?>
                    <a href="#login-popup" class="user-login-trigger" data-fancybox="login-popup">
					<svg xmlns="http://www.w3.org/2000/svg" width="16" height="20" viewBox="0 0 16 20" fill="none">
<path d="M7.95 7.95C9.93822 7.95 11.55 6.33822 11.55 4.35C11.55 2.36177 9.93822 0.75 7.95 0.75C5.96177 0.75 4.35 2.36177 4.35 4.35C4.35 6.33822 5.96177 7.95 7.95 7.95Z" stroke="white" stroke-width="1.5"/>
<path d="M15.15 14.7C15.15 16.9365 15.15 18.75 7.95 18.75C0.75 18.75 0.75 16.9365 0.75 14.7C0.75 12.4635 3.9738 10.65 7.95 10.65C11.9262 10.65 15.15 12.4635 15.15 14.7Z" stroke="white" stroke-width="1.5"/>
</svg>
                    </a>
                    <?php endif; ?>
                    <?php endif; ?>
                    <?php
                    if ( has_action( 'wpml_add_language_selector' ) ) {
                        echo '<div class="language_switcher_wrap language_button button_link">';
                        do_action( 'wpml_add_language_selector' );
                        echo '</div>';
                    }
                    ?>
                    <?php
                    $header_btn = function_exists( 'tasheel_get_header_button' ) ? tasheel_get_header_button() : array( 'text' => esc_html__( 'Contact', 'tasheel' ), 'url' => home_url( '/contact' ) );
                    if ( $header_btn ) :
                    ?>
                    <a class="btn_style btn_transparent <?php echo $is_black_header ? 'btn_green' : ''; ?>" href="<?php echo esc_url( $header_btn['url'] ); ?>">
                        <?php echo esc_html( $header_btn['text'] ); ?>
                    </a>
                    <?php endif; ?>
                    </div>
                </div>

            </div>

            <div class="mobile_header_actions">
                <div class="menu_right_block menu_right_block_mobile">
                    <?php if ( function_exists( 'tasheel_header_show_login' ) && tasheel_header_show_login() ) : ?>
                    <?php if ( is_user_logged_in() ) : ?>
                    <a href="<?php echo esc_url( $my_profile_url ); ?>" class="user-profile-link" title="<?php esc_attr_e( 'My Profile', 'tasheel' ); ?>">
                        <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/user-logon.svg' ); ?>" alt="<?php echo esc_attr__( 'My Profile', 'tasheel' ); ?>">
                    </a>
                    <?php else : ?>
                    <a href="#login-popup" class="user-login-trigger" data-fancybox="login-popup">
                        <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/user-logon.svg' ); ?>" alt="<?php echo esc_attr__( 'User Icon', 'tasheel' ); ?>">
                    </a>
                    <?php endif; ?>
                    <?php endif; ?>
                    <?php
                    if ( has_action( 'wpml_add_language_selector' ) ) {
                        echo '<div class="language_switcher_wrap language_button button_link">';
                        do_action( 'wpml_add_language_selector' );
                        echo '</div>';
                    }
                    ?>
                    <?php if ( $header_btn ) : ?>
                    <a class="btn_style btn_transparent <?php echo $is_black_header ? 'btn_green' : ''; ?>" href="<?php echo esc_url( $header_btn['url'] ); ?>">
                        <?php echo esc_html( $header_btn['text'] ); ?>
                    </a>
                    <?php endif; ?>
                </div>

                <div class="menu_toggle">
                    <button id="menuIcon" class="menu_icon" aria-label="Toggle navigation">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                </div>
            </div>

            <div id="mobileMenuOverlay" class="mobile_menu_overlay">
				<div class="mobile_menu_overlay_inner">
                <?php
                $mobile_menu_args = array(
                    'container'   => false,
                    'items_wrap'  => '<ul class="mobile_menu_list">%3$s</ul>',
                    'fallback_cb' => false,
                    'walker'      => new Tasheel_Header_Mobile_Menu_Walker(),
                    'depth'       => 2,
                );
                if ( $header_menu_id ) {
                    $mobile_menu_args['menu'] = $header_menu_id;
                } else {
                    $mobile_menu_args['theme_location'] = has_nav_menu( 'header-menu' ) ? 'header-menu' : 'menu-1';
                }
                $has_mobile_menu = false;
                if ( $header_menu_id || has_nav_menu( 'menu-1' ) || has_nav_menu( 'header-menu' ) ) {
                    ob_start();
                    wp_nav_menu( $mobile_menu_args );
                    $mobile_output = ob_get_clean();
                    $has_mobile_menu = ! empty( trim( $mobile_output ) );
                    if ( $has_mobile_menu ) {
                        echo $mobile_output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                    }
                }
                if ( ! $has_mobile_menu ) {
                    get_template_part( 'template-parts/header', 'fallback-mobile-menu' );
                }
                ?>
			</div>
            </div>

            </div>

    </div>
</header>



<?php
// Training popup job ID: set when on My Profile with apply_to (training) or when on a single Corporate Training job.
if ( ! isset( $GLOBALS['tasheel_training_popup_job_id'] ) && is_singular( 'hr_job' ) && function_exists( 'tasheel_hr_get_job_type_slug' ) && function_exists( 'tasheel_hr_normalize_job_type_slug' ) ) {
	$current_job_id = get_the_ID();
	$raw_slug = $current_job_id ? tasheel_hr_get_job_type_slug( $current_job_id ) : '';
	if ( $current_job_id && tasheel_hr_normalize_job_type_slug( $raw_slug ) === 'corporate_training' ) {
		$GLOBALS['tasheel_training_popup_job_id'] = $current_job_id;
	}
}
$tasheel_training_popup_job_id = isset( $GLOBALS['tasheel_training_popup_job_id'] ) ? (int) $GLOBALS['tasheel_training_popup_job_id'] : 0;
?>
<!-- Login Popup (Corporate Training: shows "Apply as a Guest") -->
<div id="login-popup-training" class="job-form-popup" style="display: none;">
	<span class="form-close-icon">
		<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/pop-close.svg' ); ?>" alt="<?php echo esc_attr__( 'Close', 'tasheel' ); ?>">
	</span>
	<h3 class="h3_title_50 pb_5 text_center mb_20"><?php esc_html_e( 'Sign In', 'tasheel' ); ?></h3>

	<div class="related_jobs_section_content">
		<h5><?php esc_html_e( 'Have an account?', 'tasheel' ); ?></h5>
		<p><?php esc_html_e( 'Enter your email address and password', 'tasheel' ); ?></p>
	</div>

	<ul class="career-form-list-ul">
		<li><input autocomplete="off" class="input" type="email" placeholder="<?php esc_attr_e( 'Email address', 'tasheel' ); ?>" required></li>
		<li>
			<input class="input" type="password" placeholder="<?php esc_attr_e( 'Password', 'tasheel' ); ?>" required>
			<span class="form-icon">
				<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/eye-icn.svg' ); ?>" alt="<?php esc_attr__( 'Toggle password', 'tasheel' ); ?>">
			</span>
		</li>
		<li class="login-options">
			<label class="keep-logged-in">
				<input type="checkbox" checked>
				<span><?php esc_html_e( 'Keep me logged in', 'tasheel' ); ?></span>
			</label>
			<a href="#" class="forget-password-link"><?php esc_html_e( 'Forget password?', 'tasheel' ); ?></a>
		</li>
		<li><a href="<?php echo esc_url( home_url( '/my-profile-training' ) ); ?>" class="input-buttion btn_style btn_transparent but_black" type="submit"><?php esc_html_e( 'Sign In', 'tasheel' ); ?></a></li>
	</ul>

	<div class="form-bottom-txt">
		<h5><?php esc_html_e( 'Not a registered user yet?', 'tasheel' ); ?></h5>
		<p><a href="#job-form-popup" class="text_black" data-fancybox="job-form"><?php esc_html_e( 'Create an account', 'tasheel' ); ?></a> <?php esc_html_e( 'to apply for our career opportunities.', 'tasheel' ); ?></p>
		<span class="or_span"><?php esc_html_e( 'or', 'tasheel' ); ?></span><br>
		<p><a href="<?php echo $tasheel_training_popup_job_id ? esc_url( home_url( '/apply-as-a-guest/?apply_to=' . $tasheel_training_popup_job_id ) ) : esc_url( home_url( '/apply-as-a-guest/' ) ); ?>" class="text_black"><?php esc_html_e( 'Apply as a Guest', 'tasheel' ); ?></a></p>
	</div>
</div>





<?php
$tasheel_training_popup_form_action = '';
$tasheel_training_popup_nonce = '';
if ( $tasheel_training_popup_job_id ) {
	$tasheel_training_popup_form_action = function_exists( 'tasheel_hr_my_profile_url' ) ? tasheel_hr_my_profile_url( $tasheel_training_popup_job_id ) : add_query_arg( 'apply_to', $tasheel_training_popup_job_id, home_url( '/my-profile/' ) );
	$tasheel_training_popup_nonce = wp_create_nonce( 'tasheel_hr_apply_' . $tasheel_training_popup_job_id );
}
?>
<div id="login-popup-training-submit" class="job-form-popup" style="display: none;">
	<span class="form-close-icon">
		<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/pop-close.svg' ); ?>" alt="Close">
	</span>
	<h3 class="h3_title_35 pb_10 text_center mb_20">Training Program Enrollment</h3>

	<?php if ( $tasheel_training_popup_job_id ) : ?>
	<form method="post" action="<?php echo esc_url( $tasheel_training_popup_form_action ); ?>">
		<input type="hidden" name="tasheel_hr_submit_application" value="1" />
		<input type="hidden" name="_wpnonce" value="<?php echo esc_attr( $tasheel_training_popup_nonce ); ?>" />
		<input type="hidden" name="apply_to" value="<?php echo esc_attr( $tasheel_training_popup_job_id ); ?>" />
		<input type="hidden" name="job_id" value="<?php echo esc_attr( $tasheel_training_popup_job_id ); ?>" />
		<input type="hidden" name="job_title" value="<?php echo esc_attr( get_the_title( $tasheel_training_popup_job_id ) ); ?>" />
		<ul class="career-form-list-ul">
			<li>
				<div class="select-wrapper">
					<select class="input select-input" name="start_date" required>
						<option value="">Start Date *</option>
						<option value="2026-01">January 2026</option>
						<option value="2026-02">February 2026</option>
						<option value="2026-03">March 2026</option>
						<option value="2026-04">April 2026</option>
					</select>
					<span class="select-arrow"></span>
				</div>
			</li>
			<li>
				<div class="select-wrapper">
					<select class="input select-input" name="duration" required>
						<option value="">Duration Time *</option>
						<option value="1-month">1 Month</option>
						<option value="3-months">3 Months</option>
						<option value="6-months">6 Months</option>
						<option value="12-months">12 Months</option>
					</select>
					<span class="select-arrow"></span>
				</div>
			</li>
			<li><button type="submit" class="input-buttion btn_style btn_transparent but_black">Submit</button></li>
		</ul>
	</form>
	<?php else : ?>
	<p class="training-popup-no-job-msg" style="padding: 1em 0; color: #666;"><?php esc_html_e( 'To submit a training application, please visit a Training Program on the Careers page and click Apply there. You will then review your profile and submit with Start Date and Duration.', 'tasheel' ); ?></p>
	<?php endif; ?>
</div>





<?php
$tasheel_popup_redirects = function_exists( 'tasheel_hr_popup_redirect_urls' ) ? tasheel_hr_popup_redirect_urls() : array( 'login' => home_url( '/my-profile/' ), 'register' => home_url( '/create-profile/' ) );
$tasheel_user_logged_in = is_user_logged_in();
?>
<!-- Login Popup (Sign In / Sign Up). "Apply as a Guest" shown only for Corporate Training jobs. -->
<div id="login-popup" class="job-form-popup" style="display: none;" data-ajax-url="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>" data-sending-text="<?php echo esc_attr__( 'Sending…', 'tasheel' ); ?>" data-error-generic="<?php echo esc_attr__( 'The email could not be sent. Please try again.', 'tasheel' ); ?>" data-logged-in="<?php echo $tasheel_user_logged_in ? '1' : '0'; ?>" data-login-redirect="<?php echo esc_url( $tasheel_popup_redirects['login'] ); ?>">
	<span class="form-close-icon">
		<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/pop-close.svg' ); ?>" alt="<?php echo esc_attr__( 'Close', 'tasheel' ); ?>">
	</span>
	
	<!-- Sign In Content -->
	<div class="popup-content-signin" data-popup-view="signin">
		<h3 class="h3_title_50 pb_5 text_center mb_20"><?php esc_html_e( 'Sign In', 'tasheel' ); ?></h3>

		<div class="related_jobs_section_content">
			<h5><?php esc_html_e( 'Have an account?', 'tasheel' ); ?></h5>
			<p><?php esc_html_e( 'Enter your email address and password', 'tasheel' ); ?></p>
		</div>

		<form method="post" action="" class="apply-login-form" novalidate>
			<?php wp_nonce_field( 'tasheel_popup_login', 'tasheel_popup_login_nonce' ); ?>
			<input type="hidden" name="redirect_to" value="<?php echo esc_url( $tasheel_popup_redirects['login'] ); ?>" />
			<ul class="career-form-list-ul">
				<li>
					<input class="input" type="email" name="log" placeholder="<?php esc_attr_e( 'Email address', 'tasheel' ); ?>" required autocomplete="email">
					<span class="field-error" data-field="log" aria-live="polite"></span>
				</li>
				<li>
					<input class="input" type="password" name="pwd" placeholder="<?php esc_attr_e( 'Password', 'tasheel' ); ?>" required>
					<span class="form-icon">
						<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/eye-icn.svg' ); ?>" alt="<?php echo esc_attr__( 'Toggle password visibility', 'tasheel' ); ?>">
					</span>
					<span class="field-error" data-field="pwd" aria-live="polite"></span>
				</li>
				<li class="login-form-message" style="display: none;" aria-live="polite"></li>
				<li class="login-options">
					<label class="keep-logged-in">
						<input type="checkbox" name="rememberme" value="forever" checked>
						<span><?php esc_html_e( 'Keep me logged in', 'tasheel' ); ?></span>
					</label>
					<a href="#" class="forget-password-link swap-to-forgot" data-swap-view="forgot"><?php esc_html_e( 'Forgot password?', 'tasheel' ); ?></a>
				</li>
				<li><button type="submit" class="input-buttion btn_style btn_transparent but_black"><?php esc_html_e( 'Sign In', 'tasheel' ); ?></button></li>
			</ul>
		</form>

		<div class="form-bottom-txt">
			<h5><?php esc_html_e( 'Not a registered user yet?', 'tasheel' ); ?></h5>
			<p><a href="#" class="text_black swap-to-signup" data-swap-view="signup"><?php esc_html_e( 'Create an account', 'tasheel' ); ?></a> <?php esc_html_e( 'to apply for our career opportunities.', 'tasheel' ); ?></p>
			<?php if ( $tasheel_training_popup_job_id && ! is_user_logged_in() ) : ?>
			<span class="or_span"><?php esc_html_e( 'or', 'tasheel' ); ?></span>
			<p><a href="<?php echo esc_url( home_url( '/apply-as-a-guest/?apply_to=' . $tasheel_training_popup_job_id ) ); ?>" class="text_black apply-as-guest-link" id="apply-as-guest-link"><?php esc_html_e( 'Apply as a Guest', 'tasheel' ); ?></a></p>
			<?php endif; ?>
		</div>
	</div>

	<!-- Forgot Password Content -->
	<div class="popup-content-forgot" data-popup-view="forgot" style="display: none;">
		<h3 class="h3_title_50 pb_5 text_center mb_20"><?php esc_html_e( 'Reset password', 'tasheel' ); ?></h3>

		<div class="related_jobs_section_content">
			<h5><?php esc_html_e( 'Forgot your password?', 'tasheel' ); ?></h5>
			<p><?php esc_html_e( 'Enter your email address and we\'ll send you a link to reset your password.', 'tasheel' ); ?></p>
		</div>

		<form class="apply-forgot-form" method="post" action="" novalidate>
			<?php wp_nonce_field( 'tasheel_forgot_password', 'tasheel_forgot_password_nonce' ); ?>
			<ul class="career-form-list-ul">
				<li>
					<input class="input" type="email" name="user_login" placeholder="<?php esc_attr_e( 'Email address', 'tasheel' ); ?>" required autocomplete="email">
					<span class="field-error" data-field="user_login" aria-live="polite"></span>
				</li>
				<li class="forgot-form-message" style="display: none;" aria-live="polite"></li>
				<li><button type="submit" class="input-buttion btn_style btn_transparent but_black"><?php esc_html_e( 'Send reset link', 'tasheel' ); ?></button></li>
			</ul>
		</form>

		<div class="form-bottom-txt">
			<p><a href="#" class="text_black swap-to-signin" data-swap-view="signin"><?php esc_html_e( 'Back to Sign In', 'tasheel' ); ?></a></p>
		</div>
	</div>

	<!-- Sign Up Content -->
	<div class="popup-content-signup" data-popup-view="signup" style="display: none;">
		<h3 class="h3_title_50 pb_5 text_center mb_20"><?php esc_html_e( 'Sign Up', 'tasheel' ); ?></h3>

		<div class="related_jobs_section_content">
			<h5><?php esc_html_e( 'Create an account', 'tasheel' ); ?></h5>
			<p><?php esc_html_e( 'Create your account in a seconds', 'tasheel' ); ?></p>
		</div>

		<?php
		// POST to home URL so no plugin can redirect create-profile/ to wp-login before our handler runs.
		$register_action = home_url( '/' );
		?>
		<form method="post" action="<?php echo esc_url( $register_action ); ?>" class="apply-register-form" id="signup-form" novalidate>
			<?php wp_nonce_field( 'tasheel_register', 'tasheel_register_nonce' ); ?>
			<input type="hidden" name="tasheel_register" value="1" />
			<input type="hidden" name="redirect_to" value="<?php echo esc_url( $tasheel_popup_redirects['register'] ); ?>" />
			<ul class="career-form-list-ul">
				<li>
					<input class="input" type="email" name="user_email" id="signup-user_email" placeholder="<?php esc_attr_e( 'Email Address *', 'tasheel' ); ?>" required autocomplete="email">
					<span class="field-error" data-field="user_email" aria-live="polite"></span>
				</li>
				<li>
					<input class="input" type="email" name="user_email_confirm" id="signup-user_email_confirm" placeholder="<?php esc_attr_e( 'Retype Email Address *', 'tasheel' ); ?>" required autocomplete="email">
					<span class="field-error" data-field="user_email_confirm" aria-live="polite"></span>
				</li>
				<li>
					<input class="input" type="text" name="first_name" placeholder="<?php esc_attr_e( 'First Name *', 'tasheel' ); ?>" required autocomplete="given-name">
					<span class="field-error" data-field="first_name" aria-live="polite"></span>
				</li>
				<li>
					<input class="input" type="text" name="last_name" placeholder="<?php esc_attr_e( 'Last Name *', 'tasheel' ); ?>" required autocomplete="family-name">
					<span class="field-error" data-field="last_name" aria-live="polite"></span>
				</li>
				<li>
					<input class="input" type="password" name="user_pass" id="signup-user_pass" placeholder="<?php esc_attr_e( 'Choose Password *', 'tasheel' ); ?>" required autocomplete="new-password" minlength="6">
					<span class="form-icon">
						<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/eye-icn.svg' ); ?>" alt="Eye">
					</span>
					<span class="field-error" data-field="user_pass" aria-live="polite"></span>
				</li>
				<li>
					<input class="input" type="password" name="user_pass_confirm" id="signup-user_pass_confirm" placeholder="<?php esc_attr_e( 'Retype Password *', 'tasheel' ); ?>" required autocomplete="new-password" minlength="6">
					<span class="form-icon">
						<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/eye-icn.svg' ); ?>" alt="Eye">
					</span>
					<span class="field-error" data-field="user_pass_confirm" aria-live="polite"></span>
				</li>
				<li class="signup-form-message" style="display: none;" aria-live="polite"></li>
				<li><button type="submit" class="input-buttion btn_style btn_transparent but_black"><?php esc_html_e( 'Create Account', 'tasheel' ); ?></button></li>
			</ul>
		</form>

		<div class="form-bottom-txt">
			<p><?php esc_html_e( 'Already a registered user?', 'tasheel' ); ?> <a href="#" class="text_black swap-to-signin" data-swap-view="signin"><?php esc_html_e( 'Please sign in', 'tasheel' ); ?></a></p>
		</div>
	</div>
</div>

<style>
#login-popup .career-form-list-ul li.forgot-form-message,
#login-popup .career-form-list-ul li.login-form-message { font-size: 14px; padding: 10px 0; margin-bottom: 5px; }
#login-popup .career-form-list-ul li.forgot-form-message.forgot-form-message--success,
#login-popup .career-form-list-ul li.login-form-message.login-form-message--success { color: #0d6a37; }
#login-popup .career-form-list-ul li.forgot-form-message.forgot-form-message--error,
#login-popup .career-form-list-ul li.login-form-message.login-form-message--error { color: #c00; }
#login-popup .career-form-list-ul li.signup-form-message { font-size: 14px; padding: 10px 0; margin-bottom: 5px; }
#login-popup .career-form-list-ul li.signup-form-message.signup-form-message--error { color: #c00; }
#login-popup .career-form-list-ul li .field-error { display: block; font-size: 12px; color: #c00; margin-top: 4px; min-height: 1.2em; }
#login-popup .career-form-list-ul li .field-error:empty,
[id^="login-popup"] .career-form-list-ul li .field-error:empty { display: none; margin: 0; min-height: 0; }
#login-popup .career-form-list-ul li .field-hint { display: block; font-size: 12px; color: #666; margin-top: 4px; }
.fancybox__container:has(.job-form-popup) .fancybox__toolbar,
.fancybox__container:has(.job-form-popup) .fancybox__button--close,
.fancybox__container:has(.job-form-popup) .f-button.is-close-btn,
.fancybox__container:has(.job-form-popup) button[data-fancybox-close] { display: none !important; visibility: hidden !important; pointer-events: none !important; }
</style>

<!-- Logout Confirm Popup (styled like Sign In modal) -->
<?php if ( is_user_logged_in() ) : ?>
<div id="logout-confirm-popup" class="job-form-popup" style="display: none;">
	<span class="form-close-icon js-logout-confirm-close">
		<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/pop-close.svg' ); ?>" alt="<?php echo esc_attr__( 'Close', 'tasheel' ); ?>">
	</span>
	<h3 class="h3_title_50 pb_5 text_center mb_20"><?php esc_html_e( 'Log out', 'tasheel' ); ?></h3>
	<p class="text_center mb_20" style="margin-bottom: 1.5em;"><?php esc_html_e( 'Are you sure you want to log out?', 'tasheel' ); ?></p>
	<div class="logout-confirm-actions" style="display: flex; gap: 1em; justify-content: center; flex-wrap: wrap;">
		<button type="button" class="btn_style btn_transparent but_black js-logout-cancel"><?php esc_html_e( 'Cancel', 'tasheel' ); ?></button>
		<button type="button" class="btn_style but_black js-logout-confirm-submit"><?php esc_html_e( 'Log out', 'tasheel' ); ?></button>
	</div>
</div>
<?php endif; ?>
</body>