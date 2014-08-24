<?php
/* @var $this TransfersController */
/* @var $model ChdTransfer */

$this->breadcrumbs=array(
	'Заявки на перенос'=>array('index'),
	'Создать',
);
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'chd-transfer-form',
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

	<fieldset>
	<legend>Удаленный сервер</legend>

	<div class="row">
		<?php echo $form->labelEx($model,'server'); ?>
		<?php echo $form->textField($model,'server',array('size'=>30,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'server'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'realmlist'); ?>
		<?php echo $form->textField($model,'realmlist',array('size'=>30,'maxlength'=>40)); ?>
		<?php echo $form->error($model,'realmlist'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'realm'); ?>
		<?php echo $form->textField($model,'realm',array('size'=>30,'maxlength'=>40)); ?>
		<?php echo $form->error($model,'realm'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'account'); ?>
		<?php echo $form->textField($model,'account',array('size'=>30,'maxlength'=>32)); ?>
		<?php echo $form->error($model,'account'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'pass'); ?>
		<?php echo $form->passwordField($model,'pass',array('size'=>30,'maxlength'=>40)); ?>
		<?php echo $form->error($model,'pass'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'username_old'); ?>
		<?php echo $form->textField($model,'username_old',array('size'=>30,'maxlength'=>12)); ?>
		<?php echo $form->error($model,'username_old'); ?>
	</div>

	</fieldset>

	<?php if ($model->isNewRecord): ?>
	<div class="row">
		<?php echo $form->labelEx($model,'fileLua'); ?>
		<?php echo $form->fileField($model,'fileLua'); ?>
		<?php echo $form->error($model,'fileLua'); ?>
	</div>
	<?php endif; ?>

	<fieldset>
		<legend><?php echo $form->labelEx($model,'transferOptions'); ?></legend>

		<div class="row">
			<div>
				<?php echo $form->error($model,'transferOptions'); ?>
			</div>
			<?php echo $form->checkBoxList($model, 'transferOptions', $model->getTransferOptionsToUser(),
				array('checkAll' => 'Выбрать все', 'checkAllLast' => true, 'template' => '<span class="toptions">{input} {label}</span>', 'separator' => '', 'class' => 'inline-chb')); ?>
		</div>
	</fieldset>

	<div class="row">
		<?php echo $form->labelEx($model,'comment'); ?>
		<?php echo $form->textField($model,'comment',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'comment'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
		<?php echo CHtml::link('Отмена', $this->createUrl('index')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->