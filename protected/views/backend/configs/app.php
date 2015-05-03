<?php
/* @var $this ConfigsController */
/* @var $model AppConfigForm */
/* @var $cores array */

$this->breadcrumbs = array(
	'Настройка' => array('/configs'),
	'Приложение',
);

?>
<h1>Настройка приложения</h1>

<div class="alert alert-warning">
	Настройки приложения хранятся в файле <code>/protected/config/app.php</code>.
	В случае сбоя его можно изменить вручную.
</div>

<?php if (Yii::app()->user->hasFlash('success')): ?>
	<div class="flash-success"><?php echo Yii::app()->user->getFlash('success'); ?></div>
<?php endif; ?>

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

<div class="form-group">
	<div class="col-sm-3"></div>
	<div class="col-sm-9">

		<button type="submit" class="btn btn-primary" name="server" disabled="disabled">
			Save
		</button>

		<a href="<?php echo $this->createUrl('/configs') ?>" class="btn btn-default">
			<span class="glyphicon glyphicon-ban-circle"></span> Cancel
		</a>

	</div>
</div>

<fieldset>
<legend>Сервис</legend>
	<?php echo $form->textFieldControlGroup($model, 'serviceUsername', array(
		'maxlength' => 32,
	)); ?>
	<?php echo $form->textFieldControlGroup($model, 'accessToken', array(
		'maxlength' => 32,
	)); ?>

	<?php if (YII_DEBUG): ?>
		<?php echo $form->textFieldControlGroup($model, 'apiBaseUrl'); ?>
	<?php endif ?>
</fieldset>

<div class="form-group">
	<div class="col-sm-3"></div>
	<div class="col-sm-9">

		<button type="submit" class="btn btn-primary" name="service">
			Save
		</button>

		<a href="<?php echo $this->createUrl('/configs'); ?>" class="btn btn-default">
			<span class="glyphicon glyphicon-ban-circle"></span>
			Cancel
		</a>

		<a class="btn btn-default" href="?default=1"
		   onclick="return confirm('Вы уверены?');"
		   >
			По-умолчанию
		</a>

	</div>
</div>

<?php $this->endWidget(); ?>
<?php unset($form); ?>