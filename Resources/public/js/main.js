require.config({
    paths: {
        examplenews: '../../examplenews/js',
        examplenewscss: '../../examplenews/css',

        'type/news-selection': '../../examplenews/js/validation/types/news-selection'
    }
});

define(function() {

    'use strict';

    return {

        name: "Example News Bundle",

        initialize: function(app) {

            app.components.addSource('examplenews', '/bundles/examplenews/js/components');

            app.sandbox.mvc.routes.push({
                route: 'example/news',
                callback: function() {
                    return '<div data-aura-component="news/list@examplenews" data-aura-name="sulu" />';
                }
            });

            app.sandbox.mvc.routes.push({
                route: 'example/news/add',
                callback: function() {
                    return '<div data-aura-component="news/form@examplenews"/>';
                }
            });

            app.sandbox.mvc.routes.push({
                route: 'example/news/edit::id',
                callback: function(id) {
                    return '<div data-aura-component="news/form@examplenews" data-aura-id="' + id + '"/>';
                }
            });
        }
    };
});
