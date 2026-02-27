<?php
/**
 * HR Engine: job application creation and checks. Theme-based (no plugin).
 *
 * @package tasheel
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Check if a user has already applied to a job.
 *
 * @param int $user_id User ID.
 * @param int $job_id  Job post ID.
 * @return bool
 */
function tasheel_hr_user_has_applied( $user_id, $job_id ) {
	if ( ! $user_id || ! $job_id ) {
		return false;
	}
	$apps = get_posts( array(
		'post_type'      => 'job_application',
		'post_status'    => 'any',
		'posts_per_page' => 1,
		'meta_query'     => array(
			array( 'key' => 'job_id', 'value' => (int) $job_id, 'compare' => '=' ),
			array( 'key' => 'user_id', 'value' => (int) $user_id, 'compare' => '=' ),
		),
	) );
	return ! empty( $apps );
}

/**
 * Check if an email has already applied to a job (guest application or logged-in user with that email).
 * FRD: one application per job per email.
 *
 * @param string $email  Email address (normalized).
 * @param int    $job_id Job post ID.
 * @return bool True if this email already has an application for this job.
 */
function tasheel_hr_email_has_applied_to_job( $email, $job_id ) {
	$email = sanitize_email( $email );
	if ( $email === '' || ! $job_id ) {
		return false;
	}
	$job_id = (int) $job_id;
	// Guest application with this email.
	$guest_apps = get_posts( array(
		'post_type'      => 'job_application',
		'post_status'    => 'any',
		'posts_per_page' => 1,
		'meta_query'     => array(
			array( 'key' => 'job_id', 'value' => $job_id, 'compare' => '=' ),
			array( 'key' => 'guest_email', 'value' => $email, 'compare' => '=' ),
		),
	) );
	if ( ! empty( $guest_apps ) ) {
		return true;
	}
	// Logged-in user with this email who applied to this job.
	$user = get_user_by( 'email', $email );
	if ( $user && tasheel_hr_user_has_applied( (int) $user->ID, $job_id ) ) {
		return true;
	}
	return false;
}

/**
 * Create a job application (logged-in user or guest).
 *
 * @param int    $user_id User ID (0 for guest).
 * @param int    $job_id  Job post ID.
 * @param array  $extra   Optional: start_date, duration (for corporate), guest_email, snapshot data.
 * @return int|false Application post ID or false.
 */
function tasheel_hr_create_application( $user_id, $job_id, $extra = array() ) {
	$job = get_post( $job_id );
	if ( ! $job || $job->post_type !== ( function_exists( 'tasheel_hr_job_post_type' ) ? tasheel_hr_job_post_type() : 'hr_job' ) ) {
		return false;
	}
	if ( $user_id && tasheel_hr_user_has_applied( $user_id, $job_id ) ) {
		return false;
	}
	$title = sprintf( /* translators: 1: job id, 2: job title, 3: applicant */ __( '%1$s %2$s – %3$s', 'tasheel' ), (int) $job_id, get_the_title( $job_id ), $user_id ? get_the_author_meta( 'display_name', $user_id ) : ( isset( $extra['guest_email'] ) ? $extra['guest_email'] : __( 'Guest', 'tasheel' ) ) );
	$app_id = wp_insert_post( array(
		'post_type'   => 'job_application',
		'post_title'  => $title,
		'post_status' => 'publish',
	) );
	if ( is_wp_error( $app_id ) || ! $app_id ) {
		return false;
	}
	update_post_meta( $app_id, 'job_id', (int) $job_id );
	$job_type_slug = function_exists( 'tasheel_hr_get_job_type_slug' ) ? tasheel_hr_get_job_type_slug( $job_id ) : '';
	if ( $job_type_slug ) {
		update_post_meta( $app_id, 'job_type_slug', $job_type_slug );
	}
	update_post_meta( $app_id, 'user_id', (int) $user_id );
	update_post_meta( $app_id, 'application_status', 'submitted' );
	if ( ! empty( $extra['start_date'] ) ) {
		update_post_meta( $app_id, 'start_date', sanitize_text_field( $extra['start_date'] ) );
	}
	if ( ! empty( $extra['duration'] ) ) {
		update_post_meta( $app_id, 'duration', sanitize_text_field( $extra['duration'] ) );
	}
	if ( isset( $extra['snapshot'] ) && is_array( $extra['snapshot'] ) ) {
		update_post_meta( $app_id, 'application_snapshot', $extra['snapshot'] );
		tasheel_hr_application_sync_filter_meta( $app_id );
	}
	if ( ! empty( $extra['guest_email'] ) ) {
		update_post_meta( $app_id, 'guest_email', sanitize_email( $extra['guest_email'] ) );
	}
	return $app_id;
}

/**
 * Sync filterable fields from application_snapshot to dedicated meta for admin filtering (FRD §11).
 * Saves: application_filter_nationality, application_filter_visa_status, application_filter_has_resume, application_filter_has_portfolio.
 *
 * @param int $app_id Job application post ID.
 */
function tasheel_hr_application_sync_filter_meta( $app_id ) {
	$snapshot = get_post_meta( $app_id, 'application_snapshot', true );
	if ( ! is_array( $snapshot ) ) {
		delete_post_meta( $app_id, 'application_filter_nationality' );
		delete_post_meta( $app_id, 'application_filter_visa_status' );
		delete_post_meta( $app_id, 'application_filter_has_resume' );
		delete_post_meta( $app_id, 'application_filter_has_portfolio' );
		return;
	}
	if ( isset( $snapshot['profile_nationality'] ) && (string) $snapshot['profile_nationality'] !== '' ) {
		update_post_meta( $app_id, 'application_filter_nationality', sanitize_text_field( $snapshot['profile_nationality'] ) );
	} else {
		delete_post_meta( $app_id, 'application_filter_nationality' );
	}
	if ( isset( $snapshot['profile_visa_status'] ) && (string) $snapshot['profile_visa_status'] !== '' ) {
		$visa_val = sanitize_text_field( $snapshot['profile_visa_status'] );
		$visa_val = ( $visa_val === 'box1' ) ? 'has_visa' : ( ( $visa_val === 'box2' ) ? 'no_visa' : $visa_val );
		update_post_meta( $app_id, 'application_filter_visa_status', $visa_val );
	} else {
		delete_post_meta( $app_id, 'application_filter_visa_status' );
	}
	$has_resume = 0;
	if ( ! empty( $snapshot['profile_resume'] ) ) {
		if ( is_array( $snapshot['profile_resume'] ) && ! empty( $snapshot['profile_resume']['url'] ) ) {
			$has_resume = 1;
		} elseif ( is_string( $snapshot['profile_resume'] ) && trim( $snapshot['profile_resume'] ) !== '' ) {
			$has_resume = 1;
		}
	}
	update_post_meta( $app_id, 'application_filter_has_resume', $has_resume );
	$has_portfolio = 0;
	if ( ! empty( $snapshot['profile_portfolio'] ) && is_string( $snapshot['profile_portfolio'] ) && trim( $snapshot['profile_portfolio'] ) !== '' ) {
		$has_portfolio = 1;
	} elseif ( ! empty( $snapshot['profile_portfolio'] ) && is_array( $snapshot['profile_portfolio'] ) ) {
		$has_portfolio = 1;
	}
	update_post_meta( $app_id, 'application_filter_has_portfolio', $has_portfolio );
}

/**
 * Handle submit application request (POST from my-profile or create-profile).
 */
function tasheel_hr_handle_submit_application() {
	if ( ! isset( $_POST['tasheel_hr_submit_application'] ) || ! isset( $_POST['apply_to'] ) ) {
		return;
	}
	$job_id = (int) $_POST['apply_to'];
	if ( ! $job_id ) {
		return;
	}
	if ( ! wp_verify_nonce( isset( $_POST['_wpnonce'] ) ? $_POST['_wpnonce'] : '', 'tasheel_hr_apply_' . $job_id ) ) {
		return;
	}
	$user_id = get_current_user_id();
	if ( ! $user_id ) {
		$create_url = function_exists( 'tasheel_hr_create_profile_url' ) ? tasheel_hr_create_profile_url( $job_id ) : add_query_arg( array( 'apply_to' => $job_id, 'login' => '1' ), home_url( '/create-profile/' ) );
		wp_safe_redirect( add_query_arg( 'login', '1', $create_url ) );
		exit;
	}
	// One application per job per email (FRD): block if this user's email already applied (as user or guest).
	$user_email = get_the_author_meta( 'user_email', $user_id );
	if ( function_exists( 'tasheel_hr_email_has_applied_to_job' ) && tasheel_hr_email_has_applied_to_job( $user_email, $job_id ) ) {
		$my_profile_url = function_exists( 'tasheel_hr_my_profile_url' ) ? tasheel_hr_my_profile_url( $job_id ) : add_query_arg( 'apply_to', $job_id, home_url( '/my-profile/' ) );
		wp_safe_redirect( add_query_arg( 'apply_error', 'already_applied', $my_profile_url ) );
		exit;
	}
	// Validate required profile fields for this job type before creating application.
	$raw_slug = function_exists( 'tasheel_hr_get_job_type_slug' ) ? tasheel_hr_get_job_type_slug( $job_id ) : '';
	$job_type_slug = function_exists( 'tasheel_hr_normalize_job_type_slug' ) ? tasheel_hr_normalize_job_type_slug( $raw_slug ) : ( $raw_slug ?: 'career' );
	$missing = function_exists( 'tasheel_hr_profile_missing_required_fields' ) ? tasheel_hr_profile_missing_required_fields( $user_id, $job_type_slug ) : array();
	if ( ! empty( $missing ) ) {
		$my_profile_url = function_exists( 'tasheel_hr_my_profile_url' ) ? tasheel_hr_my_profile_url( $job_id ) : add_query_arg( 'apply_to', $job_id, home_url( '/my-profile/' ) );
		set_transient( 'tasheel_hr_apply_missing_' . $user_id, array( 'job_id' => $job_id, 'missing' => $missing ), 120 );
		wp_safe_redirect( add_query_arg( 'apply_error', '1', $my_profile_url ) );
		exit;
	}
	// Training/corporate: require Start Date and Duration from popup; submission not valid without them.
	if ( $job_type_slug === 'corporate_training' ) {
		$start_date = isset( $_POST['start_date'] ) ? sanitize_text_field( wp_unslash( $_POST['start_date'] ) ) : '';
		$duration   = isset( $_POST['duration'] ) ? sanitize_text_field( wp_unslash( $_POST['duration'] ) ) : '';
		if ( $start_date === '' || $duration === '' ) {
			$my_profile_url = function_exists( 'tasheel_hr_my_profile_url' ) ? tasheel_hr_my_profile_url( $job_id ) : add_query_arg( 'apply_to', $job_id, home_url( '/my-profile/' ) );
			set_transient( 'tasheel_hr_apply_training_missing_' . $user_id, array( 'job_id' => $job_id ), 120 );
			wp_safe_redirect( add_query_arg( 'apply_error', 'training', $my_profile_url ) );
			exit;
		}
	}
	$extra = array();
	if ( ! empty( $_POST['start_date'] ) ) {
		$extra['start_date'] = sanitize_text_field( wp_unslash( $_POST['start_date'] ) );
	}
	if ( ! empty( $_POST['duration'] ) ) {
		$extra['duration'] = sanitize_text_field( wp_unslash( $_POST['duration'] ) );
	}
	// Final guard: never create application if required fields are still missing (same check as AJAX).
	$missing_again = function_exists( 'tasheel_hr_profile_missing_required_fields' ) ? tasheel_hr_profile_missing_required_fields( $user_id, $job_type_slug ) : array();
	if ( ! empty( $missing_again ) ) {
		$my_profile_url = function_exists( 'tasheel_hr_my_profile_url' ) ? tasheel_hr_my_profile_url( $job_id ) : add_query_arg( 'apply_to', $job_id, home_url( '/my-profile/' ) );
		set_transient( 'tasheel_hr_apply_missing_' . $user_id, array( 'job_id' => $job_id, 'missing' => $missing_again ), 120 );
		wp_safe_redirect( add_query_arg( 'apply_error', '1', $my_profile_url ) );
		exit;
	}
	// Snapshot = immutable point-in-time copy of submitted data. Never read from live user profile.
	if ( function_exists( 'tasheel_hr_get_user_profile' ) ) {
		$full_profile = tasheel_hr_get_user_profile( $user_id );
		$job_type_slug = function_exists( 'tasheel_hr_get_job_type_slug' ) ? tasheel_hr_get_job_type_slug( $job_id ) : 'career';
		$snapshot_keys = function_exists( 'tasheel_hr_snapshot_keys_for_job_type' ) ? tasheel_hr_snapshot_keys_for_job_type( $job_type_slug ) : array_keys( $full_profile );
		$extra['snapshot'] = array();
		foreach ( $snapshot_keys as $key ) {
			if ( array_key_exists( $key, $full_profile ) ) {
				$val = $full_profile[ $key ];
				// User meta stores education/experience/recent_projects as JSON; normalize to array for snapshot.
				$extra['snapshot'][ $key ] = tasheel_hr_normalize_snapshot_value( $key, $val );
			}
		}
		$extra['snapshot']['job_id']    = (string) $job_id;
		$extra['snapshot']['job_title'] = get_the_title( $job_id );
		if ( ! isset( $extra['snapshot']['profile_email'] ) ) {
			$user = get_user_by( 'id', $user_id );
			$extra['snapshot']['profile_email'] = $user ? $user->user_email : '';
		}
	}
	$app_id = tasheel_hr_create_application( $user_id, $job_id, $extra );
	if ( $app_id ) {
		tasheel_hr_send_application_emails( $app_id, $user_id, $job_id );
	}
	$received_url = home_url( '/application-received/' );
	if ( $app_id ) {
		$received_url = add_query_arg( 'application_id', $app_id, $received_url );
	}
	wp_safe_redirect( $received_url );
	exit;
}

add_action( 'init', 'tasheel_hr_handle_submit_application', 2 );

/**
 * Normalize a snapshot value for storage/display. User meta stores education, experience, recent_projects as JSON strings.
 * Returns array for repeater fields; pass-through for others.
 *
 * @param string $key Snapshot key (e.g. profile_education, profile_experience).
 * @param mixed  $val Raw value from user meta or snapshot.
 * @return mixed Normalized value (array for repeaters, original otherwise).
 */
function tasheel_hr_normalize_snapshot_value( $key, $val ) {
	$repeater_keys = array( 'profile_education', 'profile_experience', 'profile_recent_projects', 'profile_licenses' );
	if ( ! in_array( $key, $repeater_keys, true ) ) {
		return $val;
	}
	if ( is_array( $val ) && ! empty( $val ) ) {
		return $val;
	}
	if ( is_string( $val ) && $val !== '' ) {
		$decoded = json_decode( $val, true );
		return is_array( $decoded ) ? $decoded : array();
	}
	return array();
}

/**
 * Build guest profile snapshot from POST and FILES (for corporate training guest apply).
 * Returns array compatible with application_snapshot (profile_* keys + job_id/job_title set by caller).
 *
 * @return array Snapshot array; profile_resume may be array with url/key if file uploaded.
 */
function tasheel_hr_build_guest_snapshot_from_post() {
	$snapshot = array();
	$post_data = isset( $_POST ) ? wp_unslash( $_POST ) : array();
	$keys = array(
		'profile_title', 'profile_first_name', 'profile_last_name', 'profile_phone', 'profile_gender',
		'profile_marital_status', 'profile_dob', 'profile_national_status', 'profile_nationality', 'profile_location',
		'profile_linkedin', 'profile_education', 'profile_resume', 'profile_portfolio',
	);
	foreach ( $keys as $key ) {
		if ( isset( $post_data[ $key ] ) ) {
			$val = $post_data[ $key ];
			if ( is_array( $val ) ) {
				$snapshot[ $key ] = array_map( 'sanitize_text_field', $val );
			} else {
				$snapshot[ $key ] = sanitize_text_field( (string) $val );
			}
		}
	}
	// profile_education may be array of entries from form (e.g. profile_education[0][degree]).
	if ( isset( $post_data['profile_education'] ) && is_array( $post_data['profile_education'] ) ) {
		$edu = array();
		foreach ( $post_data['profile_education'] as $i => $row ) {
			if ( ! is_array( $row ) ) {
				continue;
			}
			$edu[] = array_map( 'sanitize_text_field', $row );
		}
		$snapshot['profile_education'] = $edu;
	}
	$snapshot['_file_errors'] = array();
	// Resume file: validate type/size (5MB) then upload.
	if ( ! empty( $_FILES['profile_resume']['name'] ) && ! empty( $_FILES['profile_resume']['tmp_name'] ) ) {
		$resume_err = function_exists( 'tasheel_hr_validate_profile_document_upload' ) ? tasheel_hr_validate_profile_document_upload( 'profile_resume', array( 'pdf', 'doc', 'docx' ), 5 ) : '';
		if ( $resume_err !== '' ) {
			$snapshot['_file_errors']['profile_resume'] = $resume_err;
		} else {
			require_once ABSPATH . 'wp-admin/includes/file.php';
			$file = $_FILES['profile_resume'];
			$upload = wp_handle_upload( $file, array( 'test_form' => false, 'mimes' => array( 'pdf' => 'application/pdf', 'doc' => 'application/msword', 'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' ) ) );
			if ( ! empty( $upload['url'] ) ) {
				$snapshot['profile_resume'] = array( 'url' => $upload['url'], 'file' => isset( $upload['file'] ) ? $upload['file'] : $upload['url'] );
			}
		}
	}
	// Profile photo (guest): validate (PNG/JPG only, max 1MB) then handle upload.
	if ( ! empty( $_FILES['profile_photo']['name'] ) && ! empty( $_FILES['profile_photo']['tmp_name'] ) ) {
		$photo_err = function_exists( 'tasheel_hr_validate_profile_photo_upload' ) ? tasheel_hr_validate_profile_photo_upload() : '';
		if ( $photo_err !== '' ) {
			$snapshot['_file_errors']['profile_photo'] = $photo_err;
		} else {
			require_once ABSPATH . 'wp-admin/includes/file.php';
			$file   = $_FILES['profile_photo'];
			$upload = wp_handle_upload( $file, array( 'test_form' => false, 'mimes' => array( 'jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg', 'png' => 'image/png' ) ) );
			if ( ! empty( $upload['url'] ) ) {
				$snapshot['profile_photo'] = $upload['url'];
			}
		}
	}
	// Portfolio file (guest): validate type/size (5MB) then upload.
	if ( ! empty( $_FILES['profile_portfolio']['name'] ) && ! empty( $_FILES['profile_portfolio']['tmp_name'] ) ) {
		$port_err = function_exists( 'tasheel_hr_validate_profile_document_upload' ) ? tasheel_hr_validate_profile_document_upload( 'profile_portfolio', array( 'pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png' ), 5 ) : '';
		if ( $port_err !== '' ) {
			$snapshot['_file_errors']['profile_portfolio'] = $port_err;
		} else {
			require_once ABSPATH . 'wp-admin/includes/file.php';
			$file = $_FILES['profile_portfolio'];
			$upload = wp_handle_upload( $file, array( 'test_form' => false, 'mimes' => array( 'pdf' => 'application/pdf', 'doc' => 'application/msword', 'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg', 'png' => 'image/png' ) ) );
			if ( ! empty( $upload['url'] ) ) {
				$snapshot['profile_portfolio'] = $upload['url'];
			}
		}
	}
	return $snapshot;
}

/**
 * Handle guest application: step "review" (save and redirect to Guest Profile) or "submit" (from Guest Profile, create application).
 * POST: tasheel_hr_guest_apply=1, apply_to=JOB_ID, _wpnonce. If step=review: profile fields, then redirect to guest-profile. If step=submit: review_token, start_date, duration.
 */
function tasheel_hr_handle_guest_application() {
	if ( $_SERVER['REQUEST_METHOD'] !== 'POST' || empty( $_POST['tasheel_hr_guest_apply'] ) || empty( $_POST['apply_to'] ) ) {
		return;
	}
	// AJAX review step returns JSON; do not run redirect logic here.
	if ( defined( 'DOING_AJAX' ) && DOING_AJAX && ! empty( $_POST['action'] ) && $_POST['action'] === 'tasheel_hr_guest_apply_review_ajax' ) {
		return;
	}
	$job_id = (int) $_POST['apply_to'];
	if ( ! $job_id ) {
		return;
	}
	// Block logged-in users from applying as guest (FRD: use account to apply).
	if ( get_current_user_id() ) {
		wp_safe_redirect( add_query_arg( array( 'guest_error' => 'logged_in', 'apply_to' => $job_id ), home_url( '/apply-as-a-guest/' ) ) );
		exit;
	}
	if ( ! wp_verify_nonce( isset( $_POST['_wpnonce'] ) ? $_POST['_wpnonce'] : '', 'tasheel_hr_guest_apply_' . $job_id ) ) {
		wp_safe_redirect( add_query_arg( 'guest_error', 'nonce', home_url( '/apply-as-a-guest/?apply_to=' . $job_id ) ) );
		exit;
	}
	$job_type_slug = function_exists( 'tasheel_hr_get_job_type_slug' ) ? tasheel_hr_get_job_type_slug( $job_id ) : '';
	$job_type_slug = function_exists( 'tasheel_hr_normalize_job_type_slug' ) ? tasheel_hr_normalize_job_type_slug( $job_type_slug ) : ( $job_type_slug ?: 'career' );
	if ( $job_type_slug !== 'corporate_training' ) {
		wp_safe_redirect( add_query_arg( 'guest_error', 'type', home_url( '/apply-as-a-guest/' ) ) );
		exit;
	}
	$job = get_post( $job_id );
	if ( ! $job || $job->post_type !== ( function_exists( 'tasheel_hr_job_post_type' ) ? tasheel_hr_job_post_type() : 'hr_job' ) ) {
		wp_safe_redirect( add_query_arg( 'guest_error', 'job', home_url( '/apply-as-a-guest/' ) ) );
		exit;
	}

	// Step: submit from Guest Profile page (review token + start_date + duration only).
	$step = isset( $_POST['step'] ) ? sanitize_text_field( wp_unslash( $_POST['step'] ) ) : '';
	$review_token = isset( $_POST['review_token'] ) ? sanitize_text_field( wp_unslash( $_POST['review_token'] ) ) : '';
	if ( $step === 'submit' && $review_token !== '' ) {
		$stored = get_transient( 'tasheel_guest_review_' . $review_token );
		if ( empty( $stored ) || ! is_array( $stored ) || (int) ( isset( $stored['job_id'] ) ? $stored['job_id'] : 0 ) !== $job_id ) {
			wp_safe_redirect( add_query_arg( 'guest_error', 'expired', home_url( '/apply-as-a-guest/?apply_to=' . $job_id ) ) );
			exit;
		}
		$snapshot   = isset( $stored['snapshot'] ) ? $stored['snapshot'] : array();
		$guest_email = isset( $stored['guest_email'] ) ? sanitize_email( $stored['guest_email'] ) : '';
		$start_date = isset( $_POST['start_date'] ) ? sanitize_text_field( wp_unslash( $_POST['start_date'] ) ) : '';
		$duration   = isset( $_POST['duration'] ) ? sanitize_text_field( wp_unslash( $_POST['duration'] ) ) : '';
		if ( $guest_email === '' || $start_date === '' || $duration === '' ) {
			wp_safe_redirect( add_query_arg( array( 'guest_error' => 'training', 'review_token' => $review_token, 'apply_to' => $job_id ), home_url( '/guest-profile/' ) ) );
			exit;
		}
		// One application per job per email (FRD).
		if ( function_exists( 'tasheel_hr_email_has_applied_to_job' ) && tasheel_hr_email_has_applied_to_job( $guest_email, $job_id ) ) {
			wp_safe_redirect( add_query_arg( array( 'guest_error' => 'already_applied', 'apply_to' => $job_id ), home_url( '/apply-as-a-guest/' ) ) );
			exit;
		}
		$snapshot['job_id'] = (string) $job_id;
		$snapshot['job_title'] = get_the_title( $job_id );
		$snapshot['profile_email'] = $guest_email;
		$extra = array( 'guest_email' => $guest_email, 'snapshot' => $snapshot, 'start_date' => $start_date, 'duration' => $duration );
		$app_id = tasheel_hr_create_application( 0, $job_id, $extra );
		if ( $app_id && function_exists( 'tasheel_hr_send_application_emails' ) ) {
			tasheel_hr_send_application_emails( $app_id, 0, $job_id );
		}
		delete_transient( 'tasheel_guest_review_' . $review_token );
		$received_url = home_url( '/application-received/' );
		if ( $app_id ) {
			$received_url = add_query_arg( 'application_id', $app_id, $received_url );
		}
		wp_safe_redirect( $received_url );
		exit;
	}

	// Step: review – build snapshot from POST, validate, save to transient, redirect to Guest Profile.
	$snapshot = tasheel_hr_build_guest_snapshot_from_post();
	$guest_email = isset( $_POST['guest_email'] ) ? sanitize_email( wp_unslash( $_POST['guest_email'] ) ) : '';
	if ( empty( $guest_email ) ) {
		$guest_email = isset( $_POST['profile_email'] ) ? sanitize_email( wp_unslash( $_POST['profile_email'] ) ) : '';
	}
	if ( empty( $guest_email ) ) {
		wp_safe_redirect( add_query_arg( array( 'guest_error' => 'email', 'apply_to' => $job_id ), home_url( '/apply-as-a-guest/' ) ) );
		exit;
	}
	// One application per job per email (FRD).
	if ( function_exists( 'tasheel_hr_email_has_applied_to_job' ) && tasheel_hr_email_has_applied_to_job( $guest_email, $job_id ) ) {
		wp_safe_redirect( add_query_arg( array( 'guest_error' => 'already_applied', 'apply_to' => $job_id ), home_url( '/apply-as-a-guest/' ) ) );
		exit;
	}
	$snapshot['job_id'] = (string) $job_id;
	$snapshot['job_title'] = get_the_title( $job_id );
	$snapshot['profile_email'] = $guest_email;
	// When editing from Guest Profile (review_token present), preserve existing photo/resume if not re-uploaded.
	$edit_token = isset( $_POST['review_token'] ) ? sanitize_text_field( wp_unslash( $_POST['review_token'] ) ) : '';
	if ( $edit_token !== '' ) {
		$stored = get_transient( 'tasheel_guest_review_' . $edit_token );
		if ( is_array( $stored ) && (int) ( isset( $stored['job_id'] ) ? $stored['job_id'] : 0 ) === $job_id && ! empty( $stored['snapshot'] ) ) {
			$prev = $stored['snapshot'];
			if ( ( empty( $snapshot['profile_resume'] ) || ( is_array( $snapshot['profile_resume'] ) && empty( $snapshot['profile_resume']['url'] ) ) ) && ! empty( $prev['profile_resume'] ) ) {
				$snapshot['profile_resume'] = $prev['profile_resume'];
			}
		}
	}
	$missing = array();
	$guest_required = array( 'profile_title', 'profile_first_name', 'profile_last_name', 'profile_phone', 'profile_gender', 'profile_marital_status', 'profile_dob', 'profile_national_status', 'profile_nationality', 'profile_location' );
	foreach ( $guest_required as $k ) {
		if ( empty( $snapshot[ $k ] ) || ( is_string( $snapshot[ $k ] ) && trim( $snapshot[ $k ] ) === '' ) ) {
			$missing[] = $k;
		} elseif ( $k === 'profile_phone' && ( ! function_exists( 'tasheel_hr_profile_phone_is_valid' ) || ! tasheel_hr_profile_phone_is_valid( $snapshot[ $k ] ) ) ) {
			$missing[] = $k;
		}
	}
	if ( empty( $snapshot['profile_resume'] ) || ( is_array( $snapshot['profile_resume'] ) && empty( $snapshot['profile_resume']['url'] ) ) ) {
		$missing[] = 'profile_resume';
	}
	if ( empty( $snapshot['profile_education'] ) || ! is_array( $snapshot['profile_education'] ) ) {
		$missing[] = 'profile_education';
	} else {
		$edu_reqd = array( 'degree', 'institute', 'major', 'start_date', 'end_date', 'city', 'country', 'gpa', 'avg_grade', 'mode' );
		$has_valid_edu = false;
		foreach ( $snapshot['profile_education'] as $e ) {
			if ( ! is_array( $e ) ) {
				continue;
			}
			$under_process = ! empty( $e['under_process'] );
			$ok = true;
			foreach ( $edu_reqd as $fk ) {
				if ( $fk === 'end_date' && $under_process ) {
					continue;
				}
				if ( empty( $e[ $fk ] ) || trim( (string) $e[ $fk ] ) === '' ) {
					$ok = false;
					break;
				}
			}
			if ( $ok ) {
				$has_valid_edu = true;
				break;
			}
		}
		if ( ! $has_valid_edu ) {
			$missing[] = 'profile_education';
		}
	}
	$photo_err = function_exists( 'tasheel_hr_validate_profile_photo_upload' ) ? tasheel_hr_validate_profile_photo_upload() : '';
	if ( $photo_err !== '' ) {
		$missing[] = 'profile_photo';
	}
	$file_errors = isset( $snapshot['_file_errors'] ) && is_array( $snapshot['_file_errors'] ) ? $snapshot['_file_errors'] : array();
	foreach ( $file_errors as $fk => $msg ) {
		if ( ! in_array( $fk, $missing, true ) ) {
			$missing[] = $fk;
		}
	}
	$format_errors = function_exists( 'tasheel_hr_profile_format_validation' ) ? tasheel_hr_profile_format_validation( $snapshot ) : array();
	foreach ( $format_errors as $fk => $msg ) {
		if ( ! in_array( $fk, $missing, true ) ) {
			$missing[] = $fk;
		}
	}
	if ( ! empty( $missing ) ) {
		$required_msg = __( 'is required.', 'tasheel' );
		$field_errors = array();
		foreach ( $missing as $mk ) {
			if ( isset( $file_errors[ $mk ] ) ) {
				$field_errors[ $mk ] = $file_errors[ $mk ];
			} elseif ( isset( $format_errors[ $mk ] ) ) {
				$field_errors[ $mk ] = $format_errors[ $mk ];
			} elseif ( $mk === 'profile_photo' && $photo_err !== '' ) {
				$field_errors[ $mk ] = $photo_err;
			} else {
				$field_errors[ $mk ] = ( function_exists( 'tasheel_hr_get_field_error_message' )
					? tasheel_hr_get_field_error_message( $mk, isset( $snapshot[ $mk ] ) ? $snapshot[ $mk ] : '', $required_msg )
					: ( ( function_exists( 'tasheel_hr_profile_field_error_label' ) ? tasheel_hr_profile_field_error_label( $mk ) : $mk ) . ' ' . $required_msg ) );
			}
		}
		set_transient( 'tasheel_guest_apply_missing', array( 'job_id' => $job_id, 'missing' => $missing, 'submitted' => $snapshot, 'field_errors' => $field_errors ), 120 );
		wp_safe_redirect( add_query_arg( array( 'guest_error' => 'missing', 'apply_to' => $job_id ), home_url( '/apply-as-a-guest/' ) ) );
		exit;
	}
	$start_date = isset( $_POST['start_date'] ) ? sanitize_text_field( wp_unslash( $_POST['start_date'] ) ) : '';
	$duration   = isset( $_POST['duration'] ) ? sanitize_text_field( wp_unslash( $_POST['duration'] ) ) : '';
	unset( $snapshot['_file_errors'] );
	// Save for Guest Profile review step; redirect to guest-profile with token.
	$review_token = wp_generate_password( 32, false );
	set_transient( 'tasheel_guest_review_' . $review_token, array( 'job_id' => $job_id, 'guest_email' => $guest_email, 'snapshot' => $snapshot, 'start_date' => $start_date, 'duration' => $duration ), 600 );
	$guest_profile_url = home_url( '/guest-profile/' );
	wp_safe_redirect( add_query_arg( array( 'review_token' => $review_token, 'apply_to' => $job_id ), $guest_profile_url ) );
	exit;
}

add_action( 'init', 'tasheel_hr_handle_guest_application', 3 );

/**
 * AJAX: Guest apply "Review Profile" step. Same validation as init handler; returns JSON so page does not reload (data preserved).
 */
function tasheel_hr_guest_apply_review_ajax() {
	if ( get_current_user_id() ) {
		wp_send_json_error( array( 'code' => 'logged_in', 'message' => __( 'You already have an account. Please use your account to apply.', 'tasheel' ) ) );
	}
	$job_id = isset( $_POST['apply_to'] ) ? (int) $_POST['apply_to'] : 0;
	if ( ! $job_id ) {
		wp_send_json_error( array( 'code' => 'invalid', 'message' => __( 'Missing job.', 'tasheel' ) ) );
	}
	if ( ! wp_verify_nonce( isset( $_POST['_wpnonce'] ) ? $_POST['_wpnonce'] : '', 'tasheel_hr_guest_apply_' . $job_id ) ) {
		wp_send_json_error( array( 'code' => 'nonce', 'message' => __( 'Security check failed. Please refresh and try again.', 'tasheel' ) ) );
	}
	$job_type_slug = function_exists( 'tasheel_hr_get_job_type_slug' ) ? tasheel_hr_get_job_type_slug( $job_id ) : '';
	$job_type_slug = function_exists( 'tasheel_hr_normalize_job_type_slug' ) ? tasheel_hr_normalize_job_type_slug( $job_type_slug ) : ( $job_type_slug ?: 'career' );
	if ( $job_type_slug !== 'corporate_training' ) {
		wp_send_json_error( array( 'code' => 'type', 'message' => __( 'Guest apply is only for Corporate Training.', 'tasheel' ) ) );
	}
	$job = get_post( $job_id );
	if ( ! $job || $job->post_type !== ( function_exists( 'tasheel_hr_job_post_type' ) ? tasheel_hr_job_post_type() : 'hr_job' ) ) {
		wp_send_json_error( array( 'code' => 'job', 'message' => __( 'Invalid job.', 'tasheel' ) ) );
	}
	$step = isset( $_POST['step'] ) ? sanitize_text_field( wp_unslash( $_POST['step'] ) ) : '';
	if ( $step !== 'review' ) {
		wp_send_json_error( array( 'code' => 'invalid', 'message' => __( 'Invalid step.', 'tasheel' ) ) );
	}
	$snapshot = tasheel_hr_build_guest_snapshot_from_post();
	$guest_email = isset( $_POST['guest_email'] ) ? sanitize_email( wp_unslash( $_POST['guest_email'] ) ) : '';
	if ( empty( $guest_email ) ) {
		$guest_email = isset( $_POST['profile_email'] ) ? sanitize_email( wp_unslash( $_POST['profile_email'] ) ) : '';
	}
	$snapshot['job_id'] = (string) $job_id;
	$snapshot['job_title'] = get_the_title( $job_id );
	$snapshot['profile_email'] = $guest_email;
	$edit_token = isset( $_POST['review_token'] ) ? sanitize_text_field( wp_unslash( $_POST['review_token'] ) ) : '';
	if ( $edit_token !== '' ) {
		$stored = get_transient( 'tasheel_guest_review_' . $edit_token );
		if ( is_array( $stored ) && (int) ( isset( $stored['job_id'] ) ? $stored['job_id'] : 0 ) === $job_id && ! empty( $stored['snapshot'] ) ) {
			$prev = $stored['snapshot'];
			if ( ( empty( $snapshot['profile_resume'] ) || ( is_array( $snapshot['profile_resume'] ) && empty( $snapshot['profile_resume']['url'] ) ) ) && ! empty( $prev['profile_resume'] ) ) {
				$snapshot['profile_resume'] = $prev['profile_resume'];
			}
		}
	}
	$missing = array();
	if ( empty( $guest_email ) ) {
		$missing[] = 'guest_email';
	}
	$guest_required = array( 'profile_title', 'profile_first_name', 'profile_last_name', 'profile_phone', 'profile_gender', 'profile_marital_status', 'profile_dob', 'profile_national_status', 'profile_nationality', 'profile_location' );
	foreach ( $guest_required as $k ) {
		if ( empty( $snapshot[ $k ] ) || ( is_string( $snapshot[ $k ] ) && trim( $snapshot[ $k ] ) === '' ) ) {
			$missing[] = $k;
		} elseif ( $k === 'profile_phone' && ( ! function_exists( 'tasheel_hr_profile_phone_is_valid' ) || ! tasheel_hr_profile_phone_is_valid( $snapshot[ $k ] ) ) ) {
			$missing[] = $k;
		}
	}
	if ( empty( $snapshot['profile_resume'] ) || ( is_array( $snapshot['profile_resume'] ) && empty( $snapshot['profile_resume']['url'] ) ) ) {
		$missing[] = 'profile_resume';
	}
	$edu_reqd = array( 'degree', 'institute', 'major', 'start_date', 'end_date', 'city', 'country', 'gpa', 'avg_grade', 'mode' );
	$edu_reqd_labels = array(
		'degree'     => __( 'Degree', 'tasheel' ),
		'institute'  => __( 'Institute', 'tasheel' ),
		'major'      => __( 'Major', 'tasheel' ),
		'start_date' => __( 'Start Date', 'tasheel' ),
		'end_date'   => __( 'End Date', 'tasheel' ),
		'city'       => __( 'City', 'tasheel' ),
		'country'    => __( 'Country', 'tasheel' ),
		'gpa'        => __( 'GPA', 'tasheel' ),
		'avg_grade'  => __( 'Average Grade', 'tasheel' ),
		'mode'       => __( 'Mode of study', 'tasheel' ),
	);
	$required_msg_edu = __( 'is required.', 'tasheel' );
	$education_block_errors = array();
	if ( empty( $snapshot['profile_education'] ) || ! is_array( $snapshot['profile_education'] ) ) {
		$missing[] = 'profile_education';
		// No entries: mark all required sub-fields of first block (index 0) so client shows error under each field.
		foreach ( $edu_reqd as $fk ) {
			$err_key = 'profile_education_0_' . $fk;
			$education_block_errors[ $err_key ] = function_exists( 'tasheel_hr_get_field_error_message' ) ? tasheel_hr_get_field_error_message( $err_key, '', $required_msg_edu ) : ( ( isset( $edu_reqd_labels[ $fk ] ) ? $edu_reqd_labels[ $fk ] : $fk ) . ' ' . $required_msg_edu );
		}
	} else {
		$has_valid_edu = false;
		foreach ( $snapshot['profile_education'] as $idx => $e ) {
			if ( ! is_array( $e ) ) {
				continue;
			}
			$under_process = ! empty( $e['under_process'] );
			$ok = true;
			foreach ( $edu_reqd as $fk ) {
				if ( $fk === 'end_date' && $under_process ) {
					continue;
				}
				if ( empty( $e[ $fk ] ) || trim( (string) $e[ $fk ] ) === '' ) {
					$ok = false;
					break;
				}
			}
			if ( $ok ) {
				$has_valid_edu = true;
			} else {
				// Per-field errors for this incomplete block (same message format as Create Profile).
				$idx = (int) $idx;
				foreach ( $edu_reqd as $fk ) {
					if ( $fk === 'end_date' && $under_process ) {
						continue;
					}
					if ( empty( $e[ $fk ] ) || trim( (string) $e[ $fk ] ) === '' ) {
						$err_key = 'profile_education_' . $idx . '_' . $fk;
						$education_block_errors[ $err_key ] = function_exists( 'tasheel_hr_get_field_error_message' ) ? tasheel_hr_get_field_error_message( $err_key, '', $required_msg_edu ) : ( ( isset( $edu_reqd_labels[ $fk ] ) ? $edu_reqd_labels[ $fk ] : $fk ) . ' ' . $required_msg_edu );
					}
				}
			}
		}
		if ( ! $has_valid_edu ) {
			$missing[] = 'profile_education';
			// If no per-block errors were added (e.g. empty rows), add for index 0.
			if ( empty( $education_block_errors ) ) {
				foreach ( $edu_reqd as $fk ) {
					$err_key = 'profile_education_0_' . $fk;
					$education_block_errors[ $err_key ] = function_exists( 'tasheel_hr_get_field_error_message' ) ? tasheel_hr_get_field_error_message( $err_key, '', $required_msg_edu ) : ( ( isset( $edu_reqd_labels[ $fk ] ) ? $edu_reqd_labels[ $fk ] : $fk ) . ' ' . $required_msg_edu );
				}
			}
		}
	}
	// Training Program Enrollment (guest apply only).
	$start_date = isset( $_POST['start_date'] ) ? sanitize_text_field( wp_unslash( $_POST['start_date'] ) ) : '';
	$duration   = isset( $_POST['duration'] ) ? sanitize_text_field( wp_unslash( $_POST['duration'] ) ) : '';
	if ( empty( $start_date ) ) {
		$missing[] = 'start_date';
	}
	if ( empty( $duration ) ) {
		$missing[] = 'duration';
	}
	$photo_err = function_exists( 'tasheel_hr_validate_profile_photo_upload' ) ? tasheel_hr_validate_profile_photo_upload() : '';
	if ( $photo_err !== '' ) {
		$missing[] = 'profile_photo';
	}
	$file_errors = isset( $snapshot['_file_errors'] ) && is_array( $snapshot['_file_errors'] ) ? $snapshot['_file_errors'] : array();
	foreach ( $file_errors as $fk => $msg ) {
		if ( ! in_array( $fk, $missing, true ) ) {
			$missing[] = $fk;
		}
	}
	$format_errors = function_exists( 'tasheel_hr_profile_format_validation' ) ? tasheel_hr_profile_format_validation( $snapshot ) : array();
	foreach ( $format_errors as $fk => $msg ) {
		if ( ! in_array( $fk, $missing, true ) ) {
			$missing[] = $fk;
		}
	}
	if ( ! empty( $missing ) ) {
		$required_msg = __( 'is required.', 'tasheel' );
		$field_errors = array();
		foreach ( $missing as $mk ) {
			if ( isset( $file_errors[ $mk ] ) ) {
				$field_errors[ $mk ] = $file_errors[ $mk ];
			} elseif ( isset( $format_errors[ $mk ] ) ) {
				$field_errors[ $mk ] = $format_errors[ $mk ];
			} elseif ( $mk === 'profile_photo' && $photo_err !== '' ) {
				$field_errors[ $mk ] = $photo_err;
			} elseif ( $mk === 'guest_email' ) {
				$field_errors[ $mk ] = __( 'Email address', 'tasheel' ) . ' ' . $required_msg;
			} elseif ( $mk === 'start_date' ) {
				$field_errors[ $mk ] = __( 'Start Date', 'tasheel' ) . ' ' . $required_msg;
			} elseif ( $mk === 'duration' ) {
				$field_errors[ $mk ] = __( 'Duration Time', 'tasheel' ) . ' ' . $required_msg;
			} else {
				$field_errors[ $mk ] = function_exists( 'tasheel_hr_get_field_error_message' )
					? tasheel_hr_get_field_error_message( $mk, isset( $snapshot[ $mk ] ) ? $snapshot[ $mk ] : '', $required_msg )
					: ( ( function_exists( 'tasheel_hr_profile_field_error_label' ) ? tasheel_hr_profile_field_error_label( $mk ) : $mk ) . ' ' . $required_msg );
			}
		}
		foreach ( $education_block_errors as $err_key => $err_msg ) {
			$field_errors[ $err_key ] = $err_msg;
		}
		wp_send_json_error( array( 'code' => 'missing', 'missing' => $missing, 'field_errors' => $field_errors ) );
	}
	// One application per job per email (only when email is present).
	if ( function_exists( 'tasheel_hr_email_has_applied_to_job' ) && tasheel_hr_email_has_applied_to_job( $guest_email, $job_id ) ) {
		wp_send_json_error( array( 'code' => 'already_applied', 'message' => __( 'You have already applied to this job.', 'tasheel' ) ) );
	}
	$start_date = isset( $_POST['start_date'] ) ? sanitize_text_field( wp_unslash( $_POST['start_date'] ) ) : '';
	$duration   = isset( $_POST['duration'] ) ? sanitize_text_field( wp_unslash( $_POST['duration'] ) ) : '';
	unset( $snapshot['_file_errors'] );
	$review_token = wp_generate_password( 32, false );
	set_transient( 'tasheel_guest_review_' . $review_token, array( 'job_id' => $job_id, 'guest_email' => $guest_email, 'snapshot' => $snapshot, 'start_date' => $start_date, 'duration' => $duration ), 600 );
	$guest_profile_url = home_url( '/guest-profile/' );
	$redirect = add_query_arg( array( 'review_token' => $review_token, 'apply_to' => $job_id ), $guest_profile_url );
	wp_send_json_success( array( 'redirect' => $redirect ) );
}
add_action( 'wp_ajax_nopriv_tasheel_hr_guest_apply_review_ajax', 'tasheel_hr_guest_apply_review_ajax' );

/**
 * AJAX: Validate profile before submit (returns missing fields for display).
 * Uses admin-ajax.php (no REST API needed, works on all WordPress installs).
 */
function tasheel_hr_ajax_validate_apply() {
	// Prevent caching so validation is always fresh.
	nocache_headers();
	$job_id = isset( $_REQUEST['job_id'] ) ? (int) $_REQUEST['job_id'] : 0;
	if ( is_user_logged_in() && isset( $_REQUEST['nonce'] ) && ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_REQUEST['nonce'] ) ), 'tasheel_validate_apply' ) ) {
		wp_send_json( array( 'ok' => false, 'message' => __( 'Security check failed.', 'tasheel' ) ) );
	}
	if ( ! $job_id ) {
		wp_send_json( array( 'ok' => false, 'message' => __( 'Missing job ID.', 'tasheel' ) ) );
	}
	if ( ! is_user_logged_in() ) {
		wp_send_json( array( 'ok' => false, 'message' => __( 'Please log in to continue.', 'tasheel' ) ) );
	}
	$user_id = get_current_user_id();
	if ( function_exists( 'tasheel_hr_user_has_applied' ) && tasheel_hr_user_has_applied( $user_id, $job_id ) ) {
		wp_send_json( array( 'ok' => true, 'already_applied' => true ) );
	}
	// Use job_type from request if valid (same as Review Profile page); else derive from job's taxonomy.
	$job_type_slug = isset( $_REQUEST['job_type'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['job_type'] ) ) : '';
	$allowed_types = array( 'career', 'corporate_training', 'academic' );
	if ( ! in_array( $job_type_slug, $allowed_types, true ) ) {
		$raw_slug    = function_exists( 'tasheel_hr_get_job_type_slug' ) ? tasheel_hr_get_job_type_slug( $job_id ) : '';
		$job_type_slug = function_exists( 'tasheel_hr_normalize_job_type_slug' ) ? tasheel_hr_normalize_job_type_slug( $raw_slug ) : ( $raw_slug ?: 'career' );
	}
	if ( ! function_exists( 'tasheel_hr_profile_missing_required_fields' ) ) {
		wp_send_json( array( 'ok' => false, 'message' => __( 'Validation is not available. Please try again.', 'tasheel' ) ) );
	}
	$missing = tasheel_hr_profile_missing_required_fields( $user_id, $job_type_slug );
	$missing = is_array( $missing ) ? $missing : array();
	$missing_labels = array();
	foreach ( $missing as $key ) {
		$missing_labels[] = function_exists( 'tasheel_hr_profile_field_error_label' ) ? tasheel_hr_profile_field_error_label( $key ) : $key;
	}
	wp_send_json( array(
		'ok'             => empty( $missing ),
		'missing'        => $missing,
		'missing_labels' => $missing_labels,
	) );
}

add_action( 'wp_ajax_tasheel_validate_apply', 'tasheel_hr_ajax_validate_apply' );
add_action( 'wp_ajax_nopriv_tasheel_validate_apply', 'tasheel_hr_ajax_validate_apply' );

/**
 * Get admin email(s) for application notifications. Filter to set your address.
 *
 * @return string Comma-separated or single email.
 */
function tasheel_hr_application_admin_email() {
	$email = get_option( 'admin_email' );
	return apply_filters( 'tasheel_hr_application_admin_email', $email );
}

/**
 * Build list of HR notification recipients for a new application (recruiters for job type + optional admin).
 * Production: recruiters for that job's category get the email; admin can be included or omitted via filter.
 *
 * @param int $app_id Application post ID.
 * @param int $job_id Job post ID.
 * @return string[] Array of unique, valid email addresses.
 */
function tasheel_hr_application_notification_recipients( $app_id, $job_id ) {
	$job_type_slug = function_exists( 'tasheel_hr_get_job_type_slug' ) ? tasheel_hr_get_job_type_slug( $job_id ) : '';
	$recipients = array();
	if ( $job_type_slug && function_exists( 'tasheel_hr_recruiter_emails_for_job_type' ) ) {
		$recipients = tasheel_hr_recruiter_emails_for_job_type( $job_type_slug );
	}
	$include_admin = apply_filters( 'tasheel_hr_application_notify_admin', true );
	if ( $include_admin ) {
		$admin_email = tasheel_hr_application_admin_email();
		if ( $admin_email !== '' ) {
			$admin_emails = array_map( 'trim', explode( ',', $admin_email ) );
			foreach ( $admin_emails as $e ) {
				if ( is_email( $e ) ) {
					$recipients[] = $e;
				}
			}
		}
	}
	$recipients = array_unique( array_filter( $recipients ) );
	return apply_filters( 'tasheel_hr_application_notification_recipients', $recipients, $app_id, $job_id );
}

/**
 * Send confirmation email to applicant and notification to HR (recruiters for that job type + optional admin).
 *
 * Who gets the notification:
 * - Applicant: always gets a confirmation email (if we have their email).
 * - Recruiters: users with the role for this job's category (Career / Corporate Training / Academic) get the notification.
 * - Admin: included by default; set add_filter( 'tasheel_hr_application_notify_admin', '__return_false' ) to notify only recruiters.
 * - Customize list: use filter tasheel_hr_application_notification_recipients to add/remove recipients.
 *
 * @param int $app_id  Application post ID.
 * @param int $user_id Applicant user ID.
 * @param int $job_id  Job post ID.
 */
function tasheel_hr_send_application_emails( $app_id, $user_id, $job_id ) {
	$job_title = get_the_title( $job_id );
	$site_name = get_bloginfo( 'name' );
	$my_job_url = home_url( '/my-job/' );

	if ( $user_id ) {
		$user_email = get_the_author_meta( 'user_email', $user_id );
		$user_name  = get_the_author_meta( 'display_name', $user_id );
	} else {
		$user_email = get_post_meta( $app_id, 'guest_email', true );
		$snapshot   = get_post_meta( $app_id, 'application_snapshot', true );
		$user_name  = '';
		if ( ! empty( $snapshot['profile_first_name'] ) || ! empty( $snapshot['profile_last_name'] ) ) {
			$user_name = trim( ( isset( $snapshot['profile_first_name'] ) ? $snapshot['profile_first_name'] : '' ) . ' ' . ( isset( $snapshot['profile_last_name'] ) ? $snapshot['profile_last_name'] : '' ) );
		}
		if ( $user_name === '' && $user_email ) {
			$user_name = $user_email;
		}
		if ( $user_name === '' ) {
			$user_name = _x( 'Guest', 'Guest applicant', 'tasheel' );
		}
	}

	// 1. Applicant confirmation (HTML).
	if ( ! empty( $user_email ) && function_exists( 'tasheel_get_email_html_wrapper' ) && function_exists( 'tasheel_send_html_email' ) ) {
		$subject_user = sprintf( /* translators: 1: site name, 2: job id, 3: job title */ __( '[%1$s] Application received – Job #%2$s %3$s', 'tasheel' ), $site_name, $job_id, $job_title );
		$title_user   = __( 'Application received', 'tasheel' );
		$subtitle_user = sprintf( __( 'You have received a message from %s', 'tasheel' ), $site_name );
		$body_user    = '<p style="margin: 0 0 16px; font-size: 16px; color: #333;">' . sprintf( esc_html__( 'Hello %s,', 'tasheel' ), esc_html( $user_name ) ) . '</p>';
		$body_user   .= '<p style="margin: 0 0 20px; font-size: 16px; color: #333;">' . sprintf( esc_html__( 'Thank you for applying for Job #%1$s – %2$s at %3$s. We have received your application and will review it shortly.', 'tasheel' ), $job_id, esc_html( $job_title ), esc_html( $site_name ) ) . '</p>';
		$body_user   .= '<p style="margin: 0 0 24px; font-size: 16px; color: #333;">' . esc_html__( 'You can view your application status here:', 'tasheel' ) . ' <a href="' . esc_url( $my_job_url ) . '" style="color: #0D6A37; font-weight: 600;">' . esc_html( $my_job_url ) . '</a></p>';
		$body_user   .= '<p style="margin: 0; font-size: 16px; color: #333;">' . esc_html__( 'Best regards,', 'tasheel' ) . '<br>' . esc_html( $site_name ) . ' ' . esc_html__( 'Team', 'tasheel' ) . '</p>';
		$html_user    = tasheel_get_email_html_wrapper( $title_user, $subtitle_user, $body_user );
		tasheel_send_html_email( $user_email, $subject_user, $html_user );
	} elseif ( ! empty( $user_email ) ) {
		$subject_user = sprintf( __( '[%1$s] Application received – Job #%2$s %3$s', 'tasheel' ), $site_name, $job_id, $job_title );
		$body_user    = sprintf( __( "Hello %1\$s,\n\nThank you for applying for Job #%2\$s – %3\$s at %4\$s. We have received your application and will review it shortly.\n\nYou can view your application status here: %5\$s\n\nBest regards,\n%4\$s Team", 'tasheel' ), $user_name, $job_id, $job_title, $site_name, $my_job_url );
		wp_mail( $user_email, $subject_user, $body_user );
	}

	// 2. HR notification: recruiters for this job's category + optional admin (filterable). HTML.
	$recipients = tasheel_hr_application_notification_recipients( $app_id, $job_id );
	if ( empty( $recipients ) ) {
		return;
	}
	$subject_hr = sprintf( /* translators: 1: site name, 2: job id, 3: job title, 4: applicant name */ __( '[%1$s] New application: Job #%2$s %3$s – %4$s', 'tasheel' ), $site_name, $job_id, $job_title, $user_name );
	$admin_edit = admin_url( 'post.php?post=' . $app_id . '&action=edit' );
	if ( function_exists( 'tasheel_get_email_html_wrapper' ) && function_exists( 'tasheel_send_html_email' ) ) {
		$title_hr    = __( 'New job application', 'tasheel' );
		$subtitle_hr = sprintf( __( 'You have received a message from %s', 'tasheel' ), $site_name );
		$body_hr     = '<p style="margin: 0 0 20px; font-size: 16px; color: #333;">' . esc_html__( 'A new job application has been submitted.', 'tasheel' ) . '</p>';
		$body_hr    .= '<table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom: 24px;">';
		$body_hr    .= '<tr><td style="padding: 15px; background-color: #f8f9fa; border-bottom: 2px solid #e9ecef;"><div style="font-size: 12px; color: #6c757d; margin-bottom: 4px;">' . esc_html__( 'Applicant', 'tasheel' ) . '</div><div style="font-size: 16px; color: #0D6A37; font-weight: 600;">' . esc_html( $user_name ) . '</div></td></tr>';
		$body_hr    .= '<tr><td style="padding: 15px; background-color: #ffffff; border-bottom: 2px solid #e9ecef;"><div style="font-size: 12px; color: #6c757d; margin-bottom: 4px;">' . esc_html__( 'Email', 'tasheel' ) . '</div><div style="font-size: 16px;"><a href="mailto:' . esc_attr( $user_email ) . '" style="color: #0D6A37; text-decoration: none; font-weight: 600;">' . esc_html( $user_email ) . '</a></div></td></tr>';
		$body_hr    .= '<tr><td style="padding: 15px; background-color: #f8f9fa; border-bottom: 2px solid #e9ecef;"><div style="font-size: 12px; color: #6c757d; margin-bottom: 4px;">' . esc_html__( 'Job ID', 'tasheel' ) . '</div><div style="font-size: 16px; color: #0D6A37; font-weight: 600;">' . esc_html( (string) $job_id ) . '</div></td></tr>';
		$body_hr    .= '<tr><td style="padding: 15px; background-color: #ffffff; border-bottom: 2px solid #e9ecef;"><div style="font-size: 12px; color: #6c757d; margin-bottom: 4px;">' . esc_html__( 'Position', 'tasheel' ) . '</div><div style="font-size: 16px; color: #0D6A37; font-weight: 600;">' . esc_html( $job_title ) . '</div></td></tr>';
		$body_hr    .= '</table>';
		$body_hr    .= '<p style="margin: 0;"><a href="' . esc_url( $admin_edit ) . '" target="_blank" style="display: inline-block; padding: 12px 24px; font-size: 14px; font-weight: 600; color: #ffffff !important; background-color: #0D6A37; border-radius: 6px; text-decoration: none;">' . esc_html__( 'View application in backend', 'tasheel' ) . '</a></p>';
		$html_hr     = tasheel_get_email_html_wrapper( $title_hr, $subtitle_hr, $body_hr );
		tasheel_send_html_email( $recipients, $subject_hr, $html_hr );
	} else {
		$body_hr = sprintf( __( "A new job application has been submitted.\n\nApplicant: %1\$s (%2\$s)\nJob ID: %3\$s\nPosition: %4\$s\n\nView application in backend: %5\$s", 'tasheel' ), $user_name, $user_email, $job_id, $job_title, $admin_edit );
		wp_mail( $recipients, $subject_hr, $body_hr );
	}
}

/**
 * Allowed application status values (internal slugs). Used for admin dropdown and validation.
 *
 * @return string[]
 */
function tasheel_hr_application_statuses() {
	return array( 'submitted', 'under_review', 'shortlisted', 'accepted', 'rejected' );
}

/**
 * Get application status label for admin (distinct labels for shortlisted etc.).
 *
 * @param string $status Internal status.
 * @return string
 */
function tasheel_hr_application_status_label_admin( $status ) {
	$labels = array(
		'submitted'    => __( 'Submitted', 'tasheel' ),
		'under_review' => __( 'Under Review', 'tasheel' ),
		'shortlisted'  => __( 'Shortlisted', 'tasheel' ),
		'accepted'     => __( 'Accepted', 'tasheel' ),
		'rejected'     => __( 'Rejected', 'tasheel' ),
	);
	return isset( $labels[ $status ] ) ? $labels[ $status ] : $status;
}

/**
 * Add meta boxes on job_application edit screen (status + snapshot).
 * Remove Custom Fields meta box to avoid duplicate "notes" fields; we provide the only internal notes field.
 */
function tasheel_hr_application_meta_boxes() {
	// Snapshot first (main column), then Status/Rating/Notes in main column so everything appears once and saves together.
	add_meta_box(
		'tasheel_hr_app_snapshot',
		__( 'Submitted profile (snapshot)', 'tasheel' ),
		'tasheel_hr_render_application_snapshot_meta_box',
		'job_application',
		'normal',
		'high'
	);
	add_meta_box(
		'tasheel_hr_app_status',
		__( 'Job Application (HR Engine)', 'tasheel' ),
		'tasheel_hr_render_application_status_meta_box',
		'job_application',
		'normal',
		'default'
	);
}

/**
 * Remove Custom Fields and any duplicate "Job Application (HR Engine)" or "Internal notes" meta box.
 * We register only one "Job Application (HR Engine)" box in normal context so Status, Rating, and Notes appear once and save together.
 */
function tasheel_hr_application_remove_duplicate_meta_boxes() {
	$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
	if ( ! $screen || $screen->post_type !== 'job_application' ) {
		return;
	}
	$page = $screen->id;
	remove_meta_box( 'postcustom', 'job_application', 'normal' );
	global $wp_meta_boxes;
	if ( empty( $wp_meta_boxes[ $page ] ) || ! is_array( $wp_meta_boxes[ $page ] ) ) {
		return;
	}
	$hr_box_title = __( 'Job Application (HR Engine)', 'tasheel' );
	$internal_notes_title = __( 'Internal notes', 'tasheel' );
	foreach ( array( 'normal', 'side', 'advanced' ) as $context ) {
		if ( empty( $wp_meta_boxes[ $page ][ $context ] ) ) {
			continue;
		}
		foreach ( $wp_meta_boxes[ $page ][ $context ] as $priority => $boxes ) {
			if ( ! is_array( $boxes ) ) {
				continue;
			}
			foreach ( $boxes as $id => $box ) {
				$title = isset( $box['title'] ) ? $box['title'] : '';
				$is_duplicate_hr = ( $title === $hr_box_title || $title === 'Job Application (HR Engine)' ) && $id !== 'tasheel_hr_app_status';
				$is_duplicate_notes = ( $title === $internal_notes_title || $title === 'Internal notes' ) && $id !== 'tasheel_hr_app_status';
				if ( $is_duplicate_hr || $is_duplicate_notes ) {
					remove_meta_box( $id, 'job_application', $context );
				}
			}
		}
	}
}
add_action( 'add_meta_boxes', 'tasheel_hr_application_remove_duplicate_meta_boxes', 999 );

/**
 * Render Application Status meta box: status, rating, and the single Internal notes field. Production-ready for admins.
 *
 * @param \WP_Post $post Application post.
 */
function tasheel_hr_render_application_status_meta_box( $post ) {
	$current = get_post_meta( $post->ID, 'application_status', true );
	if ( $current === '' ) {
		$current = 'submitted';
	}
	$rating = get_post_meta( $post->ID, 'application_rating', true );
	$notes  = get_post_meta( $post->ID, 'application_internal_notes', true );
	$statuses = tasheel_hr_application_statuses();
	wp_nonce_field( 'tasheel_hr_save_application_status', 'tasheel_hr_application_status_nonce' );

	// --- Status & rating ---
	echo '<div class="tasheel-hr-app-meta-section" style="margin-bottom:16px;">';
	echo '<p style="margin:0 0 4px 0; font-weight:600; color:#1d2327;">' . esc_html__( 'Application Status', 'tasheel' ) . '</p>';
	echo '<select name="application_status" id="application_status" style="width:100%;">';
	foreach ( $statuses as $slug ) {
		$label = tasheel_hr_application_status_label_admin( $slug );
		echo '<option value="' . esc_attr( $slug ) . '" ' . selected( $current, $slug, false ) . '>' . esc_html( $label ) . '</option>';
	}
	echo '</select>';
	echo '<p class="description" style="margin:4px 0 0 0;">' . esc_html__( 'Shown to applicant on My Jobs.', 'tasheel' ) . '</p>';
	echo '</div>';

	echo '<div class="tasheel-hr-app-meta-section" style="margin-bottom:16px;">';
	echo '<p style="margin:0 0 4px 0; font-weight:600; color:#1d2327;">' . esc_html__( 'Rating (internal)', 'tasheel' ) . '</p>';
	echo '<input type="text" name="application_rating" id="application_rating" value="' . esc_attr( $rating ) . '" class="widefat" placeholder="' . esc_attr__( 'e.g. 1–10', 'tasheel' ) . '" />';
	echo '<p class="description" style="margin:4px 0 0 0;">' . esc_html__( 'Internal only. Not shown to applicant.', 'tasheel' ) . '</p>';
	echo '</div>';

	// --- Single Internal notes field (for this application only) ---
	echo '<div class="tasheel-hr-app-meta-section" style="margin-bottom:16px; padding-top:12px; border-top:1px solid #c3c4c7;">';
	echo '<p style="margin:0 0 4px 0; font-weight:600; color:#1d2327;">' . esc_html__( 'Internal notes', 'tasheel' ) . '</p>';
	echo '<p class="description" style="margin:0 0 6px 0; font-size:12px;">' . esc_html__( 'Notes for this application only. Not visible to applicant.', 'tasheel' ) . '</p>';
	echo '<textarea name="application_internal_notes" id="application_internal_notes" class="widefat" rows="4" placeholder="' . esc_attr__( 'Add notes about this application…', 'tasheel' ) . '">' . esc_textarea( $notes ) . '</textarea>';
	echo '</div>';

	// --- General notes about the person (read-only; edit on User profile) ---
	$user_id = (int) get_post_meta( $post->ID, 'user_id', true );
	if ( $user_id ) {
		$profile_notes = get_user_meta( $user_id, 'tasheel_hr_profile_notes', true );
		$edit_user_url = admin_url( 'user-edit.php?user_id=' . $user_id );
		echo '<div class="tasheel-hr-app-meta-section" style="padding-top:12px; border-top:1px solid #c3c4c7;">';
		echo '<p style="margin:0 0 4px 0; font-weight:600; color:#1d2327;">' . esc_html__( 'General notes (HR) — from User profile', 'tasheel' ) . '</p>';
		echo '<p class="description" style="margin:0 0 6px 0; font-size:12px;">' . esc_html__( 'Notes about this person (all applications). Read-only here.', 'tasheel' ) . '</p>';
		if ( $profile_notes !== '' ) {
			echo '<div style="padding:8px; background:#f0f0f1; border:1px solid #c3c4c7; border-radius:2px; max-height:100px; overflow-y:auto; white-space:pre-wrap; font-size:12px; color:#2c3338;">' . esc_html( $profile_notes ) . '</div>';
		} else {
			echo '<p class="description" style="margin:0;">' . esc_html__( 'No notes yet.', 'tasheel' ) . '</p>';
		}
		echo '<p style="margin:6px 0 0 0;"><a href="' . esc_url( $edit_user_url ) . '" class="button button-small">' . esc_html__( 'Edit in User profile', 'tasheel' ) . '</a></p>';
		echo '</div>';
	}
}

/**
 * Save application status when job_application is saved in admin.
 */
function tasheel_hr_save_application_status( $post_id ) {
	if ( get_post_type( $post_id ) !== 'job_application' ) {
		return;
	}
	if ( ! isset( $_POST['tasheel_hr_application_status_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['tasheel_hr_application_status_nonce'] ) ), 'tasheel_hr_save_application_status' ) ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	$status = isset( $_POST['application_status'] ) ? sanitize_text_field( wp_unslash( $_POST['application_status'] ) ) : '';
	$allowed = tasheel_hr_application_statuses();
	if ( in_array( $status, $allowed, true ) ) {
		update_post_meta( $post_id, 'application_status', $status );
	}
	$rating = isset( $_POST['application_rating'] ) ? sanitize_text_field( wp_unslash( $_POST['application_rating'] ) ) : '';
	update_post_meta( $post_id, 'application_rating', $rating );
	$notes = isset( $_POST['application_internal_notes'] ) ? sanitize_textarea_field( wp_unslash( $_POST['application_internal_notes'] ) ) : '';
	update_post_meta( $post_id, 'application_internal_notes', $notes );
}
add_action( 'save_post_job_application', 'tasheel_hr_save_application_status', 10, 1 );

/**
 * Add admin-oriented columns: Application (replaces Title), Job, Job ID, Applicant, Status, Date.
 * Uses late priority to ensure title column is removed after any plugin adds it (avoids duplicate row actions).
 */
function tasheel_hr_application_list_columns( $columns ) {
	$new = array();
	foreach ( $columns as $key => $label ) {
		if ( $key === 'title' ) {
			$new['application_primary']     = __( 'Application', 'tasheel' );
			$new['application_job']        = __( 'Job', 'tasheel' );
			$new['application_job_id']     = __( 'Job ID', 'tasheel' );
			$new['application_applicant']   = __( 'Applicant', 'tasheel' );
			$new['application_status']     = __( 'Status', 'tasheel' );
			$new['application_user_note']  = __( 'User note (HR)', 'tasheel' );
			$new['application_app_note']   = __( 'Application note', 'tasheel' );
			$new['application_rating']     = __( 'Rating', 'tasheel' );
			continue;
		}
		$new[ $key ] = $label;
	}
	unset( $new['title'] );
	return $new;
}

/**
 * Set Application column as primary so row actions display correctly (avoids duplicate when title column is removed).
 */
function tasheel_hr_application_list_primary_column( $default, $screen_id ) {
	if ( $screen_id === 'edit-job_application' ) {
		return 'application_primary';
	}
	return $default;
}

/**
 * Output custom column content for Job Applications list.
 */
function tasheel_hr_application_list_column_content( $column, $post_id ) {
	$job_id   = (int) get_post_meta( $post_id, 'job_id', true );
	$user_id  = (int) get_post_meta( $post_id, 'user_id', true );
	$guest_email = get_post_meta( $post_id, 'guest_email', true );

	// Application column (replaces Title): "Application #ID" only. Row actions (Edit, Quick Edit, Trash, Duplicate) are added by WP_List_Table::handle_row_actions() – do NOT output our own or we get duplicates.
	if ( $column === 'application_primary' ) {
		$post = get_post( $post_id );
		if ( ! $post ) {
			return;
		}
		$edit_url = get_edit_post_link( $post, 'raw' );
		echo '<strong><a href="' . esc_url( $edit_url ) . '" class="row-title">' . esc_html( sprintf( __( 'Application #%s', 'tasheel' ), $post_id ) ) . '</a></strong>';
		return;
	}

	if ( $column === 'application_job_id' ) {
		if ( $job_id ) {
			$job = get_post( $job_id );
			if ( $job ) {
				$edit_url = admin_url( 'post.php?post=' . $job_id . '&action=edit' );
				echo '<a href="' . esc_url( $edit_url ) . '">' . esc_html( (string) $job_id ) . '</a>';
			} else {
				echo esc_html( (string) $job_id );
			}
		} else {
			echo '—';
		}
		return;
	}

	if ( $column === 'application_job' ) {
		if ( ! $job_id ) {
			echo '—';
			return;
		}
		$job = get_post( $job_id );
		if ( ! $job ) {
			echo '—';
			return;
		}
		$edit_url = admin_url( 'post.php?post=' . $job_id . '&action=edit' );
		echo '<a href="' . esc_url( $edit_url ) . '">' . esc_html( get_the_title( $job ) ) . '</a>';
		return;
	}

	if ( $column === 'application_applicant' ) {
		$name = '';
		if ( $user_id ) {
			$user = get_userdata( $user_id );
			if ( $user ) {
				$first = get_user_meta( $user_id, 'profile_first_name', true );
				$last  = get_user_meta( $user_id, 'profile_last_name', true );
				if ( ( $first === '' && $last === '' ) && ( isset( $user->first_name ) || isset( $user->last_name ) ) ) {
					$first = isset( $user->first_name ) ? $user->first_name : '';
					$last  = isset( $user->last_name ) ? $user->last_name : '';
				}
				$name = trim( $first . ' ' . $last );
				if ( $name === '' ) {
					$name = $user->display_name ?: $user->user_email;
				}
				$edit_url = admin_url( 'user-edit.php?user_id=' . $user_id );
				echo '<a href="' . esc_url( $edit_url ) . '">' . esc_html( $name ) . '</a>';
				echo '<br><span class="description">' . esc_html( $user->user_email ) . '</span>';
			} else {
				echo '—';
			}
		} else {
			$snapshot = get_post_meta( $post_id, 'application_snapshot', true );
			if ( is_array( $snapshot ) ) {
				$first = isset( $snapshot['profile_first_name'] ) ? $snapshot['profile_first_name'] : '';
				$last  = isset( $snapshot['profile_last_name'] ) ? $snapshot['profile_last_name'] : '';
				$name  = trim( $first . ' ' . $last );
			}
			if ( $name !== '' ) {
				echo esc_html( $name );
				if ( is_string( $guest_email ) && $guest_email !== '' ) {
					echo '<br><span class="description">' . esc_html( $guest_email ) . ' · ' . esc_html__( 'Guest', 'tasheel' ) . '</span>';
				}
			} elseif ( is_string( $guest_email ) && $guest_email !== '' ) {
				echo esc_html( $guest_email );
				echo '<br><span class="description">' . esc_html__( 'Guest', 'tasheel' ) . '</span>';
			} else {
				echo '—';
			}
		}
		return;
	}

	if ( $column === 'application_status' ) {
		$status = get_post_meta( $post_id, 'application_status', true );
		if ( $status === '' ) {
			$status = 'submitted';
		}
		echo esc_html( tasheel_hr_application_status_label_admin( $status ) );
		return;
	}

	if ( $column === 'application_user_note' ) {
		$user_id = (int) get_post_meta( $post_id, 'user_id', true );
		if ( ! $user_id ) {
			echo '—';
			return;
		}
		$note = get_user_meta( $user_id, 'tasheel_hr_profile_notes', true );
		if ( (string) $note === '' ) {
			echo '—';
			return;
		}
		echo '<span title="' . esc_attr( $note ) . '">' . esc_html( wp_trim_words( $note, 12 ) ) . '</span>';
		return;
	}

	if ( $column === 'application_app_note' ) {
		$notes = get_post_meta( $post_id, 'application_internal_notes', true );
		if ( (string) $notes === '' ) {
			echo '—';
			return;
		}
		echo '<span title="' . esc_attr( $notes ) . '">' . esc_html( wp_trim_words( $notes, 12 ) ) . '</span>';
		return;
	}

	if ( $column === 'application_rating' ) {
		$rating = get_post_meta( $post_id, 'application_rating', true );
		echo (string) $rating !== '' ? esc_html( $rating ) : '—';
	}
}

/**
 * Make Job Applications list columns sortable.
 */
function tasheel_hr_application_sortable_columns( $columns ) {
	$columns['application_status']  = 'application_status';
	$columns['application_job']    = 'job_id';
	$columns['application_job_id'] = 'job_id';
	return $columns;
}

/**
 * Order Job Applications list by meta when sorting by status or job.
 */
function tasheel_hr_application_orderby_columns( $query ) {
	if ( ! is_admin() || ! $query->is_main_query() ) {
		return;
	}
	$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
	if ( ! $screen || $screen->post_type !== 'job_application' ) {
		return;
	}
	$orderby = $query->get( 'orderby' );
	if ( $orderby === 'application_status' ) {
		$query->set( 'meta_key', 'application_status' );
		$query->set( 'orderby', 'meta_value' );
	}
	if ( $orderby === 'job_id' ) {
		$query->set( 'meta_key', 'job_id' );
		$query->set( 'orderby', 'meta_value_num' );
	}
}

/**
 * Add admin filters: by Status and by Job (above the list table).
 *
 * @param string $post_type Post type.
 * @param string $which     'top' or 'bottom'.
 */
function tasheel_hr_application_list_filters( $post_type, $which = '' ) {
	if ( $post_type !== 'job_application' || $which !== 'top' ) {
		return;
	}

	$current_status       = isset( $_GET['application_status'] ) ? sanitize_text_field( wp_unslash( $_GET['application_status'] ) ) : '';
	$current_job_id       = isset( $_GET['application_job_id'] ) ? (int) $_GET['application_job_id'] : 0;
	$current_nationality  = isset( $_GET['application_nationality'] ) ? sanitize_text_field( wp_unslash( $_GET['application_nationality'] ) ) : '';
	$current_visa         = isset( $_GET['application_visa'] ) ? sanitize_text_field( wp_unslash( $_GET['application_visa'] ) ) : '';
	$current_has_resume   = isset( $_GET['application_has_resume'] ) ? sanitize_text_field( wp_unslash( $_GET['application_has_resume'] ) ) : '';
	$current_has_portfolio = isset( $_GET['application_has_portfolio'] ) ? sanitize_text_field( wp_unslash( $_GET['application_has_portfolio'] ) ) : '';
	$date_from = isset( $_GET['application_date_from'] ) ? sanitize_text_field( wp_unslash( $_GET['application_date_from'] ) ) : '';
	$date_to   = isset( $_GET['application_date_to'] ) ? sanitize_text_field( wp_unslash( $_GET['application_date_to'] ) ) : '';

	$statuses  = tasheel_hr_application_statuses();
	$job_ids   = tasheel_hr_get_applicable_job_ids_for_admin();
	$countries = function_exists( 'tasheel_hr_get_countries' ) ? tasheel_hr_get_countries() : array();
	$visa_options = function_exists( 'tasheel_hr_visa_status_options' ) ? tasheel_hr_visa_status_options() : array( 'has_visa' => __( 'Has Visa / Residency', 'tasheel' ), 'no_visa' => __( 'No Visa', 'tasheel' ) );
	?>
	<select name="application_status" id="application_status_filter">
		<option value=""><?php esc_html_e( 'All statuses', 'tasheel' ); ?></option>
		<?php foreach ( $statuses as $slug ) : ?>
			<option value="<?php echo esc_attr( $slug ); ?>" <?php selected( $current_status, $slug ); ?>><?php echo esc_html( tasheel_hr_application_status_label_admin( $slug ) ); ?></option>
		<?php endforeach; ?>
	</select>
	<select name="application_job_id" id="application_job_id_filter">
		<option value=""><?php esc_html_e( 'All jobs', 'tasheel' ); ?></option>
		<?php
		foreach ( $job_ids as $jid ) {
			$job = get_post( $jid );
			if ( ! $job ) {
				continue;
			}
			$title = get_the_title( $job );
			?>
			<option value="<?php echo esc_attr( $jid ); ?>" <?php selected( $current_job_id, $jid ); ?>><?php echo esc_html( $title ); ?></option>
		<?php } ?>
	</select>
	<select name="application_nationality" id="application_nationality_filter">
		<option value=""><?php esc_html_e( 'All nationalities', 'tasheel' ); ?></option>
		<?php foreach ( $countries as $code => $name ) : ?>
			<option value="<?php echo esc_attr( $code ); ?>" <?php selected( $current_nationality, $code ); ?>><?php echo esc_html( $name ); ?></option>
		<?php endforeach; ?>
	</select>
	<?php
	$show_visa_filter = ! function_exists( 'tasheel_hr_show_visa_status_filter' ) || tasheel_hr_show_visa_status_filter();
	if ( $show_visa_filter ) :
		?>
	<select name="application_visa" id="application_visa_filter">
		<option value=""><?php esc_html_e( 'All visa statuses', 'tasheel' ); ?></option>
		<?php foreach ( $visa_options as $val => $label ) : ?>
			<option value="<?php echo esc_attr( $val ); ?>" <?php selected( $current_visa, $val ); ?>><?php echo esc_html( $label ); ?></option>
		<?php endforeach; ?>
	</select>
	<?php endif; ?>
	<select name="application_has_resume" id="application_has_resume_filter">
		<option value=""><?php esc_html_e( 'Resume: Any', 'tasheel' ); ?></option>
		<option value="1" <?php selected( $current_has_resume, '1' ); ?>><?php esc_html_e( 'Resume: Yes', 'tasheel' ); ?></option>
		<option value="0" <?php selected( $current_has_resume, '0' ); ?>><?php esc_html_e( 'Resume: No', 'tasheel' ); ?></option>
	</select>
	<select name="application_has_portfolio" id="application_has_portfolio_filter">
		<option value=""><?php esc_html_e( 'Portfolio: Any', 'tasheel' ); ?></option>
		<option value="1" <?php selected( $current_has_portfolio, '1' ); ?>><?php esc_html_e( 'Portfolio: Yes', 'tasheel' ); ?></option>
		<option value="0" <?php selected( $current_has_portfolio, '0' ); ?>><?php esc_html_e( 'Portfolio: No', 'tasheel' ); ?></option>
	</select>
	<span class="tasheel-export-date-range" style="margin-left:8px;">
		<label for="application_date_from"><?php esc_html_e( 'From', 'tasheel' ); ?></label>
		<input type="date" name="application_date_from" id="application_date_from" value="<?php echo esc_attr( $date_from ); ?>" />
		<label for="application_date_to" style="margin-left:6px;"><?php esc_html_e( 'To', 'tasheel' ); ?></label>
		<input type="date" name="application_date_to" id="application_date_to" value="<?php echo esc_attr( $date_to ); ?>" />
	</span>
	<?php
	// Submit buttons so the current form (including date range) is sent with the export request.
	?>
	<button type="submit" name="tasheel_hr_export" value="csv" class="button" style="margin-left:8px;"><?php esc_html_e( 'Export CSV', 'tasheel' ); ?></button>
	<button type="submit" name="tasheel_hr_export" value="excel" class="button"><?php esc_html_e( 'Export Excel', 'tasheel' ); ?></button>
	<button type="submit" name="tasheel_hr_download_cvs" value="1" class="button"><?php esc_html_e( 'Download CVs', 'tasheel' ); ?></button>
	<?php
}

/**
 * Get job IDs that the current admin/recruiter can see (for filter dropdown).
 * Recruiters see only jobs in their term; administrators see all.
 *
 * @return int[]
 */
function tasheel_hr_get_applicable_job_ids_for_admin() {
	$args = array(
		'post_type'      => function_exists( 'tasheel_hr_job_post_type' ) ? tasheel_hr_job_post_type() : 'hr_job',
		'post_status'    => 'any',
		'posts_per_page' => -1,
		'fields'         => 'ids',
		'orderby'        => 'title',
		'order'          => 'ASC',
	);
	$term_slug = function_exists( 'tasheel_hr_recruiter_allowed_term_slug' ) ? tasheel_hr_recruiter_allowed_term_slug() : '';
	if ( $term_slug !== '' ) {
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'job_type',
				'field'    => 'slug',
				'terms'    => $term_slug,
			),
		);
	}
	return get_posts( $args );
}

/**
 * Apply Status, Job, and advanced filters (nationality, visa, has resume, has portfolio) to list query.
 * Runs after recruiter filter so meta_query is merged.
 */
function tasheel_hr_application_list_apply_filters( $query ) {
	if ( ! is_admin() || ! $query->is_main_query() ) {
		return;
	}
	$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
	if ( ! $screen || $screen->post_type !== 'job_application' ) {
		return;
	}

	$meta_query = $query->get( 'meta_query' );
	if ( ! is_array( $meta_query ) ) {
		$meta_query = array();
	}

	$status = isset( $_GET['application_status'] ) ? sanitize_text_field( wp_unslash( $_GET['application_status'] ) ) : '';
	if ( $status !== '' && in_array( $status, tasheel_hr_application_statuses(), true ) ) {
		$meta_query[] = array(
			'key'     => 'application_status',
			'value'   => $status,
			'compare' => '=',
		);
	}

	$job_id = isset( $_GET['application_job_id'] ) ? (int) $_GET['application_job_id'] : 0;
	if ( $job_id > 0 ) {
		$meta_query[] = array(
			'key'     => 'job_id',
			'value'   => $job_id,
			'compare' => '=',
		);
	}

	$nationality = isset( $_GET['application_nationality'] ) ? sanitize_text_field( wp_unslash( $_GET['application_nationality'] ) ) : '';
	if ( $nationality !== '' ) {
		$meta_query[] = array(
			'key'     => 'application_filter_nationality',
			'value'   => $nationality,
			'compare' => '=',
		);
	}

	$visa = isset( $_GET['application_visa'] ) ? sanitize_text_field( wp_unslash( $_GET['application_visa'] ) ) : '';
	if ( $visa !== '' ) {
		$meta_query[] = array(
			'key'     => 'application_filter_visa_status',
			'value'   => $visa,
			'compare' => '=',
		);
	}

	$has_resume = isset( $_GET['application_has_resume'] ) ? sanitize_text_field( wp_unslash( $_GET['application_has_resume'] ) ) : '';
	if ( $has_resume === '1' ) {
		$meta_query[] = array(
			'key'     => 'application_filter_has_resume',
			'value'   => '1',
			'compare' => '=',
		);
	} elseif ( $has_resume === '0' ) {
		$meta_query[] = array(
			'relation' => 'OR',
			array(
				'key'     => 'application_filter_has_resume',
				'compare' => 'NOT EXISTS',
			),
			array(
				'key'     => 'application_filter_has_resume',
				'value'   => '0',
				'compare' => '=',
			),
		);
	}

	$has_portfolio = isset( $_GET['application_has_portfolio'] ) ? sanitize_text_field( wp_unslash( $_GET['application_has_portfolio'] ) ) : '';
	if ( $has_portfolio === '1' ) {
		$meta_query[] = array(
			'key'     => 'application_filter_has_portfolio',
			'value'   => '1',
			'compare' => '=',
		);
	} elseif ( $has_portfolio === '0' ) {
		$meta_query[] = array(
			'relation' => 'OR',
			array(
				'key'     => 'application_filter_has_portfolio',
				'compare' => 'NOT EXISTS',
			),
			array(
				'key'     => 'application_filter_has_portfolio',
				'value'   => '0',
				'compare' => '=',
			),
		);
	}

	if ( ! empty( $meta_query ) ) {
		$query->set( 'meta_query', $meta_query );
	}

	$date_query = tasheel_hr_application_build_filter_date_query();
	if ( $date_query !== null ) {
		$query->set( 'date_query', $date_query );
	}
}

/**
 * FRD §9: Advance filtering – search bar filters list by similar data in any field.
 * Extend search to: post title, application_snapshot (all profile data), guest_email, user display_name and user_email.
 */
function tasheel_hr_application_advanced_search( $query ) {
	if ( ! is_admin() || ! $query->is_main_query() ) {
		return;
	}
	$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
	if ( ! $screen || $screen->post_type !== 'job_application' ) {
		return;
	}
	$s = $query->get( 's' );
	if ( $s === '' || ! is_string( $s ) ) {
		return;
	}

	$term = trim( $s );
	$term = sanitize_text_field( $term );
	if ( $term === '' ) {
		return;
	}

	global $wpdb;
	$like = '%' . $wpdb->esc_like( $term ) . '%';
	$ids = array();

	// By post title.
	$title_ids = $wpdb->get_col( $wpdb->prepare(
		"SELECT ID FROM {$wpdb->posts} WHERE post_type = 'job_application' AND post_status IN ('publish','draft','pending','private') AND post_title LIKE %s",
		$like
	) );
	if ( is_array( $title_ids ) ) {
		$ids = array_merge( $ids, array_map( 'intval', $title_ids ) );
	}

	// By application_snapshot (serialized; LIKE finds any matching text in profile data).
	$snapshot_ids = $wpdb->get_col( $wpdb->prepare(
		"SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key = 'application_snapshot' AND meta_value LIKE %s",
		$like
	) );
	if ( is_array( $snapshot_ids ) ) {
		$ids = array_merge( $ids, array_map( 'intval', $snapshot_ids ) );
	}

	// By guest_email.
	$guest_ids = $wpdb->get_col( $wpdb->prepare(
		"SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key = 'guest_email' AND meta_value LIKE %s",
		$like
	) );
	if ( is_array( $guest_ids ) ) {
		$ids = array_merge( $ids, array_map( 'intval', $guest_ids ) );
	}

	// By user display_name or user_email (applications linked to users whose name/email matches).
	$user_ids = $wpdb->get_col( $wpdb->prepare(
		"SELECT ID FROM {$wpdb->users} WHERE display_name LIKE %s OR user_email LIKE %s",
		$like,
		$like
	) );
	if ( ! empty( $user_ids ) ) {
		$user_ids = array_map( 'absint', $user_ids );
		$placeholders = implode( ',', array_fill( 0, count( $user_ids ), '%d' ) );
		$user_app_ids = $wpdb->get_col( $wpdb->prepare(
			"SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key = 'user_id' AND meta_value IN ($placeholders)",
			...$user_ids
		) );
		if ( is_array( $user_app_ids ) ) {
			$ids = array_merge( $ids, array_map( 'intval', $user_app_ids ) );
		}
	}

	$ids = array_unique( array_filter( $ids ) );
	$query->set( 's', '' );
	if ( empty( $ids ) ) {
		$query->set( 'post__in', array( 0 ) );
		return;
	}
	$query->set( 'post__in', $ids );
}

/**
 * One-time backfill: sync filter meta for all existing job applications so advanced filters work.
 */
function tasheel_hr_application_maybe_backfill_filter_meta() {
	$post_type = isset( $_GET['post_type'] ) ? sanitize_text_field( wp_unslash( $_GET['post_type'] ) ) : '';
	if ( $post_type !== 'job_application' ) {
		return;
	}
	if ( get_option( 'tasheel_hr_app_filter_synced', '' ) === '1' ) {
		return;
	}

	$apps = get_posts( array(
		'post_type'      => 'job_application',
		'post_status'    => 'any',
		'posts_per_page' => -1,
		'fields'         => 'ids',
	) );
	foreach ( $apps as $app_id ) {
		tasheel_hr_application_sync_filter_meta( (int) $app_id );
	}
	update_option( 'tasheel_hr_app_filter_synced', '1' );
}

/**
 * Build meta_query array from current GET params (for export or other use).
 *
 * @return array Meta query array.
 */
function tasheel_hr_application_build_filter_meta_query() {
	$meta_query = array();
	$status = isset( $_GET['application_status'] ) ? sanitize_text_field( wp_unslash( $_GET['application_status'] ) ) : '';
	if ( $status !== '' && in_array( $status, tasheel_hr_application_statuses(), true ) ) {
		$meta_query[] = array( 'key' => 'application_status', 'value' => $status, 'compare' => '=' );
	}
	$job_id = isset( $_GET['application_job_id'] ) ? (int) $_GET['application_job_id'] : 0;
	if ( $job_id > 0 ) {
		$meta_query[] = array( 'key' => 'job_id', 'value' => $job_id, 'compare' => '=' );
	}
	$nationality = isset( $_GET['application_nationality'] ) ? sanitize_text_field( wp_unslash( $_GET['application_nationality'] ) ) : '';
	if ( $nationality !== '' ) {
		$meta_query[] = array( 'key' => 'application_filter_nationality', 'value' => $nationality, 'compare' => '=' );
	}
	$visa = isset( $_GET['application_visa'] ) ? sanitize_text_field( wp_unslash( $_GET['application_visa'] ) ) : '';
	if ( $visa !== '' ) {
		$meta_query[] = array( 'key' => 'application_filter_visa_status', 'value' => $visa, 'compare' => '=' );
	}
	$has_resume = isset( $_GET['application_has_resume'] ) ? sanitize_text_field( wp_unslash( $_GET['application_has_resume'] ) ) : '';
	if ( $has_resume === '1' ) {
		$meta_query[] = array( 'key' => 'application_filter_has_resume', 'value' => '1', 'compare' => '=' );
	} elseif ( $has_resume === '0' ) {
		$meta_query[] = array(
			'relation' => 'OR',
			array( 'key' => 'application_filter_has_resume', 'compare' => 'NOT EXISTS' ),
			array( 'key' => 'application_filter_has_resume', 'value' => '0', 'compare' => '=' ),
		);
	}
	$has_portfolio = isset( $_GET['application_has_portfolio'] ) ? sanitize_text_field( wp_unslash( $_GET['application_has_portfolio'] ) ) : '';
	if ( $has_portfolio === '1' ) {
		$meta_query[] = array( 'key' => 'application_filter_has_portfolio', 'value' => '1', 'compare' => '=' );
	} elseif ( $has_portfolio === '0' ) {
		$meta_query[] = array(
			'relation' => 'OR',
			array( 'key' => 'application_filter_has_portfolio', 'compare' => 'NOT EXISTS' ),
			array( 'key' => 'application_filter_has_portfolio', 'value' => '0', 'compare' => '=' ),
		);
	}
	return $meta_query;
}

/**
 * Build date_query array from current GET params (application_date_from, application_date_to).
 * Uses a single clause with both after/before so the date range is applied correctly.
 *
 * @return array|null Date query array or null if no date filter.
 */
function tasheel_hr_application_build_filter_date_query() {
	$date_from = isset( $_GET['application_date_from'] ) ? sanitize_text_field( wp_unslash( $_GET['application_date_from'] ) ) : '';
	$date_to   = isset( $_GET['application_date_to'] ) ? sanitize_text_field( wp_unslash( $_GET['application_date_to'] ) ) : '';
	if ( $date_from === '' && $date_to === '' ) {
		return null;
	}
	$clause = array( 'inclusive' => true );
	if ( $date_from !== '' ) {
		$clause['after'] = $date_from . ' 00:00:00';
	}
	if ( $date_to !== '' ) {
		$clause['before'] = $date_to . ' 23:59:59';
	}
	return array( $clause );
}

/**
 * Return application post IDs matching the current admin search term (same logic as advanced search).
 *
 * @param string $term Search term.
 * @return int[]
 */
function tasheel_hr_application_search_result_ids( $term ) {
	global $wpdb;
	$term = trim( sanitize_text_field( $term ) );
	if ( $term === '' ) {
		return array();
	}
	$like = '%' . $wpdb->esc_like( $term ) . '%';
	$ids = array();
	$title_ids = $wpdb->get_col( $wpdb->prepare(
		"SELECT ID FROM {$wpdb->posts} WHERE post_type = 'job_application' AND post_status IN ('publish','draft','pending','private') AND post_title LIKE %s",
		$like
	) );
	if ( is_array( $title_ids ) ) {
		$ids = array_merge( $ids, array_map( 'intval', $title_ids ) );
	}
	$snapshot_ids = $wpdb->get_col( $wpdb->prepare(
		"SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key = 'application_snapshot' AND meta_value LIKE %s",
		$like
	) );
	if ( is_array( $snapshot_ids ) ) {
		$ids = array_merge( $ids, array_map( 'intval', $snapshot_ids ) );
	}
	$guest_ids = $wpdb->get_col( $wpdb->prepare(
		"SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key = 'guest_email' AND meta_value LIKE %s",
		$like
	) );
	if ( is_array( $guest_ids ) ) {
		$ids = array_merge( $ids, array_map( 'intval', $guest_ids ) );
	}
	$user_ids = $wpdb->get_col( $wpdb->prepare(
		"SELECT ID FROM {$wpdb->users} WHERE display_name LIKE %s OR user_email LIKE %s",
		$like,
		$like
	) );
	if ( ! empty( $user_ids ) ) {
		$user_ids = array_map( 'absint', $user_ids );
		$placeholders = implode( ',', array_fill( 0, count( $user_ids ), '%d' ) );
		$user_app_ids = $wpdb->get_col( $wpdb->prepare(
			"SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key = 'user_id' AND meta_value IN ($placeholders)",
			...$user_ids
		) );
		if ( is_array( $user_app_ids ) ) {
			$ids = array_merge( $ids, array_map( 'intval', $user_app_ids ) );
		}
	}
	return array_unique( array_filter( $ids ) );
}

/**
 * Format education array for export with explicit labels so Excel is easy to read.
 * Each entry: "Degree: X | Major: Y | Institute: Z | Dates: ...". Multiple entries separated by " --- ".
 *
 * @param mixed $education Array or JSON string from snapshot.
 * @return string
 */
function tasheel_hr_export_format_education( $education ) {
	$list = tasheel_hr_normalize_snapshot_value( 'profile_education', $education );
	if ( ! is_array( $list ) || empty( $list ) ) {
		return '';
	}
	$sep_entry = ' --- ';
	$lines     = array();
	foreach ( $list as $idx => $e ) {
		$e        = is_array( $e ) ? $e : array();
		$degree   = isset( $e['degree'] ) ? trim( (string) $e['degree'] ) : '';
		$major    = isset( $e['major'] ) ? trim( (string) $e['major'] ) : '';
		$institute = isset( $e['institute'] ) ? trim( (string) $e['institute'] ) : '';
		$start    = isset( $e['start_date'] ) ? trim( (string) $e['start_date'] ) : '';
		$end      = isset( $e['end_date'] ) ? trim( (string) $e['end_date'] ) : '';
		$city     = isset( $e['city'] ) ? trim( (string) $e['city'] ) : '';
		$country  = isset( $e['country'] ) ? trim( (string) $e['country'] ) : '';
		$gpa      = isset( $e['gpa'] ) ? trim( (string) $e['gpa'] ) : '';
		$mode     = isset( $e['mode'] ) ? trim( (string) $e['mode'] ) : '';
		$dates    = ( $start !== '' || $end !== '' ) ? ( $start . ' to ' . $end ) : '';
		$country_name = ( $country !== '' && function_exists( 'tasheel_hr_get_country_name' ) ) ? tasheel_hr_get_country_name( $country ) : $country;
		$parts = array();
		if ( $degree !== '' ) {
			$parts[] = __( 'Degree', 'tasheel' ) . ': ' . $degree;
		}
		if ( $major !== '' ) {
			$parts[] = __( 'Major', 'tasheel' ) . ': ' . $major;
		}
		if ( $institute !== '' ) {
			$parts[] = __( 'Institute', 'tasheel' ) . ': ' . $institute;
		}
		if ( $dates !== '' ) {
			$parts[] = __( 'Dates', 'tasheel' ) . ': ' . $dates;
		}
		if ( $city !== '' ) {
			$parts[] = __( 'City', 'tasheel' ) . ': ' . $city;
		}
		if ( $country_name !== '' ) {
			$parts[] = __( 'Country', 'tasheel' ) . ': ' . $country_name;
		}
		if ( $gpa !== '' ) {
			$parts[] = __( 'GPA', 'tasheel' ) . ': ' . $gpa;
		}
		if ( $mode !== '' ) {
			$parts[] = __( 'Mode', 'tasheel' ) . ': ' . $mode;
		}
		$lines[] = implode( ' | ', $parts );
	}
	return implode( $sep_entry, $lines );
}

/**
 * Format experience array for export with explicit labels for Excel.
 * Each entry: "Job title: X | Employer: Y | Dates: ...". Multiple entries separated by " --- ".
 *
 * @param mixed $experience Array or JSON string from snapshot.
 * @return string
 */
function tasheel_hr_export_format_experience( $experience ) {
	$list = tasheel_hr_normalize_snapshot_value( 'profile_experience', $experience );
	if ( ! is_array( $list ) || empty( $list ) ) {
		return '';
	}
	$sep_entry = ' --- ';
	$lines     = array();
	foreach ( $list as $item ) {
		$item     = is_array( $item ) ? $item : array();
		$title    = isset( $item['job_title'] ) ? trim( (string) $item['job_title'] ) : '';
		$employer = isset( $item['employer'] ) ? trim( (string) $item['employer'] ) : '';
		$start    = isset( $item['start_date'] ) ? trim( (string) $item['start_date'] ) : '';
		$end      = isset( $item['end_date'] ) ? trim( (string) $item['end_date'] ) : '';
		$country  = isset( $item['country'] ) ? trim( (string) $item['country'] ) : '';
		$years    = isset( $item['years'] ) ? trim( (string) $item['years'] ) : '';
		$dates    = ( $start !== '' || $end !== '' ) ? ( $start . ' to ' . $end ) : '';
		$country_name = ( $country !== '' && function_exists( 'tasheel_hr_get_country_name' ) ) ? tasheel_hr_get_country_name( $country ) : $country;
		$parts = array();
		if ( $title !== '' ) {
			$parts[] = __( 'Job title', 'tasheel' ) . ': ' . $title;
		}
		if ( $employer !== '' ) {
			$parts[] = __( 'Employer', 'tasheel' ) . ': ' . $employer;
		}
		if ( $dates !== '' ) {
			$parts[] = __( 'Dates', 'tasheel' ) . ': ' . $dates;
		}
		if ( $country_name !== '' ) {
			$parts[] = __( 'Country', 'tasheel' ) . ': ' . $country_name;
		}
		if ( $years !== '' ) {
			$parts[] = __( 'Years', 'tasheel' ) . ': ' . $years;
		}
		$lines[] = implode( ' | ', $parts );
	}
	return implode( $sep_entry, $lines );
}

/**
 * Format licenses array for export with explicit label for Excel.
 *
 * @param mixed $licenses Array or JSON string from snapshot.
 * @return string
 */
function tasheel_hr_export_format_licenses( $licenses ) {
	$list = tasheel_hr_normalize_snapshot_value( 'profile_licenses', $licenses );
	if ( ! is_array( $list ) || empty( $list ) ) {
		return '';
	}
	$lines = array();
	foreach ( $list as $item ) {
		$item  = is_array( $item ) ? $item : array();
		$name  = isset( $item['name'] ) ? trim( (string) $item['name'] ) : '';
		$label = ( $name !== '' ) ? ( __( 'License', 'tasheel' ) . ': ' . $name ) : implode( ', ', array_filter( array_map( 'trim', $item ) ) );
		if ( $label !== '' ) {
			$lines[] = $label;
		}
	}
	return implode( ' --- ', $lines );
}

/**
 * Format recent projects array for export with explicit labels for Excel.
 * Each entry: "Company: X | Position: Y | Period: Z | Client: ...". Multiple entries separated by " --- ".
 *
 * @param mixed $projects Array or JSON string from snapshot.
 * @return string
 */
function tasheel_hr_export_format_recent_projects( $projects ) {
	$list = tasheel_hr_normalize_snapshot_value( 'profile_recent_projects', $projects );
	if ( ! is_array( $list ) || empty( $list ) ) {
		return '';
	}
	$sep_entry = ' --- ';
	$lines     = array();
	foreach ( $list as $p ) {
		$p        = is_array( $p ) ? $p : array();
		$company  = isset( $p['company'] ) ? trim( (string) $p['company'] ) : '';
		$client   = isset( $p['client'] ) ? trim( (string) $p['client'] ) : '';
		$position = isset( $p['position'] ) ? trim( (string) $p['position'] ) : '';
		$period   = isset( $p['period'] ) ? trim( (string) $p['period'] ) : '';
		$duties   = isset( $p['duties'] ) ? trim( (string) $p['duties'] ) : '';
		$parts    = array();
		if ( $company !== '' ) {
			$parts[] = __( 'Company', 'tasheel' ) . ': ' . $company;
		}
		if ( $client !== '' ) {
			$parts[] = __( 'Client', 'tasheel' ) . ': ' . $client;
		}
		if ( $position !== '' ) {
			$parts[] = __( 'Position', 'tasheel' ) . ': ' . $position;
		}
		if ( $period !== '' ) {
			$parts[] = __( 'Period', 'tasheel' ) . ': ' . $period;
		}
		if ( $duties !== '' ) {
			$parts[] = __( 'Duties', 'tasheel' ) . ': ' . $duties;
		}
		$lines[] = implode( ' | ', $parts );
	}
	return implode( $sep_entry, $lines );
}

/**
 * Snapshot keys for export only (no duplicates of main columns: Title, Applicant, Email, Job ID, Job Title, Resume URL).
 * Order matches the Create Profile form (contact → diversity → documents → education → experience → saudi council → additional → employment → recent projects → training).
 *
 * @return array Key => translated label.
 */
function tasheel_hr_application_export_snapshot_headers() {
	$labels = function_exists( 'tasheel_hr_profile_meta_labels' ) ? tasheel_hr_profile_meta_labels() : array();
	$labels['start_date'] = __( 'Training start date', 'tasheel' );
	$labels['duration']   = __( 'Training duration', 'tasheel' );
	$keys = function_exists( 'tasheel_hr_export_snapshot_keys_in_form_order' ) ? tasheel_hr_export_snapshot_keys_in_form_order() : array();
	$out = array();
	foreach ( $keys as $k ) {
		$out[ $k ] = isset( $labels[ $k ] ) ? $labels[ $k ] : $k;
	}
	return $out;
}

/**
 * Flatten one application's snapshot into export row values (same order as export_snapshot_headers).
 * Uses human-readable text for Education, Experience, Licenses, Recent Projects (no raw JSON).
 *
 * @param int   $app_id   Application post ID.
 * @param array $snapshot application_snapshot meta (array).
 * @return array Values only (same order as keys from tasheel_hr_application_export_snapshot_headers).
 */
function tasheel_hr_application_export_snapshot_row( $app_id, $snapshot ) {
	$keys = array_keys( tasheel_hr_application_export_snapshot_headers() );
	$row  = array();
	if ( ! is_array( $snapshot ) ) {
		$snapshot = array();
	}
	$start_date = get_post_meta( $app_id, 'start_date', true );
	$duration   = get_post_meta( $app_id, 'duration', true );
	$snapshot['start_date'] = $start_date;
	$snapshot['duration']   = $duration;

	$readable_complex = array( 'profile_education', 'profile_experience', 'profile_licenses', 'profile_recent_projects' );

	foreach ( $keys as $key ) {
		$val = isset( $snapshot[ $key ] ) ? $snapshot[ $key ] : '';
		if ( in_array( $key, $readable_complex, true ) ) {
			if ( $key === 'profile_education' ) {
				$val = tasheel_hr_export_format_education( $val );
			} elseif ( $key === 'profile_experience' ) {
				$val = tasheel_hr_export_format_experience( $val );
			} elseif ( $key === 'profile_licenses' ) {
				$val = tasheel_hr_export_format_licenses( $val );
			} else {
				$val = tasheel_hr_export_format_recent_projects( $val );
			}
		} elseif ( is_array( $val ) ) {
			if ( ( $key === 'profile_portfolio' || $key === 'profile_photo' ) && ! empty( $val['url'] ) ) {
				$val = $val['url'];
			} else {
				$val = '';
			}
		}
		if ( $key === 'profile_nationality' || $key === 'profile_country' ) {
			$val = function_exists( 'tasheel_hr_get_country_name' ) ? tasheel_hr_get_country_name( $val ) : $val;
		}
		if ( $key === 'profile_specialization' && function_exists( 'tasheel_hr_specialization_label' ) ) {
			$val = tasheel_hr_specialization_label( $val );
		}
		if ( $key === 'profile_visa_status' && function_exists( 'tasheel_hr_visa_status_label' ) ) {
			$val = tasheel_hr_visa_status_label( $val );
		}
		$row[] = (string) $val;
	}
	return $row;
}

/**
 * Handle Download CVs: build ZIP of resumes for filtered applications. Respects all filters and date range; works for HR admins (recruiter scope).
 * Runs on load-edit.php. Uses streaming (one file at a time) and raised limits to avoid timeout on long lists.
 */
function tasheel_hr_application_handle_download_cvs() {
	$post_type = isset( $_GET['post_type'] ) ? sanitize_text_field( wp_unslash( $_GET['post_type'] ) ) : '';
	$download  = isset( $_GET['tasheel_hr_download_cvs'] ) ? (int) $_GET['tasheel_hr_download_cvs'] : 0;
	if ( $post_type !== 'job_application' || $download !== 1 ) {
		return;
	}
	$app_obj = get_post_type_object( 'job_application' );
	$cap     = ( $app_obj && isset( $app_obj->cap->edit_posts ) ) ? $app_obj->cap->edit_posts : 'edit_posts';
	if ( ! current_user_can( $cap ) ) {
		return;
	}

	// Avoid timeout and memory exhaustion on long lists.
	if ( function_exists( 'set_time_limit' ) ) {
		@set_time_limit( 0 );
	}
	$current = ini_get( 'memory_limit' );
	if ( $current !== '-1' && wp_convert_hr_to_bytes( $current ) < 256 * 1024 * 1024 ) {
		@ini_set( 'memory_limit', '256M' );
	}

	$redirect_base = add_query_arg( array( 'post_type' => 'job_application' ), admin_url( 'edit.php' ) );
	$redirect_params = array(
		'application_status'        => isset( $_GET['application_status'] ) ? sanitize_text_field( wp_unslash( $_GET['application_status'] ) ) : '',
		'application_job_id'         => isset( $_GET['application_job_id'] ) ? (int) $_GET['application_job_id'] : 0,
		'application_nationality'    => isset( $_GET['application_nationality'] ) ? sanitize_text_field( wp_unslash( $_GET['application_nationality'] ) ) : '',
		'application_visa'           => isset( $_GET['application_visa'] ) ? sanitize_text_field( wp_unslash( $_GET['application_visa'] ) ) : '',
		'application_has_resume'     => isset( $_GET['application_has_resume'] ) ? sanitize_text_field( wp_unslash( $_GET['application_has_resume'] ) ) : '',
		'application_has_portfolio'  => isset( $_GET['application_has_portfolio'] ) ? sanitize_text_field( wp_unslash( $_GET['application_has_portfolio'] ) ) : '',
		'application_date_from'      => isset( $_GET['application_date_from'] ) ? sanitize_text_field( wp_unslash( $_GET['application_date_from'] ) ) : '',
		'application_date_to'        => isset( $_GET['application_date_to'] ) ? sanitize_text_field( wp_unslash( $_GET['application_date_to'] ) ) : '',
		's'                          => isset( $_GET['s'] ) ? sanitize_text_field( wp_unslash( $_GET['s'] ) ) : '',
	);
	$redirect_params = array_filter( $redirect_params );

	if ( ! class_exists( 'ZipArchive' ) ) {
		wp_safe_redirect( add_query_arg( array_merge( $redirect_params, array( 'tasheel_hr_cvs_error' => 'zip' ) ), $redirect_base ) );
		exit;
	}

	$meta_query = tasheel_hr_application_build_filter_meta_query();
	$term_slug  = function_exists( 'tasheel_hr_recruiter_allowed_term_slug' ) ? tasheel_hr_recruiter_allowed_term_slug() : '';
	if ( $term_slug !== '' ) {
		$job_ids = function_exists( 'tasheel_hr_get_applicable_job_ids_for_admin' ) ? tasheel_hr_get_applicable_job_ids_for_admin() : array();
		if ( empty( $job_ids ) ) {
			$meta_query[] = array( 'key' => 'job_id', 'value' => 0, 'compare' => '=' );
		} else {
			$meta_query[] = array( 'key' => 'job_id', 'value' => $job_ids, 'compare' => 'IN' );
		}
	}
	$date_query = tasheel_hr_application_build_filter_date_query();
	$args = array(
		'post_type'      => 'job_application',
		'post_status'    => 'any',
		'posts_per_page' => -1,
		'orderby'        => 'date',
		'order'          => 'DESC',
		'meta_query'     => $meta_query,
	);
	if ( $date_query !== null ) {
		$args['date_query'] = $date_query;
	}
	$search = isset( $_GET['s'] ) ? trim( sanitize_text_field( wp_unslash( $_GET['s'] ) ) ) : '';
	if ( $search !== '' ) {
		$ids = tasheel_hr_application_search_result_ids( $search );
		if ( empty( $ids ) ) {
			$args['post__in'] = array( 0 );
		} else {
			$args['post__in'] = $ids;
		}
	}

	$posts = get_posts( $args );
	$zip = new ZipArchive();
	$tmp = wp_tempnam( 'tasheel-cvs-' );
	if ( $zip->open( $tmp, ZipArchive::CREATE | ZipArchive::OVERWRITE ) !== true ) {
		@unlink( $tmp );
		wp_safe_redirect( add_query_arg( array_merge( $redirect_params, array( 'tasheel_hr_cvs_error' => 'zip' ) ), $redirect_base ) );
		exit;
	}

	$used_filenames = array();
	$added_count = 0;

	foreach ( $posts as $post ) {
		$app_id   = $post->ID;
		$snapshot = get_post_meta( $app_id, 'application_snapshot', true );
		$user_id  = (int) get_post_meta( $app_id, 'user_id', true );
		$guest    = get_post_meta( $app_id, 'guest_email', true );

		$resume_url = '';
		if ( ! empty( $snapshot['profile_resume'] ) && is_array( $snapshot['profile_resume'] ) && ! empty( $snapshot['profile_resume']['url'] ) ) {
			$resume_url = $snapshot['profile_resume']['url'];
		} elseif ( ! empty( $snapshot['profile_resume'] ) && is_string( $snapshot['profile_resume'] ) ) {
			$resume_url = $snapshot['profile_resume'];
		}
		if ( $resume_url === '' && $user_id ) {
			$profile_resume = get_user_meta( $user_id, 'profile_resume', true );
			if ( is_string( $profile_resume ) && trim( $profile_resume ) !== '' ) {
				$resume_url = $profile_resume;
			} elseif ( is_array( $profile_resume ) && ! empty( $profile_resume['url'] ) ) {
				$resume_url = $profile_resume['url'];
			}
		}
		if ( $resume_url === '' ) {
			continue;
		}

		$applicant_name = '';
		if ( is_array( $snapshot ) && ( ! empty( $snapshot['profile_first_name'] ) || ! empty( $snapshot['profile_last_name'] ) ) ) {
			$applicant_name = trim( ( $snapshot['profile_first_name'] ?? '' ) . ' ' . ( $snapshot['profile_last_name'] ?? '' ) );
		}
		if ( $applicant_name === '' && $user_id ) {
			$user = get_user_by( 'id', $user_id );
			$applicant_name = $user ? $user->display_name : '';
		}
		if ( $applicant_name === '' ) {
			$applicant_name = $guest ? $guest : __( 'Applicant', 'tasheel' );
		}
		$applicant_name = sanitize_file_name( preg_replace( '/[^a-zA-Z0-9_\-\s\.]/', '', $applicant_name ) );
		$applicant_name = trim( $applicant_name ) ?: 'Applicant';
		$applicant_name = str_replace( array( ' ', '.' ), '_', $applicant_name );

		$ext = 'pdf';
		$parsed = parse_url( $resume_url );
		if ( ! empty( $parsed['path'] ) && preg_match( '/\.(pdf|doc|docx)$/i', $parsed['path'], $m ) ) {
			$ext = strtolower( $m[1] );
		}
		$base_name = $applicant_name . '_' . $app_id . '.' . $ext;
		$counter = 0;
		while ( in_array( $base_name, $used_filenames, true ) ) {
			$counter++;
			$base_name = $applicant_name . '_' . $app_id . '_' . $counter . '.' . $ext;
		}
		$used_filenames[] = $base_name;

		if ( strpos( $resume_url, 'http' ) !== 0 ) {
			$resume_url = home_url( $resume_url );
		}
		$response = wp_remote_get( $resume_url, array( 'timeout' => 45, 'sslverify' => true ) );
		if ( is_wp_error( $response ) ) {
			continue;
		}
		$code = wp_remote_retrieve_response_code( $response );
		if ( $code !== 200 ) {
			continue;
		}
		$body = wp_remote_retrieve_body( $response );
		if ( $body === '' ) {
			continue;
		}
		$zip->addFromString( $base_name, $body );
		$added_count++;
		unset( $body );
	}

	$zip->close();

	if ( $added_count === 0 ) {
		@unlink( $tmp );
		wp_safe_redirect( add_query_arg( array_merge( $redirect_params, array( 'tasheel_hr_cvs_no_resumes' => '1' ) ), $redirect_base ) );
		exit;
	}

	$filename = 'applicant-resumes-' . gmdate( 'Y-m-d-His' ) . '.zip';
	header( 'Content-Type: application/zip' );
	header( 'Content-Disposition: attachment; filename="' . $filename . '"' );
	header( 'Content-Length: ' . filesize( $tmp ) );
	readfile( $tmp );
	@unlink( $tmp );
	exit;
}

add_action( 'load-edit.php', 'tasheel_hr_application_handle_download_cvs', 4 );

/**
 * Handle export CSV/Excel: output filtered application list with CV links. Runs on load-edit.php.
 */
function tasheel_hr_application_handle_export() {
	$post_type = isset( $_GET['post_type'] ) ? sanitize_text_field( wp_unslash( $_GET['post_type'] ) ) : '';
	$export    = isset( $_GET['tasheel_hr_export'] ) ? sanitize_text_field( wp_unslash( $_GET['tasheel_hr_export'] ) ) : '';
	if ( $post_type !== 'job_application' || ( $export !== 'csv' && $export !== 'excel' ) ) {
		return;
	}
	$app_obj = get_post_type_object( 'job_application' );
	$cap     = ( $app_obj && isset( $app_obj->cap->edit_posts ) ) ? $app_obj->cap->edit_posts : 'edit_posts';
	if ( ! current_user_can( $cap ) ) {
		return;
	}

	$meta_query = tasheel_hr_application_build_filter_meta_query();
	// Recruiter scope: export only applications for jobs in their job_type (export uses a secondary query, so pre_get_posts does not apply).
	$term_slug = function_exists( 'tasheel_hr_recruiter_allowed_term_slug' ) ? tasheel_hr_recruiter_allowed_term_slug() : '';
	if ( $term_slug !== '' ) {
		$job_ids = function_exists( 'tasheel_hr_get_applicable_job_ids_for_admin' ) ? tasheel_hr_get_applicable_job_ids_for_admin() : array();
		if ( empty( $job_ids ) ) {
			$meta_query[] = array(
				'key'     => 'job_id',
				'value'   => 0,
				'compare' => '=', // No matching jobs -> no results.
			);
		} else {
			$meta_query[] = array(
				'key'     => 'job_id',
				'value'   => $job_ids,
				'compare' => 'IN',
			);
		}
	}
	$date_query = tasheel_hr_application_build_filter_date_query();
	$args = array(
		'post_type'      => 'job_application',
		'post_status'    => 'any',
		'posts_per_page' => -1,
		'orderby'        => 'date',
		'order'          => 'DESC',
		'meta_query'     => $meta_query,
	);
	if ( $date_query !== null ) {
		$args['date_query'] = $date_query;
	}
	$search = isset( $_GET['s'] ) ? trim( sanitize_text_field( wp_unslash( $_GET['s'] ) ) ) : '';
	if ( $search !== '' ) {
		$ids = tasheel_hr_application_search_result_ids( $search );
		if ( empty( $ids ) ) {
			$args['post__in'] = array( 0 );
		} else {
			$args['post__in'] = $ids;
		}
	}

	$posts = get_posts( $args );
	$use_bom = ( $export === 'excel' );
	$filename = 'job-applications-' . gmdate( 'Y-m-d-His' ) . ( $export === 'excel' ? '.xls' : '.csv' );

	header( 'Content-Type: ' . ( $use_bom ? 'application/vnd.ms-excel' : 'text/csv' ) . '; charset=utf-8' );
	header( 'Content-Disposition: attachment; filename="' . $filename . '"' );
	if ( $use_bom ) {
		echo "\xEF\xBB\xBF";
	}

	// Main columns: Application ID first, then Rating/Internal notes/User note, then job & applicant info, then Resume URL (so Photo can follow right after).
	$cols = array(
		__( 'Application ID', 'tasheel' ),
		__( 'Rating (internal)', 'tasheel' ),
		__( 'Internal notes', 'tasheel' ),
		__( 'User note (HR)', 'tasheel' ),
		__( 'Job ID', 'tasheel' ),
		__( 'Job Title', 'tasheel' ),
		__( 'Title', 'tasheel' ),
		__( 'Applicant', 'tasheel' ),
		__( 'Email', 'tasheel' ),
		__( 'Date', 'tasheel' ),
		__( 'Status', 'tasheel' ),
		__( 'Resume URL', 'tasheel' ),
	);
	$snapshot_headers = tasheel_hr_application_export_snapshot_headers();
	$cols = array_merge( $cols, array_values( $snapshot_headers ) );
	echo tasheel_hr_application_csv_row( $cols, $use_bom );

	$status_labels = array(
		'submitted' => __( 'Submitted', 'tasheel' ),
		'under_review' => __( 'Under Review', 'tasheel' ),
		'shortlisted' => __( 'Shortlisted', 'tasheel' ),
		'accepted' => __( 'Accepted', 'tasheel' ),
		'rejected' => __( 'Rejected', 'tasheel' ),
	);

	foreach ( $posts as $post ) {
		$app_id   = $post->ID;
		$job_id   = (int) get_post_meta( $app_id, 'job_id', true );
		$user_id  = (int) get_post_meta( $app_id, 'user_id', true );
		$guest    = get_post_meta( $app_id, 'guest_email', true );
		$status   = get_post_meta( $app_id, 'application_status', true );
		$rating   = get_post_meta( $app_id, 'application_rating', true );
		$notes    = get_post_meta( $app_id, 'application_internal_notes', true );
		$snapshot = get_post_meta( $app_id, 'application_snapshot', true );
		$job_title = $job_id ? get_the_title( $job_id ) : '';
		$applicant = '';
		$email    = '';
		if ( $user_id ) {
			$user = get_user_by( 'id', $user_id );
			$applicant = $user ? $user->display_name : '';
			$email = $user ? $user->user_email : '';
		} else {
			$applicant = __( 'Guest', 'tasheel' );
			$email = $guest;
		}
		if ( is_array( $snapshot ) && ! empty( $snapshot['profile_first_name'] ) ) {
			$applicant = trim( ( $snapshot['profile_first_name'] ?? '' ) . ' ' . ( $snapshot['profile_last_name'] ?? '' ) );
			if ( $email === '' && ! empty( $snapshot['profile_email'] ) ) {
				$email = $snapshot['profile_email'];
			}
		}
		$title_label = '';
		if ( ! empty( $snapshot['profile_title'] ) && function_exists( 'tasheel_hr_title_display_label' ) ) {
			$title_label = tasheel_hr_title_display_label( $snapshot['profile_title'] );
		} elseif ( ! empty( $snapshot['profile_title'] ) ) {
			$title_label = $snapshot['profile_title'];
		}
		$resume_url = '';
		if ( ! empty( $snapshot['profile_resume'] ) ) {
			if ( is_array( $snapshot['profile_resume'] ) && ! empty( $snapshot['profile_resume']['url'] ) ) {
				$resume_url = $snapshot['profile_resume']['url'];
			} elseif ( is_string( $snapshot['profile_resume'] ) ) {
				$resume_url = $snapshot['profile_resume'];
			}
		}
		$status_label = isset( $status_labels[ $status ] ) ? $status_labels[ $status ] : $status;
		$user_note   = $user_id ? (string) get_user_meta( $user_id, 'tasheel_hr_profile_notes', true ) : '';
		// Row order must match header: Application ID, Rating, Internal notes, User note, then Job ID … Resume URL, then snapshot (Photo first so it follows Resume).
		$row = array( $app_id, $rating, $notes, $user_note, $job_id, $job_title, $title_label, $applicant, $email, get_the_date( '', $post ), $status_label, $resume_url );
		$snapshot_row = tasheel_hr_application_export_snapshot_row( $app_id, $snapshot );
		$row = array_merge( $row, $snapshot_row );
		echo tasheel_hr_application_csv_row( $row, $use_bom );
	}
	exit;
}

/**
 * Output a CSV row (escape and quote for CSV/Excel).
 *
 * @param array $row    Values.
 * @param bool  $excel  Use tab and UTF-8 BOM already sent.
 */
function tasheel_hr_application_csv_row( $row, $excel = false ) {
	$sep = $excel ? "\t" : ',';
	$out = array();
	foreach ( $row as $cell ) {
		$cell = (string) $cell;
		$cell = str_replace( array( "\r", "\n" ), array( ' ', ' ' ), $cell );
		if ( $excel ) {
			$out[] = '"' . str_replace( '"', '""', $cell ) . '"';
		} else {
			if ( strpos( $cell, $sep ) !== false || strpos( $cell, '"' ) !== false ) {
				$cell = '"' . str_replace( '"', '""', $cell ) . '"';
			}
			$out[] = $cell;
		}
	}
	return implode( $sep, $out ) . "\n";
}

add_action( 'load-edit.php', 'tasheel_hr_application_handle_export', 5 );

/**
 * Admin notices after Download CVs redirect (no resumes found or ZIP error).
 */
function tasheel_hr_application_download_cvs_notices() {
	$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
	if ( ! $screen || $screen->id !== 'edit-job_application' ) {
		return;
	}
	if ( isset( $_GET['tasheel_hr_cvs_no_resumes'] ) && (int) $_GET['tasheel_hr_cvs_no_resumes'] === 1 ) {
		echo '<div class="notice notice-warning is-dismissible"><p>' . esc_html__( 'No resumes found for the selected applications. Try adjusting your filters or ensure applications have a resume attached.', 'tasheel' ) . '</p></div>';
	}
	if ( isset( $_GET['tasheel_hr_cvs_error'] ) && $_GET['tasheel_hr_cvs_error'] === 'zip' ) {
		echo '<div class="notice notice-error is-dismissible"><p>' . esc_html__( 'Download CVs failed: ZIP support is not available on this server.', 'tasheel' ) . '</p></div>';
	}
}
add_action( 'admin_notices', 'tasheel_hr_application_download_cvs_notices' );

add_filter( 'manage_job_application_posts_columns', 'tasheel_hr_application_list_columns', 9999 );
add_filter( 'list_table_primary_column', 'tasheel_hr_application_list_primary_column', 10, 2 );
add_action( 'manage_job_application_posts_custom_column', 'tasheel_hr_application_list_column_content', 10, 2 );
add_filter( 'manage_edit-job_application_sortable_columns', 'tasheel_hr_application_sortable_columns' );
add_action( 'pre_get_posts', 'tasheel_hr_application_orderby_columns', 5 );
add_action( 'restrict_manage_posts', 'tasheel_hr_application_list_filters', 10, 2 );
add_action( 'pre_get_posts', 'tasheel_hr_application_list_apply_filters', 15 );
add_action( 'pre_get_posts', 'tasheel_hr_application_advanced_search', 20 );
add_action( 'load-edit.php', 'tasheel_hr_application_maybe_backfill_filter_meta' );

/**
 * Render the application snapshot meta box (read-only profile at time of submit).
 *
 * @param \WP_Post $post Application post.
 */
function tasheel_hr_render_application_snapshot_meta_box( $post ) {
	$start_date = get_post_meta( $post->ID, 'start_date', true );
	$duration   = get_post_meta( $post->ID, 'duration', true );
	$snapshot = get_post_meta( $post->ID, 'application_snapshot', true );
	$user_id  = (int) get_post_meta( $post->ID, 'user_id', true );
	// CRITICAL: Only show stored snapshot. Never read from live user profile — changes after submission must NOT reflect here.
	if ( empty( $snapshot ) || ! is_array( $snapshot ) ) {
		echo '<p>' . esc_html__( 'No profile snapshot stored.', 'tasheel' ) . '</p>';
		if ( $user_id ) {
			$edit_user = admin_url( 'user-edit.php?user_id=' . $user_id );
			echo '<p><a href="' . esc_url( $edit_user ) . '" class="button">' . esc_html__( 'View full profile in User', 'tasheel' ) . '</a></p>';
		}
		return;
	}
	if ( $user_id ) {
		$edit_user = admin_url( 'user-edit.php?user_id=' . $user_id );
		echo '<p><a href="' . esc_url( $edit_user ) . '" class="button">' . esc_html__( 'View full profile in User', 'tasheel' ) . '</a></p>';
	}
	// Show only details that were submitted for this job category (same sections as review for each job type).
	$job_id = (int) get_post_meta( $post->ID, 'job_id', true );
	$job_type_slug = $job_id && function_exists( 'tasheel_hr_get_job_type_slug' ) ? tasheel_hr_get_job_type_slug( $job_id ) : 'career';
	$job_type_normalized = function_exists( 'tasheel_hr_normalize_job_type_slug' ) ? tasheel_hr_normalize_job_type_slug( $job_type_slug ) : ( $job_type_slug ?: 'career' );
	$allowed_keys = array( 'job_id', 'job_title', 'profile_email' );
	if ( function_exists( 'tasheel_hr_snapshot_keys_for_job_type' ) ) {
		$allowed_keys = array_merge( $allowed_keys, tasheel_hr_snapshot_keys_for_job_type( $job_type_slug ) );
	}
	$review_sections = function_exists( 'tasheel_hr_review_sections_for_job_type' ) ? tasheel_hr_review_sections_for_job_type( $job_type_normalized ) : array( 'contact', 'diversity', 'documents', 'education', 'experience', 'saudi_council', 'additional_info', 'employment_history' );
	$labels = function_exists( 'tasheel_hr_profile_meta_labels' ) ? tasheel_hr_profile_meta_labels() : array();
	$labels['job_id']    = __( 'Job ID', 'tasheel' );
	$labels['job_title'] = __( 'Job Title', 'tasheel' );
	$labels['profile_email'] = __( 'Email', 'tasheel' );

	// Keys to skip in main table (shown in dedicated blocks or not at all). profile_photo shown above table to match frontend Review Profile.
	$skip_in_table = array( 'profile_education', 'profile_experience', 'profile_licenses', 'profile_recent_projects', 'profile_saudi_council_thumb', 'profile_saudi_council', 'profile_currently_employed', 'profile_previously_worked', 'profile_employee_id', 'profile_current_project', 'profile_current_department', 'profile_previous_duration', 'profile_last_project', 'profile_previous_department', 'profile_photo' );

	// Order matches Review Profile: contact (then photo above) → diversity (Gender, Marital Status, DOB, National Status, Nationality, Location) → documents.
	$contact_diversity_documents = array( 'job_id', 'job_title', 'profile_title', 'profile_first_name', 'profile_last_name', 'profile_email', 'profile_phone', 'profile_photo', 'profile_gender', 'profile_marital_status', 'profile_dob', 'profile_national_status', 'profile_nationality', 'profile_location', 'profile_resume', 'profile_linkedin', 'profile_portfolio' );
	$additional_info_keys = array( 'profile_specialization', 'profile_years_experience', 'profile_notice_period', 'profile_current_salary', 'profile_expected_salary', 'profile_visa_status' );

	$render_snapshot_row = function( $key, $val, $labels ) {
		if ( is_array( $val ) || ( $val === '' && $key !== 'job_id' && $key !== 'job_title' ) ) {
			return null;
		}
		$label = isset( $labels[ $key ] ) ? $labels[ $key ] : $key;
		$display_val = $val;
		if ( $key === 'profile_title' && function_exists( 'tasheel_hr_title_display_label' ) ) {
			$display_val = tasheel_hr_title_display_label( $val );
		}
		if ( $key === 'profile_gender' && function_exists( 'tasheel_hr_gender_display_label' ) ) {
			$display_val = tasheel_hr_gender_display_label( $val );
		}
		if ( $key === 'profile_marital_status' && function_exists( 'tasheel_hr_marital_status_label' ) ) {
			$display_val = tasheel_hr_marital_status_label( $val );
		}
		if ( $key === 'profile_national_status' && $val !== '' ) {
			$display_val = ucfirst( $val );
		}
		if ( $key === 'profile_nationality' || $key === 'profile_country' ) {
			$display_val = function_exists( 'tasheel_hr_get_country_name' ) ? tasheel_hr_get_country_name( $val ) : $val;
		}
		if ( $key === 'profile_specialization' && function_exists( 'tasheel_hr_specialization_label' ) ) {
			$display_val = tasheel_hr_specialization_label( $val );
		}
		if ( $key === 'profile_visa_status' && function_exists( 'tasheel_hr_visa_status_label' ) ) {
			$display_val = tasheel_hr_visa_status_label( $val );
		}
		$cell = esc_html( $display_val );
		if ( ( $key === 'profile_photo' || $key === 'profile_resume' || $key === 'profile_portfolio' || $key === 'profile_linkedin' ) && is_string( $val ) && filter_var( $val, FILTER_VALIDATE_URL ) ) {
			$link_text = ( $key === 'profile_photo' ) ? __( 'View photo', 'tasheel' ) : ( basename( wp_parse_url( $val, PHP_URL_PATH ) ) ?: $val );
			$cell = '<a href="' . esc_url( $val ) . '" target="_blank" rel="noopener">' . esc_html( $link_text ) . '</a>';
		}
		return array( 'label' => $label, 'cell' => $cell );
	};

	// Profile photo above table (same as frontend Review Profile: photo first / above title)
	$snapshot_photo = isset( $snapshot['profile_photo'] ) ? $snapshot['profile_photo'] : '';
	if ( is_array( $snapshot_photo ) && ! empty( $snapshot_photo['url'] ) ) {
		$snapshot_photo = $snapshot_photo['url'];
	}
	if ( $snapshot_photo !== '' && is_string( $snapshot_photo ) && filter_var( $snapshot_photo, FILTER_VALIDATE_URL ) ) {
		echo '<div style="margin-bottom:16px; padding:15px; background:#f9f9f9; border-radius:6px; display:inline-block;">';
		echo '<p style="margin:0 0 10px 0; font-weight:600;">' . esc_html__( 'Profile Photo', 'tasheel' ) . '</p>';
		echo '<a href="' . esc_url( $snapshot_photo ) . '" target="_blank" rel="noopener">';
		echo '<img src="' . esc_url( $snapshot_photo ) . '" alt="' . esc_attr__( 'Profile Photo', 'tasheel' ) . '" style="max-width:150px; height:auto; border-radius:6px; border:1px solid #ddd; display:block;">';
		echo '</a>';
		echo '<p style="margin:8px 0 0 0; font-size:12px;"><a href="' . esc_url( $snapshot_photo ) . '" target="_blank" rel="noopener">' . esc_html( basename( wp_parse_url( $snapshot_photo, PHP_URL_PATH ) ) ?: $snapshot_photo ) . '</a></p>';
		echo '</div>';
	}

	// Table 1: Contact, Diversity, Documents (same order as review)
	echo '<table class="widefat striped" style="margin-top:8px;"><tbody>';
	foreach ( $contact_diversity_documents as $key ) {
		if ( ! in_array( $key, $allowed_keys, true ) || in_array( $key, $skip_in_table, true ) ) {
			continue;
		}
		$val = isset( $snapshot[ $key ] ) ? $snapshot[ $key ] : '';
		if ( $key === 'profile_resume' && is_array( $val ) && ! empty( $val['url'] ) ) {
			$val = $val['url'];
		} elseif ( $key === 'profile_portfolio' && is_array( $val ) && ! empty( $val['url'] ) ) {
			$val = $val['url'];
		} elseif ( $key === 'profile_photo' && is_array( $val ) && ! empty( $val['url'] ) ) {
			$val = $val['url'];
		}
		$row = $render_snapshot_row( $key, $val, $labels );
		if ( $row ) {
			echo '<tr><th style="width:220px;">' . esc_html( $row['label'] ) . '</th><td>' . $row['cell'] . '</td></tr>';
		}
	}
	echo '</tbody></table>';

	// Training enrollment (after main applicant details)
	if ( $start_date || $duration ) {
		$start_date_labels = array(
			'2026-01' => __( 'January 2026', 'tasheel' ),
			'2026-02' => __( 'February 2026', 'tasheel' ),
			'2026-03' => __( 'March 2026', 'tasheel' ),
			'2026-04' => __( 'April 2026', 'tasheel' ),
		);
		$duration_labels = array(
			'1-month'   => __( '1 Month', 'tasheel' ),
			'3-months'  => __( '3 Months', 'tasheel' ),
			'6-months'  => __( '6 Months', 'tasheel' ),
			'12-months' => __( '12 Months', 'tasheel' ),
		);
		$display_start   = isset( $start_date_labels[ $start_date ] ) ? $start_date_labels[ $start_date ] : $start_date;
		$display_duration = isset( $duration_labels[ $duration ] ) ? $duration_labels[ $duration ] : $duration;
		echo '<h4 style="margin:16px 0 8px 0;">' . esc_html__( 'Training enrollment', 'tasheel' ) . '</h4>';
		echo '<table class="widefat striped" style="margin-bottom:12px;"><tbody>';
		echo '<tr><th style="width:220px;">' . esc_html__( 'Start date', 'tasheel' ) . '</th><td>' . esc_html( $display_start ?: '—' ) . '</td></tr>';
		echo '<tr><th>' . esc_html__( 'Duration', 'tasheel' ) . '</th><td>' . esc_html( $display_duration ?: '—' ) . '</td></tr>';
		echo '</tbody></table>';
	}

	// Education (when in allowed keys and review sections)
	if ( in_array( 'profile_education', $allowed_keys, true ) && in_array( 'education', $review_sections, true ) ) {
		$education = tasheel_hr_normalize_snapshot_value( 'profile_education', isset( $snapshot['profile_education'] ) ? $snapshot['profile_education'] : '' );
		echo '<h4 style="margin:16px 0 8px 0;">' . esc_html__( 'Education', 'tasheel' ) . '</h4>';
		if ( ! empty( $education ) ) {
			$edu_labels = array(
				'institute'   => __( 'Institute', 'tasheel' ),
				'degree'      => __( 'Degree', 'tasheel' ),
				'major'       => __( 'Major', 'tasheel' ),
				'start_date'  => __( 'Start Date', 'tasheel' ),
				'end_date'    => __( 'End Date', 'tasheel' ),
				'under_process' => __( 'Under Process', 'tasheel' ),
				'city'        => __( 'City', 'tasheel' ),
				'country'     => __( 'Country', 'tasheel' ),
				'gpa'         => __( 'GPA', 'tasheel' ),
				'avg_grade'   => __( 'Average Grade', 'tasheel' ),
				'mode'        => __( 'Mode of Study', 'tasheel' ),
			);
			foreach ( $education as $i => $item ) {
				$item = is_array( $item ) ? $item : array();
				$entry_num = $i + 1;
				echo '<table class="widefat striped" style="margin-bottom:12px;"><thead><tr><th colspan="2" style="background:#f6f7f7;padding:8px 12px;">' . esc_html( sprintf( __( 'Education %d', 'tasheel' ), $entry_num ) ) . '</th></tr></thead><tbody>';
				$institute = isset( $item['institute'] ) ? $item['institute'] : ( isset( $item['institution'] ) ? $item['institution'] : '' );
				if ( $institute ) {
					echo '<tr><th style="width:180px;">' . esc_html( $edu_labels['institute'] ) . '</th><td>' . esc_html( $institute ) . '</td></tr>';
				}
				$degree = isset( $item['degree'] ) ? $item['degree'] : '';
				if ( $degree ) {
					$degree_display = function_exists( 'tasheel_hr_education_degree_label' ) ? tasheel_hr_education_degree_label( $degree ) : $degree;
					echo '<tr><th>' . esc_html( $edu_labels['degree'] ) . '</th><td>' . esc_html( $degree_display ) . '</td></tr>';
				}
				$major = isset( $item['major'] ) ? $item['major'] : '';
				if ( $major ) {
					$major_display = function_exists( 'tasheel_hr_education_major_label' ) ? tasheel_hr_education_major_label( $major ) : $major;
					echo '<tr><th>' . esc_html( $edu_labels['major'] ) . '</th><td>' . esc_html( $major_display ) . '</td></tr>';
				}
				$start = isset( $item['start_date'] ) ? $item['start_date'] : '';
				$end = isset( $item['end_date'] ) ? $item['end_date'] : '';
				if ( $start || $end ) {
					echo '<tr><th>' . esc_html( $edu_labels['start_date'] ) . ' / ' . esc_html( $edu_labels['end_date'] ) . '</th><td>' . esc_html( $start . ( $start && $end ? ' – ' : '' ) . $end ) . '</td></tr>';
				}
				if ( ! empty( $item['under_process'] ) ) {
					echo '<tr><th>' . esc_html( $edu_labels['under_process'] ) . '</th><td>' . esc_html__( 'Yes', 'tasheel' ) . '</td></tr>';
				}
				$city = isset( $item['city'] ) ? $item['city'] : '';
				$country = isset( $item['country'] ) && function_exists( 'tasheel_hr_get_country_name' ) ? tasheel_hr_get_country_name( $item['country'] ) : ( isset( $item['country'] ) ? $item['country'] : '' );
				if ( $city || $country ) {
					echo '<tr><th>' . esc_html( $edu_labels['city'] ) . ' / ' . esc_html( $edu_labels['country'] ) . '</th><td>' . esc_html( trim( $city . ( $city && $country ? ', ' : '' ) . $country ) ) . '</td></tr>';
				}
				$gpa = isset( $item['gpa'] ) ? $item['gpa'] : '';
				$avg = isset( $item['avg_grade'] ) ? $item['avg_grade'] : '';
				$mode = isset( $item['mode'] ) ? $item['mode'] : '';
				if ( $gpa || $avg || $mode ) {
					$grade_parts = array();
					if ( $gpa ) { $grade_parts[] = 'GPA: ' . $gpa; }
					if ( $avg ) { $grade_parts[] = 'Avg: ' . $avg; }
					if ( $mode ) {
						$mode_display = function_exists( 'tasheel_hr_education_mode_label' ) ? tasheel_hr_education_mode_label( $mode ) : $mode;
						$grade_parts[] = $mode_display;
					}
					echo '<tr><th>' . esc_html( $edu_labels['gpa'] ) . ' / ' . esc_html( $edu_labels['avg_grade'] ) . ' / ' . esc_html( $edu_labels['mode'] ) . '</th><td>' . esc_html( implode( ' | ', $grade_parts ) ) . '</td></tr>';
				}
				echo '</tbody></table>';
			}
		} else {
			echo '<p class="description">—</p>';
		}
	}

	// Experience
	if ( in_array( 'profile_experience', $allowed_keys, true ) && in_array( 'experience', $review_sections, true ) ) {
		$exp_list = tasheel_hr_normalize_snapshot_value( 'profile_experience', isset( $snapshot['profile_experience'] ) ? $snapshot['profile_experience'] : '' );
		echo '<h4 style="margin:16px 0 8px 0;">' . esc_html__( 'Experience', 'tasheel' ) . '</h4>';
		if ( ! empty( $exp_list ) && is_array( $exp_list ) ) {
			$exp_labels = array(
				'job_title'   => __( 'Job Title', 'tasheel' ),
				'employer'    => __( 'Employer', 'tasheel' ),
				'start_date'  => __( 'Start Date', 'tasheel' ),
				'end_date'    => __( 'End Date', 'tasheel' ),
				'current_job' => __( 'Current Job', 'tasheel' ),
				'country'     => __( 'Country', 'tasheel' ),
				'years'       => __( 'Years', 'tasheel' ),
				'salary'      => __( 'Salary', 'tasheel' ),
				'benefits'    => __( 'Benefits', 'tasheel' ),
				'reason_leaving' => __( 'Reason for Leaving', 'tasheel' ),
			);
			foreach ( $exp_list as $i => $item ) {
				$item = is_array( $item ) ? $item : array();
				$entry_num = $i + 1;
				echo '<table class="widefat striped" style="margin-bottom:12px;"><thead><tr><th colspan="2" style="background:#f6f7f7;padding:8px 12px;">' . esc_html( sprintf( __( 'Experience %d', 'tasheel' ), $entry_num ) ) . '</th></tr></thead><tbody>';
				$title = isset( $item['job_title'] ) ? $item['job_title'] : '';
				if ( $title ) {
					echo '<tr><th style="width:180px;">' . esc_html( $exp_labels['job_title'] ) . '</th><td>' . esc_html( $title ) . '</td></tr>';
				}
				$employer = isset( $item['employer'] ) ? $item['employer'] : '';
				if ( $employer ) {
					echo '<tr><th>' . esc_html( $exp_labels['employer'] ) . '</th><td>' . esc_html( $employer ) . '</td></tr>';
				}
				$start = isset( $item['start_date'] ) ? $item['start_date'] : '';
				$end = isset( $item['end_date'] ) ? $item['end_date'] : '';
				if ( $start || $end ) {
					$dates = $start . ( $start && $end ? ' – ' : '' ) . $end;
					if ( ! empty( $item['current_job'] ) ) {
						$dates .= ' (' . __( 'Current', 'tasheel' ) . ')';
					}
					echo '<tr><th>' . esc_html( $exp_labels['start_date'] ) . ' / ' . esc_html( $exp_labels['end_date'] ) . '</th><td>' . esc_html( $dates ) . '</td></tr>';
				} elseif ( ! empty( $item['current_job'] ) ) {
					echo '<tr><th>' . esc_html( $exp_labels['current_job'] ) . '</th><td>' . esc_html__( 'Yes', 'tasheel' ) . '</td></tr>';
				}
				$country = isset( $item['country'] ) && function_exists( 'tasheel_hr_get_country_name' ) ? tasheel_hr_get_country_name( $item['country'] ) : ( isset( $item['country'] ) ? $item['country'] : '' );
				if ( $country ) {
					echo '<tr><th>' . esc_html( $exp_labels['country'] ) . '</th><td>' . esc_html( $country ) . '</td></tr>';
				}
				$years = isset( $item['years'] ) ? $item['years'] : '';
				if ( $years ) {
					echo '<tr><th>' . esc_html( $exp_labels['years'] ) . '</th><td>' . esc_html( $years ) . '</td></tr>';
				}
				$salary = isset( $item['salary'] ) ? $item['salary'] : '';
				if ( $salary ) {
					echo '<tr><th>' . esc_html( $exp_labels['salary'] ) . '</th><td>' . esc_html( $salary ) . '</td></tr>';
				}
				$benefits = isset( $item['benefits'] ) ? $item['benefits'] : '';
				if ( $benefits ) {
					echo '<tr><th>' . esc_html( $exp_labels['benefits'] ) . '</th><td>' . esc_html( $benefits ) . '</td></tr>';
				}
				$reason = isset( $item['reason_leaving'] ) ? $item['reason_leaving'] : '';
				if ( $reason ) {
					echo '<tr><th>' . esc_html( $exp_labels['reason_leaving'] ) . '</th><td>' . esc_html( $reason ) . '</td></tr>';
				}
				echo '</tbody></table>';
			}
		} else {
			echo '<p class="description">—</p>';
		}
	}

	// Saudi Council (single block only; not duplicated in main table)
	if ( in_array( 'profile_saudi_council', $allowed_keys, true ) && in_array( 'saudi_council', $review_sections, true ) ) {
		$saudi_url = isset( $snapshot['profile_saudi_council'] ) ? $snapshot['profile_saudi_council'] : '';
		if ( is_array( $saudi_url ) && ! empty( $saudi_url['url'] ) ) {
			$saudi_url = $saudi_url['url'];
		}
		echo '<h4 style="margin:16px 0 8px 0;">' . esc_html__( 'Saudi Council Classification', 'tasheel' ) . '</h4>';
		echo '<table class="widefat striped"><tbody>';
		echo '<tr><th style="width:220px;">' . esc_html__( 'Document', 'tasheel' ) . '</th><td>';
		echo $saudi_url ? '<a href="' . esc_url( $saudi_url ) . '" target="_blank" rel="noopener">' . esc_html( basename( wp_parse_url( $saudi_url, PHP_URL_PATH ) ) ?: __( 'View document', 'tasheel' ) ) . '</a>' : '—';
		echo '</td></tr></tbody></table>';
	}

	// Additional Information (after Saudi Council, before Employment History)
	if ( in_array( 'additional_info', $review_sections, true ) ) {
		$has_any = false;
		foreach ( $additional_info_keys as $key ) {
			if ( ! in_array( $key, $allowed_keys, true ) ) {
				continue;
			}
			$v = isset( $snapshot[ $key ] ) ? $snapshot[ $key ] : '';
			if ( $v !== '' && ! is_array( $v ) ) {
				$has_any = true;
				break;
			}
		}
		if ( $has_any ) {
			echo '<h4 style="margin:16px 0 8px 0;">' . esc_html__( 'Additional Information', 'tasheel' ) . '</h4>';
			echo '<table class="widefat striped" style="margin-bottom:12px;"><tbody>';
			foreach ( $additional_info_keys as $key ) {
				if ( ! in_array( $key, $allowed_keys, true ) ) {
					continue;
				}
				$val = isset( $snapshot[ $key ] ) ? $snapshot[ $key ] : '';
				$row = $render_snapshot_row( $key, $val, $labels );
				if ( $row ) {
					echo '<tr><th style="width:220px;">' . esc_html( $row['label'] ) . '</th><td>' . $row['cell'] . '</td></tr>';
				}
			}
			echo '</tbody></table>';
		}
	}

	// Employment History at Saud Consult (currently/previously employed + sub-details when yes)
	if ( in_array( 'employment_history', $review_sections, true ) ) {
		$curr_emp = isset( $snapshot['profile_currently_employed'] ) ? $snapshot['profile_currently_employed'] : '';
		$prev_work = isset( $snapshot['profile_previously_worked'] ) ? $snapshot['profile_previously_worked'] : '';
		if ( $curr_emp !== '' || $prev_work !== '' ) {
			echo '<h4 style="margin:16px 0 8px 0;">' . esc_html__( 'Employment History at Saud Consult', 'tasheel' ) . '</h4>';
			echo '<table class="widefat striped" style="margin-bottom:12px;"><tbody>';
			echo '<tr><th style="width:220px;">' . esc_html__( 'Currently employed at Saud Consult?', 'tasheel' ) . '</th><td>' . esc_html( $curr_emp ? ucfirst( $curr_emp ) : '—' );
			if ( $curr_emp === 'yes' ) {
				$emp_id   = isset( $snapshot['profile_employee_id'] ) ? $snapshot['profile_employee_id'] : '';
				$curr_prj = isset( $snapshot['profile_current_project'] ) ? $snapshot['profile_current_project'] : '';
				$curr_dept = isset( $snapshot['profile_current_department'] ) ? $snapshot['profile_current_department'] : '';
				if ( $emp_id !== '' || $curr_prj !== '' || $curr_dept !== '' ) {
					echo '<div style="margin-top:8px; padding-left:12px; border-left:3px solid #0D6A37;">';
					if ( $emp_id !== '' ) { echo '<p style="margin:4px 0;"><strong>' . esc_html__( 'Employee ID', 'tasheel' ) . ':</strong> ' . esc_html( $emp_id ) . '</p>'; }
					if ( $curr_prj !== '' ) { echo '<p style="margin:4px 0;"><strong>' . esc_html__( 'Current Project', 'tasheel' ) . ':</strong> ' . esc_html( $curr_prj ) . '</p>'; }
					if ( $curr_dept !== '' ) {
					$curr_dept_display = function_exists( 'tasheel_hr_department_display_label' ) ? tasheel_hr_department_display_label( $curr_dept ) : $curr_dept;
					echo '<p style="margin:4px 0;"><strong>' . esc_html__( 'Department', 'tasheel' ) . ':</strong> ' . esc_html( $curr_dept_display ) . '</p>';
				}
					echo '</div>';
				}
			}
			echo '</td></tr>';
			echo '<tr><th>' . esc_html__( 'Previously worked at Saud Consult?', 'tasheel' ) . '</th><td>' . esc_html( $prev_work ? ucfirst( $prev_work ) : '—' );
			if ( $prev_work === 'yes' ) {
				$prev_dur  = isset( $snapshot['profile_previous_duration'] ) ? $snapshot['profile_previous_duration'] : '';
				$last_prj  = isset( $snapshot['profile_last_project'] ) ? $snapshot['profile_last_project'] : '';
				$prev_dept = isset( $snapshot['profile_previous_department'] ) ? $snapshot['profile_previous_department'] : '';
				if ( $prev_dur !== '' || $last_prj !== '' || $prev_dept !== '' ) {
					echo '<div style="margin-top:8px; padding-left:12px; border-left:3px solid #0D6A37;">';
					if ( $prev_dur !== '' ) { echo '<p style="margin:4px 0;"><strong>' . esc_html__( 'Duration', 'tasheel' ) . ':</strong> ' . esc_html( $prev_dur ) . '</p>'; }
					if ( $last_prj !== '' ) { echo '<p style="margin:4px 0;"><strong>' . esc_html__( 'Last Project', 'tasheel' ) . ':</strong> ' . esc_html( $last_prj ) . '</p>'; }
					if ( $prev_dept !== '' ) {
						$prev_dept_display = function_exists( 'tasheel_hr_department_display_label' ) ? tasheel_hr_department_display_label( $prev_dept ) : $prev_dept;
						echo '<p style="margin:4px 0;"><strong>' . esc_html__( 'Department', 'tasheel' ) . ':</strong> ' . esc_html( $prev_dept_display ) . '</p>';
					}
					echo '</div>';
				}
			}
			echo '</td></tr></tbody></table>';
		}
	}

	// Recent Projects (employment_history section)
	if ( in_array( 'profile_recent_projects', $allowed_keys, true ) && in_array( 'employment_history', $review_sections, true ) ) {
		$proj_list = tasheel_hr_normalize_snapshot_value( 'profile_recent_projects', isset( $snapshot['profile_recent_projects'] ) ? $snapshot['profile_recent_projects'] : '' );
		echo '<h4 style="margin:16px 0 8px 0;">' . esc_html__( 'Recent Projects', 'tasheel' ) . '</h4>';
		if ( ! empty( $proj_list ) && is_array( $proj_list ) ) {
			$proj_labels = array(
				'company'  => __( 'Company', 'tasheel' ),
				'client'   => __( 'Client', 'tasheel' ),
				'position' => __( 'Position', 'tasheel' ),
				'period'   => __( 'Period', 'tasheel' ),
				'duties'   => __( 'Duties', 'tasheel' ),
			);
			foreach ( $proj_list as $i => $pr ) {
				$pr = is_array( $pr ) ? $pr : array();
				$entry_num = $i + 1;
				echo '<table class="widefat striped" style="margin-bottom:12px;"><thead><tr><th colspan="2" style="background:#f6f7f7;padding:8px 12px;">' . esc_html( sprintf( __( 'Project %d', 'tasheel' ), $entry_num ) ) . '</th></tr></thead><tbody>';
				$company = isset( $pr['company'] ) ? $pr['company'] : '';
				if ( $company ) {
					echo '<tr><th style="width:180px;">' . esc_html( $proj_labels['company'] ) . '</th><td>' . esc_html( $company ) . '</td></tr>';
				}
				$client = isset( $pr['client'] ) ? $pr['client'] : '';
				if ( $client ) {
					echo '<tr><th>' . esc_html( $proj_labels['client'] ) . '</th><td>' . esc_html( $client ) . '</td></tr>';
				}
				$position = isset( $pr['position'] ) ? $pr['position'] : '';
				if ( $position ) {
					$position_display = function_exists( 'tasheel_hr_project_position_label' ) ? tasheel_hr_project_position_label( $position ) : $position;
					echo '<tr><th>' . esc_html( $proj_labels['position'] ) . '</th><td>' . esc_html( $position_display ) . '</td></tr>';
				}
				$period = isset( $pr['period'] ) ? $pr['period'] : '';
				if ( $period ) {
					$period_display = function_exists( 'tasheel_hr_project_period_label' ) ? tasheel_hr_project_period_label( $period ) : $period;
					echo '<tr><th>' . esc_html( $proj_labels['period'] ) . '</th><td>' . esc_html( $period_display ) . '</td></tr>';
				}
				$duties = isset( $pr['duties'] ) ? $pr['duties'] : '';
				if ( $duties ) {
					echo '<tr><th>' . esc_html( $proj_labels['duties'] ) . '</th><td>' . esc_html( $duties ) . '</td></tr>';
				}
				echo '</tbody></table>';
			}
		} else {
			echo '<p class="description">—</p>';
		}
	}
}

add_action( 'add_meta_boxes', 'tasheel_hr_application_meta_boxes' );

/**
 * Get application status label for front end (user-facing statuses only).
 *
 * @param string $status Internal status.
 * @return string
 */
function tasheel_hr_application_status_label( $status ) {
	$labels = array(
		'submitted'    => __( 'Submitted', 'tasheel' ),
		'under_review'  => __( 'Under Review', 'tasheel' ),
		'shortlisted'  => __( 'Under Review', 'tasheel' ),
		'accepted'     => __( 'Accepted', 'tasheel' ),
		'rejected'     => __( 'Rejected', 'tasheel' ),
	);
	return isset( $labels[ $status ] ) ? $labels[ $status ] : $status;
}

/**
 * Get all job applications for a user (for My Jobs page).
 * Returns array of application data with job title, post id, job type, applied date, location, status.
 *
 * @param int $user_id User ID (default current user).
 * @return array List of arrays: job_title, job_id, job_type_label, applied_date, location, country, city, status, application_id.
 */
function tasheel_hr_get_user_applications( $user_id = 0 ) {
	if ( ! $user_id ) {
		$user_id = get_current_user_id();
	}
	if ( ! $user_id ) {
		return array();
	}
	$posts = get_posts( array(
		'post_type'      => 'job_application',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'orderby'        => 'date',
		'order'          => 'DESC',
		'meta_query'     => array(
			array( 'key' => 'user_id', 'value' => (int) $user_id, 'compare' => '=' ),
		),
	) );
	$out = array();
	$date_format = get_option( 'date_format' ) ?: 'Y-m-d';
	foreach ( $posts as $app_post ) {
		$job_id   = (int) get_post_meta( $app_post->ID, 'job_id', true );
		$job      = $job_id ? get_post( $job_id ) : null;
		$job_type_slug = get_post_meta( $app_post->ID, 'job_type_slug', true );
		$job_type_label = '';
		if ( $job_type_slug ) {
			$term = get_term_by( 'slug', $job_type_slug, 'job_type' );
			$job_type_label = $term && ! is_wp_error( $term ) ? $term->name : $job_type_slug;
		}
		if ( ! $job_type_label && $job ) {
			$terms = get_the_terms( $job_id, 'job_type' );
			if ( $terms && ! is_wp_error( $terms ) ) {
				$t = reset( $terms );
				$job_type_label = $t ? $t->name : '';
			}
		}
		// Job location from ACF: location_city + location_country (or legacy "location"); display "City, Country".
		$loc_parts = ( $job_id && function_exists( 'tasheel_hr_job_location_parts' ) ) ? tasheel_hr_job_location_parts( $job_id ) : array( 'city' => '', 'country' => '', 'display' => '' );
		$city    = isset( $loc_parts['city'] ) ? $loc_parts['city'] : '';
		$country = isset( $loc_parts['country'] ) ? $loc_parts['country'] : '';
		$location = isset( $loc_parts['display'] ) ? $loc_parts['display'] : '';
		$status_raw = get_post_meta( $app_post->ID, 'application_status', true );
		$status_label = function_exists( 'tasheel_hr_application_status_label' ) ? tasheel_hr_application_status_label( $status_raw ) : $status_raw;
		$out[] = array(
			'application_id'  => $app_post->ID,
			'job_id'          => $job_id,
			'job_title'       => $job ? get_the_title( $job ) : __( 'Unknown', 'tasheel' ),
			'job_type_label'  => $job_type_label ?: '—',
			'applied_date'    => get_the_date( $date_format, $app_post ),
			'location'        => $location,
			'country'         => $country ?: '—',
			'city'            => $city ?: '—',
			'status'          => $status_label,
			'status_slug'     => $status_raw,
		);
	}
	return $out;
}
