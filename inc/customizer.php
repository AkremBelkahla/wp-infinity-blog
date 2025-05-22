<?php
/**
 * Infinity Blog Theme Customizer
 *
 * @package Infinity_Blog
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function infinity_blog_customize_register( $wp_customize ) {
    // Remove default sections
    $wp_customize->remove_section( 'colors' );
    $wp_customize->remove_section( 'background_image' );
    
    // Add Panel for Theme Options
    $wp_customize->add_panel( 'infinity_blog_theme_options', array(
        'title'       => __( 'Theme Options', 'infinity-blog' ),
        'description' => __( 'Customize the theme settings', 'infinity-blog' ),
        'priority'    => 130,
    ) );

    // General Settings Section
    $wp_customize->add_section( 'infinity_blog_general_settings', array(
        'title'    => __( 'General Settings', 'infinity-blog' ),
        'panel'    => 'infinity_blog_theme_options',
        'priority' => 10,
    ) );

    // Header Settings Section
    $wp_customize->add_section( 'infinity_blog_header_settings', array(
        'title'    => __( 'Header Settings', 'infinity-blog' ),
        'panel'    => 'infinity_blog_theme_options',
        'priority' => 20,
    ) );

    // Footer Settings Section
    $wp_customize->add_section( 'infinity_blog_footer_settings', array(
        'title'    => __( 'Footer Settings', 'infinity-blog' ),
        'panel'    => 'infinity_blog_theme_options',
        'priority' => 30,
    ) );

    // Social Media Section
    $wp_customize->add_section( 'infinity_blog_social_media', array(
        'title'    => __( 'Social Media', 'infinity-blog' ),
        'panel'    => 'infinity_blog_theme_options',
        'priority' => 40,
    ) );

    // About Section
    $wp_customize->add_section( 'infinity_blog_about_section', array(
        'title'    => __( 'About Section', 'infinity-blog' ),
        'panel'    => 'infinity_blog_theme_options',
        'priority' => 50,
    ) );

    // Add settings and controls for General Settings
    $wp_customize->add_setting( 'infinity_blog_preloader', array(
        'default'           => true,
        'sanitize_callback' => 'infinity_blog_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'infinity_blog_preloader', array(
        'label'    => __( 'Enable Preloader', 'infinity-blog' ),
        'section'  => 'infinity_blog_general_settings',
        'type'     => 'checkbox',
        'priority' => 10,
    ) );

    // Header Settings
    $wp_customize->add_setting( 'infinity_blog_sticky_header', array(
        'default'           => true,
        'sanitize_callback' => 'infinity_blog_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'infinity_blog_sticky_header', array(
        'label'    => __( 'Enable Sticky Header', 'infinity-blog' ),
        'section'  => 'infinity_blog_header_settings',
        'type'     => 'checkbox',
        'priority' => 10,
    ) );

    // Footer Copyright Text
    $wp_customize->add_setting( 'infinity_blog_footer_copyright', array(
        'default'           => sprintf( __( '&copy; %1$s %2$s. All Rights Reserved.', 'infinity-blog' ), date( 'Y' ), get_bloginfo( 'name' ) ),
        'sanitize_callback' => 'wp_kses_post',
    ) );

    $wp_customize->add_control( 'infinity_blog_footer_copyright', array(
        'label'    => __( 'Copyright Text', 'infinity-blog' ),
        'section'  => 'infinity_blog_footer_settings',
        'type'     => 'textarea',
        'priority' => 10,
    ) );

    // Social Media Settings
    $social_platforms = array(
        'facebook'  => __( 'Facebook URL', 'infinity-blog' ),
        'twitter'   => __( 'Twitter URL', 'infinity-blog' ),
        'instagram' => __( 'Instagram URL', 'infinity-blog' ),
        'youtube'   => __( 'YouTube URL', 'infinity-blog' ),
        'linkedin'  => __( 'LinkedIn URL', 'infinity-blog' ),
        'pinterest' => __( 'Pinterest URL', 'infinity-blog' ),
    );

    foreach ( $social_platforms as $platform => $label ) {
        $wp_customize->add_setting( 'infinity_blog_' . $platform, array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ) );

        $wp_customize->add_control( 'infinity_blog_' . $platform, array(
            'label'    => $label,
            'section'  => 'infinity_blog_social_media',
            'type'     => 'url',
            'priority' => 10,
        ) );
    }

    // About Section Settings
    $wp_customize->add_setting( 'infinity_blog_about_title', array(
        'default'           => __( 'About Us', 'infinity-blog' ),
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    $wp_customize->add_control( 'infinity_blog_about_title', array(
        'label'    => __( 'About Title', 'infinity-blog' ),
        'section'  => 'infinity_blog_about_section',
        'type'     => 'text',
        'priority' => 10,
    ) );

    $wp_customize->add_setting( 'infinity_blog_about_content', array(
        'default'           => __( 'Welcome to our blog where we share interesting articles and news about various topics.', 'infinity-blog' ),
        'sanitize_callback' => 'wp_kses_post',
    ) );

    $wp_customize->add_control( 'infinity_blog_about_content', array(
        'label'    => __( 'About Content', 'infinity-blog' ),
        'section'  => 'infinity_blog_about_section',
        'type'     => 'textarea',
        'priority' => 20,
    ) );

    $wp_customize->add_setting( 'infinity_blog_about_image', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ) );

    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'infinity_blog_about_image', array(
        'label'    => __( 'About Image', 'infinity-blog' ),
        'section'  => 'infinity_blog_about_section',
        'settings' => 'infinity_blog_about_image',
        'priority' => 30,
    ) ) );
}
add_action( 'customize_register', 'infinity_blog_customize_register' );

/**
 * Sanitize checkbox
 */
function infinity_blog_sanitize_checkbox( $checked ) {
    return ( ( isset( $checked ) && true === $checked ) ? true : false );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function infinity_blog_customize_preview_js() {
    wp_enqueue_script( 'infinity-blog-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'infinity_blog_customize_preview_js' );
