/**
 * Fix WPML language counts on Job Applications / Jobs list for recruiters (role-scoped counts).
 * Only updates the three language tabs (Arabic, English, All languages) - never touches All / Published / Trash.
 */
(function() {
	'use strict';

	var counts = window.tasheelHrWpmlCounts;
	if ( ! counts || typeof counts.all === 'undefined' ) {
		return;
	}

	function getCountForLink( link ) {
		var text = ( link.textContent || link.innerText || '' ).trim().toLowerCase();
		var href = link.getAttribute( 'href' ) || '';
		// Only treat as language tab if the link text is clearly a language name (not status: All, Published, Trash).
		if ( text.indexOf( 'all languages' ) !== -1 ) return counts.all;
		if ( text.indexOf( 'english' ) !== -1 ) return counts.en;
		if ( text.indexOf( 'arabic' ) !== -1 ) return counts.ar;
		// Do not use href-only: "All" and "Published" links can also have lang= in URL; we must not overwrite those.
		return null;
	}

	function updateCountInElement( el, n ) {
		if ( ! el ) return;
		var html = el.innerHTML;
		if ( ! html ) return;
		var current = ( el.textContent || el.innerText || '' ).match( /\((\d+)\)/ );
		var currentNum = current ? parseInt( current[1], 10 ) : -1;
		if ( currentNum === n ) return;
		// Replace only the count: (number) or <span class="count">(number)</span>
		var newHtml = html.replace( /<span[^>]*class="count"[^>]*>\(\d+\)<\/span>/gi, '<span class="count">(' + n + ')</span>' );
		newHtml = newHtml.replace( /\(\d+\)/g, '(' + n + ')' );
		if ( newHtml !== html ) el.innerHTML = newHtml;
	}

	function run() {
		var wrap = document.querySelector( '.wrap' );
		if ( ! wrap ) return;
		// Only links in the views row (subsubsub) that are clearly language tabs by their text.
		var links = wrap.querySelectorAll( 'ul.subsubsub a[href*="lang="], .subsubsub a[href*="lang="]' );
		for ( var i = 0; i < links.length; i++ ) {
			var a = links[i];
			var n = getCountForLink( a );
			if ( n === null ) continue;
			// Update only the count inside the link; prefer span.count if present so we don't replace link text.
			var countSpan = a.querySelector( 'span.count' );
			if ( countSpan ) {
				updateCountInElement( countSpan, n );
			} else {
				updateCountInElement( a, n );
			}
		}
	}

	function scheduleRuns() {
		run();
		setTimeout( run, 100 );
		setTimeout( run, 500 );
		setTimeout( run, 1200 );
		setTimeout( run, 2500 );
	}

	if ( document.readyState === 'complete' ) {
		scheduleRuns();
	} else {
		window.addEventListener( 'load', scheduleRuns );
	}
	document.addEventListener( 'DOMContentLoaded', function() {
		run();
		setTimeout( run, 200 );
		setTimeout( run, 600 );
	} );
})();
