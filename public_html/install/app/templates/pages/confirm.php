<?php
use Installer\App;

if (isset($_POST['back'])) {
    header('Location: index.php?page=config');
	exit;
}
if (isset($_POST['action'])) {
	// current action
    // next action
	// status
    // error message
}
?>

<form action="" method="post" id="confirm-form">

    <button class="btn btn-default" type="submit" name="back">
        <span class="glyphicon glyphicon-chevron-left"></span>
        <?= App::t('Back') ?>
    </button>

	<button class="btn btn-primary" type="submit" name="submit">
		<?= App::t('Install') ?>
	</button>

</form>
