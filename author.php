<?php
/**
 * The template for displaying author archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Velox
 */

get_header(); ?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main">

		<?php if ( have_posts() ) : ?>

			<?php
			/* Queue the first post, that way we know
			 * what author we're dealing with (if that is the case).
			 *
			 * We reset this later so we can run the loop
			 * properly with a call to rewind_posts().
			 */
			the_post();
			?>

			<header class="page-header author vcard h-card" itemprop="author" itemscope itemtype="http://schema.org/Person">
				<h1 class="page-title">
					<?php esc_html_e( 'Author Archives: ', 'velox' ); ?>
					<a class="url u-url fn p-fn n p-name" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" title="<?php echo get_the_author(); ?>" rel="me author" itemprop="url">
						<span itemprop="name"><?php echo get_the_author(); ?></span>
					</a>
				</h1>
				<?php echo get_avatar( get_the_author_meta( 'ID' ), 60 ); ?>
				<?php if ( get_the_author_meta( 'description' ) ) { ?>
					<div class="author-note note p-note" itemprop="description">
						<p><?php echo wp_kses( get_the_author_meta( 'description' ), null ); ?></p>
					</div>
				<?php } ?>
			</header>

			<?php
			/* Since we called the_post() above, we need to
			 * rewind the loop back to the beginning that way
			 * we can run the loop properly, in full.
			 */
			rewind_posts();

			/* Start the Loop */
			while ( have_posts() ) :

				the_post();

				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				get_template_part( 'template-parts/content', get_post_format() );

			endwhile;

			the_posts_navigation();
			?>

		<?php else : ?>

			<?php get_template_part( 'template-parts/content', 'none' ); ?>

		<?php endif; ?>

		</main><!-- #main -->
	</section><!-- #primary -->

<?php
get_footer();
