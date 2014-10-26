<?php
/* @var $this TransfersController */
/* @var $model ChdTransfer */
?>

<?php $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
	'id'=>'chd-transfer-form',
	'type'=>'horizontal',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	'enableClientValidation'=>true,
	'clientOptions' => array(
		'validateOnSubmit' => true,
	),
	'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<?php if ($model->isNewRecord): ?>
		<fieldset>
			<legend>Выбор lua-дампа</legend>
			<?php echo $form->fileFieldGroup($model, 'fileLua'); ?>
		</fieldset>
	<?php endif; ?>

	<fieldset>
		<legend>Удаленный сервер</legend>
		<?php echo $form->textFieldGroup($model, 'server'); // array('size'=>30,'maxlength'=>100) ?>
		<?php echo $form->textFieldGroup($model, 'realmlist'); // array('size'=>30,'maxlength'=>40) ?>
		<?php echo $form->textFieldGroup($model, 'realm'); // array('size'=>30,'maxlength'=>40) ?>
		<?php echo $form->textFieldGroup($model, 'account'); // array('size'=>30,'maxlength'=>32) ?>
		<?php echo $form->passwordFieldGroup($model, 'pass'); // array('size'=>30,'maxlength'=>40) ?>
		<?php echo $form->passwordFieldGroup($model, 'pass2'); // array('size'=>30,'maxlength'=>40) ?>
		<?php echo $form->textFieldGroup($model, 'username_old'); // array('size'=>30,'maxlength'=>12) ?>
		<?php echo $form->textFieldGroup($model, 'comment'); // array('size'=>60,'maxlength'=>255) ?>
	</fieldset>

	<fieldset>
		<legend>Опции переноса</legend>
		<?php echo $form->error($model, 'transferOptions'); ?>

		<?php $this->widget('application.components.widgets.TransferOptionsWidget', array(
				'model' => $model,
				'form' => $form,
				'options' => $model->getTransferOptionsToUser(),
				'readonly' => false,
			));
		?>
	</fieldset>

	<div class="form-actions">
		<?php $this->widget('booster.widgets.TbButton', array(
			'buttonType' => 'submit',
			'context' => 'primary',
			'label' => $model->isNewRecord ? 'Создать' : 'Сохранить',
		)); ?>
		<?php $this->widget('booster.widgets.TbButton', array(
			'buttonType' => 'link',
			'label' => 'Отмена',
			'url' => $this->createUrl('/transfers'),
			'icon' => 'ban-circle',
		)); ?>
	</div>

<?php
$this->endWidget();
unset($form);
?>