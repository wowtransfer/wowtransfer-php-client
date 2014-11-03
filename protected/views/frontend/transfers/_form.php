<?php
/* @var $this TransfersController */
/* @var $model ChdTransfer */
?>

<?php $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
	'id' => 'chd-transfer-form',
	'type' => 'horizontal',
	'enableAjaxValidation' => false,
	'enableClientValidation' => true,
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
		<?php echo $form->textFieldGroup($model, 'server', array(
			'hint' => 'Вводить без протокола (http://), например, myserver.ru или twoserver.com',
			'wrapperHtmlOptions' => array('class' => 'col-sm-4'),
		)); ?>

		<?php echo $form->textFieldGroup($model, 'realmlist', array(
			'wrapperHtmlOptions' => array('class' => 'col-sm-4'),
		)); ?>
		<?php echo $form->textFieldGroup($model, 'realm', array(
			'wrapperHtmlOptions' => array('class' => 'col-sm-4'),
		)); ?>
		<?php echo $form->textFieldGroup($model, 'account', array(
			'wrapperHtmlOptions' => array('class' => 'col-sm-4'),
		)); ?>
		<?php echo $form->passwordFieldGroup($model, 'pass', array(
			'wrapperHtmlOptions' => array('class' => 'col-sm-4'),
		)); ?>
		<?php echo $form->passwordFieldGroup($model, 'pass2', array(
			'wrapperHtmlOptions' => array('class' => 'col-sm-4'),
		)); ?>
		<?php echo $form->textFieldGroup($model, 'username_old', array(
			'wrapperHtmlOptions' => array('class' => 'col-sm-4'),
		)); ?>
		<?php echo $form->textFieldGroup($model, 'comment'); ?>
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