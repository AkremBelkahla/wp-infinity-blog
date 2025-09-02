/**
 * Gestion du menu mobile et du bouton de retour en haut
 * Version améliorée pour Infinity Blog 1.1.0
 */
(function($) {
    'use strict';

    // Document ready
    $(document).ready(function() {
        // Menu mobile
        const menuToggle = $('.menu-toggle');
        const primaryMenu = $('.primary-menu');
        const primaryNavigation = $('.primary-navigation');
        
        // Bouton de retour en haut
        const backToTop = $('.back-to-top');
        
        // Créer un overlay pour le menu mobile
        $('body').append('<div class="menu-overlay"></div>');
        const menuOverlay = $('.menu-overlay');
        
        // Toggle du menu mobile
        menuToggle.on('click', function(e) {
            e.preventDefault();
            
            // Basculer l'état du bouton
            const isExpanded = menuToggle.attr('aria-expanded') === 'true';
            menuToggle.attr('aria-expanded', !isExpanded);
            menuToggle.toggleClass('active');
            
            // Basculer la classe active sur le menu
            primaryMenu.toggleClass('active');
            primaryNavigation.toggleClass('active');
            
            // Afficher/masquer l'overlay
            menuOverlay.toggleClass('active');
            
            // Empêcher le défilement du corps lorsque le menu est ouvert
            $('body').toggleClass('menu-open', !isExpanded);
        });
        
        // Fermer le menu lorsque l'overlay est cliqué
        menuOverlay.on('click', function() {
            menuToggle.attr('aria-expanded', 'false').removeClass('active');
            primaryMenu.removeClass('active');
            primaryNavigation.removeClass('active');
            menuOverlay.removeClass('active');
            $('body').removeClass('menu-open');
        });
        
        // Fermer le menu lorsqu'un lien est cliqué (pour les ancres)
        primaryMenu.on('click', 'a', function() {
            if ($(this).closest('.menu-item-has-children').length === 0) {
                menuToggle.attr('aria-expanded', 'false').removeClass('active');
                primaryMenu.removeClass('active');
                primaryNavigation.removeClass('active');
                menuOverlay.removeClass('active');
                $('body').removeClass('menu-open');
            }
        });
        
        // Fermer le menu avec la touche Escape
        $(document).on('keyup', function(e) {
            if (e.key === 'Escape' && menuToggle.attr('aria-expanded') === 'true') {
                menuToggle.attr('aria-expanded', 'false').removeClass('active');
                primaryMenu.removeClass('active');
                primaryNavigation.removeClass('active');
                menuOverlay.removeClass('active');
                $('body').removeClass('menu-open');
            }
        });
        
        // Bouton de retour en haut avec debounce pour améliorer les performances
        let scrollTimer;
        $(window).on('scroll', function() {
            clearTimeout(scrollTimer);
            scrollTimer = setTimeout(function() {
                if ($(window).scrollTop() > 300) {
                    backToTop.addClass('visible');
                } else {
                    backToTop.removeClass('visible');
                }
            }, 100);
        });
        
        // Animation fluide vers le haut
        backToTop.on('click', function(e) {
            e.preventDefault();
            $('html, body').animate({ scrollTop: 0 }, 600);
            return false;
        });
        
        // Gestion des sous-menus sur mobile
        $('.menu-item-has-children > a').after('<button class="submenu-toggle" aria-expanded="false"><span class="screen-reader-text">' + infinity_blog_vars.toggle_submenu + '</span><span class="dashicons dashicons-arrow-down"></span></button>');
        
        $('.submenu-toggle').on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const $this = $(this);
            const submenu = $this.next('.sub-menu');
            const isExpanded = $this.attr('aria-expanded') === 'true';
            
            // Fermer tous les autres sous-menus au même niveau
            $this.parent().siblings('.menu-item-has-children').find('.submenu-toggle').attr('aria-expanded', 'false').removeClass('active');
            $this.parent().siblings('.menu-item-has-children').find('.sub-menu').slideUp(200).removeClass('active');
            
            // Basculer l'état du bouton et du sous-menu actuel
            $this.attr('aria-expanded', !isExpanded).toggleClass('active');
            submenu.slideToggle(200).toggleClass('active');
        });
        
        // Ajuster la hauteur du menu en cas de redimensionnement
        $(window).on('resize', function() {
            if ($(window).width() > 768) {
                primaryMenu.removeAttr('style');
                primaryNavigation.removeClass('active');
                menuToggle.attr('aria-expanded', 'false').removeClass('active');
                menuOverlay.removeClass('active');
                $('body').removeClass('menu-open');
            }
        });
    });
    
})(jQuery);
