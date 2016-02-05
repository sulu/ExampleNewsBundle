define(['text!./form.html'], function(form) {

    return {

        defaults: {
            templates: {
                form: form
            },
            translations: {
                title: 'public.title',
                content: 'news.content'
            }
        },

        header: {
            title: 'news.headline',
            toolbar: {
                buttons: {
                    save: {
                        parent: 'saveWithOptions'
                    }
                }
            }
        },

        layout: {
            content: {
                width: 'fixed',
                leftSpace: true,
                rightSpace: true
            }
        },

        initialize: function() {
            this.render();

            this.bindDomEvents();
        },

        render: function() {
            this.$el.html(this.templates.form({translations: this.translations}));

            this.sandbox.form.create('#news-form');
        },

        bindDomEvents: function() {
            this.$el.find('input, textarea').on('keypress', function() {
                this.sandbox.emit('sulu.header.toolbar.item.enable', 'save');
            }.bind(this));
        }
    };
});
