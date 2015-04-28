<?php
/* @var $this TransfersController */
/* @var $model ChdTransfer */

$this->breadcrumbs = array(
	'Заявки на перенос' => array('index'),
	$model->id,
);

$this->menu = array(
	array('label'=>'Список заявок', 'url'=>array('index'), 'icon' => 'list'),
	($model->char_guid > 0) ?
		array('label'=>'Удалить персонажа', 'url'=>'#', 'icon' => 'remove',
			'linkOptions'=>array('submit'=>array('deletechar','id'=>$model->id),'confirm'=>'Вы действительно хотите удалить персонажа?'))
	:
		array('label'=>'Создать персонажа', 'url'=>array('/transfers/char/' . $model->id), 'icon' => 'plane'),
	array('label'=>'Lua-dump', 'url'=>array('luadump', 'id'=>$model->id), 'icon' => 'file'),
);
?>

<h1>Просмотр заявки #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data' => $model,
	'attributes' => array(
		'id',
		'account_id',
		'server',
		'realmlist',
		'realm',
		'username_old',
		'username_new',
		'char_guid',
		'create_char_date',
		'create_transfer_date',
		'status',
		'account',
		'pass',
		'file_lua_crypt',
		'options',
		'comment',
	),
)); ?>

<div class="form-actions">

	<a href="<?php echo $this->createUrl('/transfers'); ?>" class="btn btn-default">
		<span class="glyphicon glyphicon-ban-circle"></span>
		Отмена
	</a>

</div>