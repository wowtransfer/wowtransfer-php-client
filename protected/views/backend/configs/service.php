<?php
/* @var $this ConfigsController */
/* @var $model ServiceConfigForm */

$this->breadcrumbs = array(
	'Настройка' => array('/configs'),
	'Приложение',
);

?>

<h1>Настройка связи с сервисом</h1>

<div class="alert alert-warning">
	Настройки связи с сервисом хранятся в файле <code>/protected/config/service-local.php</code>.
	В случае сбоя его можно изменить вручную либо загрузить значения по-умолчанию.
</div>

<? if (Yii::app()->user->hasFlash('success')): ?>
	<div class="alert alert-success"><?= Yii::app()->user->getFlash('success'); ?></div>
<? endif; ?>

<? $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
	'enableClientValidation' => true,
	'htmlOptions' => array(
		'id' => 'config-service-form',
	),
)); ?>

<fieldset>
	<legend>Сервис</legend>
	<?php echo $form->textFieldControlGroup($model, 'serviceUsername', array(
		'maxlength' => 32,
	)); ?>
	<?php echo $form->textFieldControlGroup($model, 'accessToken', array(
		'maxlength' => 32,
	)); ?>

	<?php if (YII_DEBUG): ?>
		<?php echo $form->textFieldControlGroup($model, 'apiBaseUrl'); ?>
	<?php endif ?>
</fieldset>

<div class="form-group">
	<div class="col-sm-3"></div>
	<div class="col-sm-9">
		<button type="submit" class="btn btn-primary">
			Save
		</button>
		<a href="<?php echo $this->createUrl('/configs') ?>" class="btn btn-default">
			<span class="glyphicon glyphicon-ban-circle"></span> Cancel
		</a>
		<a class="btn btn-default" href="?default=1"
		   onclick="return confirm('Вы уверены?');"
		   >
			Default
		</a>
	</div>
</div>

<? $this->endWidget(); ?>
<? unset($form); ?>
