<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Infinity_Blog
 */

get_header();
?>

<main id="primary" class="site-main">
    <div class="container mx-auto px-4 py-16 text-center">
        <div class="max-w-3xl mx-auto">
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="px-8 py-12 sm:px-16 sm:py-20">
                    <div class="text-6xl font-bold text-red-500 mb-4">404</div>
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                        <?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'infinity-blog' ); ?>
                    </h1>
                    
                    <div class="text-gray-600 text-lg mb-8">
                        <?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'infinity-blog' ); ?>
                    </div>
                    
                    <div class="max-w-md mx-auto mb-10">
                        <?php get_search_form(); ?>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-left">
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h2 class="text-xl font-bold text-gray-900 mb-4"><?php esc_html_e( 'Recent Posts', 'infinity-blog' ); ?></h2>
                            <ul class="space-y-2">
                                <?php
                                $recent_posts = wp_get_recent_posts( array(
                                    'numberposts' => 5,
                                    'post_status' => 'publish',
                                ) );
                                
                                foreach ( $recent_posts as $post ) :
                                    printf(
                                        '<li><a href="%1$s" class="text-red-600 hover:text-red-700 hover:underline">%2$s</a></li>',
                                        esc_url( get_permalink( $post['ID'] ) ),
                                        esc_html( $post['post_title'] )
                                    );
                                endforeach;
                                ?>
                            </ul>
                        </div>
                        
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h2 class="text-xl font-bold text-gray-900 mb-4"><?php esc_html_e( 'Categories', 'infinity-blog' ); ?></h2>
                            <ul class="space-y-2">
                                <?php
                                wp_list_categories( array(
                                    'orderby'    => 'count',
                                    'order'      => 'DESC',
                                    'show_count' => 1,
                                    'title_li'   => '',
                                    'number'     => 5,
                                ) );
                                ?>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="mt-10">
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="inline-block bg-red-600 hover:bg-red-700 text-white font-medium py-3 px-6 rounded-lg transition duration-300">
                            <?php esc_html_e( 'Back to Homepage', 'infinity-blog' ); ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php
get_footer();
