/**
 * Clients Filter – Clients page (AJAX)
 * Filter by category (tab links) and Load more. Updates grid without full page reload.
 */
(function() {
	'use strict';

	var config = typeof tasheelClientsFilter !== 'undefined' ? tasheelClientsFilter : {};
	var ajaxUrl = config.ajaxUrl || '';
	var action = config.action || 'tasheel_filter_clients';

	function getGrid() {
		return document.getElementById('clients-grid');
	}

	function getActiveCategory() {
		var container = document.querySelector('.clients_filter_container');
		if (!container) return '';
		var active = container.querySelector('.clients-filter-link.active');
		return active ? (active.getAttribute('data-client-category') || '') : '';
	}

	function setActiveCategory(slug) {
		var container = document.querySelector('.clients_filter_container');
		if (!container) return;
		container.querySelectorAll('.clients-filter-link').forEach(function(link) {
			var linkSlug = link.getAttribute('data-client-category') || '';
			link.classList.toggle('active', linkSlug === slug);
		});
	}

	function getPerPage() {
		var grid = getGrid();
		if (!grid) return 12;
		var val = parseInt(grid.getAttribute('data-per-page'), 10);
		return isNaN(val) ? 12 : val;
	}

	function getCurrentOffset() {
		var grid = getGrid();
		if (!grid) return 0;
		var offset = parseInt(grid.getAttribute('data-offset'), 10);
		return isNaN(offset) ? 0 : offset;
	}

	function setCurrentOffset(offset) {
		var grid = getGrid();
		if (grid) grid.setAttribute('data-offset', String(offset));
	}

	function setLoading(loading) {
		var section = document.querySelector('.clients_list_section');
		if (!section) return;
		var loader = section.querySelector('.clients_filter_loader');
		if (loader) loader.style.display = loading ? 'flex' : 'none';
	}

	function runFilter(append) {
		if (!ajaxUrl) return;

		var category = getActiveCategory();
		var perPage = getPerPage();
		var offset = append ? getCurrentOffset() : 0;

		var grid = getGrid();
		var loadMoreWrapper = grid && grid.closest('.client_list_section') && grid.closest('.client_list_section').querySelector('.load_more_wrapper');
		var loadMoreBtn = loadMoreWrapper && loadMoreWrapper.querySelector('.load_more_btn');

		if (!grid) return;

		var loadingText = config.loadingText || (typeof wp !== 'undefined' && wp.i18n ? wp.i18n.__('Loading…', 'tasheel') : 'Loading…');
		if (!append) {
			setLoading(true);
		} else if (loadMoreBtn) {
			if (!loadMoreBtn.dataset.originalHtml) loadMoreBtn.dataset.originalHtml = loadMoreBtn.innerHTML;
			loadMoreBtn.disabled = true;
			loadMoreBtn.classList.add('loading');
			loadMoreBtn.innerHTML = '<span>' + loadingText + '</span>';
		}

		var url = ajaxUrl + '?action=' + encodeURIComponent(action) +
			'&category=' + encodeURIComponent(category) +
			'&per_page=' + encodeURIComponent(perPage) +
			'&offset=' + encodeURIComponent(offset);

		fetch(url, { method: 'GET', credentials: 'same-origin' })
			.then(function(response) { return response.json(); })
			.then(function(json) {
				if (!append) setLoading(false);
				if (loadMoreBtn) {
					loadMoreBtn.disabled = false;
					loadMoreBtn.classList.remove('loading');
					if (loadMoreBtn.dataset.originalHtml) loadMoreBtn.innerHTML = loadMoreBtn.dataset.originalHtml;
				}
				if (json.success && json.data && json.data.html !== undefined) {
					if (append && json.data.html) {
						// Append: insert list items (or no-clients message might replace)
						if (json.data.html.indexOf('<li') === 0 || json.data.html.indexOf('<p') === 0) {
							grid.insertAdjacentHTML('beforeend', json.data.html);
						} else {
							grid.innerHTML = grid.innerHTML + json.data.html;
						}
					} else {
						grid.innerHTML = json.data.html;
					}
					var newOffset = json.data.offset !== undefined ? json.data.offset : (offset + (append ? 1 : 0));
					setCurrentOffset(newOffset);
					if (grid.getAttribute('data-total') !== undefined) {
						grid.setAttribute('data-total', String(json.data.total !== undefined ? json.data.total : 0));
					}
					if (loadMoreWrapper) {
						loadMoreWrapper.style.display = json.data.hasMore ? 'flex' : 'none';
						loadMoreWrapper.setAttribute('data-total', String(json.data.total !== undefined ? json.data.total : 0));
					}
					if (!append) {
						var base = window.location.origin + window.location.pathname;
						var url = category ? base + '?category=' + encodeURIComponent(category) : base;
						window.history.pushState({ category: category }, '', url);
					}
				}
			})
			.catch(function() {
				if (!append) setLoading(false);
				if (loadMoreBtn) {
					loadMoreBtn.disabled = false;
					loadMoreBtn.classList.remove('loading');
					if (loadMoreBtn.dataset.originalHtml) loadMoreBtn.innerHTML = loadMoreBtn.dataset.originalHtml;
				}
				if (!append) {
					grid.innerHTML = '<p class="no-clients">' + (typeof wp !== 'undefined' && wp.i18n ? wp.i18n.__('Error loading clients.', 'tasheel') : 'Error loading clients.') + '</p>';
				}
			});
	}

	function init() {
		var container = document.querySelector('.clients_filter_container');
		if (!container) return;

		container.querySelectorAll('.clients-filter-link').forEach(function(link) {
			link.addEventListener('click', function(e) {
				e.preventDefault();
				var slug = link.getAttribute('data-client-category') || '';
				setActiveCategory(slug);
				setCurrentOffset(0);
				runFilter(false);
			});
		});

		var loadMoreBtn = document.getElementById('load-more-clients-ajax');
		if (loadMoreBtn) {
			loadMoreBtn.addEventListener('click', function() {
				runFilter(true);
			});
		}
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', init);
	} else {
		init();
	}
})();
