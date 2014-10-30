<?php
/* @var $this TransfersController */
/* @var $model ChdTransfer */
/* @var $form CActiveForm */
?>

<?php $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
	'id' => 'chd-transfer-form',
	'type' => 'horizontal',
	'enableAjaxValidation' => false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<fieldset>
		<legend>Заявка</legend>
		<?php echo $form->textFieldGroup($model, 'create_transfer_date', array('widgetOptions' => array('htmlOptions' => array('disabled' => true)))); ?>
		<?php echo $form->textFieldGroup($model, 'status'); ?>
		<?php echo $form->textFieldGroup($model, 'file_lua_crypt', array('widgetOptions' => array('htmlOptions' => array('disabled' => true)))); ?>
		<?php echo $form->textFieldGroup($model, 'file_lua', array('widgetOptions' => array('htmlOptions' => array('disabled' => true)))); ?>
		<?php echo $form->textFieldGroup($model, 'comment'); ?>
	</fieldset>

	<fieldset>
		<legend>Удаленный сервер</legend>
		<?php echo $form->textFieldGroup($model, 'account_id', array('widgetOptions' => array('htmlOptions' => array('disabled' => true)))); ?>
		<?php echo $form->textFieldGroup($model, 'server', array('widgetOptions' => array('htmlOptions' => array('disabled' => true)))); ?>
		<?php echo $form->textFieldGroup($model, 'realmlist', array('widgetOptions' => array('htmlOptions' => array('disabled' => true)))); ?>
		<?php echo $form->textFieldGroup($model, 'realm', array('widgetOptions' => array('htmlOptions' => array('disabled' => true)))); ?>
		<?php echo $form->textFieldGroup($model, 'account', array('widgetOptions' => array('htmlOptions' => array('disabled' => true)))); ?>
		<?php echo $form->textFieldGroup($model, 'pass', array('widgetOptions' => array('htmlOptions' => array('disabled' => true)))); ?>
		<?php echo $form->textFieldGroup($model, 'username_old', array('widgetOptions' => array('htmlOptions' => array('disabled' => true)))); ?>
	</fieldset>

	<fieldset>
		<legend>Персонаж</legend>
		<?php echo $form->textFieldGroup($model, 'username_new'); ?>
		<?php echo $form->textFieldGroup($model, 'char_guid', array('widgetOptions' => array('htmlOptions' => array('disabled' => true)))); ?>
		<?php echo $form->textFieldGroup($model, 'create_char_date', array('widgetOptions' => array('htmlOptions' => array('disabled' => true)))); ?>
	</fieldset>

	<fieldset>
		<legend>Опции переноса</legend>
		<?php $this->widget('application.components.widgets.TransferOptionsWidget', array(
			'model' => $model,
			'options' => $model->getTransferOptionsToUser()
		));	?>
	</fieldset>

	<div class="form-actions">
		<?php $this->widget('booster.widgets.TbButton', array(
			'context' => 'primary',
			'label' => $model->isNewRecord ? 'Create' : 'Save',
		)); ?>
		<?php $this->widget('booster.widgets.TbButton', array(
			'buttonType' => 'link',
			'label' => 'Отмена',
			'icon' => 'ban-circle',
			'url' => $this->createUrl('/transfers'),
		));	?>
	</div>

<?php $this->endWidget(); ?>
<?php unset($form); ?>