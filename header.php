<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- ========== { HEADER } ========== -->
<header class="site-header">
    <div class="container">
        <div class="main-navigation">
            <!-- Logo du site -->
            <div class="site-branding">
                <?php
                if ( has_custom_logo() ) {
                    the_custom_logo();
                } else {
                    ?>
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-title" rel="home">
                        <?php bloginfo( 'name' ); ?>
                    </a>
                    <?php if ( get_bloginfo( 'description' ) ) : ?>
                        <p class="site-description"><?php bloginfo( 'description' ); ?></p>
                    <?php endif; ?>
                    <?php
                }
                ?>
            </div>

            <!-- Menu principal -->
            <nav id="site-navigation" class="primary-navigation">
                <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
                    <span class="screen-reader-text"><?php esc_html_e( 'Menu', 'infinity-blog' ); ?></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                
                <?php
                wp_nav_menu(
                    array(
                        'theme_location'  => 'primary',
                        'menu_class'      => 'primary-menu',
                        'container'       => false,
                        'fallback_cb'     => false,
                        'depth'           => 2,
                        'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                        'walker'          => class_exists('Infinity_Blog_Walker_Nav_Menu') ? new Infinity_Blog_Walker_Nav_Menu() : '',
                    )
                );
                ?>
            </nav>

            <!-- Formulaire de recherche -->
            <div class="header-search">
                <?php get_search_form(); ?>
            </div>
        </div>
    </div>
</header>

<!-- Contenu principal -->
<main id="primary" class="site-main">
