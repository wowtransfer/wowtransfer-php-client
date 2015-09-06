<?php

/**
 * @return null
 */
function checkInstalled() {
	$installedLocal = file_exists(__DIR__ . '/.installed');
	if (is_dir(__DIR__ . '/install') && !$installedLocal) {
		$installUrl = '/' . substr(__DIR__, strlen($_SERVER['DOCUMENT_ROOT']) + 1) . '/install';
		$installUrl = str_replace('\\', '/', $installUrl);
		header('Location: ' . $installUrl);
		exit;
	}
}

/**
 * @return null
 */
function preInitApp() {
	$appConfigsFilePath = __DIR__ . '/protected/config/app-local.php';

	$yiiFilePath = __DIR__ . '/../../../yii/yii.php';
	if (file_exists($appConfigsFilePath)) {
		$appConfigs = require $appConfigsFilePath;
		$debug = !empty($appConfigs['yiiDebug']);
		$traceLevel = isset($appConfigs['yiiTraceLevel']) ? (int)$appConfigs['yiiTraceLevel'] : 0;
		if (isset($appConfigs['yiiDir'])) {
			$yiiFilePath = $appConfigs['yiiDir'] . '/yii.php';
		}
	}
	else {
		$debug = false;
		$traceLevel = 0;
	}

	defined('YII_DEBUG') or define('YII_DEBUG', $debug);
	if ($traceLevel) {
		defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', $traceLevel);
	}

	require_once($yiiFilePath);
}
