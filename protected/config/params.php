<?

$params = [];

if (file_exists(__DIR__ . '/app.php')) {
	$params = array_merge($params, require_once __DIR__ . '/app.php');
}
if (file_exists(__DIR__ . '/service.php')) {
	$params = array_merge($params, require_once __DIR__ . '/service.php');
}

return $params;
