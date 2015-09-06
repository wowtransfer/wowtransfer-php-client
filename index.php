<?php
include_once 'common.php';

checkInstalled();

preInitApp();

$config = __DIR__ . '/protected/config/frontend.php';
Yii::createWebApplication($config)->runEnd('frontend');