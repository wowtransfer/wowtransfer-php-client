<?php
/* @var $this TransfersController */
/* @var $model ChdTransfer */

$this->breadcrumbs=array(
	'Заявки на перенос'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Изменить',
);

$this->menu=array(
	array('label'=>'Список заявок', 'url'=>array('index')),
	array('label'=>'Создать заявку', 'url'=>array('create')),
	array('label'=>'Просмотр заявки', 'url'=>array('view', 'id'=>$model->id)),
);
?>

<h1>Изменить заявку #<?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>