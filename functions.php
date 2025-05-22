<?php
/**
 * Infinity Blog functions and definitions
 *
 * @package Infinity_Blog
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Define theme constants
define( 'INFINITY_BLOG_VERSION', '1.0.0' );
define( 'INFINITY_BLOG_THEME_DIR', get_template_directory() );
define( 'INFINITY_BLOG_THEME_URI', get_template_directory_uri() );

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function infinity_blog_setup() {
    // Make theme available for translation
    load_theme_textdomain( 'infinity-blog', get_template_directory() . '/languages' );

    // Add default posts and comments RSS feed links to head
    add_theme_support( 'automatic-feed-links' );

    // Let WordPress manage the document title
    add_theme_support( 'title-tag' );

    // Enable support for Post Thumbnails on posts and pages
    add_theme_support( 'post-thumbnails' );

    // Register navigation menus
    register_nav_menus(
        array(
            'primary' => esc_html__( 'Primary Menu', 'infinity-blog' ),
            'footer'  => esc_html__( 'Footer Menu', 'infinity-blog' ),
        )
    );

    // Add theme support for selective refresh for widgets
    add_theme_support( 'customize-selective-refresh-widgets' );

    // Add support for core custom logo
    add_theme_support(
        'custom-logo',
        array(
            'height'      => 50,
            'width'       => 200,
            'flex-width'  => true,
            'flex-height' => true,
        )
    );

    // Add support for editor styles
    add_theme_support( 'editor-styles' );
    add_editor_style( 'dist/css/editor-style.css' );

    // Add support for responsive embedded content
    add_theme_support( 'responsive-embeds' );

    // Add support for full and wide align images
    add_theme_support( 'align-wide' );
}
add_action( 'after_setup_theme', 'infinity_blog_setup' );

/**
 * Enqueue scripts and styles.
 */
function infinity_blog_scripts() {
    // Enqueue Google Fonts
    wp_enqueue_style( 'google-fonts', 'https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;600;700&display=swap', array(), null );
    
    // Theme stylesheet (style.css à la racine du thème)
    wp_enqueue_style( 'infinity-blog-style', get_stylesheet_uri(), array(), INFINITY_BLOG_VERSION );
    
    // Enqueue custom JS files
    wp_enqueue_script( 'infinity-blog-custom-comments', get_template_directory_uri() . '/js/custom-comments.js', array( 'jquery' ), INFINITY_BLOG_VERSION, true );
    wp_enqueue_script( 'infinity-blog-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'jquery' ), INFINITY_BLOG_VERSION, true );
    
    // Suppression des références aux fichiers manquants
    // wp_enqueue_style( 'tailwind', get_template_directory_uri() . '/dist/css/style.css', array(), INFINITY_BLOG_VERSION );
    // wp_enqueue_script( 'splide', get_template_directory_uri() . '/src/js/splide.min.js', array(), '3.6.9', true );
    // wp_enqueue_script( 'infinity-blog-script', get_template_directory_uri() . '/dist/js/script.js', array( 'jquery' ), INFINITY_BLOG_VERSION, true );

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'infinity_blog_scripts' );

/**
 * Register widget area.
 */
function infinity_blog_widgets_init() {
    register_sidebar(
        array(
            'name'          => esc_html__( 'Sidebar', 'infinity-blog' ),
            'id'            => 'sidebar-1',
            'description'   => esc_html__( 'Add widgets here.', 'infinity-blog' ),
            'before_widget' => '<section id="%1$s" class="widget %2$s mb-8 p-6 bg-white rounded shadow">',
            'after_widget'  => '</section>',
            'before_title'  => '<h3 class="widget-title text-xl font-bold mb-4 text-gray-800 border-l-4 border-red-600 pl-3">',
            'after_title'   => '</h3>',
        )
    );

    // Footer widget areas
    register_sidebar(
        array(
            'name'          => esc_html__( 'Footer 1', 'infinity-blog' ),
            'id'            => 'footer-1',
            'description'   => esc_html__( 'First footer widget area', 'infinity-blog' ),
            'before_widget' => '<div id="%1$s" class="widget %2$s mb-4">',
            'after_widget'  => '</div>',
            'before_title'  => '<h4 class="text-base leading-normal mb-3 uppercase text-gray-100">',
            'after_title'   => '</h4>',
        )
    );

    register_sidebar(
        array(
            'name'          => esc_html__( 'Footer 2', 'infinity-blog' ),
            'id'            => 'footer-2',
            'description'   => esc_html__( 'Second footer widget area', 'infinity-blog' ),
            'before_widget' => '<div id="%1$s" class="widget %2$s mb-4">',
            'after_widget'  => '</div>',
            'before_title'  => '<h4 class="text-base leading-normal mb-3 uppercase text-gray-100">',
            'after_title'   => '</h4>',
        )
    );

    register_sidebar(
        array(
            'name'          => esc_html__( 'Footer 3', 'infinity-blog' ),
            'id'            => 'footer-3',
            'description'   => esc_html__( 'Third footer widget area', 'infinity-blog' ),
            'before_widget' => '<div id="%1$s" class="widget %2$s mb-4">',
            'after_widget'  => '</div>',
            'before_title'  => '<h4 class="text-base leading-normal mb-3 uppercase text-gray-100">',
            'after_title'   => '</h4>',
        )
    );
}
add_action( 'widgets_init', 'infinity_blog_widgets_init' );

// Charger la classe de menu personnalisée
require get_template_directory() . '/inc/class-walker-nav-menu.php';

// Charger les fichiers d'incusion du thème
$theme_includes = array(
    'template-tags.php',    // Balises de modèle personnalisées
    'template-functions.php', // Fonctions du thème
    'customizer.php',       // Personnalisateur
);

foreach ( $theme_includes as $file ) {
    $filepath = get_template_directory() . '/inc/' . $file;
    if ( file_exists( $filepath ) ) {
        require_once $filepath;
    } else {
        // Enregistrer une erreur si le fichier est manquant
        trigger_error( sprintf( 'Erreur de chargement du fichier %s', $filepath ), E_USER_WARNING );
    }
}

// Charger la compatibilité Jetpack si disponible
if ( defined( 'JETPACK__VERSION' ) ) {
    $jetpack_file = get_template_directory() . '/inc/jetpack.php';
    if ( file_exists( $jetpack_file ) ) {
        require_once $jetpack_file;
    }
}

/**
 * Add theme support for infinite scroll.
 */
function infinity_blog_infinite_scroll_init() {
    add_theme_support(
        'infinite-scroll',
        array(
            'container' => 'main',
            'render'    => 'infinity_blog_infinite_scroll_render',
            'footer'    => 'page',
        )
    );
}
add_action( 'after_setup_theme', 'infinity_blog_infinite_scroll_init' );

/**
 * Custom render function for Infinite Scroll.
 */
function infinity_blog_infinite_scroll_render() {
    while ( have_posts() ) {
        the_post();
        get_template_part( 'template-parts/content', get_post_type() );
    }
}
