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
        }
    };
});
