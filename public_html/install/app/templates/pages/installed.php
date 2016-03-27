<?php
if (isset($_POST['remove_dir'])) {
	$result = $app->removeDir();
	if (!$view->hasErrors()) {
		header('Location: ' . getAppRelativeUrl());
		exit;
	}
}
?>

<div class="alert alert-success">
	<?= App::t('The application has installed alredy') ?>
</div>

<?php $view->errorSummary() ?>

<div>
	<p>
		<?= App::t('Remove the directory necessary') ?> "install".
	</p>
	<form action="" method="post">
		<button type="submit" name="remove_dir" class="btn btn-primary" id="remove-install-dir">
			<?= App::t('Delete') ?>
		</button>
	</form>
</div>
