<?php
/* @var $this TransfersController */
/* @var $model ChdTransfer */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'chd-transfer-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'create_transfer_date'); ?>
		<?php echo $form->textField($model,'create_transfer_date'); ?>
		<?php echo $form->error($model,'create_transfer_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'server'); ?>
		<?php echo $form->textField($model,'server',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'server'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'realmlist'); ?>
		<?php echo $form->textField($model,'realmlist',array('size'=>40,'maxlength'=>40)); ?>
		<?php echo $form->error($model,'realmlist'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'realm'); ?>
		<?php echo $form->textField($model,'realm',array('size'=>40,'maxlength'=>40)); ?>
		<?php echo $form->error($model,'realm'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'username_old'); ?>
		<?php echo $form->textField($model,'username_old',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'username_old'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'username_new'); ?>
		<?php echo $form->textField($model,'username_new',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'username_new'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'account'); ?>
		<?php echo $form->textField($model,'account',array('size'=>40,'maxlength'=>40)); ?>
		<?php echo $form->error($model,'account'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'pass'); ?>
		<?php echo $form->passwordField($model,'pass',array('size'=>40,'maxlength'=>40)); ?>
		<?php echo $form->error($model,'pass'); ?>
	</div>

		<div class="row">
		<?php echo $form->labelEx($model,'file_lua'); ?>
		<?php echo $form->textField($model,'file_lua'); ?>
		<?php echo $form->error($model,'file_lua'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'options'); ?>
		<?php echo $form->textField($model,'options',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'options'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'comment'); ?>
		<?php echo $form->textField($model,'comment',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'comment'); ?>
	</div>
	
	<hr>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->textField($model,'status'); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'char_guid'); ?>
		<?php echo $form->textField($model,'char_guid',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'char_guid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'create_char_date'); ?>
		<?php echo $form->textField($model,'create_char_date'); ?>
		<?php echo $form->error($model,'create_char_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'file_lua_crypt'); ?>
		<?php echo $form->textField($model,'file_lua_crypt'); ?>
		<?php echo $form->error($model,'file_lua_crypt'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->