<?php

/* @var $view Installer\View */
?>
<!DOCTYPE html>
<html>
	<head>
		<title><?= $view->getPageTitle() ?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">

		<link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="vendor/bootstrap/css/bootstrap-theme.min.css">

		<link rel="stylesheet" type="text/css" href="css/styles.css">
	</head>
	<body>
		<div id="page">

		<?= $content ?>

		<?php include_once __DIR__ . '/footer.php' ?>

		</div>

		<script src="vendor/jquery/jquery.min.js"></script>
		<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
        <script src="js/main.js"></script>
	</body>
</html>