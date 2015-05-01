app = {};

app.getBaseUrl = function() {
	return "/chdphp/admin.php";
};

app.showMessage = function(message) {
	var $dlg = $("#dialog");
	$dlg.html('<div class="alert alert-success">' + message + '</div>');
	$dlg.dialog("open");
	$dlg.animate({opacity: 1.0}, 1000).fadeOut("slow", function() {
		$dlg.dialog("close");
	});
};

app.beginLoading = function(message) {
	var $dlg = $("#dialog-loading");
	$dlg.html('<div class="alert alert-info">' + message + '</div>');
	$dlg.dialog("open");
};

app.endLoading = function() {
	$("#dialog-loading").dialog("close");
};
