/**
 * Prévisualisation en direct pour le personnalisateur WordPress
 * Gère les mises à jour en temps réel dans l'aperçu
 */
(function($) {
    'use strict';

    // Sélecteurs CSS
    const selectors = {
        body: 'body',
        header: '.site-header',
        footer: '.site-footer',
        content: '.site-content',
        main: '.site-main',
        sidebar: '.sidebar',
        buttons: 'button, .button, input[type="button"]',
        links: 'a',
        headings: 'h1, h2, h3, h4, h5, h6'
    };

    // Mise à jour des propriétés CSS
    function updateCSS(selector, property, value, unit = '') {
        $(selector).css(property, value + unit);
    }

    // Mise à jour des variables CSS
    function updateCSSVar(varName, value, unit = '') {
        document.documentElement.style.setProperty('--' + varName, value + unit);
    }

    // Initialisation
    wp.customize.bind('preview-ready', function() {
        // Couleurs
        const colors = [
            'primary', 'secondary', 'text', 'background',
            'header_bg', 'footer_bg', 'link', 'link_hover'
        ];

        colors.forEach(color => {
            wp.customize(color + '_color', value => {
                value.bind(to => updateCSSVar(color, to));
            });
        });

        // Typographie
        const typography = [
            { setting: 'body_font', selector: 'body', prop: 'font-family' },
            { setting: 'heading_font', selector: 'h1, h2, h3, h4, h5, h6', prop: 'font-family' },
            { setting: 'font_size', selector: 'body', prop: 'font-size', unit: 'px' }
        ];

        typography.forEach(item => {
            wp.customize(item.setting, value => {
                value.bind(to => updateCSS(item.selector, item.prop, to, item.unit || ''));
            });
        });

        // Mise en page
        wp.customize('container_width', value => {
            value.bind(to => updateCSS('.container', 'max-width', to, 'px'));
        });

        wp.customize('sidebar_position', value => {
            value.bind(to => {
                $('body').removeClass('sidebar-left sidebar-right no-sidebar')
                         .addClass('sidebar-' + to);
            });
        });

        // En-tête
        wp.customize('header_style', value => {
            value.bind(to => {
                $(selectors.header).removeClass('header-style-1 header-style-2')
                                 .addClass('header-style-' + to);
            });
        });

        // Pied de page
        wp.customize('footer_style', value => {
            value.bind(to => {
                $(selectors.footer).removeClass('footer-style-1 footer-style-2')
                                 .addClass('footer-style-' + to);
            });
        });

        // Logo personnalisé
        wp.customize('custom_logo', value => {
            value.bind(to => {
                if (to) {
                    $('.site-logo').html('<img src="' + to + '" alt="' + wp.customize('blogname')() + '">');
                } else {
                    $('.site-logo').text(wp.customize('blogname')());
                }
            });
        });

        // Image d'en-tête
        wp.customize('header_image', value => {
            value.bind(to => {
                if (to) {
                    $(selectors.header).css('background-image', 'url(' + to + ')');
                } else {
                    $(selectors.header).css('background-image', 'none');
                }
            });
        });

        // Arrière-plan
        wp.customize('background_image', value => {
            value.bind(to => {
                if (to) {
                    $(selectors.body).css('background-image', 'url(' + to + ')');
                } else {
                    $(selectors.body).css('background-image', 'none');
                }
            });
        });

        // Boutons
        wp.customize('button_style', value => {
            value.bind(to => {
                $(selectors.buttons).removeClass('button-style-1 button-style-2')
                                 .addClass('button-style-' + to);
            });
        });

        // Liens
        wp.customize('link_style', value => {
            value.bind(to => {
                $(selectors.links).removeClass('link-style-1 link-style-2')
                                .addClass('link-style-' + to);
            });
        });

        // Mise à jour du texte du site
        wp.customize('blogname', value => {
            value.bind(to => $('.site-title a').text(to));
        });

        wp.customize('blogdescription', value => {
            value.bind(to => $('.site-description').text(to));
        });
    });

})(jQuery);
