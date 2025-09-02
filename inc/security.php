<?php
/**
 * Fonctions de sécurité pour le thème Infinity Blog
 *
 * @package Infinity_Blog
 */

// Sortie si accès direct
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Ajouter des en-têtes de sécurité
 */
function infinity_blog_security_headers() {
    // Protection contre le clickjacking
    header( 'X-Frame-Options: SAMEORIGIN' );
    
    // Protection contre le MIME-sniffing
    header( 'X-Content-Type-Options: nosniff' );
    
    // Protection XSS
    header( 'X-XSS-Protection: 1; mode=block' );
    
    // Référer Policy
    header( 'Referrer-Policy: strict-origin-when-cross-origin' );
    
    // Content Security Policy - version basique
    $csp = "default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval' *.googleapis.com *.gstatic.com; style-src 'self' 'unsafe-inline' *.googleapis.com; img-src 'self' data: *.gravatar.com; font-src 'self' data: *.gstatic.com; connect-src 'self';";
    header( "Content-Security-Policy: $csp" );
}
add_action( 'send_headers', 'infinity_blog_security_headers' );

/**
 * Désactiver la divulgation de la version de WordPress
 */
function infinity_blog_remove_version() {
    return '';
}
add_filter( 'the_generator', 'infinity_blog_remove_version' );

/**
 * Supprimer les informations de version des scripts et styles
 */
function infinity_blog_remove_version_from_scripts( $src ) {
    if ( strpos( $src, 'ver=' ) ) {
        $src = remove_query_arg( 'ver', $src );
    }
    return $src;
}
add_filter( 'style_loader_src', 'infinity_blog_remove_version_from_scripts', 9999 );
add_filter( 'script_loader_src', 'infinity_blog_remove_version_from_scripts', 9999 );

/**
 * Désactiver l'API XML-RPC
 */
add_filter( 'xmlrpc_enabled', '__return_false' );

/**
 * Désactiver les pings de retour et les pings
 */
function infinity_blog_disable_pingback( &$links ) {
    foreach ( $links as $l => $link ) {
        if ( 0 === strpos( $link, 'pingback' ) ) {
            unset( $links[$l] );
        }
    }
}
add_action( 'pre_ping', 'infinity_blog_disable_pingback' );

/**
 * Désactiver l'API REST pour les utilisateurs non connectés
 */
function infinity_blog_restrict_rest_api( $result ) {
    if ( ! is_user_logged_in() ) {
        return new WP_Error( 'rest_not_logged_in', 'Vous devez être connecté pour accéder à l\'API REST', array( 'status' => 401 ) );
    }
    return $result;
}
// Décommenter la ligne suivante pour restreindre l'API REST aux utilisateurs connectés
// add_filter( 'rest_authentication_errors', 'infinity_blog_restrict_rest_api' );

/**
 * Protéger contre les injections SQL
 */
function infinity_blog_sql_injection_protection() {
    global $wpdb;
    
    // Forcer l'utilisation de requêtes préparées
    $wpdb->show_errors = false;
}
add_action( 'init', 'infinity_blog_sql_injection_protection' );

/**
 * Limiter les tentatives de connexion
 */
function infinity_blog_login_limiter( $user, $username, $password ) {
    if ( empty( $username ) ) {
        return $user;
    }
    
    // Récupérer l'adresse IP
    $ip = $_SERVER['REMOTE_ADDR'];
    
    // Nombre maximum de tentatives
    $max_attempts = 5;
    
    // Période de blocage (en secondes)
    $block_time = 1800; // 30 minutes
    
    // Récupérer les tentatives échouées
    $failed_login_attempts = get_transient( 'failed_login_attempts_' . $ip );
    
    if ( $failed_login_attempts === false ) {
        $failed_login_attempts = 0;
    }
    
    // Vérifier si l'IP est bloquée
    if ( $failed_login_attempts >= $max_attempts ) {
        $block_expires = get_transient( 'login_block_' . $ip );
        
        if ( $block_expires !== false ) {
            return new WP_Error( 'too_many_attempts', sprintf( 
                __( '<strong>ERREUR</strong>: Trop de tentatives de connexion. Veuillez réessayer dans %d minutes.', 'infinity-blog' ),
                ceil( ( $block_expires - time() ) / 60 )
            ) );
        }
    }
    
    return $user;
}
add_filter( 'authenticate', 'infinity_blog_login_limiter', 30, 3 );

/**
 * Enregistrer les tentatives de connexion échouées
 */
function infinity_blog_failed_login( $username ) {
    // Récupérer l'adresse IP
    $ip = $_SERVER['REMOTE_ADDR'];
    
    // Nombre maximum de tentatives
    $max_attempts = 5;
    
    // Période de blocage (en secondes)
    $block_time = 1800; // 30 minutes
    
    // Récupérer les tentatives échouées
    $failed_login_attempts = get_transient( 'failed_login_attempts_' . $ip );
    
    if ( $failed_login_attempts === false ) {
        $failed_login_attempts = 0;
    }
    
    // Incrémenter le compteur
    $failed_login_attempts++;
    
    // Enregistrer le nombre de tentatives
    set_transient( 'failed_login_attempts_' . $ip, $failed_login_attempts, 3600 ); // 1 heure
    
    // Bloquer l'IP si trop de tentatives
    if ( $failed_login_attempts >= $max_attempts ) {
        set_transient( 'login_block_' . $ip, time() + $block_time, $block_time );
    }
}
add_action( 'wp_login_failed', 'infinity_blog_failed_login' );

/**
 * Réinitialiser le compteur après une connexion réussie
 */
function infinity_blog_login_success() {
    $ip = $_SERVER['REMOTE_ADDR'];
    delete_transient( 'failed_login_attempts_' . $ip );
    delete_transient( 'login_block_' . $ip );
}
add_action( 'wp_login', 'infinity_blog_login_success' );

/**
 * Ajouter nonce à tous les formulaires
 */
function infinity_blog_add_nonce_to_forms( $content ) {
    if ( ! is_admin() && ! is_feed() && ! is_search() ) {
        $pattern = '/<form(.*?)>/i';
        $replacement = '<form$1>' . wp_nonce_field( 'infinity_blog_form_action', 'infinity_blog_nonce', true, false );
        $content = preg_replace( $pattern, $replacement, $content );
    }
    return $content;
}
add_filter( 'the_content', 'infinity_blog_add_nonce_to_forms' );

/**
 * Vérifier les nonces dans les formulaires
 */
function infinity_blog_verify_form_nonce() {
    if ( isset( $_POST['infinity_blog_nonce'] ) && ! wp_verify_nonce( $_POST['infinity_blog_nonce'], 'infinity_blog_form_action' ) ) {
        wp_die( __( 'Erreur de sécurité. Veuillez réessayer.', 'infinity-blog' ) );
    }
}
add_action( 'init', 'infinity_blog_verify_form_nonce' );
