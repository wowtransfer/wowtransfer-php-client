<?
/* @var $this TransfersController */
/* @var $model ChdTransfer */

$this->breadcrumbs = [
	Yii::t('app', 'Transfer requests') => ['index'],
	$model->id,
];

$this->menu = [
	['label' => Yii::t('app', 'Requests list'), 'url' => ['index'], 'icon' => 'list'],
	['label' => Yii::t('app', 'Create request'), 'url' => ['create'], 'icon' => 'plus'],
	['label' => Yii::t('app', 'Update request'), 'url' => array('update', 'id' => $model->id), 'icon' => 'pencil'],
];
?>

<h1><?= Yii::t('app', 'Request view') ?> #<?= $model->id; ?></h1>

<div id="transfer-list-view-block">
	<? $this->renderPartial('_view', ['data' => $model, 'where' => 'card']) ?>
</div>

<div style="margin: 10px 0;">

	<a href="<?= $this->createUrl('/transfers'); ?>" class="btn btn-default">
		<span class="glyphicon glyphicon-arrow-left"></span>
		<?= Yii::t('app', 'Cancel') ?>
	</a>

</div>

<div id="t-configrm-request-delete" class="hidden"><?= Yii::t('app', 'Confirm delete request') ?></div>
