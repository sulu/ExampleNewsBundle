define(['jquery'], function($) {

    'use strict';

    return {

        defaults: {
            templates: {
                url: '/admin/api/news<% if (!!id) { %>/<%= id %><% } %>'
            },
            translations: {
                headline: 'news.headline'
            }
        },

        header: function() {
            return {
                title: function() {
                    return !!this.data.name ? this.data.name : this.translations.headline;
                }.bind(this),

                tabs: {
                    url: '/admin/content-navigations?alias=news',
                    options: {
                        data: function() {
                            return this.sandbox.util.extend(false, {}, this.data);
                        }.bind(this)
                    },
                    componentOptions: {
                        values: this.data
                    }
                },

                toolbar: {
                    buttons: {
                        save: {
                            parent: 'saveWithOptions'
                        }
                    }
                }
            };
        },

        loadComponentData: function() {
            var promise = $.Deferred();

            if (!this.options.id) {
                promise.resolve({});

                return promise;
            }
            this.sandbox.util.load(_.template(this.defaults.templates.url, {id: this.options.id}))
                .done(function(data) {
                    promise.resolve(data);
                });

            return promise;
        },

        initialize: function() {
            this.bindCustomEvents();
        },

        bindCustomEvents: function() {
            this.sandbox.on('sulu.header.back', this.toList.bind(this));
            this.sandbox.on('sulu.tab.dirty', this.enableSave.bind(this));
            this.sandbox.on('sulu.toolbar.save', this.save.bind(this));
            this.sandbox.on('sulu.tab.data-changed', this.setData.bind(this));
        },

        toList: function() {
            this.sandbox.emit('sulu.router.navigate', 'example/news');
        },

        save: function(action) {
            this.loadingSave();

            this.saveTab().then(function(data) {
                this.afterSave(action, data);
            }.bind(this));
        },

        setData: function(data) {
            this.data = data;
        },

        saveTab: function() {
            var promise = $.Deferred();

            this.sandbox.once('sulu.tab.saved', function(savedData) {
                this.setData(savedData);

                promise.resolve(savedData);
            }.bind(this));

            this.sandbox.emit('sulu.tab.save');

            return promise;
        },

        enableSave: function() {
            this.sandbox.emit('sulu.header.toolbar.item.enable', 'save', false);
        },

        loadingSave: function() {
            this.sandbox.emit('sulu.header.toolbar.item.loading', 'save');
        },

        afterSave: function(action, data) {
            this.sandbox.emit('sulu.header.toolbar.item.disable', 'save', true);
            this.sandbox.emit('sulu.header.saved', data);

            if (action === 'back') {
                this.sandbox.emit('sulu.router.navigate', 'example/news');
            } else if (action === 'new') {
                this.sandbox.emit('sulu.router.navigate', 'example/news/add');
            } else if (!this.options.id) {
                this.sandbox.emit('sulu.router.navigate', 'example/news/edit:' + data.id);
            }
        }
    };
});
