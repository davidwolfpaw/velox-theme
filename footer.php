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

	<footer id="colophon" class="site-footer" role="contentinfo">
		<?php
		if ( is_active_sidebar( 'footer' ) ) :
			?>
			<aside id="secondary" class="widget-area footer-sidebar" role="complementary">
				<?php dynamic_sidebar( 'footer' ); ?>
			</aside><!-- #secondary -->
			<?php
		endif;
		?>
		<div class="site-info">
			<?php
			$velox_blog_info = get_bloginfo( 'name' );
			if ( ! empty( $velox_blog_info ) ) :
				?>
				<span class="copyright">&copy; <?php echo esc_html( date_i18n( __( 'Y', 'velox' ) ) ); ?></span> <a class="site-name" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
			<?php endif; ?>
			<?php if ( has_nav_menu( 'footer' ) ) : ?>
				<span class="separator"> | </span>
				<nav id="footer-navigation" class="footer-navigation" aria-label="<?php esc_attr_e( 'Footer Menu', 'velox' ); ?>">
					<h1 class="screen-reader-text section-heading"><a href="#access"><?php esc_html_e( 'Footer Menu', 'velox' ); ?></a></h1>
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


<div class="modal micromodal-slide" id="header-menu" aria-hidden="true">
	<div class="modal-overlay" tabindex="-1" data-micromodal-close="">
		<div id="header-menu-title">Menu</div>
		<div class="modal-container" role="dialog" aria-modal="true">
			<header class="modal-header">
				<button class="modal-close" data-micromodal-close=""> <?php _e( 'Close Menu', 'velox' ); ?></button>
			</header>
			<div class="modal-content" id="header-menu-content">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'primary',
						'menu_id'        => 'primary-menu-modal',
					)
				);
				?>
			</div>
		</div>
	</div>
</div>


<?php wp_footer(); ?>
</body>
</html>
