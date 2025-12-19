/**
 * Statistics Component JavaScript
 * Converted from React to vanilla JavaScript for WordPress
 * 
 * Handles count-up animations when statistics come into view
 */

(function() {
	'use strict';

	// Store animated items to prevent re-animation
	const animatedItems = new Set();

	/**
	 * Animate number from start to end
	 */
	const animateNumber = function(element, start, end, duration, decimals) {
		const startTime = performance.now();
		const isDecimal = decimals > 0;

		const animate = function(currentTime) {
			const elapsed = currentTime - startTime;
			const progress = Math.min(elapsed / duration, 1);

			// Easing function (ease-out)
			const easeOut = 1 - Math.pow(1 - progress, 3);

			const current = start + (end - start) * easeOut;
			
			if (isDecimal) {
				element.textContent = current.toFixed(decimals);
			} else {
				element.textContent = Math.floor(current);
			}

			if (progress < 1) {
				requestAnimationFrame(animate);
			} else {
				// Ensure final value is set
				if (isDecimal) {
					element.textContent = end.toFixed(decimals);
				} else {
					element.textContent = Math.floor(end);
				}
			}
		};

		requestAnimationFrame(animate);
	};

	/**
	 * Initialize Statistics Component
	 */
	const initStatistics = function() {
		const container = document.querySelector('[data-statistics-container]');
		if (!container) {
			return;
		}

		const statItems = container.querySelectorAll('[data-stat-item]');
		if (statItems.length === 0) {
			return;
		}

		// Create Intersection Observer
		const observer = new IntersectionObserver(
			function(entries) {
				entries.forEach(function(entry) {
					if (entry.isIntersecting && !animatedItems.has(entry.target)) {
						const item = entry.target;
						const value = parseFloat(item.getAttribute('data-stat-value'));
						const decimals = parseInt(item.getAttribute('data-stat-decimals')) || 0;
						const index = parseInt(item.getAttribute('data-stat-index')) || 0;
						const numberElement = item.querySelector('.statNumber');

						if (numberElement && !isNaN(value)) {
							// Mark as animated
							animatedItems.add(item);

							// Add fade-up animation with delay
							setTimeout(function() {
								item.style.opacity = '0';
								item.style.transform = 'translateY(30px)';
								item.style.transition = 'opacity 0.8s ease, transform 0.8s ease';

								// Trigger animation
								setTimeout(function() {
									item.style.opacity = '1';
									item.style.transform = 'translateY(0)';
								}, 50);

								// Start count-up animation
								animateNumber(numberElement, 0, value, 2500, decimals);
							}, index * 200); // Stagger delay
						}

						// Disconnect observer for this item
						observer.unobserve(item);
					}
				});
			},
			{
				threshold: 0.3,
				rootMargin: '0px 0px -50px 0px',
			}
		);

		// Observe all stat items
		statItems.forEach(function(item) {
			// Set initial state
			item.style.opacity = '0';
			item.style.transform = 'translateY(30px)';
			observer.observe(item);
		});
	};

	/**
	 * Initialize when DOM is ready
	 */
	const init = function() {
		if (document.readyState === 'loading') {
			document.addEventListener('DOMContentLoaded', initStatistics);
		} else {
			// DOM already loaded
			initStatistics();
		}
	};

	// Start initialization
	init();

})();

