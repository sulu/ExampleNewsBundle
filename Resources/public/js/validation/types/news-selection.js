define(['type/default'], function(Default) {

    'use strict';

    var dataChangedHandler = function(data, $el) {
        App.emit('sulu.preview.update', $el, data);
        App.emit('sulu.content.changed');
    };

    return function($el, options) {
        var defaults = {},

            subType = {
                initializeSub: function() {
                    var dataChangedEvent = 'sulu.news-selection.' + options.instanceName + '.data-changed';

                    App.off(dataChangedEvent, dataChangedHandler);
                    App.on(dataChangedEvent, dataChangedHandler);
                },

                setValue: function(value) {
                    App.dom.data($el, 'news-selection', value);
                },

                getValue: function() {
                    return App.dom.data($el, 'news-selection');
                },

                needsValidation: function() {
                    return false;
                },

                validate: function() {
                    return true;
                }
            };

        return new Default($el, defaults, options, 'newsSelection', subType);
    };
});
