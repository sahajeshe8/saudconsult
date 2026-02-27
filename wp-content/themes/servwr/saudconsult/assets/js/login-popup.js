(function() {
var popup = document.getElementById('login-popup');
if (!popup) return;
var i18n = window.tasheelLoginPopupI18n || {};
var _ = function(key, fallback) { return (i18n[key] !== undefined && i18n[key] !== '') ? i18n[key] : fallback; };
var loggedIn = popup.getAttribute('data-logged-in') === '1';
var loginRedirect = popup.getAttribute('data-login-redirect') || '';
var ajaxUrl = popup.getAttribute('data-ajax-url');

// Helper: if user is logged in but page says otherwise (bfcache/cache), force reload to clean URL.
// Using location.replace ensures a fresh server render with correct auth state (same as manual reload).
function checkLoginAndCloseIfNeeded(cb) {
	if (!ajaxUrl || window.location.search.indexOf('open_login=1') === -1) {
		if (cb) cb(false);
		return;
	}
	var params = new URLSearchParams();
	params.append('action', 'tasheel_check_login');
	fetch(ajaxUrl, { method: 'POST', headers: { 'Content-Type': 'application/x-www-form-urlencoded' }, body: params.toString(), credentials: 'same-origin' })
		.then(function(r) { return r.json(); })
		.then(function(data) {
			if (data && data.success && data.data && data.data.logged_in) {
				var url = new URL(window.location.href);
				url.searchParams.delete('open_login');
				url.searchParams.delete('redirect_to');
				var cleanUrl = url.pathname + (url.search || '') + (url.hash || '');
				window.location.replace(cleanUrl);
				if (cb) cb(true);
			} else {
				if (cb) cb(false);
			}
		})
		.catch(function() { if (cb) cb(false); });
}

// On pageshow (including Back - bfcache or full reload): if open_login=1 and user is logged in, close popup.
window.addEventListener('pageshow', function(event) {
	checkLoginAndCloseIfNeeded();
});

// If redirected from protected page (open_login=1): first verify user is not actually logged in (handles cache/bfcache),
// then set redirect_to and open popup once Fancybox is ready (main.js loads in footer).
if (!loggedIn && window.location.search.indexOf('open_login=1') !== -1) {
	var params = new URLSearchParams(window.location.search);
	var redirectTo = params.get('redirect_to');
	if (redirectTo) {
		var loginForm = popup.querySelector('.apply-login-form');
		if (loginForm) {
			var redirectInput = loginForm.querySelector('input[name="redirect_to"]');
			if (redirectInput) redirectInput.value = decodeURIComponent(redirectTo);
		}
	}
	function tryOpenLoginPopup() {
		if (window._tasheelLoginPopupOpened) return true;
		if (typeof Fancybox !== 'undefined') {
			window._tasheelLoginPopupOpened = true;
			Fancybox.show([{ src: '#login-popup' }]);
			// Refresh login nonce for the visible form (and clone) so login does not fail with "session expired"
			setTimeout(function() {
				// When opened programmatically, Fancybox may clone #login-popup; keep source hidden so only one close shows
				var srcPopup = document.getElementById('login-popup');
				if (srcPopup && !srcPopup.closest('.fancybox__container')) {
					srcPopup.style.setProperty('display', 'none', 'important');
				}
				resetForgotView();
				// Re-apply redirect_to to all login forms (original + Fancybox clone) so redirect survives nonce refresh
				if (redirectTo) {
					var loginForms = document.querySelectorAll('#login-popup .apply-login-form, [id^="login-popup"] .apply-login-form');
					for (var f = 0; f < loginForms.length; f++) {
						var rdi = loginForms[f].querySelector('input[name="redirect_to"]');
						if (rdi) rdi.value = decodeURIComponent(redirectTo);
					}
				}
			}, 300);
			return true;
		}
		return false;
	}
	function maybeOpenLoginPopup() {
		// Run login check first – if user is logged in (cached page/bfcache), don't open popup.
		checkLoginAndCloseIfNeeded(function(wasLoggedIn) {
			if (wasLoggedIn) return;
			var attempts = 0;
			var maxAttempts = 100;
			var interval = setInterval(function() {
				attempts++;
				if (tryOpenLoginPopup() || attempts >= maxAttempts) clearInterval(interval);
			}, 100);
		});
	}
	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', maybeOpenLoginPopup);
	} else {
		maybeOpenLoginPopup();
	}
}
// If already logged in and URL has login-popup hash, redirect to My Profile so popup never opens
var loginPopupHash = window.location.hash && (window.location.hash === '#login-popup' || window.location.hash === '#login-popup-1' || String(window.location.hash).indexOf('#login-popup') === 0 || String(window.location.hash).indexOf('#login-popup-training') === 0 || String(window.location.hash).indexOf('#login-popup-training-submit') === 0);
if (loggedIn && loginPopupHash) {
	if (loginRedirect) {
		window.location.replace(loginRedirect);
	} else {
		history.replaceState(null, '', window.location.pathname + window.location.search);
	}
}
// If already logged in and user clicks something that would open login popup (career or training), redirect to My Profile instead.
// Exception: do NOT redirect when opening #login-popup-training-submit — that is the "Training Program Enrollment" popup
// where logged-in users pick Start Date/Duration and submit; they are already on my-profile and must not be redirected.
document.addEventListener('click', function(e) {
	if (!loggedIn || !loginRedirect) return;
	var trigger = e.target.closest('[data-fancybox="login-popup"]') || e.target.closest('[data-fancybox="login-popup-training"]') || e.target.closest('[data-fancybox="login-popup-training-submit"]') || e.target.closest('a[href="#login-popup"]') || e.target.closest('a[href="#login-popup-1"]') || e.target.closest('a[href="#login-popup-training"]') || e.target.closest('a[href="#login-popup-training-submit"]');
	if (trigger) {
		var href = (trigger.getAttribute && trigger.getAttribute('href')) || '';
		var dataFancybox = (trigger.getAttribute && trigger.getAttribute('data-fancybox')) || '';
		if (href === '#login-popup-training-submit' || dataFancybox === 'login-popup-training-submit') {
			return; // Let the training submit popup open so user can fill Start Date/Duration and submit
		}
		e.preventDefault();
		e.stopImmediatePropagation();
		window.location.href = loginRedirect;
	}
}, true);
var signin = popup.querySelector('.popup-content-signin');
var signup = popup.querySelector('.popup-content-signup');
var forgot = popup.querySelector('.popup-content-forgot');
// When popup opens: hide forgot view, clear messages, refresh login and register nonces (so real WordPress errors show; Fancybox clone can have stale nonce)
function resetForgotView() {
	if (forgot) {
		forgot.style.display = 'none';
		var msg = forgot.querySelector('.forgot-form-message');
		if (msg) { msg.style.display = 'none'; msg.textContent = ''; msg.className = 'forgot-form-message'; }
	}
	var loginMsgList = document.querySelectorAll('.login-form-message');
	for (var i = 0; i < loginMsgList.length; i++) {
		if (loginMsgList[i].closest('#login-popup') || loginMsgList[i].closest('[id^="login-popup"]')) {
			loginMsgList[i].style.display = 'none';
			loginMsgList[i].textContent = '';
			loginMsgList[i].className = 'login-form-message';
		}
	}
	var ajaxUrlForLoginNonce = popup.getAttribute('data-ajax-url');
	if (ajaxUrlForLoginNonce) {
		fetch(ajaxUrlForLoginNonce, { method: 'POST', headers: { 'Content-Type': 'application/x-www-form-urlencoded' }, body: 'action=tasheel_popup_login_get_nonce' })
			.then(function(r) { return r.json(); })
			.then(function(data) {
				if (data && data.success && data.data && data.data.nonce) {
					var loginForms = document.querySelectorAll('#login-popup .apply-login-form, [id^="login-popup"] .apply-login-form');
					for (var j = 0; j < loginForms.length; j++) {
						var lf = loginForms[j];
						var ni = lf.querySelector('input[name="tasheel_popup_login_nonce"]');
						if (ni) ni.value = data.data.nonce;
						else {
							var hid = document.createElement('input');
							hid.type = 'hidden';
							hid.name = 'tasheel_popup_login_nonce';
							hid.value = data.data.nonce;
							lf.appendChild(hid);
						}
					}
				}
			});
	}
}
document.body.addEventListener('click', function(e) {
	if (e.target.closest('[data-fancybox="login-popup"]') || e.target.closest('a[href="#login-popup"]')) {
		setTimeout(resetForgotView, 200);
	}
}, true);
// Ensure the popup close (X) always closes Fancybox when opened via open_login=1 or by link
document.addEventListener('click', function(e) {
	var closeBtn = e.target.closest('.form-close-icon');
	if (!closeBtn) return;
	var inLoginPopup = closeBtn.closest('#login-popup') || closeBtn.closest('[id^="login-popup"]') || closeBtn.closest('.job-form-popup');
	if (!inLoginPopup) return;
	if (typeof Fancybox !== 'undefined') {
		var instance = Fancybox.getInstance();
		if (instance) {
			e.preventDefault();
			e.stopPropagation();
			e.stopImmediatePropagation();
			if (window.clearPendingPopup) window.clearPendingPopup();
			instance.close();
		}
	}
}, true);
// Use document capture so we run before Fancybox; works when Fancybox shows a clone (e.g. id="login-popup-1")
function getLoginPopupContainer(el) {
	return el.closest('#login-popup') || el.closest('[id^="login-popup"]') || (el.closest('.job-form-popup') && el.closest('.job-form-popup').querySelector('.popup-content-forgot') ? el.closest('.job-form-popup') : null);
}
document.addEventListener('click', function(e) {
	var toForgot = e.target.closest('.forget-password-link') || e.target.closest('.swap-to-forgot');
	if (toForgot) {
		var container = getLoginPopupContainer(toForgot);
		if (!container) return;
		e.preventDefault();
		e.stopImmediatePropagation();
		var s = container.querySelector('.popup-content-signin');
		var u = container.querySelector('.popup-content-signup');
		var f = container.querySelector('.popup-content-forgot');
		if (s) s.style.display = 'none';
		if (u) u.style.display = 'none';
		if (f) {
			f.style.display = 'block';
			var msg = f.querySelector('.forgot-form-message');
			if (msg) { msg.style.display = 'none'; msg.textContent = ''; }
			var form = f.querySelector('.apply-forgot-form');
			var ajaxUrlForNonce = container.getAttribute('data-ajax-url') || popup.getAttribute('data-ajax-url');
			if (ajaxUrlForNonce && form) {
				fetch(ajaxUrlForNonce, { method: 'POST', headers: { 'Content-Type': 'application/x-www-form-urlencoded' }, body: 'action=tasheel_forgot_password_get_nonce' })
					.then(function(r) { return r.json(); })
					.then(function(data) {
						if (data && data.success && data.data && data.data.nonce) {
							var nonceInput = form.querySelector('input[name="tasheel_forgot_password_nonce"]');
							if (nonceInput) nonceInput.value = data.data.nonce;
							else {
								var hid = document.createElement('input');
								hid.type = 'hidden';
								hid.name = 'tasheel_forgot_password_nonce';
								hid.value = data.data.nonce;
								form.appendChild(hid);
							}
						}
					});
			}
			setTimeout(function() {
				var inp = f.querySelector('.input');
				if (inp) inp.focus();
			}, 100);
		}
		return;
	}
	// When switching to sign-in view: show signin, hide signup and forgot (works from Sign Up form or Forgot form)
	var toSignin = e.target.closest('.swap-to-signin');
	if (toSignin) {
		var container = getLoginPopupContainer(toSignin);
		if (container) {
			e.preventDefault();
			e.stopImmediatePropagation();
			var s = container.querySelector('.popup-content-signin');
			var u = container.querySelector('.popup-content-signup');
			var f = container.querySelector('.popup-content-forgot');
			if (u) u.style.display = 'none';
			if (f) f.style.display = 'none';
			if (s) {
				s.style.display = 'block';
				setTimeout(function() {
					var inp = s.querySelector('.input');
					if (inp) inp.focus();
				}, 100);
			}
		}
	}
	// When switching to sign-up view: show signup, hide signin (so it works when popup opened via open_login=1), then refresh registration nonce
	var toSignup = e.target.closest('.swap-to-signup');
	if (toSignup) {
		var container = getLoginPopupContainer(toSignup);
		if (container) {
			var signInView = container.querySelector('.popup-content-signin');
			var signUpView = container.querySelector('.popup-content-signup');
			if (signInView) signInView.style.display = 'none';
			if (signUpView) signUpView.style.display = 'block';
			setTimeout(function() {
				if (!signUpView) return;
				var ajaxUrlForRegister = container.getAttribute('data-ajax-url') || (popup && popup.getAttribute('data-ajax-url'));
				if (!ajaxUrlForRegister) return;
				fetch(ajaxUrlForRegister, { method: 'POST', headers: { 'Content-Type': 'application/x-www-form-urlencoded' }, body: 'action=tasheel_register_get_nonce' })
					.then(function(r) { return r.json(); })
					.then(function(data) {
						if (data && data.success && data.data && data.data.nonce) {
							var nonceInput = signUpView.querySelector('input[name="tasheel_register_nonce"]');
							if (nonceInput) nonceInput.value = data.data.nonce;
						}
					});
			}, 150);
		}
	}
}, true);
var ajaxUrl = popup.getAttribute('data-ajax-url');
var sendingText = _('sending', popup.getAttribute('data-sending-text') || 'Sending…');
if (ajaxUrl) {
	document.addEventListener('submit', function(e) {
		var form = e.target && e.target.closest && e.target.closest('.apply-login-form');
		if (form) {
			var container = getLoginPopupContainer(form);
			if (!container) return;
			e.preventDefault();
			e.stopImmediatePropagation();
			var msgEl = container.querySelector('.login-form-message');
			if (!msgEl) return;
			msgEl.style.display = 'none';
			msgEl.textContent = '';
			msgEl.className = 'login-form-message';
			var loginFieldErrors = container.querySelectorAll('.apply-login-form .field-error[data-field]');
			for (var lfe = 0; lfe < loginFieldErrors.length; lfe++) { loginFieldErrors[lfe].textContent = ''; }
			var submitBtn = form.querySelector('button[type="submit"]');
			var originalText = submitBtn ? submitBtn.textContent : '';
			if (submitBtn) { submitBtn.disabled = true; submitBtn.textContent = sendingText; }
			var formData = new FormData(form);
			formData.append('action', 'tasheel_popup_login');
			var loginNonceInput = form.querySelector('input[name="tasheel_popup_login_nonce"]');
			var loginNonceVal = loginNonceInput ? loginNonceInput.value : (popup && popup.querySelector('.apply-login-form input[name="tasheel_popup_login_nonce"]') && popup.querySelector('.apply-login-form input[name="tasheel_popup_login_nonce"]').value);
			if (loginNonceVal) formData.set('tasheel_popup_login_nonce', loginNonceVal);
			var xhr = new XMLHttpRequest();
			xhr.open('POST', ajaxUrl);
			xhr.onload = function() {
				if (submitBtn) { submitBtn.disabled = false; submitBtn.textContent = originalText; }
				var data;
				try { data = JSON.parse(xhr.responseText); } catch (err) {
					msgEl.className = 'login-form-message login-form-message--error';
					msgEl.textContent = _('errorGeneric', 'Something went wrong. Please try again.');
					msgEl.style.display = 'block';
					return;
				}
				if (data && data.success && data.data && data.data.redirect_to) {
					window.location.href = data.data.redirect_to;
				} else {
					var loginErrors = data && data.data && data.data.errors;
					var hasLoginFieldErrors = loginErrors && typeof loginErrors === 'object' && Object.keys(loginErrors).length > 0;
					if (hasLoginFieldErrors) {
						for (var fn in loginErrors) {
							if (loginErrors.hasOwnProperty(fn)) {
								var fel = container.querySelector('.apply-login-form .field-error[data-field="' + fn + '"]');
								if (fel) fel.textContent = loginErrors[fn] || '';
							}
						}
					}
					if (msgEl) {
						if (hasLoginFieldErrors) {
							msgEl.style.display = 'none';
							msgEl.textContent = '';
						} else {
							msgEl.className = 'login-form-message login-form-message--error';
							msgEl.textContent = (data && data.data && data.data.message) ? data.data.message : _('errorGeneric', 'Something went wrong. Please try again.');
							msgEl.style.display = 'block';
						}
					}
				}
			};
			xhr.onerror = function() {
				if (submitBtn) { submitBtn.disabled = false; submitBtn.textContent = originalText; }
				msgEl.className = 'login-form-message login-form-message--error';
				msgEl.textContent = _('errorGeneric', 'Something went wrong. Please try again.');
				msgEl.style.display = 'block';
			};
			xhr.send(formData);
			return;
		}
		// Sign Up form: validate and submit via AJAX so errors show in popup; redirect only on success
		var registerForm = e.target && e.target.closest && e.target.closest('.apply-register-form');
		if (registerForm) {
			e.preventDefault();
			e.stopImmediatePropagation();
			var container = getLoginPopupContainer(registerForm);
			if (!container) return;
			var msgEl = container.querySelector('.signup-form-message') || registerForm.querySelector('.signup-form-message');
			if (msgEl) {
				msgEl.style.display = 'none';
				msgEl.textContent = '';
				msgEl.className = 'signup-form-message';
			}
			// Clear per-field errors (only within this form so we don't touch forgot/signin fields)
			var fieldErrors = registerForm.querySelectorAll('.field-error[data-field]');
			for (var fe = 0; fe < fieldErrors.length; fe++) { fieldErrors[fe].textContent = ''; }
			var email = (registerForm.querySelector('input[name="user_email"]') || {}).value || '';
			var emailConfirm = (registerForm.querySelector('input[name="user_email_confirm"]') || {}).value || '';
			var firstName = (registerForm.querySelector('input[name="first_name"]') || {}).value || '';
			var lastName = (registerForm.querySelector('input[name="last_name"]') || {}).value || '';
			var pass = (registerForm.querySelector('input[name="user_pass"]') || {}).value || '';
			var passConfirm = (registerForm.querySelector('input[name="user_pass_confirm"]') || {}).value || '';
			function setFieldError(fieldName, message) {
				var el = registerForm.querySelector('.field-error[data-field="' + fieldName + '"]');
				if (el) el.textContent = message || '';
			}
			function passwordStrong(p) {
				return /[a-z]/.test(p) && /[A-Z]/.test(p) && /[0-9]/.test(p) && /[^a-zA-Z0-9]/.test(p);
			}
			var hasError = false;
			if (!email.trim()) { setFieldError('user_email', _('errEmailRequired', 'Please enter your email address.')); hasError = true; }
			else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) { setFieldError('user_email', _('errEmailInvalid', 'Please enter a valid email address.')); hasError = true; }
			else setFieldError('user_email', '');
			if (!emailConfirm.trim()) { setFieldError('user_email_confirm', _('errEmailRetype', 'Please retype your email address.')); hasError = true; }
			else if (email.trim() && email !== emailConfirm) { setFieldError('user_email_confirm', _('errEmailMismatch', 'Email addresses do not match.')); hasError = true; }
			else setFieldError('user_email_confirm', '');
			if (!firstName.trim()) { setFieldError('first_name', _('errFirstNameRequired', 'Please enter your first name.')); hasError = true; }
			else setFieldError('first_name', '');
			if (!lastName.trim()) { setFieldError('last_name', _('errLastNameRequired', 'Please enter your last name.')); hasError = true; }
			else setFieldError('last_name', '');
			if (!pass) { setFieldError('user_pass', _('errPasswordRequired', 'Please choose a password.')); hasError = true; }
			else if (pass.length < 6) { setFieldError('user_pass', _('errPasswordMinLength', 'Password must be at least 6 characters.')); hasError = true; }
			else if (!passwordStrong(pass)) { setFieldError('user_pass', _('errPasswordStrong', 'Password must include at least one uppercase letter, one lowercase letter, one digit, and one special character.')); hasError = true; }
			else setFieldError('user_pass', '');
			if (!passConfirm.trim()) { setFieldError('user_pass_confirm', _('errPasswordRetype', 'Please retype your password.')); hasError = true; }
			else if (pass !== passConfirm) { setFieldError('user_pass_confirm', _('errPasswordsMismatch', 'Passwords do not match.')); hasError = true; }
			else setFieldError('user_pass_confirm', '');
			if (hasError) return;
			var submitBtn = registerForm.querySelector('button[type="submit"]');
			var originalText = submitBtn ? submitBtn.textContent : '';
			if (submitBtn) { submitBtn.disabled = true; submitBtn.textContent = sendingText; }
			var formData = new FormData(registerForm);
			formData.append('action', 'tasheel_ajax_register');
			var xhr = new XMLHttpRequest();
			xhr.open('POST', ajaxUrl);
			xhr.onload = function() {
				if (submitBtn) { submitBtn.disabled = false; submitBtn.textContent = originalText; }
				var data;
				var raw = (xhr.responseText || '').trim();
				try { data = JSON.parse(raw); } catch (parseErr) {
					// If parse failed but response looks like success (e.g. extra output before JSON), try to extract JSON
					var jsonStart = raw.indexOf('{"success":true');
					if (jsonStart !== -1) {
						try { data = JSON.parse(raw.substring(jsonStart)); } catch (e) { data = null; }
					}
					if (!data) {
						if (typeof console !== 'undefined' && console.warn) {
							console.warn('Registration: server response was not valid JSON. Status:', xhr.status, 'Preview:', raw.substring(0, 300));
						}
						if (msgEl) {
							msgEl.className = 'signup-form-message signup-form-message--error';
							msgEl.textContent = _('errorGeneric', 'Something went wrong. Please try again.');
							msgEl.style.display = 'block';
						}
						return;
					}
				}
				if (data && data.success && data.data && data.data.redirect_to) {
					window.location.href = data.data.redirect_to;
				} else {
					// Show only per-field errors OR only general message (not both)
					var errors = data && data.data && data.data.errors;
					var hasFieldErrors = errors && typeof errors === 'object' && Object.keys(errors).length > 0;
					if (hasFieldErrors) {
						for (var fieldName in errors) {
							if (errors.hasOwnProperty(fieldName)) {
								var fieldErrEl = registerForm.querySelector('.field-error[data-field="' + fieldName + '"]');
								if (fieldErrEl) {
									fieldErrEl.textContent = errors[fieldName] || '';
								}
							}
						}
					}
					if (msgEl) {
						if (hasFieldErrors) {
							msgEl.style.display = 'none';
							msgEl.textContent = '';
						} else {
							msgEl.className = 'signup-form-message signup-form-message--error';
							msgEl.textContent = (data && data.data && data.data.message) ? data.data.message : _('errorGeneric', 'Something went wrong. Please try again.');
							msgEl.style.display = 'block';
						}
					}
				}
			};
			xhr.onerror = function() {
				if (submitBtn) { submitBtn.disabled = false; submitBtn.textContent = originalText; }
				if (msgEl) {
					msgEl.className = 'signup-form-message signup-form-message--error';
					msgEl.textContent = _('errorGeneric', 'Something went wrong. Please try again.');
					msgEl.style.display = 'block';
				}
			};
			xhr.send(formData);
			return;
		}
		form = e.target && e.target.closest && e.target.closest('.apply-forgot-form');
		if (!form) return;
		var container = getLoginPopupContainer(form);
		if (!container) return;
		e.preventDefault();
		var msgEl = container.querySelector('.forgot-form-message');
		if (!msgEl) return;
		msgEl.style.display = 'none';
		msgEl.textContent = '';
		msgEl.className = 'forgot-form-message';
		var forgotFieldErr = container.querySelector('.apply-forgot-form .field-error[data-field="user_login"]');
		if (forgotFieldErr) forgotFieldErr.textContent = '';
		var submitBtn = form.querySelector('button[type="submit"]');
		var originalText = submitBtn ? submitBtn.textContent : '';
		if (submitBtn) {
			submitBtn.disabled = true;
			submitBtn.textContent = sendingText;
		}
		var formData = new FormData(form);
		formData.append('action', 'tasheel_forgot_password');
		var nonceInput = form.querySelector('input[name="tasheel_forgot_password_nonce"]');
		var nonceVal = nonceInput ? nonceInput.value : (popup && popup.querySelector('.apply-forgot-form input[name="tasheel_forgot_password_nonce"]') && popup.querySelector('.apply-forgot-form input[name="tasheel_forgot_password_nonce"]').value);
		if (nonceVal) formData.set('tasheel_forgot_password_nonce', nonceVal);
		var xhr = new XMLHttpRequest();
		xhr.open('POST', ajaxUrl);
		var genericError = _('errorForgot', 'The email could not be sent. Please try again.');
		xhr.onload = function() {
			if (submitBtn) { submitBtn.disabled = false; submitBtn.textContent = originalText; }
			var data;
			try { data = JSON.parse(xhr.responseText); } catch (err) {
				msgEl.className = 'forgot-form-message forgot-form-message--error';
				msgEl.textContent = genericError;
				msgEl.style.display = 'block';
				return;
			}
			if (data && data.success && data.data && data.data.message) {
				msgEl.className = 'forgot-form-message forgot-form-message--success';
				msgEl.textContent = data.data.message;
				msgEl.style.display = 'block';
				var loginInput = form.querySelector('input[name="user_login"]');
				var loginValue = loginInput ? loginInput.value : '';
				if (loginInput) loginInput.value = '';
				if (forgotFieldErr) forgotFieldErr.textContent = '';
				// Send reset email in a separate request (same as registration – avoids 500 / wp_mail issues in form request).
				// Pass user_login so backend can send even if queue is empty (e.g. load balancer / race).
				var processUrl = (container && container.getAttribute('data-ajax-url')) || (popup && popup.getAttribute('data-ajax-url')) || ajaxUrl;
				if (processUrl) {
					var fd = new FormData();
					fd.append('action', 'tasheel_process_reset_email_queue');
					if (loginValue) fd.append('user_login', loginValue);
					setTimeout(function() {
						fetch(processUrl, { method: 'POST', body: fd }).catch(function() {});
					}, 50);
				}
			} else {
				var forgotErrors = data && data.data && data.data.errors;
				var hasFieldError = forgotErrors && forgotErrors.user_login;
				if (hasFieldError && forgotFieldErr) {
					forgotFieldErr.textContent = forgotErrors.user_login;
					msgEl.style.display = 'none';
					msgEl.textContent = '';
				} else {
					if (forgotFieldErr) forgotFieldErr.textContent = '';
					msgEl.className = 'forgot-form-message forgot-form-message--error';
					msgEl.textContent = (data && data.data && data.data.message) ? data.data.message : genericError;
					msgEl.style.display = 'block';
				}
			}
		};
		xhr.onerror = function() {
			if (submitBtn) { submitBtn.disabled = false; submitBtn.textContent = originalText; }
			msgEl.className = 'forgot-form-message forgot-form-message--error';
			msgEl.textContent = genericError;
			msgEl.style.display = 'block';
		};
		xhr.send(formData);
	}, true);
}
})();

// Move focus out of Fancybox slide before close to avoid "Blocked aria-hidden on an element because its descendant retained focus" console warning.
document.addEventListener('DOMContentLoaded', function() {
document.addEventListener('fancybox:shouldClose', function() {
	var active = document.activeElement;
	if (active && typeof active.blur === 'function') { active.blur(); }
	if (document.body && document.body.focus) { document.body.focus(); }
});
});
