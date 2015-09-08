<?php
use Installer\DatabaseManager;

$dbTransferUser = isset($_POST['db_transfer_user']) ? trim($_POST['db_transfer_user']) : 'wowtransfer';
$dbTransferUserHost = isset($_POST['db_transfer_user_host']) ? trim($_POST['db_transfer_user_host']) : 'localhost';
$dbTransferPassword = isset($_POST['db_transfer_password']) ? trim($_POST['db_transfer_password']) : 'wowtransfer';

$fields = array('db_transfer_user', 'db_transfer_user_host', 'db_transfer_password', 'submit', 'back', 'next');

if (isset($_POST['back'])) {
	unset($_POST['submit']);
	unset($_POST['next']);
	unset($_POST['back']);

	$view->writeSubmitedFields();
	header('Location: index.php?page=db');
	exit;
}

if (isset($_POST['submit'])) {
	unset($_POST['submit']);
	unset($_POST['next']);
	unset($_POST['back']);

	// simple checking...
	if (empty($dbTransferUser)) {
		$view->addError('Введите имя пользователя');
	}
	elseif (empty($dbTransferPassword)) {
		$view->addError('Введите пароль');
	}
	else {
		$db = new DatabaseManager($view);
		$db->createUser($dbTransferUser, $dbTransferPassword, $dbTransferUserHost);
		if (!$view->hasErrors()) {
			$view->writeSubmitedFields();
			header('Location: index.php?page=struct');
			exit;
		}
	}
}

if (isset($_POST['next'])) {
	unset($_POST['submit']);
	unset($_POST['next']);
	unset($_POST['back']);

	if (empty($dbTransferUser)) {
		$view->addError('Введите имя пользователя');
	}
	else {
		$view->writeSubmitedFields();
		header('Location: index.php?page=struct');
		exit;
	}
}

?>

<p>
	Выбор или создание пользователя базы данных под которым будет работать приложение.
</p>

<div class="alert alert-info">
По-умолчанию пользователь и пароль равны <code>wowtransfer</code>.
</div>

<ul>
	<li>Для создания нового пользователя введите <i>имя</i> и <i>пароль</i>, нажмите кнопку "<strong>Создать</strong>".</li>
	<li>Если пользователь уже существует то введите только его <i>имя</i>, пароль не будет учитывается, нажмите кнопку "<strong>Далее</strong>".</li>
	<li>Хост, как правило, имеет значение <i>localhost</i>.</li>
</ul>

<form action="" method="post">

	<?php $view->errorSummary(); ?>

	<fieldset>
		<legend>Пользователь</legend>

		<label for="db_transfer_user">Имя</label>
		<input type="text" name="db_transfer_user" id="db_transfer_user"
			   value="<?php echo $dbTransferUser; ?>" class="form-control"
			   list="db_transfer_user_list">
		<datalist id="db_transfer_user_list">
			<option>trinity</option>
			<option>mangos</option>
			<option>wowtransfer</option>
		</datalist>

		<label for="db_transfer_user_host">Хост</label>
		<input type="text" name="db_transfer_user_host" id="db_transfer_user_host"
			   value="<?php echo $dbTransferUserHost; ?>" class="form-control"
			   list="db_transfer_user_host_list">
		<datalist id="db_transfer_user_host_list">
			<option>localhost</option>
		</datalist>

		<label for="db_transfer_user">Пароль</label>
		<input type="password" name="db_transfer_password" id="db_transfer_password" value="<?php echo $dbTransferPassword; ?>" class="form-control">
	</fieldset>

	<div class="actions-panel">
		<button class="btn btn-default" title="Back" type="submit" name="back">Назад</button>
		<button class="btn btn-primary" title="Create" type="submit" name="submit">Создать</button>
		<button class="btn btn-primary" title="Next" type="submit" name="next">Далее</button>

		<?php $view->printHiddenFields($fields); ?>
	</div>

</form>