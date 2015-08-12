<?php
include_once 'common.php';

checkInstalled();

$yii = __DIR__ . '/../../yii/yii.php';
$config = __DIR__ . '/protected/config/backend.php';

preInitApp();

require_once $yii;
Yii::createWebApplication($config)->runEnd('backend');