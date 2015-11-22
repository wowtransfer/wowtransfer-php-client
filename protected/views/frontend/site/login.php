<?php

/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle = Yii::t('app', 'Autorization');
$this->breadcrumbs = [
	Yii::t('app', 'Autorization')
];
?>

<h1 class="text-center"><?= Yii::t('app', 'Autorization') ?></h1>

<?php if ($model->hasErrors()): ?>
	<div class="flash-error">
		<?= CHtml::errorSummary($model); ?>
	</div>
<?php endif; ?>

<div class="form auth-form">
<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'layout' => TbHtml::FORM_LAYOUT_VERTICAL,
	'htmlOptions' => array(
		'id' => 'create-char-from',
		'class' => 'well',
	),
)); ?>

	<?= $form->textFieldControlGroup($model, 'username', array('size' => 20)); ?>
	<?= $form->passwordFieldControlGroup($model, 'password', array('size' => 20)); ?>
	<?php //echo $form->checkBoxControlGroup($model, 'remember'); ?>

	<button type="submit" class="btn btn-primary">
		<span class="glyphicon glyphicon-log-in"></span>
		<?= Yii::t('app', 'Login') ?>
	</button>

	<a href="/" class="btn btn-default">
		<span class="glyphicon glyphicon-home"></span>
		<?= Yii::t('app', 'Cancel') ?>
	</a>

<?php $this->endWidget(); ?>
</div>