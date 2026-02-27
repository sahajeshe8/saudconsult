/**
 * Subsidiaries Component JavaScript
 * Converted from React to vanilla JavaScript for WordPress
 * 
 * Handles category switching and Swiper initialization
 */

(function() {
	'use strict';

	let activeCategory = 0;
	let swiperInstances = {};

	/**
	 * Initialize Subsidiaries Component
	 */
	const initSubsidiaries = function() {
		// Check if Swiper is loaded
		if (typeof Swiper === 'undefined') {
			console.warn('Subsidiaries: Swiper library is not loaded');
			return;
		}

		// Initialize all Swiper instances
		const swiperWrappers = document.querySelectorAll('[data-subsidiaries-swiper]');
		
		if (swiperWrappers.length === 0) {
			console.warn('Subsidiaries: No Swiper elements found');
			return;
		}

		swiperWrappers.forEach(function(wrapper) {
			const categoryIndex = wrapper.getAttribute('data-subsidiaries-swiper');
			const swiperElement = wrapper;

			// Check if wrapper and slides exist
			const swiperWrapper = swiperElement.querySelector('.swiper-wrapper');
			if (!swiperWrapper) {
				console.warn('Subsidiaries: Swiper wrapper not found for category', categoryIndex);
				return;
			}

			const slides = swiperWrapper.querySelectorAll('.swiper-slide');
			if (slides.length === 0) {
				console.warn('Subsidiaries: No slides found for category', categoryIndex);
				return;
			}

			// Get navigation buttons for this specific Swiper (optional)
			const prevButton = wrapper.parentElement.querySelector('.subsidiaries-swiper-prev-' + categoryIndex);
			const nextButton = wrapper.parentElement.querySelector('.subsidiaries-swiper-next-' + categoryIndex);

			// Build Swiper config
			const swiperConfig = {
				spaceBetween: 30,
				slidesPerView: 1,
				speed: 2000,
				autoplay: {
					delay: 3000,
					disableOnInteraction: false,
					pauseOnMouseEnter: true,
				},
				loop: true,
				breakpoints: {
					768: {
						slidesPerView: 1.2,
						spaceBetween: 30,
					}
				},
			};

			// Add modules
			const modules = [];
			if (Swiper.Autoplay) {
				modules.push(Swiper.Autoplay);
			}

			// Add navigation only if buttons exist
			if (prevButton && nextButton) {
				if (Swiper.Navigation) {
					modules.push(Swiper.Navigation);
				}
				swiperConfig.navigation = {
					nextEl: nextButton,
					prevEl: prevButton,
				};
			}

			if (modules.length > 0) {
				swiperConfig.modules = modules;
			}

			// Initialize Swiper for this category
			try {
				const swiper = new Swiper(swiperElement, swiperConfig);

				// Store swiper instance
				swiperInstances[categoryIndex] = swiper;
				swiperElement._swiperInstance = swiper;

				console.log('Subsidiaries: Swiper initialized for category', categoryIndex, 'with', slides.length, 'slides');
			} catch (error) {
				console.error('Subsidiaries: Error initializing Swiper for category', categoryIndex, error);
			}
		});

		// Initialize category click handlers
		initCategoryHandlers();

		// Show first category by default (after a short delay to ensure Swiper is ready)
		setTimeout(function() {
			showCategory(0);
		}, 100);

		console.log('Subsidiaries: Initialized successfully');
	};

	/**
	 * Show specific category
	 */
	const showCategory = function(index) {
		// Hide all swiper wrappers and stop their autoplay
		const allWrappers = document.querySelectorAll('.subsidiaries-swiper-wrapper');
		allWrappers.forEach(function(wrapper) {
			wrapper.classList.remove('active');
			// Stop autoplay on inactive swipers
			const wrapperIndex = wrapper.getAttribute('data-swiper-category');
			if (wrapperIndex !== null && swiperInstances[wrapperIndex] && swiperInstances[wrapperIndex].autoplay) {
				swiperInstances[wrapperIndex].autoplay.stop();
			}
		});

		// Show selected category
		const selectedWrapper = document.querySelector('[data-swiper-category="' + index + '"]');
		if (selectedWrapper) {
			selectedWrapper.classList.add('active');
			
			// Update active category
			activeCategory = index;

			// Update Swiper if needed
			if (swiperInstances[index]) {
				setTimeout(function() {
					swiperInstances[index].update();
					swiperInstances[index].updateSlidesClasses();
					swiperInstances[index].updateSize();
					// Restart autoplay if it exists
					if (swiperInstances[index].autoplay) {
						swiperInstances[index].autoplay.start();
					}
				}, 150);
			} else {
				// If Swiper instance doesn't exist, try to initialize it
				const swiperElement = selectedWrapper.querySelector('[data-subsidiaries-swiper="' + index + '"]');
				if (swiperElement && typeof Swiper !== 'undefined') {
					const swiperWrapper = swiperElement.querySelector('.swiper-wrapper');
					const slides = swiperWrapper ? swiperWrapper.querySelectorAll('.swiper-slide') : [];
					
					if (slides.length === 0) {
						console.warn('Subsidiaries: No slides found for category', index);
						return;
					}

					const prevButton = selectedWrapper.querySelector('.subsidiaries-swiper-prev-' + index);
					const nextButton = selectedWrapper.querySelector('.subsidiaries-swiper-next-' + index);
					
					const swiperConfig = {
						spaceBetween: 30,
						slidesPerView: 1,
						speed: 2000,
						autoplay: {
							delay: 3000,
							disableOnInteraction: false,
							pauseOnMouseEnter: true,
						},
						loop: true,
						breakpoints: {
							768: {
								slidesPerView: 1.2,
								spaceBetween: 30,
							}
						},
					};

					// Add modules
					const modules = [];
					if (Swiper.Autoplay) {
						modules.push(Swiper.Autoplay);
					}

					// Add navigation only if buttons exist
					if (prevButton && nextButton) {
						if (Swiper.Navigation) {
							modules.push(Swiper.Navigation);
						}
						swiperConfig.navigation = {
							nextEl: nextButton,
							prevEl: prevButton,
						};
					}

					if (modules.length > 0) {
						swiperConfig.modules = modules;
					}
					
					try {
						const swiper = new Swiper(swiperElement, swiperConfig);
						swiperInstances[index] = swiper;
						swiperElement._swiperInstance = swiper;
						console.log('Subsidiaries: Swiper initialized for category', index);
					} catch (error) {
						console.error('Subsidiaries: Error initializing Swiper for category', index, error);
					}
				}
			}
		}

		// Update active category item
		const allItems = document.querySelectorAll('.subsidiaries-category-item');
		allItems.forEach(function(item, itemIndex) {
			if (itemIndex === index) {
				item.classList.add('active');
			} else {
				item.classList.remove('active');
			}
		});
	};

	/**
	 * Initialize category click handlers
	 */
	const initCategoryHandlers = function() {
		const categoryItems = document.querySelectorAll('.subsidiaries-category-item');
		
		categoryItems.forEach(function(item) {
			item.addEventListener('click', function() {
				const categoryIndex = parseInt(this.getAttribute('data-category-index'), 10);
				if (!isNaN(categoryIndex)) {
					showCategory(categoryIndex);
				}
			});
		});
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
				// Wait a bit for DOM to be ready
				setTimeout(function() {
					initSubsidiaries();
				}, 200);
			} else if (retryCount < maxRetries) {
				retryCount++;
				console.warn(`Subsidiaries: Swiper not loaded, retrying (${retryCount}/${maxRetries})...`);
				setTimeout(tryInit, retryDelay);
			} else {
				console.error('Subsidiaries: Failed to load Swiper after multiple retries.');
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

