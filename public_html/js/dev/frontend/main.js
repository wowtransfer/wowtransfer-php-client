require([
    'jquery',
    'common/common',
    'common/dialogs',
    'frontend/transfers'
], function($) {

    var app = {};

    /**
     * @returns {String}
     */
    app.getBaseUrl = function () {
        return "index.php?r=";
    };

    return app;
});
