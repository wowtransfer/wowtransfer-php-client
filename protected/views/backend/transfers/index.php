<?php
/* @var $this TransfersController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Заявки на перенос',
);

$this->menu=array(
	array('label'=>'Управление заявками', 'url'=>array('admin')),
);
?>

<h1>Заявки на перенос. Администрирование.</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
