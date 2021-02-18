<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Velox
 */

if ( ! function_exists( 'velox_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function velox_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf(
			$time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			/* translators: %s: post date. */
			esc_html_x( 'Posted on %s', 'post date', 'velox' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		echo '<span class="posted-on">' . $posted_on . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	}
endif;

if ( ! function_exists( 'velox_posted_by' ) ) :
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function velox_posted_by() {
		$byline = sprintf(
			/* translators: %s: post author. */
			esc_html_x( 'by %s', 'post author', 'velox' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="byline"> ' . $byline . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	}
endif;

if ( ! function_exists( 'velox_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function velox_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'velox' ) );
			if ( $categories_list ) {
				/* translators: 1: list of categories. */
				printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'velox' ) . '</span>', $categories_list ); // WPCS: XSS OK.
			}

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'velox' ) );
			if ( $tags_list ) {
				/* translators: 1: list of tags. */
				printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'velox' ) . '</span>', $tags_list ); // WPCS: XSS OK.
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link(
				sprintf(
					wp_kses(
						/* translators: %s: post title */
						__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'velox' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				)
			);
			echo '</span>';
		}

		edit_post_link(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Edit <span class="screen-reader-text">%s</span>', 'velox' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
endif;

if ( ! function_exists( 'velox_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function velox_post_thumbnail() {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}

		if ( is_singular() ) :
			?>

		<div class="post-thumbnail">
			<?php the_post_thumbnail(); ?>
		</div><!-- .post-thumbnail -->

		<?php else : ?>

		<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
			<?php
				the_post_thumbnail(
					'post-thumbnail',
					array(
						'alt' => the_title_attribute(
							array(
								'echo' => false,
							)
						),
					)
				);
			?>
		</a>

			<?php
		endif; // End is_singular().
	}
endif;

if ( ! function_exists( 'velox_categories' ) ) :
	/**
	 * Prints HTML with categories for the current post
	 */
	function velox_categories() {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ', ', 'velox' ) );
		if ( $categories_list ) {
			/* translators: 1: list of categories. */
			echo '<span class="cat-links"><span class="screen-reader-text">' . esc_html_x( 'Posted in', 'blog category', 'velox' ) . '</span> ' . $categories_list . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
	}
endif;

if ( ! function_exists( 'velox_author_info' ) ) :
	/**
	 * Prints HTML with author info for archives and posts
	 */
	function velox_author_info() {
		?>
		<div class="author-info author vcard h-card" itemprop="author" itemscope itemtype="http://schema.org/Person">
			<div class="author-image">
				<?php echo get_avatar( get_the_author_meta( 'ID' ), 72, 'mysteryman', get_the_author_meta( 'display_name' ) ); ?>
			</div>
			<div class="author-description">
				<?php if ( ! is_archive() ) { ?>
					<a class="url u-url fn p-fn n p-name" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="me author" itemprop="url">
						<span itemprop="name"><?php echo get_the_author(); ?></span>
					</a>
				<?php } ?>
				<?php if ( get_the_author_meta( 'description' ) ) { ?>
					<div class="author-note note p-note" itemprop="description">
						<p><?php echo wp_kses( get_the_author_meta( 'description' ), null ); ?></p>
					</div>
				<?php } ?>
			</div>
		</div><!-- .author-info -->
		<?php
	}
endif;

