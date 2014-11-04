<?php
/* @var $this ConfigsController */

$this->breadcrumbs = array(
	'Настройка' => array('/configs'),
	'Приложение',
);

$cores = $model->getCores();
?>
<h1>Настройка приложения</h1>

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

<?php echo $form->textFieldGroup($model, 'siteUrl', array('wrapperHtmlOptions' => array('class' => 'col-sm-4'))); ?>
<?php echo $form->emailFieldGroup($model, 'emailAdmin', array('wrapperHtmlOptions' => array('class' => 'col-sm-4'))); ?>
<?php echo $form->dropDownListGroup($model, 'core', array('wrapperHtmlOptions' => array('class' => 'col-sm-4'),
	'widgetOptions' => array('data' => $cores))); ?>
<?php echo $form->numberFieldGroup($model, 'maxTransfersCount', array('wrapperHtmlOptions' => array('class' => 'col-sm-4'))); ?>
<?php echo $form->numberFieldGroup($model, 'maxAccountCharCount', array('wrapperHtmlOptions' => array('class' => 'col-sm-4'))); ?>
<?php echo $form->textFieldGroup($model, 'apiBaseUrl', array('wrapperHtmlOptions' => array('class' => 'col-sm-4'))); ?>
<?php echo $form->textFieldGroup($model, 'adminsStr', array('hint' => 'Строка с именами администраторов, разделенных запятыми')); ?>
<?php echo $form->textFieldGroup($model, 'moderatorsStr', array('hint' => 'Строка с именами модераторов, разделенных запятыми')); ?>


<div class="form-actions">
	<?php $this->widget('booster.widgets.TbButton', array(
		'buttonType' => 'submit',
		'context' => 'primary',
		'label' => 'Save'
	)); ?>
	<?php $this->widget('booster.widgets.TbButton', array(
		'buttonType' => 'link',
		'url' => $this->createUrl('/configs'),
		'icon' => 'ban-circle',
		'label' => 'Cancel'
	)); ?>
</div>

<?php $this->endWidget(); ?>
<?php unset($form); ?>