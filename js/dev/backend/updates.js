/**
 * 
 */
var app = app || {};

(function($) {

	var $latestVersion = $("#latest-version");
	if ($latestVersion.length) {
		$.get(app.getBaseUrl() + "/updates/latestRelease", function(response) {
			console.debug(response);
			$("#latest-version").html(response.version);
			$("#latest-date").html(response.updated_at);
		}, "json");
	}

})(window.jQuery);
	
