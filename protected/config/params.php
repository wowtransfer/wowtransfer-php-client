<?

$params = [];

$appFilePath = __DIR__ . '/app.php';
if (!file_exists($appFilePath)) {
	$defaultFilePath = __DIR__ . '/app.default.php';
	copy($defaultFilePath, $appFilePath);
}
$params = array_merge($params, require $appFilePath);

$serviceFilePath = __DIR__ . '/service.php';
if (!file_exists($serviceFilePath)) {
	$defaultFilePath = __DIR__ . '/service.default.php';
	copy($defaultFilePath, $serviceFilePath);
}
$params = array_merge($params, require $serviceFilePath);

return $params;
