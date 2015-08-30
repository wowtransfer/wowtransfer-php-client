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

<div id="transfers-listview-block">
	<?php $this->renderPartial('_index_data', array('dataProvider' => $dataProvider)) ?>
</div>

<script><!--

window.statuses = [];
<?php foreach (ChdTransfer::getStatuses() as $name => $title): ?>
	window.statuses["<?php echo $name; ?>"] = "<?php echo $title; ?>";
<?php endforeach; ?>

--></script>

<div class="hidden" id="confirm-delete-character"><?= Yii::t('app', 'Confirm delete the character') ?></div>
<div class="hidden" id="delete-character"><?= Yii::t('app', 'Delete the character') ?></div>
<div class="hidden" id="character-deleted"><?= Yii::t('app', 'Character has deleted') ?></div>
<div class="hidden" id="t-success-changed"><?= Yii::t('app', 'Success changed') ?></div>
