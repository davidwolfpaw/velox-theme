<?php
/**
 * Template part for displaying posts with the Gallery format
 *
 * @link http://codex.wordpress.org/Post_Formats
 *
 * @package Velox
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php velox_post_thumbnail(); ?>

		<div class="entry-header-content">
			<?php
			if ( is_singular() ) :
				the_title( '<h1 class="entry-title">', '</h1>' );
			else :
				the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			endif;

			if ( 'post' === get_post_type() ) :
				?>
			<div class="entry-meta">
				<?php echo do_shortcode( get_theme_mod( 'post_meta_header', 'Posted on [post_date]' ) ); ?>
			</div><!-- .entry-meta -->
				<?php
			endif;
			?>
		</div>
	</header><!-- .entry-header -->

	<?php if ( is_search() ) : // Only display Excerpts for search pages ?>
		<div class="entry-summary p-summary" itemprop="description">
			<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->
	<?php else : ?>
		<div class="entry-content e-content" itemprop="description">
			<?php
				the_content(
					sprintf(
						wp_kses(
							/* translators: %s: Name of current post. Only visible to screen readers */
							__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'velox' ),
							array(
								'span' => array(
									'class' => array(),
								),
							)
						),
						get_the_title()
					)
				);

				wp_link_pages(
					array(
						'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'velox' ),
						'after'  => '</div>',
					)
				);
			?>
		</div><!-- .entry-content -->
	<?php endif; ?>

	<footer class="entry-footer">
		<?php echo do_shortcode( get_theme_mod( 'post_meta_footer', '[post_categories] [post_tags]' ) ); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->