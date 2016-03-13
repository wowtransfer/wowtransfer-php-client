<?php
use Installer\App;
use Installer\DatabaseManager;

$dbTransferUser = isset($_POST['db_transfer_user']) ? trim($_POST['db_transfer_user']) : 'wowtransfer';
$dbTransferUserHost = isset($_POST['db_transfer_user_host']) ? trim($_POST['db_transfer_user_host']) : 'localhost';
$dbTransferPassword = isset($_POST['db_transfer_password']) ? trim($_POST['db_transfer_password']) : 'wowtransfer';

$fields = array('db_transfer_user', 'db_transfer_user_host', 'db_transfer_password', 'submit', 'back', 'next');

if (isset($_POST['back'])) {
	unset($_POST['submit']);
	unset($_POST['next']);
	unset($_POST['back']);

	header('Location: index.php?page=db');
	exit;
}

if (isset($_POST['submit'])) {
	unset($_POST['submit']);
	unset($_POST['next']);
	unset($_POST['back']);
    $_POST['db_transfer_user_create'] = 1;

	// simple checking...
	if (empty($dbTransferUser)) {
		$view->addError(App::t('Put the user name'));
	}
	elseif (empty($dbTransferPassword)) {
		$view->addError(App::t('Put the password'));
	}
	else {
		$db = new DatabaseManager($view);
		$db->createUser($dbTransferUser, $dbTransferPassword, $dbTransferUserHost);
		if (!$view->hasErrors()) {
			App::$app->getSettings()->save();
			header('Location: index.php?page=struct');
			exit;
		}
	}
}

if (isset($_POST['next'])) {
	unset($_POST['submit']);
	unset($_POST['next']);
	unset($_POST['back']);
    $_POST['db_transfer_user_next'] = 1;

	if (empty($dbTransferUser)) {
		$view->addError(App::t('Put the user name'));
	}
	else {
		App::$app->getSettings()->save();
		header('Location: index.php?page=struct');
		exit;
	}
}

?>

<p>
	<?= App::t('Select or create of the application`s user') ?>
</p>

<div class="alert alert-info">
	<?= App::t('Default the user and the password equal') ?> <code>wowtransfer</code>.
</div>

<ul>
	<li>
		<?= App::t('For the creating of new user put the name and password, press the "Create" button') ?>.
	</li>
	<li>
		<?= App::t('If the user alredy exists then put only name, the password will have skiped, press the "Next" button') ?>
	</li>
	<li>
		<?= App::t('The host usually have value "localhost"') ?>.
	</li>
</ul>

<form action="" method="post">

	<?php $view->errorSummary(); ?>

	<fieldset>

		<label for="db_transfer_user"><?= App::t('User') ?></label>
		<input type="text" name="db_transfer_user" id="db_transfer_user"
			   value="<?php echo $dbTransferUser; ?>" class="form-control"
			   list="db_transfer_user_list">
		<datalist id="db_transfer_user_list">
			<option>trinity</option>
			<option>mangos</option>
			<option>wowtransfer</option>
		</datalist>

		<label for="db_transfer_user_host"><?= App::t('Host') ?></label>
		<input type="text" name="db_transfer_user_host" id="db_transfer_user_host"
			   value="<?php echo $dbTransferUserHost; ?>" class="form-control"
			   list="db_transfer_user_host_list">
		<datalist id="db_transfer_user_host_list">
			<option>localhost</option>
		</datalist>

		<label for="db_transfer_user"><?= App::t('Password') ?></label>
		<input type="password" name="db_transfer_password" id="db_transfer_password" value="<?php echo $dbTransferPassword; ?>" class="form-control">
	</fieldset>

	<div class="actions-panel">
		<button class="btn btn-default" title="Back" type="submit" name="back">
            <span class="glyphicon glyphicon-chevron-left"></span>
            <?= App::t('Back') ?>
        </button>
		<button class="btn btn-success" title="Create" type="submit" name="submit">
            <span class="glyphicon glyphicon-chevron-right"></span>
            <?= App::t('Create') ?>
        </button>
		<button class="btn btn-primary" title="Next" type="submit" name="next">
            <span class="glyphicon glyphicon-chevron-right"></span>
            <?= App::t('Next') ?>
        </button>
	</div>

</form>