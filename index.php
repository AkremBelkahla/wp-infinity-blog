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

<div class="bg-white py-6">
    <div class="xl:container mx-auto px-3 sm:px-4 xl:px-2">
        <div class="flex flex-row flex-wrap">
            <!-- Main Content -->
            <div class="flex-shrink max-w-full w-full lg:w-2/3 overflow-hidden">
                <?php if ( is_home() && ! is_front_page() ) : ?>
                    <header class="mb-8">
                        <h1 class="text-3xl font-bold text-gray-800"><?php single_post_title(); ?></h1>
                    </header>
                <?php endif; ?>

                <div class="flex flex-row flex-wrap -mx-3">
                    <?php
                    if ( have_posts() ) :
                        /* Start the Loop */
                        while ( have_posts() ) :
                            the_post();
                            ?>
                            <div class="flex-shrink max-w-full w-full sm:w-1/2 lg:w-1/2 px-3 pb-6">
                                <div class="flex flex-col h-full bg-white rounded-lg shadow hover:shadow-lg transition-shadow duration-300">
                                    <?php if ( has_post_thumbnail() ) : ?>
                                        <a href="<?php the_permalink(); ?>" class="block overflow-hidden rounded-t-lg">
                                            <?php the_post_thumbnail( 'post-thumbnail', array( 'class' => 'w-full h-48 object-cover transition-transform duration-500 hover:scale-105' ) ); ?>
                                        </a>
                                    <?php endif; ?>
                                    
                                    <div class="p-6 flex-grow">
                                        <?php the_title( '<h2 class="text-xl font-bold text-gray-800 mb-2 hover:text-red-600 transition-colors"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>
                                        
                                        <div class="text-sm text-gray-500 mb-4">
                                            <span class="mr-4">
                                                <i class="far fa-calendar-alt mr-1"></i>
                                                <?php echo get_the_date(); ?>
                                            </span>
                                            <span>
                                                <i class="far fa-user mr-1"></i>
                                                <?php the_author_posts_link(); ?>
                                            </span>
                                        </div>
                                        
                                        <div class="text-gray-600 mb-4">
                                            <?php the_excerpt(); ?>
                                        </div>
                                        
                                        <a href="<?php the_permalink(); ?>" class="inline-block text-red-600 font-medium hover:text-red-700 transition-colors">
                                            <?php _e( 'Read More', 'infinity-blog' ); ?>
                                            <i class="fas fa-arrow-right ml-1"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <?php
                        endwhile;
                        
                        // Pagination
                        the_posts_pagination( array(
                            'mid_size'  => 2,
                            'prev_text' => '<i class="fas fa-chevron-left"></i> ' . __( 'Previous', 'infinity-blog' ),
                            'next_text' => __( 'Next', 'infinity-blog' ) . ' <i class="fas fa-chevron-right"></i>',
                            'class'     => 'pagination flex justify-center mt-8',
                        ) );
                        
                    else :
                        get_template_part( 'template-parts/content', 'none' );
                    endif;
                    ?>
                </div>
            </div>
            
            <!-- Sidebar -->
            <div class="flex-shrink max-w-full w-full lg:w-1/3 lg:pl-8 order-first lg:order-last">
                <div class="w-full">
                    <?php get_sidebar(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
get_footer();
