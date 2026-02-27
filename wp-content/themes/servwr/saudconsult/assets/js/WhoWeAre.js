/**
 * WhoWeAre Component JavaScript
 * Converted from React to vanilla JavaScript for WordPress
 * 
 * Handles GSAP scroll-triggered animations
 */

(function() {
	'use strict';

	// Ensure GSAP is available globally
	const gsap = window.gsap;
	const ScrollTrigger = window.ScrollTrigger;

	/**
	 * Initialize WhoWeAre Component Animations
	 */
	const initWhoWeAre = function() {
		// Get DOM elements using data attributes
		const headingRef = document.querySelector('[data-who-we-are-heading]');
		const titleRef = document.querySelector('[data-who-we-are-title]');
		const imageRef = document.querySelector('[data-who-we-are-image]');
		const desc1Ref = document.querySelector('[data-who-we-are-desc-1]');
		const desc2Ref = document.querySelector('[data-who-we-are-desc-2]');
		const buttonRef = document.querySelector('[data-who-we-are-button]');

		// Validate required elements
		if (!headingRef || !titleRef || !imageRef || !desc1Ref || !desc2Ref || !buttonRef) {
			console.warn('WhoWeAre: Required elements not found');
			return;
		}

		// Check if GSAP is loaded
		if (typeof gsap === 'undefined') {
			console.error('WhoWeAre: GSAP library is not loaded');
			return;
		}

		// Check if ScrollTrigger is available
		if (typeof ScrollTrigger === 'undefined') {
			console.warn('WhoWeAre: ScrollTrigger not found, using basic GSAP animations');
			initBasicAnimations(headingRef, titleRef, imageRef, desc1Ref, desc2Ref, buttonRef);
		} else {
			// Register ScrollTrigger plugin
			gsap.registerPlugin(ScrollTrigger);
			initScrollAnimations(headingRef, titleRef, imageRef, desc1Ref, desc2Ref, buttonRef);
		}
	};

	/**
	 * Initialize Scroll-Triggered Animations with ScrollTrigger
	 */
	const initScrollAnimations = function(headingRef, titleRef, imageRef, desc1Ref, desc2Ref, buttonRef) {
		// Set initial states
		gsap.set([headingRef, titleRef, imageRef, desc1Ref, desc2Ref, buttonRef], {
			opacity: 0,
			y: 50,
		});

		// Set initial state for heading (fade from left)
		gsap.set(headingRef, {
			opacity: 0,
			x: -50,
		});

		// Create timeline for heading (fade from left)
		gsap.to(headingRef, {
			opacity: 1,
			x: 0,
			duration: 0.8,
			ease: "power2.out",
			scrollTrigger: {
				trigger: headingRef,
				start: "top 80%",
				end: "top 50%",
				toggleActions: "play none none none",
				scrub: false,
			},
		});

		// Animate title (fade up)
		gsap.to(titleRef, {
			opacity: 1,
			y: 0,
			duration: 0.8,
			ease: "power2.out",
			scrollTrigger: {
				trigger: titleRef,
				start: "top 80%",
				end: "top 50%",
				toggleActions: "play none none none",
				scrub: false,
			},
		});

		// Animate image (fade up)
		gsap.to(imageRef, {
			opacity: 1,
			y: 0,
			duration: 0.8,
			ease: "power2.out",
			scrollTrigger: {
				trigger: imageRef,
				start: "top 80%",
				end: "top 50%",
				toggleActions: "play none none none",
				scrub: false,
			},
		});

		// Animate descriptions (fade up with stagger)
		gsap.to([desc1Ref, desc2Ref], {
			opacity: 1,
			y: 0,
			duration: 0.8,
			ease: "power2.out",
			stagger: 0.2,
			scrollTrigger: {
				trigger: desc1Ref,
				start: "top 80%",
				end: "top 50%",
				toggleActions: "play none none none",
				scrub: false,
			},
		});

		// Animate button (fade up)
		gsap.to(buttonRef, {
			opacity: 1,
			y: 0,
			duration: 0.8,
			ease: "power2.out",
			scrollTrigger: {
				trigger: buttonRef,
				start: "top 80%",
				end: "top 50%",
				toggleActions: "play none none none",
				scrub: false,
			},
		});
	};

	/**
	 * Initialize Basic Animations (fallback if ScrollTrigger not available)
	 */
	const initBasicAnimations = function(headingRef, titleRef, imageRef, desc1Ref, desc2Ref, buttonRef) {
		// Set initial states
		gsap.set(headingRef, {
			opacity: 0,
			x: -50,
		});

		gsap.set([titleRef, imageRef, desc1Ref, desc2Ref, buttonRef], {
			opacity: 0,
			y: 50,
		});

		// Create timeline
		const tl = gsap.timeline({
			scrollTrigger: {
				trigger: headingRef.closest('.whoWeAreSection'),
				start: "top 80%",
				toggleActions: "play none none none",
			},
		});

		// Animate elements in sequence
		tl.to(headingRef, {
			opacity: 1,
			x: 0,
			duration: 0.8,
			ease: "power2.out",
		})
		.to(titleRef, {
			opacity: 1,
			y: 0,
			duration: 0.8,
			ease: "power2.out",
		}, "-=0.4")
		.to(imageRef, {
			opacity: 1,
			y: 0,
			duration: 0.8,
			ease: "power2.out",
		}, "-=0.6")
		.to([desc1Ref, desc2Ref], {
			opacity: 1,
			y: 0,
			duration: 0.8,
			ease: "power2.out",
			stagger: 0.2,
		}, "-=0.4")
		.to(buttonRef, {
			opacity: 1,
			y: 0,
			duration: 0.8,
			ease: "power2.out",
		}, "-=0.4");
	};

	/**
	 * Initialize when DOM is ready
	 */
	const init = function() {
		let retryCount = 0;
		const maxRetries = 10;
		const retryDelay = 500; // ms

		const tryInit = function() {
			if (typeof gsap !== 'undefined') {
				initWhoWeAre();
			} else if (retryCount < maxRetries) {
				retryCount++;
				console.warn(`WhoWeAre: GSAP not loaded, retrying (${retryCount}/${maxRetries})...`);
				setTimeout(tryInit, retryDelay);
			} else {
				console.error('WhoWeAre: Failed to load GSAP after multiple retries.');
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

