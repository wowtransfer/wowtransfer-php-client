<?php
/* @var $view Installer\View */
?>

<?php
	$glyphicon = 'glyphicon-ok';
?>
<nav>
    <ul>
	<?php foreach ($pages as $name => $menuPage): ?>
<?php

		$current = $name === $pageName;
		if ($current) {
			$glyphicon = 'glyphicon-arrow-right';
		}
?>
		<li class="<?= $name === $pageName ? 'active' : '' ?>">
			<span class="glyphicon <?= $glyphicon; ?>"></span>
			<?= $menuPage['title']; ?>
		</li>
<?php
		if ($current) {
			$glyphicon = 'glyphicon-remove';
		}
?>
	<?php endforeach ?>
    </ul>
</nav>