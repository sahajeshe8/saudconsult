<?php
/**
 * HR Engine: single post type (hr_job) + taxonomy (job_type). Roles see only their term.
 * All functionality in theme (no plugin). WPML-ready.
 *
 * @package tasheel
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Job type term slugs (taxonomy job_type). */
define( 'TASHEEL_HR_JOB_TYPE_CAREER', 'career' );
define( 'TASHEEL_HR_JOB_TYPE_CORPORATE', 'corporate_training' );
define( 'TASHEEL_HR_JOB_TYPE_ACADEMIC', 'academic' );

/**
 * HR ROLES – WHO SEES WHAT
 *
 * Administrator
 * - Full access: all Jobs, all Job Applications, all Users, Media, Settings.
 * - Can create/edit/delete any job in any category (Career, Corporate Training, Academic).
 * - Receives application notifications if enabled (see tasheel_hr_application_admin_email and filters).
 *
 * Recruiter – Careers (recruiter_career)
 * - Jobs: only jobs in category "Career". Can create/edit/delete those; new jobs auto-assigned to Career.
 * - Job Applications: only applications for Career jobs. Can view, rate, add internal notes, export.
 * - Users: can list and edit users (e.g. applicant profiles). Media: can upload (e.g. job banner).
 * - No access to default "Posts" menu; redirected to Jobs if they open post list.
 * - Receives application notification emails for applications to Career jobs only.
 *
 * Recruiter – Corporate Training (recruiter_corporate_training)
 * - Same as above but scoped to "Corporate Training" jobs and applications.
 *
 * Recruiter – Academy (recruiter_academic)
 * - Same as above but scoped to "Academic Program" jobs and applications.
 *
 * Application emails: applicant gets confirmation; recruiters for that job's category get notification;
 * optional admin copy via filter tasheel_hr_application_notification_recipients / tasheel_hr_application_admin_email.
 */

/**
 * HR Engine job post type (single).
 *
 * @return string
 */
function tasheel_hr_job_post_type() {
	return 'hr_job';
}

/**
 * Job type term slugs for role mapping.
 *
 * @return string[]
 */
function tasheel_hr_job_type_slugs() {
	return array( TASHEEL_HR_JOB_TYPE_CAREER, TASHEEL_HR_JOB_TYPE_CORPORATE, TASHEEL_HR_JOB_TYPE_ACADEMIC );
}

/**
 * Map listing type (from ACF) to job_type term slug.
 *
 * @param string $listing_type career|corporate_training|academic
 * @return string Term slug or empty.
 */
function tasheel_hr_listing_type_to_term_slug( $listing_type ) {
	$map = array(
		'career'             => TASHEEL_HR_JOB_TYPE_CAREER,
		'corporate_training'  => TASHEEL_HR_JOB_TYPE_CORPORATE,
		'academic'            => TASHEEL_HR_JOB_TYPE_ACADEMIC,
	);
	return isset( $map[ $listing_type ] ) ? $map[ $listing_type ] : '';
}

/**
 * Get the job type term slug for a job post (first term).
 *
 * @param int $job_id hr_job post ID.
 * @return string Term slug or empty.
 */
function tasheel_hr_get_job_type_slug( $job_id ) {
	$terms = get_the_terms( $job_id, 'job_type' );
	if ( ! $terms || is_wp_error( $terms ) ) {
		return '';
	}
	$t = reset( $terms );
	return $t ? $t->slug : '';
}

/**
 * Get the canonical (original) job ID for display and duplicate-application checks.
 * When WPML is active, returns the original/source post ID so EN and AR show the same Job ID
 * and applying to either language counts as the same job.
 *
 * @param int $job_id Job post ID (may be a translation).
 * @return int Canonical job ID (original when WPML, else $job_id).
 */
function tasheel_hr_canonical_job_id( $job_id ) {
	$job_id = (int) $job_id;
	if ( ! $job_id ) {
		return 0;
	}
	if ( function_exists( 'apply_filters' ) && has_filter( 'wpml_original_element_id' ) ) {
		$post_type = get_post_type( $job_id );
		$original  = apply_filters( 'wpml_original_element_id', null, $job_id, 'post_' . ( $post_type ?: 'hr_job' ) );
		if ( $original && (int) $original !== $job_id ) {
			return (int) $original;
		}
	}
	return $job_id;
}

/**
 * ACF field names for job location (post type: hr_job). Must match ACF field "name" in group_hr_job_details.
 */
define( 'TASHEEL_HR_ACF_JOB_LOCATION_CITY', 'location_city' );
define( 'TASHEEL_HR_ACF_JOB_LOCATION_COUNTRY', 'location_country' );

/**
 * Get job location from ACF (location_city, location_country). Display: "City, Country".
 * Handles both ISO code (SA) and label (Saudi Arabia) for country.
 *
 * @param int $job_id Job post ID.
 * @return array{ city: string, country: string, country_code: string, display: string }
 */
function tasheel_hr_job_location_parts( $job_id ) {
	$city = '';
	$country_code = '';
	$field_city   = defined( 'TASHEEL_HR_ACF_JOB_LOCATION_CITY' ) ? TASHEEL_HR_ACF_JOB_LOCATION_CITY : 'location_city';
	$field_country = defined( 'TASHEEL_HR_ACF_JOB_LOCATION_COUNTRY' ) ? TASHEEL_HR_ACF_JOB_LOCATION_COUNTRY : 'location_country';

	if ( function_exists( 'get_field' ) ) {
		$city         = get_field( $field_city, $job_id );
		$country_code = get_field( $field_country, $job_id );
	}
	$city         = is_string( $city ) ? trim( $city ) : '';
	$country_code = is_string( $country_code ) ? trim( $country_code ) : '';

	// ACF Select may save "Value" (SA) or "Label" (Saudi Arabia) depending on Return Value setting.
	if ( $country_code !== '' && function_exists( 'tasheel_hr_get_country_name' ) ) {
		$name_for_display = tasheel_hr_get_country_name( $country_code );
		if ( $name_for_display === $country_code && function_exists( 'tasheel_hr_get_country_code_from_name' ) ) {
			$code = tasheel_hr_get_country_code_from_name( $country_code );
			if ( $code !== '' ) {
				$country_code = $code;
			}
		}
	}

	// Fallback: legacy single ACF field "location" (e.g. "Riyadh, Saudi Arabia").
	if ( $city === '' && $country_code === '' && function_exists( 'get_field' ) ) {
		$legacy = get_field( 'location', $job_id );
		$legacy = is_string( $legacy ) ? trim( $legacy ) : '';
		if ( $legacy !== '' ) {
			$parts = array_map( 'trim', explode( ',', $legacy, 2 ) );
			if ( count( $parts ) >= 2 ) {
				$city = $parts[0];
				$country_name = $parts[1];
				$country_code = function_exists( 'tasheel_hr_get_country_code_from_name' ) ? tasheel_hr_get_country_code_from_name( $country_name ) : '';
				if ( $country_code === '' ) {
					$country_code = $country_name;
				}
			} else {
				$city = $legacy;
			}
			$existing = get_post_meta( $job_id, $field_country, true );
			if ( ( $existing === '' || ! is_string( $existing ) ) && $country_code !== '' ) {
				update_post_meta( $job_id, $field_city, $city );
				update_post_meta( $job_id, $field_country, $country_code );
			}
		}
	}

	$meta_city    = get_post_meta( $job_id, $field_city, true );
	$meta_country = get_post_meta( $job_id, $field_country, true );
	if ( is_string( $meta_city ) && trim( $meta_city ) !== '' ) {
		$city = trim( $meta_city );
	}
	if ( is_string( $meta_country ) && trim( $meta_country ) !== '' ) {
		$country_code = trim( $meta_country );
		if ( function_exists( 'tasheel_hr_get_country_name' ) && tasheel_hr_get_country_name( $country_code ) === $country_code && function_exists( 'tasheel_hr_get_country_code_from_name' ) ) {
			$code = tasheel_hr_get_country_code_from_name( $country_code );
			if ( $code !== '' ) {
				$country_code = $code;
			}
		}
	}

	$country_display = ( $country_code !== '' && function_exists( 'tasheel_hr_get_country_name' ) ) ? tasheel_hr_get_country_name( $country_code ) : $country_code;
	$display = $city;
	if ( $country_display !== '' ) {
		$display = $city !== '' ? $city . ', ' . $country_display : $country_display;
	}
	return array(
		'city'         => $city,
		'country'      => $country_display,
		'country_code' => $country_code,
		'display'      => $display,
	);
}

/**
 * Create HR recruiter roles. Each role can edit hr_job and job_application; visibility is filtered by term in pre_get_posts.
 */
function tasheel_hr_create_roles() {
	$job_obj = get_post_type_object( tasheel_hr_job_post_type() );
	$app_obj = get_post_type_object( 'job_application' );
	if ( ! $job_obj || ! $app_obj ) {
		return;
	}
	$role_config = array(
		'recruiter_career'             => __( 'Recruiter – Careers', 'tasheel' ),
		'recruiter_corporate_training' => __( 'Recruiter – Corporate Training', 'tasheel' ),
		'recruiter_academic'           => __( 'Recruiter – Academy', 'tasheel' ),
	);
	$caps = array(
		'read'                           => true,
		'upload'                         => true,
		'upload_files'                   => true,
		'list_users'                     => true,
		'edit_users'                     => true,
		$job_obj->cap->edit_posts        => true,
		$job_obj->cap->edit_others_posts => true,
		$job_obj->cap->publish_posts     => true,
		$job_obj->cap->read_private_posts => true,
		$job_obj->cap->delete_posts      => true,
		$job_obj->cap->delete_others_posts => true,
		$job_obj->cap->delete_private_posts => true,
		$job_obj->cap->delete_published_posts => true,
	);
	if ( isset( $job_obj->cap->create_posts ) ) {
		$caps[ $job_obj->cap->create_posts ] = true;
	}
	foreach ( (array) $app_obj->cap as $cap ) {
		$caps[ $cap ] = true;
	}
	foreach ( $role_config as $role_id => $role_name ) {
		if ( ! get_role( $role_id ) ) {
			add_role( $role_id, $role_name, $caps );
		}
	}
}

/**
 * Ensure existing recruiter roles have all HR caps (edit/delete others' jobs, upload, users).
 * Fixes missing Edit/Trash on Jobs list and media/access issues.
 */
function tasheel_hr_recruiter_roles_add_caps() {
	$job_obj = get_post_type_object( tasheel_hr_job_post_type() );
	$app_obj = get_post_type_object( 'job_application' );
	if ( ! $job_obj || ! $app_obj ) {
		return;
	}
	$role_ids = array( 'recruiter_career', 'recruiter_corporate_training', 'recruiter_academic' );
	$caps_to_add = array( 'upload', 'upload_files', 'list_users', 'edit_users' );
	foreach ( (array) $job_obj->cap as $cap ) {
		$caps_to_add[] = $cap;
	}
	foreach ( (array) $app_obj->cap as $cap ) {
		$caps_to_add[] = $cap;
	}
	if ( isset( $job_obj->cap->create_posts ) ) {
		$caps_to_add[] = $job_obj->cap->create_posts;
	}
	$caps_to_add = array_unique( $caps_to_add );
	foreach ( $role_ids as $role_id ) {
		$role = get_role( $role_id );
		if ( ! $role ) {
			continue;
		}
		foreach ( $caps_to_add as $cap ) {
			if ( ! $role->has_cap( $cap ) ) {
				$role->add_cap( $cap );
			}
		}
	}
}
add_action( 'init', 'tasheel_hr_recruiter_roles_add_caps', 22 );

/**
 * Ensure administrator has all HR capabilities.
 */
function tasheel_hr_grant_admin_hr_caps() {
	$admin = get_role( 'administrator' );
	if ( ! $admin ) {
		return;
	}
	foreach ( array( tasheel_hr_job_post_type(), 'job_application' ) as $pt ) {
		$obj = get_post_type_object( $pt );
		if ( ! $obj ) {
			continue;
		}
		foreach ( (array) $obj->cap as $cap ) {
			$admin->add_cap( $cap );
		}
	}
}

add_action( 'init', 'tasheel_hr_create_roles', 20 );
add_action( 'init', 'tasheel_hr_grant_admin_hr_caps', 21 );

/**
 * Redirect recruiters away from edit.php (default posts list) and post-new.php (default new post).
 * Use load-edit.php / load-post-new.php so we run in the right context before capability checks.
 */
function tasheel_hr_recruiter_redirect_edit_php() {
	$term_slug = tasheel_hr_recruiter_allowed_term_slug();
	if ( $term_slug === '' ) {
		return;
	}
	$post_type = isset( $_GET['post_type'] ) ? sanitize_text_field( wp_unslash( $_GET['post_type'] ) ) : 'post';
	if ( $post_type === 'post' ) {
		$args = array( 'post_type' => tasheel_hr_job_post_type() );
		if ( isset( $_GET['message'] ) ) {
			$args['message'] = (int) $_GET['message'];
		}
		wp_safe_redirect( add_query_arg( $args, admin_url( 'edit.php' ) ) );
		exit;
	}
}
function tasheel_hr_recruiter_redirect_post_new_php() {
	$term_slug = tasheel_hr_recruiter_allowed_term_slug();
	if ( $term_slug === '' ) {
		return;
	}
	$post_type = isset( $_GET['post_type'] ) ? sanitize_text_field( wp_unslash( $_GET['post_type'] ) ) : 'post';
	if ( $post_type === 'post' ) {
		wp_safe_redirect( admin_url( 'post-new.php?post_type=' . tasheel_hr_job_post_type() ) );
		exit;
	}
}
add_action( 'load-edit.php', 'tasheel_hr_recruiter_redirect_edit_php', 1 );
add_action( 'load-post-new.php', 'tasheel_hr_recruiter_redirect_post_new_php', 1 );

/**
 * Hide "Posts" menu for recruiters so they only use Jobs and don't hit the "not allowed" page.
 */
function tasheel_hr_recruiter_remove_posts_menu() {
	if ( tasheel_hr_recruiter_allowed_term_slug() === '' ) {
		return;
	}
	remove_menu_page( 'edit.php' );
}
add_action( 'admin_menu', 'tasheel_hr_recruiter_remove_posts_menu', 999 );

/**
 * After saving an hr_job, ensure recruiters are not sent to default edit.php (posts list) which they cannot access.
 * Only change redirect when it would land on the generic posts list; keep post.php?post=X&action=edit so they see the job they just saved.
 */
function tasheel_hr_recruiter_redirect_after_save_job( $location ) {
	$term_slug = tasheel_hr_recruiter_allowed_term_slug();
	if ( $term_slug === '' ) {
		return $location;
	}
	$post_id = isset( $_POST['post_ID'] ) ? (int) $_POST['post_ID'] : 0;
	if ( ! $post_id ) {
		return $location;
	}
	if ( get_post_type( $post_id ) !== tasheel_hr_job_post_type() ) {
		return $location;
	}
	// If WordPress redirected to edit.php without post_type (posts list), send to Jobs list instead.
	if ( strpos( $location, 'edit.php' ) !== false && strpos( $location, 'post_type=' ) === false ) {
		$parsed = wp_parse_url( $location );
		$query = array( 'post_type' => tasheel_hr_job_post_type() );
		if ( ! empty( $parsed['query'] ) ) {
			wp_parse_str( $parsed['query'], $q );
			if ( isset( $q['message'] ) ) {
				$query['message'] = (int) $q['message'];
			}
		}
		if ( ! isset( $query['message'] ) ) {
			$query['message'] = 1;
		}
		$location = add_query_arg( $query, admin_url( 'edit.php' ) );
	}
	return $location;
}
add_filter( 'redirect_post_location', 'tasheel_hr_recruiter_redirect_after_save_job', 10, 1 );

/**
 * Map recruiter role to the single job_type term slug they can see.
 *
 * @param WP_User $user User.
 * @return string Term slug or empty (empty = no restriction / admin).
 */
function tasheel_hr_recruiter_allowed_term_slug( $user = null ) {
	if ( ! $user ) {
		$user = wp_get_current_user();
	}
	if ( empty( $user->roles ) || in_array( 'administrator', $user->roles, true ) ) {
		return '';
	}
	if ( in_array( 'recruiter_career', $user->roles, true ) ) {
		return TASHEEL_HR_JOB_TYPE_CAREER;
	}
	if ( in_array( 'recruiter_corporate_training', $user->roles, true ) ) {
		return TASHEEL_HR_JOB_TYPE_CORPORATE;
	}
	if ( in_array( 'recruiter_academic', $user->roles, true ) ) {
		return TASHEEL_HR_JOB_TYPE_ACADEMIC;
	}
	return '';
}

/**
 * Whether to show the visa status filter on the Job Applications list.
 * Hidden for recruiter_corporate_training and recruiter_academic; shown for admin and recruiter_career.
 *
 * @return bool
 */
function tasheel_hr_show_visa_status_filter() {
	$user = wp_get_current_user();
	if ( empty( $user->roles ) || in_array( 'administrator', $user->roles, true ) ) {
		return true;
	}
	if ( in_array( 'recruiter_corporate_training', $user->roles, true ) || in_array( 'recruiter_academic', $user->roles, true ) ) {
		return false;
	}
	return true;
}

/**
 * Recruiter role slug for a job_type term slug (for notifications: who gets email for this job category).
 *
 * @param string $term_slug career|corporate_training|academic
 * @return string Role slug or empty.
 */
function tasheel_hr_recruiter_role_for_job_type_slug( $term_slug ) {
	$map = array(
		TASHEEL_HR_JOB_TYPE_CAREER    => 'recruiter_career',
		TASHEEL_HR_JOB_TYPE_CORPORATE => 'recruiter_corporate_training',
		TASHEEL_HR_JOB_TYPE_ACADEMIC  => 'recruiter_academic',
	);
	return isset( $map[ $term_slug ] ) ? $map[ $term_slug ] : '';
}

/**
 * Email addresses of users with the recruiter role for a job type (for application notifications).
 *
 * @param string $term_slug career|corporate_training|academic
 * @return string[] Array of unique, non-empty emails.
 */
function tasheel_hr_recruiter_emails_for_job_type( $term_slug ) {
	$role = tasheel_hr_recruiter_role_for_job_type_slug( $term_slug );
	if ( $role === '' ) {
		return array();
	}
	$users = get_users( array( 'role' => $role, 'fields' => array( 'user_email' ) ) );
	$emails = array();
	foreach ( $users as $u ) {
		if ( ! empty( $u->user_email ) && is_email( $u->user_email ) ) {
			$emails[] = $u->user_email;
		}
	}
	return array_unique( $emails );
}

/**
 * When a recruiter creates or updates an hr_job, auto-assign the job_type term for their role
 * so the job shows under the correct category (Career / Corporate Training / Academic).
 */
function tasheel_hr_auto_assign_job_type_for_recruiter( $post_id ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( wp_is_post_revision( $post_id ) ) {
		return;
	}
	if ( get_post_type( $post_id ) !== tasheel_hr_job_post_type() ) {
		return;
	}
	$term_slug = tasheel_hr_recruiter_allowed_term_slug();
	if ( $term_slug === '' ) {
		return;
	}
	if ( ! taxonomy_exists( 'job_type' ) ) {
		return;
	}
	wp_set_object_terms( $post_id, $term_slug, 'job_type' );
}
add_action( 'save_post_' . tasheel_hr_job_post_type(), 'tasheel_hr_auto_assign_job_type_for_recruiter', 10, 1 );

/**
 * Restrict Jobs list in admin: recruiters only see jobs in their job_type term.
 */
function tasheel_hr_filter_jobs_list_by_role( $query ) {
	if ( ! is_admin() || ! $query->is_main_query() ) {
		return;
	}
	$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
	if ( ! $screen || $screen->post_type !== tasheel_hr_job_post_type() ) {
		return;
	}
	$term_slug = tasheel_hr_recruiter_allowed_term_slug();
	if ( $term_slug === '' ) {
		return;
	}
	$tax_query = $query->get( 'tax_query' );
	if ( ! is_array( $tax_query ) ) {
		$tax_query = array();
	}
	$tax_query[] = array(
		'taxonomy' => 'job_type',
		'field'    => 'slug',
		'terms'    => $term_slug,
	);
	$query->set( 'tax_query', $tax_query );
}

add_action( 'pre_get_posts', 'tasheel_hr_filter_jobs_list_by_role' );

/**
 * Filter Jobs list by Job Type (category) when admin selects a type from the dropdown.
 * Merges with recruiter role filter when applicable.
 */
function tasheel_hr_filter_jobs_list_by_job_type( $query ) {
	if ( ! is_admin() || ! $query->is_main_query() ) {
		return;
	}
	$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
	if ( ! $screen || $screen->post_type !== tasheel_hr_job_post_type() ) {
		return;
	}
	$filter = isset( $_GET['job_type_filter'] ) ? sanitize_text_field( wp_unslash( $_GET['job_type_filter'] ) ) : '';
	if ( $filter === '' ) {
		return;
	}
	if ( ! taxonomy_exists( 'job_type' ) ) {
		return;
	}
	$term = get_term_by( 'slug', $filter, 'job_type' );
	if ( ! $term || is_wp_error( $term ) ) {
		return;
	}
	$tax_query = $query->get( 'tax_query' );
	if ( ! is_array( $tax_query ) ) {
		$tax_query = array();
	}
	$tax_query[] = array(
		'taxonomy' => 'job_type',
		'field'    => 'slug',
		'terms'    => $filter,
	);
	$query->set( 'tax_query', $tax_query );
}

add_action( 'pre_get_posts', 'tasheel_hr_filter_jobs_list_by_job_type', 12 );

/**
 * Filter Jobs list by Active/Expired (closing date) when admin selects from Job Status dropdown.
 */
function tasheel_hr_filter_jobs_list_by_status( $query ) {
	if ( ! is_admin() || ! $query->is_main_query() ) {
		return;
	}
	$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
	if ( ! $screen || $screen->post_type !== tasheel_hr_job_post_type() ) {
		return;
	}
	$status = isset( $_GET['job_status_filter'] ) ? sanitize_text_field( wp_unslash( $_GET['job_status_filter'] ) ) : '';
	if ( $status !== 'active' && $status !== 'expired' ) {
		return;
	}
	$today = gmdate( 'Y-m-d' );
	$meta_query = $query->get( 'meta_query' );
	if ( ! is_array( $meta_query ) ) {
		$meta_query = array();
	}
	if ( $status === 'expired' ) {
		$meta_query[] = array(
			'relation' => 'AND',
			array( 'key' => 'closing_date', 'compare' => 'EXISTS' ),
			array( 'key' => 'closing_date', 'value' => '', 'compare' => '!=' ),
			array( 'key' => 'closing_date', 'value' => $today, 'compare' => '<', 'type' => 'DATE' ),
		);
	} else {
		// Active: no closing date, or closing_date >= today, or closing_date empty.
		$meta_query[] = array(
			'relation' => 'OR',
			array( 'key' => 'closing_date', 'compare' => 'NOT EXISTS' ),
			array( 'key' => 'closing_date', 'value' => '', 'compare' => '=' ),
			array( 'key' => 'closing_date', 'value' => $today, 'compare' => '>=', 'type' => 'DATE' ),
		);
	}
	$query->set( 'meta_query', $meta_query );
}
add_action( 'pre_get_posts', 'tasheel_hr_filter_jobs_list_by_status', 13 );

/**
 * Add Job Type dropdown filter to the Jobs list (edit.php?post_type=hr_job).
 * For recruiters: only show their assigned job type (+ "All job types") since they only see jobs in that category.
 */
function tasheel_hr_jobs_restrict_manage_posts( $post_type, $which ) {
	if ( $post_type !== tasheel_hr_job_post_type() || $which !== 'top' ) {
		return;
	}
	if ( ! taxonomy_exists( 'job_type' ) ) {
		return;
	}
	$terms = get_terms( array( 'taxonomy' => 'job_type', 'hide_empty' => false ) );
	if ( ! $terms || is_wp_error( $terms ) ) {
		return;
	}
	$term_slug = function_exists( 'tasheel_hr_recruiter_allowed_term_slug' ) ? tasheel_hr_recruiter_allowed_term_slug() : '';
	if ( $term_slug !== '' ) {
		$terms = array_filter( $terms, function ( $t ) use ( $term_slug ) {
			return $t->slug === $term_slug;
		} );
	}
	$current = isset( $_GET['job_type_filter'] ) ? sanitize_text_field( wp_unslash( $_GET['job_type_filter'] ) ) : '';
	?>
	<select name="job_type_filter" id="job_type_filter">
		<option value=""><?php esc_html_e( 'All job types', 'tasheel' ); ?></option>
		<?php foreach ( $terms as $term ) : ?>
			<option value="<?php echo esc_attr( $term->slug ); ?>" <?php selected( $current, $term->slug ); ?>><?php echo esc_html( $term->name ); ?></option>
		<?php endforeach; ?>
	</select>
	<?php
	$current_status = isset( $_GET['job_status_filter'] ) ? sanitize_text_field( wp_unslash( $_GET['job_status_filter'] ) ) : '';
	?>
	<select name="job_status_filter" id="job_status_filter">
		<option value=""><?php esc_html_e( 'All statuses', 'tasheel' ); ?></option>
		<option value="active" <?php selected( $current_status, 'active' ); ?>><?php esc_html_e( 'Active', 'tasheel' ); ?></option>
		<option value="expired" <?php selected( $current_status, 'expired' ); ?>><?php esc_html_e( 'Expired', 'tasheel' ); ?></option>
	</select>
	<?php
}

add_action( 'restrict_manage_posts', 'tasheel_hr_jobs_restrict_manage_posts', 10, 2 );

/**
 * Restrict job applications list in admin: recruiters only see applications for jobs in their term.
 */
function tasheel_hr_filter_applications_by_recruiter( $query ) {
	if ( ! is_admin() || ! $query->is_main_query() ) {
		return;
	}
	$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
	if ( ! $screen || $screen->post_type !== 'job_application' ) {
		return;
	}
	$term_slug = tasheel_hr_recruiter_allowed_term_slug();
	if ( $term_slug === '' ) {
		return;
	}
	$job_ids = get_posts( array(
		'post_type'      => tasheel_hr_job_post_type(),
		'post_status'    => 'any',
		'posts_per_page' => -1,
		'fields'         => 'ids',
		'tax_query'      => array(
			array(
				'taxonomy' => 'job_type',
				'field'    => 'slug',
				'terms'    => $term_slug,
			),
		),
	) );
	if ( empty( $job_ids ) ) {
		$query->set( 'post__in', array( 0 ) );
		return;
	}
	$meta_query = $query->get( 'meta_query' );
	if ( ! is_array( $meta_query ) ) {
		$meta_query = array();
	}
	$meta_query[] = array(
		'key'     => 'job_id',
		'value'   => $job_ids,
		'compare' => 'IN',
	);
	$query->set( 'meta_query', $meta_query );
}

add_action( 'pre_get_posts', 'tasheel_hr_filter_applications_by_recruiter' );

/**
 * Filter wp_count_posts so recruiters see role-scoped counts. WPML (and core) use this for the view tabs including language (Arabic, English, All languages).
 *
 * @param stdClass $counts Counts by status (publish, draft, pending, etc.).
 * @param string  $type   Post type.
 * @param string  $perm   Permission ('readable' or '').
 * @return stdClass
 */
function tasheel_hr_wp_count_posts_recruiter_scope( $counts, $type, $perm ) {
	if ( ! is_admin() ) {
		return $counts;
	}
	$post_types = array( tasheel_hr_job_post_type(), 'job_application' );
	if ( ! in_array( $type, $post_types, true ) ) {
		return $counts;
	}
	$term_slug = tasheel_hr_recruiter_allowed_term_slug();
	if ( $term_slug === '' ) {
		return $counts;
	}
	$count_job = ( $type === tasheel_hr_job_post_type() );
	$statuses  = array( 'publish', 'draft', 'pending', 'private', 'trash', 'future' );
	$out       = new stdClass();
	foreach ( $statuses as $st ) {
		$out->$st = $count_job ? tasheel_hr_recruiter_jobs_count( $st ) : tasheel_hr_recruiter_applications_count( $st );
	}
	// Ensure any other status on original counts exists so WPML doesn't break.
	foreach ( (array) $counts as $key => $val ) {
		if ( ! isset( $out->$key ) ) {
			$out->$key = 0;
		}
	}
	return $out;
}
add_filter( 'wp_count_posts', 'tasheel_hr_wp_count_posts_recruiter_scope', 10, 3 );

/**
 * Count hr_job posts by status, optional job_type, and optional Active/Expired filter.
 * Used for Jobs list view counts when filtering by Job Type or Job Status (Active/Expired).
 *
 * @param string $status            Post status: 'all' (non-trash), 'mine', 'publish', 'draft', 'pending', 'private', 'trash'.
 * @param string $job_type_slug     Optional. Job type term slug; empty = all types.
 * @param string $lang_code         Optional. WPML language code (e.g. 'en', 'ar'); empty = all languages.
 * @param string $job_status_filter Optional. 'active' or 'expired' to count only by closing_date; empty = no filter.
 * @return int
 */
function tasheel_hr_jobs_count_by_status_and_type( $status, $job_type_slug = '', $lang_code = '', $job_status_filter = '' ) {
	$args = array(
		'post_type'      => tasheel_hr_job_post_type(),
		'posts_per_page' => -1,
		'fields'         => 'ids',
	);
	if ( $job_type_slug !== '' && taxonomy_exists( 'job_type' ) ) {
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'job_type',
				'field'    => 'slug',
				'terms'    => $job_type_slug,
			),
		);
	}
	if ( $job_status_filter === 'active' || $job_status_filter === 'expired' ) {
		$today = gmdate( 'Y-m-d' );
		if ( $job_status_filter === 'expired' ) {
			$args['meta_query'] = array(
				'relation' => 'AND',
				array( 'key' => 'closing_date', 'compare' => 'EXISTS' ),
				array( 'key' => 'closing_date', 'value' => '', 'compare' => '!=' ),
				array( 'key' => 'closing_date', 'value' => $today, 'compare' => '<', 'type' => 'DATE' ),
			);
		} else {
			$args['meta_query'] = array(
				'relation' => 'OR',
				array( 'key' => 'closing_date', 'compare' => 'NOT EXISTS' ),
				array( 'key' => 'closing_date', 'value' => '', 'compare' => '=' ),
				array( 'key' => 'closing_date', 'value' => $today, 'compare' => '>=', 'type' => 'DATE' ),
			);
		}
	}
	if ( $status === 'mine' ) {
		$args['author'] = get_current_user_id();
		$args['post_status'] = array( 'publish', 'draft', 'pending', 'private' );
	} elseif ( $status === 'all' ) {
		$args['post_status'] = array( 'publish', 'draft', 'pending', 'private' );
	} else {
		$args['post_status'] = $status;
	}
	if ( $lang_code !== '' && has_filter( 'wpml_current_language' ) && has_action( 'wpml_switch_language' ) ) {
		$previous = apply_filters( 'wpml_current_language', null );
		do_action( 'wpml_switch_language', $lang_code );
	}
	if ( has_filter( 'wpml_current_language' ) ) {
		$args['suppress_filters'] = false;
	}
	$q = new WP_Query( $args );
	$count = $q->found_posts;
	if ( isset( $previous ) ) {
		do_action( 'wpml_switch_language', $previous );
	}
	return $count;
}

/**
 * Role-scoped count for Jobs list view (All, Published, Draft, Trash). Used when current user is a recruiter.
 *
 * @param string $status Post status: 'all' (non-trash), 'publish', 'draft', 'pending', 'private', 'trash'.
 * @return int
 */
function tasheel_hr_recruiter_jobs_count( $status ) {
	$term_slug = tasheel_hr_recruiter_allowed_term_slug();
	if ( $term_slug === '' ) {
		return 0;
	}
	return tasheel_hr_jobs_count_by_status_and_type( $status, $term_slug, '' );
}

/**
 * Role-scoped count for Job Applications list view. Used when current user is a recruiter.
 *
 * @param string $status Post status: 'all' (non-trash), 'publish', 'draft', 'pending', 'private', 'trash'.
 * @return int
 */
function tasheel_hr_recruiter_applications_count( $status ) {
	$term_slug = tasheel_hr_recruiter_allowed_term_slug();
	if ( $term_slug === '' ) {
		return 0;
	}
	$job_ids = function_exists( 'tasheel_hr_get_applicable_job_ids_for_admin' ) ? tasheel_hr_get_applicable_job_ids_for_admin() : array();
	if ( empty( $job_ids ) ) {
		return 0;
	}
	$args = array(
		'post_type'      => 'job_application',
		'posts_per_page' => -1,
		'fields'         => 'ids',
		'meta_query'     => array(
			array(
				'key'     => 'job_id',
				'value'   => $job_ids,
				'compare' => 'IN',
			),
		),
	);
	if ( $status === 'all' ) {
		$args['post_status'] = array( 'publish', 'draft', 'pending', 'private' );
	} else {
		$args['post_status'] = $status;
	}
	// WPML: allow language filter when building view counts (job_application may be linked to language).
	if ( has_filter( 'wpml_current_language' ) ) {
		$args['suppress_filters'] = false;
	}
	$q = new WP_Query( $args );
	return $q->found_posts;
}

/**
 * Replace count in a single view entry (array with 'label' or string) with role-scoped count.
 * Handles WordPress core (span.count with parentheses), WPML (span.count.ar/en with brackets [N]), and plain (N) or [N].
 *
 * @param array|string $view  View entry.
 * @param int          $count Count to show.
 * @return array|string
 */
function tasheel_hr_views_replace_count( $view, $count ) {
	$num = number_format_i18n( $count );
	$repl_span_paren   = '<span class="count">(' . $num . ')</span>';
	$repl_span_bracket = '<span class="count">[' . $num . ']</span>';
	$repl_plain_paren  = '(' . $num . ')';
	$repl_plain_bracket = '[' . $num . ']';
	$patterns = array(
		'/<span class="count[^"]*">\s*\(\s*[\d,.]+\s*\)\s*<\/span>/' => $repl_span_paren,
		'/<span class="count[^"]*">\s*\[\s*[\d,.]+\s*\]\s*<\/span>/' => $repl_span_bracket,
		'/\(\s*[\d,.]+\s*\)/' => $repl_plain_paren,
		'/\[\s*[\d,.]+\s*\]/' => $repl_plain_bracket,
	);
	if ( is_array( $view ) && isset( $view['label'] ) ) {
		foreach ( $patterns as $pattern => $repl ) {
			$view['label'] = preg_replace( $pattern, $repl, $view['label'] );
		}
		return $view;
	}
	if ( is_string( $view ) ) {
		foreach ( $patterns as $pattern => $repl ) {
			$view = preg_replace( $pattern, $repl, $view );
		}
		return $view;
	}
	return $view;
}

/**
 * Detect WPML/Polylang language from a view (by view key, label text, or URL). Used to apply per-language role-scoped counts.
 *
 * @param array|string $view View entry (array with 'url'/'label' or HTML string).
 * @param string       $key  Optional. View key (e.g. 'lang_ar', 'lang_en') for key-based detection.
 * @return string|null 'ar', 'en', 'all', or null if not a language view.
 */
function tasheel_hr_views_detect_wpml_lang( $view, $key = '' ) {
	$label = is_array( $view ) ? ( isset( $view['label'] ) ? $view['label'] : '' ) : (string) $view;
	$url   = is_array( $view ) && isset( $view['url'] ) ? $view['url'] : '';
	$text  = strip_tags( $label ) . ' ' . $url;
	$lower = strtolower( $text );
	$key_lower = strtolower( $key );

	// Match by view key (WPML may use lang_ar, lang_en, en, ar, all, all_languages, etc.).
	if ( $key !== '' ) {
		if ( strpos( $key_lower, 'lang_ar' ) !== false || $key_lower === 'ar' ) {
			return 'ar';
		}
		if ( strpos( $key_lower, 'lang_en' ) !== false || $key_lower === 'en' ) {
			return 'en';
		}
		if ( $key_lower === 'all' || ( strpos( $key_lower, 'all' ) !== false && ( strpos( $key_lower, 'lang' ) !== false || strpos( $key_lower, 'language' ) !== false ) ) ) {
			return 'all';
		}
	}
	// Match by label: Arabic (عربي or "Arabic"), English (ENG or "English"), All languages.
	if ( strpos( $label, 'عربي' ) !== false || strpos( $lower, 'arabic' ) !== false ) {
		return 'ar';
	}
	if ( preg_match( '/\beng\b/i', $text ) || strpos( $lower, 'english' ) !== false ) {
		return 'en';
	}
	if ( strpos( $lower, 'all languages' ) !== false ) {
		return 'all';
	}
	// Match by lang= in URL.
	if ( preg_match( '/[?&]lang=([^&]+)/', $url, $m ) ) {
		$lang = strtolower( $m[1] );
		if ( $lang === 'ar' ) {
			return 'ar';
		}
		if ( $lang === 'en' || $lang === 'en_us' ) {
			return 'en';
		}
		if ( $lang === 'all' ) {
			return 'all';
		}
	}
	return null;
}

/**
 * Filter Jobs list view counts so recruiters see only role-scoped counts.
 * When job_type_filter or job_status_filter (Active/Expired) is set, all counts and language tabs reflect the filter.
 * Priority 99999 so we run after WPML adds its language views (PHP-only, no JS).
 */
function tasheel_hr_views_edit_hr_job( $views ) {
	$term_slug         = tasheel_hr_recruiter_allowed_term_slug();
	$job_type_filter   = isset( $_GET['job_type_filter'] ) ? sanitize_text_field( wp_unslash( $_GET['job_type_filter'] ) ) : '';
	$job_status_filter = isset( $_GET['job_status_filter'] ) ? sanitize_text_field( wp_unslash( $_GET['job_status_filter'] ) ) : '';
	if ( $job_status_filter !== '' && $job_status_filter !== 'active' && $job_status_filter !== 'expired' ) {
		$job_status_filter = '';
	}
	$post_type = tasheel_hr_job_post_type();
	$statuses  = array( 'all', 'mine', 'publish', 'draft', 'pending', 'private', 'trash' );

	$effective_type = $job_type_filter;
	if ( $effective_type === '' && $term_slug !== '' ) {
		$effective_type = $term_slug;
	}
	$need_custom_counts = ( $job_type_filter !== '' && taxonomy_exists( 'job_type' ) && get_term_by( 'slug', $job_type_filter, 'job_type' ) ) || ( $job_status_filter !== '' ) || ( $term_slug !== '' );

	if ( $need_custom_counts ) {
		foreach ( $statuses as $st ) {
			if ( ! isset( $views[ $st ] ) ) {
				continue;
			}
			$count = tasheel_hr_jobs_count_by_status_and_type( $st, $effective_type, '', $job_status_filter );
			$views[ $st ] = tasheel_hr_views_replace_count( $views[ $st ], $count );
		}
		foreach ( array_keys( $views ) as $key ) {
			if ( in_array( $key, $statuses, true ) ) {
				continue;
			}
			$lang = tasheel_hr_views_detect_wpml_lang( $views[ $key ], $key );
			if ( $lang === 'all' || $lang === null ) {
				$count = tasheel_hr_jobs_count_by_status_and_type( 'all', $effective_type, '', $job_status_filter );
			} else {
				$count = tasheel_hr_jobs_count_by_status_and_type( 'all', $effective_type, $lang, $job_status_filter );
			}
			$views[ $key ] = tasheel_hr_views_replace_count( $views[ $key ], $count );
		}
		return $views;
	}

	return $views;
}
// Run after WPML (they may add language views late) so our counts are not overwritten.
add_filter( 'views_edit-hr_job', 'tasheel_hr_views_edit_hr_job', PHP_INT_MAX );

/**
 * Pass WPML language counts to JS and update language tab counts in the DOM so they match WordPress default counts.
 * WPML often injects or overwrites counts via JS; we run multiple times and observe DOM changes to reapply correct counts.
 * Always runs on Jobs list so عربي / ENG / All languages match the current filters (job type, Active/Expired).
 */
function tasheel_hr_jobs_wpml_counts_script() {
	$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
	if ( ! $screen || $screen->id !== 'edit-hr_job' ) {
		return;
	}
	$post_type = isset( $_GET['post_type'] ) ? sanitize_text_field( wp_unslash( $_GET['post_type'] ) ) : '';
	if ( $post_type !== tasheel_hr_job_post_type() ) {
		return;
	}
	$job_type_filter   = isset( $_GET['job_type_filter'] ) ? sanitize_text_field( wp_unslash( $_GET['job_type_filter'] ) ) : '';
	$job_status_filter = isset( $_GET['job_status_filter'] ) ? sanitize_text_field( wp_unslash( $_GET['job_status_filter'] ) ) : '';
	if ( $job_status_filter !== '' && $job_status_filter !== 'active' && $job_status_filter !== 'expired' ) {
		$job_status_filter = '';
	}
	$term_slug      = function_exists( 'tasheel_hr_recruiter_allowed_term_slug' ) ? tasheel_hr_recruiter_allowed_term_slug() : '';
	$effective_type = $job_type_filter !== '' ? $job_type_filter : $term_slug;
	$counts = array(
		'ar'  => tasheel_hr_jobs_count_by_status_and_type( 'all', $effective_type, 'ar', $job_status_filter ),
		'en'  => tasheel_hr_jobs_count_by_status_and_type( 'all', $effective_type, 'en', $job_status_filter ),
		'all' => tasheel_hr_jobs_count_by_status_and_type( 'all', $effective_type, '', $job_status_filter ),
	);
	$counts_json = wp_json_encode( $counts );
	?>
	<script>
	(function() {
		var counts = <?php echo $counts_json; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>;
		function updateWpmlCounts() {
			var root = document.querySelector('.wrap') || document.getElementById('wpbody') || document.body;
			if (!root) return;
			var subsub = root.querySelector('.subsubsub');
			var links = subsub ? subsub.querySelectorAll('a') : [];
			if (links.length === 0) {
				links = root.querySelectorAll('a[href*="lang="]');
			}
			links.forEach(function(link) {
				var href = (link.getAttribute('href') || '').toLowerCase();
				var text = (link.textContent || '').trim();
				var lang = null;
				if (href.indexOf('lang=ar') !== -1) lang = 'ar';
				else if (href.indexOf('lang=en') !== -1) lang = 'en';
				else if (href.indexOf('lang=all') !== -1) lang = 'all';
				else if (text.indexOf('عربي') !== -1) lang = 'ar';
				else if (text.indexOf('ENG') !== -1 || text.indexOf('English') !== -1) lang = 'en';
				else if (text.indexOf('All languages') !== -1) lang = 'all';
				if (lang === null) return;
				var num = parseInt(counts[lang], 10);
				if (isNaN(num)) return;
				var label = text.replace(/\s*\([\d,.\s]+\)\s*$/g, '').replace(/\s*\[[\d,.\s]+\]\s*$/g, '').trim();
				var newText = label + ' (' + num + ')';
				if (link.textContent !== newText) {
					link.textContent = newText;
				}
			});
		}
		function run() {
			updateWpmlCounts();
		}
		function schedule() {
			run();
			setTimeout(run, 350);
			setTimeout(run, 900);
			setTimeout(run, 2500);
		}
		if (document.readyState === 'complete') {
			schedule();
		} else {
			window.addEventListener('load', schedule);
		}
		document.addEventListener('DOMContentLoaded', run);
		try {
			var observer = new MutationObserver(function() {
				run();
			});
			var wrap = document.querySelector('.wrap');
			if (wrap) {
				observer.observe(wrap, { childList: true, subtree: true, characterData: true });
			}
		} catch (e) {}
		document.addEventListener('visibilitychange', function() {
			if (document.visibilityState === 'visible') run();
		});
	})();
	</script>
	<?php
}
add_action( 'admin_footer', 'tasheel_hr_jobs_wpml_counts_script', 99 );

/**
 * Change the Filter button label to "Apply Filter" on the Jobs list screen only.
 */
function tasheel_hr_filter_button_text( $translated, $text, $domain ) {
	if ( $text !== 'Filter' || $domain !== 'default' ) {
		return $translated;
	}
	$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
	if ( ! $screen || $screen->id !== 'edit-hr_job' ) {
		return $translated;
	}
	return __( 'Apply Filter', 'tasheel' );
}
add_filter( 'gettext', 'tasheel_hr_filter_button_text', 10, 3 );

/**
 * Filter Job Applications list view counts so recruiters see only role-scoped counts.
 * Also updates WPML/Polylang language tabs (Arabic, English, All languages) with per-language role-scoped counts.
 * Priority 99999 so we run after WPML (PHP-only, no JS).
 */
function tasheel_hr_views_edit_job_application( $views ) {
	$term_slug = tasheel_hr_recruiter_allowed_term_slug();
	if ( $term_slug === '' ) {
		return $views;
	}
	$post_type = 'job_application';
	$statuses  = array( 'all', 'mine', 'publish', 'draft', 'pending', 'private', 'trash' );
	foreach ( $statuses as $st ) {
		if ( ! isset( $views[ $st ] ) ) {
			continue;
		}
		$count = tasheel_hr_recruiter_applications_count( $st === 'mine' ? 'all' : $st );
		$views[ $st ] = tasheel_hr_views_replace_count( $views[ $st ], $count );
	}
	// WPML/Polylang language tabs: use role-scoped count per language (عربي, ENG, All languages).
	$all_count = tasheel_hr_recruiter_applications_count( 'all' );
	foreach ( array_keys( $views ) as $key ) {
		if ( in_array( $key, $statuses, true ) ) {
			continue;
		}
		$lang = tasheel_hr_views_detect_wpml_lang( $views[ $key ], $key );
		if ( $lang === 'all' || $lang === null ) {
			$count = $all_count;
		} else {
			$count = tasheel_hr_recruiter_count_for_lang( $post_type, $lang );
		}
		$views[ $key ] = tasheel_hr_views_replace_count( $views[ $key ], $count );
	}
	return $views;
}
add_filter( 'views_edit-job_application', 'tasheel_hr_views_edit_job_application', 99999 );

/**
 * Get role-scoped count for a given language (WPML). Switches language temporarily so the count query respects it.
 *
 * @param string $post_type  'hr_job' or 'job_application'.
 * @param string $lang_code  Language code (e.g. 'en', 'ar'). Empty = all languages.
 * @return int
 */
function tasheel_hr_recruiter_count_for_lang( $post_type, $lang_code ) {
	$term_slug = tasheel_hr_recruiter_allowed_term_slug();
	if ( $term_slug === '' ) {
		return 0;
	}
	$previous_lang = null;
	if ( $lang_code !== '' && has_filter( 'wpml_current_language' ) && function_exists( 'do_action' ) && has_action( 'wpml_switch_language' ) ) {
		$previous_lang = apply_filters( 'wpml_current_language', null );
		do_action( 'wpml_switch_language', $lang_code );
	}
	$count = ( $post_type === tasheel_hr_job_post_type() )
		? tasheel_hr_recruiter_jobs_count( 'all' )
		: tasheel_hr_recruiter_applications_count( 'all' );
	if ( $previous_lang !== null ) {
		do_action( 'wpml_switch_language', $previous_lang );
	}
	return $count;
}

/**
 * Set Job Code (backend field) to post ID so backend always shows post ID after publish/save.
 */
function tasheel_hr_maybe_generate_job_code( $post_id ) {
	if ( wp_is_post_revision( $post_id ) || wp_is_post_autosave( $post_id ) ) {
		return;
	}
	$post = get_post( $post_id );
	if ( ! $post || $post->post_type !== tasheel_hr_job_post_type() ) {
		return;
	}
	update_post_meta( $post_id, 'job_code', (string) $post_id );
}

add_action( 'transition_post_status', 'tasheel_hr_on_job_publish', 10, 3 );
function tasheel_hr_on_job_publish( $new_status, $old_status, $post ) {
	if ( $new_status !== 'publish' || ! $post || $post->post_type !== tasheel_hr_job_post_type() ) {
		return;
	}
	tasheel_hr_maybe_generate_job_code( $post->ID );
}

/**
 * Run after save_post so job_code is set (for non-ACF saves).
 */
add_action( 'save_post_' . tasheel_hr_job_post_type(), 'tasheel_hr_maybe_generate_job_code_on_save', 20, 3 );
function tasheel_hr_maybe_generate_job_code_on_save( $post_id, $post, $update ) {
	if ( $post->post_status !== 'publish' ) {
		return;
	}
	tasheel_hr_maybe_generate_job_code( $post_id );
}

/**
 * Run after ACF has saved, so our job_code (post ID) is not overwritten by ACF's form data.
 */
add_action( 'acf/save_post', 'tasheel_hr_set_job_code_after_acf', 20 );
function tasheel_hr_set_job_code_after_acf( $post_id ) {
	if ( ! $post_id || get_post_type( $post_id ) !== tasheel_hr_job_post_type() ) {
		return;
	}
	$post = get_post( $post_id );
	if ( ! $post || $post->post_status !== 'publish' ) {
		return;
	}
	update_post_meta( $post_id, 'job_code', (string) $post_id );
}

/**
 * Query active jobs (not past closing date) for a job_type term slug.
 *
 * @param string $term_slug career|corporate_training|academic
 * @param int    $per_page  Number to return.
 * @param int    $paged     Page number.
 * @return WP_Query
 */
function tasheel_hr_query_active_jobs( $term_slug, $per_page = 12, $paged = 1 ) {
	$today = gmdate( 'Y-m-d' );
	$args = array(
		'post_type'      => tasheel_hr_job_post_type(),
		'post_status'    => 'publish',
		'posts_per_page' => $per_page,
		'paged'          => $paged,
		'orderby'        => 'date',
		'order'          => 'DESC',
		'tax_query'      => array(
			array(
				'taxonomy' => 'job_type',
				'field'    => 'slug',
				'terms'    => $term_slug,
			),
		),
		'meta_query'     => array(
			'relation' => 'OR',
			array( 'key' => 'closing_date', 'compare' => 'NOT EXISTS' ),
			array( 'key' => 'closing_date', 'value' => $today, 'compare' => '>=', 'type' => 'DATE' ),
			array( 'key' => 'closing_date', 'value' => '', 'compare' => '=' ),
		),
	);
	return new WP_Query( $args );
}

/**
 * Build opening item for front-end listing from a job post.
 *
 * @param WP_Post $job Job post.
 * @return array
 */
function tasheel_hr_build_opening_item( $job ) {
	$job_id = $job->ID;
	// Job location from ACF: location_city + location_country; display "City, Country".
	$loc_parts = function_exists( 'tasheel_hr_job_location_parts' ) ? tasheel_hr_job_location_parts( $job_id ) : array( 'display' => '' );
	$loc = isset( $loc_parts['display'] ) ? $loc_parts['display'] : '';
	$emp    = function_exists( 'get_field' ) ? get_field( 'employment_type', $job_id ) : '';
	$summary = $job->post_excerpt ? $job->post_excerpt : wp_trim_words( $job->post_content, 20 );
	// Use original job's post date for "Posted X ago" when this is a WPML translation (same as single job detail).
	$date_source_id = $job_id;
	if ( function_exists( 'apply_filters' ) && has_filter( 'wpml_original_element_id' ) ) {
		$post_type = get_post_type( $job_id );
		$original_id = apply_filters( 'wpml_original_element_id', null, $job_id, 'post_' . ( $post_type ?: 'hr_job' ) );
		if ( $original_id && (int) $original_id !== (int) $job_id ) {
			$date_source_id = (int) $original_id;
		}
	}
	$posted_timestamp = get_post_time( 'U', false, $date_source_id );
	$human = human_time_diff( $posted_timestamp, current_time( 'timestamp' ) );
	// Build "Posted X ago" so the time always shows; fallback if translation omits %s (fixes Arabic "منذ" only).
	$posted_format = __( 'Posted %s ago', 'tasheel' );
	$posted_human = ( strpos( $posted_format, '%s' ) !== false )
		? sprintf( $posted_format, $human )
		: ( $posted_format . ' ' . $human );
	// Arabic: show numbers in Arabic-Indic numerals (٠-٩).
	if ( function_exists( 'tasheel_arabic_numerals' ) ) {
		$posted_human = tasheel_arabic_numerals( $posted_human );
	}
	// Display same Job ID for EN and AR (canonical/original post ID).
	$display_id = function_exists( 'tasheel_hr_canonical_job_id' ) ? tasheel_hr_canonical_job_id( $job_id ) : $job_id;
	return array(
		'title'           => get_the_title( $job ),
		'posted_date'     => $posted_human,
		'location'        => is_string( $loc ) ? $loc : '',
		'job_id'          => ( function_exists( '__' ) ? esc_html__( 'ID:', 'tasheel' ) : 'ID:' ) . ' ' . $display_id,
		'job_post_id'     => $job_id,
		'details_link'    => get_permalink( $job ),
		'icon'            => '',
		'employment_type' => is_string( $emp ) ? $emp : '',
		'summary'         => $summary,
	);
}

/**
 * Provide latest openings to careers flexible content (by job_type term).
 *
 * @param array  $openings       Existing openings.
 * @param string $listing_type   career|corporate_training|academic
 * @param int    $page_id        Page ID (unused).
 * @param int    $initial_count  Number to show on first load (default 12).
 * @return array{openings: array, has_more: bool}
 */
function tasheel_hr_filter_latest_openings( $openings, $listing_type, $page_id, $initial_count = 12 ) {
	$term_slug = tasheel_hr_listing_type_to_term_slug( $listing_type );
	if ( ! $term_slug || ! taxonomy_exists( 'job_type' ) ) {
		return array( 'openings' => array(), 'has_more' => false );
	}
	$per_page = max( 1, min( 50, (int) $initial_count ) );
	$query = tasheel_hr_query_active_jobs( $term_slug, $per_page, 1 );
	$out = array();
	if ( $query->have_posts() ) {
		foreach ( $query->posts as $job ) {
			$out[] = tasheel_hr_build_opening_item( $job );
		}
		wp_reset_postdata();
	}
	// has_more: there are more jobs than we showed (use found_posts so it's reliable)
	$has_more = $query->found_posts > $per_page;
	return array( 'openings' => $out, 'has_more' => $has_more );
}

add_filter( 'tasheel_careers_latest_openings', 'tasheel_hr_filter_latest_openings', 10, 4 );

/**
 * AJAX: Load more jobs for Latest Openings section.
 */
function tasheel_ajax_load_more_jobs() {
	$nonce = isset( $_POST['nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['nonce'] ) ) : '';
	if ( ! wp_verify_nonce( $nonce, 'tasheel_load_more_jobs' ) ) {
		wp_send_json_error( array( 'message' => __( 'Invalid request.', 'tasheel' ) ) );
	}
	$listing_type = isset( $_POST['listing_type'] ) ? sanitize_text_field( wp_unslash( $_POST['listing_type'] ) ) : 'career';
	$per_page     = isset( $_POST['per_page'] ) ? max( 1, min( 50, (int) $_POST['per_page'] ) ) : 12;
	$paged        = isset( $_POST['page'] ) ? max( 1, (int) $_POST['page'] ) : 1;

	$term_slug = tasheel_hr_listing_type_to_term_slug( $listing_type );
	if ( ! $term_slug || ! taxonomy_exists( 'job_type' ) ) {
		wp_send_json_success( array( 'html' => '', 'has_more' => false ) );
	}

	$query = tasheel_hr_query_active_jobs( $term_slug, $per_page, $paged );
	$openings = array();
	if ( $query->have_posts() ) {
		foreach ( $query->posts as $job ) {
			$openings[] = tasheel_hr_build_opening_item( $job );
		}
		wp_reset_postdata();
	}
	$has_more = $paged < $query->max_num_pages;

	ob_start();
	get_template_part( 'template-parts/Latest-Openings-items', null, array( 'openings' => $openings ) );
	$html = ob_get_clean();

	wp_send_json_success( array( 'html' => $html, 'has_more' => $has_more ) );
}

add_action( 'wp_ajax_tasheel_load_more_jobs', 'tasheel_ajax_load_more_jobs' );
add_action( 'wp_ajax_nopriv_tasheel_load_more_jobs', 'tasheel_ajax_load_more_jobs' );

/**
 * Add Applicants and Expired columns to Jobs list in admin.
 */
function tasheel_hr_job_list_columns( $columns ) {
	$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
	if ( ! $screen || $screen->post_type !== tasheel_hr_job_post_type() ) {
		return $columns;
	}
	$new = array();
	foreach ( $columns as $key => $label ) {
		$new[ $key ] = $label;
		if ( $key === 'title' ) {
			$new['applicants'] = __( 'Applicants', 'tasheel' );
		}
		// Add Status (Active/Expired) after Job Types or after Date.
		if ( $key === 'taxonomy-job_type' || ( $key === 'date' && ! isset( $new['tasheel_hr_status'] ) ) ) {
			$new['tasheel_hr_status'] = __( 'Status', 'tasheel' );
		}
	}
	if ( ! isset( $new['tasheel_hr_status'] ) ) {
		$new['tasheel_hr_status'] = __( 'Status', 'tasheel' );
	}
	return $new;
}

function tasheel_hr_job_list_column_applicants( $column, $post_id ) {
	if ( $column !== 'applicants' ) {
		return;
	}
	$apps = get_posts( array(
		'post_type'      => 'job_application',
		'post_status'    => 'any',
		'posts_per_page' => -1,
		'fields'         => 'ids',
		'meta_query'     => array( array( 'key' => 'job_id', 'value' => $post_id, 'compare' => '=' ) ),
	) );
	echo esc_html( is_array( $apps ) ? count( $apps ) : 0 );
}

/**
 * Whether an hr_job is expired (past closing date). No closing date = not expired.
 *
 * @param int $job_id Job post ID.
 * @return bool
 */
function tasheel_hr_job_is_expired( $job_id ) {
	$closing = function_exists( 'get_field' ) ? get_field( 'closing_date', $job_id ) : get_post_meta( $job_id, 'closing_date', true );
	if ( $closing === '' || $closing === null || $closing === false ) {
		return false;
	}
	$closing = is_array( $closing ) ? ( isset( $closing['value'] ) ? $closing['value'] : '' ) : (string) $closing;
	if ( $closing === '' ) {
		return false;
	}
	$today = gmdate( 'Y-m-d' );
	return $closing < $today;
}

function tasheel_hr_job_list_column_status( $column, $post_id ) {
	if ( $column !== 'tasheel_hr_status' ) {
		return;
	}
	$expired = function_exists( 'tasheel_hr_job_is_expired' ) ? tasheel_hr_job_is_expired( $post_id ) : false;
	if ( $expired ) {
		echo '<span class="tasheel-hr-status-badge" style="color:#b32d2e;">' . esc_html__( 'Expired', 'tasheel' ) . '</span>';
	} else {
		echo '<span class="tasheel-hr-status-badge" style="color:#00a32a;">' . esc_html__( 'Active', 'tasheel' ) . '</span>';
	}
}

add_filter( 'manage_hr_job_posts_columns', 'tasheel_hr_job_list_columns' );
add_action( 'manage_hr_job_posts_custom_column', 'tasheel_hr_job_list_column_applicants', 10, 2 );
add_action( 'manage_hr_job_posts_custom_column', 'tasheel_hr_job_list_column_status', 10, 2 );
