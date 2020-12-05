<?php
/**
 * Velox functions and definitions
 *
 * @package Velox
 */

if ( ! function_exists( 'velox_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 */
	function velox_setup() {
		/*
		 * Make theme available for translation.
		 */
		load_theme_textdomain( 'velox', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in two locations.
		register_nav_menus(
			array(
				'primary' => esc_html__( 'Primary', 'velox' ),
				'footer'  => esc_html__( 'Footer', 'velox' ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'script',
				'style',
			)
		);

		// Add theme support for Post Formats.
		add_theme_support(
			'post-formats',
			array( 'status', 'quote', 'gallery', 'image', 'video', 'audio', 'link', 'aside', 'chat' )
		);

		// Remove the WordPress core custom header image feature.
		remove_theme_support( 'custom-header' );

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'velox_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 200,
				'width'       => 200,
				'flex-width'  => true,
				'flex-height' => true,
				'header-text' => array(
					'site-title',
					'site-description',
				),
			)
		);

		/**
		 * Add support for Gutenberg editor color palette.
		 *
		 * @link https://wordpress.org/gutenberg/
		 */
		add_theme_support(
			'editor-color-palette',
			array(
				array(

					'name'  => __( 'Text Color', 'velox' ),
					'slug'  => 'text',
					'color' => get_theme_mod( 'text_color', '#1D2731' ),
				),
				array(

					'name'  => __( 'Accent Text Color', 'velox' ),
					'slug'  => 'accent-text',
					'color' => get_theme_mod( 'accent_text_color', '#515962' ),
				),
				array(

					'name'  => __( 'Accent Color', 'velox' ),
					'slug'  => 'accent',
					'color' => get_theme_mod( 'accent_color', '#c31c31' ),
				),
			)
		);

		/**
		 * Add support for block editor wide images.
		 */
		add_theme_support( 'align-wide' );

		/**
		 * Add support for block editor responsive embedded content.
		 */
		add_theme_support( 'responsive-embeds' );

	}
endif;
add_action( 'after_setup_theme', 'velox_setup', 20 );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function velox_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'velox_content_width', 720 );
}
add_action( 'after_setup_theme', 'velox_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function velox_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Header', 'velox' ),
			'id'            => 'header',
			'description'   => esc_html__( 'Displays in the header, below the site title.', 'velox' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer', 'velox' ),
			'id'            => 'footer',
			'description'   => esc_html__( 'Displays in the footer, below the footer menu.', 'velox' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'After Entry', 'velox' ),
			'id'            => 'after-entry',
			'description'   => esc_html__( 'Displays at the end of posts, before comments.', 'velox' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);
}
add_action( 'widgets_init', 'velox_widgets_init' );

/**
 * Registers an editor stylesheet for the theme.
 */
function velox_editor_styles() {
	// Editor styles.
	wp_enqueue_style( 'velox-editor-style', get_template_directory_uri() . '/css/editor-style.css', '1.0.0', 'all' );
}
add_action( 'enqueue_block_editor_assets', 'velox_editor_styles' );

/**
 * Enqueue scripts and styles.
 */
function velox_scripts() {
	// Primary Styles.
	wp_enqueue_style( 'velox-style', get_stylesheet_uri(), array(), '1.0.0', 'all' );

	// Thread comments.
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	// Scripts for the Velox theme.
	wp_enqueue_script( 'velox-scripts', get_template_directory_uri() . '/js/velox-scripts.js', array( 'wp-i18n', 'jquery' ), '1.0.0', true );

	// Pass theme mods to Velox scripts.
	$velox_options = array(
		'night_mode'         => sanitize_key( get_theme_mod( 'night_mode', 'default_light' ) ),
		'read_time'          => (bool) get_theme_mod( 'read_time', true ),
		'progress_bar'       => (bool) get_theme_mod( 'progress_bar', true ),
		'progress_bar_pride' => (bool) get_theme_mod( 'progress_bar_pride', true ),
		'link_color'         => sanitize_hex_color_no_hash( get_theme_mod( 'link_color', '065e88' ) ),
	);
	wp_localize_script( 'velox-scripts', 'velox_options', $velox_options );
	wp_set_script_translations( 'velox-scripts', 'velox' );

}
add_action( 'wp_enqueue_scripts', 'velox_scripts' );

/**
 * Defer loading of scripts.
 *
 * @param string $tag The tag of the source for the script.
 * @param string $handle The handle of the script to check.
 *
 * @return string $tag The call to the script.
 */
function velox_defer_scripts( $tag, $handle ) {

	// The handles of the enqueued scripts we want to defer.
	$defer_scripts = array(
		'comment-reply',
	);

	foreach ( $defer_scripts as $defer_script ) {
		if ( $handle === $defer_script ) {
			return str_replace( ' src', ' defer="defer" src', $tag );
		}
	}

	return $tag;
}
add_filter( 'script_loader_tag', 'velox_defer_scripts', 10, 2 );

if ( ! function_exists( 'wp_body_open' ) ) {

	/**
	 * Shim for wp_body_open, ensuring backward compatibility with versions of WordPress older than 5.2.
	 */
	function wp_body_open() {
		do_action( 'wp_body_open' );
	}
}

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Functions which manage the entry meta.
 */
require get_template_directory() . '/inc/template-meta.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}
