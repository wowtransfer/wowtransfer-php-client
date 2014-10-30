<?php
/* @var $this TransfersController */
/* @var $model ChdTransfer */

$this->breadcrumbs = array(
	'Заявки на перенос' => array('index'),
	$model->id,
);

$this->menu = array(
	array('label'=>'Список заявок', 'url'=>array('index'), 'icon' => 'list'),
	array('label'=>'Изменить заявку', 'url'=>array('update', 'id'=>$model->id), 'icon' => 'pencil'),
	array('label'=>'Удалить заявку', 'url'=>'#', 'icon' => 'remove', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Управление заявками', 'url'=>array('admin'), 'icon' => ''),
	($model->char_guid > 0) ?
	array('label'=>'Удалить персонажа', 'url'=>array('/transfers/deletechar/' . $model->id), 'icon' => '') : 
	array('label'=>'Создать персонажа', 'url'=>array('/transfers/char/' . $model->id), 'icon' => ''),
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

<div style="margin-top: 10px;">
<?php
$this->widget('booster.widgets.TbButton', array(
	'buttonType' => 'link',
	'label' => 'Отмена',
	'icon' => 'ban-circle',
	'url' => $this->createUrl('/transfers'),
));
?>
</div>