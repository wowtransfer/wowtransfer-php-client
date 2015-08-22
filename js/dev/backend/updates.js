/**
 * 
 */
var app = app || {};

(function($) {
	
	$("#get-lates-version").click(function() {
		$.get(app.getBaseUrl() + "/updates/latestRelease", function(response) {
			console.debug(response);
			var message = "<b>" + response.tag_name + "</b> " + response.created_at;
			message += " <a href='" + response.download_url + "'>" + response.name + "</a>";
			$("#latest-version").html(message);
		}, "json");
	});
	
})(window.jQuery);
	
