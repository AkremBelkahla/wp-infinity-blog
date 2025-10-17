<?php
/**
 * Template Name: Modèle: Page d'accueil
 * Template Post Type: page
 * 
 * Template pour afficher une page d'accueil de type magazine
 * avec slider, articles en vedette et derniers articles
 *
 * @package Infinity_Blog
 */

get_header();
?>

<!-- Main News Slider Start -->
<div class="container-fluid">
    <div class="container">
        <div class="row">
            <?php
            // Récupérer les 3 derniers articles pour le slider principal
            $slider_query = new WP_Query( array(
                'posts_per_page' => 3,
                'post_status' => 'publish',
            ) );
            
            if ( $slider_query->have_posts() ) :
                $slider_posts = array();
                while ( $slider_query->have_posts() ) : $slider_query->the_post();
                    $slider_posts[] = get_post();
                endwhile;
                wp_reset_postdata();
                
                // Grand article à gauche
                if ( isset( $slider_posts[0] ) ) :
                    $main_post = $slider_posts[0];
                    ?>
                    <div class="col-lg-7 px-0">
                        <div class="position-relative overflow-hidden" style="height: 500px;">
                            <?php if ( has_post_thumbnail( $main_post->ID ) ) : ?>
                                <?php echo get_the_post_thumbnail( $main_post->ID, 'large', array( 'class' => 'img-fluid h-100 w-100', 'style' => 'object-fit: cover;' ) ); ?>
                            <?php endif; ?>
                            <div class="overlay">
                                <div class="mb-2">
                                    <?php
                                    $categories = get_the_category( $main_post->ID );
                                    if ( ! empty( $categories ) ) {
                                        echo '<a class="badge badge-primary text-uppercase font-weight-semi-bold p-2 mr-2" href="' . esc_url( get_category_link( $categories[0]->term_id ) ) . '">' . esc_html( $categories[0]->name ) . '</a>';
                                    }
                                    ?>
                                    <a class="text-white" href="<?php echo esc_url( get_permalink( $main_post->ID ) ); ?>"><?php echo get_the_date( '', $main_post->ID ); ?></a>
                                </div>
                                <a class="h2 m-0 text-white text-uppercase font-weight-bold" href="<?php echo esc_url( get_permalink( $main_post->ID ) ); ?>"><?php echo esc_html( get_the_title( $main_post->ID ) ); ?></a>
                            </div>
                        </div>
                    </div>
                    <?php
                endif;
                
                // Deux petits articles à droite
                ?>
                <div class="col-lg-5 px-0">
                    <div class="row mx-0">
                        <?php
                        for ( $i = 1; $i <= 2; $i++ ) :
                            if ( isset( $slider_posts[$i] ) ) :
                                $small_post = $slider_posts[$i];
                                ?>
                                <div class="col-12 px-0">
                                    <div class="position-relative overflow-hidden" style="height: 250px;">
                                        <?php if ( has_post_thumbnail( $small_post->ID ) ) : ?>
                                            <?php echo get_the_post_thumbnail( $small_post->ID, 'medium', array( 'class' => 'img-fluid w-100 h-100', 'style' => 'object-fit: cover;' ) ); ?>
                                        <?php endif; ?>
                                        <div class="overlay">
                                            <div class="mb-2">
                                                <?php
                                                $categories = get_the_category( $small_post->ID );
                                                if ( ! empty( $categories ) ) {
                                                    echo '<a class="badge badge-primary text-uppercase font-weight-semi-bold p-2 mr-2" href="' . esc_url( get_category_link( $categories[0]->term_id ) ) . '">' . esc_html( $categories[0]->name ) . '</a>';
                                                }
                                                ?>
                                                <a class="text-white" href="<?php echo esc_url( get_permalink( $small_post->ID ) ); ?>"><small><?php echo get_the_date( '', $small_post->ID ); ?></small></a>
                                            </div>
                                            <a class="h6 m-0 text-white text-uppercase font-weight-semi-bold" href="<?php echo esc_url( get_permalink( $small_post->ID ) ); ?>"><?php echo esc_html( get_the_title( $small_post->ID ) ); ?></a>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            endif;
                        endfor;
                        ?>
                    </div>
                </div>
                <?php
            endif;
            ?>
        </div>
    </div>
</div>
<!-- Main News Slider End -->

<!-- Featured News Start -->
<div class="container-fluid pt-5 pb-3">
    <div class="container">
        <div class="section-title">
            <h4 class="m-0 text-uppercase font-weight-bold"><?php _e( 'Featured News', 'infinity-blog' ); ?></h4>
        </div>
        <div class="row">
            <?php
            // Récupérer 4 articles en vedette
            $featured_query = new WP_Query( array(
                'posts_per_page' => 4,
                'offset' => 3,
                'post_status' => 'publish',
            ) );
            
            if ( $featured_query->have_posts() ) :
                while ( $featured_query->have_posts() ) : $featured_query->the_post();
                    ?>
                    <div class="col-lg-3 col-md-6 mb-3">
                        <div class="position-relative overflow-hidden" style="height: 300px;">
                            <?php if ( has_post_thumbnail() ) : ?>
                                <?php the_post_thumbnail( 'medium', array( 'class' => 'img-fluid h-100 w-100', 'style' => 'object-fit: cover;' ) ); ?>
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
                endwhile;
                wp_reset_postdata();
            endif;
            ?>
        </div>
    </div>
</div>
<!-- Featured News End -->

<!-- Latest News Start -->
<div class="container-fluid">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="section-title mb-0">
                    <h4 class="m-0 text-uppercase font-weight-bold"><?php _e( 'Latest News', 'infinity-blog' ); ?></h4>
                    <a class="text-secondary font-weight-medium text-decoration-none" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php _e( 'View All', 'infinity-blog' ); ?></a>
                </div>
                <div class="row">
                    <?php
                    // Récupérer les derniers articles
                    $latest_query = new WP_Query( array(
                        'posts_per_page' => 6,
                        'offset' => 7,
                        'post_status' => 'publish',
                    ) );
                    
                    if ( $latest_query->have_posts() ) :
                        while ( $latest_query->have_posts() ) : $latest_query->the_post();
                            ?>
                            <div class="col-lg-6">
                                <div class="d-flex align-items-center bg-white mb-3" style="height: 110px;">
                                    <?php if ( has_post_thumbnail() ) : ?>
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_post_thumbnail( 'thumbnail', array( 'class' => 'img-fluid', 'style' => 'width: 110px; height: 110px; object-fit: cover;' ) ); ?>
                                        </a>
                                    <?php endif; ?>
                                    <div class="w-100 h-100 px-3 d-flex flex-column justify-content-center border border-left-0">
                                        <div class="mb-2">
                                            <?php
                                            $categories = get_the_category();
                                            if ( ! empty( $categories ) ) {
                                                echo '<a class="badge badge-primary text-uppercase font-weight-semi-bold p-1 mr-2" href="' . esc_url( get_category_link( $categories[0]->term_id ) ) . '">' . esc_html( $categories[0]->name ) . '</a>';
                                            }
                                            ?>
                                            <a class="text-body" href="<?php the_permalink(); ?>"><small><?php echo get_the_date(); ?></small></a>
                                        </div>
                                        <a class="h6 m-0 text-secondary text-uppercase font-weight-bold" href="<?php the_permalink(); ?>"><?php echo wp_trim_words( get_the_title(), 10, '...' ); ?></a>
                                    </div>
                                </div>
                            </div>
                            <?php
                        endwhile;
                        wp_reset_postdata();
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
<!-- Latest News End -->

<?php
get_footer();
