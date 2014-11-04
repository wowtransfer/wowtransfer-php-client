<!DOCTYPE html>
<html>
<head>
	<title>Install</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<script src="js/bootstrap.min.js"></script>

	<link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>

<div id="page">

	<div id="header">
		Установка приложения<br>
		Шаг <?php echo $step ?> из <?php echo $stepCount; ?>: <?php echo $title; ?>.
	</div>

	<!-- menu -->
	<?php
	$glyphicon = 'glyphicon-ok';
	?>
	<ul id="menu">
		<?php foreach ($pages as $name => $page): ?>
<?php
			$current = $name === $pageName;
			if ($current)
				$glyphicon = 'glyphicon-arrow-right';
?>
			<li class="<?php if ($name === $pageName) echo 'active'; ?>">
				<span class="glyphicon <?php echo $glyphicon; ?>"></span>
				<?php echo $page['title']; ?>
			</li>
<?php
			if ($current)
				$glyphicon = 'glyphicon-remove';
?>
		<?php endforeach ?>
	</ul><!-- menu -->

	<div id="content" class="well">
		<?php echo $content; ?>
	</div>
	
	<div id="footer">
	
	</div>
</div>

</body>
</html>