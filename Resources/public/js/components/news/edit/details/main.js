define(['underscore', 'jquery', 'text!./form.html'], function(_, $, form) {

    return {

        defaults: {
            templates: {
                form: form,
                url: '/admin/api/news<% if (!!id) { %>/<%= id %><% } %>'
            },
            translations: {
                title: 'public.title',
                content: 'news.content'
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
            this.bindCustomEvents();
        },

        render: function() {
            this.$el.html(this.templates.form({translations: this.translations}));

            this.form = this.sandbox.form.create('#news-form');
            this.form.initialized.then(function() {
                this.sandbox.form.setData('#news-form', this.data || {});
            }.bind(this));
        },

        bindDomEvents: function() {
            this.$el.find('input, textarea').on('keypress', function() {
                this.sandbox.emit('sulu.tab.dirty');
            }.bind(this));
        },

        bindCustomEvents: function() {
            this.sandbox.on('sulu.tab.save', this.save.bind(this));
        },

        save: function() {
            if (!this.sandbox.form.validate('#news-form')) {
                return;
            }

            var data = this.sandbox.form.getData('#news-form'),
                url = this.templates.url({id: this.data.id});

            this.sandbox.util.save(url, !this.data.id ? 'POST' : 'PUT', data).then(function(response) {
                this.sandbox.emit('sulu.tab.saved', response);
            }.bind(this));
        },

        loadComponentData: function() {
            var promise = $.Deferred();

            promise.resolve(this.options.data());

            return promise;
        }
    };
});
