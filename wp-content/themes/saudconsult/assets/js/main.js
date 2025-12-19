 

 
  

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
