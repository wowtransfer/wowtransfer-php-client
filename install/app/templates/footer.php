<?php

use Installer\App;
?>

<div id="footer" class="well well-sm">
	<div>
		<a href="http://wowtransfer.com?from=install" title="wowtransfer.com" class="pull-left">
			<img src="images/wowtransfer-icon-48.png" alt="wowtransfer.com">
		</a>

		<div class="btn-group pull-right">
			<button type="button" class="btn btn-default dropdown-toggle"
					data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<?= App::$app->getLanguage() ?> <span class="caret"></span>
			</button>
			<ul class="dropdown-menu">
				<li class="<?= App::$app->getLanguage() === 'ru' ? 'active' : '' ?>">
					<a href="?controller=app&action=lang&value=ru">RU</a>
				</li>
				<li class="<?= App::$app->getLanguage() === 'en' ? 'active' : '' ?>">
					<a href="?controller=app&action=lang&value=en">EN</a>
				</li>
			</ul>
		</div>

		Copyright © 2014,
		<a href="http://wowtransfer.com?from=install" title="wowtransfer.com">wowtransfer.com</a>
		<span class="label label-info">1.0</span> <br>
		<span class="glyphicon glyphicon-comment"></span>
		<a href="http://forum.wowtransfer.com?from=install" title="Форум wowtransfer.com">
			<?= App::t('Forum') ?>
		</a><br>
		<!--<a href="http://forum.wowtransfer.com" title="Форум wowtransfer.com">Документация</a>-->

		<img src="images/GitHub-Mark-32px.png" alt="" title="">
		<span class="glyphicon glyphicon-github"></span>
		<a href="https://github.com/wowtransfer" title="wowtransfer on github">
			<?= App::t('Github comunity') ?></a>,
		<span class="glyphicon glyphicon-github"></span>
		<a href="https://github.com/wowtransfer/chdphp" title="wowtransfer.com application">chdphp project</a>.

	</div>
</div>