<?php
/**
 * Template part for displaying posts with the Audio format
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
				the_title( '<h1 class="entry-title p-name" itemprop="name headline">', '</h1>' );
			else :
				?>
				<h2 class="entry-title p-name" itemprop="name headline"><a href="<?php the_permalink(); ?>" class="u-url url" title="<?php the_title_attribute( array( 'before' => __( 'Permalink to: ', 'velox' ) ) ); ?>" rel="bookmark" itemprop="url"><?php the_title(); ?></a></h2>
				<?php
			endif;

			if ( 'post' === get_post_type() ) :
				?>
			<div class="entry-meta">
				<?php echo velox_get_entry_meta(); ?>
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
		<div class="entry-content e-content" itemprop="description articleBody">
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
		<?php echo velox_get_entry_footer_meta(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->
