<?php
/**
 * Template Name: My Profile
 *
 * The template for displaying the My Profile page (Review Profile).
 *
 * @package tasheel
 */

global $header_custom_class;
$header_custom_class = 'black-header';

// Require login: redirect to home page (not wp-login) so user can use the site login popup; preserve intended URL for after login.
if ( ! is_user_logged_in() ) {
	$intended = isset( $_SERVER['REQUEST_URI'] ) ? esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : ( function_exists( 'tasheel_hr_my_profile_url' ) ? tasheel_hr_my_profile_url() : home_url( '/my-profile/' ) );
	$redirect = add_query_arg( array( 'redirect_to' => rawurlencode( $intended ), 'open_login' => '1' ), home_url( '/' ) );
	wp_safe_redirect( $redirect );
	exit;
}

// If apply_to is set but user not logged in, redirect to create-profile (handled above).
$apply_to = (int) get_query_var( 'apply_to', 0 );
if ( ! $apply_to && isset( $_GET['apply_to'] ) ) {
	$apply_to = (int) $_GET['apply_to'];
}

$profile_data = function_exists( 'tasheel_hr_get_user_profile' ) ? tasheel_hr_get_user_profile( get_current_user_id() ) : array();
$edit_profile_url = function_exists( 'tasheel_hr_edit_profile_url' ) ? tasheel_hr_edit_profile_url( $apply_to ) : add_query_arg( 'edit', '1', home_url( '/create-profile/' ) );

// FRD 8.2: Review shows only job-relevant data. When applying to a job, restrict sections by job type.
$review_sections = null;
$apply_missing_on_load = array(); // Used only to know if we must render the error container (hidden on load; shown only after submit).
if ( $apply_to && function_exists( 'tasheel_hr_get_job_type_slug' ) && function_exists( 'tasheel_hr_review_sections_for_job_type' ) ) {
	$job_type_slug = tasheel_hr_get_job_type_slug( $apply_to );
	$review_sections = tasheel_hr_review_sections_for_job_type( $job_type_slug ? $job_type_slug : 'career' );
	// So header can output the training enrollment popup with this job's form action and nonce (no JS).
	$job_type_normalized = function_exists( 'tasheel_hr_normalize_job_type_slug' ) ? tasheel_hr_normalize_job_type_slug( $job_type_slug ) : ( $job_type_slug ?: 'career' );
	if ( $job_type_normalized === 'corporate_training' ) {
		$GLOBALS['tasheel_training_popup_job_id'] = $apply_to;
	}
	if ( is_user_logged_in() && function_exists( 'tasheel_hr_user_has_applied' ) && ! tasheel_hr_user_has_applied( get_current_user_id(), $apply_to ) && function_exists( 'tasheel_hr_profile_missing_required_fields' ) && function_exists( 'tasheel_hr_normalize_job_type_slug' ) ) {
		$apply_job_type_normalized = tasheel_hr_normalize_job_type_slug( $job_type_slug ? $job_type_slug : '' );
		$apply_missing_on_load = tasheel_hr_profile_missing_required_fields( get_current_user_id(), $apply_job_type_normalized );
	}
}

// No-cache when applying so submit form (and training popup) always get a valid nonce; avoids redirect back to my-profile after submit.
if ( $apply_to && is_user_logged_in() && ! headers_sent() ) {
	nocache_headers();
}

get_header();
?>

<main id="primary" class="site-main no_banner_section" style="background: #EDF3E4;">
	<style>
		/* Saudi Council PDF/document placeholder */
		.my_profile_section .license-block .license-image .license-pdf-placeholder {
			width: 100%;
			aspect-ratio: 1;
			min-height: 120px;
			background: #f5f5f5;
			border: 1px solid #ddd;
			border-radius: 6px;
			display: flex;
			flex-direction: column;
			align-items: center;
			justify-content: center;
			gap: 8px;
			color: #666;
			font-size: 12px;
			text-transform: uppercase;
			letter-spacing: 0.5px;
		}
		.my_profile_section .license-block .license-image .license-pdf-placeholder svg {
			opacity: 0.6;
		}
		.my_profile_section .license-block .license-image .license-pdf-placeholder--empty {
			background: #f9f9f9;
			color: #999;
		}
		.my_profile_section .license-block .license-image .js-pdf-preview {
			position: relative;
			padding: 0;
			overflow: hidden;
		}
		.my_profile_section .license-block .license-image .js-pdf-preview .pdf-preview-canvas {
			max-width: 100%;
			width: 100%;
			height: auto;
			display: block;
		}
		.my_profile_section .license-block .license-image .js-pdf-preview .pdf-loading-text {
			position: absolute;
			top: 50%;
			left: 50%;
			transform: translate(-50%, -50%);
			margin: 0;
		}
		.profile-title-actions {
			display: flex;
			flex-wrap: wrap;
			gap: 0.75em;
		}
	</style>
<?php
	$current_page   = get_queried_object();
	$active_tab     = ( $current_page && isset( $current_page->post_name ) ) ? $current_page->post_name : 'my-profile';
	$page_tabs_data = function_exists( 'tasheel_get_profile_tabs' ) ? tasheel_get_profile_tabs( $active_tab, get_queried_object_id() ) : array(
		'tabs'       => array(
			array( 'id' => 'my-job', 'title' => esc_html__( 'My Jobs', 'tasheel' ), 'link' => esc_url( home_url( '/my-job/' ) ) ),
			array( 'id' => 'my-profile', 'title' => esc_html__( 'My Profile', 'tasheel' ), 'link' => esc_url( home_url( '/my-profile/' ) ) ),
			array( 'id' => 'password-management', 'title' => esc_html__( 'Password Management', 'tasheel' ), 'link' => esc_url( home_url( '/password-management/' ) ) ),
		),
		'active_tab'  => $active_tab,
		'nav_class'   => 'profile-tabs-nav',
		'logout_url'  => is_user_logged_in() ? wp_logout_url( home_url( '/' ) ) : '',
	);
	get_template_part( 'template-parts/page-tabs', null, $page_tabs_data );
	?>







	<section class="my_profile_section pt_80 pb_80">
		<div class="wrap">
			<div class="my_profile_container">
				<div class="my_profile_content">
                    <div class="profile-title-block text-center-title">
					<h3 class="h3_title_50 pb_5 text_center mb_20"><?php echo esc_html__( 'Review Profile', 'tasheel' ); ?></h3>
					<?php
					// Error container is hidden on load; JS shows it only when user clicks Apply and validation fails (showErrors()).
					if ( $apply_to && is_user_logged_in() && function_exists( 'tasheel_hr_user_has_applied' ) && ! tasheel_hr_user_has_applied( get_current_user_id(), $apply_to ) ) {
						?>
					<div id="hr_apply_errors_top" class="hr_apply_errors_container" role="alert" style="margin-bottom: 1em; padding: 1em; background: #f8d7da; border: 1px solid #f5c2c7; border-radius: 4px; color: #842029; display: none;"></div>
					<?php } ?>
					<?php if ( ! empty( $_GET['profile_saved'] ) ) : ?>
						<p class="profile-saved-msg" style="margin-bottom: 1em; color: #0a0;"><?php esc_html_e( 'Profile saved successfully.', 'tasheel' ); ?></p>
					<?php endif; ?>
					<?php
					$apply_error_data = get_current_user_id() ? get_transient( 'tasheel_hr_apply_missing_' . get_current_user_id() ) : false;
					$apply_error_training = get_current_user_id() ? get_transient( 'tasheel_hr_apply_training_missing_' . get_current_user_id() ) : false;
					if ( ! empty( $_GET['apply_error'] ) && $_GET['apply_error'] === 'training' && $apply_error_training && ( ! $apply_to || (int) $apply_to === (int) ( $apply_error_training['job_id'] ?? 0 ) ) ) {
						delete_transient( 'tasheel_hr_apply_training_missing_' . get_current_user_id() );
						?>
						<div id="hr_apply_error_msg" class="hr_apply_error_msg" style="margin-bottom: 1em; padding: 1em; background: #f8d7da; border: 1px solid #f5c2c7; border-radius: 4px; color: #842029;">
							<p style="margin: 0; font-weight: 600;"><?php esc_html_e( 'Please fill Start Date and Duration in the popup and click Submit to complete your training application.', 'tasheel' ); ?></p>
						</div>
						<?php
					} elseif ( ! empty( $_GET['apply_error'] ) && $apply_error_data && is_array( $apply_error_data ) && ! empty( $apply_error_data['missing'] ) && ( ! $apply_to || (int) $apply_to === (int) ( $apply_error_data['job_id'] ?? 0 ) ) ) {
						delete_transient( 'tasheel_hr_apply_missing_' . get_current_user_id() );
						$missing_labels = array();
						foreach ( $apply_error_data['missing'] as $key ) {
							$missing_labels[] = function_exists( 'tasheel_hr_profile_field_error_label' ) ? tasheel_hr_profile_field_error_label( $key ) : $key;
						}
						?>
						<div id="hr_apply_error_msg" class="hr_apply_error_msg" style="margin-bottom: 1em; padding: 1em; background: #f8d7da; border: 1px solid #f5c2c7; border-radius: 4px; color: #842029;">
							<p style="margin: 0 0 0.5em 0; font-weight: 600;"><?php esc_html_e( 'Please fill the details.', 'tasheel' ); ?></p>
							<p style="margin: 0 0 0.5em 0;"><?php esc_html_e( 'The following mandatory fields are missing or incomplete:', 'tasheel' ); ?></p>
							<ul style="margin: 0 0 0.5em 1.5em; padding: 0;">
								<?php foreach ( $missing_labels as $label ) : ?>
									<li><?php echo esc_html( $label ); ?></li>
								<?php endforeach; ?>
							</ul>
						</div>
						<?php
					} elseif ( ! empty( $_GET['apply_error'] ) && $_GET['apply_error'] === 'already_applied' ) {
						?>
						<div id="hr_apply_error_msg" class="hr_apply_error_msg" style="margin-bottom: 1em; padding: 1em; background: #f8d7da; border: 1px solid #f5c2c7; border-radius: 4px; color: #842029;">
							<p style="margin: 0; font-weight: 600;"><?php esc_html_e( "You cannot apply—you have already applied to this job.", 'tasheel' ); ?></p>
						</div>
						<?php
					}
					?>
					<div class="but-position profile-title-actions">
						<a href="<?php echo esc_url( $edit_profile_url ); ?>" class="btn_style but_black"><?php echo esc_html__( 'Edit Profile', 'tasheel' ); ?></a>
					</div>
                    </div>

					<?php
					$full_name = trim( ( isset( $profile_data['profile_first_name'] ) ? $profile_data['profile_first_name'] : '' ) . ' ' . ( isset( $profile_data['profile_middle_name'] ) ? $profile_data['profile_middle_name'] : '' ) . ' ' . ( isset( $profile_data['profile_last_name'] ) ? $profile_data['profile_last_name'] : '' ) );
					if ( empty( $full_name ) && function_exists( 'wp_get_current_user' ) ) {
						$u = wp_get_current_user();
						$full_name = trim( $u->first_name . ' ' . $u->last_name ) ?: $u->display_name;
					}
					$profile_photo = isset( $profile_data['profile_photo'] ) ? $profile_data['profile_photo'] : '';
					?>
					<?php if ( $review_sections === null || in_array( 'contact', $review_sections, true ) ) : ?>
					<div class="form-group">
						<div class="profile-view-block-01 colm-rev-mobile related_jobs_section_content">
							<div class="profile-view-block-01-item-01">
								<h5><?php esc_html_e( 'Contact Information *', 'tasheel' ); ?></h5>
								<ul class="profile-view-block-01-list">
									<li>
										<h6><?php esc_html_e( 'Title *', 'tasheel' ); ?></h6>
										<p><?php echo esc_html( function_exists( 'tasheel_hr_title_display_label' ) ? tasheel_hr_title_display_label( isset( $profile_data['profile_title'] ) ? $profile_data['profile_title'] : '' ) : ( isset( $profile_data['profile_title'] ) && $profile_data['profile_title'] !== '' ? $profile_data['profile_title'] : '—' ) ); ?></p>
									</li>
									<li>
										<h6><?php esc_html_e( 'Full Name *', 'tasheel' ); ?></h6>
										<p><?php echo esc_html( $full_name ?: '—' ); ?></p>
									</li>
									<li>
										<h6><?php esc_html_e( 'Email *', 'tasheel' ); ?></h6>
										<p><?php echo isset( $profile_data['profile_email'] ) && $profile_data['profile_email'] ? '<a href="mailto:' . esc_attr( $profile_data['profile_email'] ) . '">' . esc_html( $profile_data['profile_email'] ) . '</a>' : '—'; ?></p>
									</li>
									<li>
										<h6><?php esc_html_e( 'Phone *', 'tasheel' ); ?></h6>
										<p><?php echo isset( $profile_data['profile_phone'] ) && $profile_data['profile_phone'] ? '<a href="tel:' . esc_attr( $profile_data['profile_phone'] ) . '">' . esc_html( $profile_data['profile_phone'] ) . '</a>' : '—'; ?></p>
									</li>
								</ul>
							</div>
							<div class="profile-photo-block">
								<?php if ( $profile_photo ) : ?>
									<img src="<?php echo esc_url( $profile_photo ); ?>" alt="<?php esc_attr_e( 'Profile Photo', 'tasheel' ); ?>">
								<?php else : ?>
									<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/profile-img.jpg' ); ?>" alt="<?php esc_attr_e( 'Profile Photo', 'tasheel' ); ?>">
								<?php endif; ?>
							</div>
						</div>
					</div>
					<?php endif; ?>

					<?php if ( $review_sections === null || in_array( 'diversity', $review_sections, true ) ) : ?>
					<div class="form-group">
						<div class="profile-view-block-01 related_jobs_section_content">
							<div class="profile-view-block-01-item-01">
								<h5><?php esc_html_e( 'Diversity Information *', 'tasheel' ); ?></h5>
								<ul class="profile-view-block-01-list">
									<li><h6><?php esc_html_e( 'Gender *', 'tasheel' ); ?></h6><p><?php echo esc_html( function_exists( 'tasheel_hr_gender_display_label' ) ? tasheel_hr_gender_display_label( isset( $profile_data['profile_gender'] ) ? $profile_data['profile_gender'] : '' ) : ( isset( $profile_data['profile_gender'] ) && $profile_data['profile_gender'] ? $profile_data['profile_gender'] : '—' ) ); ?></p></li>
									<li><h6><?php esc_html_e( 'Marital Status *', 'tasheel' ); ?></h6><p><?php echo esc_html( isset( $profile_data['profile_marital_status'] ) && $profile_data['profile_marital_status'] ? ( function_exists( 'tasheel_hr_marital_status_label' ) ? tasheel_hr_marital_status_label( $profile_data['profile_marital_status'] ) : ucfirst( $profile_data['profile_marital_status'] ) ) : '—' ); ?></p></li>
									<li><h6><?php esc_html_e( 'Date of Birth *', 'tasheel' ); ?></h6><p><?php echo esc_html( isset( $profile_data['profile_dob'] ) && $profile_data['profile_dob'] ? $profile_data['profile_dob'] : '—' ); ?></p></li>
									<li><h6><?php esc_html_e( 'National Status *', 'tasheel' ); ?></h6><p><?php echo esc_html( isset( $profile_data['profile_national_status'] ) && $profile_data['profile_national_status'] ? ucfirst( $profile_data['profile_national_status'] ) : '—' ); ?></p></li>
									<li><h6><?php esc_html_e( 'Nationality *', 'tasheel' ); ?></h6><p><?php echo esc_html( isset( $profile_data['profile_nationality'] ) && $profile_data['profile_nationality'] ? ( function_exists( 'tasheel_hr_get_country_name' ) ? tasheel_hr_get_country_name( $profile_data['profile_nationality'] ) : $profile_data['profile_nationality'] ) : '—' ); ?></p></li>
									<li><h6><?php esc_html_e( 'Location *', 'tasheel' ); ?></h6><p><?php echo esc_html( isset( $profile_data['profile_location'] ) && $profile_data['profile_location'] ? $profile_data['profile_location'] : '—' ); ?></p></li>
								</ul>
							</div>
						</div>
					</div>
					<?php endif; ?>

					<?php
					$resume_url   = isset( $profile_data['profile_resume'] ) ? $profile_data['profile_resume'] : '';
					$portfolio_url = isset( $profile_data['profile_portfolio'] ) ? $profile_data['profile_portfolio'] : '';
					$resume_name   = $resume_url ? basename( wp_parse_url( $resume_url, PHP_URL_PATH ) ) : '';
					$portfolio_name = $portfolio_url ? basename( wp_parse_url( $portfolio_url, PHP_URL_PATH ) ) : '';
					?>
					<?php if ( $review_sections === null || in_array( 'documents', $review_sections, true ) ) : ?>
					<div class="form-group">
						<div class="profile-view-block-01 related_jobs_section_content">
							<div class="profile-view-block-01-item-01">
								<h5><?php esc_html_e( 'Supporting Documents and URLs *', 'tasheel' ); ?></h5>
								<ul class="profile-view-block-01-list">
									<?php if ( ! empty( $profile_data['profile_linkedin'] ) ) : ?>
									<li><h6><?php esc_html_e( 'LinkedIn Profile (optional)', 'tasheel' ); ?></h6><p><a href="<?php echo esc_url( $profile_data['profile_linkedin'] ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( $profile_data['profile_linkedin'] ); ?></a></p></li>
									<?php endif; ?>
									<?php if ( ! empty( $resume_url ) ) : ?>
									<li><h6><?php esc_html_e( 'Resume *', 'tasheel' ); ?></h6><p><a href="<?php echo esc_url( $resume_url ); ?>" class="resume-download-link" target="_blank" rel="noopener"><?php echo esc_html( $resume_name ?: __( 'Download Resume', 'tasheel' ) ); ?></a></p></li>
									<?php endif; ?>
									<?php if ( ! empty( $portfolio_url ) ) : ?>
									<li><h6><?php esc_html_e( 'Portfolio (optional)', 'tasheel' ); ?></h6><p><a href="<?php echo esc_url( $portfolio_url ); ?>" class="portfolio-download-link" target="_blank" rel="noopener"><?php echo esc_html( $portfolio_name ?: __( 'Download Portfolio', 'tasheel' ) ); ?></a></p></li>
									<?php endif; ?>
									<?php if ( empty( $resume_url ) ) : ?>
									<li><h6><?php esc_html_e( 'Resume *', 'tasheel' ); ?></h6><p>—</p></li>
									<?php endif; ?>
								</ul>
							</div>
						</div>
					</div>
					<?php endif; ?>

					<?php
					$edu = isset( $profile_data['profile_education'] ) ? $profile_data['profile_education'] : '';
					$edu_list = is_string( $edu ) ? json_decode( $edu, true ) : ( is_array( $edu ) ? $edu : array() );
					$exp = isset( $profile_data['profile_experience'] ) ? $profile_data['profile_experience'] : '';
					$exp_list = is_string( $exp ) ? json_decode( $exp, true ) : ( is_array( $exp ) ? $exp : array() );
					if ( function_exists( 'tasheel_hr_fix_profile_json_strings' ) ) {
						$edu_list = tasheel_hr_fix_profile_json_strings( $edu_list );
						$exp_list = tasheel_hr_fix_profile_json_strings( $exp_list );
					}
					?>
					<?php if ( $review_sections === null || in_array( 'education', $review_sections, true ) ) : ?>
					<div class="form-group">
						<div class="profile-view-block-01 related_jobs_section_content">
							<div class="profile-view-block-01-item-01 w_100">
								<h5><?php esc_html_e( 'Education *', 'tasheel' ); ?></h5>
								<div class="education-list">
									<?php if ( ! empty( $edu_list ) && is_array( $edu_list ) ) : foreach ( $edu_list as $i => $item ) : $item = is_array( $item ) ? $item : array(); ?>
									<div class="education-item">
										<div class="education-header">
											<h6 class="education-institution"><?php echo esc_html( isset( $item['institute'] ) ? $item['institute'] : ( isset( $item['institution'] ) ? $item['institution'] : ( isset( $item['degree'] ) ? $item['degree'] : '' ) ) ); ?></h6>
											<?php if ( ! empty( $item['start_date'] ) || ! empty( $item['end_date'] ) ) : ?><span class="education-duration"><?php echo esc_html( ( isset( $item['start_date'] ) ? $item['start_date'] : '' ) . ( ! empty( $item['start_date'] ) && ! empty( $item['end_date'] ) ? ' - ' : '' ) . ( isset( $item['end_date'] ) ? $item['end_date'] : '' ) ); ?></span><?php endif; ?>
											<?php if ( ! empty( $item['under_process'] ) ) : ?><span class="education-under-process">(<?php esc_html_e( 'Under Process', 'tasheel' ); ?>)</span><?php endif; ?>
										</div>
										<?php if ( ! empty( $item['degree'] ) || ! empty( $item['major'] ) ) : ?><p class="education-degree"><?php
											$deg_val = isset( $item['degree'] ) ? $item['degree'] : '';
											$major_val = isset( $item['major'] ) ? $item['major'] : '';
											$deg_label = function_exists( 'tasheel_hr_education_degree_label' ) ? tasheel_hr_education_degree_label( $deg_val ) : $deg_val;
											$major_label = function_exists( 'tasheel_hr_education_major_label' ) ? tasheel_hr_education_major_label( $major_val ) : $major_val;
											echo esc_html( $deg_label . ( $deg_label && $major_label ? ': ' : '' ) . $major_label );
										?></p><?php endif; ?>
										<?php if ( ! empty( $item['city'] ) || ! empty( $item['country'] ) ) : ?><p class="education-location"><?php echo esc_html( ( isset( $item['city'] ) ? $item['city'] : '' ) . ( ! empty( $item['city'] ) && ! empty( $item['country'] ) ? ', ' : '' ) . ( isset( $item['country'] ) && function_exists( 'tasheel_hr_get_country_name' ) ? tasheel_hr_get_country_name( $item['country'] ) : ( isset( $item['country'] ) ? $item['country'] : '' ) ) ); ?></p><?php endif; ?>
										<?php if ( ! empty( $item['gpa'] ) || ! empty( $item['avg_grade'] ) || ! empty( $item['mode'] ) ) : ?>
										<p class="education-details"><?php
											$parts = array();
											if ( ! empty( $item['gpa'] ) ) { $parts[] = esc_html__( 'GPA:', 'tasheel' ) . ' ' . esc_html( $item['gpa'] ); }
											if ( ! empty( $item['avg_grade'] ) ) { $parts[] = esc_html__( 'Avg Grade:', 'tasheel' ) . ' ' . esc_html( $item['avg_grade'] ); }
											if ( ! empty( $item['mode'] ) ) {
												$mode_label = function_exists( 'tasheel_hr_education_mode_label' ) ? tasheel_hr_education_mode_label( $item['mode'] ) : $item['mode'];
												$parts[] = esc_html__( 'Mode:', 'tasheel' ) . ' ' . esc_html( $mode_label );
											}
											echo implode( ' | ', $parts );
										?></p>
										<?php endif; ?>
									</div>
									<?php if ( $i < count( $edu_list ) - 1 ) : ?><div class="education-divider"></div><?php endif; ?>
									<?php endforeach; else : ?><p>—</p><?php endif; ?>
								</div>
							</div>
						</div>
					</div>
					<?php endif; ?>

					<?php if ( $review_sections === null || in_array( 'experience', $review_sections, true ) ) : ?>
					<div class="form-group">
						<div class="profile-view-block-01 related_jobs_section_content">
							<div class="profile-view-block-01-item-01 w_100">
								<h5><?php esc_html_e( 'Experience *', 'tasheel' ); ?></h5>
								<div class="experience-list">
									<?php if ( ! empty( $exp_list ) && is_array( $exp_list ) ) : foreach ( $exp_list as $item ) : $item = is_array( $item ) ? $item : array(); ?>
									<div class="experience-item">
										<div class="experience-header">
											<h6 class="experience-position"><?php echo esc_html( isset( $item['job_title'] ) ? $item['job_title'] : ( isset( $item['employer'] ) ? $item['employer'] : '' ) ); ?></h6>
											<?php if ( ! empty( $item['start_date'] ) || ! empty( $item['end_date'] ) ) : ?><span class="experience-duration"><?php echo esc_html( ( isset( $item['start_date'] ) ? $item['start_date'] : '' ) . ( ! empty( $item['start_date'] ) && ! empty( $item['end_date'] ) ? ' - ' : '' ) . ( isset( $item['end_date'] ) ? $item['end_date'] : '' ) ); ?></span><?php endif; ?>
											<?php if ( ! empty( $item['current_job'] ) ) : ?><span class="experience-current">(<?php esc_html_e( 'Current', 'tasheel' ); ?>)</span><?php endif; ?>
										</div>
										<?php if ( ! empty( $item['employer'] ) || ! empty( $item['country'] ) ) : ?><p class="experience-company"><?php echo esc_html( ( isset( $item['employer'] ) ? $item['employer'] : '' ) . ( ! empty( $item['employer'] ) && ! empty( $item['country'] ) ? ' | ' : '' ) . ( isset( $item['country'] ) && function_exists( 'tasheel_hr_get_country_name' ) ? tasheel_hr_get_country_name( $item['country'] ) : ( isset( $item['country'] ) ? $item['country'] : '' ) ) ); ?></p><?php endif; ?>
										<?php if ( ! empty( $item['years'] ) || ! empty( $item['salary'] ) || ! empty( $item['benefits'] ) ) : ?>
										<p class="experience-details"><?php
											$parts = array();
											if ( ! empty( $item['years'] ) ) { $parts[] = esc_html__( 'Years:', 'tasheel' ) . ' ' . esc_html( $item['years'] ); }
											if ( ! empty( $item['salary'] ) ) { $parts[] = esc_html__( 'Salary:', 'tasheel' ) . ' ' . esc_html( $item['salary'] ); }
											if ( ! empty( $item['benefits'] ) ) { $parts[] = esc_html__( 'Benefits:', 'tasheel' ) . ' ' . esc_html( $item['benefits'] ); }
											echo implode( ' | ', $parts );
										?></p>
										<?php endif; ?>
										<?php if ( ! empty( $item['reason_leaving'] ) ) : ?><p class="experience-reason"><?php esc_html_e( 'Reason for leaving:', 'tasheel' ); ?> <?php echo esc_html( $item['reason_leaving'] ); ?></p><?php endif; ?>
									</div>
									<?php endforeach; else : ?><p>—</p><?php endif; ?>
								</div>
							</div>
						</div>
					</div>
					<?php endif; ?>

					<?php
					$saudi_url   = isset( $profile_data['profile_saudi_council'] ) ? $profile_data['profile_saudi_council'] : '';
					$saudi_thumb = isset( $profile_data['profile_saudi_council_thumb'] ) ? $profile_data['profile_saudi_council_thumb'] : '';
					$saudi_name  = $saudi_url ? basename( wp_parse_url( $saudi_url, PHP_URL_PATH ) ) : '';
					$saudi_ext   = $saudi_name ? strtolower( pathinfo( $saudi_name, PATHINFO_EXTENSION ) ) : '';
					$saudi_is_image = $saudi_url && in_array( $saudi_ext, array( 'jpg', 'jpeg', 'png', 'gif', 'webp' ), true );
					$saudi_preview_src = $saudi_is_image ? $saudi_url : ( $saudi_thumb ? $saudi_thumb : '' );
					$saudi_has_preview = ! empty( $saudi_preview_src );
					?>
					<?php if ( $review_sections === null || in_array( 'saudi_council', $review_sections, true ) ) : ?>
					<div class="form-group related_jobs_section_content">
						<h5><?php esc_html_e( 'Saudi Council Classification', 'tasheel' ); ?></h5>
						<div class="profile-view-block-01 related_jobs_section_content license-block">
							<div class="license-image">
								<?php if ( ! empty( $saudi_url ) ) : ?>
								<a href="<?php echo esc_url( $saudi_url ); ?>" target="_blank" rel="noopener">
									<?php if ( $saudi_has_preview ) : ?>
									<img src="<?php echo esc_url( $saudi_preview_src ); ?>" alt="<?php esc_attr_e( 'Saudi Council Classification', 'tasheel' ); ?>">
									<?php elseif ( $saudi_ext === 'pdf' ) : ?>
									<div class="license-pdf-placeholder js-pdf-preview" data-pdf-url="<?php echo esc_attr( $saudi_url ); ?>">
										<canvas class="pdf-preview-canvas" width="194" height="250"></canvas>
										<span class="pdf-loading-text" aria-hidden="true"><?php esc_html_e( 'PDF', 'tasheel' ); ?></span>
									</div>
									<?php else : ?>
									<div class="license-pdf-placeholder">
										<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
										<span><?php echo esc_html( strtoupper( $saudi_ext ) ); ?></span>
									</div>
									<?php endif; ?>
								</a>
								<?php else : ?>
								<div class="license-pdf-placeholder license-pdf-placeholder--empty">
									<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
									<span><?php esc_html_e( 'No document', 'tasheel' ); ?></span>
								</div>
								<?php endif; ?>
							</div>
							<div class="license-content">
								<?php if ( $saudi_name ) : ?>
								<p><a href="<?php echo esc_url( $saudi_url ); ?>" class="saudi-download-link" target="_blank" rel="noopener"><?php echo esc_html( $saudi_name ); ?></a></p>
								<?php else : ?>
								<p><?php esc_html_e( 'No document uploaded', 'tasheel' ); ?></p>
								<?php endif; ?>
							</div>
						</div>
					</div>
					<?php endif; ?>

					<?php if ( $review_sections === null || in_array( 'additional_info', $review_sections, true ) ) : ?>
					<div class="form-group">
						<div class="profile-view-block-01 related_jobs_section_content">
							<div class="profile-view-block-01-item-01">
								<h5><?php esc_html_e( 'Additional Information *', 'tasheel' ); ?></h5>
								<ul class="profile-view-block-01-list">
									<li><h6><?php esc_html_e( 'Years of Experience *', 'tasheel' ); ?></h6><p><?php echo esc_html( isset( $profile_data['profile_years_experience'] ) && $profile_data['profile_years_experience'] ? $profile_data['profile_years_experience'] : '—' ); ?></p></li>
									<li><h6><?php esc_html_e( 'Specialization *', 'tasheel' ); ?></h6><p><?php echo esc_html( isset( $profile_data['profile_specialization'] ) && $profile_data['profile_specialization'] ? ( function_exists( 'tasheel_hr_specialization_label' ) ? tasheel_hr_specialization_label( $profile_data['profile_specialization'] ) : $profile_data['profile_specialization'] ) : '—' ); ?></p></li>
									<li><h6><?php esc_html_e( 'Notice Period *', 'tasheel' ); ?></h6><p><?php echo esc_html( isset( $profile_data['profile_notice_period'] ) && $profile_data['profile_notice_period'] ? $profile_data['profile_notice_period'] : '—' ); ?></p></li>
									<li><h6><?php esc_html_e( 'Current Salary *', 'tasheel' ); ?></h6><p><?php echo esc_html( isset( $profile_data['profile_current_salary'] ) && $profile_data['profile_current_salary'] ? $profile_data['profile_current_salary'] : '—' ); ?></p></li>
									<li><h6><?php esc_html_e( 'Expected Salary *', 'tasheel' ); ?></h6><p><?php echo esc_html( isset( $profile_data['profile_expected_salary'] ) && $profile_data['profile_expected_salary'] ? $profile_data['profile_expected_salary'] : '—' ); ?></p></li>
									<li><h6><?php esc_html_e( 'Visa Status *', 'tasheel' ); ?></h6><p><?php echo esc_html( function_exists( 'tasheel_hr_visa_status_label' ) ? tasheel_hr_visa_status_label( isset( $profile_data['profile_visa_status'] ) ? $profile_data['profile_visa_status'] : '' ) : ( isset( $profile_data['profile_visa_status'] ) && $profile_data['profile_visa_status'] ? $profile_data['profile_visa_status'] : '—' ) ); ?></p></li>
								</ul>
							</div>
						</div>
					</div>
					<?php endif; ?>

					<?php if ( $review_sections === null || in_array( 'employment_history', $review_sections, true ) ) : ?>
					<div class="form-group">
						<div class="profile-view-block-01 related_jobs_section_content">
							<div class="profile-view-block-01-item-01">
								<h5><?php esc_html_e( 'Employment History at Saud Consult *', 'tasheel' ); ?></h5>
								<ul class="profile-view-block-01-list">
									<li><h6><?php esc_html_e( 'Currently employed at Saud Consult? *', 'tasheel' ); ?></h6><p><?php echo esc_html( isset( $profile_data['profile_currently_employed'] ) && $profile_data['profile_currently_employed'] ? ucfirst( $profile_data['profile_currently_employed'] ) : '—' ); ?></p></li>
									<?php if ( isset( $profile_data['profile_currently_employed'] ) && $profile_data['profile_currently_employed'] === 'yes' ) : ?>
									<li><h6><?php esc_html_e( 'Employee ID *', 'tasheel' ); ?></h6><p><?php echo esc_html( isset( $profile_data['profile_employee_id'] ) ? $profile_data['profile_employee_id'] : '—' ); ?></p></li>
									<li><h6><?php esc_html_e( 'Current Project *', 'tasheel' ); ?></h6><p><?php echo esc_html( isset( $profile_data['profile_current_project'] ) ? $profile_data['profile_current_project'] : '—' ); ?></p></li>
									<li><h6><?php esc_html_e( 'Department *', 'tasheel' ); ?></h6><p><?php echo esc_html( function_exists( 'tasheel_hr_department_display_label' ) ? tasheel_hr_department_display_label( isset( $profile_data['profile_current_department'] ) ? $profile_data['profile_current_department'] : '' ) : ( isset( $profile_data['profile_current_department'] ) ? $profile_data['profile_current_department'] : '—' ) ); ?></p></li>
									<?php endif; ?>
									<li><h6><?php esc_html_e( 'Previously worked at Saud Consult? *', 'tasheel' ); ?></h6><p><?php echo esc_html( isset( $profile_data['profile_previously_worked'] ) && $profile_data['profile_previously_worked'] ? ucfirst( $profile_data['profile_previously_worked'] ) : '—' ); ?></p></li>
									<?php if ( isset( $profile_data['profile_previously_worked'] ) && $profile_data['profile_previously_worked'] === 'yes' ) : ?>
									<li><h6><?php esc_html_e( 'Duration *', 'tasheel' ); ?></h6><p><?php echo esc_html( isset( $profile_data['profile_previous_duration'] ) ? $profile_data['profile_previous_duration'] : '—' ); ?></p></li>
									<li><h6><?php esc_html_e( 'Last Project *', 'tasheel' ); ?></h6><p><?php echo esc_html( isset( $profile_data['profile_last_project'] ) ? $profile_data['profile_last_project'] : '—' ); ?></p></li>
									<li><h6><?php esc_html_e( 'Department *', 'tasheel' ); ?></h6><p><?php echo esc_html( function_exists( 'tasheel_hr_department_display_label' ) ? tasheel_hr_department_display_label( isset( $profile_data['profile_previous_department'] ) ? $profile_data['profile_previous_department'] : '' ) : ( isset( $profile_data['profile_previous_department'] ) ? $profile_data['profile_previous_department'] : '—' ) ); ?></p></li>
									<?php endif; ?>
								</ul>
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="profile-view-block-01 related_jobs_section_content">
							<div class="profile-view-block-01-item-01">
								<h5><?php esc_html_e( 'Recent Projects *', 'tasheel' ); ?></h5>
								<ul class="profile-view-block-01-list recent-projects-list">
									<?php
									$proj_list = isset( $profile_data['profile_recent_projects'] ) ? $profile_data['profile_recent_projects'] : '';
									$proj_list = is_string( $proj_list ) ? json_decode( $proj_list, true ) : ( is_array( $proj_list ) ? $proj_list : array() );
									if ( function_exists( 'tasheel_hr_fix_profile_json_strings' ) ) {
										$proj_list = tasheel_hr_fix_profile_json_strings( $proj_list );
									}
									if ( ! empty( $proj_list ) && is_array( $proj_list ) ) :
										foreach ( $proj_list as $idx => $pr ) :
											$pr       = is_array( $pr ) ? $pr : array();
											$company  = isset( $pr['company'] ) ? $pr['company'] : '';
											$client   = isset( $pr['client'] ) ? $pr['client'] : '';
											$pos_val  = isset( $pr['position'] ) ? $pr['position'] : '';
											$per_val  = isset( $pr['period'] ) ? $pr['period'] : '';
											$pos_label = function_exists( 'tasheel_hr_project_position_label' ) ? tasheel_hr_project_position_label( $pos_val ) : $pos_val;
											$per_label = function_exists( 'tasheel_hr_project_period_label' ) ? tasheel_hr_project_period_label( $per_val ) : $per_val;
											$duties   = isset( $pr['duties'] ) ? $pr['duties'] : '';
											$is_first = (int) $idx === 0;
											$li_class = $is_first ? 'recent-project-item' : 'recent-project-group-start';
									?>
									<li class="<?php echo esc_attr( $li_class ); ?>">
										<h6><?php esc_html_e( 'Company Name', 'tasheel' ); ?></h6>
										<p><?php echo esc_html( $company ? $company : '—' ); ?></p>
									</li>
									<li>
										<h6><?php esc_html_e( 'Client Name', 'tasheel' ); ?></h6>
										<p><?php echo esc_html( $client ? $client : '—' ); ?></p>
									</li>
									<li>
										<h6><?php esc_html_e( 'Position', 'tasheel' ); ?></h6>
										<p><?php echo esc_html( $pos_label ? $pos_label : '—' ); ?></p>
									</li>
									<li>
										<h6><?php esc_html_e( 'Period', 'tasheel' ); ?></h6>
										<p><?php echo esc_html( $per_label ? $per_label : '—' ); ?></p>
									</li>
									<li>
										<h6><?php esc_html_e( 'Duties &amp; Responsibilities', 'tasheel' ); ?></h6>
										<p class="project-duties"><?php echo esc_html( $duties ? $duties : '—' ); ?></p>
									</li>
									<?php if ( $idx < count( $proj_list ) - 1 ) : ?>
									<li aria-hidden="true"><div class="education-divider"></div></li>
									<?php endif; ?>
									<?php
										endforeach;
									else :
									?>
									<li><h6><?php esc_html_e( 'Company Name', 'tasheel' ); ?></h6><p>—</p></li>
									<?php endif; ?>
								</ul>
							</div>
						</div>
					</div>
					<?php endif; ?>

					<?php
					if ( $apply_to && is_user_logged_in() && function_exists( 'tasheel_hr_user_has_applied' ) ) {
						$already_applied = tasheel_hr_user_has_applied( get_current_user_id(), $apply_to );
						$apply_job = get_post( $apply_to );
						$apply_pt = function_exists( 'tasheel_hr_job_post_type' ) ? tasheel_hr_job_post_type() : 'hr_job';
						$apply_job_valid = $apply_job && $apply_job->post_type === $apply_pt;
						$apply_raw_slug = $apply_job_valid && function_exists( 'tasheel_hr_get_job_type_slug' ) ? tasheel_hr_get_job_type_slug( $apply_to ) : '';
						$apply_job_type_normalized = $apply_job_valid && function_exists( 'tasheel_hr_normalize_job_type_slug' ) ? tasheel_hr_normalize_job_type_slug( $apply_raw_slug ) : 'career';
						$apply_is_corporate = $apply_job_type_normalized === 'corporate_training';
						?>
						<div class="hr_apply_section mt_40" id="hr_apply_section">
						<div class="hr_apply_form_wrap" data-job-id="<?php echo esc_attr( $apply_to ); ?>" data-job-type="<?php echo esc_attr( $apply_job_type_normalized ); ?>" data-validate-url="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>" data-nonce="<?php echo esc_attr( wp_create_nonce( 'tasheel_validate_apply' ) ); ?>">
						<?php if ( $already_applied ) : ?>
							<p class="hr_apply_already"><?php echo esc_html__( 'You have already applied for this position.', 'tasheel' ); ?></p>
						<?php elseif ( ! $apply_job_valid ) : ?>
							<p class="hr_apply_invalid"><?php echo esc_html__( 'This job is no longer available.', 'tasheel' ); ?></p>
						<?php elseif ( $apply_is_corporate ) : ?>
							<div class="form-buttion-row flex-align-right">
								<a href="#login-popup-training-submit" class="btn_style but_black hr_apply_corporate_link" data-fancybox="login-popup-training-submit"><?php echo esc_html__( 'Submit Application', 'tasheel' ); ?></a>
							</div>
						<?php else : ?>
							<form method="post" action="" class="hr_apply_form">
								<?php wp_nonce_field( 'tasheel_hr_apply_' . $apply_to, '_wpnonce' ); ?>
								<input type="hidden" name="tasheel_hr_submit_application" value="1" />
								<input type="hidden" name="apply_to" value="<?php echo esc_attr( $apply_to ); ?>" />
								<input type="hidden" name="job_id" value="<?php echo esc_attr( $apply_to ); ?>" />
								<input type="hidden" name="job_title" value="<?php echo esc_attr( get_the_title( $apply_to ) ); ?>" />
								<p class="form-buttion-row flex-align-right">
									<button type="submit" class="btn_style btn_transparent but_black"><?php echo esc_html__( 'Submit application', 'tasheel' ); ?></button>
								</p>
							</form>
						<?php endif; ?>
						</div>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</section>

</main><!-- #main -->

<?php
// Client-side PDF first-page preview (works without Imagick/Ghostscript).
$has_pdf_preview = ! empty( $saudi_url ) && ! $saudi_has_preview && ( $saudi_ext === 'pdf' );
if ( $has_pdf_preview ) :
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
<script>
(function() {
	function initPdfPreview() {
		if (typeof pdfjsLib === 'undefined') return;
		pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';
		document.querySelectorAll('.js-pdf-preview').forEach(function(el) {
			var url = el.getAttribute('data-pdf-url');
			if (!url) return;
			el.style.position = 'relative';
			var loadingEl = el.querySelector('.pdf-loading-text');
			pdfjsLib.getDocument({ url: url }).promise.then(function(pdf) {
				return pdf.getPage(1);
			}).then(function(page) {
				var canvas = el.querySelector('.pdf-preview-canvas');
				if (!canvas) return;
				var scale = 1.5;
				var viewport = page.getViewport({ scale: scale });
				canvas.width = viewport.width;
				canvas.height = viewport.height;
				page.render({ canvasContext: canvas.getContext('2d'), viewport: viewport }).promise.then(function() {
					if (loadingEl) loadingEl.style.display = 'none';
				});
			}).catch(function() {
				if (loadingEl) { loadingEl.textContent = 'PDF'; loadingEl.style.display = ''; }
				var canvas = el.querySelector('.pdf-preview-canvas');
				if (canvas) canvas.style.display = 'none';
			});
		});
	}
	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', initPdfPreview);
	} else {
		initPdfPreview();
	}
})();
</script>
<?php endif; ?>
<?php
if ( $apply_to && is_user_logged_in() && function_exists( 'tasheel_hr_user_has_applied' ) && ! tasheel_hr_user_has_applied( get_current_user_id(), $apply_to ) ) :
?>
<script>
(function() {
	var msgPleaseFill = <?php echo wp_json_encode( __( 'Please fill the details.', 'tasheel' ) ); ?>;
	var msgFieldsNeeded = <?php echo wp_json_encode( __( 'The following mandatory fields are missing or incomplete:', 'tasheel' ) ); ?>;
	var msgValidating = <?php echo wp_json_encode( __( 'Validating...', 'tasheel' ) ); ?>;
	var msgSubmitApplication = <?php echo wp_json_encode( __( 'Submit application', 'tasheel' ) ); ?>;
	var msgValidationFailed = <?php echo wp_json_encode( __( 'Validation failed', 'tasheel' ) ); ?>;
	var msgUnableToValidate = <?php echo wp_json_encode( __( 'Unable to validate. Please try again.', 'tasheel' ) ); ?>;
	var headerOffset = 100;
	function scrollToError(el) {
		if (!el) return;
		// Scroll to the block that contains title + Edit Profile button + error so all stay visible.
		var block = el.closest ? el.closest('.profile-title-block') : null;
		var target = block || el;
		var top = target.getBoundingClientRect().top + (window.pageYOffset || document.documentElement.scrollTop);
		window.scrollTo({ top: Math.max(0, top - headerOffset), behavior: 'smooth' });
	}
	function showErrors(labels) {
		var el = document.getElementById('hr_apply_errors_top');
		if (!el) return;
		var html = '<p style="margin: 0 0 0.5em 0; font-weight: 600;">' + msgPleaseFill + '</p>';
		if (labels && labels.length) {
			html += '<p style="margin: 0 0 0.5em 0;">' + msgFieldsNeeded + '</p>';
			html += '<ul style="margin: 0 1.5em 0 0; padding: 0;">';
			for (var i = 0; i < labels.length; i++) html += '<li>' + String(labels[i] || '').replace(/</g, '&lt;').replace(/>/g, '&gt;') + '</li>';
			html += '</ul>';
		}
		el.innerHTML = html;
		el.style.display = 'block';
		scrollToError(el);
	}
	function hideErrors() {
		var el = document.getElementById('hr_apply_errors_top');
		if (el) { el.style.display = 'none'; el.innerHTML = ''; }
	}
	function validateAndProceed(jobId, onSuccess, btn) {
		var wrap = document.querySelector('.hr_apply_form_wrap[data-job-id="' + jobId + '"]');
		if (!wrap) return;
		var nonce = wrap.getAttribute('data-nonce') || '';
		var jobType = wrap.getAttribute('data-job-type') || '';
		var url = (wrap.getAttribute('data-validate-url') || '') + '?action=tasheel_validate_apply&job_id=' + encodeURIComponent(jobId) + '&nonce=' + encodeURIComponent(nonce || '') + (jobType ? '&job_type=' + encodeURIComponent(jobType) : '') + '&_=' + (Date.now ? Date.now() : 0);
		var done = function() { if (btn) { btn.disabled = false; btn.textContent = btn.getAttribute('data-original-text') || msgSubmitApplication; } };
		if (btn) { btn.disabled = true; btn.setAttribute('data-original-text', btn.textContent); btn.textContent = msgValidating; }
		fetch(url, { method: 'GET', credentials: 'same-origin', cache: 'no-store' })
			.then(function(r) {
				if (!r.ok) throw new Error('Request failed: ' + r.status);
				return r.json();
			})
			.then(function(data) {
				// Never allow submit if we have missing fields (even if server sent ok: true by mistake).
				var hasMissing = (data.missing_labels && data.missing_labels.length) || (data.missing && data.missing.length);
				if (hasMissing) {
					showErrors(data.missing_labels && data.missing_labels.length ? data.missing_labels : data.missing);
					done();
					return;
				}
				if (data.ok) {
					hideErrors();
					onSuccess();
				} else {
					showErrors([data.message || data.error || msgValidationFailed]);
					done();
				}
			})
			.catch(function(err) {
				showErrors([msgUnableToValidate]);
				done();
			});
	}
	function initApplyValidation() {
		var wrap = document.querySelector('.hr_apply_form_wrap');
		if (!wrap) return;
		var jobId = wrap.getAttribute('data-job-id');
		if (!jobId) return;
		var form = wrap.querySelector('form.hr_apply_form');
		if (form) {
			// Block form submit: run validation first; only submit when validation passes.
			form.addEventListener('submit', function(e) {
				e.preventDefault();
				e.stopPropagation();
				var btn = form.querySelector('button[type="submit"]');
				validateAndProceed(jobId, function() { form.submit(); }, btn);
				return false;
			}, true);
			// Also intercept button click so submit never fires from click (handles cases where submit event is skipped).
			var btn = form.querySelector('button[type="submit"]');
			if (btn) {
				btn.addEventListener('click', function(e) {
					e.preventDefault();
					e.stopPropagation();
					validateAndProceed(jobId, function() { form.submit(); }, btn);
					return false;
				}, true);
			}
		}
		var corpLink = wrap.querySelector('a.hr_apply_corporate_link');
		if (corpLink) {
			corpLink.addEventListener('click', function(e) {
				e.preventDefault();
				e.stopPropagation();
				// Always prevent default so href="#..." never runs (no scroll/redirect). Open popup via Fancybox.
				if (typeof Fancybox !== 'undefined') {
					Fancybox.show([{ src: '#login-popup-training-submit' }]);
				}
				return false;
			}, true);
		}
	}
	function scrollToErrorOnLoad() {
		var errTop = document.getElementById('hr_apply_errors_top');
		if (errTop && errTop.style.display !== 'none' && errTop.offsetParent !== null) {
			scrollToError(errTop);
			return;
		}
		var errMsg = document.getElementById('hr_apply_error_msg');
		if (errMsg) scrollToError(errMsg);
	}
	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', function() {
			initApplyValidation();
			scrollToErrorOnLoad();
		});
	} else {
		initApplyValidation();
		scrollToErrorOnLoad();
	}
})();
</script>
<?php endif; ?>
<?php
get_footer();

