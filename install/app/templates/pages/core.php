<?php
$fields = ['core'];

if (isset($_POST['back'])) {
	unset($_POST['back']);
	unset($_POST['submit']);
	$view->writeSubmitedFields();
	header('Location: index.php?page=yii');
	exit;
}

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

	<!-- TODO: take this values from service -->
	<label for="core" class="control-label">Ядро WoW сервера</label>
	<select name="core" id="core" class="form-control">
		<option value="trinity_335a" <?php ?> >trinity_335a</option>
		<!--<option value="cmangos_335a" <?php ?> >cmangos_335a</option>-->
	</select>

	<div class="actions-panel">
		<button class="btn btn-default" type="submit" name="back">Назад</button>
		<button class="btn btn-primary" type="submit" name="submit">Далее</button>

		<?php $view->printHiddenFields($fields); ?>
	</div>

</form>
