function chdInit(baseUrl)
{
	window.baseUrl = baseUrl;
}

/**
 *
 */
function OnBeforeCreateCharClick(button)
{
	$("#create-char-wait").css("visibility", "visible");
	$("#create-char-sql").text("");
	$("#create-char-sql-header").hide();
	$("#create-char-error").hide();
	$("#run-queries-table").text("");
	$("#run-queries-table-header").hide();
}

/**
 *
 */
function OnCreateCharClick(data)
{
	var createCharErrorContainer = $("#create-char-error");
	var sqlContainer = $("#create-char-sql");
	var runQueriesContainer = $("#run-queries-table");

	$("#create-char-wait").css("visibility", "hidden");

	result = $.parseJSON(data);
	if (result == null)
		return;

	if (result.error != undefined && result.error)
	{
		createCharErrorContainer.text(result.error);
		createCharErrorContainer.show();
		return false;
	}
	else
	{
		$("#btn-create-char").hide();
		$("#btn-create-char-cancel").hide();
		$("#btn-create-char-success").show();
	}
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