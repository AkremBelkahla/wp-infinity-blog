<?php
/**
 * The template for displaying single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Infinity_Blog
 */

get_header();
?>

<main id="primary" class="site-main">
    <div class="container mx-auto px-4 py-8">
        <div class="flex flex-wrap -mx-4">
            <div class="w-full lg:w-2/3 px-4">
                <?php
                while ( have_posts() ) :
                    the_post();
                    ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class( 'bg-white rounded-lg shadow-md overflow-hidden mb-8' ); ?>>
                        <?php if ( has_post_thumbnail() ) : ?>
                            <div class="post-thumbnail mb-6">
                                <?php the_post_thumbnail( 'full', array( 'class' => 'w-full h-auto' ) ); ?>
                            </div>
                        <?php endif; ?>

                        <div class="p-6">
                            <header class="entry-header mb-6">
                                <?php
                                if ( is_singular() ) :
                                    the_title( '<h1 class="entry-title text-3xl font-bold text-gray-900 mb-4">', '</h1>' );
                                else :
                                    the_title( '<h2 class="entry-title text-2xl font-bold text-gray-900 mb-4"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
                                endif;

                                if ( 'post' === get_post_type() ) :
                                    ?>
                                    <div class="entry-meta text-gray-600 text-sm mb-4">
                                        <?php
                                        infinity_blog_posted_on();
                                        infinity_blog_posted_by();
                                        ?>
                                    </div>
                                <?php endif; ?>
                            </header>

                            <div class="entry-content">
                                <?php
                                the_content(
                                    sprintf(
                                        wp_kses(
                                            /* translators: %s: Name of current post. Only visible to screen readers */
                                            __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'infinity-blog' ),
                                            array(
                                                'span' => array(
                                                    'class' => array(),
                                                ),
                                            )
                                        ),
                                        wp_kses_post( get_the_title() )
                                    )
                                );

                                wp_link_pages(
                                    array(
                                        'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'infinity-blog' ),
                                        'after'  => '</div>',
                                    )
                                );
                                ?>
                            </div>

                            <footer class="entry-footer mt-8 pt-6 border-t border-gray-200">
                                <?php infinity_blog_entry_footer(); ?>
                            </footer>
                        </div>
                    </article>

                    <?php
                    // If comments are open or we have at least one comment, load up the comment template.
                    if ( comments_open() || get_comments_number() ) :
                        comments_template();
                    endif;

                    the_post_navigation(
                        array(
                            'prev_text' => '<span class="nav-subtitle">' . esc_html__( 'Previous:', 'infinity-blog' ) . '</span> <span class="nav-title">%title</span>',
                            'next_text' => '<span class="nav-subtitle">' . esc_html__( 'Next:', 'infinity-blog' ) . '</span> <span class="nav-title">%title</span>',
                        )
                    );

                endwhile; // End of the loop.
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
