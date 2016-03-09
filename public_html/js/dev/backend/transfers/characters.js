/**
 * 
 */
var app = app || {};

app.characters = (function($) {

	var characters = {};

	/**
	 * @param array messages
	 * @param string type
	 *   "errors"
	 *   "warnings"
	 * @return boolean
	 */
	function showMessages(messages, type)
	{
		var messageContainer = $("#create-char-" + type);

		messageContainer.empty();
		var ol = messageContainer.append("<ol>").find("ol");
		for (var i = 0; i < messages.length; ++i)
		{
			ol.append("<li>" + messages[i] + "</li>");
		}
		var a = $('#create-char-tabs a[href="#tab-' + type + '"]');
		a.tab("show");
		a.find("span").text(messages.length);

		return true;
	}

	/**
	 *
	 */
	function onBeforeCreateCharClick() {
		$("#btn-create-char").attr("disabled", "disabled");
		$("#create-char-wait").css("visibility", "visible");
		$("#create-char-sql").empty().removeClass("hidden");
		$("#create-char-errors").empty().removeClass("hidden");
		$("#create-char-warnings").empty().removeClass("hidden");
		$("#run-queries-table").empty();
		$('#create-char-tabs span').text("0");
	}

	/**
	 * @param {String} data
	 * @returns {Boolean}
	 */
	function onCreateCharClick(result) {
		$("#btn-create-char").removeAttr("disabled");
		$("#create-char-wait").css("visibility", "hidden");

		// 1
		$("#create-char-sql").text(result.sql);
		$('#create-char-tabs a[href="#tab-sql"] span').text(Math.floor(result.sql.length / 1024) + " kb");

		// 2
		var queries = result.queries;
		var queryCount = queries.length;
		var runQueriesContainer = $("#run-queries-table");
		runQueriesContainer.empty();
		for (var i = 0; i < queryCount; ++i) {
			query = queries[i];
			var failed = query.status === 'failed';
			runQueriesContainer.append('<a class="query-res query-res-' +
				(failed ? 'failed' : 'success') +
				'" ' +
				'href="#query_' + i + '" title="' + query.query + '">' +
				(failed ? '' : query.status) +
				'</a>');
		}
		runQueriesContainer.append("<hr>");
		for (var i = 0; i < queryCount; ++i) {
			query = queries[i];
			runQueriesContainer.append('<div id="query_' + i + '">'	+
				'<a href="#create-char-tabs" title="up"><span class="glyphicon glyphicon-chevron-up"></span></a> ' +
				'<span class="label label-info">' + i + '</span>' + ' Status: <code>' +
				query.status + "</code><pre>" + query.query + "</pre></div>");
		}
		$('#create-char-tabs a[href="#tab-queries"] span').text(queryCount);

		// 3
		showMessages(result.warnings, "warnings");

		if (result.errors !== undefined && result.errors.length > 0) {
			showMessages(result.errors, "errors");
			return false;
		}

		$("#btn-create-char").hide();
		$("#btn-create-char-success").show();
		$("#btn-delete-char").show();

		$('#create-char-tabs a[href="#tab-queries"]').tab("show");

		return true;
	}

	/**
	 *
	 */
	function onClearCharacterDataByTransferIdClick(url, transferId) {
		console.log("clearing");
		$.post(url, {id: transferId}, function() {

			console.log("cleared");
		}, "json");
	}

	/**
	 *
	 */
	function onClearCharacterDataByGuidClick(characterGuid) {
		alert("TODO: AJAX...");
	}

	/**
	 *
	 */
	function onShowCharacterDataClick(charactedGuid) {

	}

	/**
	 *
	 */
	function onViewUncryptedLuaDumpClick(transferId) {
		alert("TODO:\n view uncrypted lua dump.\nAJAX...");
	}

	/**
	 * Show only SQL
	 * @param {Object} $btn
	 * @param {Number} transferId
	 * @returns {undefined}
	 */
	function onOnlySqlClick($btn, transferId) {
		var url = $btn.attr("href");
		var $form = $("#create-char-from");

		$btn.button("loading");
		$.post(url, $form.serialize(), function(response) {
			var sqlSize = 0;
			var $sqlBlock = $("#create-char-sql");
			if (response.error) {
				$sqlBlock.text("");
				$("#create-char-errors").text(response.error).removeClass("hidden");
				$('#create-char-tabs a[href="#tab-errors"]').tab("show");
			}
			else {
				sqlSize = Math.floor(response.sql.length / 1024) + " kb";
				$sqlBlock.text(response.sql).removeClass("hidden");
				$('#create-char-tabs a[href="#tab-sql"]').tab("show");
				$("#create-char-warnings").empty().addClass("hidden");
				$("#create-char-errors").empty().addClass("hidden");
			}
			$('#create-char-tabs a[href="#tab-sql"] span').text(sqlSize);
		}, "json").always(function() {
			$btn.button("reset");
		});
	}

	characters.deleteCharacter = function($btn, onComplete) {
		var url = $btn.attr("href");

		$btn.button("loading");
		$.post(url, function (data) {
				if (data.error) {
					app.showMessage(data.error);
				}
				else {
					$btn.hide();
					if (typeof onComplete === "function") {
						onComplete();
					}
				}
			},  "json")
		.always(function() {
			$btn.button("reset");
		});
	};

	$(function() {

		var $transferRequest = $("#transfer"),
			transferId = $transferRequest.data("id"),
			charGuid = $transferRequest.data("char-guid");

		$("#view-luadump").click(function() {
			$.get(app.getBaseUrl() + "/transfers/luadump/" + transferId, {}, function (data) {
				$("#lua-dump-dialog-content").text(data);
				$("#lua-dump-dialog").modal({keyboard: true});
			});
		});

		$("#btn-create-char").click(function() {
			var $btn = $(this),
				url = $btn.data("href"),
				$form = $("#create-char-from");

			$btn.button("loading");
			onBeforeCreateCharClick();
			$.post(url, $form.serialize(), function(data) {
				onCreateCharClick(data);
			}, "json").always(function() {
				$btn.button("reset");
			});

			return false;
		});

		$("#btn-delete-char").click(function() {
			var $btn = $(this);
			app.dialogs.confirm($("#t-confirm-delete-character").text(), function() {
				$("#create-char-wait").css("visibility", "visible");
				characters.deleteCharacter($btn, function() {
					$("#btn-create-char").show();
					$("#run-queries-table").empty();
					$("#create-char-sql").empty();
					$("#create-char-wait").css("visibility", "hidden");
				});
			});
			return false;
		});

		$("#view-uncrypted-luadump").click(function() {
			onViewUncryptedLuaDumpClick(transferId);
			return false;
		});

		$("#show-char-info").click(function() {
			onShowCharacterDataClick(charGuid);
			return false;
		});

		$("#clear-by-guid").click(function() {
			onClearCharacterDataByGuidClick(charGuid);
			return false;
		});

		$("#clear-by-guid-id").click(function() {
			onClearCharacterDataByTransferIdClick($(this).attr("href"), transferId);
			return false;
		});

		$("#btn-only-sql").click(function() {
			onOnlySqlClick($(this), transferId);
			return false;
		});
	});

	return characters;

}(window.jQuery));