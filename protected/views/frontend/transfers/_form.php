<?php
/* @var $this TransfersController */
/* @var $model ChdTransfer */

?>

<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
	'enableAjaxValidation' => false,
	'enableClientValidation' => false,
	'htmlOptions' => array(
		'enctype' => 'multipart/form-data',
		'id' => 'chd-transfer-form',
	),
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<?php if ($model->isNewRecord): ?>
		<fieldset>
			<legend>Выбор lua-дампа</legend>
			<?php echo $form->fileFieldControlGroup($model, 'fileLua', ['help' => ' ']); ?>
		</fieldset>
	<?php endif; ?>

	<fieldset>
		<legend>Удаленный сервер</legend>

		<?php echo $form->textFieldControlGroup($model, 'server', array(
			'help' => 'Вводить без протокола (http://), например, myserver.ru или twoserver.com',
			'class' => 'col-sm-4',
		)); ?>

		<?php echo $form->textFieldControlGroup($model, 'realmlist', array(
			'class' => 'col-sm-4', 'readonly' => 1,
		)); ?>

		<?php /*echo CHtml::dropDownList('wowserver-realm', null, array(), array(
			'onchange' => '$("#ChdTransfer_realm").val(this.value);',
			'class' => 'pull-right',
			'style' => 'width: 180px;',
		)); */ ?>
		<?php echo $form->textFieldControlGroup($model, 'realm', array(
			'class' => 'col-sm-4', 'readonly' => 1,
		)); ?>

		<?php echo $form->textFieldControlGroup($model, 'account', array(
			'class' => 'col-sm-4'
		)); ?>
		<?php echo $form->passwordFieldControlGroup($model, 'pass', array(
			'class' => 'col-sm-4'
		)); ?>
		<?php echo $form->passwordFieldControlGroup($model, 'pass2', array(
			'class' => 'col-sm-4'
		)); ?>
		<?php echo $form->textFieldControlGroup($model, 'username_old', array(
			'class' => 'col-sm-4', 'readonly' => 1,
		)); ?>
		<?php echo $form->textAreaControlGroup($model, 'comment', array(
			'span' => 8, 'rows' => 4, 'class' => 'col-sm-12',
		)); ?>
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
		
		<button type="submit" class="btn btn-primary">
			<?php echo $model->isNewRecord ? 'Создать' : 'Сохранить'; ?>
		</button>
		
		<a href="<?php echo $this->createUrl('/transfers'); ?>" class="btn btn-default">
			<span class="glyphicon glyphicon-ban-circle"></span>
			Отмена
		</a>

	</div>

<?php
$this->endWidget();
unset($form);
?>
