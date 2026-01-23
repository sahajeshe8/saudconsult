 

 
  

  // Leadership Team Swiper - Initialize when DOM is ready
  (function() {
	const initLeadershipTeamSwiper = function() {
	  // Check if Swiper is loaded
	  if (typeof Swiper === 'undefined') {
		console.warn('LeadershipTeam: Swiper library is not loaded');
		return;
	  }

	  const swiperElement = document.querySelector(".leadership-team-swiper");
	  if (!swiperElement) {
		return; // Element not found, might not be on this page
	  }

	  // Check if already initialized
	  if (swiperElement.swiper) {
		return; // Already initialized
	  }

	  // Find buttons in the global_brands_content_title div (parent section)
	  const section = swiperElement.closest('section');
	  const nextButton = section ? section.querySelector(".leadership-team-next") : null;
	  const prevButton = section ? section.querySelector(".leadership-team-prev") : null;

	  if (!nextButton || !prevButton) {
		console.warn('LeadershipTeam: Navigation buttons not found');
		return;
	  }

	  try {
		// Check if mobile view (below 768px)
		const isMobile = window.innerWidth < 768;
		
		var leadershipTeamSwiper = new Swiper(swiperElement, {
		  slidesPerView: 1,
		  spaceBetween: 20,
		  navigation: {
			nextEl: nextButton,
			prevEl: prevButton,
		  },
		  speed: 800,
		  autoplay: isMobile ? {
			delay: 3000,
			disableOnInteraction: false,
			pauseOnMouseEnter: true,
		  } : false,
		  breakpoints: {
			768: {
			  slidesPerView: 2,
			  spaceBetween: 20,
			  autoplay: false, // Disable autoplay on tablet and desktop
			},
			1024: {
			  slidesPerView: 3,
			  spaceBetween: 30,
			  autoplay: false, // Disable autoplay on desktop
			},
		  },
		  on: {
			// Handle autoplay on window resize
			init: function(swiper) {
			  const handleResize = function() {
				const isMobileNow = window.innerWidth < 768;
				if (isMobileNow && !swiper.autoplay.running) {
				  swiper.autoplay.start();
				} else if (!isMobileNow && swiper.autoplay.running) {
				  swiper.autoplay.stop();
				}
			  };
			  
			  window.addEventListener('resize', handleResize);
			  // Store cleanup function
			  swiper.destroy = (function(originalDestroy) {
				return function() {
				  window.removeEventListener('resize', handleResize);
				  if (originalDestroy) originalDestroy.call(this);
				};
			  })(swiper.destroy);
			}
		  }
		});
		console.log('LeadershipTeam: Swiper initialized successfully', isMobile ? 'with autoplay' : 'without autoplay');
	  } catch (error) {
		console.error('LeadershipTeam: Error initializing Swiper', error);
	  }
	};

	// Initialize when DOM is ready
	if (document.readyState === 'loading') {
	  document.addEventListener('DOMContentLoaded', function() {
		setTimeout(initLeadershipTeamSwiper, 100);
	  });
	} else {
	  setTimeout(initLeadershipTeamSwiper, 100);
	}
  })();







   
var swiper = new Swiper(".mySwiper_banner", {});
 
 







var swiper = new Swiper(".mySwiper-services", {
	slidesPerView: 1,
	spaceBetween: 10,
	// pagination: {
	//   el: ".swiper-pagination",
	//   clickable: true,
	// },
	breakpoints: {
	  640: {
		slidesPerView: 2,
		spaceBetween: 2,
	  },
	  768: {
		slidesPerView: 3,
		spaceBetween: 5,
	  },
	  1024: {
		slidesPerView: 4,
		spaceBetween:5,
	  },

	  1920: {
		slidesPerView: 5,
		spaceBetween:5,
	  },
	},
  });

// Projects Swiper - Initialize when DOM is ready
(function() {
	const initProjectsSwiper = function() {
		// Check if Swiper is loaded
		if (typeof Swiper === 'undefined') {
			console.warn('Projects: Swiper library is not loaded');
			return;
		}

		const swiperElement = document.querySelector(".mySwiper-projects");
		if (!swiperElement) {
			return; // Element not found, might not be on this page
		}

		// Check if already initialized
		if (swiperElement.swiper) {
			return; // Already initialized
		}

		// Find buttons in the projects section
		const section = swiperElement.closest('.projects_section');
		const nextButton = section ? section.querySelector(".but_next") : null;
		const prevButton = section ? section.querySelector(".but_prev") : null;

		try {
			var projectsSwiper = new Swiper(swiperElement, {
				slidesPerView: 1,
				spaceBetween: 0,
				loop: true,
				pagination: {
					el: ".swiper-pagination",
					clickable: true,
				},
				navigation: {
					nextEl: nextButton,
					prevEl: prevButton,
				},
				speed: 800,
			});
			console.log('Projects: Swiper initialized successfully');
		} catch (error) {
			console.error('Projects: Error initializing Swiper', error);
		}
	};

	// Initialize when DOM is ready
	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', function() {
			setTimeout(initProjectsSwiper, 100);
		});
	} else {
		setTimeout(initProjectsSwiper, 100);
	}
})();

var swiper = new Swiper(".mySwiper-partners", {
	slidesPerView: 2,
	 
	loop: true,
	autoplay: {
		delay: 3000,
		disableOnInteraction: false,
	},
 
	breakpoints: {
		640: {
			slidesPerView: 3,
			 
		},
		768: {
			slidesPerView: 4,
			 
		},
		1024: {
			slidesPerView: 5,
			 
		},
		1280: {
			slidesPerView: 6,
			 
		},
	},
});

var swiper = new Swiper(".mySwiper-clients", {
	slidesPerView: 2,
	 
	loop: true,
	autoplay: {
		delay: 3000,
		disableOnInteraction: false,
	},
 
	breakpoints: {
		640: {
			slidesPerView: 3,
			 
		},
		768: {
			slidesPerView: 4,
			 
		},
		1024: {
			slidesPerView: 5,
			 
		},
		1280: {
			slidesPerView: 6,
			 
		},
	},
});

// Insights Swiper initialization
(function() {
	const initInsightsSwiper = function() {
		if (typeof Swiper === 'undefined') {
			console.warn('Insights: Swiper library is not loaded');
			return;
		}
		const swiperElement = document.querySelector(".mySwiper-insights");
		if (!swiperElement) {
			return;
		}
		if (swiperElement.swiper) {
			return;
		}

		// Find navigation buttons
		const nextButton = document.querySelector(".news_but_next");
		const prevButton = document.querySelector(".news_but_prev");

		if (!nextButton || !prevButton) {
			console.warn('Insights: Navigation buttons not found');
			return;
		}

		try {
			new Swiper(swiperElement, {
				slidesPerView: 1,
				spaceBetween: 30,
				loop: true,
				navigation: {
					nextEl: nextButton,
					prevEl: prevButton,
				},
				// pagination: {
				// 	el: ".swiper-pagination",
				// 	clickable: true,
				// },
				breakpoints: {
					480: {
						slidesPerView: 1,
						spaceBetween: 20,
					},
					768: {
						slidesPerView: 2,
						spaceBetween: 25,
					},
					1024: {
						slidesPerView: 3,
						spaceBetween: 30,
					},
					1280: {
						slidesPerView: 4,
						spaceBetween: 30,
					},
				},
			});
			console.log('Insights: Swiper initialized successfully');
		} catch (error) {
			console.error('Insights: Error initializing Swiper', error);
		}
	};

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', function() {
			setTimeout(initInsightsSwiper, 100);
		});
	} else {
		setTimeout(initInsightsSwiper, 100);
	}
})();

// Page Tabs functionality
(function() {
	const initPageTabs = function() {
		const tabsContainer = document.querySelector('[data-page-tabs]');
		if (!tabsContainer) {
			return;
		}

		const tabLinks = tabsContainer.querySelectorAll('.page_tabs_link');
		const tabPanels = tabsContainer.querySelectorAll('.page_tabs_panel');

		tabLinks.forEach(link => {
			link.addEventListener('click', function(e) {
				const href = this.getAttribute('href');
				
				// If href is a full URL or page link (not starting with #), allow normal navigation
				if (href && !href.startsWith('#')) {
					// Allow normal link navigation - don't prevent default
					// Navigate to the page
					window.location.href = href;
					return;
				}
				
				// Otherwise, prevent default and handle tab switching for hash links
				e.preventDefault();
				
				const targetTab = this.getAttribute('data-tab');
				const targetPanel = tabsContainer.querySelector('#' + targetTab);
				
				if (!targetPanel) {
					return;
				}

				// Remove active class from all tabs and panels
				tabLinks.forEach(l => {
					l.closest('.page_tabs_item').classList.remove('active');
				});
				tabPanels.forEach(panel => {
					panel.classList.remove('active');
				});

				// Add active class to clicked tab and corresponding panel
				this.closest('.page_tabs_item').classList.add('active');
				targetPanel.classList.add('active');

				// Update URL hash
				if (history.pushState) {
					history.pushState(null, null, '#' + targetTab);
				}
			});
		});

		// Handle initial hash in URL
		if (window.location.hash) {
			const hash = window.location.hash.substring(1);
			const targetLink = tabsContainer.querySelector('[data-tab="' + hash + '"]');
			if (targetLink) {
				targetLink.click();
			}
		}
	};

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', function() {
			setTimeout(initPageTabs, 100);
		});
	} else {
		setTimeout(initPageTabs, 100);
	}
})();

// Timeline Scroll Animations and Infinite Scroll with AOS
(function() {
	const initTimelineAnimations = function() {
		const timelineSection = document.querySelector('.timeline_section');
		if (!timelineSection) {
			return;
		}

		const timelineItems = timelineSection.querySelectorAll('.tileline_ul > li');
		const loadMoreBtn = timelineSection.querySelector('.timeline-load-more');
		let isLoading = false;
		let currentPage = 1;
		const itemsPerPage = 3; // Number of items to load each time

		// Initialize AOS for timeline if not already initialized
		if (typeof AOS !== 'undefined') {
			// Refresh AOS to detect new elements
			setTimeout(function() {
				AOS.refresh();
			}, 100);

			// Add active class to li when timeline item appears
			document.addEventListener('aos:in', function(e) {
				const animatedElement = e.detail;
				// Check if the animated element is part of timeline
				if (animatedElement && animatedElement.closest && animatedElement.closest('.timeline_section')) {
					const timelineItem = animatedElement.closest('.tileline_ul > li');
					if (timelineItem) {
						// Add active class when the first child (image) starts animating
						if (animatedElement.classList.contains('timeline_item_img')) {
							timelineItem.classList.add('active');
						}
					}
				}
			});
		}

		// Infinite scroll functionality
		const loadMoreItems = function() {
			if (isLoading) {
				return;
			}

			isLoading = true;
			if (loadMoreBtn) {
				loadMoreBtn.classList.add('loading');
				loadMoreBtn.textContent = 'Loading...';
			}

			// Simulate loading delay (replace with actual AJAX call)
			setTimeout(function() {
				// Get all items (including hidden ones if you have them)
				const allItems = Array.from(timelineItems);
				const totalItems = allItems.length;
				const startIndex = currentPage * itemsPerPage;
				const endIndex = Math.min(startIndex + itemsPerPage, totalItems);

				// Show next batch of items
				for (let i = startIndex; i < endIndex; i++) {
					if (allItems[i]) {
						allItems[i].style.display = 'flex';
						
						// Add AOS attributes to newly loaded items
						const imgBlock = allItems[i].querySelector('.timeline_item_img');
						const contentBlock = allItems[i].querySelector('.timeline_item_content');
						
						if (imgBlock && !imgBlock.hasAttribute('data-aos')) {
							imgBlock.setAttribute('data-aos', 'fade-up');
							imgBlock.setAttribute('data-aos-delay', '0');
						}
						
						if (contentBlock && !contentBlock.hasAttribute('data-aos')) {
							contentBlock.setAttribute('data-aos', 'fade-up');
							contentBlock.setAttribute('data-aos-delay', '100');
						}
					}
				}

				currentPage++;

				// Refresh AOS to animate newly loaded items
				if (typeof AOS !== 'undefined') {
					setTimeout(function() {
						AOS.refresh();
					}, 100);
				}

				// Hide load more button if all items are loaded
				if (endIndex >= totalItems && loadMoreBtn) {
					loadMoreBtn.classList.add('hidden');
				}

				isLoading = false;
				if (loadMoreBtn) {
					loadMoreBtn.classList.remove('loading');
					loadMoreBtn.textContent = 'Load More';
				}
			}, 800);
		};

		// Load more on button click
		if (loadMoreBtn) {
			loadMoreBtn.addEventListener('click', loadMoreItems);
		}

		// Infinite scroll on reaching load-more element
		const loadMoreObserver = new IntersectionObserver(function(entries) {
			entries.forEach(function(entry) {
				if (entry.isIntersecting && !isLoading) {
					loadMoreItems();
				}
			});
		}, {
			root: null,
			rootMargin: '100px',
			threshold: 0.1
		});

		if (loadMoreBtn) {
			loadMoreObserver.observe(loadMoreBtn);
		}

		// Initially hide items beyond first batch (optional)
		timelineItems.forEach(function(item, index) {
			if (index >= itemsPerPage) {
				item.style.display = 'none';
			}
		});
	};

	// Initialize when DOM is ready
	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', function() {
			setTimeout(initTimelineAnimations, 100);
		});
	} else {
		setTimeout(initTimelineAnimations, 100);
	}
})();

// Latest Openings Load More functionality
(function() {
	const initLatestOpeningsLoadMore = function() {
		const openingsSection = document.querySelector('.latest_openings_section');
		if (!openingsSection) {
			return;
		}

		const openingsList = openingsSection.querySelector('[data-openings-list]');
		const loadMoreBtn = openingsSection.querySelector('.load_more_btn');
		
		if (!openingsList || !loadMoreBtn) {
			return;
		}

		const allItems = Array.from(openingsList.querySelectorAll('li'));
		const totalItems = allItems.length;
		let currentPage = 1;
		const itemsPerPage = 8; // Number of items to show initially and load per click
		let isLoading = false;

		// Initially hide items beyond first batch
		allItems.forEach(function(item, index) {
			if (index >= itemsPerPage) {
				item.style.display = 'none';
			}
		});

		// Hide load more button if all items are already visible
		if (totalItems <= itemsPerPage) {
			loadMoreBtn.closest('.load_more_container').style.display = 'none';
			return;
		}

		// Load more functionality
		const loadMoreItems = function() {
			if (isLoading) {
				return;
			}

			isLoading = true;
			loadMoreBtn.classList.add('loading');
			loadMoreBtn.textContent = 'Loading...';

			// Simulate loading delay (replace with actual AJAX call if needed)
			setTimeout(function() {
				const startIndex = currentPage * itemsPerPage;
				const endIndex = Math.min(startIndex + itemsPerPage, totalItems);

				// Show next batch of items
				for (let i = startIndex; i < endIndex; i++) {
					if (allItems[i]) {
						allItems[i].style.display = '';
					}
				}

				currentPage++;

				// Hide load more button if all items are loaded
				if (endIndex >= totalItems) {
					loadMoreBtn.closest('.load_more_container').style.display = 'none';
				}

				isLoading = false;
				loadMoreBtn.classList.remove('loading');
				loadMoreBtn.textContent = 'Load more';
			}, 500);
		};

		// Load more on button click
		loadMoreBtn.addEventListener('click', loadMoreItems);
	};

	// Initialize when DOM is ready
	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', function() {
			setTimeout(initLatestOpeningsLoadMore, 100);
		});
	} else {
		setTimeout(initLatestOpeningsLoadMore, 100);
	}
})();

// News Page Load More functionality
(function() {
	const initNewsPageLoadMore = function() {
		const newsSection = document.querySelector('.news_page_section');
		if (!newsSection) {
			return;
		}

		const newsList = document.getElementById('news-list');
		const loadMoreBtn = document.getElementById('load-more-news');
		
		if (!newsList || !loadMoreBtn) {
			return;
		}

		const allItems = Array.from(newsList.querySelectorAll('li'));
		const totalItems = allItems.length;
		let currentPage = 1;
		const itemsPerPage = 16; // Number of items to show initially (4 rows × 4 columns)
		const itemsPerLoad = 8; // Number of items to load per click (2 rows × 4 columns)
		let isLoading = false;

		// Initially hide items beyond first batch
		allItems.forEach(function(item, index) {
			if (index >= itemsPerPage) {
				item.style.display = 'none';
			}
		});

		// Hide load more button if all items are already visible
		if (totalItems <= itemsPerPage) {
			loadMoreBtn.closest('.load_more_container').style.display = 'none';
			return;
		}

		// Load more functionality
		const loadMoreItems = function() {
			if (isLoading) {
				return;
			}

			isLoading = true;
			loadMoreBtn.classList.add('loading');
			loadMoreBtn.querySelector('span').textContent = 'Loading...';

			// Simulate loading delay (replace with actual AJAX call if needed)
			setTimeout(function() {
				const startIndex = itemsPerPage + (currentPage - 1) * itemsPerLoad;
				const endIndex = Math.min(startIndex + itemsPerLoad, totalItems);

				// Show next batch of items
				for (let i = startIndex; i < endIndex; i++) {
					if (allItems[i]) {
						allItems[i].style.display = '';
						allItems[i].style.opacity = '0';
						allItems[i].style.transform = 'translateY(20px)';
						
						// Trigger animation
						setTimeout(function() {
							allItems[i].style.transition = 'opacity 0.6s ease-in-out, transform 0.6s ease-in-out';
							allItems[i].style.opacity = '1';
							allItems[i].style.transform = 'translateY(0)';
						}, 10);
					}
				}

				currentPage++;

				// Hide load more button if all items are loaded
				if (endIndex >= totalItems) {
					loadMoreBtn.closest('.load_more_container').style.display = 'none';
				}

				isLoading = false;
				loadMoreBtn.classList.remove('loading');
				loadMoreBtn.querySelector('span').textContent = 'Load More';
			}, 500);
		};

		// Load more on button click
		loadMoreBtn.addEventListener('click', loadMoreItems);
	};

	// Initialize when DOM is ready
	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', function() {
			setTimeout(initNewsPageLoadMore, 100);
		});
	} else {
		setTimeout(initNewsPageLoadMore, 100);
	}
})();

// Events Page Load More Functionality
(function() {
	const initEventsPageLoadMore = function() {
		const eventsSection = document.querySelector('.events_page_section');
		if (!eventsSection) {
			return;
		}

		const eventsList = document.getElementById('events-list');
		const loadMoreBtn = document.getElementById('events-load-more');
		
		if (!eventsList || !loadMoreBtn) {
			return;
		}

		const allItems = Array.from(eventsList.querySelectorAll('li'));
		const totalItems = allItems.length;
		let currentPage = 1;
		const itemsPerPage = 6; // Number of items to show initially
		const itemsPerLoad = 4; // Number of items to load per click
		let isLoading = false;

		// Ensure all items are visible first, then hide the ones beyond first 6
		allItems.forEach(function(item, index) {
			// Remove hidden class from all items first
			item.classList.remove('events_item_hidden');
			
			// Then hide items beyond first 6
			if (index >= itemsPerPage) {
				item.classList.add('events_item_hidden');
			}
		});

		// Hide load more button if all items are already visible
		if (totalItems <= itemsPerPage) {
			loadMoreBtn.closest('.load_more_container').style.display = 'none';
			return;
		}

		// Load more functionality
		const loadMoreItems = function() {
			if (isLoading) {
				return;
			}

			isLoading = true;
			loadMoreBtn.classList.add('loading');
			loadMoreBtn.textContent = 'Loading...';

			// Simulate loading delay (replace with actual AJAX call if needed)
			setTimeout(function() {
				const startIndex = itemsPerPage + (currentPage - 1) * itemsPerLoad;
				const endIndex = Math.min(startIndex + itemsPerLoad, totalItems);

				// Show next batch of items
				for (let i = startIndex; i < endIndex; i++) {
					if (allItems[i]) {
						allItems[i].classList.remove('events_item_hidden');
						allItems[i].style.opacity = '0';
						allItems[i].style.transition = 'opacity 0.3s ease';
						
						// Fade in animation
						setTimeout(function() {
							allItems[i].style.opacity = '1';
						}, 10);
					}
				}

				currentPage++;

				// Hide load more button if all items are loaded
				if (endIndex >= totalItems) {
					loadMoreBtn.closest('.load_more_container').style.display = 'none';
				}

				isLoading = false;
				loadMoreBtn.classList.remove('loading');
				loadMoreBtn.textContent = 'Load More';
			}, 500);
		};

		// Load more on button click
		loadMoreBtn.addEventListener('click', loadMoreItems);
	};

	// Initialize Events Load More when DOM is ready
	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', function() {
			setTimeout(initEventsPageLoadMore, 100);
		});
	} else {
		setTimeout(initEventsPageLoadMore, 100);
	}
})();

// Engineering Expertise Interactive Content
(function() {
	function initEngineeringExpertise() {
		const container = document.querySelector('[data-expertise-container]');
		if (!container) {
			return; // Element not found, might not be on this page
		}

		const listItems = container.querySelectorAll('.expertise_list_ul .expertise_list_item');
		const image1 = container.querySelector('.expertise_image_1');
		const image2 = container.querySelector('.expertise_image_2');
		const activeTitle = container.querySelector('.expertise_active_title');
		const activeDescription = container.querySelector('.expertise_active_description');
		const activeButton = container.querySelector('.expertise_active_button');
		const buttonImg = activeButton ? activeButton.querySelector('span img') : null;
		const arrowImgSrc = buttonImg ? buttonImg.src : '';

		if (!listItems.length || !image1 || !image2) {
			return;
		}

		let currentImage = 1; // Track which image is currently visible

		listItems.forEach(function(item) {
			item.addEventListener('click', function(e) {
				e.preventDefault();
				
				// Remove active class from all items
				listItems.forEach(function(li) {
					li.classList.remove('active');
				});

				// Add active class to clicked item
				this.classList.add('active');

				// Get data from clicked item
				const newImage = this.getAttribute('data-image');
				const newTitle = this.getAttribute('data-title');
				const newDescription = this.getAttribute('data-description');
				const newButtonText = this.getAttribute('data-button-text');
				const newButtonLink = this.getAttribute('data-button-link');

				// Determine which images to use for cross-fade
				const fadeOutImage = currentImage === 1 ? image1 : image2;
				const fadeInImage = currentImage === 1 ? image2 : image1;

				// Update the fade-in image source first (before it becomes visible)
				if (fadeInImage && newImage) {
					fadeInImage.src = newImage;
					fadeInImage.alt = newTitle || '';
				}

				// Update text content immediately (no fade needed for text)
				if (activeTitle && newTitle) {
					activeTitle.textContent = newTitle;
				}

				if (activeDescription && newDescription) {
					activeDescription.innerHTML = newDescription;
				}

				// Update button without flashing - preserve the span structure
				if (activeButton) {
					if (newButtonText && newButtonLink) {
						// Update href first
						activeButton.href = newButtonLink;
						
						// Find and update text node
						let textUpdated = false;
						for (let i = 0; i < activeButton.childNodes.length; i++) {
							const node = activeButton.childNodes[i];
							if (node.nodeType === 3) { // Text node
								node.textContent = newButtonText + ' ';
								textUpdated = true;
								break;
							}
						}
						
						// If no text node found, update the first child or create structure
						if (!textUpdated) {
							// Preserve the span with arrow image
							const existingSpan = activeButton.querySelector('span');
							if (existingSpan) {
								activeButton.innerHTML = newButtonText + ' ';
								activeButton.appendChild(existingSpan);
							} else {
								// Create new structure
								const newSpan = document.createElement('span');
								newSpan.innerHTML = '<img src="' + arrowImgSrc + '" alt="' + newButtonText + '">';
								activeButton.innerHTML = newButtonText + ' ';
								activeButton.appendChild(newSpan);
							}
						}
						
						activeButton.style.display = '';
					} else {
						activeButton.style.display = 'none';
					}
				}

				// Cross-fade images
				fadeOutImage.style.transition = 'opacity 0.5s ease';
				fadeInImage.style.transition = 'opacity 0.5s ease';
				
				// Start cross-fade
				fadeOutImage.style.opacity = '0';
				fadeInImage.style.opacity = '1';

				// Switch current image reference
				currentImage = currentImage === 1 ? 2 : 1;
			});
		});
	}

	// Initialize when DOM is ready
	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', function() {
			setTimeout(initEngineeringExpertise, 100);
		});
	} else {
		setTimeout(initEngineeringExpertise, 100);
	}
})();

// Load More Projects Functionality
(function() {
	const initLoadMoreProjects = function() {
		const loadMoreBtn = document.getElementById('load-more-projects');
		const projectsGrid = document.getElementById('projects-grid');
		
		if (!loadMoreBtn || !projectsGrid) {
			return; // Elements not found, might not be on this page
		}

		// Get all project cards
		const allProjects = Array.from(projectsGrid.querySelectorAll('.project_card'));
		const initialVisible = 12; // Initially showing 12 items
		const itemsPerLoad = 8; // Load 8 items each time
		let currentVisible = initialVisible; // Initially showing 12 items

		// Hide button if all items are already visible
		if (allProjects.length <= initialVisible) {
			loadMoreBtn.style.display = 'none';
			return;
		}

		loadMoreBtn.addEventListener('click', function() {
			// Calculate how many items to show (8 items per click)
			const itemsToShow = Math.min(itemsPerLoad, allProjects.length - currentVisible);
			
			// Show next batch of items
			for (let i = currentVisible; i < currentVisible + itemsToShow; i++) {
				if (allProjects[i]) {
					allProjects[i].classList.remove('project_card_hidden');
					allProjects[i].style.opacity = '0';
					allProjects[i].style.transform = 'translateY(20px)';
					
					// Trigger animation
					setTimeout(function() {
						allProjects[i].style.transition = 'opacity 0.6s ease-in-out, transform 0.6s ease-in-out';
						allProjects[i].style.opacity = '1';
						allProjects[i].style.transform = 'translateY(0)';
					}, 10);
				}
			}

			// Update current visible count
			currentVisible += itemsToShow;

			// Check if all items are now visible
			if (currentVisible >= allProjects.length) {
				loadMoreBtn.style.display = 'none';
			}
		});
	};

	// Initialize when DOM is ready
	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', function() {
			setTimeout(initLoadMoreProjects, 100);
		});
	} else {
		setTimeout(initLoadMoreProjects, 100);
	}
})();

// Project Gallery Swiper Functionality
(function() {
	const initProjectGallerySwiper = function() {
		const swiperElement = document.querySelector('.project_gallery_swiper');
		
		if (!swiperElement) {
			return; // Element not found, might not be on this page
		}

		// Check if Swiper is loaded
		if (typeof Swiper === 'undefined') {
			console.warn('ProjectGallery: Swiper library is not loaded');
			return;
		}

		// Check if already initialized
		if (swiperElement.swiper) {
			return; // Already initialized
		}

		// Find navigation buttons
		const section = swiperElement.closest('.project_gallery_slider_wrapper');
		const nextButton = section ? section.querySelector('.project_gallery_next') : null;
		const prevButton = section ? section.querySelector('.project_gallery_prev') : null;

		if (!nextButton || !prevButton) {
			console.warn('ProjectGallery: Navigation buttons not found');
			return;
		}

		try {
			new Swiper(swiperElement, {
				slidesPerView: 1,
				spaceBetween: 0,
				loop: true,
				speed: 1000,
				effect: 'slide',
				watchOverflow: true,
				resistance: true,
				resistanceRatio: 0.85,
				slideToClickedSlide: false,
				preventClicks: true,
				preventClicksPropagation: true,
				grabCursor: true,
				navigation: {
					nextEl: nextButton,
					prevEl: prevButton,
				},
				breakpoints: {
					640: {
						slidesPerView: 2,
						spaceBetween:4,
					},
					768: {
						slidesPerView: 3,
						spaceBetween: 4,
					},
						1024: {
							slidesPerView: 4,
							spaceBetween: 4,
						},	
						1600: {
							slidesPerView: 5,
							spaceBetween: 4,
						},
				},
			});
			console.log('ProjectGallery: Swiper initialized successfully');
		} catch (error) {
			console.error('ProjectGallery: Error initializing Swiper', error);
		}
	};

	// Initialize when DOM is ready
	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', function() {
			setTimeout(initProjectGallerySwiper, 100);
		});
	} else {
		setTimeout(initProjectGallerySwiper, 100);
	}
})();

// Project Gallery Fancybox Initialization
(function() {
	const initProjectGalleryFancybox = function() {
		// Check if Fancybox is loaded
		if (typeof Fancybox === 'undefined') {
			console.warn('ProjectGallery: Fancybox library is not loaded');
			return;
		}

		// Get all gallery links (images and videos) with data-fancybox attribute
		const galleryLinks = document.querySelectorAll('[data-fancybox="project-gallery"]');
		
		if (galleryLinks.length === 0) {
			return; // No gallery items found
		}

		// Initialize Fancybox for both images and videos in the same gallery
		Fancybox.bind('[data-fancybox="project-gallery"]', {
			Toolbar: {
				display: {
					left: ['infobar'],
					middle: [],
					right: ['slideshow', 'download', 'thumbs', 'close'],
				},
			},
			Thumbs: {
				autoStart: false,
			},
			Image: {
				zoom: true,
			},
			Video: {
				autoplay: true,
				tpl: '<video class="fancybox__html5video" playsinline controls controlsList="nodownload" poster="{{poster}}">' +
					'<source src="{{src}}" type="{{format}}" />' +
					'Sorry, your browser doesn\'t support embedded videos.</video>',
			},
			// YouTube and Vimeo support
			Youtube: {
				noCookie: false,
				rel: 0,
				showinfo: 0,
			},
			Vimeo: {
				byline: false,
				portrait: false,
				title: false,
				transparent: false,
			},
		});

		console.log('ProjectGallery: Fancybox initialized successfully');
	};

	// Initialize when DOM is ready
	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', function() {
			setTimeout(initProjectGalleryFancybox, 100);
		});
	} else {
		setTimeout(initProjectGalleryFancybox, 100);
	}
})();

// FAQ Accordion Functionality
(function() {
	const initFAQAccordion = function() {
		const faqQuestions = document.querySelectorAll('.faq_question');
		
		if (faqQuestions.length === 0) {
			return; // No FAQ items found
		}

		faqQuestions.forEach(function(question) {
			question.addEventListener('click', function() {
				const faqItem = this.closest('.faq_item');
				const answer = faqItem.querySelector('.faq_answer');
				const isOpen = faqItem.classList.contains('faq_item_open');
				
				// Close all other FAQ items
				document.querySelectorAll('.faq_item').forEach(function(item) {
					if (item !== faqItem) {
						const otherAnswer = item.querySelector('.faq_answer');
						if (otherAnswer && item.classList.contains('faq_item_open')) {
							otherAnswer.style.height = '0px';
							item.classList.remove('faq_item_open');
						}
						const button = item.querySelector('.faq_question');
						if (button) {
							button.setAttribute('aria-expanded', 'false');
						}
					}
				});
				
				// Toggle current FAQ item
				if (isOpen) {
					// Closing
					answer.style.height = '0px';
					faqItem.classList.remove('faq_item_open');
					this.setAttribute('aria-expanded', 'false');
				} else {
					// Opening
					faqItem.classList.add('faq_item_open');
					// Get the natural height
					answer.style.height = 'auto';
					const height = answer.scrollHeight + 'px';
					answer.style.height = '0px';
					// Trigger reflow
					answer.offsetHeight;
					// Set to actual height
					answer.style.height = height;
					this.setAttribute('aria-expanded', 'true');
				}
			});
		});

		// Initialize items that should be open on page load
		document.querySelectorAll('.faq_item.faq_item_open').forEach(function(item) {
			const answer = item.querySelector('.faq_answer');
			if (answer) {
				setTimeout(function() {
					answer.style.height = 'auto';
					const height = answer.scrollHeight + 'px';
					answer.style.height = height;
				}, 10);
			}
		});
	};

	// Initialize on DOM ready
	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', initFAQAccordion);
	} else {
		initFAQAccordion();
	}
})();

// News List Swiper initialization
(function() {
	const initNewsListSwiper = function() {
		if (typeof Swiper === 'undefined') {
			console.warn('NewsList: Swiper library is not loaded');
			return;
		}
		const swiperElement = document.querySelector(".news_list_swiper");
		if (!swiperElement) {
			return;
		}
		if (swiperElement.swiper) {
			return;
		}

		// Find navigation buttons
		const nextButton = document.querySelector(".news_list_but_next");
		const prevButton = document.querySelector(".news_list_but_prev");

		if (!nextButton || !prevButton) {
			console.warn('NewsList: Navigation buttons not found');
			return;
		}

		try {
			new Swiper(swiperElement, {
				slidesPerView: 1,
				spaceBetween: 30,
				loop: true,
				navigation: {
					nextEl: nextButton,
					prevEl: prevButton,
				},
				breakpoints: {
					768: {
						slidesPerView: 2,
						spaceBetween: 8,
					},
					1024: {
						slidesPerView: 2.6,
						spaceBetween: 10,
					},
				},
			});
			console.log('NewsList: Swiper initialized successfully');
		} catch (error) {
			console.error('NewsList: Error initializing Swiper', error);
		}
	};

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', function() {
			setTimeout(initNewsListSwiper, 100);
		});
	} else {
		setTimeout(initNewsListSwiper, 100);
	}
})();

// Same Month Events Swiper
var sameMonthEventsSwiper = new Swiper(".same_month_events_swiper", {
	slidesPerView: 2,
	spaceBetween: 30,
	loop: true,
	breakpoints: {
		480: {
			slidesPerView: 1,
			spaceBetween: 20,
		},
		768: {
			slidesPerView: 2,
			spaceBetween: 30,
		},
	},
});

var swiper = new Swiper(".brochures_list_swiper", {
	slidesPerView:2,
	spaceBetween:5,
	loop: true,
	navigation: {
		nextEl: ".brochures_list_but_next",
		prevEl: ".brochures_list_but_prev",
	},
	breakpoints: {

		500: {
			slidesPerView:3,
			spaceBetween:5,
		},



		768: {
			slidesPerView: 4,
			spaceBetween:5,
		},

		
		1024: {
			slidesPerView: 6,
			spaceBetween: 10,
		},
	},
});

// Gallery Masonry Initialization
(function() {
	const initGalleryMasonry = function() {
		const galleryElement = document.getElementById('gallery-masonry');
		if (!galleryElement) {
			return; // Element not found, might not be on this page
		}

		// Check if Masonry is loaded
		if (typeof Masonry === 'undefined') {
			console.warn('Gallery: Masonry library is not loaded');
			return;
		}

		// Check if already initialized
		if (galleryElement.masonry) {
			return; // Already initialized
		}

		try {
			// Initialize Masonry
			const masonry = new Masonry(galleryElement, {
				itemSelector: '.gallery_item',
				columnWidth: '.gallery_item.normal',
				percentPosition: true,
				gutter: 20,
				transitionDuration: '0.4s',
				resize: true,
			});

			// Store masonry instance
			galleryElement.masonry = masonry;

			// Re-layout on images loaded
			const images = galleryElement.querySelectorAll('img');
			let imagesLoadedCount = 0;
			const totalImages = images.length;

			if (totalImages > 0) {
				images.forEach(function(img) {
					if (img.complete) {
						imagesLoadedCount++;
					} else {
						img.addEventListener('load', function() {
							imagesLoadedCount++;
							if (imagesLoadedCount === totalImages) {
								masonry.layout();
							}
						});
					}
				});

				if (imagesLoadedCount === totalImages) {
					masonry.layout();
				}
			}

			// Re-layout on window resize
			let resizeTimer;
			window.addEventListener('resize', function() {
				clearTimeout(resizeTimer);
				resizeTimer = setTimeout(function() {
					masonry.layout();
				}, 250);
			});

			console.log('Gallery: Masonry initialized successfully');
		} catch (error) {
			console.error('Gallery: Error initializing Masonry', error);
		}
	};

	// Initialize when DOM is ready
	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', function() {
			setTimeout(initGalleryMasonry, 100);
		});
	} else {
		setTimeout(initGalleryMasonry, 100);
	}
})();

// Job Form Popup Fancybox Initialization
(function() {
	const initJobFormFancybox = function() {
		// Check if Fancybox is loaded
		if (typeof Fancybox === 'undefined') {
			console.warn('JobForm: Fancybox library is not loaded');
			return;
		}

		// Get the job form popup link
		const jobFormLink = document.querySelector('[data-fancybox="job-form"]');
		
		if (!jobFormLink) {
			return; // Element not found, might not be on this page
		}

		try {
			// Initialize Fancybox for the job form popup
			const fancyboxInstance = Fancybox.bind('[data-fancybox="job-form"]', {
				Toolbar: {
					display: {
						left: [],
						middle: [],
						right: [], // Hide default close button
					},
				},
				closeButton: false, // Disable default close button
				backdrop: 'auto',
				placeFocusBack: true,
				trapFocus: true,
				autoFocus: true,
				preventCaptionOverlap: false,
				on: {
					'reveal': function(fancybox, slide) {
						// Focus on first input when popup opens
						const firstInput = slide.el.querySelector('.input');
						if (firstInput) {
							setTimeout(function() {
								firstInput.focus();
							}, 100);
						}
						
						// Add click handler to custom close button
						const closeButton = slide.el.querySelector('.form-close-icon');
						if (closeButton) {
							closeButton.addEventListener('click', function(e) {
								e.preventDefault();
								e.stopPropagation();
								fancybox.close();
							});
						}
					}
				}
			});

			console.log('JobForm: Fancybox initialized successfully');
		} catch (error) {
			console.error('JobForm: Error initializing Fancybox', error);
		}
	};

	// Initialize when DOM is ready
	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', function() {
			setTimeout(initJobFormFancybox, 100);
		});
	} else {
		setTimeout(initJobFormFancybox, 100);
	}
})();

// Design Scope Video Fancybox Initialization
(function() {
	const initDesignScopeVideoFancybox = function() {
		// Check if Fancybox is loaded
		if (typeof Fancybox === 'undefined') {
			console.warn('DesignScope: Fancybox library is not loaded');
			return;
		}

		// Get the design scope video link
		const designScopeVideoLink = document.querySelector('[data-fancybox="design-scope-video"]');
		
		if (!designScopeVideoLink) {
			return; // Element not found, might not be on this page
		}

		try {
			// Initialize Fancybox for the design scope video
			Fancybox.bind('[data-fancybox="design-scope-video"]', {
				Toolbar: {
					display: {
						left: ['infobar'],
						middle: [],
						right: ['close'],
					},
				},
				Video: {
					autoplay: true,
					tpl: '<video class="fancybox__html5video" playsinline controls controlsList="nodownload" poster="{{poster}}">' +
						'<source src="{{src}}" type="{{format}}" />' +
						'Sorry, your browser doesn\'t support embedded videos.</video>',
				},
				// YouTube and Vimeo support
				Youtube: {
					noCookie: false,
					rel: 0,
					showinfo: 0,
				},
				Vimeo: {
					byline: false,
					portrait: false,
					title: false,
					transparent: false,
				},
			});

			console.log('DesignScope: Fancybox initialized successfully');
		} catch (error) {
			console.error('DesignScope: Error initializing Fancybox', error);
		}
	};

	// Initialize when DOM is ready
	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', function() {
			setTimeout(initDesignScopeVideoFancybox, 100);
		});
	} else {
		setTimeout(initDesignScopeVideoFancybox, 100);
	}
})();

// File Upload Preview Functionality
(function() {
	const initFileUpload = function() {
		const fileInput = document.getElementById('profile-photo-upload');
		const filePreviewContainer = document.querySelector('.file-preview-container');
		const filePreviewImage = document.getElementById('file-preview-image');
		const fileUploadLabel = document.querySelector('.file-upload-label');
		const fileRemoveBtn = document.querySelector('.file-remove-btn');
		
		if (!fileInput || !filePreviewContainer || !filePreviewImage) {
			return; // Elements not found, might not be on this page
		}

		// Handle file selection
		fileInput.addEventListener('change', function(e) {
			const file = e.target.files[0];
			
			if (file) {
				// Check if file is an image
				if (file.type.startsWith('image/')) {
					const reader = new FileReader();
					
					reader.onload = function(e) {
						filePreviewImage.src = e.target.result;
						filePreviewContainer.style.display = 'inline-block';
						if (fileUploadLabel) {
							fileUploadLabel.style.display = 'none';
						}
					};
					
					reader.readAsDataURL(file);
				} else {
					alert('Please select an image file.');
					fileInput.value = '';
				}
			}
		});

		// Handle remove button click
		if (fileRemoveBtn) {
			fileRemoveBtn.addEventListener('click', function(e) {
				e.preventDefault();
				e.stopPropagation();
				
				fileInput.value = '';
				filePreviewImage.src = '';
				filePreviewContainer.style.display = 'none';
				if (fileUploadLabel) {
					fileUploadLabel.style.display = 'flex';
				}
			});
		}
	};

	// Initialize when DOM is ready
	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', function() {
			setTimeout(initFileUpload, 100);
		});
	} else {
		setTimeout(initFileUpload, 100);
	}
})();

// Resume Upload Functionality
(function() {
	const initResumeUpload = function() {
		const resumeInput = document.getElementById('resume-upload');
		const resumeFileName = document.querySelector('.resume-file-name');
		const resumeUploadButton = document.querySelector('.resume-upload-button');
		
		if (!resumeInput || !resumeFileName) {
			return; // Elements not found, might not be on this page
		}

		// Handle file selection
		resumeInput.addEventListener('change', function(e) {
			const file = e.target.files[0];
			
			if (file) {
				// Check if file is PDF or DOC
				const allowedTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
				if (allowedTypes.includes(file.type) || file.name.match(/\.(pdf|doc|docx)$/i)) {
					// Display file name
					resumeFileName.textContent = file.name;
					resumeFileName.style.display = 'inline-block';
					if (resumeUploadButton) {
						resumeUploadButton.textContent = 'Change resume';
					}
				} else {
					alert('Please select a PDF or Word document (.pdf, .doc, .docx)');
					resumeInput.value = '';
				}
			}
		});
	};

	// Initialize when DOM is ready
	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', function() {
			setTimeout(initResumeUpload, 100);
		});
	} else {
		setTimeout(initResumeUpload, 100);
	}
})();

// Certificate Upload Functionality
(function() {
	const initCertificateUpload = function() {
		const certificateInput = document.getElementById('certificate-upload');
		const certificateFileName = document.querySelector('.certificate-file-name');
		const certificateUploadButton = document.querySelector('.certificate-upload-button');
		
		if (!certificateInput || !certificateFileName) {
			return; // Elements not found, might not be on this page
		}

		// Handle file selection
		certificateInput.addEventListener('change', function(e) {
			const file = e.target.files[0];
			
			if (file) {
				// Display file name
				certificateFileName.textContent = file.name;
				certificateFileName.style.display = 'inline-block';
				if (certificateUploadButton) {
					certificateUploadButton.textContent = 'Change attachment';
				}
			}
		});
	};

	// Initialize when DOM is ready
	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', function() {
			setTimeout(initCertificateUpload, 100);
		});
	} else {
		setTimeout(initCertificateUpload, 100);
	}
})();

// Saudi Council Classification Upload Functionality
(function() {
	const initSaudiCouncilUpload = function() {
		const saudiCouncilInput = document.getElementById('saudi-council-upload');
		const saudiCouncilFileName = document.querySelector('.saudi-council-file-name');
		const saudiCouncilInputField = document.querySelector('.saudi-council-input');
		
		if (!saudiCouncilInput || !saudiCouncilInputField) {
			return; // Elements not found, might not be on this page
		}

		// Handle file selection
		saudiCouncilInput.addEventListener('change', function(e) {
			const file = e.target.files[0];
			
			if (file) {
				// Update input field with file name
				saudiCouncilInputField.value = file.name;
				
				// Display file name below if element exists
				if (saudiCouncilFileName) {
					saudiCouncilFileName.textContent = file.name;
					saudiCouncilFileName.style.display = 'inline-block';
				}
			}
		});
	};

	// Initialize when DOM is ready
	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', function() {
			setTimeout(initSaudiCouncilUpload, 100);
		});
	} else {
		setTimeout(initSaudiCouncilUpload, 100);
	}
})();
