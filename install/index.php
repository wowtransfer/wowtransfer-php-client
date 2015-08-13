<?php
$root = __DIR__;
include_once $root . '/global.php';
include_once $root . '/template.php';
include_once $root . '/database.php';

$pages = array(
	'hello' => array(
		'title' => 'Добро пожаловать',
	),
	'requirements' => array(
		'title' => 'Проверка системных тербований',
	),
	'core' => array(
		'title' => 'Выбор ядра WoW сервера',
	),
	'db' => array(
		'title' => 'Подключение к базе',
	),
	'user' => array(
		'title' => 'Выбор пользователя',
	),
	'struct' => array(
		'title' => 'Создание таблиц',
	),
	'procedures' => array(
		'title' => 'Хранимые процедуры',
	),
	'privileges' => array(
		'title' => 'Права',
	),
	'config' => array(
		'title' => 'Конфигурация',
	),
	'finish' => array(
		'title' => 'Заключение',
	),
);

$i = 1;
foreach ($pages as $name => $item) {
	$pages[$name]['step'] = $i;
	++$i;
}

$template = new InstallerTemplate();

$pageName = isset($_GET['page']) ? $_GET['page'] : 'hello';
$hiddenFields = array();
$maket = 'main';

if ($template->isInstalled()) {
	$maket = 'installed';
	$pageName = 'installed';
}
else {
	$page = key_exists($pageName, $pages) ? $pages[$pageName] : reset($pages);
	if (!file_exists('page_' . $pageName . '.php')) {
		$page = reset($pages);
		$pageName = 'hello';
	}

	$stepCount = count($pages);
	$stepPercent = intval($page['step'] * 100 / $stepCount);

	$template->readSubmitedFields();
}

ob_start();
include_once $root . '/page_' . $pageName . '.php';
$content = ob_get_clean();

include_once $root . '/' . $maket . '.php';