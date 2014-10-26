<?php
/* @var $this TransfersController */
/* @var $model ChdTransfer */

$this->breadcrumbs = array(
	'Заявки на перенос'=>array('index'),
	'Создание',
);

$this->menu = array(
	array('label'=>'Список заявок', 'url'=>array('index'), 'icon' => 'list'),
);
?>

<h1>Создание заявки</h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>