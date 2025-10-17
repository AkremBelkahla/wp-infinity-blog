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

<!-- ========== { HEADER - Infinity Blog } ========== -->
<!-- Topbar Start -->
<div class="container-fluid d-none d-lg-block">
    <div class="row align-items-center bg-dark px-lg-5">
        <div class="col-lg-9">
            <nav class="navbar navbar-expand-sm bg-dark p-0">
                <ul class="navbar-nav ml-n2">
                    <li class="nav-item border-right border-secondary">
                        <a class="nav-link text-body small" href="#"><?php echo date_i18n( get_option( 'date_format' ) ); ?></a>
                    </li>
                    <?php
                    // Menu secondaire pour la topbar
                    if ( has_nav_menu( 'footer' ) ) {
                        wp_nav_menu(
                            array(
                                'theme_location'  => 'footer',
                                'menu_class'      => 'navbar-nav',
                                'container'       => false,
                                'depth'           => 1,
                                'items_wrap'      => '%3$s',
                                'link_before'     => '<span class="nav-link text-body small">',
                                'link_after'      => '</span>',
                            )
                        );
                    }
                    ?>
                </ul>
            </nav>
        </div>
        <div class="col-lg-3 text-right d-none d-md-block">
            <nav class="navbar navbar-expand-sm bg-dark p-0">
                <ul class="navbar-nav ml-auto mr-n2">
                    <li class="nav-item">
                        <a class="nav-link text-body" href="#" aria-label="Twitter"><small class="fab fa-twitter"></small></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-body" href="#" aria-label="Facebook"><small class="fab fa-facebook-f"></small></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-body" href="#" aria-label="LinkedIn"><small class="fab fa-linkedin-in"></small></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-body" href="#" aria-label="Instagram"><small class="fab fa-instagram"></small></a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
    <div class="row align-items-center bg-white py-3 px-lg-5">
        <div class="col-lg-4">
            <?php if ( has_custom_logo() ) : ?>
                <div class="navbar-brand p-0 d-none d-lg-block">
                    <?php the_custom_logo(); ?>
                </div>
            <?php else : ?>
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="navbar-brand p-0 d-none d-lg-block">
                    <h1 class="m-0 display-4 text-uppercase">
                        <span class="text-primary"><?php echo esc_html( substr( get_bloginfo( 'name' ), 0, strpos( get_bloginfo( 'name' ), ' ' ) ?: strlen( get_bloginfo( 'name' ) ) ) ); ?></span><span class="text-secondary font-weight-normal"><?php echo esc_html( substr( get_bloginfo( 'name' ), strpos( get_bloginfo( 'name' ), ' ' ) ?: 0 ) ); ?></span>
                    </h1>
                </a>
            <?php endif; ?>
        </div>
        <div class="col-lg-8 text-center text-lg-right">
            <?php if ( get_bloginfo( 'description' ) ) : ?>
                <p class="site-description text-muted mb-0"><?php bloginfo( 'description' ); ?></p>
            <?php endif; ?>
        </div>
    </div>
</div>
<!-- Topbar End -->

<!-- Navbar Start -->
<div class="container-fluid p-0">
    <nav class="navbar navbar-expand-lg bg-dark navbar-dark py-2 py-lg-0 px-lg-5">
        <?php if ( has_custom_logo() ) : ?>
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="navbar-brand d-block d-lg-none">
                <?php the_custom_logo(); ?>
            </a>
        <?php else : ?>
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="navbar-brand d-block d-lg-none">
                <h1 class="m-0 display-4 text-uppercase">
                    <span class="text-primary"><?php echo esc_html( substr( get_bloginfo( 'name' ), 0, strpos( get_bloginfo( 'name' ), ' ' ) ?: strlen( get_bloginfo( 'name' ) ) ) ); ?></span><span class="text-white font-weight-normal"><?php echo esc_html( substr( get_bloginfo( 'name' ), strpos( get_bloginfo( 'name' ), ' ' ) ?: 0 ) ); ?></span>
                </h1>
            </a>
        <?php endif; ?>
        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="<?php esc_attr_e( 'Toggle navigation', 'infinity-blog' ); ?>">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-between px-0 px-lg-3" id="navbarCollapse">
            <?php
            wp_nav_menu(
                array(
                    'theme_location'  => 'primary',
                    'menu_class'      => 'navbar-nav mr-auto py-0',
                    'container'       => false,
                    'fallback_cb'     => false,
                    'depth'           => 2,
                    'items_wrap'      => '<div class="navbar-nav mr-auto py-0">%3$s</div>',
                    'link_before'     => '',
                    'link_after'      => '',
                    'before'          => '',
                    'after'           => '',
                )
            );
            ?>
            <div class="input-group ml-auto d-none d-lg-flex" style="width: 100%; max-width: 300px;">
                <form role="search" method="get" class="d-flex w-100" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                    <input type="text" class="form-control border-0" name="s" placeholder="<?php esc_attr_e( 'Rechercher...', 'infinity-blog' ); ?>" value="<?php echo get_search_query(); ?>">
                    <div class="input-group-append">
                        <button type="submit" class="input-group-text bg-primary text-dark border-0 px-3" aria-label="<?php esc_attr_e( 'Rechercher', 'infinity-blog' ); ?>">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </nav>
</div>
<!-- Navbar End -->

<!-- Contenu principal -->
<main id="primary" class="site-main">
