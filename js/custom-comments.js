/**
 * Gestion des commentaires pour Infinity Blog
 * Améliore l'expérience utilisateur des commentaires avec AJAX et des interactions fluides
 * 
 * Fonctionnalités :
 * - Soumission de commentaires en AJAX
 * - Chargement infini des commentaires
 * - Réponse aux commentaires
 * - Édition des commentaires
 * - Notifications utilisateur
 * - Validation en temps réel
 * - Prévisualisation du formatage
 * - Anti-spam et sécurité
 */
(function($) {
    'use strict';

    // État global de l'application
    const state = {
        isSubmitting: false,
        isLoadingMore: false,
        isReplying: false,
        currentReplyId: 0,
        currentEditId: 0,
        commentCount: parseInt($('#comments-title .count').text() || '0'),
        commentPage: 1,
        commentsPerPage: parseInt(infinity_blog_comments.comments_per_page || '50')
    };

    // Initialisation des événements
    function initEvents() {
        // Soumission du formulaire de commentaire
        $(document).on('submit', '#commentform', handleCommentSubmit);
        
        // Réponse aux commentaires
        $(document).on('click', '.comment-reply-link', handleReplyClick);
        
        // Annulation de la réponse
        $(document).on('click', '#cancel-comment-reply-link', cancelReply);
        
        // Édition des commentaires
        $(document).on('click', '.comment-edit-link', handleEditClick);
        
        // Annulation de l'édition
        $(document).on('click', '.cancel-edit', cancelEdit);
        
        // Chargement de plus de commentaires
        $(document).on('click', '.load-more-comments', loadMoreComments);
        
        // Prévisualisation du commentaire
        $(document).on('input', '#comment', debounce(updatePreview, 300));
        
        // Validation en temps réel
        $(document).on('input', '#comment, #author, #email', validateFields);
        
        // Gestion des onglets d'édition (texte/aperçu)
        $(document).on('click', '.comment-tabs a', handleTabClick);
    }


    // Fonction utilitaire pour le debounce
    function debounce(func, wait) {
        let timeout;
        return function() {
            const context = this, args = arguments;
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(context, args), wait);
        };
    }

    // Fonction pour valider les champs du formulaire
    function validateFields() {
        let isValid = true;
        const $form = $('#commentform');
        
        // Valider le champ commentaire
        const $comment = $form.find('#comment');
        if ($comment.val().trim().length < 10) {
            showError($comment, infinity_blog_comments.comment_too_short);
            isValid = false;
        } else {
            clearError($comment);
        }
        
        // Valider l'email si l'utilisateur n'est pas connecté
        if (!infinity_blog_comments.logged_in) {
            const $email = $form.find('#email');
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            
            if (!emailRegex.test($email.val())) {
                showError($email, infinity_blog_comments.invalid_email);
                isValid = false;
            } else {
                clearError($email);
            }
            
            // Valider le nom
            const $author = $form.find('#author');
            if ($author.val().trim().length < 2) {
                showError($author, infinity_blog_comments.name_required);
                isValid = false;
            } else {
                clearError($author);
            }
        }
        
        return isValid;
    }

    // Fonction pour afficher une erreur de validation
    function showError($field, message) {
        $field.addClass('error');
        let $error = $field.siblings('.error-message');
        
        if ($error.length === 0) {
            $error = $('<div class="error-message"></div>');
            $field.after($error);
        }
        
        $error.text(message).show();
    }

    // Fonction pour effacer les erreurs de validation
    function clearError($field) {
        $field.removeClass('error');
        $field.siblings('.error-message').remove();
    }

    // Gestion de la soumission du formulaire
    function handleCommentSubmit(e) {
        e.preventDefault();
        return submitComment($(this));
    }

    // Gestion du clic sur le bouton de réponse
    function handleReplyClick(e) {
        e.preventDefault();
        
        const $link = $(this);
        const commentId = $link.data('comment-id');
        const commentAuthor = $link.data('comment-author');
        
        // Annuler toute édition en cours
        if (state.currentEditId) {
            cancelEdit();
        }
        
        // Définir l'ID du commentaire parent
        state.currentReplyId = commentId;
        state.isReplying = true;
        
        // Mettre à jour le formulaire
        $('#comment_parent').val(commentId);
        
        // Déplacer le formulaire s'il est en mode mobile
        if ($(window).width() < 768) {
            const $respond = $('#respond');
            $respond.insertAfter($link.closest('.comment'));
            $('html, body').animate({
                scrollTop: $respond.offset().top - 100
            }, 300);
        }
        
        // Mettre à jour le texte du bouton d'annulation
        $('#cancel-comment-reply-link')
            .show()
            .on('click', cancelReply);
        
        // Mettre à jour le placeholder du commentaire
        $('#comment')
            .attr('placeholder', 'Réponse à ' + commentAuthor + '...')
            .focus();
    }

    // Annuler la réponse à un commentaire
    function cancelReply() {
        state.currentReplyId = 0;
        state.isReplying = false;
        
        // Réinitialiser le formulaire
        $('#comment_parent').val('0');
        $('#comment').attr('placeholder', infinity_blog_comments.comment_placeholder);
        
        // Cacher le bouton d'annulation
        $('#cancel-comment-reply-link').hide();
        
        // Replacer le formulaire à sa position d'origine si nécessaire
        if ($(window).width() < 768) {
            const $respond = $('#respond');
            $('#comments').append($respond);
        }
        
        return false;
    }

    // Gestion du clic sur le bouton d'édition
    function handleEditClick(e) {
        e.preventDefault();
        
        const $link = $(this);
        const $comment = $link.closest('.comment');
        const commentId = $link.data('comment-id');
        const commentContent = $comment.find('.comment-content').html().trim();
        
        // Annuler toute réponse en cours
        if (state.isReplying) {
            cancelReply();
        }
        
        // Mettre à jour l'état
        state.currentEditId = commentId;
        
        // Créer le formulaire d'édition
        const $editForm = $(
            '<form id="edit-comment-form" class="comment-form edit-comment-form">' +
            '<div class="comment-form-comment">' +
            '<textarea id="edit-comment" class="form-control" rows="4" required>' + 
            $('<div/>').text(commentContent).html() + 
            '</textarea>' +
            '</div>' +
            '<p class="form-submit">' +
            '<input type="submit" class="submit" value="' + infinity_blog_comments.update_text + '">' +
            '<button type="button" class="cancel-edit">' + infinity_blog_comments.cancel_text + '</button>' +
            '</p>' +
            '</form>'
        );
        
        // Remplacer le contenu du commentaire par le formulaire
        $comment.find('.comment-content')
            .empty()
            .append($editForm);
        
        // Mettre le focus sur le champ de texte
        $('#edit-comment').focus();
    }

    // Annuler l'édition d'un commentaire
    function cancelEdit() {
        const $comment = $('.comment-' + state.currentEditId);
        const originalContent = $comment.data('original-content');
        
        // Restaurer le contenu original
        $comment.find('.comment-content')
            .empty()
            .html(originalContent);
        
        // Réinitialiser l'état
        state.currentEditId = 0;
    }

    // Gestion du clic sur les onglets d'édition
    function handleTabClick(e) {
        e.preventDefault();
        
        const $tab = $(this);
        const target = $tab.data('tab');
        const $tabs = $tab.closest('.comment-tabs');
        const $form = $tab.closest('form');
        
        // Mettre à jour les onglets actifs
        $tabs.find('a').removeClass('active');
        $tab.addClass('active');
        
        // Afficher le contenu de l'onglet sélectionné
        $form.find('.tab-pane').removeClass('active');
        $form.find('#' + target + '-tab').addClass('active');
        
        // Mettre à jour la prévisualisation si nécessaire
        if (target === 'preview') {
            const $preview = $form.find('.comment-edit-preview');
            const $textarea = $form.find('.comment-edit-textarea');
            // Convertir le markdown en HTML (à implémenter)
            $preview.html($textarea.val());
        }
    }
    
    // Fonction pour charger plus de commentaires
    function loadMoreComments() {
        if (state.isLoadingMore) return;
        
        const $button = $('.load-more-comments');
        const $commentsContainer = $('#comments .comment-list');
        
        // Mettre à jour l'état
        state.isLoadingMore = true;
        state.commentPage++;
        
        // Afficher l'indicateur de chargement
        $button.addClass('loading').text(infinity_blog_comments.loading);
        
        // Envoyer la requête AJAX
        $.ajax({
            type: 'GET',
            url: infinity_blog_comments.ajaxurl,
            data: {
                action: 'load_more_comments',
                post_id: infinity_blog_comments.post_id,
                page: state.commentPage,
                security: infinity_blog_comments.nonce
            },
            dataType: 'json',
            success: function(response) {
                if (response.success && response.data.html) {
                    // Ajouter les nouveaux commentaires
                    $commentsContainer.append(response.data.html);
                    
                    // Mettre à jour le nombre de commentaires chargés
                    state.commentCount += response.data.count || 0;
                    
                    // Cacher le bouton s'il n'y a plus de commentaires à charger
                    if (!response.data.more) {
                        $button.remove();
                    } else {
                        $button.removeClass('loading').text(infinity_blog_comments.load_more);
                    }
                    
                    // Déclencher un événement personnalisé
                    $(document).trigger('comments:loaded', [response.data.count]);
                } else {
                    // Afficher un message d'erreur
                    showNotice('error', response.data.message || infinity_blog_comments.error_loading);
                }
            },
            error: function(xhr, status, error) {
                console.error('Erreur lors du chargement des commentaires :', error);
                showNotice('error', infinity_blog_comments.error_loading);
            },
            complete: function() {
                state.isLoadingMore = false;
                $button.removeClass('loading').text(infinity_blog_comments.load_more);
            }
        });
    }
    
    // Fonction pour afficher une notification
    function showNotice(type, message) {
        const $notice = $('<div class="comment-notice notice-' + type + '"><p>' + message + '</p></div>');
        
        // Ajouter la notification avant le formulaire
        $('#respond').before($notice);
        
        // Supprimer la notification après 5 secondes
        setTimeout(function() {
            $notice.fadeOut(300, function() {
                $(this).remove();
            });
        }, 5000);
    }
    
    // Fonction pour soumettre un commentaire via AJAX
    function submitComment($form) {
        if (state.isSubmitting) return false;
        
        const $submitButton = $form.find('input[type="submit"], button[type="submit"]');
        const originalButtonText = $submitButton.val();
        const isEdit = state.currentEditId > 0;
        
        // Validation des champs requis
        if (!validateFields()) return false;
        
        // Désactiver le bouton pour éviter les soumissions multiples
        state.isSubmitting = true;
        $submitButton.prop('disabled', true).val(infinity_blog_comments.sending);
        
        // Ajouter un indicateur de chargement
        $form.addClass('is-submitting');
        
        // Préparer les données du formulaire
        const formData = new FormData($form[0]);
        
        // Définir l'action appropriée
        const action = isEdit ? 'edit_comment' : 'submit_comment';
        formData.append('action', action);
        formData.append('security', infinity_blog_comments.nonce);
        
        // Envoyer la requête AJAX
        $.ajax({
            type: 'POST',
            url: infinity_blog_comments.ajaxurl,
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    handleCommentSuccess(response, $form, isEdit);
                } else {
                    handleCommentError(response);
                }
            },
            error: function(xhr, status, error) {
                console.error('Erreur lors de la soumission du commentaire :', error);
                showNotice('error', infinity_blog_comments.error_submitting);
            },
            complete: function() {
                // Réactiver le formulaire
                state.isSubmitting = false;
                $submitButton.prop('disabled', false).val(originalButtonText);
                $form.removeClass('is-submitting');
            }
        });
    }
    
    // Gestion de la soumission réussie d'un commentaire
    function handleCommentSuccess(response, $form, isEdit) {
        if (isEdit) {
            // Mettre à jour le commentaire existant
            const $comment = $('.comment-' + state.currentEditId);
            const $commentContent = $comment.find('.comment-content');
            
            // Mettre à jour le contenu du commentaire
            $commentContent.html(response.data.comment_content);
            
            // Afficher un message de succès
            showNotice('success', infinity_blog_comments.comment_updated);
            
            // Réinitialiser l'état d'édition
            state.currentEditId = 0;
        } else {
            // Réinitialiser le formulaire
            $form[0].reset();
            
            // Ajouter le nouveau commentaire à la liste
            if (response.data && response.data.comment_html) {
                const $commentsList = $('#comments .comment-list');
                
                if ($commentsList.length) {
                    if (state.currentReplyId > 0) {
                        // Insérer en réponse au commentaire parent
                        const $parentComment = $('.comment-' + state.currentReplyId);
                        let $children = $parentComment.find('> .children');
                        
                        if ($children.length === 0) {
                            $children = $('<ol class="children"></ol>');
                            $parentComment.append($children);
                        }
                        
                        $children.append(response.data.comment_html);
                    } else {
                        // Ajouter en haut de la liste des commentaires
                        $commentsContainer.prepend(response.data.comment_html);
                    }
                    
                    // Mettre à jour le compteur de commentaires
                    state.commentCount++;
                    const $count = $('#comments-title .count');
                    if ($count.length) {
                        $count.text(state.commentCount);
                    }
                    
                    // Faire défiler jusqu'au nouveau commentaire
                    $('html, body').animate({
                        scrollTop: $('#comment-' + response.data.comment_id).offset().top - 100
                    }, 500);
                }
                
                // Afficher un message de succès
                showNotice('success', infinity_blog_comments.comment_submitted);
            }
            
            // Réinitialiser la réponse en cours
            if (state.isReplying) {
                cancelReply();
            }
        }
    }
    
    // Gestion des erreurs de soumission de commentaire
    function handleCommentError(response) {
        let errorMessage = infinity_blog_comments.error_submitting;
        
        if (response.data && response.data.errors) {
            errorMessage = '';
            
            // Afficher chaque erreur
            $.each(response.data.errors, function(field, errors) {
                errorMessage += errors.join('<br>') + '<br>';
                
                // Mettre en surbrillance les champs en erreur
                const $field = $('#' + field);
                if ($field.length) {
                    $field.addClass('error');
                    
                    // Afficher le message d'erreur sous le champ
                    let $error = $field.siblings('.error-message');
                    if ($error.length === 0) {
                        $error = $('<div class="error-message"></div>');
                        $field.after($error);
                    }
                    
                    $error.html(errors.join('<br>'));
                }
            });
        } else if (response.data && response.data.message) {
            errorMessage = response.data.message;
        }
        
        showNotice('error', errorMessage);
    }
    
    // Initialisation du script
    function init() {
        // Initialiser les événements
        initEvents();
        
        // Vérifier si l'URL contient un hash de commentaire
        if (window.location.hash && window.location.hash.indexOf('#comment-') === 0) {
            const $comment = $(window.location.hash);
            if ($comment.length) {
                // Faire défiler jusqu'au commentaire
                $('html, body').animate({
                    scrollTop: $comment.offset().top - 100
                }, 500);
                
                // Mettre en surbrillance le commentaire
                $comment.addClass('highlight');
                
                // Supprimer la mise en surbrillance après 3 secondes
                setTimeout(function() {
                    $comment.removeClass('highlight');
                }, 3000);
            }
        }
        
        // Initialiser la pagination infinie
        initInfiniteScroll();
    }
    
    // Initialiser le défilement infini
    function initInfiniteScroll() {
        let isLoading = false;
        let $loadMore = $('.load-more-comments');
        
        if ($loadMore.length) {
            $(window).on('scroll', function() {
                if (isLoading || !$loadMore.length) return;
                
                const scrollPosition = $(window).scrollTop() + $(window).height();
                const loadMorePosition = $loadMore.offset().top + $loadMore.outerHeight();
                
                if (scrollPosition > loadMorePosition - 200) {
                    isLoading = true;
                    loadMoreComments();
                }
            });
        }
    }
    
    // Démarrer l'initialisation lorsque le DOM est prêt
    $(document).ready(init);
    
    // Fonction pour afficher les notifications
    function showNotice(type, message) {
        const $notice = $('<div class="comment-notice notice-' + type + '"><p>' + message + '</p></div>');
        
        // Insérer la notification avant le formulaire
        $('#respond').before($notice);
        
        // Supprimer la notification après 5 secondes
        setTimeout(function() {
            $notice.fadeOut(300, function() {
                $(this).remove();
            });
        }, 5000);
    }
    
    // Fonction pour charger plus de commentaires
    function loadMoreComments() {
        const $loadMoreButton = $('.load-more-comments');
        const page = parseInt($loadMoreButton.data('page'), 10) || 1;
        const postId = $loadMoreButton.data('post-id');
        
        // Vérifier si le bouton existe
        if (!$loadMoreButton.length) {
            return;
        }
        
        // Désactiver le bouton pendant le chargement
        $loadMoreButton.prop('disabled', true).text(infinity_blog_comments.loading);
        
        // Afficher l'indicateur de chargement
        $loadMoreButton.addClass('loading');
        
        // Envoyer la requête AJAX
        $.ajax({
            type: 'POST',
            url: infinity_blog_comments.ajaxurl,
            data: {
                action: 'infinity_blog_load_more_comments',
                post_id: postId,
                page: page,
                security: infinity_blog_comments.nonce
            },
            dataType: 'json',
            success: function(response) {
                if (response.success && response.data && response.data.html) {
                    // Ajouter les nouveaux commentaires
                    const $commentsList = $('ol.comment-list');
                    
                    if ($commentsList.length) {
                        $commentsList.append(response.data.html);
                        
                        // Mettre à jour le numéro de page
                        $loadMoreButton.data('page', page + 1);
                        
                        // Cacher le bouton s'il n'y a plus de commentaires à charger
                        if (!response.data.has_more) {
                            $loadMoreButton.hide();
                        }
                        
                        // Déclencher un événement personnalisé
                        $(document).trigger('comments:loaded', [response.data.count]);
                    }
                } else {
                    // Afficher un message d'erreur
                    const errorMsg = (response.data && response.data.message) || infinity_blog_comments.error_loading;
                    showNotice('error', errorMsg);
                }
            },
            error: function(xhr, status, error) {
                console.error('Erreur lors du chargement des commentaires :', error);
                showNotice('error', infinity_blog_comments.error_loading);
            },
            complete: function() {
                // Réactiver le bouton
                $loadMoreButton
                    .prop('disabled', false)
                    .removeClass('loading')
                    .text(infinity_blog_comments.load_more);
            }
        });
    }
    
})(jQuery);
