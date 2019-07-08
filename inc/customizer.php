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
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->default   = '#1D2731';
	$wp_customize->get_setting( 'background_color' )->transport = 'postMessage';
	$wp_customize->get_setting( 'background_color' )->default   = '#FFFFFF';

	$wp_customize->remove_section( 'custom-header' );

	// Text color.
	$wp_customize->add_setting(
		'text_color',
		array(
			'default'   => '#1D2731',
			'transport' => 'postMessage',
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
			'default'   => '#808182',
			'transport' => 'postMessage',
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
			'default'   => '#A51323',
			'transport' => 'postMessage',
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
			'default'   => '#0059a7',
			'transport' => 'postMessage',
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
			'default'   => '#0B3C5D',
			'transport' => 'postMessage',
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
			'priority'    => 40,
			'title'       => __( 'Velox Theme Settings', 'velox' ),
			'description' => __( 'Settings specific to the Velox theme.', 'velox' ),
			'capability'  => 'edit_theme_options',
		)
	);

	// Setting: Font Pairing.
	$wp_customize->add_setting(
		'font_pairing',
		array(
			'default'           => 'playfair_lato',
			'transport'         => 'refresh',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'velox_sanitize_select',
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
				'playfair_lato'             => 'Playfair Display / Lato',
				'opensans_gentiumbasic'     => 'Open Sans / Gentium Basic',
				'archivoblack_tenorsans'    => 'Archivo Black / Tenor Sans',
				'rubik_robotomono'          => 'Rubik / Roboto Mono',
				'ovo_muli'                  => 'Ovo / Muli',
				'opensanscondensed_lora'    => 'Open Sans Condensed / Lora',
				'nixieone_librebaskerville' => 'Nixie One / Libre Baskerville',
			),
		)
	);

	// Setting: Night Mode.
	$wp_customize->add_setting(
		'night_mode',
		array(
			'default'           => true,
			'sanitize_callback' => 'velox_sanitize_checkbox',
			'transport'         => 'refresh',
			'capability'        => 'edit_theme_options',
		)
	);

	// Control: Night Mode.
	$wp_customize->add_control(
		'night_mode',
		array(
			'label'       => __( 'Night Mode', 'velox' ),
			'description' => __( 'Allow a night mode setting to be active for visitors to your site to change to a darker page style.', 'velox' ),
			'section'     => 'velox_theme_settings',
			'type'        => 'checkbox',
		)
	);

	// Setting: Read Time.
	$wp_customize->add_setting(
		'read_time',
		array(
			'default'           => true,
			'sanitize_callback' => 'velox_sanitize_checkbox',
			'transport'         => 'refresh',
			'capability'        => 'edit_theme_options',
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
			'default'           => true,
			'sanitize_callback' => 'velox_sanitize_checkbox',
			'transport'         => 'refresh',
			'capability'        => 'edit_theme_options',
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

	// Setting: Author Info.
	$wp_customize->add_setting(
		'author_info',
		array(
			'default'           => true,
			'sanitize_callback' => 'velox_sanitize_checkbox',
			'transport'         => 'refresh',
			'capability'        => 'edit_theme_options',
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

	// Setting: Post Meta Header.
	$wp_customize->add_setting(
		'post_meta_header',
		array(
			'default'           => 'Posted on [post_date]',
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
			'capability'        => 'edit_theme_options',
		)
	);

	// Control: Post Meta Header.
	$wp_customize->add_control(
		'post_meta_header',
		array(
			'label'       => __( 'Post Meta Header', 'velox' ),
			'description' => __( 'Post meta that displays before the post content. See shortcodes below.', 'velox' ),
			'section'     => 'velox_theme_settings',
			'type'        => 'text',
		)
	);

	// Setting: Post Meta Footer.
	$wp_customize->add_setting(
		'post_meta_footer',
		array(
			'default'           => '[post_categories] [post_tags]',
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
			'capability'        => 'edit_theme_options',
		)
	);

	// Control: Post Meta Footer.
	$wp_customize->add_control(
		'post_meta_footer',
		array(
			'label'       => __( 'Post Meta Footer', 'velox' ),
			'description' => __( 'Post meta that displays after the post content. See shortcodes below.', 'velox' ),
			'section'     => 'velox_theme_settings',
			'type'        => 'text',
		)
	);

	// Setting: Post Meta Message.
	$wp_customize->add_setting(
		'post_meta_message',
		array(
			'default' => '',
		)
	);

	// Control: Post Meta Message.
	$wp_customize->add_control(
		'post_meta_message_control',
		array(
			'label'       => __( 'Post Meta Shortcodes', 'velox' ),
			'description' => velox_post_meta_shortcode_message(),
			'section'     => 'velox_theme_settings',
			'type'        => 'hidden',
			'settings'    => 'post_meta_message',
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
 * Creates Post Meta Shortcode Message
 *
 * @return message
 */
function velox_post_meta_shortcode_message() {

	$message  = '<ul>';
	$message .= __( '<li><strong>[post_date]</strong> - Displays the posted or modified date of the post</li>', 'velox' );
	$message .= __( '<li><strong>[post_time]</strong> - Displays the posted or modified time of the post</li>', 'velox' );
	$message .= __( '<li><strong>[post_author]</strong> - Displays the author of the post</li>', 'velox' );
	$message .= __( '<li><strong>[post_comments]</strong> - Displays the number of comments and link to leave a comment</li>', 'velox' );
	$message .= __( '<li><strong>[post_tags]</strong> - Displays all tags of the post</li>', 'velox' );
	$message .= __( '<li><strong>[post_categories]</strong> - Displays all categories of the post</li>', 'velox' );
	$message .= '</ul>';

	return $message;

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
 */
function velox_customizer_css() {
	?>
	<style type="text/css">
		body, button, input, select, optgroup, textarea, h1, h2, h3, h4, h5, h6 { color: <?php echo esc_html( get_theme_mod( 'text_color', '#1D2731' ) ); ?>; }
		.entry-footer, .entry-meta, .wp-block-image figcaption, .wp-block-pullquote cite, .wp-block-latest-posts__post-date, .wp-caption-text { color: <?php echo esc_html( get_theme_mod( 'accent_text_color', '#808182' ) ); ?>; }
		.wp-block-button .wp-block-button__link {	background-color: <?php echo esc_html( get_theme_mod( 'link_color', '#0059a7' ) ); ?>; }
		.wp-block-button .wp-block-button__link:hover, .wp-block-button .wp-block-button__link:active, .wp-block-button .wp-block-button__link:focus {	background-color: <?php echo esc_html( get_theme_mod( 'link_active_color', '#0B3C5D' ) ); ?>; }
		.comment-navigation, .posts-navigation, .post-navigation, .entry-footer, .author-info, hr, .wp-block-separator { border-bottom-color: <?php echo esc_html( get_theme_mod( 'accent_color', '#A51323' ) ); ?>; }
		.navigation .nav-previous { border-right-color: <?php echo esc_html( get_theme_mod( 'accent_color', '#A51323' ) ); ?>; }
		.wp-block-pullquote { border-top-color: <?php echo esc_html( get_theme_mod( 'accent_color', '#A51323' ) ); ?>; border-bottom-color: <?php echo esc_html( get_theme_mod( 'accent_color', '#A51323' ) ); ?>; }
		.wp-block-quote:not(.is-large) { border-left-color: <?php echo esc_html( get_theme_mod( 'accent_color', '#A51323' ) ); ?>; }
		.wp-block-separator.is-style-dots:before { color: <?php echo esc_html( get_theme_mod( 'accent_color', '#A51323' ) ); ?>; }
		a, a:visited { color: <?php echo esc_html( get_theme_mod( 'link_color', '#0059a7' ) ); ?>; }
		a:hover, a:focus, a:active { color: <?php echo esc_html( get_theme_mod( 'link_active_color', '#0B3C5D' ) ); ?>; }
	</style>
	<?php
}
add_action( 'wp_head', 'velox_customizer_css' );

/**
 * Apply customizer fonts
 */
function velox_font_families() {
	// Get the fonts that the site uses from theme settings.
	$font_selection = get_theme_mod( 'font_pairing', 'playfair_lato' );

	if ( 'playfair_lato' === $font_selection ) {
		$heading_font = 'Playfair Display';
		$body_font    = 'Lato';
	} elseif ( 'opensans_gentiumbasic' === $font_selection ) {
		$heading_font = 'Open Sans';
		$body_font    = 'Gentium Basic';
	} elseif ( 'archivoblack_tenorsans' === $font_selection ) {
		$heading_font = 'Archivo Black';
		$body_font    = 'Tenor Sans';
	} elseif ( 'rubik_robotomono' === $font_selection ) {
		$heading_font = 'Rubik';
		$body_font    = 'Roboto Mono';
	} elseif ( 'ovo_muli' === $font_selection ) {
		$heading_font = 'Ovo';
		$body_font    = 'Muli';
	} elseif ( 'opensanscondensed_lora' === $font_selection ) {
		$heading_font = 'Open Sans Condensed';
		$body_font    = 'Lora';
	} elseif ( 'nixieone_librebaskerville' === $font_selection ) {
		$heading_font = 'Nixie One';
		$body_font    = 'Libre Baskerville';
	} else {
		$heading_font = 'Playfair Display';
		$body_font    = 'Lato';
	}

	$font_css = "body, button, input, select, optgroup, textarea {
			font-family: {$body_font},-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Oxygen-Sans,Ubuntu,Cantarell,'Helvetica Neue',sans-serif;
		}
		h1, h2, h3, h4, h5, h6 {
			font-family: {$heading_font},-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Oxygen-Sans,Ubuntu,Cantarell,'Helvetica Neue',sans-serif;
		}
	";

	// Add inline style to use the selected fonts.
	wp_add_inline_style( 'velox-style', $font_css );
}
add_action( 'wp_enqueue_scripts', 'velox_font_families' );
