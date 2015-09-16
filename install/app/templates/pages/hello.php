<?php
use Installer\App;

$view->clearSubmitedFields();
?>

<div class="form ">

<div class="alert alert-info">
	<?= App::t('Welcome to installer') ?>.
</div>

<div class="actions-panel">
	<a class="btn btn-primary" href="index.php?page=requirements" title="Install">
		<?= App::t('Begin install') ?>
	</a>
</div>

</div>