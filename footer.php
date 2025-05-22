    </main><!-- end main -->

    <!-- =========={ FOOTER }==========  -->
    <footer class="bg-black text-gray-400">
        <!-- Footer content -->
        <div id="footer-content" class="relative pt-8 xl:pt-16 pb-6 xl:pb-12">
            <div class="xl:container mx-auto px-3 sm:px-4 xl:px-2 overflow-hidden">
                <div class="flex flex-wrap flex-row lg:justify-between -mx-3">
                    <!-- Footer About -->
                    <div class="flex-shrink max-w-full w-full lg:w-2/5 px-3 lg:pr-16">
                        <div class="flex items-center mb-4">
                            <?php
                            $custom_logo_id = get_theme_mod( 'custom_logo' );
                            $logo = wp_get_attachment_image_src( $custom_logo_id , 'full' );
                            
                            if ( has_custom_logo() ) {
                                echo '<img src="' . esc_url( $logo[0] ) . '" alt="' . get_bloginfo( 'name' ) . '" class="h-10">';
                            } else {
                                echo '<span class="text-3xl leading-normal font-bold text-gray-100">' . get_bloginfo( 'name' ) . '</span>';
                            }
                            ?>
                        </div>
                        <p class="mb-4"><?php echo esc_html( get_bloginfo( 'description' ) ); ?></p>
                        <div class="social-icons flex space-x-4 mt-6">
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
                                    echo '<a href="' . esc_url( $url ) . '" target="_blank" rel="noopener noreferrer" class="text-gray-400 hover:text-white transition-colors duration-300">';
                                    echo '<span class="sr-only">' . ucfirst( $platform ) . '</span>';
                                    echo '<i class="fab fa-' . esc_attr( $platform ) . ' text-xl"></i>';
                                    echo '</a>';
                                }
                            }
                            ?>
                        </div>
                    </div>
                    
                    <!-- Footer Widgets -->
                    <div class="flex-shrink max-w-full w-full lg:w-3/5 px-3 mt-8 lg:mt-0">
                        <div class="flex flex-wrap flex-row">
                            <?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
                                <div class="flex-shrink max-w-full w-1/2 md:w-1/4 mb-6 lg:mb-0">
                                    <?php dynamic_sidebar( 'footer-1' ); ?>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
                                <div class="flex-shrink max-w-full w-1/2 md:w-1/4 mb-6 lg:mb-0">
                                    <?php dynamic_sidebar( 'footer-2' ); ?>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ( is_active_sidebar( 'footer-3' ) ) : ?>
                                <div class="flex-shrink max-w-full w-1/2 md:w-1/4 mb-6 lg:mb-0">
                                    <?php dynamic_sidebar( 'footer-3' ); ?>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ( is_active_sidebar( 'footer-4' ) ) : ?>
                                <div class="flex-shrink max-w-full w-1/2 md:w-1/4 mb-6 lg:mb-0">
                                    <?php dynamic_sidebar( 'footer-4' ); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer copyright -->
        <div class="footer-dark">
            <div class="container py-4 border-t border-gray-200 border-opacity-10">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center">
                            <p class="text-sm text-gray-500 mb-0">
                                &copy; <?php echo date( 'Y' ); ?> 
                                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="text-gray-400 hover:text-white">
                                    <?php bloginfo( 'name' ); ?>
                                </a>. 
                                <?php _e( 'All Rights Reserved.', 'infinity-blog' ); ?>
                                
                                <?php
                                if ( function_exists( 'the_privacy_policy_link' ) ) {
                                    the_privacy_policy_link( '<span class="px-2">|</span>' );
                                }
                                ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scroll to top button -->
    <a href="#" class="back-top fixed p-4 rounded bg-gray-100 border border-gray-100 text-gray-500 dark:bg-gray-900 dark:border-gray-800 right-4 bottom-4 hidden" aria-label="<?php esc_attr_e( 'Scroll to top', 'infinity-blog' ); ?>">
        <svg width="1rem" height="1rem" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M8 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L7.5 2.707V14.5a.5.5 0 0 0 .5.5z"/>
        </svg>
    </a>

    <?php wp_footer(); ?>
</body>
</html>
