<!DOCTYPE html>
<html>
<head>
	<title><?php echo $page['title']; ?></title>
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

	<div id="header">
		<div class="clearfix">
			<div class="progress" style="margin: 0;">
				<div class="progress-bar progress-bar-success" role="progressbar"
					aria-valuenow="<?php echo $stepPercent; ?>" aria-valuemin="0"
					aria-valuemax="100" style="width: <?php echo $stepPercent; ?>%;">
					<?php echo $stepPercent; ?>%
				</div>
			</div>
		</div>
		<div style="font-size: large;">
			Шаг <?php echo $page['step']; ?> из <?php echo $stepCount; ?>: <?php echo $page['title']; ?>.
		</div>
	</div>


	<!-- menu -->
	<?php
	$glyphicon = 'glyphicon-ok';
	?>
	<div id="menu">
		<ul>
		<?php foreach ($pages as $name => $menuPage): ?>
<?php
			$current = $name === $pageName;
			if ($current)
				$glyphicon = 'glyphicon-arrow-right';
?>
			<li class="<?php if ($name === $pageName) echo 'active'; ?>">
				<span class="glyphicon <?php echo $glyphicon; ?>"></span>
				<?php echo $menuPage['title']; ?>
			</li>
<?php
			if ($current)
				$glyphicon = 'glyphicon-remove';
?>
		<?php endforeach ?>
		</ul>
	</div><!-- menu -->


	<div id="content" class="well">
		<h1 style="margin: 5px 5px 10px;"><?php echo $page['title']; ?></h1>

		<?php echo $content; ?>

		<hr>

		<?php if ($page['step']): ?>
			<div class="alert alert-warning">
				При возникновении проблем с установкой, пожалуйста, посетите наш
				<a href="http://forum.wowtransfer.com?from=install" title="wowtransfer.com forum">форум</a>
				или
				<a href="http://wowtransfer.com/contact/?from=install" title="wowtransfer.com - Contact us">напишите нам</a>!
			</div>
		<?php endif; ?>
	</div>

	<?php include_once 'footer.php'; ?>
</div>

</body>
</html>