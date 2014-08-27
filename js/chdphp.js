/**
 *
 */
function OnCreateCharClick(data, textStatus, jqXHR)
{
	var retrieveSqlErrorContainer = $("#retrieve-sql-error");
	var runSqlErrorContainer = $("#run-sql-error");
	var sqlContainer = $("#sql-content");
	var runQueriesContainer = $("#run-queries");

	$("#create-char-wait").css("visibility", "hidden");
	sqlContainer.text("");
	runQueriesContainer.text("");
	retrieveSqlErrorContainer.hide();
	runSqlErrorContainer.hide();

	if (data == "")
		return;
	result = $.parseJSON(data);
	if (result == null)
		return;

	var queries = result.queries;

	if (result.retrieve_sql_error != "")
	{
		retrieveSqlErrorContainer.show();
		retrieveSqlErrorContainer.text(result.retrieve_sql_error);
	}
	if (result.run_sql_error != "")
	{
		runSqlErrorContainer.show();
		runSqlErrorContainer.text(result.run_sql_error);
	}
	sqlContainer.text(result.sql);

	// create result table...
	// in $(#sql-run-result)
}