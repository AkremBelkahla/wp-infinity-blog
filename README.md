# Thème WordPress Infinity Blog v1.2.0

Un thème WordPress moderne et réactif conçu pour les blogs et les sites d'actualités avec un système de commentaires avancé, une compatibilité complète avec l'Édition Complète de Site (FSE), intégration de TailwindCSS et des optimisations de performance.

## Fonctionnalités principales

### 🌍 Édition Complète de Site (FSE)
- **Compatibilité totale** avec l'éditeur de site WordPress
- **Modèles FSE** prédéfinis (index, single, page, archive)
- **Parts de thème** réutilisables (header, footer, sidebar)
- **Patterns personnalisés** pour une construction rapide de pages
- **Styles globaux** via theme.json

### 🎨 Intégration TailwindCSS
- **Utilitaires CSS** puissants pour un développement rapide
- **Thème responsive** adapté à tous les appareils
- **Personnalisation facile** des couleurs et styles
- **Optimisation automatique** des CSS pour la production

### 🚀 Système de commentaires avancé
- **Soumission AJAX** des commentaires sans rechargement de page
- **Édition en ligne** des commentaires
- **Chargement infini** des commentaires
- **Notifications** visuelles pour les actions utilisateur
- **Validation en temps réel** des champs du formulaire
- **Prévisualisation** des commentaires avant envoi

### 🌈 Personnalisation
- **Édition visuelle complète** via l'éditeur de site WordPress
- **Modèles de page flexibles** avec ou sans barre latérale
- **Support complet de l'éditeur Gutenberg**
  - Styles de blocs natifs optimisés avec TailwindCSS
  - Palette de couleurs personnalisée via theme.json
  - Tailles de police personnalisées
  - Support des alignements larges et pleine largeur
- Design responsive amélioré pour tous les appareils
  - Menu mobile optimisé avec animations
  - Gestion des sous-menus tactiles
  - Interface adaptative sur tous les écrans

### 🔒 Sécurité
- Protection contre les soumissions multiples
- Vérification des nonces pour toutes les actions AJAX
- Validation côté client et serveur
- Protection contre le spam
- En-têtes de sécurité HTTP avancés
- Protection contre les injections SQL
- Limitation des tentatives de connexion
- Désactivation des fonctionnalités WordPress vulnérables
- Content Security Policy (CSP) intégrée

## Installation

1. Téléchargez le dossier du thème
2. Placez-le dans le répertoire `/wp-content/themes/`
3. Activez le thème via le menu 'Apparence > Thèmes' dans WordPress

### Installation des dépendances de développement

Pour travailler sur le thème et compiler les assets :

```bash
# Installer les dépendances
npm install

# Développement avec compilation à la volée
npm run watch

# Compilation pour la production
npm run build
```
### ⚡ Performance
- Chargement différé des images (lazy loading)
- Préchargement DNS pour les ressources externes
- Désactivation des emojis WordPress pour réduire les requêtes HTTP
- Chargement différé des scripts non critiques
- Optimisation des ressources CSS et JavaScript

## Configuration requise

- WordPress 5.9 ou version ultérieure (pour le support FSE)
- PHP 7.4 ou version ultérieure
- MySQL 5.6 ou version ultérieure
- Node.js 14+ (pour le développement uniquement)

## Personnalisation

### Édition de site (FSE)

Le thème est entièrement compatible avec l'édition de site (FSE) de WordPress. Vous pouvez personnaliser tous les aspects du thème via l'éditeur de site :

- Modèles de page (templates)
- Parts de thème (header, footer, sidebar)
- Styles globaux (couleurs, typographie, espacement)
- Patterns réutilisables

### TailwindCSS

Le thème utilise TailwindCSS pour les styles. Pour personnaliser les styles :

1. Modifiez le fichier `tailwind.config.js` pour ajuster les couleurs, espacement, etc.
2. Modifiez les fichiers CSS dans le dossier `src/css`
3. Exécutez `npm run build` pour compiler les styles

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

// Personnaliser les scripts à charger en différé
add_filter('infinity_blog_defer_scripts', function($scripts) {
    $scripts[] = 'mon-script-personnalise';
    return $scripts;
});

// Ajouter des patterns personnalisés
add_action('init', function() {
    register_block_pattern(
        'infinity-blog/custom-pattern',
        array(
            'title'       => __('Mon Pattern Personnalisé', 'infinity-blog'),
            'description' => __('Un pattern personnalisé pour mon site.', 'infinity-blog'),
            'content'     => '<!-- wp:paragraph --><p>Mon contenu personnalisé</p><!-- /wp:paragraph -->',
            'categories'  => array('featured')
        )
    );

// Modifier la palette de couleurs de l'éditeur
add_filter('infinity_blog_editor_color_palette', function($colors) {
    $colors[] = array(
        'slug'  => 'ma-couleur',
        'color' => '#ff6b6b',
    );
    return $colors;
});

Ce thème est sous licence GPL v2 ou ultérieure.

## Crédits

- Développé par l'équipe Infinity Blog
- Icônes par [Font Awesome](https://fontawesome.com/) et [Dashicons](https://developer.wordpress.org/resource/dashicons/)
- Polices Google Fonts intégrées
- Styles CSS par [TailwindCSS](https://tailwindcss.com/)
- Compilation des assets avec [Laravel Mix](https://laravel-mix.com/)

---

## Changelog

### Version 1.2.0
- Ajout du support complet pour l'Édition Complète de Site (FSE)
- Intégration de TailwindCSS pour les styles
- Création de modèles et parts de thème FSE
- Ajout de patterns réutilisables
- Refonte du système de styles avec theme.json
- Optimisation des performances avec compilation des assets

### Version 1.1.0
- Ajout du support complet pour les blocs WordPress (Gutenberg)
- Amélioration de la compatibilité mobile et de l'expérience utilisateur
- Optimisation des performances (lazy loading, defer scripts, etc.)
- Renforcement de la sécurité (en-têtes HTTP, protection contre les injections, etc.)
- Mise à jour du menu mobile avec gestion améliorée des sous-menus

### Version 1.0.0
- Version initiale

---

*Dernière mise à jour : 29 septembre 2025*
