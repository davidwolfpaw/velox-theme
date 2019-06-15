<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Velox
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width" />
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="profile" href="http://microformats.org/profile/specs" />
	<link rel="profile" href="http://microformats.org/profile/hatom" />

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site-wrap">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'velox' ); ?></a>

	<header id="masthead" class="site-header" role="banner">
		<div class="site-header-wrap">
			<div class="site-header-content">
				<div class="site-branding">
					<?php
					// If there is a custom logo, display it.
					if ( has_custom_logo() ) :
						$velox_logo = wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ) );
						?>
						<div class="u-photo photo logo custom-logo-link" itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
							<img itemprop="url" src="<?php echo esc_url( current( $velox_logo ) ); ?>" />
							<meta itemprop="width" content="<?php echo esc_attr( next( $velox_logo ) ); ?>" />
							<meta itemprop="height" content="<?php echo esc_attr( next( $velox_logo ) ); ?>" />
						</div>
						<?php
					endif;
					?>
					<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
					<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
				</div><!-- .site-branding -->

				<?php
				if ( true === get_theme_mod( 'night_mode', true ) ) :
					?>
				<div class="site-options">
					<div id="night-mode"><span class="night-mode-icon"></span></div>
				</div><!-- .site-options -->
					<?php
				endif;
				?>

				<?php
				if ( is_active_sidebar( 'header-right' ) ) :
					?>
					<aside id="secondary" class="widget-area header-right-sidebar" role="complementary">
						<?php dynamic_sidebar( 'header-right' ); ?>
					</aside><!-- #secondary -->
					<?php
				endif;
				?>
			</div>

			<nav id="main-navigation" class="site-navigation" role="navigation">
				<h1 class="screen-reader-text section-heading"><a href="#access" title="<?php esc_attr_e( 'Main menu', 'velox' ); ?>"><?php esc_html_e( 'Main menu', 'velox' ); ?></a></h1>
				<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><span class="menu-icon"></span><span class="menu-icon-text"><?php esc_html_e( 'Menu', 'velox' ); ?></span></button>
				<?php
					wp_nav_menu(
						array(
							'theme_location' => 'primary',
							'menu_id'        => 'primary-menu',
						)
					);
					?>
			</nav><!-- #main-navigation -->
		</div><!-- .site-header-wrap -->
	</header><!-- #masthead -->

	<div id="content" class="site-content">
