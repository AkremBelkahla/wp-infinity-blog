/**
 * Gestion du menu mobile et du bouton de retour en haut
 */
(function($) {
    'use strict';

    // Document ready
    $(document).ready(function() {
        // Menu mobile
        const menuToggle = $('.menu-toggle');
        const primaryMenu = $('.primary-menu');
        
        // Bouton de retour en haut
        const backToTop = $('.back-to-top');
        
        // Toggle du menu mobile
        menuToggle.on('click', function(e) {
            e.preventDefault();
            
            // Basculer l'état du bouton
            const isExpanded = menuToggle.attr('aria-expanded') === 'true';
            menuToggle.attr('aria-expanded', !isExpanded);
            
            // Basculer la classe active sur le menu
            primaryMenu.toggleClass('active');
            
            // Empêcher le défilement du corps lorsque le menu est ouvert
            $('body').toggleClass('menu-open', !isExpanded);
        });
        
        // Fermer le menu lorsqu'un lien est cliqué (pour les ancres)
        primaryMenu.on('click', 'a', function() {
            if ($(this).closest('.menu-item-has-children').length === 0) {
                menuToggle.attr('aria-expanded', 'false');
                primaryMenu.removeClass('active');
                $('body').removeClass('menu-open');
            }
        });
        
        // Bouton de retour en haut
        $(window).on('scroll', function() {
            if ($(this).scrollTop() > 300) {
                backToTop.addClass('visible');
            } else {
                backToTop.removeClass('visible');
            }
        });
        
        // Animation fluide vers le haut
        backToTop.on('click', function(e) {
            e.preventDefault();
            $('html, body').animate({ scrollTop: 0 }, 'smooth');
            return false;
        });
        
        // Gestion des sous-menus sur mobile
        $('.menu-item-has-children > a').after('<button class="submenu-toggle" aria-expanded="false"><span class="screen-reader-text">' + infinity_blog_vars.toggle_submenu + '</span><span class="dashicons dashicons-arrow-down"></span></button>');
        
        $('.submenu-toggle').on('click', function() {
            const $this = $(this);
            const submenu = $this.prev('a').next('.sub-menu');
            const isExpanded = $this.attr('aria-expanded') === 'true';
            
            $this.attr('aria-expanded', !isExpanded);
            submenu.slideToggle(200);
        });
    });
    
})(jQuery);
