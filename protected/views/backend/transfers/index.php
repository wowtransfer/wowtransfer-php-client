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

<h1>Заявки на перенос.</h1>

<?php if (Yii::app()->user->hasFlash('success')): ?>
	<div class="flash-success"><?php echo Yii::app()->user->getFlash('success'); ?></div>
<?php endif; ?>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
