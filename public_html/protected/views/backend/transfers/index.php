<?php
/* @var $this TransfersController */
/* @var $dataProvider CActiveDataProvider */
/* @var $viewMode string */

$this->breadcrumbs = [
	Yii::t('app', 'Transfer requests')
];
?>

<div class="change-view-mode pull-right">
	<?php if ($viewMode === 'list'): ?>
		<span title="<?= Yii::t('app', 'List') ?>" class="selected">
			<span class="glyphicon glyphicon-th-large"></span>
		</span>
	<?php else: ?>
		<a href="<?= $this->createUrl('changeview', ['mode' => 'list']) ?>"
			title="<?= Yii::t('app', 'List') ?>">
			 <span class="glyphicon glyphicon-th-large"></span></a>
	<?php endif ?>

	<?php if ($viewMode === 'table'): ?>
		<span title="<?= Yii::t('app', 'Table') ?>" class="selected">
			<span class="glyphicon glyphicon-th-list"></span>
		</span>
	<?php else: ?>
		<a href="<?= $this->createUrl('changeview', ['mode' => 'table']) ?>"
			title="<?= Yii::t('app', 'Table') ?>">
			 <span class="glyphicon glyphicon-th-list"></span></a>
	<?php endif ?>
</div>

<h1><?= Yii::t('app', 'Transfer requests') ?></h1>

<?php if (Yii::app()->user->hasFlash('success')): ?>
	<div class="alert alert-success"><?= Yii::app()->user->getFlash('success'); ?></div>
<?php endif; ?>

<div id="transfers-listview-block">
	<?php $this->renderPartial('_index_data', [
		'dataProvider' => $dataProvider,
		'viewMode' => $viewMode,
	]) ?>
</div>

<script><!--

window.statuses = [];
<?php foreach (ChdTransfer::getStatusLabels() as $name => $title): ?>
	window.statuses["<?= $name; ?>"] = "<?= $title; ?>";
<?php endforeach; ?>

--></script>

<div class="hidden" id="t-confirm-delete-character"><?= Yii::t('app', 'Confirm delete the character') ?></div>
<div class="hidden" id="delete-character"><?= Yii::t('app', 'Delete the character') ?></div>
<div class="hidden" id="character-deleted"><?= Yii::t('app', 'Character has deleted') ?></div>
<div class="hidden" id="t-success-changed"><?= Yii::t('app', 'Success changed') ?></div>
