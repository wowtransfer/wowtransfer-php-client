<?php
/* @var $this TransfersController */
/* @var $data ChdTransfer */
?>

<div class="view" style="background-color: #CCFFFF;">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo $data->id; ?>

	<?php $this->widget('booster.widgets.TbButton', array(
		'buttonType' => 'ajaxButton',
		'url' => $this->createUrl('/transfers/delete', array('id' => $data->id, 'ajax' => 'delete')),
		'icon' => 'remove',
		'size' => 'small',
		'htmlOptions' => array('class' => 'pull-right', 'title' => 'Удалить'),
		'ajaxOptions' => array(
			'beforeSend' => 'js:function(){return confirm("' . Yii::t('app', 'Are you sure you want to delete this transfer #{id}?', array('{id}' => $data->id)) . '");}',
			'success' =>'js:function(data){$.fn.yiiListView.update("transfer-list-view",{});}',
			'type' => 'POST',
		),
	)); ?>
	<?php $this->widget('booster.widgets.TbButton', array(
		'buttonType' => 'link',
		'url' => $this->createUrl('/transfers/update', array('id' => $data->id)),
		'icon' => 'pencil',
		'size' => 'small',
		'htmlOptions' => array('class' => 'pull-right', 'title' => 'Изменить...'),
	)); ?>
	<?php $this->widget('booster.widgets.TbButton', array(
		'buttonType' => 'link',
		'url' => $this->createUrl('/transfers/view', array('id' => $data->id)),
		'icon' => 'eye-open',
		'size' => 'small',
		'htmlOptions' => array('class' => 'pull-right', 'title' => 'Просмотр...'),
	)); ?>

	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->statusName); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('create_transfer_date')); ?>:</b>
	<?php echo CHtml::encode($data->create_transfer_date); ?>
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

	<div><b>Опции переноса:</b>
	<?php $this->widget('application.components.widgets.TransferOptionsWidget', array(
			'model' => $data,
			'options' => $data->getTransferOptionsToUser()
		));
			?>
	</div>
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