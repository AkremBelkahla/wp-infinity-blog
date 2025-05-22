<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Infinity_Blog
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! function_exists( 'infinity_blog_body_classes' ) ) {
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
}

if ( ! function_exists( 'infinity_blog_pingback_header' ) ) {
    /**
     * Add a pingback url auto-discovery header for single posts, pages, or attachments.
     */
    function infinity_blog_pingback_header() {
        if ( is_singular() && pings_open() ) {
            printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
        }
    }
    add_action( 'wp_head', 'infinity_blog_pingback_header' );
}

if ( ! function_exists( 'infinity_blog_fonts_url' ) ) {
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
}

if ( ! function_exists( 'infinity_blog_resource_hints' ) ) {
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
}

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

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