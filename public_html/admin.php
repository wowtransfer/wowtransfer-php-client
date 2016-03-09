<?php
include_once 'common.php';

checkInstalled();

preInitApp();

$config = __DIR__ . '/protected/config/backend.php';
Yii::createWebApplication($config)->runEnd('backend');