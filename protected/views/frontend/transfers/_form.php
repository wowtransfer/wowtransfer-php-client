<?
/* @var $this TransfersController */
/* @var $model ChdTransfer */
/* @var array $wowserversSites */

?>

<? $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
	'enableAjaxValidation' => false,
	'enableClientValidation' => false,
	'htmlOptions' => [
		'enctype' => 'multipart/form-data',
		'id' => 'chd-transfer-form',
	],
)); ?>

	<?= $form->errorSummary($model); ?>

	<? if ($model->isNewRecord): ?>
		<fieldset>
			<legend><?= Yii::t('app', 'Select Lua dump') ?></legend>
			<?= $form->fileFieldControlGroup($model, 'fileLua', ['help' => ' ']); ?>
		</fieldset>
	<? endif; ?>

	<fieldset>
		<legend><?= Yii::t('app', 'Remote server') ?></legend>

		<? if (Yii::app()->params['onlyCheckedServers']): ?>

			<?= $form->dropDownListControlGroup($model, 'server', $wowserversPair, [
				'class' => 'col-sm-4', 'list' => 'servers-list',
			]); ?>

		<? else: ?>

			<?= $form->textFieldControlGroup($model, 'server', [
				'class' => 'col-sm-4', 'list' => 'servers-list',
			]); ?>

			<datalist id="servers-list">
				<? foreach ($wowserversSites as $server): ?>
					<option value="<?= $server ?>">
				<? endforeach; ?>
			</datalist>

		<? endif ?>

		<?= $form->textFieldControlGroup($model, 'realmlist', array(
			'class' => 'col-sm-4', 'readonly' => 1,
		)); ?>

		<? /*echo CHtml::dropDownList('wowserver-realm', null, array(), array(
			'onchange' => '$("#ChdTransfer_realm").val(this.value);',
			'class' => 'pull-right',
			'style' => 'width: 180px;',
		)); */ ?>
		<?= $form->textFieldControlGroup($model, 'realm', array(
			'class' => 'col-sm-4', 'readonly' => 1,
		)); ?>

		<?= $form->textFieldControlGroup($model, 'account', array(
			'class' => 'col-sm-4'
		)); ?>
		<?= $form->passwordFieldControlGroup($model, 'pass', array(
			'class' => 'col-sm-4'
		)); ?>
		<?= $form->passwordFieldControlGroup($model, 'pass2', array(
			'class' => 'col-sm-4'
		)); ?>
		<?= $form->textFieldControlGroup($model, 'username_old', array(
			'class' => 'col-sm-4', 'readonly' => 1,
		)); ?>
		<?= $form->textAreaControlGroup($model, 'comment', array(
			'span' => 8, 'rows' => 4, 'class' => 'col-sm-12',
		)); ?>
	</fieldset>

	<fieldset>
		<legend><?= Yii::t('app', 'Transfer options') ?></legend>
		<?= $form->error($model, 'transferOptions'); ?>

		<? $this->widget('application.components.widgets.TransferOptionsWidget', array(
				'model' => $model,
				'form' => $form,
				'options' => $model->getTransferOptionsToUser(),
				'readonly' => false,
			));
		?>
	</fieldset>

	<div class="form-actions">
		
		<button type="submit" class="btn btn-primary">
			<?= $model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'); ?>
		</button>
		
		<a href="<?= $this->createUrl('/transfers'); ?>" class="btn btn-default">
			<span class="glyphicon glyphicon-ban-circle"></span>
			<?= Yii::t('app', 'Cancel') ?>
		</a>

	</div>

<?
$this->endWidget();
unset($form);
?>
