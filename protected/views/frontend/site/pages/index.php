<?php
/* @var $this SiteController */

$this->pageTitle = Yii::app()->name . ' - Index';
$this->breadcrumbs = array(
	'Полезная информация',
);
?>

<h1>Полезная информация</h1>

<ul>
<li><a href="http://wowtransfer.com/downloads/addon/">Скачать аддон для трансфера</a>.
</li>
<li><a href="http://wowtransfer.com/docs/create-dump-335a/">Создание дампа персонажа в игре 3.3.5a</a>.
</li>
<li><a href="http://wowtransfer.com/docs/create-dump-434/">Создание дампа персонажа в игре 4.3.4</a></li>
<li>Создание заявки на перенос <span class="label label-warning">todo</span></li>
<li><a href="<?php echo $this->createUrl('/site/page/', array('view' => 'tconfigs')) ?>">Конфигурации переноса</a> <span class="label label-warning">todo</span></li>
<li>Статусы заявок:
	<ul>
		<li>process: заявка создана, никаких действий над ней не произведено.</li>
		<li>check: заявка проверяется администратором</li>
		<li>cancel: заявка отклонена по какой либо причине, написать сообщение почему.</li>
		<li>apply: заявка проверена и принята, по ней будет создан персонаж.</li>
		<li>game: заявка принята, персонаж созда, приятной игры.</li>
	</ul>
</li>
</ul>