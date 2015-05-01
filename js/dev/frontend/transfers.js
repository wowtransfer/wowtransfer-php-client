/*
 * Transfers module
 */
(function($) {
	var transfers = {};

	$(function() {

		$("#transfer-list-view").on("click", ".transfer-delete", function() {
			var id = $(this).closest(".view").data("id");
			if (!confirm("Подтвердите удаление заявки #" + id)) {
				return false;
			}
			$.post(app.getBaseUrl() + "/transfers/delete/" + id, {}, function (data) {
				var message = (data.error === undefined) ? data.message : data.error;
				var dialog = $("#chd-modal-info");
				dialog.find(".modal-body").text(message);
				dialog.modal('show', {
					keyboard: true
				});

				$.fn.yiiListView.update("transfer-list-view", {});
			}, "json");
		});

	});

	return transfers;
}(window.jQuery));
