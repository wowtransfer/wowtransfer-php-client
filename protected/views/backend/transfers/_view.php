<?php
/* @var $this TransfersController */
/* @var $data ChdTransfer */

$statuses = ChdTransfer::getStatuses();
?>

<div class="view" id="view_<?php echo $data->id ?>" data-id="<?php echo $data->id ?>">

	<div class="pull-right">

		<div class="btn-group">
			<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false" title="Изменить статус">
				<span id="status_<?php echo $data->id; ?>" class="tstatus tstatus-<?php echo $data->status; ?>" data-name="<?php echo $data->status; ?>"><?php echo $statuses[$data->status]; ?></span> <span class="caret"></span>
			</button><!-- TODO: class transfer-statuses is not defined in css! -->
			<ul class="dropdown-menu transfer-statuses" role="menu">
				<?php foreach ($statuses as $name => $title): ?>
					<li><a href="#" data-name="<?php echo $name; ?>"><?php echo $title; ?></a></li>
				<?php endforeach; ?>
			</ul>
		</div>

		<?php if ($data->char_guid): ?>
			<?php $this->widget('booster.widgets.TbButton', array(
				'buttonType' => 'link',
				'label' => 'Delete character',
				'url' => $this->createUrl('deletechar', array('id' => $data->id)),
				'icon' => 'remove',
				'context' => 'danger',
				'htmlOptions' => array('onclick' => 'return OnDeleteChar();', 'title' => 'Удалить персонажа'),
			));?>
		<?php else: ?>
			<?php $this->widget('booster.widgets.TbButton', array(
				'buttonType' => 'link',
				'context' => 'success',
				'label' => 'Create character',
				'url' => $this->createUrl('char', array('id' => $data->id)),
				'icon' => 'plane',
				'htmlOptions' => array('title' => 'Создать персонажа'),
			));?>
		<?php endif; ?>

		<?php $this->widget('booster.widgets.TbButton', array(
			'buttonType' => 'link',
			'label' => 'Lua-dump',
			'url' => $this->createUrl('luadump', array('id' => $data->id)),
			'icon' => 'file',
		));?>

		<div style="margin-top: 5px;">
			<textarea style="width: 100%; height: 65px; resize: none;"><?php echo htmlspecialchars($data->comment) ?></textarea>
		</div>

		<button id="" class="btn btn-primary" onclick="UpdateComment(<?php echo $data->id; ?>);">
			Change comment
		</button>

	</div>

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('account_id')); ?>:</b>
	<?php echo CHtml::encode($data->account_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('server')); ?>:</b>
	<?php echo CHtml::encode($data->server); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('realmlist')); ?>:</b>
	<?php echo CHtml::encode($data->realmlist); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('realm')); ?>:</b>
	<?php echo CHtml::encode($data->realm); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('username_old')); ?>:</b>
	<?php echo CHtml::encode($data->username_old); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('username_new')); ?>:</b>
	<?php echo CHtml::encode($data->username_new); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('char_guid')); ?>:</b>
	<?php echo CHtml::encode($data->char_guid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_char_date')); ?>:</b>
	<?php echo CHtml::encode($data->create_char_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_transfer_date')); ?>:</b>
	<?php echo CHtml::encode($data->create_transfer_date); ?>
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