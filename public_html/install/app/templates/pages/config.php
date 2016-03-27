<?php

/* @var $view \Installer\View */

use Installer\App;

$settings = App::$app->getSettings();
$fields = ['submit', 'back'];

if (isset($_POST['back'])) {
	header('Location: ' . App::$app->createUrl(['page' => 'privileges']));
	exit;
}

if (isset($_POST['submit'])) {
    header('Location: ' . App::$app->createUrl(['page' => 'confirm']));
	exit;
}

?>

<div class="alert alert-info">
	<p><?= App::t('This step have a writing of the params to configuration file') ?></p>
	<p><code><?= App::$app->getAppConfigRelativeFilePath() ?></code></p>
</div>

<form action="" method="post">

	<?php $view->errorSummary() ?>

	<p class="text-center"><?= App::t('The table for the transfer requests') ?>:
		<b><?= $settings->getFieldValue('db_transfer_table') ?></b>
	</p>

	<p class="text-center"><?= App::t('Core of the WoW server') ?>:
		<b><?= $settings->getFieldValue('core') ?></b>
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
	</div>

</form>