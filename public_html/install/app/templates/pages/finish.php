<?php
use Installer\App;

App::$app->getSettings()->clear();

if (isset($_POST['submit'])) {
	App::$app->removeDir();
	if (!$view->hasErrors()) {
		header('Location: ' . App::$app->getRelativeUrl());
		exit;
	}
}
?>

<div class="alert alert-success">
	<?= App::t('The installing has completed success') ?>.
</div>

<div class="alert alert-danger">
	<?= App::t('Remove the directory necessary') ?> <code><b>install</b></code>.
</div>

<?php $view->errorSummary(); ?>

<form action="" method="post">

	<button class="btn btn-primary" type="submit" name="submit">
		<?= App::t('Remove the directory "install" and go to the authorization') ?>
	</button>

</form>