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

			get_template_part( 'template-parts/content', get_post_type() );

			if ( true === get_theme_mod( 'author_info', true ) ) :
				?>
				<div class="author-info">
					<div class="author-image">
						<?php echo get_avatar( get_the_author_meta( 'ID' ), 96, 'mysteryman', get_the_author_meta( 'display_name' ) ); ?>
					</div>
					<div class="author-description">
						<h4><?php echo esc_html( get_the_author_meta( 'display_name' ) ); ?></h4>
						<p>
							<?php
							echo wp_kses(
								get_the_author_meta( 'user_description' ),
								array(
									'a'      => array(
										'href'  => array(),
										'title' => array(),
									),
									'br'     => array(),
									'em'     => array(),
									'strong' => array(),
								)
							);
							?>
							</p>
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
get_sidebar();
get_footer();
