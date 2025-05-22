/**
 * Fonctionnalités du personnalisateur pour Infinity Blog
 * Gère les interactions en temps réel dans le personnalisateur de thème WordPress
 */
(function($) {
    'use strict';

    // Vérifier si l'objet wp est disponible (nécessaire pour le customizer)
    if (typeof wp === 'undefined' || typeof wp.customize === 'undefined') {
        console.warn('WordPress Customizer API not available. Customizer features disabled.');
        return;
    }

    // Sélecteurs CSS pour une meilleure maintenabilité
    const selectors = {
        body: 'body',
        header: '.site-header',
        footer: '.site-footer',
        content: '.site-content',
        main: '.site-main',
        sidebar: '.sidebar',
        buttons: 'button, .button, input[type="button"], input[type="submit"]',
        links: 'a',
        headings: 'h1, h2, h3, h4, h5, h6',
        blockquotes: 'blockquote',
        code: 'code, pre',
        tables: 'table',
        images: 'img',
        forms: 'input, textarea, select',
        siteTitle: '.site-title',
        siteDescription: '.site-description',
        menuPrimary: '.main-navigation',
        menuFooter: '.footer-navigation',
        entryTitle: '.entry-title',
        entryContent: '.entry-content',
        entryMeta: '.entry-meta',
        comments: '.comments-area',
        widgets: '.widget',
        searchForm: '.search-form',
        navigation: '.navigation',
        pagination: '.pagination',
        breadcrumbs: '.breadcrumbs',
        authorBio: '.author-bio',
        relatedPosts: '.related-posts',
        postNavigation: '.post-navigation',
        commentNavigation: '.comment-navigation'
    };

    // Fonction utilitaire pour mettre à jour les propriétés CSS
    function updateCSS(selector, property, value, unit = '') {
        $(selector).css(property, value + unit);
    }

    // Fonction utilitaire pour mettre à jour les variables CSS personnalisées
    function updateCSSVar(varName, value, unit = '') {
        document.documentElement.style.setProperty('--' + varName, value + unit);
    }

    // Prise en charge du rafraîchissement en direct pour les contrôles du personnalisateur
    wp.customize.bind('ready', function() {
        // Prévisualisation des couleurs
        const colors = [
            'primary_color',
            'secondary_color',
            'text_color',
            'background_color',
            'header_background',
            'footer_background',
            'link_color',
            'link_hover_color',
            'button_background',
            'button_text_color',
            'button_hover_background',
            'button_hover_text_color',
            'border_color',
            'heading_color',
            'meta_color',
            'widget_background',
            'widget_title_color',
            'widget_text_color',
            'widget_link_color',
            'widget_link_hover_color',
            'menu_link_color',
            'menu_link_hover_color',
            'submenu_background',
            'submenu_link_color',
            'submenu_link_hover_color',
            'footer_widgets_background',
            'footer_widgets_text_color',
            'footer_widgets_link_color',
            'footer_widgets_link_hover_color',
            'footer_background',
            'footer_text_color',
            'footer_link_color',
            'footer_link_hover_color'
        ];

        colors.forEach(function(color) {
            wp.customize(color, function(value) {
                value.bind(function(to) {
                    const cssVar = color.replace(/_/g, '-');
                    updateCSSVar(cssVar, to);
                });
            });
        });

        // Gestion de la typographie
        const typographySettings = [
            { setting: 'body_font_family', selector: selectors.body, property: 'font-family' },
            { setting: 'headings_font_family', selector: selectors.headings, property: 'font-family' },
            { setting: 'body_font_size', selector: selectors.body, property: 'font-size', unit: 'px' },
            { setting: 'body_line_height', selector: selectors.body, property: 'line-height' },
            { setting: 'body_letter_spacing', selector: selectors.body, property: 'letter-spacing', unit: 'px' },
            { setting: 'headings_font_weight', selector: selectors.headings, property: 'font-weight' },
            { setting: 'headings_line_height', selector: selectors.headings, property: 'line-height' },
            { setting: 'headings_letter_spacing', selector: selectors.headings, property: 'letter-spacing', unit: 'px' },
            { setting: 'h1_font_size', selector: 'h1', property: 'font-size', unit: 'px' },
            { setting: 'h2_font_size', selector: 'h2', property: 'font-size', unit: 'px' },
            { setting: 'h3_font_size', selector: 'h3', property: 'font-size', unit: 'px' },
            { setting: 'h4_font_size', selector: 'h4', property: 'font-size', unit: 'px' },
            { setting: 'h5_font_size', selector: 'h5', property: 'font-size', unit: 'px' },
            { setting: 'h6_font_size', selector: 'h6', property: 'font-size', unit: 'px' }
        ];

        typographySettings.forEach(function(item) {
            wp.customize(item.setting, function(value) {
                value.bind(function(to) {
                    updateCSS(item.selector, item.property, to, item.unit || '');
                });
            });
        });

        // Gestion des espacements
        const spacingSettings = [
            { setting: 'container_width', selector: '.container', property: 'max-width', unit: 'px' },
            { setting: 'content_width', selector: selectors.content, property: 'max-width', unit: 'px' },
            { setting: 'content_padding', selector: selectors.content, property: 'padding', unit: 'px' },
            { setting: 'section_spacing', selector: 'section', property: 'margin-bottom', unit: 'px' },
            { setting: 'element_spacing', selector: 'p, ul, ol, dl, figure, pre, table, fieldset', property: 'margin-bottom', unit: 'px' },
            { setting: 'widget_spacing', selector: '.widget', property: 'margin-bottom', unit: 'px' },
            { setting: 'header_padding', selector: selectors.header, property: 'padding', unit: 'px' },
            { setting: 'footer_padding', selector: selectors.footer, property: 'padding', unit: 'px' },
            { setting: 'button_padding', selector: selectors.buttons, property: 'padding', unit: 'px' },
            { setting: 'input_padding', selector: 'input[type="text"], input[type="email"], input[type="url"], input[type="password"], input[type="search"], input[type="number"], input[type="tel"], input[type="range"], input[type="date"], input[type="month"], input[type="week"], input[type="time"], input[type="datetime"], input[type="datetime-local"], input[type="color"], textarea, select', property: 'padding', unit: 'px' }
        ];

        spacingSettings.forEach(function(item) {
            wp.customize(item.setting, function(value) {
                value.bind(function(to) {
                    updateCSS(item.selector, item.property, to, item.unit || '');
                });
            });
        });

        // Gestion des bordures
        const borderSettings = [
            { setting: 'border_radius', varName: 'border-radius', unit: 'px' },
            { setting: 'border_width', varName: 'border-width', unit: 'px' },
            { setting: 'border_style', varName: 'border-style' },
            { setting: 'border_color', varName: 'border-color' }
        ];

        borderSettings.forEach(function(item) {
            wp.customize(item.setting, function(value) {
                value.bind(function(to) {
                    updateCSSVar(item.varName, to, item.unit || '');
                });
            });
        });

        // Gestion des boutons
        wp.customize('button_style', function(value) {
            value.bind(function(to) {
                $(selectors.buttons).removeClass('button-style-1 button-style-2 button-style-3')
                                 .addClass('button-style-' + to);
            });
        });

        // Gestion des liens
        wp.customize('link_style', function(value) {
            value.bind(function(to) {
                $(selectors.links).removeClass('link-style-1 link-style-2 link-style-3')
                                .addClass('link-style-' + to);
            });
        });

        // Gestion de la mise en page
        wp.customize('layout_style', function(value) {
            value.bind(function(to) {
                $(selectors.body).removeClass('layout-boxed layout-wide')
                               .addClass('layout-' + to);
            });
        });

        // Gestion de la position de la barre latérale
        wp.customize('sidebar_position', function(value) {
            value.bind(function(to) {
                const $content = $(selectors.content);
                const $sidebar = $(selectors.sidebar);
                
                // Supprimer les classes existantes
                $content.removeClass('content-left content-right content-full');
                $sidebar.removeClass('sidebar-left sidebar-right');
                
                // Ajouter les nouvelles classes
                if (to === 'left') {
                    $content.addClass('content-right');
                    $sidebar.addClass('sidebar-left');
                } else if (to === 'right') {
                    $content.addClass('content-left');
                    $sidebar.addClass('sidebar-right');
                } else {
                    $content.addClass('content-full');
                }
            });
        });

        // Gestion de la largeur de la barre latérale
        wp.customize('sidebar_width', function(value) {
            value.bind(function(to) {
                updateCSSVar('sidebar-width', to, '%');
            });
        });

        // Gestion de l'image d'en-tête
        wp.customize('header_image', function(value) {
            value.bind(function(to) {
                if (to) {
                    $(selectors.header).css('background-image', 'url(' + to + ')');
                } else {
                    $(selectors.header).css('background-image', 'none');
                }
            });
        });

        // Gestion de l'image d'arrière-plan
        wp.customize('background_image', function(value) {
            value.bind(function(to) {
                if (to) {
                    $(selectors.body).css('background-image', 'url(' + to + ')');
                } else {
                    $(selectors.body).css('background-image', 'none');
                }
            });
        });

        // Gestion du logo personnalisé
        wp.customize('custom_logo', function(value) {
            value.bind(function(to) {
                if (to) {
                    $('.site-logo').html('<img src="' + to + '" alt="' + wp.customize('blogname')() + '">');
                } else {
                    $('.site-logo').text(wp.customize('blogname')());
                }
            });
        });

        // Mise à jour du texte du site
        wp.customize('blogname', function(value) {
            value.bind(function(to) {
                $('.site-title a').text(to);
            });
        });

        wp.customize('blogdescription', function(value) {
            value.bind(function(to) {
                $('.site-description').text(to);
            });
        });

        // Gestion de l'accessibilité
        const accessibilitySettings = [
            { setting: 'focus_visible', varName: 'focus-visible', value: '2px solid #0073aa' },
            { setting: 'skip_link_selector', selector: '.skip-link', property: 'display' },
            { setting: 'skip_link_bg', selector: '.skip-link', property: 'background-color' },
            { setting: 'skip_link_color', selector: '.skip-link', property: 'color' },
            { setting: 'contrast_ratio', varName: 'contrast-ratio', value: '4.5' }
        ];

        accessibilitySettings.forEach(function(item) {
            wp.customize(item.setting, function(value) {
                value.bind(function(to) {
                    if (item.varName) {
                        updateCSSVar(item.varName, to || item.value);
                    }
                    if (item.selector && item.property) {
                        updateCSS(item.selector, item.property, to);
                    }
                });
            });
        });

        // Gestion de la réactivité
        const breakpoints = {
            mobile: '480px',
            tablet: '768px',
            desktop: '1024px',
            large: '1200px'
        };

        // Mise à jour des variables CSS pour les points de rupture
        Object.entries(breakpoints).forEach(([name, size]) => {
            updateCSSVar('breakpoint-' + name, size);
        });

        // Gestion des tailles de police réactives
        const responsiveFontSizes = [
            { setting: 'h1_font_size_mobile', selector: 'h1', size: '2rem' },
            { setting: 'h2_font_size_mobile', selector: 'h2', size: '1.8rem' },
            { setting: 'h3_font_size_mobile', selector: 'h3', size: '1.6rem' },
            { setting: 'h4_font_size_mobile', selector: 'h4', size: '1.4rem' },
            { setting: 'h5_font_size_mobile', selector: 'h5', size: '1.2rem' },
            { setting: 'h6_font_size_mobile', selector: 'h6', size: '1rem' },
            { setting: 'body_font_size_mobile', selector: 'body', size: '16px' }
        ];

        responsiveFontSizes.forEach(function(item) {
            wp.customize(item.setting, function(value) {
                value.bind(function(to) {
                    const mediaQuery = window.matchMedia('(max-width: 767px)');
                    if (mediaQuery.matches) {
                        updateCSS(item.selector, 'font-size', to || item.size);
                    }
                });
            });
        });

        // Détection des changements de taille d'écran
        function handleViewportChange() {
            const viewportWidth = window.innerWidth;
            let viewportSize = 'mobile';
            
            if (viewportWidth >= 1200) viewportSize = 'large';
            else if (viewportWidth >= 1024) viewportSize = 'desktop';
            else if (viewportWidth >= 768) viewportSize = 'tablet';
            
            document.body.setAttribute('data-viewport', viewportSize);
            updateCSSVar('viewport-size', viewportSize);
        }


        // Écouteur d'événement pour les changements de taille de fenêtre
        let resizeTimer;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(handleViewportChange, 250);
        });

        // Initialisation au chargement
        handleViewportChange();

        // Gestion du mode sombre/clair
        wp.customize('color_scheme', function(value) {
            value.bind(function(to) {
                const body = $(selectors.body);
                body.removeClass('light-theme dark-theme system-theme')
                    .addClass(to + '-theme');
                
                // Mise à jour de l'attribut pour l'accessibilité
                body.attr('data-theme', to);
                
                // Sauvegarder la préférence utilisateur
                if (typeof Storage !== 'undefined') {
                    localStorage.setItem('themePreference', to);
                }
            });
        });

        // Détection du mode système
        if (window.matchMedia) {
            const prefersDarkScheme = window.matchMedia('(prefers-color-scheme: dark)');
            
            // Mettre à jour le thème en fonction des préférences système
            const updateSystemTheme = (e) => {
                const prefersDark = e.matches;
                $(selectors.body).toggleClass('system-dark-theme', prefersDark)
                               .toggleClass('system-light-theme', !prefersDark);
            };
            
            // Écouter les changements de préférence
            prefersDarkScheme.addListener(updateSystemTheme);
            updateSystemTheme(prefersDarkScheme);
        }

        // Gestion du contraste élevé
        wp.customize('high_contrast_mode', function(value) {
            value.bind(function(to) {
                const body = $(selectors.body);
                body.toggleClass('high-contrast', to);
                
                // Mise à jour de l'attribut pour l'accessibilité
                body.attr('data-high-contrast', to ? 'true' : 'false');
            });
        });

        // Gestion de la taille de police personnalisée
        wp.customize('font_size_adjustment', function(value) {
            value.bind(function(to) {
                const baseSize = parseFloat(to) || 100;
                const html = $('html');
                const currentSize = parseFloat(html.css('font-size'));
                const newSize = (baseSize / 100) * 16; // 16px est la taille de base
                
                html.css('font-size', newSize + 'px');
                updateCSSVar('font-size-adjustment', baseSize + '%');
            });
        });

        // Gestion de l'espacement des lignes
        wp.customize('line_height_adjustment', function(value) {
            value.bind(function(to) {
                updateCSSVar('line-height-multiplier', to);
            });
        });

        // Gestion de l'espacement des mots et des lettres
        wp.customize('word_spacing', function(value) {
            value.bind(function(to) {
                updateCSSVar('word-spacing', to, 'px');
            });
        });

        wp.customize('letter_spacing', function(value) {
            value.bind(function(to) {
                updateCSSVar('letter-spacing', to, 'px');
            });
        });

        // Gestion des animations
        wp.customize('reduce_motion', function(value) {
            value.bind(function(to) {
                const html = $('html');
                html.toggleClass('reduce-motion', to);
                
                // Mise à jour de l'attribut pour l'accessibilité
                html.attr('data-reduce-motion', to ? 'true' : 'false');
                
                // Appliquer les préférences de réduction des mouvements
                if (to) {
                    updateCSSVar('animation-duration', '0.01ms');
                    updateCSSVar('transition-duration', '0.01ms');
                } else {
                    updateCSSVar('animation-duration', '');
                    updateCSSVar('transition-duration', '');
                }
            });
        });

        // Gestion du mode focus amélioré
        wp.customize('enhanced_focus_styles', function(value) {
            value.bind(function(to) {
                const styleId = 'enhanced-focus-styles';
                
                if (to) {
                    let style = document.getElementById(styleId);
                    
                    if (!style) {
                        style = document.createElement('style');
                        style.id = styleId;
                        style.textContent = `
                            ${selectors.links}:focus,
                            ${selectors.buttons}:focus,
                            input:focus,
                            textarea:focus,
                            select:focus,
                            [tabindex="0"]:focus {
                                outline: 3px solid var(--focus-visible) !important;
                                outline-offset: 2px !important;
                                box-shadow: 0 0 0 3px rgba(0, 115, 170, 0.5) !important;
                            }
                        `;
                        document.head.appendChild(style);
                    }
                } else {
                    const style = document.getElementById(styleId);
                    if (style) {
                        style.remove();
                    }
                }
            });
        });

        // Initialisation des paramètres d'accessibilité
        if (typeof Storage !== 'undefined') {
            const savedTheme = localStorage.getItem('themePreference');
            if (savedTheme) {
                wp.customize('color_scheme').set(savedTheme);
            }
        }

        // Prévisualisation de la typographie
        wp.customize('body_font_family', function(value) {
            value.bind(function(to) {
                $('body').css('font-family', to);
            });
        });

        wp.customize('headings_font_family', function(value) {
            value.bind(function(to) {
                $('h1, h2, h3, h4, h5, h6, .site-title').css('font-family', to);
            });
        });

        // Prévisualisation de la largeur du contenu
        wp.customize('container_width', function(value) {
            value.bind(function(to) {
                $('.container').css('max-width', to + 'px');
            });
        });

        // Prévisualisation du style de la bannière
        wp.customize('header_style', function(value) {
            value.bind(function(to) {
                $('.site-header').removeClass('header-style-1 header-style-2 header-style-3').addClass('header-style-' + to);
            });
        });

        // Prévisualisation du style du pied de page
        wp.customize('footer_style', function(value) {
            value.bind(function(to) {
                $('.site-footer').removeClass('footer-style-1 footer-style-2').addClass('footer-style-' + to);
            });
        });

        // Activation/désactivation des éléments du blog
        const blogElements = [
            'show_post_date',
            'show_post_author',
            'show_post_categories',
            'show_post_tags',
            'show_post_navigation',
            'show_related_posts',
            'show_author_bio'
        ];

        blogElements.forEach(function(element) {
            wp.customize(element, function(value) {
                value.bind(function(to) {
                    if (to) {
                        $('.' + element).show();
                    } else {
                        $('.' + element).hide();
                    }
                });
            });
        });

        // Prévisualisation du style des boutons
        wp.customize('button_style', function(value) {
            value.bind(function(to) {
                $('.btn, button, input[type="button"], input[type="reset"], input[type="submit"]')
                    .removeClass('btn-style-1 btn-style-2 btn-style-3')
                    .addClass('btn-style-' + to);
            });
        });

        // Prévisualisation du style des liens
        wp.customize('link_style', function(value) {
            value.bind(function(to) {
                $('a').removeClass('link-style-1 link-style-2').addClass('link-style-' + to);
            });
        });

        // Prévisualisation du style des bordures
        wp.customize('border_radius', function(value) {
            value.bind(function(to) {
                document.documentElement.style.setProperty('--border-radius', to + 'px');
            });
        });

        // Prévisualisation de l'espacement
        wp.customize('content_spacing', function(value) {
            value.bind(function(to) {
                document.documentElement.style.setProperty('--content-spacing', to + 'px');
            });
        });

        // Prévisualisation de la largeur du contenu
        wp.customize('content_width', function(value) {
            value.bind(function(to) {
                $('.entry-content').css('max-width', to + 'px');
            });
        });

        // Prévisualisation du style des citations
        wp.customize('blockquote_style', function(value) {
            value.bind(function(to) {
                $('blockquote').removeClass('blockquote-style-1 blockquote-style-2').addClass('blockquote-style-' + to);
            });
        });

        // Prévisualisation du style des codes
        wp.customize('code_style', function(value) {
            value.bind(function(to) {
                $('code, pre').removeClass('code-style-1 code-style-2').addClass('code-style-' + to);
            });
        });

        // Prévisualisation du style des tableaux
        wp.customize('table_style', function(value) {
            value.bind(function(to) {
                $('table').removeClass('table-style-1 table-style-2').addClass('table-style-' + to);
            });
        });
    });

})(jQuery);
