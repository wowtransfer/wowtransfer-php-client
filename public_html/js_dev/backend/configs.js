define([
    'jquery',
    'common/dialogs'
], function($, dialogs) {

    $("#check-service-connection").click(function() {
        var $button = $(this);
        var $form = $("#config-service-form");
        var url = $(this).attr("href");
        $.post(url, $form.serialize(), function(response) {
            if (response && response.cores.length) {
                alert("Success");
                $button.addClass("btn-success");
            } else {
                alert("Connection fail");
                $button.addClass("btn-danger");
            }
        }, "json");
        return false;
    });

});
