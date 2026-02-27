/**
 * PageTabs Component JavaScript
 * 
 * Handles tab navigation and active state management
 */

(function() {
	'use strict';

	/**
	 * Initialize PageTabs Component
	 */
	const initPageTabs = function() {
		const tabsNav = document.querySelector('[data-page-tabs]');
		if (!tabsNav) {
			return;
		}

		const tabItems = tabsNav.querySelectorAll('.page-tabs-item');
		
		// Handle tab click
		tabItems.forEach(item => {
			const link = item.querySelector('.page-tabs-link');
			if (link) {
				link.addEventListener('click', function(e) {
					// Don't prevent default - allow navigation to work
					// Only update active state if it's not a hash link
					if (this.getAttribute('href') !== '#' && !this.getAttribute('href').startsWith('#')) {
						// Remove active class from all tab items
						tabItems.forEach(tab => {
							tab.classList.remove('active');
						});
						
						// Add active class to clicked tab item
						item.classList.add('active');
					}
				});
			}
		});
	};

	/**
	 * Initialize when DOM is ready
	 */
	const init = function() {
		if (document.readyState === 'loading') {
			document.addEventListener('DOMContentLoaded', initPageTabs);
		} else {
			initPageTabs();
		}
	};

	// Start initialization
	init();

})();

