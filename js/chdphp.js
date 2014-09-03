/**
 *
 */
function OnCreateCharClick(data, textStatus, jqXHR)
{
	var createCharErrorContainer = $("#create-char-error");
	var sqlContainer = $("#sql-content");
	var runQueriesContainer = $("#run-queries");

	$("#create-char-wait").css("visibility", "hidden");
	sqlContainer.text("");
	runQueriesContainer.text("");
	createCharErrorContainer.hide();

	if (data == "")
		return;
	result = $.parseJSON(data);
	if (result == null)
		return;

	var queries = result.queries;

	if (result.error != "")
	{
		createCharErrorContainer.show();
		createCharErrorContainer.text(result.error);
	}
	sqlContainer.text(result.sql);

	// create result table...
	// in $(#sql-run-result)
}