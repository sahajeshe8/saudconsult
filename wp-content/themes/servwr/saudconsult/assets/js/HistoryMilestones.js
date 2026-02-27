/**
 * History Milestones Component JavaScript
 * 
 * Handles year click events, content switching with fade effect,
 * and Swiper vertical slider for images
 */

(function() {
	'use strict';

	let historyMilestonesSwiper = null;

	/**
	 * Initialize History Milestones Component
	 */
	const initHistoryMilestones = function() {
		// Check if Swiper is loaded
		if (typeof Swiper === 'undefined') {
			console.warn('HistoryMilestones: Swiper library is not loaded');
			return;
		}

		const section = document.querySelector('.history_milestones_content');
		if (!section) {
			console.warn('HistoryMilestones: Section not found');
			return;
		}

		// Get year list items
		const yearItems = section.querySelectorAll('.time-line-block ul li');
		if (yearItems.length === 0) {
			console.warn('HistoryMilestones: No year items found');
			return;
		}

		// Get content items
		const contentItems = section.querySelectorAll('.time-line-txt-content');
		if (contentItems.length === 0) {
			console.warn('HistoryMilestones: No content items found');
			return;
		}

		// Get Swiper element
		const swiperElement = section.querySelector('.history-milestones-image-swiper');
		if (!swiperElement) {
			console.warn('HistoryMilestones: Swiper element not found');
			return;
		}

		// Initialize Swiper vertical slider
		historyMilestonesSwiper = new Swiper(swiperElement, {
			direction: 'vertical',
			slidesPerView: 1,
			spaceBetween: 0,
			speed: 800,
			allowTouchMove: false, // Disable touch/swipe - only control via year clicks
			effect: 'slide',
		});

		/**
		 * Update active year
		 */
		const updateActiveYear = function(activeIndex) {
			yearItems.forEach((item, index) => {
				if (index === activeIndex) {
					item.classList.add('active');
				} else {
					item.classList.remove('active');
				}
			});
		};

		/**
		 * Update content with fade effect
		 */
		const updateContent = function(activeIndex) {
			contentItems.forEach((item, index) => {
				if (index === activeIndex) {
					// Remove active class from all items first
					contentItems.forEach(function(contentItem) {
						contentItem.classList.remove('active');
						contentItem.style.opacity = '0';
					});
					
					// Fade in the active item
					item.classList.add('active');
					setTimeout(function() {
						item.style.transition = 'opacity 0.5s ease-in-out';
						item.style.opacity = '1';
					}, 10);
				} else {
					// Fade out
					item.style.transition = 'opacity 0.5s ease-in-out';
					item.style.opacity = '0';
					setTimeout(function() {
						if (!item.classList.contains('active')) {
							item.classList.remove('active');
						}
					}, 500);
				}
			});
		};

		/**
		 * Update Swiper slide
		 */
		const updateSwiperSlide = function(activeIndex) {
			if (historyMilestonesSwiper) {
				historyMilestonesSwiper.slideTo(activeIndex, 800);
			}
		};

		/**
		 * Handle year click
		 */
		const handleYearClick = function(yearItem, index) {
			// Update active year
			updateActiveYear(index);

			// Update content with fade effect
			updateContent(index);

			// Update Swiper slide
			updateSwiperSlide(index);
		};

		// Add click event listeners to year items
		yearItems.forEach((yearItem, index) => {
			yearItem.addEventListener('click', function() {
				handleYearClick(yearItem, index);
			});

			// Make year items clickable (cursor pointer)
			yearItem.style.cursor = 'pointer';
		});

		// Initialize first content item
		if (contentItems.length > 0) {
			contentItems[0].classList.add('active');
			contentItems[0].style.opacity = '1';
		}
	};

	/**
	 * Initialize when DOM is ready
	 */
	const init = function() {
		if (document.readyState === 'loading') {
			document.addEventListener('DOMContentLoaded', function() {
				setTimeout(initHistoryMilestones, 100);
			});
		} else {
			setTimeout(initHistoryMilestones, 100);
		}
	};

	// Start initialization
	init();

})();

