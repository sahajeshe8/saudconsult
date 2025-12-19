/**
 * Header Component JavaScript
 * Converted from React to vanilla JavaScript for WordPress
 * 
 * Handles scroll detection, menu toggle, and animations
 */

(function() {
	'use strict';

	/**
	 * Initialize Header Component
	 */
	const initHeader = function() {
		const headerSection = document.getElementById('headerMainSection');
		const menuIcon = document.getElementById('menuIcon');
		
		if (!headerSection) {
			return;
		}

		let isScrolled = false;
		let isMenuOpen = false;
		const isHomePage = document.body.classList.contains('home');

		// Show header immediately on non-home pages (pages without Banner component)
		if (!isHomePage) {
			// Add class to show header immediately
			document.body.classList.add('header_visible');
		}

		/**
		 * Handle scroll event
		 */
		const handleScroll = function() {
			if (window.scrollY > 1) {
				if (!isScrolled) {
					isScrolled = true;
					headerSection.classList.add('scrolled');
				}
			} else {
				if (isScrolled) {
					isScrolled = false;
					headerSection.classList.remove('scrolled');
				}
			}
		};

		/**
		 * Toggle menu
		 */
		const toggleMenu = function(e) {
			if (e) {
				e.preventDefault();
				e.stopPropagation();
			}
			
			isMenuOpen = !isMenuOpen;
			
			if (menuIcon) {
				if (isMenuOpen) {
					menuIcon.classList.add('menu_open');
				} else {
					menuIcon.classList.remove('menu_open');
				}
			}

			// Toggle body classes
			document.body.classList.toggle('overflow_body_hidden');
			document.body.classList.toggle('header_activated');
			
			// Toggle mobile menu overlay
			const mobileMenuOverlay = document.getElementById('mobileMenuOverlay');
			if (mobileMenuOverlay) {
				if (isMenuOpen) {
					mobileMenuOverlay.classList.add('mobile_menu_open');
				} else {
					mobileMenuOverlay.classList.remove('mobile_menu_open');
				}
			}
		};

		/**
		 * Check current scroll position on load
		 */
		const checkInitialScroll = function() {
			handleScroll();
		};

		// Initialize
		checkInitialScroll();

		// Use window scroll event
		window.addEventListener('scroll', handleScroll, { passive: true });

		// Add menu toggle event listener
		if (menuIcon) {
			menuIcon.addEventListener('click', toggleMenu);
		}

		// Close menu when clicking outside or on menu items
		document.addEventListener('click', function(event) {
			const mobileMenuOverlay = document.getElementById('mobileMenuOverlay');
			if (isMenuOpen && mobileMenuOverlay) {
				// Close if clicking outside the menu overlay and menu icon
				if (!mobileMenuOverlay.contains(event.target) && !menuIcon.contains(event.target)) {
					toggleMenu();
				}
				// Close if clicking on a menu item
				if (mobileMenuOverlay.contains(event.target) && event.target.classList.contains('mobile_menu_item')) {
					setTimeout(toggleMenu, 300); // Small delay to allow navigation
				}
			}
		});

		// Close menu on escape key
		document.addEventListener('keydown', function(event) {
			if (event.key === 'Escape' && isMenuOpen) {
				toggleMenu();
			}
		});

		/**
		 * Initialize Dropdown Functionality
		 */
		const initDropdowns = function() {
			const dropdownArrows = document.querySelectorAll('.dropdown_arrow');
			const dropdownMenus = document.querySelectorAll('.dropdown_menu_fullwidth');
			
			// Close all dropdowns
			const closeAllDropdowns = function() {
				dropdownMenus.forEach(menu => {
					menu.classList.remove('dropdown_open');
				});
				dropdownArrows.forEach(arrow => {
					arrow.classList.remove('dropdown_active');
				});
				// Remove dropdown_open class from header
				if (headerSection) {
					headerSection.classList.remove('dropdown_open');
				}
			};

			// Calculate header height for dropdown positioning
			const updateDropdownPosition = function() {
				const headerSection = document.getElementById('headerMainSection');
				if (headerSection) {
					const headerHeight = headerSection.offsetHeight;
					dropdownMenus.forEach(menu => {
						menu.style.top = headerHeight + 'px';
					});
				}
			};

			// Update position on load and resize
			updateDropdownPosition();
			window.addEventListener('resize', updateDropdownPosition);

			// Handle dropdown arrow click
			dropdownArrows.forEach(arrow => {
				arrow.addEventListener('click', function(e) {
					e.preventDefault();
					e.stopPropagation();
					
					const dropdownId = this.getAttribute('data-dropdown');
					const dropdownMenu = document.getElementById('dropdown-' + dropdownId);
					
					if (!dropdownMenu) {
						return;
					}

					const isOpen = dropdownMenu.classList.contains('dropdown_open');

					// Close all dropdowns first
					closeAllDropdowns();

					// Toggle current dropdown if it wasn't open
					if (!isOpen) {
						updateDropdownPosition();
						dropdownMenu.classList.add('dropdown_open');
						this.classList.add('dropdown_active');
						// Add dropdown_open class to header
						if (headerSection) {
							headerSection.classList.add('dropdown_open');
						}
					}
				});
			});

			// Close dropdowns when clicking on dropdown items or buttons
			dropdownMenus.forEach(menu => {
				menu.addEventListener('click', function(e) {
					if (e.target.classList.contains('dropdown_item') || e.target.classList.contains('btn_primary')) {
						// Close dropdown after a short delay to allow navigation
						setTimeout(closeAllDropdowns, 100);
					}
				});
			});

			// Close dropdowns when clicking outside
			document.addEventListener('click', function(event) {
				const clickedInside = event.target.closest('.nav_item_with_dropdown');
				if (!clickedInside) {
					closeAllDropdowns();
				}
			});

			// Close dropdowns on escape key
			document.addEventListener('keydown', function(event) {
				if (event.key === 'Escape') {
					closeAllDropdowns();
				}
			});
		};

		// Initialize dropdowns
		initDropdowns();

		/**
		 * Initialize Mobile Menu Submenu Functionality
		 */
		const initMobileSubmenus = function() {
			const submenuToggles = document.querySelectorAll('.mobile_menu_submenu_toggle');
			
			submenuToggles.forEach(toggle => {
				toggle.addEventListener('click', function(e) {
					e.preventDefault();
					e.stopPropagation();
					
					const submenuId = this.getAttribute('data-submenu');
					const submenu = document.getElementById('mobile-submenu-' + submenuId);
					const parentItem = this.closest('.mobile_menu_item_has_submenu');
					
					if (!submenu || !parentItem) {
						return;
					}
					
					const isOpen = submenu.classList.contains('mobile_submenu_open');
					
					// Close all other submenus
					document.querySelectorAll('.mobile_menu_submenu').forEach(menu => {
						if (menu !== submenu) {
							menu.classList.remove('mobile_submenu_open');
						}
					});
					document.querySelectorAll('.mobile_menu_submenu_toggle').forEach(btn => {
						if (btn !== toggle) {
							btn.classList.remove('mobile_submenu_toggle_active');
						}
					});
					
					// Toggle current submenu
					if (isOpen) {
						submenu.classList.remove('mobile_submenu_open');
						toggle.classList.remove('mobile_submenu_toggle_active');
					} else {
						submenu.classList.add('mobile_submenu_open');
						toggle.classList.add('mobile_submenu_toggle_active');
					}
				});
			});
		};

		// Initialize mobile submenus
		initMobileSubmenus();
	};

	/**
	 * Initialize when DOM is ready
	 */
	const init = function() {
		if (document.readyState === 'loading') {
			document.addEventListener('DOMContentLoaded', initHeader);
		} else {
			// DOM already loaded
			initHeader();
		}
	};

	// Start initialization
	init();

})();

