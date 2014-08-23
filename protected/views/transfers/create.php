<?php
/* @var $this TransfersController */
/* @var $model ChdTransfer */

$this->breadcrumbs=array(
	'Заявки на перенос'=>array('index'),
	'Создать',
);

$this->menu=array(
	array('label'=>'Список заявок', 'url'=>array('index')),
);
?>

<h1>Создание заявки на перенос</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>