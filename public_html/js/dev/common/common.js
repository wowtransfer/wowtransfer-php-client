$(function() {
	$(".toptions-block").on("click", ".toptions-btn", function() {
		var $checkboxes = $('#transfer-options-container input');
		var $btn = $(this);

        $checkboxes.prop('checked', $btn.is(":checked"));
	});
});