/*
 * Transfers module
 */
(function($) {
	var transfers = {};

	$(function() {

		initTransfersListview();

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
			$.fn.yiiListView.update("transfer-list-view", {
				complete: function() {
					initTransfersListview();
				}
			});

			return false;
		}
	}

	/**
	 * @returns {undefined}
	 */
	function initTransfersListview() {
		$("#transfer-list-view").on("click", ".transfer-delete", function() {
			var id = $(this).closest(".view").data("id");
			if (!confirm("Подтвердите удаление заявки #" + id)) {
				return false;
			}
			$.post(app.getBaseUrl() + "/transfers/delete/" + id, {}, function (data) {
				updateTransfersListview(data);
			}, "json");

			return false;
		});
	}

	return transfers;
}(window.jQuery));
