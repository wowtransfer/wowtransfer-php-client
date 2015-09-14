<?
/* @var $data ChdTransfer */
?>

<div class="t-request-item">
	<span><b>
		ID: <?= $data->id ?>
	</b></span>
	<span class="tstatus tstatus-<?= $data->status ?>">
		<?= \ChdTransfer::getStatusTitle($data->status) ?>
	</span>
	<span>
		<?= $data->create_transfer_date ?>
	</span>
	<span><b>
		<?= $data->server ?>
	</b></span>
	<span>
		<?= $data->realm ?>
	</span>
	<span><b>
		<?= $data->username_old ?>
	</b></span>

	<div class="pull-right">
		<a href="<?= $this->createUrl('char', ['id' => $data->id]); ?>"
		   class="btn btn-success btn-xs" title="<?= Yii::t('app', 'Character') ?>">
			<span class="spr create-char"></span>
		</a>
		<a href="<?= $this->createUrl('deletechar', ['id' => $data->id]); ?>"
		   class="btn btn-danger btn-xs delete-char" title="<?= Yii::t('app', 'Delete') ?>"
		   style="display: <?= $data->char_guid ? 'inline-block' : 'none'; ?>">
			<span class="spr delete-char"></span>
		</a>
		<a href="<?= $this->createUrl('luadump', ['id' => $data->id]); ?>"
		   class="btn btn-default btn-xs" title="<?= Yii::t('app', 'Dump') ?>">
			<span class="spr lua-dump"></span>
		</a>
	</div>
</div>
