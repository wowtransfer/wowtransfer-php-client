app = {};

app.getBaseUrl = function() {
	return "/chdphp/admin.php";
};

app.showMessage = function(message) {
	var $dialog = $("#dialog");
	$dialog.find(".modal-body").html(message);
	$dialog.modal();
};

app.beginLoading = function(message) {
	
};

app.endLoading = function() {
	
};
