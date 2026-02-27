<?php
/**
 * ACF Header & Footer Integration
 *
 * Helper functions for dynamic header/footer with WPML string translation support.
 * All output strings use esc_html__/esc_attr__ for translation.
 *
 * @package tasheel
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once get_template_directory() . '/inc/class-header-mega-menu-walker.php';
require_once get_template_directory() . '/inc/class-header-mobile-menu-walker.php';

/**
 * Get translated option value (WPML-ready).
 * ACF options are auto-translated when WPML is active and option page is registered.
 *
 * @param string $field Field name.
 * @param string $option Optional. Option page slug. Default 'option'.
 * @return mixed
 */
function tasheel_header_footer_get_option( $field, $option = 'option' ) {
	if ( ! function_exists( 'get_field' ) ) {
		return null;
	}
	return get_field( $field, $option );
}

/**
 * Get header logo URL (from ACF or fallback).
 *
 * @param string $variant 'default' or 'dark'.
 * @return string|null
 */
function tasheel_get_header_logo_url( $variant = 'default' ) {
	$field = 'default' === $variant ? 'header_logo' : 'header_logo_dark';
	$img = tasheel_header_footer_get_option( $field, 'option' );
	if ( ! empty( $img ) && is_array( $img ) && ! empty( $img['url'] ) ) {
		return $img['url'];
	}
	$filename = 'default' === $variant ? 'saudconsult-logo.svg' : 'saudconsult-logo-black.svg';
	$path = get_template_directory() . '/assets/images/' . $filename;
	return file_exists( $path ) ? get_template_directory_uri() . '/assets/images/' . $filename : null;
}

/**
 * Get footer logo URL (from ACF or fallback).
 *
 * @return string|null
 */
function tasheel_get_footer_logo_url() {
	$img = tasheel_header_footer_get_option( 'footer_logo', 'option' );
	if ( ! empty( $img ) && is_array( $img ) && ! empty( $img['url'] ) ) {
		return $img['url'];
	}
	$path = get_template_directory() . '/assets/images/footer-logo.svg';
	return file_exists( $path ) ? get_template_directory_uri() . '/assets/images/footer-logo.svg' : null;
}

/**
 * Check if header button should be shown and return data.
 *
 * @return array|null ['url' => string, 'text' => string] or null to hide
 */
function tasheel_get_header_button() {
	$text = tasheel_header_footer_get_option( 'header_button_text', 'option' );
	$url  = tasheel_header_footer_get_option( 'header_button_url', 'option' );
	if ( empty( trim( (string) $text ) ) ) {
		return null;
	}
	return array(
		'text' => $text,
		'url'  => ! empty( $url ) ? $url : home_url( '/contact' ),
	);
}

/**
 * Get header menu ID from theme location.
 * Checks: Header Menu location first, then Primary.
 *
 * @return int|null
 */
function tasheel_get_header_menu_id() {
	$locations = get_nav_menu_locations();
	if ( ! empty( $locations['header-menu'] ) ) {
		return (int) $locations['header-menu'];
	}
	return isset( $locations['menu-1'] ) ? (int) $locations['menu-1'] : null;
}

/**
 * Whether to show login icon in header.
 *
 * @return bool
 */
function tasheel_header_show_login() {
	$show = tasheel_header_footer_get_option( 'header_show_login', 'option' );
	return $show !== false && $show !== 0 && $show !== '0';
}

/**
 * Get language switcher text (translatable via WPML/pot).
 *
 * @return string
 */
function tasheel_get_header_language_switcher_text() {
	return esc_html__( 'عربي', 'tasheel' );
}

/**
 * Get language switcher URL (WPML/Polylang compatible).
 * Plugins can filter this.
 *
 * @return string
 */
function tasheel_get_header_language_switcher_url() {
	$url = apply_filters( 'tasheel_language_switcher_url', '' );
	if ( ! empty( $url ) ) {
		return $url;
	}
	if ( function_exists( 'pll_the_languages' ) ) {
		$langs = pll_the_languages( array( 'raw' => 1 ) );
		if ( is_array( $langs ) ) {
			foreach ( $langs as $l ) {
				if ( empty( $l['current_lang'] ) && ! empty( $l['url'] ) ) {
					return $l['url'];
				}
			}
		}
	}
	// WPML: use filter or return empty for custom implementation.
	return '';
}

// --- Footer helpers ---

/**
 * Get footer social links from ACF.
 *
 * @return array
 */
function tasheel_get_footer_social_links() {
	$links = tasheel_header_footer_get_option( 'footer_social_links', 'option' );
	if ( empty( $links ) || ! is_array( $links ) ) {
		return array();
	}
	return $links;
}

/**
 * Get footer Quick Links menu ID from theme location.
 * Assign menu via Appearance > Menus to "Footer Quick Links".
 *
 * @return int|null
 */
function tasheel_get_footer_quick_links_menu() {
	$locations = get_nav_menu_locations();
	return ! empty( $locations['footer-quick-links'] ) ? (int) $locations['footer-quick-links'] : null;
}

/**
 * Get footer Services menu ID from theme location.
 * Assign menu via Appearance > Menus to "Footer Services".
 *
 * @return int|null
 */
function tasheel_get_footer_services_menu() {
	$locations = get_nav_menu_locations();
	return ! empty( $locations['footer-services'] ) ? (int) $locations['footer-services'] : null;
}

/**
 * Get footer CF7 shortcode.
 *
 * @return string
 */
function tasheel_get_footer_contact_form_shortcode() {
	$shortcode = tasheel_header_footer_get_option( 'footer_contact_form_shortcode', 'option' );
	return is_string( $shortcode ) ? trim( $shortcode ) : '';
}

/**
 * Get footer options with fallbacks (translatable).
 *
 * @return array
 */
function tasheel_get_footer_options() {
	$opts = array(
		'quick_links_title'  => tasheel_header_footer_get_option( 'footer_quick_links_title', 'option' ) ?: esc_html__( 'Quick Links', 'tasheel' ),
		'services_title'     => tasheel_header_footer_get_option( 'footer_services_title', 'option' ) ?: esc_html__( 'Services', 'tasheel' ),
		'newsletter_heading' => tasheel_header_footer_get_option( 'footer_newsletter_heading', 'option' ),
		'contact_title'      => tasheel_header_footer_get_option( 'footer_contact_title', 'option' ) ?: esc_html__( 'Contact us', 'tasheel' ),
		'contact_email'      => tasheel_header_footer_get_option( 'footer_contact_email', 'option' ) ?: '',
		'contact_phone'      => tasheel_header_footer_get_option( 'footer_contact_phone', 'option' ) ?: '',
		'copyright_text'     => tasheel_header_footer_get_option( 'footer_copyright_text', 'option' ) ?: '© {year}, Saud Consult   |   All Rights Reserved',
		'legal_links'        => tasheel_header_footer_get_option( 'footer_legal_links', 'option' ),
	);
	if ( ! is_array( $opts['legal_links'] ) ) {
		$opts['legal_links'] = array();
	}
	// Default legal links when repeater is empty.
	if ( empty( $opts['legal_links'] ) ) {
		$opts['legal_links'] = array(
			array( 'link_text' => esc_html__( 'Terms and Conditions', 'tasheel' ), 'link_url' => '#' ),
			array( 'link_text' => esc_html__( 'Privacy Policy', 'tasheel' ), 'link_url' => '#' ),
		);
	}
	return $opts;
}
