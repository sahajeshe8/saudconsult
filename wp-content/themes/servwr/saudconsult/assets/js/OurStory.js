/**
 * OurStory Component JavaScript
 * Converted from React to vanilla JavaScript for WordPress
 * 
 * Handles GSAP ScrollTrigger rotation animations
 */

(function() {
	'use strict';

	// Ensure GSAP and ScrollTrigger are available globally
	const gsap = window.gsap;
	const ScrollTrigger = window.ScrollTrigger;

	/**
	 * Initialize OurStory Component
	 * Matches original React useEffect logic
	 */
	const initOurStory = async function() {
		try {
			// Check if GSAP and ScrollTrigger are loaded
			if (typeof gsap === 'undefined' || typeof ScrollTrigger === 'undefined') {
				console.warn('OurStory: GSAP or ScrollTrigger not loaded');
				return;
			}

			// Register ScrollTrigger plugin
			gsap.registerPlugin(ScrollTrigger);

			// Wait for DOM to be ready (matching original: await new Promise(resolve => setTimeout(resolve, 100)))
			await new Promise(function(resolve) {
				setTimeout(resolve, 100);
			});

			// Get DOM elements
			const sectionRef = document.querySelector('[data-our-story-section]');
			const bigCircleRef = document.querySelector('[data-big-circle]');
			const btnInsideRef = document.querySelector('[data-btn-inside]');

			if (!sectionRef || !bigCircleRef || !btnInsideRef) {
				console.warn('OurStory: Required elements not found');
				return;
			}

			// Set initial state - both at 0 degrees
			gsap.set(bigCircleRef, {
				rotation: 0,
			});
			gsap.set(btnInsideRef, {
				rotation: 0,
			});

			// Determine rotation value based on device width
			const getRotationValue = function() {
				return window.innerWidth <= 700 ? 100 : 130;
			};

			// Create smooth ScrollTrigger animation with responsive rotation
			const rotationValue = getRotationValue();
			
			gsap.to(bigCircleRef, {
				rotation: rotationValue,
				ease: "power1.out",
				scrollTrigger: {
					trigger: sectionRef,
					start: "top 50%",
					end: "top 10%",
					scrub: 2, // Slower scrubbing with 2s lag for slower rotation
				},
			});

			// Reverse rotation for button text to keep it upright
			gsap.to(btnInsideRef, {
				rotation: -rotationValue,
				ease: "power1.out",
				scrollTrigger: {
					trigger: sectionRef,
					start: "top 50%",
					end: "top 10%",
					scrub: 2, // Slower scrubbing with 2s lag for slower rotation
				},
			});

			ScrollTrigger.refresh();
		} catch (error) {
			console.error('Failed to initialize OurStory animation:', error);
		}
	};

	/**
	 * Handle button click to open popup
	 */
	const initButtonClick = function() {
		const buttonWrapper = document.querySelector('[data-our-story-button]');
		if (!buttonWrapper) {
			return;
		}

		buttonWrapper.addEventListener('click', function(e) {
			e.preventDefault();
			e.stopPropagation();
			
			// Check if popup exists
			const popup = document.getElementById('ourStoryPopup');
			if (popup) {
				const modalOverlay = popup.querySelector('[data-modal-overlay]');
				if (modalOverlay) {
					// Show popup container
					popup.style.display = 'block';
					popup.classList.add('active');
					
					// Show modal overlay with slight delay for smooth animation
					setTimeout(function() {
						modalOverlay.style.display = 'flex';
						modalOverlay.classList.add('active');
						document.body.classList.add('popup-open');
						// Prevent body scroll when modal is open
						document.body.style.overflow = 'hidden';
						
						// Initialize Swiper after modal is visible
						setTimeout(function() {
							initModalSwiper();
						}, 100);
					}, 10);
				} else {
					console.warn('OurStory: Modal overlay not found');
				}
			} else {
				console.warn('OurStory: Popup container not found');
			}
		});
	};

	/**
	 * Initialize modal close functionality
	 */
	const initModalClose = function() {
		const popup = document.getElementById('ourStoryPopup');
		if (!popup) {
			return;
		}

		const modalOverlay = popup.querySelector('[data-modal-overlay]');
		if (!modalOverlay) {
			return;
		}

		// Close button
		const closeButton = modalOverlay.querySelector('[data-modal-close]');
		if (closeButton) {
			closeButton.addEventListener('click', function(e) {
				e.preventDefault();
				e.stopPropagation();
				closeModal();
			});
		}

		// Close on overlay click
		modalOverlay.addEventListener('click', function(e) {
			if (e.target === modalOverlay) {
				closeModal();
			}
		});

		// Close on ESC key
		document.addEventListener('keydown', function(e) {
			if (e.key === 'Escape' && modalOverlay.classList.contains('active')) {
				closeModal();
			}
		});

		function closeModal() {
			const popup = document.getElementById('ourStoryPopup');
			
			// Add closing class for fade out animation
			modalOverlay.classList.add('closing');
			modalOverlay.classList.remove('active');
			
			// Hide after animation completes
			setTimeout(function() {
				modalOverlay.style.display = 'none';
				modalOverlay.classList.remove('closing');
				if (popup) {
					popup.style.display = 'none';
					popup.classList.remove('active');
				}
				document.body.classList.remove('popup-open');
				document.body.style.overflow = '';
			}, 300);
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
			if (typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined') {
				// Start async initialization
				initOurStory();
				// Initialize button click handler
				initButtonClick();
				// Initialize modal close functionality
				initModalClose();
			} else if (retryCount < maxRetries) {
				retryCount++;
				console.warn(`OurStory: GSAP or ScrollTrigger not loaded, retrying (${retryCount}/${maxRetries})...`);
				setTimeout(tryInit, retryDelay);
			} else {
				console.error('OurStory: Failed to load GSAP or ScrollTrigger after multiple retries.');
				// Still initialize button click and modal even if GSAP fails
				initButtonClick();
				initModalClose();
			}
		};

		if (document.readyState === 'loading') {
			document.addEventListener('DOMContentLoaded', tryInit);
		} else {
			// DOM already loaded
			tryInit();
		}
	};

	/**
	 * Initialize Swiper for modal
	 */
	const initModalSwiper = function() {
		const swiperElement = document.querySelector('[data-popup-modal-swiper]');
		if (!swiperElement) {
			return;
		}

		// Check if Swiper is loaded
		if (typeof Swiper === 'undefined') {
			console.warn('OurStory Modal: Swiper library is not loaded');
			return;
		}

		// Check if wrapper and slides exist
		const swiperWrapper = swiperElement.querySelector('.swiper-wrapper');
		if (!swiperWrapper) {
			return;
		}

		const slides = swiperWrapper.querySelectorAll('.swiper-slide');
		if (slides.length === 0) {
			return;
		}

		// Get navigation elements
		const nextButton = swiperElement.querySelector('.popup-swiper-next');
		const prevButton = swiperElement.querySelector('.popup-swiper-prev');
		const pagination = swiperElement.querySelector('.popup-swiper-pagination');

		// Build Swiper config
		// Show 1.5 slides initially (1 full + 0.5 peek of next)
		const swiperConfig = {
			spaceBetween: 0,
			slidesPerView: 1,
			speed: 800,
			autoplay: false, // Disable autoplay for manual control
			watchSlidesProgress: true,
			slideToClickedSlide: true,
		};

	 

		// Add pagination if element exists
		if (pagination && typeof Swiper.Pagination !== 'undefined') {
			if (!swiperConfig.modules) {
				swiperConfig.modules = [];
			}
			swiperConfig.modules.push(Swiper.Pagination);
			swiperConfig.pagination = {
				el: pagination,
				clickable: true,
			};
		}

		// Initialize Swiper
		try {
			const modalSwiper = new Swiper(swiperElement, swiperConfig);
			swiperElement._swiperInstance = modalSwiper;
			window.modalSwiperInstance = modalSwiper;

			// Function to trigger animations on active slide
			const triggerSlideAnimations = function(activeSlide) {
				if (!activeSlide) {
					return;
				}

				// Remove animation class from all slides first
				modalSwiper.slides.forEach(function(slide) {
					slide.classList.remove('slide-animate');
					// Reset all animated elements in the slide
					const animatedElements = slide.querySelectorAll(
						'.popup-slide-info-title, .popup-slide-info-description, ' +
						'.popup-slide-year, .popup-slide-title, .popup-slide-logos, ' +
						'.popup-slide-logo, .popup-slide-description'
					);
					animatedElements.forEach(function(element) {
						element.style.animation = 'none';
					});
				});

				// Force reflow to ensure reset
				void activeSlide.offsetWidth;

				// Add animation class to active slide after a brief delay
				setTimeout(function() {
					activeSlide.classList.add('slide-animate');
					// Re-enable animations
					const animatedElements = activeSlide.querySelectorAll(
						'.popup-slide-info-title, .popup-slide-info-description, ' +
						'.popup-slide-year, .popup-slide-title, .popup-slide-logos, ' +
						'.popup-slide-logo, .popup-slide-description'
					);
					animatedElements.forEach(function(element) {
						element.style.animation = '';
					});
				}, 100);
			};

			// Trigger animations on slide change
			modalSwiper.on('slideChange', function() {
				const activeSlide = modalSwiper.slides[modalSwiper.activeIndex];
				triggerSlideAnimations(activeSlide);
			});

			// Trigger animations on initial load (wait for modal to be fully visible)
			setTimeout(function() {
				const activeSlide = modalSwiper.slides[modalSwiper.activeIndex];
				if (activeSlide) {
					triggerSlideAnimations(activeSlide);
				}
			}, 400);
		} catch (error) {
			console.error('OurStory Modal: Error initializing Swiper', error);
		}
	};

	// Start initialization
	init();

})();
