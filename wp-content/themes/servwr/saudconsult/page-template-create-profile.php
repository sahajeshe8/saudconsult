<?php
/**
 * Template Name: Create Profile
 *
 * The template for displaying the Create Profile page
 *
 * @package tasheel
 */
global $header_custom_class;
$header_custom_class = 'black-header';

$registration_failed = ! empty( $_GET['registration_error'] );
$registration_errors = array();
if ( $registration_failed && ! empty( $_GET['errkey'] ) && is_string( $_GET['errkey'] ) ) {
	$registration_errors = get_transient( sanitize_text_field( wp_unslash( $_GET['errkey'] ) ) );
	if ( is_array( $registration_errors ) ) {
		delete_transient( sanitize_text_field( wp_unslash( $_GET['errkey'] ) ) );
	} else {
		$registration_errors = array();
	}
}

if ( ! is_user_logged_in() ) {
	// After a failed registration we show the error on this page instead of redirecting to wp-login.
	if ( $registration_failed ) {
		// Show registration error message and link to try again (no redirect to login).
		get_header();
		?>
		<main id="primary" class="site-main no_banner_section" style="background: #EDF3E4;">
			<section class="create_profile_section pt_80 pb_80">
				<div class="wrap">
					<div class="create_profile_container">
						<div class="create_profile_content">
							<h3 class="h3_title_50 pb_5 text_center mb_20"><?php esc_html_e( 'Create Profile', 'tasheel' ); ?></h3>
							<div class="registration-error-msg" style="margin-bottom: 1.5em; padding: 1em; background: #fff3cd; border: 1px solid #ffc107; border-radius: 4px;">
								<p style="margin: 0 0 0.5em 0; font-weight: bold;"><?php esc_html_e( 'Registration could not be completed.', 'tasheel' ); ?></p>
								<?php if ( ! empty( $registration_errors ) ) : ?>
									<ul style="margin: 0; padding-left: 1.2em;">
										<?php foreach ( $registration_errors as $msg ) : ?>
											<li><?php echo esc_html( $msg ); ?></li>
										<?php endforeach; ?>
									</ul>
								<?php endif; ?>
								<p style="margin: 1em 0 0 0;">
									<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn_style btn_transparent but_black"><?php esc_html_e( 'Go back', 'tasheel' ); ?></a>
									<span style="margin-left: 0.5em;"><?php esc_html_e( 'Try creating an account again from the Sign Up form, or', 'tasheel' ); ?></span>
									<?php
									$login_redirect = isset( $_SERVER['REQUEST_URI'] ) ? home_url( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : ( function_exists( 'tasheel_hr_create_profile_url' ) ? tasheel_hr_create_profile_url( 0 ) : home_url( '/create-profile/' ) );
									?>
									<a href="<?php echo esc_url( add_query_arg( 'redirect_to', rawurlencode( $login_redirect ), home_url( '/' ) ) ); ?>" class="btn_style btn_transparent but_black" style="margin-left: 0.5em;"><?php esc_html_e( 'Log in', 'tasheel' ); ?></a>
								</p>
							</div>
						</div>
					</div>
				</div>
			</section>
		</main>
		<?php
		get_footer();
		exit;
	}
	$intended = isset( $_SERVER['REQUEST_URI'] ) ? esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : ( function_exists( 'tasheel_hr_create_profile_url' ) ? tasheel_hr_create_profile_url( 0 ) : home_url( '/create-profile/' ) );
	wp_safe_redirect( add_query_arg( array( 'redirect_to' => rawurlencode( $intended ), 'open_login' => '1' ), home_url( '/' ) ) );
	exit;
}

/*
 * Edit-from-Review flow: User clicks "Edit Profile" on my-profile/apply/{job_id}/ (Review Profile).
 * Link goes to create-profile/apply/{job_id}/?edit=1. We must:
 * - Resolve apply_to from URL so the correct form sections and job context are used.
 * - Load the current user's profile so the form is pre-filled. Never serve cached empty form.
 */
$create_profile_user_id = get_current_user_id();

// Resolve apply_to: query var, GET param, then URL path fallback (handles rewrites/WPML).
$apply_to = get_query_var( 'apply_to' ) ? (int) get_query_var( 'apply_to' ) : 0;
if ( ! $apply_to && ! empty( $_GET['apply_to'] ) ) {
	$apply_to = (int) $_GET['apply_to'];
}
if ( ! $apply_to && isset( $_SERVER['REQUEST_URI'] ) && preg_match( '#/create-profile/apply/([0-9]+)/?#', wp_unslash( $_SERVER['REQUEST_URI'] ), $m ) ) {
	$apply_to = (int) $m[1];
	global $wp_query;
	if ( $wp_query ) {
		$wp_query->query_vars['apply_to'] = $apply_to;
	}
}

// Show "Edit Profile" heading only when URL has ?edit=1 (e.g. from Review Profile). Otherwise "Create Profile".
$is_edit_profile = isset( $_GET['edit'] ) && $_GET['edit'] === '1';

// Prevent any cache from serving this page to a logged-in user with stale/empty form.
if ( $create_profile_user_id && function_exists( 'nocache_headers' ) ) {
	nocache_headers();
}
if ( $create_profile_user_id ) {
	header( 'Cache-Control: no-store, no-cache, must-revalidate, max-age=0', true );
	header( 'Pragma: no-cache', true );
}

// Load profile for this request using stable user ID. When edit=1, force fresh read if object cache returned empty.
$profile_data = array();
if ( $create_profile_user_id && function_exists( 'tasheel_hr_get_user_profile' ) ) {
	$profile_data = tasheel_hr_get_user_profile( $create_profile_user_id );
	if ( $is_edit_profile && empty( $profile_data['profile_email'] ) ) {
		wp_cache_delete( $create_profile_user_id, 'user_meta' );
		$profile_data = tasheel_hr_get_user_profile( $create_profile_user_id );
	}
}
if ( ! is_array( $profile_data ) ) {
	$profile_data = array();
}

$field_errors = array();
$save_missing = $create_profile_user_id ? get_transient( 'tasheel_hr_profile_save_missing_' . $create_profile_user_id ) : false;
if ( ! empty( $_GET['profile_error'] ) && $_GET['profile_error'] === 'missing' && $save_missing && is_array( $save_missing ) ) {
	if ( ! empty( $save_missing['submitted'] ) && is_array( $save_missing['submitted'] ) ) {
		$profile_data = array_merge( $profile_data, $save_missing['submitted'] );
	}
	if ( ! empty( $save_missing['field_errors'] ) && is_array( $save_missing['field_errors'] ) ) {
		$field_errors = $save_missing['field_errors'];
	}
}
// Same validation messages as backend (Create Profile and Guest apply). All fields so client-side matches every validated field.
$required_msg = __( 'is required.', 'tasheel' );
$profile_phone_required_msg = function_exists( 'tasheel_hr_get_field_error_message' ) ? tasheel_hr_get_field_error_message( 'profile_phone', '', $required_msg ) : ( ( function_exists( 'tasheel_hr_profile_field_error_label' ) ? tasheel_hr_profile_field_error_label( 'profile_phone' ) : __( 'Phone', 'tasheel' ) ) . ' ' . $required_msg );
$required_field_messages = function_exists( 'tasheel_hr_get_all_required_field_messages' ) ? tasheel_hr_get_all_required_field_messages( $required_msg, 10 ) : array();

// When coming from job apply, show only sections relevant to that job type (same as Review Profile).
$edit_sections = null;
if ( $apply_to && function_exists( 'tasheel_hr_get_job_type_slug' ) && function_exists( 'tasheel_hr_normalize_job_type_slug' ) && function_exists( 'tasheel_hr_review_sections_for_job_type' ) ) {
	$raw_slug = tasheel_hr_get_job_type_slug( $apply_to );
	$edit_sections = tasheel_hr_review_sections_for_job_type( tasheel_hr_normalize_job_type_slug( $raw_slug ) );
	// So header can render the training submit popup with this job's form (for my-profile flow after save).
	if ( $edit_sections && function_exists( 'tasheel_hr_review_sections_for_job_type' ) ) {
		$ct_sections = tasheel_hr_review_sections_for_job_type( 'corporate_training' );
		if ( is_array( $ct_sections ) && $edit_sections === $ct_sections ) {
			$GLOBALS['tasheel_training_popup_job_id'] = $apply_to;
		}
	}
}

$edu_list = array();
if ( ! empty( $profile_data['profile_education'] ) ) {
	$decoded = is_string( $profile_data['profile_education'] ) ? json_decode( $profile_data['profile_education'], true ) : $profile_data['profile_education'];
	$edu_list = ( is_array( $decoded ) && ! empty( $decoded ) ) ? $decoded : array( array() );
	if ( function_exists( 'tasheel_hr_fix_profile_json_strings' ) ) {
		$edu_list = tasheel_hr_fix_profile_json_strings( $edu_list );
	}
}
if ( empty( $edu_list ) ) {
	$edu_list = array( array() );
}
$exp_list = array();
if ( ! empty( $profile_data['profile_experience'] ) ) {
	$decoded = is_string( $profile_data['profile_experience'] ) ? json_decode( $profile_data['profile_experience'], true ) : $profile_data['profile_experience'];
	$exp_list = ( is_array( $decoded ) && ! empty( $decoded ) ) ? $decoded : array( array() );
	if ( function_exists( 'tasheel_hr_fix_profile_json_strings' ) ) {
		$exp_list = tasheel_hr_fix_profile_json_strings( $exp_list );
	}
}
if ( empty( $exp_list ) ) {
	$exp_list = array( array() );
}
$proj_list = array();
if ( ! empty( $profile_data['profile_recent_projects'] ) ) {
	$decoded = is_string( $profile_data['profile_recent_projects'] ) ? json_decode( $profile_data['profile_recent_projects'], true ) : $profile_data['profile_recent_projects'];
	$proj_list = ( is_array( $decoded ) && ! empty( $decoded ) ) ? array_slice( $decoded, 0, 3 ) : array( array() );
	if ( function_exists( 'tasheel_hr_fix_profile_json_strings' ) ) {
		$proj_list = tasheel_hr_fix_profile_json_strings( $proj_list );
	}
}
if ( empty( $proj_list ) ) {
	$proj_list = array( array() );
}

get_header();
?>

<main id="primary" class="site-main no_banner_section" style="background: #EDF3E4;">
	<style>
		/* Create Profile - Remove block buttons (trash icon, right-aligned) */
		.create_profile_section .block-actions { margin-top: 10px; display: flex; justify-content: flex-end; }
		.create_profile_section .btn-remove-block {
			width: 36px;
			height: 36px;
			min-width: 36px;
			border-radius: 6px;
			background: #ff4444;
			color: #fff;
			border: none;
			cursor: pointer;
			display: inline-flex;
			align-items: center;
			justify-content: center;
			transition: background 0.2s;
		}
		.create_profile_section .btn-remove-block:hover {
			background: #cc0000;
		}
		.create_profile_section .btn-remove-block-icon svg {
			display: block;
			width: 18px;
			height: 18px;
		}
		/* Existing file display & remove */
		.create_profile_section .existing-file-display {
			display: flex;
			align-items: center;
			gap: 12px;
			margin-bottom: 12px;
			padding: 12px 16px;
			background: #f9f9f9;
			border: 1px solid #e0e0e0;
			border-radius: 8px;
		}
		.create_profile_section .existing-file-display a {
			flex: 1;
			color: #0D6A37;
			text-decoration: none;
			font-size: 14px;
		}
		.create_profile_section .existing-file-display a:hover { text-decoration: underline; }
		.create_profile_section .existing-file-display {
			position: relative;
			display: inline-flex;
			align-items: center;
			gap: 10px;
		}
		.create_profile_section .btn-remove-file {
			width: 28px;
			height: 28px;
			border-radius: 50%;
			background: #ff4444;
			color: #fff;
			border: none;
			font-size: 18px;
			line-height: 1;
			cursor: pointer;
			display: inline-flex;
			align-items: center;
			justify-content: center;
			flex-shrink: 0;
			transition: background 0.2s;
		}
		.create_profile_section .btn-remove-file:hover {
			background: #cc0000;
		}
		.create_profile_section .field-error {
			display: block;
			color: #842029;
			font-size: 0.85em;
			margin-top: 4px;
		}
		.create_profile_section .has-error .input,
		.create_profile_section .has-error .select-input,
		.create_profile_section .has-error .date-input { border-color: #f5c2c7; }
		.create_profile_section .section-error { margin-bottom: 8px; color: #842029; font-size: 0.9em; }
	</style>
	<section class="create_profile_section pt_80 pb_80">
		<div class="wrap">
			<div class="create_profile_container">
				<div class="create_profile_content">
					<h3 class="h3_title_50 pb_5 text_center mb_20"><?php echo $is_edit_profile ? esc_html__( 'Edit Profile', 'tasheel' ) : esc_html__( 'Create Profile', 'tasheel' ); ?></h3>
					<?php if ( ! empty( $_GET['profile_saved'] ) ) : ?>
						<p class="profile-saved-msg" style="margin-bottom: 1em; color: #0a0;"><?php esc_html_e( 'Profile saved successfully.', 'tasheel' ); ?></p>
					<?php endif; ?>
					<?php
					$profile_err = $create_profile_user_id ? get_transient( 'tasheel_profile_save_err_' . $create_profile_user_id ) : false;
					if ( $profile_err ) :
						delete_transient( 'tasheel_profile_save_err_' . $create_profile_user_id );
						$err_msg = $profile_err === 'invalid_nonce' ? __( 'Session expired. Please refresh the page and try again.', 'tasheel' ) : __( 'Please log in to save your profile.', 'tasheel' );
					?>
						<p class="profile-error-msg" style="margin-bottom: 1em; padding: 1em; background: #fee; border: 1px solid #c00; border-radius: 4px; color: #c00;"><?php echo esc_html( $err_msg ); ?></p>
					<?php endif; ?>
					<?php
					if ( ! empty( $_GET['profile_error'] ) && $_GET['profile_error'] === 'missing' && ! empty( $field_errors ) ) :
						delete_transient( 'tasheel_hr_profile_save_missing_' . $create_profile_user_id );
						?>
						<p class="profile-error-summary" style="margin-bottom: 1em; color: #842029; font-weight: 600;"><?php esc_html_e( 'Please fix the errors below.', 'tasheel' ); ?></p>
					<?php endif; ?>
					<p id="profile-ajax-error-summary" class="profile-error-summary" style="display: none; margin-bottom: 1em; color: #842029; font-weight: 600;"><?php esc_html_e( 'Please fix the errors below.', 'tasheel' ); ?></p>

					<?php
					$ct_sections = function_exists( 'tasheel_hr_review_sections_for_job_type' ) ? tasheel_hr_review_sections_for_job_type( 'corporate_training' ) : array();
					$use_corporate_training_form = ( is_array( $edit_sections ) && $edit_sections === $ct_sections );
					?>
					<form method="post" action="" id="create-profile-form" class="create-profile-form" enctype="multipart/form-data" novalidate data-save-ajax-url="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>"<?php if ( $create_profile_user_id ) : ?> data-fetch-profile="1" data-ajax-url="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>" data-nonce="<?php echo esc_attr( wp_create_nonce( 'tasheel_hr_profile_fetch' ) ); ?>"<?php endif; ?>>
						<?php wp_nonce_field( 'tasheel_save_profile', 'tasheel_save_profile_nonce' ); ?>
						<input type="hidden" name="tasheel_save_profile" value="1" />
						<?php if ( $apply_to ) : ?><input type="hidden" name="apply_to" value="<?php echo (int) $apply_to; ?>" /><?php endif; ?>

					<?php if ( $use_corporate_training_form ) : ?>
						<?php
						get_template_part( 'template-parts/form-profile-corporate-training', null, array(
							'profile_data'   => $profile_data,
							'field_errors'   => $field_errors,
							'edu_list'       => $edu_list,
							'is_guest'       => false,
						) );
						?>
						<div class="form-buttion-row flex-align-right">
							<button type="submit" class="btn_style btn_transparent but_black"><?php esc_html_e( 'Save Profile', 'tasheel' ); ?></button>
						</div>
						</form>
					<?php else : ?>
					<?php if ( $edit_sections === null || in_array( 'contact', $edit_sections, true ) ) : ?>
					<div class="form-group">
						<div class="related_jobs_section_content">
							<h5><?php esc_html_e( 'Contact Information *', 'tasheel' ); ?></h5>
							<?php
							$existing_photo = isset( $profile_data['profile_photo'] ) ? $profile_data['profile_photo'] : '';
							?>
							<div class="file-upload-section-wrapper<?php echo ! empty( $field_errors['profile_photo'] ) ? ' has-error' : ''; ?>" data-has-existing-photo="<?php echo ! empty( $existing_photo ) ? '1' : '0'; ?>">
								<span class="field-error" id="profile-photo-field-error" role="alert"<?php echo empty( $field_errors['profile_photo'] ) ? ' style="display: none;"' : ''; ?>><?php echo ! empty( $field_errors['profile_photo'] ) ? esc_html( $field_errors['profile_photo'] ) : ''; ?></span>
								<input type="hidden" name="remove_profile_photo" id="remove_profile_photo" value="0">
								<div class="file-upload-section">
									<input type="file" id="profile-photo-upload" name="profile_photo" accept=".jpg,.jpeg,.png" class="file-input-hidden">
									<label for="profile-photo-upload" class="file-upload-label"<?php echo ! empty( $existing_photo ) ? ' style="display: none;"' : ''; ?>>
										<span class="file-upload-icon"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/file-upload.svg' ); ?>" alt="Upload"></span>
										<p class="file-upload-text"><?php esc_html_e( 'Upload a photo *', 'tasheel' ); ?></p>
									</label>
									<div class="file-preview-container"<?php echo empty( $existing_photo ) ? ' style="display: none;"' : ''; ?>>
										<img id="file-preview-image" src="<?php echo ! empty( $existing_photo ) ? esc_url( $existing_photo ) : ''; ?>" alt="" class="file-preview-image">
										<button type="button" class="file-remove-btn" aria-label="<?php esc_attr_e( 'Remove photo', 'tasheel' ); ?>">×</button>
									</div>
									<p class="file-upload-hint file-upload-hint-photo" style="margin:6px 0 0;font-size:12px;color:#666;" data-max-size="1MB"><?php esc_html_e( 'Accepted: JPG, PNG. Max 1MB.', 'tasheel' ); ?></p>
								</div>
							</div>
							<ul class="career-form-list-ul form-col-2">
								<li class="<?php echo ! empty( $field_errors['profile_title'] ) ? 'has-error' : ''; ?>">
									<div class="select-wrapper">
										<select class="input select-input" name="profile_title" required>
											<?php
											$title_opts = function_exists( 'tasheel_hr_title_salutation_options' ) ? tasheel_hr_title_salutation_options() : array( '' => __( 'Title *', 'tasheel' ), 'mr' => __( 'Mr.', 'tasheel' ), 'ms' => __( 'Ms.', 'tasheel' ), 'mrs' => __( 'Mrs.', 'tasheel' ), 'miss' => __( 'Miss', 'tasheel' ), 'dr' => __( 'Dr.', 'tasheel' ), 'prof' => __( 'Prof.', 'tasheel' ) );
											$title_caps = array( 'mr' => 'Mr.', 'ms' => 'Ms.', 'mrs' => 'Mrs.', 'miss' => 'Miss', 'dr' => 'Dr.', 'prof' => 'Prof.' );
											$current_title = isset( $profile_data['profile_title'] ) ? $profile_data['profile_title'] : '';
											foreach ( $title_opts as $val => $label ) :
												$display_label = ( $val !== '' && isset( $title_caps[ $val ] ) ) ? $title_caps[ $val ] : $label;
												?>
											<option value="<?php echo esc_attr( $val ); ?>" <?php selected( $current_title, $val ); ?>><?php echo esc_html( $display_label ); ?></option>
											<?php endforeach; ?>
										</select>
										<span class="select-arrow"></span>
									</div>
									<?php if ( ! empty( $field_errors['profile_title'] ) ) : ?><span class="field-error"><?php echo esc_html( $field_errors['profile_title'] ); ?></span><?php endif; ?>
								</li>
								<li class="<?php echo ! empty( $field_errors['profile_first_name'] ) ? 'has-error' : ''; ?>">
									<input class="input" type="text" name="profile_first_name" placeholder="<?php esc_attr_e( 'First Name *', 'tasheel' ); ?>" value="<?php echo esc_attr( isset( $profile_data['profile_first_name'] ) ? $profile_data['profile_first_name'] : '' ); ?>" required>
									<?php if ( ! empty( $field_errors['profile_first_name'] ) ) : ?><span class="field-error"><?php echo esc_html( $field_errors['profile_first_name'] ); ?></span><?php endif; ?>
								</li>
								<li class="<?php echo ! empty( $field_errors['profile_last_name'] ) ? 'has-error' : ''; ?>">
									<input class="input" type="text" name="profile_last_name" placeholder="<?php esc_attr_e( 'Last Name *', 'tasheel' ); ?>" value="<?php echo esc_attr( isset( $profile_data['profile_last_name'] ) ? $profile_data['profile_last_name'] : '' ); ?>" required>
									<?php if ( ! empty( $field_errors['profile_last_name'] ) ) : ?><span class="field-error"><?php echo esc_html( $field_errors['profile_last_name'] ); ?></span><?php endif; ?>
								</li>
								<li><input class="input" type="email" placeholder="<?php esc_attr_e( 'Email Address *', 'tasheel' ); ?>" value="<?php echo esc_attr( isset( $profile_data['profile_email'] ) ? $profile_data['profile_email'] : '' ); ?>" readonly></li>
								<li class="<?php echo ! empty( $field_errors['profile_phone'] ) ? 'has-error' : ''; ?>">
									<input class="input" type="tel" name="profile_phone" placeholder="<?php esc_attr_e( 'Phone Number *', 'tasheel' ); ?>" value="<?php echo esc_attr( isset( $profile_data['profile_phone'] ) ? $profile_data['profile_phone'] : '' ); ?>" required data-required-msg="<?php echo esc_attr( $profile_phone_required_msg ); ?>">
									<?php if ( ! empty( $field_errors['profile_phone'] ) ) : ?><span class="field-error"><?php echo esc_html( $field_errors['profile_phone'] ); ?></span><?php endif; ?>
								</li>
							</ul>
						</div>
					</div>
					<?php endif; ?>

					<?php if ( $edit_sections === null || in_array( 'diversity', $edit_sections, true ) ) : ?>
					<div class="form-group">
						<div class="related_jobs_section_content">
							<h5><?php esc_html_e( 'Diversity Information *', 'tasheel' ); ?></h5>
						</div>

						<ul class="career-form-list-ul form-col-2">
							<li class="<?php echo ! empty( $field_errors['profile_gender'] ) ? 'has-error' : ''; ?>">
								<div class="select-wrapper">
									<select class="input select-input" name="profile_gender" required>
										<option value=""><?php esc_html_e( 'Gender *', 'tasheel' ); ?></option>
										<option value="male" <?php selected( isset( $profile_data['profile_gender'] ) ? $profile_data['profile_gender'] : '', 'male' ); ?>><?php esc_html_e( 'Male', 'tasheel' ); ?></option>
										<option value="female" <?php selected( isset( $profile_data['profile_gender'] ) ? $profile_data['profile_gender'] : '', 'female' ); ?>><?php esc_html_e( 'Female', 'tasheel' ); ?></option>
										<option value="other" <?php selected( isset( $profile_data['profile_gender'] ) ? $profile_data['profile_gender'] : '', 'other' ); ?>><?php esc_html_e( 'Other', 'tasheel' ); ?></option>
										<option value="prefer-not-to-say" <?php selected( isset( $profile_data['profile_gender'] ) ? $profile_data['profile_gender'] : '', 'prefer-not-to-say' ); ?>><?php esc_html_e( 'Prefer not to say', 'tasheel' ); ?></option>
									</select>
									<span class="select-arrow"></span>
								</div>
								<?php if ( ! empty( $field_errors['profile_gender'] ) ) : ?><span class="field-error"><?php echo esc_html( $field_errors['profile_gender'] ); ?></span><?php endif; ?>
							</li>
							<li class="<?php echo ! empty( $field_errors['profile_marital_status'] ) ? 'has-error' : ''; ?>">
								<div class="select-wrapper">
									<select class="input select-input" name="profile_marital_status" required>
										<option value=""><?php esc_html_e( 'Marital Status *', 'tasheel' ); ?></option>
										<option value="single" <?php selected( isset( $profile_data['profile_marital_status'] ) ? $profile_data['profile_marital_status'] : '', 'single' ); ?>><?php esc_html_e( 'Single', 'tasheel' ); ?></option>
										<option value="married" <?php selected( isset( $profile_data['profile_marital_status'] ) ? $profile_data['profile_marital_status'] : '', 'married' ); ?>><?php esc_html_e( 'Married', 'tasheel' ); ?></option>
									</select>
									<span class="select-arrow"></span>
								</div>
								<?php if ( ! empty( $field_errors['profile_marital_status'] ) ) : ?><span class="field-error"><?php echo esc_html( $field_errors['profile_marital_status'] ); ?></span><?php endif; ?>
							</li>
							<li class="<?php echo ! empty( $field_errors['profile_dob'] ) ? 'has-error' : ''; ?>">
								<div class="select-wrapper date-input-wrapper">
									<input class="input date-input" type="date" name="profile_dob" placeholder="<?php esc_attr_e( 'Date of Birth *', 'tasheel' ); ?>" value="<?php echo esc_attr( isset( $profile_data['profile_dob'] ) ? $profile_data['profile_dob'] : '' ); ?>" max="<?php echo esc_attr( date( 'Y-m-d' ) ); ?>" required>
								</div>
								<?php if ( ! empty( $field_errors['profile_dob'] ) ) : ?><span class="field-error"><?php echo esc_html( $field_errors['profile_dob'] ); ?></span><?php endif; ?>
							</li>
							<li class="<?php echo ! empty( $field_errors['profile_national_status'] ) ? 'has-error' : ''; ?>">
								<div class="select-wrapper">
									<select class="input select-input" name="profile_national_status" required>
										<option value=""><?php esc_html_e( 'National Status *', 'tasheel' ); ?></option>
										<option value="national" <?php selected( isset( $profile_data['profile_national_status'] ) ? $profile_data['profile_national_status'] : '', 'national' ); ?>><?php esc_html_e( 'National', 'tasheel' ); ?></option>
										<option value="resident" <?php selected( isset( $profile_data['profile_national_status'] ) ? $profile_data['profile_national_status'] : '', 'resident' ); ?>><?php esc_html_e( 'Resident', 'tasheel' ); ?></option>
									</select>
									<span class="select-arrow"></span>
								</div>
								<?php if ( ! empty( $field_errors['profile_national_status'] ) ) : ?><span class="field-error"><?php echo esc_html( $field_errors['profile_national_status'] ); ?></span><?php endif; ?>
							</li>
							<li class="<?php echo ! empty( $field_errors['profile_nationality'] ) ? 'has-error' : ''; ?>">
								<div class="select-wrapper">
									<select class="input select-input" name="profile_nationality" required>
										<option value=""><?php esc_html_e( 'Nationality *', 'tasheel' ); ?></option>
										<?php
										$nationalities = function_exists( 'tasheel_hr_get_nationalities' ) ? tasheel_hr_get_nationalities() : array();
										$current_nat = isset( $profile_data['profile_nationality'] ) ? $profile_data['profile_nationality'] : '';
										foreach ( $nationalities as $code => $name ) :
											?>
										<option value="<?php echo esc_attr( $code ); ?>" <?php selected( $current_nat, $code ); ?>><?php echo esc_html( $name ); ?></option>
										<?php endforeach; ?>
									</select>
									<span class="select-arrow"></span>
								</div>
								<?php if ( ! empty( $field_errors['profile_nationality'] ) ) : ?><span class="field-error"><?php echo esc_html( $field_errors['profile_nationality'] ); ?></span><?php endif; ?>
							</li>
							<li class="<?php echo ! empty( $field_errors['profile_location'] ) ? 'has-error' : ''; ?>">
								<input class="input" type="text" name="profile_location" placeholder="<?php esc_attr_e( 'Location *', 'tasheel' ); ?>" value="<?php echo esc_attr( isset( $profile_data['profile_location'] ) ? $profile_data['profile_location'] : '' ); ?>" required>
								<?php if ( ! empty( $field_errors['profile_location'] ) ) : ?><span class="field-error"><?php echo esc_html( $field_errors['profile_location'] ); ?></span><?php endif; ?>
							</li>
						</ul>
					</div>
					<?php endif; ?>

					<?php if ( $edit_sections === null || in_array( 'documents', $edit_sections, true ) ) : ?>
					<div class="form-group supporting-documents-section">
						<div class="related_jobs_section_content">
							<h5><?php esc_html_e( 'Supporting Documents and URLs *', 'tasheel' ); ?></h5>
						</div>
						<?php if ( ! empty( $field_errors['profile_resume'] ) ) : ?><p class="section-error"><?php echo esc_html( $field_errors['profile_resume'] ); ?></p><?php endif; ?>

						<div class="resume-upload-wrapper<?php echo ! empty( $field_errors['profile_resume'] ) ? ' has-error' : ''; ?>" id="resume-upload-container">
							<?php
							$existing_resume = isset( $profile_data['profile_resume'] ) ? $profile_data['profile_resume'] : '';
							$resume_name = $existing_resume ? basename( wp_parse_url( $existing_resume, PHP_URL_PATH ) ) : '';
							?>
							<?php if ( $existing_resume && $resume_name ) : ?>
							<div class="existing-file-display" data-field="resume">
								<a href="<?php echo esc_url( $existing_resume ); ?>" target="_blank" rel="noopener"><?php echo esc_html( $resume_name ); ?></a>
								<button type="button" class="btn-remove-file" data-field="resume" aria-label="<?php esc_attr_e( 'Remove resume', 'tasheel' ); ?>">×</button>
								<input type="hidden" name="remove_profile_resume" id="remove_profile_resume" value="0">
							</div>
							<?php endif; ?>
							<div class="resume-upload-area">
								<input type="file" id="resume-upload" name="profile_resume" accept=".pdf,.doc,.docx" class="file-input-hidden">
								<label for="resume-upload" class="resume-upload-button"><?php echo ( $existing_resume && $resume_name ) ? esc_html__( 'Replace resume *', 'tasheel' ) : esc_html__( 'Upload resume here *', 'tasheel' ); ?></label>
								<div class="resume-file-name" style="display: none;"></div>
								<p class="file-upload-hint" style="margin:6px 0 0;font-size:12px;color:#666;"><?php esc_html_e( 'Accepted: PDF, DOC, DOCX. Max 5MB.', 'tasheel' ); ?></p>
							</div>
						</div>

						<div class="resume-upload-wrapper" id="portfolio-upload-container">
							<?php
							$existing_portfolio = isset( $profile_data['profile_portfolio'] ) ? $profile_data['profile_portfolio'] : '';
							$portfolio_name = $existing_portfolio ? basename( wp_parse_url( $existing_portfolio, PHP_URL_PATH ) ) : '';
							?>
							<?php if ( $existing_portfolio && $portfolio_name ) : ?>
							<div class="existing-file-display" data-field="portfolio">
								<a href="<?php echo esc_url( $existing_portfolio ); ?>" target="_blank" rel="noopener"><?php echo esc_html( $portfolio_name ); ?></a>
								<button type="button" class="btn-remove-file" data-field="portfolio" aria-label="<?php esc_attr_e( 'Remove portfolio', 'tasheel' ); ?>">×</button>
								<input type="hidden" name="remove_profile_portfolio" id="remove_profile_portfolio" value="0">
							</div>
							<?php endif; ?>
							<div class="resume-upload-area">
								<input type="file" id="portfolio-upload" name="profile_portfolio" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" class="file-input-hidden">
								<label for="portfolio-upload" class="resume-upload-button"><?php echo ( $existing_portfolio && $portfolio_name ) ? esc_html__( 'Replace portfolio (optional)', 'tasheel' ) : esc_html__( 'Upload portfolio here (optional)', 'tasheel' ); ?></label>
								<div class="portfolio-file-name" style="display: none;"></div>
								<p class="file-upload-hint" style="margin:6px 0 0;font-size:12px;color:#666;"><?php esc_html_e( 'Accepted: PDF, DOC, DOCX, JPG, PNG. Max 5MB.', 'tasheel' ); ?></p>
							</div>
						</div>

						<ul class="career-form-list-ul">
							<li class="<?php echo ! empty( $field_errors['profile_linkedin'] ) ? 'has-error' : ''; ?>">
								<input class="input" type="url" name="profile_linkedin" placeholder="<?php esc_attr_e( 'LinkedIn Profile Link (optional)', 'tasheel' ); ?>" value="<?php echo esc_attr( isset( $profile_data['profile_linkedin'] ) ? $profile_data['profile_linkedin'] : '' ); ?>">
								<?php if ( ! empty( $field_errors['profile_linkedin'] ) ) : ?><span class="field-error"><?php echo esc_html( $field_errors['profile_linkedin'] ); ?></span><?php endif; ?>
							</li>
						</ul>
					</div>
					<?php endif; ?>

					<?php if ( $edit_sections === null || in_array( 'education', $edit_sections, true ) ) : ?>
					<div class="form-group js-education-group<?php echo ! empty( $field_errors['profile_education'] ) ? ' has-error' : ''; ?>">
						<div class="related_jobs_section_content">
							<h5><?php esc_html_e( 'Education *', 'tasheel' ); ?></h5>
							<p><?php esc_html_e( 'Please provide details about your education.', 'tasheel' ); ?></p>
						</div>
						<div class="js-education-blocks" data-additional-hint="<?php echo esc_attr( __( 'Enter details for this additional education entry.', 'tasheel' ) ); ?>">
							<?php foreach ( $edu_list as $ei => $ed ) : $ed = is_array( $ed ) ? $ed : array(); ?>
							<div class="js-education-block education-block" data-index="<?php echo (int) $ei; ?>">
								<?php if ( $ei > 0 ) : ?><p class="form-block-hint" style="margin-bottom: 10px; color: #555; font-size: 0.95em;"><?php esc_html_e( 'Enter details for this additional education entry.', 'tasheel' ); ?></p><?php endif; ?>
								<?php if ( $ei > 0 ) : ?><div class="education-block-divider"></div><?php endif; ?>
								<ul class="career-form-list-ul form-col-2">
									<?php $err_degree = 'profile_education_' . $ei . '_degree'; ?>
									<li class="<?php echo ! empty( $field_errors[ $err_degree ] ) ? 'has-error' : ''; ?>">
										<div class="select-wrapper">
											<select class="input select-input" name="profile_education[<?php echo (int) $ei; ?>][degree]" required>
												<option value=""><?php esc_html_e( 'Degree *', 'tasheel' ); ?></option>
												<option value="bachelor" <?php selected( isset( $ed['degree'] ) ? $ed['degree'] : '', 'bachelor' ); ?>><?php esc_html_e( "Bachelor's Degree", 'tasheel' ); ?></option>
												<option value="master" <?php selected( isset( $ed['degree'] ) ? $ed['degree'] : '', 'master' ); ?>><?php esc_html_e( "Master's Degree", 'tasheel' ); ?></option>
												<option value="phd" <?php selected( isset( $ed['degree'] ) ? $ed['degree'] : '', 'phd' ); ?>><?php esc_html_e( 'PhD', 'tasheel' ); ?></option>
												<option value="diploma" <?php selected( isset( $ed['degree'] ) ? $ed['degree'] : '', 'diploma' ); ?>><?php esc_html_e( 'Diploma', 'tasheel' ); ?></option>
											</select>
											<span class="select-arrow"></span>
										</div>
										<?php if ( ! empty( $field_errors[ $err_degree ] ) ) : ?><span class="field-error"><?php echo esc_html( $field_errors[ $err_degree ] ); ?></span><?php endif; ?>
									</li>
									<?php $err_inst = 'profile_education_' . $ei . '_institute'; ?>
									<li class="<?php echo ! empty( $field_errors[ $err_inst ] ) ? 'has-error' : ''; ?>"><input class="input" type="text" name="profile_education[<?php echo (int) $ei; ?>][institute]" placeholder="<?php esc_attr_e( 'Institute *', 'tasheel' ); ?>" value="<?php echo esc_attr( isset( $ed['institute'] ) ? $ed['institute'] : '' ); ?>" required><?php if ( ! empty( $field_errors[ $err_inst ] ) ) : ?><span class="field-error"><?php echo esc_html( $field_errors[ $err_inst ] ); ?></span><?php endif; ?></li>
									<?php $err_major = 'profile_education_' . $ei . '_major'; ?>
									<li class="<?php echo ! empty( $field_errors[ $err_major ] ) ? 'has-error' : ''; ?>">
										<div class="select-wrapper">
											<select class="input select-input" name="profile_education[<?php echo (int) $ei; ?>][major]" required>
												<option value=""><?php esc_html_e( 'Major *', 'tasheel' ); ?></option>
												<option value="engineering" <?php selected( isset( $ed['major'] ) ? $ed['major'] : '', 'engineering' ); ?>><?php esc_html_e( 'Engineering', 'tasheel' ); ?></option>
												<option value="business" <?php selected( isset( $ed['major'] ) ? $ed['major'] : '', 'business' ); ?>><?php esc_html_e( 'Business', 'tasheel' ); ?></option>
												<option value="science" <?php selected( isset( $ed['major'] ) ? $ed['major'] : '', 'science' ); ?>><?php esc_html_e( 'Science', 'tasheel' ); ?></option>
											</select>
											<span class="select-arrow"></span>
										</div>
										<?php if ( ! empty( $field_errors[ $err_major ] ) ) : ?><span class="field-error"><?php echo esc_html( $field_errors[ $err_major ] ); ?></span><?php endif; ?>
									</li>
									<?php $err_start = 'profile_education_' . $ei . '_start_date'; ?>
									<li class="<?php echo ! empty( $field_errors[ $err_start ] ) ? 'has-error' : ''; ?>"><div class="select-wrapper date-input-wrapper"><input class="input date-input career-date-start" type="date" name="profile_education[<?php echo (int) $ei; ?>][start_date]" placeholder="<?php esc_attr_e( 'Start Date *', 'tasheel' ); ?>" value="<?php echo esc_attr( isset( $ed['start_date'] ) ? $ed['start_date'] : '' ); ?>" max="<?php echo esc_attr( date( 'Y-m-d' ) ); ?>"  required></div><?php if ( ! empty( $field_errors[ $err_start ] ) ) : ?><span class="field-error"><?php echo esc_html( $field_errors[ $err_start ] ); ?></span><?php endif; ?></li>
									<?php $err_end = 'profile_education_' . $ei . '_end_date'; ?>
									<li class="<?php echo ! empty( $field_errors[ $err_end ] ) ? 'has-error' : ''; ?>"><div class="select-wrapper date-input-wrapper"><input class="input date-input career-date-end" type="date" name="profile_education[<?php echo (int) $ei; ?>][end_date]" placeholder="<?php esc_attr_e( 'End Date *', 'tasheel' ); ?>" value="<?php echo esc_attr( isset( $ed['end_date'] ) ? $ed['end_date'] : '' ); ?>" required></div><?php if ( ! empty( $field_errors[ $err_end ] ) ) : ?><span class="field-error"><?php echo esc_html( $field_errors[ $err_end ] ); ?></span><?php endif; ?></li>
									<?php $err_city = 'profile_education_' . $ei . '_city'; ?>
									<li class="<?php echo ! empty( $field_errors[ $err_city ] ) ? 'has-error' : ''; ?>"><input class="input" type="text" name="profile_education[<?php echo (int) $ei; ?>][city]" placeholder="<?php esc_attr_e( 'City *', 'tasheel' ); ?>" value="<?php echo esc_attr( isset( $ed['city'] ) ? $ed['city'] : '' ); ?>" required><?php if ( ! empty( $field_errors[ $err_city ] ) ) : ?><span class="field-error"><?php echo esc_html( $field_errors[ $err_city ] ); ?></span><?php endif; ?></li>
									<?php $err_country = 'profile_education_' . $ei . '_country'; ?>
									<li class="<?php echo ! empty( $field_errors[ $err_country ] ) ? 'has-error' : ''; ?>">
										<div class="select-wrapper">
											<select class="input select-input" name="profile_education[<?php echo (int) $ei; ?>][country]" required>
												<option value=""><?php esc_html_e( 'Country *', 'tasheel' ); ?></option>
												<?php
												$countries = function_exists( 'tasheel_hr_get_countries' ) ? tasheel_hr_get_countries() : array();
												$ed_country = isset( $ed['country'] ) ? $ed['country'] : '';
												foreach ( $countries as $code => $name ) :
													?>
												<option value="<?php echo esc_attr( $code ); ?>" <?php selected( $ed_country, $code ); ?>><?php echo esc_html( $name ); ?></option>
												<?php endforeach; ?>
											</select>
											<span class="select-arrow"></span>
										</div>
										<?php if ( ! empty( $field_errors[ $err_country ] ) ) : ?><span class="field-error"><?php echo esc_html( $field_errors[ $err_country ] ); ?></span><?php endif; ?>
									</li>
									<?php $err_gpa = 'profile_education_' . $ei . '_gpa'; ?>
									<li class="<?php echo ! empty( $field_errors[ $err_gpa ] ) ? 'has-error' : ''; ?>"><input class="input" type="text" name="profile_education[<?php echo (int) $ei; ?>][gpa]" placeholder="<?php esc_attr_e( 'GPA *', 'tasheel' ); ?>" value="<?php echo esc_attr( isset( $ed['gpa'] ) ? $ed['gpa'] : '' ); ?>" required><?php if ( ! empty( $field_errors[ $err_gpa ] ) ) : ?><span class="field-error"><?php echo esc_html( $field_errors[ $err_gpa ] ); ?></span><?php endif; ?></li>
									<?php $err_avg = 'profile_education_' . $ei . '_avg_grade'; ?>
									<li class="<?php echo ! empty( $field_errors[ $err_avg ] ) ? 'has-error' : ''; ?>"><input class="input" type="text" name="profile_education[<?php echo (int) $ei; ?>][avg_grade]" placeholder="<?php esc_attr_e( 'Average Grade *', 'tasheel' ); ?>" value="<?php echo esc_attr( isset( $ed['avg_grade'] ) ? $ed['avg_grade'] : '' ); ?>" required><?php if ( ! empty( $field_errors[ $err_avg ] ) ) : ?><span class="field-error"><?php echo esc_html( $field_errors[ $err_avg ] ); ?></span><?php endif; ?></li>
									<?php $err_mode = 'profile_education_' . $ei . '_mode'; ?>
									<li class="<?php echo ! empty( $field_errors[ $err_mode ] ) ? 'has-error' : ''; ?>">
										<div class="select-wrapper">
											<select class="input select-input" name="profile_education[<?php echo (int) $ei; ?>][mode]" required>
												<option value=""><?php esc_html_e( 'What was the mode of study? *', 'tasheel' ); ?></option>
												<option value="full-time" <?php selected( isset( $ed['mode'] ) ? $ed['mode'] : '', 'full-time' ); ?>><?php esc_html_e( 'Full-time', 'tasheel' ); ?></option>
												<option value="part-time" <?php selected( isset( $ed['mode'] ) ? $ed['mode'] : '', 'part-time' ); ?>><?php esc_html_e( 'Part-time', 'tasheel' ); ?></option>
												<option value="online" <?php selected( isset( $ed['mode'] ) ? $ed['mode'] : '', 'online' ); ?>><?php esc_html_e( 'Online', 'tasheel' ); ?></option>
											</select>
											<span class="select-arrow"></span>
										</div>
										<?php if ( ! empty( $field_errors[ $err_mode ] ) ) : ?><span class="field-error"><?php echo esc_html( $field_errors[ $err_mode ] ); ?></span><?php endif; ?>
									</li>
								</ul>
								<div class="education-checkbox-wrapper">
									<label class="education-checkbox-label">
										<input type="checkbox" name="profile_education[<?php echo (int) $ei; ?>][under_process]" class="education-checkbox" value="1" <?php checked( ! empty( $ed['under_process'] ) ); ?>>
										<span class="checkbox-text"><?php esc_html_e( 'Under Process', 'tasheel' ); ?></span>
									</label>
								</div>
								<?php if ( $ei > 0 ) : ?>
								<div class="block-actions mt_10">
									<button type="button" class="js-remove-education btn-remove-block btn-remove-block-icon" aria-label="<?php esc_attr_e( 'Remove education', 'tasheel' ); ?>"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></button>
								</div>
								<?php endif; ?>
							</div>
							<?php endforeach; ?>
						</div>
						<div class="education-buttons-wrapper">
							<button type="button" class="max-w-but btn_style btn_add_more_education"><?php esc_html_e( 'Add More Education', 'tasheel' ); ?></button>
						</div>
					</div>
					<?php endif; ?>

					<?php if ( $edit_sections === null || in_array( 'experience', $edit_sections, true ) ) : ?>
					<?php
					$has_experience = isset( $profile_data['profile_has_experience'] ) ? $profile_data['profile_has_experience'] : '';
					$exp_has_data = ! empty( $profile_data['profile_experience'] );
					$has_exp_checked = ( $has_experience === '1' || $has_experience === 'yes' || ( $has_experience !== '0' && $exp_has_data ) );
					?>
					<div class="form-group js-experience-group<?php echo ! empty( $field_errors['profile_experience'] ) ? ' has-error' : ''; ?>">
						<div class="related_jobs_section_content">
							<h5><?php esc_html_e( 'Experience', 'tasheel' ); ?></h5>
							<div class="education-checkbox-wrapper" style="margin-bottom: 16px;">
								<label class="education-checkbox-label">
									<input type="checkbox" id="profile_has_experience" class="education-checkbox js-has-experience-toggle" value="1" <?php checked( $has_exp_checked ); ?>>
									<span class="checkbox-text"><?php esc_html_e( 'I have work experience', 'tasheel' ); ?></span>
								</label>
							</div>
							<input type="hidden" name="profile_has_experience" id="profile_has_experience_input" value="<?php echo $has_exp_checked ? '1' : '0'; ?>">
						</div>
						<div class="js-experience-fields-wrapper" style="<?php echo $has_exp_checked ? '' : 'display: none;'; ?>">
						<div class="related_jobs_section_content" style="margin-top: 0;">
							<p><?php esc_html_e( 'Please provide details about your work experience.', 'tasheel' ); ?></p>
						</div>
						<div class="js-experience-blocks" data-additional-hint="<?php echo esc_attr( __( 'Enter details for this additional experience entry.', 'tasheel' ) ); ?>">
							<?php foreach ( $exp_list as $xi => $ex ) : $ex = is_array( $ex ) ? $ex : array(); ?>
							<div class="js-experience-block experience-block" data-index="<?php echo (int) $xi; ?>">
								<?php if ( $xi > 0 ) : ?><p class="form-block-hint" style="margin-bottom: 10px; color: #555; font-size: 0.95em;"><?php esc_html_e( 'Enter details for this additional experience entry.', 'tasheel' ); ?></p><?php endif; ?>
								<?php if ( $xi > 0 ) : ?><div class="experience-block-divider"></div><?php endif; ?>
								<ul class="career-form-list-ul form-col-2">
									<?php $err_employer = 'profile_experience_' . $xi . '_employer'; ?>
									<li class="<?php echo ! empty( $field_errors[ $err_employer ] ) ? 'has-error' : ''; ?>"><input class="input" type="text" name="profile_experience[<?php echo (int) $xi; ?>][employer]" placeholder="<?php esc_attr_e( 'Employer Name *', 'tasheel' ); ?>" value="<?php echo esc_attr( isset( $ex['employer'] ) ? $ex['employer'] : '' ); ?>"<?php echo $has_exp_checked ? ' required' : ''; ?>><?php if ( ! empty( $field_errors[ $err_employer ] ) ) : ?><span class="field-error"><?php echo esc_html( $field_errors[ $err_employer ] ); ?></span><?php endif; ?></li>
									<?php $err_job = 'profile_experience_' . $xi . '_job_title'; ?>
									<li class="<?php echo ! empty( $field_errors[ $err_job ] ) ? 'has-error' : ''; ?>"><input class="input" type="text" name="profile_experience[<?php echo (int) $xi; ?>][job_title]" placeholder="<?php esc_attr_e( 'Job Title *', 'tasheel' ); ?>" value="<?php echo esc_attr( isset( $ex['job_title'] ) ? $ex['job_title'] : '' ); ?>"<?php echo $has_exp_checked ? ' required' : ''; ?>><?php if ( ! empty( $field_errors[ $err_job ] ) ) : ?><span class="field-error"><?php echo esc_html( $field_errors[ $err_job ] ); ?></span><?php endif; ?></li>
									<?php $err_start = 'profile_experience_' . $xi . '_start_date'; ?>
									<li class="<?php echo ! empty( $field_errors[ $err_start ] ) ? 'has-error' : ''; ?>"><div class="select-wrapper date-input-wrapper"><input class="input date-input career-date-start" type="date" name="profile_experience[<?php echo (int) $xi; ?>][start_date]" placeholder="<?php esc_attr_e( 'Start Date *', 'tasheel' ); ?>" value="<?php echo esc_attr( isset( $ex['start_date'] ) ? $ex['start_date'] : '' ); ?>" max="<?php echo esc_attr( date( 'Y-m-d' ) ); ?>"<?php echo $has_exp_checked ? ' required' : ''; ?>></div><?php if ( ! empty( $field_errors[ $err_start ] ) ) : ?><span class="field-error"><?php echo esc_html( $field_errors[ $err_start ] ); ?></span><?php endif; ?></li>
									<?php $err_end = 'profile_experience_' . $xi . '_end_date'; ?>
									<li class="<?php echo ! empty( $field_errors[ $err_end ] ) ? 'has-error' : ''; ?>"><div class="select-wrapper date-input-wrapper"><input class="input date-input career-date-end" type="date" name="profile_experience[<?php echo (int) $xi; ?>][end_date]" placeholder="<?php esc_attr_e( 'End Date *', 'tasheel' ); ?>" value="<?php echo esc_attr( isset( $ex['end_date'] ) ? $ex['end_date'] : '' ); ?>"<?php echo $has_exp_checked ? ' required' : ''; ?>></div><?php if ( ! empty( $field_errors[ $err_end ] ) ) : ?><span class="field-error"><?php echo esc_html( $field_errors[ $err_end ] ); ?></span><?php endif; ?></li>
									<?php $err_country = 'profile_experience_' . $xi . '_country'; ?>
									<li class="<?php echo ! empty( $field_errors[ $err_country ] ) ? 'has-error' : ''; ?>">
										<div class="select-wrapper">
											<select class="input select-input" name="profile_experience[<?php echo (int) $xi; ?>][country]"<?php echo $has_exp_checked ? ' required' : ''; ?>>
												<option value=""><?php esc_html_e( 'Country *', 'tasheel' ); ?></option>
												<?php
												$countries = function_exists( 'tasheel_hr_get_countries' ) ? tasheel_hr_get_countries() : array();
												$ex_country = isset( $ex['country'] ) ? $ex['country'] : '';
												foreach ( $countries as $code => $name ) :
													?>
												<option value="<?php echo esc_attr( $code ); ?>" <?php selected( $ex_country, $code ); ?>><?php echo esc_html( $name ); ?></option>
												<?php endforeach; ?>
											</select>
											<span class="select-arrow"></span>
										</div>
										<?php if ( ! empty( $field_errors[ $err_country ] ) ) : ?><span class="field-error"><?php echo esc_html( $field_errors[ $err_country ] ); ?></span><?php endif; ?>
									</li>
									<?php $err_years = 'profile_experience_' . $xi . '_years'; ?>
									<li class="<?php echo ! empty( $field_errors[ $err_years ] ) ? 'has-error' : ''; ?>"><input class="input" type="text" name="profile_experience[<?php echo (int) $xi; ?>][years]" placeholder="<?php esc_attr_e( 'Years of Experience *', 'tasheel' ); ?>" value="<?php echo esc_attr( isset( $ex['years'] ) ? $ex['years'] : '' ); ?>"<?php echo $has_exp_checked ? ' required' : ''; ?>><?php if ( ! empty( $field_errors[ $err_years ] ) ) : ?><span class="field-error"><?php echo esc_html( $field_errors[ $err_years ] ); ?></span><?php endif; ?></li>
									<?php $err_sal = 'profile_experience_' . $xi . '_salary'; ?>
									<li class="<?php echo ! empty( $field_errors[ $err_sal ] ) ? 'has-error' : ''; ?>"><input class="input" type="text" name="profile_experience[<?php echo (int) $xi; ?>][salary]" placeholder="<?php esc_attr_e( 'Salary *', 'tasheel' ); ?>" value="<?php echo esc_attr( isset( $ex['salary'] ) ? $ex['salary'] : '' ); ?>"<?php echo $has_exp_checked ? ' required' : ''; ?>><?php if ( ! empty( $field_errors[ $err_sal ] ) ) : ?><span class="field-error"><?php echo esc_html( $field_errors[ $err_sal ] ); ?></span><?php endif; ?></li>
									<?php $err_ben = 'profile_experience_' . $xi . '_benefits'; ?>
									<li class="<?php echo ! empty( $field_errors[ $err_ben ] ) ? 'has-error' : ''; ?>"><input class="input" type="text" name="profile_experience[<?php echo (int) $xi; ?>][benefits]" placeholder="<?php esc_attr_e( 'Benefits *', 'tasheel' ); ?>" value="<?php echo esc_attr( isset( $ex['benefits'] ) ? $ex['benefits'] : '' ); ?>"<?php echo $has_exp_checked ? ' required' : ''; ?>><?php if ( ! empty( $field_errors[ $err_ben ] ) ) : ?><span class="field-error"><?php echo esc_html( $field_errors[ $err_ben ] ); ?></span><?php endif; ?></li>
								</ul>
								<div class="career-form-list-ul"><li><textarea class="input textarea-input" name="profile_experience[<?php echo (int) $xi; ?>][reason_leaving]" placeholder="<?php esc_attr_e( 'Reason for Leaving (optional)', 'tasheel' ); ?>" rows="4"><?php echo esc_textarea( isset( $ex['reason_leaving'] ) ? $ex['reason_leaving'] : '' ); ?></textarea></li></div>
								<div class="education-checkbox-wrapper">
									<label class="education-checkbox-label">
										<input type="checkbox" name="profile_experience[<?php echo (int) $xi; ?>][current_job]" class="education-checkbox" value="1" <?php checked( ! empty( $ex['current_job'] ) ); ?>>
										<span class="checkbox-text"><?php esc_html_e( 'Current Job', 'tasheel' ); ?></span>
									</label>
								</div>
								<?php if ( $xi > 0 ) : ?>
								<div class="block-actions mt_10">
									<button type="button" class="js-remove-experience btn-remove-block btn-remove-block-icon" aria-label="<?php esc_attr_e( 'Remove experience', 'tasheel' ); ?>"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></button>
								</div>
								<?php endif; ?>
							</div>
							<?php endforeach; ?>
						</div>
						<div class="education-buttons-wrapper">
							<button type="button" class="max-w-but btn_style btn_add_more_experience"><?php esc_html_e( 'Add More Experience', 'tasheel' ); ?></button>
						</div>
						</div>
					</div>
					<?php endif; ?>

					<?php if ( $edit_sections === null || in_array( 'saudi_council', $edit_sections, true ) ) : ?>
					<div class="form-group<?php echo ! empty( $field_errors['profile_saudi_council'] ) ? ' has-error' : ''; ?>" id="saudi-council-container">
						<div class="saudi-council-section">
							<h5 class="saudi-council-title"><?php esc_html_e( 'Saudi Council Classification', 'tasheel' ); ?></h5>
							<p class="file-upload-hint file-type-hint-under-heading" style="margin:4px 0 12px 0;font-size:12px;color:#666;"><?php esc_html_e( 'File upload: PDF, DOC, DOCX, JPG, PNG. Max 5MB.', 'tasheel' ); ?></p>
							<p class="section-error" id="saudi-council-section-error" role="alert"<?php echo empty( $field_errors['profile_saudi_council'] ) ? ' style="display: none;"' : ''; ?>><?php echo ! empty( $field_errors['profile_saudi_council'] ) ? esc_html( $field_errors['profile_saudi_council'] ) : ''; ?></p>
							<?php
							$existing_saudi = isset( $profile_data['profile_saudi_council'] ) ? $profile_data['profile_saudi_council'] : '';
							$saudi_filename = $existing_saudi ? basename( wp_parse_url( $existing_saudi, PHP_URL_PATH ) ) : '';
							?>
							<?php if ( $existing_saudi && $saudi_filename ) : ?>
							<div class="existing-file-display saudi-council-existing" data-field="saudi">
								<a href="<?php echo esc_url( $existing_saudi ); ?>" target="_blank" rel="noopener"><?php echo esc_html( $saudi_filename ); ?></a>
								<button type="button" class="btn-remove-file" data-field="saudi" aria-label="<?php esc_attr_e( 'Remove Saudi Council document', 'tasheel' ); ?>">×</button>
								<input type="hidden" name="remove_profile_saudi_council" id="remove_profile_saudi_council" value="0">
							</div>
							<?php endif; ?>
							<div class="saudi-council-upload-wrapper">
								<div class="mob_Show placeholder_mob_show">
									<p class="m_0"><?php esc_html_e( 'Saudi Council Classification Certificate (شهادة هيئة المهندسين السعوديين)', 'tasheel' ); ?></p>
								</div>
								<div class="saudi-council-input-wrapper mobile_hide">
									<input type="text" class="input saudi-council-input" placeholder="<?php esc_attr_e( 'Saudi Council Classification Certificate (شهادة هيئة المهندسين السعوديين)', 'tasheel' ); ?>" readonly>
								</div>
								<div class="saudi-council-button-wrapper">
									<input type="file" id="saudi-council-upload" name="saudi_council_certificate" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" class="file-input-hidden">
									<label for="saudi-council-upload" class="saudi-council-attach-btn"><?php esc_html_e( 'Attach Copy', 'tasheel' ); ?></label>
								</div>
							</div>
						</div>
					</div>
					<?php endif; ?>

					<?php if ( $edit_sections === null || in_array( 'additional_info', $edit_sections, true ) ) : ?>
					<div class="form-group">
						<div class="related_jobs_section_content">
							<h5><?php esc_html_e( 'Additional Information *', 'tasheel' ); ?></h5>
						</div>

						<ul class="career-form-list-ul form-col-2">
							<li class="<?php echo ! empty( $field_errors['profile_years_experience'] ) ? 'has-error' : ''; ?>">
								<input class="input" type="text" name="profile_years_experience" placeholder="<?php esc_attr_e( 'Years of Experience *', 'tasheel' ); ?>" value="<?php echo esc_attr( isset( $profile_data['profile_years_experience'] ) ? $profile_data['profile_years_experience'] : '' ); ?>" required>
								<?php if ( ! empty( $field_errors['profile_years_experience'] ) ) : ?><span class="field-error"><?php echo esc_html( $field_errors['profile_years_experience'] ); ?></span><?php endif; ?>
							</li>
							<li class="<?php echo ! empty( $field_errors['profile_specialization'] ) ? 'has-error' : ''; ?>">
								<div class="select-wrapper">
									<select class="input select-input" name="profile_specialization" required>
										<?php
										$spec_opts = function_exists( 'tasheel_hr_specialization_options' ) ? tasheel_hr_specialization_options() : array( '' => __( 'Specialization *', 'tasheel' ) );
										$current_spec = isset( $profile_data['profile_specialization'] ) ? $profile_data['profile_specialization'] : '';
										foreach ( $spec_opts as $val => $label ) :
											?>
										<option value="<?php echo esc_attr( $val ); ?>" <?php selected( $current_spec, $val ); ?>><?php echo esc_html( $label ); ?></option>
										<?php endforeach; ?>
									</select>
									<span class="select-arrow"></span>
								</div>
								<?php if ( ! empty( $field_errors['profile_specialization'] ) ) : ?><span class="field-error"><?php echo esc_html( $field_errors['profile_specialization'] ); ?></span><?php endif; ?>
							</li>
							<li class="<?php echo ! empty( $field_errors['profile_notice_period'] ) ? 'has-error' : ''; ?>">
								<input class="input" type="text" name="profile_notice_period" placeholder="<?php esc_attr_e( 'Notice Period *', 'tasheel' ); ?>" value="<?php echo esc_attr( isset( $profile_data['profile_notice_period'] ) ? $profile_data['profile_notice_period'] : '' ); ?>" required>
								<?php if ( ! empty( $field_errors['profile_notice_period'] ) ) : ?><span class="field-error"><?php echo esc_html( $field_errors['profile_notice_period'] ); ?></span><?php endif; ?>
							</li>
							<li class="<?php echo ! empty( $field_errors['profile_current_salary'] ) ? 'has-error' : ''; ?>">
								<div class="select-wrapper">
									<select class="input select-input" name="profile_current_salary" required>
										<option value=""><?php esc_html_e( 'Current Salary *', 'tasheel' ); ?></option>
										<option value="0-5000" <?php selected( isset( $profile_data['profile_current_salary'] ) ? $profile_data['profile_current_salary'] : '', '0-5000' ); ?>>0 - 5,000 SAR</option>
										<option value="5000-10000" <?php selected( isset( $profile_data['profile_current_salary'] ) ? $profile_data['profile_current_salary'] : '', '5000-10000' ); ?>>5,000 - 10,000 SAR</option>
										<option value="10000-15000" <?php selected( isset( $profile_data['profile_current_salary'] ) ? $profile_data['profile_current_salary'] : '', '10000-15000' ); ?>>10,000 - 15,000 SAR</option>
										<option value="15000+" <?php selected( isset( $profile_data['profile_current_salary'] ) ? $profile_data['profile_current_salary'] : '', '15000+' ); ?>>15,000+ SAR</option>
									</select>
									<span class="select-arrow"></span>
								</div>
								<?php if ( ! empty( $field_errors['profile_current_salary'] ) ) : ?><span class="field-error"><?php echo esc_html( $field_errors['profile_current_salary'] ); ?></span><?php endif; ?>
							</li>
							<li class="<?php echo ! empty( $field_errors['profile_expected_salary'] ) ? 'has-error' : ''; ?>">
								<div class="select-wrapper">
									<select class="input select-input" name="profile_expected_salary" required>
										<option value=""><?php esc_html_e( 'Expected Salary *', 'tasheel' ); ?></option>
										<option value="0-5000" <?php selected( isset( $profile_data['profile_expected_salary'] ) ? $profile_data['profile_expected_salary'] : '', '0-5000' ); ?>>0 - 5,000 SAR</option>
										<option value="5000-10000" <?php selected( isset( $profile_data['profile_expected_salary'] ) ? $profile_data['profile_expected_salary'] : '', '5000-10000' ); ?>>5,000 - 10,000 SAR</option>
										<option value="10000-15000" <?php selected( isset( $profile_data['profile_expected_salary'] ) ? $profile_data['profile_expected_salary'] : '', '10000-15000' ); ?>>10,000 - 15,000 SAR</option>
										<option value="15000+" <?php selected( isset( $profile_data['profile_expected_salary'] ) ? $profile_data['profile_expected_salary'] : '', '15000+' ); ?>>15,000+ SAR</option>
									</select>
									<span class="select-arrow"></span>
								</div>
								<?php if ( ! empty( $field_errors['profile_expected_salary'] ) ) : ?><span class="field-error"><?php echo esc_html( $field_errors['profile_expected_salary'] ); ?></span><?php endif; ?>
							</li>
							<li class="<?php echo ! empty( $field_errors['profile_visa_status'] ) ? 'has-error' : ''; ?>">
								<div class="select-wrapper">
									<select class="input select-input" name="profile_visa_status" required>
										<option value=""><?php esc_html_e( 'Visa Status *', 'tasheel' ); ?></option>
										<?php
										$visa_val = isset( $profile_data['profile_visa_status'] ) ? $profile_data['profile_visa_status'] : '';
										$visa_opts = function_exists( 'tasheel_hr_visa_status_options' ) ? tasheel_hr_visa_status_options() : array( 'has_visa' => __( 'Has Visa / Residency', 'tasheel' ), 'no_visa' => __( 'No Visa', 'tasheel' ) );
										foreach ( $visa_opts as $v => $label ) :
											?>
											<option value="<?php echo esc_attr( $v ); ?>" <?php selected( $visa_val, $v ); ?>><?php echo esc_html( $label ); ?></option>
										<?php endforeach; ?>
									</select>
									<span class="select-arrow"></span>
								</div>
								<?php if ( ! empty( $field_errors['profile_visa_status'] ) ) : ?><span class="field-error"><?php echo esc_html( $field_errors['profile_visa_status'] ); ?></span><?php endif; ?>
							</li>
						</ul>
					</div>
					<?php endif; ?>

					<?php if ( $edit_sections === null || in_array( 'employment_history', $edit_sections, true ) ) : ?>
					<div class="form-group">
						<div class="related_jobs_section_content">
							<h5><?php esc_html_e( 'Employment History at Saud Consult *', 'tasheel' ); ?></h5>
						</div>
						<?php
						$emp_errors = array();
						foreach ( array( 'profile_currently_employed', 'profile_employee_id', 'profile_current_project', 'profile_current_department', 'profile_previously_worked', 'profile_previous_duration', 'profile_last_project', 'profile_previous_department' ) as $ek ) {
							if ( ! empty( $field_errors[ $ek ] ) ) {
								$emp_errors[] = $field_errors[ $ek ];
							}
						}
						if ( ! empty( $emp_errors ) ) :
							?>
							<p class="section-error"><?php echo esc_html( implode( ' ', array_unique( $emp_errors ) ) ); ?></p>
						<?php endif; ?>

						<?php
						$curr_emp = isset( $profile_data['profile_currently_employed'] ) ? $profile_data['profile_currently_employed'] : 'yes';
						$prev_work = isset( $profile_data['profile_previously_worked'] ) ? $profile_data['profile_previously_worked'] : 'no';
						?>
						<!-- Section 1: Currently employed -->
						<div class="employment-section mt_20">
							<div class="career-form-list-ul form-col-2">
								<li>
									<div class="employment-question">
										<label class="employment-question-label"><?php esc_html_e( 'Currently employed at Saud Consult? *', 'tasheel' ); ?></label>
										<div class="yes-no-checkboxes">
											<label class="yes-no-checkbox-label">
												<input type="radio" name="profile_currently_employed" value="yes" class="yes-no-checkbox js-currently-employed-radio" <?php checked( $curr_emp, 'yes' ); ?>>
												<span class="checkbox-text"><?php esc_html_e( 'Yes', 'tasheel' ); ?></span>
											</label>
											<label class="yes-no-checkbox-label">
												<input type="radio" name="profile_currently_employed" value="no" class="yes-no-checkbox js-currently-employed-radio" <?php checked( $curr_emp, 'no' ); ?>>
												<span class="checkbox-text"><?php esc_html_e( 'No', 'tasheel' ); ?></span>
											</label>
										</div>
									</div>
								</li>
							</div>
							<div class="employment-currently-employed-fields js-currently-employed-fields" style="<?php echo $curr_emp !== 'yes' ? 'display:none;' : ''; ?>">
								<ul class="career-form-list-ul form-col-2">
									<li>
										<input class="input" type="text" name="profile_employee_id" placeholder="<?php esc_attr_e( 'Employee ID *', 'tasheel' ); ?>" value="<?php echo esc_attr( isset( $profile_data['profile_employee_id'] ) ? $profile_data['profile_employee_id'] : '' ); ?>" data-required="1"<?php echo $curr_emp === 'yes' ? ' required' : ''; ?>>
									</li>
									<li>
										<input class="input" type="text" name="profile_current_project" placeholder="<?php esc_attr_e( 'Current Project *', 'tasheel' ); ?>" value="<?php echo esc_attr( isset( $profile_data['profile_current_project'] ) ? $profile_data['profile_current_project'] : '' ); ?>" data-required="1"<?php echo $curr_emp === 'yes' ? ' required' : ''; ?>>
									</li>
									<li>
										<div class="select-wrapper">
											<select class="input select-input" name="profile_current_department" data-required="1"<?php echo $curr_emp === 'yes' ? ' required' : ''; ?>>
												<option value=""><?php esc_html_e( 'Department *', 'tasheel' ); ?></option>
												<option value="engineering" <?php selected( isset( $profile_data['profile_current_department'] ) ? $profile_data['profile_current_department'] : '', 'engineering' ); ?>><?php esc_html_e( 'Engineering', 'tasheel' ); ?></option>
												<option value="design" <?php selected( isset( $profile_data['profile_current_department'] ) ? $profile_data['profile_current_department'] : '', 'design' ); ?>><?php esc_html_e( 'Design', 'tasheel' ); ?></option>
												<option value="management" <?php selected( isset( $profile_data['profile_current_department'] ) ? $profile_data['profile_current_department'] : '', 'management' ); ?>><?php esc_html_e( 'Management', 'tasheel' ); ?></option>
											</select>
											<span class="select-arrow"></span>
										</div>
									</li>
								</ul>
							</div>
						</div>

						<!-- Section 2: Previously worked -->
						<div class="employment-section">
							<div class="career-form-list-ul form-col-2">
								<li>
									<div class="employment-question">
										<label class="employment-question-label"><?php esc_html_e( 'Previously worked at Saud Consult? *', 'tasheel' ); ?></label>
										<div class="yes-no-checkboxes">
											<label class="yes-no-checkbox-label">
												<input type="radio" name="profile_previously_worked" value="yes" class="yes-no-checkbox js-previously-worked-radio" <?php checked( $prev_work, 'yes' ); ?>>
												<span class="checkbox-text"><?php esc_html_e( 'Yes', 'tasheel' ); ?></span>
											</label>
											<label class="yes-no-checkbox-label">
												<input type="radio" name="profile_previously_worked" value="no" class="yes-no-checkbox js-previously-worked-radio" <?php checked( $prev_work, 'no' ); ?>>
												<span class="checkbox-text"><?php esc_html_e( 'No', 'tasheel' ); ?></span>
											</label>
										</div>
									</div>
								</li>
							</div>
							<div class="employment-previously-worked-fields js-previously-worked-fields" style="<?php echo $prev_work !== 'yes' ? 'display:none;' : ''; ?>">
								<ul class="career-form-list-ul form-col-2">
									<li>
										<input class="input" type="text" name="profile_previous_duration" placeholder="<?php esc_attr_e( 'Duration *', 'tasheel' ); ?>" value="<?php echo esc_attr( isset( $profile_data['profile_previous_duration'] ) ? $profile_data['profile_previous_duration'] : '' ); ?>" data-required="1"<?php echo $prev_work === 'yes' ? ' required' : ''; ?>>
									</li>
									<li>
										<input class="input" type="text" name="profile_last_project" placeholder="<?php esc_attr_e( 'Last Project *', 'tasheel' ); ?>" value="<?php echo esc_attr( isset( $profile_data['profile_last_project'] ) ? $profile_data['profile_last_project'] : '' ); ?>" data-required="1"<?php echo $prev_work === 'yes' ? ' required' : ''; ?>>
									</li>
									<li>
										<div class="select-wrapper">
											<select class="input select-input" name="profile_previous_department" data-required="1"<?php echo $prev_work === 'yes' ? ' required' : ''; ?>>
												<option value=""><?php esc_html_e( 'Department *', 'tasheel' ); ?></option>
												<option value="engineering" <?php selected( isset( $profile_data['profile_previous_department'] ) ? $profile_data['profile_previous_department'] : '', 'engineering' ); ?>><?php esc_html_e( 'Engineering', 'tasheel' ); ?></option>
												<option value="design" <?php selected( isset( $profile_data['profile_previous_department'] ) ? $profile_data['profile_previous_department'] : '', 'design' ); ?>><?php esc_html_e( 'Design', 'tasheel' ); ?></option>
												<option value="management" <?php selected( isset( $profile_data['profile_previous_department'] ) ? $profile_data['profile_previous_department'] : '', 'management' ); ?>><?php esc_html_e( 'Management', 'tasheel' ); ?></option>
											</select>
											<span class="select-arrow"></span>
										</div>
									</li>
								</ul>
							</div>
						</div>

						<!-- Section 3: Recent Projects experience (max 3) -->
						<div class="employment-section js-projects-group<?php echo ! empty( $field_errors['profile_recent_projects'] ) ? ' has-error' : ''; ?>">
							<div class="career-form-list-ul form-col-2">
								<li>
									<div class="employment-question">
										<label class="employment-question-label"><?php esc_html_e( 'Recent Projects experience *', 'tasheel' ); ?></label>
										<?php if ( ! empty( $field_errors['profile_recent_projects'] ) ) : ?><p class="section-error"><?php echo esc_html( $field_errors['profile_recent_projects'] ); ?></p><?php endif; ?>
									</div>
								</li>
							</div>
							<div class="js-projects-blocks" data-additional-hint="<?php echo esc_attr( __( 'Enter details for this additional project.', 'tasheel' ) ); ?>">
								<?php foreach ( $proj_list as $pi => $pr ) : $pr = is_array( $pr ) ? $pr : array(); ?>
								<div class="js-project-block project-block" data-index="<?php echo (int) $pi; ?>">
									<?php if ( $pi > 0 ) : ?><p class="form-block-hint" style="margin-bottom: 10px; color: #555; font-size: 0.95em;"><?php esc_html_e( 'Enter details for this additional project.', 'tasheel' ); ?></p><?php endif; ?>
									<?php if ( $pi > 0 ) : ?><div class="project-block-divider"></div><?php endif; ?>
									<ul class="career-form-list-ul form-col-2">
										<li><input class="input" type="text" name="profile_recent_projects[<?php echo (int) $pi; ?>][company]" placeholder="<?php esc_attr_e( 'Company Name *', 'tasheel' ); ?>" value="<?php echo esc_attr( isset( $pr['company'] ) ? $pr['company'] : '' ); ?>" required></li>
										<li><input class="input" type="text" name="profile_recent_projects[<?php echo (int) $pi; ?>][client]" placeholder="<?php esc_attr_e( 'Client Name *', 'tasheel' ); ?>" value="<?php echo esc_attr( isset( $pr['client'] ) ? $pr['client'] : '' ); ?>" required></li>
										<li>
											<div class="select-wrapper">
												<select class="input select-input" name="profile_recent_projects[<?php echo (int) $pi; ?>][period]" required>
													<option value=""><?php esc_html_e( 'Employment Period *', 'tasheel' ); ?></option>
													<option value="0-1" <?php selected( isset( $pr['period'] ) ? $pr['period'] : '', '0-1' ); ?>><?php esc_html_e( '0-1 years', 'tasheel' ); ?></option>
													<option value="1-3" <?php selected( isset( $pr['period'] ) ? $pr['period'] : '', '1-3' ); ?>><?php esc_html_e( '1-3 years', 'tasheel' ); ?></option>
													<option value="3-5" <?php selected( isset( $pr['period'] ) ? $pr['period'] : '', '3-5' ); ?>><?php esc_html_e( '3-5 years', 'tasheel' ); ?></option>
													<option value="5+" <?php selected( isset( $pr['period'] ) ? $pr['period'] : '', '5+' ); ?>><?php esc_html_e( '5+ years', 'tasheel' ); ?></option>
												</select>
												<span class="select-arrow"></span>
											</div>
										</li>
										<li>
											<div class="select-wrapper">
												<select class="input select-input" name="profile_recent_projects[<?php echo (int) $pi; ?>][position]" required>
													<option value=""><?php esc_html_e( 'Position *', 'tasheel' ); ?></option>
													<option value="engineer" <?php selected( isset( $pr['position'] ) ? $pr['position'] : '', 'engineer' ); ?>><?php esc_html_e( 'Engineer', 'tasheel' ); ?></option>
													<option value="senior-engineer" <?php selected( isset( $pr['position'] ) ? $pr['position'] : '', 'senior-engineer' ); ?>><?php esc_html_e( 'Senior Engineer', 'tasheel' ); ?></option>
													<option value="manager" <?php selected( isset( $pr['position'] ) ? $pr['position'] : '', 'manager' ); ?>><?php esc_html_e( 'Manager', 'tasheel' ); ?></option>
												</select>
												<span class="select-arrow"></span>
											</div>
										</li>
									</ul>
									<div class="career-form-list-ul">
										<li><textarea class="input textarea-input" name="profile_recent_projects[<?php echo (int) $pi; ?>][duties]" placeholder="<?php esc_attr_e( 'Duties & Responsibilities *', 'tasheel' ); ?>" rows="4" required><?php echo esc_textarea( isset( $pr['duties'] ) ? $pr['duties'] : '' ); ?></textarea></li>
									</div>
									<?php if ( $pi > 0 ) : ?>
									<div class="block-actions mt_10">
										<button type="button" class="js-remove-project btn-remove-block btn-remove-block-icon" aria-label="<?php esc_attr_e( 'Remove project', 'tasheel' ); ?>"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></button>
									</div>
									<?php endif; ?>
								</div>
								<?php endforeach; ?>
							</div>
							<div class="add-more-projects-link">
								<a href="#" class="add-more-link js-add-more-project"><?php esc_html_e( 'Add more projects', 'tasheel' ); ?></a>
							</div>
						</div>
					</div>
					<?php endif; ?>

					<div class="form-buttion-row flex-align-right">
						<button type="submit" class="btn_style btn_transparent but_black"><?php esc_html_e( 'Save Profile', 'tasheel' ); ?></button>
					</div>
					</form>
					<?php endif; // end else (not use_corporate_training_form) ?>
				</div>
			</div>
		</div>
	</section>

</main><!-- #main -->

<style>
.create-profile-form .portfolio-file-name { margin-top: 15px; font-size: 14px; color: #444; padding: 10px 15px; background: #fff; border-radius: 10px; border: 1px solid #e0e0e0; display: inline-block; }
</style>
<script>
(function() {
	var po = document.getElementById('portfolio-upload');
	var pf = document.querySelector('.portfolio-file-name');
	if (po && pf) {
		po.addEventListener('change', function() {
			var file = this.files[0];
			if (file) {
				var ok = /\.(pdf|doc|docx|jpg|jpeg|png)$/i.test(file.name);
				if (ok) {
					pf.textContent = file.name;
					pf.style.display = 'inline-block';
					var btn = document.querySelector('#portfolio-upload-container .resume-upload-button');
					if (btn) btn.textContent = '<?php echo esc_js( __( 'Replace portfolio (optional)', 'tasheel' ) ); ?>';
				} else {
					alert('<?php echo esc_js( __( 'Please select a PDF, Word document, or image (.pdf, .doc, .docx, .jpg, .jpeg, .png)', 'tasheel' ) ); ?>');
					this.value = '';
				}
			}
		});
	}
})();
</script>
<script>
(function() {
	function initEmploymentConditional() {
		var currRadios = document.querySelectorAll('.js-currently-employed-radio');
		var currFields = document.querySelector('.js-currently-employed-fields');
		var prevRadios = document.querySelectorAll('.js-previously-worked-radio');
		var prevFields = document.querySelector('.js-previously-worked-fields');
		function setDisabled(container, disabled) {
			if (!container) return;
			var inputs = container.querySelectorAll('input, select, textarea');
			inputs.forEach(function(inp) {
				inp.disabled = disabled;
				if (disabled) inp.removeAttribute('required'); else if (inp.getAttribute('data-required')) inp.setAttribute('required', '');
				if (inp.tagName === 'SELECT') {
					var sumoWrap = inp.closest('.SumoSelect');
					if (sumoWrap) {
						if (disabled) sumoWrap.classList.add('disabled'); else sumoWrap.classList.remove('disabled');
					}
				}
			});
		}
		function updateCurrently() {
			var yes = document.querySelector('.js-currently-employed-radio[value="yes"]');
			var show = yes && yes.checked;
			if (currFields) currFields.style.display = show ? '' : 'none';
			setDisabled(currFields, !show);
		}
		function updatePreviously() {
			var yes = document.querySelector('.js-previously-worked-radio[value="yes"]');
			var show = yes && yes.checked;
			if (prevFields) prevFields.style.display = show ? '' : 'none';
			setDisabled(prevFields, !show);
		}
		currRadios.forEach(function(r) { r.addEventListener('change', updateCurrently); });
		prevRadios.forEach(function(r) { r.addEventListener('change', updatePreviously); });
		updateCurrently();
		updatePreviously();
	}
	function initAddMoreBlocks() {
		var trashIconSvg = '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>';
		function ensureRemoveButton(clone, btnClass, ariaLabel) {
			if (clone.querySelector(btnClass)) return;
			var wrap = document.createElement('div');
			wrap.className = 'block-actions mt_10';
			var btn = document.createElement('button');
			btn.type = 'button';
			btn.className = btnClass.replace('.', '') + ' btn-remove-block btn-remove-block-icon';
			btn.setAttribute('aria-label', ariaLabel);
			btn.innerHTML = trashIconSvg;
			wrap.appendChild(btn);
			clone.appendChild(wrap);
		}
		function cloneAndRename(node, index) {
			var clone = node.cloneNode(true);
			clone.querySelectorAll('[name]').forEach(function(inp) {
				var name = inp.getAttribute('name');
				var m = name && name.match(/^([^\[]+)\[\d+\](.*)$/);
				if (m) {
					inp.setAttribute('name', m[1] + '[' + index + ']' + m[2]);
				}
				if (inp.type === 'checkbox') inp.checked = false;
				else if (inp.tagName === 'SELECT') { inp.selectedIndex = 0; }
				else inp.value = '';
			});
			clone.setAttribute('data-index', index);
			return clone;
		}
		function reindexBlocks(container, blockClass) {
			var blocks = container.querySelectorAll(blockClass);
			blocks.forEach(function(block, i) {
				block.setAttribute('data-index', i);
				block.querySelectorAll('[name]').forEach(function(inp) {
					var name = inp.getAttribute('name');
					var m = name && name.match(/^([^\[]+)\[\d+\](.*)$/);
					if (m) inp.setAttribute('name', m[1] + '[' + i + ']' + m[2]);
				});
			});
		}
		function setupRemoveHandler(selector, blockClass, containerSel, dividerClass) {
			document.addEventListener('click', function(e) {
				var btn = e.target.closest(selector);
				if (!btn) return;
				e.preventDefault();
				var block = btn.closest(blockClass);
				var container = document.querySelector(containerSel);
				if (!block || !container) return;
				var prev = block.previousElementSibling;
				if (prev && prev.classList.contains(dividerClass)) prev.remove();
				block.remove();
				reindexBlocks(container, blockClass);
			});
		}
		setupRemoveHandler('.js-remove-education', '.js-education-block', '.js-education-blocks', 'education-block-divider');
		setupRemoveHandler('.js-remove-experience', '.js-experience-block', '.js-experience-blocks', 'experience-block-divider');
		setupRemoveHandler('.js-remove-project', '.js-project-block', '.js-projects-blocks', 'project-block-divider');
		var hasExpToggle = document.getElementById('profile_has_experience');
		var hasExpInput = document.getElementById('profile_has_experience_input');
		var expFieldsWrap = document.querySelector('.js-experience-fields-wrapper');
		if (hasExpToggle && hasExpInput && expFieldsWrap) {
			hasExpToggle.addEventListener('change', function() {
				var val = this.checked ? '1' : '0';
				hasExpInput.value = val;
				expFieldsWrap.style.display = val === '1' ? '' : 'none';
				expFieldsWrap.querySelectorAll('input, select, textarea').forEach(function(el) { el.removeAttribute('required'); });
				if (val === '1') {
					expFieldsWrap.querySelectorAll('.js-experience-block').forEach(function(block, i) {
						block.querySelectorAll('input:not([name*="reason_leaving"]):not([name*="current_job"]), select').forEach(function(inp) { inp.setAttribute('required', 'required'); });
					});
				}
			});
		}
		document.addEventListener('click', function(e) {
			var btn = e.target.closest('.js-remove-project');
			if (!btn) return;
			var projLink = document.querySelector('.js-add-more-project');
			if (projLink) projLink.style.display = '';
		});
		var eduBtn = document.querySelector('.btn_add_more_education');
		var eduBlocks = document.querySelector('.js-education-blocks');
		if (eduBtn && eduBlocks) {
			eduBtn.addEventListener('click', function() {
				if (eduBtn.disabled) return;
				eduBtn.disabled = true;
				setTimeout(function() { eduBtn.disabled = false; }, 400);
				var last = eduBlocks.querySelector('.js-education-block:last-child');
				if (!last) return;
				var idx = eduBlocks.querySelectorAll('.js-education-block').length;
				var div = document.createElement('div');
				div.className = 'education-block-divider';
				eduBlocks.appendChild(div);
				var clone = cloneAndRename(last, idx);
				clone.querySelectorAll('.form-block-hint').forEach(function(h) { h.remove(); });
				ensureRemoveButton(clone, '.js-remove-education', 'Remove education');
				var hint = eduBlocks.getAttribute('data-additional-hint');
				if (hint) {
					var p = document.createElement('p');
					p.className = 'form-block-hint';
					p.style.marginBottom = '10px';
					p.style.color = '#555';
					p.style.fontSize = '0.95em';
					p.textContent = hint;
					clone.insertBefore(p, clone.firstChild);
				}
				eduBlocks.appendChild(clone);
			});
		}
		var expBtn = document.querySelector('.btn_add_more_experience');
		var expBlocks = document.querySelector('.js-experience-blocks');
		if (expBtn && expBlocks) {
			expBtn.addEventListener('click', function() {
				if (expBtn.disabled) return;
				expBtn.disabled = true;
				setTimeout(function() { expBtn.disabled = false; }, 400);
				var last = expBlocks.querySelector('.js-experience-block:last-child');
				if (!last) return;
				var idx = expBlocks.querySelectorAll('.js-experience-block').length;
				var div = document.createElement('div');
				div.className = 'experience-block-divider';
				expBlocks.appendChild(div);
				var clone = cloneAndRename(last, idx);
				clone.querySelectorAll('.form-block-hint').forEach(function(h) { h.remove(); });
				ensureRemoveButton(clone, '.js-remove-experience', 'Remove experience');
				var hint = expBlocks.getAttribute('data-additional-hint');
				if (hint) {
					var p = document.createElement('p');
					p.className = 'form-block-hint';
					p.style.marginBottom = '10px';
					p.style.color = '#555';
					p.style.fontSize = '0.95em';
					p.textContent = hint;
					clone.insertBefore(p, clone.firstChild);
				}
				expBlocks.appendChild(clone);
			});
		}
		var projLink = document.querySelector('.js-add-more-project');
		var projBlocks = document.querySelector('.js-projects-blocks');
		var MAX_PROJECTS = 3;
		if (projLink && projBlocks) {
			if (projBlocks.querySelectorAll('.js-project-block').length >= MAX_PROJECTS) {
				projLink.style.display = 'none';
			}
			projLink.addEventListener('click', function(e) {
				e.preventDefault();
				var count = projBlocks.querySelectorAll('.js-project-block').length;
				if (count >= MAX_PROJECTS) return;
				var last = projBlocks.querySelector('.js-project-block:last-child');
				if (!last) return;
				var idx = count;
				var div = document.createElement('div');
				div.className = 'project-block-divider';
				projBlocks.appendChild(div);
				var clone = cloneAndRename(last, idx);
				clone.querySelectorAll('.form-block-hint').forEach(function(h) { h.remove(); });
				ensureRemoveButton(clone, '.js-remove-project', 'Remove project');
				var hint = projBlocks.getAttribute('data-additional-hint');
				if (hint) {
					var p = document.createElement('p');
					p.className = 'form-block-hint';
					p.style.marginBottom = '10px';
					p.style.color = '#555';
					p.style.fontSize = '0.95em';
					p.textContent = hint;
					clone.insertBefore(p, clone.firstChild);
				}
				projBlocks.appendChild(clone);
				if (idx + 1 >= MAX_PROJECTS) projLink.style.display = 'none';
			});
		}
	}
		// Remove file buttons (resume, portfolio, saudi council, photo).
		document.addEventListener('click', function(e) {
			var btn = e.target.closest('.btn-remove-file');
			if (!btn) return;
			e.preventDefault();
			var display = btn.closest('.existing-file-display');
			if (!display) return;
			var removeInput = display.querySelector('input[name^="remove_profile_"]');
			if (removeInput) removeInput.value = '1';
			display.style.display = 'none';
		});

		// Photo preview: when user clicks the close icon (×) on the image, mark photo for removal.
		document.addEventListener('click', function(e) {
			var btn = e.target.closest('.file-remove-btn');
			if (!btn) return;
			var form = document.getElementById('create-profile-form');
			if (!form) return;
			var removeInput = form.querySelector('input[name="remove_profile_photo"]');
			if (removeInput) removeInput.value = '1';
			var photoWrap = btn.closest('.file-upload-section-wrapper');
			if (photoWrap) {
				photoWrap.setAttribute('data-has-existing-photo', '0');
				var preview = photoWrap.querySelector('.file-preview-container');
				var label = photoWrap.querySelector('.file-upload-label');
				var img = photoWrap.querySelector('.file-preview-image');
				if (preview) preview.style.display = 'none';
				if (label) label.style.display = '';
				if (img) img.src = '';
			}
		});

		function scrollToFirstError(form) {
			var first = form.querySelector('.has-error');
			if (first) {
				first.scrollIntoView({ behavior: 'smooth', block: 'center' });
			}
		}
		function initCreateProfileValidation() {
		var form = document.getElementById('create-profile-form');
		if (!form) return;
		var photoHintText = <?php echo wp_json_encode( __( 'Accepted: JPG, PNG. Max 1MB.', 'tasheel' ) ); ?>;
		form.querySelectorAll('.file-upload-hint-photo').forEach(function(p) { p.textContent = photoHintText; });
		var msgRequired = <?php echo wp_json_encode( __( 'This field is required.', 'tasheel' ) ); ?>;
		var requiredFieldMessages = <?php echo wp_json_encode( $required_field_messages ); ?>;
		<?php
		$phone_min_digits = function_exists( 'tasheel_hr_profile_phone_min_digits' ) ? tasheel_hr_profile_phone_min_digits() : 8;
		$phone_label = function_exists( 'tasheel_hr_profile_field_error_label' ) ? tasheel_hr_profile_field_error_label( 'profile_phone' ) : __( 'Phone', 'tasheel' );
		$phone_msg_min = $phone_label . ' ' . sprintf( /* translators: %d: minimum number of digits */ __( 'must be at least %d digits.', 'tasheel' ), $phone_min_digits );
		$phone_msg_required = function_exists( 'tasheel_hr_get_field_error_message' ) ? tasheel_hr_get_field_error_message( 'profile_phone', '', __( 'is required.', 'tasheel' ) ) : ( $phone_label . ' ' . __( 'is required.', 'tasheel' ) );
		?>
		var phoneMinDigits = <?php echo (int) $phone_min_digits; ?>;
		var phoneMsgMin = <?php echo wp_json_encode( $phone_msg_min ); ?>;
		var phoneMsgRequired = <?php echo wp_json_encode( $phone_msg_required ); ?>;
		var photoMsgExt = <?php echo wp_json_encode( __( 'Only PNG, JPG and JPEG images are allowed.', 'tasheel' ) ); ?>;
		var photoMsgSize = <?php echo wp_json_encode( __( 'Profile photo must be 1MB or less.', 'tasheel' ) ); ?>;
		var photoMaxBytes = 1024 * 1024; // 1MB
		var docMaxBytes = 5 * 1024 * 1024; // 5MB
		var msgInvalidUrl = <?php echo wp_json_encode( __( 'Please enter a valid URL.', 'tasheel' ) ); ?>;
		var msgFileTooLarge5MB = <?php echo wp_json_encode( __( 'File is too large. Please upload a file up to 5MB.', 'tasheel' ) ); ?>;
		var msgFileType5MB = <?php echo wp_json_encode( __( 'Please upload a file with allowed type (see below). Max 5MB.', 'tasheel' ) ); ?>;
		var docAllowedExts = { profile_resume: ['pdf','doc','docx'], profile_portfolio: ['pdf','doc','docx','jpg','jpeg','png'], saudi_council_certificate: ['pdf','doc','docx','jpg','jpeg','png'] };
		// On load: if page has validation errors (e.g. after server redirect), scroll to first error.
		if (window.location.search.indexOf('profile_error=missing') !== -1) {
			setTimeout(function() { scrollToFirstError(form); }, 100);
		}
		form.addEventListener('submit', function(e) {
			e.preventDefault();
			form.querySelectorAll('.field-error').forEach(function(span) { span.textContent = ''; if (span.id === 'profile-photo-field-error') span.style.display = 'none'; });
			form.querySelectorAll('.section-error').forEach(function(p) { p.textContent = ''; p.style.display = 'none'; });
			form.querySelectorAll('.has-error').forEach(function(el) { el.classList.remove('has-error'); });
			var summaryEl = document.getElementById('profile-ajax-error-summary');
			if (summaryEl) summaryEl.style.display = 'none';
			var invalid = [];
			form.querySelectorAll('input[required], select[required], textarea[required]').forEach(function(el) {
				if (el.getAttribute('readonly') !== null || el.type === 'hidden') return;
				if (el.disabled) return;
				var hidden = el.closest('[style*="display: none"]');
				if (hidden || (el.offsetParent === null && el.type !== 'hidden')) return;
				var val = (el.value || '').trim();
				if (el.type === 'checkbox' || el.type === 'radio') {
					var name = el.name;
					var group = form.elements[name];
					var list = group && (group.length != null ? [].slice.call(group) : [group]);
					var checked = list && list.some(function(r) { return r.checked; });
					if (!checked) invalid.push(el);
				} else if (val === '') {
					invalid.push(el);
				}
			});
			// Required file: profile photo (new upload or existing from server).
			var photoInput = form.querySelector('input[name="profile_photo"]');
			var removePhotoInput = form.querySelector('input[name="remove_profile_photo"]');
			var photoWrap = (photoInput && photoInput.closest('.file-upload-section-wrapper')) || form.querySelector('.file-upload-section-wrapper');
			var markedForRemoval = removePhotoInput && String(removePhotoInput.value).trim() === '1';
			var preview = photoWrap ? photoWrap.querySelector('.file-preview-container') : null;
			var previewVisible = preview && preview.style.display !== 'none';
			var hasExistingPhoto = photoWrap && photoWrap.getAttribute('data-has-existing-photo') === '1' && !markedForRemoval && previewVisible;
			var hasNewPhoto = photoInput && photoInput.files && photoInput.files.length > 0;
			var hasPhoto = hasNewPhoto || hasExistingPhoto;
			if (photoWrap && !hasPhoto) {
				var fake = document.createElement('input');
				fake.setAttribute('data-fake-for', 'profile_photo');
				fake._wrapper = photoWrap;
				fake._msg = requiredFieldMessages['profile_photo'] || msgRequired;
				invalid.push(fake);
			} else if (hasNewPhoto && photoWrap) {
				var file = photoInput.files[0];
				var ext = (file.name || '').split('.').pop().toLowerCase();
				var allowedExts = ['jpg', 'jpeg', 'png'];
				if (allowedExts.indexOf(ext) === -1) {
					invalid.push({ _wrapper: photoWrap, _msg: photoMsgExt });
				} else if (file.size > photoMaxBytes) {
					invalid.push({ _wrapper: photoWrap, _msg: photoMsgSize });
				}
			}
			// Required file: resume (new upload or existing display visible; support both main and corporate form)
			var resumeInput = form.querySelector('input[name="profile_resume"]');
			var existingResume = form.querySelector('.existing-file-display[data-field="resume"]');
			var existingResumeVisible = existingResume && (existingResume.offsetParent !== null || (existingResume.style && existingResume.style.display !== 'none'));
			var hasResume = (resumeInput && resumeInput.files && resumeInput.files.length > 0) || existingResumeVisible;
			var resumeWrap = form.querySelector('#resume-upload-container') || form.querySelector('#guest-resume-upload-container');
			if (!hasResume && resumeWrap) {
				var fakeResume = document.createElement('input');
				fakeResume.setAttribute('data-fake-for', 'profile_resume');
				fakeResume._wrapper = resumeWrap;
				fakeResume._msg = requiredFieldMessages['profile_resume'] || msgRequired;
				invalid.push(fakeResume);
			}
			// Phone: minimum digits (same rule as server; message matches backend).
			var phoneEl = form.querySelector('input[name="profile_phone"]');
			if (phoneEl) {
				var val = (phoneEl.value || '').trim();
				var digits = (val || '').replace(/\D/g, '');
				if (val !== '' && digits.length < phoneMinDigits) {
					var phoneWrap = phoneEl.closest('li') || phoneEl.closest('.form-group') || phoneEl.parentElement;
					invalid.push({ _wrapper: phoneWrap, _msg: phoneMsgMin });
				}
			}
			// LinkedIn / URL: only allow valid URL when non-empty.
			var linkedinEl = form.querySelector('input[name="profile_linkedin"]');
			if (linkedinEl) {
				var urlVal = (linkedinEl.value || '').trim();
				if (urlVal !== '') {
					try {
						var u = new URL(urlVal);
						if (!/^https?:$/i.test(u.protocol)) throw new Error('Invalid');
					} catch (err) {
						var linkedinWrap = linkedinEl.closest('li') || linkedinEl.closest('.form-group') || linkedinEl.parentElement;
						invalid.push({ _wrapper: linkedinWrap, _msg: msgInvalidUrl });
					}
				}
			}
			// Document files (resume, portfolio, saudi council): check size and type before submit so we don't show "Submitting..." for large files.
			['profile_resume', 'profile_portfolio', 'saudi_council_certificate'].forEach(function(name) {
				var input = form.querySelector('input[name="' + name + '"]');
				if (!input || !input.files || input.files.length === 0) return;
				var file = input.files[0];
				var ext = (file.name || '').split('.').pop().toLowerCase();
				var allowed = docAllowedExts[name];
				var wrap = input.closest('.resume-upload-wrapper') || input.closest('.saudi-council-upload-wrapper') || input.closest('li') || input.parentElement;
				if (allowed && allowed.indexOf(ext) === -1) {
					invalid.push({ _wrapper: wrap, _msg: msgFileType5MB });
				} else if (file.size > docMaxBytes) {
					invalid.push({ _wrapper: wrap, _msg: msgFileTooLarge5MB });
				}
			});
			if (invalid.length > 0) {
				// Show summary so user sees "Please fix the errors below." on first submit with empty form
				if (summaryEl) {
					document.querySelectorAll('.profile-error-summary').forEach(function(el) { el.style.display = 'none'; });
					summaryEl.textContent = <?php echo wp_json_encode( __( 'Please fix the errors below.', 'tasheel' ) ); ?>;
					summaryEl.style.display = 'block';
				}
				invalid.forEach(function(el) {
					var wrap = el._wrapper || el.closest('li') || el.closest('.select-wrapper') || el.closest('.date-input-wrapper') || el.parentElement;
					if (!wrap) return;
					wrap.classList.add('has-error');
					var sectionErr = wrap.querySelector('.section-error');
					var err = wrap.querySelector('.field-error');
					var msg = (el._msg !== undefined && el._msg !== null) ? el._msg : (el.getAttribute && el.getAttribute('data-required-msg'));
					if (!msg && el.name) {
						var key = el.name.replace(/\[/g, '_').replace(/\]/g, '');
						msg = requiredFieldMessages[key] || requiredFieldMessages[el.name];
					}
					msg = msg || msgRequired;
					if (sectionErr) {
						sectionErr.textContent = msg;
						sectionErr.style.display = 'block';
					}
					if (err) {
						err.textContent = msg;
						err.style.display = 'block';
					} else if (!sectionErr) {
						err = document.createElement('span');
						err.className = 'field-error';
						err.textContent = msg;
						err.style.display = 'block';
						wrap.appendChild(err);
					}
				});
				// Show profile photo required error (span is hidden by default with display:none)
				if (!hasPhoto && photoWrap) {
					var photoErr = photoWrap.querySelector('.field-error');
					if (photoErr) {
						photoErr.textContent = requiredFieldMessages['profile_photo'] || msgRequired;
						photoErr.removeAttribute('style');
					}
				}
				var firstInvalid = invalid[0];
				if (firstInvalid && firstInvalid._wrapper) {
					firstInvalid._wrapper.scrollIntoView({ behavior: 'smooth', block: 'center' });
				} else if (firstInvalid && firstInvalid.scrollIntoView) {
					firstInvalid.focus();
					firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
				} else {
					scrollToFirstError(form);
				}
				return;
			}
			var url = form.getAttribute('data-save-ajax-url');
			if (!url) return;
			var formData = new FormData(form);
			if (removePhotoInput && String(removePhotoInput.value).trim() === '1') {
				formData.set('remove_profile_photo', '1');
			}
			formData.append('action', 'tasheel_hr_save_profile_ajax');
			var submitBtn = form.querySelector('button[type="submit"]');
			var submittingText = <?php echo wp_json_encode( __( 'Submitting…', 'tasheel' ) ); ?>;
			if (submitBtn) {
				submitBtn.disabled = true;
				submitBtn.setAttribute('aria-busy', 'true');
				if (!submitBtn.dataset.originalText) submitBtn.dataset.originalText = submitBtn.textContent;
				submitBtn.textContent = submittingText;
			}
			function showOneError(msg) {
				document.querySelectorAll('.profile-error-summary').forEach(function(el) { el.style.display = 'none'; });
				if (summaryEl) { summaryEl.textContent = msg; summaryEl.style.display = 'block'; summaryEl.scrollIntoView({ behavior: 'smooth', block: 'center' }); }
			}
			fetch(url, { method: 'POST', body: formData, credentials: 'same-origin' })
				.then(function(r) {
					return r.text().then(function(text) {
						var res = null;
						try {
							res = text ? JSON.parse(text) : null;
						} catch (e) {}
						return { response: r, ok: r.ok, data: res, raw: text };
					});
				})
				.then(function(obj) {
					if (submitBtn) {
						submitBtn.disabled = false;
						submitBtn.removeAttribute('aria-busy');
						if (submitBtn.dataset.originalText) submitBtn.textContent = submitBtn.dataset.originalText;
					}
					var res = obj.data;
					if (!res || typeof res.success === 'undefined') {
						showOneError(<?php echo wp_json_encode( __( 'Server returned an invalid response. Please try again.', 'tasheel' ) ); ?>);
						return;
					}
					if (res.success && res.data && res.data.redirect) {
						window.location = res.data.redirect;
						return;
					}
					var data = res.data || {};
					if (res.success === false && data.code === 'missing' && data.field_errors) {
						showOneError(<?php echo wp_json_encode( __( 'Please fix the errors below.', 'tasheel' ) ); ?>);
						var sectionKeys = { profile_resume: ['#resume-upload-container', '#guest-resume-upload-container'], profile_saudi_council: ['#saudi-council-container'], profile_photo: ['.file-upload-section-wrapper'] };
						Object.keys(data.field_errors).forEach(function(key) {
							var msg = data.field_errors[key];
							var container = null;
							if (sectionKeys[key]) {
								for (var i = 0; i < sectionKeys[key].length; i++) {
									container = form.querySelector(sectionKeys[key][i]);
									if (container) break;
								}
							}
							if (!container && key.indexOf('profile_education_') === 0 && /^profile_education_\d+_.+$/.test(key)) {
								var rest = key.replace('profile_education_', '');
								var match = rest.match(/^(\d+)_(.+)$/);
								if (match) {
									var idx = match[1], sub = match[2];
									var block = form.querySelector('.js-education-block[data-index="' + idx + '"]');
									if (!block) {
										var blocks = form.querySelectorAll('.js-education-block');
										block = blocks[parseInt(idx, 10)];
									}
									if (block) {
										var needName = 'profile_education[' + idx + '][' + sub + ']';
										block.querySelectorAll('input, select').forEach(function(el) {
											if (el.getAttribute('name') === needName) {
												container = el.closest('li') || el.closest('.form-group') || el.parentElement;
											}
										});
									}
								}
							}
							if (!container && key.indexOf('profile_experience_') === 0 && /^profile_experience_\d+_.+$/.test(key)) {
								var rest = key.replace('profile_experience_', '');
								var match = rest.match(/^(\d+)_(.+)$/);
								if (match) {
									var idx = match[1], sub = match[2];
									var block = form.querySelector('.js-experience-block[data-index="' + idx + '"]');
									if (!block) {
										var blocks = form.querySelectorAll('.js-experience-block');
										block = blocks[parseInt(idx, 10)];
									}
									if (block) {
										var needName = 'profile_experience[' + idx + '][' + sub + ']';
										block.querySelectorAll('input, select').forEach(function(el) {
											if (el.getAttribute('name') === needName) {
												container = el.closest('li') || el.closest('.form-group') || el.parentElement;
											}
										});
									}
								}
							}
							if (!container) {
								var input = form.querySelector('[name="' + key + '"]');
								container = input ? (input.closest('li') || input.closest('.form-group') || input.closest('.resume-upload-wrapper')) : null;
							}
							if (container) {
								container.classList.add('has-error');
								var sectionErr = container.querySelector('.section-error');
								var fieldErr = container.querySelector('.field-error');
								if (sectionErr) {
									sectionErr.textContent = msg;
									sectionErr.style.display = '';
								} else if (fieldErr) {
									fieldErr.textContent = msg;
									fieldErr.removeAttribute('style');
								} else {
									var span = document.createElement('span');
									span.className = 'field-error';
									span.textContent = msg;
									container.appendChild(span);
								}
							}
						});
						scrollToFirstError(form);
						return;
					}
					var genericMsg = (data.message && data.message.length) ? data.message : <?php echo wp_json_encode( __( 'Something went wrong. Please try again.', 'tasheel' ) ); ?>;
					showOneError(genericMsg);
				})
				.catch(function() {
					if (submitBtn) {
						submitBtn.disabled = false;
						submitBtn.removeAttribute('aria-busy');
						if (submitBtn.dataset.originalText) submitBtn.textContent = submitBtn.dataset.originalText;
					}
					showOneError(<?php echo wp_json_encode( __( 'Request failed. Please check your connection and try again.', 'tasheel' ) ); ?>);
				});
		});
		// Immediate file size/type check when user selects a file (no need to submit first).
		function showFileError(input, message) {
			var wrap = input.closest('.resume-upload-wrapper') || input.closest('.saudi-council-upload-wrapper') || input.closest('.file-upload-section-wrapper') || input.closest('li') || input.parentElement;
			if (!wrap) return;
			wrap.classList.add('has-error');
			var err = wrap.querySelector('.field-error');
			if (err) { err.textContent = message; err.style.display = 'block'; }
			else {
				var span = document.createElement('span');
				span.className = 'field-error';
				span.textContent = message;
				span.style.display = 'block';
				wrap.appendChild(span);
			}
		}
		function clearFileError(input) {
			var wrap = input.closest('.resume-upload-wrapper') || input.closest('.saudi-council-upload-wrapper') || input.closest('.file-upload-section-wrapper') || input.closest('li') || input.parentElement;
			if (wrap) {
				wrap.classList.remove('has-error');
				var err = wrap.querySelector('.field-error');
				if (err) { err.textContent = ''; err.style.display = 'none'; }
			}
		}
		form.querySelectorAll('input[name="profile_photo"]').forEach(function(input) {
			input.addEventListener('change', function() {
				clearFileError(input);
				if (!input.files || input.files.length === 0) return;
				var file = input.files[0];
				var ext = (file.name || '').split('.').pop().toLowerCase();
				if (['jpg','jpeg','png'].indexOf(ext) === -1) showFileError(input, photoMsgExt);
				else if (file.size > photoMaxBytes) showFileError(input, photoMsgSize);
			});
		});
		['profile_resume', 'profile_portfolio', 'saudi_council_certificate'].forEach(function(name) {
			var input = form.querySelector('input[name="' + name + '"]');
			if (!input) return;
			input.addEventListener('change', function() {
				clearFileError(input);
				if (!input.files || input.files.length === 0) return;
				var file = input.files[0];
				var ext = (file.name || '').split('.').pop().toLowerCase();
				var allowed = docAllowedExts[name];
				if (allowed && allowed.indexOf(ext) === -1) showFileError(input, msgFileType5MB);
				else if (file.size > docMaxBytes) showFileError(input, msgFileTooLarge5MB);
			});
		});
	}
		function init() {
		// Run first so Save always uses AJAX (no full-page reload); works for both corporate and career form.
		initCreateProfileValidation();
		// When form was served empty (e.g. cached page), fetch profile via AJAX and fill so Edit Profile shows existing data.
		var form = document.getElementById('create-profile-form');
		if (form && form.getAttribute('data-fetch-profile') === '1') {
			var titleEl = form.querySelector('[name="profile_title"]');
			var firstEl = form.querySelector('input[name="profile_first_name"]');
			var needFetch = (titleEl && !titleEl.value.trim()) || (firstEl && !firstEl.value.trim());
			if (needFetch) {
				var url = form.getAttribute('data-ajax-url');
				var nonce = form.getAttribute('data-nonce');
				if (url && nonce) {
					var body = new FormData();
					body.append('action', 'tasheel_hr_get_profile_for_edit');
					body.append('nonce', nonce);
					fetch(url, { method: 'POST', body: body, credentials: 'same-origin' })
						.then(function(r) { return r.json(); })
						.then(function(res) {
							if (res.success && res.data && typeof res.data === 'object') {
								var data = res.data;
								Object.keys(data).forEach(function(key) {
									if (key.indexOf('profile_education') === 0 || key.indexOf('profile_experience') === 0 || key.indexOf('profile_recent_projects') === 0) return;
									var el = form.querySelector('[name="' + key + '"]');
									if (!el || el.type === 'file') return;
									var val = data[key];
									if (val == null) val = '';
									if (typeof val === 'object') return;
									if (el.type === 'checkbox' || el.type === 'radio') el.checked = (val === '1' || val === 'yes' || val === true);
									else el.value = String(val);
								});
								var emailById = form.querySelector('#profile-email');
								if (emailById && data.profile_email) emailById.value = data.profile_email;
								var photoWrapper = form.querySelector('.file-upload-section-wrapper[data-has-existing-photo]');
								if (data.profile_photo && photoWrapper) {
									photoWrapper.setAttribute('data-has-existing-photo', '1');
									var removePhotoInput = form.querySelector('input[name="remove_profile_photo"]');
									if (removePhotoInput) removePhotoInput.value = '0';
									var preview = photoWrapper.querySelector('.file-preview-container');
									var img = photoWrapper.querySelector('.file-preview-image');
									if (preview && img) { img.src = data.profile_photo; preview.style.display = ''; }
									var label = photoWrapper.querySelector('.file-upload-label');
									if (label) label.style.display = 'none';
								}
								var eduRaw = data.profile_education;
								if (eduRaw) {
									var eduArr = typeof eduRaw === 'string' ? (function(){ try { return JSON.parse(eduRaw); } catch(e) { return []; } })() : (Array.isArray(eduRaw) ? eduRaw : []);
									if (Array.isArray(eduArr) && eduArr.length > 0) {
										var addEduBtn = form.querySelector('.btn_add_more_education');
										for (var n = eduArr.length - 1; n > 0 && addEduBtn; n--) addEduBtn.click();
										eduArr.forEach(function(entry, i) {
											entry = entry || {};
											var set = function(name, v) { var el = form.querySelector('[name="profile_education[' + i + '][' + name + ']"]'); if (el && v != null && v !== '') el.value = String(v); };
											set('degree', entry.degree);
											set('institute', entry.institute);
											set('major', entry.major);
											set('start_date', entry.start_date);
											set('end_date', entry.end_date);
											set('city', entry.city);
											set('country', entry.country);
											set('gpa', entry.gpa);
											set('avg_grade', entry.avg_grade);
											set('mode', entry.mode);
											var under = form.querySelector('[name="profile_education[' + i + '][under_process]"]');
											if (under) under.checked = !!(entry.under_process);
										});
									}
								}
							}
						})
						.catch(function() {});
				}
			}
		}
		try { initEmploymentConditional(); } catch (err) {}
		try { initAddMoreBlocks(); } catch (err) {}
	}
	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', init);
	} else {
		init();
	}
})();
</script>
<style>
p.profile-error-summary {
    display: none !important;
}
</style>
<?php
get_footer();

