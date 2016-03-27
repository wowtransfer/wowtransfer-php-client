<?php
use Installer\App;

/* @var $view Installer\View */
?>
<header>
	<div class="progress">
        <div class="progress-bar progress-bar-success" role="progressbar"
            aria-valuenow="<?= $stepPercent; ?>" aria-valuemin="0"
            aria-valuemax="100" style="width: <?= $stepPercent; ?>%;">
            <?= $stepPercent; ?>%
        </div>
    </div>
	<div>
		<?= App::t('Step') ?> <?= $page['step']; ?> / <?= $stepCount; ?>: <?= $view->getPageTitle() ?>.
	</div>
</header>
