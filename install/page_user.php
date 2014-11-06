<?php
$dbTransferUser = isset($_POST['db_transfer_user']) ? trim($_POST['db_transfer_user']) : 'wowtransfer';
$dbTransferPassword = isset($_POST['db_transfer_password']) ? trim($_POST['db_transfer_password']) : 'wowtransfer';

$fields = array('db_transfer_user', 'db_transfer_password');

if (isset($_POST['back']))
{
	unset($_POST['back']);
	$template->writeSubmitedFields();
	header('Location: index.php?page=db');
	exit;
}

if (isset($_POST['submit']))
{
	/*$template->setHiddenFields($_POST);
	$db = new InstallerDatabaseManager($template);

	$db->createUser();

	if (!$template->hasErrors())
	{
		header('Location: index.php?page=db');
		exit;
	}*/
}

if (isset($_POST['next']))
{
	// simple check user...
	if (empty($dbTransferUser))
		$template->addError('Введите имя пользователя');
	elseif (empty($dbTransferPassword))
		$template->addError('Введите пароль пользователя');
	else
	{
		unset($_POST['next']);
		$template->writeSubmitedFields();
		header('Location: index.php?page=struct');
		exit;
	}
}

?>

<div class="alert alert-info">Создание пользователя базы данных под которым будет работать приложение.</div>

<form action="" method="post">

	<?php $template->errorSummary(); ?>

	<label for="db_transfer_user">Пользователь</label>
	<input type="text" name="db_transfer_user" id="db_transfer_user" value="<?php echo $dbTransferUser; ?>" class="form-control">

	<label for="db_transfer_user">Пароль</label>
	<input type="text" name="db_transfer_password" id="db_transfer_password" value="<?php echo $dbTransferPassword; ?>" class="form-control">

	<div class="actions-panel">
		<button class="btn btn-primary" title="Next" type="submit" name="back">Назад</button>
		<button class="btn btn-primary" title="Next" type="submit" name="submit">Создать</button>
		<button class="btn btn-primary" title="Next" type="submit" name="next">Далее</button>

		<?php $template->printHiddenFields($fields); ?>
	</div>

</form>