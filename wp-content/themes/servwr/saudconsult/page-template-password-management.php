<?php
/**
 * Template Name: Password Management
 *
 * The template for displaying the Password Management page
 *
 * @package tasheel
 */
global $header_custom_class;
$header_custom_class = 'black-header';

// Require login: redirect to home so user can use the site login popup; preserve intended URL for after login.
if ( ! is_user_logged_in() ) {
	$intended = isset( $_SERVER['REQUEST_URI'] ) ? esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : home_url( '/password-management/' );
	$redirect = add_query_arg( array( 'redirect_to' => rawurlencode( $intended ), 'open_login' => '1' ), home_url( '/' ) );
	wp_safe_redirect( $redirect );
	exit;
}

get_header();
?>

<main id="primary" class="site-main no_banner_section" style="background: #EDF3E4;">
 

	<?php 
	$current_page   = get_queried_object();
	$active_tab     = ( $current_page && isset( $current_page->post_name ) ) ? $current_page->post_name : 'password-management';
	$page_tabs_data = function_exists( 'tasheel_get_profile_tabs' ) ? tasheel_get_profile_tabs( $active_tab, get_queried_object_id() ) : array(
		'tabs'       => array(
			array( 'id' => 'my-job', 'title' => __( 'My Jobs', 'tasheel' ), 'link' => esc_url( home_url( '/my-job/' ) ) ),
			array( 'id' => 'my-profile', 'title' => __( 'My Profile', 'tasheel' ), 'link' => esc_url( home_url( '/my-profile/' ) ) ),
			array( 'id' => 'password-management', 'title' => __( 'Password Management', 'tasheel' ), 'link' => esc_url( home_url( '/password-management/' ) ) ),
		),
		'active_tab'  => $active_tab,
		'nav_class'   => 'profile-tabs-nav',
		'logout_url'  => is_user_logged_in() ? wp_logout_url( home_url( '/' ) ) : '',
	);
	get_template_part( 'template-parts/page-tabs', null, $page_tabs_data ); 
	?>

	<?php
	$password_message = array();
	$user_id = get_current_user_id();
	if ( $user_id ) {
		$password_message = get_transient( 'tasheel_password_change_message_' . $user_id );
		if ( is_array( $password_message ) ) {
			delete_transient( 'tasheel_password_change_message_' . $user_id );
		} else {
			$password_message = array();
		}
	}
	?>
	<section class="password_management_section pt_80 pb_80">
		<div class="wrap">
			<div class="password_management_container">
				<div class="password_management_content">
					<div class="profile-title-block text-center-title">
						<h3 class="h3_title_50 pb_5 text_center mb_20"><?php esc_html_e( 'Password Management', 'tasheel' ); ?></h3>
					</div>

					<?php if ( ! empty( $password_message['success'] ) ) : ?>
						<div class="password_management_message password_management_message--success" role="alert" style="text-align: center;">
							<?php echo esc_html( $password_message['success'] ); ?>
						</div>
					<?php endif; ?>
					<?php
					$field_errors = isset( $password_message['field_errors'] ) && is_array( $password_message['field_errors'] ) ? $password_message['field_errors'] : array();
					$show_general_error = ! empty( $password_message['error'] ) && empty( $field_errors );
					?>
					<?php if ( $show_general_error ) : ?>
						<div class="password_management_message password_management_message--error" role="alert">
							<?php echo esc_html( $password_message['error'] ); ?>
						</div>
					<?php endif; ?>
					<div class="password_management_message password_management_message--success" id="password-ajax-message-success" role="alert" style="display: none;" style="text-align: center;"></div>
					<div class="password_management_message password_management_message--error" id="password-ajax-message-error" role="alert" style="display: none;"></div>
					<form class="password_management_form" id="password-change-form" method="post" action="<?php echo esc_url( home_url( '/password-management/' ) ); ?>" novalidate data-ajax-url="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>">
						<?php wp_nonce_field( 'tasheel_change_password', 'tasheel_change_password_nonce' ); ?>
						<ul class="career-form-list-ul">
							<li class="<?php echo ! empty( $field_errors['current_password'] ) ? 'has-error' : ''; ?>">
								<div class="password-input-wrapper">
									<input class="input" type="password" name="current_password" id="current_password" placeholder="<?php esc_attr_e( 'Current Password *', 'tasheel' ); ?>" required autocomplete="current-password" aria-describedby="error-current_password" aria-invalid="<?php echo ! empty( $field_errors['current_password'] ) ? 'true' : 'false'; ?>">
									<span class="form-icon password-toggle-btn" role="button" tabindex="0" aria-label="<?php esc_attr_e( 'Show password', 'tasheel' ); ?>" data-toggle-for="current_password">
										<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/eye-icn.svg' ); ?>" alt="<?php echo esc_attr__( 'Toggle password visibility', 'tasheel' ); ?>">
									</span>
								</div>
								<span class="password-field-error" id="error-current_password" data-field="current_password" role="alert" aria-live="polite"><?php echo ! empty( $field_errors['current_password'] ) ? esc_html( $field_errors['current_password'] ) : ''; ?></span>
							</li>
							<li class="<?php echo ! empty( $field_errors['new_password'] ) ? 'has-error' : ''; ?>">
								<div class="password-input-wrapper">
									<input class="input" type="password" name="new_password" id="new_password" placeholder="<?php esc_attr_e( 'New Password *', 'tasheel' ); ?>" required minlength="6" autocomplete="new-password" aria-describedby="error-new_password" aria-invalid="<?php echo ! empty( $field_errors['new_password'] ) ? 'true' : 'false'; ?>">
									<span class="form-icon password-toggle-btn" role="button" tabindex="0" aria-label="<?php esc_attr_e( 'Show password', 'tasheel' ); ?>" data-toggle-for="new_password">
										<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/eye-icn.svg' ); ?>" alt="<?php echo esc_attr__( 'Toggle password visibility', 'tasheel' ); ?>">
									</span>
								</div>
								<span class="password-field-error" id="error-new_password" data-field="new_password" role="alert" aria-live="polite"><?php echo ! empty( $field_errors['new_password'] ) ? esc_html( $field_errors['new_password'] ) : ''; ?></span>
							</li>
							<li class="<?php echo ! empty( $field_errors['new_password_confirm'] ) ? 'has-error' : ''; ?>">
								<div class="password-input-wrapper">
									<input class="input" type="password" name="new_password_confirm" id="new_password_confirm" placeholder="<?php esc_attr_e( 'Retype New Password *', 'tasheel' ); ?>" required minlength="6" autocomplete="new-password" aria-describedby="error-new_password_confirm" aria-invalid="<?php echo ! empty( $field_errors['new_password_confirm'] ) ? 'true' : 'false'; ?>">
									<span class="form-icon password-toggle-btn" role="button" tabindex="0" aria-label="<?php esc_attr_e( 'Show password', 'tasheel' ); ?>" data-toggle-for="new_password_confirm">
										<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/eye-icn.svg' ); ?>" alt="<?php echo esc_attr__( 'Toggle password visibility', 'tasheel' ); ?>">
									</span>
								</div>
								<span class="password-field-error" id="error-new_password_confirm" data-field="new_password_confirm" role="alert" aria-live="polite"><?php echo ! empty( $field_errors['new_password_confirm'] ) ? esc_html( $field_errors['new_password_confirm'] ) : ''; ?></span>
							</li>
						</ul>

						<button type="submit" class="btn_style but_black but-position w_100" id="password-change-submit" data-normal-text="<?php echo esc_attr( __( 'Change Password', 'tasheel' ) ); ?>" data-submitting-text="<?php echo esc_attr( __( 'Submitting…', 'tasheel' ) ); ?>"><?php esc_html_e( 'Change Password', 'tasheel' ); ?></button>
					</form>
				</div>
			</div>
		</div>
	</section>

</main><!-- #main -->

<style>
#password-change-submit.is-loading {
	cursor: wait;
	opacity: 0.85;
	position: relative;
}
#password-change-submit.is-loading::after {
	content: '';
	position: absolute;
	width: 1em;
	height: 1em;
	border: 2px solid currentColor;
	border-right-color: transparent;
	border-radius: 50%;
	animation: password-btn-spin 0.6s linear infinite;
	right: 1em;
	top: 50%;
	margin-top: -0.5em;
}
@keyframes password-btn-spin {
	to { transform: rotate(360deg); }
}
</style>
<script>
var tasheelPasswordMessages = {
	currentPasswordRequired: <?php echo json_encode( __( 'Please enter your current password.', 'tasheel' ) ); ?>,
	newPasswordRequired: <?php echo json_encode( __( 'Please enter a new password.', 'tasheel' ) ); ?>,
	retypeNewPassword: <?php echo json_encode( __( 'Please retype your new password.', 'tasheel' ) ); ?>,
	passwordsDoNotMatch: <?php echo json_encode( __( 'New passwords do not match.', 'tasheel' ) ); ?>,
	newPasswordDifferent: <?php echo json_encode( __( 'New password must be different from your current password.', 'tasheel' ) ); ?>,
	minLength: <?php echo json_encode( __( 'New password must be at least 6 characters.', 'tasheel' ) ); ?>,
	strengthRequirement: <?php echo json_encode( __( 'Password must include at least one uppercase letter, one lowercase letter, one digit, and one special character.', 'tasheel' ) ); ?>,
	somethingWentWrong: <?php echo json_encode( __( 'Something went wrong. Please try again.', 'tasheel' ) ); ?>,
	showPassword: <?php echo json_encode( __( 'Show password', 'tasheel' ) ); ?>,
	hidePassword: <?php echo json_encode( __( 'Hide password', 'tasheel' ) ); ?>
};
</script>
<script>
(function() {
	var form = document.getElementById('password-change-form');
	if (!form) return;
	var msg = typeof tasheelPasswordMessages !== 'undefined' ? tasheelPasswordMessages : {};
	var current = form.querySelector('#current_password');
	var newPass = form.querySelector('#new_password');
	var newConfirm = form.querySelector('#new_password_confirm');
	var minLength = 6;
	var matchMsg = msg.passwordsDoNotMatch || 'New passwords do not match.';
	var sameAsCurrentMsg = msg.newPasswordDifferent || 'New password must be different from your current password.';
	var strengthMsg = msg.strengthRequirement || 'Password must include at least one uppercase letter, one lowercase letter, one digit, and one special character.';

	function passwordStrong(p) {
		return p && p.length >= 6 && /[a-z]/.test(p) && /[A-Z]/.test(p) && /[0-9]/.test(p) && /[^a-zA-Z0-9]/.test(p);
	}

	function getErrorEl(fieldName) {
		return form.querySelector('.password-field-error[data-field="' + fieldName + '"]');
	}
	function getLi(input) {
		return input ? input.closest('li') : null;
	}
	function setFieldError(fieldName, message) {
		var el = getErrorEl(fieldName);
		var input = form.querySelector('[name="' + fieldName + '"]');
		var li = getLi(input);
		if (el) el.textContent = message || '';
		if (li) li.classList.toggle('has-error', !!message);
		if (input) input.setAttribute('aria-invalid', message ? 'true' : 'false');
	}
	function clearAllErrors() {
		setFieldError('current_password', '');
		setFieldError('new_password', '');
		setFieldError('new_password_confirm', '');
	}
	function checkConfirmMatch() {
		var newVal = newPass ? newPass.value : '';
		var confVal = newConfirm ? newConfirm.value : '';
		if (confVal === '') {
			setFieldError('new_password_confirm', '');
		} else if (newVal !== confVal) {
			setFieldError('new_password_confirm', matchMsg);
		} else {
			setFieldError('new_password_confirm', '');
		}
	}

	function validate() {
		clearAllErrors();
		var valid = true;
		var curVal = current ? current.value.trim() : '';
		var newVal = newPass ? newPass.value : '';
		var confVal = newConfirm ? newConfirm.value : '';

		if (curVal === '') {
			setFieldError('current_password', msg.currentPasswordRequired || 'Please enter your current password.');
			valid = false;
		}
		if (newVal === '') {
			setFieldError('new_password', msg.newPasswordRequired || 'Please enter a new password.');
			valid = false;
		} else if (newVal.length < minLength) {
			setFieldError('new_password', msg.minLength || 'New password must be at least 6 characters.');
			valid = false;
		} else if (!passwordStrong(newVal)) {
			setFieldError('new_password', strengthMsg);
			valid = false;
		} else if (curVal !== '' && newVal === curVal) {
			setFieldError('new_password', sameAsCurrentMsg);
			valid = false;
		}
		if (confVal === '') {
			setFieldError('new_password_confirm', msg.retypeNewPassword || 'Please retype your new password.');
			valid = false;
		} else if (newVal !== confVal) {
			setFieldError('new_password_confirm', matchMsg);
			valid = false;
		}
		return valid;
	}

		var ajaxSuccessEl = document.getElementById('password-ajax-message-success');
		var ajaxErrorEl = document.getElementById('password-ajax-message-error');
		var submitBtn = document.getElementById('password-change-submit');
		var ajaxUrl = form.getAttribute('data-ajax-url');
		if (!ajaxUrl) ajaxUrl = (typeof tasheelPasswordChange !== 'undefined' && tasheelPasswordChange.ajaxUrl) ? tasheelPasswordChange.ajaxUrl : '';

	form.addEventListener('submit', function(e) {
		if (!validate()) {
			e.preventDefault();
			var firstLi = form.querySelector('li.has-error');
			if (firstLi) {
				var inp = firstLi.querySelector('input');
				if (inp) inp.focus();
			}
			return false;
		}
		if (ajaxUrl) {
			e.preventDefault();
			if (ajaxSuccessEl) ajaxSuccessEl.style.display = 'none';
			if (ajaxErrorEl) ajaxErrorEl.style.display = 'none';
			clearAllErrors();
			if (submitBtn) {
				submitBtn.disabled = true;
				submitBtn.classList.add('is-loading');
				submitBtn.textContent = submitBtn.getAttribute('data-submitting-text') || 'Submitting…';
			}
			var formData = new FormData(form);
			formData.append('action', 'tasheel_change_password');
			fetch(ajaxUrl, {
				method: 'POST',
				body: formData,
				credentials: 'same-origin'
			}).then(function(res) { return res.json(); }).then(function(data) {
				if (submitBtn) {
					submitBtn.disabled = false;
					submitBtn.classList.remove('is-loading');
					submitBtn.textContent = submitBtn.getAttribute('data-normal-text') || 'Change Password';
				}
				if (data && data.success) {
					if (ajaxErrorEl) ajaxErrorEl.style.display = 'none';
					if (ajaxSuccessEl) {
						ajaxSuccessEl.textContent = data.data && data.data.message ? data.data.message : '';
						ajaxSuccessEl.style.display = 'block';
					}
					form.reset();
					clearAllErrors();
					return;
				}
				var errs = data && data.data && data.data.field_errors ? data.data.field_errors : {};
				if (errs.current_password) setFieldError('current_password', errs.current_password);
				if (errs.new_password) setFieldError('new_password', errs.new_password);
				if (errs.new_password_confirm) setFieldError('new_password_confirm', errs.new_password_confirm);
				// Show general error only when there are no field-specific errors (e.g. nonce failure)
				var hasFieldErrors = errs.current_password || errs.new_password || errs.new_password_confirm;
				if (!hasFieldErrors && ajaxErrorEl) {
					var generalMsg = (data && data.data && data.data.message) ? data.data.message : (data && data.message) ? data.message : (msg.somethingWentWrong || 'Something went wrong. Please try again.');
					ajaxErrorEl.textContent = generalMsg;
					ajaxErrorEl.style.display = 'block';
				}
				var firstLi = form.querySelector('li.has-error');
				if (firstLi) {
					var inp = firstLi.querySelector('input');
					if (inp) inp.focus();
				}
			}).catch(function() {
				if (submitBtn) {
					submitBtn.disabled = false;
					submitBtn.classList.remove('is-loading');
					submitBtn.textContent = submitBtn.getAttribute('data-normal-text') || 'Change Password';
				}
				if (ajaxErrorEl) {
					ajaxErrorEl.textContent = msg.somethingWentWrong || 'Something went wrong. Please try again.';
					ajaxErrorEl.style.display = 'block';
				}
			});
			return false;
		}
	});

	[current, newPass, newConfirm].forEach(function(input) {
		if (!input) return;
		input.addEventListener('input', function() {
			var name = input.getAttribute('name');
			if (name) setFieldError(name, '');
			if (name === 'new_password' || name === 'new_password_confirm') {
				checkConfirmMatch();
			}
		});
		input.addEventListener('blur', function() {
			var name = input.getAttribute('name');
			if (!name) return;
			var val = input.value;
			if (name === 'current_password') return;
			if (name === 'new_password') {
				var curVal = current ? current.value : '';
				if (val && val.length < minLength) setFieldError('new_password', msg.minLength || 'New password must be at least 6 characters.');
				else if (val && !passwordStrong(val)) setFieldError('new_password', strengthMsg);
				else if (curVal && val === curVal) setFieldError('new_password', sameAsCurrentMsg);
				else setFieldError('new_password', '');
			}
			if (name === 'new_password_confirm') checkConfirmMatch();
		});
	});

	form.querySelectorAll('.password-toggle-btn').forEach(function(btn) {
		var id = btn.getAttribute('data-toggle-for');
		var input = id ? form.querySelector('#' + id) : null;
		if (!input) return;
		function toggleVisibility() {
			var isPass = input.type === 'password';
			input.type = isPass ? 'text' : 'password';
			btn.setAttribute('aria-label', isPass ? (msg.hidePassword || 'Hide password') : (msg.showPassword || 'Show password'));
		}
		btn.addEventListener('click', toggleVisibility);
		btn.addEventListener('keydown', function(e) {
			if (e.key === 'Enter' || e.key === ' ') {
				e.preventDefault();
				toggleVisibility();
			}
		});
	});
})();
</script>

<?php
get_footer();

