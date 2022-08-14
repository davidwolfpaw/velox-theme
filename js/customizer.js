/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

(function($) {
	// Site title and description.
	wp.customize(
		"blogname",
		function(value) {
			value.bind(
				function(to) {
					$( ".site-title a" ).text( to );
				}
			);
		}
	);
	wp.customize(
		"blogdescription",
		function(value) {
			value.bind(
				function(to) {
					$( ".site-description" ).text( to );
				}
			);
		}
	);

	// Text Color.
	wp.customize(
		"text_color",
		function(value) {
			value.bind(
				function(to) {
					$( "body, input, select, optgroup, textarea, h1, h2, h3, h4, h5, h6, .has-text-color" ).css(
						{
							"color": to
						}
					);
					$( ".has-text-background-color" ).css(
						{
							"backgroundColor": to
						}
					);
				}
			);
		}
	);

	// Accent Text Color.
	wp.customize(
		"accent_text_color",
		function(value) {
			value.bind(
				function(to) {
					$( ".entry-footer, .entry-meta, .wp-block-image figcaption, .wp-block-pullquote cite, .wp-block-latest-posts__post-date, .wp-caption-text, .has-accent-text-color" ).css(
						{
							"color": to
						}
					);
					$( ".has-accent-text-background-color" ).css(
						{
							"backgroundColor": to
						}
					);
				}
			);
		}
	);

	// Accent Color.
	wp.customize(
		"accent_color",
		function(value) {
			value.bind(
				function(to) {
					$( ".wp-block-separator.is-style-dots:before, .has-accent-color" ).css(
						{
							"color": to
						}
					);
					$( "hr, hr.wp-block-separator, .wp-block-button__link, .progress-bar, .has-accent-background-color" ).css(
						{
							"backgroundColor": to
						}
					);
					$( ".comment-navigation, .after-entry-sidebar, .posts-navigation, .post-navigation, .entry-footer, .author-info, hr, .wp-block-separator" ).css(
						{
							"borderBottomColor": to
						}
					);
					$( ".wp-block-pullquote" ).css(
						{
							"borderTopColor": to,
							"borderBottomColor": to
						}
					);
					$( ".navigation .nav-previous" ).css(
						{
							"borderRightColor": to
						}
					);
					$( ".wp-block-quote:not(.is-large)" ).css(
						{
							"borderLeftColor": to
						}
					);
				}
			);
		}
	);

	// Link Color.
	wp.customize(
		"link_color",
		function(value) {
			value.bind(
				function(to) {
					$( "a, a:visited" ).css(
						{
							color: to
						}
					);
					$( "#main-navigation a" ).css(
						{
							color: to
						}
					);
					$( ".site-title a" ).css(
						{
							color: to
						}
					);
					$( ".wp-block-button__link, #main-navigation a:hover, #main-navigation a:focus" ).css(
						{
							"backgroundColor": to,
							color: "#fff"
						}
					);
					$( ".wp-block-button__link" ).css(
						{
							color: "#fff"
						}
					);
					$( ".hentry .entry-content a:not(.wp-block-button__link)" ).css(
						{
							color: to,
							"borderBottomColor": to,
							"boxShadow": "inset 0 -2px 0" + to
						}
					);
				}
			);
		}
	);

	// Link Color on hover.
	wp.customize(
		'link_color',
		function(value) {
			value.bind(
				function(to) {
					var style, el;
					// build the style element
					style = '<style class="hover-styles">.wp-block-button__link, #main-navigation a:hover, #main-navigation a:focus { background-color: ' + to + '; color: #fff !important; }</style>';
					// look for a matching style element that might already be there
					el = $( ".hover-styles" );
					// add the style element into the DOM or replace the matching style element that is already there
					if (el.length) {
						el.replaceWith( style ); // style element already exists, so replace it
					} else {
						$( "head" ).append( style ); // style element doesn't exist so add it
					}
				}
			);
		}
	);

	// Link Active/Hover/Focus Color.
	wp.customize(
		"link_active_color",
		function(value) {
			value.bind(
				function(to) {
					$( "a:hover, a:focus, a:active" ).css(
						{
							"color": to
						}
					);
					$( ".wp-block-button__link:hover, .wp-block-button__link:active, .wp-block-button__link:focus, .hentry .entry-content a.wp-block-button__link:hover, .hentry .entry-content a.wp-block-button__link:active, .hentry .entry-content a.wp-block-button__link:focus" ).css(
						{
							"backgroundColor": to
						}
					);
					$( ".hentry .entry-content a:hover, .hentry .entry-content a:focus, .hentry .entry-content a:active, .hentry .wp-block-image a:active, .hentry .wp-block-image a:focus, .hentry .wp-block-image a:hover, .hentry .wp-block-gallery a:active, .hentry .wp-block-gallery a:focus, .hentry .wp-block-gallery a:hover" ).css(
						{
							"backgroundColor": to,
							"borderBottomColor": to,
							"boxShadow": "inset 0 -2px 0" + to
						}
					);
					$( ".wp-block-button__link:hover, .wp-block-button__link:active, .wp-block-button__link:focus" ).css(
						{
							"color": "#fff"
						}
					);
				}
			);
		}
	);
})( jQuery );
