define([
    'jquery',
    'common/dialogs'
], function($, dialogs) {

    $("#check-service-connection").click(function() {
        var $form = $("#config-service-form");
        var url = $(this).attr("href");
        $.post(url, $form.serialize(), function(response) {
            console.log(response);
            if (response && response.api_version) {
                alert("Success. API version: " + response.api_version);
            } else {
                alert("Connection fail");
            }
        }, "json");
        return false;
    });

});
