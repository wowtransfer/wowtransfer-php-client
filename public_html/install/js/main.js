(function($) {

    console.log($);

    $(function () {
        var $form = $("#confirm-form");

        $form.submit(function() {
            install();
            return false;
        });

        function install() {
            var $backBtn = $form.find("button[name='back']");
            var $nextBtn = $form.find("button[name='submit']");

            $backBtn.attr("disabled", true);
            $nextBtn.attr("disabled", true);

            console.log($form.find("button[name='back']"));
            
            try {
                doAction("runInstallation");
            }
            catch (ex) {
                
            }
        }
        
        function doAction(action) {
            var $list = $("#actions");
            var li = "<li>" + action + "</li>";
            $list.append(li);
            var params = {action: action};
            $.post("", params, function(response) {
                if (response.finish) {
                    return true;
                }
                if (response.errorMessage) {
                    var text = "";
                    text += response.errorMessage;
                    text += "<br>";
                    text += "<a href='" + response.errorPageUrl + "'>Page</a>";
                    $("#error").html(text);
                    
                    return false;
                }
                doAction(response.nextAction);
            }, "json");
        }

        function startInstallation() {
            
        }

        function nextAction() {
            
        }

    });

})(window.jQuery);
