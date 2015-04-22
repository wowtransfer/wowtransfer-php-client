<?php
/* @var $this ConfigsController */
/* @var $model AppConfigForm */
/* @var $cores array */

$this->breadcrumbs = array(
	'Настройка' => array('/configs'),
	'Приложение',
);

?>
<h1>Настройка приложения</h1>

<div class="alert alert-warning">
Настройки приложения хранятся в файле <code>/protected/config/app.php</code>. В случае сбоя его можно изменить вручную.
</div>

<?php if (Yii::app()->user->hasFlash('success')): ?>
	<div class="flash-success"><?php echo Yii::app()->user->getFlash('success'); ?></div>
<?php endif; ?>

<?php $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
	'id' => 'config-app-form',
	'type' => 'horizontal',
	'enableClientValidation' => true,
	'clientOptions' => array(
		'validateOnSubmit' => true,
	),
)); ?>

<fieldset>
<legend>Сервер</legend>
<?php echo $form->textFieldGroup($model, 'siteUrl', array('wrapperHtmlOptions' => array('class' => 'col-sm-4'))); ?>
<?php echo $form->emailFieldGroup($model, 'emailAdmin', array('wrapperHtmlOptions' => array('class' => 'col-sm-4'))); ?>
<?php echo $form->dropDownListGroup($model, 'core', array('wrapperHtmlOptions' => array('class' => 'col-sm-4'),
	'widgetOptions' => array('data' => $cores))); ?>
<?php echo $form->numberFieldGroup($model, 'maxTransfersCount', array('wrapperHtmlOptions' => array('class' => 'col-sm-4'))); ?>
<?php echo $form->numberFieldGroup($model, 'maxAccountCharsCount', array('wrapperHtmlOptions' => array('class' => 'col-sm-4'))); ?>
<?php echo $form->textFieldGroup($model, 'adminsStr', array('hint' => 'Строка с именами администраторов, разделенных запятыми')); ?>
<?php echo $form->textFieldGroup($model, 'modersStr', array('hint' => 'Строка с именами модераторов, разделенных запятыми')); ?>
<?php echo $form->textFieldGroup($model, 'transferTable', array('wrapperHtmlOptions' => array('class' => 'col-sm-4'))); ?>
</fieldset>

<div class="form-group">
	<div class="col-sm-3"></div>
	<div class="col-sm-9">
	<?php $this->widget('booster.widgets.TbButton', array(
		'buttonType' => 'submit',
		'context' => 'primary',
		'label' => 'Save',
		'htmlOptions' => array(
			'name' => 'server',
			'disabled' => 'disabled',
		),
	)); ?>
	<?php $this->widget('booster.widgets.TbButton', array(
		'buttonType' => 'link',
		'url' => $this->createUrl('/configs'),
		'icon' => 'ban-circle',
		'label' => 'Cancel'
	)); ?>
	</div>
</div>

<fieldset>
<legend>Сервис</legend>
<?php echo $form->textFieldGroup($model, 'serviceUsername', array('wrapperHtmlOptions' => array('class' => 'col-sm-4'))); ?>
<?php if (YII_DEBUG): ?>
	<?php echo $form->textFieldGroup($model, 'apiBaseUrl'); ?>
<?php endif ?>
<?php echo $form->textFieldGroup($model, 'accessToken', array(
	'widgetOptions' => array(
		'htmlOptions' => array(
			'maxlength' => 32,
		)
	))
); ?>
</fieldset>

<div class="form-group">
	<div class="col-sm-3"></div>
	<div class="col-sm-9">
	<?php $this->widget('booster.widgets.TbButton', array(
		'buttonType' => 'submit',
		'context' => 'primary',
		'label' => 'Save',
		'htmlOptions' => array(
			'name' => 'service',
		),
	)); ?>
	<?php $this->widget('booster.widgets.TbButton', array(
		'buttonType' => 'link',
		'url' => $this->createUrl('/configs'),
		'icon' => 'ban-circle',
		'label' => 'Cancel'
	)); ?>
	</div>
</div>

<?php $this->endWidget(); ?>
<?php unset($form); ?>