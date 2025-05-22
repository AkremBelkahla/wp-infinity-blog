<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
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
                <?php
                while ( have_posts() ) :
                    the_post();
                    ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class( 'bg-white rounded-lg shadow-md overflow-hidden mb-8' ); ?>>
                        <?php if ( has_post_thumbnail() ) : ?>
                            <div class="post-thumbnail">
                                <?php the_post_thumbnail( 'full', array( 'class' => 'w-full h-auto' ) ); ?>
                            </div>
                        <?php endif; ?>

                        <div class="p-6">
                            <header class="entry-header mb-6">
                                <?php the_title( '<h1 class="entry-title text-3xl font-bold text-gray-900 mb-4">', '</h1>' ); ?>
                            </header>

                            <div class="entry-content">
                                <?php
                                the_content();

                                wp_link_pages(
                                    array(
                                        'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'infinity-blog' ),
                                        'after'  => '</div>',
                                    )
                                );
                                ?>
                            </div>

                            <?php if ( get_edit_post_link() ) : ?>
                                <footer class="entry-footer mt-8 pt-6 border-t border-gray-200">
                                    <?php
                                    edit_post_link(
                                        sprintf(
                                            wp_kses(
                                                /* translators: %s: Name of current post. Only visible to screen readers */
                                                __( 'Edit <span class="screen-reader-text">%s</span>', 'infinity-blog' ),
                                                array(
                                                    'span' => array(
                                                        'class' => array(),
                                                    ),
                                                )
                                            ),
                                            wp_kses_post( get_the_title() )
                                        ),
                                        '<span class="edit-link">',
                                        '</span>'
                                    );
                                    ?>
                                </footer>
                            <?php endif; ?>
                        </div>
                    </article>

                    <?php
                    // If comments are open or we have at least one comment, load up the comment template.
                    if ( comments_open() || get_comments_number() ) :
                        comments_template();
                    endif;

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
