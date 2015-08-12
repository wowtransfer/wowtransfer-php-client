<?php
include_once 'common.php';

checkInstalled();

$yii = __DIR__ . '/../../yii/yii.php';
$config = __DIR__ . '/protected/config/frontend.php';

preInitApp();

require_once($yii);
Yii::createWebApplication($config)->runEnd('frontend');