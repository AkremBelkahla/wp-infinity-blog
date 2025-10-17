<?php
/**
 * Template Registration
 *
 * @package Infinity_Blog
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Register custom page templates.
 * 
 * Note: Les templates FSE sont définis dans theme.json sous customTemplates.
 * Cette fonction est conservée pour la compatibilité future si nécessaire.
 */
function infinity_blog_register_page_templates() {
    // Les templates FSE sont maintenant gérés via theme.json
    // Voir la section customTemplates dans theme.json
    
    /**
     * Filtre pour ajouter des templates personnalisés programmatiquement
     * 
     * @param array $templates Liste des templates personnalisés
     */
    $custom_templates = apply_filters( 'infinity_blog_custom_templates', array() );
    
    // Réservé pour une utilisation future si nécessaire
    return $custom_templates;
}
add_action( 'init', 'infinity_blog_register_page_templates' );

/**
 * Register block patterns.
 */
function infinity_blog_register_block_patterns() {
    // Vérifier si la fonction est disponible
    if ( ! function_exists( 'register_block_pattern_category' ) ) {
        return;
    }
    
    // Enregistrer les catégories de patterns
    register_block_pattern_category(
        'infinity-blog',
        array( 'label' => __( 'Infinity Blog', 'infinity-blog' ) )
    );
    
    register_block_pattern_category(
        'infinity-blog-sections',
        array( 'label' => __( 'Sections de page', 'infinity-blog' ) )
    );
    
    register_block_pattern_category(
        'infinity-blog-layouts',
        array( 'label' => __( 'Mises en page', 'infinity-blog' ) )
    );
}
add_action( 'init', 'infinity_blog_register_block_patterns', 9 );

/**
 * Add block styles.
 */
function infinity_blog_register_block_styles() {
    // Vérifier si la fonction existe (WordPress 5.3+)
    if ( ! function_exists( 'register_block_style' ) ) {
        return;
    }
    
    // Styles de boutons
    register_block_style(
        'core/button',
        array(
            'name'  => 'primary',
            'label' => __( 'Primary', 'infinity-blog' ),
        )
    );
    
    register_block_style(
        'core/button',
        array(
            'name'  => 'secondary',
            'label' => __( 'Secondary', 'infinity-blog' ),
        )
    );
    
    // Styles de groupe
    register_block_style(
        'core/group',
        array(
            'name'  => 'card',
            'label' => __( 'Card', 'infinity-blog' ),
        )
    );
    
    // Styles d'image
    register_block_style(
        'core/image',
        array(
            'name'  => 'rounded',
            'label' => __( 'Rounded', 'infinity-blog' ),
        )
    );
    
    // Styles de paragraphe
    register_block_style(
        'core/paragraph',
        array(
            'name'  => 'lead',
            'label' => __( 'Lead', 'infinity-blog' ),
        )
    );
    
    // Styles de couverture
    register_block_style(
        'core/cover',
        array(
            'name'  => 'overlay-primary',
            'label' => __( 'Overlay Primary', 'infinity-blog' ),
        )
    );
    
    // Styles de colonnes
    register_block_style(
        'core/columns',
        array(
            'name'  => 'boxed',
            'label' => __( 'Boxed', 'infinity-blog' ),
        )
    );
}
add_action( 'init', 'infinity_blog_register_block_styles' );
