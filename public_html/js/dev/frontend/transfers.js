require([
    'jquery',
    'frontend/main'
], function($, app) {
    var transfers = {};

    $(function () {

        initTransfersListview();

        var $fileLua = $("#ChdTransfer_fileLua");
        $fileLua.change(function (event) {
            if (this.files && this.files.length) {
                onFileLuaChange($(this), this.files[0]);
            }
            event.preventDefault();
            return false;
        });
    });

    /**
     * @param {Object} data
     * @returns {Boolean}
     */
    function updateTransfersListview(data) {
        var message = data.error ? data.error : data.message;

        var dialog = $("#chd-modal-info");
        dialog.find(".modal-body").text(message);
        dialog.modal('show', {
            keyboard: true
        });

        if (!data.error) {
            $.fn.yiiListView.update("transfer-list-view");
            return false;
        }
    }

    /**
     * @returns {undefined}
     */
    function initTransfersListview() {
        $("#transfer-list-view-block").on("click", ".transfer-delete", function () {
            deleteTransfer($(this));
            return false;
        });
    }

    /**
     * @param {Object}
     */
    function deleteTransfer($btn) {
        var $view = $btn.closest(".view");
        var id = $view.data("id");
        var where = $view.data("where");
        var message = $("#t-configrm-request-delete").text() + " #" + id;
        app.dialogs.confirm(message, function () {
            var url = $btn.attr("href");
            $.post(url, {}, function (response) {
                if (where === "card") {
                    window.location.href = response.returnUrl;
                }
                else {
                    updateTransfersListview(response);
                }
            }, "json");
        });
    }

    /**
     * @param {Object} $e
     * @param {Object} file
     * @returns {undefined}
     */
    function onFileLuaChange($e, file) {
        if (window.FormData === undefined) {
            return false;
        }
        var formData = new FormData();
        formData.append("fileLua", file);

        $.ajax($e.data('url'), {
            type: "POST",
            cache: false,
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function (response) {
                var $formGroup = $e.closest(".form-group");
                var $helpBlock = $formGroup.find(".help-block");
                if (response.error_message) {
                    $formGroup.addClass("has-error");
                    $helpBlock.show().text(response.error_message);
                }
                else {
                    $formGroup.addClass("has-success");
                    $helpBlock.hide();
                    var $realmlist = $("#ChdTransfer_realmlist");
                    $realmlist.val(response.realmlist).attr("readonly", 1);
                    var $realm = $("#ChdTransfer_realm");
                    $realm.val(response.realm).attr("readonly", 1);
                    var $username = $("#ChdTransfer_username_old");
                    $username.val(response.username).attr("readonly", 1);
                }
            }
        });
    }

    return transfers;
});
