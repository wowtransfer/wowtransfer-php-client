<?php
/* @var $this TransfersController */
/* @var $data ChdTransfer */
?>

<script><!--
function OnDeleteChar()
{
	return confirm('Подтвердите удаление.');
}

--></script>

<div class="view">

	<div style="float: right;">
	<?php if ($data->char_guid): ?>
		<?php $this->widget('booster.widgets.TbButton', array(
			'buttonType' => 'link',
			'label' => 'Delete character',
			'url' => $this->createUrl('deletechar', array('id' => $data->id)),
			'icon' => 'remove',
			'context' => 'danger',
			'htmlOptions' => array('onclick' => 'return OnDeleteChar();'),
		));?>
	<?php else: ?>
		<?php $this->widget('booster.widgets.TbButton', array(
			'buttonType' => 'link',
			'context' => 'success',
			'label' => 'Create character',
			'url' => $this->createUrl('char', array('id' => $data->id)),
			'icon' => 'plane',
		));?>
	<?php endif; ?>

	<?php $this->widget('booster.widgets.TbButton', array(
		'buttonType' => 'link',
		'label' => 'Lua-dump',
		'url' => $this->createUrl('luadump', array('id' => $data->id)),
		'icon' => 'file',
	));?>
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

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
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