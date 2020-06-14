<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Velox
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php
		while ( have_posts() ) :

			the_post();

			get_template_part( 'template-parts/content', get_post_format() );

			if ( true === get_theme_mod( 'author_info', true ) ) :
				velox_author_info();
			endif;



			if ( is_active_sidebar( 'after-entry' ) ) {
				?>
				<div class="after-entry-sidebar">
					<?php dynamic_sidebar( 'after-entry' ); ?>
				</div>
				<?php
			}

			// Previous/next post navigation.
			the_post_navigation(
				array(
					'next_text' => '<span class="navigation-arrow" aria-hidden="true">&rsaquo;</span><span class="meta-nav">' . __( 'Next Post', 'velox' ) . '</span>' .
						'<br/>' .
						'<span class="post-title">%title</span>',
					'prev_text' => '<span class="meta-nav">' . __( 'Previous Post', 'velox' ) . '</span><span class="navigation-arrow" aria-hidden="true">&lsaquo;</span>' .
						'<br/>' .
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
	</div><!-- #primary -->

<?php
get_footer();
