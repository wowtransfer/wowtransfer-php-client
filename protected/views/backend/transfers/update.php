<?php
/* @var $this TransfersController */
/* @var $model ChdTransfer */

$this->breadcrumbs=array(
	'Заявки на перенос'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Изменить',
);

$this->menu=array(
	array('label'=>'Список заявок', 'url'=>array('index'), 'icon' => 'list'),
	array('label'=>'Просмотр заявки', 'url'=>array('view', 'id'=>$model->id), 'icon' => 'eye-open'),
	array('label'=>'Управление заявками', 'url'=>array('admin'), 'icon' => ''),
);
?>

<h1>Update ChdTransfer <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>