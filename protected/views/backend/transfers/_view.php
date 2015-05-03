<?php
/* @var $this TransfersController */
/* @var $data ChdTransfer */

$statuses = ChdTransfer::getStatuses();
?>

<div class="view" id="view_<?php echo $data->id ?>" data-id="<?php echo $data->id ?>">

	<div class="col-md-4 pull-right">

		<a class="btn btn-danger delete-char" onclick="OnDeleteChar(this, <?php echo $data->id; ?>); return false;"
		   href="<?php echo $this->createUrl('deletechar', array('id' => $data->id)); ?>"
		   style="display: <?php echo $data->char_guid ? 'inline-block' : 'none'; ?>">
			<span class="spr delete-char"></span>
			Delete
		</a>

		<a href="<?php echo $this->createUrl('char', array('id' => $data->id)); ?>"
		   class="btn btn-success" title="Создать персонажа"
		   style="display: <?php echo $data->char_guid ? 'none' : 'inline-block' ?>"
		   >
			<span class="spr create-char"></span>
			character
		</a>

		<a href="<?php echo $this->createUrl('luadump', array('id' => $data->id)); ?>" class="btn btn-default">
			<span class="spr lua-dump"></span>
			dump
		</a>

		<textarea class="transfer-comment"><?php echo $data->comment; ?></textarea>

		<button class="btn btn-primary pull-right transfer-save-comment">
			Save
		</button>

	</div>

	<table class="table-transfer-view table-condensed">
		<tbody>
			<tr>
				<td colspan="2">
					<b style="font-size: large;"><?php echo CHtml::link('#' . $data->id, array('view', 'id' => $data->id)); ?></b>
					<span title="<?php echo $data->getAttributeLabel('create_transfer_date'); ?>"><?php echo $data->create_transfer_date; ?></span>
				</td>
			</tr>
			<tr>
				<th>
					<?php echo $data->getAttributeLabel('account_id'); ?>
				</th>
				<td>
					<?php echo $data->account_id; ?>
				</td>
			</tr>
			<tr>
				<th><?php echo $data->getAttributeLabel('status'); ?></th>
				<td>
				<div class="btn-group">
					<button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
						<span id="status_<?php echo $data->id; ?>"
							  class="tstatus tstatus-<?php echo $data->status; ?>"
							  data-name="<?php echo $data->status; ?>">
								  <?php echo $statuses[$data->status]; ?>
						</span> <span class="caret"></span>
					</button>
					<ul class="dropdown-menu transfer-statuses" role="menu">
						<?php foreach ($statuses as $name => $title): ?>
							<li><a href="#" data-name="<?php echo $name; ?>">
								<?php echo $title; ?></a>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
				</td>
			</tr>
			<tr>
				<th><?php echo $data->getAttributeLabel('server'); ?></th>
				<td><?php echo CHtml::encode($data->server); ?></td>
			</tr>
			<tr>
				<th><?php echo $data->getAttributeLabel('realmlist'); ?></th>
				<td><?php echo CHtml::encode($data->realmlist); ?></td>
			</tr>
			<tr>
				<th><?php echo $data->getAttributeLabel('realm'); ?></th>
				<td><?php echo CHtml::encode($data->realm); ?></td>
			</tr>
			<tr>
				<th><?php echo $data->getAttributeLabel('username_old'); ?></th>
				<td><?php echo CHtml::encode($data->username_old); ?></td>
			</tr>

		</tbody>
	</table>

</div>