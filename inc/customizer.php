<?php
/**
 * Velox Theme Customizer
 *
 * @package Velox
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function velox_customize_register( $wp_customize ) {
	// Change some setting defaults.
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'background_color' )->transport = 'postMessage';
	$wp_customize->get_setting( 'background_color' )->default   = '#FFFFFF';

	// Text color.
	$wp_customize->add_setting(
		'text_color',
		array(
			'default'           => '#1D2731',
			'sanitize_callback' => 'velox_sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'text_color',
			array(
				'section' => 'colors',
				'label'   => esc_html__( 'Text Color', 'velox' ),
			)
		)
	);

	// Accent Text color.
	$wp_customize->add_setting(
		'accent_text_color',
		array(
			'default'           => '#515962',
			'sanitize_callback' => 'velox_sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'accent_text_color',
			array(
				'section' => 'colors',
				'label'   => esc_html__( 'Accent Text Color', 'velox' ),
			)
		)
	);

	// Accent color.
	$wp_customize->add_setting(
		'accent_color',
		array(
			'default'           => '#c31c31',
			'sanitize_callback' => 'velox_sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'accent_color',
			array(
				'section' => 'colors',
				'label'   => esc_html__( 'Accent Color', 'velox' ),
			)
		)
	);

	// Link Color.
	$wp_customize->add_setting(
		'link_color',
		array(
			'default'           => '#065e88',
			'sanitize_callback' => 'velox_sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'link_color',
			array(
				'section' => 'colors',
				'label'   => esc_html__( 'Link Color', 'velox' ),
			)
		)
	);

	// Link Active/Hover/Focus Color.
	$wp_customize->add_setting(
		'link_active_color',
		array(
			'default'           => '#c31c31',
			'sanitize_callback' => 'velox_sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'link_active_color',
			array(
				'section' => 'colors',
				'label'   => esc_html__( 'Link Active/Hover/Focus Color', 'velox' ),
			)
		)
	);

	// Section: Velox Options.
	$wp_customize->add_section(
		'velox_theme_settings',
		array(
			'priority'   => 40,
			'title'      => __( 'Velox Theme Settings', 'velox' ),
			'capability' => 'edit_theme_options',
		)
	);

	// Setting: Font Pairing.
	$wp_customize->add_setting(
		'font_pairing',
		array(
			'capability'        => 'edit_theme_options',
			'default'           => 'librefranklin_sourceserifpro',
			'sanitize_callback' => 'velox_sanitize_select',
			'transport'         => 'refresh',
		)
	);

	// Control: Font Pairing.
	$wp_customize->add_control(
		'font_pairing',
		array(
			'label'       => __( 'Font Pairing', 'velox' ),
			'description' => __( 'Pairings of fonts for headings and body content.', 'velox' ),
			'section'     => 'velox_theme_settings',
			'type'        => 'select',
			'choices'     => array(
				'librefranklin_sourceserifpro' => 'Libre Franklin / Source Serif Pro',
				'rubik_robotomono'             => 'Rubik / Roboto Mono',
				'ovo_muli'                     => 'Ovo / Muli',
				'nixieone_librebaskerville'    => 'Nixie One / Libre Baskerville',
			),
		)
	);

	// Setting: Night Mode.
	$wp_customize->add_setting(
		'night_mode',
		array(
			'capability'        => 'edit_theme_options',
			'default'           => 'default_light',
			'sanitize_callback' => 'velox_sanitize_select',
			'transport'         => 'refresh',
		)
	);

	// Control: Night Mode.
	$wp_customize->add_control(
		'night_mode',
		array(
			'label'       => __( 'Night Mode', 'velox' ),
			'description' => __( 'Allow a night mode setting to be active for visitors to your site to change to a darker page style.', 'velox' ),
			'section'     => 'velox_theme_settings',
			'type'        => 'select',
			'choices'     => array(
				'default_light' => __( 'Default Light Mode', 'velox' ),
				'default_dark'  => __( 'Default Dark Mode', 'velox' ),
				'no_toggle'     => __( 'No Dark Mode Toggle', 'velox' ),
			),
		)
	);

	// Setting: Read Time.
	$wp_customize->add_setting(
		'read_time',
		array(
			'capability'        => 'edit_theme_options',
			'default'           => true,
			'sanitize_callback' => 'velox_sanitize_checkbox',
			'transport'         => 'refresh',
		)
	);

	// Control: Read Time.
	$wp_customize->add_control(
		'read_time',
		array(
			'label'       => __( 'Read Time', 'velox' ),
			'description' => __( 'Display an estimate of time to read posts.', 'velox' ),
			'section'     => 'velox_theme_settings',
			'type'        => 'checkbox',
		)
	);

	// Setting: Article Progress Bar.
	$wp_customize->add_setting(
		'progress_bar',
		array(
			'capability'        => 'edit_theme_options',
			'default'           => true,
			'sanitize_callback' => 'velox_sanitize_checkbox',
			'transport'         => 'refresh',
		)
	);

	// Control: Article Progress Bar.
	$wp_customize->add_control(
		'progress_bar',
		array(
			'label'       => __( 'Article Progress Bar', 'velox' ),
			'description' => __( 'Display a progress bar for post length.', 'velox' ),
			'section'     => 'velox_theme_settings',
			'type'        => 'checkbox',
		)
	);

	// Setting: Article Progress Bar Pride Colors.
	$wp_customize->add_setting(
		'progress_bar_pride',
		array(
			'capability'        => 'edit_theme_options',
			'default'           => true,
			'sanitize_callback' => 'velox_sanitize_checkbox',
			'transport'         => 'refresh',
		)
	);

	// Control: Article Progress Bar.
	$wp_customize->add_control(
		'progress_bar_pride',
		array(
			'label'       => __( 'Pride Article Progress Bar', 'velox' ),
			'description' => __( 'Display LGBTQIA+ pride flag as progress bar.', 'velox' ),
			'section'     => 'velox_theme_settings',
			'type'        => 'checkbox',
		)
	);

	// Setting: Author Info.
	$wp_customize->add_setting(
		'author_info',
		array(
			'capability'        => 'edit_theme_options',
			'default'           => true,
			'sanitize_callback' => 'velox_sanitize_checkbox',
			'transport'         => 'refresh',
		)
	);

	// Control: Author Info.
	$wp_customize->add_control(
		'author_info',
		array(
			'label'       => __( 'Author Info', 'velox' ),
			'description' => __( 'Display author information on posts.', 'velox' ),
			'section'     => 'velox_theme_settings',
			'type'        => 'checkbox',
		)
	);

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'blogname',
			array(
				'selector'        => '.site-title a',
				'render_callback' => 'velox_customize_partial_blogname',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'blogdescription',
			array(
				'selector'        => '.site-description',
				'render_callback' => 'velox_customize_partial_blogdescription',
			)
		);
	}

}
add_action( 'customize_register', 'velox_customize_register' );


/**
 * Sanitize color callbacks
 *
 * @see sanitize_hex_color() https://developer.wordpress.org/reference/functions/sanitize_hex_color/
 *
 * @param string               $hex_color HEX color to sanitize.
 * @param WP_Customize_Setting $setting   Setting instance.
 * @return string The sanitized hex color if not null; otherwise, the setting default.
 */
function velox_sanitize_hex_color( $hex_color, $setting ) {
	// Sanitize $input as a hex value without the hash prefix.
	$hex_color = sanitize_hex_color( $hex_color );

	// If $input is a valid hex value, return it; otherwise, return the default.
	return ( ! is_null( $hex_color ) ? $hex_color : $setting->default );
}

/**
 * Sanitize checkbox callbacks
 *
 * @param bool $checked whether it is checked or not.
 * @return checked
 */
function velox_sanitize_checkbox( $checked ) {
	// Boolean check.
	return ( ( isset( $checked ) && true === $checked ) ? true : false );
}

/**
 * Sanitize radio callbacks
 *
 * @param string $input radio input values.
 * @param object $setting parameters.
 * @return input
 */
function velox_sanitize_radio( $input, $setting ) {
	// Input must be a slug: lowercase alphanumeric characters, dashes and underscores are allowed only.
	$input = sanitize_key( $input );

	// Get the list of possible radio box options.
	$choices = $setting->manager->get_control( $setting->id )->choices;

	// Return input if valid or return default option.
	return ( array_key_exists( $input, $choices ) ? $input : $setting->default );

}

/**
 * Sanitize select callbacks
 *
 * @param string $input select input values.
 * @param object $setting parameters.
 * @return input
 */
function velox_sanitize_select( $input, $setting ) {
	// Input must be a slug: lowercase alphanumeric characters, dashes and underscores are allowed only.
	$input = sanitize_key( $input );

	// Get the list of possible select options.
	$choices = $setting->manager->get_control( $setting->id )->choices;

	// Return input if valid or return default option.
	return ( array_key_exists( $input, $choices ) ? $input : $setting->default );

}

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function velox_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function velox_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function velox_customize_preview_js() {
	wp_enqueue_script( 'velox-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'jquery', 'customize-preview' ), '20180405', true );
}
add_action( 'customize_preview_init', 'velox_customize_preview_js' );

/**
 * Apply customizer colors
 * Applies pride bar if selected
 */
function velox_customizer_css() {
	?>
	<style type="text/css">
		body, button, input, select, optgroup, textarea, h1, h2, h3, h4, h5, h6 { color: <?php echo esc_html( get_theme_mod( 'text_color', '#1D2731' ) ); ?>; }
		.entry-footer, .entry-meta, .wp-block-image figcaption, .wp-block-pullquote cite, .wp-block-latest-posts__post-date, .wp-caption-text { color: <?php echo esc_html( get_theme_mod( 'accent_text_color', '#515962' ) ); ?>; }
		.wp-block-button__link { background-color: <?php echo esc_html( get_theme_mod( 'link_color', '#065e88' ) ); ?>; }
		.wp-block-button__link:hover, .wp-block-button__link:active, .wp-block-button__link:focus, .hentry .entry-content a.wp-block-button__link:hover, .hentry .entry-content a.wp-block-button__link:active, .hentry .entry-content a.wp-block-button__link:focus {	background-color: <?php echo esc_html( get_theme_mod( 'link_active_color', '#065e88' ) ); ?>; }
		.hentry .entry-content a { border-bottom-color: <?php echo esc_html( get_theme_mod( 'link_color', '#065e88' ) ); ?>; box-shadow: inset 0 -2px 0 <?php echo esc_html( get_theme_mod( 'link_color', '#065e88' ) ); ?>; }
		.hentry .entry-content a:hover, .hentry .entry-content a:focus, .hentry .entry-content a:active, .hentry .wp-block-image a:active, .hentry .wp-block-image a:focus, .hentry .wp-block-image a:hover, .hentry .wp-block-gallery a:active, .hentry .wp-block-gallery a:focus, .hentry .wp-block-gallery a:hover {	background-color: <?php echo esc_html( get_theme_mod( 'link_color', '#065e88' ) ); ?>; border-bottom: 1px solid <?php echo esc_html( get_theme_mod( 'link_color', '#065e88' ) ); ?>; box-shadow: inset 0 -2px 0 <?php echo esc_html( get_theme_mod( 'link_color', '#065e88' ) ); ?>; }
		hr, hr.wp-block-separator, .progress-bar, button, input[type="button"], input[type="reset"], input[type="submit"], .wp-block-button .wp-block-button__link { background-color: <?php echo esc_html( get_theme_mod( 'accent_color', '#c31c31' ) ); ?>; }
		.wp-block-separator.is-style-dots:before { color: <?php echo esc_html( get_theme_mod( 'accent_color', '#c31c31' ) ); ?>; }
		.comment-navigation, .after-entry-sidebar, .posts-navigation, .post-navigation, .entry-footer, .author-info, hr, .wp-block-separator { border-bottom-color: <?php echo esc_html( get_theme_mod( 'accent_color', '#c31c31' ) ); ?>; }
		.wp-block-pullquote { border-top-color: <?php echo esc_html( get_theme_mod( 'accent_color', '#c31c31' ) ); ?>; border-bottom-color: <?php echo esc_html( get_theme_mod( 'accent_color', '#c31c31' ) ); ?>; }
		.navigation .nav-previous { border-right-color: <?php echo esc_html( get_theme_mod( 'accent_color', '#c31c31' ) ); ?>; }
		q, blockquote, .wp-block-quote:not(.is-large) { border-left-color: <?php echo esc_html( get_theme_mod( 'accent_color', '#c31c31' ) ); ?>; }
		a, a:visited { color: <?php echo esc_html( get_theme_mod( 'link_color', '#065e88' ) ); ?>; }
		#main-navigation a:hover, #main-navigation a:focus { background-color: <?php echo esc_html( get_theme_mod( 'link_color', '#065e88' ) ); ?>; }
		.has-text-color { color: <?php echo esc_html( get_theme_mod( 'text_color', '#1D2731' ) ); ?>; }
		.has-text-background-color { background-color: <?php echo esc_html( get_theme_mod( 'text_color', '#1D2731' ) ); ?>; }
		.has-accent-text-color { color: <?php echo esc_html( get_theme_mod( 'accent_text_color', '#515962' ) ); ?>; }
		.has-accent-text-background-color { background-color: <?php echo esc_html( get_theme_mod( 'accent_text_color', '#515962' ) ); ?>; }
		.has-accent-color { color: <?php echo esc_html( get_theme_mod( 'accent_color', '#c31c31' ) ); ?>; }
		.has-accent-background-color { background-color: <?php echo esc_html( get_theme_mod( 'accent_color', '#c31c31' ) ); ?>; }
	</style>
	<?php
}
add_action( 'wp_head', 'velox_customizer_css' );

/**
 * Apply customizer colors
 * Applies pride bar if selected
 */
function velox_customizer_admin_css() {
	?>
	<style type="text/css">
		body.wp-admin .editor-styles-wrapper { background-color: #<?php echo esc_html( get_theme_mod( 'background_color', '#FFFFFF' ) ); ?>; }
		.wp-admin .editor-styles-wrapper, .wp-admin .editor-post-title__block .editor-post-title__input, .wp-admin .editor-styles-wrapper h1, .wp-admin .editor-styles-wrapper h2, .wp-admin .editor-styles-wrapper h3, .wp-admin .editor-styles-wrapper h4, .wp-admin .editor-styles-wrapper h5, .wp-admin .editor-styles-wrapper h6, .wp-admin .editor-styles-wrapper textarea, .wp-admin .editor-styles-wrapper .wp-block-quote__citation, .wp-admin .editor-styles-wrapper .wp-block-quote cite, .wp-admin .editor-styles-wrapper .wp-block-quote footer { color: <?php echo esc_html( get_theme_mod( 'text_color', '#1D2731' ) ); ?>; }
		.wp-admin .editor-styles-wrapper .wp-block-image figcaption, .wp-admin .editor-styles-wrapper .wp-block-pullquote cite, .wp-admin .editor-styles-wrapper .wp-block-pullquote .wp-block-pullquote__citation, .wp-admin .editor-styles-wrapper .wp-block-latest-posts__post-date, .wp-admin .editor-styles-wrapper .wp-caption-text { color: <?php echo esc_html( get_theme_mod( 'accent_text_color', '#515962' ) ); ?>; }
		.wp-admin .editor-styles-wrapper .wp-block-button__link { background-color: <?php echo esc_html( get_theme_mod( 'link_color', '#065e88' ) ); ?>; }
		.wp-admin .editor-styles-wrapper .wp-block-button__link:hover, .wp-admin .editor-styles-wrapper .wp-block-button__link:active, .wp-admin .editor-styles-wrapper .wp-block-button__link:focus, .wp-admin .editor-styles-wrapper .hentry .entry-content a.wp-block-button__link:hover, .wp-admin .editor-styles-wrapper .hentry .entry-content a.wp-block-button__link:active, .wp-admin .editor-styles-wrapper .hentry .entry-content a.wp-block-button__link:focus {	background-color: <?php echo esc_html( get_theme_mod( 'link_active_color', '#065e88' ) ); ?>; }
		.wp-admin .editor-styles-wrapper a { border-bottom-color: <?php echo esc_html( get_theme_mod( 'link_color', '#065e88' ) ); ?>; box-shadow: inset 0 -2px 0 <?php echo esc_html( get_theme_mod( 'link_color', '#065e88' ) ); ?>; }
		.wp-admin .editor-styles-wrapper a:hover, .wp-admin .editor-styles-wrapper a:focus, .wp-admin .editor-styles-wrapper a:active, .wp-admin .editor-styles-wrapper .wp-block-image a:active, .wp-admin .editor-styles-wrapper .wp-block-image a:focus, .wp-admin .editor-styles-wrapper .wp-block-image a:hover, .wp-admin .editor-styles-wrapper .wp-block-gallery a:active, .wp-admin .editor-styles-wrapper .wp-block-gallery a:focus, .wp-admin .editor-styles-wrapper .wp-block-gallery a:hover {	background-color: <?php echo esc_html( get_theme_mod( 'link_active_color', '#065e88' ) ); ?>; border-bottom: 1px solid <?php echo esc_html( get_theme_mod( 'link_active_color', '#065e88' ) ); ?>; box-shadow: inset 0 -2px 0 <?php echo esc_html( get_theme_mod( 'link_active_color', '#065e88' ) ); ?>; }
		.wp-admin .editor-styles-wrapper hr, .wp-admin .editor-styles-wrapper hr.wp-block-separator, .wp-admin .editor-styles-wrapper button:not(.components-button), .wp-admin .editor-styles-wrapper input[type="button"], .wp-admin .editor-styles-wrapper input[type="reset"], .wp-admin .editor-styles-wrapper input[type="submit"], .wp-admin .editor-styles-wrapper .wp-block-button .wp-block-button__link { background-color: <?php echo esc_html( get_theme_mod( 'accent_color', '#c31c31' ) ); ?>; }
		.wp-admin .editor-styles-wrapper .wp-block-separator.is-style-dots:before { color: <?php echo esc_html( get_theme_mod( 'accent_color', '#c31c31' ) ); ?>; }
		.wp-admin .editor-styles-wrapper hr, .wp-admin .editor-styles-wrapper .wp-block-separator { border-bottom-color: <?php echo esc_html( get_theme_mod( 'accent_color', '#c31c31' ) ); ?>; }
		.wp-admin .editor-styles-wrapper .wp-block-pullquote { border-top-color: <?php echo esc_html( get_theme_mod( 'accent_color', '#c31c31' ) ); ?>; border-bottom-color: <?php echo esc_html( get_theme_mod( 'accent_color', '#c31c31' ) ); ?>; }
		.wp-admin .editor-styles-wrapper .wp-block-quote:not(.is-large) { border-left-color: <?php echo esc_html( get_theme_mod( 'accent_color', '#c31c31' ) ); ?>; }
		.wp-admin .editor-styles-wrapper a, .wp-admin .editor-styles-wrapper a:visited { color: <?php echo esc_html( get_theme_mod( 'link_color', '#065e88' ) ); ?>; }
	</style>
	<?php
}
add_action( 'admin_head', 'velox_customizer_admin_css' );

/**
 * Apply customizer fonts
 */
function velox_font_families() {
	// Get the fonts that the site uses from theme settings.
	$font_selection = get_theme_mod( 'font_pairing', 'librefranklin_sourceserifpro' );

	if ( 'librefranklin_sourceserifpro' === $font_selection ) {
		$heading_font   = 'Libre Franklin Bold';
		$heading_slug   = 'libre-franklin-v3-latin-700';
		$heading_weight = '700';
		$body_font      = 'Source Serif Pro';
		$body_slug      = 'source-serif-pro-v7-latin-regular';
		$body_weight    = '400';
	} elseif ( 'rubik_robotomono' === $font_selection ) {
		$heading_font   = 'Rubik';
		$heading_slug   = 'rubik-v8-latin-500';
		$heading_weight = '500';
		$body_font      = 'Roboto Mono';
		$body_slug      = 'roboto-mono-v6-latin-regular';
		$body_weight    = '400';
	} elseif ( 'ovo_muli' === $font_selection ) {
		$heading_font   = 'Ovo';
		$heading_slug   = 'ovo-v11-latin-regular';
		$heading_weight = '400';
		$body_font      = 'Muli';
		$body_slug      = 'muli-v13-latin-regular';
		$body_weight    = '400';
	} elseif ( 'nixieone_librebaskerville' === $font_selection ) {
		$heading_font   = 'Nixie One';
		$heading_slug   = 'nixie-one-v10-latin-regular';
		$heading_weight = '400';
		$body_font      = 'Libre Baskerville';
		$body_slug      = 'libre-baskerville-v6-latin-regular';
		$body_weight    = '400';
	} else {
		$heading_font   = 'Libre Franklin Bold';
		$heading_slug   = 'libre-franklin-v3-latin-700';
		$heading_weight = '700';
		$body_font      = 'Source Serif Pro';
		$body_slug      = 'source-serif-pro-v7-latin-regular';
		$body_weight    = '400';
	}

	$font_dir    = get_template_directory_uri() . '/fonts';
	$heading_url = esc_url_raw( $font_dir . '/' . $heading_slug . '/' . $heading_slug );
	$body_url    = esc_url_raw( $font_dir . '/' . $body_slug . '/' . $body_slug );

	$font_styles = array(
		'heading_font'   => $heading_font,
		'heading_weight' => $heading_weight,
		'heading_url'    => $heading_url,
		'body_font'      => $body_font,
		'body_weight'    => $body_weight,
		'body_url'       => $body_url,
	);

	return $font_styles;
}

/**
 * Apply customizer fonts to frontend
 */
function velox_frontend_fonts() {
	$font_styles = velox_font_families();

	if ( ! empty( $font_styles ) ) {
		$font_css = "
		@font-face {
			font-family: {$font_styles['heading_font']};
			src:url('{$font_styles['heading_url']}.woff2') format('woff2'),
		    	url('{$font_styles['heading_url']}.woff') format('woff');
			font-weight: {$font_styles['heading_weight']};

		}
		@font-face {
			font-family: {$font_styles['body_font']};
			src:url('{$font_styles['body_url']}.woff2') format('woff2'),
		    	url('{$font_styles['body_url']}.woff') format('woff');
			font-weight: {$font_styles['body_weight']};
		}
		body, button, input, select, optgroup, textarea {
			font-family: '{$font_styles['body_font']}',-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Oxygen-Sans,Ubuntu,Cantarell,'Helvetica Neue',sans-serif;
			font-weight: {$font_styles['body_weight']};
		}
		h1, h2, h3, h4, h5, h6 {
			font-family: '{$font_styles['heading_font']}',-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Oxygen-Sans,Ubuntu,Cantarell,'Helvetica Neue',sans-serif;
			font-weight: {$font_styles['heading_weight']};
		}
		";

		// Add inline style to use the selected fonts.
		wp_add_inline_style( 'velox-style', $font_css );
	}
}
add_action( 'wp_enqueue_scripts', 'velox_frontend_fonts' );

/**
 * Apply customizer fonts to block editor
 */
function velox_block_editor_fonts() {
	$font_styles = velox_font_families();

	if ( ! empty( $font_styles ) ) {
		$font_css = "<style>
		@font-face {
			font-family: {$font_styles['heading_font']};
			src:url('{$font_styles['heading_url']}.woff2') format('woff2'),
		    	url('{$font_styles['heading_url']}.woff') format('woff');
			font-weight: {$font_styles['heading_weight']};

		}
		@font-face {
			font-family: {$font_styles['body_font']};
			src:url('{$font_styles['body_url']}.woff2') format('woff2'),
		    	url('{$font_styles['body_url']}.woff') format('woff');
			font-weight: {$font_styles['body_weight']};
		}
		body.wp-admin .editor-styles-wrapper,
		.wp-admin .editor-styles-wrapper button:not(.components-button),
		.wp-admin .editor-styles-wrapper input,
		.wp-admin .editor-styles-wrapper select,
		.wp-admin .editor-styles-wrapper optgroup,
		.wp-admin .editor-styles-wrapper textarea {
			font-family: '{$font_styles['body_font']}',-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Oxygen-Sans,Ubuntu,Cantarell,'Helvetica Neue',sans-serif;
			font-weight: {$font_styles['body_weight']};
		}
		.wp-admin .editor-styles-wrapper h1,
		.wp-admin .editor-styles-wrapper h2,
		.wp-admin .editor-styles-wrapper h3,
		.wp-admin .editor-styles-wrapper h4,
		.wp-admin .editor-styles-wrapper h5,
		.wp-admin .editor-styles-wrapper h6,
		.wp-admin .editor-post-title__block .editor-post-title__input {
			font-family: '{$font_styles['heading_font']}',-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Oxygen-Sans,Ubuntu,Cantarell,'Helvetica Neue',sans-serif;
			font-weight: {$font_styles['heading_weight']};
		}
		</style>";
		echo $font_css;
	}
}
add_action( 'admin_head', 'velox_block_editor_fonts' );
