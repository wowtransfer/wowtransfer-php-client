<?
/* @var $this TransfersController */
/* @var $model ChdTransfer */

$this->breadcrumbs = [
	Yii::t('app', 'Transfer requests') => ['index'],
	$model->id,
];

$this->menu = [
	array('label' => Yii::t('app', 'Requests list'), 'url'=>array('index'), 'icon' => 'list'),
	($model->char_guid > 0) ?
		array('label'=>'Удалить персонажа', 'url'=>'#', 'icon' => 'remove',
			'linkOptions'=>array('submit'=>array('deletechar','id'=>$model->id),'confirm'=>'Вы действительно хотите удалить персонажа?'))
	:
		['label' => Yii::t('app', 'Create the character'), 'url'=>array('/transfers/char/' . $model->id), 'icon' => 'plane'],
	array('label'=>'Lua-dump', 'url'=>array('luadump', 'id'=>$model->id), 'icon' => 'file'),
];
?>

<h1><?= Yii::t('app', 'Request view') ?> #<?= $model->id; ?></h1>

<? $this->widget('zii.widgets.CDetailView', array(
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

	<a href="<?= $this->createUrl('/transfers'); ?>" class="btn btn-default">
		<span class="glyphicon glyphicon-ban-circle"></span>
		<?= Yii::t('app', 'Cancel') ?>
	</a>

</div>