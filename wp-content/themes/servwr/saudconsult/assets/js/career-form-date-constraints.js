/**
 * Career form date constraints.
 * Block future dates on START date only; END date allows future (e.g. ongoing education/job).
 * Enforce end date >= start date in education/experience.
 * Enqueued on create-profile and apply-as-guest pages only.
 */
(function() {
	function todayStr() {
		var d = new Date();
		return d.getFullYear() + '-' + String(d.getMonth() + 1).padStart(2, '0') + '-' + String(d.getDate()).padStart(2, '0');
	}

	function applyEndDateOptional() {
		var forms = document.querySelectorAll('.create-profile-form');
		forms.forEach(function(form) {
			form.querySelectorAll('.js-education-block').forEach(function(block) {
				var underProcess = block.querySelector('input[name*="[under_process]"]');
				var endInput = block.querySelector('.career-date-end') || block.querySelector('.date-input[name*="[end_date]"]');
				if (!endInput) return;
				function setEducationEndRequired() {
					if (underProcess && underProcess.checked) {
						endInput.removeAttribute('required');
					} else {
						endInput.setAttribute('required', '');
					}
				}
				setEducationEndRequired();
				if (underProcess && !underProcess._endDateOptionalBound) {
					underProcess._endDateOptionalBound = true;
					underProcess.addEventListener('change', setEducationEndRequired);
				}
			});
			form.querySelectorAll('.js-experience-block').forEach(function(block) {
				var currentJob = block.querySelector('input[name*="[current_job]"]');
				var endInput = block.querySelector('.career-date-end') || block.querySelector('.date-input[name*="[end_date]"]');
				if (!endInput) return;
				function setExperienceEndRequired() {
					if (currentJob && currentJob.checked) {
						endInput.removeAttribute('required');
					} else {
						endInput.setAttribute('required', '');
					}
				}
				setExperienceEndRequired();
				if (currentJob && !currentJob._endDateOptionalBound) {
					currentJob._endDateOptionalBound = true;
					currentJob.addEventListener('change', setExperienceEndRequired);
				}
			});
		});
	}

	function applyCareerFormDateConstraints() {
		var forms = document.querySelectorAll('.create-profile-form');
		var today = todayStr();
		forms.forEach(function(form) {
			form.querySelectorAll('.date-input').forEach(function(input) {
				if (input.classList.contains('career-date-end')) return;
				input.setAttribute('max', today);
			});
			form.querySelectorAll('.js-education-block, .js-experience-block').forEach(function(block) {
				var startInput = block.querySelector('.career-date-start') || block.querySelector('.date-input[name*="[start_date]"]');
				var endInput = block.querySelector('.career-date-end') || block.querySelector('.date-input[name*="[end_date]"]');
				if (!startInput || !endInput) return;
				endInput.removeAttribute('max');
				if (startInput.value) {
					endInput.setAttribute('min', startInput.value);
					if (endInput.value && endInput.value < startInput.value) {
						endInput.value = startInput.value;
					}
				} else {
					endInput.removeAttribute('min');
				}
				if (!startInput._careerDateBound) {
					startInput._careerDateBound = true;
					function updateEndMin() {
						endInput.removeAttribute('max');
						if (startInput.value) {
							endInput.setAttribute('min', startInput.value);
							if (endInput.value && endInput.value < startInput.value) {
								endInput.value = startInput.value;
							}
						} else {
							endInput.removeAttribute('min');
						}
					}
					startInput.addEventListener('change', updateEndMin);
					startInput.addEventListener('input', updateEndMin);
				}
			});
		});
		applyEndDateOptional();
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', function() {
			applyCareerFormDateConstraints();
			setTimeout(applyCareerFormDateConstraints, 500);
		});
	} else {
		applyCareerFormDateConstraints();
		setTimeout(applyCareerFormDateConstraints, 500);
	}
	document.addEventListener('fancybox:reveal', function() {
		setTimeout(applyCareerFormDateConstraints, 100);
	});
	var careerDateObserver = new MutationObserver(function() {
		setTimeout(applyCareerFormDateConstraints, 100);
	});
	if (document.body) {
		careerDateObserver.observe(document.body, { childList: true, subtree: true });
	} else {
		document.addEventListener('DOMContentLoaded', function() {
			careerDateObserver.observe(document.body, { childList: true, subtree: true });
		});
	}
})();
