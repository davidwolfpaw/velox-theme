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
				?>
				<div class="author-info author vcard h-card" itemprop="author" itemscope itemtype="http://schema.org/Person">
					<div class="author-image">
						<?php echo get_avatar( get_the_author_meta( 'ID' ), 96, 'mysteryman', get_the_author_meta( 'display_name' ) ); ?>
					</div>
					<div class="author-description">
						<a class="url u-url fn p-fn n p-name" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" title="<?php echo get_the_author(); ?>" rel="me author" itemprop="url">
							<span itemprop="name"><?php echo get_the_author(); ?></span>
						</a>
						<?php if ( get_the_author_meta( 'description' ) ) { ?>
							<div class="author-note note p-note" itemprop="description">
								<p><?php echo wp_kses( get_the_author_meta( 'description' ), null ); ?></p>
							</div>
						<?php } ?>
					</div>
				</div><!-- .author-info -->
				<?php
			endif;

			the_post_navigation();

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
