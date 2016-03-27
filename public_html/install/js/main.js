(function($) {

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

            var action = new ConfirmAction();
            action.name = "runInstallation";
            action.description = "Установка";
            doAction(action);

            /**
             * @param {ConfirmAction} action
             * @returns {undefined}
             */
            function doAction(action) {
                var $list = $("#actions"),
                    params = {actionName: action.name},
                    $li = $("<li>");

                $li.html("<img src='images/wait24.gif'>" + action.description);
                $li.addClass("list-group-item");
                $list.append($li);
                $.post("", params, function (response) {
                    $li.html(action.description);
                    if (response.errorMessage) {
                        $li.addClass("list-group-item-danger");
                        onError(response);
                        return false;
                    }
                    $li.addClass("list-group-item-success");
                    onSuccess(response);
                }, "json");
            }

            function onError(response) {
                var $error = $("#error");
                $error.find(".error-message").html(response.errorMessage);
                $error.find(".error-page-url").attr("href", response.errorPageUrl);
                $error.removeClass("hidden");
            }

            function onSuccess(response) {
                if (response.finish) {
                    setTimeout(function() {
                        window.location.href = response.finishUrl;
                    }, 1000);
                    return true;
                }
                var nextAction = new ConfirmAction();
                nextAction.name = response.nextActionName;
                nextAction.description = response.nextActionDescription;

                doAction(nextAction);

                return true;
            }

            function ConfirmAction() {
                this.name = '';
                this.description = '';
            };
        }

    });

})(window.jQuery);
