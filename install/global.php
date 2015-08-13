<?php

/**
 * @return string
 */
function getAppRelativeUrl() {
	$url = '/' . substr(__DIR__, strlen($_SERVER['DOCUMENT_ROOT']) + 1);
	$url = str_replace('\\', '/', $url);
	// - '/install'
	$url = substr($url, 0, strlen($url) - 8);

	return $url;
}
