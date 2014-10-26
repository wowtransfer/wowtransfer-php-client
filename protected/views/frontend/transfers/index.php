<?php
/* @var $this TransfersController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Заявки на перенос',
);

$this->menu = array(
	array('label' => 'Создать заявку', 'url'=>array('create'), 'icon' => 'plus'),
);
?>

<h1>Заявки на перенос</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
