<?php
/* @var $this TransfersController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = [
	Yii::t('app', 'Transfer requests')
];
?>

<h1><?= Yii::t('app', 'Transfer requests') ?></h1>

<?php if (Yii::app()->user->hasFlash('success')): ?>
	<div class="alert alert-success"><?php echo Yii::app()->user->getFlash('success'); ?></div>
<?php endif; ?>

<?php $this->renderPartial('_index_data', array('dataProvider' => $dataProvider)) ?>

<script><!--

window.statuses = [];
<?php foreach (ChdTransfer::getStatuses() as $name => $title): ?>
	window.statuses["<?php echo $name; ?>"] = "<?php echo $title; ?>";
<?php endforeach; ?>

--></script>