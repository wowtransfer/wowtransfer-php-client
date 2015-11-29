<?php

/* @var $this ConfigsController */
/* @var $model DbConfigForm */

$this->breadcrumbs = [
	Yii::t('app', 'Settings') => ['/configs'],
	Yii::t('app', 'Database')
];

?>
<h1><?= Yii::t('app', 'Database options') ?></h1>

<?php if (Yii::app()->user->hasFlash('success')): ?>
	<div class="alert alert-success"><?= Yii::app()->user->getFlash('success'); ?></div>
<?php endif; ?>


<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', [
	'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
	'enableClientValidation' => true,
	'htmlOptions' => [
		'id' => 'config-db-form',
	],
]);
	echo $form->errorSummary($model);

	echo $form->textFieldControlGroup($model, 'host');
	echo $form->textFieldControlGroup($model, 'dbName');
	echo $form->textFieldControlGroup($model, 'username');
	echo $form->passwordFieldControlGroup($model, 'password');
	echo $form->passwordFieldControlGroup($model, 'password2');
	echo $form->textFieldControlGroup($model, 'charset');

?>
	<div class="form-group">
		<div class="col-sm-2"></div>
		<div class="col-sm-10">
			<button type="submit" class="btn btn-primary" name="server">
				<?= Yii::t('app', 'Save') ?>
			</button>
			<a href="<?= $this->createUrl('/configs') ?>" class="btn btn-default">
				<span class="glyphicon glyphicon-ban-circle"></span>
				<?= Yii::t('app', 'Cancel') ?>
			</a>
		</div>
	</div>

<?php
$this->endWidget();
unset($form);
?>

<div class="alert alert-warning">
	<?= Yii::t('app', 'Settings saves in the file') ?> <code>/protected/config/db-local.php</code>.
</div>
