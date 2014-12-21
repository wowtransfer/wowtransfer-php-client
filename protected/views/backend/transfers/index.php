<?php
/* @var $this TransfersController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
	'Заявки на перенос',
);
?>

<h1>Заявки на перенос</h1>

<?php if (Yii::app()->user->hasFlash('success')): ?>
	<div class="alert alert-success"><?php echo Yii::app()->user->getFlash('success'); ?></div>
<?php endif; ?>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider' => $dataProvider,
	'itemView' => '_view',
)); ?>

<script><!--

window.statuses = [];
<?php foreach (ChdTransfer::getStatuses() as $name => $title): ?>
	window.statuses["<?php echo $name; ?>"] = "<?php echo $title; ?>";
<?php endforeach; ?>

--></script>