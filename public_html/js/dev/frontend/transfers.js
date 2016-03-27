/*
 * Transfers module
 */
(function($) {
	var transfers = {};

	$(function() {

		initTransfersListview();

		var $fileLua = $("#ChdTransfer_fileLua");
		$fileLua.change(function(event) {
			if (this.files && this.files.length) {
				onFileLuaChange(this, this.files[0]);
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
		$("#transfer-list-view-block").on("click", ".transfer-delete", function() {
			deleteTransfer(this);
			return false;
		});
	}

	/**
	 * @param {Object} btn The button element
	 * @returns {Boolean}
	 */
	function deleteTransfer(btn) {
		var $view = $(btn).closest(".view");
		var id = $view.data("id");
		var where = $view.data("where");
		var message = $("#t-configrm-request-delete").text() + " #" + id;
		app.dialogs.confirm(message, function() {
			$.post(app.getBaseUrl() + "transfers/delete/" + id, {}, function (response) {
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
	 * @param {Object} e
	 * @param {Object} file
	 * @returns {undefined}
	 */
	function onFileLuaChange(e, file) {
		if (window.FormData === undefined) {
			return false;
		}
		var formData = new FormData();
		formData.append("fileLua", file);

		$.ajax('getCommonFields', {
			type: "POST",
			cache: false,
			data: formData,
			processData: false,
			contentType: false,
			dataType: "json",
			success: function(response) {
				var $formGroup = $(e).closest(".form-group");
				var $helpBlock = $formGroup.find(".help-block");
				if (response.error_message) {
					$formGroup.addClass("has-error");
					$helpBlock.show().text(response.error_message);
				}
				else {
					$formGroup.addClass("has-success");
					$helpBlock.hide();
					$("#ChdTransfer_realmlist").val(response.realmlist);
					$("#ChdTransfer_realm").val(response.realm);
					$("#ChdTransfer_username_old").val(response.username);
				}
			}
		});
	}

	return transfers;
}(window.jQuery));
