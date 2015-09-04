<?
/* @var $this TransfersController */
/* @var $data ChdTransfer */

$statuses = ChdTransfer::getStatuses();
?>

<div class="view" id="view_<?= $data->id ?>" data-id="<?= $data->id ?>">

	<div class="col-md-6">

		<table class="table-transfer-view table-condensed">
			<tbody>
				<tr>
					<td colspan="2">
						<b style="font-size: large;"><?= CHtml::link('#' . $data->id, array('view', 'id' => $data->id)); ?></b>
						<span title="<?= $data->getAttributeLabel('create_transfer_date'); ?>"><?= $data->create_transfer_date; ?></span>
					</td>
				</tr>
				<tr>
					<th>
						<?= $data->getAttributeLabel('account_id') ?>
					</th>
					<td>
						<?= $data->account_id ?>
					</td>
				</tr>
				<tr>
					<th><?= $data->getAttributeLabel('status') ?></th>
					<td>
					<div class="btn-group">
						<button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
							<span id="status_<?= $data->id ?>"
								  class="tstatus tstatus-<?= $data->status ?>"
								  data-name="<?= $data->status ?>">
									  <?= $statuses[$data->status] ?>
							</span> <span class="caret"></span>
						</button>
						<ul class="dropdown-menu transfer-statuses" role="menu">
							<? foreach ($statuses as $name => $title): ?>
								<li><a href="#" data-name="<?= $name ?>">
									<?= $title ?></a>
								</li>
							<? endforeach ?>
						</ul>
					</div>
					</td>
				</tr>
				<tr>
					<th><?= $data->getAttributeLabel('server'); ?></th>
					<td><?= CHtml::encode($data->server); ?></td>
				</tr>
				<tr>
					<th><?= $data->getAttributeLabel('realmlist'); ?></th>
					<td><?= CHtml::encode($data->realmlist); ?></td>
				</tr>
				<tr>
					<th><?= $data->getAttributeLabel('realm'); ?></th>
					<td><?= CHtml::encode($data->realm); ?></td>
				</tr>
				<tr>
					<th><?= $data->getAttributeLabel('username_old'); ?></th>
					<td><?= CHtml::encode($data->username_old); ?></td>
				</tr>

			</tbody>
		</table>

	</div>

	<div class="col-md-6">

		<b><?= $data->getAttributeLabel('comment'); ?></b>
		<textarea class="transfer-comment"><?= $data->comment; ?></textarea>

		<button class="btn btn-primary pull-right transfer-save-comment">
			<?= Yii::t('app', 'Save comment') ?>
		</button>

		<div class="clearfix"></div>
		<div class="transfer-actions">
			<a href="<?= $this->createUrl('char', array('id' => $data->id)); ?>"
			   class="btn btn-success" title="<?= Yii::t('app', 'Character') ?>">
				<span class="spr create-char"></span>
				<?= Yii::t('app', 'Character') ?>...
			</a>
			<a class="btn btn-danger delete-char"
			   href="<?= $this->createUrl('deletechar', array('id' => $data->id)); ?>"
			   style="display: <?= $data->char_guid ? 'inline-block' : 'none'; ?>">
				<span class="spr delete-char"></span>
				<?= Yii::t('app', 'Delete') ?>
			</a>
			<a href="<?= $this->createUrl('luadump', array('id' => $data->id)); ?>" class="btn btn-default">
				<span class="spr lua-dump"></span>
				<?= Yii::t('app', 'Dump') ?>...
			</a>
		</div>

	</div>

	<div class="clearfix"></div>

</div>