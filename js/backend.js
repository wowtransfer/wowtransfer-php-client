/**
 *
 */
function OnBeforeCreateCharClick(button)
{
	$("#create-char-wait").css("visibility", "visible");
	$("#create-char-sql").text("");
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
	sqlContainer.text("");
	sqlContainer.show();
	runQueriesContainer.text("");
	runQueriesContainer.show();
	createCharErrorContainer.hide();

	if (data == "")
		return;
	result = $.parseJSON(data);
	if (result == null)
		return;

	if (result.error != "undefined" && result.error)
	{
		createCharErrorContainer.show();
		createCharErrorContainer.text(result.error);
	}
	else
	{
		$("#btn-create-char").hide();
	}
	sqlContainer.text(result.sql);

	var span;
	var queries = result.queries;
	var queryCount = result.count;
	runQueriesContainer.empty();
	for (var i = 0; i < queryCount; ++i)
	{
		query = queries[i];
		runQueriesContainer.append('<span class="query-res query-res-success" title="' + query.query + '">' + query.status + '</span>');
	}
}