/**
 * Gestion du menu mobile et du bouton de retour en haut
 * Version améliorée pour Infinity Blog 1.2.0
 */
(function() {
    'use strict';

    // Attendre que le DOM soit chargé
    document.addEventListener('DOMContentLoaded', function() {
        // Menu mobile
        const menuToggle = document.querySelector('.menu-toggle');
        const primaryMenu = document.querySelector('.primary-menu');
        const primaryNavigation = document.querySelector('.primary-navigation');
        
        // Bouton de retour en haut
        const backToTop = document.querySelector('.back-to-top');
        
        // Créer un overlay pour le menu mobile s'il n'existe pas déjà
        if (!document.querySelector('.menu-overlay')) {
            const overlay = document.createElement('div');
            overlay.className = 'menu-overlay';
            document.body.appendChild(overlay);
        }
        const menuOverlay = document.querySelector('.menu-overlay');
        
        // Toggle du menu mobile
        if (menuToggle) {
            menuToggle.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Basculer l'état du bouton
                const isExpanded = menuToggle.getAttribute('aria-expanded') === 'true';
                menuToggle.setAttribute('aria-expanded', !isExpanded);
                menuToggle.classList.toggle('active');
                
                // Basculer la classe active sur le menu
                if (primaryMenu) primaryMenu.classList.toggle('active');
                if (primaryNavigation) primaryNavigation.classList.toggle('active');
                
                // Afficher/masquer l'overlay
                if (menuOverlay) menuOverlay.classList.toggle('active');
                
                // Empêcher le défilement du corps lorsque le menu est ouvert
                document.body.classList.toggle('menu-open', !isExpanded);
            });
        }
        
        // Fermer le menu lorsque l'overlay est cliqué
        if (menuOverlay) {
            menuOverlay.addEventListener('click', function() {
                if (menuToggle) {
                    menuToggle.setAttribute('aria-expanded', 'false');
                    menuToggle.classList.remove('active');
                }
                if (primaryMenu) primaryMenu.classList.remove('active');
                if (primaryNavigation) primaryNavigation.classList.remove('active');
                menuOverlay.classList.remove('active');
                document.body.classList.remove('menu-open');
            });
        }
        
        // Fermer le menu lorsqu'un lien est cliqué (pour les ancres)
        if (primaryMenu) {
            const menuLinks = primaryMenu.querySelectorAll('a');
            menuLinks.forEach(link => {
                link.addEventListener('click', function() {
                    if (!this.closest('.menu-item-has-children')) {
                        if (menuToggle) {
                            menuToggle.setAttribute('aria-expanded', 'false');
                            menuToggle.classList.remove('active');
                        }
                        if (primaryMenu) primaryMenu.classList.remove('active');
                        if (primaryNavigation) primaryNavigation.classList.remove('active');
                        if (menuOverlay) menuOverlay.classList.remove('active');
                        document.body.classList.remove('menu-open');
                    }
                });
            });
        }
        
        // Fermer le menu avec la touche Escape
        document.addEventListener('keyup', function(e) {
            if (e.key === 'Escape' && menuToggle && menuToggle.getAttribute('aria-expanded') === 'true') {
                menuToggle.setAttribute('aria-expanded', 'false');
                menuToggle.classList.remove('active');
                if (primaryMenu) primaryMenu.classList.remove('active');
                if (primaryNavigation) primaryNavigation.classList.remove('active');
                if (menuOverlay) menuOverlay.classList.remove('active');
                document.body.classList.remove('menu-open');
            }
        });
        
        // Bouton de retour en haut avec debounce pour améliorer les performances
        let scrollTimer;
        if (backToTop) {
            window.addEventListener('scroll', function() {
                clearTimeout(scrollTimer);
                scrollTimer = setTimeout(function() {
                    if (window.scrollY > 300) {
                        backToTop.classList.add('visible');
                    } else {
                        backToTop.classList.remove('visible');
                    }
                }, 100);
            });
            
            // Animation fluide vers le haut
            backToTop.addEventListener('click', function(e) {
                e.preventDefault();
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
                return false;
            });
        }
        
        // Gestion des sous-menus sur mobile
        const menuItemsWithChildren = document.querySelectorAll('.menu-item-has-children > a');
        menuItemsWithChildren.forEach(item => {
            // Créer le bouton de toggle pour les sous-menus
            const toggleButton = document.createElement('button');
            toggleButton.className = 'submenu-toggle';
            toggleButton.setAttribute('aria-expanded', 'false');
            
            // Ajouter le texte d'accessibilité
            const toggleText = document.createElement('span');
            toggleText.className = 'screen-reader-text';
            toggleText.textContent = window.infinity_blog_vars ? window.infinity_blog_vars.toggle_submenu : 'Toggle submenu';
            toggleButton.appendChild(toggleText);
            
            // Ajouter l'icône
            const toggleIcon = document.createElement('span');
            toggleIcon.className = 'dashicons dashicons-arrow-down';
            toggleButton.appendChild(toggleIcon);
            
            // Insérer le bouton après le lien
            item.parentNode.insertBefore(toggleButton, item.nextSibling);
        });
        
        // Ajouter les écouteurs d'événements pour les boutons de sous-menu
        const submenuToggles = document.querySelectorAll('.submenu-toggle');
        submenuToggles.forEach(toggle => {
            toggle.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                const submenu = this.nextElementSibling;
                if (!submenu || !submenu.classList.contains('sub-menu')) return;
                
                const isExpanded = this.getAttribute('aria-expanded') === 'true';
                
                // Fermer tous les autres sous-menus au même niveau
                const parent = this.parentNode;
                const siblings = parent.parentNode.querySelectorAll('.menu-item-has-children');
                siblings.forEach(sibling => {
                    if (sibling !== parent) {
                        const siblingToggle = sibling.querySelector('.submenu-toggle');
                        const siblingSubmenu = sibling.querySelector('.sub-menu');
                        if (siblingToggle) {
                            siblingToggle.setAttribute('aria-expanded', 'false');
                            siblingToggle.classList.remove('active');
                        }
                        if (siblingSubmenu) {
                            siblingSubmenu.style.display = 'none';
                            siblingSubmenu.classList.remove('active');
                        }
                    }
                });
                
                // Basculer l'état du bouton et du sous-menu actuel
                this.setAttribute('aria-expanded', !isExpanded);
                this.classList.toggle('active');
                
                if (isExpanded) {
                    submenu.style.display = 'none';
                    submenu.classList.remove('active');
                } else {
                    submenu.style.display = 'block';
                    submenu.classList.add('active');
                }
            });
        });
        
        // Ajuster la hauteur du menu en cas de redimensionnement
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768) {
                if (primaryMenu) primaryMenu.style.display = '';
                if (primaryNavigation) primaryNavigation.classList.remove('active');
                if (menuToggle) {
                    menuToggle.setAttribute('aria-expanded', 'false');
                    menuToggle.classList.remove('active');
                }
                if (menuOverlay) menuOverlay.classList.remove('active');
                document.body.classList.remove('menu-open');
            }
        });
    });
})();
