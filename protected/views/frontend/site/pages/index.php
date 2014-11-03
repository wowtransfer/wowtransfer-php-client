<?php
/* @var $this SiteController */

$this->pageTitle = Yii::app()->name . ' - Index';
$this->breadcrumbs = array(
	'Полезная информация',
);
?>

<h1>Полезная информация</h1>

<ul>
<li><a href="<?php echo $this->createUrl('/site/page/', array('view' => 'addon')) ?>">Где скачать аддон для трансфера?</a></li>
<li>Создание дампа персонажа в игре 3.3.5a</li>
<li>Создание дампа персонажа в игре 4.3.4</li>
<li>Создание заявки на перенос</li>
<li><a href="<?php echo $this->createUrl('/site/page/', array('view' => 'tconfigs')) ?>">Конфигурации переноса</a></li>
</ul>