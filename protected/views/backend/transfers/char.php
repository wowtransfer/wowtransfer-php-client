<?php

/* @var $this TransfersController */
/* @var $model ChdTransfer */
/* @var $errors string */
/* @var $queries array */
/* @var $queriesCount integer */
/* @var $sql string */
/* @var $tconfigs array Transfer's configurations */

$this->breadcrumbs = [
	Yii::t('app', 'Transfer requests') => ['index'],
	' ' . $model->id => ['view', 'id' => $model->id], // TODO: hack
	Yii::t('app', 'Create the character'),
];

?>

<div id="transfer"
	 data-id="<?= $model->id ?>"
	 data-char-guid="<?= $model->char_guid ?>"
	 class="hidden">
</div>


<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', [
	'layout' => TbHtml::FORM_LAYOUT_HORIZONTAL,
	'htmlOptions' => [
		'id' => 'create-char-from',
	],
]); ?>


<div class="row create-char-top">
	<div class="col-md-6">

		<div class="request-part">
			<b><?= Yii::t('app', 'Created at') ?></b><br><?= $model->create_transfer_date; ?><br>
			<b><?= Yii::t('app', 'Status') ?></b><br> <?= $model->status; ?>
		</div>

		<div class="request-part">
			<b><?= Yii::t('app', 'Server') ?></b><br>
			<?= $model->server; ?><br>
			<b><?= Yii::t('app', 'Realmlist') ?></b><br>
			<?= $model->realmlist; ?><br>
			<b><?= Yii::t('app', 'Realm') ?></b><br>
			<?= $model->realm; ?>
		</div>

		<div class="request-part">
			<b><?= Yii::t('app', 'Account') ?></b><br>
			<?= $model->account; ?><br>
			<b><?= Yii::t('app', 'Password') ?></b><br>

			<span class="btn btn-default btn-xs switch-password">+</span>
			<span id="password_<?= $model->id ?>" data-password="">*******</span><br>

			<b><?= Yii::t('app', 'Character') ?></b><br>
			<?= $model->username_old; ?>
		</div>

	</div>
	<div class="col-md-2">
		<label for="tconfig"><?= Yii::t('app', 'Configuration') ?></label>
		<?= CHtml::dropDownList('tconfig', '', $tconfigs, [ // Store active element in the cookie, TODO
			'style' => 'width: 100%;',
			'id' => 'tconfig'
		]); ?>
	</div>
	<div class="col-md-4">

		<div id="create-char-subactions">
			<a class="btn btn-default btn-sm disabled btn-char-action" id="clear-by-guid-id"
			   href="<?= Yii::t('app', 'clearchardata', ['id' => $model->id]) ?>">
				<?= Yii::t('app', 'Clear character`s data by ID') ?>
			</a> <span class="label label-success lowercase"><?= Yii::t('app', 'Safe') ?></span><br>
			<a class="btn btn-default btn-sm disabled btn-char-action" href="#" id="clear-by-guid">
				<?= Yii::t('app', 'Clear character`s data by GUID') ?>
			</a> <span class="label label-danger btn-char-action lowercase"><?= Yii::t('app', 'Unsafe') ?></span><br>
			<a class="btn btn-default btn-sm disabled btn-char-action" href="#" id="show-char-info">
				<?= Yii::t('app', 'Show character`s info') ?>
			</a><br>
			<a class="btn btn-default btn-sm" href="#" id="view-luadump" data-toggle="modal">
				<?= Yii::t('app', 'Lua dump') ?>
			</a>
			<a class="btn btn-default disabled btn-sm" href="#" id="view-uncrypted-luadump">
				<?= Yii::t('app', 'Uncrypted lua-dump') ?>
			</a>
		</div>

	</div>
</div>

<div class="chd-row">
	<?php $this->widget('application.components.widgets.TransferOptionsWidget', [
		'model' => $model,
		'form' => $form,
		'options' => $model->getTransferOptionsToUser(),
		'readonly' => true,
	]); ?>
</div>

<div class="row">
	<div class="col-md-6">
		<img id="create-char-wait" src="<?= Yii::app()->request->baseUrl ?>/images/wait30.gif" style="visibility: hidden;">

		<a href="<?= $this->createUrl('char', ['id' => $model->id]) ?>"
		   class="btn btn-primary" id="btn-create-char" autocomplete="off"
		   style="display: <?= $model->char_guid ? 'none' : 'inline-block' ?>">
			<span class="glyphicon glyphicon-plane"></span>
			<?= Yii::t('app', 'Create') ?>
		</a>

		<a href="<?= $this->createUrl('deletechar', ['id' => $model->id]); ?>"
		   class="btn btn-danger" id="btn-delete-char" autocomplete="off"
		   style="display: <?= $model->char_guid ? 'inline-block' : 'none' ?>">
			<span class="spr delete-char"></span>
			<?= Yii::t('app', 'Delete') ?>
		</a>

		<a class="btn btn-primary" href="<?= $this->createUrl('onlysql', ['id' => $model->id]) ?>"
			id="btn-only-sql">
			<span class="glyphicon"></span>
			SQL
		</a>

		<a href="<?= $this->createUrl('/transfers') ?>" class="btn btn-default"
		   id="btn-create-char-cancel">
			<span class="glyphicon glyphicon-ban-circle"></span>
			<?= Yii::t('app', 'Cancel') ?>
		</a>

	</div>
	<div class="col-md-6">
		<a href="<?= Yii::app()->createUrl('/configs/toptions') ?>">
			<?= Yii::t('app', 'If the option are disabled then she not sets in global settings') ?>
		</a>
	</div>
</div>

<?php $this->endWidget(); ?>
<?php unset($form); ?>

<hr>

<ul class="nav nav-tabs" id="create-char-tabs">
	<li>
		<a href="#tab-sql" data-toggle="tab">
			SQL <span class="badge" title="<?= Yii::t('app', 'Size of SQL') ?>">0</span>
		</a>
	</li>
	<li class="active">
		<a href="#tab-queries" data-toggle="tab">
			<?= Yii::t('app', 'Queries') ?>
			<span class="badge" title="<?= Yii::t('app', 'Count of queries') ?>">0</span>
		</a>
	</li>
	<li>
		<a href="#tab-warnings" data-toggle="tab">
			<?= Yii::t('app', 'Warnings') ?> <span class="badge" title="<?= Yii::t('app', 'Count of warnings') ?>">0</span>
		</a>
	</li>
	<li>
		<a href="#tab-errors" data-toggle="tab">
			<?= Yii::t('app', 'Errors') ?> <span class="badge" title="<?= Yii::t('app', 'Count of errors') ?>">0</span>
		</a>
	</li>
</ul>

<div class="tab-content">

	<div class="tab-pane" id="tab-sql">
		<h3><?= Yii::t('app', 'SQL script of character') ?></h3>
		<pre id="create-char-sql" class="hidden"><?= $sql; ?></pre>
	</div>

	<div class="tab-pane active" id="tab-queries">
		<h3><?= Yii::t('app', 'Result of the queries runing') ?></h3>

		<?php if ($queriesCount > 0): ?>
			<div id="run-queries-table">
			<?php for ($i = 0; $i < $queriesCount; ++$i): ?>
<?php

				if (isset($queries[$i])) {
					$query = $queries[$i];
					$classStatus = 'query-res-success';
				}
				else {
					$query = ['query' => '', 'status' => '&nbsp;'];
					$classStatus = '';
				}
?>
				<span class="query-res <?= $classStatus; ?>" title="<?= $query['query']; ?>"><?= $query['status'] ?></span>
			<?php endfor; ?>
			</div>
		<?php else: ?>
			<div id="run-queries-table"></div>
		<?php endif; ?>

	</div>

	<div class="tab-pane" id="tab-warnings">
		<h3><?= Yii::t('app', 'Warnings') ?></h3>

		<div id="create-char-warnings" class="alert alert-warning hidden"></div>
	</div>

	<div class="tab-pane" id="tab-errors">
		<h3><?= Yii::t('app', 'Errors') ?></h3>

		<div id="create-char-errors" class="alert alert-danger hidden"></div>
	</div>
</div>


<!-- Lua dump dialog, TODO -->
<div class="modal fade" id="lua-dump-dialog" role="dialog" tabindex="-1" aria-hidden="true" aria-labelledby="lua-dump-dialog-title">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">&times;</span>
					<span class="sr-only">Close</span>
				</button>
				<h4 class="modal-title" id="lua-dump-dialog-title">Lua dump from database</h4>
			</div>
			<div class="modal-body">
				<pre id="lua-dump-dialog-content" style="height: 500px;"></pre>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Ok</button>
			</div>
		</div>
	</div>
</div>


<div class="hidden" id="text-create-char"><?= Yii::t('app', 'Create the character') ?></div>
<div class="hidden" id="t-confirm-delete-character"><?= Yii::t('app', 'Confirm delete the character') ?></div>