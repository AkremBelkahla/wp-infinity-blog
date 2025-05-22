    </main><!-- #main -->

    <!-- ========== { FOOTER } ========== -->
    <footer class="site-footer">
        <div class="container">
            <div class="footer-widgets">
                <!-- À propos -->
                <div class="footer-widget">
                    <div class="site-branding">
                        <?php
                        if ( has_custom_logo() ) {
                            the_custom_logo();
                        } else {
                            echo '<h2 class="footer-widget-title"><a href="' . esc_url( home_url( '/' ) ) . '" rel="home">' . get_bloginfo( 'name' ) . '</a></h2>';
                        }
                        ?>
                        <?php if ( get_bloginfo( 'description' ) ) : ?>
                            <p class="site-description"><?php echo esc_html( get_bloginfo( 'description' ) ); ?></p>
                        <?php endif; ?>
                    </div>
                    
                    <div class="social-links">
                        <?php
                        $social_links = array(
                            'facebook'  => get_theme_mod( 'infinity_blog_facebook' ),
                            'twitter'   => get_theme_mod( 'infinity_blog_twitter' ),
                            'instagram' => get_theme_mod( 'infinity_blog_instagram' ),
                            'youtube'   => get_theme_mod( 'infinity_blog_youtube' ),
                            'linkedin'  => get_theme_mod( 'infinity_blog_linkedin' ),
                        );
                        
                        foreach ( $social_links as $platform => $url ) {
                            if ( ! empty( $url ) ) {
                                echo '<a href="' . esc_url( $url ) . '" target="_blank" rel="noopener noreferrer" class="social-link" aria-label="' . esc_attr( ucfirst( $platform ) ) . '">';
                                echo '<span class="dashicons dashicons-' . esc_attr( $platform ) . '"></span>';
                                echo '</a>';
                            }
                        }
                        ?>
                    </div>
                </div>
                
                <!-- Widgets du pied de page -->
                <?php for ( $i = 1; $i <= 3; $i++ ) : ?>
                    <?php if ( is_active_sidebar( 'footer-' . $i ) ) : ?>
                        <div class="footer-widget">
                            <?php dynamic_sidebar( 'footer-' . $i ); ?>
                        </div>
                    <?php endif; ?>
                <?php endfor; ?>
            </div>
        </div>

        <!-- Copyright -->
        <div class="site-info">
            <div class="container">
                <div class="footer-copyright">
                    <p>
                        &copy; <?php echo date( 'Y' ); ?> 
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
                            <?php bloginfo( 'name' ); ?>
                        </a>.
                        <?php esc_html_e( 'Tous droits réservés.', 'infinity-blog' ); ?>
                        
                        <?php
                        if ( function_exists( 'the_privacy_policy_link' ) ) {
                            the_privacy_policy_link( '<span class="separator">|</span>' );
                        }
                        ?>
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bouton de retour en haut -->
    <a href="#page" class="back-to-top" aria-label="<?php esc_attr_e( 'Retour en haut', 'infinity-blog' ); ?>">
        <span class="dashicons dashicons-arrow-up-alt2"></span>
    </a>
    
    <?php wp_footer(); ?>
</body>
</html>
