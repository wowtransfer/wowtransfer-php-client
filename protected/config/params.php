<?

$params = [];

$appFilePath = __DIR__ . '/app.php';
if (!file_exists($appFilePath)) {
	$defaultFilePath = __DIR__ . '/app.default.php';
	$h = fopen($appFilePath, 'w');
	if ($h) {
		fwrite($h, file_get_contents($defaultFilePath));
		fclose($h);
	}
}
$params = array_merge($params, require_once $appFilePath);

$serviceFilePath = __DIR__ . '/service.php';
if (!file_exists($serviceFilePath)) {
	$defaultFilePath = __DIR__ . '/service.default.php';
	$h = fopen($serviceFilePath, 'w');
	if ($h) {
		fwrite($h, file_get_contents($defaultFilePath));
		fclose($h);
	}
}
$params = array_merge($params, require_once $serviceFilePath);

return $params;
