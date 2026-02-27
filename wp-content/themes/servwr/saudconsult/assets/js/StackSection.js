/**
 * Stack Section Component JavaScript
 * 
 * GSAP ScrollTrigger pinned gallery with stack animation
 * Converted from React component
 */

(function() {
	'use strict';

	// Ensure GSAP and ScrollTrigger are available globally
	const gsap = window.gsap;
	const ScrollTrigger = window.ScrollTrigger;

	/**
	 * Initialize Stack Section Animations
	 */
	const initStackSection = function() {
		// Check if GSAP and ScrollTrigger are loaded
		if (typeof gsap === 'undefined' || typeof ScrollTrigger === 'undefined') {
			console.warn('StackSection: GSAP or ScrollTrigger not loaded');
			return;
		}

		// Register ScrollTrigger plugin
		gsap.registerPlugin(ScrollTrigger);

		// Get window width for responsive adjustments
		var w = document.documentElement.clientWidth || window.innerWidth;
		var isMobile = w < 768;

		// Get all pinned galleries
		const pinnedGalleries = document.querySelectorAll('.stack-section.pinned_gallery');
		
		if (pinnedGalleries.length === 0) {
			return; // No stack sections found
		}

		gsap.utils.toArray('.stack-section.pinned_gallery').forEach((pinnedGallery) => {
			if (!pinnedGallery) return;

			// Handle random image rotation if class exists
			if (pinnedGallery.classList.contains('random-img-ratation')) {
				const rotatedImages = pinnedGallery.querySelectorAll('.pinned_image:not(:first-child):not(:last-child)');
				gsap.utils.toArray(rotatedImages).forEach((pImage, i, arr) => {
					const img = pImage.querySelector('img');
					if (img) {
						let rotation = i % 2 === 0 ? gsap.utils.random(-4, 0) : gsap.utils.random(0, 4);
						gsap.set(img, { rotation: rotation });
					}
				});
			}

			const pinnedImages = pinnedGallery.querySelectorAll('.pinned_image');
			const lastImage = pinnedGallery.querySelector('.pinned_image.last-pin-block');
			const firstImage = pinnedImages[0];
			const firstCrdBlock = firstImage ? firstImage.querySelector('.crd_block') : null;
			const isTextBlock = firstCrdBlock && firstCrdBlock.classList.contains('stack-text-block');

			// Handle text block separately - pin until last section appears
			if (isTextBlock && lastImage) {
				// Set initial z-index
				gsap.set(firstCrdBlock, { zIndex: 1000 });
				
				ScrollTrigger.create({
					trigger: firstImage,
					start: "top top",
					endTrigger: lastImage,
					end: "top top",
					pin: true,
					pinSpacing: false,
					scrub: 1,
					invalidateOnRefresh: true,
					anticipatePin: 1,
				});
			}

			// Handle regular image sections (skip first if it's text block)
			const startIndex = isTextBlock ? 1 : 0;
			pinnedImages.forEach((pImage, i, arr) => {
				// Skip first if it's text block (already handled) and skip last
				if (i >= startIndex && i < arr.length - 1) {
					const durationMultiplier = arr.length - i - 1;
					const crdBlock = pImage.querySelector('.crd_block');
					
					if (!crdBlock) return;

					// Calculate z-index for proper stacking
					const zIndexValue = (arr.length - i) * 10;
					
					// Set initial z-index
					gsap.set(crdBlock, { zIndex: zIndexValue });

					ScrollTrigger.create({
						trigger: pImage,
						start: function() {
							// For mobile, use top top, for desktop use center
							if (isMobile) {
								return "top top";
							} else {
								const centerPin = (window.innerHeight - crdBlock.offsetHeight) / 2;
								return "top +=" + centerPin;
							}
						},
						end: function() {
							const durationHeight = pImage.offsetHeight * durationMultiplier;
							return "+=" + durationHeight;
						},
						pin: true,
						pinSpacing: false,
						scrub: isMobile ? 0.5 : 1,
						invalidateOnRefresh: true,
						anticipatePin: 1,
						animation: gsap.to(crdBlock, {
							scale: 1,
							opacity: 1,
							duration: 1,
							ease: "none"
						}),
					});
				}
			});
		});

		// Refresh ScrollTrigger after initialization
		ScrollTrigger.refresh();

		// Handle window resize to prevent glitches
		let resizeTimer;
		window.addEventListener('resize', function() {
			clearTimeout(resizeTimer);
			resizeTimer = setTimeout(function() {
				ScrollTrigger.refresh();
			}, 250);
		});
	};

	/**
	 * Initialize when DOM and libraries are ready
	 */
	const init = function() {
		let retryCount = 0;
		const maxRetries = 10;
		const retryDelay = 500; // ms

		const tryInit = function() {
			if (typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined') {
				// Wait a bit for DOM to be fully ready
				if (document.readyState === 'loading') {
					document.addEventListener('DOMContentLoaded', function() {
						setTimeout(initStackSection, 100);
					});
				} else {
					setTimeout(initStackSection, 100);
				}
			} else if (retryCount < maxRetries) {
				retryCount++;
				console.warn(`StackSection: GSAP or ScrollTrigger not loaded, retrying (${retryCount}/${maxRetries})...`);
				setTimeout(tryInit, retryDelay);
			} else {
				console.error('StackSection: Failed to load GSAP or ScrollTrigger after multiple retries.');
			}
		};

		tryInit();
	};

	// Start initialization
	init();

})();

