<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class( 'text-gray-700 pt-9 sm:pt-10' ); ?>>
<?php wp_body_open(); ?>

<!-- ========== { HEADER } ========== -->
<header class="fixed top-0 left-0 right-0 z-50">
    <nav class="bg-black">
        <div class="xl:container mx-auto px-3 sm:px-4 xl:px-2">
            <div class="flex justify-between">
                <!-- Site Logo -->
                <div class="mx-w-10 text-2xl font-bold capitalize text-white flex items-center">
                    <?php
                    if ( has_custom_logo() ) {
                        the_custom_logo();
                    } else {
                        ?>
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                            <?php bloginfo( 'name' ); ?>
                        </a>
                        <?php
                    }
                    ?>
                </div>
                
                <!-- Primary Navigation -->
                <div class="flex flex-row">
                    <?php
                    wp_nav_menu(
                        array(
                            'theme_location'  => 'primary',
                            'menu_class'      => 'navbar hidden lg:flex lg:flex-row text-gray-400 text-sm items-center font-bold',
                            'container'       => false,
                            'fallback_cb'     => false,
                            'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                            'depth'           => 3,
                            'walker'          => new Infinity_Blog_Walker_Nav_Menu(),
                        )
                    );
                    ?>

                    <!-- Search Form -->
                    <div class="flex flex-row items-center text-gray-300">
                        <div class="search-dropdown relative border-r lg:border-l border-gray-800 hover:bg-gray-900">
                            <button id="search-btn" class="block p-3 text-gray-300 hover:text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" width="1.2em" height="1.2em" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </button>
                            <div id="search-form" class="absolute right-0 top-full bg-white p-5 shadow-lg hidden w-80">
                                <?php get_search_form( array( 'aria_label' => __( 'Search for:', 'infinity-blog' ) ) ); ?>
                            </div>
                        </div>
                        
                        <!-- Mobile menu button -->
                        <button id="mobile-menu-btn" class="lg:hidden p-3 text-gray-300 hover:text-white focus:outline-none">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>

<!-- Mobile Menu -->
<div id="mobile-menu" class="side-area fixed w-full h-full inset-0 z-50 bg-white transform translate-x-full transition-transform duration-300 ease-in-out lg:hidden">
    <div class="w-full h-full overflow-y-auto">
        <div class="container mx-auto px-4 py-8">
            <div class="flex justify-between items-center mb-8">
                <?php
                if ( has_custom_logo() ) {
                    the_custom_logo();
                } else {
                    ?>
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="text-2xl font-bold text-gray-800">
                        <?php bloginfo( 'name' ); ?>
                    </a>
                    <?php
                }
                ?>
                <button id="close-mobile-menu" class="text-gray-600 hover:text-gray-900">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <nav class="mobile-navigation">
                <?php
                wp_nav_menu(
                    array(
                        'theme_location'  => 'primary',
                        'menu_class'      => 'space-y-4',
                        'container'       => false,
                        'fallback_cb'     => false,
                        'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                        'depth'           => 2,
                    )
                );
                ?>
            </nav>
            
            <div class="mt-8">
                <?php get_search_form(); ?>
            </div>
        </div>
    </div>
</div>

<!-- Main Content -->
<main id="content" class="min-h-screen">
