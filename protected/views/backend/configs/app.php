<?php
/* @var $this ConfigsController */

$this->breadcrumbs = array(
	'Настройка' => array('/configs'),
	'Приложение',
);
?>
<h1>Настройка приложения</h1>

<p><a href="<?php echo $this->createUrl('/configs/toptions'); ?>">Опции переноса</a></p>

<?php if (Yii::app()->user->hasFlash('success')): ?>
	<div class="flash-success"><?php echo Yii::app()->user->getFlash('success'); ?></div>
<?php endif; ?>

<div class="form">
<?php
$form = $this->beginWidget('CActiveForm', array(
	'id'=>'config-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
));
?>

<div class="row">
	<?php echo $form->labelEx($model, 'siteUrl'); ?>
	<?php echo $form->textField($model, 'siteUrl', array('size' => 40)); ?>
	<?php echo $form->error($model, 'siteUrl'); ?>
</div>

<div class="row">
	<?php echo $form->labelEx($model, 'emailAdmin'); ?>
	<?php echo $form->emailField($model, 'emailAdmin', array('size' => 40)); ?>
	<?php echo $form->error($model, 'emailAdmin'); ?>
</div>

<div class="row">
	<?php echo $form->labelEx($model, 'core'); ?>
	<?php echo $form->dropDownList($model, 'core', $model->getCores()); ?>
	<?php echo $form->error($model, 'core'); ?>
</div>

<div class="row">
	<?php echo $form->labelEx($model, 'maxTransfersCount'); ?>
	<?php echo $form->numberField($model, 'maxTransfersCount'); ?>
	<?php echo $form->error($model, 'maxTransfersCount'); ?>
</div>

<div class="row">
	<?php echo $form->labelEx($model, 'maxAccountCharCount'); ?>
	<?php echo $form->numberField($model, 'maxAccountCharCount'); ?>
	<?php echo $form->error($model, 'maxAccountCharCount'); ?>
</div>

<div class="row">
	<?php echo $form->labelEx($model, 'apiBaseUrl'); ?>
	<?php echo $form->textField($model, 'apiBaseUrl', array('size' => 40)) ?>
	<?php echo $form->error($model, 'apiBaseUrl') ?>
</div>

<div class="row">
	<?php echo $form->labelEx($model, 'adminsStr'); ?>
	<?php echo $form->textField($model, 'adminsStr', array('size' => 40)); ?>
	<?php echo $form->error($model, 'adminsStr') ?>
</div>

<div class="row">
	<?php echo $form->labelEx($model, 'moderatorsStr'); ?>
	<?php echo $form->textField($model, 'moderatorsStr', array('size' => 40)); ?>
	<?php echo $form->error($model, 'moderatorsStr') ?>
</div>

<div>
	<?php echo CHtml::submitButton('Изменить'); ?>
</div>

<?php $this->endWidget(); ?>
</div>