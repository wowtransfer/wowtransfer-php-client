<?php

/* @var $view \Installer\View */

use Installer\App;

$fields = ['submit', 'back'];

if (isset($_POST['back'])) {
	unset($_POST['back']);
	unset($_POST['submit']);

	$view->writeSubmitedFields();
	header('Location: index.php?page=privileges');
	exit;
}

if (isset($_POST['submit'])) {
	unset($_POST['back']);
	unset($_POST['submit']);

	if (App::$app->writeAppConfig() && !$view->hasErrors()) {
		header('Location: index.php?page=finish');
		exit;
	}
}

?>

<div class="alert alert-info">
	<p><?= App::t('This step have a writing of the params to configuration file') ?></p>
	<p><code><?= App::$app->getAppConfigRelativeFilePath() ?></code></p>
</div>

<form action="" method="post">

	<?php $view->errorSummary() ?>

	<p class="text-center"><?= App::t('The table for the transfer requests') ?>:
		<b><?= $view->getFieldValue('db_transfer_table') ?></b>
	</p>

	<p class="text-center"><?= App::t('Core of the WoW server') ?>:
		<b><?= $view->getFieldValue('core') ?></b>
	</p>

	<div class="actions-panel">
		<button class="btn btn-default" type="submit" name="back">
            <span class="glyphicon glyphicon-chevron-left"></span>
            <?= App::t('Back') ?>
        </button>
		<button class="btn btn-primary" type="submit" name="submit">
            <span class="glyphicon glyphicon-chevron-right"></span>
            <?= App::t('Next') ?>
        </button>

		<?php $view->printHiddenFields($fields) ?>
	</div>

</form>