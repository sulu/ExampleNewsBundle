define(function() {

    'use strict';

    return {
        initialize: function() {
            this.$el.html('<h1>Hello awesome ' + this.options.name + ' world</h1>');
        }
    };
});
