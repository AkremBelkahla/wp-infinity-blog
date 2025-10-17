    </main><!-- #main -->

    <!-- ========== { FOOTER - Infinity Blog } ========== -->
    <!-- Footer Start -->
    <div class="container-fluid bg-dark pt-5 px-sm-3 px-md-5 mt-5">
        <div class="row py-4">
            <div class="col-lg-3 col-md-6 mb-5">
                <h5 class="mb-4 text-white text-uppercase font-weight-bold"><?php bloginfo( 'name' ); ?></h5>
                <?php if ( get_bloginfo( 'description' ) ) : ?>
                    <p class="font-weight-medium text-body"><?php echo esc_html( get_bloginfo( 'description' ) ); ?></p>
                <?php endif; ?>
                <div class="d-flex justify-content-start mt-4">
                    <?php
                    $social_links = array(
                        'twitter'   => array( 'url' => get_theme_mod( 'infinity_blog_twitter' ), 'icon' => 'fab fa-twitter' ),
                        'facebook'  => array( 'url' => get_theme_mod( 'infinity_blog_facebook' ), 'icon' => 'fab fa-facebook-f' ),
                        'linkedin'  => array( 'url' => get_theme_mod( 'infinity_blog_linkedin' ), 'icon' => 'fab fa-linkedin-in' ),
                        'instagram' => array( 'url' => get_theme_mod( 'infinity_blog_instagram' ), 'icon' => 'fab fa-instagram' ),
                        'youtube'   => array( 'url' => get_theme_mod( 'infinity_blog_youtube' ), 'icon' => 'fab fa-youtube' ),
                    );
                    
                    foreach ( $social_links as $platform => $data ) {
                        if ( ! empty( $data['url'] ) ) {
                            echo '<a class="btn btn-lg btn-secondary btn-lg-square mr-2" href="' . esc_url( $data['url'] ) . '" target="_blank" rel="noopener noreferrer" aria-label="' . esc_attr( ucfirst( $platform ) ) . '">';
                            echo '<i class="' . esc_attr( $data['icon'] ) . '"></i>';
                            echo '</a>';
                        }
                    }
                    ?>
                </div>
            </div>
            
            <?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
                <div class="col-lg-3 col-md-6 mb-5">
                    <?php dynamic_sidebar( 'footer-1' ); ?>
                </div>
            <?php endif; ?>
            
            <?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
                <div class="col-lg-3 col-md-6 mb-5">
                    <?php dynamic_sidebar( 'footer-2' ); ?>
                </div>
            <?php endif; ?>
            
            <?php if ( is_active_sidebar( 'footer-3' ) ) : ?>
                <div class="col-lg-3 col-md-6 mb-5">
                    <?php dynamic_sidebar( 'footer-3' ); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="container-fluid py-4 px-sm-3 px-md-5" style="background: #111111;">
        <p class="m-0 text-center text-body">
            &copy; <?php echo date( 'Y' ); ?> 
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="text-primary"><?php bloginfo( 'name' ); ?></a>. 
            <?php esc_html_e( 'Tous droits réservés.', 'infinity-blog' ); ?>
            <?php
            if ( function_exists( 'the_privacy_policy_link' ) ) {
                the_privacy_policy_link( ' | ' );
            }
            ?>
        </p>
    </div>
    <!-- Footer End -->

    <!-- Back to Top -->
    <a href="#" class="btn btn-primary btn-square back-to-top" aria-label="<?php esc_attr_e( 'Retour en haut', 'infinity-blog' ); ?>">
        <i class="fa fa-arrow-up"></i>
    </a>
    
    <?php wp_footer(); ?>
</body>
</html>
