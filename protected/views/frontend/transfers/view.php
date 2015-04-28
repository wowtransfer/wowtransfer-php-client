<?php
/* @var $this TransfersController */
/* @var $model ChdTransfer */

$this->breadcrumbs = array(
	'Заявки на перенос' => array('index'),
	$model->id,
);

$this->menu = array(
	array('label'=>'Список заявок', 'url' => array('index'), 'icon' => 'list'),
	array('label'=>'Создать заявку', 'url' => array('create'), 'icon' => 'plus'),
	array('label'=>'Изменить заявку', 'url' => array('update', 'id' => $model->id), 'icon' => 'pencil'),
);
?>

<h1>Просмотр заявки номер #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
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

	<a href="<?php echo $this->createUrl('/transfers'); ?>" class="btn btn-default">
		<span class="glyphicon glyphicon-arrow-left"></span>
		К заявкам
	</a>

</div>