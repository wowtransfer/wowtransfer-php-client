<?php
/* @var $this ConfigsController */
/* @var $model AppConfigForm */
/* @var $cores array */

$this->breadcrumbs = [
	'Настройка' => ['/configs'],
	Yii::t('app', 'Application')
];

?>
<h1>Настройка приложения</h1>

<div class="alert alert-warning">
	Настройки приложения хранятся в файле <code>/protected/config/app-local.php</code>.
	В случае сбоя его можно изменить вручную либо загрузить значения по-умолчанию.
</div>

<? if (Yii::app()->user->hasFlash('success')): ?>
	<div class="alert alert-success"><?php echo Yii::app()->user->getFlash('success'); ?></div>
<? endif; ?>

<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
	'enableClientValidation' => true,
	'htmlOptions' => array(
		'id' => 'config-app-form',
	),
)); ?>

<fieldset>
	<legend>Сервер</legend>
<?php
	echo $form->textFieldControlGroup($model, 'siteUrl');
	echo $form->emailFieldControlGroup($model, 'emailAdmin');
	echo $form->dropDownListControlGroup($model, 'core', $cores);
	echo $form->numberFieldControlGroup($model, 'maxTransfersCount');
	echo $form->numberFieldControlGroup($model, 'maxAccountCharsCount');
	echo $form->textFieldControlGroup($model, 'adminsStr', array(
		'help' => 'Строка с именами администраторов, разделенных запятыми',
		'autocomplete' => 'off',
	));
	echo $form->textFieldControlGroup($model, 'modersStr', array(
		'help' => 'Строка с именами модераторов, разделенных запятыми',
		'autocomplete' => 'off',
	));
	echo $form->textFieldControlGroup($model, 'transferTable');
?>
</fieldset>

<fieldset>
	<legend><?= Yii::t('app', 'Application') ?></legend>

	<?= $form->checkboxControlGroup($model, 'yiiDebug', [
		'help' => '<div class="alert alert-danger">Выключать на боевом сервере!!!</div>'
	]) ?>
	<?= $form->dropDownListControlGroup($model, 'yiiTraceLevel', [0, 1, 2, 3, 4, 5], [
		'help' => '<div class="alert alert-info">0 - отключить. Работает только в Debug режиме.</div>',
	]) ?>

</fieldset>

<div class="form-group">
	<div class="col-sm-3"></div>
	<div class="col-sm-9">
		<button type="submit" class="btn btn-primary" name="server">
			Save
		</button>
		<a href="<?php echo $this->createUrl('/configs') ?>" class="btn btn-default">
			<span class="glyphicon glyphicon-ban-circle"></span> Cancel
		</a>
		<a class="btn btn-default" href="?default=1"
		   onclick="return confirm('Вы уверены?');"
		   >
			Default
		</a>
	</div>
</div>

<?php $this->endWidget(); ?>
<?php unset($form); ?>