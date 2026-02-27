<?php
/**
 * Corporate Training profile form: Contact, Diversity, Documents, Education.
 * Shared by Create Profile (logged-in) and Apply as a Guest. Same fields and structure.
 *
 * Expects (passed via get_template_part third param in WP 5.5+ so they are in scope via extract()):
 * - $profile_data (array), $field_errors (array), $is_guest (bool), $edu_list (array of education entries).
 * - Optional: $guest_email_editable (bool). Without explicit args, these would be undefined and default to empty.
 *
 * @package tasheel
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Normalize and ensure profile_data is always populated for logged-in edit (avoids empty resume/portfolio when args not extracted).
$profile_data = isset( $profile_data ) && is_array( $profile_data ) ? $profile_data : array();
$field_errors = isset( $field_errors ) && is_array( $field_errors ) ? $field_errors : array();
$is_guest = ! empty( $is_guest );
$is_guest_form_page = ! empty( $GLOBALS['tasheel_apply_as_guest_form'] );
$guest_email_editable = ! empty( $guest_email_editable ) || $is_guest || $is_guest_form_page;
$edu_list = isset( $edu_list ) && is_array( $edu_list ) ? $edu_list : array( array() );

// When used from Create Profile (logged-in) and profile_data is empty, load it here so existing resume/portfolio/education show.
if ( ! $is_guest && ! $is_guest_form_page && empty( $profile_data ) && is_user_logged_in() && function_exists( 'tasheel_hr_get_user_profile' ) ) {
	$profile_data = tasheel_hr_get_user_profile( get_current_user_id() );
}

// If edu_list is empty but profile has education, build it so Edit Profile shows full details.
$edu_list_empty = empty( $edu_list ) || ( count( $edu_list ) === 1 && empty( array_filter( isset( $edu_list[0] ) ? $edu_list[0] : array() ) ) );
if ( $edu_list_empty && ! empty( $profile_data['profile_education'] ) ) {
	$decoded = is_string( $profile_data['profile_education'] ) ? json_decode( $profile_data['profile_education'], true ) : $profile_data['profile_education'];
	if ( is_array( $decoded ) && ! empty( $decoded ) ) {
		$edu_list = function_exists( 'tasheel_hr_fix_profile_json_strings' ) ? tasheel_hr_fix_profile_json_strings( $decoded ) : $decoded;
	}
}
if ( empty( $edu_list ) ) {
	$edu_list = array( array() );
}
$id_prefix = ( $is_guest || $is_guest_form_page ) ? 'guest-' : '';
$nationalities = function_exists( 'tasheel_hr_get_nationalities' ) ? tasheel_hr_get_nationalities() : array();
$countries = function_exists( 'tasheel_hr_get_countries' ) ? tasheel_hr_get_countries() : array();
// Same validation messages as backend (Create Profile and Guest apply).
$profile_phone_required_msg = function_exists( 'tasheel_hr_get_field_error_message' ) ? tasheel_hr_get_field_error_message( 'profile_phone', '', __( 'is required.', 'tasheel' ) ) : ( ( function_exists( 'tasheel_hr_profile_field_error_label' ) ? tasheel_hr_profile_field_error_label( 'profile_phone' ) : __( 'Phone', 'tasheel' ) ) . ' ' . __( 'is required.', 'tasheel' ) );
?>

<!-- Contact -->
<div class="form-group">
	<div class="related_jobs_section_content">
		<h5><?php esc_html_e( 'Contact Information *', 'tasheel' ); ?></h5>
		<?php if ( ! $is_guest && ! $is_guest_form_page ) : ?>
		<?php
			$existing_photo = isset( $profile_data['profile_photo'] ) ? $profile_data['profile_photo'] : '';
		?>
		<div class="file-upload-section-wrapper<?php echo ! empty( $field_errors['profile_photo'] ) ? ' has-error' : ''; ?>" data-has-existing-photo="<?php echo ! empty( $existing_photo ) ? '1' : '0'; ?>">
			<span class="field-error" id="profile-photo-field-error" role="alert"<?php echo empty( $field_errors['profile_photo'] ) ? ' style="display: none;"' : ''; ?>><?php echo ! empty( $field_errors['profile_photo'] ) ? esc_html( $field_errors['profile_photo'] ) : ''; ?></span>
			<input type="hidden" name="remove_profile_photo" id="remove_profile_photo" value="0">
			<div class="file-upload-section">
				<input type="file" id="<?php echo esc_attr( $id_prefix ); ?>profile-photo-upload" name="profile_photo" accept=".jpg,.jpeg,.png" class="file-input-hidden">
				<label for="<?php echo esc_attr( $id_prefix ); ?>profile-photo-upload" class="file-upload-label"<?php echo ! empty( $existing_photo ) ? ' style="display: none;"' : ''; ?>>
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
		<?php endif; ?>
	</div>
	<ul class="career-form-list-ul form-col-2">
		<li class="<?php echo ! empty( $field_errors['profile_title'] ) ? 'has-error' : ''; ?>">
			<div class="select-wrapper">
				<select class="input select-input" name="profile_title" required>
					<?php
					$title_opts = function_exists( 'tasheel_hr_title_salutation_options' ) ? tasheel_hr_title_salutation_options() : array( '' => __( 'Title *', 'tasheel' ), 'mr' => __( 'Mr.', 'tasheel' ), 'ms' => __( 'Ms.', 'tasheel' ), 'mrs' => __( 'Mrs.', 'tasheel' ), 'miss' => __( 'Miss', 'tasheel' ), 'dr' => __( 'Dr.', 'tasheel' ), 'prof' => __( 'Prof.', 'tasheel' ) );
					// Ensure labels display capitalised (Mr., Ms., etc.) even if theme/plugin shows value.
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
		<li class="<?php echo ( ! $guest_email_editable ) ? '' : ( ! empty( $field_errors['guest_email'] ) || ! empty( $field_errors['profile_email'] ) ? 'has-error' : '' ); ?>">
			<?php if ( $guest_email_editable ) : ?>
			<input class="input input-guest-email" type="email" id="<?php echo esc_attr( $id_prefix ); ?>profile-email" name="guest_email" placeholder="<?php esc_attr_e( 'Email Address *', 'tasheel' ); ?>" value="<?php echo esc_attr( isset( $profile_data['profile_email'] ) ? $profile_data['profile_email'] : ( isset( $profile_data['guest_email'] ) ? $profile_data['guest_email'] : '' ) ); ?>" required autocomplete="email">
			<?php if ( ! empty( $field_errors['guest_email'] ) ) : ?><span class="field-error"><?php echo esc_html( $field_errors['guest_email'] ); ?></span><?php endif; ?>
			<?php if ( ! empty( $field_errors['profile_email'] ) ) : ?><span class="field-error"><?php echo esc_html( $field_errors['profile_email'] ); ?></span><?php endif; ?>
			<?php else : ?>
			<input class="input" type="email" id="<?php echo esc_attr( $id_prefix ); ?>profile-email" placeholder="<?php esc_attr_e( 'Email Address *', 'tasheel' ); ?>" value="<?php echo esc_attr( isset( $profile_data['profile_email'] ) ? $profile_data['profile_email'] : '' ); ?>" readonly>
			<?php endif; ?>
		</li>
		<li class="<?php echo ! empty( $field_errors['profile_phone'] ) ? 'has-error' : ''; ?>">
			<input class="input" type="tel" name="profile_phone" placeholder="<?php esc_attr_e( 'Phone Number *', 'tasheel' ); ?>" value="<?php echo esc_attr( isset( $profile_data['profile_phone'] ) ? $profile_data['profile_phone'] : '' ); ?>" required data-required-msg="<?php echo esc_attr( $profile_phone_required_msg ); ?>">
			<?php if ( ! empty( $field_errors['profile_phone'] ) ) : ?><span class="field-error"><?php echo esc_html( $field_errors['profile_phone'] ); ?></span><?php endif; ?>
		</li>
	</ul>
</div>

<!-- Diversity -->
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

<!-- Supporting Documents -->
<div class="form-group supporting-documents-section">
	<div class="related_jobs_section_content">
		<h5><?php esc_html_e( 'Supporting Documents and URLs *', 'tasheel' ); ?></h5>
	</div>
	<?php
	// Resume/portfolio may be URL string or array with 'url' key (guest snapshot from transient).
	$existing_resume_url = '';
	if ( ! empty( $profile_data['profile_resume'] ) ) {
		$r = $profile_data['profile_resume'];
		$existing_resume_url = is_array( $r ) && isset( $r['url'] ) ? $r['url'] : ( is_string( $r ) ? $r : '' );
	}
	$existing_portfolio_url = '';
	if ( ! empty( $profile_data['profile_portfolio'] ) ) {
		$p = $profile_data['profile_portfolio'];
		$existing_portfolio_url = is_array( $p ) && isset( $p['url'] ) ? $p['url'] : ( is_string( $p ) ? $p : '' );
	}
	$guest_has_resume = $is_guest && $existing_resume_url !== '';
	?>
	<?php if ( ! empty( $field_errors['profile_resume'] ) ) : ?><p class="section-error"><?php echo esc_html( $field_errors['profile_resume'] ); ?></p><?php endif; ?>
	<div class="resume-upload-wrapper<?php echo ! empty( $field_errors['profile_resume'] ) ? ' has-error' : ''; ?>" id="<?php echo esc_attr( $id_prefix ); ?>resume-upload-container">
		<?php if ( ! empty( $field_errors['profile_resume'] ) ) : ?><span class="field-error"><?php echo esc_html( $field_errors['profile_resume'] ); ?></span><?php endif; ?>
		<?php
		$resume_name = $existing_resume_url ? basename( wp_parse_url( $existing_resume_url, PHP_URL_PATH ) ) : '';
		if ( $existing_resume_url ) :
			if ( ! $resume_name ) {
				$resume_name = __( 'Resume', 'tasheel' );
			}
			?>
		<div class="existing-file-display" data-field="resume">
			<a href="<?php echo esc_url( $existing_resume_url ); ?>" target="_blank" rel="noopener"><?php echo esc_html( $resume_name ); ?></a>
			<?php if ( ! $is_guest ) : ?>
			<button type="button" class="btn-remove-file" data-field="resume" aria-label="<?php esc_attr_e( 'Remove resume', 'tasheel' ); ?>">×</button>
			<input type="hidden" name="remove_profile_resume" value="0">
			<?php endif; ?>
		</div>
		<?php endif; ?>
		<div class="resume-upload-area">
			<input type="file" id="<?php echo esc_attr( $id_prefix ); ?>resume-upload" name="profile_resume" accept=".pdf,.doc,.docx" class="file-input-hidden" <?php echo ( $is_guest && ! $guest_has_resume ) ? ' required' : ''; ?>>
			<label for="<?php echo esc_attr( $id_prefix ); ?>resume-upload" class="resume-upload-button"><?php echo $guest_has_resume ? esc_html__( 'Replace resume *', 'tasheel' ) : esc_html__( 'Upload resume here *', 'tasheel' ); ?></label>
			<div class="resume-file-name" style="display: none;"></div>
			<p class="file-upload-hint" style="margin:6px 0 0;font-size:12px;color:#666;"><?php esc_html_e( 'Accepted: PDF, DOC, DOCX. Max 5MB.', 'tasheel' ); ?></p>
		</div>
	</div>
	<div class="resume-upload-wrapper" id="<?php echo esc_attr( $id_prefix ); ?>portfolio-upload-container">
		<?php
		$portfolio_name = $existing_portfolio_url ? basename( wp_parse_url( $existing_portfolio_url, PHP_URL_PATH ) ) : '';
		if ( $existing_portfolio_url ) :
			if ( ! $portfolio_name ) {
				$portfolio_name = __( 'Portfolio', 'tasheel' );
			}
			?>
		<div class="existing-file-display" data-field="portfolio">
			<a href="<?php echo esc_url( $existing_portfolio_url ); ?>" target="_blank" rel="noopener"><?php echo esc_html( $portfolio_name ); ?></a>
			<?php if ( ! $is_guest ) : ?>
			<button type="button" class="btn-remove-file" data-field="portfolio" aria-label="<?php esc_attr_e( 'Remove portfolio', 'tasheel' ); ?>">×</button>
			<input type="hidden" name="remove_profile_portfolio" value="0">
			<?php endif; ?>
		</div>
		<?php endif; ?>
		<div class="resume-upload-area">
			<input type="file" id="<?php echo esc_attr( $id_prefix ); ?>portfolio-upload" name="profile_portfolio" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" class="file-input-hidden">
			<label for="<?php echo esc_attr( $id_prefix ); ?>portfolio-upload" class="resume-upload-button"><?php echo ( $is_guest && $existing_portfolio_url ) ? esc_html__( 'Replace portfolio (optional)', 'tasheel' ) : esc_html__( 'Upload portfolio here (optional)', 'tasheel' ); ?></label>
			<div class="resume-file-name" style="display: none;"></div>
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

<!-- Education -->
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
				<li class="<?php echo ! empty( $field_errors[ $err_start ] ) ? 'has-error' : ''; ?>"><div class="select-wrapper date-input-wrapper"><input class="input date-input career-date-start" type="date" name="profile_education[<?php echo (int) $ei; ?>][start_date]" placeholder="<?php esc_attr_e( 'Start Date *', 'tasheel' ); ?>" value="<?php echo esc_attr( isset( $ed['start_date'] ) ? $ed['start_date'] : '' ); ?>" max="<?php echo esc_attr( date( 'Y-m-d' ) ); ?>" required></div><?php if ( ! empty( $field_errors[ $err_start ] ) ) : ?><span class="field-error"><?php echo esc_html( $field_errors[ $err_start ] ); ?></span><?php endif; ?></li>
				<?php $err_end = 'profile_education_' . $ei . '_end_date'; ?>
				<li class="<?php echo ! empty( $field_errors[ $err_end ] ) ? 'has-error' : ''; ?>"><div class="select-wrapper date-input-wrapper"><input class="input date-input career-date-end" type="date" name="profile_education[<?php echo (int) $ei; ?>][end_date]" placeholder="<?php esc_attr_e( 'End Date *', 'tasheel' ); ?>" value="<?php echo esc_attr( isset( $ed['end_date'] ) ? $ed['end_date'] : '' ); ?>" required></div><?php if ( ! empty( $field_errors[ $err_end ] ) ) : ?><span class="field-error"><?php echo esc_html( $field_errors[ $err_end ] ); ?></span><?php endif; ?></li>
				<?php $err_city = 'profile_education_' . $ei . '_city'; ?>
				<li class="<?php echo ! empty( $field_errors[ $err_city ] ) ? 'has-error' : ''; ?>"><input class="input" type="text" name="profile_education[<?php echo (int) $ei; ?>][city]" placeholder="<?php esc_attr_e( 'City *', 'tasheel' ); ?>" value="<?php echo esc_attr( isset( $ed['city'] ) ? $ed['city'] : '' ); ?>" required><?php if ( ! empty( $field_errors[ $err_city ] ) ) : ?><span class="field-error"><?php echo esc_html( $field_errors[ $err_city ] ); ?></span><?php endif; ?></li>
				<?php $err_country = 'profile_education_' . $ei . '_country'; ?>
				<li class="<?php echo ! empty( $field_errors[ $err_country ] ) ? 'has-error' : ''; ?>">
					<div class="select-wrapper">
						<select class="input select-input" name="profile_education[<?php echo (int) $ei; ?>][country]" required>
							<option value=""><?php esc_html_e( 'Country *', 'tasheel' ); ?></option>
							<?php $ed_country = isset( $ed['country'] ) ? $ed['country'] : ''; foreach ( $countries as $code => $name ) : ?>
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
