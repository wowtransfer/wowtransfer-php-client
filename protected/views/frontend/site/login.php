<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle = 'Авторизация';
$this->breadcrumbs=array(
	'Авторизация',
);
?>

<h1 class="text-center">Авторизация</h1>

<?php if ($model->hasErrors()): ?>
	<div class="flash-error">
		<?php echo CHtml::errorSummary($model); ?>
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

	<?php echo $form->textFieldControlGroup($model, 'username', array('size' => 20)); ?>
	<?php echo $form->passwordFieldControlGroup($model, 'password', array('size' => 20)); ?>
	<?php //echo $form->checkBoxControlGroup($model, 'remember'); ?>

	<button type="submit" class="btn btn-primary">
		<span class="glyphicon glyphicon-log-in"></span>
		Войти
	</button>

	<a href="/" class="btn btn-default">
		<span class="glyphicon glyphicon-home"></span>
		Отмена
	</a>

<?php $this->endWidget(); ?>
</div>