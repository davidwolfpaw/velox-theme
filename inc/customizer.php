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

	// Header & Footer color.
	$wp_customize->add_setting(
		'header_footer_color',
		array(
			'default'   => '#0B3C5D',
			'transport' => 'postMessage',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'header_footer_color',
			array(
				'section' => 'colors',
				'label'   => esc_html__( 'Header Menu & Footer Color', 'velox' ),
			)
		)
	);

	// Link Color.
	$wp_customize->add_setting(
		'link_color',
		array(
			'default'   => '#205493',
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

	// Setting: Header Location.
	$wp_customize->add_setting(
		'header_location',
		array(
			'default'    => 'top',
			'transport'  => 'refresh',
			'capability' => 'edit_theme_options',
		)
	);

	// Control: Header Location.
	$wp_customize->add_control(
		'header_location_control',
		array(
			'label'       => __( 'Header Location', 'velox' ),
			'description' => __( 'Choose whether to place the site header at the top or side of the page.<br /> <strong>Header will always display on top on mobile</strong>', 'velox' ),
			'section'     => 'velox_theme_settings',
			'type'        => 'radio',
			'choices'     => array(
				'top'  => 'Top of page',
				'side' => 'Side of page',
			),
			'settings'    => 'header_location',
		)
	);

	// Setting: Hide Header on Scroll.
	$wp_customize->add_setting(
		'hide_header',
		array(
			'default'           => true,
			'sanitize_callback' => 'velox_sanitize_checkbox',
			'transport'         => 'refresh',
			'capability'        => 'edit_theme_options',
		)
	);

	// Control: Hide Header on Scroll.
	$wp_customize->add_control(
		'hide_header_control',
		array(
			'label'       => __( 'Hide Header on Scroll', 'velox' ),
			'description' => __( 'Hide the header (logo, site title, header sidebar) on scroll.<br /> <strong>Header will always hide on mobile</strong>', 'velox' ),
			'section'     => 'velox_theme_settings',
			'type'        => 'checkbox',
			'settings'    => 'hide_header',
		)
	);

	// Setting: Hide Header Menu on Scroll.
	$wp_customize->add_setting(
		'hide_header_menu',
		array(
			'default'           => true,
			'sanitize_callback' => 'velox_sanitize_checkbox',
			'transport'         => 'refresh',
			'capability'        => 'edit_theme_options',
		)
	);

	// Control: Hide Header Menu on Scroll.
	$wp_customize->add_control(
		'hide_header_menu_control',
		array(
			'label'       => __( 'Hide Header Menu on Scroll', 'velox' ),
			'description' => __( 'Hide the header menu on scroll.', 'velox' ),
			'section'     => 'velox_theme_settings',
			'type'        => 'checkbox',
			'settings'    => 'hide_header_menu',
		)
	);

	// Setting: Font Pairing.
	$wp_customize->add_setting(
		'font_pairing',
		array(
			'default'    => 'playfair_lato',
			'transport'  => 'refresh',
			'capability' => 'edit_theme_options',
		)
	);

	// Control: Font Pairing.
	$wp_customize->add_control(
		'font_pairing_control',
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
			'settings'    => 'font_pairing',
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
		'night_mode_control',
		array(
			'label'       => __( 'Night Mode', 'velox' ),
			'description' => __( 'Allow a night mode setting to be active for visitors to your site to change to a darker page style.', 'velox' ),
			'section'     => 'velox_theme_settings',
			'type'        => 'checkbox',
			'settings'    => 'night_mode',
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
		'read_time_control',
		array(
			'label'       => __( 'Read Time', 'velox' ),
			'description' => __( 'Display an estimate of time to read posts.', 'velox' ),
			'section'     => 'velox_theme_settings',
			'type'        => 'checkbox',
			'settings'    => 'read_time',
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
		'progress_bar_control',
		array(
			'label'       => __( 'Article Progress Bar', 'velox' ),
			'description' => __( 'Display a progress bar for post length.', 'velox' ),
			'section'     => 'velox_theme_settings',
			'type'        => 'checkbox',
			'settings'    => 'progress_bar',
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
		'author_info_control',
		array(
			'label'       => __( 'Author Info', 'velox' ),
			'description' => __( 'Display author information on posts.', 'velox' ),
			'section'     => 'velox_theme_settings',
			'type'        => 'checkbox',
			'settings'    => 'author_info',
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
		'post_meta_header_control',
		array(
			'label'       => __( 'Post Meta Header', 'velox' ),
			'description' => __( 'Post meta that displays before the post content. See shortcodes below.', 'velox' ),
			'section'     => 'velox_theme_settings',
			'type'        => 'text',
			'settings'    => 'post_meta_header',
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
		'post_meta_footer_control',
		array(
			'label'       => __( 'Post Meta Footer', 'velox' ),
			'description' => __( 'Post meta that displays after the post content. See shortcodes below.', 'velox' ),
			'section'     => 'velox_theme_settings',
			'type'        => 'text',
			'settings'    => 'post_meta_footer',
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
 *
 * @return checked
 */
function velox_sanitize_checkbox( $checked ) {
	// Boolean check.
	return ( ( isset( $checked ) && true === $checked ) ? true : false );
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
		.site-header-content, #secondary { background-color: <?php echo get_theme_mod( 'background_color', '#FFFFFF' ); ?>; }
		body, button, input, select, optgroup, textarea, h1, h2, h3, h4, h5, h6, .wp-block-pullquote { color: <?php echo get_theme_mod( 'text_color', '#1D2731' ); ?>; }
		.entry-footer, .entry-meta, .wp-block-image figcaption, .wp-block-pullquote > cite, .wp-block-latest-posts__post-date, .wp-caption-text { color: <?php echo get_theme_mod( 'accent_text_color', '#808182' ); ?>; }
		.wp-block-button .wp-block-button__link {	background-color: <?php echo get_theme_mod( 'link_color', '#205493' ); ?>; }
		.wp-block-button .wp-block-button__link:hover, .wp-block-button .wp-block-button__link:active, .wp-block-button .wp-block-button__link:focus {	background-color: <?php echo get_theme_mod( 'link_active_color', '#0B3C5D' ); ?>; }
		.comment-navigation, .posts-navigation, .post-navigation, .entry-footer, .author-info, hr, .wp-block-separator { border-bottom-color: <?php echo get_theme_mod( 'accent_color', '#A51323' ); ?>; }
		.wp-block-pullquote { border-top-color: <?php echo get_theme_mod( 'accent_color' ); ?>; border-bottom-color: <?php echo get_theme_mod( 'accent_color', '#A51323' ); ?>; }
		.site-navigation, .site-footer { background-color: <?php echo get_theme_mod( 'header_footer_color', '#0B3C5D' ); ?>; }
		.wp-block-quote:not(.is-large) { border-left-color: <?php echo get_theme_mod( 'link_color', '#205493' ); ?>; }
		a, a:visited { color: <?php echo get_theme_mod( 'link_color', '#205493' ); ?>; }
		a:hover, a:focus, a:active { color: <?php echo get_theme_mod( 'link_active_color', '#0B3C5D' ); ?>; }
	</style>
	<?php
}
add_action( 'wp_head', 'velox_customizer_css' );
