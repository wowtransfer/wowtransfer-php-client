<?php
use Installer\App;
use Installer\Models\ConfirmForm;

if (isset($_POST['back'])) {
    header('Location: index.php?page=config');
	exit;
}

$action = isset($_POST['action']) ? trim($_POST['action']) : '';

$model = new ConfirmForm($this);
$model->run($action);
?>

<form action="" method="post" id="confirm-form">

    <div class="alert alert-danger" id="error">
        Error
    </div>

    <ul id="actions">

    </ul>

    <button class="btn btn-default" type="submit" name="back">
        <span class="glyphicon glyphicon-chevron-left"></span>
        <?= App::t('Back') ?>
    </button>

	<button class="btn btn-primary" type="submit" name="submit">
		<?= App::t('Install') ?>
	</button>

</form>
