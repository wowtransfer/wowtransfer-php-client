<?php
/* @var $this ConfigsController */

$this->breadcrumbs = array(
	'Настройка' => array('/configs'),
	'Приложение',
);
?>
<h1>Настройка приложения</h1>

<?php if (Yii::app()->user->hasFlash('success')): ?>
	<div class="flash-success"><?php echo Yii::app()->user->getFlash('success'); ?></div>
<?php endif; ?>

<?php $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
	'id' => 'config-app-form',
	'enableClientValidation' => true,
	'clientOptions' => array(
		'validateOnSubmit' => true,
	),
)); ?>

<?php echo $form->textFieldGroup($model, 'siteUrl'); ?>
<?php echo $form->emailFieldGroup($model, 'emailAdmin'); ?>
<?php echo $form->dropDownListGroup($model, 'core'); ?>
<?php echo $form->numberFieldGroup($model, 'maxTransfersCount'); ?>
<?php echo $form->numberFieldGroup($model, 'maxAccountCharCount'); ?>
<?php echo $form->textFieldGroup($model, 'apiBaseUrl'); ?>
<?php echo $form->textFieldGroup($model, 'adminsStr'); ?>
<?php echo $form->textFieldGroup($model, 'moderatorsStr'); ?>


<div class="form-actions">
	<?php $this->widget('booster.widgets.TbButton', array(
		'buttonType' => 'submit',
		'context' => 'primary',
		'label' => 'Submit'
	)); ?>
</div>

<?php $this->endWidget(); ?>
<?php unset($form); ?>