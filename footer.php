<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Velox
 */

?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer">
		<?php
		if ( is_active_sidebar( 'footer' ) ) :
			?>
			<aside id="secondary" class="widget-area footer-sidebar">
				<?php dynamic_sidebar( 'footer' ); ?>
			</aside><!-- #secondary -->
			<?php
		endif;
		?>
		<div class="site-info">
			<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'velox' ) ); ?>">
				<?php
				/* translators: %s: CMS name, i.e. WordPress. */
				printf( esc_html__( 'Proudly powered by %s', 'velox' ), 'WordPress' );
				?>
			</a>
			<span class="sep"> | </span>
			<?php
				/* translators: 1: Theme name, 2: Theme author. */
				printf( esc_html__( '%1$s Theme by %2$s.', 'velox' ), 'Velox', '<a href="https://davidwolfpaw.com">David Wolfpaw</a>' );
			?>
		</div><!-- .site-info -->

	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>
