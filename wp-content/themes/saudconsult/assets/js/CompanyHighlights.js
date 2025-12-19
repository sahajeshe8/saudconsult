/**
 * CompanyHighlights Component JavaScript
 * 
 * Handles count-up animations for highlight numbers when section comes into view
 * Uses CountUp.js library for smooth number animations
 */

(function() {
	'use strict';

	// Store animated items to prevent re-animation
	const animatedItems = new Set();

	/**
	 * Parse number string to extract numeric value, suffix, and prefix
	 * Handles formats like: "200K+", "8M+", "18+ Years", "1000", etc.
	 */
	const parseNumber = function(numberString) {
		if (!numberString || typeof numberString !== 'string') {
			return null;
		}

		const cleanString = numberString.trim();
		
		// Extract number part (with decimals)
		const numberMatch = cleanString.match(/(\d+(?:\.\d+)?)/);
		if (!numberMatch) {
			return null;
		}

		const baseValue = parseFloat(numberMatch[1]);
		const numberStartIndex = numberMatch.index;
		const numberEndIndex = numberStartIndex + numberMatch[0].length;
		
		// Extract prefix (text before number)
		const prefix = cleanString.substring(0, numberStartIndex).trim();
		
		// Extract suffix (text after number)
		const suffix = cleanString.substring(numberEndIndex).trim();
		
		// Check for plus sign
		const hasPlus = cleanString.includes('+');
		
		// Determine if it's K, M, or regular number
		let displayFormat = 'number';
		
		if (suffix.match(/^[Kk]/i) || (cleanString.match(/K/i) && !cleanString.match(/OK|ok|link/i))) {
			displayFormat = 'K';
		} else if (suffix.match(/^[Mm]/i) || (cleanString.match(/M/i) && !cleanString.match(/km|KM/i))) {
			displayFormat = 'M';
		} else if (suffix.match(/^[Bb]/i)) {
			displayFormat = 'B';
		}

		// Extract additional text from suffix (like "Years")
		let additionalText = suffix;
		if (displayFormat === 'K') {
			additionalText = additionalText.replace(/^[Kk]\+?/i, '').trim();
		} else if (displayFormat === 'M') {
			additionalText = additionalText.replace(/^[Mm]\+?/i, '').trim();
		} else if (displayFormat === 'B') {
			additionalText = additionalText.replace(/^[Bb]\+?/i, '').trim();
		}
		additionalText = additionalText.replace(/^\++\s*/, '').trim();

		return {
			baseValue: baseValue,
			prefix: prefix,
			displayFormat: displayFormat,
			hasPlus: hasPlus,
			additionalText: additionalText
		};
	};

	/**
	 * Format number for display
	 */
	const formatDisplay = function(value, parsed) {
		let formattedValue = '';
		
		if (parsed.displayFormat === 'K') {
			formattedValue = Math.floor(value) + 'K';
		} else if (parsed.displayFormat === 'M') {
			formattedValue = (value % 1 === 0 ? Math.floor(value) : value.toFixed(1)) + 'M';
		} else if (parsed.displayFormat === 'B') {
			formattedValue = (value % 1 === 0 ? Math.floor(value) : value.toFixed(1)) + 'B';
		} else {
			formattedValue = Math.floor(value).toString();
		}
		
		if (parsed.hasPlus) {
			formattedValue += '+';
		}
		
		if (parsed.additionalText) {
			formattedValue += ' ' + parsed.additionalText;
		}
		
		return parsed.prefix + formattedValue;
	};

	/**
	 * Animate number using custom animation with CountUp.js easing
	 */
	const animateNumber = function(element, parsed) {
		const startTime = performance.now();
		const duration = 2500;
		const startValue = 0;
		const endValue = parsed.baseValue;

		const animate = function(currentTime) {
			const elapsed = currentTime - startTime;
			const progress = Math.min(elapsed / duration, 1);

			// Easing function (ease-out cubic) - similar to CountUp.js
			const easeOut = 1 - Math.pow(1 - progress, 3);
			const current = startValue + (endValue - startValue) * easeOut;
			
			element.textContent = formatDisplay(current, parsed);

			if (progress < 1) {
				requestAnimationFrame(animate);
			} else {
				element.textContent = formatDisplay(endValue, parsed);
			}
		};

		requestAnimationFrame(animate);
	};

	/**
	 * Initialize CompanyHighlights Component
	 */
	const initCompanyHighlights = function() {
		// Find all highlight sections (both standalone and within COO quote)
		const highlightSections = document.querySelectorAll('[data-company-highlights], .company-highlights-wrapper');
		
		highlightSections.forEach(function(section) {
			const highlightItems = section.querySelectorAll('.company-highlight-item');
			
			if (highlightItems.length === 0) {
				return;
			}

			// Create Intersection Observer for the section
			const observer = new IntersectionObserver(
				function(entries) {
					entries.forEach(function(entry) {
						if (entry.isIntersecting && !animatedItems.has(section)) {
							// Mark section as animated
							animatedItems.add(section);

							// Animate each highlight item with stagger delay
							highlightItems.forEach(function(item, index) {
								const numberElement = item.querySelector('.company-highlight-number');
								
								if (!numberElement) {
									return;
								}

								// Get the original text
								const originalText = numberElement.textContent.trim();
								
								// Parse the number
								const parsed = parseNumber(originalText);
								
								if (!parsed || parsed.baseValue === 0) {
									// Not a valid number, skip animation
									return;
								}

								// Set initial value to 0 with proper format
								numberElement.textContent = formatDisplay(0, parsed);
								
								// Start animation with delay
								setTimeout(function() {
									animateNumber(numberElement, parsed);
								}, index * 200); // Stagger delay
							});

							// Disconnect observer after animation starts
							observer.unobserve(entry.target);
						}
					});
				},
				{
					threshold: 0.3,
					rootMargin: '0px 0px -50px 0px'
				}
			);

			// Observe the section
			observer.observe(section);
		});
	};

	/**
	 * Initialize when DOM is ready
	 */
	const init = function() {
		if (document.readyState === 'loading') {
			document.addEventListener('DOMContentLoaded', initCompanyHighlights);
		} else {
			// DOM already loaded
			initCompanyHighlights();
		}
	};

	// Start initialization
	init();

})();
