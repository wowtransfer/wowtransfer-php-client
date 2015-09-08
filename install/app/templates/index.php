<?
/* @var $view Installer\View */
?>
<!DOCTYPE html>
<html>
	<head>
		<title><?= $view->getPageTitle() ?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">

		<script src="http://code.jquery.com/jquery-2.1.1.min.js"></script>

		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap-theme.min.css">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>

		<link rel="stylesheet" type="text/css" href="css/styles.css">
		<script src="js/main.js"></script>
	</head>
	<body>
		<div id="page">

		<?= $content ?>

		<? include_once __DIR__ . '/footer.php' ?>

		</div>
	</body>
</html>