<?
use Installer\App;
use Installer\DatabaseManager;

$fields = array('submit', 'back');

if (isset($_POST['back']))
{
	unset($_POST['back']);
	unset($_POST['submit']);

	$view->writeSubmitedFields();
	header('Location: index.php?page=struct');
	exit;
}

if (isset($_POST['submit']))
{
	unset($_POST['back']);
	unset($_POST['submit']);

	$db = new DatabaseManager($view);
	if ($db->createProcedures() && !$view->hasErrors()) {
		$view->writeSubmitedFields();
		header('Location: index.php?page=privileges');
		exit;
	}
}

?>

<form action="" method="post">

	<? $view->errorSummary(); ?>

	<div class="alert alert-info">
		<?= App::t('This step have a creating of the stored procedures in the characters database') ?>.
	</div>

	<pre class="sql-code" style="height: 400px;"><?= App::$app->loadDbProcedures() ?></pre>

	<div class="actions-panel">
		<button class="btn btn-default" type="submit" name="back"><?= App::t('Back') ?></button>
		<button class="btn btn-primary" type="submit" name="submit"><?= App::t('Next') ?></button>

		<? $view->printHiddenFields($fields); ?>
	</div>

</form>