require.config({
    paths: {
        examplenews: '../../examplenews/js',
        examplenewscss: '../../examplenews/css'
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
                    return '<div data-aura-component="news/edit@examplenews"/>';
                }
            });

            app.sandbox.mvc.routes.push({
                route: 'example/news/edit::id/:content',
                callback: function(id) {
                    return '<div data-aura-component="news/edit@examplenews" data-aura-id="' + id + '"/>';
                }
            });
        }
    };
});
