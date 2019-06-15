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
			<div id="site-publisher" itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
				<meta itemprop="name" content="<?php echo esc_url( get_bloginfo( 'name', 'display' ) ); ?>" />
				<meta itemprop="url" content="<?php echo esc_url( home_url( '/' ) ); ?>" />
			</div>
			<?php
			$blog_info = get_bloginfo( 'name' );
			if ( ! empty( $blog_info ) ) :
				?>
				<span class="copyright">&copy; <?php echo esc_html( date( 'Y' ) ); ?></span> <a class="site-name" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
			<?php endif; ?>
			<?php if ( has_nav_menu( 'footer' ) ) : ?>
				<span class="separator"> | </span>
				<nav id="footer-navigation" class="footer-navigation" aria-label="<?php esc_attr_e( 'Footer Menu', 'velox' ); ?>">
					<h1 class="screen-reader-text section-heading"><a href="#access" title="<?php esc_attr_e( 'Footer Menu', 'velox' ); ?>"><?php esc_html_e( 'Footer Menu', 'velox' ); ?></a></h1>
					<?php
					if ( function_exists( 'the_privacy_policy_link' ) ) {
						the_privacy_policy_link();
					}
					wp_nav_menu(
						array(
							'theme_location' => 'footer',
							'menu_class'     => 'footer-menu',
							'menu_id'        => 'footer-menu',
							'depth'          => 1,
							'container'      => '',
						)
					);
					?>
				</nav><!-- .footer-navigation -->
			<?php endif; ?>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>
