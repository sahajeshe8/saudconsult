/**
 * Listing Load More – News (and Events) listing pages
 * AJAX load more for .tasheel-listing-load-more button; list and config come from data-* on .load_more_container
 */
(function () {
	'use strict';

	var config = typeof tasheelListingLoadMore !== 'undefined' ? tasheelListingLoadMore : {};
	var ajaxUrl = config.ajaxUrl || '';
	var newsNonce = config.newsNonce || '';
	var newsAction = config.newsAction || 'tasheel_load_more_news';
	var eventsNonce = config.eventsNonce || '';
	var eventsAction = config.eventsAction || 'tasheel_load_more_events';
	var loadingText = config.loadingText || 'Loading...';
	var loadMoreText = config.loadMoreText || 'Load More';

	if (!ajaxUrl) return;

	function getListAndContainer(btn) {
		var container = btn.closest('.load_more_container');
		if (!container) return { list: null, container: null };
		var listingType = container.getAttribute('data-listing-ajax');
		var listId = listingType === 'news' ? 'news-list' : (listingType === 'events' ? 'events-list' : null);
		var list = listId ? document.getElementById(listId) : null;
		// Fallback: list is usually the previous sibling of the load-more container (news)
		if (!list && container.previousElementSibling && container.previousElementSibling.tagName === 'UL') {
			list = container.previousElementSibling;
		}
		// Events: list may be nested inside previous sibling (e.g. .events_list_content > .events_list_container > ul#events-list)
		if (!list && listId && container.previousElementSibling) {
			list = container.previousElementSibling.querySelector('#' + listId);
		}
		return { list: list, container: container };
	}

	function setButtonLoading(btn, loading) {
		var span = btn.querySelector('span');
		var text = loading ? (loadingText || 'Loading...') : (loadMoreText || 'Load More');
		if (loading) {
			btn.disabled = true;
			btn.classList.add('loading');
			btn.setAttribute('aria-busy', 'true');
		} else {
			btn.disabled = false;
			btn.classList.remove('loading');
			btn.setAttribute('aria-busy', 'false');
		}
		if (span) {
			span.textContent = text;
		} else {
			btn.textContent = text;
		}
	}

	document.addEventListener('click', function (e) {
		var btn = e.target.closest('.tasheel-listing-load-more');
		if (!btn) return;

		var ref = getListAndContainer(btn);
		if (!ref.list || !ref.container) {
			if (typeof console !== 'undefined' && console.error) {
				console.error('ListingLoadMore: list or container not found', { list: ref.list, container: ref.container });
			}
			return;
		}

		var listingType = ref.container.getAttribute('data-listing-ajax');
		var action, nonce;
		if (listingType === 'news') {
			action = newsAction;
			nonce = newsNonce;
		} else if (listingType === 'events') {
			action = eventsAction;
			nonce = eventsNonce;
		} else {
			return;
		}
		if (!nonce) return;

		var perPage = parseInt(ref.container.getAttribute('data-per-page'), 10) || 12;
		var currentPage = parseInt(ref.container.getAttribute('data-current-page'), 10) || 1;
		var nextPage = currentPage + 1;
		var lang = ref.container.getAttribute('data-lang');

		e.preventDefault();
		setButtonLoading(btn, true);

		var formData = new FormData();
		formData.append('action', action);
		formData.append('nonce', nonce);
		formData.append('page', nextPage);
		formData.append('per_page', perPage);
		if (lang) {
			formData.append('lang', lang);
		}

		fetch(ajaxUrl, {
			method: 'POST',
			body: formData,
			credentials: 'same-origin',
		})
			.then(function (res) { return res.text(); })
			.then(function (text) {
				var json = null;
				try {
					// WordPress or plugins may prepend "0" or whitespace; find the WordPress JSON response
					var start = text.indexOf('{"success":');
					if (start === -1) start = text.indexOf('{');
					if (start !== -1) {
						json = JSON.parse(text.slice(start));
					}
				} catch (err) {
					if (typeof console !== 'undefined' && console.error) {
						console.error('ListingLoadMore: invalid JSON', err);
						console.error('Response text (first 500 chars):', text ? text.slice(0, 500) : '');
					}
				}
				setButtonLoading(btn, false);
				if (!json) return;
				if (json.success === false) {
					if (typeof console !== 'undefined' && console.error) {
						console.error('ListingLoadMore: server error', json.data && json.data.message ? json.data.message : json);
					}
					return;
				}
				if (json.success && json.data) {
					if (json.data.html && json.data.html.trim()) {
						// Store current item count before appending
						var beforeCount = ref.list.children.length;
						
						// Try to append using insertAdjacentHTML (fastest)
						try {
							ref.list.insertAdjacentHTML('beforeend', json.data.html);
						} catch (e) {
							// Fallback: create a temporary container and parse HTML
							if (typeof console !== 'undefined' && console.warn) {
								console.warn('ListingLoadMore: insertAdjacentHTML failed, using fallback', e);
							}
							var temp = document.createElement('div');
							temp.innerHTML = json.data.html;
							while (temp.firstChild) {
								ref.list.appendChild(temp.firstChild);
							}
						}
						
						// Verify items were added
						var afterCount = ref.list.children.length;
						if (typeof console !== 'undefined' && console.log) {
							console.log('ListingLoadMore: appended HTML. Items before:', beforeCount, 'after:', afterCount);
							if (afterCount === beforeCount) {
								console.warn('ListingLoadMore: WARNING - no items were added to the list!');
								console.warn('HTML received:', json.data.html.substring(0, 200));
								console.warn('List element:', ref.list);
							} else {
								console.log('ListingLoadMore: successfully added', afterCount - beforeCount, 'items');
							}
						}
					} else {
						if (typeof console !== 'undefined' && console.warn) {
							console.warn('ListingLoadMore: received empty HTML');
						}
					}
					ref.container.setAttribute('data-current-page', String(nextPage));
					if (json.data.hasMore === false) {
						ref.container.style.display = 'none';
					}
					if (json.data.total !== undefined) {
						ref.container.setAttribute('data-total', String(json.data.total));
					}
				}
			})
			.catch(function (err) {
				setButtonLoading(btn, false);
				if (typeof console !== 'undefined' && console.error) {
					console.error('ListingLoadMore: fetch error', err);
				}
			});
	}, true);
})();
