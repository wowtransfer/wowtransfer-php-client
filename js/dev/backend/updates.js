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
			if (response.download_url) {
				$("#download-latest-version").removeClass("hidden");
			}
		}, "json");
		var $btnDonload = $("#download-latest-version");
		$btnDonload.click(function() {
			var $a = $(this);
			$btnDonload.button("loading");
			$.post($a.attr("href"), function(response) {
				if (response.error_message) {
					var dialog = $("#chd-modal-info");
					dialog.find(".modal-body").text(response.error_message);
					dialog.modal('show', {
						keyboard: true
					});
				}
				else {
					window.location.reload();
				}
				$btnDonload.button("reset");
			}, "json");
			return false;
		});
	}

})(window.jQuery);
	
