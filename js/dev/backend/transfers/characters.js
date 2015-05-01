/**
 * 
 */
var app = app || {};


(function($) {

	var characters = {};

	/**
	 * @param array messages
	 * @param string type
	 *   "errors"
	 *   "warnings"
	 * @return boolean
	 */
	function ShowMessages(messages, type)
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
		$("#create-char-sql").empty();
		$("#create-char-errors").empty();
		$("#create-char-warnings").empty();
		$("#run-queries-table").empty();
		$('#create-char-tabs span').text("0");

		app.beginLoading("Создание персонажа...");
	}

	/**
	 *
	 */
	function onCreateCharClick(data) {
		app.endLoading();

		$("#btn-create-char").removeAttr("disabled");
		$("#create-char-wait").css("visibility", "hidden");
		/*console.log(data);//*/
		result = $.parseJSON(data);
		/*console.log(result);//*/
		if (result === null) {
			result = {"errors": ["Не удалось разобрать JSON"]};
		}

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
			runQueriesContainer.append('<a class="query-res query-res-success" ' +
				'href="#query_' + i + '" title="' + query.query + '">' + query.status + '</a>');
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
		ShowMessages(result.warnings, "warnings");

		if (result.errors !== undefined && result.errors.length > 0) {
			ShowMessages(result.errors, "errors");
			return false;
		}

		$("#btn-create-char").hide();
		$("#btn-create-char-cancel").hide();
		$("#btn-create-char-success").show();

		$('#create-char-tabs a[href="#tab-queries"]').tab("show");

		return true;
	}

	/**
	 *
	 */
	function onClearCharacterDataByTransferIdClick(transferId, characterGuid) {
		alert("TODO: AJAX...");
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
		alert("TODO:\n Character's information...\n AJAX...");
	}

	/**
	 *
	 */
	function onViewUncryptedLuaDumpClick(transferId) {
		alert("TODO:\n view uncrypted lua dump.\nAJAX...");
	}

	$(function() {

		var $transfer = $("#transfer");

		$("#view-luadump").click(function() {
			var transferId = $transfer.data("id");

			$.get(app.getBaseUrl() + "/transfers/luadump/" + transferId, {}, function (data) {
				$("#lua-dump-dialog-content").text(data);
				$("#lua-dump-dialog").modal({keyboard: true});
			});

		});

	});

	return characters;

}(window.jQuery));