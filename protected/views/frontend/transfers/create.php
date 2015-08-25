<?php
/* @var $this TransfersController */
/* @var $model ChdTransfer */

$this->breadcrumbs = [
	Yii::t('app', 'Transfer requests') => ['index'],
	'Создание',
];

$this->menu = [
	['label' => Yii::t('app', 'Requests list'), 'url' => ['index'], 'icon' => 'list'],
];
?>

<h1><?= Yii::t('app', 'Create request') ?></h1>

<?php $this->renderPartial('_form', array(
	'model' => $model,
)); ?>