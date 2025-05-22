<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Infinity_Blog
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
    return;
}
?>

<aside id="secondary" class="widget-area space-y-8">
    <!-- About Widget -->
    <div class="bg-white p-6 rounded-lg shadow-md">
        <?php
        $about_title = get_theme_mod( 'infinity_blog_about_title', __( 'About Us', 'infinity-blog' ) );
        $about_content = get_theme_mod( 'infinity_blog_about_content', __( 'Welcome to our blog where we share interesting articles and news about various topics.', 'infinity-blog' ) );
        $about_image = get_theme_mod( 'infinity_blog_about_image' );
        ?>
        
        <h3 class="text-xl font-bold text-gray-800 mb-4 border-l-4 border-red-600 pl-3"><?php echo esc_html( $about_title ); ?></h3>
        
        <?php if ( $about_image ) : ?>
            <div class="mb-4 rounded overflow-hidden">
                <img src="<?php echo esc_url( $about_image ); ?>" alt="<?php echo esc_attr( $about_title ); ?>" class="w-full h-auto rounded">
            </div>
        <?php endif; ?>
        
        <div class="text-gray-600">
            <?php echo wp_kses_post( wpautop( $about_content ) ); ?>
        </div>
    </div>

    <!-- Social Media Widget -->
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h3 class="text-xl font-bold text-gray-800 mb-4 border-l-4 border-red-600 pl-3"><?php _e( 'Follow Us', 'infinity-blog' ); ?></h3>
        <div class="flex flex-wrap gap-3">
            <?php
            $social_platforms = array(
                'facebook'  => array(
                    'url'  => get_theme_mod( 'infinity_blog_facebook' ),
                    'icon' => 'facebook-f',
                    'name' => 'Facebook'
                ),
                'twitter'   => array(
                    'url'  => get_theme_mod( 'infinity_blog_twitter' ),
                    'icon' => 'twitter',
                    'name' => 'Twitter'
                ),
                'instagram' => array(
                    'url'  => get_theme_mod( 'infinity_blog_instagram' ),
                    'icon' => 'instagram',
                    'name' => 'Instagram'
                ),
                'youtube'   => array(
                    'url'  => get_theme_mod( 'infinity_blog_youtube' ),
                    'icon' => 'youtube',
                    'name' => 'YouTube'
                ),
                'linkedin'  => array(
                    'url'  => get_theme_mod( 'infinity_blog_linkedin' ),
                    'icon' => 'linkedin-in',
                    'name' => 'LinkedIn'
                ),
                'pinterest' => array(
                    'url'  => get_theme_mod( 'infinity_blog_pinterest' ),
                    'icon' => 'pinterest-p',
                    'name' => 'Pinterest'
                ),
            );

            foreach ( $social_platforms as $platform ) {
                if ( ! empty( $platform['url'] ) ) {
                    echo '<a href="' . esc_url( $platform['url'] ) . '" target="_blank" rel="noopener noreferrer" class="w-10 h-10 flex items-center justify-center rounded-full bg-gray-100 text-gray-700 hover:bg-red-600 hover:text-white transition-colors duration-300" aria-label="' . esc_attr( $platform['name'] ) . '">';
                    echo '<i class="fab fa-' . esc_attr( $platform['icon'] ) . '"></i>';
                    echo '</a>';
                }
            }
            ?>
        </div>
    </div>

    <!-- Popular Posts Widget -->
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h3 class="text-xl font-bold text-gray-800 mb-4 border-l-4 border-red-600 pl-3"><?php _e( 'Popular Posts', 'infinity-blog' ); ?></h3>
        <div class="space-y-4">
            <?php
            $popular_posts = new WP_Query( array(
                'posts_per_page' => 3,
                'meta_key'       => 'post_views_count',
                'orderby'        => 'meta_value_num',
                'order'          => 'DESC',
                'post_status'    => 'publish',
            ) );

            if ( $popular_posts->have_posts() ) :
                while ( $popular_posts->have_posts() ) : $popular_posts->the_post();
                    ?>
                    <div class="flex items-start space-x-4">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <a href="<?php the_permalink(); ?>" class="flex-shrink-0 w-20 h-20 rounded overflow-hidden">
                                <?php the_post_thumbnail( 'thumbnail', array( 'class' => 'w-full h-full object-cover' ) ); ?>
                            </a>
                        <?php endif; ?>
                        <div>
                            <h4 class="text-sm font-semibold text-gray-800 hover:text-red-600 transition-colors">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h4>
                            <span class="text-xs text-gray-500"><?php echo get_the_date(); ?></span>
                        </div>
                    </div>
                    <?php
                endwhile;
                wp_reset_postdata();
            else :
                echo '<p class="text-gray-500">' . __( 'No popular posts found.', 'infinity-blog' ) . '</p>';
            endif;
            ?>
        </div>
    </div>

    <!-- Categories Widget -->
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h3 class="text-xl font-bold text-gray-800 mb-4 border-l-4 border-red-600 pl-3"><?php _e( 'Categories', 'infinity-blog' ); ?></h3>
        <ul class="space-y-2">
            <?php
            $categories = get_categories( array(
                'orderby' => 'count',
                'order'   => 'DESC',
                'number'  => 6,
            ) );

            foreach ( $categories as $category ) {
                echo '<li class="border-b border-gray-100 pb-2">';
                echo '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" class="flex justify-between items-center text-gray-600 hover:text-red-600 transition-colors">';
                echo '<span>' . esc_html( $category->name ) . '</span>';
                echo '<span class="bg-gray-100 text-xs font-medium px-2 py-1 rounded-full">' . esc_html( $category->count ) . '</span>';
                echo '</a>';
                echo '</li>';
            }
            ?>
        </ul>
    </div>

    <!-- Tags Widget -->
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h3 class="text-xl font-bold text-gray-800 mb-4 border-l-4 border-red-600 pl-3"><?php _e( 'Popular Tags', 'infinity-blog' ); ?></h3>
        <div class="flex flex-wrap gap-2">
            <?php
            $tags = get_tags( array(
                'orderby' => 'count',
                'order'   => 'DESC',
                'number'  => 15,
            ) );

            if ( $tags ) {
                foreach ( $tags as $tag ) {
                    echo '<a href="' . esc_url( get_tag_link( $tag->term_id ) ) . '" class="inline-block px-3 py-1 bg-gray-100 text-sm text-gray-600 rounded-full hover:bg-red-600 hover:text-white transition-colors">' . esc_html( $tag->name ) . '</a>';
                }
            } else {
                echo '<p class="text-gray-500">' . __( 'No tags found.', 'infinity-blog' ) . '</p>';
            }
            ?>
        </div>
    </div>

    <!-- Newsletter Widget -->
    <div class="bg-gradient-to-r from-red-600 to-red-700 p-6 rounded-lg shadow-md text-white">
        <h3 class="text-xl font-bold mb-3"><?php _e( 'Newsletter', 'infinity-blog' ); ?></h3>
        <p class="text-red-100 mb-4"><?php _e( 'Subscribe to our newsletter to get the latest updates.', 'infinity-blog' ); ?></p>
        
        <?php
        if ( function_exists( 'mc4wp_show_form' ) ) {
            mc4wp_show_form();
        } else {
            echo '<form class="space-y-3">';
            echo '<input type="email" placeholder="' . esc_attr__( 'Your email address', 'infinity-blog' ) . '" class="w-full px-4 py-2 rounded text-gray-800 focus:outline-none focus:ring-2 focus:ring-white focus:ring-opacity-50">';
            echo '<button type="submit" class="w-full bg-white text-red-600 font-medium py-2 px-4 rounded hover:bg-gray-100 transition-colors">' . esc_html__( 'Subscribe', 'infinity-blog' ) . '</button>';
            echo '</form>';
        }
        ?>
    </div>

    <!-- Default WordPress Widgets -->
    <?php dynamic_sidebar( 'sidebar-1' ); ?>
</aside>
