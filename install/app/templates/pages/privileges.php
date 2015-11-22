<?php

use Installer\App;
use Installer\DatabaseManager;

$fields = ['submit', 'back'];

if (isset($_POST['back'])) {
	unset($_POST['back']);
	unset($_POST['submit']);

	$view->writeSubmitedFields();
	header('Location: index.php?page=struct');
	exit;
}

if (isset($_POST['submit'])) {
	unset($_POST['back']);
	unset($_POST['submit']);

	$db = new DatabaseManager($view);
	if ($db->applyPrivileges() && !$view->hasErrors()) {
		header('Location: index.php?page=config');
		exit;
	}
}
?>

<div class="alert alert-info">
	<?= App::t('This step have a privileges of the database objects') ?>.
</div>

<form action="" method="post">

	<?php $view->errorSummary(); ?>


	<p class="text-center">Пользователь:
		<span style="font-weight: bold;">
		<?= "'" . $view->getFieldValue('db_transfer_user') . "'@'" . $view->getFieldValue('db_transfer_user_host') . "'"; ?>
		</span>
	</p>

	<pre class="sql-code" style="height: 400px;"><?= App::$app->loadDbPrivileges (); ?></pre>

	<div class="actions-panel">
		<button class="btn btn-default" type="submit" name="back"><?= App::t('Back') ?></button>
		<button class="btn btn-primary" type="submit" name="submit"><?= App::t('Next') ?></button>

		<?php $view->printHiddenFields($fields); ?>
	</div>

</form>