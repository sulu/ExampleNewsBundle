define(['text!./list.html'], function(list) {

    var defaults = {
        templates: {
            list: list
        }
    };

    return {

        defaults: defaults,

        header: {
            title: 'news.headline',
            underline: false,

            toolbar: {
                buttons: {
                    add: {},
                    deleteSelected: {}
                }
            }
        },

        layout: {
            content: {
                width: 'max'
            }
        },

        initialize: function() {
            this.render();

            this.bindDomEvents();
            this.bindCustomEvents();
        },

        render: function() {
            this.$el.html(this.templates.list());

            this.sandbox.sulu.initListToolbarAndList.call(this,
                'news',
                '/admin/api/news/fields',
                {
                    el: this.$find('#list-toolbar-container'),
                    instanceName: 'news',
                    template: this.sandbox.sulu.buttons.get({
                        settings: {
                            options: {
                                dropdownItems: [
                                    {
                                        type: 'columnOptions'
                                    }
                                ]
                            }
                        }
                    })
                },
                {
                    el: this.sandbox.dom.find('#news-list'),
                    url: '/admin/api/news',
                    searchInstanceName: 'news',
                    searchFields: ['title', 'content'],
                    resultKey: 'news-items',
                    instanceName: 'news',
                    actionCallback: this.toEdit.bind(this),
                    viewOptions: {
                        table: {
                            actionIconColumn: 'title'
                        }
                    }
                }
            );
        },

        toEdit: function(id) {
            this.sandbox.emit('sulu.router.navigate', 'example/news/edit:' + id);
        },

        toAdd: function() {
            this.sandbox.emit('sulu.router.navigate', 'example/news/add');
        },

        deleteItems: function(ids) {
            for (var i = 0, length = ids.length; i < length; i++) {
                this.deleteItem(ids[i]);
            }
        },

        deleteItem: function(id) {
            this.sandbox.util.save('/admin/api/news/' + id, 'DELETE').then(function() {
                this.sandbox.emit('husky.datagrid.news.record.remove', id);
            }.bind(this));
        },

        bindDomEvents: function() {
        },

        bindCustomEvents: function() {
            this.sandbox.on('sulu.toolbar.add', this.toAdd.bind(this));

            this.sandbox.on('husky.datagrid.news.number.selections', function(number) {
                var postfix = number > 0 ? 'enable' : 'disable';
                this.sandbox.emit('sulu.header.toolbar.item.' + postfix, 'deleteSelected', false);
            }.bind(this));

            this.sandbox.on('sulu.toolbar.delete', function() {
                this.sandbox.emit('husky.datagrid.news.items.get-selected', this.deleteItems.bind(this));
            }.bind(this));
        }
    };
});
