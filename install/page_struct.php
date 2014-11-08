<?php

$fields = array('back', 'submit', 'db_transfer_table');

$dbTransferTableName = isset($_POST['db_transfer_table']) ? trim($_POST['db_transfer_table']) : 'chd_transfer';

if (isset($_POST['back']))
{
	unset($_POST['back']);
	unset($_POST['submit']);

	$template->writeSubmitedFields();
	header('Location: index.php?page=user');
	exit;
}

if (isset($_POST['submit']))
{
	unset($_POST['back']);
	unset($_POST['submit']);

	if (empty($dbTransferTableName))
		$template->addError('Введите название таблицы');
	elseif (!preg_match('/^[a-z_]+$/', $dbTransferTableName))
		$template->addError('Название таблицы может состоять из [a-z, _] символов');
	else
	{
		$db = new InstallerDatabaseManager($template);

		$db->createStructure();

		if (!$template->hasErrors())
		{
			$template->writeSubmitedFields();
			header('Location: index.php?page=procedures');
			exit;
		}
	}
}

?>

<form action="" method="post">

	<?php $template->errorSummary(); ?>

	<div class="alert alert-info">
		На этом шаге будут созданы таблицы в базе данных с персонажами.
	</div>

	<label for="db_transfer_table">Таблица для заявок на перенос</label>
	<input type="text" name="db_transfer_table" id="db_transfer_table" value="<?php echo $dbTransferTableName;?>" class="form-control">

	<pre class="sql-code" style="height: 400px;"><?php echo $template->loadDbStructure(); ?></pre>

	<div class="actions-panel">
		<button class="btn btn-default" type="submit" name="back">Назад</button>
		<button class="btn btn-primary" type="submit" name="submit">Далее</button>

		<?php $template->printHiddenFields($fields); ?>
	</div>

</form>