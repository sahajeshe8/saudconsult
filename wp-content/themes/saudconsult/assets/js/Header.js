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
		
		// Check if black-header is already set by page template (before any scroll)
		const hasBlackHeaderFromTemplate = headerSection.classList.contains('black-header');

		// Get logo and contact buttons
		const logoImg = headerSection.querySelector('.logo_desktop .navbar-brand img');
		const contactButtons = headerSection.querySelectorAll('.btn_style.btn_transparent[href*="contact"]');
		
		// Store original logo src (captured on page load)
		const originalLogoSrc = logoImg ? logoImg.getAttribute('src') : '';
		
		// Determine logo paths (swap between regular and black)
		const getLogoPath = function(isBlack) {
			if (!originalLogoSrc) return '';
			if (isBlack) {
				// Return black logo path
				return originalLogoSrc.replace('saudconsult-logo.svg', 'saudconsult-logo-black.svg');
			} else {
				// Return regular logo path
				return originalLogoSrc.replace('saudconsult-logo-black.svg', 'saudconsult-logo.svg');
			}
		};

		// Show header immediately on non-home pages (pages without Banner component)
		if (!isHomePage) {
			// Add class to show header immediately
			document.body.classList.add('header_visible');
		}

		/**
		 * Update logo and buttons for sticky header
		 */
		const updateStickyHeaderElements = function(isSticky) {
			// Update logo
			if (logoImg && originalLogoSrc) {
				const newLogoSrc = getLogoPath(isSticky);
				if (newLogoSrc && newLogoSrc !== logoImg.getAttribute('src')) {
					logoImg.setAttribute('src', newLogoSrc);
				}
			}
			
			// Update contact buttons
			contactButtons.forEach(function(btn) {
				if (isSticky) {
					// Add btn_green, remove btn_transparent
					btn.classList.remove('btn_transparent');
					btn.classList.add('btn_green');
				} else {
					// Remove btn_green, add btn_transparent
					btn.classList.remove('btn_green');
					btn.classList.add('btn_transparent');
				}
			});
		};

		/**
		 * Handle scroll event
		 */
		const handleScroll = function() {
			if (window.scrollY > 1) {
				if (!isScrolled) {
					isScrolled = true;
					// Only add if not already present from template
					if (!hasBlackHeaderFromTemplate) {
						headerSection.classList.add('black-header');
						updateStickyHeaderElements(true);
					}
				}
			} else {
				if (isScrolled) {
					isScrolled = false;
					// Only remove if it wasn't there from template
					if (!hasBlackHeaderFromTemplate) {
						headerSection.classList.remove('black-header');
						updateStickyHeaderElements(false);
					}
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
					// Scroll header to top when menu opens (mobile view)
					if (window.innerWidth <= 1024 && headerSection) {
						window.scrollTo({
							top: 0,
							behavior: 'smooth'
						});
						// Also ensure header is at top after scroll
						setTimeout(function() {
							headerSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
						}, 100);
					}
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
		 * Initialize Mobile Menu Submenu Functionality - Same as Desktop
		 */
		const initMobileSubmenus = function() {
			const mobileMenuItems = document.querySelectorAll('.mobile_menu_item');
			const mobileMenuList = document.querySelector('.mobile_menu_list');
			
			if (!mobileMenuList) {
				return;
			}

			// Find desktop menu items with submenus to replicate in mobile
			const desktopNavItems = document.querySelectorAll('.nav-item');
			
			// Close all mobile submenus with accordion animation
			const closeAllMobileSubmenus = function(excludeMenu = null) {
				document.querySelectorAll('.mobile_menu_submenu').forEach(menu => {
					if (menu !== excludeMenu) {
						const isOpen = menu.classList.contains('mobile_submenu_open');
						if (isOpen) {
							// Animate height to 0
							const content = menu.querySelector('.mobile_submenu_content');
							if (content) {
								content.style.height = content.scrollHeight + 'px';
								// Force reflow
								content.offsetHeight;
								content.style.height = '0px';
							}
							menu.classList.remove('mobile_submenu_open');
						}
					}
				});
				document.querySelectorAll('.mobile_menu_item_has_submenu').forEach(item => {
					if (!excludeMenu || !item.contains(excludeMenu)) {
						item.classList.remove('mobile_submenu_item_active');
					}
				});
				document.querySelectorAll('.mobile_menu_submenu_toggle').forEach(btn => {
					if (!excludeMenu || btn.getAttribute('data-submenu') !== excludeMenu.id) {
						btn.classList.remove('mobile_submenu_toggle_active');
					}
				});
			};

			// Open submenu with accordion animation
			const openMobileSubmenu = function(submenu, parentItem, toggleButton) {
				const content = submenu.querySelector('.mobile_submenu_content');
				if (content) {
					// Set initial height
					submenu.style.display = 'block';
					content.style.height = '0px';
					content.style.overflow = 'hidden';
					
					// Force reflow
					content.offsetHeight;
					
					// Animate to full height
					const targetHeight = content.scrollHeight;
					content.style.height = targetHeight + 'px';
					
					// After animation, set to auto
					setTimeout(function() {
						content.style.height = 'auto';
						content.style.overflow = 'visible';
					}, 300);
				}
				
				submenu.classList.add('mobile_submenu_open');
				parentItem.classList.add('mobile_submenu_item_active');
				if (toggleButton) {
					toggleButton.classList.add('mobile_submenu_toggle_active');
				}
			};

			// Close submenu with accordion animation
			const closeMobileSubmenu = function(submenu, parentItem, toggleButton) {
				const content = submenu.querySelector('.mobile_submenu_content');
				if (content) {
					// Set current height
					content.style.height = content.scrollHeight + 'px';
					content.style.overflow = 'hidden';
					
					// Force reflow
					content.offsetHeight;
					
					// Animate to 0
					content.style.height = '0px';
					
					// Remove classes after animation
					setTimeout(function() {
						submenu.style.display = '';
						content.style.height = '';
						content.style.overflow = '';
					}, 300);
				}
				
				submenu.classList.remove('mobile_submenu_open');
				parentItem.classList.remove('mobile_submenu_item_active');
				if (toggleButton) {
					toggleButton.classList.remove('mobile_submenu_toggle_active');
				}
			};

			// Process each desktop nav item to create mobile equivalents
			desktopNavItems.forEach(function(desktopItem, index) {
				const desktopSubmenu = desktopItem.querySelector('.sub_menu_block');
				if (!desktopSubmenu) {
					return; // Skip items without submenus
				}

				// Find corresponding mobile menu item or create one
				const desktopLink = desktopItem.querySelector('.nav-link');
				const desktopLinkText = desktopLink ? desktopLink.textContent.trim().replace(/\s+/g, ' ') : '';
				
				// Try to find existing mobile menu item with same text
				let mobileItem = null;
				mobileMenuItems.forEach(function(item) {
					const itemLink = item.querySelector('a');
					if (itemLink && itemLink.textContent.trim().replace(/\s+/g, ' ') === desktopLinkText) {
						mobileItem = item;
					}
				});

				// If mobile item found, enhance it with submenu functionality
				if (mobileItem) {
					// Mark as having submenu
					mobileItem.classList.add('mobile_menu_item_has_submenu');
					
					// Get submenu content from desktop
					const submenuInner = desktopSubmenu.querySelector('.sub_menu_block_inner');
					if (submenuInner) {
						// Check if submenu already exists in mobile
						let mobileSubmenu = mobileItem.querySelector('.mobile_menu_submenu');
						
						if (!mobileSubmenu) {
							// Create mobile submenu structure
							mobileSubmenu = document.createElement('div');
							mobileSubmenu.className = 'mobile_menu_submenu';
							mobileSubmenu.id = 'mobile-submenu-' + index;
							
							// Clone and adapt desktop submenu content for mobile
							const mobileSubmenuContent = document.createElement('div');
							mobileSubmenuContent.className = 'mobile_submenu_content';
							
							// Get all links from desktop submenu
							const desktopSubmenuLinks = desktopSubmenu.querySelectorAll('.list-submenu a, .sub_menu_block_right_block a');
							if (desktopSubmenuLinks.length > 0) {
								const mobileSubmenuList = document.createElement('ul');
								mobileSubmenuList.className = 'mobile_submenu_list';
								
								desktopSubmenuLinks.forEach(function(link) {
									const listItem = document.createElement('li');
									const mobileLink = document.createElement('a');
									mobileLink.href = link.href;
									mobileLink.textContent = link.textContent.trim();
									listItem.appendChild(mobileLink);
									mobileSubmenuList.appendChild(listItem);
								});
								
								mobileSubmenuContent.appendChild(mobileSubmenuList);
							}
							
							mobileSubmenu.appendChild(mobileSubmenuContent);
							mobileItem.appendChild(mobileSubmenu);
						}

						// Add toggle button if not exists
						let toggleButton = mobileItem.querySelector('.mobile_menu_submenu_toggle');
						if (!toggleButton) {
							toggleButton = document.createElement('span');
							toggleButton.className = 'mobile_menu_submenu_toggle';
							toggleButton.setAttribute('data-submenu', 'mobile-submenu-' + index);
							toggleButton.innerHTML = '<img src="' + (desktopLink.querySelector('img') ? desktopLink.querySelector('img').src : '') + '" alt="Toggle">';
							
							// Insert toggle after the link
							const mobileLink = mobileItem.querySelector('a');
							if (mobileLink) {
								mobileLink.parentNode.insertBefore(toggleButton, mobileLink.nextSibling);
							}
						}

						// Link should navigate normally, only toggle button opens accordion
						const mobileLink = mobileItem.querySelector('a');
						if (mobileLink) {
							// Remove any existing click handlers that might prevent navigation
							mobileLink.addEventListener('click', function(e) {
								// Allow link to navigate normally
								// Don't prevent default - let the link work as normal
							});
						}

						// Add toggle button click handler (accordion) - ONLY opens on click
						if (toggleButton) {
							// Mark as handled to prevent duplicate handlers
							if (!toggleButton.hasAttribute('data-toggle-handler-added')) {
								toggleButton.setAttribute('data-toggle-handler-added', 'true');
								
								toggleButton.addEventListener('click', function(e) {
									e.preventDefault();
									e.stopPropagation();
									e.stopImmediatePropagation();
									
									const isOpen = mobileSubmenu.classList.contains('mobile_submenu_open');
									
									if (isOpen) {
										// Close this submenu
										closeMobileSubmenu(mobileSubmenu, mobileItem, toggleButton);
									} else {
										// Close all other submenus first (accordion behavior)
										closeAllMobileSubmenus(mobileSubmenu);
										// Then open this one
										openMobileSubmenu(mobileSubmenu, mobileItem, toggleButton);
									}
									
									return false;
								}, true); // Use capture phase to ensure it fires first
							}
						}
					}
				}
			});

			// Also handle existing submenu toggles (for manually added ones) - ONLY opens on click
			const submenuToggles = document.querySelectorAll('.mobile_menu_submenu_toggle');
			
			submenuToggles.forEach(toggle => {
				// Skip if already has handler
				if (toggle.hasAttribute('data-handler-added')) {
					return;
				}
				
				toggle.setAttribute('data-handler-added', 'true');
				
				toggle.addEventListener('click', function(e) {
					e.preventDefault();
					e.stopPropagation();
					e.stopImmediatePropagation();
					
					const submenuId = this.getAttribute('data-submenu');
					const submenu = document.getElementById(submenuId);
					const parentItem = this.closest('.mobile_menu_item_has_submenu');
					
					if (!submenu || !parentItem) {
						return false;
					}
					
					const isOpen = submenu.classList.contains('mobile_submenu_open');
					
					if (isOpen) {
						// Close this submenu
						closeMobileSubmenu(submenu, parentItem, toggle);
					} else {
						// Close all other submenus first (accordion behavior)
						closeAllMobileSubmenus(submenu);
						// Then open this one
						openMobileSubmenu(submenu, parentItem, toggle);
					}
					
					return false;
				}, true); // Use capture phase to ensure it fires first
			});

			// Close submenus when clicking outside
			document.addEventListener('click', function(event) {
				const clickedInside = event.target.closest('.mobile_menu_item_has_submenu');
				if (!clickedInside) {
					closeAllMobileSubmenus();
				}
			});
		};

		// Initialize mobile submenus
		initMobileSubmenus();

		/**
		 * Initialize Mega Menu Functionality
		 */
		const initMegaMenu = function() {
			// Check if jQuery is available
			if (typeof jQuery === 'undefined') {
				console.warn('MegaMenu: jQuery is not loaded');
				return;
			}

			// Wait for DOM to be ready
			jQuery(document).ready(function() {
				const $navItems = jQuery('.nav-item');
				const $megaMenus = jQuery('.sub_menu_block');

				// Close all mega menus
				const closeAllMegaMenus = function() {
					$megaMenus.removeClass('active');
					$navItems.removeClass('mega_menu_active');
				};

				// Handle click on nav links that have mega menus
				$navItems.each(function() {
					const $navItem = jQuery(this);
					const $navLink = $navItem.find('.nav-link');
					const $megaMenu = $navItem.find('.sub_menu_block');

					// Only add click handler if mega menu exists
					if ($megaMenu.length > 0 && $navLink.length > 0) {
						// Handle click on the nav-link
						$navLink.on('click', function(e) {
							e.preventDefault();
							e.stopPropagation();

							const isActive = $megaMenu.hasClass('active');

							// Close all mega menus first
							closeAllMegaMenus();

							// Toggle current mega menu if it wasn't active
							if (!isActive) {
								$megaMenu.addClass('active');
								$navItem.addClass('mega_menu_active');
							}
						});
					}
				});

				// Close mega menus when clicking outside
				jQuery(document).on('click', function(e) {
					const $target = jQuery(e.target);
					const isNavLink = $target.closest('.nav-link').length > 0;
					const isNavItem = $target.closest('.nav-item').length > 0;
					const isMegaMenu = $target.closest('.sub_menu_block').length > 0;
					
					// Don't close if clicking on nav-link or inside mega menu
					if (!isNavLink && !isNavItem && !isMegaMenu) {
						closeAllMegaMenus();
					}
				});

				// Close mega menus when clicking on mega menu links
				jQuery(document).on('click', '.sub_menu_block a', function() {
					setTimeout(function() {
						closeAllMegaMenus();
					}, 100);
				});

				// Close mega menus on escape key
				jQuery(document).on('keydown', function(e) {
					if (e.key === 'Escape' || e.keyCode === 27) {
						closeAllMegaMenus();
					}
				});
			});
		};

		// Initialize mega menu
		initMegaMenu();
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

