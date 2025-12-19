/**
 * CompanyVideo Component JavaScript
 * 
 * Handles video zoom animation when video is clicked
 */

(function() {
	'use strict';

	/**
	 * Initialize CompanyVideo Component
	 */
	const initCompanyVideo = function() {
		const videoSections = document.querySelectorAll('[data-company-video]');
		
		videoSections.forEach(function(section) {
			const videoWrapper = section.querySelector('[data-video-wrapper]');
			const videoPlayer = section.querySelector('[data-video-player]');
			const videoElement = section.querySelector('[data-video-element]');
			const videoThumbnail = section.querySelector('[data-video-thumbnail]');
			const playButton = section.querySelector('[data-video-play]');
			const closeButton = section.querySelector('[data-video-close]');
			
			if (!videoWrapper || !videoPlayer) {
				return;
			}

			let isZoomed = false;

			/**
			 * Zoom in video and move content to sides
			 */
			const zoomIn = function() {
				if (isZoomed) return;
				
				isZoomed = true;
				
				// Add zoomed class to section and wrapper
				section.classList.add('zoomed');
				videoWrapper.classList.add('zoomed');
				
				// Hide thumbnail and play button
				videoPlayer.classList.add('playing');
				
				// Show close button
				if (closeButton) {
					setTimeout(function() {
						closeButton.style.display = 'flex';
					}, 300);
				}
				
				// Handle YouTube iframe
				if (videoElement && videoElement.tagName === 'IFRAME') {
					const embedUrl = videoElement.getAttribute('data-embed-url');
					if (embedUrl) {
						videoElement.src = embedUrl;
						videoElement.style.display = 'block';
					}
				} else if (videoElement && videoElement.tagName === 'VIDEO') {
					// Handle regular video
					setTimeout(function() {
						videoElement.style.display = 'block';
						videoElement.play().catch(function(error) {
							console.warn('Video autoplay failed:', error);
						});
					}, 300);
				}
			};

			/**
			 * Zoom out video and restore content
			 */
			const zoomOut = function() {
				if (!isZoomed) return;
				
				isZoomed = false;
				
				// Pause video or stop iframe
				if (videoElement) {
					if (videoElement.tagName === 'IFRAME') {
						// Stop YouTube video by removing src
						videoElement.src = '';
						videoElement.style.display = 'none';
					} else if (videoElement.tagName === 'VIDEO') {
						videoElement.pause();
						videoElement.currentTime = 0;
						setTimeout(function() {
							videoElement.style.display = 'none';
						}, 300);
					}
				}
				
				// Hide close button
				if (closeButton) {
					closeButton.style.display = 'none';
				}
				
				// Remove zoomed class
				videoWrapper.classList.remove('zoomed');
				section.classList.remove('zoomed');
				
				// Show thumbnail and play button
				videoPlayer.classList.remove('playing');
			};

			// Event listeners
			if (playButton) {
				playButton.addEventListener('click', function(e) {
					e.stopPropagation();
					zoomIn();
				});
			}

			if (videoPlayer) {
				videoPlayer.addEventListener('click', function(e) {
					// Don't trigger if clicking on close button
					if (e.target.closest('[data-video-close]')) {
						return;
					}
					if (!isZoomed) {
						zoomIn();
					}
				});
			}

			if (closeButton) {
				closeButton.addEventListener('click', function(e) {
					e.stopPropagation();
					zoomOut();
				});
			}

			// Close on Escape key
			document.addEventListener('keydown', function(e) {
				if (e.key === 'Escape' && isZoomed) {
					zoomOut();
				}
			});
		});
	};

	/**
	 * Initialize when DOM is ready
	 */
	const init = function() {
		if (document.readyState === 'loading') {
			document.addEventListener('DOMContentLoaded', initCompanyVideo);
		} else {
			// DOM already loaded
			initCompanyVideo();
		}
	};

	// Start initialization
	init();

})();
