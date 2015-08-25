<?php
/* @var $this TransfersController */
/* @var $model ChdTransfer */
/* @var $wowServers array */

$this->breadcrumbs = [
	Yii::t('app', 'Transfer requests') => ['index'],
	' ' . $model->id => array('view', 'id' => $model->id), // TODO: hack
	'Изменение',
];

$this->menu = [
	['label' => Yii::t('app', 'Requests list'), 'url' => ['index'], 'icon' => 'list'],
	['label' => Yii::t('app', 'Create request'), 'url'=>['create'], 'icon' => 'plus'],
	['label' => Yii::t('app', 'Request view'), 'url'=>array('view', 'id'=>$model->id), 'icon' => 'eye-open'],
];
?>

<h1>Изменение заявки #<?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array(
	'model' => $model,
	'wowServers' => $wowServers,
)); ?>