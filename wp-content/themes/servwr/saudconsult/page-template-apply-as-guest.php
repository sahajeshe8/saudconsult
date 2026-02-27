<?php
/**
 * Template Name: Apply as a Guest
 *
 * Corporate Training only (FRD): same form fields as logged-in Create Profile; no account required.
 * Uses shared template part so fields stay in sync with Create Profile.
 *
 * @package tasheel
 */
global $header_custom_class;
$header_custom_class = 'black-header';

// Edit profile from Guest Profile: accept POST so request bypasses GET cache and form always loads with saved data.
$is_edit_profile_post = ( $_SERVER['REQUEST_METHOD'] === 'POST' && ! empty( $_POST['tasheel_guest_edit_profile'] ) );
if ( $is_edit_profile_post ) {
	$apply_to     = isset( $_POST['apply_to'] ) ? max( 0, (int) $_POST['apply_to'] ) : 0;
	$review_token = isset( $_POST['review_token'] ) ? sanitize_text_field( wp_unslash( $_POST['review_token'] ) ) : '';
	$guest_error  = '';
	$nonce_ok     = $apply_to && wp_verify_nonce( isset( $_POST['tasheel_guest_edit_nonce'] ) ? $_POST['tasheel_guest_edit_nonce'] : '', 'tasheel_guest_edit_profile_' . $apply_to );
	if ( ! $nonce_ok ) {
		$is_edit_profile_post = false;
		$apply_to             = 0;
		$review_token         = '';
	}
}
if ( ! $is_edit_profile_post ) {
	$apply_to     = isset( $_GET['apply_to'] ) ? max( 0, (int) $_GET['apply_to'] ) : 0;
	$review_token = isset( $_GET['review_token'] ) ? sanitize_text_field( wp_unslash( $_GET['review_token'] ) ) : '';
	$guest_error  = isset( $_GET['guest_error'] ) ? sanitize_text_field( wp_unslash( $_GET['guest_error'] ) ) : '';
}
$guest_missing = $apply_to ? get_transient( 'tasheel_guest_apply_missing' ) : false;
if ( $guest_missing && ! empty( $guest_missing['job_id'] ) && (int) $guest_missing['job_id'] === $apply_to ) {
	$guest_error = 'missing';
}

// Guest-only: form data for repopulation. Does not affect logged-in users (they see "use your account" and never this form).
// Prefer review token (Edit profile from Guest Profile) over validation-error transient so Edit profile always shows saved data.
$guest_data = array();
$edu_list = array( array() );
$edit_start_date = '';
$edit_duration   = '';
if ( $review_token && $apply_to ) {
	// Edit profile: load from review transient so previously entered details are kept.
	$stored = get_transient( 'tasheel_guest_review_' . $review_token );
	if ( ! is_array( $stored ) || (int) ( isset( $stored['job_id'] ) ? $stored['job_id'] : 0 ) !== $apply_to ) {
		wp_safe_redirect( add_query_arg( array( 'guest_error' => 'expired', 'apply_to' => $apply_to ), home_url( '/apply-as-a-guest/' ) ) );
		exit;
	}
	$snapshot = isset( $stored['snapshot'] ) ? $stored['snapshot'] : array();
	$guest_email = isset( $stored['guest_email'] ) ? $stored['guest_email'] : '';
	if ( ! empty( $snapshot ) ) {
		$guest_data = $snapshot;
		$guest_data['profile_email'] = $guest_email;
		if ( ! empty( $guest_data['profile_education'] ) && is_array( $guest_data['profile_education'] ) ) {
			$edu_list = $guest_data['profile_education'];
		}
		$edit_start_date = isset( $stored['start_date'] ) ? $stored['start_date'] : '';
		$edit_duration   = isset( $stored['duration'] ) ? $stored['duration'] : '';
	} else {
		wp_safe_redirect( add_query_arg( array( 'guest_error' => 'expired', 'apply_to' => $apply_to ), home_url( '/apply-as-a-guest/' ) ) );
		exit;
	}
} elseif ( $guest_missing && ! empty( $guest_missing['submitted'] ) && is_array( $guest_missing['submitted'] ) ) {
	$guest_data = $guest_missing['submitted'];
	if ( ! empty( $guest_data['profile_education'] ) && is_array( $guest_data['profile_education'] ) ) {
		$edu_list = $guest_data['profile_education'];
	}
}
$field_errors = array();
if ( $guest_error === 'missing' && $guest_missing && ! empty( $guest_missing['missing'] ) ) {
	if ( ! empty( $guest_missing['field_errors'] ) && is_array( $guest_missing['field_errors'] ) ) {
		$field_errors = $guest_missing['field_errors'];
	} else {
		$required_msg = __( 'is required.', 'tasheel' );
		$submitted = isset( $guest_missing['submitted'] ) && is_array( $guest_missing['submitted'] ) ? $guest_missing['submitted'] : array();
		foreach ( $guest_missing['missing'] as $key ) {
			if ( $key === 'guest_email' ) {
				$field_errors[ $key ] = __( 'Email address', 'tasheel' ) . ' ' . $required_msg;
			} else {
				$field_errors[ $key ] = function_exists( 'tasheel_hr_get_field_error_message' )
					? tasheel_hr_get_field_error_message( $key, isset( $submitted[ $key ] ) ? $submitted[ $key ] : '', $required_msg )
					: ( ( function_exists( 'tasheel_hr_profile_field_error_label' ) ? tasheel_hr_profile_field_error_label( $key ) : $key ) . ' ' . $required_msg );
			}
		}
	}
}
if ( $guest_error === 'email' ) {
	$field_errors['guest_email'] = __( 'Please enter a valid email address.', 'tasheel' );
}
// Block logged-in users from using guest apply (FRD: use their account).
$user_logged_in_on_guest_page = is_user_logged_in();
if ( $apply_to ) {
	$GLOBALS['tasheel_apply_as_guest_form'] = true;
}

// When loading from "Edit profile" (review_token present), prevent caching so transient is always read and form shows saved data.
if ( $review_token && $apply_to ) {
	header( 'Cache-Control: no-store, no-cache, must-revalidate, max-age=0' );
	header( 'Pragma: no-cache' );
	header( 'Expires: 0' );
}

get_header();
?>

<main id="primary" class="site-main no_banner_section" style="background: #EDF3E4;">

	<style>
		.create_profile_section .block-actions { margin-top: 10px; display: flex; justify-content: flex-end; }
		.create_profile_section .btn-remove-block {
			background: none;
			border: 1px solid #c00;
			color: #c00;
			font-size: 14px;
			padding: 8px 16px;
			border-radius: 4px;
			cursor: pointer;
			transition: background 0.2s, color 0.2s;
		}
		.create_profile_section .btn-remove-block-icon {
			display: inline-flex;
			align-items: center;
			justify-content: center;
			padding: 8px;
		}
		.create_profile_section .btn-remove-block-icon svg {
			display: block;
		}
		.create_profile_section .btn-remove-block:hover {
			background: #c00;
			color: #fff;
		}
		#guest-apply-form input[name="guest_email"],
		#guest-apply-form .input-guest-email {
			pointer-events: auto !important;
			user-select: text !important;
			-webkit-user-select: text !important;
		}
		/* Already used email / already applied: force error to be visible (overrides any hiding). */
		#guest-apply-form.guest-form-has-already-applied-error #guest-ajax-error-summary,
		#guest-apply-form.guest-form-has-already-applied-error .field-error {
			display: block !important;
		}
	</style>

	<section class="create_profile_section pt_80 pb_80">
		<div class="wrap">
			<div class="create_profile_container">
				<div class="create_profile_content">
					<h3 class="h3_title_50 pb_5 text_center mb_20"><?php esc_html_e( 'Apply as a Guest', 'tasheel' ); ?></h3>

					<?php if ( ! $apply_to ) : ?>
						<p class="guest-apply-no-job" style="margin-bottom: 2em; color: #666;">
							<?php esc_html_e( 'To apply as a guest, please go to the Corporate Training page, choose a program, and click Apply. Then select "Apply as a Guest" to open this form with your chosen program.', 'tasheel' ); ?>
						</p>
						<p><a href="<?php echo esc_url( home_url( '/corporate-training/' ) ); ?>" class="btn_style but_black"><?php esc_html_e( 'View Training Programs', 'tasheel' ); ?></a></p>
					<?php elseif ( $user_logged_in_on_guest_page ) : ?>
						<p class="guest-apply-logged-in" style="margin-bottom: 1em; color: #842029; font-weight: 600;"><?php esc_html_e( 'You already have an account.', 'tasheel' ); ?></p>
						<p style="margin-bottom: 1.5em;"><?php esc_html_e( 'Please use your account to apply for this position.', 'tasheel' ); ?></p>
						<?php
						$my_profile_url = function_exists( 'tasheel_hr_my_profile_url' ) ? tasheel_hr_my_profile_url( $apply_to ) : add_query_arg( 'apply_to', $apply_to, home_url( '/my-profile/' ) );
						?>
						<p><a href="<?php echo esc_url( $my_profile_url ); ?>" class="btn_style but_black"><?php esc_html_e( 'Apply with my account', 'tasheel' ); ?></a></p>
					<?php else : ?>
						<?php
						$job = get_post( $apply_to );
						$is_training = $job && $job->post_type === ( function_exists( 'tasheel_hr_job_post_type' ) ? tasheel_hr_job_post_type() : 'hr_job' ) && function_exists( 'tasheel_hr_get_job_type_slug' ) && function_exists( 'tasheel_hr_normalize_job_type_slug' ) && tasheel_hr_normalize_job_type_slug( tasheel_hr_get_job_type_slug( $apply_to ) ) === 'corporate_training';
						if ( ! $is_training ) :
							?>
							<p class="guest-apply-bad-job" style="margin-bottom: 2em; color: #842029;"><?php esc_html_e( 'Guest application is only available for Corporate Training programs. Please select a training program from the Corporate Training page.', 'tasheel' ); ?></p>
						<?php else : ?>
							<?php if ( $guest_error === 'missing' && ! empty( $field_errors ) ) : ?>
								<p class="guest-apply-error" style="margin-bottom: 1em; color: #842029;"><?php esc_html_e( 'Please fill in all required fields.', 'tasheel' ); ?></p>
							<?php elseif ( $guest_error === 'email' ) : ?>
								<p class="guest-apply-error" style="margin-bottom: 1em; color: #842029;"><?php esc_html_e( 'Please enter a valid email address.', 'tasheel' ); ?></p>
							<?php elseif ( $guest_error === 'training' ) : ?>
								<p class="guest-apply-error" style="margin-bottom: 1em; color: #842029;"><?php esc_html_e( 'Please select Start Date and Duration.', 'tasheel' ); ?></p>
							<?php elseif ( $guest_error === 'expired' ) : ?>
								<p class="guest-apply-error" style="margin-bottom: 1em; color: #842029;"><?php esc_html_e( 'Your review session has expired. Please fill in the form and click Review Profile again.', 'tasheel' ); ?></p>
							<?php elseif ( $guest_error === 'already_applied' ) : ?>
								<p id="guest-already-applied-error" class="guest-apply-error" style="display: block !important; margin-bottom: 1em; color: #842029;"><?php esc_html_e( "You cannot apply—you have already applied to this job.", 'tasheel' ); ?></p>
							<?php elseif ( $guest_error === 'logged_in' ) : ?>
								<p class="guest-apply-error" style="margin-bottom: 1em; color: #842029;"><?php esc_html_e( 'You already have an account. Please use your account to apply.', 'tasheel' ); ?></p>
							<?php endif; ?>

							<p id="guest-ajax-error-summary" class="guest-apply-error" style="display: none; margin-bottom: 1em; color: #842029;" aria-live="polite"></p>
							<form method="post" action="<?php echo esc_url( home_url( '/apply-as-a-guest/' ) ); ?>" enctype="multipart/form-data" class="guest-apply-form create-profile-form<?php echo $guest_error === 'already_applied' ? ' guest-form-has-already-applied-error' : ''; ?>" id="guest-apply-form" data-save-ajax-url="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>" novalidate>
								<?php wp_nonce_field( 'tasheel_hr_guest_apply_' . $apply_to, '_wpnonce' ); ?>
								<input type="hidden" name="tasheel_hr_guest_apply" value="1" />
								<input type="hidden" name="apply_to" value="<?php echo (int) $apply_to; ?>" />
								<input type="hidden" name="step" value="review" />
								<?php if ( $review_token ) : ?><input type="hidden" name="review_token" value="<?php echo esc_attr( $review_token ); ?>" /><?php endif; ?>

								<?php
								get_template_part( 'template-parts/form-profile-corporate-training', null, array(
									'profile_data'        => $guest_data,
									'field_errors'        => $field_errors,
									'edu_list'            => $edu_list,
									'is_guest'            => true,
									'guest_email_editable' => true,
								) );
								?>

								<div class="form-group">
									<div class="related_jobs_section_content">
										<h5><?php esc_html_e( 'Training Program Enrollment', 'tasheel' ); ?></h5>
									</div>
									<ul class="career-form-list-ul form-col-2">
										<li>
											<div class="select-wrapper">
												<select class="input select-input" name="start_date" required>
													<option value=""><?php esc_html_e( 'Start Date *', 'tasheel' ); ?></option>
													<option value="2026-01" <?php selected( $edit_start_date, '2026-01' ); ?>><?php esc_html_e( 'January 2026', 'tasheel' ); ?></option>
													<option value="2026-02" <?php selected( $edit_start_date, '2026-02' ); ?>><?php esc_html_e( 'February 2026', 'tasheel' ); ?></option>
													<option value="2026-03" <?php selected( $edit_start_date, '2026-03' ); ?>><?php esc_html_e( 'March 2026', 'tasheel' ); ?></option>
													<option value="2026-04" <?php selected( $edit_start_date, '2026-04' ); ?>><?php esc_html_e( 'April 2026', 'tasheel' ); ?></option>
												</select>
												<span class="select-arrow"></span>
											</div>
										</li>
										<li>
											<div class="select-wrapper">
												<select class="input select-input" name="duration" required>
													<option value=""><?php esc_html_e( 'Duration Time *', 'tasheel' ); ?></option>
													<option value="1-month" <?php selected( $edit_duration, '1-month' ); ?>><?php esc_html_e( '1 Month', 'tasheel' ); ?></option>
													<option value="3-months" <?php selected( $edit_duration, '3-months' ); ?>><?php esc_html_e( '3 Months', 'tasheel' ); ?></option>
													<option value="6-months" <?php selected( $edit_duration, '6-months' ); ?>><?php esc_html_e( '6 Months', 'tasheel' ); ?></option>
													<option value="12-months" <?php selected( $edit_duration, '12-months' ); ?>><?php esc_html_e( '12 Months', 'tasheel' ); ?></option>
												</select>
												<span class="select-arrow"></span>
											</div>
										</li>
									</ul>
								</div>

								<div class="form-buttion-row flex-align-right">
									<button type="submit" class="btn_style btn_transparent but_black"><?php esc_html_e( 'Review Profile', 'tasheel' ); ?></button>
								</div>
							</form>
						<?php endif; ?>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</section>

</main><!-- #main -->

<?php if ( $apply_to ) : ?>
<?php
	$phone_min_digits_guest = function_exists( 'tasheel_hr_profile_phone_min_digits' ) ? tasheel_hr_profile_phone_min_digits() : 8;
	$phone_label_guest = function_exists( 'tasheel_hr_profile_field_error_label' ) ? tasheel_hr_profile_field_error_label( 'profile_phone' ) : __( 'Phone', 'tasheel' );
	$phone_msg_min_guest = $phone_label_guest . ' ' . sprintf( /* translators: %d: minimum number of digits */ __( 'must be at least %d digits.', 'tasheel' ), $phone_min_digits_guest );
?>
<script>
(function() {
	// When page loads with "already applied" error (server-rendered), scroll to it after paint.
	var alreadyAppliedErr = document.getElementById('guest-already-applied-error');
	if (alreadyAppliedErr) {
		setTimeout(function() {
			alreadyAppliedErr.scrollIntoView({ behavior: 'smooth', block: 'center' });
		}, 150);
	}
	var form = document.getElementById('guest-apply-form');
	if (!form) return;
	var ajaxUrl = form.getAttribute('data-save-ajax-url') || '';
	var errorSummary = document.getElementById('guest-ajax-error-summary');
	var phoneMinDigits = <?php echo (int) $phone_min_digits_guest; ?>;
	var phoneMsgMin = <?php echo wp_json_encode( $phone_msg_min_guest ); ?>;
	var photoMsgExt = <?php echo wp_json_encode( __( 'Only PNG, JPG and JPEG images are allowed.', 'tasheel' ) ); ?>;
	var photoMsgSize = <?php echo wp_json_encode( __( 'Profile photo must be 1MB or less.', 'tasheel' ) ); ?>;
	var photoMaxBytes = 1024 * 1024;

	function clearGuestErrors() {
		if (errorSummary) {
			errorSummary.style.display = 'none';
			errorSummary.textContent = '';
		}
		form.querySelectorAll('.has-error').forEach(function(el) { el.classList.remove('has-error'); });
		form.querySelectorAll('.field-error, .section-error').forEach(function(el) {
			var p = el.parentNode;
			if (p && (p.classList.contains('resume-upload-wrapper') || p.classList.contains('form-group') || p.classList.contains('js-education-group') || p.classList.contains('file-upload-section-wrapper'))) {
				el.textContent = '';
				el.style.display = 'none';
			} else {
				el.remove();
			}
		});
	}

	function showFieldError(key, message) {
		var container = null;
		if (key === 'profile_photo') {
			container = form.querySelector('.file-upload-section-wrapper');
			if (container) {
				container.classList.add('has-error');
				var errEl = container.querySelector('.field-error');
				if (!errEl) {
					errEl = document.createElement('span');
					errEl.className = 'field-error';
					errEl.id = 'profile-photo-field-error';
					errEl.style.color = '#842029';
					container.insertBefore(errEl, container.firstChild);
				}
				errEl.textContent = message;
				errEl.style.display = 'block';
				errEl.style.color = '#842029';
			}
		} else if (key === 'profile_resume') {
			container = document.getElementById('guest-resume-upload-container');
			if (container) {
				container.classList.add('has-error');
				var area = container.querySelector('.resume-upload-area');
				var errEl = area ? area.querySelector('.section-error, .field-error') : null;
				if (!errEl) {
					errEl = document.createElement('p');
					errEl.className = 'section-error';
					errEl.style.color = '#842029';
					if (area) area.appendChild(errEl);
					else container.appendChild(errEl);
				}
				errEl.textContent = message;
				errEl.style.display = 'block';
				errEl.style.color = '#842029';
			}
		} else if (key === 'profile_education') {
			container = form.querySelector('.js-education-group');
			if (container) {
				container.classList.add('has-error');
				var errEl = container.querySelector('.section-error');
				if (!errEl) {
					errEl = document.createElement('p');
					errEl.className = 'section-error';
					errEl.style.color = '#842029';
					var first = container.querySelector('.js-education-blocks');
					if (first) container.insertBefore(errEl, first);
					else container.appendChild(errEl);
				}
				errEl.textContent = message;
				errEl.style.display = 'block';
				errEl.style.color = '#842029';
			}
		} else if (key.indexOf('profile_education_') === 0 && /^profile_education_\d+_.+$/.test(key)) {
			// Per-field education keys: profile_education_0_degree, profile_education_0_institute, etc.
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
					var control = null;
					block.querySelectorAll('input, select').forEach(function(el) {
						if (el.getAttribute('name') === needName) control = el;
					});
					if (control) {
						container = control.closest('li') || control.closest('.form-group') || control.parentElement;
						if (container) {
							container.classList.add('has-error');
							var errEl = container.querySelector('.field-error');
							if (!errEl) {
								errEl = document.createElement('span');
								errEl.className = 'field-error';
								errEl.style.display = 'block';
								errEl.style.color = '#842029';
								errEl.style.marginTop = '4px';
								container.appendChild(errEl);
							}
							errEl.textContent = message;
							errEl.style.display = 'block';
							errEl.style.color = '#842029';
						}
					}
				}
			}
		} else {
			var control = form.querySelector('[name="' + key + '"]');
			if (control) {
				container = control.closest('li') || control.closest('.form-group') || control.parentElement;
				if (container) {
					container.classList.add('has-error');
					var errEl = container.querySelector('.field-error');
					if (!errEl) {
						errEl = document.createElement('span');
						errEl.className = 'field-error';
						errEl.style.display = 'block';
						errEl.style.color = '#842029';
						errEl.style.marginTop = '4px';
						container.appendChild(errEl);
					}
					errEl.textContent = message;
					if (form.classList.contains('guest-form-has-already-applied-error')) {
						errEl.style.setProperty('display', 'block', 'important');
					} else {
						errEl.style.display = 'block';
					}
					errEl.style.color = '#842029';
				}
			}
		}
		return container;
	}

	form.addEventListener('submit', function(e) {
		if (!ajaxUrl) return;
		e.preventDefault();
		clearGuestErrors();
		var photoInput = form.querySelector('input[name="profile_photo"]');
		if (photoInput && photoInput.files && photoInput.files.length > 0) {
			var file = photoInput.files[0];
			var ext = (file.name || '').split('.').pop().toLowerCase();
			var allowedExts = ['jpg', 'jpeg', 'png'];
			if (allowedExts.indexOf(ext) === -1) {
				if (errorSummary) { errorSummary.textContent = '<?php echo esc_js( __( 'Please fix the errors below.', 'tasheel' ) ); ?>'; errorSummary.style.display = 'block'; }
				var el = showFieldError('profile_photo', photoMsgExt);
				if (el) el.scrollIntoView({ behavior: 'smooth', block: 'center' });
				return;
			}
			if (file.size > photoMaxBytes) {
				if (errorSummary) { errorSummary.textContent = '<?php echo esc_js( __( 'Please fix the errors below.', 'tasheel' ) ); ?>'; errorSummary.style.display = 'block'; }
				var el = showFieldError('profile_photo', photoMsgSize);
				if (el) el.scrollIntoView({ behavior: 'smooth', block: 'center' });
				return;
			}
		}
		var phoneEl = form.querySelector('input[name="profile_phone"]');
		if (phoneEl) {
			var val = (phoneEl.value || '').trim();
			var digits = (val || '').replace(/\D/g, '');
			if (val !== '' && digits.length < phoneMinDigits) {
				if (errorSummary) {
					errorSummary.textContent = '<?php echo esc_js( __( 'Please fix the errors below.', 'tasheel' ) ); ?>';
					errorSummary.style.display = 'block';
				}
				var el = showFieldError('profile_phone', phoneMsgMin);
				if (el) el.scrollIntoView({ behavior: 'smooth', block: 'center' });
				return;
			}
		}
		var formData = new FormData(form);
		formData.append('action', 'tasheel_hr_guest_apply_review_ajax');
		var submitBtn = form.querySelector('button[type="submit"]');
		var btnText = submitBtn ? submitBtn.textContent : '';
		if (submitBtn) {
			submitBtn.disabled = true;
			submitBtn.textContent = '<?php echo esc_js( __( 'Please wait...', 'tasheel' ) ); ?>';
		}
		fetch(ajaxUrl, { method: 'POST', body: formData })
			.then(function(r) { return r.json(); })
			.then(function(body) {
				if (submitBtn) {
					submitBtn.disabled = false;
					submitBtn.textContent = btnText;
				}
				if (body && body.success && body.data && body.data.redirect) {
					window.location.href = body.data.redirect;
					return;
				}
				var data = body && body.data ? body.data : {};
				var code = data.code;
				var msg = data.message || '<?php echo esc_js( __( 'Please fix the errors below.', 'tasheel' ) ); ?>';
				if (code === 'missing' && data.field_errors) {
					if (errorSummary) {
						errorSummary.textContent = '<?php echo esc_js( __( 'Please fix the errors below.', 'tasheel' ) ); ?>';
						errorSummary.style.display = 'block';
					}
					var firstErr = null;
					Object.keys(data.field_errors).forEach(function(key) {
						var el = showFieldError(key, data.field_errors[key]);
						if (el && !firstErr) firstErr = el;
					});
					if (firstErr) firstErr.scrollIntoView({ behavior: 'smooth', block: 'center' });
				} else {
					if (code === 'already_applied') {
						form.classList.add('guest-form-has-already-applied-error');
					}
					if (errorSummary) {
						errorSummary.textContent = msg;
						errorSummary.style.display = 'block';
						if (code === 'already_applied') {
							errorSummary.style.setProperty('display', 'block', 'important');
						}
					}
					if ((code === 'email' || code === 'already_applied') && data.field_errors) {
						var firstErr = null;
						Object.keys(data.field_errors).forEach(function(key) {
							var el = showFieldError(key, data.field_errors[key]);
							if (el && !firstErr) firstErr = el;
						});
						if (firstErr) firstErr.scrollIntoView({ behavior: 'smooth', block: 'center' });
					} else if (code === 'already_applied' && errorSummary) {
						setTimeout(function() {
							errorSummary.scrollIntoView({ behavior: 'smooth', block: 'center' });
						}, 100);
					}
				}
			})
			.catch(function() {
				if (submitBtn) {
					submitBtn.disabled = false;
					submitBtn.textContent = btnText;
				}
				if (errorSummary) {
					errorSummary.textContent = '<?php echo esc_js( __( 'Something went wrong. Please try again.', 'tasheel' ) ); ?>';
					errorSummary.style.display = 'block';
				}
			});
	});

	var emailInput = form.querySelector('input[name="guest_email"]');
	if (emailInput) {
		emailInput.removeAttribute('readonly');
		emailInput.removeAttribute('disabled');
	}
	// Show selected file name for resume and portfolio (guest form only).
	var resumeInput = form.querySelector('input[name="profile_resume"]');
	var portfolioInput = form.querySelector('input[name="profile_portfolio"]');
	function showFileName(input, label) {
		var area = input && input.closest('.resume-upload-area');
		var nameEl = area && area.querySelector('.resume-file-name');
		if (!nameEl) return;
		var file = input.files && input.files[0];
		if (file) {
			nameEl.textContent = label + ' ' + file.name;
			nameEl.style.display = 'block';
			nameEl.style.marginTop = '8px';
		} else {
			nameEl.textContent = '';
			nameEl.style.display = 'none';
		}
	}
	if (resumeInput) {
		resumeInput.addEventListener('change', function() { showFileName(this, 'Selected:'); });
	}
	if (portfolioInput) {
		portfolioInput.addEventListener('change', function() { showFileName(this, 'Selected:'); });
	}
	var eduBlocks = form.querySelector('.js-education-blocks');
	var removeBtnSvg = '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>';
	function ensureRemoveButton(clone, btnClass, ariaLabel) {
		if (clone.querySelector(btnClass)) return;
		var wrap = document.createElement('div');
		wrap.className = 'block-actions mt_10';
		var btn = document.createElement('button');
		btn.type = 'button';
		btn.className = btnClass.replace('.', '') + ' btn-remove-block btn-remove-block-icon';
		btn.setAttribute('aria-label', ariaLabel);
		btn.innerHTML = removeBtnSvg;
		wrap.appendChild(btn);
		clone.appendChild(wrap);
	}
	function cloneAndRename(node, index) {
		var clone = node.cloneNode(true);
		clone.querySelectorAll('[name]').forEach(function(inp) {
			var name = inp.getAttribute('name');
			var m = name && name.match(/^([^\[]+)\[\d+\](.*)$/);
			if (m) { inp.setAttribute('name', m[1] + '[' + index + ']' + m[2]); }
			if (inp.type === 'checkbox') inp.checked = false;
			else if (inp.tagName === 'SELECT') inp.selectedIndex = 0;
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
	if (eduBlocks) {
		form.addEventListener('click', function(e) {
			var btn = e.target.closest('.js-remove-education');
			if (!btn) return;
			e.preventDefault();
			var block = btn.closest('.js-education-block');
			if (!block || !eduBlocks) return;
			var blocks = eduBlocks.querySelectorAll('.js-education-block');
			if (blocks.length <= 1) return;
			var prev = block.previousElementSibling;
			if (prev && prev.classList.contains('education-block-divider')) prev.remove();
			block.remove();
			reindexBlocks(eduBlocks, '.js-education-block');
		});
		var eduBtn = form.querySelector('.btn_add_more_education');
		if (eduBtn) {
			eduBtn.addEventListener('click', function() {
				var last = eduBlocks.querySelector('.js-education-block:last-child');
				if (!last) return;
				var idx = eduBlocks.querySelectorAll('.js-education-block').length;
				var div = document.createElement('div');
				div.className = 'education-block-divider';
				eduBlocks.appendChild(div);
				var clone = cloneAndRename(last, idx);
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
	}
})();
</script>
<?php endif; ?>

<?php
get_footer();
