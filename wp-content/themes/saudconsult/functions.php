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

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__('Primary', 'tasheel'),
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

	// Enqueue AOS (Animate On Scroll) library (CDN) - loaded on all pages
	wp_enqueue_style('aos-css', 'https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css', array(), '2.3.4');
	wp_enqueue_script('aos-js', 'https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js', array(), '2.3.4', true);

	// Initialize AOS after DOM is ready (global initialization for all pages)
	wp_add_inline_script('aos-js', 'document.addEventListener("DOMContentLoaded", function() { if (typeof AOS !== "undefined") { AOS.init({ duration: 800, once: false }); setTimeout(function() { AOS.refresh(); }, 500); } });', 'after');

	// Check if current page uses Company Detail, Investments Detail, or TasHeel Modern Support Services template
	$is_company_detail_page = false;
	$is_tasheel_modern_support_page = false;
	$is_group_companies_page = false;
	if (is_page()) {
		$template = get_page_template_slug();
		$is_company_detail_page = ($template === 'page-company-detail.php' || $template === 'page-investments-detail.php' || $template === 'page-tasheel-modern-support-services.php');
		$is_tasheel_modern_support_page = ($template === 'page-tasheel-modern-support-services.php');
		$is_group_companies_page = ($template === 'page-group-companies.php');
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
	if (is_page_template('page-template-event-detail.php')) {
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

