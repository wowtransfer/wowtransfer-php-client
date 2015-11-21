<?
/* @var $this TransfersController */
/* @var $model ChdTransfer */
/* @var array $wowserversSites */
/* @var array $wowserversPair */

$this->breadcrumbs = [
	Yii::t('app', 'Transfer requests') => ['index'],
	Yii::t('app', 'Create')
];

$this->menu = [
	['label' => Yii::t('app', 'Requests list'), 'url' => ['index'], 'icon' => 'list'],
];
?>

<h1><?= Yii::t('app', 'Create request') ?></h1>

<? $this->renderPartial('_form', [
	'model' => $model,
	'wowserversSites' => $wowserversSites,
	'wowserversPair' => $wowserversPair,
]); ?>