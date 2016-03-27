<?php
use Installer\App;
use Installer\Models\ConfirmForm;

$action = isset($_POST['actionName']) ? trim($_POST['actionName']) : '';
$model = new ConfirmForm($this);
$model->run($action);
?>

<div class="alert alert-danger hidden" id="error">
    <div class="error-message"></div>
    <div>
        <a href="#" class="error-page-url">Перейти</a>
    </div>
</div>

<ul id="actions" class="install-actions list-group"></ul>

<form action="" method="post" id="confirm-form">

    <a class="btn btn-default" href="<?= App::$app->createUrl(['page' => 'config']) ?>">
        <span class="glyphicon glyphicon-chevron-left"></span>
        <?= App::t('Back') ?>
    </a>

	<button class="btn btn-primary" type="submit" name="submit">
		<?= App::t('Install') ?>
	</button>

</form>
