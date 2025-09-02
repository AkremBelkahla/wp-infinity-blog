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
define( 'INFINITY_BLOG_VERSION', '1.2.0' );
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
    
    // Support complet pour l'édition de site (FSE)
    add_theme_support( 'block-templates' );
    add_theme_support( 'block-template-parts' );

    // Add support for editor styles
    add_theme_support( 'editor-styles' );
    add_editor_style( 'css/app.css' );

    // Add support for responsive embedded content
    add_theme_support( 'responsive-embeds' );

    // Add support for full and wide align images
    add_theme_support( 'align-wide' );
    
    // Add support for block styles
    add_theme_support( 'wp-block-styles' );
    
    // Désactiver les styles de blocs par défaut de WordPress pour utiliser TailwindCSS
    add_filter( 'should_load_separate_core_block_assets', '__return_false' );
    
    // Désactiver les styles de blocs par défaut de WordPress pour utiliser TailwindCSS
    remove_filter( 'render_block', 'wp_render_layout_support_flag' );
    remove_filter( 'render_block', 'gutenberg_render_layout_support_flag' );
}
add_action( 'after_setup_theme', 'infinity_blog_setup' );

/**
 * Enqueue scripts and styles.
 */
function infinity_blog_scripts() {
    // Enqueue Google Fonts
    wp_enqueue_style( 'google-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap', array(), null );
    
    // Enqueue TailwindCSS styles
    wp_enqueue_style( 'infinity-blog-tailwind', get_template_directory_uri() . '/css/app.css', array(), INFINITY_BLOG_VERSION );
    
    // Theme stylesheet (style.css à la racine du thème pour les styles spécifiques)
    wp_enqueue_style( 'infinity-blog-style', get_stylesheet_uri(), array('infinity-blog-tailwind'), INFINITY_BLOG_VERSION );
    
    // Enqueue main JS file
    wp_enqueue_script( 'infinity-blog-app', 
        get_template_directory_uri() . '/js/app.js', 
        array( 'jquery' ), 
        INFINITY_BLOG_VERSION, 
        true 
    );
    
    // Localize script with data needed for comments
    $comments_data = array(
        'ajax_url' => admin_url( 'admin-ajax.php' ),
        'nonce' => wp_create_nonce( 'infinity_blog_comments_nonce' ),
        'comments_per_page' => get_option( 'comments_per_page' ),
        'is_singular' => is_singular() ? '1' : '0',
        'post_id' => get_the_ID(),
        'text' => array(
            'submitting' => __( 'Submitting...', 'infinity-blog' ),
            'submit_error' => __( 'An error occurred. Please try again.', 'infinity-blog' ),
            'submit_success' => __( 'Thank you for your comment!', 'infinity-blog' ),
        )
    );
    
    wp_localize_script( 'infinity-blog-app', 'infinity_blog_comments', $comments_data );
    
    // Localize script with translated strings
    $mobile_menu_data = array(
        'toggle_submenu' => __( 'Toggle submenu', 'infinity-blog' ),
    );
    
    wp_localize_script( 'infinity-blog-app', 'infinity_blog_vars', $mobile_menu_data );
    
    // Add dashicons for frontend
    wp_enqueue_style( 'dashicons' );
    
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

/**
 * Ajoute les classes nécessaires aux éléments de menu
 */
function infinity_blog_nav_menu_css_class($classes, $item, $args, $depth) {
    // Ajoute une classe pour les éléments de menu avec des sous-menus
    if (in_array('menu-item-has-children', $classes)) {
        $classes[] = 'has-submenu';
    }
    
    // Ajoute une classe pour le niveau de profondeur
    $classes[] = 'menu-item-depth-' . $depth;
    
    return $classes;
}
add_filter('nav_menu_css_class', 'infinity_blog_nav_menu_css_class', 10, 4);

/**
 * Ajoute les attributs ARIA aux liens de menu
 */
function infinity_blog_nav_menu_link_attributes($atts, $item, $args, $depth) {
    if (in_array('menu-item-has-children', $item->classes)) {
        $atts['aria-haspopup'] = 'true';
        $atts['aria-expanded'] = 'false';
    }
    
    return $atts;
}
add_filter('nav_menu_link_attributes', 'infinity_blog_nav_menu_link_attributes', 10, 4);

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
 * Load security functions.
 */
require get_template_directory() . '/inc/security.php';

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

/**
 * Optimisation des performances
 */

// Ajouter le préchargement DNS pour les ressources externes
function infinity_blog_resource_hints( $urls, $relation_type ) {
    if ( 'dns-prefetch' === $relation_type ) {
        // Ajouter les domaines pour le préchargement DNS
        $urls[] = '//fonts.googleapis.com';
        $urls[] = '//fonts.gstatic.com';
        $urls[] = '//ajax.googleapis.com';
    }
    return $urls;
}
add_filter( 'wp_resource_hints', 'infinity_blog_resource_hints', 10, 2 );

// Désactiver les emojis WordPress pour réduire les requêtes HTTP
function infinity_blog_disable_emojis() {
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_action( 'admin_print_styles', 'print_emoji_styles' );
    remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
    remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
    remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
    add_filter( 'tiny_mce_plugins', 'infinity_blog_disable_emojis_tinymce' );
    add_filter( 'wp_resource_hints', 'infinity_blog_disable_emojis_remove_dns_prefetch', 10, 2 );
}
add_action( 'init', 'infinity_blog_disable_emojis' );

// Désactiver les emojis dans TinyMCE
function infinity_blog_disable_emojis_tinymce( $plugins ) {
    if ( is_array( $plugins ) ) {
        return array_diff( $plugins, array( 'wpemoji' ) );
    } else {
        return array();
    }
}

// Supprimer le préchargement DNS pour les emojis
function infinity_blog_disable_emojis_remove_dns_prefetch( $urls, $relation_type ) {
    if ( 'dns-prefetch' === $relation_type ) {
        $emoji_svg_url = apply_filters( 'emoji_svg_url', 'https://s.w.org/images/core/emoji/13.0.0/svg/' );
        $urls = array_diff( $urls, array( $emoji_svg_url ) );
    }
    return $urls;
}

// Optimiser le chargement des scripts
function infinity_blog_defer_scripts( $tag, $handle, $src ) {
    // Liste des scripts à différer
    $defer_scripts = array( 
        'infinity-blog-mobile-menu',
        'infinity-blog-navigation'
    );

    // Ajouter l'attribut defer aux scripts spécifiés
    if ( in_array( $handle, $defer_scripts ) ) {
        return str_replace( ' src', ' defer src', $tag );
    }
    
    return $tag;
}
add_filter( 'script_loader_tag', 'infinity_blog_defer_scripts', 10, 3 );

// Ajouter le support pour le chargement paresseux des images
function infinity_blog_add_image_loading_lazy( $content ) {
    if ( is_admin() || empty( $content ) ) {
        return $content;
    }
    
    // Ne pas appliquer aux flux RSS ou aux extraits
    if ( is_feed() || is_excerpt() ) {
        return $content;
    }
    
    // Remplacer les attributs src par loading="lazy"
    $content = preg_replace( '/(<img[^>]*?)\s?\/?>/i', '$1 loading="lazy" />', $content );
    
    return $content;
}
add_filter( 'the_content', 'infinity_blog_add_image_loading_lazy', 99 );
add_filter( 'post_thumbnail_html', 'infinity_blog_add_image_loading_lazy', 99 );
add_filter( 'get_avatar', 'infinity_blog_add_image_loading_lazy', 99 );
