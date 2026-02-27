/**
 * ButtonPrimary Component JavaScript
 * Handles hover effects for primary buttons
 */

(function() {
	'use strict';

	/**
	 * Initialize ButtonPrimary hover effects
	 */
	const initButtonPrimary = function() {
		const buttons = document.querySelectorAll('[data-button-primary]');

		buttons.forEach(function(button) {
			let isHovered = false;
			let mouseX = 0;
			let mouseY = 0;

			// Mouse enter - add hovered class
			button.addEventListener('mouseenter', function(e) {
				isHovered = true;
				button.classList.add('hovered');
				
				// Get mouse position relative to button
				const rect = button.getBoundingClientRect();
				mouseX = e.clientX - rect.left;
				mouseY = e.clientY - rect.top;
			});

			// Mouse leave - remove hovered class
			button.addEventListener('mouseleave', function() {
				isHovered = false;
				button.classList.remove('hovered');
				
				// Add cursor pointer left class for smooth exit
				button.classList.add('cursor_pointer_left');
				
				// Remove cursor pointer left class after transition
				setTimeout(function() {
					button.classList.remove('cursor_pointer_left');
				}, 500);
			});

			// Mouse move - track cursor position for advanced effects (if needed)
			button.addEventListener('mousemove', function(e) {
				if (isHovered) {
					const rect = button.getBoundingClientRect();
					mouseX = e.clientX - rect.left;
					mouseY = e.clientY - rect.top;
				}
			});
		});
	};

	/**
	 * Initialize when DOM is ready
	 */
	const init = function() {
		if (document.readyState === 'loading') {
			document.addEventListener('DOMContentLoaded', initButtonPrimary);
		} else {
			// DOM already loaded
			initButtonPrimary();
		}
	};

	// Start initialization
	init();

})();

