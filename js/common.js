$(function() {
	$(".toptions-block").on("click", ".toptions-btn", function() {
		var checkboxes = $('#transfer-options-container input');
		var $btn = $(this);

		if ($btn.hasClass("set")) {
			checkboxes.prop('checked', true);
		}
		else if ($btn.hasClass("unset")) {
			checkboxes.prop('checked', false);
		}
		else {
			checkboxes.prop('checked', function (i, value) {
				return !value;
			});
		}
	});
});