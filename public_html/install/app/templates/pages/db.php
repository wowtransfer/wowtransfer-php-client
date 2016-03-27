<?php
use Installer\App;
use Installer\DatabaseManager;

$settings = App::$app->getSettings();
$fields = ['db_type', 'db_host', 'db_port', 'db_user', 'db_password', 'db_auth', 'db_characters'];

$defaultValues = [
	'trinity_335a' => [
		'user' => 'trinity',
		'password' => 'trinity',
		'auth' => 'auth',
		'characters' => 'characters',
	],
	/*'cmangos_335a' => [
		'user' => 'mangos',
		'password' => 'mangos',
		'auth' => 'realmd',
		'characters' => 'characters',	
	]*/
];
$core = $settings->getFieldValue('core');
$default = isset($defaultValues[$core]) ? $defaultValues[$core] : reset($defaultValues);

$dbHost = isset($_POST['db_host']) ? trim($_POST['db_host']) : 'localhost';
$dbPort = isset($_POST['db_port']) ? intval($_POST['db_port']) : 3306;
$dbUser = isset($_POST['db_user']) ? trim($_POST['db_user']) : $default['user'];
$dbPassword = isset($_POST['db_password']) ? $_POST['db_password'] : $default['password'];
$dbPassword2 = isset($_POST['db_password2']) ? $_POST['db_password2'] : $default['password'];
$dbAuth = isset($_POST['db_auth']) ? trim($_POST['db_auth']) : $default['auth'];
$dbCharacters = isset($_POST['db_characters']) ? trim($_POST['db_characters']) : $default['characters'];


if (isset($_POST['submit']))
{
	unset($_POST['submit']);
    App::$app->getSettings()->save();

	// validate
	if (empty($dbHost)) {
		$view->addError(App::t('Put the server'));
	}
	if (empty($dbUser)) {
		$view->addError(App::t('Put the user'));
	}
	if (empty($dbAuth)) {
		$view->addError(App::t('Put the name of database with accounts'));
	}
	if (empty($dbCharacters)) {
		$view->addError(App::t('Put the name of database with characters'));
	}
    if ($dbPassword != $dbPassword2) {
        $view->addError(App::t('Wrong confirmed password'));
    }

	if (!$view->hasErrors()) {
		$db = new DatabaseManager($view);
		$db->checkConnection();
	}
	if (!$view->hasErrors()) {
		header('Location: ' . App::$app->createUrl(['page' => 'user']));
		exit;
	}
}

if ($dbPassword != $default['password']) {
    $dbPassword = '';
}
?>

<div class="alert alert-info">
	<p><?= App::t('This step writes user information, which will have been installed application') ?>.</p>
	<?= App::t('User must have the privileges on') ?>
	<ul>
		<li>
			CREATE USER, <span class="lowercase"><?= App::t('Optional') ?></span>.
		</li>
		<li>CREATE, DROP <span class="lowercase"></span>
			<?= App::t('for a tables with the characters database') ?>.
		</li>
		<li>CREATE ROUTINE <span class="lowercase">
			<?= App::t('for the characters database') ?></span>.
		</li>
		<li>GRANT OPTION (SELECT, INSERT, UPDATE, EXECUTE)
			<span class="lowercase"><?= App::t('for the characters database') ?></span>.
		</li>
		<li>
			GRANT OPTION (SELECT) <?= App::t('for the accounts database') ?>.
		</li>
	</ul>
</div>

<div class="alert alert-warning">
	<?= App::t('Warning! User of the insalling is not user of the application') ?>.
</div>

<form action="" method="post">

	<?php $view->errorSummary(); ?>

	<label for="db_type"><?= App::t('Database type') ?></label>
	<select name="db_type" id="db_type" class="form-control">
		<option value="mysql" selected="selected">MySQL</option>
	</select>


	<label for="db_host"><?= App::t('Host') ?></label>
	<input type="text" name="db_host" id="db_host" value="<?php echo $dbHost; ?>" class="form-control" list="db_host_list">
	<datalist id="db_host_list">
		<option>localhost</option>
		<option>127.0.0.1</option>
	</datalist>

	<label for="db_port"><?= App::t('Port') ?></label>
    <input type="number" min="0" name="db_port" id="db_port" value="<?php echo $dbPort; ?>" class="form-control">
	<datalist id="db_port_list">
		<option>3306</option>
	</datalist>

	<label for="db_port"><?= App::t('User') ?></label>
	<input type="text" name="db_user" id="db_user" value="<?php echo $dbUser; ?>" class="form-control" list="db_user_list">
	<datalist id="db_user_list">
		<option>trinity</option>
		<option>mangos</option>
	</datalist>

	<label for="db_port"><?= App::t('Password') ?></label>
	<input type="password" name="db_password" id="db_password" value="<?php echo $dbPassword; ?>" class="form-control">

    <label for="db_port"><?= App::t('Confirm password') ?></label>
    <input type="password" name="db_password2" id="db_password2" value="<?php echo $dbPassword2; ?>" class="form-control">


	<label for="db_port"><?= App::t('Database with characters') ?></label>
	<input type="text" name="db_characters" id="db_character" value="<?php echo $dbCharacters; ?>" class="form-control" list="db_character_list">
	<datalist id="db_character_list">
		<option>characters</option>
	</datalist>

	<label for="db_port"><?= App::t('Database with an accounts') ?></label>
	<input type="text" name="db_auth" id="db_auth" value="<?php echo $dbAuth; ?>" class="form-control" list="db_auth_list">
	<datalist id="db_auth_list">
		<option>auth</option>
		<option>realmd</option>
	</datalist>


	<div class="actions-panel">
        <a class="btn btn-default" href="<?= App::$app->createUrl(['page' => 'core']) ?>">
            <span class="glyphicon glyphicon-chevron-left"></span>
            <?= App::t('Back') ?>
        </a>
		<button class="btn btn-primary" type="submit" name="submit">
            <span class="glyphicon glyphicon-chevron-right"></span>
            <?= App::t('Next') ?>
        </button>
	</div>

</form>