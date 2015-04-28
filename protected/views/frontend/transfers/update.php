<?php
/* @var $this TransfersController */
/* @var $model ChdTransfer */
/* @var $wowServers array */

$this->breadcrumbs = array(
	'Заявки на перенос'=>array('index'),
	' ' . $model->id => array('view', 'id'=>$model->id), // TODO: hack
	'Изменение',
);

$this->menu = array(
	array('label'=>'Список заявок', 'url'=>array('index'), 'icon' => 'list'),
	array('label'=>'Создать заявку', 'url'=>array('create'), 'icon' => 'plus'),
	array('label'=>'Просмотр заявки', 'url'=>array('view', 'id'=>$model->id), 'icon' => 'eye-open'),
);
?>

<h1>Изменить заявку #<?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array(
	'model' => $model,
	'wowServers' => $wowServers,
)); ?>