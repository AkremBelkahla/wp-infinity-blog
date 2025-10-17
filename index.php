<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Infinity_Blog
 */

get_header();
?>

<!-- News Section Start -->
<div class="container-fluid">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <?php if ( is_home() && ! is_front_page() ) : ?>
                    <div class="section-title mb-0">
                        <h4 class="m-0 text-uppercase font-weight-bold"><?php single_post_title(); ?></h4>
                    </div>
                <?php endif; ?>

                <div class="row">
                    <?php
                    if ( have_posts() ) :
                        $post_count = 0;
                        /* Start the Loop */
                        while ( have_posts() ) :
                            the_post();
                            $post_count++;
                            
                            // Premier article en grand
                            if ( $post_count === 1 ) :
                                ?>
                                <div class="col-12">
                                    <div class="position-relative overflow-hidden mb-3" style="height: 400px;">
                                        <?php if ( has_post_thumbnail() ) : ?>
                                            <?php the_post_thumbnail( 'large', array( 'class' => 'img-fluid h-100 w-100', 'style' => 'object-fit: cover;' ) ); ?>
                                        <?php else : ?>
                                            <img class="img-fluid h-100 w-100" src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/default.jpg' ); ?>" style="object-fit: cover;" alt="<?php the_title_attribute(); ?>">
                                        <?php endif; ?>
                                        <div class="overlay">
                                            <div class="mb-2">
                                                <?php
                                                $categories = get_the_category();
                                                if ( ! empty( $categories ) ) {
                                                    echo '<a class="badge badge-primary text-uppercase font-weight-semi-bold p-2 mr-2" href="' . esc_url( get_category_link( $categories[0]->term_id ) ) . '">' . esc_html( $categories[0]->name ) . '</a>';
                                                }
                                                ?>
                                                <a class="text-white" href="<?php the_permalink(); ?>"><small><?php echo get_the_date(); ?></small></a>
                                            </div>
                                            <a class="h2 m-0 text-white text-uppercase font-weight-bold" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            else :
                                // Articles suivants en grille
                                ?>
                                <div class="col-lg-6">
                                    <div class="position-relative overflow-hidden mb-3" style="height: 300px;">
                                        <?php if ( has_post_thumbnail() ) : ?>
                                            <?php the_post_thumbnail( 'medium_large', array( 'class' => 'img-fluid w-100 h-100', 'style' => 'object-fit: cover;' ) ); ?>
                                        <?php else : ?>
                                            <img class="img-fluid w-100 h-100" src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/default.jpg' ); ?>" style="object-fit: cover;" alt="<?php the_title_attribute(); ?>">
                                        <?php endif; ?>
                                        <div class="overlay">
                                            <div class="mb-2">
                                                <?php
                                                $categories = get_the_category();
                                                if ( ! empty( $categories ) ) {
                                                    echo '<a class="badge badge-primary text-uppercase font-weight-semi-bold p-2 mr-2" href="' . esc_url( get_category_link( $categories[0]->term_id ) ) . '">' . esc_html( $categories[0]->name ) . '</a>';
                                                }
                                                ?>
                                                <a class="text-white" href="<?php the_permalink(); ?>"><small><?php echo get_the_date(); ?></small></a>
                                            </div>
                                            <a class="h6 m-0 text-white text-uppercase font-weight-semi-bold" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            endif;
                        endwhile;
                        
                        // Pagination
                        ?>
                        <div class="col-12">
                            <nav aria-label="Page navigation">
                                <?php
                                the_posts_pagination( array(
                                    'mid_size'  => 2,
                                    'prev_text' => '<i class="fa fa-angle-left"></i> ' . __( 'Précédent', 'infinity-blog' ),
                                    'next_text' => __( 'Suivant', 'infinity-blog' ) . ' <i class="fa fa-angle-right"></i>',
                                    'class'     => 'pagination justify-content-center mb-4',
                                ) );
                                ?>
                            </nav>
                        </div>
                        <?php
                    else :
                        get_template_part( 'template-parts/content', 'none' );
                    endif;
                    ?>
                </div>
            </div>
            
            <!-- Sidebar -->
            <div class="col-lg-4">
                <?php get_sidebar(); ?>
            </div>
        </div>
    </div>
</div>
<!-- News Section End -->

<?php
get_footer();
