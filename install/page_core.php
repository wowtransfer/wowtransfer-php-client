<?php
$fields = array('core');

if (isset($_POST['submit']))
{
	if (!$template->hasErrors())
	{
		unset($_POST['submit']);
		$template->writeSubmitedFields();
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
		<option value="cmangos_335a" <?php ?> >cmangos_335a</option>
	</select>

	<div class="actions-panel">
		<button class="btn btn-primary" type="submit" name="submit">Далее</button>

		<?php $template->printHiddenFields($fields); ?>
	</div>

</form>