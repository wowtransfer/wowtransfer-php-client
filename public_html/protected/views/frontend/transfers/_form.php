<?php

/* @var $this TransfersController */
/* @var $model ChdTransfer */
/* @var array $wowserversSites */

?>

<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', [
	'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
	'enableAjaxValidation' => false,
	'enableClientValidation' => false,
	'htmlOptions' => [
		'enctype' => 'multipart/form-data',
		'id' => 'chd-transfer-form',
	],
]); ?>

	<?= $form->errorSummary($model); ?>

	<?php if ($model->isNewRecord): ?>
		<fieldset>
			<legend><?= Yii::t('app', 'Select Lua dump') ?></legend>
			<?= $form->fileFieldControlGroup($model, 'fileLua', [
                'help' => ' ', 'data-url' => $this->createUrl('transfers/getCommonFields')]);
            ?>
		</fieldset>
	<?php endif; ?>

	<fieldset>
		<legend><?= Yii::t('app', 'Remote server') ?></legend>

		<?php if (Config::getInstance()->getOnlyCheckedServers()): ?>

			<?= $form->dropDownListControlGroup($model, 'server', $wowserversPair, [
				'class' => 'col-sm-4', 'list' => 'servers-list',
			]); ?>

		<?php else: ?>

			<?= $form->textFieldControlGroup($model, 'server', [
				'class' => 'col-sm-4', 'list' => 'servers-list',
			]); ?>

			<datalist id="servers-list">
			<?php if ($wowserversSites): ?>
				<?php foreach ($wowserversSites as $server): ?>
					<option value="<?= $server ?>">
				<?php endforeach; ?>
			<?php endif ?>
			</datalist>

		<?php endif ?>

		<?= $form->textFieldControlGroup($model, 'realmlist', [
			'class' => 'col-sm-4',
            'help' => Yii::t('app', 'If this field are not reads from dump, then fill it')
		]); ?>

		<?php /*echo CHtml::dropDownList('wowserver-realm', null, [], [
			'onchange' => '$("#ChdTransfer_realm").val(this.value);',
			'class' => 'pull-right',
			'style' => 'width: 180px;',
		]); */ ?>
		<?= $form->textFieldControlGroup($model, 'realm', [
			'class' => 'col-sm-4',
            'help' => Yii::t('app', 'If this field are not reads from dump, then fill it')
		]); ?>

		<?= $form->textFieldControlGroup($model, 'account', [
			'class' => 'col-sm-4'
		]); ?>
		<?= $form->passwordFieldControlGroup($model, 'pass', [
			'class' => 'col-sm-4'
		]); ?>
		<?= $form->passwordFieldControlGroup($model, 'pass2', [
			'class' => 'col-sm-4'
		]); ?>
		<?= $form->textFieldControlGroup($model, 'username_old', [
			'class' => 'col-sm-4',
            'help' => Yii::t('app', 'If this field are not reads from dump, then fill it')
		]); ?>
		<?= $form->textAreaControlGroup($model, 'comment', [
			'rows' => 4, 'class' => 'col-sm-12',
		]); ?>
	</fieldset>

	<fieldset>
		<legend><?= Yii::t('app', 'Transfer options') ?></legend>
		<?= $form->error($model, 'transferOptions'); ?>

		<?php $this->widget('application.components.widgets.TransferOptionsWidget', [
			'model' => $model,
			'form' => $form,
			'options' => TransferOptions::getOptionsPair(),
			'readonly' => false,
		]); ?>
	</fieldset>

	<div class="form-actions">

		<button type="submit" class="btn btn-primary">
			<?= Yii::t('app', $model->isNewRecord ? 'Create' : 'Update') ?>
		</button>

		<a href="<?= $this->createUrl('/transfers'); ?>" class="btn btn-default">
			<span class="glyphicon glyphicon-ban-circle"></span>
			<?= Yii::t('app', 'Cancel') ?>
		</a>

	</div>

<?php

$this->endWidget();
unset($form);
?>
