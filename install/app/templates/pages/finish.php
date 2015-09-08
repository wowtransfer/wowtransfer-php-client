<?php
use Installer\App;

$view->clearSubmitedFields();

if (isset($_POST['submit'])) {
	App::$app->removeDir();
	if (!$view->hasErrors()) {
		header('Location: ' . App::$app->getRelativeUrl());
		exit;
	}
}
?>

<div class="alert alert-success">
	Установка успешно завершена.
</div>

<div class="alert alert-danger">
	Необходимо удалить папку <code><b>install</b></code>.
</div>

<div class="alert alert-warning">
	<?php $view->errorSummary(); ?>

	<p>Настройте файлы конфигурации приложения:</p>
	<ul>
		<li>/protected/config/main.php - общая конфигурация.</li>
		<li>/protected/config/backend.php - конфигурация для пользовательской части.</li>
		<li>/protected/config/frontend.php - конфигурация для админской части.</li>
	</ul>
</div>

<form action="" method="post">


	<button class="btn btn-primary" type="submit" name="submit">Удалить папку <i>install</i> и перейти к авторизации</button>

</form>