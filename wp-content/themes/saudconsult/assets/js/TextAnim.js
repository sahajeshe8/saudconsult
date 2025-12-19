/**
 * TextAnim Component JavaScript
 * Converted from React to vanilla JavaScript for WordPress
 * 
 * Exact conversion from original TextAnim.js
 */

(function() {
	'use strict';

	/**
	 * Initialize TextAnim Component
	 * Matches original React useEffect logic
	 */
	const initTextAnim = async function() {
		try {
			// Check if GSAP and ScrollTrigger are loaded
			if (typeof gsap === 'undefined' || typeof ScrollTrigger === 'undefined') {
				console.warn('TextAnim: GSAP or ScrollTrigger not loaded');
				return;
			}

			// Register ScrollTrigger plugin
			gsap.registerPlugin(ScrollTrigger);

			// Wait for DOM to be ready (matching original: await new Promise(resolve => setTimeout(resolve, 200)))
			await new Promise(function(resolve) {
				setTimeout(resolve, 200);
			});

			// Get all text anim elements
			const textAnimElements = document.querySelectorAll('.text[data-text-anim]');

			textAnimElements.forEach(function(element) {
				// Get all letter spans - match original: textRef.current.querySelectorAll(`.${styles.letter}`)
				const letterSpans = element.querySelectorAll('.letter');

				console.log('TextAnim: Found', letterSpans.length, 'letter spans');

				if (letterSpans.length === 0) {
					console.warn('TextAnim: No letter spans found');
					return;
				}

				// Convert NodeList to Array for GSAP - match original: Array.from(letterSpans)
				const letterArray = Array.from(letterSpans);

				// Set initial state - all letters show only stroke (background-position-x: 100%)
				// Match original: gsap.set(letterArray, { backgroundPositionX: "100%" })
				gsap.set(letterArray, {
					backgroundPositionX: "100%"
				});

				// Create a master ScrollTrigger that controls all letters
				const masterTrigger = ScrollTrigger.create({
					trigger: element,
					start: "top 80%",
					end: "top 20%",
					scrub: 1,
					onUpdate: function(self) {
						const progress = self.progress;
						const totalLetters = letterArray.length;

						// Calculate which letters should be filled based on scroll progress
						letterArray.forEach(function(letter, index) {
							// Each letter gets a portion of the scroll progress
							// First letter starts at 0, last letter completes at 1
							const letterStart = index / totalLetters;
							const letterEnd = (index + 1) / totalLetters;
							const letterDuration = letterEnd - letterStart;

							let letterProgress = 0;

							if (progress >= letterStart) {
								if (progress >= letterEnd) {
									letterProgress = 1; // Letter is fully filled
								} else {
									// Letter is currently filling
									letterProgress = (progress - letterStart) / letterDuration;
								}
							}

							// Animate from 100% (stroke only) to 0% (fully filled)
							// Match original: backgroundPositionX: `${backgroundPos}%`
							const backgroundPos = 100 - (letterProgress * 100);
							gsap.set(letter, {
								backgroundPositionX: backgroundPos + "%"
							});
						});
					}
				});

				// Store trigger reference for cleanup
				element._textAnimTrigger = masterTrigger;
			});

			// Refresh ScrollTrigger after initialization
			ScrollTrigger.refresh();
		} catch (error) {
			console.error('Failed to initialize TextAnim:', error);
		}
	};

	/**
	 * Initialize when DOM is ready
	 * Matches original React useEffect pattern
	 */
	const init = function() {
		let retryCount = 0;
		const maxRetries = 10;
		const retryDelay = 500; // ms

		const tryInit = function() {
			if (typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined') {
				// Start async initialization
				initTextAnim();
			} else if (retryCount < maxRetries) {
				retryCount++;
				console.warn(`TextAnim: GSAP or ScrollTrigger not loaded, retrying (${retryCount}/${maxRetries})...`);
				setTimeout(tryInit, retryDelay);
			} else {
				console.error('TextAnim: Failed to load GSAP or ScrollTrigger after multiple retries.');
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
