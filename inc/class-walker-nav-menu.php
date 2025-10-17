<?php
/**
 * Custom navigation walker class for the theme.
 *
 * @package Infinity_Blog
 */

if ( ! class_exists( 'Infinity_Blog_Walker_Nav_Menu' ) ) {
    /**
     * Custom Walker for navigation menus with TailwindCSS classes.
     *
     * @since 1.0.0
     */
    class Infinity_Blog_Walker_Nav_Menu extends Walker_Nav_Menu {
        
        /**
         * Starts the element output.
         *
         * @since 1.0.0
         *
         * @param string   $output Used to append additional content (passed by reference).
         * @param WP_Post  $item   Menu item data object.
         * @param int      $depth  Depth of menu item. Used for padding.
         * @param stdClass $args   An object of wp_nav_menu() arguments.
         * @param int      $id     Current item ID.
         */
        public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
            $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

            $classes = empty( $item->classes ) ? array() : (array) $item->classes;
            $classes[] = 'menu-item-' . $item->ID;
            $classes[] = 'px-4 py-2 hover:bg-gray-900 rounded transition-colors duration-200';

            if ( in_array( 'current-menu-item', $classes, true ) ) {
                $classes[] = 'text-white';
            } else {
                $classes[] = 'text-gray-400 hover:text-white';
            }

            $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
            $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

            $id = apply_filters( 'nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth );
            $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

            $output .= $indent . '<li' . $id . $class_names . '>';

            $atts = array();
            $atts['title'] = ! empty( $item->attr_title ) ? $item->attr_title : '';
            $atts['target'] = ! empty( $item->target ) ? $item->target : '';
            if ( '_blank' === $item->target && empty( $item->xfn ) ) {
                $atts['rel'] = 'noopener';
            } else {
                $atts['rel'] = $item->xfn;
            }
            $atts['href'] = ! empty( $item->url ) ? $item->url : '';
            $atts['aria-current'] = $item->current ? 'page' : '';
            $atts['class'] = 'block w-full';

            $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

            $attributes = '';
            foreach ( $atts as $attr => $value ) {
                if ( is_scalar( $value ) && '' !== $value && false !== $value ) {
                    $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                    $attributes .= ' ' . $attr . '="' . $value . '"';
                }
            }

            $title = apply_filters( 'the_title', $item->title, $item->ID );
            $title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );

            $item_output = $args->before;
            $item_output .= '<a' . $attributes . '>';
            $item_output .= $args->link_before . $title . $args->link_after;
            $item_output .= '</a>';
            $item_output .= $args->after;

            $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
        }

        /**
         * Starts the list before the elements are added.
         *
         * @since 1.0.0
         *
         * @param string   $output Used to append additional content (passed by reference).
         * @param int      $depth  Depth of menu item. Used for padding.
         * @param stdClass $args   An object of wp_nav_menu() arguments.
         */
        public function start_lvl( &$output, $depth = 0, $args = null ) {
            $indent = str_repeat( "\t", $depth );
            $output .= "\n";
            $output .= $indent;
            $output .= '<ul class="sub-menu bg-gray-900 p-2 rounded shadow-lg">';
            $output .= "\n";
        }

        /**
         * Ends the list of after the elements are added.
         *
         * @since 1.0.0
         *
         * @param string   $output Used to append additional content (passed by reference).
         * @param int      $depth  Depth of menu item. Used for padding.
         * @param stdClass $args   An object of wp_nav_menu() arguments.
         */
        public function end_lvl( &$output, $depth = 0, $args = null ) {
            $indent = str_repeat( "\t", $depth );
            $output .= $indent . '</ul>' . "\n";
        }
    }
}
