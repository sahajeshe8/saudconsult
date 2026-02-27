/**
 * Our Journey Component JavaScript
 * 
 * GSAP ScrollTrigger pinned section with scroll-controlled slide progression
 */

(function() {
	'use strict';

	// Ensure GSAP and ScrollTrigger are available globally
	const gsap = window.gsap;
	const ScrollTrigger = window.ScrollTrigger;

	/**
	 * Initialize Our Journey ScrollTrigger Animation
	 */
	const initOurJourneyScrollTrigger = function() {
		// Check if GSAP and ScrollTrigger are loaded
		if (typeof gsap === 'undefined' || typeof ScrollTrigger === 'undefined') {
			console.warn('OurJourney: GSAP or ScrollTrigger not loaded');
			// Retry after a delay
			setTimeout(initOurJourneyScrollTrigger, 500);
			return;
		}

		// Check if desktop view (1024px and above)
		const windowWidth = window.innerWidth || document.documentElement.clientWidth;
		const isDesktop = windowWidth >= 1024;

		if (!isDesktop) {
			// On mobile/tablet, don't initialize ScrollTrigger - let regular Swiper handle it
			return;
		}

		// Register ScrollTrigger plugin
		gsap.registerPlugin(ScrollTrigger);

		// Get the section and swiper elements
		const section = document.querySelector('.our_journey_section');
		const mainSwiperEl = document.querySelector('.our_journey_main_swiper');
		const thumbSwiperEl = document.querySelector('.our_journey_thumb_swiper');
		
		if (!section || !mainSwiperEl || !thumbSwiperEl) {
			return; // Elements not found, might not be on this page
		}

		// Check if Swiper is loaded
		if (typeof Swiper === 'undefined') {
			console.warn('OurJourney: Swiper library is not loaded');
			setTimeout(initOurJourneyScrollTrigger, 500);
			return;
		}

		// Check if already initialized
		if (section.hasAttribute('data-scrolltrigger-initialized')) {
			return;
		}
		section.setAttribute('data-scrolltrigger-initialized', 'true');

		try {
			// Get all slides
			const slides = mainSwiperEl.querySelectorAll('.swiper-slide');
			const totalSlides = slides.length;

			if (totalSlides === 0) {
				console.warn('OurJourney: No slides found');
				return;
			}

			// Find custom navigation buttons scoped to this section
			const nextButton = section.querySelector('.news_but_next');
			const prevButton = section.querySelector('.news_but_prev');

			// Initialize thumbnail swiper first
			const thumbSwiper = new Swiper(thumbSwiperEl, {
				spaceBetween: 0,
				slidesPerView: 3.5,
				freeMode: true,
				loop: false,
				watchSlidesProgress: true,
				centeredSlides: false,
				breakpoints: {
					640: {
						slidesPerView: 3.5,
						spaceBetween: 0,
					},
					768: {
						slidesPerView: 3.5,
						spaceBetween: 0,
					},
					1024: {
						slidesPerView: 3.1,
						spaceBetween: 0,
					},
				},
			});

			// Initialize main swiper with thumbnail control and custom navigation
			const mainSwiper = new Swiper(mainSwiperEl, {
				spaceBetween: 10,
				slidesPerView: 1,
				loop: false,
				speed: 800,
				effect: 'fade',
				fadeEffect: {
					crossFade: true
				},
				thumbs: {
					swiper: thumbSwiper,
				},
				navigation: nextButton && prevButton ? {
					nextEl: prevButton,  // Swapped to fix reversed navigation
					prevEl: nextButton,  // Swapped to fix reversed navigation
				} : false,
				allowTouchMove: false, // Disable touch/swipe during scroll animation
			});

			// Calculate scroll distance per slide
			// Each slide will change with less scroll - approximately 50% of viewport height per slide for faster transitions
			const scrollPerSlide = window.innerHeight * 0.5; // Each slide gets 50% of viewport height for quicker changes
			const scrollDistance = scrollPerSlide * totalSlides;
			
			// Track current slide to avoid unnecessary updates
			let currentSlideIndex = 0;
			
			// Create ScrollTrigger to pin the section and control slide progression
			const scrollTrigger = ScrollTrigger.create({
				trigger: section,
				start: 'top top',
				end: `+=${scrollDistance}`,
				pin: true,
				pinSpacing: true,
				scrub: 0.3, // Faster scrubbing (0.3 second lag) for more responsive feel
				anticipatePin: 1,
				invalidateOnRefresh: true,
				onUpdate: (self) => {
					// Calculate which slide should be active based on scroll progress
					const progress = self.progress; // 0 to 1
					const targetSlideIndex = Math.min(
						Math.floor(progress * totalSlides),
						totalSlides - 1
					);
					
					// Only change slide if it's different from current
					if (currentSlideIndex !== targetSlideIndex) {
						currentSlideIndex = targetSlideIndex;
						mainSwiper.slideTo(currentSlideIndex, 400); // Faster transition for quicker response
					}
				},
				onEnter: () => {
					// When entering the pinned section
					mainSwiper.allowTouchMove = false;
					mainSwiper.setTranslate(0); // Reset position
				},
				onLeave: () => {
					// When leaving the pinned section (after all slides)
					mainSwiper.allowTouchMove = true; // Re-enable touch/swipe
				},
				onEnterBack: () => {
					// When scrolling back into the section
					mainSwiper.allowTouchMove = false;
				},
				onLeaveBack: () => {
					// When scrolling back before the section
					mainSwiper.allowTouchMove = true;
				}
			});

			// Handle window resize to recalculate scroll distance or disable on mobile
			let resizeTimer;
			window.addEventListener('resize', function() {
				clearTimeout(resizeTimer);
				resizeTimer = setTimeout(function() {
					const newWindowWidth = window.innerWidth || document.documentElement.clientWidth;
					const isStillDesktop = newWindowWidth >= 1024;
					
					if (!isStillDesktop) {
						// If resized to mobile/tablet, kill ScrollTrigger and let regular Swiper take over
						if (scrollTrigger) {
							scrollTrigger.kill();
							section.removeAttribute('data-scrolltrigger-initialized');
							mainSwiper.allowTouchMove = true; // Re-enable touch/swipe
						}
						return;
					}
					
					// Recalculate scroll distance with new viewport height
					const newScrollPerSlide = window.innerHeight * 0.5;
					const newScrollDistance = newScrollPerSlide * totalSlides;
					scrollTrigger.vars.end = `+=${newScrollDistance}`;
					ScrollTrigger.refresh();
				}, 250);
			});

			// Refresh ScrollTrigger after initialization
			ScrollTrigger.refresh();

			console.log('OurJourney: ScrollTrigger animation initialized successfully');
		} catch (error) {
			console.error('OurJourney: Error initializing ScrollTrigger animation', error);
		}
	};

	/**
	 * Initialize when DOM and libraries are ready
	 */
	const init = function() {
		// Wait for DOM to be ready
		if (document.readyState === 'loading') {
			document.addEventListener('DOMContentLoaded', function() {
				setTimeout(initOurJourneyScrollTrigger, 100);
			});
		} else {
			setTimeout(initOurJourneyScrollTrigger, 100);
		}
	};

	// Start initialization
	init();
})();
