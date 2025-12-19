/**
 * NewsSlider Component JavaScript
 * Converted from React to vanilla JavaScript for WordPress
 * 
 * Handles Swiper slider initialization for news items
 */

(function() {
	'use strict';

	/**
	 * Initialize NewsSlider Component
	 */
	const initNewsSlider = function() {
		// Check if Swiper is loaded
		if (typeof Swiper === 'undefined') {
			console.warn('NewsSlider: Swiper library is not loaded');
			return;
		}

		const swiperElement = document.querySelector('[data-news-swiper]');
		if (!swiperElement) {
			console.warn('NewsSlider: Swiper element not found');
			return;
		}

		// Get the NewsSlider section container
		const newsSliderSection = swiperElement.closest('.news-slider-section');
		if (!newsSliderSection) {
			console.warn('NewsSlider: Section container not found');
			return;
		}

		// Check if wrapper and slides exist
		const swiperWrapper = swiperElement.querySelector('.swiper-wrapper');
		if (!swiperWrapper) {
			console.warn('NewsSlider: Swiper wrapper not found');
			return;
		}

		const slides = swiperWrapper.querySelectorAll('.swiper-slide');
		if (slides.length === 0) {
			console.warn('NewsSlider: No Swiper slides found');
			return;
		}

		console.log('NewsSlider: Found', slides.length, 'slides');

		// Get navigation buttons scoped to NewsSlider section
		const prevButton = newsSliderSection.querySelector('.news-slider-prev-btn') || newsSliderSection.querySelector('.slider_prev_btn');
		const nextButton = newsSliderSection.querySelector('.news-slider-next-btn') || newsSliderSection.querySelector('.slider_next_btn');

		// Build Swiper config
		const swiperConfig = {
			spaceBetween: 30,
			slidesPerView: 1,
			loop: slides.length > 1, // Only loop if more than 1 slide
			speed: 1500,
			breakpoints: {
				768: {
					slidesPerView: 2,
					spaceBetween: 30,
				},
				1024: {
					slidesPerView: 2.2,
					spaceBetween: 30,
				},
			},
		};

		// Add navigation only if buttons exist
		if (prevButton && nextButton) {
			// Swiper 11 - navigation is included in bundle, just configure it
			swiperConfig.navigation = {
				nextEl: nextButton,
				prevEl: prevButton,
				enabled: true,
			};
			console.log('NewsSlider: Navigation buttons found and configured', {
				prevButton: prevButton,
				nextButton: nextButton
			});
		} else {
			console.warn('NewsSlider: Navigation buttons not found', {
				prevButton: prevButton,
				nextButton: nextButton,
				section: newsSliderSection
			});
		}

		// Initialize Swiper
		try {
			const newsSwiper = new Swiper(swiperElement, swiperConfig);

			// Store swiper instance for potential cleanup
			swiperElement._swiperInstance = newsSwiper;
			window.newsSwiperInstance = newsSwiper; // Store globally for debugging

			console.log('NewsSlider: Swiper initialized successfully', {
				swiper: newsSwiper,
				slides: slides.length,
				hasNavigation: !!swiperConfig.navigation
			});
		} catch (error) {
			console.error('NewsSlider: Error initializing Swiper', error);
		}
	};

	/**
	 * Initialize when DOM is ready
	 */
	const init = function() {
		let retryCount = 0;
		const maxRetries = 10;
		const retryDelay = 500; // ms

		const tryInit = function() {
			if (typeof Swiper !== 'undefined') {
				// Wait a bit for DOM to be ready and ensure all elements are loaded
				setTimeout(function() {
					// Double check that Swiper element exists
					const swiperElement = document.querySelector('[data-news-swiper]');
					if (swiperElement) {
						initNewsSlider();
					} else {
						console.warn('NewsSlider: Swiper element not found in DOM, retrying...');
						if (retryCount < maxRetries) {
							retryCount++;
							setTimeout(tryInit, retryDelay);
						}
					}
				}, 300);
			} else if (retryCount < maxRetries) {
				retryCount++;
				console.warn(`NewsSlider: Swiper not loaded, retrying (${retryCount}/${maxRetries})...`);
				setTimeout(tryInit, retryDelay);
			} else {
				console.error('NewsSlider: Failed to load Swiper after multiple retries.');
			}
		};

		if (document.readyState === 'loading') {
			document.addEventListener('DOMContentLoaded', tryInit);
		} else {
			// DOM already loaded
			tryInit();
		}
	};

	// Start initialization
	init();

})();

