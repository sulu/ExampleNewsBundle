define(['underscore', 'jquery', 'text!/admin/content/template/content/seo.html'], function(_, $, seoTemplate) {

    'use strict';

    var formId = '#seo-form';

    return {

        defaults: {
            templates: {
                seo: seoTemplate,
                url: '/admin/api/news<% if (!!id) { %>/<%= id %><% } %>'
            }
        },

        layout: {
            extendExisting: true,
            content: {
                width: 'fixed',
                rightSpace: true,
                leftSpace: true
            }
        },

        initialize: function() {
            this.render();
        },

        render: function() {
            this.$el.html(this.templates.seo({translate: this.sandbox.translate, siteUrl: 'example.com'}));

            this.form = this.sandbox.form.create('#news-form');
            this.form.initialized.then(function() {
                this.sandbox.form.setData('#news-form', this.data || {});
            }.bind(this));
        },



        loadComponentData: function() {
            var promise = $.Deferred();

            // TODO seo api
            promise.resolve({});

            return promise;
        }

    };

});
