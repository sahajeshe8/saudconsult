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
		var grid = document.getElementById('projects-grid');
		if (!grid) return 12;
		var val = parseInt(grid.getAttribute('data-per-page'), 10);
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
		var loader = wrapper.querySelector('.project_filter_loader');
		if (loader) {
			loader.style.display = loading ? 'flex' : 'none';
		}
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

		// Pass current language so AJAX returns projects in that language (WPML).
		var lang = grid.getAttribute('data-lang');
		if (lang) params.lang = lang;

		var loadingText = config.loadingText || (typeof wp !== 'undefined' && wp.i18n ? wp.i18n.__('Loading…', 'tasheel') : 'Loading…');
		// Full overlay only when filtering; Load More shows loading text on button
		if (!append) {
			setLoading(true);
		} else if (loadMoreBtn) {
			if (!loadMoreBtn.dataset.originalHtml) {
				loadMoreBtn.dataset.originalHtml = loadMoreBtn.innerHTML;
			}
			loadMoreBtn.disabled = true;
			loadMoreBtn.classList.add('loading');
			loadMoreBtn.innerHTML = '<span>' + loadingText + '</span>';
		}

		var url = ajaxUrl + '?action=' + encodeURIComponent(action) + buildQueryStringFromObject(params);

		fetch(url, { method: 'GET', credentials: 'same-origin' })
			.then(function(response) {
				return response.json();
			})
			.then(function(json) {
				if (!append) setLoading(false);
				if (loadMoreBtn) {
					loadMoreBtn.disabled = false;
					loadMoreBtn.classList.remove('loading');
					if (loadMoreBtn.dataset.originalHtml) {
						loadMoreBtn.innerHTML = loadMoreBtn.dataset.originalHtml;
					}
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
						if (json.data.total !== undefined) {
							loadMoreWrapper.setAttribute('data-total', String(json.data.total));
						}
					}
					if (loadMoreBtn) {
						loadMoreBtn.style.display = '';
					}
					if (!append) {
						var urlParams = {};
						Object.keys(params).forEach(function(k) {
							if (k !== 'offset' && k !== 'lang') urlParams[k] = params[k];
						});
						updateUrl(urlParams);
					}
				}
			})
			.catch(function() {
				if (!append) setLoading(false);
				if (loadMoreBtn) {
					loadMoreBtn.disabled = false;
					loadMoreBtn.classList.remove('loading');
					if (loadMoreBtn.dataset.originalHtml) {
						loadMoreBtn.innerHTML = loadMoreBtn.dataset.originalHtml;
					}
				}
				if (!append) {
					grid.innerHTML = '<p class="no-projects">' + (typeof wp !== 'undefined' && wp.i18n ? wp.i18n.__('Error loading projects.', 'tasheel') : 'Error loading projects.') + '</p>';
				}
			});
	}

	function runLoadMore() {
		runFilter(true);
	}

	function applyLoadMoreVisibility() {
		var grid = document.getElementById('projects-grid');
		var wrap = grid && grid.closest('.wrap');
		var loadMoreWrapper = wrap && wrap.querySelector('.load_more_wrapper');
		if (!grid || !loadMoreWrapper) return;
		var total = parseInt(loadMoreWrapper.getAttribute('data-total'), 10) || 0;
		var offset = parseInt(grid.getAttribute('data-offset'), 10) || 0;
		var hasMore = total > offset;
		loadMoreWrapper.style.display = hasMore ? '' : 'none';
		var loadMoreBtn = loadMoreWrapper.querySelector('.load_more_btn');
		if (loadMoreBtn) loadMoreBtn.style.display = '';
	}

	function getSectorsByCategory(container) {
		// Use global set by template (reliable); fallback to JSON script or data attribute
		if (typeof window.tasheelSectorsByCategory === 'object' && window.tasheelSectorsByCategory !== null) {
			return window.tasheelSectorsByCategory;
		}
		var scriptEl = document.getElementById('project-sectors-by-category');
		if (scriptEl && scriptEl.textContent) {
			try {
				var data = JSON.parse(scriptEl.textContent.trim());
				if (data && typeof data === 'object') return data;
			} catch (e) {}
		}
		var raw = container && container.getAttribute('data-sectors-by-category');
		if (!raw) return {};
		try {
			return JSON.parse(raw);
		} catch (e) {
			return {};
		}
	}

	function getCategorySelect(container) {
		return container ? container.querySelector('.project_filter_select[data-filter-type="category"]') : null;
	}

	function getSectorSelect(container) {
		return container ? container.querySelector('.project_filter_select[data-filter-type="sector"]') : null;
	}

	function setSectorOptions(sectorSelect, options, allSectorsText, preserveValue) {
		if (!sectorSelect) return;
		var first = options && options[0];
		var label = (allSectorsText !== undefined && allSectorsText !== '') ? allSectorsText : (first && first.value === '' ? first.text : 'All Sectors');
		sectorSelect.innerHTML = '';
		var opt0 = document.createElement('option');
		opt0.value = '';
		opt0.textContent = label;
		sectorSelect.appendChild(opt0);
		if (options && options.length > 1) {
			for (var i = 1; i < options.length; i++) {
				var o = options[i];
				var opt = document.createElement('option');
				opt.value = o.value;
				opt.textContent = o.text;
				sectorSelect.appendChild(opt);
			}
		}
		// Preserve URL/default sector if it exists in the new options (e.g. when landing with ?category=...&sector=...)
		if (preserveValue && preserveValue !== '') {
			var found = false;
			for (var j = 0; j < sectorSelect.options.length; j++) {
				if (sectorSelect.options[j].value === preserveValue) {
					found = true;
					break;
				}
			}
			if (found) sectorSelect.value = preserveValue;
			else sectorSelect.value = '';
		} else {
			sectorSelect.value = '';
		}
	}

	function updateSectorFromCategory(container, sectorsByCategory, categoryValue, preserveSectorValue) {
		var sectorSelect = getSectorSelect(container);
		if (!sectorSelect) return;
		var allSectorsText = sectorSelect.querySelector('option[value=""]') ? sectorSelect.querySelector('option[value=""]').textContent : 'All Sectors';
		if (!categoryValue) {
			// No category selected: disable sector and show only "All Sectors"
			sectorSelect.disabled = true;
			sectorSelect.setAttribute('aria-disabled', 'true');
			sectorSelect.classList.add('project_filter_select--disabled');
			setSectorOptions(sectorSelect, [{ value: '', text: allSectorsText }], allSectorsText);
		} else {
			// Category selected: always enable sector and set options for this category (key = category slug from dropdown)
			sectorSelect.disabled = false;
			sectorSelect.removeAttribute('aria-disabled');
			sectorSelect.classList.remove('project_filter_select--disabled');
			var options = [];
			if (sectorsByCategory && categoryValue) {
				options = (sectorsByCategory[categoryValue] && sectorsByCategory[categoryValue].length) ? sectorsByCategory[categoryValue] : [];
				// Fallback: try slug-style key (lowercase, spaces to hyphens) in case value format differs
				if (options.length === 0 && typeof sectorsByCategory === 'object') {
					var slugKey = categoryValue.toLowerCase().replace(/\s+/g, '-').replace(/_/g, '-');
					if (sectorsByCategory[slugKey] && sectorsByCategory[slugKey].length) {
						options = sectorsByCategory[slugKey];
					}
				}
			}
			setSectorOptions(sectorSelect, [{ value: '', text: allSectorsText }].concat(options), allSectorsText, preserveSectorValue);
		}
	}

	function init() {
		var container = document.querySelector('.project_filter_section');
		if (!container) return;

		var sectorsByCategory = getSectorsByCategory(container);
		var categorySelect = getCategorySelect(container);
		var sectorSelect = getSectorSelect(container);

		// On load: if a category is already selected (e.g. from URL), enable sector and show its related services; preserve sector from URL so it stays selected
		if (sectorSelect && categorySelect) {
			var categoryValue = (categorySelect.value || '').trim();
			var sectorValueFromUrl = (sectorSelect.value || '').trim();
			updateSectorFromCategory(container, sectorsByCategory, categoryValue, sectorValueFromUrl);
		}

		// When category changes: re-read sector data (in case script wasn't ready at init), update sector, then run AJAX filter
		if (categorySelect) {
			categorySelect.addEventListener('change', function() {
				var categoryValue = (categorySelect.value || '').trim();
				if (sectorSelect) {
					var freshSectors = getSectorsByCategory(container);
					updateSectorFromCategory(container, freshSectors, categoryValue);
				}
				setCurrentOffset(0);
				runFilter(false);
			});
		}

		var selects = container.querySelectorAll('.project_filter_select');
		selects.forEach(function(select) {
			var type = select.getAttribute('data-filter-type');
			select.addEventListener('change', function() {
				if (type === 'category') {
					return; // already handled above
				}
				setCurrentOffset(0);
				runFilter(false);
			});
		});

		var loadMoreBtn = document.getElementById('load-more-projects');
		if (loadMoreBtn) {
			loadMoreBtn.addEventListener('click', function() {
				runLoadMore();
			});
		}

		// Restore Load More visibility after other scripts (e.g. main.js) that may hide it
		setTimeout(applyLoadMoreVisibility, 150);
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', init);
	} else {
		init();
	}
})();
