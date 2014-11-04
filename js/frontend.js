/**
 *
 */
function OnDeleteTransferSuccess(data)
{
	var result = $.parseJSON(data);
	if (result === null)
		return false;

	var message = result.error ? result.error : result.message;
	var dialog = $("#chd-modal-info");
	dialog.find(".modal-body").text(message);

	$("#chd-modal-info").modal('show', {
		keyboard: true
	});

	$.fn.yiiListView.update("transfer-list-view", {});
}