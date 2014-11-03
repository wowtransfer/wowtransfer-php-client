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
function OnCreateCharClick(button, data, textStatus, jqXHR)
{
	var createCharErrorContainer = $("#create-char-error");
	var sqlContainer = $("#create-char-sql");
	var runQueriesContainer = $("#run-queries-table");

	$("#create-char-wait").css("visibility", "hidden");

	if (data == "")
		return;
	result = $.parseJSON(data);
	if (result == null)
		return;

	if (result.error != undefined && result.error)
	{
		createCharErrorContainer.show();
		createCharErrorContainer.text(result.error);
		return false;
	}
	else
	{
		$("#btn-create-char").hide();
		$("#btn-create-char-cancel").hide();

		$("#btn-create-char-success").show();
	}
	sqlContainer.text(result.sql);

	var span;
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
	alert("TODO:\n view lua dump.\nAJAX...");
}

/**
 *
 */
function OnViewUncryptedLuaDumpClick(transferId)
{
	alert("TODO:\n view uncrypted lua dump.\nAJAX...");
}