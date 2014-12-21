<?php
/* @var $this TransfersController */
/* @var $data ChdTransfer */

$statuses = ChdTransfer::getStatuses();
?>

<div class="view" id="view_<?php echo $data->id ?>" data-id="<?php echo $data->id ?>">

	<div class="pull-right col-md-4">

		<a class="btn btn-danger" onclick="OnDeleteChar(this, <?php echo $data->id; ?>); return false;"
		   href="<?php echo $this->createUrl('deletechar', array('id' => $data->id)); ?>"
		   style="display: <?php echo !$data->char_guid ? 'none' : 'inline-block'; ?>">
			<span class="glyphicon glyphicon-remove"></span>
			Delete cahracter
		</a>

		<?php $this->widget('booster.widgets.TbButton', array(
			'buttonType' => 'link',
			'context' => 'success',
			'label' => 'character',
			'url' => $this->createUrl('char', array('id' => $data->id)),
			'icon' => 'plane',
			'htmlOptions' => array(
				'id' => 'btn-create-char-' . $data->id,
				'title' => 'Создать персонажа',
				'style' => 'display:' . ($data->char_guid ? 'none' : 'inline-block'),
			),
		));?>

		<?php $this->widget('booster.widgets.TbButton', array(
			'buttonType' => 'link',
			'label' => 'Lua-dump',
			'url' => $this->createUrl('luadump', array('id' => $data->id)),
			'icon' => 'file',
		));?>

		<div style="margin-top: 5px;">
			<textarea style="width: 100%; height: 65px; resize: none;"><?php echo $data->comment; ?></textarea>
		</div>

		<button id="" class="btn btn-primary pull-right" onclick="UpdateComment(<?php echo $data->id; ?>);">
			Change
		</button>

	</div>

	<table class="table-transfer-view table-condensed">
		<tbody>
			<tr>
				<td>
					<?php echo CHtml::link('#' . $data->id, array('view', 'id' => $data->id)); ?><br>
					<span title="<?php echo $data->getAttributeLabel('create_transfer_date'); ?>"><?php echo $data->create_transfer_date; ?></span>
				</td>
				<td>
					<b><?php echo $data->getAttributeLabel('account_id'); ?></b>
					<?php echo $data->account_id; ?>
				</td>
			</tr>
			<tr>
				<th><?php echo $data->getAttributeLabel('status'); ?></th>
				<td>
				<div class="btn-group">
					<button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false" title="Изменить статус">
						<span id="status_<?php echo $data->id; ?>" class="tstatus tstatus-<?php echo $data->status; ?>" data-name="<?php echo $data->status; ?>"><?php echo $statuses[$data->status]; ?></span> <span class="caret"></span>
					</button><!-- TODO: class transfer-statuses is not defined in css! -->
					<ul class="dropdown-menu transfer-statuses" role="menu">
						<?php foreach ($statuses as $name => $title): ?>
							<li><a href="#" data-name="<?php echo $name; ?>"
								   onclick="OnUpdateStatus(this); return false;"
								   >
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
				<th><?php $data->getAttributeLabel('username_old'); ?></th>
				<td><?php echo CHtml::encode($data->username_old); ?></td>
			</tr>

	<?php /*echo CHtml::encode($data->getAttributeLabel('username_new')); ?>:
	<?php echo CHtml::encode($data->username_new); */?>
		</tbody>
	</table>

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('char_guid')); ?>:</b>
	<?php echo CHtml::encode($data->char_guid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_char_date')); ?>:</b>
	<?php echo CHtml::encode($data->create_char_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('account')); ?>:</b>
	<?php echo CHtml::encode($data->account); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pass')); ?>:</b>
	<?php echo CHtml::encode($data->pass); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('file_lua_crypt')); ?>:</b>
	<?php echo CHtml::encode($data->file_lua_crypt); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('file_lua')); ?>:</b>
	<?php echo CHtml::encode($data->file_lua); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('options')); ?>:</b>
	<?php echo CHtml::encode($data->options); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('comment')); ?>:</b>
	<?php echo CHtml::encode($data->comment); ?>
	<br />

	*/ ?>

</div>