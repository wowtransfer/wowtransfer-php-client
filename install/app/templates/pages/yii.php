<?php
use Installer\App;

$excludeFields = ['yii_dir', 'submit'];

$yiiDir = isset($_POST['yii_dir']) ? trim($_POST['yii_dir']) : '';

if (isset($_POST['submit'])) {
	if (empty($yiiDir)) {
		$view->addError(App::t('Bad framework path'));
	}
	else {
		$yiiDir = $_POST['yii_dir'] = rtrim($yiiDir, "\\/");
		$yiiFilePath = $yiiDir . DIRECTORY_SEPARATOR . 'yii.php';
		if (!is_file($yiiFilePath)) {
			$view->addError('Неверный путь: "' . $yiiDir . '", yii.php не найден');
		}
	}

	if (!$view->hasErrors()) {
		unset($_POST['submit']);
		$view->writeSubmitedFields();
		header('Location: index.php?page=core');
		exit;
	}
}
?>

<form action="" method="post">

	<? $view->errorSummary() ?>

	<div class="form-group">
		<label for="yii_dir" class="control-label"><?= App::t('Directory for') ?> yii.php</label>
		<input type="text" name="yii_dir" value="<?= $yiiDir ?>" id="yii_dir" class="form-control">
	</div>

	<div class="form-group">
		<label for="document_root">DOCUMENT_ROOT</label>
		<input type="text" name="document_root" value="<?= $_SERVER['DOCUMENT_ROOT'] ?>"
			   id="document_root" disabled="1" readonly="1" class="form-control"
			   aria-describedby="sizing-addon2">
	</div>
	

	<div class="actions-panel">
		<button class="btn btn-primary" type="submit" name="submit"><?= App::t('Next') ?></button>

		<? $view->printHiddenFields($excludeFields) ?>
	</div>

</form>
