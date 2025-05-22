<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
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
                        <?php
                        the_archive_title( '<h1 class="page-title text-3xl font-bold text-gray-900 mb-2">', '</h1>' );
                        the_archive_description( '<div class="archive-description text-gray-600">', '</div>' );
                        ?>
                    </header>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <?php
                        /* Start the Loop */
                        while ( have_posts() ) :
                            the_post();
                            ?>
                            <article id="post-<?php the_ID(); ?>" <?php post_class( 'bg-white rounded-lg shadow-md overflow-hidden' ); ?>>
                                <?php if ( has_post_thumbnail() ) : ?>
                                    <div class="post-thumbnail">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_post_thumbnail( 'medium_large', array( 'class' => 'w-full h-48 object-cover' ) ); ?>
                                        </a>
                                    </div>
                                <?php endif; ?>

                                <div class="p-6">
                                    <header class="entry-header">
                                        <?php
                                        the_title( '<h2 class="entry-title text-xl font-bold text-gray-900 mb-2"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );

                                        if ( 'post' === get_post_type() ) :
                                            ?>
                                            <div class="entry-meta text-sm text-gray-600 mb-3">
                                                <?php
                                                infinity_blog_posted_on();
                                                infinity_blog_posted_by();
                                                ?>
                                            </div>
                                        <?php endif; ?>
                                    </header>

                                    <div class="entry-summary text-gray-600 mb-4">
                                        <?php the_excerpt(); ?>
                                    </div>

                                    <div class="entry-footer text-sm">
                                        <a href="<?php the_permalink(); ?>" class="text-red-600 hover:text-red-700 font-medium">
                                            <?php esc_html_e( 'Read More', 'infinity-blog' ); ?>
                                            <span class="screen-reader-text"><?php echo get_the_title(); ?></span>
                                            <span aria-hidden="true"> &rarr;</span>
                                        </a>
                                    </div>
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
                    get_template_part( 'template-parts/content', 'none' );
                endif;
                ?>
            </div>

            <div class="w-full lg:w-1/3 px-4">
                <?php get_sidebar(); ?>
            </div>
        </div>
    </div>
</main>

<?php
get_footer();
