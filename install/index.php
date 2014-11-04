<?php

$pages = array(
	'hello' => array(
		'step' => 1,
		'title' => 'Добро пожаловать',
	),
	'requirements' => array(
		'step' => 2,
		'title' => 'Проверка системных тербований',
	),
	'connect' => array(
		'step' => 3,
		'title' => 'Подключение к базе',
	),
	'step1' => array(
		'title' => 'Создание пользователя',
		'step' => 4,
	),
	'step2' => array(
		'title' => 'Создание таблиц',
		'step' => 5,
	),
	'step3' => array(
		'title' => 'Хранимые процедуры',
		'step' => 6,
	),
	'step4' => array(
		'title' => 'Создание прав',
		'step' => 7,
	),
	'finish' => array(
		'title' => 'Заключение',
		'step' => 8,
	),
);

$step = 0;
$stepCount = count($pages);
$pageName = isset($_GET['page']) ? $_GET['page'] : 'hello';

$page = key_exists($pageName, $pages) ? $pages[$pageName] : reset($pages);
if (!file_exists('page_' . $pageName . '.php'))
	$page = reset($pages);

$title = 'Установка приложения';

ob_start();
include_once('page_' . $pageName . '.php');
$content = ob_get_clean();

include_once('main.php');