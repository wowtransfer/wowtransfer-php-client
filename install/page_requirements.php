<?php
/* @var $template InstallerTemplate */

$configAppFilePath = $template->getAppConfigAbsoluteFilePath();

$requirements = array(
	'php_version' => array(
		'value' => 'Версия РНР',
		'result' => version_compare(phpversion(), '5.4', '>=') > 0,
		'comment' => 'Версия должна быть больше 5.4',
	),
	'ext_json' => array(
		'value' => 'Расширение <strong>json</strong>',
		'result' => extension_loaded('json'),
		'comment' => 'Функции для работы с json данными',
	),
	'ext_pdo' => array(
		'value' => 'Расширение <strong>PDO</strong>',
		'result' => extension_loaded('pdo'),
		'comment' => 'Необходимо для PDO MySQL',
	),
	'ext_pdo_mysql' => array(
		'value' => 'Расширение <strong>PDO MySQL</strong>',
		'result' => extension_loaded('pdo_mysql'),
		'comment' => 'Необходимо для работы с MySQL',
	),
	'ext_zlib' => array(
		'value' => 'Расширение <strong>zlib</strong>',
		'result' => extension_loaded('zlib'),
		'comment' => 'Необходимо для сжатия',
	),
	'ext_gd' => array(
		'value' => 'Расширение <strong>gd</strong>',
		'result' => extension_loaded('gd'),
		'comment' => 'Необходимо для капчи',
	),
	'config_app' => array(
		'value' => $template->getAppConfigRelativeDir(),
		'result' => is_writable($configAppFilePath),
		'comment' => 'Проверка на запись',
	),
);

foreach ($requirements as $name => $item) {
	$template->addCheckItem($name, $item);
	if (!$item['result']) {
		$template->addError('Предупреждение: ' . $item['value']);
	}
}

if (isset($_POST['submit']) && !$template->hasErrors()) {
	header('Location: index.php?page=core');
	exit;
}

?>

<form action="" method="post">

	<?php $template->errorSummary(); ?>

	<?php $template->printCheckTable(); ?>

	<div class="actions-panel">
		<button class="btn btn-primary" title="Next" type="submit" name="submit">Далее</button>
	</div>

</form>