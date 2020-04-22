<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Velox
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array $classes Classes for the body element.
 */
if ( ! function_exists( 'velox_body_classes' ) ) :
	function velox_body_classes( $classes ) {
		if ( ! is_singular() ) {
			// Adds a class of hfeed and h-feed to non-singular pages for microformats v2.
			$classes[] = 'hfeed';
			$classes[] = 'h-feed';
		} else {
			// Adds a class of hentry and h-entry for microformats v2.
			$classes[] = 'h-entry';
			$classes[] = 'hentry';
		}
		// Adds a class of single-author to blogs with only 1 published author.
		if ( ! is_multi_author() ) {
			$classes[] = 'single-author';
		}
		// Adds a class pf page-no-title to page-no-title.php template.
		if ( is_page_template( 'page-no-title.php' ) ) {
			$classes[] = 'page-no-title';
		}

		return array_unique( $classes );
	}
	add_filter( 'body_class', 'velox_body_classes' );
endif;

/**
 * Adds custom classes to the array of post classes.
 * These classes extend Microformats2 support.
 *
 * @link http://microformats.org/wiki/microformats2
 *
 * @param array $classes Classes for the post element.
 * @return array $classes Classes for the post element.
 */
if ( ! function_exists( 'velox_post_classes' ) ) :
	function velox_post_classes( $classes ) {
		// Remove hentry class from post classes.
		$classes = array_diff( $classes, array( 'hentry' ) );
		if ( ! is_singular() ) {
			// Adds a class of hentry and h-entry for microformats v2.
			// These are already added to the body class on singular pages.
			$classes[] = 'h-entry';
			$classes[] = 'hentry';
		}
		// Adds a class of no-title if there is not a title on the page.
		if ( ! get_the_title() ) {
			$classes[] = 'no-title';
		}

		return array_unique( $classes );
	}
	add_filter( 'post_class', 'velox_post_classes' );
endif;

/**
 * Adds custom classes to the array of comment classes.
 * These classes extend Microformats2 support.
 *
 * @link http://microformats.org/wiki/microformats2
 *
 * @param array $classes Classes for the comment element.
 * @return array $classes Classes for the comment element.
 */
if ( ! function_exists( 'velox_comment_classes' ) ) :
	function velox_comment_classes( $classes ) {
		$classes[] = 'h-entry';
		$classes[] = 'h-cite';
		$classes[] = 'p-comment';
		$classes[] = 'comment';

		return array_unique( $classes );
	}
	add_filter( 'comment_class', 'velox_comment_classes', 11 );
endif;

/**
 * Adds microformats v2 support to the comment_author_link.
 */
if ( ! function_exists( 'velox_author_link' ) ) :
	function velox_author_link( $link ) {
		// Adds a class for microformats v2
		return preg_replace( '/(class\s*=\s*[\"|\'])/i', '${1}u-url ', $link );
	}
	add_filter( 'get_comment_author_link', 'velox_author_link' );
endif;

/**
 * Adds classes to avatar.
 * These classes extend Microformats2 support.
 *
 * @link http://microformats.org/wiki/microformats2
 *
 * @param array             $args Arguments passed to get_avatar_data(), after processing.
 * @param int|string|object $id_or_email A user ID, email address, or comment object.
 * @return array $args
 */
if ( ! function_exists( 'velox_mf2_get_avatar_data' ) ) :
	function velox_mf2_get_avatar_data( $args, $id_or_email ) {
		if ( ! isset( $args['class'] ) ) {
			$args['class'] = array( 'u-photo' );
		} else {
			$args['class'][] = 'u-photo';
		}
		return $args;
	}
	add_filter( 'get_avatar_data', 'velox_mf2_get_avatar_data', 11, 2 );
endif;

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
if ( ! function_exists( 'velox_pingback_header' ) ) :
	function velox_pingback_header() {
		if ( is_singular() && pings_open() ) {
			echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
		}
	}
	add_action( 'wp_head', 'velox_pingback_header' );
endif;

/**
 * Calculate the time difference - a replacement for `human_time_diff()` until it is improved.
 *
 * Based on BuddyPress function `bp_core_time_since()`, which in turn is based on functions created by
 * Dunstan Orchard - http://1976design.com
 *
 * This function will return an text representation of the time elapsed since a
 * given date, giving the two largest units e.g.:
 *
 *  - 2 hours and 50 minutes
 *  - 4 days
 *  - 4 weeks and 6 days
 *
 * @param int      $older_date     Unix timestamp of date you want to calculate the time since for`.
 * @param int|bool $newer_date     Optional. Unix timestamp of date to compare older date to. Default false (current time).
 * @param int      $relative_depth Optional, how many units to include in relative date. Default 2.
 * @return string The time difference between two dates.
 */
if ( ! function_exists( 'velox_human_time_diff' ) ) :
	function velox_human_time_diff( $older_date, $newer_date = false, $relative_depth = 2 ) {

		if ( ! is_int( $older_date ) ) {
			return '';
		}

		// If no newer date is given, assume now.
		$newer_date = $newer_date ? $newer_date : time();

		// Difference in seconds.
		$since = absint( $newer_date - $older_date );

		if ( ! $since ) {
			return '0 ' . _x( 'seconds', 'time difference', 'velox' );
		}

		// Hold units of time in seconds, and their pluralised strings (not translated yet).
		$units = array(
			/* translators: %s: Number of year(s). */
			array( 31536000, _nx_noop( '%s year', '%s years', 'time difference', 'velox' ) ),  // 60 * 60 * 24 * 365
			/* translators: %s: Number of month(s). */
			array( 2592000, _nx_noop( '%s month', '%s months', 'time difference', 'velox' ) ), // 60 * 60 * 24 * 30
			/* translators: %s: Number of week(s). */
			array( 604800, _nx_noop( '%s week', '%s weeks', 'time difference', 'velox' ) ),    // 60 * 60 * 24 * 7
			/* translators: %s: Number of day(s). */
			array( 86400, _nx_noop( '%s day', '%s days', 'time difference', 'velox' ) ),       // 60 * 60 * 24
			/* translators: %s: Number of hour(s). */
			array( 3600, _nx_noop( '%s hour', '%s hours', 'time difference', 'velox' ) ),      // 60 * 60
			/* translators: %s: Number of minute(s). */
			array( 60, _nx_noop( '%s minute', '%s minutes', 'time difference', 'velox' ) ),
			/* translators: %s: Number of second(s). */
			array( 1, _nx_noop( '%s second', '%s seconds', 'time difference', 'velox' ) ),
		);

		// Build output with as many units as specified in $relative_depth.
		$relative_depth = (int) $relative_depth ? (int) $relative_depth : 2;

		$i = 0;

		$counted_seconds = 0;

		$date_partials        = array();
		$amount_date_partials = 0;
		$amount_units         = count( $units );

		while ( $amount_date_partials < $relative_depth && $i < $amount_units ) {
			$seconds = $units[ $i ][0];
			$count   = (int) floor( ( $since - $counted_seconds ) / $seconds );
			if ( 0 !== $count ) {
				$date_partials[]      = sprintf( translate_nooped_plural( $units[ $i ][1], $count, 'velox' ), $count );
				$counted_seconds     += $count * $seconds;
				$amount_date_partials = count( $date_partials );
			}
			$i++;
		}

		if ( empty( $date_partials ) ) {
			$output = '';
		} elseif ( 1 === count( $date_partials ) ) {
			$output = $date_partials[0];
		} else {

			// Combine all but last partial using commas.
			$output = implode( ', ', array_slice( $date_partials, 0, -1 ) );

			// Add 'and' separator.
			$output .= ' ' . _x( 'and', 'separator in time difference', 'velox' ) . ' ';

			// Add last partial.
			$output .= end( $date_partials );
		}

		return $output;

	}
endif;
