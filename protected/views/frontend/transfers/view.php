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

<? $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'create_transfer_date',
		'status',
		'server',
		'realmlist',
		'realm',
		'username_old',
		'account',
		'options',
		'comment',
	),
)); ?>

<div style="margin: 10px 0;">

	<a href="<?= $this->createUrl('/transfers'); ?>" class="btn btn-default">
		<span class="glyphicon glyphicon-arrow-left"></span>
		<?= Yii::t('app', 'Cancel') ?>
	</a>

</div>