<?php
use Installer\App;

App::$app->getSettings()->clear();
?>

<div class="form ">

<div class="alert alert-info">
	<?= App::t('Welcome to installer') ?>.
</div>

<div class="actions-panel">
	<a class="btn btn-primary" href="index.php?page=requirements" title="Install">
        <span class="glyphicon glyphicon-chevron-right"></span>
		<?= App::t('Begin install') ?>
	</a>
</div>

</div>