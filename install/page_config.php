<?php
/* @var $template InstallerTemplate */

$fields = array('submit', 'back');

if (isset($_POST['back'])) {
	unset($_POST['back']);
	unset($_POST['submit']);

	$template->writeSubmitedFields();
	header('Location: index.php?page=privileges');
	exit;
}

if (isset($_POST['submit'])) {
	unset($_POST['back']);
	unset($_POST['submit']);

	if ($template->writeAppConfig() && !$template->hasErrors()) {
		header('Location: index.php?page=finish');
		exit;
	}
}

?>

<div class="alert alert-info">
	<p>На этом шаге запишутся некоторые параметры в конфигурационный файл приложения</p>
	<p><code><?= $template->getAppConfigRelativeFilePath() ?></code></p>
</div>

<form action="" method="post">

	<?php $template->errorSummary(); ?>

	<p class="text-center">Название таблицы с заявками:
		<span style="font-weight: bold;">
			<?php echo $template->getFieldValue('db_transfer_table'); ?>
		</span>
	</p>

	<p class="text-center">Ядро WoW сервера:
		<span style="font-weight: bold;">
			<?php echo $template->getFieldValue('core'); ?>
		</span>
	</p>

	<div class="actions-panel">
		<button class="btn btn-default" type="submit" name="back">Назад</button>
		<button class="btn btn-primary" type="submit" name="submit">Далее</button>

		<?php $template->printHiddenFields($fields); ?>
	</div>

</form>