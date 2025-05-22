/**
 * Gestion de la navigation mobile
 */
document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.querySelector('.menu-toggle');
    const primaryMenu = document.querySelector('.primary-menu');
    
    if (!menuToggle || !primaryMenu) return;
    
    // Créer les barres d'icônes pour le bouton burger
    const iconBars = [];
    for (let i = 0; i < 3; i++) {
        const bar = document.createElement('span');
        bar.classList.add('icon-bar');
        menuToggle.appendChild(bar);
        iconBars.push(bar);
    }
    
    // Fonction pour basculer le menu
    function toggleMenu() {
        const isExpanded = menuToggle.getAttribute('aria-expanded') === 'true';
        menuToggle.setAttribute('aria-expanded', !isExpanded);
        menuToggle.classList.toggle('active');
        primaryMenu.classList.toggle('active');
        
        // Empêcher le défilement du corps lorsque le menu est ouvert
        document.body.style.overflow = isExpanded ? '' : 'hidden';
    }
    
    // Gestionnaire d'événements pour le bouton de bascule
    menuToggle.addEventListener('click', function(e) {
        e.preventDefault();
        toggleMenu();
    });
    
    // Fermer le menu lorsqu'un lien est cliqué (pour la navigation sur mobile)
    primaryMenu.addEventListener('click', function(e) {
        if (e.target.tagName === 'A') {
            // Petite temporisation pour permettre l'animation
            setTimeout(() => {
                toggleMenu();
            }, 100);
        }
    });
    
    // Fermer le menu lors du redimensionnement de la fenêtre
    let resizeTimer;
    window.addEventListener('resize', function() {
        if (window.innerWidth > 768) {
            // Réinitialiser le menu sur les grands écrans
            menuToggle.classList.remove('active');
            primaryMenu.classList.remove('active');
            menuToggle.setAttribute('aria-expanded', 'false');
            document.body.style.overflow = '';
        }
    });
});
