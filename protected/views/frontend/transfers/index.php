<?
/* @var $this TransfersController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = [
	Yii::t('app', 'Transfer requests')
];

$this->menu = [
	['label' => Yii::t('app', 'Create request'), 'url'=> ['create'], 'icon' => 'plus'],
];
?>

<h1><?= Yii::t('app', 'Transfer requests') ?></h1>

<div id="transfer-list-view-block">
<? $this->renderPartial('_list', [
	'dataProvider' => $dataProvider
]); ?>
</div>

<div id="t-configrm-request-delete" class="hidden"><?= Yii::t('app', 'Confirm delete request') ?></div>
