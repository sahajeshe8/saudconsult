/**
 * Footer Component JavaScript
 * Converted from React to vanilla JavaScript for WordPress
 * 
 * Handles newsletter form submission
 */

(function() {
	'use strict';

	/**
	 * Initialize Footer Component
	 */
	const initFooter = function() {
		const newsletterForm = document.getElementById('footerNewsletterForm');
		if (!newsletterForm) {
			return;
		}

		// Handle form submission
		newsletterForm.addEventListener('submit', function(e) {
			e.preventDefault();

			const emailInput = this.querySelector('.footer-email-input');
			const email = emailInput ? emailInput.value.trim() : '';

			if (!email) {
				console.warn('Footer: Email is required');
				return;
			}

			// Validate email format
			const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
			if (!emailRegex.test(email)) {
				console.warn('Footer: Invalid email format');
				alert('Please enter a valid email address');
				return;
			}

			// Submit form via AJAX or standard form submission
			// For now, we'll use standard form submission
			// You can enhance this with AJAX if needed
			console.log('Footer: Subscribing email:', email);
			
			// Submit the form
			this.submit();
		});
	};

	/**
	 * Initialize when DOM is ready
	 */
	const init = function() {
		if (document.readyState === 'loading') {
			document.addEventListener('DOMContentLoaded', initFooter);
		} else {
			// DOM already loaded
			initFooter();
		}
	};

	// Start initialization
	init();

})();

