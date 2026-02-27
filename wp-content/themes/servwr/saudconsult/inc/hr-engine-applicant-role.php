<?php
/**
 * HR Engine: Applicant user role. Same capabilities as Subscriber (read).
 * Used for users who register via the careers Create Account flow.
 *
 * @package tasheel
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'TASHEEL_HR_APPLICANT_ROLE', 'applicant' );

/**
 * Register Applicant role (same capabilities as Subscriber).
 * Runs early on init so the role exists in the backend and for registration.
 */
function tasheel_hr_register_applicant_role() {
	if ( get_role( TASHEEL_HR_APPLICANT_ROLE ) ) {
		return;
	}
	add_role(
		TASHEEL_HR_APPLICANT_ROLE,
		__( 'Applicant', 'tasheel' ),
		array( 'read' => true )
	);
}

add_action( 'init', 'tasheel_hr_register_applicant_role', 1 );
add_action( 'after_setup_theme', 'tasheel_hr_register_applicant_role', 1 );
