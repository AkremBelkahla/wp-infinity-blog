/**
 * Contrôles personnalisés pour le personnalisateur WordPress
 * Gère les interactions dans le panneau d'administration
 */
(function($) {
    'use strict';

    // Contrôle pour la sélection de police
    wp.customize.controlConstructor['infinity-blog-font'] = wp.customize.Control.extend({
        ready: function() {
            const control = this;
            const select = this.container.find('select');
            
            // Mettre à jour la valeur lors de la modification
            select.on('change', function() {
                control.setting.set($(this).val());
            });
            
            // Synchroniser la valeur du contrôle
            this.setting.bind(function(value) {
                select.val(value);
            });
        }
    });

    // Contrôle pour la palette de couleurs
    wp.customize.controlConstructor['infinity-blog-color-palette'] = wp.customize.Control.extend({
        ready: function() {
            const control = this;
            const container = this.container;
            const input = container.find('input[type="hidden"]');
            
            // Gérer le clic sur une couleur
            container.on('click', '.color-option', function(e) {
                e.preventDefault();
                const color = $(this).data('color');
                input.val(color).trigger('change');
                control.setting.set(color);
                container.find('.color-option').removeClass('active');
                $(this).addClass('active');
            });
            
            // Synchroniser la valeur du contrôle
            this.setting.bind(function(value) {
                if (value) {
                    input.val(value);
                    container.find('.color-option').removeClass('active')
                        .filter('[data-color="' + value + '"]').addClass('active');
                }
            });
        }
    });

    // Contrôle pour les boutons radio image
    wp.customize.controlConstructor['infinity-blog-radio-image'] = wp.customize.Control.extend({
        ready: function() {
            const control = this;
            
            // Gérer le clic sur une option
            this.container.on('click', 'input[type="radio"]', function() {
                control.setting.set($(this).val());
            });
            
            // Synchroniser la valeur du contrôle
            this.setting.bind(function(value) {
                control.container.find('input[type="radio"]')
                    .prop('checked', false)
                    .filter('[value="' + value + '"]')
                    .prop('checked', true);
            });
        }
    });

    // Contrôle pour les dimensions (largeur/hauteur)
    wp.customize.controlConstructor['infinity-blog-dimensions'] = wp.customize.Control.extend({
        ready: function() {
            const control = this;
            const inputs = this.container.find('input[type="number"]');
            const link = this.container.find('.dimensions-link');
            let values = this.setting.get() || {};
            
            // Mettre à jour les valeurs initiales
            Object.keys(values).forEach(dimension => {
                this.container.find('input[data-dimension="' + dimension + '"]').val(values[dimension]);
            });
            
            // Gérer les changements de valeur
            inputs.on('input', function() {
                const dimension = $(this).data('dimension');
                values[dimension] = $(this).val() || '';
                control.setting.set(JSON.stringify(values));
            });
            
            // Lier/délier les dimensions
            link.on('click', function(e) {
                e.preventDefault();
                const isLinked = $(this).hasClass('linked');
                
                if (isLinked) {
                    $(this).removeClass('linked').html('<span class="dashicons dashicons-admin-links"></span>');
                } else {
                    $(this).addClass('linked').html('<span class="dashicons dashicons-editor-unlink"></span>');
                    
                    // Synchroniser toutes les valeurs avec la première
                    const firstValue = inputs.first().val();
                    inputs.val(firstValue);
                    
                    Object.keys(values).forEach(dimension => {
                        values[dimension] = firstValue;
                    });
                    
                    control.setting.set(JSON.stringify(values));
                }
            });
        }
    });

    // Contrôle pour les icônes sociales
    wp.customize.controlConstructor['infinity-blog-social-icons'] = wp.customize.Control.extend({
        ready: function() {
            const control = this;
            const container = this.container;
            const addButton = container.find('.add-social-icon');
            const iconsList = container.find('.social-icons-list');
            let icons = JSON.parse(this.setting.get() || '[]');
            
            // Afficher les icônes existantes
            function renderIcons() {
                iconsList.empty();
                
                icons.forEach((icon, index) => {
                    const item = `
                        <div class="social-icon-item">
                            <select class="social-icon-select">
                                <option value="facebook" ${icon.icon === 'facebook' ? 'selected' : ''}>Facebook</option>
                                <option value="twitter" ${icon.icon === 'twitter' ? 'selected' : ''}>Twitter</option>
                                <option value="instagram" ${icon.icon === 'instagram' ? 'selected' : ''}>Instagram</option>
                                <option value="linkedin" ${icon.icon === 'linkedin' ? 'selected' : ''}>LinkedIn</option>
                                <option value="youtube" ${icon.icon === 'youtube' ? 'selected' : ''}>YouTube</option>
                            </select>
                            <input type="url" class="social-icon-url" value="${icon.url || ''}" placeholder="URL">
                            <button type="button" class="button remove-social-icon">Supprimer</button>
                        </div>
                    `;
                    
                    iconsList.append(item);
                });
                
                saveIcons();
            }
            
            // Sauvegarder les icônes
            function saveIcons() {
                icons = [];
                
                container.find('.social-icon-item').each(function() {
                    const $item = $(this);
                    icons.push({
                        icon: $item.find('.social-icon-select').val(),
                        url: $item.find('.social-icon-url').val()
                    });
                });
                
                control.setting.set(JSON.stringify(icons));
            }
            
            // Ajouter une nouvelle icône
            addButton.on('click', function() {
                icons.push({ icon: 'facebook', url: '' });
                renderIcons();
            });
            
            // Supprimer une icône
            container.on('click', '.remove-social-icon', function() {
                const index = $(this).closest('.social-icon-item').index();
                icons.splice(index, 1);
                renderIcons();
            });
            
            // Mettre à jour les icônes
            container.on('change', '.social-icon-select, .social-icon-url', saveIcons);
            
            // Afficher les icônes initiales
            renderIcons();
        }
    });

    // Initialisation des sélecteurs de couleur
    $(document).ready(function() {
        $('.color-picker').wpColorPicker();
    });

})(jQuery);
