<?php
/**
 * ACF Vendor Registration: render vendor_form layout (Contact Form 7 shortcode).
 * Uses same flexible content as About/Contact (about_page_sections). Empty shortcode = section hidden.
 *
 * @package tasheel
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Check if vendor_form section has content (hide when shortcode empty).
 *
 * @param string $layout_name Layout key.
 * @param array  $section     ACF layout data.
 * @return bool
 */
function tasheel_vendor_section_has_content( $layout_name, $section ) {
	if ( empty( $section ) || ! is_array( $section ) ) {
		return false;
	}
	if ( $layout_name === 'vendor_form' || $layout_name === 'layout_vendor_form' ) {
		$shortcode = function_exists( 'tasheel_vendor_get_form_shortcode' ) ? tasheel_vendor_get_form_shortcode( $section ) : ( isset( $section['form_shortcode'] ) ? trim( (string) $section['form_shortcode'] ) : '' );
		return $shortcode !== '';
	}
	return false;
}

/**
 * Get vendor form shortcode from ACF section (handles different key formats).
 *
 * @param array $section ACF flexible row.
 * @return string Shortcode string or empty.
 */
function tasheel_vendor_get_form_shortcode( $section ) {
	if ( empty( $section ) || ! is_array( $section ) ) {
		return '';
	}
	// ACF usually returns sub fields by name.
	$keys = array( 'form_shortcode', 'field_vendor_form_shortcode' );
	foreach ( $keys as $key ) {
		if ( isset( $section[ $key ] ) && is_string( $section[ $key ] ) ) {
			$shortcode = trim( $section[ $key ] );
			if ( $shortcode !== '' ) {
				return $shortcode;
			}
		}
	}
	// Fallback: any value in section that looks like a CF7 shortcode.
	foreach ( $section as $k => $v ) {
		if ( $k === 'acf_fc_layout' ) {
			continue;
		}
		$v = is_string( $v ) ? trim( $v ) : '';
		if ( $v !== '' && ( strpos( $v, 'contact-form-7' ) !== false || ( strpos( $v, '[' ) === 0 && strpos( $v, ']' ) !== false ) ) ) {
			return $v;
		}
	}
	return '';
}

/**
 * Ensure string is a valid shortcode (has brackets) for do_shortcode().
 *
 * @param string $shortcode Value from ACF.
 * @return string
 */
function tasheel_vendor_normalize_shortcode( $shortcode ) {
	$shortcode = trim( $shortcode );
	if ( $shortcode === '' ) {
		return '';
	}
	// If user pasted without brackets, wrap (e.g. "contact-form-7 id=\"123\"").
	if ( strpos( $shortcode, '[' ) !== 0 ) {
		$shortcode = '[' . $shortcode . ']';
	}
	return $shortcode;
}

/**
 * Render vendor_form section: output CF7 shortcode inside vendor section wrapper.
 *
 * @param array $section ACF flexible row (acf_fc_layout + fields).
 */
function tasheel_render_vendor_flexible_section( $section ) {
	if ( empty( $section ) || ! is_array( $section ) ) {
		return;
	}
	$shortcode = tasheel_vendor_get_form_shortcode( $section );
	$shortcode = tasheel_vendor_normalize_shortcode( $shortcode );
	if ( $shortcode === '' ) {
		return;
	}
	echo '<section class="vendor_registration_section pt_80 pb_80"><div class="wrap"><div class="vendor_registration_container"><div class="vendor_registration_title">
					<h3><span>' . __('Vendor Application Form', 'tasheel') . '</span></h3>
				</div>';
	echo do_shortcode( $shortcode );
	echo '</div></div></section>';
}
