<?
/* @var $this TransfersController */
/* @var $model ChdTransfer */
/* @var array $wowserversSites */

$this->breadcrumbs = [
	Yii::t('app', 'Transfer requests') => ['index'],
	' ' . $model->id => ['view', 'id' => $model->id], // TODO: hack
	Yii::t('app', 'Update')
];

$this->menu = [
	['label' => Yii::t('app', 'Requests list'), 'url' => ['index'], 'icon' => 'list'],
	['label' => Yii::t('app', 'Create request'), 'url' => ['create'], 'icon' => 'plus'],
	['label' => Yii::t('app', 'Request view'), 'url' => ['view', 'id' => $model->id], 'icon' => 'eye-open'],
];
?>

<h1><?= Yii::t('app', 'Update request') ?> #<?= $model->id; ?></h1>

<?php $this->renderPartial('_form', [
	'model' => $model,
	'wowserversSites' => $wowserversSites,
	'wowserversPair' => $wowserversPair,
]); ?>