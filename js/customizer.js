/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

(function($) {
	// Site title and description.
	wp.customize("blogname", function(value) {
		value.bind(function(to) {
			$(".site-title a").text(to);
		});
	});
	wp.customize("blogdescription", function(value) {
		value.bind(function(to) {
			$(".site-description").text(to);
		});
	});

	// Text Color.
	wp.customize("text_color", function(value) {
		value.bind(function(to) {
      $("body, button, input, select, optgroup, textarea, h1, h2, h3, h4, h5, h6, .has-text-color").css({
        "color": to
      });
      $(".has-text-background-color").css({
        "background-color": to
      });
		});
	});

	// Accent Text Color.
	wp.customize("accent_text_color", function(value) {
		value.bind(function(to) {
			$(".entry-footer, .entry-meta, .wp-block-image figcaption, .wp-block-pullquote cite, .wp-block-latest-posts__post-date, .wp-caption-text, .has-accent-text-color").css({
				"color": to
			});
      $(".has-accent-text-background-color").css({
        "background-color": to
      });
		});
	});

	// Accent Color.
	wp.customize("accent_color", function(value) {
		value.bind(function(to) {
      $(".wp-block-separator.is-style-dots:before, .has-accent-color").css({
        "color": to
      });
      $("hr, hr.wp-block-separator, .wp-block-button__link, .progress-bar, .has-accent-background-color").css({
        "background-color": to
      });
      $(".comment-navigation, .posts-navigation, .post-navigation, .entry-footer, .author-info, hr, .wp-block-separator").css({
        "border-bottom-color": to
      });
			$(".wp-block-pullquote").css({
				"border-top-color": to,
				"border-bottom-color": to
			});
      $(".navigation .nav-previous").css({
        "border-right-color": to
      });
      $(".wp-block-quote:not(.is-large)").css({
        "border-left-color": to
      });
		});
	});

	// Link Color.
	wp.customize("link_color", function(value) {
		value.bind(function(to) {
			$("a, a:visited").css({
				color: to
			});
			$("#main-navigation a").css({
				color: "#FFFFFF"
			});
			$(".site-title a").css({
				color: "initial"
			});
			$(".wp-block-button__link").css({
				"background-color": to
			});
      $(".wp-block-button__link").css({
        color: "#FFFFFF"
      });
      $(".hentry .entry-content a").css({
        color: to,
        "border-bottom-color": to,
        "box-shadow": "inset 0 -2px 0" + to
      });
		});
	});

	// Link Active/Hover/Focus Color.
	wp.customize("link_active_color", function(value) {
		value.bind(function(to) {
			$("a:hover, a:focus, a:active").css({
				"color": to
			});
      $(".wp-block-button__link:hover, .wp-block-button__link:active, .wp-block-button__link:focus, .hentry .entry-content a.wp-block-button__link:hover, .hentry .entry-content a.wp-block-button__link:active, .hentry .entry-content a.wp-block-button__link:focus").css({
        "background-color": to
      });
      $(".hentry .entry-content a:hover, .hentry .entry-content a:focus, .hentry .entry-content a:active, .hentry .wp-block-image a:active, .hentry .wp-block-image a:focus, .hentry .wp-block-image a:hover, .hentry .wp-block-gallery a:active, .hentry .wp-block-gallery a:focus, .hentry .wp-block-gallery a:hover").css({
        "background-color": to,
        "border-bottom-color": to,
        "box-shadow": "inset 0 -2px 0" + to
      });
			$(".wp-block-button__link:hover, .wp-block-button__link:active, .wp-block-button__link:focus").css({
				"color": "#FFFFFF"
			});
		});
	});
})(jQuery);


