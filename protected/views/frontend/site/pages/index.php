<?php
/* @var $this SiteController */

$this->pageTitle = Yii::app()->name . ' - Index';
$this->breadcrumbs = array(
	'Полезная информация',
);
?>

<h1>Полезная информация</h1>

<ul>
	<li>
		<a href="http://wowtransfer.com/downloads/chardumps/">
			<?= Yii::t('app', 'Download the addon for transfer') ?>
		</a>
	</li>
	<li>
		<a href="http://wowtransfer.com/docs/service/create-dump-335a/">
			<?= Yii::t('app', 'Create the dump of character in 3.3.5a') ?>
		</a>.
	</li>
	<li>
		<a href="http://wowtransfer.com/docs/service/tconfig-common/">
			<?= Yii::t('app', 'Transfer configurations') ?>
		</a>
	</li>
	<li><?= Yii::t('app', 'Request`s statuses') ?>:
		<ul>
			<li>process: заявка создана, никаких действий над ней не произведено.</li>
			<li>check: заявка проверяется администратором</li>
			<li>cancel: заявка отклонена по какой либо причине, написать сообщение почему.</li>
			<li>apply: заявка проверена и принята, по ней будет создан персонаж.</li>
			<li>game: заявка принята, персонаж созда, приятной игры.</li>
		</ul>
	</li>
</ul>