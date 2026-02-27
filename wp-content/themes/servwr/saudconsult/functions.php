<?php
/**
 * tasheel functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package tasheel
 */

if (!defined('_S_VERSION')) {
	// Replace the version number of the theme on each release.
	define('_S_VERSION', '1.0.0');
}


/**
 * Hide WordPress admin bar on the front-end for non-administrators.
 * Logged-in users (e.g. applicants) should not see the toolbar or have quick access to the backend.
 */
add_filter( 'show_admin_bar', function( $show ) {
	if ( current_user_can( 'manage_options' ) ) {
		return $show;
	}
	return false;
} );

/**
 * Block only applicants from accessing wp-admin. Other roles (editor, author, admin, etc.) can access.
 * Not-logged-in users are left to WordPress default (wp-admin redirects to wp-login).
 * AJAX (admin-ajax.php) is allowed so frontend login and forms work.
 */
add_action( 'admin_init', function() {
	if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
		return;
	}
	if ( ! is_user_logged_in() ) {
		return;
	}
	$user = wp_get_current_user();
	$applicant_role = defined( 'TASHEEL_HR_APPLICANT_ROLE' ) ? TASHEEL_HR_APPLICANT_ROLE : 'applicant';
	if ( ! $user->exists() || ! in_array( $applicant_role, (array) $user->roles, true ) ) {
		return;
	}
	wp_safe_redirect( home_url( '/' ) );
	exit;
} );

/**
 * wp-login.php: keep default for not-logged-in users (show WordPress login page).
 * Only redirect when a logged-in applicant visits wp-login — send them to home.
 * Other roles and admins are not redirected. Password reset and logout are allowed.
 */
add_action( 'login_init', function() {
	$action = isset( $_GET['action'] ) ? sanitize_text_field( wp_unslash( $_GET['action'] ) ) : '';
	if ( $action === 'rp' || $action === 'resetpass' || $action === 'logout' ) {
		return;
	}
	if ( ! is_user_logged_in() ) {
		return;
	}
	$user = wp_get_current_user();
	$applicant_role = defined( 'TASHEEL_HR_APPLICANT_ROLE' ) ? TASHEEL_HR_APPLICANT_ROLE : 'applicant';
	if ( ! $user->exists() || ! in_array( $applicant_role, (array) $user->roles, true ) ) {
		return;
	}
	wp_safe_redirect( home_url( '/' ) );
	exit;
} );

/**
 * Use "No Reply" as sender name for outgoing emails (e.g. registration welcome, password reset).
 * Replaces default "WordPress" so users see "No Reply" instead.
 */
add_filter( 'wp_mail_from_name', function( $name ) {
	return 'No Reply';
} );

/**
 * Use noreply@ site domain as from address for outgoing emails (optional; keeps replies from going to wordpress@).
 */
add_filter( 'wp_mail_from', function( $email ) {
	$domain = isset( $_SERVER['HTTP_HOST'] ) ? sanitize_text_field( wp_unslash( $_SERVER['HTTP_HOST'] ) ) : wp_parse_url( home_url(), PHP_URL_HOST );
	if ( $domain && is_email( 'noreply@' . $domain ) ) {
		return 'noreply@' . $domain;
	}
	return $email;
} );

/**
 * Convert Western digits (0-9) to Arabic-Indic numerals (٠-٩) when current language is Arabic.
 * Use for "Posted X ago" and other numeric strings on Arabic pages.
 *
 * @param string $string Text that may contain digits.
 * @return string Same string with digits converted to Arabic numerals when locale is Arabic, else unchanged.
 */
function tasheel_arabic_numerals_new( $string ) {
	if ( ! is_string( $string ) || $string === '' ) {
		return $string;
	}
	$is_arabic = false;
	if ( function_exists( 'apply_filters' ) ) {
		$lang = apply_filters( 'wpml_current_language', null );
		$is_arabic = ( is_string( $lang ) && strpos( $lang, 'ar' ) === 0 );
	}
	if ( ! $is_arabic ) {
		$locale = get_locale();
		$is_arabic = ( is_string( $locale ) && strpos( $locale, 'ar' ) === 0 );
	}
	if ( ! $is_arabic ) {
		return $string;
	}
	$western = array( '0', '1', '2', '3', '4', '5', '6', '7', '8', '9' );
	$arabic  = array( '٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩' );
	return str_replace( $western, $arabic, $string );
}


/**
 * Add User screen: uncheck "Send User Notification" by default and hide the row.
 * Script runs on DOMContentLoaded so the form exists; checkbox stays unchecked so no email is sent when adding a user.
 */
add_action( 'admin_head', function() {
	global $pagenow;
	if ( $pagenow !== 'user-new.php' ) {
		return;
	}
	echo '<style type="text/css">#createuser tr:has(input[name="send_user_notification"]) { display: none !important; }</style>';
} );
add_action( 'admin_footer', function() {
	global $pagenow;
	if ( $pagenow !== 'user-new.php' ) {
		return;
	}
	?>
	<script type="text/javascript">
	document.addEventListener('DOMContentLoaded', function() {
		var el = document.querySelector('input[name="send_user_notification"]');
		if (el) {
			el.checked = false;
			var row = el.closest('tr');
			if (row) row.style.display = 'none';
		}
	});
	</script>
	<?php
}, 5 );

/**
 * Allow Arabic and other Unicode letters in usernames.
 * WordPress by default strips non-ASCII characters via sanitize_user( $user, true ).
 * This filter re-sanitizes the raw username to keep letters from any language plus digits and safe symbols.
 */
add_filter( 'sanitize_user', function( $username, $raw_username, $strict ) {
	$raw = is_string( $raw_username ) ? wp_unslash( $raw_username ) : '';
	$raw = wp_strip_all_tags( $raw );
	// Allow Unicode letters (\p{L}), numbers (\p{N}), space, dot, hyphen, underscore, at.
	$sanitized = preg_replace( '/[^\p{L}\p{N} _.-@]/u', '', $raw );
	$sanitized = trim( $sanitized );
	if ( strlen( $sanitized ) > 60 ) {
		$sanitized = mb_substr( $sanitized, 0, 60, 'UTF-8' );
	}
	if ( $sanitized !== '' ) {
		return $sanitized;
	}
	return $username;
}, 10, 3 );

// require_once get_template_directory() . '/inc/acf-field-groups.php';
require_once get_template_directory() . '/inc/register-post-types.php';

$acf_about_render = get_template_directory() . '/inc/acf-about-render.php';
if ( file_exists( $acf_about_render ) ) {
	require_once $acf_about_render;
}

$acf_home_render = get_template_directory() . '/inc/acf-home-render.php';
if ( file_exists( $acf_home_render ) ) {
	require_once $acf_home_render;
}


$acf_contact_render = get_template_directory() . '/inc/acf-contact-render.php';
if ( file_exists( $acf_contact_render ) ) {
	require_once $acf_contact_render;
}

$acf_media_center_render = get_template_directory() . '/inc/acf-media-center-render.php';
if ( file_exists( $acf_media_center_render ) ) {
	require_once $acf_media_center_render;
}

$acf_vendor_render = get_template_directory() . '/inc/acf-vendor-render.php';
if ( file_exists( $acf_vendor_render ) ) {
	require_once $acf_vendor_render;
}

$acf_careers_render = get_template_directory() . '/inc/acf-careers-render.php';
if ( file_exists( $acf_careers_render ) ) {
	require_once $acf_careers_render;
}

$hr_engine = get_template_directory() . '/inc/hr-engine.php';
if ( file_exists( $hr_engine ) ) {
	require_once $hr_engine;
}

$hr_engine_applications = get_template_directory() . '/inc/hr-engine-applications.php';
if ( file_exists( $hr_engine_applications ) ) {
	require_once $hr_engine_applications;
}

$hr_engine_applicant_role = get_template_directory() . '/inc/hr-engine-applicant-role.php';
if ( file_exists( $hr_engine_applicant_role ) ) {
	require_once $hr_engine_applicant_role;
}

$hr_engine_user_profile = get_template_directory() . '/inc/hr-engine-user-profile.php';
if ( file_exists( $hr_engine_user_profile ) ) {
	require_once $hr_engine_user_profile;
}

$acf_header_footer = get_template_directory() . '/inc/acf-header-footer-render.php';
if ( file_exists( $acf_header_footer ) ) {
	require_once $acf_header_footer;
}





// Fallback if inc/acf-about-render.php is missing (e.g. not deployed).
if ( ! function_exists( 'tasheel_about_section_templates' ) ) {
	function tasheel_about_section_templates() {
		return array(
			'page-template-about.php',
			'page-template-vision-mission-values.php',
			'page-template-leadership.php',
			'page-template-our-team.php',
			'page-template-journey-legacy.php',
			'page-template-company-milestones.php',
			'page-template-awards.php',
		);
	}
}
if ( ! function_exists( 'tasheel_about_subpage_tabs' ) ) {
	function tasheel_about_subpage_tabs() {
		$tabs = array();
		if ( function_exists( 'get_field' ) ) {
			$selected = get_field( 'about_tab_pages', 'option' );
			if ( ! empty( $selected ) && is_array( $selected ) ) {
				foreach ( $selected as $item ) {
					$page = is_object( $item ) ? $item : get_post( $item );
					if ( $page && $page->post_type === 'page' && $page->post_status === 'publish' ) {
						$tabs[] = array(
							'id'      => $page->post_name,
							'page_id' => (int) $page->ID,
							'title'   => get_the_title( $page ),
							'link'    => get_permalink( $page ),
						);
					}
				}
				if ( ! empty( $tabs ) ) {
					return $tabs;
				}
			}
		}
		$templates = tasheel_about_section_templates();
		if ( empty( $templates ) ) {
			return $tabs;
		}
		$query = new WP_Query( array(
			'post_type'      => 'page',
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'orderby'        => 'menu_order',
			'order'          => 'ASC',
			'meta_query'     => array(
				array(
					'key'     => '_wp_page_template',
					'value'   => $templates,
					'compare' => 'IN',
				),
			),
		) );
		if ( $query->have_posts() ) {
			foreach ( $query->posts as $page ) {
				$tabs[] = array(
					'id'      => $page->post_name,
					'page_id' => (int) $page->ID,
					'title'   => get_the_title( $page ),
					'link'    => get_permalink( $page ),
				);
			}
			wp_reset_postdata();
		}
		return $tabs;
	}
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function tasheel_setup()
{
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on tasheel, use a find and replace
	 * to change 'tasheel' to the name of your theme in all the template files.
	 */
	load_theme_textdomain('tasheel', get_template_directory() . '/languages');

	// Add default posts and comments RSS feed links to head.
	add_theme_support('automatic-feed-links');

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support('title-tag');

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support('post-thumbnails');

	// This theme uses wp_nav_menu() in multiple locations.
	register_nav_menus(
		array(
			'menu-1'              => esc_html__( 'Primary', 'tasheel' ),
			'footer-quick-links'  => esc_html__( 'Footer Quick Links', 'tasheel' ),
			'footer-services'     => esc_html__( 'Footer Services', 'tasheel' ),
			'header-menu'         => esc_html__( 'Header Menu', 'tasheel' ),
		)
	);

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'tasheel_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support('customize-selective-refresh-widgets');

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height' => 250,
			'width' => 250,
			'flex-width' => true,
			'flex-height' => true,
		)
	);
}
add_action('after_setup_theme', 'tasheel_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function tasheel_content_width()
{
	$GLOBALS['content_width'] = apply_filters('tasheel_content_width', 640);
}
add_action('after_setup_theme', 'tasheel_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function tasheel_widgets_init()
{
	register_sidebar(
		array(
			'name' => esc_html__('Sidebar', 'tasheel'),
			'id' => 'sidebar-1',
			'description' => esc_html__('Add widgets here.', 'tasheel'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget' => '</section>',
			'before_title' => '<h2 class="widget-title">',
			'after_title' => '</h2>',
		)
	);
}
add_action('widgets_init', 'tasheel_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function tasheel_scripts()
{
	// Enqueue Google Fonts - Poppins
	wp_enqueue_style('google-fonts-poppins', 'https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap', array(), null);

	// Enqueue Swiper (needed for global brands slider and other sliders)
	wp_enqueue_style('swiper-css', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css', array(), '11.0.0');
	wp_enqueue_script('swiper-js', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', array(), '11.0.0', true);

	// Enqueue main CSS (compiled from SCSS with mixins and variables)
	$main_css_path = get_template_directory() . '/assets/scss/main.css';
	if (file_exists($main_css_path)) {
		wp_enqueue_style('tasheel-main', get_template_directory_uri() . '/assets/scss/main.css', array(), _S_VERSION);
	}

 

	// Enqueue common CSS (common component styles)
	$common_css_path = get_template_directory() . '/assets/css/common.css';
	if (file_exists($common_css_path)) {
		wp_enqueue_style('tasheel-common', get_template_directory_uri() . '/assets/css/common.css', array(), _S_VERSION);
	}

	// Enqueue main theme style (includes all component styles via @import)
	wp_enqueue_style('tasheel-style', get_stylesheet_uri(), array(), _S_VERSION);
	wp_style_add_data('tasheel-style', 'rtl', 'replace');

	// Enqueue style-sk CSS (load after main theme style to ensure higher priority)
	$style_sk_css_path = get_template_directory() . '/assets/css/style-sk.css';
	if (file_exists($style_sk_css_path)) {
		wp_enqueue_style('tasheel-style-sk', get_template_directory_uri() . '/assets/css/style-sk.css', array('tasheel-common', 'tasheel-style'), _S_VERSION);
	}

	// Enqueue Header component styles (loaded on all pages)
	$header_css_path = get_template_directory() . '/assets/css/Header.css';
	if (file_exists($header_css_path)) {
		wp_enqueue_style('header-style', get_template_directory_uri() . '/assets/css/Header.css', array(), _S_VERSION);
	}
 
	// Enqueue InnerBanner component styles (loaded on all pages - can be used on any inner page)
	$inner_banner_css_path = get_template_directory() . '/assets/css/InnerBanner.css';
	if (file_exists($inner_banner_css_path)) {
		wp_enqueue_style('inner-banner-style', get_template_directory_uri() . '/assets/css/InnerBanner.css', array(), _S_VERSION);
	}

	// Enqueue PageTabs component styles (loaded on all pages - can be used on any inner page)
	$page_tabs_css_path = get_template_directory() . '/assets/css/PageTabs.css';
	if (file_exists($page_tabs_css_path)) {
		wp_enqueue_style('page-tabs-style', get_template_directory_uri() . '/assets/css/PageTabs.css', array(), _S_VERSION);
	}

	// Enqueue AboutUsContent component styles (loaded on all pages - can be used on any inner page)
	$about_us_content_css_path = get_template_directory() . '/assets/css/AboutUsContent.css';
	if (file_exists($about_us_content_css_path)) {
		wp_enqueue_style('about-us-content-style', get_template_directory_uri() . '/assets/css/AboutUsContent.css', array(), _S_VERSION);
	}

	// Enqueue WhatWeStandFor component styles (loaded on all pages - can be used on any inner page)
	$what_we_stand_css_path = get_template_directory() . '/assets/css/WhatWeStandFor.css';
	if (file_exists($what_we_stand_css_path)) {
		wp_enqueue_style('what-we-stand-style', get_template_directory_uri() . '/assets/css/WhatWeStandFor.css', array(), _S_VERSION);
	}

	// Enqueue VisionMission component styles (loaded on all pages - can be used on any inner page)
	$vision_mission_css_path = get_template_directory() . '/assets/css/VisionMission.css';
	if (file_exists($vision_mission_css_path)) {
		wp_enqueue_style('vision-mission-style', get_template_directory_uri() . '/assets/css/VisionMission.css', array(), _S_VERSION);
	}

	// Enqueue CompanyCard component styles (loaded on all pages - can be used on any inner page)
	$company_card_css_path = get_template_directory() . '/assets/css/CompanyCard.css';
	if (file_exists($company_card_css_path)) {
		wp_enqueue_style('company-card-style', get_template_directory_uri() . '/assets/css/CompanyCard.css', array(), _S_VERSION);
	}

	// Enqueue SubsidiariesCardsGrid component styles (loaded on all pages - can be used on any inner page)
	$subsidiaries_cards_grid_css_path = get_template_directory() . '/assets/css/SubsidiariesCardsGrid.css';
	if (file_exists($subsidiaries_cards_grid_css_path)) {
		wp_enqueue_style('subsidiaries-cards-grid-style', get_template_directory_uri() . '/assets/css/SubsidiariesCardsGrid.css', array('company-card-style'), _S_VERSION);
	}

	// Enqueue CompanyDetail component styles (loaded on all pages - can be used on any inner page)
	$company_detail_css_path = get_template_directory() . '/assets/css/CompanyDetail.css';
	if (file_exists($company_detail_css_path)) {
		wp_enqueue_style('company-detail-style', get_template_directory_uri() . '/assets/css/CompanyDetail.css', array(), _S_VERSION);
	}

	// Enqueue Breadcrumb component styles (loaded on all pages - can be used on any inner page)
	$breadcrumb_css_path = get_template_directory() . '/assets/css/Breadcrumb.css';
	if (file_exists($breadcrumb_css_path)) {
		wp_enqueue_style('breadcrumb-style', get_template_directory_uri() . '/assets/css/Breadcrumb.css', array(), _S_VERSION);
	}

	// Enqueue main theme style
	wp_enqueue_style('tasheel-style', get_stylesheet_uri(), array(), _S_VERSION);
	wp_style_add_data('tasheel-style', 'rtl', 'replace');

	// Enqueue main JS (initializes global slider, etc.)
	$main_js_path = get_template_directory() . '/assets/js/main.js';
	if (file_exists($main_js_path)) {
		// Set dependencies based on page type
		$main_js_deps = array('swiper-js');
		if (is_front_page()) {
			// On front page, ensure GSAP and ScrollTrigger load first
			$main_js_deps[] = 'gsap-scrolltrigger';
		}
		wp_enqueue_script('tasheel-main', get_template_directory_uri() . '/assets/js/main.js', $main_js_deps, _S_VERSION, true);
		wp_localize_script( 'tasheel-main', 'tasheelLoginPopup', array(
			'ajaxUrl'    => admin_url( 'admin-ajax.php' ),
			'sendingText' => __( 'Sending…', 'tasheel' ),
		) );
		wp_localize_script( 'tasheel-main', 'tasheelI18n', array(
			'loadMore' => __( 'Load More', 'tasheel' ),
			'loading'  => __( 'Loading...', 'tasheel' ),
		) );
	}

	// Login / Sign Up popup (in header) – JS in external file for caching; CSS stays inline in header.php
	$login_popup_js = get_template_directory() . '/assets/js/login-popup.js';
	if ( file_exists( $login_popup_js ) ) {
		wp_enqueue_script( 'tasheel-login-popup', get_template_directory_uri() . '/assets/js/login-popup.js', array(), _S_VERSION, true );
		wp_localize_script( 'tasheel-login-popup', 'tasheelLoginPopupI18n', array(
			'sending'                    => __( 'Sending…', 'tasheel' ),
			'errorGeneric'               => __( 'Something went wrong. Please try again.', 'tasheel' ),
			'errorForgot'                => __( 'The email could not be sent. Please try again.', 'tasheel' ),
			'errEmailRequired'           => __( 'Please enter your email address.', 'tasheel' ),
			'errEmailInvalid'            => __( 'Please enter a valid email address.', 'tasheel' ),
			'errEmailRetype'             => __( 'Please retype your email address.', 'tasheel' ),
			'errEmailMismatch'           => __( 'Email addresses do not match.', 'tasheel' ),
			'errFirstNameRequired'       => __( 'Please enter your first name.', 'tasheel' ),
			'errLastNameRequired'        => __( 'Please enter your last name.', 'tasheel' ),
			'errPasswordRequired'        => __( 'Please choose a password.', 'tasheel' ),
			'errPasswordMinLength'        => __( 'Password must be at least 6 characters.', 'tasheel' ),
			'errPasswordStrong'           => __( 'Password must include at least one uppercase letter, one lowercase letter, one digit, and one special character.', 'tasheel' ),
			'errPasswordRetype'           => __( 'Please retype your password.', 'tasheel' ),
			'errPasswordsMismatch'       => __( 'Passwords do not match.', 'tasheel' ),
		) );
	}

	// News / Events listing: AJAX load more – enqueue before main so its capture-phase listener runs first
	if ( is_page_template( 'page-template-news.php' ) || is_page_template( 'page-template-events.php' ) ) {
		$listing_load_more_js = get_template_directory() . '/assets/js/ListingLoadMore.js';
		if ( file_exists( $listing_load_more_js ) ) {
			wp_enqueue_script( 'tasheel-listing-load-more', get_template_directory_uri() . '/assets/js/ListingLoadMore.js', array( 'jquery' ), _S_VERSION, true );
			wp_localize_script( 'tasheel-listing-load-more', 'tasheelListingLoadMore', array(
				'ajaxUrl'      => admin_url( 'admin-ajax.php' ),
				'newsNonce'    => wp_create_nonce( 'tasheel_load_more_news' ),
				'eventsNonce'  => wp_create_nonce( 'tasheel_load_more_events' ),
				'newsAction'   => 'tasheel_load_more_news',
				'eventsAction' => 'tasheel_load_more_events',
				'loadingText'  => __( 'Loading...', 'tasheel' ),
				'loadMoreText' => __( 'Load More', 'tasheel' ),
			) );
		}
	}


	// Enqueue Header component script (loaded on all pages)
	$header_js_path = get_template_directory() . '/assets/js/Header.js';
	if (file_exists($header_js_path)) {
		wp_enqueue_script('header-script', get_template_directory_uri() . '/assets/js/Header.js', array('jquery'), _S_VERSION, true);
	}

	// Enqueue Footer component script (loaded on all pages)
	$footer_js_path = get_template_directory() . '/assets/js/Footer.js';
	if (file_exists($footer_js_path)) {
		wp_enqueue_script('footer-script', get_template_directory_uri() . '/assets/js/Footer.js', array(), _S_VERSION, true);
	}

	// Enqueue ButtonPrimary component styles and scripts (loaded on all pages - used in header)
	$button_primary_css_path = get_template_directory() . '/assets/css/ButtonPrimary.css';
	if (file_exists($button_primary_css_path)) {
		wp_enqueue_style('button-primary-style', get_template_directory_uri() . '/assets/css/ButtonPrimary.css', array(), _S_VERSION);
	}
	$button_primary_js_path = get_template_directory() . '/assets/js/ButtonPrimary.js';
	if (file_exists($button_primary_js_path)) {
		wp_enqueue_script('button-primary-script', get_template_directory_uri() . '/assets/js/ButtonPrimary.js', array(), _S_VERSION, true);
	}

	// Enqueue PageTabs component script (loaded on all pages - can be used on any inner page)
	$page_tabs_js_path = get_template_directory() . '/assets/js/PageTabs.js';
	if (file_exists($page_tabs_js_path)) {
		wp_enqueue_script('page-tabs-script', get_template_directory_uri() . '/assets/js/PageTabs.js', array(), _S_VERSION, true);
	}

	// Enqueue ProjectFilter script (Projects page – AJAX filter)
	$project_filter_js_path = get_template_directory() . '/assets/js/ProjectFilter.js';
	if (file_exists($project_filter_js_path)) {
		wp_enqueue_script('project-filter-script', get_template_directory_uri() . '/assets/js/ProjectFilter.js', array(), _S_VERSION, true);
		wp_localize_script('project-filter-script', 'tasheelProjectFilter', array(
			'ajaxUrl'      => admin_url('admin-ajax.php'),
			'action'       => 'tasheel_filter_projects',
			'loadingText'  => __( 'Loading…', 'tasheel' ),
			'loadMoreText' => __( 'Load More', 'tasheel' ),
		));
	}

	// Enqueue ClientsFilter script (Clients page – AJAX filter & load more)
	if ( is_page_template( 'page-template-clients.php' ) ) {
		$clients_filter_js_path = get_template_directory() . '/assets/js/ClientsFilter.js';
		if ( file_exists( $clients_filter_js_path ) ) {
			wp_enqueue_script( 'clients-filter-script', get_template_directory_uri() . '/assets/js/ClientsFilter.js', array(), _S_VERSION, true );
			wp_localize_script( 'clients-filter-script', 'tasheelClientsFilter', array(
				'ajaxUrl'      => admin_url( 'admin-ajax.php' ),
				'action'       => 'tasheel_filter_clients',
				'loadingText'  => __( 'Loading…', 'tasheel' ),
				'loadMoreText' => __( 'Load more', 'tasheel' ),
			) );
		}
	}

	// Career form date constraints (create-profile, apply-as-guest only)
	if ( is_page_template( 'page-template-create-profile.php' ) || is_page_template( 'page-template-apply-as-guest.php' ) ) {
		$career_dates_js = get_template_directory() . '/assets/js/career-form-date-constraints.js';
		if ( file_exists( $career_dates_js ) ) {
			wp_enqueue_script( 'tasheel-career-form-dates', get_template_directory_uri() . '/assets/js/career-form-date-constraints.js', array(), _S_VERSION, true );
		}
	}

	// Enqueue AOS (Animate On Scroll) library (CDN) - loaded on all pages
	wp_enqueue_style('aos-css', 'https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css', array(), '2.3.4');
	wp_enqueue_script('aos-js', 'https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js', array(), '2.3.4', true);

	// Initialize AOS after DOM is ready (global initialization for all pages)
	wp_add_inline_script('aos-js', 'document.addEventListener("DOMContentLoaded", function() { if (typeof AOS !== "undefined") { AOS.init({ duration: 800, once: false }); setTimeout(function() { AOS.refresh(); }, 500); } });', 'after');

	// Check if current page uses Company Detail, Investments Detail, or TasHeel Modern Support Services template
	$is_company_detail_page = false;
	$is_tasheel_modern_support_page = false;
	$is_group_companies_page = false;
	$is_our_journey_page = false;
	if (is_page()) {
		$template = get_page_template_slug();
		$is_company_detail_page = ($template === 'page-company-detail.php' || $template === 'page-investments-detail.php' || $template === 'page-tasheel-modern-support-services.php');
		$is_tasheel_modern_support_page = ($template === 'page-tasheel-modern-support-services.php');
		$is_group_companies_page = ($template === 'page-group-companies.php');
		$is_our_journey_page = ($template === 'page-template-journey-legacy.php');
	}

	// Enqueue GSAP and ScrollTrigger for Our Journey page
	if ($is_our_journey_page) {
		// Enqueue GSAP library (local file)
		$gsap_js_path = get_template_directory() . '/assets/js/gsap-latest-beta.min.js';
		if (file_exists($gsap_js_path)) {
			wp_enqueue_script('gsap', get_template_directory_uri() . '/assets/js/gsap-latest-beta.min.js', array(), _S_VERSION, false);
		}

		// Enqueue GSAP ScrollTrigger plugin (local file)
		$scrolltrigger_js_path = get_template_directory() . '/assets/js/ScrollTrigger.min.js';
		if (file_exists($scrolltrigger_js_path)) {
			wp_enqueue_script('gsap-scrolltrigger', get_template_directory_uri() . '/assets/js/ScrollTrigger.min.js', array('gsap'), _S_VERSION, false);
		}

		// Enqueue Our Journey script
		$our_journey_js_path = get_template_directory() . '/assets/js/OurJourney.js';
		if (file_exists($our_journey_js_path)) {
			wp_enqueue_script('our-journey-script', get_template_directory_uri() . '/assets/js/OurJourney.js', array('gsap-scrolltrigger', 'swiper-js'), _S_VERSION, true);
		}
	}

	// Enqueue component styles
	if (is_front_page()) {
		// Enqueue GSAP library (local file)
		$gsap_js_path = get_template_directory() . '/assets/js/gsap-latest-beta.min.js';
		if (file_exists($gsap_js_path)) {
			wp_enqueue_script('gsap', get_template_directory_uri() . '/assets/js/gsap-latest-beta.min.js', array(), _S_VERSION, false);
		}

		// Enqueue GSAP ScrollTrigger plugin (local file)
		$scrolltrigger_js_path = get_template_directory() . '/assets/js/ScrollTrigger.min.js';
		if (file_exists($scrolltrigger_js_path)) {
			wp_enqueue_script('gsap-scrolltrigger', get_template_directory_uri() . '/assets/js/ScrollTrigger.min.js', array('gsap'), _S_VERSION, false);
		}

		// Enqueue Stack Section script
		$stack_section_js_path = get_template_directory() . '/assets/js/StackSection.js';
		if (file_exists($stack_section_js_path)) {
			wp_enqueue_script('stack-section-script', get_template_directory_uri() . '/assets/js/StackSection.js', array('gsap-scrolltrigger'), _S_VERSION, true);
		}

		// Enqueue Swiper CSS and JS (CDN)
		wp_enqueue_style('swiper-css', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css', array(), '11.0.0');
		wp_enqueue_script('swiper-js', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', array(), '11.0.0', true);

	 
		$who_we_are_css_path = get_template_directory() . '/assets/css/WhoWeAre.css';
		if (file_exists($who_we_are_css_path)) {
			wp_enqueue_style('who-we-are-style', get_template_directory_uri() . '/assets/css/WhoWeAre.css', array(), _S_VERSION);
		}
		$text_anim_css_path = get_template_directory() . '/assets/css/TextAnim.css';
		if (file_exists($text_anim_css_path)) {
			wp_enqueue_style('text-anim-style', get_template_directory_uri() . '/assets/css/TextAnim.css', array(), _S_VERSION);
		}
		$our_story_css_path = get_template_directory() . '/assets/css/OurStory.css';
		if (file_exists($our_story_css_path)) {
			wp_enqueue_style('our-story-style', get_template_directory_uri() . '/assets/css/OurStory.css', array(), _S_VERSION);
		}
		$subsidiaries_css_path = get_template_directory() . '/assets/css/Subsidiaries.css';
		if (file_exists($subsidiaries_css_path)) {
			wp_enqueue_style('subsidiaries-style', get_template_directory_uri() . '/assets/css/Subsidiaries.css', array(), _S_VERSION);
		}
		$news_slider_css_path = get_template_directory() . '/assets/css/NewsSlider.css';
		if (file_exists($news_slider_css_path)) {
			wp_enqueue_style('news-slider-style', get_template_directory_uri() . '/assets/css/NewsSlider.css', array(), _S_VERSION);
		}
		$contact_banner_css_path = get_template_directory() . '/assets/css/ContactBanner.css';
		if (file_exists($contact_banner_css_path)) {
			wp_enqueue_style('contact-banner-style', get_template_directory_uri() . '/assets/css/ContactBanner.css', array(), _S_VERSION);
		}
		$statistics_css_path = get_template_directory() . '/assets/css/Statistics.css';
		if (file_exists($statistics_css_path)) {
			wp_enqueue_style('statistics-style', get_template_directory_uri() . '/assets/css/Statistics.css', array(), _S_VERSION);
		}


 
	}

	// Load AOS for pages that use components with AOS animations (About, Leadership, etc.)
	if (is_page_template(array('page-about.php', 'page-about-us.php', 'page-leadership.php', 'page-culture-people.php', 'page-career.php'))) {
		// Enqueue AOS (Animate On Scroll) library (CDN) if not already loaded
		if (!wp_style_is('aos-css', 'enqueued')) {
			wp_enqueue_style('aos-css', 'https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css', array(), '2.3.4');
		}
		if (!wp_script_is('aos-js', 'enqueued')) {
			wp_enqueue_script('aos-js', 'https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js', array(), '2.3.4', true);
			// Initialize AOS after DOM is ready
			wp_add_inline_script('aos-js', 'document.addEventListener("DOMContentLoaded", function() { if (typeof AOS !== "undefined") { AOS.init({ duration: 800, once: true }); } });', 'after');
		}

		// Enqueue History Milestones script (for About Us page)
		if (is_page_template('page-about-us.php')) {
			// Ensure Swiper is loaded
			if (!wp_script_is('swiper-js', 'enqueued')) {
				wp_enqueue_style('swiper-css', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css', array(), '11.0.0');
				wp_enqueue_script('swiper-js', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', array(), '11.0.0', true);
			}
			
			// Enqueue History Milestones script
			$history_milestones_js_path = get_template_directory() . '/assets/js/HistoryMilestones.js';
			if (file_exists($history_milestones_js_path)) {
				wp_enqueue_script('history-milestones-script', get_template_directory_uri() . '/assets/js/HistoryMilestones.js', array('swiper-js'), _S_VERSION, true);
			}
		}
	}

	// Fancybox - Enqueue globally (used for galleries, job form popup, login popup, etc.)
	// Enqueue Fancybox CSS once
	if ( ! wp_style_is( 'fancybox-css', 'enqueued' ) ) {
		wp_enqueue_style(
			'fancybox-css',
			'https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css',
			array(),
			'5.0.0'
		);
	}
	// Enqueue Fancybox JS once
	if ( ! wp_script_is( 'fancybox-js', 'enqueued' ) ) {
		wp_enqueue_script(
			'fancybox-js',
			'https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js',
			array(),
			'5.0.0',
			true
		);
	}

	// Contact page specific scripts
	if (is_page_template('page-contact.php') || is_page_template('page-contact-us.php') || is_page_template('page-template-contact-us.php')) {
		// Load ContactMap script in footer, after other scripts
		$contact_map_js_path = get_template_directory() . '/assets/js/ContactMap.js';
		if (file_exists($contact_map_js_path)) {
			wp_enqueue_script('contact-map-script', get_template_directory_uri() . '/assets/js/ContactMap.js', array(), _S_VERSION, true);
		}
		
		// Enqueue AOS (Animate On Scroll) library (CDN) if not already loaded
		if (!wp_style_is('aos-css', 'enqueued')) {
			wp_enqueue_style('aos-css', 'https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css', array(), '2.3.4');
		}
		if (!wp_script_is('aos-js', 'enqueued')) {
			wp_enqueue_script('aos-js', 'https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js', array(), '2.3.4', true);
			// Initialize AOS after DOM is ready
			wp_add_inline_script('aos-js', 'document.addEventListener("DOMContentLoaded", function() { if (typeof AOS !== "undefined") { AOS.init({ duration: 800, once: true }); } });', 'after');
		}
	}

	// Event Detail page specific scripts
	if (is_page_template('page-template-event-detail.php') || is_singular( 'event' )) {
		// Load EventMap script in footer
		$event_map_js_path = get_template_directory() . '/assets/js/EventMap.js';
		if (file_exists($event_map_js_path)) {
			wp_enqueue_script('event-map-script', get_template_directory_uri() . '/assets/js/EventMap.js', array(), _S_VERSION, true);
		}
	}
	// Load Swiper and CompanyServices script on Company Detail pages
	if ($is_company_detail_page) {
		// Enqueue Swiper CSS and JS (CDN) - only if not already loaded on front page
		if (!wp_style_is('swiper-css', 'enqueued')) {
			wp_enqueue_style('swiper-css', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css', array(), '11.0.0');
		}
		if (!wp_script_is('swiper-js', 'enqueued')) {
			wp_enqueue_script('swiper-js', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', array(), '11.0.0', true);
		}

		// Enqueue CountUp.js library (CDN) for number animations
		wp_enqueue_script('countup-js', 'https://cdn.jsdelivr.net/npm/countup.js@2.9.0/dist/countUp.umd.js', array(), '2.9.0', true);

		// Enqueue CompanyServices script
		$company_services_js_path = get_template_directory() . '/assets/js/CompanyServices.js';
		if (file_exists($company_services_js_path)) {
			wp_enqueue_script('company-services-script', get_template_directory_uri() . '/assets/js/CompanyServices.js', array('swiper-js'), _S_VERSION, true);
		}

		// Enqueue CompanyHighlights script (for countup animations)
		$company_highlights_js_path = get_template_directory() . '/assets/js/CompanyHighlights.js';
		if (file_exists($company_highlights_js_path)) {
			wp_enqueue_script('company-highlights-script', get_template_directory_uri() . '/assets/js/CompanyHighlights.js', array('countup-js'), _S_VERSION, true);
		}

		// Enqueue CompanyVideo styles and script
		$company_video_css_path = get_template_directory() . '/assets/css/CompanyVideo.css';
		if (file_exists($company_video_css_path)) {
			wp_enqueue_style('company-video-style', get_template_directory_uri() . '/assets/css/CompanyVideo.css', array(), _S_VERSION);
		}
		$company_video_js_path = get_template_directory() . '/assets/js/CompanyVideo.js';
		if (file_exists($company_video_js_path)) {
			wp_enqueue_script('company-video-script', get_template_directory_uri() . '/assets/js/CompanyVideo.js', array(), _S_VERSION, true);
		}
	}

	// Enqueue AOS library for TasHeel Modern Support Services page
	if ($is_tasheel_modern_support_page) {
		// Enqueue AOS (Animate On Scroll) library (CDN)
		wp_enqueue_style('aos-css', 'https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css', array(), '2.3.4');
		wp_enqueue_script('aos-js', 'https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js', array(), '2.3.4', true);
		
		// Initialize AOS after DOM is ready
		wp_add_inline_script('aos-js', 'document.addEventListener("DOMContentLoaded", function() { if (typeof AOS !== "undefined") { AOS.init({ duration: 800, once: true, offset: 100 }); } });', 'after');
	}

	// Enqueue AOS library for Group Companies page
	if ($is_group_companies_page) {
		// Enqueue AOS (Animate On Scroll) library (CDN) - only if not already loaded
		if (!wp_style_is('aos-css', 'enqueued')) {
			wp_enqueue_style('aos-css', 'https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css', array(), '2.3.4');
		}
		if (!wp_script_is('aos-js', 'enqueued')) {
			wp_enqueue_script('aos-js', 'https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js', array(), '2.3.4', true);
		}
		
		// Initialize AOS after DOM is ready
		wp_add_inline_script('aos-js', 'document.addEventListener("DOMContentLoaded", function() { if (typeof AOS !== "undefined") { AOS.init({ duration: 800, once: true, offset: 100 }); } });', 'after');
	}

	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
}
add_action('wp_enqueue_scripts', 'tasheel_scripts');

/**
 * posts_where filter: restrict to projects that have the given service category (term ID) in project_category meta.
 * Handles ACF storage: single ID, serialized array (i:123;), or quoted ("123").
 */
function tasheel_project_category_posts_where( $where, $query ) {
	$tid = (int) $query->get( 'tasheel_category_term_id' );
	if ( $tid <= 0 ) {
		return $where;
	}
	global $wpdb;
	$like_serialized = $wpdb->esc_like( 'i:' . $tid . ';' );
	$like_quoted    = $wpdb->esc_like( '"' . $tid . '"' );
	$pattern_serialized = '%' . $like_serialized . '%';
	$pattern_quoted    = '%' . $like_quoted . '%';
	$extra = $wpdb->prepare(
		" AND {$wpdb->posts}.ID IN ( SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key = 'project_category' AND ( meta_value = %s OR meta_value LIKE %s OR meta_value LIKE %s ) )",
		(string) $tid,
		$pattern_serialized,
		$pattern_quoted
	);
	return $where . $extra;
}

/**
 * Normalize a location slug for matching: decode URL encoding and replace Unicode hyphens with ASCII.
 * Handles double-encoded URLs (e.g. riyadh%25e2%2580%2590ksa) and slugs like "riyadh‐ksa" (U+2010).
 *
 * @param string $slug Raw slug from URL or form.
 * @return string Normalized slug (ASCII hyphen, single decode).
 */
function tasheel_normalize_location_slug( $slug ) {
	if ( ! is_string( $slug ) ) {
		return '';
	}
	$slug = trim( $slug );
	if ( $slug === '' ) {
		return '';
	}
	// Decode until stable (handles double/triple encoding e.g. riyadh%25e2%2580%2590ksa)
	while ( strpos( $slug, '%' ) !== false ) {
		$decoded = rawurldecode( $slug );
		if ( $decoded === $slug ) {
			break;
		}
		$slug = $decoded;
	}
	// Replace Unicode hyphen/minus variants with ASCII hyphen (WordPress sanitize_title uses ASCII)
	$slug = str_replace( array( "\xE2\x80\x90", "\xE2\x80\x91", "\xE2\x80\x92", "\xE2\x80\x93", "\xE2\x80\x94", "\xE2\x88\x92" ), '-', $slug );
	$slug = preg_replace( '/\s+/', '-', $slug );
	return $slug;
}

/**
 * Resolve project_location param (slug, possibly URL-encoded or Unicode) to term_id for reliable filtering.
 * WPML-aware: when on Arabic (or any non-default language), resolve slug to current-language term_id
 * so the tax_query matches projects in that language.
 *
 * @param string $location_param Value from URL or form (slug, may be encoded).
 * @return int Term ID in current language, or 0 if not found.
 */
function tasheel_resolve_project_location_term_id( $location_param ) {
	$slug = is_string( $location_param ) ? trim( $location_param ) : '';
	if ( $slug === '' ) {
		return 0;
	}
	$normalized = function_exists( 'tasheel_normalize_location_slug' ) ? tasheel_normalize_location_slug( $slug ) : $slug;
	if ( $normalized === '' ) {
		$normalized = $slug;
	}
	// Try current language first (dropdown on /ar/projects/ sends current-language slug).
	$term = get_term_by( 'slug', $normalized, 'project_location' );
	if ( $term && ! is_wp_error( $term ) ) {
		$tid = (int) $term->term_id;
		if ( function_exists( 'apply_filters' ) && has_filter( 'wpml_object_id' ) ) {
			$current_lang = apply_filters( 'wpml_current_language', null );
			if ( $current_lang !== null && $current_lang !== '' ) {
				$current_tid = apply_filters( 'wpml_object_id', $tid, 'project_location', true, $current_lang );
				if ( $current_tid ) {
					$tid = (int) $current_tid;
				}
			}
		}
		return $tid;
	}
	// Fallback: match against all location terms in current language (encoding/Unicode).
	$terms = get_terms( array( 'taxonomy' => 'project_location', 'hide_empty' => false ) );
	if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
		foreach ( $terms as $t ) {
			$t_slug_norm = function_exists( 'tasheel_normalize_location_slug' ) ? tasheel_normalize_location_slug( $t->slug ) : $t->slug;
			if ( $t_slug_norm === $normalized ) {
				return (int) $t->term_id;
			}
		}
	}
	// WPML: slug might be from default language (e.g. shared slug); resolve in default lang and map to current.
	if ( ! function_exists( 'apply_filters' ) || ! has_filter( 'wpml_object_id' ) ) {
		return 0;
	}
	$current_lang = apply_filters( 'wpml_current_language', null );
	$default_lang = apply_filters( 'wpml_default_language', null );
	if ( $current_lang === null || $default_lang === null || $current_lang === $default_lang ) {
		return 0;
	}
	if ( has_action( 'wpml_switch_language' ) ) {
		do_action( 'wpml_switch_language', $default_lang );
	}
	$term = get_term_by( 'slug', $normalized, 'project_location' );
	if ( has_action( 'wpml_switch_language' ) ) {
		do_action( 'wpml_switch_language', $current_lang );
	}
	if ( ! $term || is_wp_error( $term ) ) {
		return 0;
	}
	$current_term_id = apply_filters( 'wpml_object_id', (int) $term->term_id, 'project_location', true, $current_lang );
	return $current_term_id ? (int) $current_term_id : 0;
}

/**
 * Resolve service_category slug to term_id in current language (WPML-aware).
 * When URL has default-language slug (e.g. English) but page is in Arabic, look up term in default language
 * and return the current language term_id so the projects query and dropdown work.
 *
 * @param string $slug Category slug from URL (e.g. program-and-project-management).
 * @return int Term ID in current language, or 0 if not found.
 */
function tasheel_resolve_category_slug_to_term_id( $slug ) {
	$slug = is_string( $slug ) ? trim( $slug ) : '';
	if ( $slug === '' ) {
		return 0;
	}
	// Try current language first (works when URL has same-language slug).
	$term = get_term_by( 'slug', $slug, 'service_category' );
	if ( $term && ! is_wp_error( $term ) ) {
		return (int) $term->term_id;
	}
	// WPML: resolve slug from default language and map to current language term_id.
	if ( ! function_exists( 'apply_filters' ) || ! has_filter( 'wpml_object_id' ) ) {
		return 0;
	}
	$current_lang = apply_filters( 'wpml_current_language', null );
	$default_lang = apply_filters( 'wpml_default_language', null );
	if ( $default_lang === null || $current_lang === null ) {
		return 0;
	}
	if ( has_action( 'wpml_switch_language' ) ) {
		do_action( 'wpml_switch_language', $default_lang );
	}
	$term = get_term_by( 'slug', $slug, 'service_category' );
	if ( has_action( 'wpml_switch_language' ) ) {
		do_action( 'wpml_switch_language', $current_lang );
	}
	if ( ! $term || is_wp_error( $term ) ) {
		return 0;
	}
	$current_term_id = apply_filters( 'wpml_object_id', (int) $term->term_id, 'service_category', true, $current_lang );
	return $current_term_id ? (int) $current_term_id : 0;
}

/**
 * Resolve sector (service post) slug to post ID in current language (WPML-aware).
 * When URL has default-language slug but page is in Arabic, look up post in default language
 * and return the current language post ID.
 *
 * @param string $slug Service post slug from URL (e.g. construction-management), or numeric ID.
 * @return int Post ID in current language, or 0 if not found.
 */
function tasheel_resolve_sector_slug_to_post_id( $slug ) {
	$slug = is_string( $slug ) ? trim( $slug ) : '';
	if ( $slug === '' ) {
		return 0;
	}
	if ( is_numeric( $slug ) ) {
		$id = (int) $slug;
		if ( $id <= 0 ) {
			return 0;
		}
		if ( function_exists( 'apply_filters' ) && has_filter( 'wpml_object_id' ) ) {
			$current_id = apply_filters( 'wpml_object_id', $id, 'post', true );
			return $current_id ? (int) $current_id : 0;
		}
		return $id;
	}
	// Try current language first.
	$posts = get_posts( array(
		'post_type'      => 'service',
		'name'           => $slug,
		'post_status'    => 'publish',
		'posts_per_page' => 1,
		'fields'         => 'ids',
	) );
	if ( ! empty( $posts ) ) {
		return (int) $posts[0];
	}
	// WPML: resolve slug from default language and map to current language post ID.
	if ( ! function_exists( 'apply_filters' ) || ! has_filter( 'wpml_object_id' ) ) {
		return 0;
	}
	$current_lang = apply_filters( 'wpml_current_language', null );
	$default_lang = apply_filters( 'wpml_default_language', null );
	if ( $default_lang === null || $current_lang === null ) {
		return 0;
	}
	if ( has_action( 'wpml_switch_language' ) ) {
		do_action( 'wpml_switch_language', $default_lang );
	}
	$posts = get_posts( array(
		'post_type'      => 'service',
		'name'           => $slug,
		'post_status'    => 'publish',
		'posts_per_page' => 1,
		'fields'         => 'ids',
	) );
	if ( has_action( 'wpml_switch_language' ) ) {
		do_action( 'wpml_switch_language', $current_lang );
	}
	if ( empty( $posts ) ) {
		return 0;
	}
	$current_post_id = apply_filters( 'wpml_object_id', (int) $posts[0], 'post', true, $current_lang );
	return $current_post_id ? (int) $current_post_id : 0;
}

/**
 * AJAX: Filter projects (Category, Sector, Location) – returns HTML for project cards.
 * Respects lang parameter so Arabic page loads only Arabic projects (WPML).
 */
function tasheel_ajax_filter_projects() {
	$filter_category = isset($_REQUEST['category']) ? sanitize_text_field(wp_unslash($_REQUEST['category'])) : '';
	$filter_sector   = isset($_REQUEST['sector']) ? sanitize_text_field(wp_unslash($_REQUEST['sector'])) : '';
	$filter_location_raw = isset( $_REQUEST['location'] ) ? wp_unslash( $_REQUEST['location'] ) : ( isset( $_REQUEST['filter_location'] ) ? wp_unslash( $_REQUEST['filter_location'] ) : '' );
	$filter_location = is_string( $filter_location_raw ) ? trim( $filter_location_raw ) : '';
	$per_page = isset($_REQUEST['per_page']) ? max(1, (int) $_REQUEST['per_page']) : 12;
	$offset = isset($_REQUEST['offset']) ? max(0, (int) $_REQUEST['offset']) : 0;
	if ($per_page < 1 || $per_page > 100) {
		$per_page = 12;
	}
	$lang = isset( $_REQUEST['lang'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['lang'] ) ) : '';

	// Switch to requested language so WPML returns only projects in that language.
	if ( $lang !== '' && has_action( 'wpml_switch_language' ) ) {
		do_action( 'wpml_switch_language', $lang );
	}

	$projects_args = array(
		'post_type'      => 'project',
		'posts_per_page' => $per_page,
		'offset'         => $offset,
		'post_status'    => 'publish',
		'orderby'        => 'date',
		'order'          => 'DESC',
	);

	$filter_location_term_id = function_exists( 'tasheel_resolve_project_location_term_id' )
		? tasheel_resolve_project_location_term_id( $filter_location )
		: 0;
	if ( $filter_location_term_id > 0 ) {
		// WPML: query by both current- and default-language term_id so we match whether relationships use translated or default term (term_id can differ per language).
		$location_term_ids = array( $filter_location_term_id );
		if ( $lang !== '' && function_exists( 'apply_filters' ) && has_filter( 'wpml_object_id' ) ) {
			$default_lang = apply_filters( 'wpml_default_language', null );
			if ( $default_lang !== null && $default_lang !== '' ) {
				$default_term_id = apply_filters( 'wpml_object_id', $filter_location_term_id, 'project_location', true, $default_lang );
				if ( $default_term_id && ! in_array( (int) $default_term_id, $location_term_ids, true ) ) {
					$location_term_ids[] = (int) $default_term_id;
				}
			}
		}
		$projects_args['tax_query'] = array(
			array(
				'taxonomy' => 'project_location',
				'field'    => 'term_id',
				'terms'    => $location_term_ids,
			),
		);
	}

	$meta_queries = array();
	$category_term_id_for_where = 0;
	if ( $filter_category && function_exists( 'tasheel_resolve_category_slug_to_term_id' ) ) {
		$category_term_id_for_where = tasheel_resolve_category_slug_to_term_id( $filter_category );
	}
	// Sector = service post ID (resolve from slug or numeric ID); ACF stores as serialized (WPML-aware)
	$filter_sector_id = 0;
	if ( $filter_sector !== '' && function_exists( 'tasheel_resolve_sector_slug_to_post_id' ) ) {
		$filter_sector_id = tasheel_resolve_sector_slug_to_post_id( $filter_sector );
	}
	if ($filter_sector_id > 0) {
		$sid = $filter_sector_id;
		$meta_queries[] = array(
			'relation' => 'OR',
			array(
				'key'     => 'sector',
				'value'   => '"' . $sid . '"',
				'compare' => 'LIKE',
			),
			array(
				'key'     => 'sector',
				'value'   => 'i:' . $sid . ';',
				'compare' => 'LIKE',
			),
		);
	}
	if (!empty($meta_queries)) {
		$meta_queries['relation'] = 'AND';
		$projects_args['meta_query'] = $meta_queries;
	}
	$projects_args['tasheel_category_term_id'] = $category_term_id_for_where;

	if ($category_term_id_for_where > 0) {
		add_filter( 'posts_where', 'tasheel_project_category_posts_where', 10, 2 );
	}

	$projects_query = new WP_Query($projects_args);

	if ($category_term_id_for_where > 0) {
		remove_filter( 'posts_where', 'tasheel_project_category_posts_where', 10 );
	}
	$html = '';
	$returned_count = 0;

	if ($projects_query->have_posts()) {
		while ($projects_query->have_posts()) {
			$projects_query->the_post();
			$project_id = get_the_ID();
			$project_image = '';
			$project_alt = get_the_title();
			if (function_exists('get_field')) {
				$listing_img = get_field('project_listing_image', $project_id);
				if (!empty($listing_img)) {
					$project_image = is_array($listing_img) ? (isset($listing_img['url']) ? $listing_img['url'] : '') : $listing_img;
				}
			}
			if (!$project_image && has_post_thumbnail($project_id)) {
				$project_image = get_the_post_thumbnail_url($project_id, 'full');
				$project_alt = get_the_post_thumbnail_caption($project_id) ?: get_the_title();
			}
			$title_first = function_exists('get_field') ? get_field('project_listing_title_first', $project_id) : '';
			$title_second = function_exists('get_field') ? get_field('project_listing_title_span', $project_id) : '';
			if (!is_string($title_first)) $title_first = '';
			if (!is_string($title_second)) $title_second = '';
			if ($title_first === '' && $title_second === '') {
				$project_title = get_the_title();
				$title_parts = explode(' ', $project_title);
				$title_mid = ceil(count($title_parts) / 2);
				$title_first = implode(' ', array_slice($title_parts, 0, $title_mid));
				$title_second = implode(' ', array_slice($title_parts, $title_mid));
			}
			$project_description = function_exists('get_field') ? get_field('project_listing_description', $project_id) : '';
			if (!is_string($project_description) || $project_description === '') {
				$project_description = get_the_excerpt();
			}
			$project_card_data = array(
				'image'      => $project_image,
				'image_alt'  => $project_alt,
				'title'      => $title_first,
				'title_span' => $title_second,
				'description' => $project_description,
				'link'       => get_permalink($project_id),
				'card_class' => '',
			);
			ob_start();
			get_template_part('template-parts/Project-Card', null, $project_card_data);
			$html .= ob_get_clean();
			$returned_count++;
		}
		wp_reset_postdata();
	}

	$total_found = $projects_query->found_posts;
	$has_more = $total_found > ($offset + $returned_count);

	if ($returned_count === 0 && $offset === 0) {
		$html = '<p class="no-projects">' . esc_html__('No projects found.', 'tasheel') . '</p>';
	}

	wp_send_json_success(array(
		'html'    => $html,
		'hasMore' => $has_more,
		'offset'  => $offset + $returned_count,
		'total'   => $total_found,
	));
}
add_action('wp_ajax_tasheel_filter_projects', 'tasheel_ajax_filter_projects');
add_action('wp_ajax_nopriv_tasheel_filter_projects', 'tasheel_ajax_filter_projects');

/**
 * Build client item data (logo, name, link) from client post ID – used by Clients page and AJAX
 */
function tasheel_build_client_item_data( $post_id ) {
	$name = get_the_title( $post_id );
	$logo = '';
	$link = '#';
	if ( function_exists( 'get_field' ) ) {
		$logo_field = get_field( 'client_logo', $post_id );
		if ( ! empty( $logo_field ) ) {
			$logo = is_array( $logo_field ) && isset( $logo_field['url'] ) ? $logo_field['url'] : $logo_field;
		}
		$link_field = get_field( 'client_link', $post_id );
		if ( is_string( $link_field ) && $link_field !== '' ) {
			$link = $link_field;
		}
	}
	if ( $logo === '' && has_post_thumbnail( $post_id ) ) {
		$logo = get_the_post_thumbnail_url( $post_id, 'full' );
	}
	return array(
		'logo' => $logo ?: get_template_directory_uri() . '/assets/images/partner-01.png',
		'name' => $name ?: __( 'Client', 'tasheel' ),
		'link' => $link,
	);
}

/**
 * Get client IDs in category order (same order as Clients page filter tabs).
 * Used for "All" view so the list matches the home page category order.
 *
 * @param int $offset   Offset for pagination.
 * @param int $per_page Number of IDs to return (-1 for all).
 * @return array { 'ids' => int[], 'total' => int }
 */
function tasheel_get_client_ids_by_category_order( $offset = 0, $per_page = -1 ) {
	$terms = get_terms( array(
		'taxonomy'   => 'client_category',
		'hide_empty' => true,
		'orderby'    => 'name',
		'order'      => 'ASC',
	) );
	if ( is_wp_error( $terms ) || empty( $terms ) ) {
		$count_query = new WP_Query( array(
			'post_type'      => 'client',
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'fields'         => 'ids',
		) );
		$all_ids = $count_query->posts;
		wp_reset_postdata();
		$total = count( $all_ids );
		$ids   = $per_page < 1 ? array_slice( $all_ids, $offset ) : array_slice( $all_ids, $offset, $per_page );
		return array( 'ids' => $ids, 'total' => $total );
	}
	$seen   = array();
	$all_ids = array();
	foreach ( $terms as $term ) {
		$q = new WP_Query( array(
			'post_type'      => 'client',
			'posts_per_page' => -1,
			'post_status'    => 'publish',
			'orderby'        => 'menu_order title',
			'order'          => 'ASC',
			'fields'         => 'ids',
			'tax_query'      => array(
				array(
					'taxonomy' => 'client_category',
					'field'    => 'term_id',
					'terms'    => $term->term_id,
				),
			),
		) );
		foreach ( $q->posts as $id ) {
			if ( ! isset( $seen[ $id ] ) ) {
				$seen[ $id ] = true;
				$all_ids[] = $id;
			}
		}
		wp_reset_postdata();
	}
	// Append clients with no category
	$q = new WP_Query( array(
		'post_type'      => 'client',
		'posts_per_page' => -1,
		'post_status'    => 'publish',
		'orderby'        => 'menu_order title',
		'order'          => 'ASC',
		'fields'         => 'ids',
		'tax_query'      => array(
			array(
				'taxonomy' => 'client_category',
				'operator' => 'NOT EXISTS',
			),
		),
	) );
	foreach ( $q->posts as $id ) {
		if ( ! isset( $seen[ $id ] ) ) {
			$all_ids[] = $id;
		}
	}
	wp_reset_postdata();
	$total = count( $all_ids );
	$ids   = $per_page < 1 ? array_slice( $all_ids, $offset ) : array_slice( $all_ids, $offset, $per_page );
	return array( 'ids' => $ids, 'total' => $total );
}

/**
 * AJAX: Filter clients by category and/or load more – returns HTML of client list items.
 * When category is empty (All), clients are ordered by category order (same as filter tabs).
 */
function tasheel_ajax_filter_clients() {
	$category = isset( $_REQUEST['category'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['category'] ) ) : '';
	$per_page = isset( $_REQUEST['per_page'] ) ? max( 1, min( 100, (int) $_REQUEST['per_page'] ) ) : 12;
	$offset   = isset( $_REQUEST['offset'] ) ? max( 0, (int) $_REQUEST['offset'] ) : 0;

	if ( $category === '' ) {
		$result = tasheel_get_client_ids_by_category_order( $offset, $per_page );
		$ids   = $result['ids'];
		$total_found = $result['total'];
	} else {
		$args = array(
			'post_type'      => 'client',
			'posts_per_page' => $per_page,
			'offset'         => $offset,
			'post_status'    => 'publish',
			'orderby'        => 'menu_order title',
			'order'          => 'ASC',
			'tax_query'      => array(
				array(
					'taxonomy' => 'client_category',
					'field'    => 'slug',
					'terms'    => $category,
				),
			),
		);
		$query = new WP_Query( $args );
		$ids = $query->posts ? array_map( 'intval', wp_list_pluck( $query->posts, 'ID' ) ) : array();
		$total_found = (int) $query->found_posts;
		wp_reset_postdata();
	}

	$html  = '';
	$count = 0;
	foreach ( $ids as $post_id ) {
		$post = get_post( $post_id );
		if ( ! $post || $post->post_type !== 'client' || $post->post_status !== 'publish' ) {
			continue;
		}
		$c = tasheel_build_client_item_data( $post_id );
		$logo = esc_url( $c['logo'] );
		$name = esc_attr( $c['name'] );
		$link = esc_url( $c['link'] );
		if ( $link && $link !== '#' ) {
			$html .= '<li class="client_item"><a href="' . esc_url( $link ) . '" class="client_item_link" target="_blank" rel="noopener noreferrer"><img src="' . esc_url( $logo ) . '" alt="' . esc_attr( $name ) . '"></a></li>';
		} else {
			$html .= '<li class="client_item"><img src="' . $logo . '" alt="' . $name . '"></li>';
		}
		$count++;
	}
	$has_more = $total_found > ( $offset + $count );

	if ( $count === 0 && $offset === 0 ) {
		$html = '<li class="client_item client_item--empty"><p class="no-clients">' . esc_html__( 'No clients found.', 'tasheel' ) . '</p></li>';
	}

	wp_send_json_success( array(
		'html'    => $html,
		'hasMore' => $has_more,
		'offset'  => $offset + $count,
		'total'   => $total_found,
	) );
}
add_action( 'wp_ajax_tasheel_filter_clients', 'tasheel_ajax_filter_clients' );
add_action( 'wp_ajax_nopriv_tasheel_filter_clients', 'tasheel_ajax_filter_clients' );

/**
 * ACF JSON Save Point
 */
function tasheel_acf_json_save_point( $path ) {
	return get_stylesheet_directory() . '/acf-json';
}
add_filter( 'acf/settings/save_json', 'tasheel_acf_json_save_point' );

/**
 * ACF JSON Load Point - add theme acf-json directory
 */
function tasheel_acf_json_load_point( $paths ) {
	$paths[] = get_stylesheet_directory() . '/acf-json';
	$paths[] = get_template_directory() . '/acf-json';
	return $paths;
}
add_filter( 'acf/settings/load_json', 'tasheel_acf_json_load_point' );

/**
 * Register ACF Options pages (Company, Header, Footer)
 */
function tasheel_acf_options_pages() {
	if ( function_exists( 'acf_add_options_sub_page' ) ) {
		acf_add_options_sub_page( array(
			'page_title' => __( 'Company Options', 'tasheel' ),
			'menu_title' => __( 'Company Options', 'tasheel' ),
			'menu_slug'  => 'acf-options-company',
			'capability' => 'edit_posts',
		) );
		acf_add_options_sub_page( array(
			'page_title' => __( 'Header Options', 'tasheel' ),
			'menu_title' => __( 'Header Options', 'tasheel' ),
			'menu_slug'  => 'acf-options-header',
			'capability' => 'edit_posts',
		) );
		acf_add_options_sub_page( array(
			'page_title' => __( 'Footer Options', 'tasheel' ),
			'menu_title' => __( 'Footer Options', 'tasheel' ),
			'menu_slug'  => 'acf-options-footer',
			'capability' => 'edit_posts',
		) );
		acf_add_options_sub_page( array(
			'page_title' => __( 'Account Options', 'tasheel' ),
			'menu_title' => __( 'Account Options', 'tasheel' ),
			'menu_slug'  => 'acf-options-account',
			'capability' => 'edit_posts',
		) );
		acf_add_options_sub_page( array(
			'page_title' => __( 'Careers Options', 'tasheel' ),
			'menu_title' => __( 'Careers Options', 'tasheel' ),
			'menu_slug'  => 'acf-options-careers',
			'capability' => 'edit_posts',
		) );
	}
}
add_action( 'acf/init', 'tasheel_acf_options_pages', 15 );



/**
 * WPML String Translation Helper
 * Makes ACF fields translatable via WPML
 */
function tasheel_wpml_translate_acf_string($value, $context = 'ACF', $name = '') {
	if (function_exists('icl_translate')) {
		return icl_translate($context, $name, $value);
	}
	return $value;
}

/**
 * WPML String Translation: register strings that must appear in String Translation.
 *
 * - Use __() / esc_html_e() / esc_attr_e() with domain 'tasheel' for ALL static text so it
 *   can be translated. WPML discovers most strings when you run "Scan the theme for strings"
 *   (WPML → String Translation → "Scan the theme for strings" or Theme and plugins localization).
 * - New strings are NOT added automatically: after adding new static text, run the theme scan
 *   so they appear in String Translation.
 * - Strings used in data attributes or passed to JS are registered below so they always show
 *   in WPML even if the scanner misses them. Add any other missing strings to the array.
 */
function tasheel_register_wpml_strings() {
	if ( ! function_exists( 'icl_register_string' ) ) {
		return;
	}
	$domain = 'tasheel';
	$strings = array(
		'Enter details for this additional education entry.',
		'Enter details for this additional experience entry.',
		'Enter details for this additional project.',
		'Edit profile',
		// Login popup / registration form (passed to JS via wp_localize_script)
		'Sending…',
		'Something went wrong. Please try again.',
		'The email could not be sent. Please try again.',
		'Please enter your email address.',
		'Please enter a valid email address.',
		'Please retype your email address.',
		'Email addresses do not match.',
		'Please enter your first name.',
		'Please enter your last name.',
		'Please choose a password.',
		'Password must be at least 6 characters.',
		'Password must include at least one uppercase letter, one lowercase letter, one digit, and one special character.',
		'Please retype your password.',
		'Passwords do not match.',
		// Job form popup (header) – static copy of sign-up labels
		'Email Address *',
		'Retype Email Address *',
		'First Name *',
		'Last Name *',
		'Choose Password *',
		'Retype Password *',
		'Create your account in a seconds',
	);
	foreach ( $strings as $str ) {
		$name = 'theme_' . md5( $str );
		icl_register_string( $domain, $name, $str );
	}
}
add_action( 'init', 'tasheel_register_wpml_strings' );

/**
 * Flush rewrite rules on theme activation
 */
function tasheel_flush_rewrite_rules() {
	tasheel_register_all_post_types();
	tasheel_register_all_taxonomies();
	flush_rewrite_rules();
}
add_action('after_switch_theme', 'tasheel_flush_rewrite_rules');

/**
 * Custom URL structure for services and projects
 */
function tasheel_custom_rewrite_rules() {
	// Force /services/ to load the Services PAGE (with page-template-services.php), not the CPT archive.
	$services_pages = get_posts( array(
		'post_type'   => 'page',
		'meta_key'    => '_wp_page_template',
		'meta_value'  => 'page-template-services.php',
		'numberposts' => 1,
		'post_status' => 'publish',
		'fields'      => 'ids',
	) );
	if ( ! empty( $services_pages ) ) {
		add_rewrite_rule( '^services/?$', 'index.php?page_id=' . (int) $services_pages[0], 'top' );
	}

	// Service single: /services/service-slug/
	add_rewrite_rule('^services/([^/]+)/?$', 'index.php?post_type=service&name=$matches[1]', 'top');

	// Force /projects/ to load the Projects PAGE (with page-template-projects.php), not the CPT archive.
	$projects_pages = get_posts( array(
		'post_type'      => 'page',
		'meta_key'       => '_wp_page_template',
		'meta_value'     => 'page-template-projects.php',
		'numberposts'    => 1,
		'post_status'    => 'publish',
		'fields'         => 'ids',
	) );
	if ( ! empty( $projects_pages ) ) {
		add_rewrite_rule( '^projects/?$', 'index.php?page_id=' . (int) $projects_pages[0], 'top' );
	}

	// Project single: /projects/project-slug/
	add_rewrite_rule('^projects/([^/]+)/?$', 'index.php?post_type=project&name=$matches[1]', 'top');

	// Clean URLs for apply flow: my-profile/apply/123/ and create-profile/apply/123/
	$my_profile = get_page_by_path( 'my-profile' );
	if ( $my_profile ) {
		add_rewrite_rule( '^my-profile/apply/([0-9]+)/?$', 'index.php?page_id=' . (int) $my_profile->ID . '&apply_to=$matches[1]', 'top' );
	}
	// Create Profile: use shared helper so /create-profile/ and /create-profile/apply/123/ resolve
	$create_profile_id = tasheel_get_create_profile_page_id();
	if ( $create_profile_id ) {
		add_rewrite_rule( '^create-profile/?$', 'index.php?page_id=' . $create_profile_id, 'top' );
		add_rewrite_rule( '^create-profile/apply/([0-9]+)/?$', 'index.php?page_id=' . $create_profile_id . '&apply_to=$matches[1]', 'top' );
	}
}
add_action('init', 'tasheel_custom_rewrite_rules');

function tasheel_apply_query_vars( $vars ) {
	$vars[] = 'apply_to';
	$vars[] = 'redirect';
	return $vars;
}
add_filter( 'query_vars', 'tasheel_apply_query_vars' );

/**
 * Guest-only: when loading Apply as Guest with review_token (Edit profile), prevent any caching
 * so the form is always generated fresh with guest data. No impact on logged-in users.
 * Without this, a cached empty form can be served and "previously entered details" appear removed.
 */
function tasheel_guest_apply_nocache_on_edit() {
	$review_token = isset( $_GET['review_token'] ) ? sanitize_text_field( wp_unslash( $_GET['review_token'] ) ) : '';
	$apply_to     = isset( $_GET['apply_to'] ) ? max( 0, (int) $_GET['apply_to'] ) : 0;
	if ( ! $review_token || ! $apply_to ) {
		return;
	}
	// Only run when this is the Apply as Guest page (avoids affecting other pages with same query params).
	if ( ! is_page_template( 'page-template-apply-as-guest.php' ) ) {
		return;
	}
	if ( ! defined( 'DONOTCACHEPAGE' ) ) {
		define( 'DONOTCACHEPAGE', true );
	}
	nocache_headers();
}
add_action( 'template_redirect', 'tasheel_guest_apply_nocache_on_edit', 1 );

/**
 * Set DONOTCACHEPAGE as early as possible for Apply as Guest edit (GET with review_token or POST from Edit profile).
 * Many caching plugins check DONOTCACHEPAGE at init; setting it at priority 0 ensures the page
 * is never cached so guest data pre-fill works when they click "Edit profile".
 */
function tasheel_guest_apply_donotcachepage_early() {
	$uri = isset( $_SERVER['REQUEST_URI'] ) ? $_SERVER['REQUEST_URI'] : '';
	if ( strpos( $uri, 'apply-as-a-guest' ) === false ) {
		return;
	}
	$is_edit_get  = ! empty( $_GET['review_token'] ) && ! empty( $_GET['apply_to'] );
	$is_edit_post = ( $_SERVER['REQUEST_METHOD'] === 'POST' && ! empty( $_POST['tasheel_guest_edit_profile'] ) );
	if ( ! $is_edit_get && ! $is_edit_post ) {
		return;
	}
	if ( ! defined( 'DONOTCACHEPAGE' ) ) {
		define( 'DONOTCACHEPAGE', true );
	}
}
add_action( 'init', 'tasheel_guest_apply_donotcachepage_early', 0 );

/**
 * Get the Create Profile page ID (by template or by slug). Used for rewrites and request override.
 *
 * @return int|null Page ID or null.
 */
function tasheel_get_create_profile_page_id() {
	$pages = get_posts( array(
		'post_type'   => 'page',
		'meta_key'    => '_wp_page_template',
		'meta_value'  => 'page-template-create-profile.php',
		'numberposts' => 1,
		'post_status' => 'publish',
		'fields'      => 'ids',
	) );
	if ( ! empty( $pages ) ) {
		return (int) $pages[0];
	}
	$page = get_page_by_path( 'create-profile' );
	return $page ? (int) $page->ID : null;
}

/**
 * Force Create Profile page when URL is /create-profile/ or /create-profile/apply/{id}/.
 * Handles subdir/locale (path can end with create-profile or .../create-profile/apply/123).
 */
function tasheel_force_create_profile_request( $query_vars ) {
	$uri  = isset( $_SERVER['REQUEST_URI'] ) ? wp_unslash( $_SERVER['REQUEST_URI'] ) : '';
	$path = trim( parse_url( $uri, PHP_URL_PATH ), '/' );
	// Match create-profile or create-profile/apply/123 (with optional prefix e.g. locale/subdir).
	$apply_to = 0;
	if ( preg_match( '#(?:^|/)create-profile/apply/([0-9]+)/?$#', $path, $m ) ) {
		$apply_to = (int) $m[1];
	} elseif ( $path !== 'create-profile' && substr( $path, -strlen( '/create-profile' ) ) !== '/create-profile' ) {
		// Not create-profile and not .../create-profile
		return $query_vars;
	}
	$page_id = tasheel_get_create_profile_page_id();
	if ( ! $page_id ) {
		return $query_vars;
	}
	// Remove pagename so main query uses page_id only (avoids 404 from wrong slug).
	unset( $query_vars['pagename'] );
	return array_merge( $query_vars, array( 'page_id' => $page_id, 'apply_to' => $apply_to ) );
}
add_filter( 'request', 'tasheel_force_create_profile_request', 1 );

/**
 * Override query when /projects/ is incorrectly resolved as project CPT archive.
 * The project CPT uses slug "projects", which can win over the Projects page in rewrite order.
 * This filter forces the Projects page to load when the URL path is exactly /projects/.
 */
function tasheel_force_projects_page_request( $query_vars ) {
	// Only override when: post_type=project archive (no specific project) and request URI is /projects/
	if ( isset( $query_vars['post_type'] ) && $query_vars['post_type'] === 'project' && empty( $query_vars['name'] ) ) {
		$uri = isset( $_SERVER['REQUEST_URI'] ) ? wp_unslash( $_SERVER['REQUEST_URI'] ) : '';
		$path = trim( parse_url( $uri, PHP_URL_PATH ), '/' );
		if ( $path === 'projects' ) {
			$projects_pages = get_posts( array(
				'post_type'   => 'page',
				'meta_key'    => '_wp_page_template',
				'meta_value'  => 'page-template-projects.php',
				'numberposts' => 1,
				'post_status' => 'publish',
				'fields'      => 'ids',
			) );
			if ( ! empty( $projects_pages ) ) {
				return array( 'page_id' => (int) $projects_pages[0] );
			}
		}
	}
	return $query_vars;
}
add_filter( 'request', 'tasheel_force_projects_page_request', 1 );

/**
 * Override query when /services/ is incorrectly resolved as service CPT archive.
 * Forces the Services page to load when the URL path is exactly /services/.
 */
function tasheel_force_services_page_request( $query_vars ) {
	if ( isset( $query_vars['post_type'] ) && $query_vars['post_type'] === 'service' && empty( $query_vars['name'] ) ) {
		$uri  = isset( $_SERVER['REQUEST_URI'] ) ? wp_unslash( $_SERVER['REQUEST_URI'] ) : '';
		$path = trim( parse_url( $uri, PHP_URL_PATH ), '/' );
		if ( $path === 'services' ) {
			$services_pages = get_posts( array(
				'post_type'   => 'page',
				'meta_key'    => '_wp_page_template',
				'meta_value'  => 'page-template-services.php',
				'numberposts' => 1,
				'post_status' => 'publish',
				'fields'      => 'ids',
			) );
			if ( ! empty( $services_pages ) ) {
				return array( 'page_id' => (int) $services_pages[0] );
			}
		}
	}
	return $query_vars;
}
add_filter( 'request', 'tasheel_force_services_page_request', 1 );



add_filter('wpcf7_autop_or_not', '__return_false');


/**
 * Get the Contact Form 7 form ID used in the footer newsletter shortcode (for duplicate-email check).
 * Tries raw ACF option, get_field with page slug, then generic 'option'.
 *
 * @return int Form ID, or 0 if not found.
 */
function tasheel_get_footer_cf7_form_id() {
	$shortcode = '';
	// Try raw option (ACF stores as options_acf-options-{slug}).
	$opts = get_option( 'options_acf-options-footer', array() );
	if ( is_array( $opts ) && ! empty( $opts['footer_contact_form_shortcode'] ) && is_string( $opts['footer_contact_form_shortcode'] ) ) {
		$shortcode = $opts['footer_contact_form_shortcode'];
	}
	if ( ( ! is_string( $shortcode ) || $shortcode === '' ) && function_exists( 'get_field' ) ) {
		$shortcode = get_field( 'footer_contact_form_shortcode', 'acf-options-footer' );
		if ( ! is_string( $shortcode ) || $shortcode === '' ) {
			$shortcode = get_field( 'footer_contact_form_shortcode', 'option' );
		}
	}
	if ( ! is_string( $shortcode ) || $shortcode === '' ) {
		return (int) apply_filters( 'tasheel_newsletter_cf7_form_id', 0 );
	}
	// Match id="123" or id='123' or id=123.
	if ( preg_match( '/id\s*=\s*["\']?([0-9]+)["\']?/', $shortcode, $m ) ) {
		return (int) apply_filters( 'tasheel_newsletter_cf7_form_id', (int) $m[1] );
	}
	return (int) apply_filters( 'tasheel_newsletter_cf7_form_id', 0 );
}

/**
 * Check if an email was already submitted for the newsletter form (Advanced CF7 DB or theme option).
 *
 * @param int    $form_id CF7 form ID.
 * @param string $email   Email address (will be normalized to lowercase).
 * @return bool True if this email was already submitted for this form.
 */
function tasheel_newsletter_email_already_submitted( $form_id, $email ) {
	$email = strtolower( trim( $email ) );
	if ( $email === '' || ! is_email( $email ) ) {
		return false;
	}
	global $wpdb;
	$entry_table = $wpdb->prefix . 'cf7_vdata_entry';
	// Use Advanced CF7 DB table if it exists (plugin stores all submissions there).
	if ( $form_id && $wpdb->get_var( "SHOW TABLES LIKE '" . esc_sql( $entry_table ) . "'" ) === $entry_table ) {
		$email_names = array( 'Email', 'email', 'your-email', 'subscriber-email', 'your_email' );
		$placeholders = implode( ',', array_fill( 0, count( $email_names ), '%s' ) );
		$query = $wpdb->prepare(
			"SELECT 1 FROM `{$entry_table}` WHERE `cf7_id` = %d AND `name` IN ($placeholders) AND LOWER(TRIM(`value`)) = %s LIMIT 1",
			array_merge( array( (int) $form_id ), $email_names, array( $email ) )
		);
		if ( $wpdb->get_var( $query ) ) {
			return true;
		}
	}
	// Fallback: theme option (when plugin not used or as backup).
	$emails = get_option( 'tasheel_footer_subscriber_emails', array() );
	return is_array( $emails ) && in_array( $email, $emails, true );
}

/**
 * Check if the given CF7 form is the footer newsletter form (by ID or by title).
 *
 * @param WPCF7_ContactForm|null $contact_form Contact form object.
 * @return bool
 */
function tasheel_is_newsletter_cf7_form( $contact_form ) {
	if ( ! $contact_form || ! method_exists( $contact_form, 'id' ) ) {
		return false;
	}
	$form_id = (int) $contact_form->id();
	$footer_form_id = tasheel_get_footer_cf7_form_id();
	if ( $form_id && $footer_form_id && $form_id === $footer_form_id ) {
		return true;
	}
	// Fallback: identify by form title (CF7 form title in admin).
	if ( method_exists( $contact_form, 'title' ) ) {
		$title = $contact_form->title();
		if ( is_string( $title ) && trim( $title ) !== '' ) {
			$t = strtolower( trim( $title ) );
			if ( $t === 'news letter form' || $t === 'newsletter form' || $t === 'newsletter' || strpos( $t, 'newsletter' ) !== false ) {
				return true;
			}
		}
	}
	return false;
}

/**
 * Contact Form 7 – Advanced field validation (text, email, tel, url, textarea).
 */
add_filter( 'wpcf7_validate_text', 'tasheel_cf7_field_specific_validation', 10, 2 );
add_filter( 'wpcf7_validate_text*', 'tasheel_cf7_field_specific_validation', 10, 2 );
add_filter( 'wpcf7_validate_email', 'tasheel_cf7_field_specific_validation', 10, 2 );
add_filter( 'wpcf7_validate_email*', 'tasheel_cf7_field_specific_validation', 10, 2 );
add_filter( 'wpcf7_validate_tel', 'tasheel_cf7_field_specific_validation', 10, 2 );
add_filter( 'wpcf7_validate_tel*', 'tasheel_cf7_field_specific_validation', 10, 2 );
add_filter( 'wpcf7_validate_url', 'tasheel_cf7_field_specific_validation', 10, 2 );
add_filter( 'wpcf7_validate_url*', 'tasheel_cf7_field_specific_validation', 10, 2 );
add_filter( 'wpcf7_validate_textarea', 'tasheel_cf7_field_specific_validation', 10, 2 );
add_filter( 'wpcf7_validate_textarea*', 'tasheel_cf7_field_specific_validation', 10, 2 );

/**
 * Contact Form 7 – Select validation: show "Please select an option" when placeholder is left selected.
 */
add_filter( 'wpcf7_validate_select', 'tasheel_cf7_validate_select', 10, 2 );
add_filter( 'wpcf7_validate_select*', 'tasheel_cf7_validate_select', 10, 2 );
add_filter( 'wpcf7_validate_file', 'tasheel_cf7_validate_file', 10, 2 );
add_filter( 'wpcf7_validate_file*', 'tasheel_cf7_validate_file', 10, 2 );

/**
 * Shared validation for text, email, tel, url, textarea.
 *
 * @param WPCF7_Validation $result Result object.
 * @param WPCF7_FormTag    $tag    Form tag.
 * @return WPCF7_Validation
 */
function tasheel_cf7_field_specific_validation( $result, $tag ) {
	if ( ! is_object( $result ) || ! is_object( $tag ) || ! isset( $tag->name ) ) {
		return $result;
	}
	if ( ! method_exists( $result, 'invalidate' ) ) {
		return $result;
	}
	// Run vendor conditional required validation once per submission.
	tasheel_cf7_validate_vendor_conditionals( $result );
	$name = $tag->name;
	$raw  = isset( $_POST[ $name ] ) ? $_POST[ $name ] : '';
	if ( is_array( $raw ) ) {
		return $result;
	}
	$value = trim( (string) $raw );
	if ( $value === '' ) {
		return $result;
	}

	// Global security: block script/HTML tags.
	if ( preg_match( '/<\s*(script|iframe|style|object|embed|link|meta).*?>/i', $value ) ) {
		$result->invalidate( $tag, __( 'Invalid characters detected.', 'tasheel' ) );
		return $result;
	}
	// Block obvious SQL-style payloads (omit "select" to avoid blocking normal wording).
	if ( preg_match( '/\b(insert|update|delete|drop|truncate|alter|union|create|replace)\b|(--|#|\/\*|\*\/|;)/ix', $value ) ) {
		$result->invalidate( $tag, __( 'Invalid input detected.', 'tasheel' ) );
		return $result;
	}

	// Name fields – letters, spaces & hyphens only.
	if ( in_array( $name, array( 'first_name', 'last_name', 'full_name', 'your-name' ), true ) ) {
		if ( ! preg_match( '/^[a-zA-Z\s\-]{2,50}$/', $value ) ) {
			$result->invalidate( $tag, __( 'Only letters, spaces and hyphens are allowed.', 'tasheel' ) );
			return $result;
		}
	}

	// City – letters & spaces only.
	if ( $name === 'city' ) {
		if ( ! preg_match( '/^[a-zA-Z\s]{2,50}$/', $value ) ) {
			$result->invalidate( $tag, __( 'City name should contain letters only.', 'tasheel' ) );
			return $result;
		}
	}

	// Vendor: phone – digits and optional + ( ) - space; state length in message.
	if ( in_array( $name, array( 'contact_phone', 'secondary_contact_phone' ), true ) ) {
		if ( ! preg_match( '/^\+?[0-9\s\-\(\)]{7,15}$/', $value ) ) {
			$result->invalidate( $tag, __( 'Please enter a valid phone number (7–15 digits).', 'tasheel' ) );
			return $result;
		}
	}

	// Phone number (other forms).
	if ( in_array( $name, array( 'phone_number', 'phone', 'your-phone' ), true ) ) {
		if ( ! preg_match( '/^\+?[0-9\s\-\(\)]{7,15}$/', $value ) ) {
			$result->invalidate( $tag, __( 'Please enter a valid phone number (7–15 digits).', 'tasheel' ) );
			return $result;
		}
	}

	// Legal entity name (vendor form): letters only; company (contact) allows numbers.
	if ( $name === 'legal_entity_name' ) {
		if ( ! preg_match( '/^[a-zA-Z\s\-\.&,]{2,100}$/', $value ) ) {
			$result->invalidate( $tag, __( 'Please enter letters only (no numbers or special characters).', 'tasheel' ) );
			return $result;
		}
	}
	// Company name (contact form).
	if ( $name === 'your-company' ) {
		if ( ! preg_match( '/^[a-zA-Z0-9\s\-\.&,]{2,100}$/', $value ) ) {
			$result->invalidate( $tag, __( 'Please enter a valid company name.', 'tasheel' ) );
			return $result;
		}
	}

	// Vendor: address fields – letters, numbers, spaces, commas, periods, hyphens, slashes.
	if ( in_array( $name, array( 'headquarter_address', 'other_branches' ), true ) ) {
		if ( ! preg_match( '/^[a-zA-Z0-9\s\-\.&,\/]{2,300}$/', $value ) ) {
			$result->invalidate( $tag, __( 'Please enter a valid address (letters, numbers and common punctuation only).', 'tasheel' ) );
			return $result;
		}
	}

	// Vendor: contact names and positions – letters, spaces, hyphens only.
	if ( in_array( $name, array( 'contact_name', 'contact_position', 'secondary_contact_name', 'secondary_contact_position' ), true ) ) {
		if ( ! preg_match( '/^[a-zA-Z\s\-]{2,100}$/', $value ) ) {
			$result->invalidate( $tag, __( 'Please enter letters only (no numbers or special characters).', 'tasheel' ) );
			return $result;
		}
	}

	// Vendor: role at project – letters and spaces only.
	if ( $name === 'role_at_project' ) {
		if ( ! preg_match( '/^[a-zA-Z\s\-]{2,150}$/', $value ) ) {
			$result->invalidate( $tag, __( 'Please enter letters only (no numbers or special characters).', 'tasheel' ) );
			return $result;
		}
	}

	// Vendor: year of completion – valid 4-digit year (e.g. 1900–current+1).
	if ( $name === 'year_of_completion' ) {
		$year = (int) $value;
		$current = (int) gmdate( 'Y' );
		if ( $year < 1900 || $year > $current + 1 ) {
			$result->invalidate( $tag, __( 'Please enter a valid year (e.g. 2023).', 'tasheel' ) );
			return $result;
		}
	}

	// Vendor: revenue years – numbers only.
	if ( in_array( $name, array( 'cert_year_2024', 'cert_year_2023', 'cert_year_2022' ), true ) ) {
		if ( ! preg_match( '/^[0-9]+$/', $value ) ) {
			$result->invalidate( $tag, __( 'Please enter a valid number (digits only).', 'tasheel' ) );
			return $result;
		}
	}

	// Company website (vendor form) – length only; CF7 validates URL format.
	if ( $name === 'company_website' && strlen( $value ) > 500 ) {
		$result->invalidate( $tag, __( 'URL is too long.', 'tasheel' ) );
		return $result;
	}

	// Service fields.
	if ( in_array( $name, array( 'service_required', 'service' ), true ) ) {
		if ( ! preg_match( '/^[a-zA-Z0-9\s\-\.&,()]{2,100}$/', $value ) ) {
			$result->invalidate( $tag, __( 'Please enter a valid service name.', 'tasheel' ) );
			return $result;
		}
	}

	// Message fields.
	if ( in_array( $name, array( 'your-message', 'message' ), true ) ) {
		if ( strlen( $value ) < 10 ) {
			$result->invalidate( $tag, __( 'Message must be at least 10 characters long.', 'tasheel' ) );
			return $result;
		}
		if ( strlen( $value ) > 2000 ) {
			$result->invalidate( $tag, __( 'Message must not exceed 2000 characters.', 'tasheel' ) );
			return $result;
		}
	}

	// Email length and footer subscribe duplicate check.
	if ( in_array( $name, array( 'email', 'Email', 'your-email', 'subscriber-email', 'contact_email', 'secondary_contact_email' ), true ) ) {
		if ( strlen( $value ) > 100 ) {
			$result->invalidate( $tag, __( 'Email address is too long.', 'tasheel' ) );
			return $result;
		}
		// Footer newsletter form: block duplicate email subscriptions.
		if ( class_exists( 'WPCF7_Submission' ) ) {
			$submission   = WPCF7_Submission::get_instance();
			$contact_form = $submission ? $submission->get_contact_form() : null;
			$form_id      = 0;
			if ( $contact_form && method_exists( $contact_form, 'id' ) ) {
				$form_id = (int) $contact_form->id();
			}
			if ( ! $form_id && ! empty( $_POST['_wpcf7'] ) ) {
				$form_id = (int) $_POST['_wpcf7'];
			}
			$is_newsletter = ( $contact_form && tasheel_is_newsletter_cf7_form( $contact_form ) )
				|| ( $form_id && $form_id === tasheel_get_footer_cf7_form_id() );
			if ( $is_newsletter && tasheel_newsletter_email_already_submitted( $form_id ? $form_id : tasheel_get_footer_cf7_form_id(), $value ) ) {
				$result->invalidate( $tag, __( 'This email has already been submitted. Please use a different email address.', 'tasheel' ) );
				return $result;
			}
		}
	}

	// LinkedIn URL.
	if ( $name === 'linkedin_url' && $value !== '' ) {
		$linkedin_pattern = '#^https?:\/\/(www\.)?linkedin\.com\/(in|company)\/[a-zA-Z0-9\-_%]+\/?$#';
		if ( ! preg_match( $linkedin_pattern, $value ) ) {
			$result->invalidate( $tag, __( 'Please enter a valid LinkedIn profile or company URL.', 'tasheel' ) );
			return $result;
		}
	}

	return $result;
}

/**
 * Vendor registration form: require conditional fields when Yes is chosen.
 * Runs once per submission; only applies when trigger fields are present (vendor form).
 *
 * @param WPCF7_Validation $result Validation result.
 */
function tasheel_cf7_validate_vendor_conditionals( $result ) {
	static $done = false;
	if ( $done || ! is_object( $result ) || ! method_exists( $result, 'invalidate' ) ) {
		return;
	}
	if ( ! class_exists( 'WPCF7_Submission' ) ) {
		return;
	}
	$submission = WPCF7_Submission::get_instance();
	if ( ! $submission ) {
		return;
	}
	$contact_form = $submission->get_contact_form();
	if ( ! $contact_form || ! method_exists( $contact_form, 'scan_form_tags' ) ) {
		return;
	}
	$tags = $contact_form->scan_form_tags();
	$by_name = array();
	foreach ( $tags as $t ) {
		if ( ! empty( $t->name ) ) {
			$by_name[ $t->name ] = $t;
		}
	}
	$done = true;

	$get = function( $name ) {
		return isset( $_POST[ $name ] ) ? trim( (string) $_POST[ $name ] ) : '';
	};
	$get_file = function( $name ) {
		return ( isset( $_FILES[ $name ]['name'] ) && $_FILES[ $name ]['name'] !== '' ) ? $_FILES[ $name ]['name'] : '';
	};

	// VAT: if "Yes" then vat_number and vat_number_file required.
	$vat = strtolower( $get( 'vat_registered' ) );
	if ( $vat === 'yes' ) {
		if ( $get( 'vat_number' ) === '' && isset( $by_name['vat_number'] ) ) {
			$result->invalidate( $by_name['vat_number'], __( 'Please fill out this field.', 'tasheel' ) );
		}
		if ( $get_file( 'vat_number_file' ) === '' && isset( $by_name['vat_number_file'] ) ) {
			$result->invalidate( $by_name['vat_number_file'], __( 'Please upload a file.', 'tasheel' ) );
		}
	}

	// Local content certificate: if "Yes" then file required (field may be local_content_certificate_file or company_profile_02_file).
	$local = strtolower( $get( 'local_content_certificate' ) );
	if ( $local === 'yes' ) {
		$local_file_name = isset( $by_name['local_content_certificate_file'] ) ? 'local_content_certificate_file' : 'company_profile_02_file';
		if ( $get_file( $local_file_name ) === '' && isset( $by_name[ $local_file_name ] ) ) {
			$result->invalidate( $by_name[ $local_file_name ], __( 'Please upload a file.', 'tasheel' ) );
		}
	}

	// Worked with SAUDCONSULT: if "Yes" then project_name, role_at_project, year_of_completion required.
	$saud = strtolower( $get( 'worked_with_saudconsult' ) );
	if ( $saud === 'yes' ) {
		if ( $get( 'project_name' ) === '' && isset( $by_name['project_name'] ) ) {
			$result->invalidate( $by_name['project_name'], __( 'Please fill out this field.', 'tasheel' ) );
		}
		if ( $get( 'role_at_project' ) === '' && isset( $by_name['role_at_project'] ) ) {
			$result->invalidate( $by_name['role_at_project'], __( 'Please fill out this field.', 'tasheel' ) );
		}
		if ( $get( 'year_of_completion' ) === '' && isset( $by_name['year_of_completion'] ) ) {
			$result->invalidate( $by_name['year_of_completion'], __( 'Please fill out this field.', 'tasheel' ) );
		}
	}

	// ISO certificates: if "Yes" then iso_cert_file required.
	$iso = strtolower( $get( 'has_iso_cert' ) );
	if ( $iso === 'yes' && $get_file( 'iso_cert_file' ) === '' && isset( $by_name['iso_cert_file'] ) ) {
		$result->invalidate( $by_name['iso_cert_file'], __( 'Please upload a file.', 'tasheel' ) );
	}
}

/**
 * Select validation: treat placeholder options as "not selected" and show error.
 * Kept minimal to avoid breaking form submit.
 *
 * @param WPCF7_Validation $result Result object.
 * @param WPCF7_FormTag    $tag    Form tag.
 * @return WPCF7_Validation
 */
function tasheel_cf7_validate_select( $result, $tag ) {
	if ( ! is_object( $result ) || ! is_object( $tag ) || ! isset( $tag->name ) ) {
		return $result;
	}
	if ( ! method_exists( $result, 'invalidate' ) ) {
		return $result;
	}
	$name = $tag->name;
	$raw  = isset( $_POST[ $name ] ) ? $_POST[ $name ] : '';
	if ( is_array( $raw ) ) {
		$raw = array_filter( array_map( 'trim', array_map( 'strval', $raw ) ) );
		$value = implode( ',', $raw );
	} else {
		$value = trim( (string) $raw );
	}
	$value_lower = strtolower( $value );
	$placeholders = array( 'select', '(select all that applied) *', '(select all that applied)' );
	$is_placeholder = ( $value === '' || $value_lower === 'select' || in_array( $value_lower, $placeholders, true ) );

	if ( $is_placeholder ) {
		$result->invalidate( $tag, 'Please select an option.' );
	}
	return $result;
}

/**
 * Contact Form 7 – File upload: clearer validation message (allowed types and max size).
 *
 * @param WPCF7_Validation $result Result object.
 * @param WPCF7_FormTag    $tag    Form tag.
 * @return WPCF7_Validation
 */
function tasheel_cf7_validate_file( $result, $tag ) {
	if ( ! is_object( $result ) || ! is_object( $tag ) || ! isset( $tag->name ) ) {
		return $result;
	}
	if ( ! method_exists( $result, 'invalidate' ) ) {
		return $result;
	}
	$name = $tag->name;
	$file = isset( $_FILES[ $name ] ) && is_array( $_FILES[ $name ] ) ? $_FILES[ $name ] : null;
	if ( ! $file || empty( $file['name'] ) || ! is_string( $file['name'] ) ) {
		return $result;
	}
	$allowed_types = array( 'pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png' );
	$ext = strtolower( pathinfo( $file['name'], PATHINFO_EXTENSION ) );
	if ( ! in_array( $ext, $allowed_types, true ) ) {
		$result->invalidate( $tag, __( 'Please upload a PDF, DOC, DOCX, JPG, JPEG or PNG file (max 5MB).', 'tasheel' ) );
		return $result;
	}
	$max_bytes = 5 * 1024 * 1024;
	if ( isset( $file['size'] ) && (int) $file['size'] > $max_bytes ) {
		$result->invalidate( $tag, __( 'File is too large. Please upload a file up to 5MB. Allowed types: PDF, DOC, DOCX, JPG, PNG.', 'tasheel' ) );
		return $result;
	}
	return $result;
}

/**
 * Replace generic CF7 validation message with a clearer one.
 * Filter only receives 2 parameters: $message and $status.
 *
 * @param string $message Current message.
 * @param string $status  Validation status (e.g. 'validation_failed', 'validation_error').
 * @return string
 */
function tasheel_cf7_validation_error_message( $message, $status ) {
	$is_validation_error = ( $status === 'validation_failed' || $status === 'validation_error' );
	if ( $is_validation_error && is_string( $message ) && strpos( $message, 'One or more fields' ) !== false ) {
		return __( 'Please correct the errors below and try again. Check each field for the required format.', 'tasheel' );
	}
	return $message;
}
add_filter( 'wpcf7_display_message', 'tasheel_cf7_validation_error_message', 10, 2 );


/**
 * On footer newsletter form submit (before send), store the email to block duplicate subscriptions.
 * Uses wpcf7_before_send_mail so we have the submission object; saves once per successful validation.
 *
 * @param WPCF7_ContactForm $contact_form The form being submitted.
 * @param bool              $abort       Not used; set true to abort mail.
 * @param WPCF7_Submission   $submission  The submission instance (CF7 5.4+).
 */
function tasheel_cf7_footer_newsletter_save_email( $contact_form, $abort, $submission ) {
	if ( ! $contact_form || ! tasheel_is_newsletter_cf7_form( $contact_form ) ) {
		return;
	}
	$posted = array();
	if ( $submission && method_exists( $submission, 'get_posted_data' ) ) {
		$posted = $submission->get_posted_data();
	}
	if ( empty( $posted ) && class_exists( 'WPCF7_Submission' ) ) {
		$sub = WPCF7_Submission::get_instance();
		if ( $sub && method_exists( $sub, 'get_posted_data' ) ) {
			$posted = $sub->get_posted_data();
		}
	}
	if ( empty( $posted ) && ! empty( $_POST ) ) {
		$posted = wp_unslash( $_POST );
	}
	$email = '';
	$email_keys = array( 'Email', 'email', 'your-email', 'subscriber-email', 'your_email' );
	foreach ( $email_keys as $key ) {
		if ( ! empty( $posted[ $key ] ) && is_string( $posted[ $key ] ) ) {
			$email = trim( $posted[ $key ] );
			break;
		}
	}
	if ( $email === '' || ! is_email( $email ) ) {
		return;
	}
	$email = strtolower( $email );
	$emails = get_option( 'tasheel_footer_subscriber_emails', array() );
	if ( ! is_array( $emails ) ) {
		$emails = array();
	}
	if ( ! in_array( $email, $emails, true ) ) {
		$emails[] = $email;
		update_option( 'tasheel_footer_subscriber_emails', $emails, false );
	}
}
add_action( 'wpcf7_before_send_mail', 'tasheel_cf7_footer_newsletter_save_email', 10, 3 );

/**
 * Fallback: save newsletter email again on mail_sent (in case before_send_mail had no submission).
 * Reads email from $_POST so it works even when get_posted_data() is empty.
 */
function tasheel_cf7_footer_newsletter_save_email_on_mail_sent( $contact_form ) {
	if ( ! $contact_form || ! tasheel_is_newsletter_cf7_form( $contact_form ) ) {
		return;
	}
	$email = '';
	foreach ( array( 'Email', 'email', 'your-email', 'subscriber-email', 'your_email' ) as $key ) {
		if ( ! empty( $_POST[ $key ] ) && is_string( $_POST[ $key ] ) ) {
			$email = trim( sanitize_text_field( wp_unslash( $_POST[ $key ] ) ) );
			break;
		}
	}
	if ( $email === '' || ! is_email( $email ) ) {
		return;
	}
	$email = strtolower( $email );
	$emails = get_option( 'tasheel_footer_subscriber_emails', array() );
	if ( ! is_array( $emails ) ) {
		$emails = array();
	}
	if ( ! in_array( $email, $emails, true ) ) {
		$emails[] = $email;
		update_option( 'tasheel_footer_subscriber_emails', $emails, false );
	}
}
add_action( 'wpcf7_mail_sent', 'tasheel_cf7_footer_newsletter_save_email_on_mail_sent', 10, 1 );

// =========
/**
 * Vendor registration form: replace any CF7 [radio] markup with the desired HTML structure.
 * No hardcoded field names or options — parses whatever CF7 outputs so current and future
 * radio fields get the same structure: .vendor_radio_options > label.vendor_radio_option >
 * input + .vendor_radio_custom + .vendor_radio_text.
 */
/**
 * Vendor registration form: replace any CF7 [radio] markup with the desired HTML structure.
 * No hardcoded field names or options — parses whatever CF7 outputs so current and future
 * radio fields get the same structure: .vendor_radio_options > label.vendor_radio_option >
 * input + .vendor_radio_custom + .vendor_radio_text.
 */
function tasheel_cf7_vendor_radio_styled_markup( $content ) {
	if ( strpos( $content, 'wpcf7-radio' ) === false || strpos( $content, 'vendor_radio_options' ) === false ) {
		return $content;
	}
	$pattern = '/<span([^>]*data-name="([^"]+)"[^>]*)>\s*<span[^>]*wpcf7-radio[^>]*>((?:<span[^>]*wpcf7-list-item[^>]*>[\s\S]*?<\/span>\s*)+)<\/span>\s*<\/span>/i';
	$content = preg_replace_callback( $pattern, function ( $m ) {
		$wrap_attrs = $m[1];
		$name      = $m[2];
		$list_html = $m[3];
		$list_item_pattern = '/<span[^>]*wpcf7-list-item[^>]*>([\s\S]*?)<\/span>\s*/i';
		if ( ! preg_match_all( $list_item_pattern, $list_html, $items, PREG_SET_ORDER ) ) {
			return $m[0];
		}
		$inner = '';
		foreach ( $items as $item ) {
			$block = $item[1];
			$value = '';
			if ( preg_match( '/<input[^>]*\svalue=["\']([^"\']*)["\'][^>]*>/i', $block, $v ) ) {
				$value = $v[1];
			} elseif ( preg_match( '/\svalue=["\']([^"\']*)["\']/i', $block, $v ) ) {
				$value = $v[1];
			}
			$checked = (bool) preg_match( '/<input[^>]*\bchecked\b[^>]*>/i', $block );
			$label   = '';
			if ( preg_match( '/<span[^>]*wpcf7-list-item-label[^>]*>([\s\S]*?)<\/span>/i', $block, $l ) ) {
				$label = trim( wp_strip_all_tags( $l[1] ) );
			}
			if ( $label === '' && preg_match( '/<input[^>]*>[\s\S]*?<span[^>]*>([\s\S]*?)<\/span>/i', $block, $l ) ) {
				$label = trim( wp_strip_all_tags( $l[1] ) );
			}
			// Fallback: use value as display text so labels always show (e.g. if CF7 structure differs).
			if ( $label === '' && $value !== '' ) {
				$label = $value;
			}
			$chk     = $checked ? ' checked' : '';
			$inner  .= '<label class="vendor_radio_option"><input type="radio" name="' . esc_attr( $name ) . '" value="' . esc_attr( $value ) . '"' . $chk . ' required><span class="vendor_radio_custom"></span><span class="vendor_radio_text">' . esc_html( $label ) . '</span></label>';
		}
		return '<span' . $wrap_attrs . '>' . $inner . '</span>';
	}, $content );
	return $content;
}
add_filter( 'wpcf7_form_elements', 'tasheel_cf7_vendor_radio_styled_markup', 25 );


add_action('wp_footer', function() {
    ?>
    <style>
    /* Only for vendor registration form */
    form.vendor_registration_form .select-wrapper .wpcf7-form-control-wrap,
    form.vendor_registration_form .vendor_input_with_button .wpcf7-form-control-wrap {
        display: contents;
    }
	/* Hide multi-select until SumoSelect initializes */
form.vendor_registration_form select[multiple] {
    visibility: hidden;
}
form.vendor_registration_form .SumoSelect {
    visibility: visible;
}

    </style>
	<script>
    (function() {
        function initVendorSumoSelect() {
            var form = document.querySelector('form.vendor_registration_form');
            if (!form || typeof jQuery === 'undefined' || !jQuery.fn.SumoSelect) return;
            form.querySelectorAll('select.select-input').forEach(function(sel) {
                if (sel.hasAttribute('data-sumo-select-initialized')) return;
                sel.setAttribute('data-sumo-select-initialized', 'true');
                var label = sel.closest('li') ? sel.closest('li').querySelector('label') : null;
                var isMulti = label && label.textContent.toLowerCase().indexOf('select all that applied') !== -1;
                if (isMulti && !sel.hasAttribute('multiple')) sel.setAttribute('multiple', 'multiple');
                jQuery(sel).SumoSelect({
                    placeholder: sel.getAttribute('multiple') ? '(Select all that applied)' : 'Select',
                    captionFormat: '{0} Selected',
                    captionFormatAllSelected: 'All selected',
                    floatWidth: 0, forceCustomRendering: false,
                    nativeOnDevice: ['Android', 'BlackBerry', 'iPhone', 'iPad', 'iPod', 'Opera Mini', 'IEMobile', 'Silk'],
                    okCancelInMulti: true, selectAll: isMulti, search: isMulti,
                    searchText: 'Search...', noMatch: 'No matches for "{0}"',
                    isClickAwayOk: true, triggerChangeCombined: true,
                    selectAlltext: 'Select All', locale: ['OK', 'Cancel', 'Select All']
                });
            });
        }
        document.addEventListener('wpcf7mailsent', function() {
            var form = document.querySelector('form.vendor_registration_form');
            if (!form) return;
            form.reset();
            if (typeof jQuery !== 'undefined' && jQuery.fn.SumoSelect) {
                form.querySelectorAll('select.select-input').forEach(function(sel) {
                    try { if (sel.sumo) sel.sumo.unload(); } catch (e) {}
                    sel.removeAttribute('data-sumo-select-initialized');
                });
                setTimeout(initVendorSumoSelect, 150);
            }
        });
        document.addEventListener('wpcf7invalid', function(ev) {
            setTimeout(function() {
                var form = (ev && ev.detail && ev.detail.unitTag) ? document.querySelector('form[data-unit-tag="' + ev.detail.unitTag + '"]') || document.querySelector('form.vendor_registration_form') : document.querySelector('form.vendor_registration_form');
                if (!form) return;
                var first = form.querySelector('.wpcf7-not-valid') || form.querySelector('.wpcf7-not-valid-tip') || form.querySelector('.wpcf7-form-control-wrap.wpcf7-not-valid');
                if (first) first.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }, 150);
        });
    })();
    </script>
    <?php
});


// change cf7 multi select - start

function enqueue_sumo_cf7() {
    // Enqueue SumoSelect CSS & JS on all pages (or just where needed)
    wp_enqueue_style('sumoselect-css', 'https://cdnjs.cloudflare.com/ajax/libs/jquery.sumoselect/3.0.2/sumoselect.min.css');
    wp_enqueue_script('sumoselect-js', 'https://cdnjs.cloudflare.com/ajax/libs/jquery.sumoselect/3.0.2/jquery.sumoselect.min.js', array('jquery'), null, true);

    // Initialize SumoSelect for vendor_registration_form if it exists
    wp_add_inline_script('sumoselect-js', "
        function initVendorSumo(){
            var form = document.querySelector('form.vendor_registration_form');
            if(form){
                jQuery(form).find('select[multiple]').each(function(){
                    if(!jQuery(this).hasClass('SumoSelect')) { // prevent double init
                        jQuery(this).SumoSelect({
                            placeholder: 'Select options',
                            search: true,
                            selectAll: true,
                            captionFormatAllSelected: 'All Selected',
                            csvDispCount: 3,
                            okCancelInMulti: true,
                            searchText: 'Search...'
                        });
                    }
                });
            } else {
                // retry in 500ms if form not yet loaded (CF7 AJAX forms)
                setTimeout(initVendorSumo, 500);
            }
        }
        document.addEventListener('DOMContentLoaded', initVendorSumo);
    ");
}
add_action('wp_enqueue_scripts', 'enqueue_sumo_cf7');


// change cf7 multi select - end



/**
 * Optimize ACF relationship field queries to prevent gateway timeout on save.
 * Limits partners_manual (and similar) fields to avoid loading thousands of posts.
 */
function tasheel_acf_relationship_query_optimize( $args, $field, $post_id ) {
	if ( isset( $field['name'] ) && 'partners_manual' === $field['name'] ) {
		$args['posts_per_page']      = 100;
		$args['no_found_rows']       = true;
		$args['update_post_meta_cache'] = false;
		$args['update_post_term_cache'] = false;
	}
	return $args;
}
add_filter( 'acf/fields/relationship/query', 'tasheel_acf_relationship_query_optimize', 10, 3 );

/**
 * Convert Western digits (0-9) to Eastern Arabic numerals (٠-٩) when current language is Arabic.
 * Use for date display and other numbers on Arabic frontend.
 *
 * @param string $string Text that may contain digits.
 * @return string Same string with digits converted to Eastern Arabic numerals when locale is Arabic.
 */
function tasheel_arabic_numerals( $string ) {
	if ( ! is_string( $string ) || $string === '' ) {
		return $string;
	}
	$locale = get_locale();
	$lang   = function_exists( 'apply_filters' ) ? apply_filters( 'wpml_current_language', $locale ) : $locale;
	$is_ar  = ( is_string( $lang ) && strpos( $lang, 'ar' ) === 0 ) || ( is_string( $locale ) && strpos( $locale, 'ar' ) === 0 );
	if ( ! $is_ar ) {
		return $string;
	}
	$western = array( '0', '1', '2', '3', '4', '5', '6', '7', '8', '9' );
	$eastern = array( '٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩' );
	return str_replace( $western, $eastern, $string );
}


/**
 * Get a page's URL and title by template (for breadcrumbs). Like get_the_title() for link + label.
 *
 * @param string $template Filename e.g. 'page-template-media-center.php'.
 * @param string $fallback_url  URL if no page found.
 * @param string $fallback_title Title if no page found (use esc_html__( 'X', 'tasheel' )).
 * @return array { 'url' => string, 'title' => string }
 */
function tasheel_get_page_by_template( $template, $fallback_url, $fallback_title ) {
	$pages = get_posts( array(
		'post_type'   => 'page',
		'meta_key'    => '_wp_page_template',
		'meta_value'  => $template,
		'numberposts' => 1,
		'post_status' => 'publish',
	) );
	if ( ! empty( $pages ) ) {
		$page_id = (int) $pages[0]->ID;
		// WPML: use the page in the current language so breadcrumb title/URL are translated.
		if ( function_exists( 'apply_filters' ) && has_filter( 'wpml_object_id' ) ) {
			$current_lang = apply_filters( 'wpml_current_language', null );
			if ( $current_lang !== null && $current_lang !== '' ) {
				$translated_id = apply_filters( 'wpml_object_id', $page_id, 'page', true, $current_lang );
				if ( $translated_id && (int) $translated_id !== $page_id ) {
					$page_id = (int) $translated_id;
				}
			}
		}
		return array( 'url' => get_permalink( $page_id ), 'title' => get_the_title( $page_id ) );
	}
	return array( 'url' => $fallback_url, 'title' => $fallback_title );
}

/** Backward compatibility: breadcrumb helpers (used by single-news/single-event for $news_list_url etc.). */
function tasheel_get_media_center_breadcrumb() {
	return tasheel_get_page_by_template( 'page-template-media-center.php', home_url( '/media-center' ), esc_html__( 'Media Center', 'tasheel' ) );
}
function tasheel_get_news_listing_breadcrumb() {
	$p = tasheel_get_page_by_template( 'page-template-news.php', home_url( '/news' ), esc_html__( 'News', 'tasheel' ) );
	if ( $p['url'] === home_url( '/news' ) && post_type_exists( 'news' ) && get_option( 'permalink_structure' ) ) {
		$archive = get_post_type_archive_link( 'news' );
		if ( $archive ) {
			$p['url'] = $archive;
		}
	}
	return $p;
}
function tasheel_get_events_listing_breadcrumb() {
	$p = tasheel_get_page_by_template( 'page-template-events.php', home_url( '/events' ), esc_html__( 'Events', 'tasheel' ) );
	if ( $p['url'] === home_url( '/events' ) && post_type_exists( 'event' ) && get_option( 'permalink_structure' ) ) {
		$archive = get_post_type_archive_link( 'event' );
		if ( $archive ) {
			$p['url'] = $archive;
		}
	}
	return $p;
}

/**
 * Get project info items for display from basic_info_items repeater.
 *
 * @param int $project_id Project post ID.
 * @return array Array of { 'label' => string, 'value' => string }.
 */
function tasheel_get_project_info_items( $project_id ) {
	$empty_placeholder = '—';
	$items_repeater    = function_exists( 'get_field' ) ? get_field( 'basic_info_items', $project_id ) : array();
	$items_repeater    = is_array( $items_repeater ) ? $items_repeater : array();

	$sector_val = $empty_placeholder;
	$sector_ids = function_exists( 'get_field' ) ? get_field( 'sector', $project_id ) : array();
	if ( ! empty( $sector_ids ) ) {
		$sector_ids = is_array( $sector_ids ) ? $sector_ids : array( $sector_ids );
		$titles     = array();
		foreach ( $sector_ids as $sid ) {
			$t = get_the_title( $sid );
			if ( $t ) {
				$titles[] = $t;
			}
		}
		if ( ! empty( $titles ) ) {
			$sector_val = implode( ', ', $titles );
		}
	}
	$locations_val = $empty_placeholder;
	$locations     = wp_get_post_terms( $project_id, 'project_location', array( 'fields' => 'names' ) );
	if ( ! empty( $locations ) ) {
		$locations_val = implode( ', ', $locations );
	}

	if ( ! empty( $items_repeater ) ) {
		$items = array();
		foreach ( $items_repeater as $row ) {
			$type  = isset( $row['field_type'] ) ? $row['field_type'] : 'custom';
			$label = isset( $row['label'] ) ? trim( (string) $row['label'] ) : '';
			if ( ! $label ) {
				continue;
			}
			$value = '';
			if ( $type === 'sectors' ) {
				$value = $sector_val;
			} elseif ( $type === 'locations' ) {
				$value = $locations_val;
			} else {
				$value = isset( $row['value'] ) ? trim( (string) $row['value'] ) : $empty_placeholder;
			}
			$items[] = array(
				'label' => apply_filters( 'wpml_translate_single_string', $label, 'ACF', 'project_info_label_' . $project_id ),
				'value' => apply_filters( 'wpml_translate_single_string', $value, 'ACF', 'project_info_value_' . $project_id ),
			);
		}
		return $items;
	}

	// Fallback when repeater is empty: show default labels with placeholders
	return array(
		array( 'label' => __( 'Client', 'tasheel' ), 'value' => $empty_placeholder ),
		array( 'label' => __( 'Sectors', 'tasheel' ), 'value' => $sector_val ),
		array( 'label' => __( 'Locations', 'tasheel' ), 'value' => $locations_val ),
		array( 'label' => __( 'Cost', 'tasheel' ), 'value' => $empty_placeholder ),
		array( 'label' => __( 'Length of Road', 'tasheel' ), 'value' => $empty_placeholder ),
	);
}


/**
 * Breadcrumb items for News/Events pages. One call: pass context and optional args.
 *
 * @param string $context 'news_listing'|'events_listing'|'single_news'|'single_event'|'news_detail_page'|'event_detail_page'
 * @param array  $args    'page_id' => int (listing), 'title' => string (single/detail)
 * @return array Items for template-parts/Breadcrumb.
 */
function tasheel_get_listing_breadcrumb_items( $context, $args = array() ) {
	$args  = wp_parse_args( $args, array( 'page_id' => 0, 'title' => '' ) );
	$mc    = tasheel_get_media_center_breadcrumb();
	$news  = tasheel_get_news_listing_breadcrumb();
	$events = tasheel_get_events_listing_breadcrumb();

	$trails = array(
		'news_listing'     => array( array( 'title' => ( $args['page_id'] && get_post_status( $args['page_id'] ) === 'publish' ) ? get_the_title( $args['page_id'] ) : $news['title'], 'url' => '' ) ),
		'events_listing'   => array( array( 'title' => ( $args['page_id'] && get_post_status( $args['page_id'] ) === 'publish' ) ? get_the_title( $args['page_id'] ) : $events['title'], 'url' => '' ) ),
		'single_news'      => array( array( 'title' => $news['title'], 'url' => esc_url( $news['url'] ) ), array( 'title' => $args['title'] !== '' ? $args['title'] : get_the_title(), 'url' => '' ) ),
		'single_event'     => array( array( 'title' => $events['title'], 'url' => esc_url( $events['url'] ) ), array( 'title' => $args['title'] !== '' ? $args['title'] : get_the_title(), 'url' => '' ) ),
		'news_detail_page' => array( array( 'title' => $news['title'], 'url' => esc_url( $news['url'] ) ), array( 'title' => $args['title'] !== '' ? $args['title'] : get_the_title(), 'url' => '' ) ),
		'event_detail_page'=> array( array( 'title' => $events['title'], 'url' => esc_url( $events['url'] ) ), array( 'title' => $args['title'] !== '' ? $args['title'] : get_the_title(), 'url' => '' ) ),
	);

	if ( ! isset( $trails[ $context ] ) ) {
		return array();
	}
	$base = array(
		array( 'url' => esc_url( home_url( '/' ) ), 'icon' => true ),
		array( 'title' => $mc['title'], 'url' => esc_url( $mc['url'] ) ),
	);
	return array_merge( $base, $trails[ $context ] );
}



/**
 * AJAX: Load more news – returns HTML of news list items for appending to #news-list.
 * Respects lang parameter so Arabic page loads only Arabic posts, English only English.
 */
function tasheel_ajax_load_more_news() {
	$nonce = isset( $_REQUEST['nonce'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['nonce'] ) ) : '';
	if ( ! wp_verify_nonce( $nonce, 'tasheel_load_more_news' ) ) {
		wp_send_json_error( array( 'message' => __( 'Security check failed.', 'tasheel' ) ) );
	}
	$page     = isset( $_REQUEST['page'] ) ? max( 1, (int) $_REQUEST['page'] ) : 1;
	$per_page = isset( $_REQUEST['per_page'] ) ? max( 1, min( 50, (int) $_REQUEST['per_page'] ) ) : 12;
	$offset   = ( $page - 1 ) * $per_page;
	$lang     = isset( $_REQUEST['lang'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['lang'] ) ) : '';

	// Switch to requested language so WPML returns only posts in that language.
	if ( $lang !== '' && has_action( 'wpml_switch_language' ) ) {
		do_action( 'wpml_switch_language', $lang );
	}

	$news_result = array( 'items' => array(), 'found_posts' => 0 );
	if ( function_exists( 'tasheel_get_media_center_news' ) ) {
		$news_result = tasheel_get_media_center_news( $per_page, 'listing', $offset, true );
	}
	if ( empty( $news_result['items'] ) && post_type_exists( 'news' ) ) {
		$q = new WP_Query( array(
			'post_type'      => 'news',
			'posts_per_page' => $per_page,
			'offset'         => $offset,
			'post_status'    => 'publish',
			'orderby'        => array( 'menu_order' => 'ASC', 'date' => 'DESC' ),
			'order'          => 'DESC',
			'no_found_rows'  => false,
		) );
		$news_index = 0;
		if ( $q->have_posts() ) {
			while ( $q->have_posts() ) {
				$q->the_post();
				$pid  = get_the_ID();
				$listing_img = function_exists( 'tasheel_get_listing_page_image' ) ? tasheel_get_listing_page_image( $pid, 'news' ) : get_the_post_thumbnail_url( $pid, 'full' );
				if ( ! $listing_img ) {
					$listing_img = get_template_directory_uri() . '/assets/images/news-01.jpg';
				}
				// Load-more AJAX always has offset > 0, so never use "Latest News" here — only relative time
				$cat_label = sprintf( esc_html__( '%s ago', 'tasheel' ), human_time_diff( get_the_date( 'U' ), current_time( 'timestamp' ) ) );
				$news_result['items'][] = array(
					'image'          => $listing_img,
					'image_desktop'  => $listing_img,
					'image_mobile'   => $listing_img,
					'date_label'     => get_the_date(),
					'title'          => get_the_title(),
					'category_label' => $cat_label,
					'link'           => get_permalink(),
				);
				$news_index++;
			}
			$news_result['found_posts'] = (int) $q->found_posts;
			wp_reset_postdata();
		}
	}

	$items    = isset( $news_result['items'] ) ? $news_result['items'] : array();
	$total    = isset( $news_result['found_posts'] ) ? (int) $news_result['found_posts'] : 0;
	$has_more = $total > ( $offset + count( $items ) );

	// Build listing HTML (same structure as page-template-news.php) so it works in AJAX context
	$html = '';
	if ( ! empty( $items ) ) {
		foreach ( $items as $item ) {
			$item_link  = isset( $item['link'] ) ? esc_url( $item['link'] ) : '#';
			$item_img_d  = isset( $item['image_desktop'] ) ? $item['image_desktop'] : ( isset( $item['image'] ) ? $item['image'] : get_template_directory_uri() . '/assets/images/news-01.jpg' );
			$item_img_m  = isset( $item['image_mobile'] ) ? $item['image_mobile'] : $item_img_d;
			$item_date   = isset( $item['date_label'] ) ? $item['date_label'] : '';
			$item_title  = isset( $item['title'] ) ? $item['title'] : '';
			$item_cat    = isset( $item['category_label'] ) ? $item['category_label'] : esc_html__( 'Latest News', 'tasheel' );
			$img_tag     = '<img src="' . esc_url( $item_img_d ) . '" alt="' . esc_attr( $item_title ) . '">';
			if ( function_exists( 'tasheel_listing_image_picture' ) ) {
				ob_start();
				tasheel_listing_image_picture( $item_img_d, $item_img_m, $item_title );
				$img_tag = ob_get_clean();
			}
			$html .= '<li>';
			$html .= '<div class="insights_item">';
			$html .= '<a href="' . $item_link . '" class="insights_item_image_link">';
			$html .= '<div class="insights_item_image">';
			$html .= '<span class="latest_news_lable">' . esc_html( $item_date ) . '</span>';
			$html .= $img_tag;
			$html .= '</div></a>';
			$html .= '<div class="insights_item_content">';
			$html .= '<a href="' . $item_link . '"><h4>' . esc_html( $item_title ) . '</h4></a>';
			$html .= '<span class="latest_news_text_lable">' . esc_html( $item_cat ) . '</span>';
			$html .= '</div></div></li>';
		}
	}

	wp_send_json_success( array(
		'html'    => $html,
		'hasMore' => $has_more,
		'total'   => $total,
	) );
}
add_action( 'wp_ajax_tasheel_load_more_news', 'tasheel_ajax_load_more_news' );
add_action( 'wp_ajax_nopriv_tasheel_load_more_news', 'tasheel_ajax_load_more_news' );



/**
 * AJAX: Load more events – returns HTML of event list items for appending to #events-list.
 * Respects lang parameter so Arabic page loads only Arabic events, English only English (WPML).
 */
function tasheel_ajax_load_more_events() {
	$nonce = isset( $_REQUEST['nonce'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['nonce'] ) ) : '';
	if ( ! wp_verify_nonce( $nonce, 'tasheel_load_more_events' ) ) {
		wp_send_json_error( array( 'message' => __( 'Security check failed.', 'tasheel' ) ) );
	}
	$page     = isset( $_REQUEST['page'] ) ? max( 1, (int) $_REQUEST['page'] ) : 1;
	$per_page = isset( $_REQUEST['per_page'] ) ? max( 1, min( 50, (int) $_REQUEST['per_page'] ) ) : 12;
	$offset   = ( $page - 1 ) * $per_page;
	$lang     = isset( $_REQUEST['lang'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['lang'] ) ) : '';

	// Switch to requested language so WPML returns only events in that language.
	if ( $lang !== '' && has_action( 'wpml_switch_language' ) ) {
		do_action( 'wpml_switch_language', $lang );
	}

	$events_result = array( 'items' => array(), 'found_posts' => 0 );
	if ( function_exists( 'tasheel_get_media_center_events' ) ) {
		$events_result = tasheel_get_media_center_events( $per_page, 'listing', $offset, true );
	}
	$items    = isset( $events_result['items'] ) ? $events_result['items'] : array();
	$total    = isset( $events_result['found_posts'] ) ? (int) $events_result['found_posts'] : 0;
	$has_more = $total > ( $offset + count( $items ) );
	$html     = function_exists( 'tasheel_render_events_list_items_html' ) ? tasheel_render_events_list_items_html( $items ) : '';

	wp_send_json_success( array(
		'html'    => $html,
		'hasMore' => $has_more,
		'total'   => $total,
	) );
}
add_action( 'wp_ajax_tasheel_load_more_events', 'tasheel_ajax_load_more_events' );
add_action( 'wp_ajax_nopriv_tasheel_load_more_events', 'tasheel_ajax_load_more_events' );


/**
 * In project edit screen: show Sector (Service) options with category in brackets to avoid confusion when multiple services share the same title.
 * e.g. "Defense and Aviation (Engineering Design)" and "Defense and Aviation (Construction Supervision)"
 *
 * @param string $text   Label shown in the relationship field.
 * @param object $post   The post object (service).
 * @param array  $field  ACF field settings.
 * @param mixed  $post_id Current post ID being edited.
 * @return string
 */
function tasheel_acf_sector_relationship_result( $text, $post, $field, $post_id ) {
	if ( ! isset( $field['name'] ) || $field['name'] !== 'sector' ) {
		return $text;
	}
	if ( ! $post || ! isset( $post->post_type ) || $post->post_type !== 'service' ) {
		return $text;
	}
	if ( ! taxonomy_exists( 'service_category' ) ) {
		return $text;
	}
	$terms = get_the_terms( $post->ID, 'service_category' );
	if ( empty( $terms ) || is_wp_error( $terms ) ) {
		return $text;
	}
	$names = array();
	foreach ( $terms as $term ) {
		if ( ! empty( $term->name ) ) {
			$names[] = $term->name;
		}
	}
	if ( ! empty( $names ) ) {
		$text .= ' (' . implode( ', ', $names ) . ')';
	}
	return $text;
}
add_filter( 'acf/fields/relationship/result/name=sector', 'tasheel_acf_sector_relationship_result', 10, 4 );



/**
 * AJAX: Return a fresh nonce for the forgot-password form (avoids cached/expired nonce).
 */
function tasheel_ajax_forgot_password_get_nonce() {
	wp_send_json_success( array( 'nonce' => wp_create_nonce( 'tasheel_forgot_password' ) ) );
}
add_action( 'wp_ajax_tasheel_forgot_password_get_nonce', 'tasheel_ajax_forgot_password_get_nonce' );
add_action( 'wp_ajax_nopriv_tasheel_forgot_password_get_nonce', 'tasheel_ajax_forgot_password_get_nonce' );

/**
 * Discard output buffer before sending JSON (prevents broken response from stray output).
 */
function tasheel_forgot_password_ob_clean() {
	while ( ob_get_level() > 0 ) {
		ob_end_clean();
	}
}

/**
 * Cron: send one forgot-password email (custom key + wp_mail; no Sodium).
 */
function tasheel_do_send_forgot_password_email( $user_login ) {
	tasheel_send_one_reset_email( $user_login );
}
add_action( 'tasheel_send_forgot_password_email', 'tasheel_do_send_forgot_password_email' );

/**
 * Add a pending password-reset to the queue. Frontend triggers send via tasheel_process_reset_email_queue.
 * Also sets a short-lived transient so the follow-up request can send for this user if the queue is empty (e.g. load balancer / race).
 */
function tasheel_add_pending_reset_email( $user_login ) {
	if ( ! is_string( $user_login ) || $user_login === '' ) {
		return;
	}
	$pending = get_option( 'tasheel_pending_reset_emails', array() );
	if ( ! is_array( $pending ) ) {
		$pending = array();
	}
	$pending[] = $user_login;
	$pending = array_unique( $pending );
	update_option( 'tasheel_pending_reset_emails', $pending );
	// Allow process-queue request to send for this user even if it hits another server or sees empty queue (120s TTL).
	set_transient( 'tasheel_reset_send_' . md5( $user_login ), $user_login, 120 );
}

/**
 * Custom password reset: expiry in seconds (default 24 hours). No Sodium required.
 */
function tasheel_custom_reset_key_expiry_seconds() {
	return (int) apply_filters( 'tasheel_custom_reset_key_expiry_seconds', 24 * HOUR_IN_SECONDS );
}

/**
 * Generate and store a custom reset key for a user (uses random_bytes only – no Sodium).
 *
 * @param WP_User $user User object.
 * @return string|false Reset key (64 hex chars) or false on failure.
 */
function tasheel_set_custom_reset_key( $user ) {
	if ( ! $user || ! ( $user instanceof WP_User ) ) {
		return false;
	}
	$key = bin2hex( random_bytes( 32 ) );
	$expiry = time() + tasheel_custom_reset_key_expiry_seconds();
	update_user_meta( $user->ID, 'tasheel_reset_key', $key );
	update_user_meta( $user->ID, 'tasheel_reset_expiry', $expiry );
	return $key;
}

/**
 * Verify custom reset key and return the user if valid.
 *
 * @param string $key   Reset key from email link.
 * @param string $login User login from email link.
 * @return WP_User|false User object or false if invalid/expired.
 */
function tasheel_verify_custom_reset_key( $key, $login ) {
	if ( ! is_string( $key ) || ! is_string( $login ) || strlen( $key ) !== 64 || ! ctype_xdigit( $key ) ) {
		return false;
	}
	$user = get_user_by( 'login', $login );
	if ( ! $user ) {
		return false;
	}
	$stored = get_user_meta( $user->ID, 'tasheel_reset_key', true );
	$expiry = (int) get_user_meta( $user->ID, 'tasheel_reset_expiry', true );
	if ( $stored !== $key || $expiry < time() ) {
		return false;
	}
	return $user;
}

/**
 * Standard HTML email wrapper: header (site color), content area, consistent footer.
 * Use for all system emails (password reset, registration, job application, etc.).
 *
 * @param string $title     Main title in header (e.g. "Reset your password", "Application received").
 * @param string $subtitle  Optional line under title in header (e.g. "You have received a message from your website").
 * @param string $body_html HTML content for the main area (already escaped where needed).
 * @return string Full HTML email.
 */
function tasheel_get_email_html_wrapper( $title, $subtitle, $body_html ) {
	$site_name   = wp_specialchars_decode( get_bloginfo( 'name' ), ENT_QUOTES );
	$footer_line1 = sprintf( __( 'This email was sent from your website (%s).', 'tasheel' ), $site_name );
	$footer_line2 = __( 'Do not reply directly to this email.', 'tasheel' );
	$header_bg   = '#0D6A37'; // Site brand green (matches contact, job details, headings).
	ob_start();
	?>
	<!DOCTYPE html>
	<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	</head>
	<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f5f5f5;">
		<table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #f5f5f5; padding: 20px;">
			<tr>
				<td align="center">
					<table width="600" cellpadding="0" cellspacing="0" border="0" style="background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
						<tr>
							<td style="background-color: <?php echo esc_attr( $header_bg ); ?>; padding: 40px 30px; text-align: center;">
								<h1 style="margin: 0; color: #ffffff; font-size: 32px; font-weight: bold; letter-spacing: 1px;"><?php echo esc_html( $title ); ?></h1>
								<?php if ( $subtitle !== '' ) : ?>
									<p style="margin: 10px 0 0 0; color: #ffffff; font-size: 14px; opacity: 0.9;"><?php echo esc_html( $subtitle ); ?></p>
								<?php endif; ?>
							</td>
						</tr>
						<tr>
							<td style="padding: 40px 30px;">
								<?php echo $body_html; ?>
							</td>
						</tr>
						<tr>
							<td style="background-color: <?php echo esc_attr( $header_bg ); ?>; padding: 25px 30px; text-align: center;">
								<p style="margin: 0; color: #ffffff; font-size: 13px; line-height: 1.6;">
									<?php echo esc_html( $footer_line1 ); ?><br>
									<span style="opacity: 0.8;"><?php echo esc_html( $footer_line2 ); ?></span>
								</p>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</body>
	</html>
	<?php
	return ob_get_clean();
}

/**
 * Build professional HTML body for password reset email.
 *
 * @param string  $site_name Site name.
 * @param string  $reset_url Reset link URL.
 * @param WP_User $user      User object.
 * @return string HTML message.
 */
function tasheel_get_password_reset_email_html( $site_name, $reset_url, $user ) {
	$greeting = sprintf( __( 'Hello%s,', 'tasheel' ), ( ! empty( $user->display_name ) && $user->display_name !== $user->user_login ) ? ' ' . $user->display_name : '' );
	$intro   = __( 'We received a request to reset the password for your account.', 'tasheel' );
	$cta     = __( 'Reset password', 'tasheel' );
	$expiry  = __( 'This link will expire in 24 hours for your security.', 'tasheel' );
	$ignore  = __( 'If you did not request a password reset, you can safely ignore this email. Your password will not be changed.', 'tasheel' );
	$thanks  = __( 'Thank you,', 'tasheel' );
	$html    = apply_filters( 'tasheel_password_reset_email_html', null, $site_name, $reset_url, $user );
	if ( is_string( $html ) && $html !== '' ) {
		return $html;
	}
	$title    = __( 'Reset your password', 'tasheel' );
	$subtitle = sprintf( __( 'You have received a message from %s', 'tasheel' ), $site_name );
	$body     = '<p style="margin: 0 0 16px; font-size: 16px; color: #333;">' . esc_html( $greeting ) . '</p>';
	$body    .= '<p style="margin: 0 0 24px; font-size: 16px; color: #333;">' . esc_html( $intro ) . '</p>';
	$body    .= '<p style="margin: 0 0 24px;"><a href="' . esc_url( $reset_url ) . '" style="display: inline-block; padding: 14px 28px; font-size: 16px; font-weight: 600; color: #ffffff !important; background-color: #0D6A37; text-decoration: none; border-radius: 6px;">' . esc_html( $cta ) . '</a></p>';
	$body    .= '<p style="margin: 0 0 8px; font-size: 14px; color: #6c757d;">' . esc_html( $expiry ) . '</p>';
	$body    .= '<p style="margin: 0 0 24px; font-size: 14px; color: #6c757d;">' . esc_html( $ignore ) . '</p>';
	$body    .= '<p style="margin: 0; font-size: 16px; color: #333;">' . esc_html( $thanks ) . '<br>' . esc_html( $site_name ) . '</p>';
	return tasheel_get_email_html_wrapper( $title, $subtitle, $body );
}

/**
 * Send one password-reset email using custom key (no Sodium / no get_password_reset_key).
 * Returns true if sent, false otherwise.
 */
function tasheel_send_one_reset_email( $user_login ) {
	if ( ! is_string( $user_login ) || $user_login === '' ) {
		return false;
	}
	$user = tasheel_get_user_by_login_or_email( $user_login );
	if ( ! $user ) {
		return false;
	}
	try {
		$key = tasheel_set_custom_reset_key( $user );
		if ( $key === false ) {
			return false;
		}
		$reset_base = apply_filters( 'tasheel_password_reset_base_url', home_url( '/reset-password/' ), $user );
		$reset_url = add_query_arg(
			array( 'key' => $key, 'login' => rawurlencode( $user->user_login ) ),
			$reset_base
		);
		$reset_url = apply_filters( 'tasheel_password_reset_url', $reset_url, $key, $user );
		$reset_url = esc_url( $reset_url );
		$site_name = wp_specialchars_decode( get_bloginfo( 'name' ), ENT_QUOTES );
		$subject   = sprintf( __( 'Reset your password – %s', 'tasheel' ), $site_name );
		$message   = tasheel_get_password_reset_email_html( $site_name, $reset_url, $user );
		$headers   = array( 'Content-Type: text/html; charset=UTF-8' );
		wp_mail( $user->user_email, $subject, $message, $headers );
		return true;
	} catch ( Throwable $e ) {
		return false;
	}
}

/**
 * Process pending password-reset emails: send each via custom key + wp_mail (no Sodium).
 * Called by dedicated AJAX right after forgot form success so the email goes through your SMTP and shows in mail log.
 * Returns number of emails sent.
 */
function tasheel_process_pending_reset_emails() {
	$pending = get_option( 'tasheel_pending_reset_emails', array() );
	if ( ! is_array( $pending ) ) {
		$pending = array();
	}
	$pending = array_unique( array_filter( $pending, 'is_string' ) );
	update_option( 'tasheel_pending_reset_emails', array() );
	$sent = 0;
	foreach ( $pending as $user_login ) {
		if ( $user_login === '' ) {
			continue;
		}
		if ( tasheel_send_one_reset_email( $user_login ) ) {
			$sent++;
			delete_transient( 'tasheel_reset_send_' . md5( $user_login ) );
		}
	}
	return $sent;
}

/**
 * AJAX: Process reset email queue (sends the actual reset emails). Called by frontend right after forgot form success.
 * If queue is empty (e.g. load balancer / race), optional user_login with valid transient still sends one email.
 */
function tasheel_ajax_process_reset_email_queue() {
	ob_start();
	$sent = 0;
	try {
		$sent = tasheel_process_pending_reset_emails();
		// If queue was empty, frontend may pass user_login so we can still send (avoids race / multi-server).
		if ( $sent === 0 ) {
			$user_login = isset( $_POST['user_login'] ) ? sanitize_text_field( wp_unslash( $_POST['user_login'] ) ) : '';
			if ( $user_login !== '' && strlen( $user_login ) <= 255 ) {
				$transient_key = 'tasheel_reset_send_' . md5( $user_login );
				if ( get_transient( $transient_key ) !== false ) {
					if ( tasheel_send_one_reset_email( $user_login ) ) {
						$sent = 1;
					}
					delete_transient( $transient_key );
				}
			}
		}
	} catch ( Throwable $e ) {
		// Never 500
	}
	tasheel_forgot_password_ob_clean();
	wp_send_json_success( array( 'processed' => $sent ) );
}
add_action( 'wp_ajax_tasheel_process_reset_email_queue', 'tasheel_ajax_process_reset_email_queue' );
add_action( 'wp_ajax_nopriv_tasheel_process_reset_email_queue', 'tasheel_ajax_process_reset_email_queue' );

/**
 * Whether the server can generate password reset keys (requires PHP Sodium extension or polyfill).
 * WordPress uses sodium_bin2base64() in get_password_reset_key(); without it, reset fails with a fatal error.
 * Set define( 'TASHEEL_SKIP_SODIUM_CHECK', true ); in wp-config.php to bypass this check (use only if you
 * load a sodium polyfill before WordPress; otherwise password reset may still fatal).
 *
 * @return bool True if password reset email can be sent.
 */
function tasheel_can_send_password_reset() {
	if ( defined( 'TASHEEL_SKIP_SODIUM_CHECK' ) && TASHEEL_SKIP_SODIUM_CHECK ) {
		return true;
	}
	return function_exists( 'sodium_bin2base64' );
}

/**
 * Get user by login or email (same logic as retrieve_password).
 *
 * @param string $user_login Username or email.
 * @return WP_User|false User object or false if not found.
 */
function tasheel_get_user_by_login_or_email( $user_login ) {
	if ( strpos( $user_login, '@' ) !== false ) {
		$user = get_user_by( 'email', $user_login );
		if ( $user ) {
			return $user;
		}
	}
	return get_user_by( 'login', $user_login );
}

/**
 * AJAX: Forgot password (login popup). Check user exists first; only then send reset email. Different messages for user found vs not found.
 * Security: nonce (CSRF), sanitize input, length limit. No raw SQL – uses WordPress retrieve_password().
 */
function tasheel_ajax_forgot_password() {
	$nonce = isset( $_POST['tasheel_forgot_password_nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['tasheel_forgot_password_nonce'] ) ) : '';
	if ( ! wp_verify_nonce( $nonce, 'tasheel_forgot_password' ) ) {
		tasheel_forgot_password_ob_clean();
		wp_send_json_error( array( 'message' => __( 'Security check failed. Please try again.', 'tasheel' ) ) );
	}
	$user_login = isset( $_POST['user_login'] ) ? sanitize_text_field( wp_unslash( $_POST['user_login'] ) ) : '';
	$field_errors = array();
	if ( $user_login === '' ) {
		$field_errors['user_login'] = __( 'Please enter your email address.', 'tasheel' );
	}
	if ( strlen( $user_login ) > 255 ) {
		$field_errors['user_login'] = __( 'Invalid request.', 'tasheel' );
	}
	if ( ! empty( $field_errors ) ) {
		$first_message = reset( $field_errors );
		tasheel_forgot_password_ob_clean();
		wp_send_json_error( array( 'message' => $first_message, 'errors' => $field_errors ) );
	}

	$user = tasheel_get_user_by_login_or_email( $user_login );
	if ( ! $user ) {
		tasheel_forgot_password_ob_clean();
		wp_send_json_error( array(
			'message' => __( 'No account found with that email address.', 'tasheel' ),
			'errors'  => array( 'user_login' => __( 'No account found with that email address.', 'tasheel' ) ),
		) );
	}

	// Custom reset flow (no Sodium): send one reset email per request.
	tasheel_send_one_reset_email( $user_login );
	tasheel_forgot_password_ob_clean();
	wp_send_json_success( array( 'message' => __( 'We\'ve sent you a link to reset your password. Please check your inbox.', 'tasheel' ) ) );
}
add_action( 'wp_ajax_tasheel_forgot_password', 'tasheel_ajax_forgot_password' );
add_action( 'wp_ajax_nopriv_tasheel_forgot_password', 'tasheel_ajax_forgot_password' );

/**
 * Use site URL for password reset link in email. Link format: {site}/wp-login.php?action=rp&key=KEY&login=LOGIN.
 * Default target is wp-login.php (core styling). To use a themed reset page, filter tasheel_password_reset_url in tasheel_send_one_reset_email to return your page URL with key and login query args.
 */
add_filter( 'retrieve_password_message', 'tasheel_retrieve_password_message_use_site_url', 10, 4 );
function tasheel_retrieve_password_message_use_site_url( $message, $key, $user_login, $user_data ) {
	if ( ! is_string( $message ) || ! is_string( $key ) || ! is_string( $user_login ) ) {
		return $message;
	}
	$reset_base = apply_filters( 'tasheel_password_reset_base_url', home_url( '/reset-password/' ), $user_data );
	$reset_url  = add_query_arg( array( 'key' => $key, 'login' => rawurlencode( $user_login ) ), $reset_base );
	$reset_url  = esc_url( $reset_url );
	if ( $reset_url ) {
		$message = preg_replace( '#https?://[^\s\)\]]+wp-login\.php\?[^\s\)\]]+#', $reset_url, $message );
	}
	return is_string( $message ) ? $message : '';
}

/**
 * On the reset-password page, always output the form (so shortcode is never shown as text).
 */
add_filter( 'the_content', 'tasheel_reset_password_page_content', 1 );
function tasheel_reset_password_page_content( $content ) {
	if ( ! is_singular( 'page' ) ) {
		return $content;
	}
	$post = get_queried_object();
	if ( ! $post || ( isset( $post->post_name ) && $post->post_name !== 'reset-password' ) ) {
		return $content;
	}
	return tasheel_reset_password_form_markup();
}

/**
 * Custom reset password form markup (used by shortcode and the_content filter).
 *
 * @return string HTML form or message.
 */
function tasheel_reset_password_form_markup() {
	// Process POST (set new password). Validation errors per field (no top-level error message).
	$field_errors = array( 'pass1' => '', 'pass2' => '' );
	if ( isset( $_SERVER['REQUEST_METHOD'] ) && $_SERVER['REQUEST_METHOD'] === 'POST' && isset( $_POST['tasheel_reset_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['tasheel_reset_nonce'] ) ), 'tasheel_reset_password' ) ) {
		$key   = isset( $_POST['key'] ) ? sanitize_text_field( wp_unslash( $_POST['key'] ) ) : '';
		$login = isset( $_POST['login'] ) ? sanitize_text_field( wp_unslash( $_POST['login'] ) ) : '';
		$pass1 = isset( $_POST['pass1'] ) ? (string) $_POST['pass1'] : '';
		$pass2 = isset( $_POST['pass2'] ) ? (string) $_POST['pass2'] : '';
		$user  = tasheel_verify_custom_reset_key( $key, $login );
		if ( ! $user ) {
			$field_errors['pass1'] = __( 'This reset link is invalid or has expired. Please request a new one.', 'tasheel' );
		} else {
			if ( strlen( $pass1 ) < 8 ) {
				$field_errors['pass1'] = __( 'Password must be at least 8 characters.', 'tasheel' );
			}
			if ( $pass1 !== $pass2 ) {
				$field_errors['pass2'] = __( 'Passwords do not match.', 'tasheel' );
			}
			if ( $field_errors['pass1'] === '' && $field_errors['pass2'] === '' ) {
				wp_set_password( $pass1, $user->ID );
				delete_user_meta( $user->ID, 'tasheel_reset_key' );
				delete_user_meta( $user->ID, 'tasheel_reset_expiry' );
				$reset_done_url = add_query_arg( 'tasheel_reset_done', '1', home_url( '/reset-password/' ) );
				wp_safe_redirect( $reset_done_url );
				exit;
			}
		}
	}

	// Success message after password was reset (stays on front-end; no backend login page).
	if ( isset( $_GET['tasheel_reset_done'] ) && $_GET['tasheel_reset_done'] === '1' ) {
		// Sign in link opens the login popup on the same page (filter can override to use a URL instead).
		$login_url = apply_filters( 'tasheel_reset_success_redirect_url', '' );
		$use_popup = ( $login_url === '' || $login_url === false );
		ob_start();
		?>
		<div class="tasheel-reset-success">
			<p class="tasheel-reset-success-message"><?php esc_html_e( 'Your password has been reset successfully. You can now sign in with your new password.', 'tasheel' ); ?></p>
			<p>
				<?php if ( $use_popup ) : ?>
					<a href="#login-popup" class="tasheel-reset-success-link" data-fancybox="login-popup"><?php esc_html_e( 'Sign in', 'tasheel' ); ?></a>
				<?php else : ?>
					<a href="<?php echo esc_url( $login_url ); ?>" class="tasheel-reset-success-link"><?php esc_html_e( 'Sign in', 'tasheel' ); ?></a>
				<?php endif; ?>
			</p>
		</div>
		<?php
		return ob_get_clean();
	}

	$key   = isset( $_GET['key'] ) ? sanitize_text_field( wp_unslash( $_GET['key'] ) ) : ( isset( $_POST['key'] ) ? sanitize_text_field( wp_unslash( $_POST['key'] ) ) : '' );
	$login = isset( $_GET['login'] ) ? sanitize_text_field( wp_unslash( $_GET['login'] ) ) : ( isset( $_POST['login'] ) ? sanitize_text_field( wp_unslash( $_POST['login'] ) ) : '' );
	$user  = ( $key && $login ) ? tasheel_verify_custom_reset_key( $key, $login ) : false;

	if ( ! $key || ! $login ) {
		return '<p class="tasheel-reset-error">' . esc_html__( 'Missing reset link parameters. Use the link from your email.', 'tasheel' ) . '</p>';
	}
	if ( ! $user ) {
		return '<p class="tasheel-reset-error">' . esc_html__( 'This reset link is invalid or has expired. Please request a new password reset.', 'tasheel' ) . '</p>';
	}

	$field_errors = isset( $field_errors ) && is_array( $field_errors ) ? $field_errors : array( 'pass1' => '', 'pass2' => '' );
	$eye_icon_url = get_template_directory_uri() . '/assets/images/eye-icn.svg';
	ob_start();
	?>
	<div class="tasheel-reset-password-form">
		<style>
			.tasheel-reset-password-form { max-width: 480px; margin: 0 auto; }
			.tasheel-reset-password-form .tasheel-reset-success-message { color: #0d6a37; font-size: 16px; margin-bottom: 15px; }
			.tasheel-reset-password-form .tasheel-reset-success-link { color: #0d6a37; font-weight: 500; text-decoration: none; }
			.tasheel-reset-password-form .tasheel-reset-success-link:hover { text-decoration: underline; }
			.tasheel-reset-password-form .career-form-list-ul { margin: 0; padding: 0; list-style: none; margin-top: 10px; }
			.tasheel-reset-password-form .career-form-list-ul li { list-style: none; margin-bottom: 15px; position: relative; }
			.tasheel-reset-password-form .career-form-list-ul li .input { border-radius: 35px; height: 48px; padding: 0 50px 0 20px; border: 1px solid #e0e0e0; width: 100%; font-size: 12px; color: #979797; }
			.tasheel-reset-password-form .career-form-list-ul li .input:focus-visible { outline: none; }
			.tasheel-reset-password-form .career-form-list-ul li .form-icon { position: absolute; right: 20px; top: 50%; transform: translateY(-50%); cursor: pointer; display: inline-flex; align-items: center; justify-content: center; }
			.tasheel-reset-password-form .career-form-list-ul li .form-icon img { display: block; width: 22px; height: 22px; }
			.tasheel-reset-password-form .career-form-list-ul li .field-error { display: block; font-size: 12px; color: #c00; margin-top: 4px; min-height: 1.2em; }
			.tasheel-reset-password-form .career-form-list-ul li .field-error:empty { display: none; }
			.tasheel-reset-password-form .career-form-list-ul li .input-buttion { background: #101922; color: #fff; font-size: 16px; width: 100%; height: 48px; border-radius: 35px; border: none; outline: none; cursor: pointer; transition: background 0.3s ease, color 0.3s ease; }
			.tasheel-reset-password-form .career-form-list-ul li .input-buttion:hover { background: #A9D159; color: #101922; }
			@media screen and (max-width: 700px) {
				.tasheel-reset-password-form .career-form-list-ul li .input { font-size: 14px; height: 40px; }
				.tasheel-reset-password-form .career-form-list-ul li .input-buttion { height: 44px; font-size: 15px; }
			}
		</style>
		<form method="post" action="" class="tasheel-reset-form" autocomplete="off" novalidate
			data-msg-required="<?php echo esc_attr__( 'Please enter a password.', 'tasheel' ); ?>"
			data-msg-minlength="<?php echo esc_attr__( 'Password must be at least 8 characters.', 'tasheel' ); ?>"
			data-msg-mismatch="<?php echo esc_attr__( 'Passwords do not match.', 'tasheel' ); ?>"
			data-submitting-text="<?php echo esc_attr__( 'Updating…', 'tasheel' ); ?>">
			<?php wp_nonce_field( 'tasheel_reset_password', 'tasheel_reset_nonce' ); ?>
			<input type="hidden" name="key" value="<?php echo esc_attr( $key ); ?>" />
			<input type="hidden" name="login" value="<?php echo esc_attr( $login ); ?>" />
			<ul class="career-form-list-ul">
				<li>
					<input class="input" type="password" name="pass1" id="pass1" placeholder="<?php esc_attr_e( 'New password', 'tasheel' ); ?>" value="" autocomplete="new-password" aria-describedby="error-pass1" aria-invalid="<?php echo ! empty( $field_errors['pass1'] ) ? 'true' : 'false'; ?>" />
					<span class="form-icon" role="button" tabindex="0" aria-label="<?php esc_attr_e( 'Show password', 'tasheel' ); ?>">
						<img src="<?php echo esc_url( $eye_icon_url ); ?>" alt="<?php esc_attr_e( 'Toggle password visibility', 'tasheel' ); ?>">
					</span>
					<span class="field-error" id="error-pass1" data-field="pass1" aria-live="polite"><?php echo ! empty( $field_errors['pass1'] ) ? esc_html( $field_errors['pass1'] ) : ''; ?></span>
				</li>
				<li>
					<input class="input" type="password" name="pass2" id="pass2" placeholder="<?php esc_attr_e( 'Confirm new password', 'tasheel' ); ?>" value="" autocomplete="new-password" aria-describedby="error-pass2" aria-invalid="<?php echo ! empty( $field_errors['pass2'] ) ? 'true' : 'false'; ?>" />
					<span class="form-icon" role="button" tabindex="0" aria-label="<?php esc_attr_e( 'Show password', 'tasheel' ); ?>">
						<img src="<?php echo esc_url( $eye_icon_url ); ?>" alt="<?php esc_attr_e( 'Toggle password visibility', 'tasheel' ); ?>">
					</span>
					<span class="field-error" id="error-pass2" data-field="pass2" aria-live="polite"><?php echo ! empty( $field_errors['pass2'] ) ? esc_html( $field_errors['pass2'] ) : ''; ?></span>
				</li>
				<li>
					<button type="submit" name="wp-submit" class="input-buttion btn_style btn_transparent but_black"><?php esc_html_e( 'Set new password', 'tasheel' ); ?></button>
				</li>
			</ul>
		</form>
		<script>
		(function() {
			var form = document.querySelector('.tasheel-reset-password-form .tasheel-reset-form');
			if (!form) return;
			form.addEventListener('submit', function(e) {
				e.preventDefault();
				var pass1 = form.querySelector('#pass1');
				var pass2 = form.querySelector('#pass2');
				var err1 = form.querySelector('.field-error[data-field="pass1"]');
				var err2 = form.querySelector('.field-error[data-field="pass2"]');
				var msgRequired = form.getAttribute('data-msg-required') || 'Please enter a password.';
				var msgMinlength = form.getAttribute('data-msg-minlength') || 'Password must be at least 8 characters.';
				var msgMismatch = form.getAttribute('data-msg-mismatch') || 'Passwords do not match.';
				if (err1) err1.textContent = '';
				if (err2) err2.textContent = '';
				if (pass1) pass1.setAttribute('aria-invalid', 'false');
				if (pass2) pass2.setAttribute('aria-invalid', 'false');
				var v1 = pass1 ? pass1.value.trim() : '';
				var v2 = pass2 ? pass2.value.trim() : '';
				var valid = true;
				if (v1 === '') {
					if (err1) err1.textContent = msgRequired;
					if (pass1) pass1.setAttribute('aria-invalid', 'true');
					valid = false;
				} else if (v1.length < 8) {
					if (err1) err1.textContent = msgMinlength;
					if (pass1) pass1.setAttribute('aria-invalid', 'true');
					valid = false;
				}
				if (v2 === '') {
					if (err2) err2.textContent = msgRequired;
					if (pass2) pass2.setAttribute('aria-invalid', 'true');
					valid = false;
				} else if (v1 !== v2) {
					if (err2) err2.textContent = msgMismatch;
					if (pass2) pass2.setAttribute('aria-invalid', 'true');
					valid = false;
				}
				if (valid) {
					var btn = form.querySelector('button[type="submit"]');
					var submittingText = form.getAttribute('data-submitting-text') || 'Updating…';
					if (btn) {
						btn.disabled = true;
						btn.textContent = submittingText;
					}
					form.submit();
				}
			});
		})();
		</script>
	</div>
	<?php
	return ob_get_clean();
}

add_shortcode( 'tasheel_reset_password_form', 'tasheel_reset_password_form_shortcode' );
function tasheel_reset_password_form_shortcode() {
	return tasheel_reset_password_form_markup();
}


/**
 * AJAX: Return a fresh nonce for the popup login form (avoids cached/expired nonce in Fancybox clone).
 */
function tasheel_ajax_popup_login_get_nonce() {
	wp_send_json_success( array( 'nonce' => wp_create_nonce( 'tasheel_popup_login' ) ) );
}
add_action( 'wp_ajax_tasheel_popup_login_get_nonce', 'tasheel_ajax_popup_login_get_nonce' );
add_action( 'wp_ajax_nopriv_tasheel_popup_login_get_nonce', 'tasheel_ajax_popup_login_get_nonce' );

/**
 * AJAX: Return a fresh nonce for the signup/register form (avoids expired nonce in Fancybox clone).
 */
function tasheel_ajax_register_get_nonce() {
	wp_send_json_success( array( 'nonce' => wp_create_nonce( 'tasheel_register' ) ) );
}
add_action( 'wp_ajax_tasheel_register_get_nonce', 'tasheel_ajax_register_get_nonce' );
add_action( 'wp_ajax_nopriv_tasheel_register_get_nonce', 'tasheel_ajax_register_get_nonce' );

/**
 * AJAX: Popup login – wp_signon(), return JSON. Production: nonce, sanitize, safe redirect only to same site.
 */
function tasheel_ajax_popup_login() {
	$nonce = isset( $_POST['tasheel_popup_login_nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['tasheel_popup_login_nonce'] ) ) : '';
	if ( ! wp_verify_nonce( $nonce, 'tasheel_popup_login' ) ) {
		wp_send_json_error( array( 'message' => __( 'Your session expired. Please close this popup and try again.', 'tasheel' ) ) );
	}
	$user_login = isset( $_POST['log'] ) ? sanitize_text_field( wp_unslash( $_POST['log'] ) ) : '';
	$user_pass  = isset( $_POST['pwd'] ) ? ( is_array( $_POST['pwd'] ) ? '' : (string) $_POST['pwd'] ) : '';
	$remember   = ! empty( $_POST['rememberme'] ) && $_POST['rememberme'] === 'forever';
	$requested_redirect = isset( $_POST['redirect_to'] ) ? esc_url_raw( wp_unslash( $_POST['redirect_to'] ) ) : '';
	$default_redirect   = home_url( '/my-profile/' );
	$redirect_to        = ( $requested_redirect !== '' ) ? wp_validate_redirect( $requested_redirect, $default_redirect ) : $default_redirect;
	if ( ! $redirect_to ) {
		$redirect_to = $default_redirect;
	}

	$field_errors = array();
	if ( $user_login === '' ) {
		$field_errors['log'] = __( 'Please enter your email address.', 'tasheel' );
	}
	if ( $user_pass === '' ) {
		$field_errors['pwd'] = __( 'Please enter your password.', 'tasheel' );
	}
	if ( strlen( $user_login ) > 255 ) {
		$field_errors['log'] = __( 'Invalid request.', 'tasheel' );
	}
	if ( ! empty( $field_errors ) ) {
		$first_message = reset( $field_errors );
		wp_send_json_error( array( 'message' => $first_message, 'errors' => $field_errors ) );
	}

	$result = wp_signon(
		array(
			'user_login'    => $user_login,
			'user_password' => $user_pass,
			'remember'      => $remember,
		),
		is_ssl()
	);

	if ( is_wp_error( $result ) ) {
		$msg = wp_strip_all_tags( $result->get_error_message() );
		$msg = str_replace( array( 'Lost your password?', __( 'Lost your password?', 'tasheel' ) ), __( 'Forgot password?', 'tasheel' ), $msg );
		wp_send_json_error( array( 'message' => $msg ) );
	}
	wp_send_json_success( array( 'redirect_to' => $redirect_to ) );
}
add_action( 'wp_ajax_tasheel_popup_login', 'tasheel_ajax_popup_login' );
add_action( 'wp_ajax_nopriv_tasheel_popup_login', 'tasheel_ajax_popup_login' );

/**
 * AJAX: Check if user is logged in. Used when page is restored from bfcache (e.g. back button)
 * so we can close the login popup and fix the URL if the user logged in after the page was cached.
 */
function tasheel_ajax_check_login() {
	wp_send_json_success( array( 'logged_in' => is_user_logged_in() ) );
}
add_action( 'wp_ajax_tasheel_check_login', 'tasheel_ajax_check_login' );
add_action( 'wp_ajax_nopriv_tasheel_check_login', 'tasheel_ajax_check_login' );

/**
 * Handle password change form submission (Password Management page).
 * Runs on template_redirect. Logged-in users only. No raw SQL used; passwords passed only to
 * wp_authenticate() and wp_set_password(). All displayed messages escaped to prevent XSS.
 */
function tasheel_handle_password_change() {
	if ( ! is_user_logged_in() || ! isset( $_POST['tasheel_change_password_nonce'] ) || ( isset( $_SERVER['REQUEST_METHOD'] ) && $_SERVER['REQUEST_METHOD'] !== 'POST' ) ) {
		return;
	}
	$uri = isset( $_SERVER['REQUEST_URI'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '';
	if ( strpos( $uri, 'password-management' ) === false ) {
		return;
	}
	$nonce = isset( $_POST['tasheel_change_password_nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['tasheel_change_password_nonce'] ) ) : '';
	if ( ! wp_verify_nonce( $nonce, 'tasheel_change_password' ) ) {
		$redirect = home_url( '/password-management/' );
		$msg = array(
			'error'        => __( 'Security check failed. Please try again.', 'tasheel' ),
			'field_errors' => array(),
		);
		set_transient( 'tasheel_password_change_message_' . get_current_user_id(), $msg, 120 );
		wp_safe_redirect( $redirect );
		exit;
	}
	$user_id  = get_current_user_id();
	$redirect = home_url( '/password-management/' );
	// Read password fields: use wp_unslash only; do not sanitize (would alter valid chars). Never output these values.
	$current = isset( $_POST['current_password'] ) ? (string) wp_unslash( $_POST['current_password'] ) : '';
	$new     = isset( $_POST['new_password'] ) ? (string) wp_unslash( $_POST['new_password'] ) : '';
	$confirm = isset( $_POST['new_password_confirm'] ) ? (string) wp_unslash( $_POST['new_password_confirm'] ) : '';

	$user = get_userdata( $user_id );
	if ( ! $user ) {
		set_transient( 'tasheel_password_change_message_' . $user_id, array( 'error' => __( 'Invalid request.', 'tasheel' ), 'field_errors' => array() ), 120 );
		wp_safe_redirect( $redirect );
		exit;
	}
	// Length limits to prevent DoS; no SQL/script in passwords (we never concatenate into queries or HTML).
	$max_len = 4096;
	if ( strlen( $current ) > $max_len || strlen( $new ) > $max_len || strlen( $confirm ) > $max_len ) {
		set_transient( 'tasheel_password_change_message_' . $user_id, array( 'error' => __( 'Invalid request.', 'tasheel' ), 'field_errors' => array() ), 120 );
		wp_safe_redirect( $redirect );
		exit;
	}

	$field_errors = array();
	if ( $current === '' ) {
		$field_errors['current_password'] = __( 'Please enter your current password.', 'tasheel' );
	}
	$auth = null;
	if ( $current !== '' ) {
		$auth = wp_authenticate( $user->user_login, $current );
		if ( is_wp_error( $auth ) || (int) $auth->ID !== (int) $user_id ) {
			$field_errors['current_password'] = __( 'Current password is incorrect.', 'tasheel' );
		}
	}
	if ( $new === '' ) {
		$field_errors['new_password'] = __( 'Please enter a new password.', 'tasheel' );
	} elseif ( strlen( $new ) < 6 ) {
		$field_errors['new_password'] = __( 'New password must be at least 6 characters.', 'tasheel' );
	} elseif ( $current !== '' && $new === $current ) {
		$field_errors['new_password'] = __( 'New password must be different from your current password.', 'tasheel' );
	}
	if ( $confirm === '' ) {
		$field_errors['new_password_confirm'] = __( 'Please retype your new password.', 'tasheel' );
	} elseif ( $new !== '' && $new !== $confirm ) {
		$field_errors['new_password_confirm'] = __( 'New passwords do not match.', 'tasheel' );
	}

	if ( ! empty( $field_errors ) ) {
		$first = reset( $field_errors );
		set_transient( 'tasheel_password_change_message_' . $user_id, array( 'error' => $first, 'field_errors' => $field_errors ), 120 );
		wp_safe_redirect( $redirect );
		exit;
	}

	wp_set_password( $new, $user_id );
	wp_cache_delete( $user_id, 'users' );
	wp_cache_delete( $user->user_login, 'userlogins' );
	wp_set_current_user( $user_id );
	wp_set_auth_cookie( $user_id, true );
	set_transient( 'tasheel_password_change_message_' . $user_id, array( 'success' => __( 'Your password has been changed successfully.', 'tasheel' ), 'field_errors' => array() ), 120 );
	wp_safe_redirect( $redirect );
	exit;
}
add_action( 'template_redirect', 'tasheel_handle_password_change', 5 );

/**
 * AJAX handler for password change (Password Management page).
 * Returns JSON so the form is not cleared on validation errors.
 */
function tasheel_ajax_change_password() {
	if ( ! is_user_logged_in() ) {
		wp_send_json_error( array( 'message' => __( 'You must be logged in to change your password.', 'tasheel' ), 'field_errors' => array() ) );
	}
	$nonce = isset( $_POST['tasheel_change_password_nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['tasheel_change_password_nonce'] ) ) : '';
	if ( ! wp_verify_nonce( $nonce, 'tasheel_change_password' ) ) {
		wp_send_json_error( array( 'message' => __( 'Security check failed. Please try again.', 'tasheel' ), 'field_errors' => array() ) );
	}
	$user_id = get_current_user_id();
	$current = isset( $_POST['current_password'] ) ? (string) wp_unslash( $_POST['current_password'] ) : '';
	$new     = isset( $_POST['new_password'] ) ? (string) wp_unslash( $_POST['new_password'] ) : '';
	$confirm = isset( $_POST['new_password_confirm'] ) ? (string) wp_unslash( $_POST['new_password_confirm'] ) : '';

	$user = get_userdata( $user_id );
	if ( ! $user ) {
		wp_send_json_error( array( 'message' => __( 'Invalid request.', 'tasheel' ), 'field_errors' => array() ) );
	}
	$max_len = 4096;
	if ( strlen( $current ) > $max_len || strlen( $new ) > $max_len || strlen( $confirm ) > $max_len ) {
		wp_send_json_error( array( 'message' => __( 'Invalid request.', 'tasheel' ), 'field_errors' => array() ) );
	}

	$field_errors = array();
	if ( $current === '' ) {
		$field_errors['current_password'] = __( 'Please enter your current password.', 'tasheel' );
	}
	$auth = null;
	if ( $current !== '' ) {
		$auth = wp_authenticate( $user->user_login, $current );
		if ( is_wp_error( $auth ) || (int) $auth->ID !== (int) $user_id ) {
			$field_errors['current_password'] = __( 'Current password is incorrect.', 'tasheel' );
		}
	}
	if ( $new === '' ) {
		$field_errors['new_password'] = __( 'Please enter a new password.', 'tasheel' );
	} elseif ( strlen( $new ) < 6 ) {
		$field_errors['new_password'] = __( 'New password must be at least 6 characters.', 'tasheel' );
	} elseif ( function_exists( 'tasheel_validate_password_strength' ) && tasheel_validate_password_strength( $new ) ) {
		$field_errors['new_password'] = __( 'Password must include at least one uppercase letter, one lowercase letter, one digit, and one special character.', 'tasheel' );
	} elseif ( $current !== '' && $new === $current ) {
		$field_errors['new_password'] = __( 'New password must be different from your current password.', 'tasheel' );
	}
	if ( $confirm === '' ) {
		$field_errors['new_password_confirm'] = __( 'Please retype your new password.', 'tasheel' );
	} elseif ( $new !== '' && $new !== $confirm ) {
		$field_errors['new_password_confirm'] = __( 'New passwords do not match.', 'tasheel' );
	}

	if ( ! empty( $field_errors ) ) {
		$first = reset( $field_errors );
		wp_send_json_error( array( 'message' => $first, 'field_errors' => $field_errors ) );
	}

	wp_set_password( $new, $user_id );
	wp_cache_delete( $user_id, 'users' );
	wp_cache_delete( $user->user_login, 'userlogins' );
	wp_set_current_user( $user_id );
	wp_set_auth_cookie( $user_id, true );
	wp_send_json_success( array( 'message' => __( 'Your password has been changed successfully.', 'tasheel' ) ) );
}
add_action( 'wp_ajax_tasheel_change_password', 'tasheel_ajax_change_password' );

/**
 * Password policy URL for Password Management page. Manage via:
 * Options → Account Options (Password Policy URL field), or
 * add_filter( 'tasheel_password_policy_url', function() { return home_url( '/your-page/' ); } );
 */
function tasheel_get_password_policy_url() {
	$url = '';
	if ( function_exists( 'get_field' ) ) {
		$url = get_field( 'password_policy_url', 'acf-options-account' );
		if ( ( $url === null || $url === false || $url === '' ) ) {
			$url = get_field( 'password_policy_url', 'account' );
		}
		if ( ( $url === null || $url === false || $url === '' ) ) {
			$url = get_field( 'password_policy_url', 'option' );
		}
		if ( ( $url === null || $url === false || $url === '' ) && function_exists( 'get_option' ) ) {
			$opts = get_option( 'options_acf-options-account', array() );
			$url  = is_array( $opts ) && isset( $opts['password_policy_url'] ) ? $opts['password_policy_url'] : '';
		}
		if ( is_array( $url ) && isset( $url['url'] ) ) {
			$url = $url['url'];
		}
	}
	$url = is_string( $url ) ? trim( $url ) : '';
	return apply_filters( 'tasheel_password_policy_url', $url );
}

/**
 * Get profile section tabs (My Jobs, My Profile, Password Management) for the account sub-navigation.
 * Admin can select and order pages via Options → Account Options → Profile section tabs.
 *
 * @param string $active_tab      Tab id or title to mark as active (e.g. 'My Jobs', 'my-profile').
 * @param int    $active_page_id  Optional. Current page ID for active state (matches tab by page_id).
 * @return array{ tabs: array, active_tab: string, active_page_id: int, nav_class: string }
 */
function tasheel_get_profile_tabs( $active_tab = '', $active_page_id = 0 ) {
	$nav_class = 'profile-tabs-nav';
	$tabs      = array();
	if ( function_exists( 'get_field' ) ) {
		$rows = get_field( 'profile_section_tabs', 'acf-options-account' );
		if ( is_array( $rows ) && ! empty( $rows ) ) {
			foreach ( $rows as $row ) {
				$page = isset( $row['tab_page'] ) ? $row['tab_page'] : null;
				if ( ! $page || ! is_object( $page ) || empty( $page->ID ) ) {
					continue;
				}
				$label = isset( $row['tab_label'] ) && is_string( $row['tab_label'] ) ? trim( $row['tab_label'] ) : '';
				if ( $label === '' ) {
					$label = get_the_title( $page );
				}
				$tabs[] = array(
					'id'      => $page->post_name,
					'title'   => $label,
					'link'    => get_permalink( $page ),
					'page_id' => (int) $page->ID,
				);
			}
		}
	}
	if ( empty( $tabs ) ) {
		$tabs = array(
			array( 'id' => 'my-job', 'title' => __( 'My Jobs', 'tasheel' ), 'link' => esc_url( home_url( '/my-job/' ) ), 'page_id' => 0 ),
			array( 'id' => 'my-profile', 'title' => __( 'My Profile', 'tasheel' ), 'link' => esc_url( home_url( '/my-profile/' ) ), 'page_id' => 0 ),
			array( 'id' => 'password-management', 'title' => __( 'Password Management', 'tasheel' ), 'link' => esc_url( home_url( '/password-management/' ) ), 'page_id' => 0 ),
		);
	}
	$logout_url = is_user_logged_in() ? wp_logout_url( home_url( '/' ) ) : '';
	return array(
		'tabs'           => $tabs,
		'active_tab'     => $active_tab,
		'active_page_id' => (int) $active_page_id,
		'nav_class'      => $nav_class,
		'logout_url'     => $logout_url,
	);
}

/**
 * URL for the "View Careers" button on My Jobs empty state. Manage via Options → Account Options.
 *
 * @return string
 */
function tasheel_get_view_careers_url() {
	$url = home_url( '/careers/' );
	if ( function_exists( 'get_field' ) ) {
		$page = get_field( 'view_careers_page', 'acf-options-account' );
		if ( $page && is_object( $page ) && ! empty( $page->ID ) ) {
			$url = get_permalink( $page );
		}
	}
	return apply_filters( 'tasheel_view_careers_url', $url );
}

/**
 * Prefer hr_job single when URL path is /jobs/{slug}.
 * WordPress can resolve /jobs/foo/ as a page (pagename=jobs/foo) and show home or wrong content.
 * This forces the job single so all job links work regardless of page slug conflicts.
 */
function tasheel_force_job_single_request( $query_vars ) {
	$uri  = isset( $_SERVER['REQUEST_URI'] ) ? wp_unslash( $_SERVER['REQUEST_URI'] ) : '';
	$path = trim( parse_url( $uri, PHP_URL_PATH ), '/' );
	// Path must contain "jobs/something" (single job). Supports both "jobs/slug" and "ar/jobs/slug" (WPML language prefix).
	$jobs_pos = strpos( $path, 'jobs/' );
	if ( $jobs_pos === false ) {
		return $query_vars;
	}
	$rest = substr( $path, $jobs_pos + strlen( 'jobs/' ) );
	$rest = trim( $rest, '/' );
	// Remove any trailing path (e.g. "slug/page/2" -> "slug").
	if ( $rest !== '' && strpos( $rest, '/' ) !== false ) {
		$rest = strtok( $rest, '/' );
	}
	if ( $rest === '' ) {
		return $query_vars;
	}
	// Force main query to single hr_job by slug. WPML will resolve to the correct language version.
	unset( $query_vars['pagename'] );
	return array_merge( $query_vars, array(
		'post_type' => 'hr_job',
		'name'      => $rest,
	) );
}
add_filter( 'request', 'tasheel_force_job_single_request', 0 );

add_filter( 'tasheel_hr_application_admin_email', function() {
    return 'navasahammed@element8.ae'; // your HR/admin email
});



/**
 * Specialization Google Sheet URL - from ACF options page when available, with fallback.
 * This filter runs only when specialization options are requested (e.g. create-profile / form),
 * not on every page load. ACF options can fail in some contexts (WPML, cache); this provides a fallback.
 *
 * WPML: Use different sheet URLs per language by checking wpml_current_language and returning
 * the appropriate URL (e.g. from ACF field "specialization_google_sheet_url_ar" or your own option).
 */
add_filter( 'tasheel_hr_specialization_google_sheet_url', function( $url ) {
	if ( is_string( $url ) && trim( $url ) !== '' ) {
		return $url;
	}
	// Optional: try ACF again in filter context (e.g. when WPML/cache caused empty read earlier).
	if ( function_exists( 'get_field' ) ) {
		$acf_url = get_field( 'specialization_google_sheet_url', 'acf-options-account' );
		if ( is_array( $acf_url ) && isset( $acf_url['url'] ) ) {
			$acf_url = $acf_url['url'];
		}
		if ( is_string( $acf_url ) && trim( $acf_url ) !== '' ) {
			return trim( $acf_url );
		}
	}
	// WPML: use a different sheet for Arabic (or other language) if you set it via option or constant.
	$lang = function_exists( 'apply_filters' ) ? apply_filters( 'wpml_current_language', null ) : '';
	if ( $lang === 'ar' && get_option( 'tasheel_specialization_sheet_url_ar', '' ) !== '' ) {
		return get_option( 'tasheel_specialization_sheet_url_ar', '' );
	}
	// Default fallback URL (update when you change the sheet).
	return 'https://docs.google.com/spreadsheets/d/e/2PACX-1vR1Fl8ILBjhiRwVdT3pvZ6QO-t6nA-_VpHpIZZ_-U_NcJb_4pEwZXFtVszuEC0y8FD8RgBuZ9ylT0-x/pub?output=csv';
} );

