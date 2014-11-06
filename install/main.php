<!DOCTYPE html>
<html>
<head>
	<title>Install</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<script src="http://code.jquery.com/jquery-2.1.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>

	<link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>

<div id="page">

	<div id="header">
		<div class="clearfix">
			<div class="progress-bar" role="progressbar"
				aria-valuenow="<?php echo $stepPercent; ?>" aria-valuemin="0"
				aria-valuemax="100" style="width: <?php echo $stepPercent; ?>%;">
			<?php echo $stepPercent; ?>%
			</div>
		</div>
		Установка приложения<br>
		Шаг <?php echo $page['step']; ?> из <?php echo $stepCount; ?>: <?php echo $page['title']; ?>.
	</div>

	<!-- menu -->
	<?php
	$glyphicon = 'glyphicon-ok';
	?>
	<ul id="menu">
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
	</ul><!-- menu -->

	<div id="content" class="well">
		<h1><?php echo $page['title']; ?></h1>
	
		<?php echo $content; ?>
	</div>
	
	<div id="footer">
		<?php echo '<pre>', count($_POST), '</pre>'?>
	</div>
</div>

</body>
</html>