<?php
/**
 * Minimal Sodium base64 polyfill for WordPress password reset when the PHP Sodium extension is missing or broken.
 *
 * WordPress 6.8+ uses sodium_bin2base64() and sodium_base64bin2bin() in password reset (get_password_reset_key,
 * wp_fast_hash, wp_verify_fast_hash). It also uses sodium_crypto_generichash(); if you get a fatal error about
 * that function, install the PHP Sodium extension or use paragonie/sodium_compat (Composer:
 * require paragonie/sodium_compat and require its autoload in wp-config before wp-settings.php).
 *
 * LOAD THIS FILE BEFORE WordPress: in wp-config.php, add this line *before* require_once(ABSPATH . 'wp-settings.php'):
 *
 *   require_once __DIR__ . '/wp-content/mu-plugins/sodium-polyfill.php';
 *
 * (Copy this file to wp-content/mu-plugins/sodium-polyfill.php so wp-config can load it.)
 *
 * Then optionally in wp-config.php (to bypass the theme's sodium check so forgot password and mail work):
 *
 *   define( 'TASHEEL_SKIP_SODIUM_CHECK', true );
 */

if ( ! defined( 'ABSPATH' ) ) {
	// Allow loading from wp-config before WordPress.
}

if ( function_exists( 'sodium_bin2base64' ) ) {
	return; // Extension already provides these.
}

// Constants (match PHP Sodium extension).
if ( ! defined( 'SODIUM_BASE64_VARIANT_ORIGINAL' ) ) {
	define( 'SODIUM_BASE64_VARIANT_ORIGINAL', 1 );
}
if ( ! defined( 'SODIUM_BASE64_VARIANT_URLSAFE' ) ) {
	define( 'SODIUM_BASE64_VARIANT_URLSAFE', 2 );
}
if ( ! defined( 'SODIUM_BASE64_VARIANT_URLSAFE_NO_PADDING' ) ) {
	define( 'SODIUM_BASE64_VARIANT_URLSAFE_NO_PADDING', 3 );
}
if ( ! defined( 'SODIUM_BASE64_VARIANT_ORIGINAL_NO_PADDING' ) ) {
	define( 'SODIUM_BASE64_VARIANT_ORIGINAL_NO_PADDING', 4 );
}

/**
 * Encode raw binary to base64 (Sodium variant).
 *
 * @param string $string Raw binary.
 * @param int    $id     SODIUM_BASE64_VARIANT_*.
 * @return string Base64 string.
 */
if ( ! function_exists( 'sodium_bin2base64' ) ) {
	function sodium_bin2base64( $string, $id ) {
		$b64 = base64_encode( $string );
		if ( $id === SODIUM_BASE64_VARIANT_URLSAFE || $id === SODIUM_BASE64_VARIANT_URLSAFE_NO_PADDING ) {
			$b64 = str_replace( array( '+', '/' ), array( '-', '_' ), $b64 );
		}
		if ( $id === SODIUM_BASE64_VARIANT_URLSAFE_NO_PADDING || $id === SODIUM_BASE64_VARIANT_ORIGINAL_NO_PADDING ) {
			$b64 = rtrim( $b64, '=' );
		}
		return $b64;
	}
}

/**
 * Decode base64 to raw binary (Sodium variant).
 *
 * @param string $string Base64 string.
 * @param int    $id     SODIUM_BASE64_VARIANT_*.
 * @return string Raw binary.
 */
if ( ! function_exists( 'sodium_base64bin2bin' ) ) {
	function sodium_base64bin2bin( $string, $id ) {
		if ( $id === SODIUM_BASE64_VARIANT_URLSAFE || $id === SODIUM_BASE64_VARIANT_URLSAFE_NO_PADDING ) {
			$string = str_replace( array( '-', '_' ), array( '+', '/' ), $string );
		}
		$pad = strlen( $string ) % 4;
		if ( $pad !== 0 && $id !== SODIUM_BASE64_VARIANT_URLSAFE_NO_PADDING && $id !== SODIUM_BASE64_VARIANT_ORIGINAL_NO_PADDING ) {
			$string .= str_repeat( '=', 4 - $pad );
		} elseif ( $pad === 2 || $pad === 3 ) {
			$string .= str_repeat( '=', 4 - $pad );
		}
		return (string) base64_decode( $string, true );
	}
}
