<?php
/**
 * Functions that handle entry meta and footer in theme
 *
 * @package Velox
 */


/**
 * Get the entry meta for the post.
 *
 * Output passes through `velox_get_entry_meta` filter before returning.
 *
 * @return string $entry_meta
 */
function velox_get_entry_meta() {

	$entry_meta = __( 'Posted On ', 'velox' );
	$entry_meta .= velox_get_post_date( array() );

	return apply_filters( 'velox_get_entry_meta', $entry_meta );

}

/**
 * Get the entry footer meta for the post.
 *
 * Output passes through `velox_get_entry_footer_meta` filter before returning.
 *
 * @return string $entry_meta
 */
function velox_get_entry_footer_meta() {

	$entry_meta = '<div class="entry-meta-categories">';
	$entry_meta .= velox_get_post_categories( array() );
	$entry_meta .= '</div>';
	$entry_meta .= '<div class="entry-meta-tags">';
	$entry_meta .= velox_get_post_tags( array() );
	$entry_meta .= '</div>';

	return apply_filters( 'velox_get_entry_footer_meta', $entry_meta );

}

/**
 * Produces the date of post publication.
 *
 * Supported attributes are:
 *   after (output after link, default is empty string),
 *   before (output before link, default is empty string),
 *   format (date format, default is value in date_format option field),
 *   modified (whether getting original or modified post date, defaults to false).
 *
 * Output passes through `velox_get_post_date` filter before returning.
 *
 * @param array|string $atts Meta attributes. Empty string if no attributes.
 * @return string Output for `post_date` shortcode.
 */
if ( ! function_exists( 'velox_get_post_date' ) ) :
	function velox_get_post_date( $atts ) {

		$defaults = array(
			'after'          => '',
			'before'         => '',
			'format'         => get_option( 'date_format' ),
			'modified'       => 'false',
			'relative_depth' => 2,
		);

		$atts = array_replace( $defaults, $atts );

		// If we're getting the modified date or the original post date.
		if ( 'true' === $atts['modified'] ) {

			if ( 'relative' === $atts['format'] ) {
				$display  = velox_human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ), $atts['relative_depth'] );
				$display .= ' ' . __( 'ago', 'velox' );
			} else {
				$display = get_the_modified_time( $atts['format'] );
			}

			$output = sprintf( '<time itemprop="dateModified" class="dt-modified" datetime="%s">', get_the_modified_time( 'c' ) ) . $atts['before'] . $display . $atts['after'] . '</time>';

		} else {

			if ( 'relative' === $atts['format'] ) {
				$display  = velox_human_time_diff( get_the_modified_time( 'U' ), current_time( 'timestamp' ), $atts['relative_depth'] );
				$display .= ' ' . __( 'ago', 'velox' );
			} else {
				$display = get_the_time( $atts['format'] );
			}

			$output = sprintf( '<time itemprop="datePublished" class="dt-published" datetime="%s">', get_the_time( 'c' ) ) . $atts['before'] . $display . $atts['after'] . '</time>';

		}

		return apply_filters( 'velox_get_post_date', $output, $atts );

	}
endif;

/**
 * Produces the time of post publication.
 *
 * Supported attributes are:
 *   after (output after link, default is empty string),
 *   before (output before link, default is empty string),
 *   format (date format, default is value in date_format option field),
 *   modified (whether getting original or modified post time, defaults to false).
 *
 * Output passes through `velox_get_post_time` filter before returning.
 *
 * @param array|string $atts Meta attributes. Empty string if no attributes.
 * @return string Output for `post_time` shortcode`.
 */
if ( ! function_exists( 'velox_get_post_time' ) ) :
	function velox_get_post_time( $atts ) {

		$defaults = array(
			'after'    => '',
			'before'   => '',
			'format'   => get_option( 'time_format' ),
			'modified' => false,
		);

		$atts = array_replace( $defaults, $atts );

		if ( true === $atts['modified'] ) {

			$output = sprintf( '<time itemprop="dateModified" datetime="%s">', get_the_modified_time( 'c' ) ) . $atts['before'] . get_the_modified_time( $atts['format'] ) . $atts['after'] . '</time>';

		} else {

			$output = sprintf( '<time itemprop="datePublished" datetime="%s">', get_the_time( 'c' ) ) . $atts['before'] . get_the_time( $atts['format'] ) . $atts['after'] . '</time>';

		}

		return apply_filters( 'velox_get_post_time', $output, $atts );

	}
endif;

/**
 * Produces the author of the post.
 *
 * Supported attributes are:
 *   after (output after link, default is empty string),
 *   before (output before link, default is empty string),
 *   link (none, author page, author archives).
 *
 * Output passes through `velox_get_post_author` filter before returning.
 *
 * @since 1.1.0
 *
 * @param array|string $atts Meta attributes. Empty string if no attributes.
 * @return string Return empty string if post type does not support `author` or post has no author assigned.
 *                Return `velox_get_post_author()` if author has no URL.
 *                Otherwise, output for `post_author_link` shortcode.
 */
if ( ! function_exists( 'velox_get_post_author' ) ) :
	function velox_get_post_author( $atts ) {

		if ( ! post_type_supports( get_post_type(), 'author' ) ) {
			return '';
		}

		$defaults = array(
			'after'  => '',
			'before' => '',
			'url'    => 'author',
		);

		$atts = array_replace( $defaults, $atts, 'post_author_link' );

		$author         = get_the_author();
		$author_url     = get_the_author_meta( 'user_url', get_the_author_meta( 'ID' ) );
		$author_archive = get_author_posts_url( get_the_author_meta( 'ID' ) );

		if ( ! $author ) {
			return '';
		}

		$output  = '<span itemprop="author" itemscope="true" itemtype="https://schema.org/Person">';
		$output .= $atts['before'];
		if ( 'author' === $atts['url'] && ! empty( $author_url ) ) {
			$output .= sprintf( '<a href="%s" itemprop="url" rel="author"><span itemprop="name">%s</span></a>', $author_url, esc_html( $author ) );
		} elseif ( 'archive' === $atts['url'] && ! empty( $author_archive ) ) {
			$output .= sprintf( '<a href="%s" itemprop="url" rel="author"><span itemprop="name">%s</span></a>', $author_archive, esc_html( $author ) );
		} elseif ( 'none' === $atts['url'] ) {
			$output .= sprintf( '<span itemprop="name">%s</span>', esc_html( $author ) );
		} else {
			$output .= sprintf( '<span itemprop="name">%s</span>', esc_html( $author ) );
		}
		$output .= $atts['after'];

		return apply_filters( 'velox_get_post_author', $output, $atts );

	}
endif;

/**
 * Produces the link to the current post comments.
 *
 * Supported attributes are:
 *   after (output after link, default is empty string),
 *   before (output before link, default is empty string),
 *   hide_if_off (hide link if comments are off, default is true),
 *   more (text when there is more than 1 comment, use % character as placeholder
 *     for actual number, default is '% Comments')
 *   one (text when there is exactly one comment, default is '1 Comment'),
 *   zero (text when there are no comments, default is 'Leave a Comment').
 *
 * Output passes through `velox_get_post_comments` filter before returning.
 *
 * @param array|string $atts Meta attributes. Empty string if no attributes.
 * @return string Return empty string if post does not support `comments`, or `hide_if_off` is enabled and
 *                comments are closed or disabled in Genesis theme settings.
 *                Otherwise, output for `post_comments` shortcode.
 */
if ( ! function_exists( 'velox_get_post_comments' ) ) :
	function velox_get_post_comments( $atts ) {

		if ( ! post_type_supports( get_post_type(), 'comments' ) ) {
			return '';
		}

		$defaults = array(
			'after'       => '',
			'before'      => '',
			'hide_if_off' => true,
			'more'        => __( '% Comments', 'velox' ),
			'one'         => __( '1 Comment', 'velox' ),
			'zero'        => __( 'Leave a Comment', 'velox' ),
		);

		$atts = array_replace( $defaults, $atts );

		if ( true === $atts['hide_if_off'] && ! comments_open() ) {
			return '';
		}

		// Darn you, WordPress!
		ob_start();
		comments_number( $atts['zero'], $atts['one'], $atts['more'] );
		$comments = ob_get_clean();

		$comments = sprintf( '<a href="%s">%s</a>', get_comments_link(), $comments );

		$output = sprintf( '%s<span class="entry-comments-link">%s</span>%s', $atts['before'], $comments, $atts['after'] );

		return apply_filters( 'velox_get_post_comments', $output, $atts );

	}
endif;

/**
 * Produces the tag links list.
 *
 * Supported attributes are:
 *   after (output after link, default is empty string),
 *   before (output before link, default is 'Tagged With: '),
 *   sep (separator string between tags, default is ', ').
 *
 * Output passes through `velox_get_post_tags` filter before returning.
 *
 * @param array|string $atts Meta attributes. Empty string if no attributes.
 * @return string Return empty string if the `post_tag` taxonomy is not associated with the current post type
 *                or if the post has no tags. Otherwise, output for `post_tags` shortcode.
 */
if ( ! function_exists( 'velox_get_post_tags' ) ) :
	function velox_get_post_tags( $atts ) {

		if ( ! is_object_in_taxonomy( get_post_type(), 'post_tag' ) ) {
			return '';
		}

		$defaults = array(
			'after'  => '',
			'before' => __( 'Tagged: ', 'velox' ),
			'sep'    => ', ',
		);

		$atts = array_replace( $defaults, $atts );

		$tags = get_the_tag_list( $atts['before'], trim( $atts['sep'] ) . ' ', $atts['after'] );

		// Do nothing if no tags.
		if ( ! $tags ) {
			return '';
		}

		$output = '<span class="post-tags">' . $tags . '</span>';

		return apply_filters( 'velox_get_post_tags', $output, $atts );

	}
endif;

/**
 * Produces the category links list.
 *
 * Supported attributes are:
 *   after (output after link, default is empty string),
 *   before (output before link, default is 'Tagged With: '),
 *   sep (separator string between tags, default is ', ').
 *
 * Output passes through 'velox_get_post_categories' filter before returning.
 *
 * @param array|string $atts Meta attributes. Empty string if no attributes.
 * @return string Return empty string if the `category` taxonomy is not associated with the current post type
 *                or if the post has no categories. Otherwise, output for `post_categories` shortcode.
 */
if ( ! function_exists( 'velox_get_post_categories' ) ) :
	function velox_get_post_categories( $atts ) {

		if ( ! is_object_in_taxonomy( get_post_type(), 'category' ) ) {
			return '';
		}

		$defaults = array(
			'sep'    => ', ',
			'before' => __( 'Categories: ', 'velox' ),
			'after'  => '',
		);

		$atts = array_replace( $defaults, $atts );

		$cats = get_the_category_list( trim( $atts['sep'] ) . ' ' );

		// Do nothing if there are no categories.
		if ( ! $cats ) {
			return '';
		}

		$output = $atts['before'] . '<span class="post-categories">' . $cats . '</span>' . $atts['after'];

		return apply_filters( 'velox_get_post_categories', $output, $atts );

	}
endif;
