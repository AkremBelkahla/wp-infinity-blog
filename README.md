# Thème WordPress Infinity Blog

Un thème WordPress moderne et réactif conçu pour les blogs et les sites d'actualités avec un système de commentaires avancé.

## Fonctionnalités principales

### 🚀 Système de commentaires avancé
- **Soumission AJAX** des commentaires sans rechargement de page
- **Édition en ligne** des commentaires
- **Réponses en contexte** avec prévisualisation en temps réel
- **Chargement infini** des commentaires
- **Notifications** visuelles pour les actions utilisateur
- **Validation en temps réel** des champs du formulaire
- **Prévisualisation** des commentaires avant envoi

### 🎨 Personnalisation
- Interface personnalisable via le WordPress Customizer
- Support des mises en page flexibles
- Compatible avec l'éditeur Gutenberg
- Design responsive pour tous les appareils
- Optimisé pour la vitesse de chargement

### 🔒 Sécurité
- Protection contre les soumissions multiples
- Vérification des nonces pour toutes les actions AJAX
- Validation côté client et serveur
- Protection contre le spam

## Installation

1. Téléchargez le dossier du thème
2. Placez-le dans le répertoire `/wp-content/themes/`
3. Activez le thème via le menu 'Apparence > Thèmes' dans WordPress

## Configuration requise

- WordPress 5.8 ou version ultérieure
- PHP 7.4 ou version ultérieure
- MySQL 5.6 ou version ultérieure

## Personnalisation

### Options du Customizer

Le thème propose plusieurs options de personnalisation via l'interface du WordPress Customizer :

- Couleurs du thème
- Typographie
- Mise en page
- En-tête et pied de page
- Paramètres des commentaires

### Filtres et actions

Le thème inclut plusieurs filtres et actions pour les développeurs :

```php
// Désactiver le chargement infini des commentaires
add_filter('infinity_blog_infinite_comments', '__return_false');

// Personnaliser les messages de notification
add_filter('infinity_blog_comment_notices', function($messages) {
    $messages['success'] = 'Votre commentaire a été publié avec succès !';
    return $messages;
});
```

## Support

Pour le support technique, veuillez ouvrir une issue sur le dépôt GitHub ou contactez-nous via notre site web.

## Licence

Ce thème est sous licence GPL v2 ou ultérieure.

## Crédits

- Développé par l'équipe Infinity Blog
- Icônes par [Font Awesome](https://fontawesome.com/)
- Polices Google Fonts intégrées

---

*Dernière mise à jour : 22 mai 2024*
