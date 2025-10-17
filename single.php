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

<!-- News Detail Start -->
<div class="container-fluid mt-5 pt-3">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <?php
                while ( have_posts() ) :
                    the_post();
                    ?>
                    <!-- News Detail -->
                    <div class="position-relative mb-3">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <?php the_post_thumbnail( 'full', array( 'class' => 'img-fluid w-100', 'style' => 'object-fit: cover;' ) ); ?>
                        <?php endif; ?>
                        <div class="bg-white border border-top-0 p-4">
                            <div class="mb-3">
                                <?php
                                $categories = get_the_category();
                                if ( ! empty( $categories ) ) {
                                    echo '<a class="badge badge-primary text-uppercase font-weight-semi-bold p-2 mr-2" href="' . esc_url( get_category_link( $categories[0]->term_id ) ) . '">' . esc_html( $categories[0]->name ) . '</a>';
                                }
                                ?>
                                <a class="text-body" href="<?php the_permalink(); ?>"><?php echo get_the_date(); ?></a>
                            </div>
                            <?php the_title( '<h1 class="mb-3 text-secondary text-uppercase font-weight-bold">', '</h1>' ); ?>
                            <div class="entry-content">
                                <?php
                                the_content(
                                    sprintf(
                                        wp_kses(
                                            /* translators: %s: Name of current post. Only visible to screen readers */
                                            __( 'Continuer la lecture<span class="screen-reader-text"> "%s"</span>', 'infinity-blog' ),
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
                                        'before' => '<div class="page-links mb-4">' . esc_html__( 'Pages:', 'infinity-blog' ),
                                        'after'  => '</div>',
                                    )
                                );
                                ?>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between bg-white border border-top-0 p-4">
                            <div class="d-flex align-items-center">
                                <span class="ml-3"><i class="far fa-eye mr-2"></i><?php echo get_post_meta( get_the_ID(), 'post_views_count', true ) ?: '0'; ?></span>
                                <span class="ml-3"><i class="far fa-comment mr-2"></i><?php comments_number( '0', '1', '%' ); ?></span>
                            </div>
                            <div class="d-flex align-items-center">
                                <?php
                                $tags = get_the_tags();
                                if ( $tags ) {
                                    echo '<span class="mr-2"><i class="fas fa-tags mr-2"></i></span>';
                                    foreach ( $tags as $tag ) {
                                        echo '<a class="badge badge-primary text-uppercase font-weight-semi-bold mr-2 p-2" href="' . esc_url( get_tag_link( $tag->term_id ) ) . '">' . esc_html( $tag->name ) . '</a>';
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <!-- News Detail End -->

                    <?php
                    // If comments are open or we have at least one comment, load up the comment template.
                    if ( comments_open() || get_comments_number() ) :
                        ?>
                        <div class="mb-3">
                            <div class="section-title mb-0">
                                <h4 class="m-0 text-uppercase font-weight-bold"><?php comments_number( 'Aucun commentaire', '1 Commentaire', '% Commentaires' ); ?></h4>
                            </div>
                            <div class="bg-white border border-top-0 p-4">
                                <?php comments_template(); ?>
                            </div>
                        </div>
                        <?php
                    endif;

                    // Navigation entre articles
                    $prev_post = get_previous_post();
                    $next_post = get_next_post();
                    if ( $prev_post || $next_post ) :
                        ?>
                        <div class="row">
                            <?php if ( $prev_post ) : ?>
                                <div class="col-md-6">
                                    <a href="<?php echo esc_url( get_permalink( $prev_post->ID ) ); ?>" class="d-flex align-items-center text-decoration-none bg-white border p-3 mb-3">
                                        <i class="fa fa-angle-left fa-2x text-primary mr-3"></i>
                                        <div>
                                            <small class="text-body d-block"><?php esc_html_e( 'Article précédent', 'infinity-blog' ); ?></small>
                                            <h6 class="m-0 text-secondary"><?php echo esc_html( get_the_title( $prev_post->ID ) ); ?></h6>
                                        </div>
                                    </a>
                                </div>
                            <?php endif; ?>
                            <?php if ( $next_post ) : ?>
                                <div class="col-md-6">
                                    <a href="<?php echo esc_url( get_permalink( $next_post->ID ) ); ?>" class="d-flex align-items-center text-decoration-none bg-white border p-3 mb-3">
                                        <div class="text-right">
                                            <small class="text-body d-block"><?php esc_html_e( 'Article suivant', 'infinity-blog' ); ?></small>
                                            <h6 class="m-0 text-secondary"><?php echo esc_html( get_the_title( $next_post->ID ) ); ?></h6>
                                        </div>
                                        <i class="fa fa-angle-right fa-2x text-primary ml-3"></i>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                        <?php
                    endif;

                endwhile; // End of the loop.
                ?>
            </div>

            <div class="col-lg-4">
                <?php get_sidebar(); ?>
            </div>
        </div>
    </div>
</div>
<!-- News Detail End -->

<?php
get_footer();
