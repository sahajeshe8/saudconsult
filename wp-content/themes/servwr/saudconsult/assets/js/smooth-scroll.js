/**
 * Smooth Scroll with Lenis
 * Integrates with GSAP ScrollTrigger for smooth scrolling experience
 */

(function() {
	'use strict';

	// Store Lenis instance globally
	window.lenisInstance = null;

	/**
	 * Initialize Smooth Scroll with Lenis
	 */
	const initSmoothScroll = function() {
		// Check if Lenis is loaded
		if (typeof Lenis === 'undefined') {
			console.warn('SmoothScroll: Lenis library is not loaded');
			return;
		}

		// Initialize Lenis
		const lenis = new Lenis({
			duration: 1.2,
			easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)), // Custom easing
			orientation: 'vertical',
			gestureOrientation: 'vertical',
			smoothWheel: true,
			wheelMultiplier: 1,
			smoothTouch: false,
			touchMultiplier: 2,
			infinite: false,
		});

		// Store instance globally
		window.lenisInstance = lenis;

		// Scroll to top on page load/refresh
		lenis.scrollTo(0, {
			immediate: true, // Instant scroll to top
		});

		// Integrate with GSAP ScrollTrigger if available
		if (typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined') {
			// Register ScrollTrigger plugin
			gsap.registerPlugin(ScrollTrigger);
			
			// Update ScrollTrigger on Lenis scroll
			lenis.on('scroll', ScrollTrigger.update);

			// Use GSAP ticker for smooth animation
			gsap.ticker.add((time) => {
				lenis.raf(time * 1000);
			});

			gsap.ticker.lagSmoothing(0);
		} else {
			// Fallback: Use requestAnimationFrame if GSAP is not available
			function raf(time) {
				lenis.raf(time);
				requestAnimationFrame(raf);
			}
			requestAnimationFrame(raf);
		}

		// Update header scroll detection
		lenis.on('scroll', ({ scroll, limit, velocity, direction, progress }) => {
			// Update header scroll state
			const headerSection = document.getElementById('headerMainSection');
			if (headerSection) {
				if (scroll > 1) {
					headerSection.classList.add('scrolled');
				} else {
					headerSection.classList.remove('scrolled');
				}
			}
		});

		// Handle anchor links
		document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
			anchor.addEventListener('click', function(e) {
				const href = this.getAttribute('href');
				if (href !== '#' && href.length > 1) {
					const target = document.querySelector(href);
					if (target) {
						e.preventDefault();
						lenis.scrollTo(target, {
							offset: -80, // Account for fixed header
							duration: 1.5,
						});
					}
				}
			});
		});

		console.log('SmoothScroll: Lenis initialized successfully');
	};

	/**
	 * Initialize when DOM is ready
	 */
	const init = function() {
		let retryCount = 0;
		const maxRetries = 10;
		const retryDelay = 500; // ms

		const tryInit = function() {
			if (typeof Lenis !== 'undefined') {
				initSmoothScroll();
			} else if (retryCount < maxRetries) {
				retryCount++;
				console.warn(`SmoothScroll: Lenis not loaded, retrying (${retryCount}/${maxRetries})...`);
				setTimeout(tryInit, retryDelay);
			} else {
				console.error('SmoothScroll: Failed to load Lenis after multiple retries.');
			}
		};

		if (document.readyState === 'loading') {
			document.addEventListener('DOMContentLoaded', tryInit);
		} else {
			// DOM already loaded
			tryInit();
		}
	};

	// Scroll to top immediately on page load (before Lenis initializes)
	// This ensures page starts at top even if browser remembers scroll position
	if (window.history.scrollRestoration) {
		window.history.scrollRestoration = 'manual';
	}
	
	// Fallback: Scroll to top if Lenis fails to load
	window.scrollTo(0, 0);

	// Start initialization
	init();

})();

