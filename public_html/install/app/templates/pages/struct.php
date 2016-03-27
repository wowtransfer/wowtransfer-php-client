<?php
use Installer\App;
use Installer\DatabaseManager;

$dbTransferTableName = isset($_POST['db_transfer_table']) ? trim($_POST['db_transfer_table']) : 'chd_transfer';

if (isset($_POST['submit'])) {
	unset($_POST['submit']);

	if (empty($dbTransferTableName)) {
		$view->addError(App::t('Put the table name'));
	}
	elseif (!preg_match('/^[a-z_]+$/', $dbTransferTableName)) {
		$view->addError(App::t('The table name can consist of') . ' [a-z, _]');
	}

    if (!$view->hasErrors()) {
        App::$app->getSettings()->save();
        header('Location: ' .  App::$app->createUrl(['page' => 'privileges']));
        exit;
    }

}

?>

<form action="" method="post">

	<?php $view->errorSummary(); ?>

	<div class="alert alert-info">
		<?= App::t('This step have a creating of the tables in the characters database') ?>.
	</div>

	<label for="db_transfer_table">
		<?= App::t('The table for the transfer requests') ?>
	</label>
	<input type="text" name="db_transfer_table" id="db_transfer_table"
		   value="<?= $dbTransferTableName;?>" class="form-control"
		   list="db_transfer_table_list">
	<datalist id="db_transfer_table_list">
		<option>chd_transfer</option>
	</datalist>

	<pre class="sql-code"><?= App::$app->loadDbStructure(); ?></pre>

	<div class="actions-panel">
		<a class="btn btn-default" href="<?= App::$app->createUrl(['page' => 'user']) ?>">
            <span class="glyphicon glyphicon-chevron-left"></span>
            <?= App::t('Back') ?>
        </a>
		<button class="btn btn-primary" type="submit" name="submit">
            <span class="glyphicon glyphicon-chevron-right"></span>
            <?= App::t('Next') ?>
        </button>
	</div>

</form>