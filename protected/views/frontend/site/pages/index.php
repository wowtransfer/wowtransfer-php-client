<?php
/* @var $this SiteController */

$this->pageTitle = Yii::app()->name . ' - Index';
$this->breadcrumbs = array(
	'Полезная информация',
);
?>

<h1>Полезная информация</h1>

<ul>
<li><a href="http://wowtransfer.com/downloads/addon/">Скачать аддон для трансфера</a> с сервиса <a href="http://wowtransfer.com">wowtransfer.com</a>.
</li>
<li><a href="http://wowtransfer.com/docs/create-dump-335a/">Создание дампа персонажа в игре 3.3.5a</a> доступно в документации на сервисе.
</li>
<li><a href="http://wowtransfer.com/docs/create-dump-434/">Создание дампа персонажа в игре 4.3.4</a> доступно в документаци на сервисе</li>
<li>Создание заявки на перенос <span class="label label-warning">todo</span></li>
<li><a href="<?php echo $this->createUrl('/site/page/', array('view' => 'tconfigs')) ?>">Конфигурации переноса</a> <span class="label label-warning">todo</span></li>
</ul>