<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package Infinity_Blog
 */

get_header();
?>

<main id="primary" class="site-main">
    <div class="container mx-auto px-4 py-12">
        <div class="flex flex-wrap -mx-4">
            <div class="w-full lg:w-2/3 px-4">
                <?php if ( have_posts() ) : ?>
                    <header class="page-header mb-8">
                        <h1 class="page-title text-3xl font-bold text-gray-900">
                            <?php
                            /* translators: %s: search query. */
                            printf( esc_html__( 'Search Results for: %s', 'infinity-blog' ), '<span>' . get_search_query() . '</span>' );
                            ?>
                        </h1>
                    </header>

                    <div class="grid grid-cols-1 gap-6">
                        <?php
                        /* Start the Loop */
                        while ( have_posts() ) :
                            the_post();
                            ?>
                            <article id="post-<?php the_ID(); ?>" <?php post_class( 'bg-white rounded-lg shadow-md overflow-hidden' ); ?>>
                                <div class="p-6">
                                    <header class="entry-header">
                                        <?php the_title( sprintf( '<h2 class="entry-title text-2xl font-bold text-gray-900 mb-2"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
                                        
                                        <?php if ( 'post' === get_post_type() ) : ?>
                                            <div class="entry-meta text-sm text-gray-600 mb-3">
                                                <?php
                                                infinity_blog_posted_on();
                                                infinity_blog_posted_by();
                                                ?>
                                            </div>
                                        <?php endif; ?>
                                    </header>

                                    <div class="entry-summary text-gray-600">
                                        <?php the_excerpt(); ?>
                                    </div>

                                    <footer class="entry-footer mt-4 pt-4 border-t border-gray-100">
                                        <a href="<?php the_permalink(); ?>" class="text-red-600 hover:text-red-700 font-medium">
                                            <?php esc_html_e( 'Continue reading', 'infinity-blog' ); ?>
                                            <span class="screen-reader-text"><?php the_title(); ?></span>
                                        </a>
                                    </footer>
                                </div>
                            </article>
                            <?php
                        endwhile;
                        ?>
                    </div>

                    <?php
                    the_posts_pagination(
                        array(
                            'mid_size'  => 2,
                            'prev_text' => '<span class="screen-reader-text">' . __( 'Previous page', 'infinity-blog' ) . '</span>',
                            'next_text' => '<span class="screen-reader-text">' . __( 'Next page', 'infinity-blog' ) . '</span>',
                            'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'infinity-blog' ) . ' </span>',
                        )
                    );

                else :
                    ?>
                    <div class="bg-white rounded-lg shadow-md p-8 text-center">
                        <h1 class="text-2xl font-bold text-gray-900 mb-4"><?php esc_html_e( 'Nothing Found', 'infinity-blog' ); ?></h1>
                        <p class="text-gray-600 mb-6">
                            <?php
                            printf(
                                /* translators: %s: search query. */
                                esc_html__( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'infinity-blog' ),
                                '<strong>' . get_search_query() . '</strong>'
                            );
                            ?>
                        </p>
                        <div class="max-w-md mx-auto">
                            <?php get_search_form(); ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <div class="w-full lg:w-1/3 px-4 mt-8 lg:mt-0">
                <?php get_sidebar(); ?>
            </div>
        </div>
    </div>
</main>

<?php
get_footer();
