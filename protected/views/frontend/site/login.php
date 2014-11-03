<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle = 'Авторизация';
$this->breadcrumbs=array(
	'Авторизация',
);

?>

<?php if ($model->hasErrors()): ?>
	<div class="flash-error">
		<?php echo CHtml::errorSummary($model); ?>
	</div>
<?php endif; ?>

<div>
<h1 class="text-center">Авторизация</h1>
</div>
<div class="form auth-form">
<?php $form = $this->beginWidget('booster.widgets.TbActiveForm', array(
	'id' => 'loginForm',
	'type' => 'vertical',
	'htmlOptions' => array('class' => 'well'),
)); ?>

	<?php echo $form->textFieldGroup($model, 'username', array('size' => 20)); ?>
	<?php echo $form->passwordFieldGroup($model, 'password', array('size' => 20)); ?>
	<?php //echo $form->checkboxGroup($model, 'remember'); ?>

	<?php $this->widget('booster.widgets.TbButton', array(
		'buttonType' => 'submit',
		'context' => 'primary',
		'label' => 'Войти',
		'icon' => 'log-in',
	)); ?>

	<?php $this->widget('booster.widgets.TbButton', array(
		'buttonType' => 'link',
		'label' => 'Отмена',
		'url' => '/',
		'icon' => 'home',
	)); ?>

<?php $this->endWidget(); ?>
</div>