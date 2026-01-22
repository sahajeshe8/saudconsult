/**
 * EventMap Component JavaScript
 * 
 * Initializes Google Map for Event Detail page
 */

(function () {
    'use strict';

    /**
     * Initialize Event Map
     */
    const initEventMap = function () {
        const mapContainer = document.getElementById('event-map');
        
        if (!mapContainer) {
            return; // Map container not found
        }

        // Get config from window object or use defaults
        const config = window.eventMapConfig || {
            latitude: 24.7136, // Riyadh, KSA default
            longitude: 46.6753,
            zoom: 15,
            apiKey: ''
        };

        /**
         * Create and initialize the map
         */
        function createMap() {
            try {
                const mapCenter = {
                    lat: parseFloat(config.latitude),
                    lng: parseFloat(config.longitude)
                };

                // Create map with normal/default Google Maps styling
                const map = new google.maps.Map(mapContainer, {
                    center: mapCenter,
                    zoom: parseInt(config.zoom),
                    mapTypeId: google.maps.MapTypeId.ROADMAP, // Normal map style
                    mapTypeControl: true, // Show map type selector (Roadmap/Satellite)
                    streetViewControl: false,
                    fullscreenControl: true,
                    zoomControl: true
                });

                // Add marker
                if (config.markerIcon) {
                    const marker = new google.maps.Marker({
                        position: mapCenter,
                        map: map,
                        title: config.title || 'Event Location',
                        icon: {
                            url: config.markerIcon,
                            scaledSize: new google.maps.Size(40, 40),
                            anchor: new google.maps.Point(20, 40)
                        },
                        animation: google.maps.Animation.DROP
                    });
                } else {
                    const marker = new google.maps.Marker({
                        position: mapCenter,
                        map: map,
                        title: config.title || 'Event Location',
                        animation: google.maps.Animation.DROP
                    });
                }

            } catch (error) {
                console.error('EventMap: Error creating map', error);
                mapContainer.innerHTML = '<div style="padding: 20px; text-align: center; color: #666;">Unable to load map.</div>';
            }
        }

        // Check if Google Maps API is loaded
        if (typeof google === 'undefined' || typeof google.maps === 'undefined') {
            // Load Google Maps API if API key is provided
            if (config.apiKey && config.apiKey.trim() !== '') {
                // Check if script is already being loaded
                const existingScript = document.querySelector('script[src*="maps.googleapis.com"]');
                if (existingScript) {
                    // Wait for it to load
                    const checkInterval = setInterval(function () {
                        if (typeof google !== 'undefined' && typeof google.maps !== 'undefined') {
                            clearInterval(checkInterval);
                            createMap();
                        }
                    }, 100);

                    // Timeout after 10 seconds
                    setTimeout(function () {
                        clearInterval(checkInterval);
                        if (typeof google === 'undefined' || typeof google.maps === 'undefined') {
                            console.error('EventMap: Google Maps API failed to load');
                        }
                    }, 10000);
                } else {
                    // Load Google Maps API
                    const script = document.createElement('script');
                    script.src = 'https://maps.googleapis.com/maps/api/js?key=' + config.apiKey + '&callback=initEventMapCallback';
                    script.async = true;
                    script.defer = true;
                    window.initEventMapCallback = function () {
                        createMap();
                    };
                    script.onerror = function () {
                        console.error('EventMap: Failed to load Google Maps API script');
                    };
                    document.head.appendChild(script);
                }
            } else {
                console.error('EventMap: Google Maps API key not provided.');
                mapContainer.innerHTML = '<div style="padding: 20px; text-align: center; color: #666;">Please add your Google Maps API key to display the map.</div>';
            }
        } else {
            // Google Maps API is already loaded
            createMap();
        }
    };

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function () {
            setTimeout(initEventMap, 100);
        });
    } else {
        setTimeout(initEventMap, 100);
    }
})();

