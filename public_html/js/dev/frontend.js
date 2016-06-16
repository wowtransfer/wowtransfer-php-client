requirejs.config({
    baseUrl: '/js/dev',
});

define('jquery', function() {
    return window.jQuery;
});

require([
    'frontend/main'
], function() {
});
