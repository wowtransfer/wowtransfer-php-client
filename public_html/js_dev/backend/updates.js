define([
    'jquery',
    'backend/app',
    'common/dialogs'
], function($, app, dialogs) {

    var $latestVersion = $("#latest-version");
    if ($latestVersion.length) {
        $.get(app.getBaseUrl() + "updates/latestRelease", function (response) {
            $latestVersion.html(response.version);
            $("#latest-date").html(response.updated_at);
            if (response.download_url) {
                $("#download-latest-version").removeClass("hidden");
            }
            var currentVersion = $.trim($("#current-version").text());
            var latestVersion = $.trim($latestVersion.text());
            if (compareVersions(latestVersion, currentVersion) <= 0) {
                $("#current-version-installed").removeClass("hidden");
                $downloadBtn.hide();
            }
        }, "json");
        var $downloadBtn = $("#download-latest-version");
        $downloadBtn.click(function () {
            var $btn = $(this);
            $downloadBtn.button("loading");
            $.post($btn.attr("href"), function (response) {
                if (response.error_message) {
                    var dialog = $("#chd-modal-info");
                    dialog.find(".modal-body").text(response.error_message);
                    dialog.modal('show', {
                        keyboard: true
                    });
                }
                else {
                    window.location.reload();
                }
                $downloadBtn.button("reset");
            }, "json");
            return false;
        });

        var $updateBtn = $("#update-app");
        var currentAction = "extract";
        $updateBtn.click(function () {
            var message = $("#t-updating-danger-message").text();
            dialogs.confirm(message, function () {
                $("#updating-process-block").removeClass("hidden");
                updatingAction();
            });
            return false;
        });
    }

    /**
     * @param {String} newVersion
     * @param {String} oldVersion
     * @returns {Number}
     */
    function compareVersions(newVersion, oldVersion) {
        if (newVersion.charAt(0) === "v") {
            newVersion = newVersion.substr(1);
        }
        if (oldVersion.charAt(0) === "v") {
            oldVersion = oldVersion.substr(1);
        }
        var newNumbers = newVersion.split(".");
        var oldNumbers = oldVersion.split(".");
        while (newNumbers.length < 4) {
            newNumbers.push("0");
        }
        while (oldNumbers.length < 4) {
            oldNumbers.push("0");
        }

        // 4 numbers, not more
        // ex: 1.2.3.4 vs 2.2.3.4
        for (var i = 0; i < 4; ++i) {
            var result = newNumbers[i] - oldNumbers[i];
            if (result) {
                return result;
            }
        }
        return 0;
    }

    function updatingAction() {
        var url = $updateBtn.attr("href");
        var params = {action: currentAction};
        var $li = $("#upading-actions").find("li[data-action='" + currentAction + "']");
        $li.append('<span class="updating-action-status wait wait16"></span>');
        $.post(url, params, function (response) {
            $li.find(".updating-action-status")
                .removeClass()
                .addClass("updating-action-status glyphicon glyphicon-ok");
            var statusClass = response.error_message ? "list-group-item-danger" : "list-group-item-success";
            $li.addClass(statusClass);
            updatingErrorHandle(response);
            currentAction = response.next_action;
            if (currentAction) {
                updatingAction();
            }
            else {
                updatingEnd(response);
            }
        }, "json");
    }

    function updatingEnd(response) {
        var target = response.error_message ? "failed" : "success";
        $("#updating-total-message-" + target).removeClass("hidden");
    }

    function updatingErrorHandle(response) {

    }
});
