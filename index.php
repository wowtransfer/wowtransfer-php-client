<?php
$installDir = dirname(__FILE_) . '/install';
if (is_dir($installDir))
{
	header('Location: install/');
	exit;
}

$yii = dirname(__FILE__) . '/../../yii/yii.php';
$config = dirname(__FILE__) . '/protected/config/frontend.php';

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG', true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 3);

require_once($yii);
Yii::createWebApplication($config)->runEnd('frontend');