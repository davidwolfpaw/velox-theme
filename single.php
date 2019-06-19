<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Velox
 */

get_header(); ?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main">

		<?php
		while ( have_posts() ) :

			the_post();

			get_template_part( 'template-parts/content', get_post_format() );

			if ( true === get_theme_mod( 'author_info', true ) ) :
				velox_author_info();
			endif;

			// Previous/next post navigation.
			the_post_navigation(
				array(
					'next_text' => '<span class="navigation-arrow">&rsaquo;</span><span class="meta-nav" aria-hidden="true">' . __( 'Next Post', 'velox' ) . '</span>' .
						'<span class="screen-reader-text">' . __( 'Next post:', 'velox' ) . '</span> <br/>' .
						'<span class="post-title">%title</span>',
					'prev_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Previous Post', 'velox' ) . '</span><span class="navigation-arrow">&lsaquo;</span>' .
						'<span class="screen-reader-text">' . __( 'Previous post:', 'velox' ) . '</span> <br/>' .
						'<span class="post-title">%title</span>',
				)
			);

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.
		?>

		</main><!-- #main -->
	</section><!-- #primary -->

<?php
get_footer();
