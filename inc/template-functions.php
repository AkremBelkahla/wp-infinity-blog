<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Infinity_Blog
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function infinity_blog_body_classes( $classes ) {
    // Adds a class of hfeed to non-singular pages.
    if ( ! is_singular() ) {
        $classes[] = 'hfeed';
    }

    // Adds a class of no-sidebar when there is no sidebar present.
    if ( ! is_active_sidebar( 'sidebar-1' ) ) {
        $classes[] = 'no-sidebar';
    }

    // Add class for sticky header
    if ( get_theme_mod( 'infinity_blog_sticky_header', true ) ) {
        $classes[] = 'has-sticky-header';
    }

    return $classes;
}
add_filter( 'body_class', 'infinity_blog_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function infinity_blog_pingback_header() {
    if ( is_singular() && pings_open() ) {
        printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
    }
}
add_action( 'wp_head', 'infinity_blog_pingback_header' );

/**
 * Register custom fonts.
 */
function infinity_blog_fonts_url() {
    $fonts_url = '';
    $fonts     = array();
    $subsets   = 'latin,latin-ext';

    /*
     * Translators: If there are characters in your language that are not supported
     * by Roboto, translate this to 'off'. Do not translate into your own language.
     */
    if ( 'off' !== _x( 'on', 'Roboto font: on or off', 'infinity-blog' ) ) {
        $fonts[] = 'Roboto:300,400,500,700';
    }

    /*
     * Translators: If there are characters in your language that are not supported
     * by Open Sans, translate this to 'off'. Do not translate into your own language.
     */
    if ( 'off' !== _x( 'on', 'Open Sans font: on or off', 'infinity-blog' ) ) {
        $fonts[] = 'Open Sans:400,600,700';
    }

    if ( $fonts ) {
        $fonts_url = add_query_arg(
            array(
                'family'  => urlencode( implode( '|', $fonts ) ),
                'subset'  => urlencode( $subsets ),
                'display' => 'swap',
            ),
            'https://fonts.googleapis.com/css'
        );
    }

    return $fonts_url;
}

/**
 * Add preconnect for Google Fonts.
 *
 * @param array  $urls           URLs to print for resource hints.
 * @param string $relation_type  The relation type the URLs are printed.
 * @return array $urls           URLs to print for resource hints.
 */
function infinity_blog_resource_hints( $urls, $relation_type ) {
    if ( wp_style_is( 'infinity-blog-fonts', 'queue' ) && 'preconnect' === $relation_type ) {
        $urls[] = array(
            'href' => 'https://fonts.gstatic.com',
            'crossorigin',
        );
    }

    return $urls;
}
add_filter( 'wp_resource_hints', 'infinity_blog_resource_hints', 10, 2 );

/**
 * Enqueue scripts and styles.
 */
function infinity_blog_scripts() {
    // Enqueue Google Fonts
    wp_enqueue_style( 'infinity-blog-fonts', infinity_blog_fonts_url(), array(), null );
    
    // Font Awesome
    wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/assets/vendor/font-awesome/css/all.min.css', array(), '5.15.4' );
    
    // Main stylesheet
    wp_enqueue_style( 'infinity-blog-style', get_stylesheet_uri(), array(), INFINITY_BLOG_VERSION );
    
    // Main JavaScript
    wp_enqueue_script( 'infinity-blog-navigation', get_template_directory_uri() . '/js/navigation.js', array(), INFINITY_BLOG_VERSION, true );
    
    // Skip link focus fix
    wp_enqueue_script( 'infinity-blog-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), INFINITY_BLOG_VERSION, true );
    
    // Comment reply
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
    
    // Custom scripts
    wp_enqueue_script( 'infinity-blog-custom', get_template_directory_uri() . '/js/custom.js', array( 'jquery' ), INFINITY_BLOG_VERSION, true );
    
    // Localize script for AJAX
    wp_localize_script( 'infinity-blog-custom', 'infinity_blog_ajax', array(
        'ajax_url' => admin_url( 'admin-ajax.php' ),
        'nonce'    => wp_create_nonce( 'infinity_blog_nonce' ),
    ) );
}
add_action( 'wp_enqueue_scripts', 'infinity_blog_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

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

/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'WooCommerce' ) ) {
    require get_template_directory() . '/inc/woocommerce.php';
}
