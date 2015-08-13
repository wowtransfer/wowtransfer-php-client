<?php
if (isset($_POST['remove_dir'])) {
	$result = $template->removeDir();
	if (!$template->hasErrors()) {
		header('Location: ' . getAppRelativeUrl());
		exit;
	}
}

?>

<div class="alert alert-success">
	Приложение уже установлено
</div>

<div>
	<?php $template->errorSummary() ?>
</div>

<div>
	<p>
		Для продолжения необходимо удалить директорию <code>/install</code>.
	</p>
	<form action="" method="post">
		<button type="submit" name="remove_dir" class="btn btn-primary" id="remove-install-dir">Удалить</button>
	</form>
</div>
