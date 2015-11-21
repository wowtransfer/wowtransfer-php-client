<?
/* @var $this TransfersController */
/* @var $model ChdTransfer */

$this->breadcrumbs = [
	Yii::t('app', 'Transfer requests') => ['index'],
	$model->id,
];

$this->menu = [
	['label' => Yii::t('app', 'Requests list'), 'url' => ['index'], 'icon' => 'list'],
	$model->char_guid > 0 ?
		[
			'label' => Yii::t('app', 'Delete the character'),
			'url'=>'#',
			'icon' => 'remove',
			'linkOptions' => ['submit' => ['deletechar', 'id' => $model->id],
			'confirm' => Yii::t('app', 'Confirm delete the character')]
		]
	:
		[
			'label' => Yii::t('app', 'Create the character'),
			'url' => ['/transfers/char/' . $model->id],
			'icon' => 'plane'
		],
	['label'=>'Lua-dump', 'url' => ['luadump', 'id' => $model->id], 'icon' => 'file'],
];


?>

<h1><?= Yii::t('app', 'Request view') ?> #<?= $model->id; ?></h1>

<? $this->widget('zii.widgets.CDetailView', [
	'data' => $model,
	'attributes' => [
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
		'comment',
	],
]); ?>

<div class="chd-row">
	<? $this->widget('application.components.widgets.TransferOptionsWidget', [
		'model' => $model,
		//'form' => $form,
		'options' => $model->getTransferOptionsToUser(),
		'readonly' => true,
	]); ?>
</div>

<div class="form-actions">

	<a href="<?= $this->createUrl('/transfers'); ?>" class="btn btn-default">
		<span class="glyphicon glyphicon-ban-circle"></span>
		<?= Yii::t('app', 'Cancel') ?>
	</a>

</div>