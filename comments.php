<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Velox
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php
	// You can start editing here -- including this comment!
	if ( have_comments() ) :
		?>
		<h2 class="comments-title">
			<?php
			$velox_comment_count = get_comments_number();
			if ( '1' === $velox_comment_count ) {
				printf(
					/* translators: 1: title. */
					esc_html__( 'One comment on &ldquo;%1$s&rdquo;', 'velox' ),
					'<span>' . esc_html( get_the_title() ) . '</span>'
				);
			} else {
				printf( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					/* translators: 1: comment count number, 2: title. */
					esc_html( _nx( '%1$s comment on &ldquo;%2$s&rdquo;', '%1$s comments on &ldquo;%2$s&rdquo;', $velox_comment_count, 'comments title', 'velox' ) ),
					number_format_i18n( $velox_comment_count ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					'<span>' . esc_html( get_the_title() ) . '</span>'
				);
			}
			?>
		</h2><!-- .comments-title -->

		<h1 class="screen-reader-text section-heading"><?php esc_html_e( 'Comment navigation', 'velox' ); ?></h1>
		<?php the_comments_navigation(); ?>

		<ol class="comment-list">
			<?php
				wp_list_comments(
					array(
						'walker'      => new Velox_Walker_Comment(),
						'avatar_size' => 48,
						'style'       => 'ol',
						'short_ping'  => true,
						'format'      => 'html5',
					)
				);
			?>
		</ol><!-- .comment-list -->

		<?php
		the_comments_navigation();

		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() ) :
			?>
			<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'velox' ); ?></p>
			<?php
		endif;

	endif; // Check for have_comments().

	comment_form( array( 'format' => 'html5' ) );
	?>

</div><!-- #comments -->
