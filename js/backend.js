function chdInit(baseUrl)
{
	window.baseUrl = baseUrl;
}

/**
 *
 */
function OnBeforeCreateCharClick()
{
	$("#btn-create-char").attr('disabled', 'disabled');
	$("#create-char-wait").css("visibility", "visible");
	$("#create-char-sql").text("");
	$("#create-char-sql-header").hide();
	$("#create-char-error").hide();
	$("#run-queries-table").text("");
	$("#run-queries-table-header").hide();
	$('#create-char-tabs span').text("0");
}

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
function OnCreateCharClick(data)
{
	var sqlContainer = $("#create-char-sql");
	var runQueriesContainer = $("#run-queries-table");

	$("#btn-create-char").removeAttr("disabled");
	$("#create-char-wait").css("visibility", "hidden");
	/*console.log(data);//*/
	result = $.parseJSON(data);
	/*console.log(result);//*/
	if (result == null)
		result = {"errors": ["Не удалось разобрать JSON"]};

	if (result.errors != undefined && result.errors)
	{
		ShowMessages(result.errors, "errors");
		return false;
	}

	$("#btn-create-char").hide();
	$("#btn-create-char-cancel").hide();
	$("#btn-create-char-success").show();
	sqlContainer.text(result.sql);

	var queries = result.queries;
	var queryCount = queries.length;
	runQueriesContainer.empty();
	for (var i = 0; i < queryCount; ++i)
	{
		query = queries[i];
		runQueriesContainer.append('<span class="query-res query-res-success" title="' + query.query + '">' + query.status + '</span>');
	}

	$("#create-char-sql-header").show();
	sqlContainer.show();
	$("#run-queries-table-header").show();
	runQueriesContainer.show();

	return true;
}

/**
 *
 */
function OnClearCharacterDataByTransferIdClick(transferId, characterGuid)
{
	alert("TODO: AJAX...");
}

/**
 *
 */
function OnClearCharacterDataByGuidClick(characterGuid)
{
	alert("TODO: AJAX...");
}

/**
 *
 */
function OnShowCharacterDataClick(charactedGuid)
{
	alert("TODO:\n Character's information...\n AJAX...");
}

/**
 *
 */
function OnViewLuaDumpClick(transferId)
{
	var dialog = $("#lua-dump-dialog");
	var content = $("#lua-dump-dialog-content");

	$.ajax(window.baseUrl + "/transfers/luadump/" + transferId, {
		method: "GET",
		success: function (data, textStatus, jqXHR) {
			content.text(data);
		}
	});

	dialog.modal({keyboard: true});
}

/**
 *
 */
function OnViewUncryptedLuaDumpClick(transferId)
{
	alert("TODO:\n view uncrypted lua dump.\nAJAX...");
}