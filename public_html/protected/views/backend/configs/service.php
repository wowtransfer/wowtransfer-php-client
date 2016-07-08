<?php

/* @var $this ConfigsController */
/* @var $model ServiceConfigForm */

$this->breadcrumbs = [
	Yii::t('app', 'Settings') => array('/configs'),
	Yii::t('app', 'Service')
];

?>

<h1><?= Yii::t('app', 'Service connection') ?></h1>

<?php if (Yii::app()->user->hasFlash('success')): ?>
	<div class="alert alert-success"><?= Yii::app()->user->getFlash('success'); ?></div>
<?php endif; ?>

<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
	'enableClientValidation' => true,
	'htmlOptions' => array(
		'id' => 'config-service-form',
	),
)); ?>

<fieldset>
	<legend><?= Yii::t('app', 'Service') ?></legend>
	<?= $form->textFieldControlGroup($model, 'serviceUsername', array(
		'maxlength' => 32,
	)); ?>
	<?= $form->textFieldControlGroup($model, 'accessToken', array(
		'maxlength' => 32,
	)); ?>

	<?php if (YII_DEBUG): ?>
		<?= $form->textFieldControlGroup($model, 'apiBaseUrl'); ?>
	<?php endif ?>
</fieldset>

<div class="form-group">
	<div class="col-sm-3"></div>
	<div class="col-sm-9">
		<button type="submit" class="btn btn-primary">
			<?= Yii::t('app', 'Save') ?>
		</button>
		<a href="<?= $this->createUrl('/configs') ?>" class="btn btn-default">
			<span class="glyphicon glyphicon-ban-circle"></span>
			<?= Yii::t('app', 'Cancel') ?>
		</a>
		<a class="btn btn-default" href="?default=1"
		   onclick="return confirm('<?= Yii::t('app', 'Are you sure?') ?>');"
		   >
			<?= Yii::t('app', 'Default') ?>
		</a>
        <a class="btn btn-default" href="<?= $this->createUrl('/configs/service', ['checkServiceConnection' => 1]) ?>" id="check-service-connection">
			<?= Yii::t('app', 'Check connection') ?>
		</a>
	</div>
</div>

<?php $this->endWidget(); ?>
<?php unset($form); ?>

<div class="alert alert-warning">
	<?= Yii::t('app', 'Settings saves in the file') ?> <code>/protected/config/service-local.php</code>.
</div>
