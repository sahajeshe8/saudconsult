// Event Detail Media Type Detection
(function() {
	function detectMediaTypeAndOrientation() {
		const mediaContainer = document.querySelector('.news_detail_image');
		if (!mediaContainer) {
			return; // Element not found
		}

		const video = mediaContainer.querySelector('video');
		const image = mediaContainer.querySelector('img');

		if (video) {
			// Remove any existing classes
			mediaContainer.classList.remove('media-image', 'media-video-horizontal', 'media-video-vertical', 'media-video');
			
			// Function to determine and apply orientation class
			function applyOrientationClass() {
				const videoWidth = video.videoWidth;
				const videoHeight = video.videoHeight;
				
				// Only proceed if dimensions are valid
				if (videoWidth > 0 && videoHeight > 0) {
					// Remove temporary video class
					mediaContainer.classList.remove('media-video');
					
					// Determine orientation and add appropriate class
					if (videoHeight > videoWidth) {
						// Vertical video
						mediaContainer.classList.add('media-video-vertical');
					} else {
						// Horizontal video
						mediaContainer.classList.add('media-video-horizontal');
					}
				}
			}
			
			// Check if video dimensions are already available (cached video)
			if (video.readyState >= 2 && video.videoWidth > 0 && video.videoHeight > 0) {
				applyOrientationClass();
			} else {
				// Add temporary video class while waiting for metadata
				mediaContainer.classList.add('media-video');
				
				// Wait for metadata to load
				video.addEventListener('loadedmetadata', function() {
					applyOrientationClass();
				}, { once: true });
				
				// Also check on loadeddata as fallback
				video.addEventListener('loadeddata', function() {
					if (!mediaContainer.classList.contains('media-video-vertical') && 
						!mediaContainer.classList.contains('media-video-horizontal')) {
						applyOrientationClass();
					}
				}, { once: true });
			}
		} else if (image) {
			// Remove any existing classes
			mediaContainer.classList.remove('media-video-horizontal', 'media-video-vertical', 'media-video');
			
			// Add image class
			mediaContainer.classList.add('media-image');
		}
	}

	// Initialize when DOM is ready
	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', function() {
			setTimeout(detectMediaTypeAndOrientation, 100);
		});
	} else {
		setTimeout(detectMediaTypeAndOrientation, 100);
	}
})();
