define([
    'jquery'
], function($) {

    $("#check-service-connection").click(function() {
        var $button = $(this);
        var $form = $("#config-service-form");
        var url = $(this).attr("href");
        $.post(url, $form.serialize(), function(response) {
            if (response && response.userInfo) {
                var message = "Success. User email: " + response.userInfo.email;
                alert(message);
                $button.addClass("btn-success");
            } else {
                alert("Connection fail");
                $button.addClass("btn-danger");
            }
        }, "json");
        return false;
    });

});
