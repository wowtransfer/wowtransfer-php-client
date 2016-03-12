<?php
use Installer\App;

$fields = ['core'];

if (isset($_POST['submit'])) {
	if (!$view->hasErrors()) {
		unset($_POST['back']);
		unset($_POST['submit']);
		$view->writeSubmitedFields();
		header('Location: index.php?page=db');
		exit;
	}
}
?>

<form action="" method="post">

	<label for="core" class="control-label"><?= App::t('Core of the WoW server') ?></label>
	<select name="core" id="core" class="form-control">
		<option value="trinity_335a">trinity_335a</option>
		<!--<option value="cmangos_335a">cmangos_335a</option>-->
	</select>

	<div class="actions-panel">
		<button class="btn btn-primary" type="submit" name="submit"><?= App::t('Next') ?></button>

		<?php $view->printHiddenFields($fields); ?>
	</div>

</form>
