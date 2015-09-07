<?php
/* @var $this ConfigsController */

$this->breadcrumbs = [
	Yii::t('app', 'Settings') => ['/configs'],
	Yii::t('app', 'Transfer options')
];
?>

<h1 class="text-center"><?= Yii::t('app', 'Transfer options') ?></h1>

<? if (Yii::app()->user->hasFlash('success')): ?>
<div class="alert alert-success">
	<?= Yii::app()->user->getFlash('success') ?>
</div>
<? endif ?>

<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
	'htmlOptions' => array(
		'id' => 'toptions-form',
	),
)); ?>

<table class="table table-condensed table-hover">
	<col style="width: 40px;">
	<thead>
	<tr>
		<th></th>
		<th>Title</th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($options as $name => $option): ?>
	<tr class="toptions-row">
		<td><?php echo CHtml::checkBox('toptions[' . $name . '][disabled]', !isset($option['disabled']), ['id' => 'opt-' . $name]); ?></td>
		<td><label for="<?= 'opt-' . $name ?>"><?= $option['label']; ?></label></td>
	</tr>
	<?php endforeach; ?>
	</tbody>
</table>

<div class="form-actions">
	<button type="submit" class="btn btn-primary">
		<?= Yii::t('app', 'Save') ?>
	</button>
	<a href="<?php echo $this->createUrl('/configs'); ?>" class="btn btn-default">
		<span class="glyphicon glyphicon-ban-circle"></span>
		<?= Yii::t('app', 'Cancel') ?>
	</a>
</div>

<?php
$this->endWidget();
unset($form);
?>

<div class="alert alert-warning">
	<?= Yii::t('app', 'Settings saves in the file') ?> <code>/protected/config/toptions-local.php</code>.
</div>
