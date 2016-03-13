<?php
/* @var $view \Installer\View */

use Installer\App;

$configAppFilePath = App::$app->getAppConfigAbsoluteFilePath();

$requirements = [
	'php_version' => [
		'value' => App::t('PHP version'),
		'result' => version_compare(phpversion(), '5.4', '>=') > 0,
		'comment' => App::t('The version must be >= 5.4'),
	],
	'ext_json' => [
		'value' => App::t('Extension') . ' <strong>json</strong>',
		'result' => extension_loaded('json'),
		'comment' => App::t('The functions for the json data work'),
	],
	'ext_pdo' => [
		'value' => App::t('Extension') . ' <strong>PDO</strong>',
		'result' => extension_loaded('pdo'),
		'comment' => App::t('Need for the PDO MySQL'),
	],
	'ext_pdo_mysql' => [
		'value' => App::t('Extension') . ' <strong>PDO MySQL</strong>',
		'result' => extension_loaded('pdo_mysql'),
		'comment' => App::t('Need for the MySQL work'),
	],
	'ext_zlib' => [
		'value' => App::t('Extension') . ' <strong>zlib</strong>',
		'result' => extension_loaded('zlib'),
		'comment' => App::t('Need for the compressing'),
	],
	'ext_gd' => [
		'value' => App::t('Extension') . ' <strong>gd</strong>',
		'result' => extension_loaded('gd'),
		'comment' => App::t('Need for the captcha'),
	],
	'config_app' => [
		'value' => App::$app->getAppConfigRelativeDir(),
		'result' => is_writable($configAppFilePath),
		'comment' => App::t('Write check'),
	],
];

foreach ($requirements as $name => $item) {
	$view->addCheckItem($name, $item);
	if (!$item['result']) {
		$view->addError(App::t('Warning') . ': ' . $item['value']);
	}
}

if (isset($_POST['submit']) && !$view->hasErrors()) {
	header('Location: index.php?page=core');
	exit;
}

?>

<form action="" method="post">

	<?php $view->errorSummary(); ?>

	<?php $view->printCheckTable (); ?>

	<div class="actions-panel">
		<button class="btn btn-primary" title="Next" type="submit" name="submit">
            <span class="glyphicon glyphicon-chevron-right"></span>
            <?= App::t('Next') ?>
        </button>
	</div>

</form>