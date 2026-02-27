/**
 * ContactMap Component JavaScript
 * 
 * Initializes styled Google Map with custom marker
 */

(function () {
    'use strict';

    /**
     * Snazzy Maps style - Dark/Black Theme (matching contact page design)
     */
    const mapStyle = [
        {
            "featureType": "all",
            "elementType": "geometry",
            "stylers": [
                {
                    "color": "#1a1a1a"
                }
            ]
        },
        {
            "featureType": "all",
            "elementType": "labels.text.fill",
            "stylers": [
                {
                    "color": "#999999"
                },
                {
                    "visibility": "on"
                }
            ]
        },
        {
            "featureType": "all",
            "elementType": "labels.text.stroke",
            "stylers": [
                {
                    "color": "#1a1a1a"
                },
                {
                    "visibility": "on"
                }
            ]
        },
        {
            "featureType": "all",
            "elementType": "labels.icon",
            "stylers": [
                {
                    "visibility": "off"
                }
            ]
        },
        {
            "featureType": "landscape",
            "elementType": "geometry.fill",
            "stylers": [
                {
                    "color": "#2a2a2a"
                }
            ]
        },
        {
            "featureType": "landscape",
            "elementType": "geometry.stroke",
            "stylers": [
                {
                    "color": "#1a1a1a"
                }
            ]
        },
        {
            "featureType": "poi",
            "elementType": "all",
            "stylers": [
                {
                    "visibility": "off"
                }
            ]
        },
        {
            "featureType": "road",
            "elementType": "geometry.fill",
            "stylers": [
                {
                    "color": "#2a2a2a"
                }
            ]
        },
        {
            "featureType": "road",
            "elementType": "geometry.stroke",
            "stylers": [
                {
                    "color": "#1a1a1a"
                },
                {
                    "weight": 0.5
                }
            ]
        },
        {
            "featureType": "road.highway",
            "elementType": "geometry.fill",
            "stylers": [
                {
                    "color": "#3a3a3a"
                }
            ]
        },
        {
            "featureType": "road.highway",
            "elementType": "geometry.stroke",
            "stylers": [
                {
                    "color": "#1a1a1a"
                },
                {
                    "weight": 1
                }
            ]
        },
        {
            "featureType": "road.arterial",
            "elementType": "geometry.fill",
            "stylers": [
                {
                    "color": "#2a2a2a"
                }
            ]
        },
        {
            "featureType": "road.local",
            "elementType": "geometry.fill",
            "stylers": [
                {
                    "color": "#2a2a2a"
                }
            ]
        },
        {
            "featureType": "transit",
            "elementType": "all",
            "stylers": [
                {
                    "visibility": "off"
                }
            ]
        },
        {
            "featureType": "water",
            "elementType": "geometry.fill",
            "stylers": [
                {
                    "color": "#1a1a1a"
                }
            ]
        },
        {
            "featureType": "water",
            "elementType": "geometry.stroke",
            "stylers": [
                {
                    "color": "#1a1a1a"
                }
            ]
        }
    ];

    /**
     * Initialize Contact Map
     */
    const initContactMap = function () {
        const mapContainer = document.getElementById('contactMap');
        if (!mapContainer) {
            console.warn('ContactMap: Map container #contactMap not found');
            return;
        }

        // Check if config exists
        if (!window.contactMapConfig) {
            console.warn('ContactMap: Configuration not found. Make sure ContactMap.php template is loaded.');
            mapContainer.innerHTML = '<div style="padding: 40px; text-align: center; color: #666; font-family: sans-serif;">Map configuration not found. Please check the template.</div>';
            return;
        }

        const config = window.contactMapConfig;
        console.log('ContactMap: Initializing with config:', config);

        // Function to create the map
        function createMap() {
            try {
                // Check if markers array exists
                const markers = config.markers || [];
                
                if (markers.length === 0) {
                    console.warn('ContactMap: No markers provided');
                    return;
                }

                // Calculate center point from all markers
                let centerLat = 0;
                let centerLng = 0;
                markers.forEach(function(marker) {
                    centerLat += parseFloat(marker.latitude);
                    centerLng += parseFloat(marker.longitude);
                });
                centerLat = centerLat / markers.length;
                centerLng = centerLng / markers.length;

                // Create map
                const map = new google.maps.Map(mapContainer, {
                    center: { lat: centerLat, lng: centerLng },
                    zoom: config.zoom || 10,
                    styles: mapStyle,
                    disableDefaultUI: false,
                    zoomControl: false,
                    mapTypeControl: false,
                    scaleControl: false,
                    streetViewControl: false,
                    rotateControl: false,
                    fullscreenControl: false,
                });

                // Create bounds to fit all markers
                const bounds = new google.maps.LatLngBounds();
                const mapMarkers = [];

                // Create markers
                markers.forEach(function(markerData, index) {
                    const position = {
                        lat: parseFloat(markerData.latitude),
                        lng: parseFloat(markerData.longitude)
                    };

                    // Create marker
                    const marker = new google.maps.Marker({
                        position: position,
                        map: map,
                        title: markerData.title || 'Location ' + (index + 1),
                        icon: {
                            url: config.markerIcon,
                            scaledSize: new google.maps.Size(44, 44),
                            anchor: new google.maps.Point(22, 44)
                        },
                        animation: google.maps.Animation.DROP,
                    });

                    // Add to bounds
                    bounds.extend(position);

                    // Create info window if title or address is provided
                    if (markerData.title || markerData.address) {
                        const infoWindow = new google.maps.InfoWindow({
                            content: '<div style="padding: 10px;"><strong>' + 
                                    (markerData.title || '') + 
                                    '</strong><br>' + 
                                    (markerData.address || '') + 
                                    '</div>'
                        });

                        // Add click event to marker
                        marker.addListener('click', function() {
                            // Close all other info windows
                            mapMarkers.forEach(function(m) {
                                if (m.infoWindow) {
                                    m.infoWindow.close();
                                }
                            });
                            infoWindow.open(map, marker);
                        });

                        marker.infoWindow = infoWindow;
                    }

                    mapMarkers.push(marker);
                });

                // Fit map to show all markers
                if (markers.length > 1) {
                    map.fitBounds(bounds);
                    // Add padding to bounds
                    const padding = 50;
                    map.fitBounds(bounds, padding);
                }

                // Store map instance and markers globally for debugging
                window.contactMapInstance = map;
                window.contactMapMarkers = mapMarkers;

                console.log('ContactMap: Map initialized successfully with', markers.length, 'markers');
            } catch (error) {
                console.error('ContactMap: Error creating map:', error);
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
                            console.error('ContactMap: Google Maps API failed to load');
                        }
                    }, 10000);
                } else {
                    // Load Google Maps API
                    const script = document.createElement('script');
                    script.src = 'https://maps.googleapis.com/maps/api/js?key=' + config.apiKey + '&callback=initContactMapCallback';
                    script.async = true;
                    script.defer = true;
                    window.initContactMapCallback = function () {
                        createMap();
                    };
                    script.onerror = function () {
                        console.error('ContactMap: Failed to load Google Maps API script');
                    };
                    document.head.appendChild(script);
                }
            } else {
                console.error('ContactMap: Google Maps API key not provided. Please add your API key in page-contact.php (line 97) or via theme mods.');
                // Show a placeholder message
                mapContainer.innerHTML = '<div style="padding: 40px; text-align: center; color: #666;">Please add your Google Maps API key to display the map.</div>';
            }
            return;
        }

        // Google Maps API is already loaded
        createMap();
    };

    /**
     * Initialize when DOM is ready and config is available
     */
    const init = function () {
        let attempts = 0;
        const maxAttempts = 50; // Try for up to 5 seconds (50 * 100ms)
        
        const tryInit = function () {
            attempts++;
            
            // Check if config is available
            if (window.contactMapConfig) {
                console.log('ContactMap: Config found, initializing map...');
                initContactMap();
            } else if (attempts < maxAttempts) {
                // Config not ready yet, try again
                setTimeout(tryInit, 100);
            } else {
                console.error('ContactMap: Configuration not found after', maxAttempts, 'attempts. Make sure ContactMap.php template is loaded.');
                const mapContainer = document.getElementById('contactMap');
                if (mapContainer) {
                    mapContainer.innerHTML = '<div style="padding: 40px; text-align: center; color: #fff; font-family: sans-serif; background: #000;">Map configuration not found. Please check the template.</div>';
                }
            }
        };

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', function () {
                // Wait a bit for config script to execute
                setTimeout(tryInit, 200);
            });
        } else {
            // DOM already loaded, wait for config
            setTimeout(tryInit, 200);
        }
    };

    // Start initialization
    init();

})();
