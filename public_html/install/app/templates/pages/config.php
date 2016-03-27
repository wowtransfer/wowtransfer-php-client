<?php

/* @var $view \Installer\View */

use Installer\App;

$settings = App::$app->getSettings();

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
        <a class="btn btn-default" href="<?= App::$app->createUrl(['page' => 'privileges']) ?>">
            <span class="glyphicon glyphicon-chevron-left"></span>
            <?= App::t('Back') ?>
        </a>
		<a class="btn btn-primary" href="<?= App::$app->createUrl(['page' => 'confirm']) ?>">
            <span class="glyphicon glyphicon-chevron-right"></span>
            <?= App::t('Next') ?>
        </a>
	</div>

</form>