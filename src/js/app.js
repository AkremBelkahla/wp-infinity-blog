/**
 * Fichier JavaScript principal
 */

// Importer les modules
import './mobile-menu';

// Gestion du header sticky
document.addEventListener('DOMContentLoaded', function() {
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
    
    // Styles pour les sections
    wp.blocks.registerBlockStyle('core/cover', {
      name: 'overlay-primary',
      label: 'Overlay Primary'
    });
    
    wp.blocks.registerBlockStyle('core/columns', {
      name: 'boxed',
      label: 'Boxed'
    });
    
    // Styles pour les paragraphes
    wp.blocks.registerBlockStyle('core/paragraph', {
      name: 'lead',
      label: 'Lead'
    });
  });
}
