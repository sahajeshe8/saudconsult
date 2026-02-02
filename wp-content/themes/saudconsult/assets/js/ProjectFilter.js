/**
 * Project Filter – Projects page (AJAX)
 * When user changes a filter dropdown (Category, Sector, Location),
 * fetches filtered projects via AJAX and updates the grid without full page reload.
 */
(function() {
	'use strict';

	var config = typeof tasheelProjectFilter !== 'undefined' ? tasheelProjectFilter : {};
	var ajaxUrl = config.ajaxUrl || '';
	var action = config.action || 'tasheel_filter_projects';

	function getFilterParams() {
		var container = document.querySelector('.project_filter_section');
		if (!container) return {};
		var selects = container.querySelectorAll('.project_filter_select');
		var params = {};
		selects.forEach(function(select) {
			var type = select.getAttribute('data-filter-type');
			var value = (select.value || '').trim();
			if (type) params[type] = value;
		});
		return params;
	}

	function getPerPage() {
		var container = document.querySelector('.project_filter_section');
		if (!container) return 12;
		var perPageSelect = container.querySelector('.project_filter_select[data-filter-type="per_page"]');
		if (!perPageSelect) return 12;
		var val = parseInt(perPageSelect.value, 10);
		return isNaN(val) ? 12 : val;
	}

	function getCurrentOffset() {
		var grid = document.getElementById('projects-grid');
		if (!grid) return 0;
		var offset = parseInt(grid.getAttribute('data-offset'), 10);
		return isNaN(offset) ? 0 : offset;
	}

	function setCurrentOffset(offset) {
		var grid = document.getElementById('projects-grid');
		if (grid) grid.setAttribute('data-offset', String(offset));
	}

	function buildQueryString(params) {
		var parts = [];
		Object.keys(params).forEach(function(key) {
			if (params[key]) parts.push(encodeURIComponent(key) + '=' + encodeURIComponent(params[key]));
		});
		return parts.length ? '&' + parts.join('&') : '';
	}

	function updateUrl(params) {
		var base = window.location.origin + window.location.pathname;
		var qs = Object.keys(params).reduce(function(acc, key) {
			if (params[key]) acc.push(encodeURIComponent(key) + '=' + encodeURIComponent(params[key]));
			return acc;
		}, []).join('&');
		var url = qs ? base + '?' + qs : base;
		window.history.pushState({ filter: params }, '', url);
	}

	function buildQueryStringFromObject(params) {
		var parts = [];
		Object.keys(params).forEach(function(key) {
			if (params[key] !== undefined && params[key] !== '') {
				parts.push(encodeURIComponent(key) + '=' + encodeURIComponent(params[key]));
			}
		});
		return parts.length ? '&' + parts.join('&') : '';
	}

	function setLoading(loading) {
		var grid = document.getElementById('projects-grid');
		var wrapper = grid && grid.closest('.projects_list_section');
		if (!wrapper) return;
		if (loading) {
			wrapper.classList.add('project-filter-loading');
		} else {
			wrapper.classList.remove('project-filter-loading');
		}
	}

	function runFilter(append) {
		if (!ajaxUrl) return;

		var params = getFilterParams();
		var perPage = getPerPage();
		var offset = append ? getCurrentOffset() : 0;
		params.per_page = perPage;
		params.offset = offset;

		var grid = document.getElementById('projects-grid');
		var wrap = grid && grid.closest('.wrap');
		var loadMoreWrapper = wrap && wrap.querySelector('.load_more_wrapper');
		var loadMoreBtn = loadMoreWrapper && loadMoreWrapper.querySelector('.load_more_btn');

		if (!grid) return;

		setLoading(true);
		if (append && loadMoreBtn) {
			loadMoreBtn.disabled = true;
			loadMoreBtn.classList.add('loading');
		}

		var url = ajaxUrl + '?action=' + encodeURIComponent(action) + buildQueryStringFromObject(params);

		fetch(url, { method: 'GET', credentials: 'same-origin' })
			.then(function(response) {
				return response.json();
			})
			.then(function(json) {
				setLoading(false);
				if (loadMoreBtn) {
					loadMoreBtn.disabled = false;
					loadMoreBtn.classList.remove('loading');
				}
				if (json.success && json.data && json.data.html !== undefined) {
					if (append && json.data.html) {
						grid.insertAdjacentHTML('beforeend', json.data.html);
					} else {
						grid.innerHTML = json.data.html;
					}
					var newOffset = json.data.offset !== undefined ? json.data.offset : (offset + (append ? 1 : 0));
					setCurrentOffset(newOffset);
					if (loadMoreWrapper) {
						loadMoreWrapper.style.display = json.data.hasMore ? '' : 'none';
					}
					if (!append) {
						var urlParams = {};
						Object.keys(params).forEach(function(k) {
							if (k !== 'offset') urlParams[k] = params[k];
						});
						updateUrl(urlParams);
					}
				}
			})
			.catch(function() {
				setLoading(false);
				if (loadMoreBtn) {
					loadMoreBtn.disabled = false;
					loadMoreBtn.classList.remove('loading');
				}
				if (!append) {
					grid.innerHTML = '<p class="no-projects">' + (typeof wp !== 'undefined' && wp.i18n ? wp.i18n.__('Error loading projects.', 'tasheel') : 'Error loading projects.') + '</p>';
				}
			});
	}

	function runLoadMore() {
		runFilter(true);
	}

	function init() {
		var container = document.querySelector('.project_filter_section');
		if (!container) return;

		var selects = container.querySelectorAll('.project_filter_select');
		selects.forEach(function(select) {
			var type = select.getAttribute('data-filter-type');
			select.addEventListener('change', function() {
				if (type === 'per_page') {
					setCurrentOffset(0);
					runFilter(false);
				} else {
					setCurrentOffset(0);
					runFilter(false);
				}
			});
		});

		var loadMoreBtn = document.getElementById('load-more-projects');
		if (loadMoreBtn) {
			loadMoreBtn.addEventListener('click', function() {
				runLoadMore();
			});
		}
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', init);
	} else {
		init();
	}
})();
