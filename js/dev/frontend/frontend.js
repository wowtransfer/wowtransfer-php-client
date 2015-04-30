/**
 *
 */
function OnDeleteTransfer(id)
{
	if (!confirm("Подтвердите удаление заявки #" + id)) {
		return false;
	}

	$.ajax(config.homeUrl + "/transfers/delete/" + id, {
		type: "post",
		dataType: 'json',
		success: function (data) {
			var message = (data.error === undefined) ? data.message : data.error;
			var dialog = $("#chd-modal-info");
			dialog.find(".modal-body").text(message);

			$("#chd-modal-info").modal('show', {
				keyboard: true
			});

			$.fn.yiiListView.update("transfer-list-view", {});
		}
	});
}