define([
    'jquery'
], function($) {

    var dialogs = {};

	/**
	 * @type Object
	 */
	var $dialogOkCancel;

	/**
	 * @type Function
	 */
	var onOkTemp;

	function onOkCancelCall() {
		if (typeof onOkTemp === "function") {
			onOkTemp();
		}
		$dialogOkCancel.modal("hide");
	}

	dialogs.confirm = function(message, onOk) {
		$dialogOkCancel.find(".modal-body").html(message);
		if (onOkTemp) {
			$dialogOkCancel.off("click", ".btn-primary", onOkCancelCall);
		}
		onOkTemp = onOk;
		$dialogOkCancel.on("click", ".btn-primary", onOkCancelCall);
		$dialogOkCancel.modal("show");
	};

	function init() {
		$dialogOkCancel = $("#common-dialog-okcancel");
	}
	init();

	return dialogs;
});
