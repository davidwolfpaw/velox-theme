<?php
/**
 * Template part for displaying posts with the Image format
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
				<h2 class="entry-title p-name" itemprop="name headline"><a href="<?php the_permalink(); ?>" class="u-url url" title="<?php the_title_attribute( array( 'before' => __( 'Permalink to: ', 'velox' ) ) ); ?>" rel="bookmark" itemprop="url"><?php the_title(); ?></a></h1>
				<?php
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
		<figure class="entry-media">
			<?php the_post_thumbnail( 'post-thumbnail', '' ); ?>
			<figcaption><?php echo get_post( get_post_thumbnail_id() )->post_excerpt; ?></figcaption>
		</figure>
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
		<?php echo do_shortcode( get_theme_mod( 'post_meta_footer', '[post_categories] [post_tags]' ) ); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->
