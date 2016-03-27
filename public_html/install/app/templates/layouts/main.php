<?php

/**
 * @var $page array
 * @var $stepCount int
 */
use Installer\App;
?>

<?php include_once '_header.php' ?>

<?php include_once '_menu.php' ?>


<main class="well well-sm">
	<h1><?= $page['title']; ?></h1>

	<?= $content ?>

</main>

<div class="clearfix"></div>
<?php if ($page['step']): ?>
	<div class="alert alert-warning">
		<?= App::t('If the errors was shown, please, visit our') ?>
		<a href="http://forum.wowtransfer.com?from=install" title="wowtransfer.com forum">
			<span class="lowercase"><?= App::t('Forum') ?></span>
		</a>
		<span class="lowercase"><?= App::t('Or') ?></span>
		<a href="http://wowtransfer.com/contact/?from=install" title="wowtransfer.com - Contact us">
			<span class="lowercase"><?= App::t('Contact us') ?></span>!
		</a>
	</div>
<?php endif ?>

<pre>
    <?= var_dump(App::$app->getSettings()->getFields()) ?>
</pre>