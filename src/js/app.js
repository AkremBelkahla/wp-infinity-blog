/**
 * Fichier JavaScript principal
 */

// Gestion du menu mobile
document.addEventListener('DOMContentLoaded', function() {
  // Sélectionner les éléments du menu
  const menuToggle = document.querySelector('.menu-toggle');
  const primaryNav = document.querySelector('.primary-navigation');
  const menuOverlay = document.querySelector('.menu-overlay');
  
  if (menuToggle) {
    menuToggle.addEventListener('click', function() {
      // Toggle la classe active sur le bouton
      this.classList.toggle('active');
      
      // Toggle la classe active sur la navigation
      if (primaryNav) {
        primaryNav.classList.toggle('active');
      }
      
      // Toggle la classe menu-open sur le body
      document.body.classList.toggle('menu-open');
      
      // Toggle l'attribut aria-expanded
      const expanded = this.getAttribute('aria-expanded') === 'true' || false;
      this.setAttribute('aria-expanded', !expanded);
      
      // Toggle la visibilité de l'overlay
      if (menuOverlay) {
        menuOverlay.style.opacity = expanded ? '0' : '1';
        menuOverlay.style.visibility = expanded ? 'hidden' : 'visible';
      }
    });
  }
  
  // Gestion des sous-menus sur mobile
  const submenuToggles = document.querySelectorAll('.submenu-toggle');
  
  submenuToggles.forEach(toggle => {
    toggle.addEventListener('click', function(e) {
      e.preventDefault();
      
      // Toggle la classe active sur le bouton
      this.classList.toggle('active');
      
      // Trouver le sous-menu associé
      const submenu = this.nextElementSibling || this.parentNode.querySelector('.sub-menu');
      
      if (submenu) {
        submenu.classList.toggle('active');
        
        // Toggle l'attribut aria-expanded
        const expanded = this.getAttribute('aria-expanded') === 'true' || false;
        this.setAttribute('aria-expanded', !expanded);
      }
    });
  });
  
  // Gestion du header sticky
  const header = document.querySelector('.site-header');
  
  if (header) {
    window.addEventListener('scroll', function() {
      if (window.scrollY > 50) {
        header.classList.add('scrolled');
      } else {
        header.classList.remove('scrolled');
      }
    });
  }
  
  // Bouton retour en haut
  const backToTopButton = document.querySelector('.back-to-top');
  
  if (backToTopButton) {
    window.addEventListener('scroll', function() {
      if (window.scrollY > 300) {
        backToTopButton.classList.add('visible');
      } else {
        backToTopButton.classList.remove('visible');
      }
    });
    
    backToTopButton.addEventListener('click', function(e) {
      e.preventDefault();
      window.scrollTo({
        top: 0,
        behavior: 'smooth'
      });
    });
  }
});

// Support pour les blocs FSE
if (window.wp && window.wp.blocks) {
  // Personnalisations pour l'éditeur FSE
  wp.domReady(function() {
    // Ajouter des styles personnalisés aux blocs
    wp.blocks.registerBlockStyle('core/button', {
      name: 'primary',
      label: 'Primary'
    });
    
    wp.blocks.registerBlockStyle('core/button', {
      name: 'secondary',
      label: 'Secondary'
    });
    
    wp.blocks.registerBlockStyle('core/group', {
      name: 'card',
      label: 'Card'
    });
    
    wp.blocks.registerBlockStyle('core/image', {
      name: 'rounded',
      label: 'Rounded'
    });
  });
}
