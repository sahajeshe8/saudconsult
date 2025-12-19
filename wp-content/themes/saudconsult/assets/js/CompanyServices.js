/**
 * CompanyServices Component JavaScript
 * 
 * Handles Swiper slider initialization for company services section
 */

(function() {
	'use strict';

	// Store Swiper instance globally for debugging
	window.companyServicesSwiperInstance = null;

	/**
	 * Update active service in the list
	 */
	const updateActiveService = function(activeIndex, swiperInstance) {
		const sectionElement = document.querySelector('[data-company-services]');
		if (!sectionElement) return;
		
		// Get the real active index (accounting for loop mode)
		const realActiveIndex = swiperInstance && swiperInstance.loopedSlides ? swiperInstance.realIndex : activeIndex;
		
		// Find all service items and update them
		const allServiceItems = sectionElement.querySelectorAll('.company-service-item');
		
		allServiceItems.forEach(function(item) {
			const itemIndex = parseInt(item.getAttribute('data-service-index'));
			
			if (itemIndex === realActiveIndex) {
				item.classList.add('active');
			} else {
				item.classList.remove('active');
			}
		});
	};

	/**
	 * Initialize Company Services Swiper Slider
	 */
	const initCompanyServicesSwiper = function() {
		const swiperElement = document.getElementById('companyServicesSwiper');
		if (!swiperElement) {
			console.warn('CompanyServices: Swiper element #companyServicesSwiper not found');
			return;
		}

		// Check if wrapper exists
		const wrapper = swiperElement.querySelector('.swiper-wrapper');
		if (!wrapper) {
			console.warn('CompanyServices: Swiper wrapper not found');
			return;
		}

		// Check if slides exist
		const slides = wrapper.querySelectorAll('.swiper-slide');
		if (slides.length === 0) {
			console.warn('CompanyServices: No Swiper slides found');
			return;
		}

		console.log('CompanyServices: Found', slides.length, 'slides');

		// Function to initialize Swiper
		const initSwiperInstance = function(attempt = 0) {
			// Check if Swiper is loaded
			if (typeof Swiper === 'undefined') {
				if (attempt < 10) {
					// Retry up to 10 times
					setTimeout(function() {
						initSwiperInstance(attempt + 1);
					}, 200);
				} else {
					console.error('CompanyServices: Swiper library failed to load after multiple attempts');
				}
				return;
			}

			try {
				const useLoop = slides.length > 1;
				
				// Find navigation buttons within the section
				const sectionElement = swiperElement.closest('[data-company-services]');
				const nextButton = sectionElement ? sectionElement.querySelector('.company-services-nav-next') : null;
				const prevButton = sectionElement ? sectionElement.querySelector('.company-services-nav-prev') : null;
				
				if (!nextButton || !prevButton) {
					console.warn('CompanyServices: Navigation buttons not found', { nextButton, prevButton, sectionElement });
					return;
				}

				console.log('CompanyServices: Initializing Swiper...');
				
				const autoplayDelay = 5000;
				let currentProgressBar = null;
				let progressStartTime = null;
				let isCompletingProgress = false;
				
				// Progress bar functions for service items
				function startProgressBar(serviceIndex) {
					// Reset all progress bars first
					resetAllProgressBars();
					isCompletingProgress = false;
					
					// Find the currently active/visible slide
					let activeSlide = swiperElement.querySelector('.swiper-slide-active');
					
					// If no active slide found, try to find the first slide (for initial load)
					if (!activeSlide) {
						activeSlide = swiperElement.querySelector('.swiper-slide:first-child');
						console.log('CompanyServices: Using first slide as fallback');
					}
					
					if (!activeSlide) {
						console.warn('CompanyServices: Active slide not found');
						return;
					}
					
					// Find the active service item within the active slide
					const serviceItems = activeSlide.querySelectorAll('.company-service-item');
					const activeItem = Array.from(serviceItems).find(function(item) {
						return parseInt(item.getAttribute('data-service-index')) === serviceIndex;
					});
					
					if (!activeItem) {
						console.warn('CompanyServices: Active service item not found for index', serviceIndex, 'Total items:', serviceItems.length);
						return;
					}
					
					const progressBar = activeItem.querySelector('.company-service-progress-bar');
					if (!progressBar) {
						console.warn('CompanyServices: Progress bar not found in active item');
						return;
					}
					
					currentProgressBar = progressBar;
					
					// Reset progress bar
					progressBar.style.width = '0%';
					progressBar.style.transition = 'none';
					
					// Force reflow
					void progressBar.offsetWidth;
					
					// Start animation with CSS transition after a small delay
					// Store timeout so we can cancel it if needed
					const progressTimeout = setTimeout(function() {
						if (progressBar && progressBar.parentElement && progressBar.parentElement.parentElement) {
							// Check if still current progress bar (not stopped)
							if (currentProgressBar === progressBar && !isCompletingProgress) {
								// Fill to 50% (half way)
								progressBar.style.transition = 'width ' + ((autoplayDelay / 2) / 1000) + 's linear';
								progressBar.style.width = '50%';
								progressStartTime = Date.now();
								console.log('CompanyServices: Progress bar started for service index', serviceIndex, '- filling to 50%');
							}
						} else {
							console.warn('CompanyServices: Progress bar element detached, retrying...');
							setTimeout(function() {
								if (currentProgressBar !== progressBar) return; // Don't retry if stopped
								startProgressBar(serviceIndex);
							}, 200);
						}
					}, 200);
					
					// Store timeout reference for cancellation
					if (!window.companyServicesProgressTimeouts) {
						window.companyServicesProgressTimeouts = [];
					}
					window.companyServicesProgressTimeouts.push(progressTimeout);
				}
				
				// Function to complete progress bar to 100% before navigating
				function completeProgressBar(callback) {
					if (isCompletingProgress) {
						if (callback) callback();
						return;
					}
					
					if (!currentProgressBar) {
						// No progress bar active, navigate immediately
						if (callback) callback();
						return;
					}
					
					isCompletingProgress = true;
					
					// Get current width percentage
					const computedStyle = window.getComputedStyle(currentProgressBar);
					const currentWidth = parseFloat(computedStyle.width) || 0;
					const containerWidth = currentProgressBar.parentElement.offsetWidth;
					const currentPercent = containerWidth > 0 ? (currentWidth / containerWidth) * 100 : 0;
					
					// Calculate remaining percent to fill (from current to 100%)
					const remainingPercent = 100 - currentPercent;
					
					// If already at or near 100%, navigate immediately
					if (remainingPercent <= 1) {
						if (callback) callback();
						isCompletingProgress = false;
						return;
					}
					
					// Calculate completion time: fill remaining 50% (from 50% to 100%) in same time as first 50%
					// Speed should be consistent: if first 50% took autoplayDelay/2 seconds, complete 50% also takes autoplayDelay/2
					const fillTime = (remainingPercent / 50) * (autoplayDelay / 2);
					
					// Stop current transition and capture current position
					currentProgressBar.style.transition = 'none';
					currentProgressBar.style.width = currentPercent + '%';
					
					// Force immediate reflow
					void currentProgressBar.offsetWidth;
					
					// Start completion animation from current position to 100%
					currentProgressBar.style.transition = 'width ' + (fillTime / 1000) + 's linear';
					currentProgressBar.style.width = '100%';
					
					console.log('CompanyServices: Completing progress bar from', currentPercent.toFixed(1) + '%', 'to 100% in', (fillTime / 1000).toFixed(2), 'seconds');
					
					// Wait for completion, then call callback to navigate
					setTimeout(function() {
						isCompletingProgress = false;
						if (callback) {
							console.log('CompanyServices: Progress bar completed, navigating...');
							callback();
						}
					}, fillTime + 50);
				}
				
				function resetAllProgressBars() {
					// Immediately stop and reset all progress bars across all slides
					const allProgressBars = sectionElement.querySelectorAll('.company-service-progress-bar');
					allProgressBars.forEach(function(bar) {
						// Get computed width to capture current state
						const computedWidth = window.getComputedStyle(bar).width;
						// Immediately stop any transition
						bar.style.transition = 'none';
						// Reset to 0
						bar.style.width = '0%';
						// Force immediate update by accessing offsetWidth
						void bar.offsetWidth;
					});
					currentProgressBar = null;
					progressStartTime = null;
				}
				
				function stopCurrentProgressBar() {
					// Cancel any pending timeouts immediately
					if (window.companyServicesProgressTimeouts) {
						window.companyServicesProgressTimeouts.forEach(function(timeout) {
							clearTimeout(timeout);
						});
						window.companyServicesProgressTimeouts = [];
					}
					
					// Immediately stop ALL progress bars synchronously
					const allProgressBars = sectionElement.querySelectorAll('.company-service-progress-bar');
					allProgressBars.forEach(function(bar) {
						// Immediately disable transition and reset width
						bar.style.cssText = 'transition: none !important; width: 0% !important;';
					});
					
					// Force synchronous reflow
					if (allProgressBars.length > 0) {
						void allProgressBars[0].offsetWidth;
					}
					
					// Clear all progress bars style to reset
					allProgressBars.forEach(function(bar) {
						bar.style.transition = 'none';
						bar.style.width = '0%';
					});
					
					currentProgressBar = null;
					progressStartTime = null;
				}
				
				function pauseProgressBar() {
					if (!currentProgressBar) return;
					
					const computedStyle = window.getComputedStyle(currentProgressBar);
					const currentWidth = computedStyle.width;
					
					// Capture current progress
					currentProgressBar.style.transition = 'none';
					currentProgressBar.style.width = currentWidth;
				}
				
				function resumeProgressBar(serviceIndex) {
					if (!currentProgressBar || !progressStartTime) {
						startProgressBar(serviceIndex);
						return;
					}
					
					const elapsed = Date.now() - progressStartTime;
					const remaining = autoplayDelay - elapsed;
					
					if (remaining > 0) {
						// Calculate how much time it should take to reach 50% total
						// Since we're animating to 50% over the full autoplay delay
						const targetPercent = 50;
						const progressBarContainer = currentProgressBar.parentElement;
						if (!progressBarContainer) {
							startProgressBar(serviceIndex);
							return;
						}
						
						const computedStyle = window.getComputedStyle(currentProgressBar);
						const currentWidth = parseFloat(computedStyle.width) || 0;
						const containerWidth = progressBarContainer.offsetWidth;
						const currentPercent = containerWidth > 0 ? (currentWidth / containerWidth) * 100 : 0;
						const remainingPercent = targetPercent - currentPercent;
						
						if (remainingPercent > 0 && targetPercent > 0) {
							// Calculate remaining time proportionally to reach 50%
							const remainingTime = (remainingPercent / targetPercent) * autoplayDelay;
							currentProgressBar.style.transition = 'width ' + (remainingTime / 1000) + 's linear';
							currentProgressBar.style.width = '50%';
							progressStartTime = Date.now() - (autoplayDelay - remainingTime);
						}
					}
				}
				
				// Initialize Swiper with element directly
				window.companyServicesSwiperInstance = new Swiper(swiperElement, {
					spaceBetween: 0,
					slidesPerView: 1,
					navigation: false, // Disable Swiper's default navigation - we'll handle it manually
					speed: 1000,
					loop: useLoop,
					watchOverflow: true,
					effect: 'fade',
					fadeEffect: {
						crossFade: true
					},
					autoplay: false, // Disable autoplay - manual navigation only
					on: {
						init: function(swiper) {
							console.log('CompanyServices: Swiper initialized', swiper);
							// Set initial active service after initialization
							const initialIndex = useLoop ? swiper.realIndex : swiper.activeIndex;
							console.log('CompanyServices: Initial index is', initialIndex);
							updateActiveService(initialIndex, swiper);
							
							// Start progress bar immediately for first slide
							setTimeout(function() {
								console.log('CompanyServices: Attempting to start progress bar for index', initialIndex);
								startProgressBar(initialIndex);
							}, 200);
						},
						ready: function(swiper) {
							// Trigger on ready event to ensure progress bar starts
							const initialIndex = useLoop ? swiper.realIndex : swiper.activeIndex;
							console.log('CompanyServices: Ready event, index is', initialIndex);
							if (initialIndex !== undefined && initialIndex !== null) {
								updateActiveService(initialIndex, swiper);
								// Only start if not already started
								if (!currentProgressBar) {
									setTimeout(function() {
										startProgressBar(initialIndex);
									}, 100);
								}
							}
						},
						slideChangeTransitionStart: function(swiper) {
							// Reset progress bars when slide starts changing (but not during completion)
							if (!isCompletingProgress) {
								stopCurrentProgressBar();
								resetAllProgressBars();
							}
						},
						slideChange: function(swiper) {
							// Reset when slide change is detected (but not during completion)
							if (!isCompletingProgress) {
								stopCurrentProgressBar();
								resetAllProgressBars();
							}
						},
						slideChangeTransitionEnd: function(swiper) {
							// Update active service item when slide change transition completes
							const realIndex = useLoop ? swiper.realIndex : swiper.activeIndex;
							updateActiveService(realIndex, swiper);
							// Reset all progress bars and start new one
							stopCurrentProgressBar();
							resetAllProgressBars();
							isCompletingProgress = false;
							// Start progress bar after transition completes
							setTimeout(function() {
								startProgressBar(realIndex);
							}, 150);
						},
					},
				});

				// Ensure progress bar starts on initial load - final backup
				setTimeout(function() {
					if (window.companyServicesSwiperInstance && !currentProgressBar) {
						const initialIndex = useLoop ? window.companyServicesSwiperInstance.realIndex : window.companyServicesSwiperInstance.activeIndex;
						if (initialIndex !== undefined && initialIndex !== null) {
							const activeSlide = swiperElement.querySelector('.swiper-slide-active');
							if (activeSlide) {
								console.log('CompanyServices: Final attempt to start progress bar for index', initialIndex);
								startProgressBar(initialIndex);
							} else {
								// If no active slide class, try with first slide
								const firstSlide = swiperElement.querySelector('.swiper-slide:first-child');
								if (firstSlide && initialIndex === 0) {
									console.log('CompanyServices: Using first slide directly');
									startProgressBar(0);
								}
							}
						}
					}
				}, 1200);

				// Handle navigation button clicks - complete progress then navigate
				if (nextButton) {
					nextButton.addEventListener('click', function(e) {
						e.preventDefault();
						e.stopPropagation();
						
						// Complete progress bar first, then navigate
						completeProgressBar(function() {
							// Now navigate to next slide
							if (window.companyServicesSwiperInstance) {
								window.companyServicesSwiperInstance.slideNext();
							}
						});
					}, false);
				}
				
				if (prevButton) {
					prevButton.addEventListener('click', function(e) {
						e.preventDefault();
						e.stopPropagation();
						
						// Complete progress bar first, then navigate
						completeProgressBar(function() {
							// Now navigate to previous slide
							if (window.companyServicesSwiperInstance) {
								window.companyServicesSwiperInstance.slidePrev();
							}
						});
					}, false);
				}
				
				
				// Handle service item clicks - complete progress then navigate
				setTimeout(function() {
					const serviceItems = sectionElement.querySelectorAll('.company-service-item[data-service-index]');
					serviceItems.forEach(function(item) {
						// Remove any existing click handlers by cloning
						const newItem = item.cloneNode(true);
						item.parentNode.replaceChild(newItem, item);
						
						newItem.style.cursor = 'pointer';
						
						newItem.addEventListener('click', function(e) {
							e.preventDefault();
							e.stopPropagation();
							
							const targetIndex = parseInt(newItem.getAttribute('data-service-index'));
							const currentIndex = window.companyServicesSwiperInstance ? (useLoop ? window.companyServicesSwiperInstance.realIndex : window.companyServicesSwiperInstance.activeIndex) : -1;
							
							// Only complete and navigate if clicking a different service
							if (!isNaN(targetIndex) && targetIndex !== currentIndex && window.companyServicesSwiperInstance) {
								console.log('CompanyServices: Clicked service', targetIndex);
								
								// Complete progress bar first, then navigate
								completeProgressBar(function() {
									if (useLoop) {
										window.companyServicesSwiperInstance.slideToLoop(targetIndex);
									} else {
										window.companyServicesSwiperInstance.slideTo(targetIndex);
									}
								});
							}
						});
					});
				}, 500);


				console.log('CompanyServices: Swiper initialized successfully', window.companyServicesSwiperInstance);
			} catch (error) {
				console.error('CompanyServices: Error initializing Swiper', error);
			}
		};

		// Initialize after a short delay to ensure DOM is ready
		if (document.readyState === 'loading') {
			document.addEventListener('DOMContentLoaded', function() {
				setTimeout(function() {
					initSwiperInstance();
				}, 500);
			});
		} else if (document.readyState === 'interactive') {
			setTimeout(function() {
				initSwiperInstance();
			}, 500);
		} else {
			// DOM is complete
			setTimeout(function() {
				initSwiperInstance();
			}, 500);
		}
	};

	/**
	 * Initialize when DOM is ready
	 */
	const init = function() {
		if (document.readyState === 'loading') {
			document.addEventListener('DOMContentLoaded', function() {
				initCompanyServicesSwiper();
			});
		} else {
			// DOM already loaded
			initCompanyServicesSwiper();
		}
	};

	// Start initialization
	init();

})();
