<?php

/**
 * @return null
 */
function checkInstalled() {
	if (is_dir(__DIR__ . '/install')) {
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
	if (file_exists(__DIR__ . '/.gitignore')) {
		// remove the following lines when in production mode
		defined('YII_DEBUG') or define('YII_DEBUG', true);
		// specify how many levels of call stack should be shown in each log message
		defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 3);
	}
}
